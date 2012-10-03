<?php

class polizas extends CI_Controller{

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
                
                $vars['title'] = 'Listado de Polizas';
                $vars['content_view'] = 'poliza_list';
                $vars['content_class'] = 'content_list';
                
                $inputFields = array(
                        'nombre_aseguradora'
                        ,'direccion'
                        ,'localidad'
                        ,'telefono'
                        ,'nro_poliza'
                        ,'fecha_inicio'
                        ,'fecha_final'
                );
                
                /* LIST */
                $vars['list_form'] = 'poliza_form_list_view';
                $vars['list_data'] = $this->getPolizas($inputFields);
                $vars['list_fields'] = $this->getFieldList();
                $vars['list_action'] = '/polizas/showList';
                $vars['url_agregar_personas'] = base_url() .'/asegurados/showAsegurados/';
                $vars['list_css'] = 'content_list';
                $vars['url_delete'] = base_url() . 'polizas/delete/';
                $vars['url_delete_grupal'] = base_url() . 'polizas/deleteGrupal/';
                
                $vars['url_edit'] = base_url() . '/polizas/showForm/';
                $vars['url_print'] = base_url() . 'polizas/printReport/';
                $vars['current_user'] = $this->current_user->user($this->db);
                
                $this->load->view('template_view', $vars);
            }
            

            public function printReport(){

                $html = $this->getReportePolizas($this->input->get('selected_ids'));

                //$html = 'hola';
                //echo $html;

                $this->load->library('pdf');

                $this->pdf->SetCreator(PDF_CREATOR);
                $this->pdf->SetAuthor('SGDA');
                $this->pdf->SetTitle('Listado de Polizas');
                $this->pdf->SetSubject('Listado de Polizas');
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

            private function getReportePolizas($selectedIds){

                $td_field_width_list_col = '100';


                $align_default = 'left';

                if($selectedIds != ''){

                    $polizas = array();

                    $selectedIdsArray = explode(',', $selectedIds);

                    foreach ($selectedIdsArray as $id) {
                        $poliza = $this->getPolizaArray($id);
                        //print_r($asegurado);
                        array_push($polizas, $poliza[0]);
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
            <div class="cap_name">Listado de Polizas</div>
            <p></p>

            <table class="first" cellpadding="0" cellspacing="0">
            <tr>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:8pt" align="{$align_default}">Aseguradora</td>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:8pt" align="{$align_default}">Direccion</td>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:8pt" align="{$align_default}">Localidad</td>
              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:8pt" align="{$align_default}">Telefono</td>
                <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:8pt" align="{$align_default}">Nro de Poliza</td>
                <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:8pt" align="{$align_default}">Fecha Inicio</td>
                <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:8pt" align="{$align_default}">Fecha Finalizacion</td>

            </tr>
            <p></p>
EOF;
                foreach ($polizas as $poliza) {
                    $aseguradora = $poliza['nombre_aseguradora'];
                    $direccion = $poliza['direccion'];
                    $localidad = $poliza['localidad'];
                    $telefono = $poliza['telefono'];
                    $nro_poliza = $poliza['nro_poliza'];
                    $fecha_inicio = parseDateFromDB($poliza['fecha_inicio']);
                    $fecha_final = parseDateFromDB($poliza['fecha_final']);

                    $html.=       <<<EOF
             <tr>
              <td width="{$td_field_width_list_col}" align="{$align_default}">{$aseguradora}</td>
              <td width="{$td_field_width_list_col}" align="{$align_default}">{$direccion}</td>
               <td width="{$td_field_width_list_col}" align="{$align_default}">{$localidad}</td>
               <td width="{$td_field_width_list_col}" align="{$align_default}">{$telefono}</td>
               <td width="{$td_field_width_list_col}" align="{$align_default}">{$nro_poliza}</td>
                <td width="{$td_field_width_list_col}" align="center">{$fecha_inicio}</td>
               <td width="{$td_field_width_list_col}" align="center">{$fecha_final}</td>



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




            public function showForm($id = null){
                
                $vars['title'] = 'Polizas';
                $vars['content_view'] = 'poliza_abm_view';
                $vars['content_class'] = '';
                
                $vars['form_action'] = 'polizas/save';
                
                /* DATA */
                $vars['poliza'] = $this->getPoliza($id);
                $vars['current_user'] = $this->current_user->user($this->db);
                $this->load->view('template_view', $vars);
            }

            public function deleteGrupal(){
                $selectedIds = $this->input->post('selected_ids');
                $selectedIdsArray = explode(',', $selectedIds);

                print_r($selectedIdsArray);

                foreach ($selectedIdsArray  as $id_poliza) {
                    $this->delete($id_poliza);
                }
            }
            
            function delete($id_poliza){

                $this->db->where('id_poliza', $id_poliza);
                $this->db->delete('polizas');

                echo array(
                        "msg" => "La poliza se ha borrado exitosamente"
                    ,   "msg_class" => "exito"
                );
            }

            private function getPolizaArray($id){
                
                if(!is_null($id)){

                    $fieldList = $this->getFieldList();

                    $query = POLIZAS . " WHERE pol.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->result_array();
                }
            }
     




            private function getPoliza($id){
                if(!is_null($id)){
                    
                    $fieldList = $this->getFieldList();
                    
                    $query = POLIZAS . " WHERE pol.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->row();
                }
                
            }
            
            private function getPolizas($inputFields){
                
                $query = POLIZAS;
                
                $query = $this->add_filters($query, $inputFields);
                
                return $this->db->query($query);
            }
            
            private function getFieldList(){
                return array(
                    
                        'id' => 'id_poliza'
                    
                    ,   'nombre_aseguradora' => array(
                                'header' => "Aseguradora"
                        )
                    ,   'direccion' => array(
                                'header' => "Direccion"
                        )
                    ,   'localidad' => array(
                                'header' => "Localidad"
                        )
                    ,   'telefono' => array(
                                'header' => "Telefono"
                        )
                     ,   'nro_poliza' => array(
                                'header' => "Nro Poliza"
                        )
                    ,   'fecha_inicio' => array(
                                'header' => "Fecha de inicio"
                        )
                    ,   'fecha_final' => array(
                                'header' => "Fecha de Finalizacion"
                        )
                          ,   'agregar_personas' => array(
                                'header' => "Agregar Personas"
                        )
                     );
            }
            
            
            function save(){

                 /* POST */
                $id_poliza = $this->input->post('id_poliza');
                
                $poliza = array(
                            'nombre_aseguradora' => $this->input->post('nombre_aseguradora')
                        ,   'direccion' => $this->input->post('direccion')
                        ,   'localidad' => $this->input->post('localidad')
                        ,   'telefono' => $this->input->post('telefono')
                        ,   'nro_poliza' => $this->input->post('nro_poliza')
                        ,   'fecha_inicio' => parseDateToDB($this->input->post('fecha_inicio'))
                        ,   'fecha_final' => parseDateToDB($this->input->post('fecha_final'))
                );

                if(isset($id_poliza) && is_numeric($id_poliza)){

                    //Edita registro
                    if($this->existePoliza($id_poliza)){

                        $this->db->where('id_poliza',$id_poliza);
                        $this->db->update('polizas', $poliza);
                        echo "el registro 'poliza' se ha modificado correctamente.";
                    }

                    //Inserta registro
                    else{
                        $this->db->insert('polizas', $poliza);
                        echo "el registro 'poliza' se ha insertado correctamente.";
                    }
                }
            }

             function existePoliza($id_poliza){
                $query = POLIZAS;
                $query.= " WHERE pol.id_poliza = ". $id_poliza;

                $result = $this->db->query($query);
                return $result->num_rows()==1;
            }
                       
          
}

?>
