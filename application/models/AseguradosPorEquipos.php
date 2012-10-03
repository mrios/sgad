<?php

class aseguradosPorEquipo {

    public function __contruct(){
            __construct();
        }

        //atributos
        var $id_persona_equipo;
        var $dni;
        var $id_equipo;

        //setters
        function setIdPersonaEquipo($id_persona_equipo){
            $this->id_persona_equipo = $id_persona_equipo;
        }

        function setDni($dni){
            $this->dni = $dni;
        }

        function setIdEquipo($id_equipo){
            $this->id_equipo = $id_equipo;
        }

        //getters
        function getIdPersonaEquipo(){
            return $this->id_persona_equipo;
        }

        function getDni(){
            return $this->dni;
        }

        function getIdEquipo(){
            return $this->id_equipo;
        }
    }
?>
