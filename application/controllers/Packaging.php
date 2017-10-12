<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packaging extends MY_Controller {
	private $any_error = array();
	public $tbl = 'packagings';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,51);
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
			'title_page' 	=> 'Transaksi / Packaging',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('packaging_v', $data);
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
		$tbl = 'packagings a';
		$select = "a.*,GROUP_CONCAT(employee_name ORDER BY employee_name SEPARATOR ' ,') employee_names";
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'packaging_code',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);
		//JOIN
		/*$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'left'
		);*/

		
		$join['data'][] = array(
			'table' => 'packaging_employees b',
			'join'	=> 'b.packaging_id=a.packaging_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'employees c',
			'join'	=> 'c.employee_id=b.employee_id',
			'type'	=> 'left'
		);
		$whare = 'user_id = 0';
		$group_by = 'packaging_id';

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL,$whare,$group_by);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL,$whare,$group_by);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL,$whare,$group_by);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->packaging_id>0) {
					$response['data'][] = array(
						$val->packaging_code,
						$val->employee_names,
						$val->packaging_date,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->packaging_id.'),reset(),reset2()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->packaging_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'packaging_details a';
		$select = 'a.*,b.package_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'package_name',
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
			'column' => 'packaging_id',
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
			'table' => 'packages b',
			'join'	=> 'b.package_id=a.package_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->packaging_detail_id>0) {
					$response['data'][] = array(
						$val->packaging_detail_id,
						$val->package_name,
						$val->packaging_detail_qty,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->packaging_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->packaging_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_detail_item($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'packaging_detail_items a';
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
			'column' => 'packaging_id',
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
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details c',
			'join'	=> 'c.item_detail_id=a.item_detail_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->packaging_detail_item_id>0) {
					$response['data'][] = array(
						$val->packaging_detail_item_id,
						$val->item_name.' - '.$val->item_detail_color,
						$val->packaging_box,
						$val->packaging_box_qty,
						$val->packaging_retail,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail_item('.$val->packaging_detail_item_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail_item('.$val->packaging_detail_item_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.item_name,b.item_status,c.item_detail_color';
		$tbl = 'packagings a';

		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details c',
			'join'	=> 'c.item_detail_id=a.item_detail_id',
			'type'	=> 'left'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'packaging_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$select2 = 'a.*,b.employee_name';
				$tbl2 = 'packaging_employees a';
				//WHERE
				$where['data'][] = array(
					'column' => 'packaging_id',
					'param'	 => $this->input->get('id')
				);
				//JOIN
				$join2['data'][] = array(
					'table' => 'employees b',
					'join'	=> 'b.employee_id=a.employee_id',
					'type'	=> 'inner'
				);
				$query_employee = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,$join2,$where);
				foreach ($query_employee->result() as $val2) {
					$employees['val2'][] = array(
						'id' 	=> $val2->employee_id,
						'text' 	=> $val2->employee_name
					);
				}

				$response['val'][] = array(
					'packaging_id'				=> $val->packaging_id,
					'packaging_code' 			=> $val->packaging_code,
					'packaging_date' 			=> $this->format_date_day_mid2($val->packaging_date),
					'item_id' 				=> $val->item_id,
					'item_name' 			=> $val->item_name,
					'item_detail_id' 		=> $val->item_detail_id,
					'item_detail_color'		=> $val->item_detail_color,
					'packaging_box' 			=> $val->packaging_box,
					'packaging_box_qty' 			=> $val->packaging_box_qty,
					'packaging_retail'			=> $val->packaging_retail,
					'packaging_lock' 			=> $val->packaging_lock,
					'packaging_request'			=> $val->packaging_request,
					'employees'			=> $employees,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.package_name';
		$tbl = 'packaging_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'packaging_detail_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'packages b',
			'join'	=> 'b.package_id=a.package_id',
			'type'	=> 'join'
		);


		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'packaging_detail_id'				=> $val->packaging_detail_id,
					'packaging_detail_qty' 				=> $val->packaging_detail_qty,
					'package_id' 						=> $val->package_id,
					'package_name' 						=> $val->package_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail_item(){
		$select = 'a.*,b.item_name,c.item_detail_color';
		$tbl = 'packaging_detail_items a';
		//WHERE
		$where['data'][] = array(
			'column' => 'packaging_detail_item_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details c',
			'join'	=> 'c.item_detail_id=a.item_detail_id',
			'type'	=> 'left'
		);


		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'packaging_detail_item_id'		=> $val->packaging_detail_item_id,
					'item_id' 						=> $val->item_id,
					'item_name' 					=> $val->item_name,
					'item_detail_id' 				=> $val->item_detail_id,
					'item_detail_color' 			=> $val->item_detail_color,
					'packaging_box' 				=> $val->packaging_box,
					'packaging_box_qty' 			=> $val->packaging_box_qty,
					'packaging_retail' 				=> $val->packaging_retail,
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
				'column' => 'packaging_id',
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
			//echo $data['packaging_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['packaging_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'packaging_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('packaging_details', $where2, $data2);
			$update = $this->g_mod->update_data_table('packaging_detail_items', $where2, $data2);

			/*$retail = $data['packaging_retail'];
			$box 	= $data['packaging_box'] * $data['packaging_box_qty'];

			if ($box) {
				//WHERE
				$where3['data'][] = array(
					'column' => 'item_detail_id',
					'param'	 => $data['item_detail_id']
				);
				//WHERE
				$where3['data'][] = array(
					'column' => 'warehouse_id',
					'param'	 => 1
				);
				//WHERE
				$where3['data'][] = array(
					'column' => 'package_id',
					'param'	 => 1
				);

				$query_box = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where3);
				if ($query_box<>false) {
					$where4 = 'and warehouse_id = 1 and package_id = 1';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',-$box,$data['item_detail_id'],$where4);
				}else{
					$data_box['item_detail_id'] 	= $data['item_detail_id'];
					$data_box['warehouse_id'] 		= 1;
					$data_box['stock_qty'] 			= $box;
					$data_box['package_id'] 		= 1;

					$this->g_mod->insert_data_table('stocks', NULL, $data_box);
				}
			}

			if ($retail) {
				//WHERE
				$where5['data'][] = array(
					'column' => 'item_detail_id',
					'param'	 => $data['item_detail_id']
				);
				//WHERE
				$where5['data'][] = array(
					'column' => 'warehouse_id',
					'param'	 => 1
				);
				//WHERE
				$where5['data'][] = array(
					'column' => 'package_id',
					'param'	 => 2
				);

				$query_retail = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where5);
				if ($query_retail<>false) {
					$where6 = 'and warehouse_id = 1 and package_id = 2';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',-$retail,$data['item_detail_id'],$where6);
				}else{
					$data_retail['item_detail_id'] 		= $data['item_detail_id'];
					$data_retail['warehouse_id'] 		= 1;
					$data_retail['stock_qty'] 			= $retail;
					$data_retail['package_id'] 			= 2;

					$this->g_mod->insert_data_table('stocks', NULL, $data_retail);
				}
			}

			$where7 = 'and warehouse_id = 1 and package_id = 0';
			$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$box + $retail,$data['item_detail_id'],$where7);*/

			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id'] = $insert->output;
			} else {
				$response['status'] = '204';
			}
			$new_id = $insert->output;
		}
		
		$employee_id = $this->input->post('i_employee');
		$arrlength_employee = count($employee_id);

		if ($employee_id) {
			//WHERE
			$where3['data'][] = array(
				'column' => 'packaging_id',
				'param'	 => $new_id
			);
			$this->g_mod->delete_data_table('packaging_employees',$where3);
			for($x = 0; $x < $arrlength_employee; $x++) {
				$data2['packaging_id'] 	= $new_id;
				$data2['employee_id'] 	= $employee_id[$x];
				$this->g_mod->insert_data_table('packaging_employees',NULL,$data2);
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
				'column' => 'packaging_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('packaging_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail();
			//echo $data['packaging_img'];
			$insert = $this->g_mod->insert_data_table('packaging_details', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_detail_item(){
		$id = $this->input->post('i_detail_item_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail_item($id);
			//WHERE
			$where['data'][] = array(
				'column' => 'packaging_detail_item_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('packaging_detail_items', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail_item($id);
			//echo $data['packaging_img'];
			$insert = $this->g_mod->insert_data_table('packaging_detail_items', NULL, $data);
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
			'column' => 'packaging_id',
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
			'column' => 'packaging_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('packaging_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_detail_item(){
		$id = $this->input->post('id');

			$detail = $this->g_mod->read_data('*','packaging_detail_items','packaging_detail_item_id',$id);

			$retail 		= -($detail['packaging_retail']);
			$box 			= -($detail['packaging_box'] * $detail['packaging_box_qty']);
			$stock_gudang 	= $box + $retail;

			if ($box) {
				//WHERE
				$where3['data'][] = array(
					'column' => 'item_detail_id',
					'param'	 => $detail['item_detail_id']
				);
				//WHERE
				$where3['data'][] = array(
					'column' => 'warehouse_id',
					'param'	 => 1
				);
				//WHERE
				$where3['data'][] = array(
					'column' => 'package_id',
					'param'	 => 1
				);

				$query_box = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where3);
				if ($query_box<>false) {
					$where4 = 'and warehouse_id = 1 and package_id = 1';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',-$box,$detail['item_detail_id'],$where4);
				}else{
					$data_box['item_detail_id'] 	= $detail['item_detail_id'];
					$data_box['warehouse_id'] 		= 1;
					$data_box['stock_qty'] 			= $box;
					$data_box['package_id'] 		= 1;

					$this->g_mod->insert_data_table('stocks', NULL, $data_box);
				}
			}

			if ($retail) {
				//WHERE
				$where5['data'][] = array(
					'column' => 'item_detail_id',
					'param'	 => $detail['item_detail_id']
				);
				//WHERE
				$where5['data'][] = array(
					'column' => 'warehouse_id',
					'param'	 => 1
				);
				//WHERE
				$where5['data'][] = array(
					'column' => 'package_id',
					'param'	 => 2
				);

				$query_retail = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where5);
				if ($query_retail<>false) {
					$where6 = 'and warehouse_id = 1 and package_id = 2';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',-$retail,$detail['item_detail_id'],$where6);
				}else{
					$data_retail['item_detail_id'] 		= $detail['item_detail_id'];
					$data_retail['warehouse_id'] 		= 1;
					$data_retail['stock_qty'] 			= $retail;
					$data_retail['package_id'] 			= 2;

					$this->g_mod->insert_data_table('stocks', NULL, $data_retail);
				}
			}

			$where7 = 'and warehouse_id = 1 and package_id = 0';
			$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$stock_gudang,$detail['item_detail_id'],$where7);


		//WHERE
		$where['data'][] = array(
			'column' => 'packaging_detail_item_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('packaging_detail_items', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_packaging(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(packaging_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(packaging_code,1,8)',
			'param'	 => 'PC'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'packaging_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('PC',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		if (!$id) {
			$data['packaging_code'] 		= $this->get_code_packaging();
		}


		/*$item = $this->input->post('i_item');
		if ($item) {
			$data['item_id'] 		= $item;
		}

		$item_half = $this->input->post('i_item_half');
		if ($item_half) {
			$data['item_id'] 		= $item_half;
		}*/
		
		$data['packaging_date'] 			= $this->format_date_day_mid($this->input->post('i_date'));
		/*$data['item_detail_id'] 			= $this->input->post('i_item_detail');
		$data['packaging_box'] 				= $this->input->post('i_dos');
		$data['packaging_box_qty'] 			= $this->input->post('i_dos_qty');
		$data['packaging_retail'] 			= $this->input->post('i_retail');*/

		/*$data = array(
			'vehicle_id' 		=> $this->input->post('i_vehicle'),
			'packaging_nominal' 	=> $this->input->post('i_nominal', TRUE),
			'machine_id' 		=> $this->input->post('i_machine'),
			'packaging_date' 		=> $this->format_date_day_mid($this->input->post('i_date', TRUE)),
			'packaging_desc' 		=> $this->input->post('i_date', TRUE)
			);*/
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'packaging_id' 				=> $this->input->post('i_id', TRUE),
			'package_id' 				=> $this->input->post('i_package', TRUE),
			'packaging_detail_qty' 		=> $this->input->post('i_qty_detail', TRUE),
			'user_id' 					=> $this->user_id
			);
			

		return $data;
	}

	function general_post_data_detail_item($id){



		$data = array(
			'packaging_id' 			=> $this->input->post('i_id', TRUE),
			'item_id' 				=> $this->input->post('i_item', TRUE),
			'item_detail_id' 		=> $this->input->post('i_item_detail', TRUE),
			'packaging_box' 		=> $this->input->post('i_qty_per_dos', TRUE),
			'packaging_box_qty' 	=> $this->input->post('i_qty_dos', TRUE),
			'packaging_retail' 		=> $this->input->post('i_qty_retail', TRUE),
			'user_id' 				=> $this->user_id
		);
			
		/*if ($id) {
			$detail = $this->g_mod->read_data('*','packaging_detail_items','packaging_detail_item_id',$id);

			$retail_new 		= $data['packaging_retail'];
			$box_new 			= $data['packaging_box'] * $data['packaging_box_qty'];

			$retail_old 		= $detail['packaging_retail'];
			$box_old 			= $detail['packaging_box'] * $detail['packaging_box_qty'];

			$retail 		= $retail_new - $retail_old;
			$box 			= $box_new - $box_old;
			$stock_gudang 	= $box + $retail;
		}else{

			$retail = $data['packaging_retail'];
			$box 	= $data['packaging_box'] * $data['packaging_box_qty'];
			$stock_gudang 	= $box + $retail;
		}


			if ($box) {
				//WHERE
				$where3['data'][] = array(
					'column' => 'item_detail_id',
					'param'	 => $data['item_detail_id']
				);
				//WHERE
				$where3['data'][] = array(
					'column' => 'warehouse_id',
					'param'	 => 1
				);
				//WHERE
				$where3['data'][] = array(
					'column' => 'package_id',
					'param'	 => 1
				);

				$query_box = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where3);
				if ($query_box<>false) {
					$where4 = 'and warehouse_id = 1 and package_id = 1';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',-$box,$data['item_detail_id'],$where4);
				}else{
					$data_box['item_detail_id'] 	= $data['item_detail_id'];
					$data_box['warehouse_id'] 		= 1;
					$data_box['stock_qty'] 			= $box;
					$data_box['package_id'] 		= 1;

					$this->g_mod->insert_data_table('stocks', NULL, $data_box);
				}
			}

			if ($retail) {
				//WHERE
				$where5['data'][] = array(
					'column' => 'item_detail_id',
					'param'	 => $data['item_detail_id']
				);
				//WHERE
				$where5['data'][] = array(
					'column' => 'warehouse_id',
					'param'	 => 1
				);
				//WHERE
				$where5['data'][] = array(
					'column' => 'package_id',
					'param'	 => 2
				);

				$query_retail = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where5);
				if ($query_retail<>false) {
					$where6 = 'and warehouse_id = 1 and package_id = 2';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',-$retail,$data['item_detail_id'],$where6);
				}else{
					$data_retail['item_detail_id'] 		= $data['item_detail_id'];
					$data_retail['warehouse_id'] 		= 1;
					$data_retail['stock_qty'] 			= $retail;
					$data_retail['package_id'] 			= 2;

					$this->g_mod->insert_data_table('stocks', NULL, $data_retail);
				}
			}

			$where7 = 'and warehouse_id = 1 and package_id = 0';
			$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$stock_gudang,$data['item_detail_id'],$where7);
*/
		return $data;
	}

	public function load_data_select_packaging(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'packaging_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'packaging_code',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->packaging_id,
					'text'	=> $val->packaging_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function read_stock(){

		$id = $this->input->post('id');

		//echo $id;
		//WHERE
		$where['data'][] = array(
			'column' => 'item_detail_id',
			'param'	 => $id
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'warehouse_id',
			'param'	 => 1
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'package_id',
			'param'	 => 0
		);

		$query_stock = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where);
		if ($query_stock<>false) {
			foreach ($query_stock->result() as $val) {
				$response['stock'] = $val->stock_qty;
			}
		}else{
			$response['stock'] = 0;
		}
		

		echo json_encode($response);
	}

	public function load_data_select_code(){
		
		$where_like['data'][] = array(
			'column' => 'packaging_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'packaging_id',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','packagings',NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->packaging_id,
					'text'	=> $val->packaging_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
		
	}

	public function action_data_lock(){
		$data['packaging_lock'] = 1;

		$where['data'][] = array(
			'column' => 'packaging_id',
			'param'	 => $this->input->post('i_id')
		);
		$update = $this->g_mod->update_data_table('packagings', $where, $data);

		if($update->status) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function action_data_request(){
		$data['packaging_request'] = 1;

		$where['data'][] = array(
			'column' => 'packaging_id',
			'param'	 => $this->input->post('i_id')
		);
		$update = $this->g_mod->update_data_table('packagings', $where, $data);

		if($update->status) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	/* end Function */

}
