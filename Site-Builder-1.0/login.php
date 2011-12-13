<?php
define("login", "true");
include "connect.php";
include "site_include.php";


$user = addslashes($_POST['user']);
$email = addslashes($_POST['email']);
$bg = "#696969";
$font = "#8FBC8F";

include "theme.php";

	if($id == "notConnected") {

	}
	else {
		$result = q("SELECT * FROM users WHERE id='".$id."'");
		if(dbcount($result)) {
			echo "<script>window.location='profile.php?id=$id'</script />";
		}
	}	

if(isset($cookie)) {
	//logged in From RWaveChicago.com
	$id = $cookie['uid'];
}
else {
	//not logged in From RWaveChicago.com
	$id = "572817251";
}

if(isset($_REQUEST['login'])) {
$result = q("SELECT * FROM users WHERE id='".$id."'");
	if(dbcount($result)) {
	header("Location: profile.php?id=" .$id);
	}

	/* Create new LOGIN script for Faqcebook UID to access table*/
		if(isset($_POST['remember'])) {
			$_session = md5(time());
			$result = q("UPDATE users SET session='".$_session."' WHERE id='".$auth['id']."'");
			setcookie('user', $auth['id'], 60 * 60 * 24 * 60 + time());
			setcookie('session', $_session, 60 * 60 * 24 * 60 + time());
		}
		else { 
			$session = md5(time());
			$result = q("UPDATE users SET session='".$_session."' WHERE id='".$auth['id']."'");
			setcookie('user', $auth['id'], 60 * 60 * 24 * 2 + time());
			setcookie('session', $_session, 60 * 60 * 24 * 2 + time());
		}

		echo "<script>window.location='profile.php'</script />";
		exit;
	}


else if(isset($_REQUEST['join'])) {

$response = parse_signed_request($_REQUEST['signed_request'], "sloppp");

$result = q("SELECT * FROM users WHERE id='" . $id . "'");
	if (dbcount($result)) echo "<script>window.location='profile.php'</script />";
		else {
	$result = q("INSERT INTO users (
	name,
	id,
	password,
	email,
	hide_email,
	location,
	birthdate,
	aim,
	theme_bgcolor,
	theme_fontcolor,
	profile,
	website,
	profile_pic,
	lastvisit,
	ip,
	friends,
	groups,
	level,
	status) 

VALUES(
	 '" . $response['registration']['name'] . "',
	 '" . $id . "',
	 '" . $password . "',
	 '" . $response['registration']['email'] . "',
	 '" . $hide_email . "',
	 '" . $response['registration']['location']['name'] . "',
	 '" . $response['registration']['birthday'] . "',
	 '" . $response['registration']['gender'] . "',
	 '" . $bgcolor . "',
	 '" . $fontcolor . "',
	 '" . $profile . "',
	 '" . $website . "',
	 '',
	 '" . time() . "',
	 '" . $_SERVER['REMOTE_ADDR'] . "',
	 '',
	 '',
	 '1',
	 '')
	");
	if($result == 0) {
		echo "Failure.\n<br />";
	}
	else {
		 echo "<script>window.location='profile.php'</script />";
	}
      }
}

else if(isset($_REQUEST['new'])) {


}

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
    <div id="fb-root"></div>
<script src="pass.js"></script />
<script src="color.js"></script />
<script src="http://connect.facebook.net/en_US/all.js"></script>

<table align="center">
<tr>
<td> 
<h1>Create an Account</h1 />
	   <script>
  window.fbAsyncInit = function() {
    FB.init({appId  : '177894922232847', status : true, cookie : true, xfbml : true });

};

function friends() {

   document.getElementById('friends').innerHTML = 'Searching .....'; 
	
   FB.api('/me/friends', { fields : 'id', offset : 0, limit : 25 }, function(response) {  
       var outstring = '<p>Friends:</p>';
       for (var i=0, l=response.data.length; i<l; i++) {
         var friend = response.data[i];
         outstring = outstring + '<fb:profile-pic uid="' + friend.id + '"  width="50" height="50" />' 
		                        + '<fb:name uid="' + friend.id + '" />&nbsp;&nbsp;&nbsp;'
       }
       document.getElementById('friends').innerHTML = outstring; 
       FB.XFBML.parse(document.getElementById('friends'));
   });	  

};
  
</script>
<center><fb:login-button><b>
If you already have an RWave account, simply sign on and click register.</b /></fb:login-button></center />
    <fb:registration
        fields="[
		{'name': 'name'}, 
		{'name': 'email'},
        {'name': 'location'},
			{'name' : 'gender'}, 
			{'name' : 'birthday'}, 
	{'name' : 'status' , 'description' : 'Player Title' , 'type' : 'text'},
 	{'name' : 'isprivate' , 'description' : 'Make Profile Private?' , 'type' : 'checkbox'}
]" redirect-uri="http://www.rwavechicago.com/login.php?join" >
    </fb:registration>
	<br />
</table />
<script>
 FB.Event.subscribe('auth.login', function(response) {
        window.location.reload();
      });
</script />
<?php 



function parse_signed_request($signed_request, $secret) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

  // decode the data
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true); 

  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  // check sig
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }

  return $data;
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}

include "foot.php";
?>