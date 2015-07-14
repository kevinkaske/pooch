<?
function getResponseType() {
	$values = array();
	foreach (preg_split('/\s*,\s*/', $_SERVER['HTTP_ACCEPT']) as $qvalue) {
		@list($value, $q) = preg_split('/\s*;\s*q\s*=\s*/', $qvalue);
		$q = (is_null($q) || !is_numeric($q)) ? 1.0 : floatval($q);
		$values[(string)$q][] = $value;
	}
	krsort($values, SORT_NUMERIC);
	$value = array_shift(array_slice($values, 0, 1));

	switch ($value[0]) {
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
}

function routeRequest(){
	global $config, $application, $controller, $action, $query_string;
	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

	$urlArray = explode('/', $uri);
	//remove empty elemnts
	$urlArray = array_filter($urlArray);
	
	$a = count($urlArray);

	$controller = '';
	$action = 'index';
	
	//setup root based on config
	$config['root'] = $config['root_controller'];
	if($config['root_action'] != 'index'){
		$config['root'] = $config['root'].'/'.$config['root_controller'];
	}
	//if there are no controller and action defined in the url
	if(isset($config['controller_indent']) && $config['controller_indent'] == true){
		//If this does have a controller passed in the url
		if(count($urlArray) > 1){
			$controller = $urlArray[2];
			if(count($urlArray) > 2){
				$action = $urlArray[3];
			}
		}else{
			//Call the root controller and action
			$controller = $config['root_controller'];
			$action     = $config['root_action'];
		}
	}else{
		$controller = $urlArray[1];
		$action     = $urlArray[2];
	}

	require(ROOT.'/controllers/application_controller.php');
	
	//special purpose routing (jobs)
	if($controller == 'jobs'){
		require(ROOT.'/jobs/'.$action.'.php');
		$controller_class_name = str_replace(" ", "", ucwords(str_replace("_", " ", $action))).'Job';
		
		eval('$application = new '.$controller_class_name.'();');
		eval('$application->index();');
	//else fall back to regular route
	}else{
		require(ROOT.'/controllers/'.$controller.'_controller.php');
		$controller_class_name = str_replace(" ", "", ucwords(str_replace("_", " ", $controller))).'Controller';
		
		$avalible_functions = get_class_methods($controller_class_name);
	
		if(in_array($action, $avalible_functions)){
			eval('$application = new '.$controller_class_name.'("'.$controller.'","'.$action.'");');
			eval('$application->'.$action.'();');
		}else{
			die('404');
		}
	}
}
?>