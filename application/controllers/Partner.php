<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends MY_Controller {
	private $any_error = array();
	public $tbl = 'partners';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,31);
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
			'title_page' 	=> 'Master Data / Partner',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('partner_v', $data);
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
		$tbl = 'partners a';
		$select = 'a.*,b.category_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'partner_name,partner_telp,category_name,partner_sales_name,partner_address',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'categories b',
			'join'	=> 'b.category_id=a.category_id',
			'type'	=> 'inner'
		);
		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->partner_id>0) {
					$response['data'][] = array(
						$val->partner_name,
						$val->partner_telp,
						$val->category_name,
						$val->partner_sales_name,
						$val->partner_address,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->partner_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->partner_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_where(){
		$select = 'a.*,b.category_name';
		$tbl = 'partners a';
		//JOIN
		$join['data'][] = array(
			'table' => 'categories b',
			'join'	=> 'b.category_id=a.category_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'partner_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'partner_id'			=> $val->partner_id,
					'partner_name' 			=> $val->partner_name,
					'partner_sales_name' 	=> $val->partner_sales_name,
					'category_id' 			=> $val->category_id,
					'category_name' 		=> $val->category_name,
					'partner_owner' 		=> $val->partner_owner,
					'partner_telp' 			=> $val->partner_telp,
					'partner_hp'			=> $val->partner_hp,
					'partner_address' 		=> $val->partner_address,
					'partner_rek' 			=> $val->partner_rek,
					'partner_bank' 			=> $val->partner_bank,
					'partner_mail' 			=> $val->partner_mail,
					'partner_npwp'			=> $val->partner_npwp,
					'partner_name_npwp' 	=> $val->partner_name_npwp,
					'partner_npwp_rek' 		=> $val->partner_npwp_rek,
					'partner_npwp_bank' 	=> $val->partner_npwp_bank,
					'partner_tempo' 		=> $val->partner_tempo,
				);
			}

			echo json_encode($response);
		}
	}

	public function action_data(){
		$id = $this->input->post('i_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'partner_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data($id);
			//echo $data['partner_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'partner_id',
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
	function general_post_data($id){

		$data = array(
			'partner_name' 			=> $this->input->post('i_name', TRUE),
			'partner_sales_name' 	=> $this->input->post('i_sales_partner', TRUE),
			'category_id' 			=> $this->input->post('i_category', TRUE),
			'partner_owner' 		=> $this->input->post('i_owner', TRUE),
			'partner_telp' 			=> $this->input->post('i_telp', TRUE),
			'partner_hp' 			=> $this->input->post('i_hp', TRUE),
			'partner_address' 		=> $this->input->post('i_addres', TRUE),
			'partner_rek' 			=> $this->input->post('i_rek', TRUE),
			'partner_bank' 			=> $this->input->post('i_bank', TRUE),
			'partner_mail' 			=> $this->input->post('i_mail', TRUE),
			'partner_npwp' 			=> $this->input->post('i_no_npwp', TRUE),
			'partner_name_npwp' 	=> $this->input->post('i_name_npwp', TRUE),
			'partner_npwp_rek' 		=> $this->input->post('i_npwp_rek', TRUE),
			'partner_npwp_bank' 	=> $this->input->post('i_npwp_bank', TRUE),
			'partner_tempo' 		=> $this->input->post('i_tempo', TRUE)
			);
			

		return $data;
	}

	public function load_data_select_category(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'category_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'category_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','categories',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->category_id,
					'text'	=> $val->category_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_partner(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'partner_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'partner_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->partner_id,
					'text'	=> $val->partner_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
