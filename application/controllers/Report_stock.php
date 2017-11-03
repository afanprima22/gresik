<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_stock extends MY_Controller {
	private $any_error = array();
	public $tbl = 'report_stocks';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,81);
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
			'title_page' 	=> 'Laporan / Stock',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('report_stock_v', $data);
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
		$tbl = 'report_stocks a';
		$select = 'a.*,b.warehouse_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'b.warehouse_name,report_stock_date',
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
			'table' => 'warehouses b',
			'join'	=> 'b.warehouse_id=a.warehouse_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				$type = $val->report_stock_type;
				if ($type == 1) {
					$types = "Stock Per Gudang";
				}else if($type == 2){
					$types = "Stock Packaging";
				}else if($type == 3){
					$types = "Stock Eceran";
				}
				if ($val->report_stock_id>0) {
					$response['data'][] = array(
						$val->report_stock_date,
						$types,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->report_stock_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->report_stock_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'report_stock_details a';
		$select = 'a.*,c.item_name,b.item_detail_color';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'c.item_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][] = array(
			'table' => 'item_details b',
			'join'	=> 'b.item_detail_id = a.item_detail_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id = b.item_id',
			'type'	=> 'inner'
		);
		
		//WHERE
		$where['data'][] = array(
			'column' => 'a.report_stock_id',
			'param'	 => $id
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->report_stock_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->item_detail_color,
						$val->report_stock_detail_qty_stock,
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

	public function load_data_stock($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'stocks a';
		$select = 'a.*,c.item_name,b.item_detail_color';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'c.item_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][] = array(
			'table' => 'item_details b',
			'join'	=> 'b.item_detail_id = a.item_detail_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id = b.item_id',
			'type'	=> 'inner'
		);
		
		//WHERE
		$where['data'][] = array(
			'column' => 'a.warehouse_id',
			'param'	 => $id
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->stock_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->item_detail_color,
						$val->stock_qty,
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

	public function load_data_stock_packaging(){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'heaps a';
		$select = 'a.*,c.item_name,b.item_detail_color';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'c.item_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][] = array(
			'table' => 'item_details b',
			'join'	=> 'b.item_detail_id = a.item_detail_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id = b.item_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->heap_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->item_detail_color,
						$val->heap_hasil,
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
		$select = 'a.*,b.warehouse_name';
		$tbl = 'report_stocks a';
		//JOIN
		$join['data'][] = array(
			'table' => 'warehouses b',
			'join'	=> 'b.warehouse_id=a.warehouse_id',
			'type'	=> 'left'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'report_stock_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'report_stock_id'				=> $val->report_stock_id,
					'report_stock_date' 				=> $this->format_date_day_mid2($val->report_stock_date),
					'warehouse_id' 			=> $val->warehouse_id,
					'warehouse_name' 		=> $val->warehouse_name,
					'report_stock_type' 					=> $val->report_stock_type,
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
				'column' => 'report_stock_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);

			$delete = $this->g_mod->delete_data_table('report_stock_details',$where);
			$this->general_post_data_detail($id);

			/*$data2['report_stock_id'] = $id;
			//WHERE
			$where2['data'][] = array(
				'column' => 'report_stock_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('report_stock_details', $where2, $data2);*/

			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data();
			//echo $data['kongsi_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			$this->general_post_data_detail($id);
			$data2['report_stock_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'report_stock_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('report_stock_details', $where2, $data2);
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
			'column' => 'report_stock_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl, $where);
		$delete2 = $this->g_mod->delete_data_table('report_stock_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	

	function general_post_data(){
		if ($this->input->post('i_type')==1) {
			$data = array(
				'warehouse_id' 					=> $this->input->post('i_warehouse', TRUE),
				'report_stock_type' 					=> $this->input->post('i_type', TRUE),
				'report_stock_date' 		=> $this->format_date_day_mid($this->input->post('i_branch', TRUE)),
			);
		return $data;
		}else if ($this->input->post('i_type')==3){
			$data = array(
				'warehouse_id' 					=> $this->input->post('i_warehouse2', TRUE),
				'report_stock_type' 					=> $this->input->post('i_type', TRUE),
				'report_stock_date' 		=> $this->format_date_day_mid($this->input->post('i_branch', TRUE)),
			);
			return $data;
		}else{
			$data = array(
			'report_stock_type' 					=> $this->input->post('i_type', TRUE),
			'report_stock_date' 		=> $this->format_date_day_mid($this->input->post('i_branch', TRUE)),
		);
		return $data;
		}
			
		
	}


	function general_post_data_detail($id){
		if (!$id) {
			if ($this->input->post('i_type', TRUE)==1) {
			$id = $this->input->post('i_warehouse', TRUE);
			
			$sql ="SELECT * FROM stocks a 
			   join item_details b on b.item_detail_id = a.item_detail_id
			   WHERE warehouse_id = $id";
			$query = $this->g_mod->select_manual_for($sql);
			if($query){
				foreach ($query->result() as $val){

					$data = array(
						'item_detail_id' 				=> $val->item_detail_id,
						'report_stock_detail_qty_stock' => $val->stock_qty,
						'user_id' 						=> $this->user_id,
						);
						

					$insert = $this->g_mod->insert_data_table('report_stock_details', NULL, $data);
				}
			}
			
		}else if ($this->input->post('i_type', TRUE)==2){
			$sql ="SELECT * FROM heaps a 
			   	   join item_details b on b.item_detail_id = a.item_detail_id";
			$query = $this->g_mod->select_manual_for($sql);
			if ($query) {
				foreach ($query->result() as $val){

					$data = array(
						'item_detail_id' 				=> $val->item_detail_id,
						'report_stock_detail_qty_stock' => $val->heap_hasil,
						'user_id' 						=> $this->user_id,
					);	

					$insert = $this->g_mod->insert_data_table('report_stock_details', NULL, $data);
				}
			}
			
		}else if ($this->input->post('i_type', TRUE)==3){
			$id = $this->input->post('i_warehouse2', TRUE);
			
			$sql ="SELECT * FROM stocks a 
			   join item_details b on b.item_detail_id = a.item_detail_id
			   WHERE warehouse_id = $id";
			$query = $this->g_mod->select_manual_for($sql);
			if($query){
				foreach ($query->result() as $val){

					$data = array(
						'item_detail_id' 				=> $val->item_detail_id,
						'report_stock_detail_qty_stock' => $val->stock_qty,
						'user_id' 						=> $this->user_id,
						);
						

					$insert = $this->g_mod->insert_data_table('report_stock_details', NULL, $data);
				}
			}
		}
		}else{
			if ($this->input->post('i_type', TRUE)==1) {
			$id = $this->input->post('i_warehouse', TRUE);
			
			$sql ="SELECT * FROM stocks a 
			   join item_details b on b.item_detail_id = a.item_detail_id
			   WHERE warehouse_id = $id";
			$query = $this->g_mod->select_manual_for($sql);
			if($query){
				foreach ($query->result() as $val){

					$data = array(
						'item_detail_id' 				=> $val->item_detail_id,
						'report_stock_detail_qty_stock' => $val->stock_qty,
						'user_id' 						=> $this->user_id,
						'report_stock_id'				=>$id
						);
						

					$insert = $this->g_mod->insert_data_table('report_stock_details', NULL, $data);
				}
			}
			
		}else if ($this->input->post('i_type', TRUE)==2){
			$sql ="SELECT * FROM heaps a 
			   	   join item_details b on b.item_detail_id = a.item_detail_id";
			$query = $this->g_mod->select_manual_for($sql);
			if ($query) {
				foreach ($query->result() as $val){

					$data = array(
						'item_detail_id' 				=> $val->item_detail_id,
						'report_stock_detail_qty_stock' => $val->heap_hasil,
						'user_id' 						=> $this->user_id,
						'report_stock_id'				=>$id
					);	

					$insert = $this->g_mod->insert_data_table('report_stock_details', NULL, $data);
				}
			}
			
		}else if ($this->input->post('i_type', TRUE)==3){
			$id = $this->input->post('i_warehouse2', TRUE);
			
			$sql ="SELECT * FROM stocks a 
			   join item_details b on b.item_detail_id = a.item_detail_id
			   WHERE warehouse_id = $id";
			$query = $this->g_mod->select_manual_for($sql);
			if($query){
				foreach ($query->result() as $val){

					$data = array(
						'item_detail_id' 				=> $val->item_detail_id,
						'report_stock_detail_qty_stock' => $val->stock_qty,
						'user_id' 						=> $this->user_id,
						'report_stock_id'				=>$id
						);
						

					$insert = $this->g_mod->insert_data_table('report_stock_details', NULL, $data);
				}
			}
		}
		}
		

		
	}

	/* end Function */

}
