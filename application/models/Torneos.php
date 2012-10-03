<?php

class Torneos {
    public function __contruct(){
            __construct();
        }

        //atributos
        var $id_torneo;
        var $nombre;
        var $id_actividad;

        //setters
        function setIdTorneo($id_torneo){
            $this->id_torneo = $id_torneo;
        }

        function setNombre($nombre){
            $this->nombre = $nombre;
        }

        function setIdActividad($id_actividad){
            $this->id_actividad = $id_actividad;
        }

        //getters
        function getIdTorneo(){
            return $this->id_torneo;
        }

        function getNombre(){
            return $this->nombre;
        }

        function getIdActividad(){
            return $this->id_actividad;
        }
}
?>
