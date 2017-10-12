<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_item extends MY_Controller {
	private $any_error = array();
	public $tbl = 'purchases';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,72);
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
			'title_page' 	=> 'Transaction / Pembelian / Barang',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('purchase_item_v', $data);
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
		$tbl = 'purchases a';
		$select = 'a.*,b.partner_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'purchase_code,partner_name',
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
			'table' => 'partners b',
			'join'	=> 'b.partner_id=a.partner_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'a.purchase_type',
			'param'	 => 1
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->purchase_id>0) {
					$response['data'][] = array(
						$val->purchase_code,
						$val->partner_name,
						$val->purchase_date,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->purchase_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->purchase_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,c.item_name as item_name,g.item_name as item_half_name,b.item_detail_color as item_detail_color,f.item_detail_color as item_half_detail_color,d.material_name,e.sperpart_name';
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
			'column' => 'a.purchase_id',
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

		$group = '';

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where,NULL,$group);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where,NULL,$group);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where,NULL,$group);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->purchase_detail_id>0) {

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
						$val->purchase_detail_id,
						$type,
						$ket,
						$val->purchase_detail_qty,
						$val->purchase_detail_discount,
						number_format($val->purchase_detail_price),
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->purchase_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->purchase_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.partner_name';
		$tbl = 'purchases a';
		//JOIN
		$join['data'][] = array(
			'table' => 'partners b',
			'join'	=> 'b.partner_id=a.partner_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$response['val'][] = array(
					'purchase_id'			=> $val->purchase_id,
					'purchase_date' 		=> $this->format_date_day_mid2($val->purchase_date),
					'partner_id' 			=> $val->partner_id,
					'partner_name' 			=> $val->partner_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,c.item_name as item_so_name,c.item_id as item_so_id,g.item_name as item_half_name,g.item_id as item_half_id,b.item_detail_color as item_so_detail_color,f.item_detail_color as item_half_detail_color,d.material_name,e.sperpart_name';
		$tbl = 'purchase_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'purchase_detail_id',
			'param'	 => $this->input->get('id')
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

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'purchase_detail_id'			=> $val->purchase_detail_id,
					'purchase_detail_data_id' 		=> $val->purchase_detail_data_id,
					'purchase_detail_qty' 			=> $val->purchase_detail_qty,
					'purchase_detail_discount' 		=> $val->purchase_detail_discount,
					'purchase_detail_price' 		=> $val->purchase_detail_price,
					'purchase_detail_type' 			=> $val->purchase_detail_type,
					'item_so_name' 					=> $val->item_so_name,
					'item_half_name' 				=> $val->item_half_name,
					'item_so_id' 					=> $val->item_so_id,
					'item_half_id' 					=> $val->item_half_id,
					'item_so_detail_color' 			=> $val->item_so_detail_color,
					'item_half_detail_color' 		=> $val->item_half_detail_color,
					'material_name' 				=> $val->material_name,
					'sperpart_name' 				=> $val->sperpart_name,
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
				'column' => 'purchase_id',
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
			//echo $data['purchase_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['purchase_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'purchase_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('purchase_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id'] = $insert->output;
			} else {
				$response['status'] = '204';
			}

			$new_id = $insert->output;
		}

		$memo_id = $this->input->post('i_memo');
		$arrlength_memo = count($memo_id);

		if ($memo_id) {
			//WHERE
			$where3['data'][] = array(
				'column' => 'purchase_id',
				'param'	 => $new_id
			);
			$this->g_mod->delete_data_table('purchase_memos',$where3);
			for($x = 0; $x < $arrlength_memo; $x++) {
				$data3['purchase_id'] 	= $new_id;
				$data3['memo_id'] 	= $memo_id[$x];
				$this->g_mod->insert_data_table('purchase_memos',NULL,$data3);

				$select2 = 'a.*';
				$tbl2 = 'memo_details a';
				//WHERE
				$where4['data'][] = array(
					'column' => 'memo_id',
					'param'	 => $memo_id[$x]
				);
				$data5['memo_status'] = 1;
				$update = $this->g_mod->update_data_table('memos', $where4, $data5);

				$query_memo = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,NULL,$where4);
				foreach ($query_memo->result() as $val2) {
					$data4['purchase_id'] 			= $new_id;
					$data4['item_id'] 			= $val2->item_id;
					$data4['item_detail_id'] 	= $val2->item_detail_id;
					$data4['purchase_detail_qty'] 	= $val2->memo_detail_qty;
					$data4['user_id'] 			= $this->user_id;

					$this->g_mod->insert_data_table('purchase_details', NULL, $data4);

					$where5 = 'and warehouse_id = 1 and package_id = 0';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$data4['purchase_detail_qty'],$data4['item_detail_id'],$where5);
				}
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
				'column' => 'purchase_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('purchase_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail();

			$insert = $this->g_mod->insert_data_table('purchase_details', NULL, $data);

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
			'column' => 'purchase_id',
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
			'column' => 'purchase_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('purchase_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_purchase(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(purchase_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(purchase_code,1,8)',
			'param'	 => 'PM'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'purchase_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('PM',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		/*$data = array(
			'customer_id' 	=> $this->input->post('i_customer', TRUE),
			'sales_id' 		=> $this->input->post('i_sales', TRUE),
			'purchase_date' 	=> $this->format_date_day_mid($this->input->post('i_date', TRUE))
			);*/
		if (!$id) {
			$data['purchase_code'] 		= $this->get_code_purchase();
		}

		$data['purchase_type'] 	= 1;
		$data['partner_id'] 	= $this->input->post('i_partner', TRUE);
		$data['purchase_date'] 		= $this->format_date_day_mid($this->input->post('i_date', TRUE));
			

		return $data;
	}

	function general_post_data_detail(){

		$item 		= $this->input->post('i_item_detail', TRUE);
		$material 	= $this->input->post('i_material', TRUE);
		$perpart 	= $this->input->post('i_sperpart', TRUE);

		if ($item) {
			$data_id = $item;
		}elseif ($material) {
			$data_id = $material;
		}elseif ($perpart) {
			$data_id = $perpart;
		}else{
			$data_id = 0;
		}

		$data = array(
			'purchase_id' 					=> $this->input->post('i_id', TRUE),
			'purchase_detail_data_id' 		=> $data_id,
			'purchase_detail_qty' 			=> $this->input->post('i_detail_qty', TRUE),
			'purchase_detail_discount' 		=> $this->input->post('i_detail_discount', TRUE),
			'purchase_detail_price' 		=> $this->input->post('i_detail_price', TRUE),
			'purchase_detail_type' 			=> $this->input->post('i_type', TRUE),
			'user_id' 						=> $this->user_id
			);
			

		return $data;
	}
	
	public function load_data_select_purchase(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'purchase_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'purchase_code',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->purchase_id,
					'text'	=> $val->purchase_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	/* end Function */

}
