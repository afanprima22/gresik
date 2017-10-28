<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_kongsi extends MY_Controller {
	private $any_error = array();
	public $tbl = 'Report_kongsis';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,85);
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
			'title_page' 	=> 'Laporan / Kongsi',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('report_kongsi_v', $data);
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
		$tbl = 'Report_kongsis a';
		$select = 'a.*,b.kongsi_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'kongsi_name',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][]=array(
			'table'		=>'kongsis b',
			'join'		=>'b.kongsi_id = a.kongsi_id',
			'type'		=>'inner'
			);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->report_kongsi_id>0) {
					$response['data'][] = array(
						$val->kongsi_name,
						$val->report_kongsi_date,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->report_kongsi_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->report_kongsi_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'report_kongsi_details a';
		$select = 'a.*,c.invoice_kongsi_code';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'invoice_kongsi_code',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][] = array(
			'table' => 'invoice_kongsis c',
			'join'	=> 'c.invoice_kongsi_id=a.invoice_kongsi_id',
			'type'	=> 'left'
		);

		$where['data'][] = array(
			'column' => 'a.report_kongsi_id',
			'param'	 => $id
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'a.user_id',
			'param'	 => $this->user_id
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->report_kongsi_detail_id>0) {
					$response['data'][] = array(
						$val->invoice_kongsi_code,
						$val->report_kongsi_detail_nominal,
						'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_detail_invoice('.$val->invoice_kongsi_id.')"><i class="glyphicon glyphicon-search"></i></a>'	
						
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

	public function load_data_detail_kongsi(){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$id =$this->input->get('id');
		
		$tbl = 'invoice_kongsis a';
		$select = 'a.*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'invoice_kongsi_code',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$where['data'][]=array(
			'column'	=>'a.kongsi_id',
			'param'		=>$id
			);


		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,NULL,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,NULL,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				$invoice_kongsi = $val->invoice_kongsi_id;
				$sql ="SELECT SUM(b.invoice_kongsi_detail_qty_print*c.order_kongsi_detail_price*b.invoice_kongsi_detail_discount/100) as total 
					   FROM invoice_kongsis a LEFT JOIN invoice_kongsi_details b on b.invoice_kongsi_id = a.invoice_kongsi_id 
					   LEFT JOIN order_kongsi_details c ON c.order_kongsi_detail_id = b.order_kongsi_detail_id 
					   WHERE a.invoice_kongsi_id = $invoice_kongsi ";
				$row = $this->g_mod->select_manual($sql);

				$sql2 ="SELECT SUM(a.invoice_kongsi_detail_qty_print*c.order_kongsi_detail_price) as total2, SUM(invoice_kongsi_detail_discount) as discount 
						FROM invoice_kongsi_details a 
						LEFT JOIN invoice_kongsis b on b.invoice_kongsi_id = a.invoice_kongsi_id 
						LEFT JOIN order_kongsi_details c ON c.order_kongsi_detail_id = a.order_kongsi_detail_id 
						WHERE a.invoice_kongsi_id = $invoice_kongsi ";
				$row2 = $this->g_mod->select_manual($sql2);
				$total3 = $val->invoice_kongsi_discount*$row2['total2']/100;

				if ($val->kongsi_id>0) {
					$response['data'][] = array(
						$val->invoice_kongsi_code,
						number_format($row2['total2']-$row['total']-$total3),
						'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_detail_invoice('.$val->invoice_kongsi_id.')"><i class="glyphicon glyphicon-search"></i></a>'

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

	

	public function load_data_detail_invoice($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'invoice_kongsi_details a';
		$select = 'a.*,c.item_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name',
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
			'column' => 'invoice_kongsi_id',
			'param'	 => $id
		);

		

		//JOIN
		$join['data'][] = array(
			'table' => 'order_kongsi_details b',
			'join'	=> 'b.order_kongsi_detail_id=a.order_kongsi_detail_id',
			'type'	=> 'left'
		);

		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=b.item_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->invoice_kongsi_detail_id>0) {

					

					$response['data'][] = array(
						$val->item_name,
						number_format($val->invoice_kongsi_detail_qty_print)
						
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
		$select = 'a.*,b.kongsi_name';
		$tbl = 'Report_kongsis a';
		//JOIN
		$join['data'][]=array(
			'table'	=>'kongsis b',
			'join'	=>'b.kongsi_id=a.kongsi_id',
			'type'	=>'LEFT'
			);
		//WHERE
		$where['data'][] = array(
			'column' => 'report_kongsi_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'report_kongsi_id'		=>$val->report_kongsi_id,
					'kongsi_id'		=>$val->kongsi_id,
					'kongsi_name'		=>$val->kongsi_name,
					'report_kongsi_date' 	=> $this->format_date_day_mid2($val->report_kongsi_date),

				);
			}

			echo json_encode($response);
		}
	}

	public function action_data(){
		$id = $this->input->post('i_id');
		if (strlen($id)>0) {
			//UPDATE
			$where2['data'][] = array(
				'column' => 'report_kongsi_id',
				'param'	 => $id
			);
			$delete2 = $this->g_mod->delete_data_table('report_kongsi_details', $where2);
			$data = $this->general_post_data();

			//WHERE
			$where['data'][] = array(
				'column' => 'report_kongsi_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);
			//detail
			$id2 = $data['kongsi_id'];
			$this->general_post_data_detail($id2);

			$data2['report_kongsi_id'] = $id;
			//WHERE
			$where3['data'][] = array(
				'column' => 'report_kongsi_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('report_kongsi_details', $where3, $data2);

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
			
			$id2 = $data['kongsi_id'];
			$this->general_post_data_detail($id2);
			
			$data2['report_kongsi_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'report_kongsi_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('report_kongsi_details', $where2, $data2);
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
			'column' => 'report_kongsi_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl, $where);
		$delete2 = $this->g_mod->delete_data_table('report_kongsi_details', $where);
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
			'report_kongsi_date' 			=> $this->format_date_day_mid($this->input->post('i_date')),
			'kongsi_id' 					=>$this->input->post('i_kongsi'),
			
			);

		return $data;
	}

	public function general_post_data_detail($id2){
		$tbl = 'invoice_kongsis a';
		$select = 'a.*';
		
		$where['data'][]=array(
			'column'	=>'a.kongsi_id',
			'param'		=>$id2
			);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);

			foreach ($query->result() as $val) {
				$invoice_kongsi = $val->invoice_kongsi_id;
				$sql ="SELECT SUM(b.invoice_kongsi_detail_qty_print*c.order_kongsi_detail_price*b.invoice_kongsi_detail_discount/100) as total 
					   FROM invoice_kongsis a LEFT JOIN invoice_kongsi_details b on b.invoice_kongsi_id = a.invoice_kongsi_id 
					   LEFT JOIN order_kongsi_details c ON c.order_kongsi_detail_id = b.order_kongsi_detail_id 
					   WHERE a.invoice_kongsi_id = $invoice_kongsi ";
				$row = $this->g_mod->select_manual($sql);

				$sql2 ="SELECT SUM(a.invoice_kongsi_detail_qty_print*c.order_kongsi_detail_price) as total2, SUM(invoice_kongsi_detail_discount) as discount 
						FROM invoice_kongsi_details a 
						LEFT JOIN invoice_kongsis b on b.invoice_kongsi_id = a.invoice_kongsi_id 
						LEFT JOIN order_kongsi_details c ON c.order_kongsi_detail_id = a.order_kongsi_detail_id 
						WHERE a.invoice_kongsi_id = $invoice_kongsi ";
				$row2 = $this->g_mod->select_manual($sql2);
				$total3 = $val->invoice_kongsi_discount*$row2['total2']/100;

				/*if ($val->kongsi_id>0) {
					$response['data'][] = array(
						$val->invoice_kongsi_code,
						number_format($row2['total2']-$row['total']-$total3),
						'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_detail_invoice('.$val->invoice_kongsi_id.')"><i class="glyphicon glyphicon-search"></i></a>'

					);
					$no++;	
				}*/
				$data2['invoice_kongsi_id'] = $val->invoice_kongsi_id;
				$data2['report_kongsi_detail_nominal'] = $row2['total2']-$row['total']-$total3;
				$data2['user_id'] = $this->user_id;
			
				$insert = $this->g_mod->insert_data_table('report_kongsi_details', NULL, $data2);
			}

	}

	/* end Function */

}