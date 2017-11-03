<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_half extends MY_Controller {
	private $any_error = array();
	public $tbl = 'items';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,42);
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
			'title_page' 	=> 'Master Data / Barang Setengah Jadi',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('item_half_v', $data);
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
		$tbl = 'items a';
		$select = 'a.*,b.item_type_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_weight,item_type_name,item_netto',
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
			'param'	 => 2
		);

		$where['data'][] = array(
			'column' => 'a.item_type_id',
			'param'	 => 2
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
						$val->item_weight,
						$val->item_type_name,
						number_format($val->item_netto),
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->item_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->item_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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

	public function load_data_lagistar(){
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
			'column' => 'item_name,item_weight,item_type_name,item_netto',
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
			'type'	=> 'left'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'item_status',
			'param'	 => 2
		);

		$where['data'][] = array(
			'column' => 'a.item_type_id',
			'param'	 => 1
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
						$val->item_weight,
						$val->item_type_name,
						number_format($val->item_netto),
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->item_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->item_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
					);
					$no++;	
				}
				$response['item_type_name'] = $val->item_type_id;
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

	public function load_data_color($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'item_details';
		$select = '*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_detail_color',
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
			'column' => 'item_id',
			'param'	 => $id
		);

		if (!$id) {
			//WHERE
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
				if ($val->item_detail_id>0) {
					$response['data'][] = array(
						$val->item_detail_id,
						$val->item_detail_color,
						$val->item_detail_min,
						$val->item_detail_max,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_color('.$val->item_detail_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_color('.$val->item_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_formula('.$val->item_detail_id.')"><i class="glyphicon glyphicon-list"></i></a>'
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

	public function load_data_formula($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'item_formulas a';
		$select = 'a.*,b.material_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'material_name,item_formula_qty',
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
			'column' => 'item_detail_id',
			'param'	 => $id
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'materials b',
			'join'	=> 'b.material_id=a.material_id',
			'type'	=> 'inner'
		);


		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->item_formula_id>0) {
					$response['data'][] = array(
						$val->item_formula_id,
						$val->material_name,
						$val->item_formula_qty,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_formula('.$val->item_formula_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_formula('.$val->item_formula_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.item_type_name,c.material_type_name,e.unit_name';
		$tbl = 'items a';
		//JOIN
		$join['data'][] = array(
			'table' => 'item_types b',
			'join'	=> 'b.item_type_id=a.item_type_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'material_types c',
			'join'	=> 'c.material_type_id=a.material_type_id',
			'type'	=> 'left'
		);
		$join['data'][] = array(
			'table' => 'units e',
			'join'	=> 'e.unit_id=a.unit_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'item_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'item_id'			=> $val->item_id,
					'item_code' 		=> $val->item_code,
					'item_name' 		=> $val->item_name,
					'item_weight' 		=> $val->item_weight,
					'item_weight_rn' 	=> $val->item_weight_rn,
					'item_type_id' 		=> $val->item_type_id,
					'item_per_unit' 		=> $val->item_per_unit,
					'item_type_name' 	=> $val->item_type_name,
					'item_price1' 		=> $val->item_price1,
					'item_price2'		=> $val->item_price2,
					'item_netto' 		=> $val->item_netto,
					'item_cost' 		=> $val->item_cost,
					'item_stock' 		=> $val->item_stock,
					'item_type' 		=> $val->item_type,
					'material_type_id' 		=> $val->material_type_id,
					'material_type_name' 	=> $val->material_type_name,
					'unit_id' 				=> $val->unit_id,
					'unit_name' 			=> $val->unit_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_color(){
		$select = 'a.*';
		$tbl = 'item_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'item_detail_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'item_detail_id'		=> $val->item_detail_id,
					'item_detail_color' 	=> $val->item_detail_color,
					'item_detail_min' 		=> $val->item_detail_min,
					'item_detail_max' 		=> $val->item_detail_max,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_formula(){
		$select = 'a.*,b.material_name';
		$tbl = 'item_formulas a';
		//WHERE
		$where['data'][] = array(
			'column' => 'item_formula_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'materials b',
			'join'	=> 'b.material_id=a.material_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'item_formula_id'		=> $val->item_formula_id,
					'item_formula_qty' 		=> $val->item_formula_qty,
					'item_detail_id' 		=> $val->item_detail_id,
					'material_id' 			=> $val->material_id,
					'material_name' 		=> $val->material_name,
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
				'column' => 'item_id',
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
			//echo $data['item_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['item_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'item_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('item_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_color(){
		$id = $this->input->post('i_color_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_color();
			//WHERE
			$where['data'][] = array(
				'column' => 'item_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('item_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_color();
			//echo $data['item_img'];
			$insert = $this->g_mod->insert_data_table('item_details', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_formula(){
		$id = $this->input->post('i_formula_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_formula();
			//WHERE
			$where['data'][] = array(
				'column' => 'item_formula_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('item_formulas', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
				$response['id'] = $data['item_detail_id'];
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_formula();
			//echo $data['item_img'];
			$insert = $this->g_mod->insert_data_table('item_formulas', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id'] = $data['item_detail_id'];
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
			'column' => 'item_id',
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

	public function delete_data_color(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'item_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('item_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_formula(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'item_formula_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('item_formulas', $where);
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

		$data = array(
			'item_code' 		=> $this->input->post('i_code', TRUE),
			'item_name' 		=> $this->input->post('i_name', TRUE),
			'item_weight' 		=> $this->input->post('i_weight', TRUE),
			'item_weight_rn' 	=> $this->input->post('i_weight_rn', TRUE),
			'item_type_id' 		=> $this->input->post('i_type', TRUE),
			'item_per_unit' 		=> $this->input->post('i_qty_per_unit', TRUE),
			'unit_id' 			=> $this->input->post('i_unit', TRUE),
			'item_price1' 		=> $this->input->post('i_price1', TRUE),
			'item_price2' 		=> $this->input->post('i_price2', TRUE),
			'item_netto' 		=> $this->input->post('i_netto', TRUE),
			'item_cost' 		=> $this->input->post('i_cost', TRUE),
			'item_stock' 		=> $this->input->post('i_stock', TRUE),
			'item_type' 		=> $this->input->post('i_status', TRUE),
			'material_type_id' 	=> $this->input->post('i_material_type', TRUE),
			'item_status' 		=> 2
			);
			

		return $data;
	}

	function general_post_data_color(){

		$data = array(
			'item_id' 				=> $this->input->post('i_id', TRUE),
			'item_detail_color' 	=> $this->input->post('i_color', TRUE),
			'item_detail_min' 		=> $this->input->post('i_dos_min', TRUE),
			'item_detail_max' 		=> $this->input->post('i_dos_max', TRUE),
			'user_id' 				=> $this->user_id
			);
			

		return $data;
	}

	function general_post_data_formula(){

		$data = array(
			'item_formula_qty' 		=> $this->input->post('i_qty_formula', TRUE),
			'item_detail_id' 		=> $this->input->post('i_detail_id', TRUE),
			'material_id' 			=> $this->input->post('i_material', TRUE)
			);
			

		return $data;
	}

	public function load_data_select_type(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_type_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'item_type_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','item_types',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->item_type_id,
					'text'	=> $val->item_type_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_item_half(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'item_name',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'item_status',
			'param'	 => 2
		);
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->item_id,
					'text'	=> $val->item_code.'-'.$val->item_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
