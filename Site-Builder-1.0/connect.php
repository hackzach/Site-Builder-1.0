<?php
include "filefunc.php";

require "facebook.php";
include "cookie.php";

$mysql_host = "hostname";
$mysql_database = "dbname";
$mysql_user = "dbuser";
$mysql_password = "password";


	/*Connect to DB*/
	connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	/*-------------*/

//Facebook functions


// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => 'facebook app id',
  'secret' => 'facebook app secret',
  'cookie' => true,
));

// We may or may not have this data based on a $_GET or $_COOKIE based session.
//
// If we get a session here, it means we found a correctly signed session using
// the Application Secret only Facebook and the Application know. We dont know
// if it is still valid until we make an API call using the session. A session
// can become invalid if it has already expired (should not be getting the
// session back in this case) or if the user logged out of Facebook.
$session = $facebook->getSession();

$me = null;
// Session based API call.
if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}

// login or logout url will be needed depending on current user state.
if($me) {
	$sfb = $session['uid'];

} else {

	$sfb = "notConnected";
}

?>