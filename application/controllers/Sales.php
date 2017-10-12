<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends MY_Controller {
	private $any_error = array();
	public $tbl = 'saless';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,37);
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
			'title_page' 	=> 'Setup Data / Sales',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('sales/sales_v', $data);
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
			'column' => 'sales_name,sales_address,sales_hp,sales_status',
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
				if ($val->sales_id>0) {
					$response['data'][] = array(
						$val->sales_name,
						$val->sales_address,
						$val->sales_hp,
						$val->sales_status,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->sales_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->sales_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl2 = 'sales_galeries';
				
		//WHERE
		$where2['data'][] = array(
			'column' => 'sales_id',
			'param'	 => $id
		);

		$query_galery = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,NULL,$where2);
		
		$this->load->view('sales/sales_g', array('query_galery' => $query_galery));
		//$this->load->view('layout/footer'); 
		
	}

	public function load_data_where(){
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'sales_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$select2 = 'a.*,b.city_name';
				$tbl2 = 'sales_cities a';
				//WHERE
				$where['data'][] = array(
					'column' => 'sales_id',
					'param'	 => $this->input->get('id')
				);
				//JOIN
				$join2['data'][] = array(
					'table' => 'cities b',
					'join'	=> 'b.city_id=a.city_id',
					'type'	=> 'inner'
				);
				$query_city = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,$join2,$where);
				foreach ($query_city->result() as $val2) {
					$city['val2'][] = array(
						'id' 	=> $val2->city_id,
						'text' 	=> $val2->city_name
					);
				}

				$response['val'][] = array(
					'sales_id'			=> $val->sales_id,
					'sales_name' 		=> $val->sales_name,
					'sales_address' 	=> $val->sales_address,
					'sales_birth' 		=> $this->format_date_day_mid2($val->sales_birth),
					'sales_ktp' 		=> $val->sales_ktp,
					'sales_simc' 		=> $val->sales_simc,
					'sales_note' 		=> $val->sales_note,
					'sales_hp' 			=> $val->sales_hp,
					'sales_begin' 		=> $this->format_date_day_mid2($val->sales_begin),
					'sales_status' 		=> $val->sales_status,
					'sales_sim_a' 		=> $val->sales_sim_a,
					'sales_married' 	=> $val->sales_married,
					'sales_type' 		=> $val->sales_type,
					'cities'			=> $city
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
				'column' => 'sales_id',
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

		$city_id = $this->input->post('i_city');
		$arrlength_city = count($city_id);

		if ($city_id) {
			//WHERE
			$where2['data'][] = array(
				'column' => 'sales_id',
				'param'	 => $new_id
			);
			$this->g_mod->delete_data_table('sales_cities',$where2);
			for($x = 0; $x < $arrlength_city; $x++) {
				$data2['sales_id'] 	= $new_id;
				$data2['city_id'] 	= $city_id[$x];
				$this->g_mod->insert_data_table('sales_cities',NULL,$data2);
			}
		}
		
		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'sales_id',
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
			'sales_name' 		=> $this->input->post('i_name', TRUE),
			'sales_address' 	=> $this->input->post('i_addres', TRUE),
			'sales_birth' 		=> $this->format_date_day_mid($this->input->post('i_date', TRUE)),
			'sales_begin' 		=> $this->format_date_day_mid($this->input->post('i_date2', TRUE)),
			'sales_ktp' 		=> $this->input->post('i_ktp', TRUE),
			'sales_note' 		=> $this->input->post('i_note', TRUE),
			'sales_simc' 		=> $this->input->post('i_simc', TRUE),
			'sales_hp' 			=> $this->input->post('i_hp', TRUE),
			'sales_sim_a' 		=> $this->input->post('i_sima', TRUE),
			'sales_married' 		=> $this->input->post('i_married', TRUE),
			'sales_type' 			=> $this->input->post('i_type', TRUE),
			'sales_status' 		=> $this->input->post('i_status', TRUE)
			);

		return $data;
	}

	public function action_galery(){
		$new_name = time()."_".$_FILES['i_galery']['name'];
			
		$configUpload['upload_path']    = './images/sales/';                 #the folder placed in the root of project
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

			$data['sales_id'] = $this->input->post('i_id', TRUE);
			$data['sales_galery_file'] = $uploadedDetails['file_name'];

			$this->g_mod->insert_data_table('sales_galeries', NULL, $data);
				//$this->_createThumbnail($uploadedDetails['file_name']);
	 
				//$thumbnail_name = $uploadedDetails['raw_name']. '_thumb' .$uploadedDetails['file_ext'];   
		}
		
		echo json_encode($response);
	}

	public function delete_galery(){

		$galery_id = $this->input->post('id_galery', TRUE);

		$select = '*';
		$tbl = 'sales_galeries';
				
		//WHERE
		$where['data'][] = array(
			'column' => 'sales_galery_id',
			'param'	 => $galery_id
		);

		$query_galery = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query_galery<>false) {
			foreach ($query_galery->result() as $val) {

				$oldfile   = "images/sales/".$val->sales_galery_file;
				
				//DELETE IMAGE
				if( file_exists( $oldfile ) ){
		    		unlink( $oldfile );
				}

			}
		}

		//DELETE DATABASE
		//WHERE
		$where2['data'][] = array(
			'column' => 'sales_galery_id',
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

	public function load_data_select_sales(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'sales_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'sales_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','saless',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->sales_id,
					'text'	=> $val->sales_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
