<?php 
//establishing db connection
require_once('lib/connection.php');

//checking for requested controller and action 
// if (isset($_REQUEST['controller']) && isset($_REQUEST['action'])) {
// 	$controller = $_REQUEST['controller'];
// 	$action = $_REQUEST['action'];
// }else{
// 	$controller = 'pages';
// 	$action = 'home';	
// }

//Read current URL
$url = $_SERVER['REQUEST_URI'];

//Split URL path
$path_info = explode('/', parse_url($url, PHP_URL_PATH));
$url = $path_info[1]; 
$url_http = $_SERVER['SERVER_NAME'].'/'.$url;

if (sizeof($path_info) <= 4 && sizeof($path_info) > 3) { //passed to requested action
	$controller = $path_info[2];
	$action = $path_info[3];
}elseif (sizeof($path_info) <= 3 && sizeof($path_info) > 2) {  //passed to default action
	if ($path_info[2] == '') {  //home page request
		$controller = 'pages';
	}else{
		$controller = $path_info[2];
	}
	$action = 'index';
}else{   //redirect to home page for illegal requests
	$controller = 'pages';
	$action = 'index';	
}

//checking the availability of the requested controller and action
require_once('lib/filter.php');

if (!isset($_SESSION)) {
	session_start();
}

//apply correct layout considering the session
if (count($_SESSION) >= 1) { //if one session available
	if ($_SESSION['type'] == 0) {
		require_once('views/layouts/admin_layout.php');
	} else {
		require_once('views/layouts/std_layout.php');
	}
} else {
	require_once('views/layouts/default_layout.php');
}
?>