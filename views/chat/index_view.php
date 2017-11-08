<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="cht-box">
	<div class="v1-box" id="v1-box">
		<div class="msgs-box" id="msgs-box">			
		</div>
		<div class="users-box" id="users-box">			
		</div>
	</div>
	<div class="msg-type-box">
		<input disabled="disabled" type="text" name="msg" id="msg" placeholder="Say hi..." />
		<button class="btn btn-outline-success" id="addKeyWord">Add KeyWord</button>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
	var url_http = '<?php echo Controller::$url_http; ?>';
	var myId = '<?php if (!isset($_SESSION)) {session_start();} echo $_SESSION["id"]; ?>';
</script>
<script type="text/javascript" src="/<?php echo Controller::$url; ?>/public/js/general.js"></script>