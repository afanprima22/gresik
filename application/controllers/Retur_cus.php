<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_cus extends MY_Controller {
	private $any_error = array();
	public $tbl = 'returs';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,58);
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
			'title_page' 	=> 'Transaction / Retur / Customer',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('retur_cus_v', $data);
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
		$tbl = 'returs a';
		$select = 'a.*,b.customer_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'retur_code,customer_name',
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
				if ($val->retur_id>0) {
					$response['data'][] = array(
						$val->retur_code,
						$val->retur_date,
						$val->customer_name,
						0,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->retur_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->retur_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'retur_details a';
		$select = 'a.*,b.nota_detail_qty,c.item_name,f.item_detail_color';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_detail_color,nota_detail_qty',
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
			'column' => 'a.retur_id',
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
			'table' => 'nota_details b',
			'join'	=> 'b.nota_detail_id =a.retur_detail_data_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=b.item_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details f',
			'join'	=> 'f.item_detail_id=b.item_detail_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->retur_detail_id>0) {

					$response['data'][] = array(
						$val->retur_detail_id,
						$val->item_name.'-'.$val->item_detail_color,
						$val->nota_detail_qty,
						number_format($val->retur_detail_price),
						$val->retur_detail_discount,
						$val->retur_detail_qty,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->retur_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->retur_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.customer_name,c.nota_code';
		$tbl = 'returs a';
		//JOIN
		$join['data'][] = array(
			'table' => 'customers b',
			'join'	=> 'b.customer_id=a.customer_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'notas c',
			'join'	=> 'c.nota_id=a.nota_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'retur_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$response['val'][] = array(
					'retur_id'			=> $val->retur_id,
					'retur_date' 		=> $this->format_date_day_mid2($val->retur_date),
					'customer_id' 			=> $val->customer_id,
					'customer_name' 			=> $val->customer_name,
					'nota_id' 			=> $val->nota_id,
					'nota_code' 			=> $val->nota_code,
					'retur_type' 			=> $val->retur_type,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.nota_detail_qty,c.item_name,f.item_detail_color';
		$tbl = 'retur_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'retur_detail_id',
			'param'	 => $this->input->get('id')
		);
		
		//JOIN
		$join['data'][] = array(
			'table' => 'nota_details b',
			'join'	=> 'b.nota_detail_id =a.retur_detail_data_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id=b.item_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details f',
			'join'	=> 'f.item_detail_id=b.item_detail_id',
			'type'	=> 'left'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'retur_detail_id'			=> $val->retur_detail_id,
					'retur_detail_data_id' 		=> $val->retur_detail_data_id,
					'retur_detail_qty' 			=> $val->retur_detail_qty,
					'retur_detail_discount' 	=> $val->retur_detail_discount,
					'retur_detail_price' 		=> $val->retur_detail_price,
					'nota_detail_qty' 			=> $val->nota_detail_qty,
					'retur_detail_item' 		=> $val->item_name.'-'.$val->item_detail_color
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
				'column' => 'retur_id',
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
			//echo $data['retur_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['retur_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'retur_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('retur_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id'] = $insert->output;
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
				'column' => 'retur_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('retur_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail();

			$insert = $this->g_mod->insert_data_table('retur_details', NULL, $data);

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
			'column' => 'retur_id',
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
			'column' => 'retur_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('retur_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_retur(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(retur_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(retur_code,1,8)',
			'param'	 => 'RT'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'retur_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('RT',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		/*$data = array(
			'customer_id' 	=> $this->input->post('i_customer', TRUE),
			'sales_id' 		=> $this->input->post('i_sales', TRUE),
			'retur_date' 	=> $this->format_date_day_mid($this->input->post('i_date', TRUE))
			);*/
		if (!$id) {
			$data['retur_code'] 		= $this->get_code_retur();
		}

		$data['customer_id'] 		= $this->input->post('i_customer', TRUE);
		$data['nota_id'] 			= $this->input->post('i_nota', TRUE);
		$data['retur_type'] 		= $this->input->post('i_type', TRUE);
		$data['retur_group'] 		= 1;
		$data['retur_date'] 		= $this->format_date_day_mid($this->input->post('i_date', TRUE));
			

		return $data;
	}

	function general_post_data_detail(){

		

		$data = array(
			'retur_id' 						=> $this->input->post('i_id', TRUE),
			'retur_detail_qty' 				=> $this->input->post('i_detail_qty', TRUE),
			'retur_detail_discount' 		=> $this->input->post('i_detail_discount', TRUE),
			'retur_detail_price' 			=> $this->input->post('i_detail_price', TRUE),
			'retur_detail_data_id' 			=> $this->input->post('i_nota_detail', TRUE),
			'user_id' 						=> $this->user_id
			);
			

		return $data;
	}
	
	public function load_data_select_retur(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'retur_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'retur_code',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->retur_id,
					'text'	=> $val->retur_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	/* end Function */

}
