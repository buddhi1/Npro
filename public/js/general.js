var scroll = false; //checks whether the chat box is being scrolled
var limit = 0		//loaded message bulk number
var crt; 			//time statmp of lasted loaded message
var loadCount = 0	//number of times messages being loaded

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
	//listing to messages 
	var myVar = setInterval(loadNewMessages ,10000);

};


//ajax message listner
var loadNewMessages = function() {
	
	sendRequestToServerPost('http://' + url_http+'/msg/newMsg', 'limit='+limit+'&crat='+crt,function(res){
		obj = JSON.parse(res);
		//my id is read in php script inline script
		if(obj.length > 0) {
			crt = obj[obj.length - 1].created_at;	//time stamp of last loaded message
			for (var i = obj.length - 1; 0 <= i; i--) {
				if (obj[i].seId == myId) {
					document.getElementById('msgs-box').innerHTML += '<div class="msg-bg-box"><div class="send-msg-box"><div class="my-prof"></div><div class="msg">'+ obj[i].text +'</div></div></div>';
				} else {
					document.getElementById('msgs-box').innerHTML +='<div class="msg-bg-box"><div class="rec-msg-box"><div class="send-prof"></div><div class="msg">'+ obj[i].text +'</div></div></div>';
				}
			}
			if (!scroll) {
				autoScrollBottom('msgs-box');			
			}
		}

		
	});
}

document.getElementById('msgs-box').onscroll = function() {
	var x=document.getElementById('msgs-box');

	if (x.scrollTop < x.scrollHeight) {
		scroll = true;
	}
	if (x.scrollTop < 1) {
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
			document.getElementById('users-box').innerHTML +='<div class="prof-box" id="prof-box"><div class="send-prof"></div><div class="user-name">'+obj[i].email+'</div></div>';
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
		//my id is read in php script inline script
		var temp;
		
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
			document.getElementById('msgs-box').innerHTML = document.getElementById('msgs-box').innerHTML + temp;
		}
		if (!scroll) {
			autoScrollBottom('msgs-box');			
		}
		
		limit += 10;
		if (loadCount == 0) {
			crt = obj[obj.length - 1].created_at;
		}
		loadCount++;
	});
	
}

//scroll to bottom
var autoScrollBottom = function(id) {
	
	var x=document.getElementById(id);
	x.scrollTo(0, x.scrollHeight);
}

//selecting chat partner
document.getElementById('prof-box').onclick = function() {
	alert('hi');
}