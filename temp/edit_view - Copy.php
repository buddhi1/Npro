<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container">
	<h2>Edit User</h2>
	<form action="postEdit" method="POST" class="form-horizontal">
	<?php if (isset($user)) { ?>
		<div class="form-group">
			<label class="control-label col-sm-2">User ID: </label>
			<div class="col-sm-4">
				<input type="text" name="id" value="<?php echo $user[0]; ?>" readonly class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">User Name: </label>
			<div class="col-sm-4">
				<label class="control-label col-sm-2"><?php echo $user[1]; ?></label>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">User Password: </label>
			<div class="col-sm-4">
				<input type="password" name="password" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">User Type: </label>
			<div class="col-sm-4">
				<select name="type" class="form-control">	
					<option value="0" <?php if($user[2] == 0) echo 'selected="selected"'; ?> >Admin</option>
					<option value="1" <?php if($user[2] == 1) echo 'selected="selected"'; ?> >Standard User</option>	
				</select>
			</div>
		</div>
	<?php } ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="Submit" class="btn btn-default">Update</button>
		</div>
	</div>
	</form>
</div>
</body>
</html>