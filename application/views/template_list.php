<!-- views/template_list -->

<? 

$this->load->view('list_actions_view'); //Carga de iconos de listado PDF
$this->load->view('one_filter_view'); 

?>

<div id="template_list">
    
         <table class="table table-hover">
             
            <thead>
                <th align='center'>
                    <? echo form_checkbox(array(
                            'name' => 'all',
                            'id' => 'all'
                        )
                    )?>
                </th>
                <? 
                foreach ($list_fields as $field => $settings) {
                    
                   //Creo la cabecera de la tabla en base al listados de campos a listar
                   if(isset($settings['header'])){
                       if($field != 'id')
                        echo "<th>".$settings['header']."</th>";
                   }
                }
                echo "<th align='center'>Editar</th>";
                echo "<th align='center'>Eliminar</th>";
                ?>
            </thead>
            <body>
             <? 
             
             foreach ($list_data->result_array() as $row) {
                 
                       echo "<tr id='".$row[$list_fields['id']]."'>";
                       
                       echo "<td align='center' width='25'>".form_checkbox(array('class' => 'checkable'))."</td>";

                       foreach ($list_fields as $field => $settings) {
                           
                           if($field != 'id'){
                               //class
                               $class = "";
                               if(isset($settings['class'])){ $class= "class='".$settings['class']."'"; }

                               echo "<td $class>";
                               if(substr($field,0, 5) == 'fecha'){
                                   $fecha = new DateTime($row[$field]);
                                   echo date_format($fecha, 'd/m/Y');
                               }
                               else{
                                   echo $row[$field];
                               }
                               echo "</td>";
                           }
                           
                       }

                       //Link edit
                       echo "<td>";
                       echo "<a class='btn btn-small' href='#' class='editar'><i class='icon-edit'></i></a>";
                       echo "</td>";
                       
                       //Link delete
                       echo "<td>";
                       echo "<a class='btn btn-small' href='#' class='eliminar'><i class='icon-remove'></i></a>";
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
    
