<?php 

if (!$current_user || (current_url() == base_url().'login_form')): 
    redirect('login_form');
else: ?>
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
                <?php 
                    $this->load->view('menu_view');
                    echo br(4);
                ?>
                        
        
<!--                <div id="form_dialog" title="Formulario de Carga" class="hidden">
                    <div id="form_content"></div>
                </div>-->
        
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span2">
                        <!--Sidebar content-->
                        <ul class="nav nav-list">
                            <li class="nav-header">List header</li>
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="#">Library</a></li>
                            ...
                        </ul>
                        </div>
                        <div class="span10">
                        <!--Body content-->
                        <?php $this->load->view($content_view); ?>
                        </div>
                    </div>
                </div>
                
                
    </body>
</html>	
<script type="text/javascript">

    $(document).ready(function(){
        activeDefaults();
    });
    
    function openDialogForm(url_edit, id){

        $("#form_dialog").dialog({ 
                    modal: true
                ,   heigth: 600
                ,   width: 900
                ,   top: 0
            }
        );
        
        loadForm(url_edit, id);
            
    };
    
    function loadForm(url_edit, id){
        
        url_edit = url_edit + id
        ajax_min(url_edit, '#form_content');
        
    }
    
</script>
<?php endif; ?>

