<?php 
/**
* class for sending and receiving messages
*/
require_once('controller.php');

class MessagesController extends Controller
{
	
	//returns the chat box page
	//GET request
	public function index() {
		require_once('views/chat/index_view.php');
	}

	//save a message
	//POST request
	public function save() {
		if (!isset($_SESSION)) {
			session_start();
		}
		if (isset($_REQUEST['pid'])) {
			$pid = $_REQUEST['pid'];

			if (isset($_REQUEST['msg'])) {
				$msg = $_REQUEST['msg'];
				$now = date('Y-m-d H:i:s');
				$db = db::getConnection();
				$seId = $_SESSION['id'];


				define('AES_256_CBC', 'aes-256-cbc');
				$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC));
				$key = openssl_random_pseudo_bytes(32);
				$seKey = $key.' '.$iv;
				$reKey = $key.' '.$iv;
				
				
				$encryptedMsg = openssl_encrypt($msg, AES_256_CBC, $key, 0, $iv);
				
	      		$req = $db->prepare('INSERT INTO messages (text, created_at) VALUES (:msg, :created_at)');
	      		$val = $req->execute(array('msg' => $encryptedMsg, 'created_at' => $now));
		    	$id = $db->lastInsertId();
		    	if ($val) {
	      			$req = $db->prepare('INSERT INTO msg_sent  VALUES (:seId, :reId, :meId, :seKey, :reKey, :createdAt)');
	      			$val = $req->execute(array('seId' => $seId, 'reId' => $pid, 'meId' => $id, 'seKey' => $seKey, 'reKey' => $reKey, 'createdAt' => $now));

	      			// $req = $db->prepare('SELECT created_at FROM msg_sent WHERE me_id = :id');
			      	// $req->execute(array('id' => $id)); //parameter value passing
			      	// $message = $req->fetch();    
					$message = "Message delivered";

		    	}

			} else {
				$message = "Something went wrong. Try again";
			}
	      	
	      	} else {
				$message = "Something went wrong";
		}
		header('Location: http://'.Controller::$url_http.'/public/temp.php?obj='.json_encode($message));		//routing to the default ajax 
	}

	//load all messages
	//POST request
	public function allMsg() {
		if (!isset($_SESSION)) {
			session_start();
		}
		if (isset($_REQUEST['pid'])) {
			$pid = $_REQUEST['pid'];
	
			$lt = 0;
			if (isset($_REQUEST['limit'])) {
				$lt = $_REQUEST['limit'];
			}
			
			$id = $_SESSION['id'];
			$msgs = [];
			$db = db::getConnection();
			// $req = $db->prepare('SELECT DISTINCT messages.id, messages.created_at, text, se_id, re_id FROM messages, msg_sent WHERE id = me_id AND (se_id = :pid AND re_id = :id) OR (se_id = :id AND re_id = :pid) ORDER BY messages.created_at DESC LIMIT :lt,10');

			$req = $db->prepare('SELECT DISTINCT text, re_id, se_id, re_key, se_key, messages.id, messages.created_at FROM messages, msg_sent WHERE  me_id = id AND me_id IN (SELECT me_id FROM msg_sent WHERE se_id = :pid AND re_id = :id) OR me_id = id AND me_id IN (SELECT me_id FROM msg_sent WHERE se_id = :id AND re_id = :pid) ORDER BY messages.created_at DESC LIMIT :lt,10');

			$req->bindValue(':pid', $pid);
			$req->bindValue(':id', $id);
			$req->bindValue(':lt', (int) $lt, PDO::PARAM_INT);
			$req->execute();
			// creating a list of objects from the database results
			define('AES_256_CBC', 'aes-256-cbc');
			while ($obj = $req->fetch()) {
				$se_id = explode(' ', $obj['se_key']);
				$re_id = explode(' ', $obj['re_key']);
				$parts = $se_id;
				if ($id == $se_id) {
					$parts = $re_id;
				} 
				$decrypted = openssl_decrypt($obj['text'], AES_256_CBC, $parts[0], 0, $parts[1]);

				$msgs[] = new Message($obj['id'], $decrypted, $obj['se_id'], $obj['re_id'], $obj['created_at']);
			}			
			
		} else {
			$msgs = "Something went wrong";
		}
		header('Location: http://'.Controller::$url_http.'/public/temp.php?obj='.json_encode($msgs));		//routing to the default ajax 
	}

	//load all messages
	//POST request
	public function newMsg() {
		if (!isset($_SESSION)) {
			session_start();
		}
		
		if (isset($_REQUEST['crat'])) {
			$crat = $_REQUEST['crat'];
		} 
		if (isset($_REQUEST['pid'])) {
			$pid = $_REQUEST['pid'];

			$id = $_SESSION['id'];
			$msgs = [];
			$db = db::getConnection();
			// $req = $db->prepare('SELECT DISTINCT messages.id, messages.created_at, text, se_id, re_id FROM messages, msg_sent WHERE id = me_id AND (se_id = :pid AND re_id = :id) OR (se_id = :id AND re_id = :pid) AND messages.created_at = :crat ORDER BY messages.created_at DESC');

			$req = $db->prepare('SELECT DISTINCT text, re_id, se_id, se_key, re_key, messages.id, messages.created_at FROM messages, msg_sent WHERE  me_id = id AND me_id IN (SELECT me_id FROM msg_sent WHERE se_id = :pid AND re_id = :id AND created_at > :crat) OR me_id = id AND me_id IN (SELECT me_id FROM msg_sent WHERE se_id = :id AND re_id = :pid AND created_at > :crat) ORDER BY messages.created_at DESC');

			$req->bindValue(':pid', $pid);
			$req->bindValue(':id', $id);
			$req->bindValue(':crat', $crat);
			$req->execute();
			// creating a list of objects from the database results
			
			define('AES_256_CBC', 'aes-256-cbc');
			while ($obj = $req->fetch()) {
				$se_id = explode(' ', $obj['se_key']);
				$re_id = explode(' ', $obj['re_key']);
				$parts = $se_id;
				if ($id == $se_id) {
					$parts = $re_id;
				} 
				$decrypted = openssl_decrypt($obj['text'], AES_256_CBC, $parts[0], 0, $parts[1]);

				$msgs[] = new Message($obj['id'], $decrypted, $obj['se_id'], $obj['re_id'], $obj['created_at']);
			}
		} else {
			$msgs = "Something went wrong";
		}
		
		header('Location: http://'.Controller::$url_http.'/public/temp.php?obj='.json_encode($msgs));		//routing to the default ajax 
	}

	//return message history
	//GET request
	public function search() {
		require_once('views/chat/history_view.php');
	}

	//returns the search results for search by username and keyword decrypted
	//POST request
	public function searchPost() {
		if (isset($_POST['uname']) && isset($_POST['keyword'])) {
			if (!isset($_SESSION)) {
				session_start();
			}
			$msgs = [];
			$uname = $_POST['uname'];
			$keyword = $_POST['keyword'];
			$id = $_SESSION['id'];

			if ($uname != '' && $keyword == '') {
				$db = db::getConnection();
	      		$req = $db->prepare("SELECT messages.id, text, re_key, messages.created_at FROM messages, msg_sent WHERE me_id = messages.id AND re_id = $id AND se_id = ANY (SELECT auth_id FROM users WHERE UPPER(name) LIKE UPPER(:funame) OR UPPER(name) LIKE UPPER(:uname)) ORDER BY messages.created_at DESC");
	      		$req->bindValue(':funame', $uname.'%', PDO::PARAM_STR);
	      		$req->bindValue(':uname', '%'.$uname.'%', PDO::PARAM_STR);
	      		$req->execute();
				define('AES_256_CBC', 'aes-256-cbc');
				while ($obj = $req->fetch()) {
					$re_id = explode(' ', $obj['re_key']);
					$parts = $re_id;
					
					$decrypted = openssl_decrypt($obj['text'], AES_256_CBC, $parts[0], 0, $parts[1]);

					$msgs[] = new Message($obj['id'], $decrypted, $obj['created_at']);      		
				} 
			} else if ($uname == '' && $keyword != '') {
				$db = db::getConnection();
	      		$req = $db->prepare("SELECT messages.id, text, re_key, messages.created_at FROM messages, message_keyword, msg_sent WHERE me_id = messages.id AND re_id = $id AND m_id = messages.id AND k_id = ANY (SELECT id FROM keywords WHERE UPPER(keyword) LIKE UPPER(:fkeyword) OR UPPER(keyword) LIKE UPPER(:keyword)) ORDER BY messages.created_at DESC");
	      		$req->bindValue(':fkeyword', $keyword.'%', PDO::PARAM_STR);
	      		$req->bindValue(':keyword', '%'.$keyword.'%', PDO::PARAM_STR);
	      		$req->execute();
				define('AES_256_CBC', 'aes-256-cbc');
				while ($obj = $req->fetch()) {
					$re_id = explode(' ', $obj['re_key']);
					$parts = $re_id;
					
					$decrypted = openssl_decrypt($obj['text'], AES_256_CBC, $parts[0], 0, $parts[1]);

					$msgs[] = new Message($obj['id'], $decrypted, $obj['created_at']); 		
				} 
			} else if ($uname != '' && $keyword != '') {
				$db = db::getConnection();
	      		$req = $db->prepare("SELECT messages.id, text, re_key, messages.created_at FROM messages, message_keyword, msg_sent WHERE me_id = messages.id AND re_id = $id AND m_id = messages.id AND k_id = ANY (SELECT id FROM keywords WHERE UPPER(keyword) LIKE UPPER(:fkeyword) OR UPPER(keyword) LIKE UPPER(:keyword)) AND se_id = ANY (SELECT auth_id FROM users WHERE UPPER(name) LIKE UPPER(:funame) OR UPPER(name) LIKE UPPER(:uname)) ORDER BY messages.created_at DESC");
	      		$req->bindValue(':fkeyword', $keyword.'%', PDO::PARAM_STR);
	      		$req->bindValue(':keyword', '%'.$keyword.'%', PDO::PARAM_STR);
	      		$req->bindValue(':funame', $uname.'%', PDO::PARAM_STR);
	      		$req->bindValue(':uname', '%'.$uname.'%', PDO::PARAM_STR);
	      		$req->execute();
				define('AES_256_CBC', 'aes-256-cbc');
				while ($obj = $req->fetch()) {
					$re_id = explode(' ', $obj['re_key']);
					$parts = $re_id;
					
					$decrypted = openssl_decrypt($obj['text'], AES_256_CBC, $parts[0], 0, $parts[1]);

					$msgs[] = new Message($obj['id'], $decrypted, $obj['created_at']);   		
				} 
			}
		} else {
			$msgs = "Something went wrong";
		}
		
		header('Location: http://'.Controller::$url_http.'/public/temp.php?obj='.json_encode($msgs));		//routing to the default ajax 

	}

	//return message history encrypted version
	//GET request
	public function searchEnc() {
		require_once('views/chat/history_enc_view.php');
	}

	//returns the search results for search by username and keyword encrypted
	//POST request
	public function searchPostEnc() {
		if (isset($_POST['uname']) && isset($_POST['keyword'])) {
			if (!isset($_SESSION)) {
				session_start();
			}
			$msgs = [];
			$uname = $_POST['uname'];
			$keyword = $_POST['keyword'];
			$id = $_SESSION['id'];

			if ($uname != '' && $keyword == '') {
				$db = db::getConnection();
	      		$req = $db->prepare("SELECT messages.id, text, messages.created_at FROM messages, msg_sent WHERE me_id = messages.id AND re_id = $id AND se_id = ANY (SELECT auth_id FROM users WHERE UPPER(name) LIKE UPPER(:funame) OR UPPER(name) LIKE UPPER(:uname)) ORDER BY messages.created_at DESC");
	      		$req->bindValue(':funame', $uname.'%', PDO::PARAM_STR);
	      		$req->bindValue(':uname', '%'.$uname.'%', PDO::PARAM_STR);
	      		$req->execute();
				while ($obj = $req->fetch()) {
					$msgs[] = new Message($obj['id'], $obj['text'], $obj['created_at']);      		
				} 
			} else if ($uname == '' && $keyword != '') {
				$db = db::getConnection();
	      		$req = $db->prepare("SELECT messages.id, text, messages.created_at FROM messages, message_keyword, msg_sent WHERE me_id = messages.id AND m_id = messages.id AND re_id = $id AND k_id = ANY (SELECT id FROM keywords WHERE UPPER(keyword) LIKE UPPER(:fkeyword) OR UPPER(keyword) LIKE UPPER(:keyword)) ORDER BY messages.created_at DESC");
	      		$req->bindValue(':fkeyword', $keyword.'%', PDO::PARAM_STR);
	      		$req->bindValue(':keyword', '%'.$keyword.'%', PDO::PARAM_STR);
	      		$req->execute();
				while ($obj = $req->fetch()) {
					$msgs[] = new Message($obj['id'], $obj['text'], $obj['created_at']);      		
				} 
			} else if ($uname != '' && $keyword != '') {
				$db = db::getConnection();
	      		$req = $db->prepare("SELECT messages.id, text, messages.created_at FROM messages, message_keyword, msg_sent WHERE me_id = messages.id AND m_id = messages.id AND re_id = $id AND k_id = ANY (SELECT id FROM keywords WHERE UPPER(keyword) LIKE UPPER(:fkeyword) OR UPPER(keyword) LIKE UPPER(:keyword)) AND se_id = ANY (SELECT auth_id FROM users WHERE UPPER(name) LIKE UPPER(:funame) OR UPPER(name) LIKE UPPER(:uname)) ORDER BY messages.created_at DESC");
	      		$req->bindValue(':fkeyword', $keyword.'%', PDO::PARAM_STR);
	      		$req->bindValue(':keyword', '%'.$keyword.'%', PDO::PARAM_STR);
	      		$req->bindValue(':funame', $uname.'%', PDO::PARAM_STR);
	      		$req->bindValue(':uname', '%'.$uname.'%', PDO::PARAM_STR);
	      		$req->execute();
				while ($obj = $req->fetch()) {
					$msgs[] = new Message($obj['id'], $obj['text'], $obj['created_at']);      		
				} 
			}
		} else {
			$msgs = "Something went wrong";
		}
		
		header('Location: http://'.Controller::$url_http.'/public/temp.php?obj='.json_encode($msgs));		//routing to the default ajax 

	}

	//return decrypted message
	//GET request
	public function decryptMsg() {

		if (isset($_GET['id'])) {
			if (!isset($_SESSION)) {
				session_start();
			}
			$id = $_GET['id'];
			$myId = $_SESSION['id'];
			$db = db::getConnection();
      		$req = $db->prepare("SELECT messages.id, text, re_key, messages.created_at FROM messages, msg_sent WHERE me_id = messages.id AND re_id = $myId AND messages.id = $id");
      		$req->execute();
      		$obj = $req->fetch();

      		if ($obj) {
      			define('AES_256_CBC', 'aes-256-cbc');				
				$re_id = explode(' ', $obj['re_key']);
				$parts = $re_id;				
				$decrypted = openssl_decrypt($obj['text'], AES_256_CBC, $parts[0], 0, $parts[1]);
				$msg = new Message($obj['id'], $decrypted, $obj['created_at']); 	
				
				require_once('views/chat/msg_view.php');
				
      		} else {
  				Controller::route('pages/error', 'Illegal Access');
      		}			
		} else {
  			Controller::route('pages/error', 'Something went wrong');
		}
	}

	//delete message
	//POST request
	public function delete() {

		if (isset($_POST['id'])) {
			if (!isset($_SESSION)) {
				session_start();
			}
			$id = $_POST['id'];
			$myId = $_SESSION['id'];
			$db = db::getConnection();
      		$req = $db->prepare("SELECT messages.id, text, re_key, messages.created_at FROM messages, msg_sent WHERE me_id = messages.id AND re_id = $myId AND messages.id = $id");
      		$req->execute();
      		$obj = $req->fetch();

      		if ($obj) {
      			$req = $db->prepare('DELETE FROM messages WHERE id = :id');
		      	$req->execute(array('id' => $id)); //parameter value passing
		      	$message = "Message deleted successfully";
				
      		} else {
  				$message = "Message ID is invalid";
      		}			
		} else {
			$message = "Something went wrong";
		}
		Controller::route('msg/searchEnc', $message);
	}
}
?>