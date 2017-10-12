<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mixer extends MY_Controller {
	private $any_error = array();
	public $tbl = 'mixers';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();
        $this->load->library('PdfGenerator');

        $akses = $this->g_mod->get_user_acces($this->user_id,48);
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
			'title_page' 	=> 'Transaksi / Mixer',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('mixer_v', $data);
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
		$tbl = 'mixers a';
		$select = 'a.*,b.item_name,c.item_detail_color,d.machine_name ';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'mixer_code,machine_name,item_name,item_detail_color',
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

		//JOIN
		$join['data'][] = array(
			'table' => 'machines d',
			'join'	=> 'd.machine_id=a.machine_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->mixer_id>0) {
					
					$response['data'][] = array(
						$val->mixer_code,
						$val->machine_name,
						$val->item_name,
						$val->item_detail_color,
						$val->mixer_qty,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->mixer_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->mixer_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'mixer_details a';
		$select = 'a.*,b.material_name,c.item_formula_qty';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'material_name',
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
			'column' => 'mixer_id',
			'param'	 => $id
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'materials b',
			'join'	=> 'b.material_id=a.material_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_formulas c',
			'join'	=> 'c.item_formula_id=a.formula_id',
			'type'	=> 'left'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->mixer_detail_id>0) {
					$response['data'][] = array(
						$val->mixer_detail_id,
						$val->material_name,
						$val->item_formula_qty,
						$val->mixer_detail_qty,
						$val->mixer_detail_production,
						'<button id="edit" class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->mixer_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button id="hapus" class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->mixer_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.item_name,b.item_status,c.item_detail_color,d.machine_name,e.order_production_code';
		$tbl = 'mixers a';

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
			'table' => 'order_productions e',
			'join'	=> 'e.order_production_id=a.order_production_id',
			'type'	=> 'left'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'mixer_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'mixer_id'				=> $val->mixer_id,
					'mixer_code' 			=> $val->mixer_code,
					'mixer_lock' 			=> $val->mixer_lock,
					'mixer_date' 			=> $this->format_date_day_mid2($val->mixer_date),
					'machine_id' 			=> $val->machine_id,
					'machine_name' 			=> $val->machine_name,
					'item_id' 				=> $val->item_id,
					'item_name' 			=> $val->item_name,
					'item_detail_id' 		=> $val->item_detail_id,
					'item_detail_color'		=> $val->item_detail_color,
					'mixer_qty' 			=> $val->mixer_qty,
					'mixer_total' 			=> $val->mixer_total,
					'mixer_rest'			=> $val->mixer_rest,
					'item_status'			=> $val->item_status,
					'order_production_id'	=> $val->order_production_id,
					'order_production_code'	=> $val->order_production_code,
					'mixer_lock'			=> $val->mixer_lock,
					'mixer_request'			=> $val->mixer_request,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.material_name,c.item_formula_qty';
		$tbl = 'mixer_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'mixer_detail_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'materials b',
			'join'	=> 'b.material_id=a.material_id',
			'type'	=> 'join'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_formulas c',
			'join'	=> 'c.item_formula_id=a.formula_id',
			'type'	=> 'left'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'mixer_detail_id'				=> $val->mixer_detail_id,
					'mixer_detail_qty' 				=> $val->mixer_detail_qty,
					'material_id' 					=> $val->material_id,
					'material_name' 				=> $val->material_name,
					'mixer_detail_production' 		=> $val->mixer_detail_production,
				);
			}

			echo json_encode($response);
		}
	}

	public function cek_data_mixer(){
		$select = '*';
		$tbl = 'mixers a';
		//WHERE
		$where['data'][] = array(
			'column' => 'mixer_id',
			'param'	 => $this->input->get('id')
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'mixer_lock'				=> $val->mixer_lock,
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
				'column' => 'mixer_id',
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
			//echo $data['mixer_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$select = 'a.*';
			$tbl = 'item_formulas a';
			//WHERE
			$where2['data'][] = array(
				'column' => 'item_detail_id',
				'param'	 => $data['item_detail_id']
			);
			
			$total = 0;
			$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where2);
			if ($query<>false) {
				foreach ($query->result() as $val) {
					$stock = $val->item_formula_qty * $data['mixer_qty'];

					$data2['mixer_id'] 					= $insert->output;
					$data2['mixer_detail_qty'] 			= $stock;
					$data2['mixer_detail_production'] 	= $stock;
					$data2['material_id'] 				= $val->material_id;
					$data2['formula_id'] 				= $val->item_formula_id;

					$this->g_mod->insert_data_table('mixer_details', NULL, $data2);
					$this->g_mod->update_data_stock('materials','material_stock','material_id',$stock,$data2['material_id']);

					$total += $stock;
				}
			}

			$where3['data'][] = array(
				'column' => 'mixer_id',
				'param'	 => $insert->output
			);

			$data3['mixer_total'] = $total;
			$data3['mixer_rest'] = $total;

			$this->g_mod->update_data_table($this->tbl, $where3, $data3);
			
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

	public function action_data_detail(){
		$id = $this->input->post('i_detail_id');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail();

			$detail = $this->g_mod->read_data('*','mixer_details','mixer_detail_id',$id);
			$qty = $data['mixer_detail_production'] - $detail['mixer_detail_production'];

			$this->g_mod->update_data_stock('materials','material_stock','material_id',$qty,$data['material_id']);
			
			//WHERE
			$where['data'][] = array(
				'column' => 'mixer_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('mixer_details', $where, $data);

			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail();
			//echo $data['mixer_img'];
			$insert = $this->g_mod->insert_data_table('mixer_details', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}

		$select = 'a.*';
		$tbl = 'mixer_details a';
		//WHERE
		$where2['data'][] = array(
			'column' => 'mixer_id',
			'param'	 => $data['mixer_id']
		);
			
		$total = 0;
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where2);
		if ($query<>false) {
			foreach ($query->result() as $val) {

				$total += $val->mixer_detail_production;
			}
		}

		$where3['data'][] = array(
			'column' => 'mixer_id',
			'param'	 => $data['mixer_id']
		);
		$data3['mixer_total'] = $total;

		$this->g_mod->update_data_table($this->tbl, $where3, $data3);
		
		echo json_encode($response);
	}

	

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'mixer_id',
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
			'column' => 'mixer_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('mixer_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_mixer(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(mixer_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(mixer_code,1,8)',
			'param'	 => 'MX'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'mixer_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('MX',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){
		$order = $this->input->post('i_order', TRUE);
		if (!$order) {
			$order =0;
		}
		if (!$id) {
			$data['mixer_code'] 		= $this->get_code_mixer();
		}

		$item = $this->input->post('i_item');
		if ($item) {
			$data['item_id'] 		= $item;
		}

		$item_half = $this->input->post('i_item_half');
		if ($item_half) {
			$data['item_id'] 		= $item_half;
		}
		
		$data['mixer_date'] 			= $this->format_date_day_mid($this->input->post('i_date'));
		$data['machine_id'] 			= $this->input->post('i_machine');
		$data['item_detail_id'] 		= $this->input->post('i_item_detail');
		$data['mixer_qty'] 				= $this->input->post('i_qty');
		$data['order_production_id'] 	= $order;

		/*$data = array(
			'vehicle_id' 		=> $this->input->post('i_vehicle'),
			'mixer_nominal' 	=> $this->input->post('i_nominal', TRUE),
			'machine_id' 		=> $this->input->post('i_machine'),
			'mixer_date' 		=> $this->format_date_day_mid($this->input->post('i_date', TRUE)),
			'mixer_desc' 		=> $this->input->post('i_date', TRUE)
			);*/
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'mixer_id' 					=> $this->input->post('i_id', TRUE),
			'material_id' 				=> $this->input->post('i_material', TRUE),
			'mixer_detail_production' 	=> $this->input->post('i_qty_detail', TRUE)
			);
			

		return $data;
	}
	function general_post_data_material(){

		$data = array(
			'mixer_id' 					=> $this->input->post('i_id_new', TRUE),
			'material_id' 				=> $this->input->post('i_material2', TRUE),
			'mixer_detail_production' 	=> $this->input->post('i_qty_material', TRUE)
			);
			

		return $data;
	}

	public function load_data_select_mixer($id){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'mixer_code',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'mixer_code',
			'type'	 => 'ASC'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'item_detail_id',
			'param'	 => $id
		);

		$where2 = 'mixer_rest > 0';

		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where,$where2);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->mixer_id,
					'text'	=> $val->mixer_code
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function get_order(){
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
					'item_id'				=> $val->item_id,
					'item_name' 			=> $val->item_name,
					'item_status' 			=> $val->item_status,
					'item_detail_id' 		=> $val->item_detail_id,
					'item_detail_color'		=> $val->item_detail_color,
					'order_production_qty'		=> $val->order_production_qty,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_select_material(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'material_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'material_name',
			'type'	 => 'ASC'
		);

		
		$query = $this->g_mod->select('*','materials',NULL,$where_like,$order,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->material_id,
					'text'	=> $val->material_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}


	public function action_data_material(){
		$id = $this->input->post('i_detail_id_new');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_material();

			$detail = $this->g_mod->read_data('*','mixer_details','mixer_detail_id',$id);
			$qty = $data['mixer_detail_production'] - $detail['mixer_detail_production'];

			$this->g_mod->update_data_stock('materials','material_stock','material_id',$qty,$data['material_id']);
			
			//WHERE
			$where['data'][] = array(
				'column' => 'mixer_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('mixer_details', $where, $data);

			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_material();
			//echo $data['mixer_img'];
			$insert = $this->g_mod->insert_data_table('mixer_details', NULL, $data);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}

		$select = 'a.*';
		$tbl = 'mixer_details a';
		//WHERE
		$where2['data'][] = array(
			'column' => 'mixer_id',
			'param'	 => $data['mixer_id']
		);
			
		$total = 0;
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where2);
		if ($query<>false) {
			foreach ($query->result() as $val) {

				$total += $val->mixer_detail_production;
			}
		}

		$where3['data'][] = array(
			'column' => 'mixer_id',
			'param'	 => $data['mixer_id']
		);
		$data3['mixer_total'] = $total;

		$this->g_mod->update_data_table($this->tbl, $where3, $data3);
		
		echo json_encode($response);
	}

	public function action_data_request(){
			//WHERE
			$data['mixer_request'] 				= 1;
			$where['data'][] = array(
				'column' => 'mixer_id',
				'param'	 => $this->input->post('i_id')
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}

			echo json_encode($response);
	}

	public function action_data_approve($id){
			//WHERE
			$data['mixer_request'] 				= 0;
			$data['mixer_lock'] 				= 0;
			$where['data'][] = array(
				'column' => 'mixer_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}

			echo json_encode($response);
	}

	function print_mixer_pdf(){
		$id = $this->input->get('id');
		$id2 = $this->format_date_day_mid($id);
		$sql = "SELECT a.*,b.item_name,c.item_detail_color,d.machine_name FROM mixers a 
		LEFT JOIN items b ON b.item_id=a.item_id 
		LEFT JOIN item_details c ON c.item_detail_id=a.item_detail_id 
		LEFT JOIN machines d on d.machine_id=a.machine_id  
		        where a.mixer_date = '$id2'";
        $query = $this->g_mod->select_manual_for($sql);
		foreach ($query->result() as $row){ 
			
			$data = array(
				'mixer_id' 					=> $row->mixer_id,
				'mixer_code' 					=> $row->mixer_code,
				'machine_name' 					=> $row->machine_name,
				'mixer_date' 				=> $row->mixer_date,
				'item_name' 					=> $row->item_name,
				'item_detail_color' 					=> $row->item_detail_color,
				'mixer_qty' 				=> $row->mixer_qty,

				);
		}
		$data['mixer_date'] 	= $id2;
		$judul			= "Daftar Mixer Per Date";
		$data['title'] 	= $judul;

	    $html = $this->load->view('report/report_mixer', $data, true);//SEND DATA TO VIEW
	    $paper = 'A4';
    	$orientation = 'portraitid';
	    
	    $this->pdfgenerator->generate($html, str_replace(" ","_",$judul), $paper, $orientation);
	}

	public function action_data_lock(){
		$data['mixer_lock'] = 1;

		$where['data'][] = array(
			'column' => 'mixer_id',
			'param'	 => $this->input->post('i_id')
		);
		$update = $this->g_mod->update_data_table('mixers', $where, $data);

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
