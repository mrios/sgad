<?php

$doc = '';
$nom = '';
$ape = '';
$fecNac = '';
$leg = '';
$email = '';
$tel = '';
$ref = '';
$tipoDoc = array('');
$espe = array('');
$estado = array('');

if(is_object($asegurado)){
    $doc = $asegurado->documento;
    $nom = $asegurado->nombre;
    $ape = $asegurado->apellido;
    $fecNac = $asegurado->fecha_nacimiento;
    $leg = $asegurado->legajo;
    $ref = $asegurado->referencia;
    $email = $asegurado->email;
    $tel = $asegurado->telefono;
    $tipoDoc = array($asegurado->tipo_documento);
    $espe = array($asegurado->id_especialidad);
    $estado = array($asegurado->id_estado);
}

    // asegurado_form_list

    echo form_open(base_url().$form_action, array('class'=>'cmxform', 'id'=>'form_asegurado')); 
    
        echo "<p>";
        echo form_label('Tipo Documento', 'tipo_documento');
        echo form_dropdown('tipo_documento', arrayResultToDropdown($tipos, 'id_tipo_documento', 'descripcion'), $tipoDoc); 
        echo "</p>";
        
        echo "<p>";
        echo form_label('Documento' . form_required(), 'documento');
        echo form_input(
                    'documento'
                ,   set_value('documento', $doc)
                ); 
        echo "</p>";
        
        echo "<p>";
        echo form_label('Legajo');
        echo form_input(
                    'legajo'
                ,   set_value('legajo', $leg)
        ); 
        echo "</p>";
        
        echo "<p>";
        echo form_label('Apellido' . form_required(), 'apellido');
        echo form_input(
                    'apellido'
                ,   set_value('apellido', $ape)
        );
        echo "</p>";
        
        echo "<p>";
        echo form_label('Nombre' . form_required(), 'nombre');
        echo form_input(
                    'nombre'
                ,   set_value('nombre', $nom)
        );
        echo "</p>";
        
        echo "<p>";
        echo form_label('email', 'email');
        echo form_input(
                    'email'
                ,   set_value('email', $email)
        ); 
        echo "</p>";
        
        echo "<p>";
        echo form_label('Especialidad', 'id_especialidad');
        echo form_dropdown('id_especialidad', arrayResultToDropdown($especialidades, 'id_especialidad', 'descripcion'), $espe);
        echo "</p>";
        
        echo "<p>";
        echo form_label('Telefono', 'telefono');
        echo form_input(
                    'telefono'
                ,   set_value('telefono', $tel)
        ); 
        echo "</p>";
        
        echo "<p>";
        echo form_label('Fecha Nacimiento' . form_required(), 'fecha_nacimiento');
        
        $fecha_nacimiento = new DateTime($fecNac);
        
        echo form_input(
                    array('name'=>'fecha_nacimiento', 'class'=>'date')
                ,   set_value('fecha_nacimiento', date_format($fecha_nacimiento, "d/m/Y"))
        ); 
        echo "</p>";
        
        echo "<p>";
        echo form_label('Referencia', 'referencia');
        echo form_input(
                    'referencia'
                ,   set_value('referencia', $ref)
        ); 
        echo "</p>";

        echo "<p>";
        echo form_label('Estado', 'id_estado');
        echo form_dropdown('id_estado', arrayResultToDropdown($estados, 'id_estado', 'descripcion'), $estado);
        echo "</p>";

        echo "<p>";
        echo form_label('Entrenador', 'id_tipo_asegurado');
        echo form_checkbox('entrenador', 'accept', FALSE);
        echo "</p>";



        echo br(2);
        
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
    
    

