<?php
$id_torneo=0;
$nombre = '';
$acti = array('');
$equipo = array('');

if(is_object($torneo)){
    $id_torneo= $torneo->id_torneo;
    $nombre = $torneo->nombre;
    $acti= array ($torneo->id_actividad);
    

}

    // asegurado_form_list

    echo form_open(base_url().$form_action, array('class'=>'cmxform', 'id'=>'form_torneo')); 
            

        echo "<p>";
        echo form_hidden('id_torneo', set_value ('id_torneo',$id_torneo));
        echo "</p>";


        echo "<p>";
        echo form_label('Nombre' . form_required(), 'nombre');
        echo form_input(array(
                            'size' => 35
                        ,   'name' => 'nombre'
                )
                ,   set_value('nombre', $nombre)
                );
        echo "</p>";

        echo "<p>";
        echo form_label('Actividad', 'id_actividad');
        echo form_dropdown('id_actividad', arrayResultToDropdown($act, 'id_actividad', 'descripcion'), $acti);
        echo "</p>";
        
       

        echo form_submit('guardar', 'Guardar');


    echo form_close(); 
    
    ?>
    <script type="text/javascript">
        $.validator.setDefaults({
                submitHandler: function() { 
                    saveAsegurado();
                }
        });
        
        function saveAsegurado(){
                
                var url= '<?=base_url()?>asegurados/save';
                var data = $("#form_asegurado").serialize();
                
                alert(data);
                    
                ajax_notify(url, data);
        }

        $().ready(function() {
                
                // validate signup form on keyup and submit
                $("#form_asegurado").validate({
                        rules: {
                                documento: {
                                        required: true,
                                        minlength: 8
                                },
                                legajo: {
                                        required: true,
                                        minlength: 4
                                },
                                apellido: {
                                        required: true,
                                        minlength: 2
                                },
                                nombre: {
                                        required: true,
                                        minlength: 2
                                },
                                email: {
                                        email: true
                                },
                                fecha_nacimiento: {
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
    
    

