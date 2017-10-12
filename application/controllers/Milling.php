<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Milling extends MY_Controller {
	private $any_error = array();
	public $tbl = 'millings';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,57);
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
			'title_page' 	=> 'Transaction / Penggilingan',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('milling_v', $data);
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
		$tbl = 'millings a';
		$select = 'a.*,b.employee_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'milling_code,milling_date,employee_name',
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
			'table' => 'employees b',
			'join'	=> 'b.employee_id=a.employee_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->milling_id>0) {
					$response['data'][] = array(
						$val->milling_code,
						$val->milling_date,
						$val->employee_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->milling_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->milling_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'milling_details a';
		$select = 'a.*,d.item_id,d.item_name,c.item_detail_color,e.material_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_detail_color,e.material_name',
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
			'column' => 'a.milling_id',
			'param'	 => $id
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details c',
			'join'	=> 'c.item_detail_id=a.item_detail_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'items d',
			'join'	=> 'd.item_id=c.item_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'materials e',
			'join'	=> 'e.material_id=a.material_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->milling_detail_id>0) {
					$response['data'][] = array(
						$val->item_name.'-'.$val->item_detail_color,
						$val->milling_detail_gs,
						$val->milling_detail_qty_gs,
						$val->milling_detail_result,
						$val->material_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->milling_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->milling_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.employee_name';
		$tbl = 'millings a';
		//JOIN
		$join['data'][] = array(
			'table' => 'employees b',
			'join'	=> 'b.employee_id=a.employee_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'milling_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'milling_id'			=> $val->milling_id,
					'milling_date' 		=> $this->format_date_day_mid2($val->milling_date),
					'employee_id' 			=> $val->employee_id,
					'employee_name' 		=> $val->employee_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,d.item_id,d.item_name,c.item_detail_color,e.material_name';
		$tbl = 'milling_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'milling_detail_id',
			'param'	 => $this->input->get('id')
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details c',
			'join'	=> 'c.item_detail_id=a.item_detail_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'items d',
			'join'	=> 'd.item_id=c.item_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'materials e',
			'join'	=> 'e.material_id=a.material_id',
			'type'	=> 'left'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'milling_detail_id'			=> $val->milling_detail_id,
					'item_id' 					=> $val->item_id,
					'item_name' 				=> $val->item_name,
					'item_detail_id' 			=> $val->item_detail_id,
					'item_detail_color' 		=> $val->item_detail_color,
					'material_id' 				=> $val->material_id,
					'material_name' 			=> $val->material_name,
					'milling_detail_gs' 		=> $val->milling_detail_gs,
					'milling_detail_qty_gs' 	=> $val->milling_detail_qty_gs,
					'milling_detail_result' 	=> $val->milling_detail_result,
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
				'column' => 'milling_id',
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
			//echo $data['milling_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['milling_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'milling_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('milling_details', $where2, $data2);

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
				'column' => 'milling_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('milling_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail();
			//echo $data['milling_img'];
			$insert = $this->g_mod->insert_data_table('milling_details', NULL, $data);
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
			'column' => 'milling_id',
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
			'column' => 'milling_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('milling_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_milling(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(milling_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(milling_code,1,8)',
			'param'	 => 'GL'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'milling_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('GL',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		/*$data = array(
			'customer_id' 	=> $this->input->post('i_customer', TRUE),
			'sales_id' 		=> $this->input->post('i_sales', TRUE),
			'milling_date' 	=> $this->format_date_day_mid($this->input->post('i_date', TRUE))
			);*/
		if (!$id) {
			$data['milling_code'] 		= $this->get_code_milling();
		}

		$data['employee_id'] 		= $this->input->post('i_employee', TRUE);
		$data['milling_date'] 		= $this->format_date_day_mid($this->input->post('i_date', TRUE));
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'milling_id' 					=> $this->input->post('i_id', TRUE),
			'item_detail_id' 				=> $this->input->post('i_item_detail', TRUE),
			'milling_detail_gs' 			=> $this->input->post('i_detail_gs', TRUE),
			'milling_detail_qty_gs' 		=> $this->input->post('i_detail_qty_gs', TRUE),
			'milling_detail_result' 		=> $this->input->post('i_detail_qty', TRUE),
			'material_id' 					=> $this->input->post('i_material', TRUE),
			'user_id' 						=> $this->user_id
			);
			

		return $data;
	}

	public function load_data_select_milling($customer_id = 0,$sales_id = 0){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'milling_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'milling_code',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'milling_status',
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
					'id'	=> $val->milling_id,
					'text'	=> $val->milling_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function get_gs(){
		//WHERE LIKE
		$id = $this->input->get('id');
		
		//WHERE
		$where['data'][] = array(
			'column' => 'item_detail_id',
			'param'	 => $id
		);

		$query = $this->g_mod->select('*','heaps',NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response = array(
					'heap_gs'	=> $val->heap_gs,
					'heap_bs'	=> $val->heap_bs
				);
			}
		}

		echo json_encode($response);
	}

	/* end Function */

}
