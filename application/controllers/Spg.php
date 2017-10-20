<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spg extends MY_Controller {
	private $any_error = array();
	public $tbl = 'spgs';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,76);
		$this->permit = $akses['permit_acces'];
	}

	/* pages begin */
	public function index(){
		$this->view();
	}

	function check_user_access(){
		if(!$this->logged_in){
			redirect('Login');
		}

	}

	public function view(){
		if($this->permit == ''){
			redirect('Page-Unauthorized'); 
		}

		if (strpos($this->permit, 'c') !== false){
			$c = '';
		} else {
			$c = 'disabled';
		}

		$data = array(
			'aplikasi'		=> 'Gresik Factory',
			'title_page' 	=> 'Master Data / Spg',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('spg_v', $data);
	}

	public function load_data(){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$select = '*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'spg_name,spg_address',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$query_total = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,NULL);
		$query_filter = $this->g_mod->select($select,$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$query = $this->g_mod->select($select,$this->tbl,$limit,$where_like,$order,NULL,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->spg_id>0) {
					$response['data'][] = array(
						$val->spg_name,
						$val->spg_address,
						$val->spg_birth,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->spg_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->spg_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
					);
					$no++;	
				}
			}
		}

		$response['recordsTotal'] = 0;
		if ($query_total<>false) {
			$response['recordsTotal'] = $query_total->num_rows();
		}
		$response['recordsFiltered'] = 0;
		if ($query_filter<>false) {
			$response['recordsFiltered'] = $query_filter->num_rows();
		}

		echo json_encode($response);
	}

	/*public function load_galery($id){
		
		$select2 = '*';
		$tbl2 = 'sales_galeries';
				
		//WHERE
		$where2['data'][] = array(
			'column' => 'sales_id',
			'param'	 => $id
		);

		$query_galery = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,NULL,$where2);
		
		$this->load->view('sales/sales_g', array('query_galery' => $query_galery));
		//$this->load->view('layout/footer'); 
		
	}*/

	public function load_data_where(){
		$select = 'a.*,b.division_name';
		$tbl = 'spgs a';

		$join['data'][] = array(
			'table' => 'divisions b',
			'join'	=> 'b.division_id=a.division_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'spg_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$response['val'][] = array(
					'spg_id'			=> $val->spg_id,
					'spg_name' 		=> $val->spg_name,
					'spg_address'		=> $val->spg_address,
					'spg_birth' 	=> $this->format_date_day_mid2($val->spg_birth),
					'spg_hp' 			=> $val->spg_hp,
					'spg_rek' 			=> $val->spg_rek,
					'spg_bank' 		=> $val->spg_bank,
					'spg_npwp'			=> $val->spg_npwp,
					'spg_name_npwp' 	=> $val->spg_name_npwp,
					'spg_ktp' 			=> $val->spg_ktp,
					'division_id' 			=> $val->division_id,
					'division_name' 		=> $val->division_name,
					'spg_status'		=> $val->spg_status,
					'spg_begin' 		=> $this->format_date_day_mid2($val->spg_begin),
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data(){
		$id = $this->input->post('i_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data();
			//WHERE
			$where['data'][] = array(
				'column' => 'spg_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}

			$new_id = $id;
		} else {
			//INSERT
			$data = $this->general_post_data();
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}

			$new_id = $insert->output;
		}
		
		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'spg_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl, $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	/* Saving $data as array to database */
	function general_post_data(){
		$data = array(
			'spg_name' 			=> $this->input->post('i_name', TRUE),
			'spg_birth' 		=> $this->format_date_day_mid($this->input->post('i_date', TRUE)),
			'spg_hp' 				=> $this->input->post('i_hp', TRUE),
			'spg_rek' 				=> $this->input->post('i_rek', TRUE),
			'spg_bank' 			=> $this->input->post('i_bank', TRUE),
			'spg_npwp' 			=> $this->input->post('i_no_npwp', TRUE),
			'spg_name_npwp' 		=> $this->input->post('i_name_npwp', TRUE),
			'spg_ktp' 				=> $this->input->post('i_ktp', TRUE),
			'division_id' 				=> $this->input->post('i_division', TRUE),
			'spg_status' 			=> $this->input->post('i_status', TRUE),
			'spg_address' 			=> $this->input->post('i_addres', TRUE),
			'spg_begin' 			=> $this->format_date_day_mid($this->input->post('i_date_begin', TRUE))
			);

		return $data;

	}
	public function load_data_select_spg(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'spg_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'spg_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','spgs',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->spg_id,
					'text'	=> $val->spg_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
