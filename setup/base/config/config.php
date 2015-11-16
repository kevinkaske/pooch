<?
//---------------------------------------------
// Job Password (Change to secure your app)
//---------------------------------------------
$config['job_key'] = '123456789123456789123456789123456789';

//---------------------------------------------
// Timezone
//---------------------------------------------
date_default_timezone_set('America/Chicago');

//---------------------------------------------
// Money Format
//---------------------------------------------
setlocale(LC_ALL, "en_US.UTF-8");

//---------------------------------------------
// Error Reporting
//---------------------------------------------
error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
ini_set("html_errors", "1");
ini_set("docref_root", "http://www.php.net/");
ini_set("error_prepend_string", "<div style='color:red; font-family:verdana; border:1px solid red; padding:5px;'>");
ini_set("error_append_string", "</div>");


$config = Array();

//---------------------------------------------
// Root
//---------------------------------------------
$config['root_controller'] = 'welcome';
$config['root_action'] = 'index';

//---------------------------------------------
// Environment
//---------------------------------------------
$config['env'] = 'dev';

//---------------------------------------------
// Password Options
//---------------------------------------------
$config['password_options'] = ['cost' => 6];

//---------------------------------------------
// Production
//---------------------------------------------
if($config['env'] == 'prod'){
	$config['address'] = 'http://www.example.com';
	//Get deploy id into a constant
	include(ROOT.'/deploy_id.php');
}

//---------------------------------------------
// Development
//---------------------------------------------
if($config['env'] == 'dev'){
	$config['address'] = 'http://localhost/example';
	//Set controller_indent to true if this application is not
	//at the root of the server. Example: if the server address
	//is http://localhost you would set it to false. If the
	//address is something like http://localhost/example you
	//would set it to true.
	$config['controller_indent'] = false;
	$config['controller_indent_directory'] = 'example';
}

//---------------------------------------------
// Custom Application Specific Options
//---------------------------------------------


//---------------------------------------------
// Database
//---------------------------------------------
$config['db_host'] = 'localhost';
$config['db_username'] = 'root';
$config['db_password'] = '';
$config['db_database'] = 'database_name';
?>
