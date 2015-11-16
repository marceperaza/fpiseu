<?php

/*
 * Nombre de la Institucion
 */
$fpiseu_config['universidad']='Universidad';

/*
 * Informacion de la Base de Datos
 */
$fpiseu_config['dbhost']='localhost';
$fpiseu_config['dbuser']='user';
$fpiseu_config['dbpass']='pass';
$fpiseu_config['dbname']='fpiseu';

/*
 * Directorio base para el sistema.
 * Ej.: Si la direccion es
 * http://localhost/fpiseu/
 * el directorio debe ser /fpiseu/
 *
 * NOTE: Siempre debe de llevar la ultima /
 */
$fpiseu_config['basedir']='/fpiseu/';

/*
 * Si se define los usuarios en este perfil
 * tendran acceso a todo el sistema.
 * Comentar para desactivarlo.
 */
$fpiseu_config['admin_group']='Administradores';

/*
 * Modulos Activos
 * El nombre edl modulo es el mismo que la carpeta.
 */
$fpiseu_config['modules']= array();

/*
 * Directorio temporal para almacenar reportes.
 * Por defector en un directorio en la raiz del sistema.
 * NOTE: El servidor debe tener acceso de escritura.
 */
$fpiseu_config['reportes_dir'] = __DIR__ . "/tmp/";

?>
