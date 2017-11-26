<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid"> 
	<h2>Edit User</h2>
	<form action="postChangePassword" method="POST" class="form-horizontal" onsubmit="return pswEditValidate()">
	<?php if (isset($user)) { ?>
		<div class="form-group">
			<label class="control-label col-sm-2">Current Password: </label>
			<div class="col-sm-4">
				<input type="password" name="currPassword" id="currPassword" placeholder="Current Password Here" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">New Password: </label>
			<div class="col-sm-4">
				<input type="password" name="password" id="password" placeholder="New Password Here" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Retype Password: </label>
			<div class="col-sm-4">
				<input type="password" name="pswConfirm" id="pswConfirm" placeholder="Retype Password Here" class="form-control" />
			</div>
		</div>		
	<?php } ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" id="submit" class="btn btn-default">Update</button>
		</div>
	</div>
	</form>
</div>
</body>
</html>
<script type="text/javascript" src="/<?php echo Controller::$url; ?>/public/js/general.js"></script>
