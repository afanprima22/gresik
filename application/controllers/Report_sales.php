<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_sales extends MY_Controller {
	private $any_error = array();
	public $tbl = 'Report_saless';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,84);
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
			'title_page' 	=> 'Laporan / Penjualan',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('report_sales_v', $data);
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
		$tbl = 'Report_saless a';
		$select = '*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'a.report_sales_date1,a.report_sales_date2',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,NULL,NULL);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,NULL,NULL);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,NULL,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->report_sales_id>0) {
					$response['data'][] = array(
						$val->report_sales_date,
						$val->report_sales_date1.' - '.$val->report_sales_date2,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->report_sales_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->report_sales_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
		$tbl = 'report_sales_details a';
		$select = 'a.*,b.nota_code';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'nota_code',
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
			'table' => 'notas b',
			'join'	=> 'b.nota_id=a.nota_id',
			'type'	=> 'inner'
		);

		$where['data'][] = array(
			'column' => 'a.report_sales_id',
			'param'	 => $id
		);

		//WHERE
		$where['data'][] = array(
			'column' => 'a.user_id',
			'param'	 => $this->user_id
		);

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->report_sales_detail_id>0) {
					$response['data'][] = array(
						$val->nota_code,
						number_format($val->report_sales_detail_nominal),
						'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_detail_nota('.$val->nota_id.')"><i class="glyphicon glyphicon-search"></i></a>'	
						
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

	public function load_data_invoice(){
		$city =$this->input->get('id');
		$sql = "SELECT * FROM `locations` WHERE location_id = $city";
		$row = $this->g_mod->select_manual($sql);
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$id =$this->input->get('id1');
		$id2 =$this->input->get('id2');
		$date1 = $this->format_date_day_mid($id);
		$date2 = $this->format_date_day_mid($id2);
		
		$tbl = 'notas a';
		$select = 'a.*,b.location_id';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'a.nota_code',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][]=array(
			'table'	=>'customers b',
			'join'	=>'b.customer_id=a.customer_id',
			'type'	=>'inner'
			);

		$join['data'][]=array(
			'table'	=>'locations c',
			'join'	=>'c.location_id=b.location_id',
			'type'	=>'left'
			);
		if ($row['location_kelurahan'] !=0) {
			$where['data'][]=array(
			'column'	=>'b.location_id',
			'param'		=>$city
			);
		}else if ($row['location_kecamatan'] !=0) {
			$where['data'][]=array(
			'column'	=>'c.location_kecamatan',
			'param'		=>$row['location_kecamatan']
			);
		}else if ($row['location_kabupatenkota'] !=0) {
			$where['data'][]=array(
			'column'	=>'c.location_kabupatenkota',
			'param'		=>$row['location_kabupatenkota']
			);
		}else if ($row['location_province'] !=0) {
			$where['data'][]=array(
			'column'	=>'c.location_province',
			'param'		=>$row['location_province']
			);
		}
		

		$where2 = "nota_date >='$date2' and nota_date <='$date1'";

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where,$where2);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,$where,$where2);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,$where,$where2);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				$nota = $val->nota_id;
				$sql ="SELECT SUM(b.nota_detail_qty*b.nota_detail_price*b.nota_detail_discount/100) as total FROM notas a LEFT JOIN nota_details b on b.nota_id = a.nota_id WHERE a.nota_id = $nota ";
				$row = $this->g_mod->select_manual($sql);

				$sql2 ="SELECT SUM(nota_detail_qty*nota_detail_price) as total2, SUM(nota_detail_discount) as discount FROM nota_details a LEFT JOIN notas b on b.nota_id = a.nota_id WHERE a.nota_id = $nota ";
				$row2 = $this->g_mod->select_manual($sql2);
				$total3 = $val->nota_discount*$row2['total2']/100;
				if ($val->nota_id>0) {
					$response['data'][] = array(
						$val->nota_code,
						number_format($row2['total2']-$row['total']-$total3),
						'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_detail_nota('.$val->nota_id.')"><i class="glyphicon glyphicon-search"></i></a>'

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
			$response['lokasi'] = $city;

		echo json_encode($response);
	}

	public function load_data_invoice2(){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$cuss = $this->input->get('id');
		$id =$this->input->get('id1');
		$id2 =$this->input->get('id2');
		$date1 = $this->format_date_day_mid($id);
		$date2 = $this->format_date_day_mid($id2);
		
		$tbl = 'notas a';
		$select = 'a.*,b.customer_id';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'a.nota_code',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$join['data'][]=array(
			'table'	=>'customers b',
			'join'	=>'b.customer_id=a.customer_id',
			'type'	=>'inner'
			);
		if ($cuss !=0) {
			$where = "nota_date >='$date2' and nota_date <='$date1' and b.customer_id = $cuss";
		}else{
			$where = "nota_date >='$date2' and nota_date <='$date1'";
		}

		

		$query_total = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL,$where);
		$query_filter = $this->g_mod->select($select,$tbl,NULL,$where_like,$order,$join,NULL,$where);
		$query = $this->g_mod->select($select,$tbl,$limit,$where_like,$order,$join,NULL,$where);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				$nota = $val->nota_id;
				$sql ="SELECT SUM(b.nota_detail_qty*b.nota_detail_price*b.nota_detail_discount/100) as total FROM notas a LEFT JOIN nota_details b on b.nota_id = a.nota_id WHERE a.nota_id = $nota ";
				$row = $this->g_mod->select_manual($sql);

				$sql2 ="SELECT SUM(nota_detail_qty*nota_detail_price) as total2, SUM(nota_detail_discount) as discount FROM nota_details a LEFT JOIN notas b on b.nota_id = a.nota_id WHERE a.nota_id = $nota ";
				$row2 = $this->g_mod->select_manual($sql2);
				$total3 = $val->nota_discount*$row2['total2']/100;
				if ($val->nota_id>0) {
					$response['data'][] = array(
						$val->nota_code,
						number_format($row2['total2']-$row['total']-$total3),
						'<a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal" onclick="search_data_detail_nota('.$val->nota_id.')"><i class="glyphicon glyphicon-search"></i></a>'

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

	public function load_data_detail_nota($id){
		$u = 'disabled'; $d = 'disabled';
		if (strpos($this->permit, 'u') !== false){
			$u = '';
		}else{

		}
		if (strpos($this->permit, 'd') !== false){
			$d = '';
		}
		$tbl = 'nota_details a';
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
			'column' => 'nota_id',
			'param'	 => $id
		);

		

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
				if ($val->nota_detail_id>0) {

					

					$response['data'][] = array(
						$val->item_name,
						number_format($val->nota_detail_price),
						$val->nota_detail_qty,
						$val->nota_detail_discount,
						number_format($val->nota_detail_price*$val->nota_detail_qty),
						
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
		$select = 'a.*,b.customer_name,c.location_name as prov,d.location_name as kab,e.location_name as kec,f.location_name as kel';
		$tbl = 'Report_saless a';
		//JOIN
		$join['data'][]=array(
			'table'	=>'customers b',
			'join'	=>'b.customer_id=a.customer_id',
			'type'	=>'LEFT'
			);

		$join['data'][]=array(
			'table'	=>'locations c',
			'join'	=>'c.location_id=a.location_id',
			'type'	=>'LEFT'
			);
		$join['data'][]=array(
			'table'	=>'locations d',
			'join'	=>'d.location_id=a.location_id2',
			'type'	=>'LEFT'
			);
		$join['data'][]=array(
			'table'	=>'locations e',
			'join'	=>'e.location_id=a.location_id3',
			'type'	=>'LEFT'
			);
		$join['data'][]=array(
			'table'	=>'locations f',
			'join'	=>'f.location_id=a.location_id4',
			'type'	=>'LEFT'
			);
		//WHERE
		$where['data'][] = array(
			'column' => 'report_sales_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'report_sales_id'		=>$val->report_sales_id,
					'report_sales_type'		=>$val->report_sales_type,
					'customer_id'		=>$val->customer_id,
					'customer_name'		=>$val->customer_name,
					'location_id'		=>$val->location_id,
					'prov'				=>$val->prov,
					'location_id2'		=>$val->location_id2,
					'kab'				=>$val->kab,
					'location_id3'		=>$val->location_id3,
					'kec'				=>$val->kec,
					'location_id4'		=>$val->location_id4,
					'kel'				=>$val->kel,
					'report_sales_date1' 	=> $this->format_date_day_mid2($val->report_sales_date1),
					'report_sales_date2'	=>$this->format_date_day_mid2($val->report_sales_date2),
					'report_sales_date' 	=> $this->format_date_day_mid2($val->report_sales_date),

				);
			}

			echo json_encode($response);
		}
	}

	public function action_data(){
		$id = $this->input->post('i_id');
		if (strlen($id)>0) {
			//UPDATE
			$where2['data'][] = array(
				'column' => 'report_sales_id',
				'param'	 => $id
			);
			$delete2 = $this->g_mod->delete_data_table('report_sales_details', $where2);
			$data = $this->general_post_data();

			//WHERE
			$where['data'][] = array(
				'column' => 'report_sales_id',
				'param'	 => $id
			);
			$update = $this->g_mod->update_data_table($this->tbl, $where, $data);
			$data2['report_sales_id'] = $id;
			//WHERE
			$where3['data'][] = array(
				'column' => 'report_sales_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('report_sales_details', $where3, $data2);

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
			
			$data2['report_sales_id'] = $insert->output;
			//WHERE
			$where2['data'][] = array(
				'column' => 'report_sales_id',
				'param'	 => 0
			);
			//WHERE
			$where2['data'][] = array(
				'column' => 'user_id',
				'param'	 =>$this->user_id
			);
			$update = $this->g_mod->update_data_table('report_sales_details', $where2, $data2);
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
			'column' => 'report_sales_id',
			'param'	 => $id
		);
		$delete = $this->g_mod->delete_data_table($this->tbl, $where);
		$delete2 = $this->g_mod->delete_data_table('report_sales_details', $where);
		if($delete->status) {
			$response['status'] = '200';
			$response['alert'] = '3';
		} else {
			$response['status'] = '204';
		}

		echo json_encode($response);
	}

	

	function general_post_data(){
		$prov = $this->input->post('i_prov');
		$kab = $this->input->post('i_kab');
		$kec = $this->input->post('i_kec');
		$kel = $this->input->post('i_kel');
		$cuss = $this->input->post('i_customer');
		if (!$prov) {
			$prov=0;
		}
		if (!$kab) {
			$kab=0;
		}
		if (!$kec) {
			$kec=0;
		}
		if (!$kel) {
			$kel=0;
		}
		if (!$cuss) {
			$cuss=0;
		}
		$data = array(
			'report_sales_date' 					=> $this->format_date_day_mid($this->input->post('i_date_report')),
			'report_sales_date1' 					=> $this->format_date_day_mid($this->input->post('i_date1')),
			'report_sales_date2' 					=> $this->format_date_day_mid($this->input->post('i_date2')),
			'customer_id' 					=>$cuss,
			'location_id' 					=>$prov,
			'location_id2' 					=>$kab,
			'location_id3' 					=>$kec,
			'location_id4' 					=>$kel,
			'report_sales_type' 					=>$this->input->post('i_type', TRUE),
			
			);

		$date1 =$data['report_sales_date2'];
		$date2 =$data['report_sales_date1'];
		
		$tbl = 'notas a';
		$select = 'a.*,b.customer_id,b.location_id,c.*';
		

		$join['data'][]=array(
			'table'	=>'customers b',
			'join'	=>'b.customer_id=a.customer_id',
			'type'	=>'left'
			);

		$join['data'][]=array(
			'table'	=>'locations c',
			'join'	=>'c.location_id=b.location_id',
			'type'	=>'left'
			);
		$sql1 = "SELECT * FROM `locations` WHERE location_id = $prov";
		$row = $this->g_mod->select_manual($sql1);
		$provinsi = $row['location_province'];

		$sql2 = "SELECT * FROM `locations` WHERE location_id = $kab";
		$row2 = $this->g_mod->select_manual($sql2);
		$kabupaten = $row2['location_kabupatenkota'];

		$sql3 = "SELECT * FROM `locations` WHERE location_id = $kec";
		$row3 = $this->g_mod->select_manual($sql3);
		$kecamatan = $row3['location_kecamatan'];

		if ($data['report_sales_type'] ==2) {
			if ($data['customer_id'] ==0) {
				$where2 = "nota_date >='$date2' and nota_date <='$date1'";
			}else{
				$where2 = "nota_date >='$date2' and nota_date <='$date1' and b.customer_id = $cuss";
			}
			
		}else if ($data['report_sales_type'] ==1) {
			if ($kel !=0) {
				$where2 = "nota_date >='$date2' and nota_date <='$date1' and b.location_id = $kel";
			}else if($kec !=0){
				$where2 = "nota_date >='$date2' and nota_date <='$date1' and c.location_kecamatan = $kecamatan";
			}else if ($kab !=0) {
				$where2 = "nota_date >='$date2' and nota_date <='$date1' and c.location_kabupatenkota = $kabupaten";
			}else if ($prov !=0) {
				$where2 = "nota_date >='$date2' and nota_date <='$date1' and c.location_province = $provinsi";
			}
			
		}
		

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,NULL,$where2);

		
			foreach ($query->result() as $val) {
				$nota = $val->nota_id;
				$sql ="SELECT SUM(b.nota_detail_qty*b.nota_detail_price*b.nota_detail_discount/100) as total FROM notas a LEFT JOIN nota_details b on b.nota_id = a.nota_id WHERE a.nota_id = $nota ";
				$row = $this->g_mod->select_manual($sql);

				$sql2 ="SELECT SUM(nota_detail_qty*nota_detail_price) as total2, SUM(nota_detail_discount) as discount FROM nota_details a LEFT JOIN notas b on b.nota_id = a.nota_id WHERE a.nota_id = $nota ";
				$row2 = $this->g_mod->select_manual($sql2);
				$total3 = $val->nota_discount*$row2['total2']/100;
				/*if ($val->nota_id>0) {
					$response['data'][] = array(
						$val->nota_code,
						number_format($row2['total2']-$row['total']-$total3),

					);
				}*/
					$data2['nota_id'] = $val->nota_id;
					$data2['report_sales_detail_nominal'] = $row2['total2']-$row['total']-$total3;
					$data2['user_id'] = $this->user_id;

					$insert = $this->g_mod->insert_data_table('report_sales_details', NULL, $data2);
					
			}
			

		return $data;
	}

	function general_post_data_detail($cuss,$city,$id1,$id2){
		
		
		$date1 = $this->format_date_day_mid($id2);
		$date2 = $this->format_date_day_mid($id1);
		
		$tbl = 'notas a';
		$select = 'a.*,b.customer_id,b.city_id';
		

		$join['data'][]=array(
			'table'	=>'customers b',
			'join'	=>'b.customer_id=a.customer_id',
			'type'	=>'left'
			);

		$join['data'][]=array(
			'table'	=>'cities c',
			'join'	=>'c.city_id=b.city_id',
			'type'	=>'left'
			);

		if ($city ==0) {
			$where['data'][]=array(
				'column'	=>'a.customer_id',
				'param'		=>$cuss
				);
		}else if ($cuss ==0) {
			$where['data'][]=array(
				'column'	=>'b.city_id',
				'param'		=>$city
				);
		}
		$where2 = "nota_date >='$date2' and nota_date <='$date1";

		$query = $this->g_mod->select($select,$tbl,NULL,NULL,NULL,$join,$where,$where2);

		$response['data'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$nota = $val->nota_id;
				$sql ="SELECT SUM(b.nota_detail_qty*b.nota_detail_price*b.nota_detail_discount/100) as total FROM notas a LEFT JOIN nota_details b on b.nota_id = a.nota_id WHERE a.nota_id = $nota ";
				$row = $this->g_mod->select_manual($sql);

				$sql2 ="SELECT SUM(nota_detail_qty*nota_detail_price) as total2, SUM(nota_detail_discount) as discount FROM nota_details a LEFT JOIN notas b on b.nota_id = a.nota_id WHERE a.nota_id = $nota ";
				$row2 = $this->g_mod->select_manual($sql2);
				$total3 = $val->nota_discount*$row2['total2']/100;
				if ($val->nota_id>0) {
					$response['data'][] = array(
						$val->nota_code,
						number_format($row2['total2']-$row['total']-$total3),

					);
					$data['nota_id'] = $val->nota_id;
					$data['report_sales_detail_nominal'] = $row2['total2']-$row['total']-$total3;
					$data['user_id'] = $this->user_id;

					$insert = $this->g_mod->insert_data_table('report_sales_details', NULL, $data);
					
				}
			}
		}
	}

	public function load_data_select_provinsi(){
		//WHERE LIKE
		
		
		$where_like['data'][] = array(
			'column' => 'location_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'location_name',
			'type'	 => 'ASC'
		);

		/*$where['data'][]=array(
			'column'	=>'location_type',
			'param'		=>0 or 1
		);*/

		$where2 = "location_type=0 or location_type=1";


		$query = $this->g_mod->select('*','locations',NULL,$where_like,$order,NULL,NULL,$where2);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->location_id,
					'text'	=> $val->location_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_kabupaten($id){
		$sql = "SELECT * FROM `locations` WHERE location_id = $id";
		$row = $this->g_mod->select_manual($sql);
		
		
		$where_like['data'][] = array(
			'column' => 'location_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'location_name',
			'type'	 => 'ASC'
		);

		$where['data'][]=array(
			'column'	=>'location_type',
			'param'		=>2
		);

		$where['data'][]=array(
			'column'	=>'location_province',
			'param'		=>$row['location_province']
		);


		$query = $this->g_mod->select('*','locations',NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->location_id,
					'text'	=> $val->location_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_kecamatan($id){
		$sql = "SELECT * FROM `locations` WHERE location_id = $id";
		$row = $this->g_mod->select_manual($sql);
		
		
		$where_like['data'][] = array(
			'column' => 'location_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'location_name',
			'type'	 => 'ASC'
		);

		$where['data'][]=array(
			'column'	=>'location_type',
			'param'		=>3
		);

		$where['data'][]=array(
			'column'	=>'location_province',
			'param'		=>$row['location_province']
		);

		$where['data'][]=array(
			'column'	=>'location_kabupatenkota',
			'param'		=>$row['location_kabupatenkota']
		);


		$query = $this->g_mod->select('*','locations',NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->location_id,
					'text'	=> $val->location_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_kelurahan($id){
		$sql = "SELECT * FROM `locations` WHERE location_id = $id";
		$row = $this->g_mod->select_manual($sql);
		
		
		$where_like['data'][] = array(
			'column' => 'location_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'location_name',
			'type'	 => 'ASC'
		);

		$where['data'][]=array(
			'column'	=>'location_type',
			'param'		=>4
		);

		$where['data'][]=array(
			'column'	=>'location_kecamatan',
			'param'		=>$row['location_kecamatan']
		);

		$where['data'][]=array(
			'column'	=>'location_province',
			'param'		=>$row['location_province']
		);

		$where['data'][]=array(
			'column'	=>'location_kabupatenkota',
			'param'		=>$row['location_kabupatenkota']
		);

		$query = $this->g_mod->select('*','locations',NULL,$where_like,$order,NULL,$where);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->location_id,
					'text'	=> $val->location_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	public function load_data_select_customer(){
		//WHERE LIKE
		
		
		$where_like['data'][] = array(
			'column' => 'customer_name',
			'param'	 => $this->input->get('q')
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'customer_name',
			'type'	 => 'ASC'
		);


		$query = $this->g_mod->select('*','customers',NULL,$where_like,$order,NULL,NULL);
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->customer_id,
					'text'	=> $val->customer_name,
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}

	/* end Function */

}