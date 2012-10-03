<?php

class Actividades {
    public function __contruct(){
            __construct();
        }

        //atributos
        var $id_actividad;
        var $descripcion;

        //setters
        function setIdAdctividad($id_actividad){
            $this->id_actividad = $id_actividad;
        }

        function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
        }

        //getters
        function getIdActividad(){
            return $this->id_actividad;
        }

        function getDescripcion(){
            return $this->descripcion;
        }
}
?>
