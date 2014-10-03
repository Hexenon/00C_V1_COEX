<?php
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
 * @package     COEX_Control_Panel
 * @copyright   Copyright (c) 2014 TianguisFriki
 * @license     http://tianguisfriki.com/developer/License.html
 */

/**
 * Variable Configuration
 *
 * @category    COEX
 * @package     COEX_Control_Panel
 * @author      Enrique Benavides <Ben@ComidaExpres.com>
 */

	/*
	--------------------------------------
	* Variables para la base de datos..
	--------------------------------------
	*/
	define("DB_HOST", "209.17.116.155");
	define("DB_USER", "login_user");
	define("DB_PASSWORD", "eKcGZr59zAa2BEWU");
	define("DB_DATABASE", "login_hexus");
	
	// isolated variable
	define("SECURE", FALSE); // Solo para testing.
	define("BASE_URL", "http://localhost/clientes/"); // Importante...
	/*
	-------------------------------------
	* Variables para envío de emails
	-------------------------------------
	*/
	define("EMAIL_HOST", "localhost");
	define("EMAIL_USER", "no.reply@comidaexpres.com");
	define("EMAIL_PASSWORD", "berktown11");
	define("EMAIL_PORT", 25);
	define("EMAIL_SECURE",false);
	define("EMAIL_ENCRYP", "ssl");
	define("EMAIL_HTML", true); 
	define("EMAIL_RESPONSE", "no.reply@comidaexpres.com");

	/*
	-------------------------------------
	* Variables de respuestas del login
	-------------------------------------
	*/
	define("RESPONSE_INCORRECT_PASSWORD", "Oops, El usuario y/o contraseña son incorrectos!");
	define("RESPONSE_LOCKED_ACCOUNT", "Oops, Su cuenta ha sido bloqueada por muchos intentos fallidos!");
	define("RESPONSE_RESET_PASSWORD_EMAIL_OK", "Se ha enviado un email con un link para restablecer su contraseña");
	define("RESPONSE_RESET_PASSWORD_EMAIL_FAIL", "Ha ocurrido un error al tratar de enviarle el email, contacte a servicio a clientes");
	define("RESPONSE_WELCOME_MSG", "Ha iniciado sesión");

	/*
	-------------------------------------
	* Variables del bloque del panel de control
	-------------------------------------
	*/
	define("CONTROL_PANEL_WELCOME_MSG", "Bienvenido al panel de control de sus pedidos");
	define("CONTROL_PANEL_PENDING_COUNTER", "Pedidos pendientes");
	define("CONTROL_PANEL_SENT_COUNTER", "Pedidos enviados");
	define("CONTROL_PANEL_CUSTOMER_EMAIL_OK", "Ha enviado una notificación a su cliente");
	define("CONTROL_PANEL_CUSTOMER_EMAIL_FAIL", "Oops, Ha ocurrido un error al tratar de enviar la notificación");
	define("CONTROL_PANEL_CHAT_ONLINE", "Preguntenos en linea");
	define("CONTROL_PANEL_CHAT_OFFLINE", "Deje una pregunta");

?>