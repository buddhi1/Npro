<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<h2>Create User</h2>
	<?php 
		if (isset($_GET['message'])) {
			echo '<div class="alert alert-info">'.urldecode(base64_decode($_GET['message'])).'</div>';
		} 
	?>
	<form action="save" method="POST" class="form-horizontal" onsubmit="return pswValidate()" enctype="multipart/form-data">
		<div class="form-group">
			<label class="control-label col-sm-2">Email: </label>
			<div class="col-sm-4">
				<input type="email" name="email"  placeholder="Email" class="form-control" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">User Password: </label>
			<div class="col-sm-4">
				<input type="password" name="password" id="password" placeholder="Password Here" class="form-control" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Retype Password: </label>
			<div class="col-sm-4">
				<input type="password" name="pswConfirm" id="pswConfirm" placeholder="Retype Password Here" class="form-control" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Gender: </label>
			<div class="col-sm-4">
				<select name="gender" class="form-control">
					<option value="0" selected="selected">Female</option>
					<option value="1">Male</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">User Type: </label>
			<div class="col-sm-4">
				<select name="type" class="form-control">
					<option value="0">Admin</option>
					<option value="1" selected="selected">Standard User</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">First Name: </label>
			<div class="col-sm-4">
				<input type="text" name="fname"  placeholder="First Name" class="form-control" required="required" />
			</div>			
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Last Name: </label>
			<div class="col-sm-4">
				<input type="text" name="lname"  placeholder="Last Name" class="form-control" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Street 1: </label>
			<div class="col-sm-4">
				<input type="text" name="street1"  placeholder="Street 1" class="form-control" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Street 2: </label>
			<div class="col-sm-4">
				<input type="text" name="street2"  placeholder="Street 2" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">City: </label>
			<div class="col-sm-4">
				<input type="text" name="city"  placeholder="City" class="form-control" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">State: </label>
			<div class="col-sm-4">
				<input type="text" name="state"  placeholder="State" class="form-control" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Zip: </label>
			<div class="col-sm-4">
				<input type="text" name="zip"  placeholder="Zip" class="form-control" required="required" />
			</div>
		</div>		
		<div class="form-group">
			<label class="control-label col-sm-2">Profile Image: </label>
			<div class="col-sm-offset-2 col-sm-10">
				<input type="file" name="fileToUpload" id="fileToUpload">
			</div>
		</div><div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" id="submit" class="btn btn-default">Submit</button>
			</div>
		</div>
	</form>
</div>
</body>
</html>
<script type="text/javascript" src="/<?php echo Controller::$url; ?>/public/js/general.js"></script>