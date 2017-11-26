<!DOCTYPE html>
<html>
<body>
<div class="container-fluid">
	<?php 
		if (isset($_GET['message'])) {
			echo '<div class="alert alert-info">'.urldecode(base64_decode($_GET['message'])).'</div>';
		} 
	?>
	<div>
		<p class="testimonial">Build a secure connection with your friends</p>
	</div>

	<div class="button-gp-home">
		<!-- Trigger the modal with a button -->
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#signin">Sign In</button>

		<!-- Trigger the modal with a button -->
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#signup">Sign Up</button>
	</div>

  <!-- Modal -->
  <div class="modal fade" id="signin" role="dialog">
    <div class="modal-dialog">
  
      <!-- Sign In Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Sign In</h4>
        </div>
        <div class="modal-body">
          <form action="auth/postLogin" method="POST" class="form-horizontal">
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

  <!-- Modal -->
  <div class="modal fade" id="signup" role="dialog">
    <div class="modal-dialog">
  
      <!-- Sign In Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Sign Up</h4>
        </div>
        <div class="modal-body">
        	<div class="container-fluid">
			<form action="users/save" method="POST" class="form-horizontal" onsubmit="return pswValidate()">
				<div class="form-group">
					<label class="control-label col-sm-3">Email: </label>
					<div class="col-sm-6">
						<input type="email" name="email"  placeholder="Email" class="form-control" required="required" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">User Password: </label>
					<div class="col-sm-6">
						<input type="password" name="password" id="password" placeholder="Password Here" class="form-control" required="required" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Retype Password: </label>
					<div class="col-sm-6">
						<input type="password" name="pswConfirm" id="pswConfirm" placeholder="Retype Password Here" class="form-control" required="required" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Gender: </label>
					<div class="col-sm-6">
						<select name="gender" class="form-control">
							<option value="0" selected="selected">Female</option>
							<option value="1">Male</option>
						</select>
					</div>
				</div>				
				<div class="form-group">
					<label class="control-label col-sm-3">First Name: </label>
					<div class="col-sm-6">
						<input type="text" name="fname"  placeholder="First Name" class="form-control" required="required" />
					</div>			
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Last Name: </label>
					<div class="col-sm-6">
						<input type="text" name="lname"  placeholder="Last Name" class="form-control" required="required" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Street 1: </label>
					<div class="col-sm-6">
						<input type="text" name="street1"  placeholder="Street 1" class="form-control" required="required" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Street 2: </label>
					<div class="col-sm-6">
						<input type="text" name="street2"  placeholder="Street 2" class="form-control"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">City: </label>
					<div class="col-sm-6">
						<input type="text" name="city"  placeholder="City" class="form-control" required="required" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">State: </label>
					<div class="col-sm-6">
						<input type="text" name="state"  placeholder="State" class="form-control" required="required" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3">Zip: </label>
					<div class="col-sm-6">
						<input type="text" name="zip"  placeholder="Zip" class="form-control" required="required" />
					</div>
				</div>		
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-10">
						<button type="submit" id="submit" class="btn btn-default">Submit</button>
					</div>
				</div>
			</form>
		</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>      
    </div>
  </div>  
</div>
</body>
<script type="text/javascript" src="/<?php echo Controller::$url; ?>/public/js/general.js"></script>
</html>