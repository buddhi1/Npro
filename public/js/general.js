var scroll = false; //checks whether the chat box is being scrolled
var limit = 0;		//loaded message bulk number
var crt; 			//time statmp of lasted loaded message
var loadCount = 0;	//number of times messages being loaded
var pid = 0;			//current chat partner 
var loadCapacity = 10;	//# of messages loaded as history

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
	//loadMessages();
	loadUsers();
};

//add key word button click
document.getElementById('addKeyWord').onclick = function() {addKeyWord();};


//add key word button
var addKeyWord = function() {
	var kWord = window.getSelection().toString();
	var mid = 126;
	
	sendRequestToServerPost('http://' + url_http+'/keywords/save', 'mid='+mid+'&kWord='+kWord,function(res){

	});

}


//ajax message listner
var loadNewMessages = function() {
	
	sendRequestToServerPost('http://' + url_http+'/msg/newMsg', 'pid='+pid+'&crat='+crt,function(res){
		obj = JSON.parse(res);
		//my id is read in php script inline script
		if(obj.length > 0) {
			crt = obj[0].created_at;	//time stamp of last loaded message
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

//message box scroll event
document.getElementById('msgs-box').onscroll = function() {
	var x=document.getElementById('msgs-box');
	//console.log(x.scrollHeight +'****'+x.scrollTop+'****'+x.offsetHeight);
	if (x.scrollTop + x.offsetHeight < x.scrollHeight) {
		scroll = true;
	} else {
		scroll = false;
	}
	if (x.scrollTop < 1 && pid != 0) {	//load old messages when scrolled top and a conversation is selected
		loadMessages();
	}
}

//message type event
document.getElementById('msg').onkeypress = function(e) {

	//sending message once enter is pressed
	if (e.keyCode == 13) {
		sendMessage();
	}
}

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
			document.getElementById('users-box').innerHTML +='<div class="prof-box" id="prof-box"><div class="send-prof"></div><div class="user-name">'+obj[i].email+'</div><div class="hide" id="partnerId">'+obj[i].id+'</div></div>';
			
		}

		//adding on click event to all the created divs
		var elements = document.querySelectorAll("#prof-box");
		for (var i = 0; i < elements.length; i++) {
		  	elements[i].addEventListener("click", function(e) {
		  		loadCount = 0;
		  		limit = 0;
		    	selectConversation(e);
		    	document.getElementById('msg').disabled = false;
		    	document.getElementById('msg').focus();
			});
		}
	});
}

//send message to db
var sendMessage = function() {
	var message = document.getElementById('msg').value;
	document.getElementById('msg').value = '';
	if (message != '') {
		sendRequestToServerPost('http://' + url_http+'/msg/save', 'pid='+pid+'&msg='+message,function(res){
			// obj = JSON.parse(res);
			// crt = obj.created_at;
		});
		loadNewMessages();
		//document.getElementById('msgs-box').innerHTML += '<div class="msg-bg-box"><div class="send-msg-box"><div class="my-prof"></div><div class="msg">'+ message +'</div></div></div>';
		autoScrollBottom('msgs-box');
	}
}

//load all messages
var loadMessages = function() {
	sendRequestToServerPost('http://' + url_http+'/msg/allMsg', 'pid='+pid+'&limit='+limit,function(res){
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
		
		limit += loadCapacity;
		loadCount++;
	});
	
}

//scroll to bottom
var autoScrollBottom = function(id) {
	
	var x=document.getElementById(id);
	x.scrollTo(0, x.scrollHeight);
}

//selecting chat partner
var selectConversation = function(e) {
	pid = e.path[1].childNodes[2].innerText;	//reading the id of the clicked elemnt
	limit = 0;
	
	document.getElementById('msgs-box').innerHTML = '';
	sendRequestToServerPost('http://' + url_http+'/msg/allMsg', 'pid='+pid+'&limit='+limit,function(res){
		obj = JSON.parse(res);
		crt = obj[0].created_at;
		//my id is read in php script inline script
		document.getElementById('msgs-box').innerHTML = ' ';
		for (var i = obj.length - 1; 0 <= i; i--) {
			if (obj[i].seId == myId) {
				document.getElementById('msgs-box').innerHTML += '<div class="msg-bg-box"><div class="send-msg-box"><div class="my-prof"></div><div class="msg">'+ obj[i].text +'</div></div></div>';
			} else {
				document.getElementById('msgs-box').innerHTML +='<div class="msg-bg-box"><div class="rec-msg-box"><div class="send-prof"></div><div class="msg">'+ obj[i].text +'</div></div></div>';
			}
		}
		autoScrollBottom('msgs-box');	//scroll down to latest message	
		//listing to messages 
		var myVar = setInterval(loadNewMessages ,1000);
	});	
	limit += loadCapacity;
	loadCount++;				//chat load count
	
}
