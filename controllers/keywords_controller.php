<?php 

/**
* keyword class controller
*/
require_once('controller.php');

class KeywordsController extends Controller
{
	
	//saves keyword 
	//POST request
	public function save(){
		if (isset($_POST['mid']) && isset($_POST['kWord'])) {
			$mid = $_POST['mid'];
			$kWord = $_POST['kWord'];

			$db = db::getConnection();
      		$req = $db->prepare('INSERT INTO keywords (keyword) VALUES (:kWord)');
      		$val = $req->execute(array('kWord' => $kWord));

      		if ($val) {
            	$kid = $db->lastInsertId();
      			$db = db::getConnection();
	      		$req = $db->prepare('INSERT INTO message_keyword (m_id, k_id) VALUES (:mid, :kid)');
	      		$req->execute(array('kid' => $kid, 'mid' => $mid));
      			$message = "Keyword saved";

      		} else {
      			$message = "Operation failed";
      		}

		} else {
			$message = 'Something went wrong';
		}
		echo $message;
	}
}

?>