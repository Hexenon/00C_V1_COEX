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
 * DataBase controller
 *
 * @category    COEX
 * @package     COEX_Control_Panel
 * @author      Enrique Benavides <Ben@ComidaExpres.com>
 */

	class dbConnector
	{	

		/**
		*
		*	Set the Connection to DataBase
		*
		*/
		public static function getConnection()
		{
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
			return $mysqli;
		}

		/**
	     * Hace un query a la base de datos
	     *
	     * @param string $sqlStmt
	     */
		public static function doQuery($sqlStmt){
			$_connection = self::getConnection();


		}
	}
?>