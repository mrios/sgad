<?

echo form_open(base_url().$list_action, array('class'=>'cmxform', 'id'=>'form_list'));

        echo form_label('Nombre') . nbs();
        echo form_input('nombre') . nbs(2);

        echo form_label('Apellido') . nbs();
        echo form_input('apellido') . nbs(2);

        echo form_label('Documento') . nbs();
        echo form_input('documento') . nbs(2);

        echo "<br></br>";
        echo "<br></br>";
        echo "<center>";

        echo form_submit('buscar', 'Buscar');
       echo form_submit('guardar', 'Guardar');

        echo "</center>";


    echo form_close();
?>
<script type="text/javascript">

	$(document).ready(inicializarEventos());

        function inicializarEventos() {
            $(".alta").click(function(){

                var url_edit = '<?=$url_edit?>';

                openDialogForm(url_edit, 0);
                return false;
            });

            $(".alta").button();

            $(".alta, .delete_grupal").button();
            $(".delete_grupal").click(function(){

                url_delete = '<?=$url_delete_grupal?>';
                data = "selected_ids=" + selectedIds;
                //alert(data);
                ajax_notify(url_delete, data);
                return false;
            });


        }


</script>