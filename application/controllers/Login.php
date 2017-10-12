<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	private $any_error = array();

	public function __construct() {
        parent::__construct();
	}

	/* pages begin */
	public function index(){
		$this->view();
	}

	function check_user_access(){
		if($this->logged_in!=null)
			redirect('Dashboard');
	}

	public function view(){
		$this->check_user_access();
		$this->load->view('layout/login');
	}

	public function do_login(){
		$user = $this->input->post('username', TRUE);
		$pass = $this->input->post('password', TRUE);
		$user_data = $this->g_mod->check_exist_user($user,$pass);

		if(!$user_data)
			$response['status'] = '204'; 
		else{		
			$this->session->set_userdata('logged', 'in');
			$this->session->set_userdata('user_id', $user_data->user_id);
			$this->session->set_userdata('user_username', $user_data->user_username);
			$this->session->set_userdata('user_name', $user_data->user_name);
			$this->session->set_userdata('user_type_id', $user_data->user_type_id);
			$response['status'] = '200';
		}
			
		echo json_encode($response);
	}

	public function do_logout(){
		$this->session->sess_destroy();
		$response['status'] = '200';
		echo json_encode($response);
	}
}
