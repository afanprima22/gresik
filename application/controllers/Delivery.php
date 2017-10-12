<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class delivery extends MY_Controller {
	private $any_error = array();
	public $tbl = 'deliveries';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,50);
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
			'title_page' 	=> 'Transaction / Pengiriman',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('delivery/delivery_v', $data);
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
		$tbl = 'deliveries a';
		$select = 'a.*,b.vehicle_name,c.operator_name as driver,d.operator_name as helper';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'delivery_code,driver,helper',
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
			'table' => 'vehicles b',
			'join'	=> 'b.vehicle_id=a.vehicle_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'operators c',
			'join'	=> 'c.operator_id=a.driver',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'operators d',
			'join'	=> 'd.operator_id=a.helper',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->delivery_id>0) {
					$response['data'][] = array(
						$val->delivery_code,
						$val->delivery_date,
						$val->driver,
						$val->helper,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->delivery_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->delivery_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$select = 'a.*,b.vehicle_name,c.operator_name as driver_name,d.operator_name as helper_name';
		$tbl = 'deliveries a';
		//JOIN
		$join['data'][] = array(
			'table' => 'vehicles b',
			'join'	=> 'b.vehicle_id=a.vehicle_id',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'operators c',
			'join'	=> 'c.operator_id=a.driver',
			'type'	=> 'inner'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'operators d',
			'join'	=> 'd.operator_id=a.helper',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'delivery_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'delivery_id'			=> $val->delivery_id,
					'delivery_date' 		=> $this->format_date_day_mid2($val->delivery_date),
					'driver' 				=> $val->driver,
					'driver_name' 			=> $val->driver_name,
					'helper' 				=> $val->helper,
					'helper_name' 			=> $val->helper_name,
					'vehicle_id' 			=> $val->vehicle_id,
					'vehicle_name'			=> $val->vehicle_name,
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
				'column' => 'delivery_id',
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
			//echo $data['delivery_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$data2['delivery_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'delivery_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 => $this->user_id
			);
			$update = $this->g_mod->update_data_table('delivery_details', $where2, $data2);

			$select = 'a.*';
			$tbl = 'delivery_details a';
			
			//WHERE
			$where3['data'][] = array(
				'column' => 'delivery_id',
				'param'	 => $insert->output
			);
			$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,$where3);
			if ($query<>false) {
				foreach ($query->result() as $val) {
					$data4['nota_status'] = 1;
					//WHERE
					$where4['data'][] = array(
						'column' => 'nota_id',
						'param'	 => $val->nota_id
					);
					$this->g_mod->update_data_table('notas', $where4, $data4);
				}
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

	public function action_data_detail($type){
		$id = $this->input->post('id');
		$detail_id = $this->input->post('detail_id');

		if ($type == 1) {
			$where2['data'][] = array(
				'column' => 'nota_id',
				'param'	 => $detail_id
			);
			$this->g_mod->delete_data_table('delivery_details', $where2);

			if ($id) {
			$data['delivery_id'] = $id;
			}
			
			$data['nota_id'] = $detail_id;
			$data['user_id'] = $this->user_id;

			$this->g_mod->insert_data_table('delivery_details', NULL, $data);
			$response['status'] = '200';
		}else{
			$where['data'][] = array(
				'column' => 'nota_id',
				'param'	 => $detail_id
			);
			$delete = $this->g_mod->delete_data_table('delivery_details', $where);
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'delivery_id',
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
			'column' => 'delivery_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('delivery_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_delivery(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(delivery_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(delivery_code,1,8)',
			'param'	 => 'DE'.$thn.''.$bln
		);
		$order['data'][] = array(
			'column' => 'delivery_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('DE',$query);
		return $new_code;
	}
	/* Saving $data as array to database */
	function general_post_data($id){

		/*$data = array(
			'customer_id' 	=> $this->input->post('i_customer', TRUE),
			'sales_id' 		=> $this->input->post('i_sales', TRUE),
			'delivery_date' 	=> $this->format_date_day_mid($this->input->post('i_date', TRUE))
			);*/
		if (!$id) {
			$data['delivery_code'] = $this->get_code_delivery();
		}

		$data['vehicle_id'] 	= $this->input->post('i_vehicle', TRUE);
		$data['driver'] 		= $this->input->post('i_driver', TRUE);
		$data['helper'] 		= $this->input->post('i_helper', TRUE);
		$data['delivery_date'] 	= $this->format_date_day_mid($this->input->post('i_date', TRUE));
			

		return $data;
	}

	public function load_detail($id){
		
		$select2 = 'a.*,b.sales_name,c.customer_name';
		$tbl2 = 'notas a';
				
		//JOIN
		$join2['data'][] = array(
			'table' => 'saless b',
			'join'	=> 'b.sales_id=a.sales_id',
			'type'	=> 'left'
		);

		//JOIN
		$join2['data'][] = array(
			'table' => 'customers c',
			'join'	=> 'c.customer_id=a.customer_id',
			'type'	=> 'left'
		);

		if ($id) {
			$where2['data'][] = array(
				'column' => 'a.nota_status',
				'param'	 => 1
			);
			//JOIN
			$join2['data'][] = array(
				'table' => 'delivery_details d',
				'join'	=> 'd.nota_id = a.nota_id',
				'type'	=> 'inner'
			);
		}else{
			//WHERE
			$where2['data'][] = array(
				'column' => 'a.nota_status',
				'param'	 => 0
			);
		}

		$query_nota = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,$join2,$where2);
		
		$this->load->view('delivery/list_detail', array('query_nota' => $query_nota,'id' => $id));
		
	}

	/* end Function */

}
