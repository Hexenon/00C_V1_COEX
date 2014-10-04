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
 * @package     COEX_Core
 * @copyright   Copyright (c) 2014 TianguisFriki
 * @license     http://tianguisfriki.com/developer/License.html
 */

/**
 * DataBase controller
 *
 * @category    COEX
 * @package     COEX_Core
 * @author      Enrique Benavides <Ben@ComidaExpres.com>
 */
	

	final class Coex{
		public function __construct(){
			echo "HOLA";

			// Por problemas de recarga del login al hacer back button en el navegador
			//session_cache_limiter('private');
			//ini_set('memory_limit','24M');

			define('DS', DIRECTORY_SEPARATOR);
			define('PS', PATH_SEPARATOR);
			define('BP', dirname(dirname(__FILE__)));
			
			Coex::register('original_include_path', get_include_path());

		    /**
		     * Set include path
		     */
		    Coex::register('config', BP . DS .'application'. DS . 'config' . DS);
		    Coex::register('controllers', BP . DS .'application'. DS . 'controllers' . DS);
		    Coex::register('includes', BP . DS .'application'. DS . 'includes' . DS);
		    Coex::register('models', BP . DS .'application'. DS . 'models' . DS);
		    Coex::register('public', BP . DS .'application'. DS . 'public' . DS);
		    Coex::register('views', BP . DS .'application'. DS . 'views' . DS);
		    Coex::register('var', BP . DS .'application'. DS . 'var' . DS);

		    include_once Coex::registry("config").'config.php';
		    include_once Coex::registry("includes").'dbConnector.php';
		    
		    if (TEST_ENVIROMENT){
		    	error_reporting(E_ALL);
		    }

		    if (DO_LOG){
		    	Coex::register("log_file",Coex::registry("var") . LOG_FILE);
				
				$log = "-Init Coex-\n";
				file_put_contents(Coex::registry("log_file"), $log);
		    }

		    include_once Coex::registry("includes").'functions.php';
			include_once Coex::registry("controllers").'controller.php';
		}
		// array static : Manejo de variables en ejecución
		private static $_registry = array();

		public function invoke(){
			$controller = new Controller();
			$controller->invoke();
		}

		/**
	     * Registra una nueva variable
	     *
	     * @param string $key
	     * @param mixed $value
	     * @param bool $graceful
	     * @throws Coex_Exception
	     */
	    public static function register($key, $value, $graceful = false)
	    {
	        if (isset(self::$_registry[$key])) {
	            if ($graceful) {
	                return;
	            }
	            self::throwException('Coex registry key "'.$key.'" already exists');
	        }
	        self::$_registry[$key] = $value;
	    }

	    /**
	     * Borra el registro de una variable $key
	     *
	     * @param string $key
	     */
	    public static function unregister($key)
	    {
	        if (isset(self::$_registry[$key])) {
	            if (is_object(self::$_registry[$key]) && (method_exists(self::$_registry[$key], '__destruct'))) {
	                self::$_registry[$key]->__destruct();
	            }
	            unset(self::$_registry[$key]);
	        }
	    }

	    /**
	     * Retrieve a value from registry by a key
	     *
	     * @param string $key
	     * @return mixed
	     */
	    public static function registry($key)
	    {
	        if (isset(self::$_registry[$key])) {
	            return self::$_registry[$key];
	        }
	        return null;
	    }
	}
