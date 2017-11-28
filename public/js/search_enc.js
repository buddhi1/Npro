
//--------------- Event listners BEGIN -------------------------------------------------------------------------------------------------

//onload
window.onload = function() {
	searchMsg();
	document.getElementById('user').focus();
	menuHum();
}

//event listner for username search
document.getElementById('user').onkeyup = function() {searchMsg();}

//event listner for username search
document.getElementById('keyword').onkeyup = function() {searchMsg();}

//click event listner for add keyword button
document.getElementById('addKeyWord').onclick = function() {addKeyWord();};


//--------------- Event listners END -------------------------------------------------------------------------------------------------


//returns the search result for search messages by username
var searchMsg = function() {
	var uname = document.getElementById('user').value;
	var keyword = document.getElementById('keyword').value;

	document.getElementById('results').innerHTML = '';
	if (uname.trim() != '' || keyword.trim() != '') {
		sendRequestToServerPost('http://' + url_http+'/msg/searchPostEnc', 'uname='+uname+'&keyword='+keyword, function(res){
			obj = JSON.parse(res);
			//my id is read in php script inline script
			for(var i=0; i < obj.length ; ++i) {
				document.getElementById('results').innerHTML += '<div id="msg-his" class="msg-his">'+ obj[i].text + '<span class="crtd" id="crtd">'+obj[i].created_at+'</span><form class="inline-form" action="http://' + url_http+'/msg/decryptMsg" method="GET"><input class="hide" name="id" value="'+obj[i].id+'" /><button class="btn btn-warning" type-="submit">Decrypt</button></form><form class="inline-form" action="http://' + url_http+'/msg/delete" method="POST"><input class="hide" name="id" value="'+obj[i].id+'" /><button class="btn btn-danger" type-="submit">Delete</button></form></div>';
			}

			// // adding on click event to all the created divs
			// var elements = document.querySelectorAll("#msg-his");
			// for (var i = 0; i < elements.length; i++) {
			//   	elements[i].addEventListener("click", function(e) {
			//     	addKeyWord(e);
			// 	});
			// }
		});
	}
}

//add key word button
var addKeyWord = function(e) {
	// mid = e.path[0].childNodes[1].innerText;
	mid = window.getSelection().focusNode.nextSibling.innerText;	//mesage id of the highlighted message 
	
	var kWord = window.getSelection().toString();
	
	sendRequestToServerPost('http://' + url_http+'/keywords/save', 'mid='+mid+'&kWord='+kWord,function(res){

	});

}