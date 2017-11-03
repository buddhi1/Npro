<?php 
if (isset($_REQUEST['obj'])) {
	header('Content-Type: application/json');
	echo $_REQUEST['obj'];
}
?>