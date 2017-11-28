var menu = false;

window.onresize = function() {
	menuHum();
}

window.onload = function() {
	menuHum();
}

var menuHum = function() {
	if (window.innerWidth < 1015) {
		document.getElementById('head').innerHTML = 'SMP';
		document.getElementById('ham').onclick = function() {
			if (!menu) {
				menu = true;
				document.getElementById('accordion').classList.add("menu-box-large");
				document.getElementById('ham').classList.add("ham-clicked");
				document.getElementById('ham').innerHTML = '<span class="glyphicon" >&#xe257;</span>';
			} else {
				menu = false;
				document.getElementById('accordion').classList.remove("menu-box-large");
				document.getElementById('ham').classList.remove("ham-clicked");
				document.getElementById('ham').innerHTML = '<span class="glyphicon" id="menu-ham">&#xe236;</span>';
			}
		}
	} else {
		document.getElementById('head').innerHTML = 'Secure Messeage Parsing (SMP)';
	}
}