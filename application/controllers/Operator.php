<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends MY_Controller {
	private $any_error = array();
	public $tbl = 'operators';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,36);
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
			'title_page' 	=> 'Setup Data / Sopir&Kernet',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('operator/operator_v', $data);
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
			'column' => 'operator_name,operator_address,operator_hp,operator_type',
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
				if ($val->operator_id>0) {
					$response['data'][] = array(
						$val->operator_name,
						$val->operator_address,
						$val->operator_hp,
						$val->operator_type,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->operator_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->operator_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_galery($id){
		
		$select2 = '*';
		$tbl2 = 'operator_galeries ';
				
		//WHERE
		$where2['data'][] = array(
			'column' => 'operator_id',
			'param'	 => $id
		);

		$query_galery = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,NULL,$where2);
		
		$this->load->view('operator/operator_g', array('query_galery' => $query_galery));
		//$this->load->view('layout/footer'); 
		
	}

	public function load_data_where(){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'operator_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$response['val'][] = array(
					'operator_id'			=> $val->operator_id,
					'operator_name' 		=> $val->operator_name,
					'operator_address' 		=> $val->operator_address,
					'operator_birth' 		=> $this->format_date_day_mid2($val->operator_birth),
					'operator_ktp' 			=> $val->operator_ktp,
					'operator_simb1' 		=> $val->operator_simb1,
					'operator_simc' 		=> $val->operator_simc,
					'operator_sima' 		=> $val->operator_sima,
					'operator_hp' 			=> $val->operator_hp,
					'operator_type' 		=> $val->operator_type
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
				'column' => 'operator_id',
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
			'column' => 'operator_id',
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
			'operator_name' 		=> $this->input->post('i_name', TRUE),
			'operator_address' 		=> $this->input->post('i_addres', TRUE),
			'operator_birth' 		=> $this->format_date_day_mid($this->input->post('i_date', TRUE)),
			'operator_ktp' 			=> $this->input->post('i_ktp', TRUE),
			'operator_simb1' 		=> $this->input->post('i_simb1', TRUE),
			'operator_simc' 		=> $this->input->post('i_simc', TRUE),
			'operator_sima' 		=> $this->input->post('i_sima', TRUE),
			'operator_hp' 			=> $this->input->post('i_hp', TRUE),
			'operator_type' 		=> $this->input->post('i_type', TRUE)
			);

		return $data;
	}

	public function action_galery(){
		$new_name = time()."_".$_FILES['i_galery']['name'];
			
		$configUpload['upload_path']    = './images/operator/';                 #the folder placed in the root of project
		$configUpload['allowed_types']  = 'gif|jpg|png|bmp|jpeg';       #allowed types description
		$configUpload['max_size']	= 1024 * 8;
		$configUpload['encrypt_name']   = TRUE;   
		$configUpload['file_name'] 		= $new_name;                      	#encrypt name of the uploaded file

		$this->load->library('upload', $configUpload);                  #init the upload class
		$this->upload->initialize($configUpload);

		if(!$this->upload->do_upload('i_galery')){
			$uploadedDetails    = $this->upload->display_errors();
			$response['status'] = '204';
		}else{
			$uploadedDetails    = $this->upload->data(); 
			$response['status'] = '200';

			$data['operator_id'] = $this->input->post('i_id', TRUE);
			$data['operator_galery_file'] = $uploadedDetails['file_name'];

			$this->g_mod->insert_data_table('operator_galeries', NULL, $data);
				//$this->_createThumbnail($uploadedDetails['file_name']);
	 
				//$thumbnail_name = $uploadedDetails['raw_name']. '_thumb' .$uploadedDetails['file_ext'];   
		}
		
		echo json_encode($response);
	}

	public function delete_galery(){

		$galery_id = $this->input->post('id_galery', TRUE);

		$select = '*';
		$tbl = 'operator_galeries';
				
		//WHERE
		$where['data'][] = array(
			'column' => 'operator_galery_id',
			'param'	 => $galery_id
		);

		$query_galery = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query_galery<>false) {
			foreach ($query_galery->result() as $val) {

				$oldfile   = "images/operator/".$val->operator_galery_file;
				
				//DELETE IMAGE
				if( file_exists( $oldfile ) ){
		    		unlink( $oldfile );
				}

			}
		}

		//DELETE DATABASE
		//WHERE
		$where2['data'][] = array(
			'column' => 'operator_galery_id',
			'param'	 => $galery_id
		);
		$delete = $this->g_mod->delete_data_table($tbl, $where2);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function load_data_select_operator($id = 0){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'operator_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'operator_name',
			'type'	 => 'ASC'
		);
		if ($id == 1) {
			$where['data'][] = array(
				'column' => 'operator_type',
				'param'	 => 'Sopir'
			);
		}

		if ($id == 2) {
			$where['data'][] = array(
				'column' => 'operator_type',
				'param'	 => 'Kernet'
			);
		}

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->operator_id,
					'text'	=> $val->operator_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	/* end Function */

}
