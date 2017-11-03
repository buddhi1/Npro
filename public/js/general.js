var scroll = false; //checks whether the chat box is being scrolled
var limit = 0		//loaded message bulk number

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

//Ajax calls
//load on window open
window.onload = function() {	
	loadMessages();
	loadUsers();
};

document.getElementById('msgs-box').onscroll = function() {
	var x=document.getElementById('msgs-box');

	if (x.scrollTop < x.scrollHeight) {
		scroll = true;
	}
	if (x.scrollTop == 0) {
		loadMessages();
	}
}

//send message
document.getElementById('send').onclick = function() {sendMessage()};

//ajx xml request
var sendRequestToServerPost = function(url, variables, callback){
	
	var var_string = JSON.stringify(variables);
    var request_url = variables;

	var xmlHttp = new XMLHttpRequest(); 
    xmlHttp.onreadystatechange = function(){

        if (xmlHttp.readyState==4 && xmlHttp.status==200){
            callback(xmlHttp.responseText);
        }
    };
    xmlHttp.open( "POST", url, true );
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlHttp.send(request_url);
}

//requests all online users
var loadUsers = function() {
	sendRequestToServerPost('http://' + url_http+'/auth/onlineAll', '',function(res){
		obj = JSON.parse(res);
		// document.getElementById('users-box').innerHTML = '';
		for (var i = obj.length - 1; i >= 0; i--) {
			document.getElementById('users-box').innerHTML +='<div class="prof-box"><div class="send-prof"></div><div class="user-name">'+obj[i].email+'</div></div>';
		}
	});
}

//send message to db
var sendMessage = function() {
	var message = document.getElementById('msg').value;
	document.getElementById('msg').value = '';
	if (message != '') {
		sendRequestToServerPost('http://' + url_http+'/msg/save', 'msg='+message,function(res){
		});
		document.getElementById('msgs-box').innerHTML += '<div class="msg-bg-box"><div class="send-msg-box"><div class="my-prof"></div><div class="msg">'+ message +'</div></div></div>';
		autoScrollBottom('msgs-box');
	}
}

//load all messages
var loadMessages = function() {
	sendRequestToServerPost('http://' + url_http+'/msg/allMsg', 'limit='+limit,function(res){
		obj = JSON.parse(res);
		var myId = 4;
		var temp;
		console.log(limit);

		temp = document.getElementById('msgs-box').innerHTML;
		document.getElementById('msgs-box').innerHTML = '';

		for (var i = obj.length - 1; 0 <= i; i--) {
			if (obj[i].seId == myId) {
				document.getElementById('msgs-box').innerHTML += '<div class="msg-bg-box"><div class="send-msg-box"><div class="my-prof"></div><div class="msg">'+ obj[i].text +'</div></div></div>';
			} else {
				document.getElementById('msgs-box').innerHTML +='<div class="msg-bg-box"><div class="rec-msg-box"><div class="send-prof"></div><div class="msg">'+ obj[i].text +'</div></div></div>';
			}
		}
		if (limit != 0) {
			document.getElementById('msgs-box').innerHTML = document.getElementById('msgs-box').innerHTML+ 'oldd--merge neww' + temp;
		}
		if (!scroll) {
			autoScrollBottom('msgs-box');			
		}
		limit += 10;
	});
	
}

//scroll to bottom
var autoScrollBottom = function(id) {
	
	var x=document.getElementById(id);
	x.scrollTo(0, x.scrollHeight);
}