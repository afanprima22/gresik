<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public $admin_granted = false;
	public $logged_in = false;
	public $logged_in2 = false;

	public $user_id;
	public $permit;

	public function __construct() {
		parent::__construct();
		$this->is_logged_in();
		$this->user_has_access();
		
		
	}	
	
	function is_logged_in() {
	   	$user = $this->session->userdata('logged');
	   	if($user=="")
	   		$this->logged_in = false;
	   	else
	   		$this->logged_in = true;
	   		$this->user_id = $this->session->userdata('user_id');
	}

	function user_has_access(){
		$user_level = $this->session->userdata('level');
		if($user_level!=0)
			$this->admin_granted = true;
		else if($user_level==0)
			$this->admin_granted = false;
	}

	function check_authorized($table,$id){
		if ($table == 'mainmenu') {
			$table1 = $table;
			$id1 = 'idmenu';
			$status1 = 'status_menu';
		} else if ($table == 'submenu') {
			$table1 = $table;
			$id1 = 'idsub';
			$status1 = 'status_submenu';
		}
		$select = 'a.*,b.*';
		$tbl =  $table1.' a';
		//JOIN
		$join['data'][] = array(
			'table' => $table1.'_akses b',
			'join'	=> 'b.'.$table1.'_'.$id1.'=a.'.$id1,
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'b.st_level_user_kode',
			'param'	 => $this->session->userdata('level')
		);
		$where['data'][] = array(
			'column' => 'a.'.$status1,
			'param'	 => 1
		);
		$where['data'][] = array(
			'column' => 'a.'.$id1,
			'param'	 => $id
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'a.index',
			'type'	 => 'ASC'
		);
		$query = $this->mod->select($select,$tbl,NULL,NULL,$order,$join,$where);
		foreach ($query->result() as $row) {
			$data = array(
				'c' => $row->c,
				'r' => $row->r,
				'u' => $row->u,
				'd' => $row->d,
			);
		}
		return $data;
	}

	function open_page($file_name, $data=null){
		/*$select = 'a.*,b.*';
		$tbl = 'mainmenu a';
		//JOIN
		$join['data'][] = array(
			'table' => 'mainmenu_akses b',
			'join'	=> 'b.mainmenu_idmenu=a.idmenu',
			'type'	=> 'inner'
		);
		//WHERE
		$where['data'][] = array(
			'column' => 'b.st_level_user_kode',
			'param'	 => $this->session->userdata('level')
		);
		$where['data'][] = array(
			'column' => 'a.status_menu',
			'param'	 => 1
		);
		//ORDER
		$order['data'][] = array(
			'column' => 'a.index',
			'type'	 => 'ASC'
		);
		$data['mainmenu'] = $this->mod->select($select,$tbl,NULL,NULL,$order,$join,$where);

		$select2 = 'a.*,b.*';
		$tbl2 = 'submenu a';
		//JOIN
		$join2['data'][] = array(
			'table' => 'submenu_akses b',
			'join'	=> 'b.submenu_idsub=a.idsub',
			'type'	=> 'inner'
		);
		//WHERE
		$where2['data'][] = array(
			'column' => 'b.st_level_user_kode',
			'param'	 => $this->session->userdata('level')
		);
		$where2['data'][] = array(
			'column' => 'a.status_submenu',
			'param'	 => 1
		);
		//ORDER
		$order2['data'][] = array(
			'column' => 'a.index',
			'type'	 => 'ASC'
		);
		$data['submenu'] = $this->mod->select($select2,$tbl2,NULL,NULL,$order2,$join2,$where2);*/

		$this->load->view('layout/header', $data);
		$this->load->view($file_name);
	}

	function format_money_id($value){
		$format = "RP ".number_format($value,0,',','.');
		return $format;
	}

	function format_kode_transaksi($type,$query){
		$bln = date('m');
		$thn = date('Y');
		if ($query<>false) {
			foreach ($query->result() as $row) {
				$urut = intval($row->id);
				if ($urut==0) {
					$urut++;
					$seq = '000'.$urut;
				} else {
					if ($urut<9) {
						$urut++;
						$seq = '000'.$urut;
					} else if ($urut<99) {
						$urut++;
						$seq = '00'.$urut;
					} else if ($urut<999) {
						$urut++;
						$seq = '0'.$urut;
					} else {
						$urut++;
						$seq = $urut;
					}
				}
			}
		} else {
			$seq = '0001';
		}
		//$kode_baru = $type.'/'.$thn.'/'.$bln.'/'.$seq;
		$kode_baru = $type.''.$thn.''.$bln.''.$seq;
		return $kode_baru;
	}

	function nama_bulan_id($bln){
		$Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$result = $Bulan[(int)$bln-1];		
		return($result);
	}

    function format_date_day_mid($date) 
    {
    	if ($date) {
    		$date = explode("/", $date);
			$date = $date[2]."-".$date[0]."-".$date[1];
    	}else{
    		$date = date('Y-m-d');
    	}
		
		return $date;
    }		

    function format_date_day_mid2($date) 
    {
    	if ($date) {
			$date = explode("-", $date);
			$date = $date[1]."/".$date[2]."/".$date[0];
		}else{
			$date = date('m/d/Y');
		}
		return $date;
    }

    function format_date_day_first($date) 
    {
    	if ($date) {
			$date = explode("-", $date);
			$date = $date[2]."-".$date[1]."-".$date[0];
		}else{
			$date = date('d-m-Y');
		}
		return $date;
    }	

    function format_code($table, $column, $prefix = '', $code_length = 4, $condition = '', $separator = '')
	{
		$number = 0;
		$code = array();
		
		$code[] = $prefix;
		$fixed_length = strlen($prefix) + 1;
		
		$ci = & get_instance();
		$ci->db->select($column);
		if($prefix)$ci->db->like($column, $prefix, 'after');
		if($condition)$ci->db->where($condition);
		$ci->db->order_by($column, 'desc');
		$query = $ci->db->get($table, 1);
		
		if ($query->num_rows() != 0) 
		{
			$row 	= $query->row_array();
			if($prefix)$number = intval(substr($row[$column], $fixed_length, $code_length));
			else $number = intval($row[$column]);
		}
		
		$code[] = $this->format_zero_padding($number + 1, $code_length);
		return implode($separator, $code);
	
	}

	function format_zero_padding($int, $width) 
    {
       return sprintf("%0" . $width . "d", $int);
    }	

    function format_time_24($time) 
    {
		$new_time = date("H:i", strtotime($time));
		return $new_time;
    }

    function format_time_12($time) 
    {
		$new_time = date("h:i A", strtotime($time));
		return $new_time;
    }

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */
