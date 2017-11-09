
//--------------- Event listners BEGIN -------------------------------------------------------------------------------------------------


//event listner for username search
document.getElementById('user').onkeyup = function() {searchByUsername();}

//event listner for username search
document.getElementById('keyword').onkeyup = function() {searchByUsername();}


//--------------- Event listners END -------------------------------------------------------------------------------------------------


//returns the search result for search messages by username
var searchByUsername = function() {
	var uname = document.getElementById('user').value;
	var keyword = document.getElementById('keyword').value;

	document.getElementById('results').innerHTML = '';
	if (uname.trim() != '' || keyword.trim() != '') {
		sendRequestToServerPost('http://' + url_http+'/msg/searchPost', 'uname='+uname+'&keyword='+keyword, function(res){
			obj = JSON.parse(res);
			
			//my id is read in php script inline script
			for(var i=0; i < obj.length ; ++i) {
				document.getElementById('results').innerHTML += '<div>'+ obj[i] + '</div>';
			}
		});
	}
}