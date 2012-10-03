<?php
class login_form extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->helper(array('form','url','html'));
                $this->load->library(array('form_validation'));
                $this->load->model('current_user');
                $this->load->database();
        }

	public function index() {
            
                $vars['title'] = 'Login';
                $vars['content_view'] = 'login_form_view';
                $vars['container_css'] = 'users';
                $vars['menu_list'] = NULL;
                $vars['menu_view'] = 'menu';
                
                $this->load->view('login_form_view', $vars);
	}

	public function submit() {

		if ($this->_submit_validate() === FALSE) {
			$this->index();
			return;
		}

		redirect('/home');

	}

	private function _submit_validate() {

		$this->form_validation->set_rules('username', 'Username',
			'trim|required|callback_authenticate');

		$this->form_validation->set_rules('password', 'Password',
			'trim|required');

		$this->form_validation->set_message('authenticate','Logeo Invalido. Por favor, intentelo de nuevo.');

		return $this->form_validation->run();

	}

	public function authenticate() {
            $db = $this->db;
            return $this->current_user->login($db, $this->input->post('username'), $this->input->post('password'));

	}

}
