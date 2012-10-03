<?

$this->load->view('list_actions_view'); //Carga de iconos de listado PDF
$this->load->view($list_form);


?>

<div id="agregarasegurados_list" class="template_list">

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
                echo "<th align='center'>Apellido</th>";
                echo "<th align='center'>Nombre</th>";
                echo "<th align='center'>Documento</th>";
                echo "<th align='center'>Fecha de Nacimiento</th>";

                ?>
            </thead>
            <body>
             <?

             foreach ($list_data->result_array() as $data) {


                       echo "<tr id='".$data['documento']."'>";

                       echo "<td align='center' width='25'>".form_checkbox(array('class' => 'checkable'))."</td>";


                       echo "<td>".$data['apellido']."</td>";
                       echo "<td>".$data['nombre']."</td>";
                        echo "<td>".$data['documento']."</td>";
                       echo "<td>".$data['fecha_nacimiento']."</td>";




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
                       var url_add = '<?=$url_agregar_equipo?>';

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
