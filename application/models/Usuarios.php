<?php

 class Usuarios {

        public function __contruct(){
            __construct();
        }

        //atributos
        var $id_usuario;
        var $usuario;
        var $clave;

        //setters
        function setIdUsuario($apellido){
            $this->id_usuario = $id_usuario;
        }

        function setUsuario($apellido){
            $this->usuario = $usuario;
        }

        function setClave($apellido){
            $this->clave = $clave;
        }

        //getters
        function getIdUsuario(){
            return $this->id_usuario;
        }

        function getUsuario(){
            return $this->usuario;
        }

        function getClave(){
            return $this->clave;
        }
    }
?>
