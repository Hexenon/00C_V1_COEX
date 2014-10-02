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

/**
 * Reporte de errores
 */
error_reporting(E_ALL | E_STRICT);
@ini_set('memory_limit','256M');
/**
 * Compilation includes configuration file
 */
define('COEX_ROOT', getcwd());

$_config = COEX_ROOT . '/app/config/config.php';
if (file_exists($_config)) {
    include $_config;
}

$_coexFileName = COEX_ROOT . '/app/Coex.php';
$_maintenanceFile = 'maintenance.flag';

if (!file_exists($_coexFileName)) {
    if (is_dir('downloader')) {
        header("Location: downloader");
    } else {
        echo $_coexFileName." was not found";
    }
    exit;
}

if (file_exists($_maintenanceFile)) {
    include_once dirname(__FILE__) . '/errors/503.php';
    exit;
}

require_once $_coexFileName;

?>