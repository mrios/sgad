<?php
class home extends CI_Controller {

            public function __construct() {
                parent::__construct();
                $this->load->helper(array('url','html'));
                $this->load->model('current_user');
                $this->load->database();
            }

            public function index() {

                $vars['title'] = 'Inicio ';
                $vars['content_view'] = 'index_view';
                $vars['content_class'] = 'content';
                $vars['current_user'] = $this->current_user->user($this->db);
                
                $this->load->view('template_view', $vars);
            }

}

?>
