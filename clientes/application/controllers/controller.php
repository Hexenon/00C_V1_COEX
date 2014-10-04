
<?php
	include_once Coex::registry("models").'model.php';
	class Controller {
		/**
		 * Modelo
		 * @var [type]
		 */
		public $model;

		/**
		 *  Constructor
		 */
		public function __construct()
		    {
		        $this->model = new Model();
		    }
		/**
		 * Función para invocar el modelo de login
		 * @return view regresa la vista que se necesita
		 */
		public function invoke()
		{
			$reslt = $this->model->getlogin();     // it call the getlogin() function of model class and store the return value of this function into the reslt variable.
			if($reslt == 'login')
			{
				include Coex::registry("views").'afterlogin.php';
			}
			else
			{
				include Coex::registry("views").'login.php';
			}
		}
	}

