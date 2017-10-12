<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nota extends MY_Controller {
	private $any_error = array();
	public $tbl = 'notas';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();
        $this->load->library('PdfGenerator');

        $akses = $this->g_mod->get_user_acces($this->user_id,52);
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
			'title_page' 	=> 'Transaction / Nota',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('nota_v', $data);
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
		$tbl = 'notas a';
		$select = 'a.*,b.customer_name,b.customer_store,c.sales_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_code,customer_name,sales_name',
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
			'table' => 'customers b',
			'join'	=> 'b.customer_id=a.customer_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'saless c',
			'join'	=> 'c.sales_id=a.sales_id',
			'type'	=> 'inner'
		);


		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->nota_id>0) {
					$response['data'][] = array(
						$val->nota_code,
						$val->customer_name.'-'.$val->customer_store,
						$val->sales_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->nota_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->nota_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_detail($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'nota_details a';
		$select = 'a.*,b.item_name,c.item_detail_color';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_detail_color',
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
			'column' => 'a.nota_id',
			'param'	 => $id
		);

		if (!$id) {
			//WHERE
			$where['data'][] = array(
				'column' => 'a.user_id',
				'param'	 => $this->user_id
			);
		}

		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details c',
			'join'	=> 'c.item_detail_id=a.item_detail_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->nota_detail_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->item_detail_color,	
						number_format($val->nota_detail_price),
						$val->nota_detail_qty,
						$val->nota_detail_discount,
						number_format($val->nota_detail_price * $val->nota_detail_qty),
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->nota_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->nota_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.customer_name,c.sales_name';
		$tbl = 'notas a';
		//JOIN
		$join['data'][] = array(
			'table' => 'customers b',
			'join'	=> 'b.customer_id=a.customer_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'saless c',
			'join'	=> 'c.sales_id=a.sales_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'nota_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$select2 = 'a.*,b.memo_code';
				$tbl2 = 'nota_memos a';
				//WHERE
				$where2['data'][] = array(
					'column' => 'nota_id',
					'param'	 => $this->input->get('id')
				);
				//JOIN
				$join2['data'][] = array(
					'table' => 'memos b',
					'join'	=> 'b.memo_id=a.memo_id',
					'type'	=> 'inner'
				);
				$query_memo = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,$join2,$where2);
				if ($query_memo<>false) {
					foreach ($query_memo->result() as $val2) {
						$memo['val2'][] = array(
							'id' 	=> $val2->memo_id,
							'text' 	=> $val2->memo_code
						);
					}
				}else{
					$memo['val2'][] = array(
						'id' 	=> '',
						'text' 	=> ''
					);
				}

				$response['val'][] = array(
					'nota_id'			=> $val->nota_id,
					'nota_date' 		=> $this->format_date_day_mid2($val->nota_date),
					'customer_id' 		=> $val->customer_id,
					'customer_name' 	=> $val->customer_name,
					'sales_id' 			=> $val->sales_id,
					'sales_name' 		=> $val->sales_name,
					'nota_print' 		=> $val->nota_print,
					'nota_sj' 			=> $val->nota_sj,
					'nota_discount' 	=> $val->nota_discount,
					'memos'				=> $memo
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.item_name,c.item_detail_color';
		$tbl = 'nota_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_detail_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'item_details c',
			'join'	=> 'c.item_detail_id=a.item_detail_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'nota_detail_id'		=> $val->nota_detail_id,
					'nota_detail_qty' 		=> $val->nota_detail_qty,
					'nota_detail_price' 	=> $val->nota_detail_price,
					'nota_detail_discount' 	=> $val->nota_detail_discount,
					'item_id' 				=> $val->item_id,
					'item_name' 			=> $val->item_name,
					'item_detail_id' 		=> $val->item_detail_id,
					'item_detail_color' 	=> $val->item_detail_color,
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
				'column' => 'nota_id',
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
			
			$data = $this->general_post_data($id);
			//echo $data['nota_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['nota_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'nota_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('nota_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id'] = $insert->output;
			} else {
				$response['status'] = '204';
			}

			$new_id = $insert->output;
		}

		$memo_id = $this->input->post('i_memo');
		$arrlength_memo = count($memo_id);

		if ($memo_id) {
			//WHERE
			$where3['data'][] = array(
				'column' => 'nota_id',
				'param'	 => $new_id
			);
			$this->g_mod->delete_data_table('nota_memos',$where3);
			for($x = 0; $x < $arrlength_memo; $x++) {
				$data3['nota_id'] 	= $new_id;
				$data3['memo_id'] 	= $memo_id[$x];
				$this->g_mod->insert_data_table('nota_memos',NULL,$data3);

				$select2 = 'a.*';
				$tbl2 = 'memo_details a';
				//WHERE
				$where4 = "memo_id = $memo_id[$x]";
				$data5['memo_status'] = 1;
				$update = $this->g_mod->update_data_table('memos', NULL, $data5,$where4);

				$query_memo = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,NULL,$where4);
				foreach ($query_memo->result() as $val2) {
					$data4['nota_id'] 				= $new_id;
					$data4['item_id'] 				= $val2->item_id;
					$data4['item_detail_id'] 		= $val2->item_detail_id;
					$data4['nota_detail_qty'] 		= $val2->memo_detail_qty;
					$data4['nota_detail_price'] 	= $this->get_price($val2->item_id);
					$data4['user_id'] 				= $this->user_id;

					$this->g_mod->insert_data_table('nota_details', NULL, $data4);

					$where5 = 'and warehouse_id = 1 and package_id = 0';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$data4['nota_detail_qty'],$data4['item_detail_id'],$where5);
				}
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_detail(){
		$id = $this->input->post('i_detail_id');

		$data = $this->general_post_data_detail();

		if (strlen($id)>0) {
			//UPDATE
			
			$detail = $this->g_mod->read_data('*','nota_details','nota_detail_id',$id);
			$qty = $data['nota_detail_qty'] - $detail['nota_detail_qty'];

			$where5 = 'and warehouse_id = 1 and package_id = 0';
			$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$qty,$data['item_detail_id'],$where5);
			
			//WHERE
			$where['data'][] = array(
				'column' => 'nota_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('nota_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT

			$nota_id = $data['nota_id'];
			$item_detail_id = $data['item_detail_id'];

			$sql = "select * from nota_details where nota_id = $nota_id and item_detail_id = $item_detail_id";
			$result = $this->g_mod->select_manual($sql);
			if (!$result) {
				$insert = $this->g_mod->insert_data_table('nota_details', NULL, $data);
				$detail_id = $insert->output;
			}else{

				$this->g_mod->update_data_stock('nota_details','nota_detail_qty','item_detail_id',-($data['nota_detail_qty']),$result['item_detail_id']);
				$detail_id = $result['item_detail_id'];
			}

			$where5 = 'and warehouse_id = 1 and package_id = 0';
			$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$data['nota_detail_qty'],$data['item_detail_id'],$where5);

			$response['status'] = '200';
			$response['alert'] = '1';
		}

		/*$date 			= $this->format_date_day_mid($this->input->post('i_date', TRUE));
		$customer_id 	= $this->input->post('i_customer', TRUE);
		$customer 		= $this->g_mod->select_manual("select * from customers where customer_id = $customer_id");
		$location_id 	= $customer['location_id'];
		$item_id 		= $data['item_id'];
		$item 			= $this->g_mod->select_manual("select * from items where item_id = $item_id");
		$category_id 	= $item['category_item_id'];
		$total_detail 	= $data['nota_detail_qty'] * $data['nota_detail_price'];

		$sql = "select a.* from discounts a 
				where '$date' >= a.discount_date1 and '$date' <= a.discount_date2 and discount_periode = 0";
		$query = $this->g_mod->select_manual_for($sql);
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$sql_customer 			= "select a.* from discount_customers a 
								   			where discount_id = $val->discount_id and customer_id = $customer_id";
				$sql_location 			= "select a.* from discount_locations a 
								   			where discount_id = $val->discount_id and location_id = $location_id";
				$sql_item 				= "select a.* from discount_items a 
						 		  		 	where discount_id = $val->discount_id and item_id = $item_id";
				$sql_category 			= "select a.* from discount_categories a 
								   			where discount_id = $val->discount_id and category_item_id = $category_id";
				$sql_discount_detail 	= "select a.* from discount_details a 
								   			where a.discount_id = $val->discount_id
								   			order by a.discount_detail_id DESC";

				$query_customer 		= $this->g_mod->select_manual_for($sql_customer);
				$query_location 		= $this->g_mod->select_manual_for($sql_location);
				$query_item				= $this->g_mod->select_manual_for($sql_item);
				$query_category 		= $this->g_mod->select_manual_for($sql_category);
				$query_discount_detail 	= $this->g_mod->select_manual_for($sql_discount_detail);

				$discount_detail_id = 0;
				$discount_detail_persen = 0;
				if ($query_discount_detail<>false) {
					foreach ($query_discount_detail->result() as $val2) {
						if ($val2->discount_detail_qty <= $data['nota_detail_qty'] || $val2->discount_detail_total <= $total_detail) {
							if ($discount_detail_id == 0) {
								$discount_detail_id 		= $val2->discount_detail_id;
								$discount_detail_persen 	= $val2->discount_detail_persen;
							}
						}
					}
				}
				
				$data_discount = array(
					'nota_id' => $data['nota_id'],
					'nota_detail_id' => $detail_id,
					'discount_detail_id' => $discount_detail_id,
					'discount_detail_value' => $total_detail * $discount_detail_persen / 100
				);

				if ($discount_detail_id != 0) {
					if ($query_location<>false) {
						$this->g_mod->insert_data_table('nota_discounts', NULL, $data_discount);
					}elseif ($query_customer<>false) {
						$this->g_mod->insert_data_table('nota_discounts', NULL, $data_discount);
					}elseif ($query_category<>false) {
						$this->g_mod->insert_data_table('nota_discounts', NULL, $data_discount);
					}elseif ($query_item<>false) {
						$this->g_mod->insert_data_table('nota_discounts', NULL, $data_discount);
					}elseif ($query_location == false && $query_customer == false && $query_category == false && $query_item == false) {
						$this->g_mod->insert_data_table('nota_discounts', NULL, $data_discount);
					}

					$response['discount'] = 'dapat';
				}

			}
		}*/
		
		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_id',
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
			'column' => 'nota_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('nota_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_nota(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(nota_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(nota_code,1,8)',
			'param'	 => 'NT'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'nota_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('NT',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		/*$data = array(
			'customer_id' 	=> $this->input->post('i_customer', TRUE),
			'sales_id' 		=> $this->input->post('i_sales', TRUE),
			'nota_date' 	=> $this->format_date_day_mid($this->input->post('i_date', TRUE))
			);*/
		if (!$id) {
			$data['nota_code'] 		= $this->get_code_nota();
		}

		$data['customer_id'] 	= $this->input->post('i_customer', TRUE);
		$data['sales_id'] 		= $this->input->post('i_sales', TRUE);
		$data['nota_date'] 		= $this->format_date_day_mid($this->input->post('i_date', TRUE));
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'nota_id' 				=> $this->input->post('i_id', TRUE),
			'item_id' 				=> $this->input->post('i_item', TRUE),
			'item_detail_id' 		=> $this->input->post('i_item_detail', TRUE),
			'nota_detail_qty' 		=> $this->input->post('i_detail_qty', TRUE),
			'nota_detail_price' 	=> $this->input->post('i_detail_price', TRUE),
			'nota_detail_discount' 	=> $this->input->post('i_detail_discount', TRUE),
			'user_id' 				=> $this->user_id
			);
			

		return $data;
	}
	
	public function load_data_select_nota($id = 0){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'nota_code',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'nota_status',
			'param'	 => 0
		);
		if ($id) {
			$where['data'][] = array(
				'column' => 'customer_id',
				'param'	 => $id
			);
		}

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->nota_id,
					'text'	=> $val->nota_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_nota_detail($id = 0){

		$select = 'a.*,b.item_name,c.item_detail_color';
		$tbl = 'nota_details a';
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_detail_color',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'item_name',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'nota_id',
			'param'	 => $id
		);
		
		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details c',
			'join'	=> 'c.item_detail_id=a.item_detail_id',
			'type'	=> 'inner'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->nota_detail_id,
					'text'	=> $val->item_name.'-'.$val->item_detail_color
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function get_price($item_new_id = 0){

		$customer_id 		= $this->input->post('i_customer');
		$date_nota 			= $this->format_date_day_mid($this->input->post('i_date', TRUE));

		if ($item_new_id) {
			$item_id 			= $item_new_id;
		}else{
			$item_id 			= $this->input->post('i_item');
		}
		

		$customer = $this->g_mod->read_data('*','customers','customer_id',$customer_id);
		$item = $this->g_mod->read_data('*','items','item_id',$item_id);

		if ($customer['customer_type_sub_id'] == 0) {
			$harga_sub = $item['item_price1'];
		}elseif($customer['customer_type_sub_id'] == 1){
			$harga_sub = $item['item_netto'];
		}elseif($customer['customer_type_sub_id'] == 2){
			$harga_sub = $item['item_price1'];
		}elseif($customer['customer_type_sub_id'] == 3){
			$harga_sub = $item['item_price2'];
		}

		if ($customer['customer_type_id'] == 0) {
			$harga = $item['item_price1'];
		}elseif($customer['customer_type_id'] == 1){
			$harga = $item['item_netto'];
		}elseif($customer['customer_type_id'] == 2){
			$harga = $item['item_price1'];
		}elseif($customer['customer_type_id'] == 3){
			$harga = $item['item_price2'];
		}elseif($customer['customer_type_id'] == 4){
			
			//cek promo 1
		    $Date1=date('Y-m-d', strtotime($date_nota));;
		    $DateBegin1 = date('Y-m-d', strtotime($customer['promo1_date1']));
		    $DateEnd1 = date('Y-m-d', strtotime($customer['promo1_date2']));

		    if (($Date1 > $DateBegin1) && ($Date1 < $DateEnd1)){
		      
			    $customer_price = $this->g_mod->read_data('*','customer_prices','customer_id',$customer_id,'item_id',$item_id);
			    if ($customer_price) {
			      $harga = $customer_price['customer_price_promo1'];
			    }else{
			      $harga = $harga_sub;
			    }

		    }else{
		      	//cek promo 2
			    $Date2=date('Y-m-d', strtotime($date_nota));;
			    $DateBegin2 = date('Y-m-d', strtotime($customer['promo2_date1']));
			    $DateEnd2 = date('Y-m-d', strtotime($customer['promo2_date2']));

			    if (($Date2 > $DateBegin2) && ($Date2 < $DateEnd2)){
			      
				    $customer_price = $this->g_mod->read_data('*','customer_prices','customer_id',$customer_id,'item_id',$item_id);
				    if ($customer_price) {
				      $harga = $customer_price['customer_price_promo2'];
				    }else{
				      $harga = $harga_sub;
				    }

			    }else{
			      	$customer_price = $this->g_mod->read_data('*','customer_prices','customer_id',$customer_id,'item_id',$item_id);
				    if ($customer_price) {
				      $harga = $customer_price['customer_price_value'];
				    }else{
				      $harga = $harga_sub;
				    }
			    }
		    }


		}

		if ($item_new_id) {
			return $harga;
		}else{
			echo json_encode($harga);
		}
		
	}

	public function get_grand_total(){

		$id = $this->input->get('id');

		$select = 'a.*';
		$tbl = 'nota_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_id',
			'param'	 => $this->input->get('id')
		);
		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		$total = 0;
		$discounts = 0;
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$total 		+= $val->nota_detail_qty * $val->nota_detail_price;
				$discounts 	+= $val->nota_detail_qty * $val->nota_detail_price * $val->nota_detail_discount / 100;
			}
		}

		$sql ="SELECT a.* FROM notas a 
			   WHERE nota_id = $id";
		$result = $this->g_mod->select_manual($sql);

		$response['total_format'] 	= number_format($total);
		$response['diskon_format'] 	= number_format($discounts);
		$response['total'] 			= $total;
		$response['discounts'] 		= $discounts;
		$response['discount_global'] 		= $result['nota_discount'];

		echo json_encode($response);
	}

	public function get_discount(/*$id*/){
		
		$tbl = 'nota_discounts a';
		$select = 'a.*,c.discount_name';
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_id',
			'param'	 => $this->input->get('id')
			//'param'	 => $id
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'discount_details b',
			'join'	=> 'b.discount_detail_id=a.discount_detail_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'discounts c',
			'join'	=> 'c.discount_id=b.discount_id',
			'type'	=> 'inner'
		);

		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$response['data'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'discount_detail_value_format'		=> number_format($val->discount_detail_value),
					'discount_detail_value'		=> $val->discount_detail_value,
					'discount_name' 		=> $val->discount_name,
				);
			}

			echo json_encode($response);
		}
		//$this->load->view('nota_d', array('query' => $query));
	}

	function print_nota_pdf(){

		$id = $this->input->get('id');

		//WHERE
		$where['data'][] = array(
			'column' => 'nota_id',
			'param'	 => $id
		);
		$data['nota_print'] = 1;
		$update = $this->g_mod->update_data_table('notas', $where, $data);


		$sql ="SELECT a.*,b.customer_name,c.sales_name FROM notas a 
			   JOIN customers b ON b.customer_id = a.customer_id
			   JOIN saless c ON c.sales_id = a.sales_id
			   WHERE nota_id = $id";

		
		$query = $this->g_mod->select_manual_for($sql);
		foreach ($query->result() as $row){ 
				$judul			= "NOTA PENJUALAN";
				$data = array(
					'nota_id' 		=> $row->nota_id,
					'nota_code' 		=> $row->nota_code,
					'customer_name' 				=> $row->customer_name,
					'sales_name' 				=> $row->sales_name,
					'nota_date' 				=> $row->nota_date,
					);
					
		}
		$data['title'] 	= $judul;

	    $html = $this->load->view('report/nota_report', $data, true);//SEND DATA TO VIEW
	    $paper = 'A4';
    	$orientation = 'portrait';
	    
	    $this->pdfgenerator->generate($html, str_replace(" ","_",$judul), $paper, $orientation);
	}

	function print_surat_jalan_pdf(){

		$id = $this->input->get('id');

		//WHERE
		$where['data'][] = array(
			'column' => 'nota_id',
			'param'	 => $id
		);
		$data['nota_sj'] = 1;
		$update = $this->g_mod->update_data_table('notas', $where, $data);

		$sql ="SELECT a.*,b.customer_name,c.sales_name FROM notas a 
			   JOIN customers b ON b.customer_id = a.customer_id
			   JOIN saless c ON c.sales_id = a.sales_id
			   WHERE nota_id = $id";

		
		$query = $this->g_mod->select_manual_for($sql);
		foreach ($query->result() as $row){ 
				$judul			= "SURAT JALAN";
				$data = array(
					'nota_id' 		=> $row->nota_id,
					'nota_code' 		=> $row->nota_code,
					'customer_name' 				=> $row->customer_name,
					'sales_name' 				=> $row->sales_name,
					'nota_date' 				=> $row->nota_date,
					);
					
		}
		$data['title'] 	= $judul;

	    $html = $this->load->view('report/report_sj', $data, true);//SEND DATA TO VIEW
	    $paper = 'A4';
    	$orientation = 'portraitid';
	    
	    $this->pdfgenerator->generate($html, str_replace(" ","_",$judul), $paper, $orientation);
	}

	function update_discount(){
		$id = $this->input->post('id');
		$value = $this->input->post('value');
			//UPDATE
		$data['nota_discount'] = $value;
			
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_id',
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
		
		echo json_encode($response);
	}

	/* end Function */

}
