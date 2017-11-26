
//--------------- Event listners BEGIN -------------------------------------------------------------------------------------------------


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
		sendRequestToServerPost('http://' + url_http+'/msg/searchPost', 'uname='+uname+'&keyword='+keyword, function(res){
			obj = JSON.parse(res);
			//my id is read in php script inline script
			for(var i=0; i < obj.length ; ++i) {
				document.getElementById('results').innerHTML += '<div id="msg-his" class="msg-his">'+ obj[i].text + '<div class="hide" id="mId">'+obj[i].id+'</div><span class="crtd" id="crtd">'+obj[i].created_at+'</span></div>';
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