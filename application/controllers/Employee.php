<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MY_Controller {
	private $any_error = array();
	public $tbl = 'employees';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,41);
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
			'title_page' 	=> 'Master Data / Pegawai',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('employee_v', $data);
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
		$tbl = 'employees a';
		$select = 'a.*,b.division_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'employee_name,employee_hp,division_name,employee_status,employee_address',
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
			'table' => 'divisions b',
			'join'	=> 'b.division_id=a.division_id',
			'type'	=> 'inner'
		);
		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->employee_id>0) {
					$response['data'][] = array(
						$val->employee_name,
						$val->employee_hp,
						$val->employee_address,
						$val->division_name,
						$val->employee_status,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->employee_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->employee_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.division_name';
		$tbl = 'employees a';
		//JOIN
		$join['data'][] = array(
			'table' => 'divisions b',
			'join'	=> 'b.division_id=a.division_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'employee_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'employee_id'			=> $val->employee_id,
					'employee_name' 		=> $val->employee_name,
					'employee_address'		=> $val->employee_address,
					'employee_birth_date' 	=> $this->format_date_day_mid2($val->employee_birth_date),
					'employee_hp' 			=> $val->employee_hp,
					'employee_rek' 			=> $val->employee_rek,
					'employee_bank' 		=> $val->employee_bank,
					'employee_npwp'			=> $val->employee_npwp,
					'employee_name_npwp' 	=> $val->employee_name_npwp,
					'employee_ktp' 			=> $val->employee_ktp,
					'division_id' 			=> $val->division_id,
					'division_name' 		=> $val->division_name,
					'employee_status'		=> $val->employee_status,
					'employee_begin' 		=> $this->format_date_day_mid2($val->employee_begin),
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
				'column' => 'employee_id',
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
			//echo $data['employee_img'];
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
			'column' => 'employee_id',
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
			'employee_name' 			=> $this->input->post('i_name', TRUE),
			'employee_birth_date' 		=> $this->format_date_day_mid($this->input->post('i_date', TRUE)),
			'employee_hp' 				=> $this->input->post('i_hp', TRUE),
			'employee_rek' 				=> $this->input->post('i_rek', TRUE),
			'employee_bank' 			=> $this->input->post('i_bank', TRUE),
			'employee_npwp' 			=> $this->input->post('i_no_npwp', TRUE),
			'employee_name_npwp' 		=> $this->input->post('i_name_npwp', TRUE),
			'employee_ktp' 				=> $this->input->post('i_ktp', TRUE),
			'division_id' 				=> $this->input->post('i_division', TRUE),
			'employee_status' 			=> $this->input->post('i_status', TRUE),
			'employee_address' 			=> $this->input->post('i_addres', TRUE),
			'employee_begin' 			=> $this->format_date_day_mid($this->input->post('i_date_begin', TRUE))
			);
			

		return $data;
	}
	
	public function load_data_select_employee(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'employee_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'employee_name',
			'type'	 => 'ASC'
		);

		
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->employee_id,
					'text'	=> $val->employee_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	/* end Function */

}
