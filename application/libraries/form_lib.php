<?php

class Form_lib extends CI_Controller {
    
    private $fieldsForm = array();

    public function setFieldsForm($arrayList = array()){
        return $this->fieldsForm = $arrayList;
    }

    public function getFieldsForm(){
        return $this->fieldsForm;
    }
    
    public function __construct() {
            parent::__construct();

            $this->load->helper(array('form', 'url', 'html'));
            $this->load->library(array('data_lib'));
            
    }
    
    public function index($id = NULL) {

            $vars['fields_form'] = $this->getFieldsForm();
            
            $vars['reg'] = $this->data_lib->findById($this->getIdField(), $id);

            $vars['model'] = $this->getModel();
            $vars['controller'] = $this->getModel();

            $this->load->view('template_form', $vars);
    }
    
    private function getIdField(){
            $fields = $this->getFieldsForm();
            return $fields['id'];
    }
    
}

?>
