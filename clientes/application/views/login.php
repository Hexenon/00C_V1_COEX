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
-->
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


