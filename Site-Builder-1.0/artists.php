
<?php
define("Profile", "true");
include "connect.php";
include "site_include.php";
include "theme.php";
makenav($id, $logoutUrl);
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
	

  
};
</script>
<?php
$artist = $_REQUEST['artist'];
$pid = $_REQUEST['pid'];
echo "<b><fb;name uid=\"".$artist."\" ></fb:name></b>";
if(isset($pid)) {
$result = q("SELECT * FROM playlists WHERE id='".$pid."'"); //first add to our list
		if(dbcount($result)) $info = dbarray($result); 

$playlist = explode('.', $info['data']);

echo "<center><b><fb:name uid=\"$artist\" possessive=\"true\" useyou=\"true\"></fb:name></b><br><br>\n

".$info['title']."<br>Songs:<br>\n
</center>";

for($i=0;$i<count($playlist);$i++) {
$result = q("SELECT * FROM music WHERE id='$playlist[$i]'");
if(dbcount($result)) $info = dbarray($result);
echo $info['title'] . "<br />";
}

}

include "foot.php";
?> 
