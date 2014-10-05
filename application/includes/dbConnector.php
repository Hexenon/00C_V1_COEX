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
 * @package     COEX_Includes
 * @copyright   Copyright (c) 2014 TianguisFriki
 * @license     http://tianguisfriki.com/developer/License.html
 */

/**
 * DataBase controller
 *
 * @category    COEX
 * @package     COEX_Includes
 * @author      Enrique Benavides <Ben@ComidaExpres.com>
 */

	final class dbConnector{
		private static $conn;

		public function __construct(){
			self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
			/* check connection */
			if (mysqli_connect_errno()) {
			    self::$conn = "Connect failed: ".mysqli_connect_error();
			}
		}

		public static function getConnection(){
			return  self::$conn;
		} 
	}
	