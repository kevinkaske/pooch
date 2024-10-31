<?php
function renderLayout(){
	global $controller, $action, $view_layout, $config, $application_data, $view_data, $query_string, $response_type;
	if($view_layout != null && $view_layout != 'none'){
		if($response_type == 'html'){
			if (file_exists(ROOT.'/views/layouts/'.$view_layout.'.php')) {
				include(ROOT.'/views/layouts/'.$view_layout.'.php');
			}
		}else{
			//json and xml don't use layouts
			renderView();
		}
	}else{
		//The renderView function is normally called from the layout file so we will just call it directly
		//since we are skipping the layout with this request.
		renderView();
	}
}

//render view
function renderView(){
	global $controller, $action, $config, $application_data, $view_data, $query_string, $response_type;
	if($response_type == 'html'){
		if (file_exists(ROOT.'/views/'.$controller.'/'.$action.'.php')) {
			include(ROOT.'/views/'.$controller.'/'.$action.'.php');
		}
	}else{
		if (file_exists(ROOT.'/views/'.$controller.'/'.$action.'.'.$response_type.'.php')) {
			include(ROOT.'/views/'.$controller.'/'.$action.'.'.$response_type.'.php');
		}
	}
}

function includePartial($partial_path){
	global $controller, $action, $config, $application_data, $view_data, $query_string;
	include(ROOT.'/views/'.$partial_path.'.php');
}

function getPath($path){
	global $config;

	//If the path needs a slash
	$slash = '';
	if(substr($path, 1) != '/' && $config['address'] != '/'){
		$slash = '/';
	}

	return $config['address'].$slash.$path;
}

function getAddress(){
	global $config;

	return $config['address'];
}

function getImage($imageName){
	global $config, $deploy_id;

	if($config['env'] == 'prod'){
		return $config['address'].'/assets/img/'.$imageName.'?'.$deploy_id;
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
