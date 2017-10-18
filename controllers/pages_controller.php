<?php 

/**
	Default controller class
*/
require_once('controller.php');
	
class PagesController extends controller
{
	//returns the home page
	public function index() {
  		require_once('views/pages/home_view.php');
    }

    //returns the error page
    public function error($message) {
		require_once('views/pages/error_view.php');
    }
	
}

 ?>