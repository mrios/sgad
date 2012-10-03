<?php

class accidentes extends CI_Controller {

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

            public function showList() {

                $vars['title'] = 'Accidentes';
                $vars['content_view'] = 'template_list';
                $vars['content_class'] = 'content_list';

                $inputFields = array(
                      'documento'
                      ,'fecha_accidente'
                      ,'descripcion'
                      ,'nombre'
                      ,'apellido'
                );

                /* LIST */
                $vars['list_form'] = 'accidente_form_list_view';
                $vars['list_data'] = $this->getAccidentes($inputFields);
                $vars['list_fields'] = $this->getFieldList();
                $vars['list_action'] = '/accidentes/showList';
                $vars['list_css'] = 'content_list';
                $vars['url_delete'] = base_url() . 'accidentes/delete/';
                $vars['url_delete_grupal'] = base_url() . 'accidentes/deleteGrupal/';


                $vars['url_edit'] = base_url() . '/accidentes/showForm/';
                $vars['url_print'] = base_url() . 'accidentes/printReport/';
                $vars['current_user'] = $this->current_user->user($this->db);

                $this->load->view('template_view', $vars);
            }

            public function showForm($id = null){

                $vars['title'] = 'Accidentes';
                $vars['content_view'] = 'accidente_abm_view';
                $vars['content_class'] = '';

                $vars['form_action'] = 'accidentes/save';

                /* DATA */
                $vars['tipos'] = $this->getTiposDocumento();
                $vars['accidente'] = $this->getAccidente($id);
                $vars['act'] = $this->getDocumento();
                
                $vars['current_user'] = $this->current_user->user($this->db);
                $this->load->view('template_view', $vars);
            }

            public function printReport(){

                $html = $this->getReporteAccidentes($this->input->get('selected_ids'));

                //$html = 'hola';
                //echo $html;

                
                $this->load->library('pdf');
                $this->pdf->SetCreator(PDF_CREATOR);
                $this->pdf->SetAuthor('SGDA');
                $this->pdf->SetTitle('Listado de Accidentes');
                $this->pdf->SetSubject('Listado de Accidentes');
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

            private function getReporteAccidentes($selectedIds){

                $td_field_width_list_col = '170';


                $align_default = 'left';

                if($selectedIds != ''){

                    $accidentes = array();

                    $selectedIdsArray = explode(',', $selectedIds);

                    foreach ($selectedIdsArray as $id) {
                        $accidente = $this->getAccidenteArray($id);
                        //print_r($asegurado);
                        array_push($accidentes, $accidente[0]);
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
            <div class="cap_name">Listado de Accidentes</div>            
            <p></p>

            <table class="first" cellpadding="0" cellspacing="0">
            <tr>

              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Documento</td>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Fecha Accidente</td>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Descripcion</td>
            </tr>
            <p></p>
EOF;
                foreach ($accidentes as $accidente) {
                    $documento = $accidente['documento'];
                    $descripcion = $accidente['descripcion'];
                    $fecha_accidente = parseDateFromDB($accidente['fecha_accidente']);

                    $html.       <<<EOF
             
             <tr>
              <td width="{$td_field_width_list_col}" align="{$align_default}">{$documento}</td>
              <td width="{$td_field_width_list_col}" align="{$align_default}">{$descripcion}</td>
               <td width="{$td_field_width_list_col}" align="center">{$fecha_accidente}</td>
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

            public function deleteGrupal(){
                $selectedIds = $this->input->post('selected_ids');
                $selectedIdsArray = explode(',', $selectedIds);

                print_r($selectedIdsArray);

                foreach ($selectedIdsArray  as $id_accidente) {
                    $this->delete($id_accidente);
                }
            }

            function delete($id_accidente){

                $this->db->where('id_accidente', $id_accidente);
                $this->db->delete('accidentes');

                echo array(
                        "msg" => "El accidente se ha borrado exitosamente"
                    ,   "msg_class" => "exito"
                );
            }






            private function getAccidentes($inputFields){

               $query = ACCIDENTES;

                $query = $this->add_filters($query, $inputFields);

                return $this->db->query($query);}
            
             private function getAccidenteArray($id){
                if(!is_null($id)){

                    $fieldList = $this->getFieldList();

                    $query = ACCIDENTES . " WHERE acc.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->result_array();
                }
            }
            
            private function getTiposDocumento(){

                $query = TIPOS_DOCUMENTO;
                return $this->db->query($query)->result_array();
            }
            private function getAccidente($id){
                if(!is_null($id)){

                    $fieldList = $this->getFieldList();

                    $query = ACCIDENTES . " WHERE acc.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->row();
                }
                else{
                    $equipo = new Equipo();
                    return $equipo;
                }
            }
            

            private function getFieldList(){
                return array(
                        'id' => 'id_accidente'
                    
                    ,   'nombre' => array(
                            'header' => "Nombre"
                        )
                    ,   'apellido' => array(
                            'header' => "Apellido"

                        )                                            
                    ,    'documento' => array(
                            'header' => "Documento"
                        )
                    ,   'fecha_accidente' => array(
                            'header' => "Fecha Accidente"
                        )
                    ,   'descripcion' => array(
                            'header' => "Descripcion"
                        )

                );
            }

            private function getDocumento(){

                $query = ASEGURADOS;
                return $this->db->query($query)->result_array();
            }

          
            function save(){

                 /* POST */
                $id_accidente = $this->input->post('id_accidente');

                $accidente = array(
                            'documento' => $this->input->post('documento')
                        ,   'fecha_accidente' => parseDateToDB($this->input->post('fecha_accidente'))
                        ,   'descripcion' => $this->input->post('descripcion')
                      

                );

                if(isset($id_accidente) && is_numeric($id_accidente)){

                    //Edita registro
                    if($this->existeAccidente($id_accidente)){

                        $this->db->where('id_accidente',$id_accidente);
                        $this->db->update('accidentes', $accidente);
                        echo "el registro 'accidente' se ha modificado correctamente.";
                    }

                    //Inserta registro
                    else{
                        $this->db->insert('accidentes', $accidente);
                        echo "el registro 'accidente' se ha insertado correctamente.";
                    }
                }
            }

           

            function existeAccidente($id_accidente){
                $query = ACCIDENTES;
                $query.= " WHERE acc.id_accidente = ". $id_accidente;

                $result = $this->db->query($query);
                return $result->num_rows()==1;
            }

}

?>
