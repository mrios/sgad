<?php
            
class Autocomplete extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'html', 'form'));
        $this->load->database();
        $this->load->model('current_user');
    }

    public function getPersonasNombreCompleto(){
        $term = $this->input->get("term");
        
        $query = ASEGURADOS_NC . " WHERE ase.apellido LIKE '%$term%'";
        $query.= " OR ase.nombre LIKE '%$term%'";
        $query.= " OR ase.documento LIKE '%$term%'";
        $data = $this->db->query($query)->result();
        $array_data = array();
        foreach ($data as $row){
            array_push($array_data, array(
                        "documento"     => $row->documento
                    ,   "nombreCompleto"=> $row->nombre_completo
                )
            );
        }
        
        echo json_encode($array_data);

    }

}
?>
