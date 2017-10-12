<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends MY_Controller {
	private $any_error = array();
	public $tbl = 'vehicles';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,40);
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
			'title_page' 	=> 'Setup Data / Kendaraan',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('vehicle/vehicle_v', $data);
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
			'column' => 'vehicle_name,vehicle_brand,vehicle_year,vehicle_stnk',
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
				if ($val->vehicle_id>0) {
					$response['data'][] = array(
						$val->vehicle_name,
						$val->vehicle_brand,
						$val->vehicle_year,
						$val->vehicle_stnk,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->vehicle_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->vehicle_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl2 = 'vehicle_galeries ';
				
		//WHERE
		$where2['data'][] = array(
			'column' => 'vehicle_id',
			'param'	 => $id
		);

		$query_galery = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,NULL,$where2);
		
		$this->load->view('vehicle/vehicle_g', array('query_galery' => $query_galery));
		//$this->load->view('layout/footer'); 
		
	}

	public function load_data_where(){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'vehicle_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$select2 = '*';
				$tbl2 = 'vehicle_galeries ';
				
				//WHERE
				$where2['data'][] = array(
					'column' => 'vehicle_id',
					'param'	 => $val->vehicle_id
				);

				$galery = '';
				$query_galery = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,NULL,$where2);
				if ($query_galery<>false) {
					foreach ($query_galery->result() as $val2) {
						$galery['val2'][] = array(
							'vehicle_galery_id' 	=> $val2->vehicle_galery_id,
							'vehicle_galery_file' 	=> $val2->vehicle_galery_file
						);
					}
				}

				$response['val'][] = array(
					'vehicle_id'			=> $val->vehicle_id,
					'vehicle_name' 			=> $val->vehicle_name,
					'vehicle_brand' 		=> $val->vehicle_brand,
					'vehicle_year' 			=> $val->vehicle_year,
					'vehicle_kir' 			=> $this->format_date_day_mid2($val->vehicle_kir),
					'vehicle_stnk' 			=> $val->vehicle_stnk,
					'vehicle_stnk_date' 	=> $this->format_date_day_mid2($val->vehicle_stnk_date),
					'vehicle_bpkb' 			=> $val->vehicle_bpkb,
					'list_galery' 			=> $galery
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
				'column' => 'vehicle_id',
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
			'column' => 'vehicle_id',
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
			'vehicle_name' 			=> $this->input->post('i_name', TRUE),
			'vehicle_brand' 		=> $this->input->post('i_brand', TRUE),
			'vehicle_year' 			=> $this->input->post('i_year', TRUE),
			'vehicle_kir' 			=> $this->format_date_day_mid($this->input->post('i_date_kir', TRUE)),
			'vehicle_stnk' 			=> $this->input->post('i_stnk', TRUE),
			'vehicle_stnk_date' 	=> $this->format_date_day_mid($this->input->post('i_date_stnk', TRUE)),
			'vehicle_bpkb' 			=> $this->input->post('i_bpkb', TRUE)
			);

		return $data;
	}

	public function action_galery(){
		$new_name = time()."_".$_FILES['i_galery']['name'];
			
		$configUpload['upload_path']    = './images/vehicle/';                 #the folder placed in the root of project
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

			$data['vehicle_id'] = $this->input->post('i_id', TRUE);
			$data['vehicle_galery_file'] = $uploadedDetails['file_name'];

			$this->g_mod->insert_data_table('vehicle_galeries', NULL, $data);
				//$this->_createThumbnail($uploadedDetails['file_name']);
	 
				//$thumbnail_name = $uploadedDetails['raw_name']. '_thumb' .$uploadedDetails['file_ext'];   
		}
		
		echo json_encode($response);
	}

	public function delete_galery(){

		$galery_id = $this->input->post('id_galery', TRUE);

		$select = '*';
		$tbl = 'vehicle_galeries';
				
		//WHERE
		$where['data'][] = array(
			'column' => 'vehicle_galery_id',
			'param'	 => $galery_id
		);

		$query_galery = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query_galery<>false) {
			foreach ($query_galery->result() as $val) {

				$oldfile   = "images/vehicle/".$val->vehicle_galery_file;
				
				//DELETE IMAGE
				if( file_exists( $oldfile ) ){
		    		unlink( $oldfile );
				}

			}
		}

		//DELETE DATABASE
		//WHERE
		$where2['data'][] = array(
			'column' => 'vehicle_galery_id',
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

	public function load_data_select_vehicle(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'vehicle_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'vehicle_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->vehicle_id,
					'text'	=> $val->vehicle_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
