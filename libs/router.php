<?php
function getResponseType() {
	global $query_string;

	$values = array();
	if(isset($_POST['response_type'])){
		if($_POST['response_type'] == 'html'){
			return 'html';
		}elseif($_POST['response_type'] == 'xml'){
			return 'xml';
		}elseif($_POST['response_type'] == 'json'){
			return 'json';
		}else{
			return 'html';
		}
	}elseif(isset($query_string['response_type'])){
		if($query_string['response_type'] == 'html'){
			return 'html';
		}elseif($query_string['response_type'] == 'xml'){
			return 'xml';
		}elseif($query_string['response_type'] == 'json'){
			return 'json';
		}else{
			return 'html';
		}
	}elseif(isset($_SERVER['HTTP_ACCEPT'])){
		try {
			$http_accept = $_SERVER['HTTP_ACCEPT'];
			if(!isset($http_accept)){
   			$http_accept = 'text/html';
			}

			$http_accept_array = explode(",", $http_accept);

			switch ($http_accept_array[0]) {
				case 'text/html':
					return 'html';
					break;
				case 'application/xml':
					return 'xml';
					break;
				case 'application/json':
					return 'json';
					break;
			}
		} catch (Exception $e) {
		    return 'html';
		}
	}else{
		return 'html';
	}
}

function catchCustomRoute(){
	global $config, $controller, $action;
	$return = false;
	if(isset($config['routes'])){
		foreach($config['routes'] as $routeArray) {
			//If the url ends in the custom path from the routes.php file
			$controller_indent_directory = '';

			if(isset($config['controller_indent'])
				&& $config['controller_indent']
				&& isset($config['controller_indent_directory'])
				&& $config['controller_indent_directory'] != ''){
				$controller_indent_directory = $config['controller_indent_directory'];
			}

			$custom_route = DIRECTORY_SEPARATOR . $controller_indent_directory . $routeArray[0];
			$custom_route = str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $custom_route); //Get rid of extra slash if there is no indent directory

			//get rid of query string to compare requested route to custom routes
			$requested_route = $_SERVER['REQUEST_URI'];
			if(strpos($requested_route, '?') === false){
				//Do nothing. This is not a query string url
			}else{
				$requested_route = stristr($requested_route, '?', true);
			}

	  	if($requested_route == $custom_route){
				$controller = $routeArray[1];
				$action = $routeArray[2];
				$return = true;
			}
		}
	}
	return $return;
}

function routeRequest(){
	global $config, $application, $controller, $action, $id, $query_string;
	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

	$urlArray = explode('/', $uri);
	//remove empty elemnts
	$urlArray = array_filter($urlArray);

	$a = count($urlArray);

	$controller = '';
	$action     = 'index';
	$id         = '';

	//setup root based on config
	$config['root'] = $config['root_controller'];
	if($config['root_action'] != 'index'){
		$config['root'] = $config['root'].DIRECTORY_SEPARATOR.$config['root_controller'];
	}

	$indent = 0;
	if(isset($config['controller_indent']) && $config['controller_indent'] == true){
		$indent = 1;
	}

	//Check if this is an exception from the routes.php file
	if(catchCustomRoute()){
		//Don't do anything here... Controller and Action set in catchCustomRoute()

	//Else if this does have a controller passed in the url
	}elseif(count($urlArray) > $indent++){
		$controller = $urlArray[$indent];
        
		//change dashes "-" to underscores "_"  since we use underscores for the file names and dashes in the
		$controller = str_replace("-", "_", $controller);

		if(count($urlArray) > $indent++){
			$action = $urlArray[$indent];
		}

		if(count($urlArray) > $indent++){
			$id = $urlArray[$indent];
		}
	}else{
		//Call the root controller and action
		$controller = $config['root_controller'];
		$action     = $config['root_action'];
	}

	require(ROOT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'application_controller.php');

	//special purpose routing (jobs)
	if($controller == 'jobs'){
		require(ROOT.DIRECTORY_SEPARATOR.'jobs'.DIRECTORY_SEPARATOR.$action.'.php');
		$controller_class_name = str_replace(" ", "", ucwords(str_replace("_", " ", $action))).'Job';

		$application = new $controller_class_name($controller, 'index');
		$application->index();
	//else fall back to regular route
	}else{
		if (file_exists(ROOT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controller.'_controller.php')) {
			include(ROOT.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controller.'_controller.php');
		}else{
			http_response_code(404);
			include(ROOT.$config['404_page']);
			die('');
		}
		$controller_class_name = str_replace(" ", "", ucwords(str_replace("_", " ", $controller))).'Controller';

		$avalible_functions = get_class_methods($controller_class_name);

		if(in_array($action, $avalible_functions)){
			$application = new $controller_class_name($controller, $action, $id);
			$application->$action();
		}else{
			http_response_code(404);
			include(ROOT.$config['404_page']);
			die('');
		}
	}
}
?>
