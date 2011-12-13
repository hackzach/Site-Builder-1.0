<playlist version="1">
<title>RWave Chicago</title>
<info>http://www.rwavechicago.com</info>
<tracklist>

<?php 
header("Content-type: text/xml"); //Tell the player that this is an XML file
define("image", "true");
include "site_include.php";

$pid = $_GET['pid'];

/*This page needs to be updated with working friends.php code. We will use the same API for friends lists as playlists,
We can use a playlist table to hold the playlist id,title,data,permissions,friends,playcount

and then a music table with the id,filename,track,title,artist,album,date,permission,playcount

$result = q("SELECT * FROM playlists WHERE id='" .$id.".".$pid . "'");
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





<track>
<title>Big Buck Bunny - PNG Image with start</title>
<creator>the Peach Open Movie Project</creator>
<info>http://www.bigbuckbunny.org/</info>

<annotation>
Big Buck Bunny is a short animated film by the Blender Institute, part of the Blender Foundation. Like the foundation's previous film Elephants Dream, the film is made using free and open source software.
</annotation>
<location>http://www.longtailvideo.com/jw/upload/bunny.png</location>
<meta rel="duration">20</meta>
<meta rel="start">10</meta>
</track>



*/

if(isset($pid)) {
	//query the db
	$result = q("SELECT * FROM playlists WHERE id='".$id.".".$pid ."'"); //based on playlist id
	if(dbcount($result)) $query = dbarray($result);
	$songs = explode('.', $query['data']); //into an array

	
	//loop through array
	for($i=0; $i < count($songs); $i++) {
	$result = q("SELECT * from music WHERE id='$songs[$i]'");
	if(dbcount($result)) $query = dbarray($result);
		echo "
		<track>
			<title>" . $query['title'] . "</title>
			<creator>" . $query['artist'] . "</creator>
			<location>http://www.rwavechicago.com/music/".$query['filename'] . "</location />
		</track>";
	
	//rattle off each song with the correct XML tags for a playlist with $query['stuff']
	
	}
}
echo "
</tracklist>
</playlist>
";

?>
