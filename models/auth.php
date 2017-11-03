<?php 
/**
* User Authenticating class
*/
class Auth 
{
	//public attributes to access class attributes using arrow operator
	public $id;
	public $name;
	public $password;
	public $flag;
	public $email;

	//class constructor
	public function __construct()
	{
		$args = func_get_args(); // read arguements in the constructor call
		$num = func_num_args();  // read number of arguements in the constructor call
		if(method_exists($this,$f = '__construct_' . $num)) {
			call_user_func_array(array($this,$f),$args); //calling the correct static function
		}
	}  

	function __construct_3($name, $password, $flag)
	{
		$this->name = $name;
		$this->password = $password;
		$this->flag = $flag;
	}

	function __construct_2($id, $email)
	{
		$this->email = $email;
		$this->id = $id;
	}
}
 ?>