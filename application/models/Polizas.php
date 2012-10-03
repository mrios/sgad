
<?php

 class Polizas {
        public function __contruct(){
            __construct();
        }

        //atributos
        var $id_poliza;
        var $nombre_aseguradora;
        var $direccion;
        var $localidad;
        var $telefono;
        var $nro_poliza;
        var $fecha_inicio;
        var $fecha_final;


         function setIdPoliza($id_poliza){
         $this->id_poliza = $id_poliza;
        }

        function setNombreAseguradora($nombre_aseguradora){
            $this->nombre_aseguradora = $nombre_aseguradora;
        }

        function setDireccion($direccion){
            $this->direccion = $direccion;
        }

        function setLocalidad($localidad){
            $this->localidad = $localidad;
        }


        function setTelefono($telefono){
            $this->telefono = $telefono;
        }

        function setNroPoliza($nro_poliza){
            $this->nro_poliza = $nro_poliza;
        }

        function setFechaInicio($fecha_inicio){
            $this->fecha_inicio = $fecha_inicio;
        }

        function setFechaFinal($fecha_final){
            $this->fecha_final = $fecha_final;
        }

        

        //getters
        function getIdPoliza(){
           return $this->id_poliza;
        }

        function getNombreAseguradora(){
            return $this->nombre_aseguradora;
        }

        function getDireccion(){
            return $this->direccion;
        }

        function getLocalidad(){
            return $this->localidad;
        }


        function getTelefono(){
            return $this->telefono;
        }

        function setNroPoliza(){
            return $this->nro_poliza;
        }

        function setFechaInicio(){
            return $this->fecha_inicio;
        }

        function setFechaFinal(){
            return $this->fecha_final;
        }



        //getters
    

 }


?>
