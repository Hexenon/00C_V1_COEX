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



<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>

        <meta charset="utf-8">
        <title>comidaexpres.com Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
        <link rel="stylesheet" href="../clientes/application/public/css/reset.css">
        <link rel="stylesheet" href="../clientes/application/public/css/supersized.css">
        <link rel="stylesheet" href="../clientes/application/public/css/style.css">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>

    <body>

        <div class="page-container">
            <h1>Login</h1>
            <form action="" method="post">
                <input type="text" name="username" class="username" placeholder="Username">
                <input type="password" name="password" class="password" placeholder="Password">
                <button type="submit">Sign me in</button>
                <div class="error"><span>+</span></div>
            </form>
            <div class="connect">
                <p>Or connect with:</p>
                <p>
                    <a class="facebook" href=""></a>
                    <a class="twitter" href=""></a>
                </p>
            </div>
        </div>

        <!-- Javascript -->
        <script src="../clientes/application/public/js/jquery-1.8.2.min.js"></script>
        <script src="../clientes/application/public/js/supersized.3.2.7.min.js"></script>
        <script src="../clientes/application/public/js/supersized-init.js"></script>
        <script src="../clientes/application/public/js/scripts.js"></script>

    </body>

</html>

