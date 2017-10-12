<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discount extends MY_Controller {
	private $any_error = array();
	public $tbl = 'discounts';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,66);
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
			'title_page' 	=> 'Mater Data / Promo',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('discount_v', $data);
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
		$tbl = 'discounts a';
		$select = 'a.*,b.city_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'discount_name,discount_date1,city_name',
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
			'table' => 'cities b',
			'join'	=> 'b.city_id=a.city_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->discount_id>0) {
					if ($val->discount_type == 0) {
						$type = "Bonus Barang";
					}else{
						$type = "Diskon";
					}
					$response['data'][] = array(
						$val->discount_name,
						$this->format_date_day_first($val->discount_date1).' S/D '.$this->format_date_day_first($val->discount_date2),
						$type,
						$val->discount_presentase,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->discount_id.'),reset(),reset2()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->discount_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_item($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'discount_details a';
		$select = 'a.*,b.item_name,c.item_discount_name	';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'discount_detail_total,discount_detail_qty,discount_detail_persen,item_name,c.item_discount_name',
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
			'join'	=> 'b.item_id=a.item_data_id and a.discount_detail_type = 0',
			'type'	=> 'left'
		);
		$join['data'][] = array(
			'table' => 'item_discounts c',
			'join'	=> 'c.item_discount_id=a.item_data_id and a.discount_detail_type = 1',
			'type'	=> 'left'
		);


		//WHERE
		$where['data'][] = array(
			'column' => 'discount_id',
			'param'	 => $id
		);
		if (!$id) {
			$where['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
		}

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->discount_detail_type == 0) {
					$name = $val->item_name;
				}else{
					$name = $val->item_discount_name;
				}
				if ($val->discount_detail_id>0) {
					$response['data'][] = array(
						$val->discount_detail_qty,
						number_format($val->discount_detail_total),
						$name,
						$val->discount_detail_item,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->discount_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->discount_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_discount($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'discount_details a';
		$select = 'a.*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'discount_detail_total,discount_detail_qty,discount_detail_persen',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'discount_id',
			'param'	 => $id
		);
		if (!$id) {
			$where['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
		}

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,NULL,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,NULL,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->discount_detail_id>0) {
					$response['data'][] = array(
						$val->discount_detail_qty,
						number_format($val->discount_detail_total),
						$val->discount_detail_persen,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->discount_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->discount_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.customer_name,c.city_name,d.category_item_name';
		$tbl = 'discounts a';
		//WHERE
		$where['data'][] = array(
			'column' => 'discount_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'customers b',
			'join'	=> 'b.customer_id=a.customer_id',
			'type'	=> 'left'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'cities c',
			'join'	=> 'c.city_id=a.city_id',
			'type'	=> 'left'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'category_items d',
			'join'	=> 'd.category_item_id=a.category_item_id',
			'type'	=> 'left'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$select2 = 'a.*,b.item_name';
				$tbl2 = 'discount_items a';
				//WHERE
				$where2['data'][] = array(
					'column' => 'discount_id',
					'param'	 => $this->input->get('id')
				);
				//JOIN
				$join2['data'][] = array(
					'table' => 'items b',
					'join'	=> 'b.item_id=a.item_id',
					'type'	=> 'inner'
				);
				$query_item = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,$join2,$where2);
				if ($query_item<>false) {
					foreach ($query_item->result() as $val2) {
						$item['val2'][] = array(
							'id' 	=> $val2->item_id,
							'text' 	=> $val2->item_name
						);
					}
				}else{
					$item['val2'][] = array(
						'id' 	=> '',
						'text' 	=> ''
					);
				}

				//JOIN
				$join3['data'][] = array(
					'table' => 'locations b',
					'join'	=> 'b.location_id=a.location_id',
					'type'	=> 'inner'
				);
				$query_location = $this->g_mod->select('a.*,b.location_name','discount_locations a',NULL,NULL,NULL,$join3,$where2);
				if ($query_location<>false) {
					foreach ($query_location->result() as $val2) {
						$location['val2'][] = array(
							'id' 	=> $val2->location_id,
							'text' 	=> $val2->location_name
						);
					}
				}else{
					$location['val2'][] = array(
						'id' 	=> '',
						'text' 	=> ''
					);
				}

				//JOIN
				$join4['data'][] = array(
					'table' => 'customers b',
					'join'	=> 'b.customer_id=a.customer_id',
					'type'	=> 'inner'
				);
				$query_customer = $this->g_mod->select('a.*,b.customer_name','discount_customers a',NULL,NULL,NULL,$join4,$where2);
				if ($query_customer<>false) {
					foreach ($query_customer->result() as $val2) {
						$customer['val2'][] = array(
							'id' 	=> $val2->customer_id,
							'text' 	=> $val2->customer_name
						);
					}
				}else{
					$customer['val2'][] = array(
						'id' 	=> '',
						'text' 	=> ''
					);
				}

				//JOIN
				$join5['data'][] = array(
					'table' => 'category_items b',
					'join'	=> 'b.category_item_id=a.category_item_id',
					'type'	=> 'inner'
				);
				$query_category = $this->g_mod->select('a.*,b.category_item_name','discount_categories a',NULL,NULL,NULL,$join5,$where2);
				if ($query_category<>false) {
					foreach ($query_category->result() as $val2) {
						$category['val2'][] = array(
							'id' 	=> $val2->category_item_id,
							'text' 	=> $val2->category_item_name
						);
					}
				}else{
					$category['val2'][] = array(
						'id' 	=> '',
						'text' 	=> ''
					);
				}

				$response['val'][] = array(
					'discount_id'			=> $val->discount_id,
					'discount_name' 		=> $val->discount_name,
					'discount_type' 		=> $val->discount_type,
					'discount_date1' 		=> $this->format_date_day_mid2($val->discount_date1),
					'discount_date2' 		=> $this->format_date_day_mid2($val->discount_date2),
					'discount_status' 		=> $val->discount_status,
					'discount_periode' 		=> $val->discount_periode,
					'discount_presentase' 	=> $val->discount_presentase,
					'customer_id' 			=> $val->customer_id,
					'customer_name' 		=> $val->customer_name,
					'city_id' 				=> $val->city_id,
					'city_name' 			=> $val->city_name,
					'category_item_id' 		=> $val->category_item_id,
					'category_item_name' 	=> $val->category_item_name,
					'item'					=> $item,
					'location'				=> $location,
					'customer'				=> $customer,
					'category'				=> $category
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.item_name,c.item_discount_name';
		$tbl = 'discount_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'discount_detail_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_data_id and a.discount_detail_type = 0',
			'type'	=> 'left'
		);
		$join['data'][] = array(
			'table' => 'item_discounts c',
			'join'	=> 'c.item_discount_id=a.item_data_id and a.discount_detail_type = 1',
			'type'	=> 'left'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$response['val'][] = array(
					'discount_detail_id'		=> $val->discount_detail_id,
					'discount_detail_total' 	=> $val->discount_detail_total,
					'discount_detail_qty' 		=> $val->discount_detail_qty,
					'discount_detail_persen' 	=> $val->discount_detail_persen,
					'discount_detail_item' 		=> $val->discount_detail_item,
					'item_data_id' 				=> $val->item_data_id,
					'item_name' 				=> $val->item_name,
					'item_discount_name' 		=> $val->item_discount_name,
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
				'column' => 'discount_id',
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

			$where2['data'][] = array(
				'column' => 'discount_id',
				'param'	 => 0
			);
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);

			$data2['discount_id'] = $new_id;
			$this->g_mod->update_data_table('discount_details', $where2, $data2);
		}


		//WHERE
		$where3['data'][] = array(
			'column' => 'discount_id',
			'param'	 => $new_id
		);

		$item_id = $this->input->post('i_item_multy');
		$arrlength_item = count($item_id);
		$this->g_mod->delete_data_table('discount_items',$where3);
		if ($item_id) {
			for($x = 0; $x < $arrlength_item; $x++) {
				$data3['discount_id'] 	= $new_id;
				$data3['item_id'] 	= $item_id[$x];
				$this->g_mod->insert_data_table('discount_items',NULL,$data3);				
			}
		}

		$location_id = $this->input->post('i_city');
		$arrlength_location = count($location_id);
		$this->g_mod->delete_data_table('discount_locations',$where3);
		if ($location_id) {
			for($x = 0; $x < $arrlength_location; $x++) {
				$data4['discount_id'] 	= $new_id;
				$data4['location_id'] 	= $location_id[$x];
				$this->g_mod->insert_data_table('discount_locations',NULL,$data4);				
			}
		}

		$customer_id = $this->input->post('i_customer');
		$arrlength_customer = count($customer_id);
		$this->g_mod->delete_data_table('discount_customers',$where3);
		if ($customer_id) {
			for($x = 0; $x < $arrlength_customer; $x++) {
				$data5['discount_id'] 	= $new_id;
				$data5['customer_id'] 	= $customer_id[$x];
				$this->g_mod->insert_data_table('discount_customers',NULL,$data5);				
			}
		}

		$category_id = $this->input->post('i_category');
		$arrlength_category = count($category_id);
		$this->g_mod->delete_data_table('discount_categories',$where3);
		if ($category_id) {
			for($x = 0; $x < $arrlength_category; $x++) {
				$data6['discount_id'] 	= $new_id;
				$data6['category_item_id'] 	= $category_id[$x];
				$this->g_mod->insert_data_table('discount_categories',NULL,$data6);				
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_detail(){
		$id = $this->input->post('i_detail_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'discount_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('discount_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}

			$new_id = $id;
		} else {
			//INSERT
			$data = $this->general_post_data_detail();
			$insert = $this->g_mod->insert_data_table('discount_details', NULL, $data);
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
			'column' => 'discount_id',
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

	public function delete_data_detail(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'discount_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('discount_details', $where);
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
		$date = $this->input->post('i_date', TRUE);
		$date = str_replace(' ', '', $date);
		$date = explode("-", $date);
		$date1 = $date[0];
		$date2 = $date[1];

		$type = $this->input->post('i_type', TRUE);
		if ($type == 1) {
			$period = 0;
		}else{
			$period = $this->input->post('i_periode', TRUE);
		}

		$data = array(
			'discount_name' 	=> $this->input->post('i_name', TRUE),
			'discount_type' 	=> $type,
			'discount_periode' 	=> $period,
			'discount_presentase' 	=> $this->input->post('i_discount', TRUE),
			'discount_date1' 	=> $this->format_date_day_mid($date1),
			'discount_date2' 	=> $this->format_date_day_mid($date2),
			//'discount_status' 	=> $this->input->post('i_status', TRUE),
			//'customer_id' 		=> $this->input->post('i_customer', TRUE),
			//'category_item_id' 	=> $this->input->post('i_category', TRUE),
			//'city_id' 			=> $this->input->post('i_city', TRUE)
			//'location_id' 			=> $this->input->post('i_city', TRUE)
			);

		return $data;
	}

	function general_post_data_detail(){
		$qty_diskon 	= $this->input->post('i_detail_qty_min_diskon', TRUE);
		$qty_item 		= $this->input->post('i_detail_qty_min_item', TRUE);
		$item 			= $this->input->post('i_item', TRUE);
		$type  			= $this->input->post('i_type', TRUE);
		$type_detail  	= $this->input->post('i_type_detail', TRUE);

		$total1  = $this->input->post('i_detail_diskon_item', TRUE);
		$total2  = $this->input->post('i_detail_diskon', TRUE);

		$type_detail = ($type_detail) ? ($type_detail) : 0;
		$min_order = ($qty_diskon) ? ($qty_diskon) : $qty_item;
		$item = ($item) ? ($item) : 0;
		$total = ($type == 0) ? ($total1) : $total2;
		$data = array(
			'discount_id' 				=> $this->input->post('i_id', TRUE),
			'discount_detail_total' 	=> $total,
			'discount_detail_qty' 		=> $min_order,
			'discount_detail_persen' 	=> $this->input->post('i_detail_qty_diskon', TRUE),
			'discount_detail_item' 		=> $this->input->post('i_detail_qty_item', TRUE),
			'item_data_id' 				=> $item,
			'discount_detail_type' 		=> $type_detail,
			'user_id' 					=> $this->user_id
			
			);

		return $data;
	}

	public function load_data_select_discount(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'discount_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'discount_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','discounts',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->discount_id,
					'text'	=> $val->discount_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_item_luar(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_discount_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'item_discount_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','item_discounts',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->item_discount_id,
					'text'	=> $val->item_discount_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
