<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div>
	<div class="jumbotron" style="text-align: center;"><h1>Admin</h1></div>
	<?php 
		if (isset($_GET['message'])) {
			echo '<div class="alert alert-info">'.urldecode(base64_decode($_GET['message'])).'</div>';
		} 
	?>
</div>
</body>
</html>
