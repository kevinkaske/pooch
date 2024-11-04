<?php
//Global version of data to use in "view"
$view_data = null;
$view_layout = null;
$controller = null;
$response_type = null;
$action = null;

Class Controller {
	public $config;
	public $db;
	public $layout;
	public $controller;
	public $action;
	public $query_string;
	public $application_data;
	public $response_type;
	public $values;
	private $redirecting = false;

	public function __construct($controller='', $action=''){
		global $config, $application_data, $query_string, $response_type;

		$application_data = array();

		//Get query string in case they need to be read in controller
		$this->query_string = $query_string;

		//Set the type of response
		$this->response_type = getResponseType();
		$response_type = $this->response_type;

		//Set content type header for non-HTML responses
		if($this->response_type == 'json'){
			header('Content-Type: application/json');
		}elseif($this->response_type == 'xml'){
			header('Content-Type: text/xml');
		}

		//Get config options in case they need to be read in controller
		$this->config = $config;

		//Set what controller and action this is
		$this->controller = $controller;
		$this->action = $action;

		//validate job key
		if($controller == 'jobs'){
			validateJobKey();
		}

		//Create DB connection
		$db = new MysqliDb ($this->config['db_host'], $this->config['db_username'], $this->config['db_password'], $this->config['db_database']);
		$this->db = $db;

		$this->values = array();

		$this->layout = 'application';
	}

	public function __destruct(){
		$this->render();
	}

	public function validateJobKey(){
		if($this->config['env'] == 'prod'){
			if(!isset($_GET['key']) || $_GET['key'] != $this->config['job_key']){
				die('Error: Job Key is incorrect');
			}
		}
	}

	private function render(){
		global $view_data, $view_layout, $controller, $action;

		$view_data = $this->values;
		$view_layout = $this->layout;
		$controller = $this->controller;
		$action = $this->action;

		renderLayout();
		//Get rid of any flash messages
		if($this->redirecting != true){
			unsetFlash();
		}
	}

	public function redirect($url){
		global $config;

		$this->redirecting = true;
		if(!substr($url, 0, 4) == "http") {
			$url = $config['address'].$url;
		}
		header('Location: '.$url);
		die();
	}

	public function addToApplicationData($key, $value){
		global $application_data;

		$application_data[$key] = $value;

		$this->application_data = $application_data;
	}

	//Used to send message to built in PHP server. Used for development.
	public function sendMessageToConsole($object_to_debug){
		ob_start();
		var_dump($object_to_debug);
		error_log(ob_get_clean(), 4);
	}
}
?>
