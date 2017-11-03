<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sperpart_industri extends MY_Controller {
	private $any_error = array();
	public $tbl = 'sperparts';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,88);
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
			'title_page' 	=> 'Setup Data / Sperpart-Industri',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('sperpart_industri_v', $data);
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
			'column' => 'sperpart_name,sperpart_price',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$where['data'][]=array(
			'column'	=>'sperpart_type',
			'param'		=>2
			);

		$join['data'][] = array(
			'table' => 'units b',
			'join'	=> 'b.unit_id=a.unit_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,'sperparts a',NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,'sperparts a',NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,'sperparts a',$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->sperpart_id>0) {
					$response['data'][] = array(
						$val->sperpart_name,
						$val->sperpart_qty,
						number_format($val->sperpart_price,2),
						$val->unit_name,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->sperpart_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->sperpart_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.unit_name';
		//WHERE
		$where['data'][] = array(
			'column' => 'sperpart_id',
			'param'	 => $this->input->get('id')
		);

		$join['data'][] = array(
			'table' => 'units b',
			'join'	=> 'b.unit_id=a.unit_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,'sperparts a',NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'sperpart_id'		=> $val->sperpart_id,
					'sperpart_name' 	=> $val->sperpart_name,
					'unit_id'		=> $val->unit_id,
					'unit_name' 	=> $val->unit_name,
					'sperpart_min' 		=> $val->sperpart_min,
					'sperpart_max' 		=> $val->sperpart_max,
					'sperpart_price' 	=> $val->sperpart_price,
					'sperpart_qty' 		=> $val->sperpart_qty,
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
				'column' => 'sperpart_id',
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
			'column' => 'sperpart_id',
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
			'sperpart_name' 	=> $this->input->post('i_name', TRUE),
			'sperpart_min' 		=> $this->input->post('i_min', TRUE),
			'sperpart_max' 		=> $this->input->post('i_max', TRUE),
			'sperpart_price' 	=> $this->input->post('i_price', TRUE),
			'unit_id' 	=> $this->input->post('i_unit', TRUE),
			'sperpart_qty' 		=> $this->input->post('i_stock', TRUE),
			'sperpart_type' 		=> 2
			);

		return $data;
	}

	public function load_data_select_sperpart_industri(){
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'sperpart_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'sperpart_name',
			'type'	 => 'ASC'
		);

		$where['data'][]=array(
			'column'	=>'sperpart_type',
			'param'		=>2
			);
		$query = $this->g_mod->select('*',$this->tbl,NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->sperpart_id,
					'text'	=> $val->sperpart_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
