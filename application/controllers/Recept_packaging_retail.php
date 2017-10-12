<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recept_packaging_retail extends MY_Controller {
	private $any_error = array();
	public $tbl = 'recept_packaging_retails';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,77);
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
			'title_page' 	=> 'Transaksi / Penerimaan Packaging Eceran',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('recept_packaging_retail_v', $data);
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
		$tbl = 'recept_packaging_retails a';
		$select = 'a.*,b.packaging_code';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'packaging_code',
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
			'table' => 'packagings b',
			'join'	=> 'b.packaging_id=a.packaging_id',
			'type'	=> 'inner'
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->recept_packaging_retail_id>0) {
					$response['data'][] = array(
						$val->packaging_code,
						$val->recept_packaging_retail_date,
						$val->recept_packaging_retail_code,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->recept_packaging_retail_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->recept_packaging_retail_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'recept_packaging_retail_details a';
		$select = 'a.*,b.item_name,d.item_detail_color,c.packaging_retail';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'recept_packaging_retail_detail_id',
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
			'column' => 'recept_packaging_retail_id',
			'param'	 => $id
		);
		

		//JOIN
		$join['data'][] = array(
			'table' => 'packaging_detail_items c',
			'join'	=> 'c.packaging_detail_item_id=a.packaging_detail_item_id',
			'type'	=> 'inner'
		);
		$join['data'][] = array(
			'table' => 'items b',
			'join'	=> 'b.item_id=c.item_id',
			'type'	=> 'left'
		);

		//JOIN
		$join['data'][] = array(
			'table' => 'item_details d',
			'join'	=> 'd.item_detail_id=c.item_detail_id',
			'type'	=> 'left'
		);
		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->recept_packaging_retail_detail_id>0) {
					
					$response['data'][] = array(
						$val->recept_packaging_retail_detail_id,
						$val->item_name.' - '.$val->item_detail_color,
						$val->packaging_retail,
						$val->recept_packaging_retail_detail_qty,
						
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

	public function load_data_detail_item($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'packaging_detail_items a';
		$select = 'a.*,b.item_name,c.item_detail_color';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'item_name,item_detail_color',
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
			'column' => 'packaging_id',
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

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->packaging_detail_item_id>0) {
					$response['data'][] = array(
						$val->packaging_detail_item_id,
						$val->item_name.' - '.$val->item_detail_color,
						$val->packaging_retail,
						'<input type="number" onchange="cek_data(this.value,'.$val->packaging_retail.','.$id.')"  class="form-control money"  name="i_qty<?='.$val->packaging_detail_item_id.'?>" id="i_qty<?='.$val->packaging_detail_item_id.'?>" placeholder="jumlah yang di masukkan gudang">',
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
	    $select = 'a.*,b.packaging_code';
	    $tbl = 'recept_packaging_retails a';
	    //WHERE
	    $where['data'][] = array(
	      'column' => 'recept_packaging_retail_id',
	      'param'  => $this->input->get('id')
	    );
	    //JOIN
	    $join['data'][] = array(
	      'table' => 'packagings b',
	      'join'  => 'b.packaging_id=a.packaging_id',
	      'type'  => 'inner'
	    );
	    
	    $query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
	    if ($query<>false) {

	      foreach ($query->result() as $val) {
	        $response['val'][] = array(
	          'recept_packaging_retail_id'     => $val->recept_packaging_retail_id,
	          'packaging_id'    => $val->packaging_id,
	          'packaging_code'    => $val->packaging_code,
	          'recept_packaging_retail_date'     =>$this->format_date_day_mid2($val->recept_packaging_retail_date),
	          
	        );
	      }

	      echo json_encode($response);
	    }
  	}

  	public function action_data(){
		$id = $this->input->post('i_id');
		$id2 = $this->input->post('i_code');
		if (strlen($id)>0) {
			//UPDATE
			$data = $this->general_post_data($id);
			
			//WHERE
			$where['data'][] = array(
				'column' => 'recept_packaging_retail_id',
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
			//echo $data['packaging_img'];
			$insert = $this->g_mod->insert_data_table($this->tbl, NULL, $data);
			

			$data2['recept_packaging_retail_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'recept_packaging_retail_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('recept_packaging_retail_details', $where2, $data2);
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
		$id = $this->input->post("i_id");
		if ($id) {
			
		$edit_stock = $this->action_data_stock_edit($id);
		$where2['data'][] = array(
			'column' => 'recept_packaging_retail_id',
			'param'	 => $id
		);
		$where2['data'][] = array(
			'column' => 'user_id',
			'param'	 => $this->user_id
		);
		$delete = $this->g_mod->delete_data_table('recept_packaging_retail_details', $where2);


		$tbl = 'packaging_detail_items a';
		$select = 'a.*,b.item_name,c.item_detail_color';
		//LIMIT
		
		
		//WHERE
		$where['data'][] = array(
			'column' => 'packaging_id',
			'param'	 => $this->input->post("i_code")
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
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);

		foreach ($query->result() as $row){ 
			$row->packaging_detail_item_id;
			$data = array(
				'recept_packaging_retail_id' 			=> $this->input->post('i_id', TRUE),
				'packaging_detail_item_id' 			=> $row->packaging_detail_item_id,
				'recept_packaging_retail_detail_qty' 	=> $this->input->post('i_qty<?='.$row->packaging_detail_item_id.'?>'),
				'recept_packaging_retail_detail_sisa' 	=>  $row->packaging_box_qty - $this->input->post('i_qty<?='.$row->packaging_detail_item_id.'?>'),
				'user_id'						=>$this->user_id,

				);
				
			$insert = $this->g_mod->insert_data_table('recept_packaging_retail_details', NULL, $data);
			$this->g_mod->update_data_stock('packaging_detail_items','packaging_box','packaging_detail_item_id',$data['recept_packaging_retail_detail_sisa'],$row->packaging_detail_item_id);
			
			
		}
		}else{

		$where2['data'][] = array(
			'column' => 'recept_packaging_retail_id',
			'param'	 => $id
		);
		$where2['data'][] = array(
			'column' => 'user_id',
			'param'	 => $this->user_id
		);
		$delete = $this->g_mod->delete_data_table('recept_packaging_retail_details', $where2);


		$tbl = 'packaging_detail_items a';
		$select = 'a.*,b.item_name,c.item_detail_color';
		//LIMIT
		
		
		//WHERE
		$where['data'][] = array(
			'column' => 'packaging_id',
			'param'	 => $this->input->post("i_code")
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
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);

		foreach ($query->result() as $row){ 
			$row->packaging_detail_item_id;
			$data = array(
				'recept_packaging_retail_id' 			=> $this->input->post('i_id', TRUE),
				'packaging_detail_item_id' 			=> $row->packaging_detail_item_id,
				'recept_packaging_retail_detail_qty' 	=> $this->input->post('i_qty<?='.$row->packaging_detail_item_id.'?>'),
				'recept_packaging_retail_detail_sisa' 	=>  $row->packaging_box - $this->input->post('i_qty<?='.$row->packaging_detail_item_id.'?>'),
				'user_id'						=>$this->user_id,

				);
				
			$insert = $this->g_mod->insert_data_table('recept_packaging_retail_details', NULL, $data);
			$this->g_mod->update_data_stock('packaging_detail_items','packaging_box','packaging_detail_item_id',$data['recept_packaging_retail_detail_qty'],$row->packaging_detail_item_id);
		}
		}
		}

		public function action_data_stock($id){
			$tbl = 'packaging_detail_items a';
		$select = 'a.*,b.item_name,c.item_detail_color';
		//LIMIT
		
		
		//WHERE
		$where['data'][] = array(
			'column' => 'packaging_id',
			'param'	 => $id
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
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);

		foreach ($query->result() as $row){ 
			
		$id = $row->packaging_detail_item_id;
		
		$data = array(
			'recept_packaging_retail_detail_qty' 	=> $this->input->post('i_qty<?='.$row->packaging_detail_item_id.'?>'),
			'item_detail_id' 				=> $row->item_detail_id,
			'packaging_box' 				=> $row->packaging_box,
			'packaging_box_qty' 			=> $row->packaging_box_qty,
			'packaging_retail' 				=> $row->packaging_retail,
			'user_id' 						=> $this->user_id
		);
			

			$retail = $data['packaging_retail'];
			$box 	= $data['recept_packaging_retail_detail_qty'] /** $data['packaging_box']*/;
			$stock_gudang 	= $box + $retail;


			if ($box) {
				//WHERE
				$where3['data'][] = array(
					'column' => 'item_detail_id',
					'param'	 => $data['item_detail_id']
				);
				//WHERE
				$where3['data'][] = array(
					'column' => 'warehouse_id',
					'param'	 => 1
				);
				//WHERE
				$where3['data'][] = array(
					'column' => 'package_id',
					'param'	 => 1
				);

				$query_box = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where3);
				if ($query_box<>false) {
					$where4 = 'and warehouse_id = 1 and package_id = 1';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',-$box,$data['item_detail_id'],$where4);
				}else{
					$data_box['item_detail_id'] 	= $data['item_detail_id'];
					$data_box['warehouse_id'] 		= 1;
					$data_box['stock_qty'] 			= $box;
					$data_box['package_id'] 		= 1;

					$this->g_mod->insert_data_table('stocks', NULL, $data_box);
				}
			}

			if ($retail) {
				//WHERE
				$where5['data'][] = array(
					'column' => 'item_detail_id',
					'param'	 => $data['item_detail_id']
				);
				//WHERE
				$where5['data'][] = array(
					'column' => 'warehouse_id',
					'param'	 => 1
				);
				//WHERE
				$where5['data'][] = array(
					'column' => 'package_id',
					'param'	 => 2
				);

				$query_retail = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where5);
				if ($query_retail<>false) {
					$where6 = 'and warehouse_id = 1 and package_id = 2';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',-$retail,$data['item_detail_id'],$where6);
				}else{
					$data_retail['item_detail_id'] 		= $data['item_detail_id'];
					$data_retail['warehouse_id'] 		= 1;
					$data_retail['stock_qty'] 			= $retail;
					$data_retail['package_id'] 			= 2;

					$this->g_mod->insert_data_table('stocks', NULL, $data_retail);
				}
			}

			$where7 = 'and warehouse_id = 1 and package_id = 0';
			$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$stock_gudang,$data['item_detail_id'],$where7);



		}
	}

	public function action_data_stock_edit($id){
		$sql = "SELECT a.*,b.item_detail_id,b.packaging_box,b.packaging_box_qty,b.packaging_retail FROM recept_packaging_retail_details a JOIN packaging_detail_items b ON b.packaging_detail_item_id = a.packaging_detail_item_id LEFT JOIN items c ON c.item_id = b.item_id WHERE recept_packaging_retail_id =$id";

		$query = $this->g_mod->select_manual_for($sql);

		foreach ($query->result() as $row){ 
			
		$id2 = $row->recept_packaging_retail_detail_id;
		
		$data = array(
			'recept_packaging_retail_detail_qty' 	=> $row->recept_packaging_retail_detail_qty,
			'item_detail_id' 				=> $row->item_detail_id,
			'packaging_box' 				=> $row->packaging_box,
			'packaging_box_qty' 			=> $row->packaging_box_qty,
			'packaging_retail' 				=> $row->packaging_retail,
			'user_id' 						=> $this->user_id
		);
		//$this->g_mod->update_data_stock('packaging_detail_items','packaging_box_qty','packaging_detail_item_id',-$row->recept_packaging_retail_detail_sisa,$row->packaging_detail_item_id);

			$retail = $data['packaging_retail'];
			$box 	= $data['recept_packaging_retail_detail_qty'] /** $data['packaging_box']*/;
			$stock_gudang 	= $box + $retail;


			if ($box) {
				//WHERE
				$where3['data'][] = array(
					'column' => 'item_detail_id',
					'param'	 => $data['item_detail_id']
				);
				//WHERE
				$where3['data'][] = array(
					'column' => 'warehouse_id',
					'param'	 => 1
				);
				//WHERE
				$where3['data'][] = array(
					'column' => 'package_id',
					'param'	 => 1
				);

				$query_box = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where3);
				if ($query_box<>false) {
					$where4 = 'and warehouse_id = 1 and package_id = 1';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$box,$data['item_detail_id'],$where4);
				}else{
					$data_box['item_detail_id'] 	= $data['item_detail_id'];
					$data_box['warehouse_id'] 		= 1;
					$data_box['stock_qty'] 			= $box;
					$data_box['package_id'] 		= 1;

					$this->g_mod->insert_data_table('stocks', NULL, $data_box);
				}
			}

			if ($retail) {
				//WHERE
				$where5['data'][] = array(
					'column' => 'item_detail_id',
					'param'	 => $data['item_detail_id']
				);
				//WHERE
				$where5['data'][] = array(
					'column' => 'warehouse_id',
					'param'	 => 1
				);
				//WHERE
				$where5['data'][] = array(
					'column' => 'package_id',
					'param'	 => 2
				);

				$query_retail = $this->g_mod->select('*','stocks',NULL,NULL,NULL,NULL,$where5);
				if ($query_retail<>false) {
					$where6 = 'and warehouse_id = 1 and package_id = 2';
					$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',$retail,$data['item_detail_id'],$where6);
				}else{
					$data_retail['item_detail_id'] 		= $data['item_detail_id'];
					$data_retail['warehouse_id'] 		= 1;
					$data_retail['stock_qty'] 			= $retail;
					$data_retail['package_id'] 			= 2;

					$this->g_mod->insert_data_table('stocks', NULL, $data_retail);
				}
			}

			$where7 = 'and warehouse_id = 1 and package_id = 0';
			$this->g_mod->update_data_stock('stocks','stock_qty','item_detail_id',-$stock_gudang,$data['item_detail_id'],$where7);

		}
	}

	function get_code_recept_packaging_retail(){
        $bln = date('m');
        $thn = date('Y');
        $select = 'MID(recept_packaging_retail_code,9,5) as id';
        $where['data'][] = array(
            'column' => 'MID(recept_packaging_retail_code,1,8)',
            'param'     => 'RR'.$thn.''.$bln.''
        );
        $order['data'][] = array(
            'column' => 'recept_packaging_retail_code',
            'type'     => 'DESC'
        );
        $limit = array(
            'start'  => 0,
            'finish' => 1
        );
        $query = $this->g_mod->select($select,$this->tbl,$limit,NULL,$order,NULL,$where);
        $new_code = $this->format_kode_transaksi('RR',$query);
        return $new_code;
    }


	function general_post_data($id){

		if (!$id) {
			$data['recept_packaging_retail_code'] = $this->get_code_recept_packaging_retail();
		}

		$data['packaging_id'] = $this->input->post('i_code', TRUE);
		$data['recept_packaging_retail_date'] =$this->format_date_day_mid($this->input->post('i_date', TRUE));
		
		
		return $data;
	}

	
	public function delete_data(){
		$id = $this->input->post('id');
		//WHERE
		$where['data'][] = array(
			'column' => 'recept_packaging_retail_id',
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
			'column' => 'recept_packaging_retail_detail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('recept_packaging_retail_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function hapus2($id){
		//WHERE
		$where['data'][] = array(
			'column' => 'recept_packaging_retail_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table('recept_packaging_retail_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	public function hapus($id){
		//WHERE
		$where['data'][] = array(
			'column' => 'recept_packaging_retail_id',
			'param'	 => 0
		);
		$delete = $this->g_mod->delete_data_table('recept_packaging_retail_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

}