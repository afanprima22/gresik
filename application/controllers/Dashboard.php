<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    private $any_error = array();

    public function __construct() {
        parent::__construct();
    }

    /* pages begin */
    public function index(){
        $this->view();
    }

    function check_user_access(){
        if(!$this->logged_in)
            redirect('Login');
    }

    public function view(){
        $this->check_user_access();
        $data = array(
            'aplikasi'      => 'Gresik Factory',
            'title_page'    => 'Dashboard',
            'title'         => ''
            );

        $this->open_page('layout/dasboard', $data);
    }
    
}
