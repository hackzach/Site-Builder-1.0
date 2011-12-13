<?php
require "facebook.php";

define('FACEBOOK_APP_ID', '177894922232847');
define('FACEBOOK_SECRET', '6e987ae3f1172c066b7f67f631c5e01c');
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
 
  echo "Hi " . $response['registration']['name'] . "! Your birthday is " . $response['registration']['birthday']; //access JSON queries in this manner. 
  echo '<pre>';
  //print_r($response);
  echo '</pre>';

  if(isset($_REQUEST['code'])) {
  $token = file_get_contents("https://graph.facebook.com/oauth/access_token?
    client_id=177894922232847&
    redirect_uri=http://wavelength.host56.com/facebook/create.php&
    client_secret=6e987ae3f1172c066b7f67f631c5e01c&
    code=" . $_REQUEST['code']);
  }

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
<div id="fb-root"></div>
<div id="welcomeMsg"></div>
<div id="friends"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
 <script>
  window.fbAsyncInit = function() {
    FB.init({appId  : '177894922232847', status : true, cookie : true, xfbml : true });
	
    FB.getLoginStatus(function(response) {
      if (response.session) {
      } else {
        alert('Who are you?');
      }
    });	

  
};
  
   function populateFriendList(session) {
   var outstring = '<p>Hello, <fb:name uid="' + session['uid'] +'" useyou="false" />!</p>';
   document.getElementById('welcomeMsg').innerHTML = outstring; 
   FB.XFBML.parse(document.getElementById('welcomeMsg'));

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
 
  function clearFriendList() {

   document.getElementById('friends').innerHTML 
	  = 'Please logon to your facebook account before seeing your friends list.'; 
 };
  
   FB.Event.subscribe('auth.login', function(response) {
     populateFriendList(response.session);
   });

   FB.Event.subscribe('auth.logout', function(response) {
     clearFriendList(); 
   });

</script>
</html />
