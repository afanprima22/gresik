<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user extends MY_Controller {
	private $any_error = array();
	public $tbl = 'users';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,29);
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
			'title_page' 	=> 'Master Data / user',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('user_v', $data);
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
			'column' => 'user_name,user_ktp,user_active_status',
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
				if ($val->user_id>0) {
					if ($val->user_active_status == 1) {
						$status = 'Aktif';
					}else{
						$status = 'Tidak Aktif';
					}
					$response['data'][] = array(
						$val->user_ktp,
						$val->user_name,
						$status,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->user_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->user_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.user_type_name';
		$tbl = 'users a';
		//JOIN
		$join['data'][] = array(
			'table' => 'user_types b',
			'join'	=> 'b.user_type_id=a.user_type_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'user_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'user_id'				=> $val->user_id,
					'user_type_id' 			=> $val->user_type_id,
					'user_type_name' 		=> $val->user_type_name,
					'user_username' 		=> $val->user_username,
					'user_password' 		=> $val->user_password,
					'user_name'				=> $val->user_name,
					'user_addres' 			=> $val->user_addres,
					'user_ktp' 				=> $val->user_ktp,
					'user_img' 				=> base_url().'images/user/'.$val->user_img,
					'user_active_status' 	=> $val->user_active_status,
					
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
				'column' => 'user_id',
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
			//echo $data['user_img'];
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
			'column' => 'user_id',
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
		$this->load->library('upload');

		//$img = $this->input->post('i_img', TRUE);
		// upload gambar
		if($_FILES['i_img']['name']){

			if($id){
				$get_img = $this->g_mod->get_img("users", "user_img", "user_id = '$id'");
			
				$oldfile   = "images/user/".$get_img;
			
				if( file_exists( $oldfile ) ){
	    			unlink( $oldfile );
				}
			}

			$img_name = $this->upload_img('i_img');

			//$img 	= str_replace(" ", "_", $new_name);

			$data['user_img']  = $img_name;

		}

		$data['user_name'] 				= $this->input->post('i_name', TRUE);
		$data['user_addres'] 			= $this->input->post('i_addres', TRUE);
		$data['user_type_id'] 			= $this->input->post('i_type', TRUE);
		$data['user_username'] 			= $this->input->post('i_username', TRUE);
		$data['user_password'] 			= md5($this->input->post('i_password', TRUE));
		$data['user_ktp'] 				= $this->input->post('i_ktp', TRUE);
		$data['user_active_status'] 	= $this->input->post('i_status', TRUE);
			

		return $data;
	}

	public function upload_img($img){
		$new_name = time()."_".$_FILES[$img]['name'];
			
			$configUpload['upload_path']    = './images/user/';                 #the folder placed in the root of project
			$configUpload['allowed_types']  = 'gif|jpg|png|bmp|jpeg';       #allowed types description
			$configUpload['max_size']	= 1024 * 8;
			$configUpload['encrypt_name']   = TRUE;   
			$configUpload['file_name'] 		= $new_name;                      	#encrypt name of the uploaded file

			$this->load->library('upload', $configUpload);                  #init the upload class
			$this->upload->initialize($configUpload);

			if(!$this->upload->do_upload($img)){
				$uploadedDetails    = $this->upload->display_errors();
			}else{
				$uploadedDetails    = $this->upload->data(); 
				//$this->_createThumbnail($uploadedDetails['file_name']);
	 
				//$thumbnail_name = $uploadedDetails['raw_name']. '_thumb' .$uploadedDetails['file_ext'];   
			}
			
			return $uploadedDetails['file_name'];
	}

	public function load_data_select_user(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'user_name,user_store',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'user_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','users',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->user_id,
					'text'	=> $val->user_name.'-'.$val->user_store
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	/* end Function */

}
