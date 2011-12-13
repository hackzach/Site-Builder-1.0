
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
$remove = $_REQUEST['remove'];
$add = $_REQUEST['add'];
$move = $_REQUEST['move'];
$position = $_REQUEST['position'];
$songid = $_REQUEST['songid'];

if(isset($pid)) {
$result = q("SELECT * FROM playlists WHERE id='".$pid."'"); //first add to our list
		if(dbcount($result)) $info = dbarray($result); 

$playlist = explode('.', $info['data']);

echo "<center><b><fb:name uid=\"$artist\" possessive=\"true\" uselink=\"false\" useyou=\"true\"></fb:name> Playlist</b><br><br>\n

".$info['title']."<br>Songs:<br>\n
</center>";

	function updown($i, $songid, $pid) {

			return "&songid=$songid&pid=$pid&position=$i";
	}

	for($i=0;$i<count($playlist);$i++) {
		$seek = $playlist[$i];
		$key = array_keys($playlist, $seek); //get the array key for the friend


		$result = q("SELECT * FROM music WHERE id='$playlist[$i]'");
			if(dbcount($result)) $info = dbarray($result);
			echo $info['title'] . " <small><a href=\"playlists.php?remove&songid=$playlist[$i]&pid=$pid\">remove</a> ";
			$up = count($playlist)-$i;
			$up = count($playlist) - $up;
			$stop = count($playlist)+1;
			$down = count($playlist)-$i;

			$down = (count($playlist) - $down) +2;
			if($up != "0") {
				echo "<a href=\"playlists.php?move=up". updown($i, $playlist[$i], $pid) . "\">move up</a />";
			}
			if($down != $stop) {
				
				echo "<a href=\"playlists.php?move=down". updown($i, $playlist[$i], $pid) . "\">move down</a />";
			}
			
			echo "</small /><br />";

	}

}
if(isset($remove) && isset($songid) && isset($pid)) {
	//How to turn a playlist into an array
	$data = getplaylist($id, $pid); //1.2.3
	echo "<pre>";
	$data = explodot($data); //Array by the dot
	$loss = remove($songid, $data); //remove $songid from array
	echo $loss;
 	echo "</pre>";
	//$result = q("UPDATE playlists SET data='$loss' WHERE owner='$id' AND id='$pid'"); //save
}

else if(isset($add) && isset($songid) && isset($pid) && isset($position)) {
	//How to turn a playlist into an array
	$data = getplaylist($id, $pid); //1.2.3
	echo "<pre>";
	$data = explodot($data); //Array by the dot
	$loss = add($songid,$position, $data); //place $songid at $position
	echo $loss;
 	echo "</pre>";
	//$result = q("UPDATE playlists SET data='$loss' WHERE owner='$id' AND id='$pid'"); //save
}

else if(isset($move) && isset($songid) && isset($pid) && isset($position)) {
	//How to turn a playlist into an array
	$data = getplaylist($id, $pid); //1.2.3
	echo "<pre>";
	$data = explodot($data); //Array by the dot
	if($move == "up") {
		$loss = moveUp($position, $data); //place $songid at $position
	}
	else if($move == "down") {
		$loss = moveDown($position, $data); //place $songid at $position
	}
	echo $loss;
 	echo "</pre>";
	//$result = q("UPDATE playlists SET data='$loss' WHERE owner='$id' AND id='$pid'"); //save
}
include "foot.php";
?> 
