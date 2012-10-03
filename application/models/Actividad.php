<?php

 class Actividad {
     
        public function __contruct(){
            __construct();
        }
     
        //atributos
        var $idActividad;
        var $descripcion;
        
        //setters
        function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
        }
        
        
        //getters
        function getDescripcion(){
            return $this->descripcion;
        }
        
        
        
    }
?>
