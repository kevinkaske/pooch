<?
//Application entry point
define('ROOT', dirname(__FILE__));

include(ROOT.'/lib/autoload.php');
include(ROOT.'/vendor/autoload.php');

if($config['env'] == 'dev'){
	include(ROOT.'/assets/css.php');
	include(ROOT.'/assets/js.php');
}

routeRequest();
?>