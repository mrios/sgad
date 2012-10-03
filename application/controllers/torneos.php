<?php
class torneos extends CI_Controller {

            public function __construct() {
                parent::__construct();
                $this->load->helper(array('url', 'html', 'form'));
                $this->load->database();
                $this->load->model('current_user');
                }

            public function showList() {
                
                $vars['title'] = 'Listado de Torneos';
                $vars['content_view'] = 'torneo_list';
                $vars['content_class'] = 'content_list';
                
                   $inputFields = array(
                      'nombre'
                );


                //$actividad = $this->input->post('actividad');//
                //$nombre = $this->input->post('nombre');
                
                /* LIST */
                $vars['list_form'] = 'torneos_form_list_view1';
                $vars['list_data'] = $this->getTorneos($inputFields);
                $vars['list_fields'] = $this->getFieldList();
                $vars['list_action'] = '/torneos/showlist';
                $vars['list_css'] = 'content_list';
                $vars['url_agregar_equipo'] = base_url() . '/equipos/showEquipos/';
                $vars['url_equip'] = base_url() . '/equipos/showForm/';
                $vars['url_edit'] = base_url() . '/torneos/showForm/';
                $vars['url_delete'] = base_url() . 'torneos/delete/';
                $vars['url_delete_grupal'] = base_url() . 'torneos/deleteGrupal/';
                $vars['url_print'] = base_url() . 'torneos/printReport/';
                $vars['current_user'] = $this->current_user->user($this->db);

                $this->load->view('template_view', $vars);
            }
            
            public function deleteGrupal(){
                $selectedIds = $this->input->post('selected_ids');
                $selectedIdsArray = explode(',', $selectedIds);

                print_r($selectedIdsArray);

                foreach ($selectedIdsArray  as $id_torneo) {
                    $this->delete($id_torneo);
                }
            }


            public function printReport(){

                $html = $this->getReporteTorneos($this->input->get('selected_ids'));

                //$html = 'hola';
                //echo $html;

                $this->load->library('pdf');

                $this->pdf->SetCreator(PDF_CREATOR);
                $this->pdf->SetAuthor('SGDA');
                $this->pdf->SetTitle('Listado de Torneos');
                $this->pdf->SetSubject('Listado de Torneos');                
                $this->pdf->SetKeywords('Salutte, Listado, Turnos');
                $this->pdf->SetHeaderData('image003.jpg',30,'UTN - Facultad Regional Delta','Secretaria de Asuntos Estudiantiles                                                                                                    Tel:(03489) 420400 Int:5120/5167                                                                                                  Horario: Lunes a Viernes - 16.00 a 21.00 hs                                                    Mail:sae@frd.utn.edu.ar / segovia@frd.utn.edu.ar');
                $this->pdf->setPrintFooter(true);


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

            private function getReporteTorneos($selectedIds){

                $td_field_width_list_col = '170';


                $align_default = 'left';

                if($selectedIds != ''){

                    $torneos = array();

                    $selectedIdsArray = explode(',', $selectedIds);

                    foreach ($selectedIdsArray as $id) {
                        $torneo = $this->getTorneoArray($id);
                        //print_r($asegurado);
                        array_push($torneos, $torneo[0]);
                    }


                // define some HTML content with style
                $html = <<<EOF
                <!-- CSS STYLE -->
                <img src="
                <style>
                    p, table.first{
                        font-family: helvetica;
                        font-size: 10pt;
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


            <div class="cap_name">Listado de Torneos</div>
            <p>
            </p>

            <table class="first" cellpadding="0" cellspacing="0">
                
              <tr>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Nombre</td>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Actividad</td>
              </tr>
EOF;
                foreach ($torneos as $torneo) {
                    $nombre = $torneo['nombre'];
                    $actividad = $torneo['id_actividad'];
                    $html.=       <<<EOF
             <tr>
              <td width="{$td_field_width_list_col}" align="{$align_default}">{$nombre}</td>
              <td width="{$td_field_width_list_col}" align="{$align_default}">{$actividad}</td>
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


                private function getTorneoArray($id){
                if(!is_null($id)){

                    $fieldList = $this->getFieldList();

                    $query = TORNEOS . " WHERE tor.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->result_array();
                }
            }


            public function showForm($id = null){
                
                $vars['title'] = 'Torneos';
                $vars['content_view'] = 'torneo_abm_view';
                $vars['content_class'] = '';
                
                $vars['form_action'] = 'torneos/save';
                
                /* DATA */

                $vars['torneo'] = $this->getTorneo($id);
                $vars['act'] = $this->getActividad();
                $vars['equip'] = $this->getEquipo();
                $vars['current_user'] = $this->current_user->user($this->db);
                $this->load->view('template_view', $vars);
            }
            
            private function getTorneo($id){
                if(!is_null($id)){
                    
                    $fieldList = $this->getFieldList();
                    
                    $query = TORNEOS . " WHERE tor.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->row();
                }
                
            }
            
            private function getTorneos($inputFields){
                $query = TORNEOS;

                $query = $this->add_filters($query, $inputFields);

                return $this->db->query($query);

                }

           private function getActividad(){

                $query = ACTIVIDADES;
                return $this->db->query($query)->result_array();
            }

            private function getEquipo(){

                $query = EQUIPOS_SOLOS;
                return $this->db->query($query)->result_array();
            }



            
            private function getFieldList(){
                return array(
                        'id' => 'id_torneo'
                    ,
                        'nombre' => array(
                            'header' => "Nombre"
                        )
                    ,
                        'descripcion' => array(
                            'header' => "Actividad"
                        )
                     ,
                        'agregar_equipo' => array(
                                'header' => "Equipos"
                            ,   'text' => "Equipos"
                        )
                        );
            }
            
            function save(){
                
                 /* POST */
                $id_torneo = $this->input->post('id_torneo');
                
                $torneo = array(
                            'id_torneo' => $this->input->post('id_torneo')
                        ,   'nombre' => $this->input->post('nombre')
                        ,   'id_actividad' => $this->input->post('id_actividad')
                );


                if(isset($id_torneo) && is_numeric($id_torneo)){
                    //Edita registro
                    if($this->existeEquipoCon($id_torneo)){

                        $this->db->where('id_torneo',$id_torneo);
                        $this->db->update('torneos', $torneo);
                        echo "el registro 'torneo' se ha modificado correctamente.";

                    }

                    //Inserta registro
                    else{
                        $this->db->insert('torneos', $torneo);
                        echo "el registro 'torneo' se ha insertado correctamente.";
                                                    }
                    }
            }
                       
                 function existeEquipoCon($id_torneo){

                $query = TORNEOS;
                $query.= " WHERE tor.id_torneo = ". $id_torneo;

                $result = $this->db->query($query);
                return $result->num_rows()==1;
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
            function delete($id_torneo){

                $this->db->where('id_torneo', $id_torneo);
                $this->db->delete('torneos');

                echo array(
                        "msg" => "El torneo se ha borrado exitosamente"
                    ,   "msg_class" => "exito"
                );
            }

            public function agregar() {
                
                
            }




}

?>
