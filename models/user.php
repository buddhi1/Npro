<?php 
	/**
	* User model class
	*/
	class User 
	{
		//public attributes to access class attributes using arrow operator
		public $id;
		public $name;
		public $fname;
		public $lname;
		public $street1;
		public $street2;
		public $city;
		public $state;
		public $zip;
		public $password;
		public $gender;
		public $picture;
		public $created_at;

		//class constructor
		public function __construct($id, $name, $gender, $picture, $created_at)
		{
			$args = func_get_args(); // read arguements in the constructor call
			$num = func_num_args();  // read number of arguements in the constructor call
			if(method_exists($this,$f = '__construct_' . $num)) {
				call_user_func_array(array($this,$f),$args); //calling the correct static function
			}
		}  

		//for 5 arguements, class constructor
		public function __construct_5($id, $name, $gender, $picture, $created_at)
		{
			$this->id = $id;
			$this->name = $name;
			$this->gender = $gender;
			$this->picture = $picture;
			$this->created_at = $created_at;
		}  

		//for 10 arguements, class constructor
		public function __construct_10($id, $fname, $lname, $street1, $street2, $city, $state, $zip, $gender, $picture)
		{
			$this->id = $id;
			$this->fname = $fname;
			$this->lname = $lname;
			$this->street1 = $street1;
			$this->street2 = $street2;
			$this->city = $city;
			$this->state = $state;
			$this->zip = $zip;
			$this->gender = $gender;
			$this->picture = $picture;
		}  
	}
 ?>