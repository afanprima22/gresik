<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class receipt extends MY_Controller {
	private $any_error = array();
	public $tbl = 'receipts';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,59);
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
			'title_page' 	=> 'Transaction / Penerimaan',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('receipt_v', $data);
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
		$tbl = 'receipts a';
		$select = 'a.*,b.purchase_code';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'receipt_code,purchase_code,receipt_date',
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
			'table' => 'purchases b',
			'join'	=> 'b.purchase_id=a.purchase_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->receipt_id>0) {
					$response['data'][] = array(
						$val->receipt_code,
						$val->purchase_code,
						$val->receipt_date,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->receipt_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->receipt_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'purchase_details a';
		$select = 'a.*,c.item_name as item_name,g.item_name as item_half_name,b.item_detail_color as item_detail_color,f.item_detail_color as item_half_detail_color,d.material_name,e.sperpart_name,h.receipt_detail_sj,h.receipt_detail_cancel,h.receipt_detail_come,h.receipt_detail_id';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'c.item_name,b.item_detail_color,g.item_name,f.item_detail_color,d.material_name,e.sperpart_name',
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
			'column' => 'h.receipt_id',
			'param'	 => $id
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details b',
			'join'	=> 'b.item_detail_id=a.purchase_detail_data_id and purchase_detail_type = 1',
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
			'join'	=> 'f.item_detail_id=a.purchase_detail_data_id and purchase_detail_type = 2',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'items g',
			'join'	=> 'g.item_id=f.item_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'materials d',
			'join'	=> 'd.material_id=a.purchase_detail_data_id and purchase_detail_type = 4',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'sperparts e',
			'join'	=> 'e.sperpart_id=a.purchase_detail_data_id and purchase_detail_type = 3',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'receipt_details h',
			'join'	=> 'h.purchase_detail_id=a.purchase_detail_id',
			'type'	=> 'join'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->receipt_detail_id>0) {

					if ($val->purchase_detail_type == 1 || $val->purchase_detail_type == 2) {
						
						if ($val->purchase_detail_type == 1) {
							$type = 'Barang Jadi';
							$ket = $val->item_name.' - '.$val->item_detail_color;
						}else{
							$type = 'Barang Setengah Jadi';
							$ket = $val->item_half_name.' - '.$val->item_half_detail_color;
						}
						
					}elseif ($val->purchase_detail_type == 4) {
						$ket = $val->material_name;
						$type = 'Material';
					}elseif ($val->purchase_detail_type == 3) {
						$ket = $val->sperpart_name;
						$type = 'Sperpart';
					}

					$response['data'][] = array(
						$type,
						$ket,
						$val->purchase_detail_qty,
						$val->purchase_detail_discount,
						number_format($val->purchase_detail_price),
						'<input type="text" class="form-control" name="i_detail_come" value="'.$val->receipt_detail_come.'" onchange="save_detail(this.value,'.$val->receipt_detail_id.',1)">',
						'<input type="text" class="form-control" name="i_detail_cancel" value="'.$val->receipt_detail_cancel.'" onchange="save_detail(this.value,'.$val->receipt_detail_id.',2)">',
						'<input type="text" class="form-control" name="i_detail_sj" value="'.$val->receipt_detail_sj.'" placeholder="Surat Jalan" onchange="save_detail(this.value,'.$val->receipt_detail_id.',3)">'
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
		$select = 'a.*,b.purchase_code';
		$tbl = 'receipts a';
		//JOIN
		$join['data'][] = array(
			'table' => 'purchases b',
			'join'	=> 'b.purchase_id=a.purchase_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'receipt_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$response['val'][] = array(
					'receipt_id'			=> $val->receipt_id,
					'receipt_date' 		=> $this->format_date_day_mid2($val->receipt_date),
					'purchase_id' 		=> $val->purchase_id,
					'purchase_code' 	=> $val->purchase_code
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
				'column' => 'receipt_id',
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
			//echo $data['purchase_id'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id'] = $insert->output;
			} else {
				$response['status'] = '204';
			}

			$new_id = $insert->output;

			$where4['data'][] = array(
				'column' => 'purchase_id',
				'param'	 => $data['purchase_id']
			);
			$query_detail = $this->g_mod->select('*','purchase_details',NULL,NULL,NULL,NULL,$where4);
			foreach ($query_detail->result() as $val2) {
				$data4['receipt_id'] 			= $new_id;
				$data4['purchase_detail_id'] 	= $val2->purchase_detail_id;

				$this->g_mod->insert_data_table('receipt_details', NULL, $data4);
				
			}
		}

		echo json_encode($response);
	}

	public function action_data_detail(){
		$id 		= $this->input->post('detail_id');
		$value 		= $this->input->post('value');
		$type 		= $this->input->post('type');

		if ($type == 1) {
			$data['receipt_detail_come'] = $value;
		}elseif ($type == 2) {
			$data['receipt_detail_cancel'] = $value;
		}else{
			$data['receipt_detail_sj'] = $value;
		}

			//WHERE
			$where['data'][] = array(
				'column' => 'receipt_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('receipt_details', $where, $data);
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
			'column' => 'receipt_id',
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
			'column' => 'receipt_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('receipt_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_receipt(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(receipt_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(receipt_code,1,8)',
			'param'	 => 'RC'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'receipt_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('RC',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		/*$data = array(
			'customer_id' 	=> $this->input->post('i_customer', TRUE),
			'sales_id' 		=> $this->input->post('i_sales', TRUE),
			'receipt_date' 	=> $this->format_date_day_mid($this->input->post('i_date', TRUE))
			);*/
		if (!$id) {
			$data['receipt_code'] 		= $this->get_code_receipt();
		}

		$data['purchase_id'] 		= $this->input->post('i_purchase', TRUE);
		$data['receipt_date'] 		= $this->format_date_day_mid($this->input->post('i_date', TRUE));
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'receipt_id' 				=> $this->input->post('i_id', TRUE),
			'item_id' 				=> $this->input->post('i_item', TRUE),
			'item_detail_id' 		=> $this->input->post('i_item_detail', TRUE),
			'receipt_detail_qty' 		=> $this->input->post('i_detail_qty', TRUE),
			'user_id' 				=> $this->user_id
			);
			

		return $data;
	}
	
	public function load_data_select_receipt(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'receipt_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'receipt_code',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'receipt_status',
			'param'	 => 0
		);
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->receipt_id,
					'text'	=> $val->receipt_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	/* end Function */

}
