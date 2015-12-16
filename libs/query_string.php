<?
//Get query string because $_GET does not work with mod rewrite
//This code should be rewritten at some point... It's ugly
function getQueryString(){
	global $query_string;
	$query_string = array();
	$new_query_string = array();
	if(strpos($_SERVER['REQUEST_URI'], '?')){
		$query_string = explode('?', $_SERVER['REQUEST_URI']);

		if(strpos($query_string[1], '&')){
			$query_string = explode('&', $query_string[1]);
			foreach ($query_string as $value) {
				$value_array = explode('=', $value);
				$new_query_string[$value_array[0]] = $value_array[1];
			}
			$query_string = $new_query_string;
		}else{
			$value_array = explode('=', $query_string[1]);
			$new_query_string[$value_array[0]] = $value_array[1];
		}
	}

	$query_string = $new_query_string;
}

getQueryString();
?>
