<?
//Get query string because $_GET does not work with mod rewrite
//This code should be rewritten at some point... It's ugly
//
//Multiple identical keys cannot be passed into pooch. This is a Limitation of this implimentation.
//Example: Give the query string "id=2&id=3" the value of $query_string['id'] would be 3.
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
				$new_query_string[urldecode($value_array[0])] = urldecode($value_array[1]);
			}
			$query_string = $new_query_string;
		}else{
			$value_array = explode('=', $query_string[1]);
			$new_query_string[urldecode($value_array[0])] = urldecode($value_array[1]);
		}
	}

	$query_string = $new_query_string;
}

getQueryString();
?>
