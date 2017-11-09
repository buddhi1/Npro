<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div>
		<div>
			<input type="text" name="user" id="user" placeholder="User Name Here" />
		</div>
		<div>
			<input type="text" name="keyword" id="keyword" placeholder="Keyword Here" />
		</div>
	</div>
	<div id="results"></div>
</body>
</html>
<script type="text/javascript">
	var url_http = '<?php echo Controller::$url_http; ?>';
	var myId = '<?php if (!isset($_SESSION)) {session_start();} echo $_SESSION["id"]; ?>';
</script>
<script type="text/javascript" src="/<?php echo Controller::$url; ?>/public/js/ajax.js"></script>
<script type="text/javascript" src="/<?php echo Controller::$url; ?>/public/js/search.js"></script>