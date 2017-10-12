<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_v2 extends MY_Controller {
	private $any_error = array();
	public $tbl = 'production_new';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,61);
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
			'title_page' 	=> 'Transaction / Produksi V2',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('production_v2_v', $data);
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
		$tbl = 'production_new a';
		$select = 'a.*,b.production_sift_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'production_new_code,production_sift_name',
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
			'table' => 'production_sifts b',
			'join'	=> 'b.production_sift_id=a.production_sift_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->production_new_id>0) {
					$response['data'][] = array(
						$val->production_new_code,
						$val->production_sift_name,
						$val->production_new_date,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->production_new_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->production_new_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'productions a';
		$select = "a.*,b.item_name,c.item_detail_color,g.employee_name";
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'b.item_name,c.item_detail_color,g.employee_name',
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
			'column' => 'a.production_new_id',
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

		//JOIN
		$join['data'][] = array(
			'table' => 'employees g',
			'join'	=> 'g.employee_id=a.employee_id',
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
				if ($val->production_id>0) {

					$response['data'][] = array(
						$val->production_id,
						$val->employee_name,
						$val->item_name.'-'.$val->item_detail_color,
						$val->production_cycle,
						$val->production_target_hour,
						$val->production_target_shift,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->production_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->production_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>&nbsp;&nbsp;<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_result('.$val->production_id.')"><i class="glyphicon glyphicon-list"></i></a>'
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

	public function load_data_result($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'production_details a';
		$select = 'a.*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'production_detail_desc',
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
			'column' => 'production_id',
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
				if ($val->production_detail_id>0) {
					$response['data'][] = array(
						$val->production_detail_qty,
						$val->production_detail_bs,
						$val->production_detail_gs,
						$val->production_detail_time1,
						$val->production_detail_time2,
						$val->production_detail_desc,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->production_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->production_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.production_sift_name';
		$tbl = 'production_new a';
		//JOIN
		$join['data'][] = array(
			'table' => 'production_sifts b',
			'join'	=> 'b.production_sift_id=a.production_sift_id',
			'type'	=> 'inner'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'production_new_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$response['val'][] = array(
					'production_new_id'			=> $val->production_new_id,
					'production_new_date' 		=> $this->format_date_day_mid2($val->production_new_date),
					'production_sift_id' 			=> $val->production_sift_id,
					'production_sift_name' 			=> $val->production_sift_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$tbl = 'productions a';
		$select = "a.*,b.item_name,b.item_status,c.item_detail_color,g.employee_name,d.machine_name";
		//WHERE
		$where['data'][] = array(
			'column' => 'production_id',
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

		//JOIN
		$join['data'][] = array(
			'table' => 'machines d',
			'join'	=> 'd.machine_id=a.machine_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'employees g',
			'join'	=> 'g.employee_id=a.employee_id',
			'type'	=> 'left'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$select2 = 'a.*,b.mixer_code';
				$tbl2 = 'production_mixers a';
				//WHERE
				$where['data'][] = array(
					'column' => 'production_id',
					'param'	 => $this->input->get('id')
				);
				//JOIN
				$join2['data'][] = array(
					'table' => 'mixers b',
					'join'	=> 'b.mixer_id=a.mixer_id',
					'type'	=> 'inner'
				);
				$query_mixer = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,$join2,$where);
				if ($query_mixer<>false) {
					foreach ($query_mixer->result() as $val2) {
						$mixer['val2'][] = array(
							'id' 	=> $val2->mixer_id,
							'text' 	=> $val2->mixer_code
						);
					}
				}else{
					$mixer['val2'][] = array();
				}
				

				$response['val'][] = array(
					'production_id'				=> $val->production_id,
					'production_code' 			=> $val->production_code,
					'production_date' 			=> $this->format_date_day_mid2($val->production_date),
					'item_id' 					=> $val->item_id,
					'item_name' 				=> $val->item_name,
					'item_status' 				=> $val->item_status,
					'item_detail_id' 			=> $val->item_detail_id,
					'item_detail_color'			=> $val->item_detail_color,
					'employee_id' 				=> $val->employee_id,
					'employee_name' 			=> $val->employee_name,
					'production_cycle'			=> $val->production_cycle,
					'production_target_hour'	=> $val->production_target_hour,
					'production_target_shift'	=> $val->production_target_shift,
					'item_status'				=> $val->item_status,
					'production_lock'			=> $val->production_lock,
					'mixers'					=> $mixer
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_result(){
		$select = 'a.*';
		$tbl = 'production_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'production_detail_id',
			'param'	 => $this->input->get('id')
		);
		

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'production_detail_id'			=> $val->production_detail_id,
					'production_detail_qty' 		=> $val->production_detail_qty,
					'production_detail_bs' 			=> $val->production_detail_bs,
					'production_detail_gs' 			=> $val->production_detail_gs,
					'production_detail_time1' 		=> $this->format_time_12($val->production_detail_time1),
					'production_detail_time2' 		=> $this->format_time_12($val->production_detail_time2),
					'production_detail_desc' 		=> $val->production_detail_desc,
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
				'column' => 'production_new_id',
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
			//echo $data['production_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['production_new_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'production_new_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('production_details', $where2, $data2);
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
				'column' => 'production_id',
				'param'	 => $new_id
			);
			$this->g_mod->delete_data_table('production_memos',$where3);
			for($x = 0; $x < $arrlength_memo; $x++) {
				$data3['production_id'] 	= $new_id;
				$data3['memo_id'] 	= $memo_id[$x];
				$this->g_mod->insert_data_table('production_memos',NULL,$data3);

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
					$data4['production_id'] 			= $new_id;
					$data4['item_id'] 			= $val2->item_id;
					$data4['item_detail_id'] 	= $val2->item_detail_id;
					$data4['production_detail_qty'] 	= $val2->memo_detail_qty;
					$data4['user_id'] 			= $this->user_id;

					$this->g_mod->insert_data_table('production_details', NULL, $data4);

					$where5 = 'and warehouse_id = 1 and package_id = 0';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$data4['production_detail_qty'],$data4['item_detail_id'],$where5);
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
				'column' => 'production_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('productions', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail();

			$insert = $this->g_mod->insert_data_table('productions', NULL, $data);

			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_result(){
		$id = $this->input->post('i_result_id');
		$item_detail_id = $this->input->post('i_color_id');

		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_result();
			//WHERE
			$where['data'][] = array(
				'column' => 'production_detail_id',
				'param'	 => $id
			);

			$result = $this->g_mod->read_data('*','production_details','production_detail_id',$id);
			$qty_old = $result['production_detail_gs'];
			$qty = $qty_old - $data['production_detail_gs'];
			$this->g_mod->update_data_stock('heaps','heap_gs','item_detail_id',$qty,$item_detail_id);

			$update = $this->g_mod->update_data_table('production_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_result();
			//echo $data['production_img'];
			$insert = $this->g_mod->insert_data_table('production_details', NULL, $data);

			$where = "item_detail_id = $item_detail_id";
			$query = $this->g_mod->select('*','heaps',NULL,NULL,NULL,NULL,NULL,$where);
			if (!$query) {
				//$data_heap['heap_bs'] = $data['production_detail_bs'];
				$data_heap['heap_gs'] 			= $data['production_detail_gs'];
				$data_heap['item_detail_id'] 	= $item_detail_id;

				$this->g_mod->insert_data_table('heaps', NULL, $data_heap);
			}else{
				$this->g_mod->update_data_stock('heaps','heap_gs','item_detail_id',-$data['production_detail_gs'],$item_detail_id);
			}

			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		
		echo json_encode($response);
	}

	public function action_data_edit(){
		$id = $this->input->post('i_detail_id');

			$where['data'][] = array(
				'column' => 'production_id',
				'param'	 => $id
			);
			$data['machine_id'] = $this->input->post('i_machine');
			$update = $this->g_mod->update_data_table('productions', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}

		$mixer_id = $this->input->post('i_mixer');
		$arrlength_mixer = count($mixer_id);

		if ($mixer_id) {
			//WHERE
			$where2['data'][] = array(
				'column' => 'production_id',
				'param'	 => $id
			);
			$this->g_mod->delete_data_table('production_mixers',$where2);
			for($x = 0; $x < $arrlength_mixer; $x++) {
				$data2['production_id'] 	= $id;
				$data2['mixer_id'] 	= $mixer_id[$x];
				$this->g_mod->insert_data_table('production_mixers',NULL,$data2);
			}
		}
		
		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'production_id',
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
			'column' => 'production_detail_id',
			'param'	 => $id
		);

		$delete = $this->g_mod->delete_data_table('production_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function delete_data_result(){
		$id = $this->input->post('id');
		$color_id = $this->input->post('detail_id');
		//WHERE
		$where['data'][] = array(
			'column' => 'production_detail_id',
			'param'	 => $id
		);

		$result = $this->g_mod->read_data('*','production_details','production_detail_id',$id);
		$qty = $result['production_detail_gs'];

		$this->g_mod->update_data_stock('heaps','heap_gs','item_detail_id',$qty,$color_id);

		$delete = $this->g_mod->delete_data_table('production_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_production(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(production_new_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(production_new_code,1,8)',
			'param'	 => 'PM'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'production_new_code',
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
			'production_date' 	=> $this->format_date_day_mid($this->input->post('i_date', TRUE))
			);*/
		if (!$id) {
			$data['production_new_code'] 		= $this->get_code_production();
		}

		$data['production_sift_id'] 	= $this->input->post('i_sift', TRUE);
		$data['production_new_date'] 		= $this->format_date_day_mid($this->input->post('i_date', TRUE));
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'production_new_id' 				=> $this->input->post('i_id', TRUE),
			'item_id' 							=> $this->input->post('i_item', TRUE),
			'item_detail_id' 					=> $this->input->post('i_item_detail', TRUE),
			'employee_id' 						=> $this->input->post('i_operator', TRUE),
			'production_cycle' 					=> $this->input->post('i_detail_cycle', TRUE),
			'production_target_hour' 			=> $this->input->post('i_detail_hour', TRUE),
			'production_target_shift' 			=> $this->input->post('i_detail_sift', TRUE),
			'user_id' 							=> $this->user_id
			);
			

		return $data;
	}

	function general_post_data_result(){

		$data = array(
			'production_id' 			=> $this->input->post('i_detail_id', TRUE),
			'production_detail_qty' 	=> $this->input->post('i_result_qty', TRUE),
			'production_detail_bs' 		=> $this->input->post('i_result_bs', TRUE),
			'production_detail_gs' 		=> $this->input->post('i_result_gs', TRUE),
			'production_detail_time1' 	=> $this->format_time_24($this->input->post('i_time1', TRUE)),
			'production_detail_time2' 	=> $this->format_time_24($this->input->post('i_time2', TRUE)),
			'production_detail_desc' 	=> $this->input->post('i_result_desc', TRUE),
			'user_id' 					=> $this->user_id
			);
			

		return $data;
	}

	
	public function load_data_select_production(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'production_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'production_code',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->production_id,
					'text'	=> $val->production_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_sift(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'production_sift_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'production_sift_name',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*','production_sifts',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->production_sift_id,
					'text'	=> $val->production_sift_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	/* end Function */

}
