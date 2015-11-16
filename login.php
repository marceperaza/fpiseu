<?php

session_start();

if(isset($_POST['usuario']) && isset($_POST['clave']) && !empty($_POST['usuario']) && !empty($_POST['clave']))
{

  require_once __DIR__ . "/includes/inc_fpiseu.php";
  require_once 'inc_rights.php';

  $fpiseu_user = &$_SESSION['user'];
  $user = $_POST['usuario'];
  $pass = $_POST['clave'];

  $rights = fpiseu_rights($user, $pass);
  if($rights === _FPISEU_PERMISOS_NOACCESS_) {
    $fpiseu_user = array();
    $_SESSION['error'] = "No tiene Acceso a esta Pagina.";
  } else if($rights === _FPISEU_PERMISOS_INVALID_PASS_) {
    $fpiseu_user = array();
    $_SESSION['error'] = "Usuario o Contrase&ntilde;a Invalida.";
  } else {
    header("Location: main.php");
    exit(0);
  }
} else {
  $_SESSION['error'] = "Ingrese Usuario y Contrase&ntilde;a.";
}
header("Location: index.php");
?>
