<!DOCTYPE html>
<html lang="es">
    <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $title; ?> | Sistema de Seguros</title>
            
            <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo base_url(); ?>css/bootstrap-responsive.css" rel="stylesheet">
            
            <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.2.min.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>js/js/bootstrap.min.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>
            
    </head>
<body>
    <div class="container">
        <? echo br(6); ?>
        <div class="hero-unit span6 offset2">
        <legend>SGAD :: Sistema de Gesti&oacute;n de Actividades Deportivas</legend>
        
        <? $attr_form = array('id'   => 'form_login', 'class' => 'form-horizontal');?>

	<? echo form_open('login_form/submit', $attr_form); ?>

	<? echo validation_errors('<div class="alert alert-error">','</div>'); ?>
       
	<div class="control-group">
                <label class="control-label" for="username">Username</label>
		<? $attr_input_username = array('name' => 'username', 'id' => 'username', 'size' => '25' , 'placeholder'=>'Username'); ?>
                <div class="controls">
                    <? echo form_input($attr_input_username); ?>
                </div>
	</div>
        <div class="control-group">
		<? $attr_input_password = array('name' => 'password', 'id' => 'password', 'size' => '25', 'placeholder'=>'Password'); ?>
                <label class="control-label" for="password">Password</label>
		<div class="controls">
                    <? echo form_password($attr_input_password); ?>
                </div>
	</div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn">Ingresar</button>
            </div>
        </div>

	<? echo form_close(); ?>
	</div>
</div>
<script type="text/javascript">

	$(document).ready(inicializarEventos);

	function inicializarEventos() {
            $('#username').focus();
	}
</script>
</body>
</html>