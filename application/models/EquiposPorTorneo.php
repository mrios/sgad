<?php

class EquiposPorTorneo {
   public function __contruct(){
            __construct();
        }

        //atributos
        var $id_equipo_torneo;
        var $id_equipo;
        var $id_torneo;

        //setters
        function setIdEquipoTorneo($id_persona_equipo){
            $this->id_equipo_torneo = $id_persona_equipo;
        }

        function setIdEquipo($id_equipo){
            $this->id_equipo = $id_equipo;
        }

        function setIdTorneo($id_torneo){
            $this->id_torneo = $id_torneo;
        }

        //getters
        function getIdEquipoTorneo(){
            return $this->id_equipo_torneo;
        }

        function getTorneo(){
            return $this->id_torneo;
        }

        function getIdEquipo(){
            return $this->id_equipo;
        }
}
?>
