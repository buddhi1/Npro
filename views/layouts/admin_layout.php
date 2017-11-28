<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">

	<!-- custom CSS file -->
	<link rel="stylesheet" type="text/css" href="/Npro/public/CSS/styles.css">
	
</head>
<body>
<?php if (!isset($_SESSION)) session_start(); ?>
<div class="nav-bar">
	<h1 class="head" id="head">Secure Messeage Parsing (SMP)</h1>
	
	<a href="../auth/logout" class="logout"><span class="glyphicon">&#xe163;</span> Logout</a>
	<p class="welcome">Welcome <?php echo $_SESSION['name']; ?>!</p>
</div>
<div class="vmenu-button" id="ham"><span class="glyphicon">&#xe236;</span></div>
<div class="menu-box" id="accordion">
	<ul>
		<li>
			<a href="../users/profile" class="vert-menu-item-home">
				<span class="glyphicon">&#xe021;</span>
				Home
			</a>
		</li>
		<li>
			<a class="vert-menu-item collapsed" data-parent="#accordion" data-toggle="collapse" data-target="#prof-col">
				<span class="glyphicon">&#xe019;</span>
				Settings
			</a>
			<ul id="prof-col" class="col collapse">
				<li><a href="/<?php echo 'Npro/users/edit?id='.$_SESSION['id'] ?>">Edit</a></li>
				<li><a href="/Npro/users/changePassword">Change Password</a></li>
			</ul>
		</li>
		<li>
			<a class="vert-menu-item collapsed" data-parent="#accordion" data-toggle="collapse" data-target="#user-col">
				<span class="glyphicon">&#xe008;</span>
				Users
			</a>
			<ul id="user-col" class="col collapse">
				<li><a href="../users/create">Create User</a></li>
				<li><a href="../users/index">All Users</a></li>
			</ul>
		</li>		
		<li>
			<a class="vert-menu-item collapsed" data-parent="#accordion" data-toggle="collapse" data-target="#msg-col">
				<span class="glyphicon">&#x2709;</span>
				Messages
			</a>
			<ul id="msg-col" class="col collapse">
				<li><a href="../msg/index">Send Now</a></li>
				<li><a href="../msg/search">History</a></li>
				<li><a href="../msg/searchEnc">Encrypted Messages</a></li>
			</ul>
		</li>
	</ul>
</div>
<script type="text/javascript" src="/Npro/public/js/layout_control.js"></script>
<div class="workspace-box">
	<?php require_once('route.php') ?>
</div>
</body>
</html>