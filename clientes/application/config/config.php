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
 * @package     COEX_Config
 * @copyright   Copyright (c) 2014 TianguisFriki
 * @license     http://tianguisfriki.com/developer/License.html
 */

/**
 * DataBase controller
 *
 * @category    COEX
 * @package     COEX_Config
 * @author      Enrique Benavides <Ben@ComidaExpres.com>
 */

/**
 * Variables globales para la base de datos
 */
define('DB_HOST','209.17.116.155');//'209.17.116.155' IP del servidor mysql
define('DB_DATABASE','login_hexus');
define('DB_USER','login_user');
define('DB_PASSWORD','eKcGZr59zAa2BEWU');

/**
 *  Variable para identificar si es un test de desarrollo 
 */
define('TEST_ENVIROMENT',false);
define('SECURE', true);
define('LOG_FILE', 'system.log');
define('DO_LOG', false);