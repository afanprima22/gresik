<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends MY_Controller {
	private $any_error = array();
	public $tbl = 'materials';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,31);
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
			'title_page' 	=> 'Master Data / Bahah Material',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('material_v', $data);
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
		$select = 'a.*,b.unit_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'material_name,material_price',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][] = array(
			'table' => 'units b',
			'join'	=> 'b.unit_id=a.unit_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,'materials a',NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,'materials a',NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,'materials a',$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->material_id>0) {
					$response['data'][] = array(
						$val->material_name,
						$val->material_min,
						$val->material_max,
						number_format($val->material_price,2),
						$val->unit_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->material_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->material_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = '*';
		//WHERE
		$where['data'][] = array(
			'column' => 'material_id',
			'param'	 => $this->input->get('id')
		);

		$join['data'][] = array(
			'table' => 'units b',
			'join'	=> 'b.unit_id=a.unit_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,'materials a',NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'material_id'		=> $val->material_id,
					'material_name' 	=> $val->material_name,
					'material_min' 		=> $val->material_min,
					'material_max' 		=> $val->material_max,
					'material_price' 	=> $val->material_price,
					'material_stock' 	=> $val->material_stock,
					'unit_id' 			=> $val->unit_id,
					'unit_name' 		=> $val->unit_name,
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
				'column' => 'material_id',
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
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
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
			'column' => 'material_id',
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

	/* Saving $data as array to database */
	function general_post_data(){
		$data = array(
			'material_name' 	=> $this->input->post('i_name', TRUE),
			'material_min' 		=> $this->input->post('i_min', TRUE),
			'material_max' 		=> $this->input->post('i_max', TRUE),
			'material_price' 	=> $this->input->post('i_price', TRUE),
			'unit_id' 	=> $this->input->post('i_unit', TRUE),
			'material_stock' 	=> $this->input->post('i_stock', TRUE)
			);

		return $data;
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
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,NULL);
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

	public function load_data_select_material_type(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'material_type_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'material_type_name',
			'type'	 => 'ASC'
		);
		$query = $this->g_mod->select('*','material_types',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->material_type_id,
					'text'	=> $val->material_type_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
