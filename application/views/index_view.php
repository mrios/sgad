<h1 class="">
        SGAD :: Sistema de Gesti&oacute;n de Actividades Deportivas.
</h1>
<div class="">
        <?=anchor(base_url().'asegurados/showList', 'Personas')?>
        <?=anchor(base_url().'equipos/showList', 'Equipos')?>
        <?=anchor(base_url().'torneos/showList', 'Torneos')?>
        <?=anchor(base_url().'polizas/showList', 'Polizas')?>
        <?=anchor(base_url().'accidentes/showList', 'Accidentes')?>
        <?=anchor(base_url().'especialidades/showList', 'Especialidades')?>
        <?=anchor(base_url().'actividades/showList', 'Actividades')?>
</div>
<script type="text/javascript">

    $(document).ready(function(){
        $(".speed-dial-wrapper a").button()
    });
    
 </script>