<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production extends MY_Controller {
	private $any_error = array();
	public $tbl = 'productions';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,49);
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
			'title_page' 	=> 'Transaksi / Production',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('production_v', $data);
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
		$tbl = 'productions a';
		$select = "a.*,b.item_name,c.item_detail_color,d.machine_code,g.employee_name,GROUP_CONCAT(mixer_code ORDER BY mixer_code SEPARATOR ' ,') mixer_codes,h.production_sift_name";
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'production_code,machine_name,item_name,item_detail_color',
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

		//JOIN
		$join['data'][] = array(
			'table' => 'production_mixers e',
			'join'	=> 'e.production_id=a.production_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'mixers f',
			'join'	=> 'f.mixer_id=e.mixer_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'employees g',
			'join'	=> 'g.employee_id=a.employee_id',
			'type'	=> 'left'
		);
		$join['data'][] = array(
			'table' => 'production_sifts h',
			'join'	=> 'h.production_sift_id=a.production_sift_id',
			'type'	=> 'left'
		);

		$whare = 'a.production_new_id = 0 and a.user_id = 0';
		$group_by = 'a.production_id';

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL,$whare,$group_by);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL,$whare,$group_by);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL,$whare,$group_by);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->production_id>0) {
					$response['data'][] = array(
						$val->production_date,
						$val->machine_code,
						$val->production_code,
						$val->mixer_codes,
						$val->item_name,
						$val->item_detail_color,
						$val->employee_name,
						$val->production_sift_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->production_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->production_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'production_details a';
		$select = "*";
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
						$val->production_detail_gr,
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

	public function load_data_detail_stiker($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'production_detail_stikers a';
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
		$join['data'][] = array(
			'table' => 'packages b',
			'join'	=> 'b.package_id=a.stiker_id',
			'type'	=> 'left'
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

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->production_detail_stiker_id>0) {
					$response['data'][] = array(
						$val->package_name,
						$val->production_detail_stiker_amount,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail_stiker('.$val->production_detail_stiker_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail_stiker('.$val->production_detail_stiker_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.item_name,b.item_status,c.item_detail_color,d.machine_name,e.employee_name,f.production_sift_name';
		$tbl = 'productions a';

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
			'table' => 'employees e',
			'join'	=> 'e.employee_id=a.employee_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'production_sifts f',
			'join'	=> 'f.production_sift_id=a.production_sift_id',
			'type'	=> 'left'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'production_id',
			'param'	 => $this->input->get('id')
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
				foreach ($query_mixer->result() as $val2) {
					$mixer['val2'][] = array(
						'id' 	=> $val2->mixer_id,
						'text' 	=> $val2->mixer_code
					);
				}


				$response['val'][] = array(
					'production_id'				=> $val->production_id,
					'production_code' 			=> $val->production_code,
					'production_date' 			=> $this->format_date_day_mid2($val->production_date),
					'machine_id' 				=> $val->machine_id,
					'machine_name' 				=> $val->machine_name,
					'item_id' 					=> $val->item_id,
					'item_name' 				=> $val->item_name,
					'item_detail_id' 			=> $val->item_detail_id,
					'item_detail_color'			=> $val->item_detail_color,
					'employee_id' 				=> $val->employee_id,
					'employee_name' 			=> $val->employee_name,
					'production_cycle'			=> $val->production_cycle,
					'production_weight'			=> $val->production_weight,
					'production_target_hour'	=> $val->production_target_hour,
					'production_target_shift'	=> $val->production_target_shift,
					'item_status'				=> $val->item_status,
					'production_sift_id'		=> $val->production_sift_id,
					'production_sift_name'		=> $val->production_sift_name,
					'production_lock'			=> $val->production_lock,
					'production_request'		=> $val->production_request,
					'mixers'					=> $mixer
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
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
					'production_detail_gr' 			=> $val->production_detail_gr,
					'production_detail_gs' 			=> $val->production_detail_gs,
					'production_detail_time1' 		=> $this->format_time_12($val->production_detail_time1),
					'production_detail_time2' 		=> $this->format_time_12($val->production_detail_time2),
					'production_detail_desc' 		=> $val->production_detail_desc,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail_stiker(){
		$select = 'a.*,b.package_name';
		$tbl = 'production_detail_stikers a';
		$join['data'][] = array(
			'table' => 'packages b',
			'join'	=> 'b.package_id=a.stiker_id',
			'type'	=> 'left'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'production_detail_stiker_id',
			'param'	 => $this->input->get('id')
		);
		

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				

				$response['val'][] = array(
					'production_detail_stiker_id'			=> $val->production_detail_stiker_id,
					'production_detail_stiker_amount' 		=> $val->production_detail_stiker_amount,
					'stiker_id' 			=> $val->stiker_id,
					'package_name' 			=> $val->package_name,
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
				'column' => 'production_id',
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

			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id'] = $insert->output;
			} else {
				$response['status'] = '204';
			}

			$data3['production_id'] = $insert->output;
			//WHERE
			$where3['data'][] = array(
				'column' => 'production_id',
				'param'	 => 0
			);
			//WHERE
			$where3['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('production_details', $where3, $data3);
			$update2 = $this->g_mod->update_data_table('production_detail_stikers', $where3, $data3);

			$new_id = $insert->output;
		}
		
		$mixer_id = $this->input->post('i_mixer');
		$arrlength_mixer = count($mixer_id);

		if ($mixer_id) {
			//WHERE
			$where2['data'][] = array(
				'column' => 'production_id',
				'param'	 => $new_id
			);
			$this->g_mod->delete_data_table('production_mixers',$where2);
			for($x = 0; $x < $arrlength_mixer; $x++) {
				$data2['production_id'] 	= $new_id;
				$data2['mixer_id'] 	= $mixer_id[$x];
				$this->g_mod->insert_data_table('production_mixers',NULL,$data2);
			}
		}

		echo json_encode($response);
	}

	public function action_data_detail(){
		$id = $this->input->post('i_detail_id');
		$item_detail_id = $this->input->post('i_item_detail');

		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail();
			//WHERE
			$where['data'][] = array(
				'column' => 'production_detail_id',
				'param'	 => $id
			);

			$result = $this->g_mod->read_data('*','production_details','production_detail_id',$id);
			$qty_old = $result['production_detail_gs'];
			$qty = $qty_old - $data['production_detail_gs'];
			$this->g_mod->update_data_stock('heaps','heap_gs','item_detail_id',$qty,$item_detail_id);
			
			$qty_hasil_old = $result['production_detail_qty'];
			$qty_hasil = $qty_old - $data['production_detail_hasil'];
			$this->g_mod->update_data_stock('heaps','heap_hasil','item_detail_id',$qty_hasil,$item_detail_id);

			$update = $this->g_mod->update_data_table('production_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
			$new_id=$id;
		} else {
			//INSERT
			$data = $this->general_post_data_detail();
			//echo $data['production_img'];
			$insert = $this->g_mod->insert_data_table('production_details', NULL, $data);

			$where = "item_detail_id = $item_detail_id";
			$query = $this->g_mod->select('*','heaps',NULL,NULL,NULL,NULL,NULL,$where);
			if (!$query) {
				//$data_heap['heap_bs'] = $data['production_detail_bs'];
				$data_heap['heap_gs'] 			= $data['production_detail_gs'];
				$data_heap['heap_hasil'] 			= $data['production_detail_qty'];
				$data_heap['item_detail_id'] 	= $item_detail_id;

				$this->g_mod->insert_data_table('heaps', NULL, $data_heap);
			}else{
				$this->g_mod->update_data_stock('heaps','heap_gs','item_detail_id',-$data['production_detail_gs'],$item_detail_id);
				$this->g_mod->update_data_stock('heaps','heap_hasil','item_detail_id',-$data['production_detail_qty'],$item_detail_id);
			}

			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
			$new_id = $insert->output;
		}/*
		$stiker_id = $this->input->post('i_stiker');
		$arrlength_stiker = count($stiker_id);

		if ($stiker_id) {
			//WHERE
			$where2['data'][] = array(
				'column' => 'production_detail_id',
				'param'	 => $new_id
			);
			$this->g_mod->delete_data_table('production_detail_stikers',$where2);
			for($x = 0; $x < $arrlength_stiker; $x++) {
				$data2['production_detail_id'] 	= $new_id;
				$data2['stiker_id'] 	= $stiker_id[$x];
				$this->g_mod->insert_data_table('production_detail_stikers',NULL,$data2);
			}
		}*/
		echo json_encode($response);
	}

	public function action_data_detail_stiker(){
		$id = $this->input->post('i_detail_id_detail');

		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data_detail_stiker();
			//WHERE
			$where['data'][] = array(
				'column' => 'production_detail_stiker_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('production_detail_stikers', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail_stiker();
			//echo $data['production_img'];
			$insert = $this->g_mod->insert_data_table('production_detail_stikers', NULL, $data);

			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
			} else {
				$response['status'] = '204';
			}
		}
		echo json_encode($response);
	}

	public function action_data_lock(){
		$data['production_lock'] = 1;

		$where['data'][] = array(
			'column' => 'production_id',
			'param'	 => $this->input->post('i_id')
		);
		$update = $this->g_mod->update_data_table('productions', $where, $data);

		if($update->status) {
			$response['status'] = '200';
			$response['alert'] = '2';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function action_data_request(){

		//WHERE
		$data['production_request'] = 1;

		$where5['data'][] = array(
			'column' => 'production_id',
			'param'	 => $this->input->post('i_id')
		);
		$update = $this->g_mod->update_data_table('productions', $where5, $data);

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

	public function delete_data_detail_stiker(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'production_detail_stiker_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('production_detail_stikers', $where);
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
		$select = 'MID(production_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(production_code,1,8)',
			'param'	 => 'PR'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'production_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('PR',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		if (!$id) {
			$data['production_code'] 		= $this->get_code_production();
		}

		$item = $this->input->post('i_item');
		if ($item) {
			$data['item_id'] 		= $item;
		}

		$item_half = $this->input->post('i_item_half');
		if ($item_half) {
			$data['item_id'] 		= $item_half;
		}
		
		$data['production_date'] 			= $this->format_date_day_mid($this->input->post('i_date'));
		$data['machine_id'] 				= $this->input->post('i_machine');
		$data['item_detail_id'] 			= $this->input->post('i_item_detail');
		$data['employee_id'] 				= $this->input->post('i_operator');
		$data['production_cycle'] 			= $this->input->post('i_cycle');
		$data['production_weight'] 			= $this->input->post('i_weight');
		$data['production_target_hour'] 	= $this->input->post('i_hour');
		$data['production_target_shift'] 	= $this->input->post('i_sift');
		$data['production_sift_id'] 		= $this->input->post('i_sift_id');

		/*$data = array(
			'vehicle_id' 		=> $this->input->post('i_vehicle'),
			'production_nominal' 	=> $this->input->post('i_nominal', TRUE),
			'machine_id' 		=> $this->input->post('i_machine'),
			'production_date' 		=> $this->format_date_day_mid($this->input->post('i_date', TRUE)),
			'production_desc' 		=> $this->input->post('i_date', TRUE)
			);*/
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'production_id' 			=> $this->input->post('i_id', TRUE),
			'production_detail_qty' 	=> $this->input->post('i_detail_qty', TRUE),
			'production_detail_bs' 		=> $this->input->post('i_detail_bs', TRUE),
			'production_detail_gr' 		=> $this->input->post('i_detail_gr', TRUE),
			'production_detail_gs' 		=> $this->input->post('i_detail_gs', TRUE),
			'production_detail_time1' 	=> $this->format_time_24($this->input->post('i_time1', TRUE)),
			'production_detail_time2' 	=> $this->format_time_24($this->input->post('i_time2', TRUE)),
			'production_detail_desc' 	=> $this->input->post('i_detail_desc', TRUE),
			'user_id' 					=> $this->user_id
			);
			

		return $data;
	}

	function general_post_data_detail_stiker(){

		$data = array(
			'production_id' 			=> $this->input->post('i_id', TRUE),
			'stiker_id' 	=> $this->input->post('i_stiker', TRUE),
			'production_detail_stiker_amount' 	=> $this->input->post('i_amount', TRUE),
			'user_id' 					=> $this->user_id
			);
			

		return $data;
	}

	public function load_data_select_stiker(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'package_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'package_id',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*','packages',NULL,$where_like,$order,NULL,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->package_id,
					'text'	=> $val->package_name
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
			'column' => 'production_sift_id',
			'type'	 => 'ASC'
		);

		$query = $this->g_mod->select('*','production_sifts',NULL,$where_like,$order,NULL,NULL,NULL);
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
