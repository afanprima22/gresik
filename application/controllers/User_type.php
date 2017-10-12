<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_type extends MY_Controller {
	private $any_error = array();
	public $tbl = 'user_types';

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
			'aplikasi'		=> 'Bali System',
			'title_page' 	=> 'Setting / User Type',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('user_type_v', $data);
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
			'column' => 'user_type_name',
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
				if ($val->user_type_id>0) {
					$response['data'][] = array(
						$val->user_type_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->user_type_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->user_type_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'user_type_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'user_type_id'			=> $val->user_type_id,
					'user_type_name' 		=> $val->user_type_name,
				);
			}
		}

		$query_p = $this->g_mod->select($select,'permits',NULL,NULL,NULL,NULL,$where);
		if ($query_p<>false) {

			foreach ($query_p->result() as $val) {
				$response['valmenu'][] = array(
					'permit_acces'			=> $val->permit_acces,
					'side_menu_id'			=> $val->side_menu_id,
				);
			}
		}

		echo json_encode($response);
	}

	public function action_data(){
		$id = $this->input->post('i_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data();
			//WHERE
			$where['data'][] = array(
				'column' => 'user_type_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}

			$delete = $this->g_mod->delete_data_table('permits', $where);
			$query = $this->g_mod->select('*','side_menus',NULL,NULL,NULL,NULL,NULL);
			if ($query<>false) {
				foreach ($query->result() as $val) {
					$crud = $this->input->post('permit'.$val->side_menu_id);
					//echo $crud;
					if(is_array($crud)){
						$crud_value = implode(',',$crud);
					}else if($val->side_menu_type_parent == 1){
						$crud_value = 1;
					}else{
						$crud_value = '';
					}

					$data2['user_type_id'] = $id;
					$data2['side_menu_id'] = $val->side_menu_id;
					$data2['permit_acces'] = $crud_value;

					$this->g_mod->insert_data_table('permits', NULL, $data2);
				}
			}
			

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

			//WHERE
			$where['data'][] = array(
				'column' => 'user_type_id',
				'param'	 => $insert->output
			);
			$delete = $this->g_mod->delete_data_table('permits', $where);
			$query = $this->g_mod->select('*','side_menus',NULL,NULL,NULL,NULL,NULL);
			if ($query<>false) {
				foreach ($query->result() as $val) {
					$crud = $this->input->post('permit'.$val->side_menu_id);
					//echo $crud;
					if(is_array($crud)){
						$crud_value = implode(',',$crud);
					}else if($val->side_menu_type_parent == 1){
						$crud_value = 1;
					}else{
						$crud_value = '';
					}

					$data2['user_type_id'] = $insert->output;
					$data2['side_menu_id'] = $val->side_menu_id;
					$data2['permit_acces'] = $crud_value;

					$this->g_mod->insert_data_table('permits', NULL, $data2);
				}
			}
		}
		
		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'user_type_id',
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
			'user_type_name' 		=> $this->input->post('i_name', TRUE),
			);

		return $data;
	}

	public function load_data_select_user_type(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'user_type_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'user_type_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->user_type_id,
					'text'	=> $val->user_type_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
