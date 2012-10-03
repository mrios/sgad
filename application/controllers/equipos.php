<?php
class equipos extends CI_Controller {

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
                        $query.= " WHERE equ.$field LIKE '%$value%' ";
                    }
                }
                return $query;
            }


              public function printReport(){

                $html = $this->getReporteEquipos($this->input->get('selected_ids'));

                //$html = 'hola';
                //echo $html;

                $this->load->library('pdf');
                $this->pdf->SetCreator(PDF_CREATOR);
                $this->pdf->SetAuthor('SGDA');
                $this->pdf->SetTitle('Listado de Equipos');                
                $this->pdf->SetSubject('Listado de Equipos');
                $this->pdf->SetKeywords('Salutte, Listado, Turnos');
                
                //header
                $this->pdf->SetHeaderData('image003.jpg',30,'UTN - Facultad Regional Delta','Secretaria de Asuntos Estudiantiles                                                                                                    Tel:(03489) 420400 Int:5120/5167                                                                                                  Horario: Lunes a Viernes - 16.00 a 21.00 hs                                                    Mail:sae@frd.utn.edu.ar / segovia@frd.utn.edu.ar');

                
                // remove default header/footer
                //$this->pdf->setPrintHeader(true);
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

            private function getReporteEquipos($selectedIds){

                $td_field_width_list_col = '170';


                $align_default = 'left';

                if($selectedIds != ''){

                    $equipos = array();

                    $selectedIdsArray = explode(',', $selectedIds);

                    foreach ($selectedIdsArray as $id) {
                        $equipo = $this->getEquipoArray($id);
                        //print_r($asegurado);
                        array_push($equipos, $equipo[0]);
                    }               

                // define some HTML content with style
                $html = <<<EOF
                    <!-- CSS STYLE -->
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

            <p></p>
            <p></p>
            <div class="cap_name">Listado de Equipos</div>
            <p></p>

            <table class="first" cellpadding="0" align="center" cellspacing="0">
            <tr>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Nombre</td>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Dni Entrenador</td>
            </tr>
            <p></p>
EOF;
                foreach ($equipos as $equipo) {
                    $nombre = $equipo['nombre'];
                    $dni_entrenador = $equipo['id_entrenador'];

                    $html.=       <<<EOF
             <tr>
              <td width="{$td_field_width_list_col}" align="{$align_default}">{$nombre}</td>
             <td width="{$td_field_width_list_col}" align="{$align_default}">{$dni_entrenador}</td>

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

              public function showEquipos() {

                $vars['title'] = 'Equipos';
                $vars['content_view'] = 'equiposxtorneo_list';
                $vars['content_class'] = 'content_list';

                 $inputFields = array(
                      'nombre'
                );


                /* LIST */
                $vars['list_form'] = 'equipos_fl_view';
                $vars['list_data'] = $this->getEquipos($inputFields);
                $vars['list_fields'] = $this->getFieldList();
                $vars['list_action'] = '/equipos/showList';
                //$vars['list_css'] = 'content_list';
                //$vars['url_delete'] = base_url() . 'equipos/delete/';
                //$vars['url_delete_grupal'] = base_url() . 'equipos/deleteGrupal/';
                //$vars['url_edit'] = base_url() . '/equipos/showForm/';
                $vars['url_print'] = base_url() . 'equipos/printReport/';
                $vars['current_user'] = $this->current_user->user($this->db);

                $this->load->view('template_view', $vars);
            }





            public function showList() {
                
                $vars['title'] = 'Listado de Equipos';
                $vars['content_view'] = 'template_list';
                $vars['content_class'] = 'content_list';
                
                $inputFields = array(
                      'nombre'
                );
                
                /* LIST */
                $vars['list_form'] = 'equipos_form_list_view';
                $vars['list_data'] = $this->getEquipos($inputFields);
                $vars['list_fields'] = $this->getFieldList();
                $vars['list_action'] = '/equipos/showList';
                $vars['list_css'] = 'content_list';
                $vars['url_delete'] = base_url() . 'equipos/delete/';
                $vars['url_delete_grupal'] = base_url() . 'equipos/deleteGrupal/';
                $vars['url_edit'] = base_url() . '/equipos/showForm/';
                $vars['url_print'] = base_url() . 'equipos/printReport/';
                $vars['current_user'] = $this->current_user->user($this->db);

                $this->load->view('template_view', $vars);
            }
            
            public function showForm($id = null){
                
                $vars['title'] = 'Equipos';
                $vars['content_view'] = 'equipo_abm_view';
                $vars['content_class'] = '';
                
                $vars['form_action'] = 'equipos/save';
                
                /* DATA */
                $vars['equipo'] = $this->getEquipo($id);
                
                $vars['current_user'] = $this->current_user->user($this->db);
                $this->load->view('template_view', $vars);
            }
            
            private function getEquipo($id){
                if(!is_null($id)){
                    
                    $fieldList = $this->getFieldList();
                    
                    $query = EQUIPOS . " WHERE equ.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->row();
                }
            }


            private function getEquipos($inputFields){
                
                $query = EQUIPOS;
                
                $query = $this->add_filters($query, $inputFields);
                
                return $this->db->query($query);
            }
            
            private function getFieldList(){
                return array(
                        'id' => 'id_equipo'
                    ,
                        'nombre' => array(
                            'header' => "Nombre"
                        )
                    ,   'apellido1' => array(
                            'header' => "Delegado"
                        )
                    ,   'apellido' => array(
                            'header' => "Entrenador"
                        )
                    
                );
            }

             private function getEquipoArray($id){
                if(!is_null($id)){

                    $fieldList = $this->getFieldList();

                    $query = EQUIPOS . " WHERE equ.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->result_array();
                }
            }

             function save(){
                $id_equipo = $this->input->post('id_equipo');
                
                $equipo = array(
                            'id_equipo' => $this->input->post('id_equipo')
                        ,   'nombre' => $this->input->post('nombre')
                        ,   'id_delegado' => $this->input->post('id_delegado')
                        ,   'id_entrenador' => $this->input->post('id_entrenador')
                );
                

                if(isset($id_equipo) && is_numeric($id_equipo)){
                    //Edita registro
                    if($this->existeEquipoCon($id_equipo)){

                        $this->db->where('id_equipo',$id_equipo);
                        $this->db->update('equipos', $equipo);
                        echo "el registro 'equipo' se ha modificado correctamente.";

                    }

                    //Inserta registro
                    else{
                        $this->db->insert('equipos', $equipo);
                        echo "el registro 'equipo' se ha insertado correctamente.";
                                                    }
                    }
            }

            public function deleteGrupal(){
                $selectedIds = $this->input->post('selected_ids');
                $selectedIdsArray = explode(',', $selectedIds);

                print_r($selectedIdsArray);

                foreach ($selectedIdsArray  as $id_equipo) {
                    $this->delete($id_equipo);
                }
            }

           

            function existeEquipoCon($id_equipo){
                $query = EQUIPOS;
                $query.= " WHERE equ.id_equipo = ". $id_equipo;

                $result = $this->db->query($query);
                return $result->num_rows()==1;
            }

            function delete($id_equipo){

                $this->db->where('id_equipo', $id_equipo);
                $this->db->delete('equipos');

                echo array(
                        "msg" => "El equipo se ha borrado exitosamente"
                    ,   "msg_class" => "exito"
                );
            }


}

?>
