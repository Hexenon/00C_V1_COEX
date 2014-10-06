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
include '../../application/includes/functions.php';
include 'includes/handler.php';

if (!defined('API_CALL')){
	define('API_CALL',true);
}

require 'Slim/Slim.php'; 

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();



/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    
    $handler = new Handler();
    
    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        // get the api key
        $api_key = $headers['Authorization'];
        // validating api key
        if (!$handler->isValidApiKey($api_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["msg"] = "Access Denied. Invalid Api key";
            $handler->echoRespnse(401, $response);
            $app->stop();
        } else {
            global $user_id;
            // get user primary key id
            $user_id = $handler->getUserId($api_key);
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["msg"] = "Api key is misssing";
        $handler->echoRespnse(400, $response);
        $app->stop();
    }
}
/**
 * Adding Middle Layer to authenticate every request of any app
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticateApp(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    
    $handler = new Handler();
    
    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        // get the api key
        $api_key = $headers['Authorization'];
        // validating api key
        if (!$handler->isValidApiKeyApp($api_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["msg"] = "Access Denied. Invalid Api key";
            $handler->echoRespnse(401, $response);
            $app->stop();
        } else {
            global $appId;
            // get user primary key id
            $appId = $handler->getAppId($api_key);
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["msg"] = "Api key is misssing";
        $handler->echoRespnse(400, $response);
        $app->stop();
    }
}
/**
 * Create post method to register a new app. No authentication required
 *
 * @param name
 * @return json file with api_key 
 */
$app->post('/registerapp', 'authenticateApp', function() use ($app) {
			
			$handler = new Handler();

			if ($handler->isProcessOk){
				$result = array("msg"=>'Oops, we couldnt create the user',
						'info'=>array(
				    		'errno'=> intval(substr(end($handler->errors), 0, 3)),
				    		'errmsg'=> substr(end($handler->errors), 3)),
			    		'error'=>true);
			}else{

	            // check for required params
	            $handler->verifyRequiredParams(array('name'));

	            // reading post params
	            $name = $app->request->post('name');
	    		
	    		// execute the process to create a new app for this api
	            $success = $handler->registerNewApp($name);

	    		if ($success){
	    			$result = array("msg"=>end($handler->messages),
			    		'error'=>false);
	    		}else {
	    			$result = array("msg"=>'Oops, we couldnt create the app',
	    				'info'=>array(
				    		'errno'=> intval(substr(end($handler->errors), 0, 3)),
				    		'errmsg'=> substr(end($handler->errors), 3)),
			    		'error'=>true);
	    		}
	    	
	    	}
		    echo json_encode($result);
		});

/**
 * Create post method to register a new user. Requires App Authentication
 *
 * @param name,email,password 
 * @return json file with status 
 */
$app->post('/register', 'authenticateApp', function() use ($app) {
			
			$handler = new Handler();

			if ($handler->isProcessOk){
				$result = array("msg"=>'Oops, we couldnt create the user',
						'info'=>array(
				    		'errno'=> intval(substr(end($handler->errors), 0, 3)),
				    		'errmsg'=> substr(end($handler->errors), 3)),
			    		'error'=>true);
			}else{

	            // check for required params
	            $handler->verifyRequiredParams(array('name', 'email', 'password'));

	            // reading post params
	            $name = $app->request->post('name');
	            $email = $app->request->post('email');
	            $password = $app->request->post('password');
	    		
	    		// validating email address
	            $handler->validateEmail($email);

	            // executes the process to add new user 
	            $success = $handler->registerNewUser($name,$email,$password);

	    		if ($success){
	    			$result = array("msg"=>end($handler->messages),
			    		'error'=>false);
	    		}else {
	    			$result = array("msg"=>'Oops, we couldnt create the user',
	    				'info'=>array(
				    		'errno'=> intval(substr(end($handler->errors), 0, 3)),
				    		'errmsg'=> substr(end($handler->errors), 3)),
			    		'error'=>true);
	    		}
	    	
	    	}
		    echo json_encode($result);
		});


/**
 * this starts the login process (Requires an App authentication)
 */
$app->post('/login', 'authenticateApp', function() use ($app) {
			
			$handler = new Handler();

			if ($handler->isProcessOk){
				$result = array("msg"=>'Oops, we couldnt create the user',
						'info'=>array(
				    		'errno'=> intval(substr(end($handler->errors), 0, 3)),
				    		'errmsg'=> substr(end($handler->errors), 3)),
			    		'error'=>true);
			}else{

	          	// check for required params
	            $handler->verifyRequiredParams(array('email', 'password'));

	            // reading post params
	            $email = $app->request->post('email');
	            $password = $app->request->post('password');
	    		
	    		// validating email address
	            $handler->validateEmail($email);

	            // login process (same as website)
	            $loginResult = login($email,$password,$handler->getConnection());

	            if ($loginResult == "login"){
						$result = array("msg"=>'User logged successfully',
			    		'error'=>false);
	    		}else {
	    			$result = array("msg"=>'Oops, Login failed',
	    			    	'info'=>array(
			    				'errno'=> 203,
					    		'errmsg'=> $loginResult),
				    		'error'=>true);
	    		}
	    	
	    	}
		    echo json_encode($result);
		});

/**
 * This returns all user info (requires authorization by api key)
 */
$app->get('/userinfo/:email', 'authenticateApp', function($email) use ($app) {
			
			$handler = new Handler;

			if ($handler->isProcessOk){
				$result = array("msg"=>'Oops, we couldnt create the user',
						'info'=>array(
				    		'errno'=> intval(substr(end($handler->errors), 0, 3)),
				    		'errmsg'=> substr(end($handler->errors), 3)),
			    		'error'=>true);
			}else{

	            // validating email address
	            $handler->validateEmail($email);

	            // gets the user information
	            $success = $handler->getUserByEmail($email);

	    		if ($success){
	    			$result = array("msg"=>end($handler->messages),
			    		'error'=>false);
	    		}else {
	    			$result = array("msg"=>'Oops, we couldnt create the user',
	    				'info'=>array(
				    		'errno'=> intval(substr(end($handler->errors), 0, 3)),
				    		'errmsg'=> substr(end($handler->errors), 3)),
			    		'error'=>true);
	    		}
	    	
	    	}
		    echo json_encode($result);
		});


$app->run();






