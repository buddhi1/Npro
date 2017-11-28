<!DOCTYPE html>
<html>
<body>
<div class="container-fluid">
	<?php 
		if (isset($_GET['message'])) {
			echo '<div class="alert alert-info">'.urldecode(base64_decode($_GET['message'])).'</div>';
		} 
	?>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Sign In</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Sign In</h4>
        </div>
        <div class="modal-body">
          <form action="postLogin" method="POST" class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-10 col-lg-offset-1">
					<input type="email" name="email" placeholder="Email" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-10 col-lg-offset-1">
					<input type="password" name="password" placeholder="Password" class="form-control" />
				</div>
			</div>
			<div class="form-group">
          <button type="Submit" class="btn btn-success col-sm-10 col-lg-offset-1">Login</button>

			</div>
		</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

</body>
</html>