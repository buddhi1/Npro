<?php 
/**
* User Controller class
*/
require_once('controller.php');
require_once('/models/user.php');

class UsersController extends Controller
{
	//returns new user create page
	//GET request
	public function create($message){
		require_once('views/users/create_view.php');
	}

  //returns new user profile page
  //GET request
  public function profile($message){
    if (!isset($_SESSION)) {
      session_start();
    }

    if ($_SESSION['type'] == 0) {
      require_once('views/profile/admin_prof_view.php');
    } else if ($_SESSION['type'] == 1) {
      require_once('views/profile/std_prof_view.php');
    } else {
      require_once('views/pages/index');
    }
  }

	//store all the user information
	//POST request
	public function save(){
    if (!isset($_SESSION)) {
      session_start();
    }
		//reading values into parameters 
  	$email = $_POST['email'];    	
		$password = trim($_POST['password']);
    $type = 1;
    if (isset($_POST['type'])) {
      $type = $_POST['type'];
    }
  	
  	$fname = $_POST['fname'];
  	$lname = $_POST['lname'];
  	$street1 = $_POST['street1'];
  	$street2 = $_POST['street2'];
  	$city = $_POST['city'];
  	$state = $_POST['state'];
  	$zip = $_POST['zip'];    
  	$gender = $_POST['gender'];	
  	$pic_path = 'def';
  	$now = date('Y-m-d H:i:s');
    	// var_dump($now); exit();

    	//validating required fields
    	if ($email != '' && $password != '' && $type != '' && $fname != '' && $lname != '' && $street1 != '' && $city != '' && $state != '' && $zip != '') {
    		//checking if the username already exists
    		$db = db::getConnection();
	    	$req = $db->prepare('SELECT * FROM auth WHERE email = :email');
	      	$req->execute(array('email' => $email)); //parameter value passing
	      	$obj_ex = $req->fetch();

	      	if (!$obj_ex) {
	      		$db = db::getConnection();
	    		$req = $db->prepare('INSERT INTO auth (email, password, type, active, flag, last_login) VALUES (:email, :password, :type, :active, :flag, :last_login)');
	    		$value1 = $req->execute(array('email' => $email, 'password' => md5($password), 'type' => $type, 'active' => 0, 'flag' => 0, 'last_login' => $now));
	    		
	    		if ($value1) {
            $id = $db->lastInsertId();
	    			$req = $db->prepare('INSERT INTO users VALUES (:auth_id, :name, :address, :gender, :picture, :created_at)');
	    			$value2 = $req->execute(array('auth_id' => $id, 'name' => $fname.' '.$lname, 'address' => $street1.','.$street2.','.$city.','.$state.','.$zip, 'gender' => $gender, 'picture' => $pic_path, 'created_at' => $now));
	    		}else {
	    			$message = "Something went wrong. User registration failed";
	    		}
	    		if ($value1 && $value2) {
            $message = "New user has been created successfully";            
            
            if (count($_SESSION) < 1) {
              Controller::route('auth/login', $message);            
            }
	    		}
	      	}else{
	      		$message = "Email exists. Please login with the email";
	      	}
    		
    	}else {
    		$message = "Fill all the required fields";
    	}

      if (count($_SESSION) >= 1) {
        if ($_SESSION['type'] == 0) { //if one session available
          Controller::route('users/create', $message);
        }
      }
      else {
        Controller::route('pages/error', $message);
      }
    	
	}

	//return available details of all the users
	//GET request
	public function index(){
    if (!isset($_SESSION)) {
      session_start();
    }

    $limit = 0; 
    if (isset($_GET['limit'])) {
      $limit = $_GET['limit'];
    }

		$users = [];
    $myId = $_SESSION['id'];
		$db = db::getConnection();
		$req = $db->prepare('SELECT * FROM users WHERE auth_id <> :myId LIMIT :lt,3');
    $req->bindValue(':myId', $myId);
    $req->bindValue(':lt', (int) $limit*3, PDO::PARAM_INT);
    $req->execute();

    // creating a list of objects from the database results
    foreach($req->fetchAll() as $obj) {      
      $users[] = new User($obj['auth_id'], $obj['name'], $obj['gender'], $obj['picture'], $obj['created_at']);
    }

    $req = $db->prepare('SELECT count(*) FROM users WHERE auth_id <> :myId');
    $req->bindValue(':myId', $myId);
    $req->execute();
    $count = $req->fetch();
		// return $users;
		require_once('views/users/index_view.php');
	}

	//returns user edit page
	//GET request
	public function edit(){
		//checking if the id exists
		$id = $_GET['id'];
		$db = db::getConnection();
    	$req = $db->prepare('SELECT auth_id, name, address, gender, picture FROM users WHERE auth_id = :id');
      	$req->execute(array('id' => $id)); //parameter value passing
      	$obj = $req->fetch();
      	if ($obj) {
      		$name = explode(' ', $obj['name']); // split name
      		$address = explode(',', $obj['address']); // split address
      		//create an user object to send to front-end
			$user = new User($obj['auth_id'], $name[0], $name[1], $address[0], $address[1], $address[2], $address[3], $address[4], $obj['gender'], $obj['picture']); 

      		require_once('views/users/edit_view.php');
      	}else{
      		Controller::route('users/index', 'Invalid User ID');
      	}
		
	}

    //returns user view page
  //GET request
  public function view(){
    //checking if the id exists
    $id = $_GET['id'];
    $db = db::getConnection();
      $req = $db->prepare('SELECT auth_id, name, address, gender, picture FROM users WHERE auth_id = :id');
        $req->execute(array('id' => $id)); //parameter value passing
        $obj = $req->fetch();
        if ($obj) {
          $name = explode(' ', $obj['name']); // split name
          $address = explode(',', $obj['address']); // split address
          //create an user object to send to front-end
      $user = new User($obj['auth_id'], $name[0], $name[1], $address[0], $address[1], $address[2], $address[3], $address[4], $obj['gender'], $obj['picture']); 

          require_once('views/users/view.php');
        }else{
          Controller::route('users/profile', 'Invalid User ID');
        }
    
  }

  //returns user change password page
  //GET request
  public function changePassword(){
    if (!isset($_SESSION)) {
      session_start();
    }

    $myId = $_SESSION['id'];
    $db = db::getConnection();
      $req = $db->prepare('SELECT * FROM auth WHERE id = :id');
        $req->execute(array('id' => $myId)); //parameter value passing
        $user = $req->fetch();
        if ($user) {
          require_once('views/profile/edit_auth_view.php');
        }else{
          Controller::route('/users/profile', 'Something went wrong');
        }
    
  }

  //returns user authenticating info edit page
  //GET request
  public function editAuth(){
    if (!isset($_SESSION)) {
        session_start();
    }
    $id = $_GET['id'];
    $db = db::getConnection();
      $req = $db->prepare('SELECT id, email, type, active, flag, last_login FROM auth WHERE id = :id');
        $req->execute(array('id' => $id)); //parameter value passing
        $user = $req->fetch();
        if ($user) {
          require_once('views/auth/edit_view.php');
        }else{
          Controller::route('users/index', 'Invalid User ID');
        }
    
  }


	//edit existing user
    //POST request
    public static function postEdit() {
      
    	//check if the id is passed
    	if (!isset($_POST['id'])) {
    		Controller::route('index', 'Invalid User ID');
    	}
    	$id = $_POST['id'];

    	//checking if the id exists
    	$db = db::getConnection();
    	$req = $db->prepare('SELECT * FROM users WHERE auth_id = :id');
      	$req->execute(array('id' => $id)); //parameter value passing
      	$obj = $req->fetch();

      	if ($obj) {
      		//reading values into parameters 
	    	$fname = $_POST['fname'];
	    	$lname = $_POST['lname'];
	    	$street1 = $_POST['street1'];
	    	$street2 = $_POST['street2'];
	    	$city = $_POST['city'];
	    	$state = $_POST['state'];
	    	$zip = $_POST['zip'];    
	    	$gender = $_POST['gender'];	
	    	$pic_path = 'def';

	    	//validating required fields
	    	if ($fname != '' && $lname != '' && $street1 != '' && $city != '' && $state != '' && $zip != '' && $gender != ' ') {
	    		$req = $db->prepare('UPDATE users SET name = :name, address = :address, gender = :gender, picture = :picture WHERE auth_id=:id');
    			$req->execute(array('name' => $fname.' '.$lname, 'address' => $street1.','.$street2.','.$city.','.$state.','.$zip, 'gender' => $gender, 'picture' => $pic_path, 'id' => $id));
	    		$message = "User information updated successfully";
	    	}
      	}else{
      		$message = "No such User ID exists";
      	}
        if ($id == $_SESSION['id']) {
          Controller::route('users/profile', $message);
        } else {
          Controller::route('users/index', $message);
        }
    }

    //Deletes an exisiting user
    //POST rewuest
    public static function delete() {
    	//check if the id is passed
    	if (!isset($_POST['id'])) {
    		Controller::route('index', 'Invalid User ID');
    	}
    	$id = $_POST['id'];

    	//checking if the id exists
    	$db = db::getConnection();
    	$req = $db->prepare('SELECT * FROM auth WHERE id = :id');
      	$req->execute(array('id' => $id)); //parameter value passing
      	$obj = $req->fetch();

      	if ($obj) {
      		$req = $db->prepare('DELETE FROM auth WHERE id = :id');
	      	$req->execute(array('id' => $id)); //parameter value passing
	      	$message = "User deleted successfully";
      	}else{
      		$message = "User ID is invalid";
      	}
      	Controller::route('users/index', $message);
    }

    //edit user password
    //POST request
    public static function postChangePassword() {
      if (!isset($_SESSION)) {
        session_start();
      }
    	$id = $_SESSION['id'];
      $currPassword = md5(trim($_POST['currPassword']));

    	//checking if the id exists
    	$db = db::getConnection();
    	$req = $db->prepare('SELECT * FROM auth WHERE id = :id');
      	$req->execute(array('id' => $id)); //parameter value passing
      	$obj = $req->fetch();

      	if ($obj['password'] == $currPassword) { //checking for old password match
          $password = trim($_POST['password']);
          $repsw = trim($_POST['pswConfirm']);
          if ($password != "" && $repsw != "") {
            if ($password == $repsw) {
                  
              $req = $db->prepare('UPDATE auth SET password=:password WHERE id=:id');
              $req->execute(array('password' => md5($password), 'id' => $obj['id']));

              $message = "Password updated successfully";          
              
            } else {
              $message = "Passwords does not match. Please try again";
            }

          } else {
            $message = "Password was not changed";
        }
      }else {
        $message = "Incorrect old Password";
      }
      	
      	Controller::route('users/profile', $message);
    }

     //edit user auth info
    //POST request
    public static function postEditAuth() {
      //check if the id is passed
      if (!isset($_POST['id'])) {
        Controller::route('index', 'Invalid User ID');
      }
      $id = $_POST['id'];
      $type = $_POST['type']; 
      $active = 0;
      if (isset($_POST['active'])) {
        if ($_POST['active'] == 'on') {
          $active = 1;
        }        
      } 

      //checking if the id exists
      $db = db::getConnection();
      $req = $db->prepare('SELECT * FROM auth WHERE id = :id');
        $req->execute(array('id' => $id)); //parameter value passing
        $obj = $req->fetch();

        if ($obj) {
          $password = trim($_POST['password']);
          $repsw = trim($_POST['pswConfirm']);
          if ($password != "" && $repsw != "") {
            if ($password == $repsw) {
                  
              $req = $db->prepare('UPDATE auth SET password=:password, type = :type, active = :active WHERE id=:id');
              $req->execute(array('password' => md5($password), 'type' => $type, 'id' => $obj['id'], 'active' => $active));

              $message = "User information updated successfully";          
              
            } else {
              $message = "Passwords does not match. Please try again";
            }

          } else {
            $req = $db->prepare('UPDATE auth SET type = :type, active = :active WHERE id=:id');
            $req->execute(array('type' => $type, 'id' => $obj['id'], 'active' => $active));
            $message = "User information updated successfully. Password preserved";
        }
      }else {
        $message = "No such User ID exists";
      }
        
        Controller::route('users/index', $message);
    }
  }

 ?>