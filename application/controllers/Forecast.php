<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forecast extends MY_Controller {
	private $any_error = array();
	public $tbl = 'forecasts';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,67);
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
			'title_page' 	=> 'Setup Data / Forecast',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('forecast_v', $data);
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
		$tbl = 'forecasts a';
		$select = 'a.*,b.sales_name,(select sum(forecast_detail_qty) from forecast_details c where a.forecast_id = c.forecast_id) as forecast_detail_qty';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'forecast_code,forecast_date,sales_name',
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
			'table' => 'saless b',
			'join'	=> 'b.sales_id=a.sales_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->forecast_id>0) {
					$response['data'][] = array(
						$val->forecast_code,
						$val->forecast_date,
						$val->sales_name,
						$val->forecast_detail_qty,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->forecast_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->forecast_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	/*public function load_data_detail($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'forecast_details a';
		$select = 'a.*,b.item_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'forecast_detail_qty,item_name',
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
			'type'	=> 'left'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'forecast_id',
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
				if ($val->forecast_detail_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->forecast_detail_qty,
						$val->forecast_detail_approve,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->forecast_detail_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->forecast_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
	}*/

	public function load_data_detail_modal($type,$id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'forecast_details a';
		$select = 'a.*,b.item_name,c.item_type_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'forecast_detail_qty,item_name',
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
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_types c',
			'join'	=> 'c.item_type_id=b.item_type_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'forecast_id',
			'param'	 => $id
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'a.item_type',
			'param'	 => $type
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
				if ($val->forecast_detail_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->item_type_name,
						$val->forecast_detail_qty
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

	public function load_data_detail($type,$id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'forecast_details a';
		$select = 'a.*,b.item_name,c.item_type_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'forecast_detail_qty,item_name',
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
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_types c',
			'join'	=> 'c.item_type_id=b.item_type_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'forecast_id',
			'param'	 => $id
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'a.item_type',
			'param'	 => $type
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
				if ($val->forecast_detail_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->forecast_detail_qty,
						//'<input type="number" class="form-control" onchange="get_approve(this.value,'.$val->forecast_detail_id.')" name="i_detail_approve'.$val->forecast_detail_id.'" placeholder="Masukkan Qty Approve">'
						$val->forecast_detail_approve
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

	public function load_data_item($type){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'items a';
		$select = 'a.*,b.item_type_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_type_name',
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
			'table' => 'item_types b',
			'join'	=> 'b.item_type_id=a.item_type_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'item_status',
			'param'	 => 1
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'item_type',
			'param'	 => $type
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->item_id>0) {
					$response['data'][] = array(
						$val->item_name,
						$val->item_type_name,
						'<input type="number" class="form-control" name="i_detail_qty'.$val->item_id.'" placeholder="Masukkan Qty Order">'
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

	public function load_data_approval(){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'forecast_approves a';
		$select = 'a.*,b.user_name,c.location_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'forecast_approve_date,user_name,location_name',
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
			'table' => 'users b',
			'join'	=> 'b.user_id=a.user_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'locations c',
			'join'	=> 'c.location_id=a.location_id',
			'type'	=> 'left'
		);


		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->forecast_approve_id>0) {
					$date = "'$val->forecast_approve_date'";
					$response['data'][] = array(
						$val->location_name,
						$val->forecast_approve_date,
						$val->user_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="search_data_approve('.$date.','.$val->forecast_approve_id.')" '.$u.'><i class="glyphicon glyphicon-search"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_approve('.$val->forecast_approve_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_detail_approval($date,$id){

		$date1 = explode('-', $date);
		$month = $date1[1];
		$year  = $date1[0];

		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'items a';
		$select = 'a.*,b.item_type_name,c.forecast_approve_detail_qty';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_type_name',
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
			'table' => 'item_types b',
			'join'	=> 'b.item_type_id=a.item_type_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'forecast_approve_details c',
			'join'	=> 'c.item_id=a.item_id',
			'type'	=> 'left'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'forecast_approves d',
			'join'	=> "d.forecast_approve_id=c.forecast_approve_id and d.forecast_approve_id = $id",
			'type'	=> 'left'
			//"d.forecast_approve_id=c.forecast_approve_id and MONTH(d.forecast_approve_date) = '$month' and YEAR(d.forecast_approve_date) = '$year'"
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'item_status',
			'param'	 => 1
		);
		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		$date = "'$date'";

		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->item_id>0) {
					if ($val->item_type == 0) {
						$type = "Baru";
					}else{
						$type = "Lama";
					}
					$response['data'][] = array(
						$val->item_name,
						'<a href="#salesModal" data-toggle="modal" onclick="search_sales('.$val->item_id.','.$month.','.$year.')">'.$val->item_type_name.'</a>',
						$type,
						'<input type="number" class="form-control" name="i_detail_approve'.$val->item_id.'" value="'.$val->forecast_approve_detail_qty.'" placeholder="Masukkan Qty Approve" onchange="update_approve('.$date.','.$val->item_id.',this.value,'.$id.')">'
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

	public function load_data_sales($item_id,$month,$year){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'forecasts a';
		$select = 'a.*,c.sales_name,b.forecast_detail_qty';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'forecast_date,sales_name',
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
			'table' => 'forecast_details b',
			'join'	=> 'b.forecast_id=a.forecast_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'saless c',
			'join'	=> 'c.sales_id=a.sales_id',
			'type'	=> 'inner'
		);

		$where = "MONTH(a.forecast_date) = '$month' and YEAR(a.forecast_date) = '$year' and b.item_id = $item_id";

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->forecast_id>0) {
					$response['data'][] = array(
						$val->sales_name,
						$val->forecast_detail_qty
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
		$select = 'a.*,b.sales_name';
		$tbl = 'forecasts a';
		//WHERE
		$where['data'][] = array(
			'column' => 'forecast_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'saless b',
			'join'	=> 'b.sales_id=a.sales_id',
			'type'	=> 'left'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'forecast_id'			=> $val->forecast_id,
					'forecast_date' 		=> $this->format_date_day_mid2($val->forecast_date),
					'sales_id' 			=> $val->sales_id,
					'sales_name' 		=> $val->sales_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.item_name';
		$tbl = 'forecast_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'forecast_detail_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'left'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'forecast_detail_id'		=> $val->forecast_detail_id,
					'forecast_detail_qty' 		=> $val->forecast_detail_qty,
					'forecast_detail_approve' 	=> $val->forecast_detail_approve,
					'item_id' 					=> $val->item_id,
					'item_name' 				=> $val->item_name,
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
				'column' => 'forecast_id',
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
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			$data2['forecast_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'forecast_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('forecast_details', $where2, $data2);

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

	public function action_data_detail(){
		$id = $this->input->post('i_detail_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'forecast_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('forecast_details', $where, $data);
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
			$insert = $this->g_mod->insert_data_table('forecast_details', NULL, $data);
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

	public function action_data_filter(){
		
		$tbl = 'items a';
		$select = 'a.*';

		$forceast_id = $this->input->post('i_id', TRUE);
		$forceast_id = ($forceast_id) ? ($forceast_id) : 0;
		$user_id = $this->user_id;
		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,NULL);

		if ($query<>false) {
			foreach ($query->result() as $val) {
				$value = $this->input->post('i_detail_qty'.$val->item_id, TRUE);
				if ($value) {
					$data = array(
						'forecast_id' => $forceast_id, 
						'item_id' => $val->item_id, 
						'item_type' => $val->item_type, 
						'forecast_detail_qty' => $value, 
						'user_id' => $user_id, 
					);

					$where2 = "forecast_id = $forceast_id and user_id = $user_id and item_id = $val->item_id";
					$query2 = $this->g_mod->select('*','forecast_details',NULL,NULL,NULL,NULL,NULL,$where2);
					if ($query2 == false) {
						$insert = $this->g_mod->insert_data_table('forecast_details', NULL, $data);
					}
				}
			}
		}
			
		$response['status'] = '200';
		$response['alert'] = '1';
		
		echo json_encode($response);
	}

	public function action_data_approval(){
		$id = $this->input->post('i_approve_id');
		if (strlen($id)>0) {
			//UPDATE
			$data['forecast_approve_date'] = $this->format_date_day_mid($this->input->post('i_date_approve', TRUE));
			$data['location_id'] = $this->input->post('i_location', TRUE);
			$data['user_id'] = $this->user_id;
			//WHERE
			$where['data'][] = array(
				'column' => 'forecast_approve_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('forecast_approves', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}

			$new_id = $id;
		} else {
			//INSERT
			$data['forecast_approve_date'] = $this->format_date_day_mid($this->input->post('i_date_approve', TRUE));
			$data['location_id'] = $this->input->post('i_location', TRUE);
			$data['user_id'] = $this->user_id;

			$insert = $this->g_mod->insert_data_table('forecast_approves', NULL, $data);
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

	public function action_data_detail_approval(){
		$item_id	= $this->input->post('item_id');
		$date 		= $this->input->post('date');
		$value 		= $this->input->post('value');
		$id 		= $this->input->post('id');

		$date1 = explode('-', $date);
		$month = $date1[1];
		$year  = $date1[0];

		
		$tbl = 'items a';
		$select = 'a.*,b.item_type_name,c.forecast_approve_detail_qty';

		//JOIN
		$join['data'][] = array(
			'table' => 'item_types b',
			'join'	=> 'b.item_type_id=a.item_type_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'forecast_approve_details c',
			'join'	=> 'c.item_id=a.item_id',
			'type'	=> 'left'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'forecast_approves d',
			'join'	=> "d.forecast_approve_id=c.forecast_approve_id",
			'type'	=> 'left'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'item_status',
			'param'	 => 1
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'c.item_id',
			'param'	 => $item_id
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'd.forecast_approve_date',
			'param'	 => "$date"
		);
		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {
		
			$data['forecast_approve_detail_qty'] 	= $value;
			//WHERE
			$where2['data'][] = array(
				'column' => 'forecast_approve_id',
				'param'	 => $id
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'item_id',
				'param'	 => $item_id
			);
			$update = $this->g_mod->update_data_table('forecast_approve_details', $where2, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}

			$new_id = $id;
		} else {
			//INSERT
			$data['forecast_approve_id'] 			= $id;
			$data['forecast_approve_detail_qty'] 	= $value;
			$data['item_id'] 						= $item_id;

			$insert = $this->g_mod->insert_data_table('forecast_approve_details', NULL, $data);
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
			'column' => 'forecast_id',
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
			'column' => 'forecast_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('forecast_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_approve(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'forecast_approve_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('forecast_approves', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_forceast(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(forecast_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(forecast_code,1,8)',
			'param'	 => 'FR'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'forecast_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('FR',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){
		if (!$id) {
			$data['forecast_code'] 		= $this->get_code_forceast();
		}

		$data['sales_id'] 			= $this->input->post('i_sales', TRUE);
		$data['forecast_date'] 		= $this->format_date_day_mid($this->input->post('i_date', TRUE));

		return $data;
	}

	function general_post_data_detail(){
		$data = array(
			'forecast_id' 				=> $this->input->post('i_id', TRUE),
			'forecast_detail_qty' 		=> $this->input->post('i_detail_qty', TRUE),
			'item_id' 					=> $this->input->post('i_item', TRUE),
			'user_id' 					=> $this->user_id
			
			);

		return $data;
	}

	public function load_data_select_forecast(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'forecast_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'forecast_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','forecasts',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->forecast_id,
					'text'	=> $val->forecast_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function get_approve(){
		$value 		= $this->input->get('value');
		$id 		= $this->input->get('id');

		//WHERE
		$where['data'][] = array(
			'column' => 'forecast_detail_id',
			'param'	 => $id
		);
		$data['forecast_detail_approve'] = $value;

		$update = $this->g_mod->update_data_table('forecast_details', $where, $data);
		if($update->status) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}
	}
	/* end Function */

}
