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

	define('DS', DIRECTORY_SEPARATOR);
	define('PS', PATH_SEPARATOR);
	define('BP', dirname(dirname(__FILE__)));
	
	Coex::register('original_include_path', get_include_path());

    /**
     * Set include path
     */
    $paths[] = BP . DS . 'app' . DS . 'config';
    $paths[] = BP . DS . 'app' . DS . 'controllers';
    $paths[] = BP . DS . 'app' . DS . 'core';
    $paths[] = BP . DS . 'app' . DS . 'models';
    $paths[] = BP . DS . 'app' . DS . 'views';
    $paths[] = BP . DS . 'css';
    $paths[] = BP . DS . 'js';

    $appPath = implode(PS, $paths);
    set_include_path($appPath . PS . Coex::registry('original_include_path'));

    require_once 'config.php';
    require_once 'dbConnector.php';
    require_once 'functions.php';
    
    if (login_check(login_check(dbConnector::getConnection()) == true){
    	Coex::loadControlPanel();
    }else{
    	Coex::loadLoginPage();
    }

	final class Coex{
		// array static : Manejo de variables en ejecución
		private static $_registry = array();



		/**
	     * Carga la página de login
	     *
	     */
		public static function loadLoginPage(){
			require_once 'login.php';
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
?>