<?php

/*
 * Nombre del modulo.
 */
define('_FPISEU_MODULO_', 'fpiseu');

/*
 * Includes de FPISEU
 */
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ );

/*
 * Siempre se necesita cargar la configuracion.
 */
require_once 'inc_config.php';

?>
