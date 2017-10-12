<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_vehicle extends MY_Controller {
	private $any_error = array();
	public $tbl = 'services';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,71);
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
			'title_page' 	=> 'Transaksi / Servis / Kendaraan',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('service_vehicle_v', $data);
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
		$tbl = 'services a';
		$select = 'a.*,b.machine_name,c.vehicle_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'service_nominal,service_desc,machine_name,vehicle_name',
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
			'table' => 'machines b',
			'join'	=> 'b.machine_id=a.machine_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'vehicles c',
			'join'	=> 'c.vehicle_id=a.vehicle_id',
			'type'	=> 'left'
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'a.machine_id',
			'param'	 => 0
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->service_id>0) {
					if ($val->machine_name) {
						$ser_name = $val->machine_name;
					}else{
						$ser_name = $val->vehicle_name;
					}
					$response['data'][] = array(
						$ser_name,
						$val->service_date,
						number_format($val->service_nominal),
						$val->service_desc,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->service_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->service_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'service_details a';
		$select = 'a.*,b.sperpart_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'sperpart_name',
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
			'column' => 'service_id',
			'param'	 => $id
		);

		if (!$id) {
			//WHERE
			$where['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
		}

		//JOIN
		$join['data'][] = array(
			'table' => 'sperparts b',
			'join'	=> 'b.sperpart_id=a.sperpart_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->service_detail_id>0) {
					$response['data'][] = array(
						$val->service_detail_id,
						$val->sperpart_name,
						$val->service_detail_qty,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data_detail('.$val->service_detail_id.')" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data_detail('.$val->service_detail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.machine_name,c.vehicle_name';
		$tbl = 'services a';
		//JOIN
		$join['data'][] = array(
			'table' => 'machines b',
			'join'	=> 'b.machine_id=a.machine_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'vehicles c',
			'join'	=> 'c.vehicle_id=a.vehicle_id',
			'type'	=> 'left'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'service_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'service_id'		=> $val->service_id,
					'service_nominal' 	=> $val->service_nominal,
					'service_date' 		=> $this->format_date_day_mid2($val->service_date),
					'service_desc' 		=> $val->service_desc,
					'vehicle_id' 		=> $val->vehicle_id,
					'vehicle_name' 		=> $val->vehicle_name,
					'machine_id' 		=> $val->machine_id,
					'machine_name'		=> $val->machine_name,
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.sperpart_name';
		$tbl = 'service_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'service_detail_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'sperparts b',
			'join'	=> 'b.sperpart_id=a.sperpart_id',
			'type'	=> 'join'
		);

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'service_detail_id'		=> $val->service_detail_id,
					'service_detail_qty' 	=> $val->service_detail_qty,
					'sperpart_id' 			=> $val->sperpart_id,
					'sperpart_name' 		=> $val->sperpart_name,
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
				'column' => 'service_id',
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
			//echo $data['service_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['service_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'service_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('service_details', $where2, $data2);
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
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
			$data = $this->general_post_data_color();
			//WHERE
			$where['data'][] = array(
				'column' => 'service_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('service_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_color();
			//echo $data['service_img'];
			$insert = $this->g_mod->insert_data_table('service_details', NULL, $data);
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
			'column' => 'service_id',
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
			'column' => 'service_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('service_details', $where);
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

		$vehicle = $this->input->post('i_vehicle');
		if ($vehicle) {
			$data['vehicle_id'] 		= $vehicle;
		}

		$machine = $this->input->post('i_machine');
		if ($machine) {
			$data['machine_id'] 		= $machine;
		}
		
		$data['service_nominal'] 	= $this->input->post('i_nominal');
		$data['service_date'] 		= $this->format_date_day_mid($this->input->post('i_date'));
		$data['service_desc'] 		= $this->input->post('i_desc');

		/*$data = array(
			'vehicle_id' 		=> $this->input->post('i_vehicle'),
			'service_nominal' 	=> $this->input->post('i_nominal', TRUE),
			'machine_id' 		=> $this->input->post('i_machine'),
			'service_date' 		=> $this->format_date_day_mid($this->input->post('i_date', TRUE)),
			'service_desc' 		=> $this->input->post('i_date', TRUE)
			);*/
			

		return $data;
	}

	function general_post_data_color(){

		$data = array(
			'service_id' 			=> $this->input->post('i_id', TRUE),
			'sperpart_id' 			=> $this->input->post('i_sperpart', TRUE),
			'service_detail_qty' 	=> $this->input->post('i_qty_detail', TRUE),
			'user_id' 				=> $this->user_id
			);
			

		return $data;
	}

	/* end Function */

}
