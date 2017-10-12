<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Memo extends MY_Controller {
	private $any_error = array();
	public $tbl = 'memos';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,50);
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
			'title_page' 	=> 'Transaction / Sales Order',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('memo_v', $data);
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
		$tbl = 'memos a';
		$select = 'a.*,b.customer_name,b.customer_store,b.customer_purchase_pic';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'memo_code,customer_name,customer_purchase_pic',
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
				if ($val->memo_id>0) {
					
						$response['data'][] = array(
							$val->memo_code,
							$val->customer_store,
							$val->customer_purchase_pic,
							'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->memo_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->memo_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'memo_details a';
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
			'column' => 'a.memo_id',
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
				$sql = "SELECT SUM(stock_qty) as stock_qty FROM stocks a 
				JOIN item_details b ON b.item_detail_id = a.item_detail_id 
				JOIN items c ON c.item_id = b.item_id 
				WHERE a.item_detail_id = $val->item_detail_id and c.item_id = $val->item_id";
				$query = $this->g_mod->select_manual_for($sql);

					foreach ($query->result() as $val2) {
						$stock_qty= $val2->stock_qty;
					}
				if ($val->memo_detail_id>0) {
					$response['data'][] = array(
						$val->memo_detail_id,
						$val->item_name,
						$val->item_detail_color,
						$stock_qty,
						$val->memo_detail_qty_nota,
						$val->memo_detail_qty,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->memo_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->memo_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.sales_name,c.customer_name';
		$tbl = 'memos a';
		//JOIN
		$join['data'][] = array(
			'table' => 'saless b',
			'join'	=> 'b.sales_id=a.sales_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'customers c',
			'join'	=> 'c.customer_id=a.customer_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'memo_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'memo_id'			=> $val->memo_id,
					'memo_date' 		=> $this->format_date_day_mid2($val->memo_date),
					'sales_id' 			=> $val->sales_id,
					'sales_name' 		=> $val->sales_name,
					'customer_id' 		=> $val->customer_id,
					'customer_name' 	=> $val->customer_name,
					'memo_lock' 		=> $val->memo_lock,
					'memo_request' 		=> $val->memo_request
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_stock($id,$item){
		
		$sql = "SELECT SUM(stock_qty) as stock_qty FROM stocks a 
		JOIN item_details b ON b.item_detail_id = a.item_detail_id 
		JOIN items c ON c.item_id = b.item_id 
		WHERE a.item_detail_id = $id and c.item_id = $item";
		$query = $this->g_mod->select_manual_for($sql);

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'stock_qty'			=> $val->stock_qty,
				);
			}

			echo json_encode($response);
	}

	public function load_data_where_nota_qty($id,$item){
		
		$sql = "SELECT SUM(memo_detail_qty)-SUM(memo_detail_qty_nota) as total FROM memo_details a
		WHERE item_detail_id = $id and item_id = $item";
		$query = $this->g_mod->select_manual_for($sql);

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'total'			=> $val->total,
				);
			}

			echo json_encode($response);
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.item_name,c.item_detail_color';
		$tbl = 'memo_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'memo_detail_id',
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
				$sql = "SELECT SUM(stock_qty) as stock_qty FROM stocks a 
				JOIN item_details b ON b.item_detail_id = a.item_detail_id 
				JOIN items c ON c.item_id = b.item_id 
				WHERE a.item_detail_id = $val->item_detail_id and c.item_id = $val->item_id";
				$query = $this->g_mod->select_manual_for($sql);

					foreach ($query->result() as $val2) {
						$stock_qty= $val2->stock_qty;
					}
				$response['val'][] = array(
					'memo_detail_id'		=> $val->memo_detail_id,
					'memo_detail_qty' 		=> $val->memo_detail_qty,
					'item_id' 				=> $val->item_id,
					'item_name' 			=> $val->item_name,
					'item_detail_id' 		=> $val->item_detail_id,
					'item_detail_color' 	=> $val->item_detail_color,
					'stock_qty' 	=> $stock_qty,
					'memo_detail_qty_nota' 	=> $val->memo_detail_qty_nota,
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
				'column' => 'memo_id',
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
			//echo $data['memo_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['memo_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'memo_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('memo_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
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
				'column' => 'memo_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('memo_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail();
			//echo $data['memo_img'];
			$insert = $this->g_mod->insert_data_table('memo_details', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_lock(){
		$data['memo_lock'] = 1;

		$where['data'][] = array(
			'column' => 'memo_id',
			'param'	 => $this->input->post('i_id')
		);
		$update = $this->g_mod->update_data_table('memos', $where, $data);

		if($update->status) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function action_data_request(){
		$data['memo_request'] = 1;

		$where['data'][] = array(
			'column' => 'memo_id',
			'param'	 => $this->input->post('i_id')
		);
		$update = $this->g_mod->update_data_table('memos', $where, $data);

		if($update->status) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'memo_id',
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
			'column' => 'memo_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('memo_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_memo(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(memo_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(memo_code,1,8)',
			'param'	 => 'ME'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'memo_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('ME',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		/*$data = array(
			'customer_id' 	=> $this->input->post('i_customer', TRUE),
			'sales_id' 		=> $this->input->post('i_sales', TRUE),
			'memo_date' 	=> $this->format_date_day_mid($this->input->post('i_date', TRUE))
			);*/
		if (!$id) {
			$data['memo_code'] 		= $this->get_code_memo();
		}

		$data['customer_id'] 	= $this->input->post('i_customer', TRUE);
		$data['sales_id'] 		= $this->input->post('i_sales', TRUE);
		$data['memo_date'] 		= $this->format_date_day_mid($this->input->post('i_date', TRUE));
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'memo_id' 				=> $this->input->post('i_id', TRUE),
			'item_id' 				=> $this->input->post('i_item', TRUE),
			'item_detail_id' 		=> $this->input->post('i_item_detail', TRUE),
			'memo_detail_qty' 		=> $this->input->post('i_detail_qty', TRUE),
			'memo_detail_qty_nota' 		=> $this->input->post('i_nota_qty', TRUE),
			'user_id' 				=> $this->user_id
			);
			

		return $data;
	}

	public function load_data_select_memo($customer_id = 0,$sales_id = 0){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'memo_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'memo_code',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'memo_status',
			'param'	 => 0
		);

		if ($customer_id) {
			//WHERE
			$where['data'][] = array(
				'column' => 'customer_id',
				'param'	 => $customer_id
			);
		}

		if ($sales_id) {
			//WHERE
			$where['data'][] = array(
				'column' => 'sales_id',
				'param'	 => $sales_id
			);
		}

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->memo_id,
					'text'	=> $val->memo_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	/* end Function */

}
