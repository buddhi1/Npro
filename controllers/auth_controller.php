<?php 
/**
* controller which handles the authetication of users
*/
require_once('controller.php');

class AuthController extends Controller
{
	
	//returns the user login form
	//GET request
	public static function login(){
		require_once('views/auth/login_view.php');
	}

	//validates the login credentials
	//POST request
	public static function postLogin(){
		session_start();
		if (!AuthController::isLogin()) {
			if(isset($_POST['email']) && isset($_POST['password'])){
				$email = $_POST['email'];
				$password = trim($_POST['password']);
				
		      	if ($email != '' && $password != '') {
		      		//checking the credentials in the db
		    		$db = db::getConnection();
			    	$req = $db->prepare('SELECT * FROM auth WHERE email = :email AND password = :password');
			      	$req->execute(array('email' => $email, 'password' => md5($password))); //parameter value passing
			      	$obj = $req->fetch();
		      		if ($obj) {
			      		//confirm login
			      		$db = db::getConnection();
			      		$req = $db->prepare('UPDATE auth SET flag = flag + 1 WHERE id = :id');
			      		$req->execute(array('id' => $obj[0]));
			      		
			      		$_SESSION["id"] = $obj[0];
			      		$_SESSION["email"] = $obj[1];
			      		$_SESSION["password"] = $obj[2]; 

			      		if (isset($_SESSION['id']) && isset($_SESSION['email']) && isset($_SESSION['password'])) {
			      			$message = "Login Successfull";
			      		}else{
			      			$message = 'Something went wrong. Try again';
			      		}
			      	}else{
			      		$message = "Invalid credentials. Try again";
			      	}
		      	}else{
		      		$message = "Required fields are empty. Please Fill Both user name and password";		
		      	}      	
			}else{
				$message = "Please try again";
			}
			Controller::route('login', $message);
		}else{
			Controller::route('login', "You are alredy logged in");
		}	      	
	}

	//destroys a session
	//GET request
	public static function logout() {
		session_start();
		if (AuthController::isLogin()) {
			//set db flag to logout
			$db = db::getConnection();
      		$req = $db->prepare('UPDATE auth SET flag = flag-1 WHERE id = :id');
      		$req->execute(array('id' => $_SESSION['id']));
			// remove all session variables
			session_unset(); 

			// destroy the session 
			session_destroy(); 
			$message = 'You are Logout successfully';
		}else {
			$message = 'You have not yet login';
		}
		Controller::route('login', $message);

	}

	//checks if user is logged in
	//internal class function
	public static function isLogin() {
		// var_dump(PHP_SESSION_NONE);exit;
		if (count($_SESSION) == 3) { //if one session available
			return true;
		}
		return false;
	}
}
 ?>