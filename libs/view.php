<?
function renderLayout(){
	global $controller, $action, $view_layout, $config, $application_data, $view_data, $query_string;
	if($view_layout != null && $view_layout != 'none'){
		require(ROOT.'/views/layouts/'.$view_layout.'.php');
	}else{
		//The renderView function is normally called from the layout file so we will just call it directly
		//since we are skipping the layout with this request.
		renderView();
	}
}

//render view
function renderView(){
	global $controller, $action, $config, $application_data, $view_data, $query_string;
	require(ROOT.'/views/'.$controller.'/'.$action.'.php');
}

function includePartial($partial_path){
	global $controller, $action, $config, $application_data, $view_data, $query_string;
	require(ROOT.'/views/'.$partial_path.'.php');
}

function getPath($path){
	global $config;
	
	return $config['address'].$path;
}

function getAddress(){
	global $config;
	
	return $config['address'];
}

function getImage($imageName){
	global $config;
	
	if($config['env'] == 'prod'){
		return $config['address'].'/assets/img/'.$imageName.'?'.$config['deploy_id'];
	}else{
		return $config['address'].'/assets/img/'.$imageName;
	}
}

function getValueIfExists($val){
	if(isset($val)){
		return $val;
	}else{
		return '';
	}
}
?>