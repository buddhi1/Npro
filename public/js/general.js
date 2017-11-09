//validates pasword with retype password in create page
var pswValidate = function(){
	var password = document.getElementById('password').value.trim();
	var pswConfirm = document.getElementById('pswConfirm').value.trim();
	if (password != "" && pswConfirm != "") {
		if(password != pswConfirm) {
			alert('Password does not match');
			return false;
		}
		return true;
	} else {
		alert('Enter a password and retype it to confirm');
		return false;
	}
	
}

//validates pasword with retype password in edit page
var pswEditValidate = function(){
	var password = document.getElementById('password').value.trim();
	var pswConfirm = document.getElementById('pswConfirm').value.trim();
	if (password != "" && pswConfirm != "") {	
		if(password != pswConfirm) {
			alert('Password does not match');
			return false;
		}
		return true;
	} 	
}

