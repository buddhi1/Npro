<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container"> 
	<h2>Edit User</h2>
	<form action="postEditAuth" method="POST" class="form-horizontal" onsubmit="return pswEditValidate()">
	<?php if (isset($user)) { ?>
		<div class="form-group">
			<label class="control-label col-sm-2">User ID: </label>
			<div class="col-sm-4">
				<input type="text" name="id" value="<?php echo $user[0]; ?>" readonly class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">User Email: </label>
			<div class="col-sm-4">
				<label class="control-label col-sm-2"><?php echo $user[1]; ?></label>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">User Password: </label>
			<div class="col-sm-4">
				<input type="password" name="password" id="password" placeholder="Password Here" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Retype Password: </label>
			<div class="col-sm-4">
				<input type="password" name="pswConfirm" id="pswConfirm" placeholder="Retype Password Here" class="form-control" />
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
		<div class="form-group">
			<label class="control-label col-sm-2">Active: </label>
			<div class="col-sm-4">
				<label class="switch">
					<input type="checkbox" name="active" <?php if($user[3] == 1) echo 'checked="1"'; ?> />
					<span class="slider round"></span>
				</label>
	  		</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Status: </label>
			<div class="col-sm-4">
	  			<h4>
					<?php 
					if ($user[4] == 0) {
					 	echo '<span class="label label-default">'."Offline".'</span>';
					 }elseif ($user[4] == 1) {
					 	echo '<span class="label label-success">'."Online".'</span>';
					 }
					?>	
				</h4>
	  		</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Last Login: </label>
			<div class="col-sm-4">
				<label class="control-label col-sm-8"><?php echo $user[5]; ?></label>
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
