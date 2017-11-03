<?php 
/**
* Controller class is the parent class
*/
class Controller 
{
	//public attributes to access class attributes using arrow operator
	public static $url;		//url
	public static $url_http;	//servername + url

	//redirects to a required url
	public static function route($path, $message){
		header('Location: '. $url.$path.'?message='.urlencode(base64_encode($message)));
    	die();
	}
	
}
 ?>