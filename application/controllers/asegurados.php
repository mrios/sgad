<?php

class asegurados extends CI_Controller{

            public function __construct() {
                parent::__construct();
                $this->load->helper(array('url', 'html', 'form', 'date'));
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

             public function showAsegurados() {

             $vars['title'] = 'Agregar Personas a Poliza';
                $vars['content_view'] = 'agregarasegurados_list';
                $vars['content_class'] = 'content_list';

                $inputFields = array(
                        'apellido'
                    ,   'nombre'
                    ,   'documento'
                    ,   'legajo'
                    ,   'email'

                );

                /* LIST */
                $vars['list_form'] = 'agregarasegurados_view';
                $vars['list_data'] = $this->getAsegurados($inputFields);
                $vars['list_fields'] = $this->getFieldList();
                $vars['list_action'] = '/asegurados/showList';
                $vars['list_css'] = 'content_list';

                $vars['url_edit'] = base_url() . 'asegurados/showForm/';
                $vars['url_delete'] = base_url() . 'asegurados/delete/';
                $vars['url_delete_grupal'] = base_url() . 'asegurados/deleteGrupal/';

                $vars['url_print'] = base_url() . 'asegurados/printReport/';
                $vars['current_user'] = $this->current_user->user($this->db);

                $this->load->view('template_view', $vars);

             }


            public function showList() {
                
                $vars['title'] = 'Listado de Asegurados';
                $vars['content_view'] = 'template_list';
                $vars['content_class'] = 'content_list';
                
                $inputFields = array(
                        'apellido'
                    ,   'nombre'
                    ,   'documento'
                    ,   'legajo'
                    ,   'email'
                    
                );
                
                /* LIST */
                $vars['list_form'] = 'asegurado_form_list_view';
                $vars['list_data'] = $this->getAsegurados($inputFields);
                $vars['list_fields'] = $this->getFieldList();
                $vars['list_action'] = '/asegurados/showList';
                $vars['list_css'] = 'content_list';
                
                $vars['url_edit'] = base_url() . 'asegurados/showForm/';
                $vars['url_delete'] = base_url() . 'asegurados/delete/';
                $vars['url_delete_grupal'] = base_url() . 'asegurados/deleteGrupal/';
                
                $vars['url_print'] = base_url() . 'asegurados/printReport/';
                $vars['current_user'] = $this->current_user->user($this->db);
                
                $this->load->view('template_view', $vars);
            }

            public function deleteGrupal(){
                $selectedIds = $this->input->post('selected_ids');
                $selectedIdsArray = explode(',', $selectedIds);

                //imprime los id seleccionados
                //print_r($selectedIdsArray);

                foreach ($selectedIdsArray  as $documento) {
                    $this->delete($documento);
                }
            }
            
            public function showForm($id = null){
                
                $vars['title'] = 'Asegurados';
                $vars['content_view'] = 'asegurado_abm_view';
                $vars['content_class'] = '';
                
                $vars['form_action'] = 'asegurados/save';
                
                /* DATA */
                $vars['tipos'] = $this->getTiposDocumento();
                $vars['especialidades'] = $this->getEspecialidades();
                $vars['estados'] = $this->getEstados();
                $vars['current_user'] = $this->current_user->user($this->db);
                $vars['asegurado'] = $this->getAsegurado($id);
                
                $this->load->view('template_form', $vars);
            }
            
            public function printReport(){
                
                $html = $this->getReporteAsegurados($this->input->get('selected_ids'));

                $this->load->library('pdf');

                $this->pdf->SetCreator(PDF_CREATOR);
                $this->pdf->SetAuthor('SGDA');
                $this->pdf->SetTitle('Listado de Asegurados');
                $this->pdf->SetSubject('Listado de Asegurados');
                $this->pdf->SetKeywords('Salutte, Listado, Turnos');
                $this->pdf->SetHeaderData('image003.jpg',30,'UTN - Facultad Regional Delta','Secretaria de Asuntos Estudiantiles                                                                                                    Tel:(03489) 420400 Int:5120/5167                                                                                                  Horario: Lunes a Viernes - 16.00 a 21.00 hs                                                    Mail:sae@frd.utn.edu.ar / segovia@frd.utn.edu.ar');

                // remove default header/footer
                //$this->pdf->setPrintHeader(true);
                //$this->pdf->setPrintFooter(false);

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
            
            private function getReporteAsegurados($selectedIds){
                
                $td_field_width_list_col = '170';
                
                
                $align_default = 'left';
                
                if($selectedIds != ''){
                
                    $asegurados = array();

                    $selectedIdsArray = explode(',', $selectedIds);
                    
                    foreach ($selectedIdsArray as $id) {
                        $asegurado = $this->getAseguradoArray($id);
                        //print_r($asegurado);
                        array_push($asegurados, $asegurado[0]);
                    }
                    
                
                // define some HTML content with style
                $html = <<<EOF
                <!-- CSS STYLE -->
                <style>
                     p,   table.first{
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
            <div class="cap_name">Listado de Asegurados</div>
            <p></p>
                
            <table class="first" cellpadding="0" cellspacing="0">
            <tr>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Apellido</td>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Nombre</td>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Documento</td>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Fecha Nacimiento</td>
            </tr>
            <p></p>
EOF;
                foreach ($asegurados as $asegurado) {
                    $nombre = $asegurado['nombre'];
                    $apellido = $asegurado['apellido'];
                    $doc = $asegurado['documento'];
                    $fechaNac = parseDateFromDB($asegurado['fecha_nacimiento']);
                    
                    $html.=       <<<EOF
             <tr>
              <td width="{$td_field_width_list_col}" align="{$align_default}">{$apellido}</td>
              <td width="{$td_field_width_list_col}" align="{$align_default}">{$nombre}</td>
              <td width="{$td_field_width_list_col}" align="{$align_default}">{$doc}</td>
               <td width="{$td_field_width_list_col}" align="{$align_default}">{$fechaNac}</td>
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
            
            private function getAsegurado($id){
                if(!is_null($id)){
                    
                    $fieldList = $this->getFieldList();
                    
                    $query = ASEGURADOS . " WHERE ase.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->row();
                }
            }
            
            private function getAseguradoArray($id){
                if(!is_null($id)){
                    
                    $fieldList = $this->getFieldList();
                    
                    $query = ASEGURADOS . " WHERE ase.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->result_array();
                }
            }
            
            private function getAsegurados($inputFields){
                

                $query = ASEGURADOS;
                
                $query = $this->add_filters($query, $inputFields);
//                echo $query;
                return $this->db->query($query);
            }
            
            private function getTiposDocumento(){
                
                $query = TIPOS_DOCUMENTO;
                return $this->db->query($query)->result_array();
            }

            private function getEstados(){

                $query = ESTADOS;
                return $this->db->query($query)->result_array();
            }
            
            private function getEspecialidades(){
                
                $query = ESPECIALIDADES;
                return $this->db->query($query)->result_array();
            }
            
            private function getFieldList(){
                return array(
                    
                        'id' => 'documento'
                    
                    ,   'apellido' => array(
                            'header' => "Apellido"
                        )
                    ,   'nombre' => array(
                            'header' => "Nombre"
                        )
                    ,   'documento' => array(
                                'header' => "Documento"
                            ,   'class'=>'rigth'
                        )
                    ,   'legajo' => array(
                                'header' => "Legajo"
                            ,   'class'=>'rigth'
                        )
                    ,   'fecha_nacimiento' => array(
                                'header' => "Fecha de Nacimiento"
                            ,   'class'=>'center'
                        )
                    ,   'email' => array(
                                'header' => "email"
                        )
                    ,   'descripcion' => array(
                                'header' => "Estado"
                        )
                );
            }
            
            function save(){
                
                 /* POST */
                $documento = $this->input->post('documento');
                if(isset($documento) && is_numeric($documento)){
                    $this->existePersonaConDocumento($documento);
                }
                
                $fechaNacimiento =  parseDateToDB($this->input->post('fecha_nacimiento'));
                
                $asegurado = array(
                            'documento' => $this->input->post('documento')
                        ,   'tipo_documento' => $this->input->post('tipo_documento')
                        ,   'legajo' => $this->input->post('legajo')
                        ,   'apellido' => $this->input->post('apellido')
                        ,   'nombre' => $this->input->post('nombre')
                        ,   'email' => $this->input->post('email')
                        ,   'id_especialidad' => $this->input->post('id_especialidad')
                        ,   'telefono' => $this->input->post('telefono')
                            //TODO parsear fecha to DB yyyy-mm--dd
                        ,   'fecha_nacimiento' => $fechaNacimiento
                        ,   'referencia' => $this->input->post('referencia')
                        
                );

                $estadoAsegurado = array(
                       'id_estado' => $this->input->post('id_estado')
                );
                
                
                if(isset($documento) && is_numeric($documento)){
                    
                    //Edita registro
                    if($this->existePersonaConDocumento($documento)){
                        
                        $this->db->where('documento', $documento);
                        $this->db->update('asegurados', $asegurado); 
                        echo "el registro 'asegurado' se ha modificado correctamente.";

                        //Siempre existe un estado, si es un nuevo registro se setea por defecto: NO ASEGURADO

                        $this->db->where('documento', $documento);
                        $this->db->update('estados_asegurados', $estadoAsegurado);
                        echo "el registro 'estado_asegurado' se ha modificado correctamente.";
                    }
                
                    //Inserta registro
                    else{
                        $this->db->insert('asegurados', $asegurado); 
                        echo "el registro 'asegurado' se ha insertado correctamente.";
                        echo "el registro 'estado_asegurado' se ha insertado correctamente.";

                            $estadoAsegurado = array(
                                        'id_estado' => $this->input->post('id_estado')
                                   ,    'documento' => $documento
                        );

                        $this->db->insert('estados_asegurados', $estadoAsegurado);
                        echo "el registro 'estado_asegurado' se ha insertado correctamente.";
                    }
                }

            

            }
            
            function delete($documento){
                
                $this->db->where('documento', $documento);
                $this->db->delete('asegurados');

                echo array(
                        "msg" => "La persona se ha borrado exitosamente"
                    ,   "msg_class" => "exito"
                );
            }
            
            function existePersonaConDocumento($documento){
                $query = ASEGURADOS;
                $query.= " WHERE ase.documento = ". $documento;
                
                $result = $this->db->query($query);
                return $result->num_rows()==1;
            }

            
}

?>
