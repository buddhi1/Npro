<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>Error page</h1>
<h3>
	<?php 
		if ($message != '') {
			echo 'ERROR'.'<br/>'.$message;
		} 
	?>
	
</h3>
</body>
</html>