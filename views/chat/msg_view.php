<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php if (isset($msg)) { ?>
	<div id="results" class="msg-search-res top-margin">
		<div class="msg-text"><?php echo $msg->text; ?></div>
		<div class="msg-crt"><?php echo $msg->created_at; ?></div>
	</div>
	<?php } ?>
	<form action="searchEnc" method="GET" class="top-margin">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" id="submit" class="btn btn-default">Back</button>
			</div>
		</div>
	</form>
</body>
</html>