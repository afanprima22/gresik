<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class nota_tax extends MY_Controller {
	private $any_error = array();
	public $tbl = 'nota_taxs';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,56);
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
			'title_page' 	=> 'Transaction / Nota Pajak',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('nota_tax_v', $data);
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
		$tbl = 'nota_taxs a';
		$select = 'a.*,b.customer_name';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_tax_code,customer_name',
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
			'table' => 'customers b',
			'join'	=> 'b.customer_id=a.customer_id',
			'type'	=> 'inner'
		);


		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->nota_tax_id>0) {
					$response['data'][] = array(
						$val->nota_tax_code,
						$val->customer_name,
						$val->nota_tax_date,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->nota_tax_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->nota_tax_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'nota_tax_details a';
		$select = 'a.*,b.item_name';
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
			'column' => 'a.nota_tax_id',
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
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->nota_tax_detail_id>0) {
					$response['data'][] = array(
						$val->item_name,
						number_format($val->nota_tax_detail_price),
						$val->nota_tax_detail_qty,
						'<input type="text" class="form-control" name="i_detail_price" value="'.$val->nota_tax_detail_tax.'" onchange="edit_tax('.$val->nota_tax_detail_id.',this.value)">'
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
		$select = 'a.*,b.customer_name,b.customer_store';
		$tbl = 'nota_taxs a';
		//JOIN
		$join['data'][] = array(
			'table' => 'customers b',
			'join'	=> 'b.customer_id=a.customer_id',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_tax_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {

				$select2 = 'a.*,b.nota_code';
				$tbl2 = 'nota_tax_notas a';
				//WHERE
				$where2['data'][] = array(
					'column' => 'nota_tax_id',
					'param'	 => $this->input->get('id')
				);
				//JOIN
				$join2['data'][] = array(
					'table' => 'notas b',
					'join'	=> 'b.nota_id=a.nota_id',
					'type'	=> 'inner'
				);
				$query_nota = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,$join2,$where2);
				if ($query_nota<>false) {
					foreach ($query_nota->result() as $val2) {
						$nota['val2'][] = array(
							'id' 	=> $val2->nota_id,
							'text' 	=> $val2->nota_code
						);
					}
				}else{
					$nota['val2'][] = array(
						'id' 	=> '',
						'text' 	=> ''
					);
				}

				$response['val'][] = array(
					'nota_tax_id'			=> $val->nota_tax_id,
					'nota_tax_date' 		=> $this->format_date_day_mid2($val->nota_tax_date),
					'customer_id' 			=> $val->customer_id,
					'customer_name' 		=> $val->customer_name.' - '.$val->customer_store,
					'notas'					=> $nota
				);
			}

			echo json_encode($response);
		}
	}

	public function load_data_where_detail(){
		$select = 'a.*,b.item_name';
		$tbl = 'nota_tax_details a';
		//WHERE
		$where['data'][] = array(
			'column' => 'nota_tax_detail_id',
			'param'	 => $this->input->get('id')
		);
		//JOIN
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=a.item_id',
			'type'	=> 'inner'
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'nota_tax_detail_id'		=> $val->nota_tax_detail_id,
					'nota_tax_detail_qty' 		=> $val->nota_tax_detail_qty,
					'item_id' 					=> $val->item_id,
					'item_name' 				=> $val->item_name,
					'nota_tax_detail_tax' 		=> $val->nota_tax_detail_tax,
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
				'column' => 'nota_tax_id',
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
			//echo $data['nota_tax_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);

			$new_id = $insert->output;
			
			if($insert->status) {
				$response['status'] = '200';
				$response['alert'] = '1';
				$response['id'] = $insert->output;
			} else {
				$response['status'] = '204';
			}

			$nota_id = $this->input->post('i_nota');
			$arrlength_nota = count($nota_id);

			if ($nota_id) {
				//WHERE
				$where3['data'][] = array(
					'column' => 'nota_tax_id',
					'param'	 => $new_id
				);
				$this->g_mod->delete_data_table('nota_tax_notas',$where3);
				for($x = 0; $x < $arrlength_nota; $x++) {
					$nota_new_id = $nota_id[$x];

					$data3['nota_tax_id'] 	= $new_id;
					$data3['nota_id'] 	= $nota_id[$x];
					$this->g_mod->insert_data_table('nota_tax_notas',NULL,$data3);

					$select2 = '*';
					$tbl2 = 'nota_details';
					//WHERE
					$where4 = "nota_id = $nota_id[$x]";

					$query_nota = $this->g_mod->select($select2,$tbl2,NULL,NULL,NULL,NULL,NULL,$where4);
					if ($query_nota<>false) {
						foreach ($query_nota->result() as $val2) {
							$data4['nota_tax_id'] 				= $new_id;
							$data4['item_id'] 					= $val2->item_id;
							$data4['nota_tax_detail_qty'] 		= $val2->nota_detail_qty;
							$data4['nota_tax_detail_price'] 	= $val2->nota_detail_price;
							$data4['nota_tax_detail_tax'] 		= 0;
							$data4['user_id'] 					= $this->user_id;

							$this->g_mod->insert_data_table('nota_tax_details', NULL, $data4);

						}
					}
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
				'column' => 'nota_tax_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('nota_tax_details', $where, $data);
			if($update->status) {
				$response['status'] = '200';
				$response['alert'] = '2';
			} else {
				$response['status'] = '204';
			}
		} else {
			//INSERT
			$data = $this->general_post_data_detail();
			//echo $data['nota_tax_img'];
			$insert = $this->g_mod->insert_data_table('nota_tax_details', NULL, $data);
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
			'column' => 'nota_tax_id',
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
			'column' => 'nota_tax_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('nota_tax_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	function get_code_nota_tax(){
		$bln = date('m');
		$thn = date('Y');
		$select = 'MID(nota_tax_code,9,5) as id';
		$where['data'][] = array(
			'column' => 'MID(nota_tax_code,1,8)',
			'param'	 => 'NP'.$thn.''.$bln.''
		);
		$order['data'][] = array(
			'column' => 'nota_tax_code',
			'type'	 => 'DESC'
		);
		$limit = array(
			'start'  => 0,
			'finish' => 1
		);
		$query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
		$new_code = $this->format_kode_transaksi('NP',$query);
		return $new_code;
	}

	/* Saving $data as array to database */
	function general_post_data($id){

		/*$data = array(
			'customer_id' 	=> $this->input->post('i_customer', TRUE),
			'sales_id' 		=> $this->input->post('i_sales', TRUE),
			'nota_tax_date' 	=> $this->format_date_day_mid($this->input->post('i_date', TRUE))
			);*/
		if (!$id) {
			$data['nota_tax_code'] 		= $this->get_code_nota_tax();
		}

		$data['customer_id'] 			= $this->input->post('i_customer', TRUE);
		$data['nota_tax_date'] 		= $this->format_date_day_mid($this->input->post('i_date', TRUE));
			

		return $data;
	}

	function general_post_data_detail(){

		$data = array(
			'nota_tax_id' 				=> $this->input->post('i_id', TRUE),
			'item_id' 					=> $this->input->post('i_item', TRUE),
			'nota_tax_detail_qty' 		=> $this->input->post('i_detail_qty', TRUE),
			'nota_tax_detail_tax' 		=> $this->input->post('i_detail_tax', TRUE),
			'user_id' 					=> $this->user_id
			);
			

		return $data;
	}

	public function update_tax(){
		$id = $this->input->post('id');
		$value = $this->input->post('value');
			//UPDATE
			$data['nota_tax_detail_tax'] = $value;
			//WHERE
			$where['data'][] = array(
				'column' => 'nota_tax_detail_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table('nota_tax_details', $where, $data);
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
