hidden = true;
normal = true
function bgcolor(color) {
document.create.bgcolor.value=color;
document.getElementById('curcolor').style.backgroundColor=color;
}

function fontcolor(color) {
document.create.fontcolor.value=color;
document.getElementById('curcolor').style.color=color;
}

function advanced() {
	if(hidden == false) {
		document.getElementById('advanced').innerHTML='<input type="hidden" name="bgcolor" /><br /><input type="hidden" name="fontcolor" /><br />';
		hidden = true;
	}
	else {
		document.getElementById('advanced').innerHTML='<input type="text" name="bgcolor" value="bgcolor" /><br /><input type="text" name="fontcolor" value="fontcolor"/><br />';
		hidden = false;
	}
}

function fchange() {
	if(normal == false) {
		document.getElementById('totse').innerHTML='<small><a href="javascript:fchange();">Use email</a /></small /><br />Username: <input type="text" name="user" /><br />';
		normal = true;
	}
	else {
		document.getElementById('totse').innerHTML='<small><a href="javascript:fchange();">Use username</a /></small /><br />Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email" /><br />';
		normal = false;
	}
}
