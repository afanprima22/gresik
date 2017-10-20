<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_branch_kongsi extends MY_Controller {
	private $any_error = array();
	public $tbl = 'set_branchs';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,79);
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
			'title_page' 	=> 'Transaction / Set Cabang Kongsi',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('set_branch_v', $data);
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
		$tbl = 'set_branchs a';
		$select = '*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'set_branch_date',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][] = array(
			'table' => 'kongsis d',
			'join'	=> 'd.kongsi_id=a.kongsi_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->set_branch_id>0) {
					$response['data'][] = array(
						$val->kongsi_name,
						$val->set_branch_date,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->set_branch_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->set_branch_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'set_branch_details a';
		$select = 'a.*,b.item_name,c.order_kongsi_detail_id,c.order_kongsi_detail_qty,d.kongsi_id';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'b.item_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'order_kongsi_details c',
			'join'	=> 'c.order_kongsi_detail_id=a.order_kongsi_detail_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'set_branchs d',
			'join'	=> 'd.set_branch_id=a.set_branch_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'a.set_branch_id',
			'param'	 => $id
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->set_branch_detail_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->order_kongsi_detail_qty,
						'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_stock('.$val->kongsi_id.','.$val->order_kongsi_detail_id.','.$val->set_branch_detail_id.')"><i class="glyphicon glyphicon-search"></i></a>'
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

	public function load_data_stock($id,$id2){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'kongsi_branchs a';
		$select = 'a.*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'kongsi_branch_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
		
		$join['data'][] = array(
			'table' => 'kongsis d',
			'join'	=> 'd.kongsi_id =a.kongsi_id',
			'type'	=> 'inner'
		);


		$join['data'][] = array(
			'table' => 'set_branchs e',
			'join'	=> 'e.kongsi_id =a.kongsi_id',
			'type'	=> 'inner'
		);

		$where['data'][]=array(
			'column'	=>'a.kongsi_id',
			'param'		=>$id

		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				$sql = "SELECT a.*,b.*
						FROM set_branch_details a 
						LEFT JOIN set_detail_branch b ON b.set_branch_detail_id=a.set_branch_detail_id
						WHERE a.order_kongsi_detail_id =$id2";
				$row = $this->g_mod->select_manual($sql);
				if ($val->kongsi_branch_id>0) {
					$response['data'][] = array(
						$val->kongsi_branch_name,
						$row['set_detail_branch_qty'],
						'<input type="number" class="form-control money" name="i_qty<?='.$val->kongsi_branch_id.'?>" id="i_qty<?='.$val->kongsi_branch_id.'?>">
						<input type="text" class="form-control money" value="'.$row['set_detail_branch_id'].'" name="i_set_id<?='.$val->kongsi_branch_id.'?>" id="i_set_id<?='.$val->kongsi_branch_id.'?>">'
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
		$select = '*';
		$tbl = 'set_branchs a';
		
		$join['data'][] = array(
			'table' => 'kongsis e',
			'join'	=> 'e.kongsi_id =a.kongsi_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'set_branch_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'set_branch_id'				=> $val->set_branch_id,
					'kongsi_id'				=> $val->kongsi_id,
					'kongsi_name'				=> $val->kongsi_name,
					'set_branch_date' 			=> $this->format_date_day_mid2($val->set_branch_date),
				);
			}

			echo json_encode($response);
		}
	}

	public function total($id2,$id3){ 
		$sql = "SELECT * FROM order_kongsi_details a 
				WHERE order_kongsi_detail_id =$id2";
		$query = $this->g_mod->select_manual_for($sql);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$sql2 = "SELECT set_detail_branch_qty as qty FROM set_detail_branch a 
						WHERE set_branch_detail_id = $id3";
				$row = $this->g_mod->select_manual($sql2);
				
				$response['val'][] = array(
					'order_kongsi_detail_qty'				=> $val->order_kongsi_detail_qty,
					'qty'				=> $row['qty'],
				);
			}

			echo json_encode($response);
		}
	}

	

	public function action_data(){
		$id = $this->input->post('i_id');
		$id2 = $this->input->post('i_kongsi');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data($id);
			
			//WHERE
			$where['data'][] = array(
				'column' => 'set_branch_id',
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
			//echo $data['kongsi_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			$data3 = $this->action_data_reference($id2);
			$data2['set_branch_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'set_branch_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('set_branch_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id2'] = $insert->output;
			} else {
				$response['status'] = '204';
			}
		}
		$response['coba'] = $id;
		echo json_encode($response);
	}

	public function action_data_reference($id2){
		$select = 'a.*,c.item_id,d.order_kongsi_detail_id';
		$tbl2 = 'order_kongsis a';

		$join['data'][] = array(
			'table' => 'kongsis b',
			'join'	=> 'b.kongsi_id = a.kongsi_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'kongsi_prices c',
			'join'	=> 'c.kongsi_id = b.kongsi_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'order_kongsi_details d',
			'join'	=> 'd.order_kongsi_id = a.order_kongsi_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][]=array(
			'column'	=>'a.kongsi_id',
			'param'		=>$id2
		);		
		$query = $this->g_mod->select($select,$tbl2,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {
			foreach ($query->result() as $val) {
				
				//WHERE
				$data['order_kongsi_id'] 			= $val->order_kongsi_id;
				$data['order_kongsi_detail_id'] 			= $val->order_kongsi_detail_id;
				$data['item_id'] 			= $val->item_id;
				$data['user_id'] 			= $this->user_id;

				$insert = $this->g_mod->insert_data_table('set_branch_details', NULL, $data);
			}
		}
	}

	public function action_data_bagi($id,$id2){
		$tbl = 'kongsi_branchs a';
		$select = 'a.*';
		
		
		$join['data'][] = array(
			'table' => 'kongsis d',
			'join'	=> 'd.kongsi_id =a.kongsi_id',
			'type'	=> 'inner'
		);


		$join['data'][] = array(
			'table' => 'set_branchs e',
			'join'	=> 'e.kongsi_id =a.kongsi_id',
			'type'	=> 'inner'
		);

		$where['data'][]=array(
			'column'	=>'a.kongsi_id',
			'param'		=>$id

		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		foreach ($query->result() as $row){ 
			$sql = "SELECT a.*,b.*,c.item_id
						FROM set_branch_details a 
						LEFT JOIN set_detail_branch b ON b.set_branch_detail_id=a.set_branch_detail_id
						JOIN order_kongsi_details c on c.order_kongsi_detail_id = a.order_kongsi_detail_id
						WHERE a.order_kongsi_detail_id =$id2";
				$row2 = $this->g_mod->select_manual($sql);

			$id_set=$this->input->post('i_set_id<?='.$row->kongsi_branch_id.'?>');
			if (strlen($id_set)>0){
				$row->kongsi_branch_id;
			$where2['data'][]=array(
				'column'	=>'set_detail_branch_id',
				'param'		=>$id_set
				);

			$data = array(
			'set_detail_branch_qty' 	=> $this->input->post('i_qty<?='.$row->kongsi_branch_id.'?>'),
			'set_branch_detail_id' 	=> $this->input->post('detail_id',TRUE),
			'item_id' 					=> $row2['item_id'],
			'kongsi_branch_id' 		=> $row->kongsi_branch_id,
			'user_id' 						=> $this->user_id
			);
				
			//$this->g_mod->update_data_stock('set_branch_details','set_branch_detail_qty','set_branch_id',-$data['set_branch_detail_qty'],$row->set_branch_id);
			$update = $this->g_mod->update_data_table('set_detail_branch', $where2, $data);
			}else{
				$row->kongsi_branch_id;

			$data = array(
			'set_detail_branch_qty' 	=> $this->input->post('i_qty<?='.$row->kongsi_branch_id.'?>'),
			'set_branch_detail_id' 	=> $this->input->post('detail_id',TRUE),
			'item_id' 					=> $row2['item_id'],
			'kongsi_branch_id' 		=> $row->kongsi_branch_id,
			'user_id' 						=> $this->user_id
			);
				
			//$this->g_mod->update_data_stock('set_branch_details','set_branch_detail_qty','set_branch_id',-$data['set_branch_detail_qty'],$row->set_branch_id);
			$insert = $this->g_mod->insert_data_table('set_detail_branch', NULL, $data);
			}
			
			
		}
		 echo json_encode($this->input->post('i_qty<?='.$row->kongsi_branch_id.'?>'));
	}


	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'set_branch_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl, $where);
		$delete2 = $this->g_mod->delete_data_table('set_branch_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function general_post_data($id){
		$data['set_branch_date'] 		= $this->format_date_day_mid($this->input->post('i_date', TRUE));
		$data['kongsi_id'] 		= $this->input->post('i_kongsi', TRUE);
		
		return $data;
	}

	/* end Function */

}
