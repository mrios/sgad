<?php

class Especialidad {

    public function __contruct(){
            __construct();
        }

        //atributos
        var $id_especialidad;
        var $descripcion;

        //setters
        function setIdEspecialidad($id_especialidad){
            $this->id_especialidad = $id_especialidad;
        }

        function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
        }

        //getters
        function getIdEspecialidad(){
            return $this->id_especialidad;
        }

        function getDescripcion(){
            return $this->descripcion;
        }
    }
?>
