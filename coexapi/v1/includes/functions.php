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

class funcHandler{
    /**
     * Stores the DB Connector
     * @var mysqli
     */
    private $conn = null;
    /**
     * Stores the error messages to show at the end of function calls 
     * @var array
     */
    public $errors = array();
    /**
     * Stores Messages to show at end of function calls 
     * @var array
     */
    public $messages = array();

    /**
     * Returns if process is ok 
     * @var boolean
     */
    public $isProcessOk = false;

    /**
     * Constructor
     */
    public function __construct(){
        $dbConnector = new dbConnector;
        $mysqli = $dbConnector::getConnection();

        if (gettype($mysqli) == 'string'){
            array_push($this->errors,"101Imposible conectarse a la base de datos\n"+$mysqli);
            $this->isProcessOk = false;
        }

        $this->conn = $mysqli;
    }

    /**
     * Used to register a new Customer into our database
     * @param  string $name     the username provided
     * @param  string $email    the email provided
     * @param  string $password the user password
     * @return bool           returns if the user has been created.
     */
    public function registerNewUser($name,$email,$password){
        // First check if user already existed in db
        if (!$this->isUserExists($email)) {
            // Generate the salt key
            $salt = $this->generateSaltKey();

            // Generating API key
            $api_key = $this->generateApiKey();

            // hashing the password with sha512
            $password_hash = hash('sha512', $password . $salt);

            // Prepares the date for "created_at" field
            $created_at = date('Y-m-d');

            // insert query
            $stmt = $this->conn->prepare("INSERT INTO members(username, email, password, salt, api_key, created_at, status) values(?, ?, ?, ?, ?, ?, 1)");
            $stmt->bind_param("ssssss", $name, $email, $password_hash, $salt, $api_key, $created_at);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                array_push($this->messages,"User successfully registered");
                return true;
            } else {
                // Failed to create user
                array_push($this->errors,'201Failed to create the user');
                return false;
            }
        } else {
            // User with same email already existed in the db
            array_push($this->errors,'202User already in database');
            return false;
        }
    }


    /**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
    private function isUserExists($email) {
        $stmt = $this->conn->prepare("SELECT id from members WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    /**
     * Generating random Unique MD5 String for user Api key
     */
    private function generateApiKey() {
        return md5(uniqid(rand(), true));
    }

    /**
     * Generating random Unique MD5 String for user salt key
     */
    private function generateSaltKey() {
        return md5(uniqid(rand(), true));
    }

    /**
     * Fetching user by email
     * @param String $email User email id
     */
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT id, username, email, api_key, status, created_at FROM members WHERE email = ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            // $user = $stmt->get_result()->fetch_assoc();
            $stmt->bind_result($id, $name, $email, $api_key, $status, $created_at);
            $stmt->fetch();
            $user = array();
            $user["id"] = $id;
            $user["name"] = $name;
            $user["email"] = $email;
            $user["api_key"] = $api_key;
            $user["status"] = $status;
            $user["created_at"] = $created_at;
            $stmt->close();

            array_push($this->messages,$user);
            return true;
        } else {
            array_push($this->errors,'203User is not found');
            return false;
        }
    }

    /**
     * Fetching user api key
     * @param String $user_id user id primary key in user table
     */
    public function getApiKeyById($user_id) {
        $stmt = $this->conn->prepare("SELECT api_key FROM members WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            // $api_key = $stmt->get_result()->fetch_assoc();
            // TODO
            $stmt->bind_result($api_key);
            $stmt->close();
            return $api_key;
        } else {
            return NULL;
        }
    }

    /**
     * Fetching user id by api key
     * @param String $api_key user api key
     */
    public function getUserId($api_key) {
        $stmt = $this->conn->prepare("SELECT id FROM members WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        if ($stmt->execute()) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            // TODO
            // $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }

    /**
     * Validating user api key
     * If the api key is there in db, it is a valid key
     * @param String $api_key user api key
     * @return boolean
     */
    public function isValidApiKey($api_key) {
        $stmt = $this->conn->prepare("SELECT id from members WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }


    /**
     * Verifying required params posted or not
     * @param  array $required_fields array set of fields to be verified
     * @return none                  there is no return value. it stops the instance of the api 
     */
    public function verifyRequiredParams($required_fields) {
        $error = false;
        $error_fields = "";
        $request_params = array();
        $request_params = $_REQUEST;
        // Handling PUT request params
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $app = \Slim\Slim::getInstance();
            parse_str($app->request()->getBody(), $request_params);
        }
        foreach ($required_fields as $field) {
            if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
                $error = true;
                $error_fields .= $field . ', ';
            }
        }

        if ($error) {
            // Required field(s) are missing or empty
            // echo error json and stop the app
            $response = array();
            $app = \Slim\Slim::getInstance();
            $response["error"] = true;
            $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
            $this->echoRespnse(400, $response);
            $app->stop();
        }
    }

    /**
     * Function to validate an email
     * @param  string $email email provided
     * @return none        doesnt return any value, stops the instance on error and send a response 
     */
    public function validateEmail($email) {
        $app = \Slim\Slim::getInstance();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response["error"] = true;
            $response["message"] = 'Email address is not valid';
            $this->echoRespnse(400, $response);
            $app->stop();
        }
    }

    /**
     * Echoing json response to client
     * @param String $status_code Http response code
     * @param Int $response Json response
     */
    public function echoRespnse($status_code, $response) {
        $app = \Slim\Slim::getInstance();
        // Http response code
        $app->status($status_code);

        // setting response content type to json
        $app->contentType('application/json');

        echo json_encode($response);
    }
}