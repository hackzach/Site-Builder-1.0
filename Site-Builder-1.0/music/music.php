<?php
define("theme", "true");
include "site_include.php";

$pid = addslashes($_GET['pid']);
/*This page needs to be updated with working friends.php code. We will use the same API for friends lists as playlists,
We can use a playlist table to hold the playlist id,title,data,permissions,friends,playcount

and then a music table with the id,filename,track,title,artist,album,date,permission,playcount

$result = q("SELECT * FROM playlists WHERE id='" . $pid . "'");
if(dbcount($result)) $query = dbarray($result);
//This will select an array of the playlist table for the selected playlist id. 
	$query['data']; could hold a playlist of let's say:
	1.2.3.4.5.6.7.8.9.10
	
	$songs = explode('.', $query['data']); //into an array
	
	We will use friends.php code to split that into an array of song ids and then
	in playlist.php
	
	
	for($i=0, $i < count($songs), $i++) {
	$result = q("SELECT * from music WHERE id='$songs[$i]");
	if(dbcount($result)) $query = dbarray($result);
	
	rattle off each song with the correct XML tags for a playlist with $query['stuff']
	
	}





*/


	if(isset($pid) && isset($_GET['play'])) {
	//make player HTML with playlist.php?pid=$pid
	auth($id, "1"); //This checks if they are a regular.We should even if we don't need to cant fake usernames with cookies. 
	//BTW do we want to only let users listen to music?
	echo "
	<!-- START OF THE PLAYER EMBEDDING TO COPY-PASTE -->
	<object id=\"player\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" name=\"player\" width=\"328\" height=\"200\"> 
		<param name=\"movie\" value=\"player.swf\" /> 
		<param name=\"allowfullscreen\" value=\"true\" /> 
		<param name=\"allowscriptaccess\" value=\"always\" /> 
		<param name=\"flashvars\" value=\"file=playlist.php?pid=" . $pid . "&image=preview.jpg\" /> 
		<embed 
			type=\"application/x-shockwave-flash\"
			id=\"player2\"
			name=\"player2\"
			src=\"player.swf\" 
			width=\"328\" 
			height=\"200\"
			allowscriptaccess=\"always\" 
			allowfullscreen=\"true\"
			flashvars=\"file=playlist.php?pid=" . $pid . "&image=preview.jpg\" 
		/> 
	</object> 
	<!-- END OF THE PLAYER EMBEDDING -->
	";
	
	
	}
	else if(isset($pid) && isset($_GET['edit'])) {
	//pid given, lets edit if its ours or die no auth
	auth($id, "2"); //This checks if tehy have admin. Allows viewing/editing profiles, pictures, and playlists 
	
	echo "Edit Playlist[[[TODO]]]";
	
	}
	
	else {
	//no playlist given, lets go to make a playlist then
	auth($id, "1"); //This checks if they are a regular.We should even if we don't need to cant fake usernames with cookies. 
	echo "Make Playlist[[[TODO]]]";
	
	
	
	
	
	
	
	}
	

	

include "foot.php";

?>