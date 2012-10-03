<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	function unique($value, $params) {
            
		$CI =& get_instance();

		$CI->form_validation->set_message('unique',
			'El valor ingresado para el campo <b> %s </b> actualmente ya está en uso. Por favor ingrese otro valor para este campo.');

		list($model, $field) = explode(".", $params, 2);

		$find = "findOneBy".$field;
                /*
                TODO implementar con repositories
		if (Doctrine::getTable($model)->$find($value)) {
			return false;
		} else {
			return true;
		}
                 *
                 */
                return true;

	}
        function alpha_numeric_space($str) //permite que el campo alfanumérico tenga espacios
	{
		return ( ! preg_match("/^([a-z0-9 ])+$/i", $str)) ? FALSE : TRUE;
	}

        function codigo_rnos($str) 

	{
            $CI =& get_instance();

            $CI->form_validation->set_message('codigo_rnos',
			'El campo <b> %s </b> es incorrecto. El formato debe ser XX-XXXXXX.');
		return ( ! preg_match("/^([a-z0-9 ]){2}(-)([a-z0-9 ]){6}$/i", $str)) ? FALSE : TRUE;
	}

        function option_selected($str)

        {           
            if ($str == 0)
            {
                $CI =& get_instance();

                $CI->form_validation->set_message('option_selected',
                            'El campo <b> %s </b> está vacío. Seleccione una opción.');
                    return FALSE;
            }
                    return TRUE;
        }

        function birth_date($date)

        {
            if ($date > date('d/m/Y'))
            {
                $CI =& get_instance();

                $CI->form_validation->set_message('birth_date',
                            'El campo <b> %s </b> es incorrecto. La Fecha de Nacimiento no puede ser posterior a la fecha actual.');
                    return FALSE;
            }
                    return TRUE;
        }

        function valid_date($date)
        {
            $month=substr($date,3,2);
            $day=substr($date,0,2);
            $year=substr($date,6,4);
            if(checkdate($month, $day, $year)==false){
            $CI =& get_instance();
            $CI->form_validation->set_message('valid_date',
                            'El campo <b> %s </b> es incorrecto. La <b> %s </b> no es correcta.');
            return FALSE;
        }
        return TRUE;

        }
    }
