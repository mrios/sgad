<?php

class TipoDocumento {

    public function __contruct(){
            __construct();
        }

        //atributos
        var $id_tipo_documento;
        var $descripcion;

        //setters
        function setTipoDocumento($id_tipo_documento){
            $this->id_tipo_documento = $id_tipo_documento;
        }

        function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
        }

        //getters
        function getTipoDocumento(){
            return $this->id_tipo_documento;
        }

        function getDescripcion(){
            return $this->descripcion;
        }
}
?>
