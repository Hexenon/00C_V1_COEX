
<?php

class Model {
	public function getlogin(){
		// here goes some hardcoded values to simulate the database
		if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
			$dbConnector = new dbConnector();
			
			$logged = login($_REQUEST['username'], $_REQUEST['password'], $dbConnector->getConnection());

			if($logged){
				return 'login';
			}
		    else{
				return 'invalid user';
			}
		}
	}
}

