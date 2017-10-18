<?php 
/**
* User Authenticating class
*/
class Auth 
{
	//public attributes to access class attributes using arrow operator
	public $name;
	public $password;
	public $flag;


	function __construct($name, $password, $flag)
	{
		$this->name = $name;
		$this->password = $password;
		$this->flag = $flag;
	}
}
 ?>