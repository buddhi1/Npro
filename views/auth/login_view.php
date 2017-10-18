<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container">
	<h2>User Login</h2>
	<?php 
		if (isset($_GET['message'])) {
			echo '<div class="alert alert-info">'.urldecode(base64_decode($_GET['message'])).'</div>';
		} 
	?>
	<form action="postLogin" method="POST" class="form-horizontal">
		<div class="form-group">
			<div class="col-sm-4">
				<input type="email" name="email" placeholder="Email" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4">
				<input type="password" name="password" placeholder="Password" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<button type="Submit" class="btn btn-primary col-sm-4">Submit</button>
		</div>
	</form>
</div>
</body>
</html>