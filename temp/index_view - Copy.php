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
				<th>User Email</th>
				<th>Type</th>
				<th>Active</th>
				<th>Flag</th>
				<th>Last Login</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user) { ?>
			<tr>
				<td><?php echo $user->id; ?></td>
				<td><?php echo $user->email; ?></td>
				<td>
				<h4>
					<?php 
					if ($user->type == 0) {
					 	echo '<span class="label label-warning">'."Admin".'</span>';
					 }elseif ($user->type == 1) {
					 	echo '<span class="label label-default">'."Standard User".'</span>';
					 }
					?>	
				</h4>	
				</td>
				<td>
				<h4>
					<?php 
					if ($user->active == 0) {
					 	echo '<span class="label label-danger">'."Blocked".'</span>';
					 }elseif ($user->active == 1) {
					 	echo '<span class="label label-success">'."Active".'</span>';
					 }
					?>	
				</h4>					
				</td>
				<td>
				<h4>
					<?php 
					if ($user->flag == 0) {
					 	echo '<span class="label label-default">'."Offline".'</span>';
					 }elseif ($user->flag == 1) {
					 	echo '<span class="label label-success">'."Online".'</span>';
					 }
					?>	
				</h4>					
				</td>
				<td><?php echo $user->lat_login; ?></td>	

				<td>
					<form action="/<?php echo Controller::$url ?>/users/edit" method="GET">
						<input type="hidden" name="id" value="<?php echo $user->id; ?>">
						<button type="submit" class="btn btn-primary">Edit</button>
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