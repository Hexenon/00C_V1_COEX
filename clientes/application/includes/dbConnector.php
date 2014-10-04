<?php
	
	final class dbConnector{
		private static $conn;

		public function __construct(){
			self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
			/* check connection */
			if (mysqli_connect_errno()) {
			    printf("Connect failed: %s\n", mysqli_connect_error());
			    if (DO_LOG){

					$log = file_get_contents(Coex::registry("log_file"));
					// Añade una nueva persona al fichero
					$log .= "Connect failed: ".mysqli_connect_error() . "\n";
					// Escribe el contenido al fichero
					file_put_contents(Coex::registry("log_file"), $log);
			    }
			    exit();
			}
		}

		public static function getConnection(){
			if (DO_LOG){
				$log = file_get_contents(Coex::registry("log_file"));
				// Añade una nueva persona al fichero
				$log .= "Retrieve $conn \n";
				// Escribe el contenido al fichero
				file_put_contents(Coex::registry("log_file"), $log);
		    }
			return  self::$conn;
		} 
	}
	