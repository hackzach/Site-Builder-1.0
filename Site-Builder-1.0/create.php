<?php
require "facebook.php";

include "connect.php";
include "site_include.php";

define('FACEBOOK_APP_ID', 'blah');
define('FACEBOOK_SECRET', 'blah');
  /*
      * PHP SDK does not work due to libcurl not ssl compatible. A new domain should have this avail

      Redirect the user to https://graph.facebook.com/oauth/authorize with your client_id and the URL the user should be redirected back to after the authorization process (redirect_uri):

https://graph.facebook.com/oauth/authorize?
    client_id=...&
    redirect_uri=http://www.example.com/oauth_redirect

    * If the user authorizes your application, we redirect the user back to the redirect URI you specified with a verification string in the argument code, which can be exchanged for an OAuth access token. Exchange it for an access token by fetching https://graph.facebook.com/oauth/access_token. Pass the exact same redirect_uri as in the previous step:

https://graph.facebook.com/oauth/access_token?
    client_id=...&
    redirect_uri=http://www.example.com/oauth_redirect&
    client_secret=...&
    code=...

    * Use the access token returned by the request above to make requests on behalf of the user:

https://graph.facebook.com/me?access_token=...
*/
//$friends = $facebook->api('/me/friends');

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

 $response = parse_signed_request($_REQUEST['signed_request'], FACEBOOK_SECRET);
 
  //echo "Hi " . $response['registration']['name'] . "! Your birthday is " . $response['registration']['birthday']; //access JSON queries in this manner. 



if(isset($_POST['join'])) {$result = q("SELECT * FROM users WHERE email='" . $email . "'");
	if (dbcount($result) != 0) echo "Email already used.<br>\n";
		else {
	$result = q("INSERT INTO users (
	id,
	name,
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
	 '" . $id . "',
	 '" . $name . "',
	 '" . $password . "',
	 '" . $email . "',
	 '" . $hide_email . "',
	 '" . $location . "',
	 '" . $birthdate . "',
	 '" . $aim . "',
	 '" . $theme_bgcolor . "',
	 '" . $theme_fontcolor . "',
	 '" . $profile . "',
	 '" . $website . "',
	 'default.gif',
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
		header("Location: profile.php?id=" . $id);
	}
      }
}

include "foot.php";
	
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId   : '<?php echo $facebook->getAppId(); ?>',
          session : <?php echo json_encode($session); ?>, //
          status  : true, 
          cookie  : true, 
          xfbml   : true 
        });

        FB.Event.subscribe('auth.login', function() {
          window.location.reload();
        });
      };

      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>


<head>
<script src="pass.js"></script />
<script src="color.js"></script />
</head />
<body>
<table align="center">
<tr>
<td>
<h1>Create an Account</h1 />
<form name="create" method="post" onSubmit="return validate();" />
<iframe src="http://www.facebook.com/plugins/registration.php?
             client_id=113869198637480&
             redirect_uri=http%3A%2F%2Fdevelopers.facebook.com%2Ftools%2Fecho%2F&
             fields=name,birthday,gender,location,email"
        scrolling="auto"
        frameborder="no"
        style="border:none"
        allowTransparency="true"
        width="100%"
        height="330">
</iframe>

Make Profile private?<select name="profile">
<option value="1" selected>Yes</option />
<option value="0">No</option />
</select /><br />
<table border width="250" height="50">
<tr>
<td id="curcolor" name="curcolor" align="center">Current Colors</td />
<td><a href="javascript:advanced();">Show advanced</a>
<div id="advanced">
<input type="hidden" name="bgcolor" value="" /><br />
<input type="hidden" name="fontcolor" /><br />
</div>
</td />
</tr />
</table />
<br />
Website:<input type="text" name="website" /><br />
<input type="submit" name="join" value="Join" /><br />
</form>
</td />
<td>
<div id="colorb" style="">
Choose a Background color
<table border width="220" height="330">
<tr>
<td align="center" bgcolor="#FFFAFA" onclick="javascript:bgcolor('#FFFAFA');"></td />
<td align="center" bgcolor="#F8F8FF" onclick="javascript:bgcolor('#F8F8FF');"></td />
<td align="center" bgcolor="#F5F5F5" onclick="javascript:bgcolor('#F5F5F5');"></td />
<td align="center" bgcolor="#DCDCDC" onclick="javascript:bgcolor('#DCDCDC');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFFAF0" onclick="javascript:bgcolor('#FFFAF0');"></td />
<td align="center" bgcolor="#FDF5E6" onclick="javascript:bgcolor('#FDF5E6');"></td />
<td align="center" bgcolor="#FAF0E6" onclick="javascript:bgcolor('#FAF0E6');"></td />
<td align="center" bgcolor="#FAEBD7" onclick="javascript:bgcolor('#FAEBD7');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFEFD5" onclick="javascript:bgcolor('#FFEFD5');"></td />
<td align="center" bgcolor="#FFEBCD" onclick="javascript:bgcolor('#FFEBCD');"></td />
<td align="center" bgcolor="#FFE4C4" onclick="javascript:bgcolor('#FFE4C4');"></td />
<td align="center" bgcolor="#FFDAB9" onclick="javascript:bgcolor('#FFDAB9');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFDEAD" onclick="javascript:bgcolor('#FFDEAD');"></td />
<td align="center" bgcolor="#FFE4B5" onclick="javascript:bgcolor('#FFE4B5');"></td />
<td align="center" bgcolor="#FFF8DC" onclick="javascript:bgcolor('#FFF8DC');"></td />
<td align="center" bgcolor="#FFFFF0" onclick="javascript:bgcolor('#FFFFF0');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFFACD" onclick="javascript:bgcolor('#FFFACD');"></td />
<td align="center" bgcolor="#FFF5EE" onclick="javascript:bgcolor('#FFF5EE');"></td />
<td align="center" bgcolor="#F0FFF0" onclick="javascript:bgcolor('#F0FFF0');"></td />
<td align="center" bgcolor="#F5FFFA" onclick="javascript:bgcolor('#F5FFFA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#F0FFFF" onclick="javascript:bgcolor('#F0FFFF');"></td />
<td align="center" bgcolor="#F0F8FF" onclick="javascript:bgcolor('#F0F8FF');"></td />
<td align="center" bgcolor="#E6E6FA" onclick="javascript:bgcolor('#E6E6FA');"></td />
<td align="center" bgcolor="#FFF0F5" onclick="javascript:bgcolor('#FFF0F5');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFE4E1" onclick="javascript:bgcolor('#FFE4E1');"></td />
<td align="center" bgcolor="#FFFFFF" onclick="javascript:bgcolor('#FFFFFF');"></td />
<td align="center" bgcolor="#000000" onclick="javascript:bgcolor('#000000');"></td />
<td align="center" bgcolor="#2F4F4F" onclick="javascript:bgcolor('#2F4F4F');"></td />
</tr />
<tr>
<td align="center" bgcolor="#696969" onclick="javascript:bgcolor('#696969');"></td />
<td align="center" bgcolor="#708090" onclick="javascript:bgcolor('#708090');"></td />
<td align="center" bgcolor="#778899" onclick="javascript:bgcolor('#778899');"></td />
<td align="center" bgcolor="#BEBEBE" onclick="javascript:bgcolor('#BEBEBE');"></td />
</tr />
<tr>
<td align="center" bgcolor="#D3D3D3" onclick="javascript:bgcolor('#D3D3D3');"></td />
<td align="center" bgcolor="#191970" onclick="javascript:bgcolor('#191970');"></td />
<td align="center" bgcolor="#000080" onclick="javascript:bgcolor('#000080');"></td />
<td align="center" bgcolor="#222222" onclick="javascript:bgcolor('#222222');"></td />
</tr />
<tr>
<td align="center" bgcolor="#6495ED" onclick="javascript:bgcolor('#6495ED');"></td />
<td align="center" bgcolor="#483D8B" onclick="javascript:bgcolor('#483D8B');"></td />
<td align="center" bgcolor="#6A5ACD" onclick="javascript:bgcolor('#6A5ACD');"></td />
<td align="center" bgcolor="#7B68EE" onclick="javascript:bgcolor('#7B68EE');"></td />
</tr />
<tr>
<td align="center" bgcolor="#8470FF" onclick="javascript:bgcolor('#8470FF');"></td />
<td align="center" bgcolor="#0000CD" onclick="javascript:bgcolor('#0000CD');"></td />
<td align="center" bgcolor="#4169E1" onclick="javascript:bgcolor('#4169E1');"></td />
<td align="center" bgcolor="#0000FF" onclick="javascript:bgcolor('#0000FF');"></td />
</tr />
<tr>
<td align="center" bgcolor="#1E90FF" onclick="javascript:bgcolor('#1E90FF');"></td />
<td align="center" bgcolor="#00BFFF" onclick="javascript:bgcolor('#00BFFF');"></td />
<td align="center" bgcolor="#87CEEB" onclick="javascript:bgcolor('#87CEEB');"></td />
<td align="center" bgcolor="#87CEFA" onclick="javascript:bgcolor('#87CEFA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#4682B4" onclick="javascript:bgcolor('#4682B4');"></td />
<td align="center" bgcolor="#B0C4DE" onclick="javascript:bgcolor('#B0C4DE');"></td />
<td align="center" bgcolor="#ADD8E6" onclick="javascript:bgcolor('#ADD8E6');"></td />
<td align="center" bgcolor="#B0E0E6" onclick="javascript:bgcolor('#B0E0E6');"></td />
</tr />
<tr>
<td align="center" bgcolor="#AFEEEE" onclick="javascript:bgcolor('#AFEEEE');"></td />
<td align="center" bgcolor="#00CED1" onclick="javascript:bgcolor('#00CED1');"></td />
<td align="center" bgcolor="#48D1CC" onclick="javascript:bgcolor('#48D1CC');"></td />
<td align="center" bgcolor="#40E0D0" onclick="javascript:bgcolor('#40E0D0');"></td />
</tr />
<tr>
<td align="center" bgcolor="#00FFFF" onclick="javascript:bgcolor('#00FFFF');"></td />
<td align="center" bgcolor="#E0FFFF" onclick="javascript:bgcolor('#E0FFFF');"></td />
<td align="center" bgcolor="#5F9EA0" onclick="javascript:bgcolor('#5F9EA0');"></td />
<td align="center" bgcolor="#66CDAA" onclick="javascript:bgcolor('#66CDAA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#7FFFD4" onclick="javascript:bgcolor('#7FFFD4');"></td />
<td align="center" bgcolor="#006400" onclick="javascript:bgcolor('#006400');"></td />

<td align="center" bgcolor="#556B2F" onclick="javascript:bgcolor('#556B2F');"></td />
<td align="center" bgcolor="#8FBC8F" onclick="javascript:bgcolor('#8FBC8F');"></td />
</tr /></tr />
</table />
</div>
</td />
<td>
<div id="colorf" style="">
Choose a Font color
<table border width="220" height="330">
<tr>
<td align="center" bgcolor="#FFFAFA" onclick="javascript:fontcolor('#FFFAFA');"></td />
<td align="center" bgcolor="#F8F8FF" onclick="javascript:fontcolor('#F8F8FF');"></td />
<td align="center" bgcolor="#F5F5F5" onclick="javascript:fontcolor('#F5F5F5');"></td />
<td align="center" bgcolor="#DCDCDC" onclick="javascript:fontcolor('#DCDCDC');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFFAF0" onclick="javascript:fontcolor('#FFFAF0');"></td />
<td align="center" bgcolor="#FDF5E6" onclick="javascript:fontcolor('#FDF5E6');"></td />
<td align="center" bgcolor="#FAF0E6" onclick="javascript:fontcolor('#FAF0E6');"></td />
<td align="center" bgcolor="#FAEBD7" onclick="javascript:fontcolor('#FAEBD7');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFEFD5" onclick="javascript:fontcolor('#FFEFD5');"></td />
<td align="center" bgcolor="#FFEBCD" onclick="javascript:fontcolor('#FFEBCD');"></td />
<td align="center" bgcolor="#FFE4C4" onclick="javascript:fontcolor('#FFE4C4');"></td />
<td align="center" bgcolor="#FFDAB9" onclick="javascript:fontcolor('#FFDAB9');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFDEAD" onclick="javascript:fontcolor('#FFDEAD');"></td />
<td align="center" bgcolor="#FFE4B5" onclick="javascript:fontcolor('#FFE4B5');"></td />
<td align="center" bgcolor="#FFF8DC" onclick="javascript:fontcolor('#FFF8DC');"></td />
<td align="center" bgcolor="#FFFFF0" onclick="javascript:fontcolor('#FFFFF0');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFFACD" onclick="javascript:fontcolor('#FFFACD');"></td />
<td align="center" bgcolor="#FFF5EE" onclick="javascript:fontcolor('#FFF5EE');"></td />
<td align="center" bgcolor="#F0FFF0" onclick="javascript:fontcolor('#F0FFF0');"></td />
<td align="center" bgcolor="#F5FFFA" onclick="javascript:fontcolor('#F5FFFA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#F0FFFF" onclick="javascript:fontcolor('#F0FFFF');"></td />
<td align="center" bgcolor="#F0F8FF" onclick="javascript:fontcolor('#F0F8FF');"></td />
<td align="center" bgcolor="#E6E6FA" onclick="javascript:fontcolor('#E6E6FA');"></td />
<td align="center" bgcolor="#FFF0F5" onclick="javascript:fontcolor('#FFF0F5');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFE4E1" onclick="javascript:fontcolor('#FFE4E1');"></td />
<td align="center" bgcolor="#FFFFFF" onclick="javascript:fontcolor('#FFFFFF');"></td />
<td align="center" bgcolor="#000000" onclick="javascript:fontcolor('#000000');"></td />
<td align="center" bgcolor="#2F4F4F" onclick="javascript:fontcolor('#2F4F4F');"></td />
</tr />
<tr>
<td align="center" bgcolor="#696969" onclick="javascript:fontcolor('#696969');"></td />
<td align="center" bgcolor="#708090" onclick="javascript:fontcolor('#708090');"></td />
<td align="center" bgcolor="#778899" onclick="javascript:fontcolor('#778899');"></td />
<td align="center" bgcolor="#BEBEBE" onclick="javascript:fontcolor('#BEBEBE');"></td />
</tr />
<tr>
<td align="center" bgcolor="#D3D3D3" onclick="javascript:fontcolor('#D3D3D3');"></td />
<td align="center" bgcolor="#191970" onclick="javascript:fontcolor('#191970');"></td />
<td align="center" bgcolor="#000080" onclick="javascript:fontcolor('#000080');"></td />
<td align="center" bgcolor="#000080" onclick="javascript:fontcolor('#000080');"></td />
</tr />
<tr>
<td align="center" bgcolor="#6495ED" onclick="javascript:fontcolor('#6495ED');"></td />
<td align="center" bgcolor="#483D8B" onclick="javascript:fontcolor('#483D8B');"></td />
<td align="center" bgcolor="#6A5ACD" onclick="javascript:fontcolor('#6A5ACD');"></td />
<td align="center" bgcolor="#7B68EE" onclick="javascript:fontcolor('#7B68EE');"></td />
</tr />
<tr>
<td align="center" bgcolor="#8470FF" onclick="javascript:fontcolor('#8470FF');"></td />
<td align="center" bgcolor="#0000CD" onclick="javascript:fontcolor('#0000CD');"></td />
<td align="center" bgcolor="#4169E1" onclick="javascript:fontcolor('#4169E1');"></td />
<td align="center" bgcolor="#0000FF" onclick="javascript:fontcolor('#0000FF');"></td />
</tr />
<tr>
<td align="center" bgcolor="#1E90FF" onclick="javascript:fontcolor('#1E90FF');"></td />
<td align="center" bgcolor="#00BFFF" onclick="javascript:fontcolor('#00BFFF');"></td />
<td align="center" bgcolor="#87CEEB" onclick="javascript:fontcolor('#87CEEB');"></td />
<td align="center" bgcolor="#87CEFA" onclick="javascript:fontcolor('#87CEFA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#4682B4" onclick="javascript:fontcolor('#4682B4');"></td />
<td align="center" bgcolor="#B0C4DE" onclick="javascript:fontcolor('#B0C4DE');"></td />
<td align="center" bgcolor="#ADD8E6" onclick="javascript:fontcolor('#ADD8E6');"></td />
<td align="center" bgcolor="#B0E0E6" onclick="javascript:fontcolor('#B0E0E6');"></td />
</tr />
<tr>
<td align="center" bgcolor="#AFEEEE" onclick="javascript:fontcolor('#AFEEEE');"></td />
<td align="center" bgcolor="#00CED1" onclick="javascript:fontcolor('#00CED1');"></td />
<td align="center" bgcolor="#48D1CC" onclick="javascript:fontcolor('#48D1CC');"></td />
<td align="center" bgcolor="#40E0D0" onclick="javascript:fontcolor('#40E0D0');"></td />
</tr />
<tr>
<td align="center" bgcolor="#00FFFF" onclick="javascript:fontcolor('#00FFFF');"></td />
<td align="center" bgcolor="#E0FFFF" onclick="javascript:fontcolor('#E0FFFF');"></td />
<td align="center" bgcolor="#5F9EA0" onclick="javascript:fontcolor('#5F9EA0');"></td />
<td align="center" bgcolor="#66CDAA" onclick="javascript:fontcolor('#66CDAA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#7FFFD4" onclick="javascript:fontcolor('#7FFFD4');"></td />
<td align="center" bgcolor="#006400" onclick="javascript:fontcolor('#006400');"></td />

<td align="center" bgcolor="#556B2F" onclick="javascript:fontcolor('#556B2F');"></td />
<td align="center" bgcolor="#8FBC8F" onclick="javascript:fontcolor('#8FBC8F');"></td />
</tr /></tr />
</table />
</div>
</td />
</tr />
</table />
</body />