
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
 * @package     COEX_Controller
 * @copyright   Copyright (c) 2014 TianguisFriki
 * @license     http://tianguisfriki.com/developer/License.html
 */

/**
 * DataBase controller
 *
 * @category    COEX
 * @package     COEX_Controller
 * @author      Enrique Benavides <Ben@ComidaExpres.com>
 */


	include_once Coex::registry("models").'model.php';
	class Controller {
		/**
		 * Modelo
		 * @var [type]
		 */
		public $model;

		/**
		 *  Constructor
		 */
		public function __construct()
	    {
	        $this->model = new Model();
	    }
		/**
		 * Función para invocar el modelo de login
		 * @return view regresa la vista que se necesita
		 */
		public function invoke()
		{
			$reslt = $this->model->getlogin();     // it call the getlogin() function of model class and store the return value of this function into the reslt variable.
			if($reslt == 'login')
			{
				include_once Coex::registry("views").'afterlogin.php';
			}
			else
			{
				include_once Coex::registry("views").'login.php';
			}
		}
	}

