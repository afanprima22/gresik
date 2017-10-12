<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class nota_retail extends MY_Controller {
	private $any_error = array();
	public $tbl = 'nota_retails';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

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
			'title_page' 	=> 'Transaction / Nota / Nota Ecerean',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('nota_retail_v', $data);
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
		$tbl = 'nota_retails a';
		$select = 'a.*,b.customer_name,b.customer_store';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_retail_code,customer_name',
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


		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->nota_retail_id>0) {
					$response['data'][] = array(
						$val->nota_retail_code,
						$val->customer_name.'-'.$val->customer_store,
						$val->nota_retail_discount,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->nota_retail_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->nota_retail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'nota_retail_details a';
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
			'column' => 'a.nota_retail_id',
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
				if ($val->nota_retail_detail_id>0) {
					$response['data'][] = array(
						$val->nota_retail_detail_id,
						$val->item_name,
						$val->item_detail_color,
						number_format($val->nota_retail_detail_price),
						$val->nota_retail_detail_qty,
						$val->nota_retail_detail_discount,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->nota_retail_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->nota_retail_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.customer_name,b.customer_hp,b.customer_address';
		$tbl = 'nota_retails a';
		//JOIN
		$join['data'][] = array(
			'table' => 'customers b',
			'join'	=> 'b.customer_id=a.customer_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'nota_retail_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$response['val'][] = array(
					'nota_retail_id'		=> $val->nota_retail_id,
					'nota_retail_date' 		=> $this->format_date_day_mid2($val->nota_retail_date),
					'customer_id' 			=> $val->customer_id,
					'customer_name' 		=> $val->customer_name,
					'customer_hp' 			=> $val->customer_hp,
					'customer_address' 		=> $val->customer_address,
					'nota_retail_discount' 	=> $val->nota_retail_discount
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.item_name,c.item_detail_color';
		$tbl = 'nota_retail_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_retail_detail_id',
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
					'nota_retail_detail_id'		=> $val->nota_retail_detail_id,
					'nota_retail_detail_qty' 		=> $val->nota_retail_detail_qty,
					'nota_retail_detail_price' 		=> $val->nota_retail_detail_price,
					'nota_retail_detail_discount' 		=> $val->nota_retail_detail_discount,
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
				'column' => 'nota_retail_id',
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
			//echo $data['nota_retail_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['nota_retail_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'nota_retail_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('nota_retail_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id'] = $insert->output;
			} else {
				$response['status'] = '204';
			}

			$new_id = $insert->output;
		}

		/*$memo_id = $this->input->post('i_memo');
		$arrlength_memo = count($memo_id);

		if ($memo_id) {
			//WHERE
			$where3['data'][] = array(
				'column' => 'nota_retail_id',
				'param'	 => $new_id
			);
			$this->g_mod->delete_data_table('nota_retail_memos',$where3);
			for($x = 0; $x < $arrlength_memo; $x++) {
				$data3['nota_retail_id'] 	= $new_id;
				$data3['memo_id'] 	= $memo_id[$x];
				$this->g_mod->insert_data_table('nota_retail_memos',NULL,$data3);

				$select2 = 'a.*';
				$tbl2 = 'memo_details a';
				//WHERE
				$where4['data'][] = array(
					'column' => 'memo_id',
					'param'	 => $memo_id[$x]
				);
				$data5['memo_status'] = 1;
				$update = $this->g_mod->update_data_table('memos', $where4, $data5);

				$query_memo = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,NULL,$where4);
				foreach ($query_memo->result() as $val2) {
					$data4['nota_retail_id'] 			= $new_id;
					$data4['item_id'] 			= $val2->item_id;
					$data4['item_detail_id'] 	= $val2->item_detail_id;
					$data4['nota_retail_detail_qty'] 	= $val2->memo_detail_qty;
					$data4['user_id'] 			= $this->user_id;

					$this->g_mod->insert_data_table('nota_retail_details', NULL, $data4);

					$where5 = 'and warehouse_id = 1 and package_id = 0';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$data4['nota_retail_detail_qty'],$data4['item_detail_id'],$where5);
				}
			}
		}*/
		
		echo json_encode($response);
	}

	public function action_data_detail(){
		$id = $this->input->post('i_detail_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail();

			$detail = $this->g_mod->read_data('*','nota_retail_details','nota_retail_detail_id',$id);
			$qty = $data['nota_retail_detail_qty'] - $detail['nota_retail_detail_qty'];

			$where5 = 'and warehouse_id = 1 and package_id = 2';
			$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$qty,$data['item_detail_id'],$where5);
			
			//WHERE
			$where['data'][] = array(
				'column' => 'nota_retail_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('nota_retail_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail();
			//echo $data['nota_retail_img'];
			$insert = $this->g_mod->insert_data_table('nota_retail_details', NULL, $data);

			$where5 = 'and warehouse_id = 1 and package_id = 2';
			$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$data['nota_retail_detail_qty'],$data['item_detail_id'],$where5);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_customer(){
		
			//INSERT
			$data = $this->general_post_data_customer();
			//echo $data['nota_retail_img'];
			$insert = $this->g_mod->insert_data_table('customers', NULL, $data);

			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		
		
		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_retail_id',
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
			'column' => 'nota_retail_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('nota_retail_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_nota_retail(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(nota_retail_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(nota_retail_code,1,8)',
			'param'	 => 'NR'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'nota_retail_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('NR',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		/*$data = array(
			'customer_id' 	=> $this->input->post('i_customer', TRUE),
			'sales_id' 		=> $this->input->post('i_sales', TRUE),
			'nota_retail_date' 	=> $this->format_date_day_mid($this->input->post('i_date', TRUE))
			);*/
		if (!$id) {
			$data['nota_retail_code'] 		= $this->get_code_nota_retail();
		}

		$data['customer_id'] 				= $this->input->post('i_customer', TRUE);
		//$data['sales_id'] 		= $this->input->post('i_sales', TRUE);
		$data['nota_retail_discount'] 		= $this->input->post('i_discount_total', TRUE);
		$data['nota_retail_date'] 			= $this->format_date_day_mid($this->input->post('i_date', TRUE));
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'nota_retail_id' 				=> $this->input->post('i_id', TRUE),
			'item_id' 						=> $this->input->post('i_item', TRUE),
			'item_detail_id' 				=> $this->input->post('i_item_detail', TRUE),
			'nota_retail_detail_qty' 		=> $this->input->post('i_detail_qty', TRUE),
			'nota_retail_detail_price' 		=> $this->input->post('i_detail_price', TRUE),
			'nota_retail_detail_discount' 	=> $this->input->post('i_detail_discount', TRUE),
			'user_id' 						=> $this->user_id
			);
			

		return $data;
	}

	function general_post_data_customer(){

		$data = array(
			'customer_name' 				=> $this->input->post('i_name', TRUE),
			'customer_address' 				=> $this->input->post('i_addres', TRUE),
			'customer_store' 				=> $this->input->post('i_store', TRUE),
			'customer_store_address' 		=> $this->input->post('i_store_addres', TRUE),
			'customer_telp' 				=> $this->input->post('i_telp', TRUE)
			);
			

		return $data;
	}

	public function load_data_select_type(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_retail_type_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'nota_retail_type_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','nota_retail_types',NULL,$where_like,$order,NULL,NULL);
		$response['nota_retails'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['nota_retails'][] = array(
					'id'	=> $val->nota_retail_type_id,
					'text'	=> $val->nota_retail_type_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_nota_retail(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_retail_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'nota_retail_name',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'nota_retail_status',
			'param'	 => 1
		);
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where);
		$response['nota_retails'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['nota_retails'][] = array(
					'id'	=> $val->nota_retail_id,
					'text'	=> $val->nota_retail_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_nota_retail_detail($id){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_retail_detail_color',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'nota_retail_detail_color',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'nota_retail_id',
			'param'	 => $id
		);
		$query = $this->g_mod->select('*','nota_retail_details',NULL,$where_like,$order,NULL,$where);
		$response['nota_retails'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['nota_retails'][] = array(
					'id'	=> $val->nota_retail_detail_id,
					'text'	=> $val->nota_retail_detail_color
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function get_total_discount($id){	

		$tbl = 'nota_retail_details a';
		$select = 'a.*,b.item_name,c.item_detail_color';	
		//WHERE
		$where['data'][] = array(
			'column' => 'a.nota_retail_id',
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

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);

		$response = 0;
		if ($query<>false) {
			$total_discount = 0;
			foreach ($query->result() as $val) {
				$total_price = $val->nota_retail_detail_qty * $val->nota_retail_detail_price;
				$discount = $total_price * $val->nota_retail_detail_discount / 100;

				$total_discount+=$discount;
			}

			$response = $total_discount;
		}

		echo json_encode($response);
	}
	/* end Function */

}
