<?php

if( ! defined('_FPISEU_MODULO_')) { exit(); }

require_once 'inc_defines.php';

/*
 * Funcion de Debug.
 * Util para imprimir una variable al error_log del servidor.
 */
function fpiseu_debug($msg, $var = false) {
  $debug = '';
  if($var)  {
    ob_start();
    var_dump($var);
    $debug = ob_get_contents();
    ob_end_clean();
  }
  error_log($msg . $debug);
}

/*
 * Obtener todas las definiciones.
 */
function fpiseu_define_all($modules) {

  static $fpiseu_rights = array();

  if(empty($fpiseu_rights)) {
    $fpiseu_rights['fpiseu'] = array(
      "_FPISEU_PERMISOS_HOME_" => 'Pagina Principal.',
    );

    /*
    * Cargar las definiciones de cada mosdulo.
    */
    foreach($modules as $mod ) {
      if(file_exists( __DIR__ . "/../" . $mod . "/include/inc_define.php"))
        require_once __DIR__ . "/../" . $mod . "/include/inc_define.php";
    }
  }
  return $fpiseu_rights;
}

/*
 * Definir el valor de cada constante.
 */
function fpiseu_define_load($fpiseu_config) {

  $fpiseu_rights = fpiseu_define_all($fpiseu_config['modules']);

  /*
   * Genera un bit por cada definicion.
   * Ej.:
   * PERMISO_1 = 0001
   * PERMISO_2 = 0010
   * PERMISO_3 = 0100
   */
  foreach($fpiseu_rights as $mod ) {
    $i = 0;
    foreach($mod as $def => $name ) {
      define($def, 1<<$i++);
    }
  }

}

/*
 * Carga o busca las opciones de configuracion.
 */
function fpiseu_config($name = false) {

  static $fpiseu_config = array();

  /*
   * Carga la configuracion solo una vez.
   */
  if(empty($fpiseu_config)) {
    require_once __DIR__ . '/../config.default.php';
    require_once __DIR__ . '/../config.php';

    /*
     * Hay que asegurarse que el basedir tenga la ultima /.
     * Sino la tiene no funciona la etiqueta HTML en el explorador.
     */
    $fpiseu_config['basedir'] .= (substr($fpiseu_config['basedir'], -1) == '/' ? '' : '/');

    /*
     * Load the definitons.
     */
    fpiseu_define_load($fpiseu_config);

    /*
     * Cargar el menu por cada modulo.
     */
    foreach($fpiseu_config['modules'] as $mod ) {
      require_once __DIR__ . "/../$mod/include/inc_menu.php";
    }

    /*
     * Cargar configuraion especifica del modulo actual si existe.
     */
    if(file_exists( __DIR__ . "/../" . _FPISEU_MODULO_ . "/config.default.php"))
      require_once __DIR__ . "/../" . _FPISEU_MODULO_ . "/config.default.php";
    if(file_exists( __DIR__ . "/../" . _FPISEU_MODULO_ . "/config.php"))
      require_once __DIR__ . "/../" . _FPISEU_MODULO_ . "/config.php";
  }

  /*
   * Busca el valor de configuracion.
   */
  $rtn = $fpiseu_config;
  if($name) {
    $leves = explode('.', $name);
    foreach($leves as $l) {
      if(isset($rtn[$l])) {
        /* Asigna rtn a el siguiente nivel */
        $rtn = $rtn[$l];
      } else {
        $rtn = null;
        break;
      }
    }
  }
  return $rtn;
}

function fpiseu_user_session() {

  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }

  return (
    isset($_SESSION['user']) &&
    isset($_SESSION['user']['permisos'] ) &&
    isset($_SESSION['user']['permisos']['fpiseu'] ) &&
    $_SESSION['user']['permisos']['fpiseu'] !== _FPISEU_PERMISOS_NOACCESS_
    ? $_SESSION['user'] : false
  );
}

?>
