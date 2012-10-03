<?php

class Data_lib extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function addFilters($query, $inputFields, $tablePrefix){
        foreach ($inputFields as $field) {
            $value = $this->input->post($field);
            if(!is_null($value) && $value != ''){
                $query.= " WHERE $tablePrefix.$field LIKE '%$value%' ";
            }
        }
        return $query;
    }
    
    public function findAll($tableModel, $inputFields){
        
        $query = $this->addFilters($tableModel, $inputFields);
        return $this->db->query($query);
    }
    
    public function findOneById($tableModel, $tablePrefix, $fieldId, $id){
    
                if(!is_null($id)){
                    $query = $tableModel . " WHERE $tablePrefix." . $fieldId . " = " . $id;
                    return $this->db->query($query)->row();
                }
                
    }
}

?>
