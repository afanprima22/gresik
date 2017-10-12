<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends MY_Controller {
	private $any_error = array();
	public $tbl = 'locations';

	public function __construct() {
        parent::__construct();
        $this->check_user_access();

        $akses = $this->g_mod->get_user_acces($this->user_id,68);
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
			'title_page' 	=> 'Setup Data / Lokasi',
			'title' 		=> 'Kelolah Data',
			'c'				=> $c
			);

		$this->open_page('location_v', $data);
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
		$select = '*';
		//LIMIT
		$limit = array(
			'start'  => $this->input->get('start'),
			'finish' => $this->input->get('length')
		);
		//WHERE LIKE
		$where_like['data'][] = array(
			'column' => 'location_name,location_code',
			'param'	 => $this->input->get('search[value]')
		);
		//ORDER
		$index_order = $this->input->get('order[0][column]');
		$order['data'][] = array(
			'column' => $this->input->get('columns['.$index_order.'][name]'),
			'type'	 => $this->input->get('order[0][dir]')
		);

		$query_total = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,NULL);
		$query_filter = $this->g_mod->select($select,$this->tbl,NULL,$where_like,$order,NULL,NULL);
		$query = $this->g_mod->select($select,$this->tbl,$limit,$where_like,$order,NULL,NULL);

		$response['data'] = array();
		if ($query<>false) {
			$no = $limit['start']+1;
			foreach ($query->result() as $val) {
				if ($val->location_id>0) {
					$kab = ($val->location_kabupatenkota != 0) ? 1 : 0;
					$kec = ($val->location_kecamatan != 0) ? 1 : 0;
					$kel = ($val->location_kelurahan != 0) ? 1 : 0;
					$jml = $kab + $kec + $kel;

					switch ($val->location_type) {
						case '1':
							$tingkat = "Provinsi";
							break;
						case '2':
							$tingkat = "Kabupaten/Kota";
							break;
						case '3':
							$tingkat = "Kecamatan";
							break;
						case '4':
							$tingkat = "Kelurahan";
							break;
						default:
							$tingkat = "Provinsi";
							break;
					}

					$response['data'][] = array(
						$no,
						$val->location_code,
						'<p style="padding-left:'.$jml.'em;">'.$val->location_name,
						$tingkat,
						'<button class="btn btn-primary btn-xs" type="button" onclick="edit_data('.$val->location_id.'),reset()" '.$u.'><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="delete_data('.$val->location_id.')" '.$d.'><i class="glyphicon glyphicon-trash"></i></button>'
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
			'column' => 'location_id',
			'param'	 => $this->input->get('id')
		);
		$query = $this->g_mod->select($select,$this->tbl,NULL,NULL,NULL,NULL,$where);
		if ($query<>false) {

			foreach ($query->result() as $val) {
				$response['val'][] = array(
					'location_id'			=> $val->location_id,
					'location_name' 		=> $val->location_name,
					'location_type' 		=> $val->location_type,
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
				'column' => 'location_id',
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
			'column' => 'location_id',
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
		$location 	= $this->input->post('i_location', TRUE);
		$type 		= $this->input->post('i_type', TRUE);

		if ($location) {
			$result = $this->g_mod->read_data('*','locations','location_id',$location);

			$prov 	= substr($result['location_code'],0,2);
			$kab 	= substr($result['location_code'],3,2);
			$kec 	= substr($result['location_code'],6,2);

			
		}

		switch ($type) {
			case '1':
				$where 	= "where location_kabupatenkota = 0 and location_kecamatan = 0 and location_kelurahan = 0";
				break;
			case '2':
				$where 	= "where location_kabupatenkota != 0 and location_kecamatan = 0 and location_kelurahan = 0 and location_code like '$prov.%'";
				break;
			case '3':
				$where 	= "where location_kabupatenkota != 0 and location_kecamatan != 0 and location_kelurahan = 0 and location_code like '$prov.$kab.%'";
				break;
			case '4':
				$where 	= "where location_kabupatenkota != 0 and location_kecamatan != 0 and location_kelurahan != 0 and location_code like '$prov.$kab.$kec.%'";
				break;
			default:
				$where 	= "";
				break;
		}

		$sql = "select * from locations $where order by location_code desc limit 1";
		$result2 = $this->g_mod->select_manual($sql);

		$prov 	= substr($result2['location_code'],0,2);
		$kab 	= substr($result2['location_code'],3,2);
		$kec 	= substr($result2['location_code'],6,2);
		$kel 	= substr($result2['location_code'],9,4);

		switch ($type) {
			case '1':
				$prov 	= $prov +1;
				$kab 	= '00';
				$kec 	= '00';
				$kel 	= '0000';
				$code 	= "$prov.$kab.$kec.$kel";
				break;
			case '2':
				$prov 	= $prov;
				$kab 	= $kab + 1;
				$kec 	= '00';
				$kel 	= '0000';
				$code 	= "$prov.$kab.$kec.$kel";
				break;
			case '3':
				$prov 	= $prov;
				$kab 	= $kab;
				$kec 	= $kec + 1;
				$kel 	= '0000';
				$code 	= "$prov.$kab.$kec.$kel";
				break;
			case '4':
				$prov 	= $prov +1;
				$kab 	= $kab;
				$kec 	= $kec;
				$kel 	= $kel + 1;
				$code 	= "$prov.$kab.$kec.$kel";
				break;
			default:
				$code 	= "";
				$prov 	= "";
				$kab 	= "";
				$kec 	= "";
				$kel 	= "";
				break;
		}

		$data = array(
			'location_code' 			=> $code,
			'location_name' 			=> $this->input->post('i_name', TRUE),
			'location_province' 		=> $prov,
			'location_kabupatenkota' 	=> $kab,
			'location_kecamatan' 		=> $kec,
			'location_kelurahan' 		=> $kel,
			'location_type' 			=> $this->input->post('i_type', TRUE)
			);

		return $data;
	}

	public function load_data_select_location($id = 0){
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

		if ($id) {
			//WHERE
			$where['data'][] = array(
				'column' => 'location_type',
				'param'	 => $id
			);
			$query = $this->g_mod->select('*','locations',NULL,$where_like,$order,NULL,$where);
		}else{
			$query = $this->g_mod->select('*','locations',NULL,$where_like,$order,NULL,NULL);
		}
		
		$response['items'] = array();
		if ($query<>false) {
			foreach ($query->result() as $val) {
				$response['items'][] = array(
					'id'	=> $val->location_id,
					'text'	=> $val->location_code.' - '.$val->location_name
				);
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	}
	/* end Function */

}
