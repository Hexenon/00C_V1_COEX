
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
 * @package     COEX_Model
 * @copyright   Copyright (c) 2014 TianguisFriki
 * @license     http://tianguisfriki.com/developer/License.html
 */

/**
 * DataBase controller
 *
 * @category    COEX
 * @package     COEX_Model
 * @author      Enrique Benavides <Ben@ComidaExpres.com>
 */

class Model {
	public function getlogin(){
		// here goes some hardcoded values to simulate the database
		if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
			
			if (empty($_REQUEST['username'])){
				return 'Must insert an username';
			}
			if (empty($_REQUEST['password'])){
				return 'Must insert an password';
			}


			$dbConnector = new dbConnector();

			$logged = login($_REQUEST['username'], $_REQUEST['password'], $dbConnector->getConnection());
			return $logged;
			
		}
	}
}

