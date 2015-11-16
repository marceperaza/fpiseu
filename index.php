<?php

require_once __DIR__ . "/include/inc_fpiseu.php";

$fpiseu_user = fpiseu_user_session();

if( $fpiseu_user ) {
  header("Location: main.php");
  exit();
}

?><!DOCTYPE html>
<html>
  <head>
    <title>Sistema de Expedientes Universitarios</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <base href="<?php echo fpiseu_config('basedir');?>">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet" />
  </head>
  <body>
    <div class="container">
      <?php if(isset($_SESSION['error'])) {?>
        <!-- TODO: Mejorar sistema de alerta -->
        <div class="alert" role="alert" style="display:none;" id="alert_msg">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
      <?php } ?>
      <form class="form-signin" method="POST" action="login.php">
        <img src="img/fpiseu.png" />
        <h1><?php echo fpiseu_config('universidad');?></h1>
        <label for="usuario" class="sr-only">Usuario</label>
        <input type="email" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required autofocus />
        <label for="clave" class="sr-only">Password</label>
        <input type="password" name="clave" id="clave" class="form-control" placeholder="Clave" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar</button>
      </form>
    </div>
  </body>
</html>
