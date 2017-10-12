<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_production extends MY_Controller {
	private $any_error = array();
	public $tbl = 'order_productions';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,65);
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
			'title_page' 	=> 'Transaksi / Order Produksi',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('order_production_v', $data);
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
		$tbl = 'order_productions a';
		$select = 'a.*,b.item_name,c.item_detail_color';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'order_production_code,item_name,item_detail_color',
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
			'table' => 'item_details c',
			'join'	=> 'c.item_detail_id=a.item_detail_id',
			'type'	=> 'left'
		);

		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->order_production_id>0) {

					if ($val->order_production_status == 0) {
						$status = 'Belum Diproses';
					}else{
						$status = 'Sudah Diproses';
					}

					$response['data'][] = array(
						$val->order_production_code,
						$val->order_production_date,
						$val->item_name,
						$val->item_detail_color,
						$val->order_production_qty,
						$status,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->order_production_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->order_production_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'order_productions a';

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
			'column' => 'order_production_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'order_production_id'				=> $val->order_production_id,
					'order_production_code' 			=> $val->order_production_code,
					'order_production_date' 			=> $this->format_date_day_mid2($val->order_production_date),
					'item_id' 				=> $val->item_id,
					'item_name' 			=> $val->item_name,
					'item_detail_id' 		=> $val->item_detail_id,
					'item_detail_color'		=> $val->item_detail_color,
					'order_production_qty' 			=> $val->order_production_qty,
					'item_status'			=> $val->item_status,
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
				'column' => 'order_production_id',
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
			//echo $data['order_production_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			
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


	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'order_production_id',
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

	function get_code_order_production(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(order_production_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(order_production_code,1,8)',
			'param'	 => 'OP'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'order_production_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('OP',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		if (!$id) {
			$data['order_production_code'] 		= $this->get_code_order_production();
		}

		$item = $this->input->post('i_item');
		if ($item) {
			$data['item_id'] 		= $item;
		}

		$item_half = $this->input->post('i_item_half');
		if ($item_half) {
			$data['item_id'] 		= $item_half;
		}
		
		$data['order_production_date'] 		= $this->format_date_day_mid($this->input->post('i_date'));
		$data['item_detail_id'] 			= $this->input->post('i_item_detail');
		$data['order_production_qty'] 		= $this->input->post('i_qty');

		return $data;
	}

	public function load_data_select_order_production(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'order_production_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'order_production_code',
			'type'	 => 'ASC'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'order_production_status',
			'param'	 => 0
		);


		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->order_production_id,
					'text'	=> $val->order_production_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
