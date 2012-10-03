<?php

class Accidente {

public function __contruct(){
            __construct();
        }

        //atributos
        var $id_accidente;
        var $dni;
        var $fecha_accidente;
        var $descripcion;


        //setters
        function setIdAccidente($id_accidente){
            $this->id_accidente = $id_accidente;
        }

        function setDni($dni){
            $this->dni = $dni;
        }

        function setFechaAccidente($fecha_accidente){
            $this->fecha_accidente = $fecha_accidente;
        }

        function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
        }
    
        //getters
        function getIDAccidente(){
            return $this->id_accidente;    
        }
        function getDni(){
            return $this->dni;    

        }
        function getFechaAccidente(){
            return $this->fecha_accidente;    

        }
        function getDescripcion(){
            return $this->descripcion;    
    
        }

}
?>
