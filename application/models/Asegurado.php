<?php

 class Asegurado {
     
        public function __contruct(){
            __construct();
        }
     
        //atributos
        var $documento;
        var $tipo_documento;
        var $legajo;
        var $apellido;
        var $nombre;
        var $email;
        var $fecha_inscripcion;
        var $telefono;
        var $fecha_nacimiento;
        var $referencia;
        
        //setters
        function setDocumento($documento){
            $this->documento = $documento;
        }

        function setTipoDocumento($tipo_documento){
            $this->tipo_documento = $tipo_documento;
        }

        function setLegajo($legajo){
            $this->legajo = $legajo;
        }

        function setApellido($apellido){
            $this->apellido = $apellido;
        }

        function setNombre($nombre){
            $this->nombre = $nombre;
        }

        function setEmail($email){
            $this->email = $email;
        }

        function setFechaInscripcion($fecha_inscripcion){
            $this->fecha_inscripcion = $fecha_inscripcion;
        }

        function setIdEspecialidad($id_especialidad){
            $this->id_especialidad = $id_especialidad;
        }

        function setTelefono($telefono){
            $this->telefono = $telefono;
        }

        function setFechaNacimiento($fecha_nacimiento){
            $this->fecha_nacimiento = $fecha_nacimiento;
        }

        function setReferencia($referencia){
            $this->referencia = $referencia;
        }

        //getters
        function getDocumento(){
            return $this->documento;
        }

        function getTipoDocumento(){
            return $this->tipo_documento;
        }

        function getLegajo(){
            return $this->legajo;
        }

        function getApellido(){
            return $this->apellido;
        }
        
        function getNombre(){
            return $this->nombre;
        }

        function getEmail(){
            return $this->email;
        }

        function getFechaInscripcion(){
            return $this->fecha_inscripcion;
        }

        function getIdEspecialidad(){
            return $this->id_especialidad;
        }

        function getTelefono(){
            return $this->telefono;
        }

        function getFechanacimiento(){
            return $this->fecha_nacimiento;
        }

        function getReferencia(){
            return $this->referencia;
        }
    }
?>
