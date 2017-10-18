<?php 
	/**
	* User model class
	*/
	class User 
	{
		//public attributes to access class attributes using arrow operator
		public $id;
		public $name;
		public $password;
		public $type;
		public $active;

		//class constructor
		public function __construct($id, $name, $type, $active)
		{
			$this->id = $id;
			$this->name = $name;
			$this->type = $type;
			$this->active = $active;
		}

		//retruns the list of all class data form database
		//get request
		public static function all() {
	      $list = [];
	      $db = db::getConnection();
	      $req = $db->query('SELECT * FROM users');

	      // creating a list of objects from the database results
	      foreach($req->fetchAll() as $obj) {
	        $list[] = new User($obj['id'], $obj['name'], $obj['type'], $obj['active']);
	      }

	      return $list;
	    }

	    //returns the details of the requested id
	    //get request
	    public static function find($id) {
	      $db = db::getConnection();
	      //make sure $id is an integer
	      $id = intval($id);
	      $req = $db->prepare('SELECT * FROM users WHERE id = :id');
	      $req->execute(array('id' => $id)); //parameter value passing
	      $obj = $req->fetch();

	      return new User($obj['id'], $obj['name'], $obj['type'], $obj['active']);
	    }

	    //creates an instance and save it to the db
	    //post request
	    public static function create() {
	    	//reading values into parameters 
	    	$name = $_POST['name'];
	    	$password = trim($_POST['password']);
	    	$type = $_POST['type'];

	    	//validating required fields
	    	if ($name != '' && $password != '') {
	    		//checking if the username already exists
	    		$db = db::getConnection();
		    	$req = $db->prepare('SELECT * FROM users WHERE name = :name');
		      	$req->execute(array('name' => $name)); //parameter value passing
		      	$obj_ex = $req->fetch();

		      	if (!$obj_ex) {
		      		$db = db::getConnection();
		    		$req = $db->prepare('INSERT INTO users (name, password, type, active) VALUES (:name, :password, :type, :active)');
		    		$req->execute(array('name' => $name, 'password' => md5($password), 'type' => $type, 'active' => 0));

		    		echo "New user has been created successfully";
		      	}else{
		      		echo "User name exists. Please select different user name";
		      	}
	    		
	    	}else {
	    		echo "Fill all the required fields";
	    	}
	    }

	    //edit existing user
	    //get request
	    public static function edit($id) {
	    	//checking if the id exists
	    	$req = $db->prepare('SELECT * FROM users WHERE id = :id');
	      	$req->execute(array('id' => $id)); //parameter value passing
	      	$obj = $req->fetch();

	      	if ($obj) {
		    	$password = trim($_POST['password']);

		    	//validating required fields
		    	if ($password != '') {
		    		$db = db::getConnection();
		    		$req = $db->prepare('UPDATE users SET password=:password WHERE id=:id');
		    		$req->execute(array('password' => md5($password), 'id' => $obj['id']));

		    		echo "Password has been updated successfully";
		    	}
	      	}else{
	      		echo "No such ID exists";
	      	}
	    }
	}
 ?>