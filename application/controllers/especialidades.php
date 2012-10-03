<?php


class especialidades extends CI_Controller{

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

                $vars['title'] = 'Especialidades';
                $vars['content_view'] = 'template_list';
                $vars['content_class'] = 'content_list';

                $inputFields = array ('descripcion');


                /* LIST */
                $vars['list_form'] = 'especialidades_form_list_view';
                $vars['list_data'] = $this->getEspecialidades($inputFields);
                $vars['list_fields'] = $this->getFieldList();
                $vars['list_action'] = '/especialidades/showList';
                $vars['list_css'] = 'content_list';
                $vars['url_delete'] = base_url() . 'especialidades/delete/';
                $vars['url_delete_grupal'] = base_url() . 'especialidades/deleteGrupal/';

                $vars['url_edit'] = base_url() . '/especialidades/showForm/';
                $vars['url_print'] = base_url() . 'especialidades/printReport/';
                $vars['current_user'] = $this->current_user->user($this->db);

                $this->load->view('template_view', $vars);
            }

             public function showForm($id = null){

                $vars['title'] = 'Especialidades';
                $vars['content_view'] = 'especialidad_abm_view';
                $vars['content_class'] = '';

                $vars['form_action'] = 'especialidades/save';

                /* DATA */
                                
                $vars['especialidad'] = $this->getEspecialidad($id);
                $vars['current_user'] = $this->current_user->user($this->db);
                $this->load->view('template_view', $vars);

            }

             public function printReport(){

                $html = $this->getReporteEspecialidades($this->input->get('selected_ids'));

                //$html = 'hola';
                //echo $html;


                $this->load->library('pdf');
                $this->pdf->SetCreator(PDF_CREATOR);
                $this->pdf->SetAuthor('SGDA');
                $this->pdf->SetTitle('Listado de Especialidades');
                $this->pdf->SetSubject('Listado de Especialidades');
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

            private function getReporteEspecialidades($selectedIds){

                $td_field_width_list_col = '170';


                $align_default = 'left';

                if($selectedIds != ''){

                    $especialidades = array();

                    $selectedIdsArray = explode(',', $selectedIds);

                    foreach ($selectedIdsArray as $id) {
                        $especialidad = $this->getEspecialidadArray($id);
                        //print_r($asegurado);
                        array_push($especialidades, $especialidad[0]);
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
            <div class="cap_name">Listado de Especialidades</div>
            <p></p>

            <table class="first" cellpadding="0" cellspacing="0">
            <tr>

              <td width="{$td_field_width_list_col}" style="font-weight:bold;font-size:14pt" align="{$align_default}">Especialidad</td>
            </tr>
            <p></p>
EOF;
                foreach ($especialidades as $especialidad) {
                    $descripcion = $especialidad['descripcion'];
                    
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

            private function getEspecialidadArray($id){
                if(!is_null($id)){

                    $fieldList = $this->getFieldList();

                    $query = ESPECIALIDADES . " WHERE esp.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->result_array();
                }
            }
             public function deleteGrupal(){
                $selectedIds = $this->input->post('selected_ids');
                $selectedIdsArray = explode(',', $selectedIds);

                print_r($selectedIdsArray);

                foreach ($selectedIdsArray  as $id_especialidad) {
                    $this->delete($id_especialidad);
                }
            }

            function delete($id_especialidad){

                $this->db->where('id_especialidad', $id_especialidad);
                $this->db->delete('especialidades');

                echo array(
                        "msg" => "La especialidad se ha borrado exitosamente"
                    ,   "msg_class" => "exito"
                );
            }

             private function getEspecialidades($inputFields){

                $query = ESPECIALIDADES;

                $query = $this->add_filters($query, $inputFields);

                return $this->db->query($query);
            }

            private function getFieldList(){
                return array(
                        'id' => 'id_especialidad',
                        'descripcion'=> array(
                            'header' => "Especialidad"
                        )

                );
           }

            private function getEspecialidad($id){
                if(!is_null($id)){

                    $fieldList = $this->getFieldList();

                    $query = ESPECIALIDADES . " WHERE esp.".$fieldList['id'] . "=" . $id;
                    return $this->db->query($query)->row();
                }
                
            }

            function save(){

                 /* POST */
                $id_especialidad = $this->input->post('id_especialidad');

                $especialidad = array(
                            'descripcion' => $this->input->post('descripcion')
                );

                if(isset($id_especialidad) && is_numeric($id_especialidad)){

                    //Edita registro
                    if($this->existeEspecialidad($id_especialidad)){

                        $this->db->where('id_especialidad',$id_especialidad);
                        $this->db->update('especialidades', $especialidad);
                        echo "el registro 'especialidad' se ha modificado correctamente.";
                    }

                    //Inserta registro
                    else{
                        $this->db->insert('especialidades', $especialidad);
                        echo "el registro 'especialidad' se ha insertado correctamente.";
                    }
                }
            }

             function existeEspecialidad($id_especialidad){
                $query = ESPECIALIDADES;
                $query.= " WHERE esp.id_especialidad = ". $id_especialidad;

                $result = $this->db->query($query);
                return $result->num_rows()==1;
            }

           







}
?>
