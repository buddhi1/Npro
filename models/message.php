<?php 
/**
* Message model class
*/
class Message
{
	//public attributes to access class attributes using arrow operator
	public $id;
	public $text;
	public $seId;
	public $recId;
	public $created_at;
	
	//class constructor
	public function __construct($id, $text)
	{
		$args = func_get_args(); // read arguements in the constructor call
		$num = func_num_args();  // read number of arguements in the constructor call
		if(method_exists($this,$f = '__construct_' . $num)) {
			call_user_func_array(array($this,$f),$args); //calling the correct static function
		}
	}  

	//for 5 arguements, class constructor
	function __construct_5($id, $text, $seId, $recId, $created_at)	
	{
		$this->id = $id;
		$this->text = $text;
		$this->seId = $seId;
		$this->recId = $recId;
		$this->created_at = $created_at;
	}

	//for 2 arguements, class constructor
	function __construct_3($id, $text, $created_at)	
	{
		$this->id = $id;
		$this->text = $text;
		$this->created_at = $created_at;
	}

}
?>