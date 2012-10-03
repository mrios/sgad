<?php

 class Equipo {
        public function __contruct(){
            __construct();
        }

        //atributos
        var $id_equipo;
        var $nombre;
        var $delegado_dni;
        var $entrenador_dni;

        //setters
        function setIdEquipo($id_equipo){
            $this->id_equipo = $id_equipo;
        }

        function setNombre($nombre){
            $this->nombre = $nombre;
        }

        function setDelegadoDni($delegado_dni){
            $this->delegado_dni = $delegado_dni;
        }

        function setEntrenadorDni($entrenador_dni){
            $this->entrenador_dni = $entrenador_dni;
        }

        //getters
        function getIdEquipo(){
            return $this->id_equipo;
        }

        function getNombre(){
            return $this->nombre;
        }

        function getDelegadoDni(){
            return $this->delegado_dni;
        }

        function getEntrenadorDni(){
            return $this->entrenador_dni;
        }
    }
?>
