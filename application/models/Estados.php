<?php

class Estados {

        public function __contruct(){
            __construct();
        }

        //atributos
        var $id_estado;
        var $dni;
        var $fecha_alta;
        var $fecha_baja;

        //setters
        function setIdEstado($id_estado){
            $this->id_estado = $id_estado;
        }

        function setDni($dni){
            $this->dni = $dni;
        }

        function setFechaAlta($fecha_alta){
            $this->fecha_alta = $fecha_alta;
        }

        function setFechaBaja($fecha_baja){
            $this->fecha_baja = $fecha_baja;
        }

        //getters
        function getIdEstado(){
            return $this->id_estado;
        }

        function getDni(){
            return $this->dni;
        }

        function getFechaAlta(){
            return $this->fecha_alta;
        }

        function getFechaBaja(){
            return $this->fecha_baja;
        }

    }
?>
