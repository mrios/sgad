<?php
class logout extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url','html'));
	}

	public function index() {
            
                $CI = & get_instance();
		$CI->load->library('session');

                $this->session->sess_destroy();
                redirect('login_form');

	}

}
