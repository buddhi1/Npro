<?php 

//selecting required controller and action. A message is being passed
function call($controller, $action, $message, $url){
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
	}
	//assign url 
	$controller::$url = $url;
	//calling required action
	$controller->{ $action }($message);
}

//checking the availability of the requested controller and action
require_once('lib/filter.php');

if (array_key_exists($controller, $controllers)) { //checking the availability of the controller
    if (in_array($action, $controllers[$controller])) { //cheking the availability of the action

      	call($controller, $action, '', $url);
    } else {
      	call('pages', 'error', 'Sorry!!! Action is not defined', $url);
    }
  } else {
    	call('pages', 'error', 'Sorry!!! There is no such Controller', $url);
  }

 ?>