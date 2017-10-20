<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_kongsi extends MY_Controller {
	private $any_error = array();
	public $tbl = 'invoice_kongsis';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();
        $this->load->library('PdfGenerator');

        $akses = $this->g_mod->get_user_acces($this->user_id,82);
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
			'title_page' 	=> 'Transaction / Invoice-Kongsi',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('invoice_kongsi_v', $data);
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
		$tbl = 'invoice_kongsis a';
		$select = 'a.*,b.kongsi_name,b.kongsi_store';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'invoice_kongsi_code,kongsi_name',
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
			'table' => 'kongsis b',
			'join'	=> 'b.kongsi_id=a.kongsi_id',
			'type'	=> 'inner'
		);

		//JOIN
		


		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->invoice_kongsi_id>0) {
					$response['data'][] = array(
						$val->invoice_kongsi_code,
						$val->kongsi_name.'-'.$val->kongsi_store,
						$val->invoice_kongsi_date,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->invoice_kongsi_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->invoice_kongsi_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'invoice_kongsi_details a';
		$select = 'a.*,c.item_name,b.order_kongsi_detail_qty,b.order_kongsi_detail_price,g.*';
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
			'column' => 'a.invoice_kongsi_id',
			'param'	 => $id
		);

		$join['data'][] = array(
			'table' => 'order_kongsi_details b',
			'join'	=> 'b.order_kongsi_detail_id =a.order_kongsi_detail_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id = b.item_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'set_branch_details e',
			'join'	=> 'e.order_kongsi_detail_id = b.order_kongsi_detail_id',
			'type'	=> 'LEFT'
		);

		$join['data'][] = array(
			'table' => 'set_detail_branch f',
			'join'	=> 'f.set_branch_detail_id = e.set_branch_detail_id',
			'type'	=> 'LEFT'
		);

		$join['data'][] = array(
			'table' => 'report_spg_details g',
			'join'	=> 'g.set_detail_branch_id = f.set_detail_branch_id',
			'type'	=> 'LEFT'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->invoice_kongsi_detail_id>0) {
					$laku = $val->report_spg_detail_date1+$val->report_spg_detail_date2+$val->report_spg_detail_date3+$val->report_spg_detail_date4+$val->report_spg_detail_date5+$val->report_spg_detail_date6+$val->report_spg_detail_date7+$val->report_spg_detail_date8+$val->report_spg_detail_date9+$val->report_spg_detail_date10+$val->report_spg_detail_date11+$val->report_spg_detail_date12+$val->report_spg_detail_date13+$val->report_spg_detail_date14+$val->report_spg_detail_date15+$val->report_spg_detail_date16+$val->report_spg_detail_date17+$val->report_spg_detail_date18+$val->report_spg_detail_date19+$val->report_spg_detail_date20+$val->report_spg_detail_date21+$val->report_spg_detail_date22+$val->report_spg_detail_date23+$val->report_spg_detail_date24+$val->report_spg_detail_date25+$val->report_spg_detail_date26+$val->report_spg_detail_date27+$val->report_spg_detail_date28+$val->report_spg_detail_date29+$val->report_spg_detail_date30+$val->report_spg_detail_date31;
					$response['data'][] = array(
						$val->item_name,
						$val->order_kongsi_detail_qty,
						$laku,
						'<input type="number" style="border: none; text-align: right;" class="form-control money" value="'.$val->invoice_kongsi_detail_qty_print.'" onchange="update_qty_print('.$val->invoice_kongsi_detail_id.')" name="i_qty<?='.$val->invoice_kongsi_detail_id.'?>" id="i_qty<?='.$val->invoice_kongsi_detail_id.'?>">
						<input type="hidden" class="form-control money" value="'.$val->invoice_kongsi_detail_id.'" name="i_detail_id<?='.$val->invoice_kongsi_detail_id.'?>" id="i_detail_id<?='.$val->invoice_kongsi_detail_id.'?>">',
						$val->order_kongsi_detail_price,
						'<input type="number" style="border: none; text-align: right;" class="form-control money" value="'.$val->invoice_kongsi_detail_discount.'" onchange="update_discount('.$val->invoice_kongsi_detail_id.')" name="i_discount<?='.$val->invoice_kongsi_detail_id.'?>" id="i_discount<?='.$val->invoice_kongsi_detail_id.'?>">',
						$laku*$val->order_kongsi_detail_price,
						//'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->invoice_kongsi_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->invoice_kongsi_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
			$response['id2'] = $val->invoice_kongsi_detail_id;
		}

		echo json_encode($response);
	}


	public function load_data_where(){
		$select = 'a.*,b.kongsi_name';
		$tbl = 'invoice_kongsis a';
		//JOIN
		$join['data'][] = array(
			'table' => 'kongsis b',
			'join'	=> 'b.kongsi_id=a.kongsi_id',
			'type'	=> 'inner'
		);
		//JOIN
		

		//WHERE
		$where['data'][] = array(
			'column' => 'invoice_kongsi_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$response['val'][] = array(
					'invoice_kongsi_id'			=> $val->invoice_kongsi_id,
					'invoice_kongsi_date' 		=> $this->format_date_day_mid2($val->invoice_kongsi_date),
					'kongsi_id' 		=> $val->kongsi_id,
					'kongsi_name' 	=> $val->kongsi_name,
					'invoice_kongsi_discount' 	=> $val->invoice_kongsi_discount,
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
				'column' => 'invoice_kongsi_id',
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
			//echo $data['invoice_kongsi_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			$id = $insert->output;
			$id2 = $data['kongsi_id'];
			$this->general_post_data_detail($id,$id2);
			$data2['invoice_kongsi_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'invoice_kongsi_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('invoice_kongsi_details', $where2, $data2);
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

	public function update_qty_print($id){
		$id2 = $this->input->post('i_detail_id<?='.$id.'?>');

			//UPDATE
			$data['invoice_kongsi_detail_qty_print'] = $this->input->post('i_qty<?='.$id.'?>');
			
			//WHERE
			$where['data'][] = array(
				'column' => 'invoice_kongsi_detail_id',
				'param'	 => $this->input->post('i_detail_id<?='.$id.'?>')
			);
			$update = $this->g_mod->update_data_table('invoice_kongsi_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
				$response['id'] = $id2;
			} else {
				$response['status'] = '204';
			}

		
		
		echo json_encode($response);
	}

	public function update_discount($id){
		$id2 = $this->input->post('i_detail_id<?='.$id.'?>');

			//UPDATE
			$data['invoice_kongsi_detail_discount'] = $this->input->post('i_discount<?='.$id.'?>');
			
			//WHERE
			$where['data'][] = array(
				'column' => 'invoice_kongsi_detail_id',
				'param'	 => $this->input->post('i_detail_id<?='.$id.'?>')
			);
			$update = $this->g_mod->update_data_table('invoice_kongsi_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
				$response['id'] = $id2;
			} else {
				$response['status'] = '204';
			}

		
		
		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'invoice_kongsi_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl, $where);
		$delete = $this->g_mod->delete_data_table('invoice_kongsi_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	/*public function delete_data_detail(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'invoice_kongsi_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('invoice_kongsi_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}*/

	function get_code_invoice_kongsi(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(invoice_kongsi_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(invoice_kongsi_code,1,8)',
			'param'	 => 'NT'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'invoice_kongsi_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('NT',$query);
		return $new_code;
	}

	function general_post_data($id){

		if (!$id) {
			$data['invoice_kongsi_code'] 		= $this->get_code_invoice_kongsi();
		}

		$data['kongsi_id'] 	= $this->input->post('i_kongsi', TRUE);
		//$data['spg_id'] 		= $this->input->post('i_spg', TRUE);
		$data['invoice_kongsi_date'] 		= $this->format_date_day_mid($this->input->post('i_date', TRUE));
			

		return $data;
	}

	function general_post_data_detail($id,$id2){

		$sql = "SELECT d.item_name,c.order_kongsi_detail_qty,c.order_kongsi_detail_id,f.set_detail_branch_qty,c.order_kongsi_detail_price 
				FROM kongsis a LEFT JOIN order_kongsis b ON b.kongsi_id = a.kongsi_id 
				LEFT JOIN order_kongsi_details c ON c.order_kongsi_id = b.order_kongsi_id 
				LEFT JOIN items d ON d.item_id = c.item_id 
				LEFT JOIN set_branch_details e ON e.order_kongsi_detail_id = c.order_kongsi_detail_id 
				LEFT JOIN set_detail_branch f ON f.set_branch_detail_id = e.set_branch_detail_id
				/*LEFT */JOIN report_spg_details g ON g.set_detail_branch_id = f.set_detail_branch_id 
				WHERE a.kongsi_id =$id2";
		$query = $this->g_mod->select_manual_for($sql);
		foreach ($query->result() as $val) {

				$data = array(
					'invoice_kongsi_id' 				=> $id,
					'order_kongsi_detail_id' 				=> $val->order_kongsi_detail_id,
					'user_id' 				=> $this->user_id
				);

				$insert = $this->g_mod->insert_data_table('invoice_kongsi_details', NULL, $data);
			}
		
			

		return $data;
	}
	
	public function load_data_select_invoice_kongsi($id = 0){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'invoice_kongsi_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'invoice_kongsi_code',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'invoice_kongsi_status',
			'param'	 => 0
		);
		if ($id) {
			$where['data'][] = array(
				'column' => 'kongsi_id',
				'param'	 => $id
			);
		}

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->invoice_kongsi_id,
					'text'	=> $val->invoice_kongsi_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_invoice_kongsi_detail($id = 0){

		$select = 'a.*,b.item_name,c.item_detail_color';
		$tbl = 'invoice_kongsi_details a';
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_detail_color',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'item_name',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'invoice_kongsi_id',
			'param'	 => $id
		);
		
		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details c',
			'join'	=> 'c.item_detail_id=a.item_detail_id',
			'type'	=> 'inner'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->invoice_kongsi_detail_id,
					'text'	=> $val->item_name.'-'.$val->item_detail_color
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function get_grand_total(){

		$id = $this->input->get('id');

		$select = 'a.*,b.order_kongsi_detail_qty,b.order_kongsi_detail_price,g.*';
		$tbl = 'invoice_kongsi_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'invoice_kongsi_id',
			'param'	 => $this->input->get('id')
		);

		$join['data'][] = array(
			'table' => 'order_kongsi_details b',
			'join'	=> 'b.order_kongsi_detail_id =a.order_kongsi_detail_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'items c',
			'join'	=> 'c.item_id = b.item_id',
			'type'	=> 'inner'
		);

		$join['data'][] = array(
			'table' => 'set_branch_details e',
			'join'	=> 'e.order_kongsi_detail_id = b.order_kongsi_detail_id',
			'type'	=> 'LEFT'
		);

		$join['data'][] = array(
			'table' => 'set_detail_branch f',
			'join'	=> 'f.set_branch_detail_id = e.set_branch_detail_id',
			'type'	=> 'LEFT'
		);

		$join['data'][] = array(
			'table' => 'report_spg_details g',
			'join'	=> 'g.set_detail_branch_id = f.set_detail_branch_id',
			'type'	=> 'LEFT'
		);
		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$total = 0;
		$discounts = 0;
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$laku = $val->report_spg_detail_date1+$val->report_spg_detail_date2+$val->report_spg_detail_date3+$val->report_spg_detail_date4+$val->report_spg_detail_date5+$val->report_spg_detail_date6+$val->report_spg_detail_date7+$val->report_spg_detail_date8+$val->report_spg_detail_date9+$val->report_spg_detail_date10+$val->report_spg_detail_date11+$val->report_spg_detail_date12+$val->report_spg_detail_date13+$val->report_spg_detail_date14+$val->report_spg_detail_date15+$val->report_spg_detail_date16+$val->report_spg_detail_date17+$val->report_spg_detail_date18+$val->report_spg_detail_date19+$val->report_spg_detail_date20+$val->report_spg_detail_date21+$val->report_spg_detail_date22+$val->report_spg_detail_date23+$val->report_spg_detail_date24+$val->report_spg_detail_date25+$val->report_spg_detail_date26+$val->report_spg_detail_date27+$val->report_spg_detail_date28+$val->report_spg_detail_date29+$val->report_spg_detail_date30+$val->report_spg_detail_date31;
				$total 		+= $laku * $val->order_kongsi_detail_price;
				$discounts 	+= $laku * $val->order_kongsi_detail_price * $val->invoice_kongsi_detail_discount / 100;
			}
		}

		$sql ="SELECT a.* FROM invoice_kongsis a 
			   WHERE invoice_kongsi_id = $id";
		$result = $this->g_mod->select_manual($sql);

		$response['total_format'] 	= number_format($total);
		$response['diskon_format'] 	= number_format($discounts);
		$response['total'] 			= $total;
		$response['discounts'] 		= $discounts;
		$response['discount_global'] 		= $result['invoice_kongsi_discount'];

		echo json_encode($response);
	}

	public function get_discount(/*$id*/){
		
		$tbl = 'invoice_kongsi_discounts a';
		$select = 'a.*,c.discount_name';
		//WHERE
		$where['data'][] = array(
			'column' => 'invoice_kongsi_id',
			'param'	 => $this->input->get('id')
			//'param'	 => $id
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'discount_details b',
			'join'	=> 'b.discount_detail_id=a.discount_detail_id',
			'type'	=> 'inner'
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'discounts c',
			'join'	=> 'c.discount_id=b.discount_id',
			'type'	=> 'inner'
		);

		
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$response['data'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'discount_detail_value_format'		=> number_format($val->discount_detail_value),
					'discount_detail_value'		=> $val->discount_detail_value,
					'discount_name' 		=> $val->discount_name,
				);
			}

			echo json_encode($response);
		}
		//$this->load->view('invoice_kongsi_d', array('query' => $query));
	}

	function print_invoice_kongsi_pdf(){

		$id = $this->input->get('id');

		//WHERE
		$where['data'][] = array(
			'column' => 'invoice_kongsi_id',
			'param'	 => $id
		);
		$data['invoice_kongsi_print'] = 1;
		$update = $this->g_mod->update_data_table('invoice_kongsis', $where, $data);


		$sql ="SELECT a.*,b.kongsi_name,c.spg_name FROM invoice_kongsis a 
			   JOIN kongsis b ON b.kongsi_id = a.kongsi_id
			   JOIN spgs c ON c.spg_id = a.spg_id
			   WHERE invoice_kongsi_id = $id";

		
		$query = $this->g_mod->select_manual_for($sql);
		foreach ($query->result() as $row){ 
				$judul			= "invoice_kongsi PENJUALAN";
				$data = array(
					'invoice_kongsi_id' 		=> $row->invoice_kongsi_id,
					'invoice_kongsi_code' 		=> $row->invoice_kongsi_code,
					'kongsi_name' 				=> $row->kongsi_name,
					'spg_name' 				=> $row->spg_name,
					'invoice_kongsi_date' 				=> $row->invoice_kongsi_date,
					);
					
		}
		$data['title'] 	= $judul;

	    $html = $this->load->view('report/invoice_kongsi_report', $data, true);//SEND DATA TO VIEW
	    $paper = 'A4';
    	$orientation = 'portrait';
	    
	    $this->pdfgenerator->generate($html, str_replace(" ","_",$judul), $paper, $orientation);
	}

	function print_surat_jalan_pdf(){

		$id = $this->input->get('id');

		//WHERE
		$where['data'][] = array(
			'column' => 'invoice_kongsi_id',
			'param'	 => $id
		);
		$data['invoice_kongsi_sj'] = 1;
		$update = $this->g_mod->update_data_table('invoice_kongsis', $where, $data);

		$sql ="SELECT a.*,b.kongsi_name,c.spg_name FROM invoice_kongsis a 
			   JOIN kongsis b ON b.kongsi_id = a.kongsi_id
			   JOIN spgs c ON c.spg_id = a.spg_id
			   WHERE invoice_kongsi_id = $id";

		
		$query = $this->g_mod->select_manual_for($sql);
		foreach ($query->result() as $row){ 
				$judul			= "SURAT JALAN";
				$data = array(
					'invoice_kongsi_id' 		=> $row->invoice_kongsi_id,
					'invoice_kongsi_code' 		=> $row->invoice_kongsi_code,
					'kongsi_name' 				=> $row->kongsi_name,
					'spg_name' 				=> $row->spg_name,
					'invoice_kongsi_date' 				=> $row->invoice_kongsi_date,
					);
					
		}
		$data['title'] 	= $judul;

	    $html = $this->load->view('report/report_sj', $data, true);//SEND DATA TO VIEW
	    $paper = 'A4';
    	$orientation = 'portraitid';
	    
	    $this->pdfgenerator->generate($html, str_replace(" ","_",$judul), $paper, $orientation);
	}

	function update_discount2(){
		$id = $this->input->post('id');
		$value = $this->input->post('value');
			//UPDATE
		$data['invoice_kongsi_discount'] = $value;
			
		//WHERE
		$where['data'][] = array(
			'column' => 'invoice_kongsi_id',
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
		
		echo json_encode($response);
	}

	public function load_data_select_memo(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'memo_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'memo_code',
			'type'	 => 'ASC'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'memo_status',
			'param'	 => 0
		);

		$query = $this->g_mod->select('*','memos',NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->memo_id,
					'text'	=> $val->memo_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	/* end Function */

}
