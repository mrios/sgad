<?php

$nombre = '';
$id_delegado = array('');
$id_delegado1 = array('');
$id_entrenador = array('');
$id_entrenador1 = array('');

$id_equipo = 0;
//$apellido='';
//$nombre1 = '';

if(is_object($equipo)){
    $id_equipo = $equipo->id_equipo;
    $nombre = $equipo->nombre;
    $id_delegado = $equipo->id_delegado;
    $nombre_delegado = "Test Delegado";
    $id_entrenador = $equipo->id_entrenador;
    $nombre_entrenador = "Test Entrenador";
   
}

    // asegurado_form_list

    echo form_open(base_url().$form_action, array('class'=>'cmxform', 'id'=>'form_equipo'));

        echo "<p>";
        echo form_hidden('id_equipo', set_value ('id_equipo',$id_equipo));
        echo "</p>";
        

        echo "<p>";
        echo form_label('Nombre del Equipo' . form_required(), 'nombre');
        echo form_input(array(
                            'size' => 35
                        ,   'name' => 'nombre'
                )
                ,   set_value('nombre', $nombre)
                );
        echo "</p>";
;
        echo "<br>","</br>";
        echo "<p>";
        echo form_label('Delegado', 'delegado');
        echo form_input(array(
                            'size' => 35
                        ,   'name' => 'delegado'
                        ,   'id' => 'delegado'
                )
                ,   set_value('delegado', $nombre_delegado)
                );
        echo "</p>";
//        echo form_label('Apellido', 'documento');
//
//
//        echo form_dropdown('documento', arrayResultToDropdown($deleg, 'documento','apellido'), $id_delegado);
//        echo "    ";
//        echo form_label('Nombre ', 'documento');
//        echo form_dropdown('documento', arrayResultToDropdown($deleg1, 'documento','nombre'), $id_delegado1);
//
//        echo br(4);
//        echo "<p>";
//        echo form_label('Entrenador', 'documento');
//        echo "</p>";

        //*echo "<p>";
        //*echo form_label('Delegado' . form_required(), 'delegado');
        //*echo form_input(
        //*            'id_delegado'
        //*        ,   set_value('id_delegado', $id_delegado)
        //*        );
        //*echo "</p>";
        
        //echo "<p>";
        //echo form_label('Entrenador' . form_required(), 'entrenador');
        //echo form_input(
        //            'id_entrenador'
        //        ,   set_value('id_entrenador', $id_entrenador)
        //        );
        //echo "</p>";

        echo br(4);

        echo form_submit('guardar', 'Guardar');
    echo form_close();

    ?>
    <script type="text/javascript">
        $.validator.setDefaults({
                submitHandler: function() {
                    saveEquipo();
                    $("#form_dialog").dialog('close');


    }
        });

        function saveEquipo(){

                var url= '<?=base_url()?>equipos/save';
                var data = $("#form_equipo").serialize();
                
                ajax_notify(url, data);
        }

        $().ready(function() {

                // validate signup form on keyup and submit
                $("#form_equipo").validate({
                        rules: {
                                                               
                                nombre: {
                                        required: true,
                                        minlength: 2
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

                $("#delegado").autocomplete({
                    source: function(request, response){
                       var url = "<?=base_url()?>/autocomplete/getPersonasNombreCompleto/"
                       $.ajax({
                            dataType: "json",
                            url: url,
                            data: {
                                term: request.term
                            },
                            success: function (data) {
                                response(
                                    $.map (
                                            data
                                        ,   function(item){
                                                return {
                                                        label: item.nombreCompleto + " (DNI: " +  item.documento + " )"
                                                    ,   value: item.nombreCompleto
                                                }
                                        }
                                    )
                                )
                            }
                        });
                    }
                    , minLength : 2
                })
        });
</script>

