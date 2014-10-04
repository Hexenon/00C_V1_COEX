<!--
/**
 * ComidaExpres.com
 *
 * Licencia
 *
 * Este código se ha escrito bajo Licencia de uso comercial por
 * ComidaExpres.com bajo condiciones de trabajo en MVC, con el 
 * futuro uso de API's controladoras para inserciones, borrados, 
 * actualizados y consultas a la base de datos.
 *
 * No edite o agregue código a éste módulo ya que será actualizado
 * por versiones en un futuro.
 * Si se requiere alguna modificación, contacte al equipo de desarrollo
 * de ComidaExpres.com en: http://comidaexpres.com/developer/support
 * @category    COEX
 * @package     COEX_Views
 * @copyright   Copyright (c) 2014 TianguisFriki
 * @license     http://tianguisfriki.com/developer/License.html
 */

/**
 * DataBase controller
 *
 * @category    COEX
 * @package     COEX_Views
 * @author      Enrique Benavides <Ben@ComidaExpres.com>
 */

<html>
<head></head>
<body>

	<?php
		sec_session_start();
		echo $reslt;
	?>

	<form action='' method='POST'>
	<p>
	<label>Username</label>
	<input id='username' value='' name='username' type='text' required='required' /><br>
	</p>
	<p>
	<label>Password</label>
	<input id='password' name='password' type='password' required='required' />
	</p>
	  <br />
	<p>
	   <button type='submit' name='submit'><span>Login</span></button> <button type='reset'><span>Cancel</span></button>
	</p>
	</form>
</body>
</html>
-->



<!DOCTYPE HTML>
<html>
<head>
<title>ComidaExpres.com Login a Clientes</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<link href="../clientes/application/public/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!--script-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
</head>
<body>
<?php
	sec_session_start();
	echo $reslt;
?>
<div class="login">
<!--start-loginform-->
		<form name="login-form" class="login-form" action="" method="post">
			<span class="header-top"><img src="../clientes/application/public/images/topimg.png"/></span>
		    <div class="header">
		    <h1>ComidaExpres.com</h1>
		   	<span>Inicia Sesión</span>
		    </div>
		    <div class="content">
			<input type="email" name='username' class="input username" placeholder="Email" required >
		    <input type="password"  name='password' class="input password" placeholder="Contraseña" required>
		    </div>
		    <div class="login_button">
		    <input type="submit" name="submit" value="Login" class="button" />
		    </div>
		</form>
<!--end login form-->
<!--side-icons-->
    <div class="user-icon"> </div>
    <div class="pass-icon"> </div>
    <!--END side-icons-->
    <!--Side-icons-->
	<script type="text/javascript">
	$(document).ready(function() {
		$(".username").focus(function() {
			$(".user-icon").css("left","-69px");
		});
		$(".username").blur(function() {
			$(".user-icon").css("left","0px");
		});
		
		$(".password").focus(function() {
			$(".pass-icon").css("left","-69px");
		});
		$(".password").blur(function() {
			$(".pass-icon").css("left","0px");
		});
	});
	</script>
	<p class="copy_right">&#169; 2014 ComidaExpres.com<a href="#" target="_blank">&nbsp; Servicio a Clientes</a> </p>

</div>
</body>
</html>