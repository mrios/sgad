<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
 
      <!-- Be sure to leave the brand out there if you want it shown -->
<!--      <a class="pull-left" href="#">Sistema de Seguros</a>
 -->
      <ul class="nav pull-left">
        <li class="active"><?=anchor(base_url(), 'SGAD')?></li>
        <li><?=anchor(base_url().'asegurados/showList'      , 'Personas')?></li>
        <li><?=anchor(base_url().'equipos/showList'         , 'Equipos')?></li>
        <li><?=anchor(base_url().'torneos/showList'         , 'Torneos')?></li>
        <li><?=anchor(base_url().'polizas/showList'         , 'Polizas')?></li>
        <li><?=anchor(base_url().'accidentes/showList'      , 'Accidentes')?></li>
        <li><?=anchor(base_url().'especialidades/showList'  , 'Especialidades')?></li>
        <li><?=anchor(base_url().'actividades/showList'     , 'Actividades')?></li>
        <li><?=anchor(base_url().'pdf/index'                , 'Manual')?></li>
      </ul>
      
      <span id="user-data" class="navbar-text pull-right">
        <? if ($current_user){ ?>
            Bienvenido, <em><? echo $current_user->usuario; ?></em>
            <a href='<?=base_url()?>logout' class="navbar-link">&nbsp;<i class="icon-off icon-white"></i>&nbsp;Salir</a>
                <?
            }
        ?>
           
    </span>
      
    </div>
  </div>
</div>
<script type="text/javascript">

    $(document).ready(function(){
        $("#menu ul li a").button()
    });
    
 </script>