
<?php
$id_especialidad=0;
$desc = '';

if(is_object($especialidad)){
    $id_especialidad=$especialidad->id_especialidad;
    $desc = $especialidad->descripcion;
}

    // especialidad_form_list

    echo form_open(base_url().$form_action, array('class'=>'cmxform', 'id'=>'form_especialidad'));

       echo "<p>";
        echo form_hidden('id_especialidad', set_value ('id_especialidad',$id_especialidad));
        echo "</p>";



      echo "<p>";
        echo form_label('Especialidad' . form_required(), 'descripcion');
        echo form_input(
                    'descripcion'
                ,   set_value('descripcion', $desc)
                );
        echo "</p>";


        echo br(2);

        echo form_submit('guardar', 'Guardar');
   

    echo form_close();

    ?>
    <script type="text/javascript">
        $.validator.setDefaults({
                submitHandler: function() {
                    saveEspecialidad();
                }
        });

        function saveEspecialidad(){

                var url= '<?=base_url()?>especialidad/save';
                var data = $("#form_especialidad").serialize();

                alert(data);

                ajax_notify(url, data);
        }

        $().ready(function() {

                // validate signup form on keyup and submit
                $("#form_especialidad").validate({
                        rules: {
                                descripcion: {
                                        required: true,
                                        minlength: 8
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

