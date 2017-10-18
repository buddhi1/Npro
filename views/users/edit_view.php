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
				<input type="text" name="id" value="<?php echo $user->id; ?>" readonly class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">First Name: </label>
			<div class="col-sm-4">
				<input type="text" name="fname"  placeholder="First Name" class="form-control" value="<?php echo $user->fname; ?>" required="required" />
			</div>			
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Last Name: </label>
			<div class="col-sm-4">
				<input type="text" name="lname"  placeholder="Last Name" class="form-control" value="<?php echo $user->lname; ?>" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Street 1: </label>
			<div class="col-sm-4">
				<input type="text" name="street1"  placeholder="Street 1" class="form-control" value="<?php echo $user->street1; ?>" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Street 2: </label>
			<div class="col-sm-4">
				<input type="text" name="street2"  placeholder="Street 2" class="form-control" value="<?php echo $user->street2; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">City: </label>
			<div class="col-sm-4">
				<input type="text" name="city"  placeholder="City" class="form-control" value="<?php echo $user->city; ?>" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">State: </label>
			<div class="col-sm-4">
				<input type="text" name="state"  placeholder="State" class="form-control" value="<?php echo $user->state; ?>" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Zip: </label>
			<div class="col-sm-4">
				<input type="text" name="zip"  placeholder="Zip" class="form-control" value="<?php echo $user->zip; ?>" required="required" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Gender: </label>
			<div class="col-sm-4">
				<select name="gender" class="form-control">	
					<option value="0" <?php if($user->gender == 0) echo 'selected="selected"'; ?> >Female</option>
					<option value="1" <?php if($user->gender == 1) echo 'selected="selected"'; ?> >Male</option>	
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