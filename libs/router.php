<?
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