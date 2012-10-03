<?

$this->load->view('list_actions_view'); //Carga de iconos de listado PDF
$this->load->view($list_form);

?>

<div id="poliza_list" class="template_list">

         <table cellpadding="0" cellspacing="0" width="100%" class="table-default">

            <thead>
                <th align='center'>
                    <? echo form_checkbox(array(
                            'name' => 'all',
                            'id' => 'all'
                        )
                    )?>
                </th>
                <?
                    echo "<th align='center'>Nombre</th>";
                    echo "<th align='center'>Direccion</th>";
                    echo "<th align='center'>Localidad</th>";
                    echo "<th align='center'>Telefono</th>";
                    echo "<th align='center'>Nro Poliza</th>";
                    echo "<th align='center'>Fecha Inicio</th>";
                    echo "<th align='center'>Fecha Final</th>";
                    echo "<th align='center'>Listado de Personas</th>";
                    echo "<th align='center'>Editar</th>";
                    echo "<th align='center'>Eliminar</th>";
                ?> 
            </thead>
            <body>
             <?

             foreach ($list_data->result_array() as $data) {


                       echo "<tr id='".$data['id_poliza']."'>";

                       echo "<td align='center' width='25'>".form_checkbox(array('class' => 'checkable'))."</td>";

                       
                       echo "<td>".$data['nombre_aseguradora']."</td>";
                       echo "<td>".$data['direccion']."</td>";
                       echo "<td>".$data['localidad']."</td>";
                       echo "<td>".$data['telefono']."</td>";
                       echo "<td>".$data['nro_poliza']."</td>";
                       echo "<td>".$data['fecha_inicio']."</td>";
                       echo "<td>".$data['fecha_final']."</td>";
                       //Link editar
                       echo "<td>";
                       echo anchor('#'
                           , img(
                                array(
                                        'src'   =>  base_url().'images/icons/pencil.png'
                                    ,   'alt'   =>  'Agregar Personas'
                                    ,   'title' =>  'Agregar Personas'
                                )
                            )
                            , array('class'=>'agregar')
                       );
                       echo "</td>";



                       echo "<td>";
                       echo anchor('#'
                           , img(
                                array(
                                        'src'   =>  base_url().'images/icons/pencil.png'
                                    ,   'alt'   =>  'Editar'
                                    ,   'title' =>  'Editar'
                                )
                            )
                            , array('class'=>'editar')
                       );
                       echo "</td>";
                       //Link borrar
                       echo "<td>";
                       echo anchor('#'
                           , img(
                                array(
                                        'src'   =>  base_url().'images/icons/sign_remove.png'
                                    ,   'alt'   =>  'Eliminar'
                                    ,   'title' =>  'Eliminar'
                                )
                            )
                            , array('class'=>'eliminar')
                       );
                       echo "</td>";

                       echo "</tr>";

                }
              ?>
            </body>
         </table>
</div>
<script type="text/javascript">
        var selectedIds = [];

	$(document).ready(inicializarEventos);

        function inicializarEventos() {

                $(".editar").click(function(){


                        var id = $(this).parent().parent().attr('id');
                        var url_edit = '<?=$url_edit?>';

                        openDialogForm(url_edit, id);
                        return false;
                });

                $(".eliminar").click(function(){

                    id = $(this).parent().parent().attr('id');
                    respuesta = confirm("Desea eliminar el registro?");
                    if (respuesta){
                        url = "<?=$url_delete?>/" + id;
                        ajax_notify(url);
                        return false;

                    }
                });

                 $(".agregar").click(function(){

                    var id = $(this).parent().parent().attr('id');
                       var url_add = '<?=$url_agregar_personas?>';

                        openDialogForm(url_add, id);
                        return false;
                });

                $('input.checkable:checkbox').change(function(){
                        if($(this).is(':checked')) selectedIds.push($(this).parent().parent().attr('id'));
                })


                $('#all').change(function(){

                    $("input.checkable:checkbox").each(function(){
                        $(this).attr('checked', $("#all").is(':checked'));
                        if($(this).is(':checked')) selectedIds.push($(this).parent().parent().attr('id'))
                    })


                });

                $("#print").click(function(){
                        var strSelectedIds = selectedIds + "";
                        var data = "?selected_ids=" + strSelectedIds;
                        var url = '<?=$url_print?>' + data;

                        $(this).attr('href', url);



                });

        }

//        function addCheckedToSelected(){
//
//                $('form input.checkable:checkbox').each( function(){
//                      if($(this).is(':checked')) selectedIds.push($(this).parent().parent().attr('id'))
//                });
//        }

</script>

