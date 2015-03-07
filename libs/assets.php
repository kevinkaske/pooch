<?
function cssTags(){
	global $config, $css_files;
	$css_tags = '';
	
	if($config['env'] == 'prod'){
		$css_tags = '<link rel="stylesheet" type="text/css" href="'.$config['address'].'/assets/css/master'.DEPLOY_ID.'.css" media="screen">';
	}else{
		foreach($css_files as $css_file) {
			$css_tags = $css_tags.'<link rel="stylesheet" type="text/css" href="'.$config['address'].'/assets/css/'.$css_file.'.css" media="screen">'."\n";
		}
	}
	
	return $css_tags;
}

function jsTags(){
	global $config, $js_files;
	$js_tags = '';
	
	if($config['env'] == 'prod'){
		$js_tags = '<script type="text/javascript" src="'.$config['address'].'/assets/js/master'.DEPLOY_ID.'.js"></script>';
	}else{
		foreach($js_files as $js_file) {
			$js_tags = $js_tags.'<script type="text/javascript" src="'.$config['address'].'/assets/js/'.$js_file.'.js"></script>'."\n";
		}
	}
	
	return $js_tags;
}
?>