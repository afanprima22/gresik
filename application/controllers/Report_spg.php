<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_spg extends MY_Controller {
	private $any_error = array();
	public $tbl = 'Report_spgs';

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
			'title_page' 	=> 'Laporan / Spg',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('Report_spg_v', $data);
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
		$tbl = 'Report_spgs a';
		$select = 'a.*,b.spg_name,c.kongsi_branch_name,d.month_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'b.spg_name,c.kongsi_branch_name',
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
			'table' => 'spgs b',
			'join'	=> 'b.spg_id=a.spg_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'kongsi_branchs c',
			'join'	=> 'c.kongsi_branch_id=a.kongsi_branch_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'months d',
			'join'	=> 'd.month_id=a.month_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->report_spg_id>0) {
					$response['data'][] = array(
						$val->spg_name,
						$val->kongsi_branch_name,
						$val->month_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->report_spg_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->report_spg_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'report_spg_details x';
		$select = 'x.*,a.*,f.item_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'f.item_name',
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
			'table' => 'set_detail_branch a',
			'join'	=> 'a.set_detail_branch_id = x.set_detail_branch_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'items f',
			'join'	=> 'f.item_id = a.item_id',
			'type'	=> 'inner'
		);
		/*$join['data'][] = array(
			'table' => 'report_spgs a',
			'join'	=> 'a.report_spg_id = x.report_spg_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'kongsi_branchs b',
			'join'	=> 'b.kongsi_branch_id = a.kongsi_branch_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'kongsis c',
			'join'	=> 'c.kongsi_id=b.kongsi_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'order_kongsis d',
			'join'	=> 'd.kongsi_id = c.kongsi_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'kongsi_prices e',
			'join'	=> 'e.kongsi_id = c.kongsi_id',
			'type'	=> 'inner'
		);

		*/
		//WHERE
		$where['data'][] = array(
			'column' => 'x.report_spg_id',
			'param'	 => $id
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				$sql = "SELECT set_detail_branch_qty as total FROM set_detail_branch a WHERE item_id =$val->item_id";
				$row= $this->g_mod->select_manual($sql);
				$laku = $val->report_spg_detail_date1+$val->report_spg_detail_date2+$val->report_spg_detail_date3+$val->report_spg_detail_date4+$val->report_spg_detail_date5+$val->report_spg_detail_date6+$val->report_spg_detail_date7+$val->report_spg_detail_date8+$val->report_spg_detail_date9+$val->report_spg_detail_date10+$val->report_spg_detail_date11+$val->report_spg_detail_date12+$val->report_spg_detail_date13+$val->report_spg_detail_date14+$val->report_spg_detail_date15+$val->report_spg_detail_date16+$val->report_spg_detail_date17+$val->report_spg_detail_date18+$val->report_spg_detail_date19+$val->report_spg_detail_date20+$val->report_spg_detail_date21+$val->report_spg_detail_date22+$val->report_spg_detail_date23+$val->report_spg_detail_date24+$val->report_spg_detail_date25+$val->report_spg_detail_date26+$val->report_spg_detail_date27+$val->report_spg_detail_date28+$val->report_spg_detail_date29+$val->report_spg_detail_date30+$val->report_spg_detail_date31;
				if ($val->report_spg_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->set_detail_branch_qty,
						$laku,
						'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_qty_per_date('.$val->report_spg_detail_id.','.$val->report_spg_id.')"><i class="glyphicon glyphicon-search"></i></a>'
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
		$select = 'a.*,c.kongsi_branch_name,b.spg_name,d.month_name';
		$tbl = 'Report_spgs a';
		//JOIN
		$join['data'][] = array(
			'table' => 'spgs b',
			'join'	=> 'b.spg_id=a.spg_id',
			'type'	=> 'left'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'kongsi_branchs c',
			'join'	=> 'c.kongsi_branch_id=a.kongsi_branch_id',
			'type'	=> 'left'
		);
		$join['data'][] = array(
			'table' => 'months d',
			'join'	=> 'd.month_id=a.month_id',
			'type'	=> 'left'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'report_spg_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'report_spg_id'				=> $val->report_spg_id,
					'kongsi_branch_id' 			=> $val->kongsi_branch_id,
					'kongsi_branch_name' 		=> $val->kongsi_branch_name,
					'spg_id' 					=> $val->spg_id,
					'spg_name' 				=> $val->spg_name,
					'month_id' 					=> $val->month_id,
					'month_name' 				=> $val->month_name,
					//'report_spg_date' 				=> $this->format_date_day_mid2($val->report_spg_date),
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_qty_per_date($id2){
		$select = 'a.*';
		$tbl = 'report_spg_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'report_spg_id',
			'param'	 => $id2
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'report_spg_detail_date1' 					=> $val->report_spg_detail_date1,
					'report_spg_detail_date2' 					=> $val->report_spg_detail_date2,
					'report_spg_detail_date3' 					=> $val->report_spg_detail_date3,
					'report_spg_detail_date4' 					=> $val->report_spg_detail_date4,
					'report_spg_detail_date5' 					=> $val->report_spg_detail_date5,
					'report_spg_detail_date6' 					=> $val->report_spg_detail_date6,
					'report_spg_detail_date7' 					=> $val->report_spg_detail_date7,
					'report_spg_detail_date8' 					=> $val->report_spg_detail_date8,
					'report_spg_detail_date9' 					=> $val->report_spg_detail_date9,
					'report_spg_detail_date10' 					=> $val->report_spg_detail_date10,
					'report_spg_detail_date11' 					=> $val->report_spg_detail_date11,
					'report_spg_detail_date12' 					=> $val->report_spg_detail_date12,
					'report_spg_detail_date13' 					=> $val->report_spg_detail_date13,
					'report_spg_detail_date14' 					=> $val->report_spg_detail_date14,
					'report_spg_detail_date15' 					=> $val->report_spg_detail_date15,
					'report_spg_detail_date16' 					=> $val->report_spg_detail_date16,
					'report_spg_detail_date17' 					=> $val->report_spg_detail_date17,
					'report_spg_detail_date18' 					=> $val->report_spg_detail_date18,
					'report_spg_detail_date19' 					=> $val->report_spg_detail_date19,
					'report_spg_detail_date20' 					=> $val->report_spg_detail_date20,
					'report_spg_detail_date21' 					=> $val->report_spg_detail_date21,
					'report_spg_detail_date22' 					=> $val->report_spg_detail_date22,
					'report_spg_detail_date23' 					=> $val->report_spg_detail_date23,
					'report_spg_detail_date24' 					=> $val->report_spg_detail_date24,
					'report_spg_detail_date25' 					=> $val->report_spg_detail_date25,
					'report_spg_detail_date26' 					=> $val->report_spg_detail_date26,
					'report_spg_detail_date27' 					=> $val->report_spg_detail_date27,
					'report_spg_detail_date28' 					=> $val->report_spg_detail_date28,
					'report_spg_detail_date29' 					=> $val->report_spg_detail_date29,
					'report_spg_detail_date30' 					=> $val->report_spg_detail_date30,
					'report_spg_detail_date31' 					=> $val->report_spg_detail_date31,
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
				'column' => 'report_spg_id',
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
			//echo $data['kongsi_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			$id2= $data['kongsi_branch_id'];
			$this->general_post_data_detail($id2);
			$data2['report_spg_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'report_spg_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('report_spg_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id'] = $insert->output;
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_qty_per_date(){
		$id = $this->input->post('i_detail_id');
			//UPDATE
			$data = $this->general_post_data_qty_per_date();
			//WHERE
			$where['data'][] = array(
				'column' => 'report_spg_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('report_spg_details', $where, $data);
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
			'column' => 'report_spg_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl, $where);
		$delete2 = $this->g_mod->delete_data_table('report_spg_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	

	function general_post_data(){

		$data = array(
			'spg_id' 					=> $this->input->post('i_spg', TRUE),
			'month_id' 					=> $this->input->post('i_month', TRUE),
			'kongsi_branch_id' 						=> $this->input->post('i_branch', TRUE),
			);
			

		return $data;
	}

	function general_post_data_qty_per_date(){

		$data = array(
			'report_spg_detail_date1' 					=> $this->input->post('date1', TRUE),
			'report_spg_detail_date2' 					=> $this->input->post('date2', TRUE),
			'report_spg_detail_date3' 					=> $this->input->post('date3', TRUE),
			'report_spg_detail_date4' 					=> $this->input->post('date4', TRUE),
			'report_spg_detail_date5' 					=> $this->input->post('date5', TRUE),
			'report_spg_detail_date6' 					=> $this->input->post('date6', TRUE),
			'report_spg_detail_date7' 					=> $this->input->post('date7', TRUE),
			'report_spg_detail_date8' 					=> $this->input->post('date8', TRUE),
			'report_spg_detail_date9' 					=> $this->input->post('date9', TRUE),
			'report_spg_detail_date10' 					=> $this->input->post('date10', TRUE),
			'report_spg_detail_date11' 					=> $this->input->post('date11', TRUE),
			'report_spg_detail_date12' 					=> $this->input->post('date12', TRUE),
			'report_spg_detail_date13' 					=> $this->input->post('date13', TRUE),
			'report_spg_detail_date14' 					=> $this->input->post('date14', TRUE),
			'report_spg_detail_date15' 					=> $this->input->post('date15', TRUE),
			'report_spg_detail_date16' 					=> $this->input->post('date16', TRUE),
			'report_spg_detail_date17' 					=> $this->input->post('date17', TRUE),
			'report_spg_detail_date18' 					=> $this->input->post('date18', TRUE),
			'report_spg_detail_date19' 					=> $this->input->post('date19', TRUE),
			'report_spg_detail_date20' 					=> $this->input->post('date20', TRUE),
			'report_spg_detail_date21' 					=> $this->input->post('date21', TRUE),
			'report_spg_detail_date22' 					=> $this->input->post('date22', TRUE),
			'report_spg_detail_date23' 					=> $this->input->post('date23', TRUE),
			'report_spg_detail_date24' 					=> $this->input->post('date24', TRUE),
			'report_spg_detail_date25' 					=> $this->input->post('date25', TRUE),
			'report_spg_detail_date26' 					=> $this->input->post('date26', TRUE),
			'report_spg_detail_date27' 					=> $this->input->post('date27', TRUE),
			'report_spg_detail_date28' 					=> $this->input->post('date28', TRUE),
			'report_spg_detail_date29' 					=> $this->input->post('date29', TRUE),
			'report_spg_detail_date30' 					=> $this->input->post('date30', TRUE),
			'report_spg_detail_date31' 					=> $this->input->post('date31', TRUE),
			);
			

		return $data;
	}

	function general_post_data_detail($id2){

		$sql ="SELECT * FROM `set_detail_branch` WHERE kongsi_branch_id = $id2";
		$query = $this->g_mod->select_manual_for($sql);
		foreach ($query->result() as $val){

		$data = array(
			'set_detail_branch_id' 					=> $val->set_detail_branch_id,
			'item_id' 					=> $val->item_id,
			'user_id' 					=> $this->user_id,
			);
			

		$insert = $this->g_mod->insert_data_table('report_spg_details', NULL, $data);
		}
	}

	public function load_data_select_branch(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'kongsi_branch_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'kongsi_branch_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','kongsi_branchs',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->kongsi_branch_id,
					'text'	=> $val->kongsi_branch_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_month(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'month_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'month_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','months',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->month_id,
					'text'	=> $val->month_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
