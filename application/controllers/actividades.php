<?php


class actividades extends CI_Controller{

            public function __construct() {
                parent::__construct();
                $this->load->helper(array('url', 'html', 'form'));
                $this->load->database();
                $this->load->model('current_user');
            }

            public function add_filters($query, $inputFields){
                foreach ($inputFields as $field) {
                    $value = $this->input->post($field);
                    if(!is_null($value) && $value != ''){
                        $query.= " WHERE $field LIKE '%$value%' ";
                    }
                }
                return $query;
            }

            public function showList() {

                $vars['title'] = 'Actividades';
                $vars['content_view'] = 'actividades_list';
                $vars['content_class'] = 'content_list';

                $inputFields = array ('descripcion');
     

                /* LIST */
                $vars['list_form'] = 'actividades_form_list_view';
                $vars['list_data'] = $this->getActividades($inputFields);
                $vars['list_fields'] = $this->getFieldList();
                $vars['list_action'] = '/actividades/showList';
                $vars['list_css'] = 'content_list';
                $vars['url_delete'] = base_url() . 'actividades/delete/';
                $vars['url_torneos'] = base_url() . 'torneos/showList/';
                $vars['url_delete_grupal'] = base_url() . 'actividades/deleteGrupal/';

                $vars['url_edit'] = base_url() . '/actividades/showForm/';
                $vars['url_print'] = base_url() . 'actividades/printReport/';
                $vars['current_user'] = $this->current_user->user($this->db);   

                $this->load->view('template_view', $vars);
            }

             public function showForm($id = null){

                $vars['title'] = 'Actividades';
                $vars['content_view'] = 'actividad_abm_view';
                $vars['content_class'] = '';

                $vars['form_action'] = 'actividades/save';

                /* DATA */
                //$vars['torneos'] = $this->getTorneos();

                $vars['tipos'] = $this->getTiposDocumento();
                $vars['actividad'] = $this->getActividad($id);
                $vars['current_user'] = $this->current_user->user($this->db);
                $this->load->view('template_view', $vars);
            }

             //private function getTorneos($id){

               // $query = 'SELECT * FROM torneos';
               // return $this->db->query($query)->result_array();

            //}
                                                                 
              public function printReport(){

                $html = $this->getReporteActividades($this->input->get('selected_ids'));

                //$html = 'hola';
                //echo $html;


                $this->load->library('pdf');
                $this->pdf->SetCreator(PDF_CREATOR);
                $this->pdf->SetAuthor('SGDA');
                $this->pdf->SetTitle('Listado de Actividades');
                $this->pdf->SetSubject('Listado de Actividades');
                $this->pdf->SetKeywords('Salutte, Listado, Turnos');
                $this->pdf->SetHeaderData('image003.jpg',30,'UTN - Facultad Regional Delta','Secretaria de Asuntos Estudiantiles                                                                                                    Tel:(03489) 420400 Int:5120/5167                                                                                                  Horario: Lunes a Viernes - 16.00 a 21.00 hs                                                    Mail:sae@frd.utn.edu.ar / segovia@frd.utn.edu.ar');


                // set default monospaced font
                $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


                //set auto page breaks
                $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                //set image scale factor
                $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                // ---------------------------------------------------------

                // set font
                $this->pdf->SetFont('times', '', 8);

                $this->pdf->AddPage();



                $this->pdf->writeHTML($html, true, false, true, false, '');
                // reset pointer to the last page
                $this->pdf->lastPage();

                //============================================================+
                // END OF FILE
                //============================================================+

                $this->pdf->Ln();

                //Close and output PDF document
                $this->pdf->Output('listado.pdf', 'I');

                //print_r($selectedIds);
            }

            private function getReporteActividades($selectedIds){

                $td_field_width_list_col = '170';


                $align_default = 'left';

                if($selectedIds != ''){

                    $actividades = array();

                    $selectedIdsArray = explode(',', $selectedIds);

                    foreach ($selectedIdsArray as $id) {
                        $actividad = $this->getActividadArray($id);
                        //print_r($asegurado);
                        array_push($actividades, $actividad[0]);
                    }


                // define some HTML content with style
                $html = <<<EOF
                <!-- CSS STYLE -->
                <style>
                    p, table.first{
                        font-family: helvetica;
                        font-size: 8pt;
                    }

                    p.title {
                        font-size: 11pt;
                        text-align: center;
                        font-weight: bold;
                    }
                    td{
                        text-indent:8pt;
                    }
                    td.underline{
                        text-decoration: underline;
                    }
                    td.field{
                        font-weight: bold;
                    }
                    div.cap_name {
                        font-size: 16pt;
                        font-weight: bold;
                        border: 1px solid black;
                        text-align: center;
                    }
                p.comment{
                        font-size: 10pt;
                        font-style: italic;
                }

                </style>

            <p></p>
            <p></p>
            <div class="cap_name">Listado de Actividades</div>
            <p></p>

            <table class="first" cellpadding="0" cellspacing="0">
            <tr>

              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Actividad</td>
            </tr>
            <p></p>
EOF;
                foreach ($actividades as $actividad) {
                    $descripcion = $actividad['descripcion'];

                    $html.       <<<EOF

             <tr>
              <td width="{$td_field_width_list_col}" align="{$align_default}">{$descripcion}</td>
             </tr>
EOF;

                }

$html.=       <<<EOF
                </table>

EOF;

    return $html;
                }
                else return '';
            }

            private function getActividadArray($id){
                if(!is_null($id)){

                    $fieldList = $this->getFieldList();

                    $query = ACTIVIDADES . " WHERE act.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->result_array();
                }
            }

            public function deleteGrupal(){
                $selectedIds = $this->input->post('selected_ids');
                $selectedIdsArray = explode(',', $selectedIds);

                print_r($selectedIdsArray);

                foreach ($selectedIdsArray  as $id_actividad) {
                    $this->delete($id_actividad);
                }
            }

            function delete($id_actividad){

                $this->db->where('id_actividad', $id_actividad);
                $this->db->delete('actividades');

                echo array(
                        "msg" => "La actividad se ha borrado exitosamente"
                    ,   "msg_class" => "exito"
                );
            }




             private function getTiposDocumento(){
                
                $query = 'SELECT * FROM tipo_documento';                
                return $this->db->query($query)->result_array();
            }


             private function getActividades($inputFields){

                $query = ACTIVIDADES;

                $query = $this->add_filters($query, $inputFields);

                return $this->db->query($query);
            }

            private function getFieldList(){
                return array(
                        'id' => 'id_actividad'
                        ,'descripcion'=> array(
                             'header' => "Actividad"
                        )
                        ,'torneos'=> array(
                            'header' => "Torneos"
                        )

                );
           }

            private function getActividad($id){
                if(!is_null($id)){

                    $fieldList = $this->getFieldList();

                    $query = ACTIVIDADES . " WHERE act.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->row();
                }
                else{
                    $actividad = new Actividad();
                    return $actividad;
                }
            }
}


function save(){

                 /* POST */
                $idactividad = $this->input->post('idActividad');

                $actividad = array(
                    'idActividad' => $this->input->post('idActividad')
                    ,'descripcion' => $this->input->post('descripcion')
                );

                if($this->existeActividad($idactividad)){
                    if(isset($idactividad) && is_numeric($idactividad)){
                        $this->db->where('idActividad', $idactividad);
                        $this->db->update('actividades', $actividad);
                    }
                }
                else{
                    $this->db->insert('actividades', $actividad);

                }

}

?>