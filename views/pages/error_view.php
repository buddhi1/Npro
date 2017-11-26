<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1 class="error">Error Page</h1>
<?php 
	if (isset($_GET['message'])) {
		echo '<div class="alert alert-danger">'.urldecode(base64_decode($_GET['message'])).'</div>';
	} 
?>
</body>
</html>