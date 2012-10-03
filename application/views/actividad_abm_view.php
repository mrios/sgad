
<?php

$desc = '';

if(is_object($actividad)){
    $desc = $actividad->descripcion;
}

    // actividad_form_list

    echo form_open(base_url().$form_action, array('class'=>'cmxform', 'id'=>'form_actividad'));

      echo "<p>";
        echo form_label('Actividad' . form_required(), 'descripcion');
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
                    saveAsegurado();
                }
        });

        function saveAsegurado(){

                var url= '<?=base_url()?>actividad/save';
                var data = $("#form_actividad").serialize();

                alert(data);

                ajax_notify(url, data);
        }

        $().ready(function() {

                // validate signup form on keyup and submit
                $("#form_actividad").validate({
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

