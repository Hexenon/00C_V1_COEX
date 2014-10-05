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
 * @package     COEX_api
 * @copyright   Copyright (c) 2014 TianguisFriki
 * @license     http://tianguisfriki.com/developer/License.html
 */

/**
 * Control Panel API v1
 *
 * @category    COEX
 * @package     COEX_api
 * @author      Enrique Benavides <Ben@ComidaExpres.com>
 */

//RewriteBase /clientes/coexapi/v1/
//goes to htacces to production server
//

include '../../application/config/config.php';
include '../../application/includes/dbConnector.php';
include 'includes/functions.php';

require 'Slim/Slim.php'; 

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->post('/register', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('name', 'email', 'password'));

            // reading post params
            $name = $app->request->post('name');
            $email = $app->request->post('email');
            $password = $app->request->post('password');
    		
    		// validating email address
            validateEmail($email);

            $newid = registerNewUser($name,$email,$password);

    		if (gettype($newid) == 'integer'){
    			$result = array('id'=>$newid, 
		    		'message'=>'You have been registered successfully',
		    		'error'=>false);
    		}else {
    			$result = array('message'=>'Oops, we couldnt create the user',
		    		'errno'=> intval(substr($newid, 0, 3)),
		    		'errmsg'=> substr($newid, 3),
		    		'error'=>true);
    		}

		    echo json_encode($result);
		});


$app->run();






