<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {
	private $any_error = array();
	public $tbl = 'customers';

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
			'title_page' 	=> 'Master Data / Customer',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('customer_v', $data);
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
		$tbl = 'customers a';
		$select = 'a.*,b.location_name,c.customer_type_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'customer_name,customer_telp,customer_store,customer_type_name,location_name',
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
			'table' => 'locations b',
			'join'	=> 'b.location_id=a.location_id',
			'type'	=> 'left'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'customer_types c',
			'join'	=> 'c.customer_type_id=a.customer_type_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->customer_id>0) {
					$response['data'][] = array(
						$val->customer_name,
						$val->customer_telp,
						$val->customer_store,
						$val->customer_type_name,
						$val->location_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->customer_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->customer_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data2($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'customer_prices a';
		$select = 'a.*,b.item_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,customer_price_value,customer_price_promo1,customer_price_promo2',
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
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'customer_id',
			'param'	 => $id
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->customer_price_id>0) {
					$response['data'][] = array(
						$val->customer_price_id,
						$val->item_name,
						number_format($val->customer_price_value),
						number_format($val->customer_price_promo1),
						number_format($val->customer_price_promo2),
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_price('.$val->customer_price_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_price('.$val->customer_price_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_category(){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'customer_categories a';
		$select = 'a.*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'customer_category_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,NULL,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,NULL,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->customer_category_id>0) {
					$response['data'][] = array(
						$val->customer_category_id,
						$val->customer_category_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_category('.$val->customer_category_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_category('.$val->customer_category_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,c.customer_type_name,b.city_name,d.customer_type_name as customer_type_sub_name,e.customer_category_name';
		$tbl = 'customers a';
		//JOIN
		$join['data'][] = array(
			'table' => 'cities b',
			'join'	=> 'b.city_id=a.city_id',
			'type'	=> 'left'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'customer_types c',
			'join'	=> 'c.customer_type_id=a.customer_type_id',
			'type'	=> 'left'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'customer_types d',
			'join'	=> 'd.customer_type_id=a.customer_type_sub_id',
			'type'	=> 'left'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'customer_categories e',
			'join'	=> 'e.customer_category_id=a.customer_category_id',
			'type'	=> 'left'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'customer_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'customer_id'				=> $val->customer_id,
					'customer_name' 			=> $val->customer_name,
					'customer_address' 			=> $val->customer_address,
					'customer_store' 			=> $val->customer_store,
					'customer_store_address' 	=> $val->customer_store_address,
					'customer_telp' 			=> $val->customer_telp,
					'customer_hp'				=> $val->customer_hp,
					'customer_no_npwp' 			=> $val->customer_no_npwp,
					'customer_name_npwp' 		=> $val->customer_name_npwp,
					'customer_mail' 			=> $val->customer_mail,
					'customer_type_id' 			=> $val->customer_type_id,
					'customer_type_sub_id' 		=> $val->customer_type_sub_id,
					'customer_type_sub_name' 	=> $val->customer_type_sub_name,
					'customer_warehouse'		=> $val->customer_warehouse,
					'customer_purchase_pic' 	=> $val->customer_purchase_pic,
					'customer_purchase_tlp' 	=> $val->customer_purchase_tlp,
					'customer_warehouse_pic' 	=> $val->customer_warehouse_pic,
					'customer_warehouse_tlp' 	=> $val->customer_warehouse_tlp,
					'customer_store_pic' 		=> $val->customer_store_pic,
					'customer_store_tlp' 		=> $val->customer_store_tlp,
					'city_id' 					=> $val->city_id,
					'customer_img' 				=> base_url().'images/customer/'.$val->customer_img,
					'promo1_name'				=> $val->promo1_name,
					'promo1_date' 				=> $this->format_date_day_mid2($val->promo1_date1).' - '.$this->format_date_day_mid2($val->promo1_date2),
					'promo2_name' 				=> $val->promo2_name,
					'promo2_date' 				=> $this->format_date_day_mid2($val->promo2_date1).' - '.$this->format_date_day_mid2($val->promo2_date2),
					'customer_type_name' 		=> $val->customer_type_name,
					'city_name' 				=> $val->city_name,
					'customer_category_id' 		=> $val->customer_category_id,
					'customer_category_name' 	=> $val->customer_category_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_price(){
		$select = 'a.*,b.item_name';
		$tbl = 'customer_prices a';
		//WHERE
		$where['data'][] = array(
			'column' => 'customer_price_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'customer_price_id'			=> $val->customer_price_id,
					'customer_price_value' 		=> $val->customer_price_value,
					'customer_price_promo1' 	=> $val->customer_price_promo1,
					'customer_price_promo2' 	=> $val->customer_price_promo2,
					'item_id' 					=> $val->item_id,
					'item_name' 				=> $val->item_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_category(){
		$select = 'a.*';
		$tbl = 'customer_categories a';
		//WHERE
		$where['data'][] = array(
			'column' => 'customer_category_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'customer_category_id'			=> $val->customer_category_id,
					'customer_category_name' 		=> $val->customer_category_name,
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
			if ($data['customer_type_id'] == 4) {

				$date1 = $this->input->post('i_promo1_date');

				$date1 = str_replace(" ", "", $date1);
				$date1 = explode("-", $date1);
				$date11 = $date1[0];
				$date12 = $date1[1];

				$date2 = $this->input->post('i_promo2_date');

				$date2 = str_replace(" ", "", $date2);
				$date2 = explode("-", $date2);
				$date21 = $date2[0];
				$date22 = $date2[1];

				$data['promo1_name'] = $this->input->post('i_name_promo1');
				$data['promo2_name'] = $this->input->post('i_name_promo2');
				$data['promo1_date1'] = $this->format_date_day_mid($date11);
				$data['promo1_date2'] = $this->format_date_day_mid($date12);
				$data['promo2_date1'] = $this->format_date_day_mid($date21);
				$data['promo2_date2'] = $this->format_date_day_mid($date22);
			}
			//WHERE
			$where['data'][] = array(
				'column' => 'customer_id',
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
			//echo $data['customer_img'];
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

	public function action_data_price(){
		$id = $this->input->post('i_price_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_price();
			//WHERE
			$where['data'][] = array(
				'column' => 'customer_price_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('customer_prices', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_price();
			//echo $data['customer_img'];
			$insert = $this->g_mod->insert_data_table('customer_prices', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_category(){
		$id = $this->input->post('i_category_id');
		if (strlen($id)>0) {
			//UPDATE
			$data['customer_category_name'] = $this->input->post('i_category_name');
			//WHERE
			$where['data'][] = array(
				'column' => 'customer_category_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('customer_categories', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data['customer_category_name'] = $this->input->post('i_category_name');
			//echo $data['customer_img'];
			$insert = $this->g_mod->insert_data_table('customer_categories', NULL, $data);
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
			'column' => 'customer_id',
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

	public function delete_data_price(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'customer_price_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('customer_prices', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_category(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'customer_category_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('customer_categories', $where);
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
				$get_img = $this->g_mod->get_img("customers", "customer_img", "customer_id = '$id'");
			
				$oldfile   = "images/customer/".$get_img;
			
				if( file_exists( $oldfile ) ){
	    			unlink( $oldfile );
				}
			}

			$img_name = $this->upload_img('i_img');

			//$img 	= str_replace(" ", "_", $new_name);

			$data['customer_img']  = $img_name;

		}

		$data['customer_name'] 				= $this->input->post('i_name', TRUE);
		$data['customer_address'] 			= $this->input->post('i_addres', TRUE);
		$data['customer_store'] 			= $this->input->post('i_store', TRUE);
		$data['customer_store_address'] 	= $this->input->post('i_store_addres', TRUE);
		$data['customer_telp'] 				= $this->input->post('i_telp', TRUE);
		$data['customer_hp'] 				= $this->input->post('i_hp', TRUE);
		$data['customer_no_npwp'] 			= $this->input->post('i_no_npwp', TRUE);
		$data['customer_name_npwp'] 		= $this->input->post('i_name_npwp', TRUE);
		$data['customer_mail'] 				= $this->input->post('i_mail', TRUE);
		$data['customer_type_id'] 			= $this->input->post('i_type', TRUE);
		//$data['city_id'] 					= $this->input->post('i_city', TRUE);
		$data['location_id'] 					= $this->input->post('i_city', TRUE);
		$data['customer_category_id'] 		= $this->input->post('i_category', TRUE);
		$data['customer_warehouse'] 		= $this->input->post('i_warehouse_addres', TRUE);
		$data['customer_purchase_pic'] 		= $this->input->post('i_purchase_pic', TRUE);
		$data['customer_purchase_tlp'] 		= $this->input->post('i_purchase_tlp', TRUE);
		$data['customer_warehouse_pic'] 	= $this->input->post('i_warehouse_pic', TRUE);
		$data['customer_warehouse_tlp'] 	= $this->input->post('i_warehouse_tlp', TRUE);
		$data['customer_store_pic'] 		= $this->input->post('i_store_pic', TRUE);
		$data['customer_store_tlp'] 		= $this->input->post('i_store_tlp', TRUE);
			

		return $data;
	}

	function general_post_data_price(){

		$data = array(
			'customer_id' 					=> $this->input->post('i_id', TRUE),
			'item_id' 						=> $this->input->post('i_item', TRUE),
			'customer_price_value' 			=> $this->input->post('i_price', TRUE),
			'customer_price_promo1' 		=> $this->input->post('i_promo1', TRUE),
			'customer_price_promo2' 		=> $this->input->post('i_promo2', TRUE),
			'user_id' 						=> $this->user_id
			);
			

		return $data;
	}

	public function upload_img($img){
		$new_name = time()."_".$_FILES[$img]['name'];
			
			$configUpload['upload_path']    = './images/customer/';                 #the folder placed in the root of project
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

	public function load_data_select_type(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'customer_type_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'customer_type_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','customer_types',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->customer_type_id,
					'text'	=> $val->customer_type_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_customer(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'customer_name,customer_store',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'customer_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','customers',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->customer_id,
					'text'	=> $val->customer_name.'-'.$val->customer_store
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_category(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'customer_category_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'customer_category_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','customer_categories',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->customer_category_id,
					'text'	=> $val->customer_category_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
