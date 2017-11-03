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
		if (isset($_REQUEST['msg'])) {
			$msg = $_REQUEST['msg'];
			$now = date('Y-m-d H:i:s');
			$db = db::getConnection();
			$seId = $_SESSION['id'];
			$reId = 3;
			$seKey = 1;
			$reKey = 1;

      		$req = $db->prepare('INSERT INTO messages (text, created_at) VALUES (:msg, :created_at)');
      		$val = $req->execute(array('msg' => $msg, 'created_at' => $now));
	    	$id = $db->lastInsertId();
	    	if ($val) {
      			$req = $db->prepare('INSERT INTO msg_sent  VALUES (:seId, :reId, :meId, :seKey, :reKey, :createdAt)');
      			$val = $req->execute(array('seId' => $seId, 'reId' => $reId, 'meId' => $id, 'seKey' => $seKey, 'reKey' => $reKey, 'createdAt' => $now));
      			$message = "Message delivered";	    		
	    	}

		} else {
			$message = "Something went wrong. Try again";
		}
      	header('Location: http://'.Controller::$url_http.'/public/temp.php?obj='.json_encode($message));		//routing to the default ajax 
	}

	//load all messages
	//POST request
	public function allMsg() {
		if (!isset($_SESSION)) {
			session_start();
		}
		$lt = 0;
		if (isset($_REQUEST['limit'])) {
			$lt = $_REQUEST['limit'];
		}
		
		$id = $_SESSION['id'];
		$pid = 3;
		$msgs = [];
		$db = db::getConnection();
		$req = $db->prepare('SELECT DISTINCT messages.id, messages.created_at, text, se_id, re_id FROM messages, msg_sent WHERE id = me_id AND (se_id = :pid AND re_id = :id) OR (se_id = :id AND re_id = :pid) ORDER BY messages.created_at DESC LIMIT :lt,10');

		$req->bindValue(':pid', $pid);
		$req->bindValue(':id', $id);
		$req->bindValue(':lt', (int) 0, PDO::PARAM_INT);
		$req->execute();
		// creating a list of objects from the database results

		while ($obj = $req->fetch()) {
			$msgs[] = new Message($obj['id'], $obj['text'], $obj['se_id'], $obj['re_id']);
		}
		
		header('Location: http://'.Controller::$url_http.'/public/temp.php?obj='.json_encode($msgs));		//routing to the default ajax 
	}

}
?>