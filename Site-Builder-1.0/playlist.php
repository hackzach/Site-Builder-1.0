<?php 
include "connect.php";

$pid = $_GET['pid'];

/*This page needs to be updated with working friends.php code. We will use the same API for friends lists as playlists,
We can use a playlist table to hold the playlist id,title,data,permissions,friends,playcount

and then a music table with the id,filename,track,title,artist,album,date,permission,playcount

$result = q("SELECT * FROM playlists WHERE id='".$pid . "'");
if(dbcount($result)) $query = dbarray($result);
//This will select an array of the playlist table for the selected playlist id. 
	$query['data']; could hold a playlist of let's say:
	1.2.3.4.5.6.7.8.9.10
	
	We will use friends.php code to split that into an array of song ids and then
	in playlist.php
	
	
	for($i=0, $i < count($songs), $i++) {
	$result = q("SELECT * from music WHERE id='$songs[$i]");
	if(dbcount($result)) $query = dbarray($result);
	
	rattle off each song with the correct XML tags for a playlist with $query['stuff']
	
	}


*/

if(isset($pid)) {
header("Content-type: text/xml"); //Tell the player that this is an XML file
echo "
<rss version=\"2.0\" xmlns:jwplayer=\"http://developer.longtailvideo.com/\">
  <channel>
	<title>RWave Chicago</title>
";
	//query the db
	$result = q("SELECT * FROM playlists WHERE id='".$pid ."'"); //based on playlist id
	if(dbcount($result)) $query = dbarray($result);
	$songs = explode('.', $query['data']); //into an array
	$up = $query['playcount'] + 1;
	$result = q("UPDATE playlists SET playcount='$up' WHERE id='$pid'");
	
	//loop through array
	for($i=0; $i < count($songs); $i++) {
	$result = q("SELECT * from music WHERE id='$songs[$i]'");
	if(dbcount($result)) $query = dbarray($result);
		echo "
		<item>
			<title>" . $query['title'] . "</title>
			<jwplayer:author>" . $query['artist'] . "</jwplayer:author>
			<jwplayer:file>http://www.rwavechicago.com/music/".$query['filename'] . "</jwplayer:file />
		</item>";
	
	//rattle off each song with the correct XML tags for a playlist with $query['stuff']
	
	}

echo "
  </channel>
</rss>
";
}

?>
