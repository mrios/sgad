<?php
$tipoDoc = array('');
$id_accidente = 0;
$documento = '';
$fecha_accidente = '';
$descripcion = '';
$acti = array ('');
$nombre ='';
$apellido = '';

if(is_object($accidente)){
    $tipoDoc = array($asegurado->tipo_documento);
    $id_accidente = $accidente->id_accidente;
    $documento = $accidente->documento;
    $fecha_accidente = $accidente->fecha_accidente;
    $nombre = $accidente -> nombre;
    $apellido = $accidente ->apellido;
    $descripcion = $accidente->descripcion;
    $acti = array ($accidente->documento);
}

    // accidente_form_list

    echo form_open(base_url().$form_action, array('class'=>'cmxform', 'id'=>'form_accidente'));

        //Id accidente para Identificar el registro en caso de Editar/Borrar
        
         echo "<p>";
        echo form_hidden('id_accidente', set_value ('id_accidente',$id_accidente));
        echo "</p>";

        echo "<p>";
        echo form_label('Tipo Documento', 'tipo_documento');
        echo form_dropdown('tipo_documento', arrayResultToDropdown($tipos, 'id_tipo_documento', 'descripcion'), $tipoDoc);
        echo "</p>";

        echo "<p>";
        echo form_label('Documento' . form_required(), 'documento');
        echo form_input(
                    'documento'
                ,   set_value('documento', $documento)
                );
        echo "</p>";

        
        echo "<p>";
        echo form_label('Fecha Accidente' . form_required(), 'fecha_accidente');

        $fecha_a = new DateTime($fecha_accidente);

        echo form_input(
                    array('name'=>'fecha_accidente', 'class'=>'date')
                ,   set_value('fecha_accidente', date_format($fecha_a, "d/m/Y"))
        );
        echo "</p>";

        echo "<p>";
        echo form_label('Descripcion' . form_required(), 'descripcion');
        echo form_input(
                    'descripcion'
                ,   set_value('descripcion', $descripcion)
                );
        echo "</p>";

        echo br(2);

        echo form_submit('guardar', 'Guardar');

    echo form_close();

    ?>
    <script type="text/javascript">
        $.validator.setDefaults({
                submitHandler: function() {
                    saveAccidente();
                }
        });

        function saveAccidente(){

                var url= '<?=base_url()?>accidentes/save';
                var data = $("#form_accidente").serialize();


                ajax_notify(url, data);
        }

        $().ready(function() {

                // validate signup form on keyup and submit
                $("#form_accidente").validate({
                        rules: {
                                
                                
                                fecha_accidente: {
                                        required: true
                                }
                        },
                        messages: {
                                firstname: "Please enter your firstname",
                                lastname: "Please enter your lastname",
                                username: {
                                        required: "Please enter a username",
                                        minlength: "Your username must consist of at least 2 characters"
                                },
                                password: {
                                        required: "Please provide a password",
                                        minlength: "Your password must be at least 5 characters long"
                                },
                                confirm_password: {
                                        required: "Please provide a password",
                                        minlength: "Your password must be at least 5 characters long",
                                        equalTo: "Please enter the same password as above"
                                },
                                email: "Please enter a valid email address",
                                agree: "Please accept our policy"
                        }
                });
        });
</script>

