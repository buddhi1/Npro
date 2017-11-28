<?php 

//selecting required controller and action. A message is being passed
function call($controller, $action, $message, $url, $url_http){
	//calling required controller 
	require_once('controllers/'.$controller.'_controller.php');
	switch ($controller) {
		//creating a new instance, if the controller is default
		case 'pages':
			$controller = new PagesController();
			break;
		case 'users':
	        // model is to query in the controller
	        require_once('models/user.php');
	        $controller = new UsersController();
      	break;
      	case 'auth':
	        // model is to query in the controller
	        require_once('models/auth.php');
	        $controller = new AuthController();
      	break;
      	case 'msg':
	        // model is to query in the controller
	        require_once('models/message.php');
	        $controller = new MessagesController();
      	break;
      	case 'keywords':
	        // model is to query in the controller
	        require_once('models/keyword.php');
	        $controller = new KeywordsController();
      	break;
	}
	//assign url 
	$controller::$url = $url;
	//assign server name + url 
	$controller::$url_http = $url_http;
	//calling required action
	$controller->{ $action }($message);
}

//checking the availability of the requested controller and action
require_once('lib/filter.php');

if (!isset($_SESSION)) {
	session_start();
}


//apply correct filter considering the session
if (count($_SESSION) >= 1) { //if one session available
	if ($_SESSION['type'] == 0) {
		$arr = $controllers_ad;
	} else {
		$arr = $controllers_st;
	}
} else {
	$arr = $controllers;
}

if (array_key_exists($controller, $arr)) { //checking the availability of the controller
    if (in_array($action, $arr[$controller])) { //cheking the availability of the action

      	call($controller, $action, '', $url, $url_http);
    } else {
      	call('pages', 'error', 'Sorry!!! Action is not defined', $url, $url_http);
    }
  } else {
    	call('pages', 'error', 'Sorry!!! There is no such Controller', $url, $url_http);
  }

 ?>