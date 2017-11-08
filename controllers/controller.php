<?php 
/**
* Controller class is the parent class
*/
class Controller 
{
	//public attributes to access class attributes using arrow operator
	public static $url;		//url
	public static $url_http;	//servername + url
	public static $glKey = '63ab1de025b1d36f8706c282257f93390b7d44bff70eea8e2a0f81b84d3714e3'; 	//global key defined for the application

	//redirects to a required url
	public static function route($path, $message){
		header('Location: '. $url.$path.'?message='.urlencode(base64_encode($message)));
    	die();
	}
	
}
 ?>