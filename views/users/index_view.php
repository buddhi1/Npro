<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h2>All Users</h2>
<div class="container">
	<?php 
		if (isset($_GET['message'])) {
			echo '<div class="alert alert-info">'.urldecode(base64_decode($_GET['message'])).'</div>';
		} 
	?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>User Name</th>
				<th>Gender</th>
				<th>Picture</th>
				<th>Created Date</th>
				<th>Profile Info</th>
				<th>Auth Info</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user) { ?>
			<tr>
				<td><?php echo $user->id; ?></td>
				<td><?php echo $user->name; ?></td>
				<td>
				<h4>
					<?php 
					if ($user->gender == 0) {
					 	echo '<span class="label label-default">'."Female".'</span>';
					 }elseif ($user->gender == 1) {
					 	echo '<span class="label label-default">'."Male".'</span>';
					 }
					?>	
				</h4>	
				</td>				
				<td><?php echo $user->picture; ?></td>	
				<td><?php echo $user->created_at; ?></td>
				<td>
					<form action="/<?php echo Controller::$url ?>/users/edit" method="GET">
						<input type="hidden" name="id" value="<?php echo $user->id; ?>">
						<button type="submit" class="btn btn-primary">Edit</button>
					</form>
				</td>
				<td>
					<form action="/<?php echo Controller::$url ?>/users/editAuth" method="GET">
						<input type="hidden" name="id" value="<?php echo $user->id; ?>">
						<button type="submit" class="btn btn-warning">Edit</button>
					</form>
				</td>
				<td>
					<form action="/<?php echo Controller::$url ?>/users/delete" method="POST">
						<input type="hidden" name="id" value="<?php echo $user->id; ?>">
						<button type="submit" class="btn btn-danger">Delete</button>
					</form>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
</body>
</html>