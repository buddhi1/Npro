<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="search-input">
		<div class="col-sm-4">
			<input type="text" name="user" id="user" placeholder="User Name Here" class="form-control top-margin-sm" />
		</div>
		<div class="col-sm-4">
			<input type="text" name="keyword" id="keyword" placeholder="Keyword Here" class="form-control top-margin-sm" />
		</div>
		<div class="col-sm-4"> 
			<button class="btn btn-success top-margin-sm" id="addKeyWord">Add KeyWord</button>
		</div>
	</div>
	<?php 
		if (isset($_GET['message'])) {
			echo '<div class="alert alert-info">'.urldecode(base64_decode($_GET['message'])).'</div>';
		} 
	?>
	<div id="results" class="msg-search-res"></div>
</body>
</html>
<script type="text/javascript">
	var url_http = '<?php echo Controller::$url_http; ?>';
	var myId = '<?php if (!isset($_SESSION)) {session_start();} echo $_SESSION["id"]; ?>';
</script>
<script type="text/javascript" src="/<?php echo Controller::$url; ?>/public/js/ajax.js"></script>
<script type="text/javascript" src="/<?php echo Controller::$url; ?>/public/js/search_enc.js"></script>