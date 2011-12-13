var xmlhttp;
function HTTPGet(url)
{
xmlhttp=null;
if (window.XMLHttpRequest)
  {// code for Firefox, Opera, IE7, etc.
  xmlhttp=new XMLHttpRequest();
  }
else if (window.ActiveXObject)
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
if (xmlhttp!=null)
  {
  xmlhttp.onreadystatechange=state_Change;
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
  }
else
  {
  document.write("Your browser does not support the chat.");
  }
}

function state_Change()
{
if (xmlhttp.readyState==4)
  {// 4 = "loaded"
  if (xmlhttp.status==200)
    {// 200 = "OK"
    document.getElementById("get").innerHTML+=xmlhttp.responseText;
     if(xmlhttp.responseText!='') {
window.scrollBy(0,50);
}
    }
  else
    {
    document.write("Problem retrieving data");
    }
  }
}

var xmlHttp=null;

function query(str)
{
if (str.length==0)
  { 
  document.getElementById("txtHint").innerHTML="";
  return;
  }
try
  {// Firefox, Opera 8.0+, Safari, IE7
  xmlHttp=new XMLHttpRequest();
  }
catch(e)
  {// Old IE
  try
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  catch(e)
    {
    return;  
    }
  }

var url="gethint.asp?q=" + str;
url=url+"&sid="+Math.random();
xmlHttp.open("GET",url,false);
xmlHttp.send(null);
document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
}

function toggleIM(url)
{
xmlhttp=null;
if (window.XMLHttpRequest)
  {// code for Firefox, Opera, IE7, etc.
  xmlhttp=new XMLHttpRequest();
  }
else if (window.ActiveXObject)
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
if (xmlhttp!=null)
  {
  xmlhttp.onreadystatechange=state_Changea;
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
  }
else
  {
  }
}

function state_Changea()
{
if (xmlhttp.readyState==4)
  {// 4 = "loaded"
  if (xmlhttp.status==200)
    {// 200 = "OK"
    document.getElementById('toggleIM').innerHTML=xmlhttp.responseText;
    }
  else
    {
    }
  }
}


function getmsg(tid,fid) {
	HTTPGet('msg_queue.php?get=to&fid='+fid);
	HTTPGet('msg_queue.php?get=from&fid='+fid);
	var m=setTimeout("getmsg("+tid+","+fid+")",400)
}

function sendmsg(id,msg) {
	HTTPGet('msg_queue.php?send&tid='+id+'&msg='+msg);
	document.im.box.value='';
	return false;
}

function getallmsg() {
	toggleIM('msg_queue.php?getall');
	if(document.getElementById("toggleIM").innerHTML!='' && open!=document.getElementById("toggleIM").innerHTML) {
		popup(document.getElementById("toggleIM").innerHTML);
		document.getElementById("toggleIM").innerHTML='';
	}
	var a=setTimeout("getallmsg()",400);
}


function popup(id) {

eval("page" + id + " = window.open('player.php?pid='+id, 'Chat', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=360,height=320');");
}

//<input type="text" id="txt1" onkeyup="query(this.value)">
//<div id="txtHint"></div />