<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="container-fluid">
	<h2>User</h2>
	<form action="/Npro/msg/index" method="GET" class="form-horizontal">
	<?php if (isset($user)) { ?>
		<div class="user-info">
			<h3><?php echo $user->fname.' '.$user->lname; ?></h3>
			 <?php if($user->gender == 0) {?>
			 <p>Female</p>
			 <?php } else {?>
			 <p>Female</p>
			 <?php } ?>	
			 <p><?php echo $user->street1.', '.$user->street2.', '.$user->city.', '.$user->state.', '.$user->zip; ?></p>		 
		</div>		
	<?php } ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="Submit" class="btn btn-default">Back</button>
		</div>
	</div>
	</form>
</div>
</body>
</html>