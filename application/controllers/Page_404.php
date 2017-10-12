<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_404 extends CI_Controller {
	private $any_error = array();

	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
	}

	/* pages begin */
	public function index(){
		$this->view();
	}

	public function view(){
		$this->load->view('layout/page_404');
	}

}
