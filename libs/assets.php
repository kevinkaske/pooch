<?
function cssTags(){
	global $config, $css_files, $css_md5;
	$css_tags = '';

	if($config['env'] == 'prod'){
		$css_tags = '<link rel="stylesheet" type="text/css" href="'.$config['address'].'/assets/css/master'.$deploy_id.'.css" media="screen">';
	}else{
		foreach($css_files as $css_file) {
			$css_tags = $css_tags.'<link rel="stylesheet" type="text/css" href="'.$config['address'].'/assets/css/'.$css_file.'.css" media="screen">'."\n";
		}
	}

	return $css_tags;
}

function cssTagsForDeploy(){
	global $config, $css_files;
	foreach($css_files as $css_file) {
		$css_tags = $css_tags.$css_file.'.css ';
	}
	echo $css_tags;
}

function jsTags(){
	global $config, $js_files, $css_md5;
	$js_tags = '';

	if($config['env'] == 'prod'){
		$js_tags = '<script type="text/javascript" src="'.$config['address'].'/assets/js/master'.$deploy_id.'.js"></script>';
	}else{
		foreach($js_files as $js_file) {
			$js_tags = $js_tags.'<script type="text/javascript" src="'.$config['address'].'/assets/js/'.$js_file.'.js"></script>'."\n";
		}
	}

	return $js_tags;
}

function jsTagsForDeploy(){
	global $config, $js_files;
	foreach($js_files as $js_file) {
		$js_tags = $js_tags.$js_file.'.js ';
	}
	echo $js_tags;
}
?>
