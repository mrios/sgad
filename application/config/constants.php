<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */

define('ASEGURADOS',        
        'SELECT ase.*, est.descripcion, est.id_estado, ase.nombre, ase.apellido
         FROM asegurados as ase
         LEFT JOIN estados_asegurados as ea ON ase.documento = ea.documento
         LEFT JOIN estados as est ON est.id_estado = ea.id_estado '
);

define('ASEGURADOS_NC',
        'SELECT ase.documento, CONCAT(ase.apellido, ",", ase.nombre) as nombre_completo
         FROM asegurados as ase
         LEFT JOIN estados_asegurados as ea ON ase.documento = ea.documento
         LEFT JOIN estados as est ON est.id_estado = ea.id_estado '
);

define('EQUIPOS', 
        'SELECT equ.*, equ.nombre as nombre, ase2.apellido as apellido, ase2.apellido as apellido1
         FROM equipos as equ
         LEFT JOIN asegurados as ase ON ase.documento = equ.id_entrenador 
         LEFT JOIN asegurados as ase2 ON ase2.documento = equ.id_delegado'
);

define('TORNEOS', 
        'SELECT tor.*,act.descripcion,act.id_actividad
         FROM torneos as tor
        LEFT JOIN actividades as act ON tor.id_actividad = act.id_actividad'
);

define('EQUIPOS_POR_TORNEO',
        'SELECT ept.*
         FROM equipos_por_torneo as ept'
);

//define('DELEGADOS',
//        'SELECT eq.*,eq.id_delegado,ase.nombre as nombre_delegado,ase.apellido as apellido_delegado
//         FROM equipos as eq
//         LEFT JOIN  asegurados as ase ON eq.id_delegado = ase.documento'
//);

define('ASEGURADOS1',
        'SELECT ase1.*,ase1.documento,ase1.nombre,ase1.apellido
         FROM asegurados as ase1'
);



define('EQUIPOS_SOLOS',
        'SELECT eqs.*
         FROM equipos as eqs'
);



define('POLIZAS', 
        'SELECT pol.* 
         FROM polizas as pol'
);

define('ESPECIALIDADES', 
        'SELECT esp.* 
         FROM especialidades as esp'
);

define('TIPOS_DOCUMENTO', 
        'SELECT tip.* 
         FROM tipo_documento as tip '
);

define('USUARIOS', 
        'SELECT * 
         FROM usuarios'
);

define('ACTIVIDADES', 
        'SELECT act.*
         FROM actividades as act '
);

define('ESTADOS', 
        'SELECT est.* 
         FROM estados as est'
);
define('ACCIDENTES',
        'SELECT acc.*,ase.nombre,ase.apellido
         FROM accidentes as acc LEFT JOIN asegurados as ase ON acc.documento=ase.documento'
);
