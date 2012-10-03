<?php
if (!function_exists('parseDateToDB')) {

    /**
     *
     * @param <type> $date, es un String con formato de la GUI (Ej: 01/10/2010) que representa una fecha.
     * @return <type> devuelve un String apto para guardar en el la BD Mysql, Ej: 2010-10-01
     */

    function parseDateToDB($date) {
        
        if($date != "" && strlen($date)==10){
            $date = str_replace(array('/'), '-', $date);
            $array_date = explode('-', $date);
            $date = $array_date[2] . "-" . $array_date[0] . "-" . $array_date[1];
        }
        return $date;
    }

}

if (!function_exists('parseDateFromDB')) {

    /**
     *
     * @param <type> $date, es un String con formato de la BD (Ej: 2010-10-01) que representa una fecha.
     * @return <type> devuelve un String apto para mostrar en la GUI, Ej: 01/10/2010
     */

    function parseDateFromDB($date){

        if(is_object($date) && get_class($date)=="DateTime"){
            $date = $date->format('Y-m-d');
        }

        if(!empty($date)){
            $date = str_replace(array('-'), '/',$date);
            $array_date = explode('/',$date);
            $date = $array_date[2]."/".$array_date[1]."/".$array_date[0];
        }
        return $date;
    }

}
?>
