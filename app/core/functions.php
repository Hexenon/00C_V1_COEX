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
 * Variable Configuration
 *
 * @category    COEX
 * @package     COEX_Core
 * @author      Enrique Benavides <Ben@ComidaExpres.com>
 */

	/**
     * Inicia una sesión segura....
     *
     */
	function sec_session_start() {
	    $session_name = 'sec_session_id';   // Inicia una sesión con un nombre custom.
	    $secure = SECURE;
	    // Previene que el JavaScript haga sesiones extras
	    $httponly = true;
	    // Forza la sesión a usar cookies solamente
	    if (ini_set('session.use_only_cookies', 1) === FALSE) {
	        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
	        exit();
	    }
	    // Obtiene los parametros de las cookies
	    $cookieParams = session_get_cookie_params();
	    session_set_cookie_params($cookieParams["lifetime"],
	        $cookieParams["path"], 
	        $cookieParams["domain"], 
	        $secure,
	        $httponly);
	    // Coloca el nuevo nombre de la sesión
	    session_name($session_name);
	    session_start();            // Inicia la sesión php
	    session_regenerate_id();    // Regenera la sesión y borra la antigua.
	}

	/**
     * Inicia sesión al servidor
     *
     * @param string $email
     * @param string $password
     * @param mysqli $mysqli
     */
	function login($email, $password, $mysqli) {
	    // Usando statements preparados, se evita la SQL Injection
	    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt 
	        FROM members
	       WHERE email = ?
	        LIMIT 1")) {

	        $stmt->bind_param('s', $email);  
	        $stmt->execute();    
	        $stmt->store_result();
	 
	        // Obtiene el resultado
	        $stmt->bind_result($user_id, $username, $db_password, $salt);
	        $stmt->fetch();
	 
	        // Hashea el password con sha512
	        $password = hash('sha512', $password . $salt);
	        if ($stmt->num_rows == 1) {
	            // Si el usuario existe, se verifica si está blockeado por muchos intentos fallidos
	 
	            if (checkbrute($user_id, $mysqli) == true) {
	                // La cuenta está blockeada
	                // TODO-> Enviar email para decir que su cuenta está blockeada...

	            	echo RESPONSE_LOCKED_ACCOUNT . '<br>' ;
	            	echo "Cuenta Blockeada... Enviar EMAIL...";

	                // TODO...
	                return false;
	            } else {
	                // Verifica si el password es correcto
	                if ($db_password == $password) {
	                    // El password es correcto
	                    // Obtiene el user-agent del usuario.
	                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
	                    // Proteccion XSS
	                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
	                    $_SESSION['user_id'] = $user_id;
	                    // XSS protection
	                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
	                                                                "", 
	                                                                $username);
	                    $_SESSION['username'] = $username;
	                    $_SESSION['login_string'] = hash('sha512', 
	                              $password . $user_browser);
	                    // Logeado exitosamente
	                    return true;
	                } else {
	                    // Password incorrecto
	                    
	                    echo RESPONSE_INCORRECT_PASSWORD . '<br>';

	                    $now = time();
	                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
	                                    VALUES ('$user_id', '$now')");
	                    return false;
	                }
	            }
	        } else {
	            // No user exists.
	            return false;
	        }
    	}
	}

	/**
     * Verifica ataques de fuerza bruta
     *
     * @param string $user_id
     * @param string $mysqli
     */
	function checkbrute($user_id, $mysqli) {	
		// Timestamp para la hora actual
	    $now = time();
	    $valid_attempts = $now - (2 * 60 * 60);
	 
	    if ($stmt = $mysqli->prepare("SELECT time 
	                             FROM login_attempts 
	                             WHERE user_id = ? 
	                            AND time > '$valid_attempts'")) {
	        $stmt->bind_param('i', $user_id);
	 
	        // Ejecuta la query preparada
	        $stmt->execute();
	        $stmt->store_result();
	 
	        // Si ha habido mas de 5 intentos fallidos
	        if ($stmt->num_rows > 5) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	}

	/**
     * Verifica si el usuario está loggeado
     *
     * @param string $mysqli
     */
	function login_check($mysqli) {
	    // Check if all session variables are set 
	    if (isset($_SESSION['user_id'], 
	                        $_SESSION['username'], 
	                        $_SESSION['login_string'])) {
	 
	        $user_id = $_SESSION['user_id'];
	        $login_string = $_SESSION['login_string'];
	        $username = $_SESSION['username'];
	 
	        // Get the user-agent string of the user.
	        $user_browser = $_SERVER['HTTP_USER_AGENT'];
	 
	        if ($stmt = $mysqli->prepare("SELECT password 
	                                      FROM members 
	                                      WHERE id = ? LIMIT 1")) {
	            // Bind "$user_id" to parameter. 
	            $stmt->bind_param('i', $user_id);
	            $stmt->execute();   // Execute the prepared query.
	            $stmt->store_result();
	 
	            if ($stmt->num_rows == 1) {
	                // If the user exists get variables from result.
	                $stmt->bind_result($password);
	                $stmt->fetch();
	                $login_check = hash('sha512', $password . $user_browser);
	 
	                if ($login_check == $login_string) {
	                    // Logged In!!!! 
	                    return true;
	                } else {
	                    // Not logged in 
	                    return false;
	                }
	            } else {
	                // Not logged in 
	                return false;
	            }
	        } else {
	            // Not logged in 
	            return false;
	        }
	    } else {
	        // Not logged in 
	        return false;
	    }
	}

	/**
     * Sanitiza el resultado de la funcion PHP _SELF   (_SERVER)
     *
     * @param string $mysqli
     */
	function esc_url($url) {
 
	    if ('' == $url) {
	        return $url;
	    }
	 
	    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
	 
	    $strip = array('%0d', '%0a', '%0D', '%0A');
	    $url = (string) $url;
	 
	    $count = 1;
	    while ($count) {
	        $url = str_replace($strip, '', $url, $count);
	    }
	 
	    $url = str_replace(';//', '://', $url);
	 
	    $url = htmlentities($url);
	 
	    $url = str_replace('&amp;', '&#038;', $url);
	    $url = str_replace("'", '&#039;', $url);
	 
	    if ($url[0] !== '/') {
	        return '';
	    } else {
	        return $url;
	    }
	}
?>