<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class keyword extends MY_Controller {
	private $any_error = array();
	public $tbl = 'keywords';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,75);
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
			'title_page' 	=> 'Setup Data / Password-Request',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('keyword_v', $data);
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
		$select = 'a.*,b.side_menu_name,c.user_name';
		$tbl = 'keywords a';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'side_menu_name,user_name',
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
			'table' => 'side_menus b',
			'join'	=> 'b.side_menu_id=a.side_menu_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'users c',
			'join'	=> 'c.user_id=a.user_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->keyword_id>0) {
					$response['data'][] = array(
						$val->side_menu_name,
						$val->user_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->keyword_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->keyword_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.side_menu_name,c.user_name';
		$tbl = 'keywords a';
		//WHERE
		$where['data'][] = array(
			'column' => 'keyword_id',
			'param'	 => $this->input->get('id')
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'side_menus b',
			'join'	=> 'b.side_menu_id=a.side_menu_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'users c',
			'join'	=> 'c.user_id=a.user_id',
			'type'	=> 'left'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'keyword_id'			=> $val->keyword_id,
					'keyword_value1' 		=> $val->keyword_value1,
					'keyword_value2' 		=> $val->keyword_value2,
					'keyword_value3' 		=> $val->keyword_value3,
					'side_menu_id' 			=> $val->side_menu_id,
					'side_menu_name' 		=> $val->side_menu_name,
					'user_id' 				=> $val->user_id,
					'user_name' 			=> $val->user_name,
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
				'column' => 'keyword_id',
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
			$data = $this->general_post_data();
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
			'column' => 'keyword_id',
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
			'keyword_value1' 		=> md5($this->input->post('i_password1', TRUE)),
			'keyword_value2' 		=> md5($this->input->post('i_password2', TRUE)),
			'keyword_value3' 		=> md5($this->input->post('i_password3', TRUE)),
			'side_menu_id' 				=> $this->input->post('i_menu_id', TRUE),
			'user_id' 				=> $this->user_id
			);

		return $data;
	}

	public function load_data_select_menu(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'side_menu_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'side_menu_name',
			'type'	 => 'ASC'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'side_menu_type_parent',
			'param'	 => 0
		);
		$query = $this->g_mod->select('*','side_menus',NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->side_menu_id,
					'text'	=> $val->side_menu_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function cek_password(){

		$id 		= $this->input->post('id');
		$menu_id 	= $this->input->post('menu_id');
		$value 		= md5($this->input->post('value'));

		switch ($menu_id) {
			case '50':
				$tbl 						= 'memos';
				$columb 					= 'memo_id';
				$data['memo_lock'] 			= 0;
				$data['memo_request'] 		= 0;
				break;
			case '48':
				$tbl 						= 'mixers';
				$columb 					= 'mixer_id';
				$data['mixer_lock'] 		= 0;
				$data['mixer_request'] 		= 0;
				break;
			case '51':
				$tbl 						= 'packagings';
				$columb 					= 'packaging_id';
				$data['packaging_lock'] 	= 0;
				$data['packaging_request'] 	= 0;
				break;
			case '49':
				$tbl 						= 'productions';
				$columb 					= 'production_id';
				$data['production_lock'] 	= 0;
				$data['production_request'] 	= 0;
				break;
			
		}
		
		$where = "side_menu_id = $menu_id and keyword_value1 = '$value' or keyword_value2 = '$value' or keyword_value3 = '$value'";
		$query = $this->g_mod->select('*','keywords',NULL,NULL,NULL,NULL,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			$response['status'] = '200';

			$where2['data'][] = array(
				'column' => $columb,
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($tbl, $where2, $data);
		}else{
			$response['status'] = '204';
		}

		echo json_encode($response);
	}
	/* end Function */

}
