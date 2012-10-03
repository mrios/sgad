<?php   
$id_poliza=0;
$nombre_aseguradora='';
$direccion = '';
$localidad = '';
$telefono='';
$nro_poliza = '';
$fecha_inicio = '';
$fecha_final = '';



if(is_object( $poliza)){
    $id_poliza = $poliza->id_poliza;
    $nombre_aseguradora = $poliza->nombre_aseguradora;
    $direccion = $poliza->direccion;
    $localidad = $poliza->localidad;
    $telefono = $poliza->telefono;
    $nro_poliza = $poliza->nro_poliza;
    $fecha_inicio = $poliza->fecha_inicio;
    $fecha_final = $poliza->fecha_final;

}

    // poliza_form_list

    echo form_open(base_url().$form_action, array('class'=>'cmxform', 'id'=>'form_poliza'));
    
        echo "<p>";
        echo form_hidden('id_poliza', set_value ('id_poliza',$id_poliza));
        echo "</p>";


        echo "<p>";
        echo form_label('Nombre Aseguradora'.form_required(), 'nombre_aseguradora');
        echo form_input(
                    'nombre_aseguradora'
                ,   set_value('nombre_aseguradora', $nombre_aseguradora)
        );
        echo "</p>";

        echo "<p>";
        echo form_label('Direccion' . form_required(), 'direccion');
        echo form_input(
                    'direccion'
                ,   set_value('direccion', $direccion)
        );
        echo "</p>";





        echo "<p>";
        echo form_label('Localidad', 'localidad');
        echo form_input(
                    'localidad'
                ,   set_value('localidad', $localidad)
        );
        echo "</p>";

        

        echo "<p>";
        echo form_label('Telefono' . form_required(), 'telefono');
        echo form_input(
                    'telefono'
                ,   set_value('telefono', $telefono)
        );
        
        echo "</p>";

        

        echo "<p>";
        echo form_label('Numero de Poliza' . form_required(), 'nro_poliza');
        echo form_input(
                    'nro_poliza'
                ,   set_value('nro_poliza', $nro_poliza)
                );
        echo "</p>";
        
        echo "<p>";    
        echo form_label('Fecho Inicio' . form_required(), 'fecha_inicio');
        
        $fecha_polizaini = new DateTime($fecha_inicio);
        
        echo form_input(
                    array('name'=>'fecha_inicio', 'class'=>'date')
                ,   set_value('fecha_inicio', date_format($fecha_polizaini, "d/m/Y"))
        ); 
        echo "</p>";
        
        
        echo "<p>";    
        echo form_label('Fecho Finalizacion' . form_required(), 'fecha_final');
        
        $fecha_polizafin = new DateTime($fecha_final);
        
        echo form_input(
                    array('name'=>'fecha_final', 'class'=>'date')
                ,   set_value('fecha_final', date_format($fecha_polizafin, "d/m/Y"))
        ); 
        echo "</p>";


        echo nbs(2);
        
        echo form_submit('guardar', 'Guardar');
        echo nbs(2);
        echo "<br></br>";
        echo anchor(base_url().'asegurados/showList', 'Cambiar estado de personas', array('class'=>'agregar_pers'));


    echo form_close(); 
    
    ?>
    <script type="text/javascript">
        $.validator.setDefaults({
                submitHandler: function() { 
                    savePoliza();

                }
        });
        
        function savePoliza(){
                
                var url= '<?=base_url()?>polizas/save';
                var data = $("#form_poliza").serialize();
                    
                ajax_notify(url, data);
               
        }

        $().ready(function() {
                
                // validate signup form on keyup and submit
                $("#form_poliza").validate({
                        rules: {
                                
                                telefono: {
                                        required: true,
                                        minlength: 6
                                },
                                fecha_inicio: {
                                        required: true
                                },
                                fecha_final: {
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
          $(".agregar_pers").button();
            $(".agregar_pers").click(function(){

                url_agregar_pers = '<?=$url_agregar_pers?>';
                return false;
            });

        
        

               

     
</script>
    
    

