<?php

include "auth.php";


/* here are some auth functions
auth($id, "1"); //This checks if they are a regular.We should even if we don't need to cant fake usernames with cookies. 
auth($id, "2"); //This checks if they have admin. Allows viewing/editing profiles, pictures, and playlists 
auth($id, "3"); //Highest level a human can get. Allows """, viewing/editing messages, viewing/editing files(music)
auth($id, "4"); //                               Allows """, """, edit admins, table data
isprivate($id); //return true if a profile is private. 
*/


//are they logged in? did they not give a userid? Go to their profile then.

//bounce them back to the login page if not logged in and no userid

 
//update last visit
$result = q("UPDATE users SET lastvisit='" . time() . "' WHERE id='$id'");

	//-Get theme settings into an array-
	$result = q("SELECT * FROM users WHERE id='$id'");
	if (dbcount($result)) $profile = dbarray($result); ;
	//--------------------------------


	//-Variable defines for profile info-

	$bgcolor = $profile['theme_bgcolor'];
	$font = "Verdana";
	$fontcolor = $profile['theme_fontcolor'];
	$fontsize = $profile['theme_fontsize'];
	$status = $profile['status'];


function explodot($data) {
		$data = explode('.', $data); //explode 1.2.3 arc
		//into a new array
		for($i=0;$i<count($data);$i++) { 
		$new[$i] = $data[$i]; 
	}

		return $new;
}

function remove($string, $data) {
		if(!in_array($string, $data)) { //not already in string
			return false;
		}
		else {
		//--- Remove $string ---
		$key = array_keys($data, $string); //get the array key for the friend
		$data[$key[0]] = ""; //null that bitch
		$datas = null;
		for($i=0;$i<count($data);$i++) {
			if($data[$i] != NULL) {
				$datas .= $data[$i] . "."; //put all the friends into a new list
			}
		}
		$len = strlen($datas); //get length of final product
		$datas = substr($datas, 0, $len-1); //get rid of the stray '.' in the list
		// ---  end  ---

		return $datas;
		}

}

function add($string,$position, $data) {

		$key = array_keys($data, $string); //get the array key for the friend
		if($key=null) {
		}

		$datas = null;
		for($i=0;$i<count($data);$i++) {
			if($data[$i] != NULL) {
				$datas .= $data[$i] . "."; //put all the friends into a new list
			}
			if($i == $position) {
				$datas .= $data[$i] . "."; //put all the friends into a new list
				$datas .= $string . "."; //put all the friends into a new list
			}
		}
		$len = strlen($datas); //get length of final product
		$datas = substr($datas, 0, $len-1); //get rid of the stray '.' in the list
		// ---  end  ---

		return $datas;


}


function moveUp($input,$index) {
      $new_array = $input;
     
       if((count($new_array)>$position) && ($iposition>0)){
                 array_splice($new_array, $position-1, 0, $input[$position]);
                 array_splice($new_array, $position+1, 1);
             }

       return $new_array;
}

function moveDown($input,$position) {
       $new_array = $input;
        
       if(count($new_array)>$position) {
                 array_splice($new_array, $position+2, 0, $input[$position]);
                 array_splice($new_array, $position, 1);
             }
  
       return $new_array;
 }  

function getplaylist($id, $pid) {
		$result = q("SELECT * FROM playlists WHERE id='$pid' AND owner='$id'"); //only if we own the playlist.
		
			if(dbcount($result)) {
			$data = dbarray($result); //into an array
			return $data['data'];
			}
			else {
			return false;
			}
}

function makenav($id,$logoutUrl) {
	//auth($id, "1"); //
	if(!defined("login")) {
		//Get messages for user
		$result = q("SELECT * FROM messages WHERE tid='$id'");
		$count = dbcount($result);
		//---------------------

		if($count > 0) {
			$nm = "messages<b>(" . $count . ")</b />";
		}
		else {
			$nm = "messages";
		}
		echo "
		<img src=\"https://graph.facebook.com/".$id."/picture\" width=\"120\" height=\"120\"> Hi, <fb:name uid=\"$id\" useyou=\"false\" linked=\"false\"></fb:name>
		<center>\n
			<a href=\"profile.php\">Profile</a />\n
			<small> 
			<a href=\"profile.php?id=" . $id . "&edit\"> edit</a />
			</small /> \n
			<a href=\"friends.php\">friends</a />\n
			<a href=\"artists.php\">artists</a />\n
			<a href=\"msgs.php\">" .$nm . "</a />\n
			<a href=\"search.php\">search</a />\n
		";

		//make new array for function
		$result = q("SELECT * FROM users WHERE id='$id'");
		if (dbcount($result)) $info = dbarray($result); 
		//---------------------------

		if($info['level'] == '2' || $info['level'] == '3' || $info['level'] == '4') {
			echo " 	<a href=\"admin.php\">admin</a />\n";
		}
		echo "<a href=\"logout.php\">logout</a />\n
		</center />
		<br />\n
		<br />\n";
	}
}

function listmsgs($id) { //cleanup this, get the data out into array returns
	//auth($id, "1"); //we should always auth even if we don't need to, that way you cant fake usernames with cookies. 
	$id = addslashes($id);
	//Get messages for user
	$result = q("SELECT * FROM messages WHERE tid='$id'");
	//---------------------
	//echo "<table align='right'>\n";
	if(dbcount($result)) $raw = dbarray($result);
			return $raw;
}

function outbox($id) { //cleanup this function, bring messages out into an array
	//auth($id, "1"); //we should always auth even if we don't need to, that way you cant fake usernames with cookies. 
	$id = addslashes($id);
	//Get messages for user
	$result = q("SELECT * FROM messages WHERE fid='$id'");
	//---------------------

		while ($row=dbrows($result)) {
			if($row['type'] != '1') {
				echo "
				<tr>\n
				<a href=\"profile.php?id=" . $row['tid'] . "\" />" . lookup($row['tid']) . "</a /> \n
				<small /><a href=\"msgs.php?delete&mid=" . $row['id'] . "\" />delete</a />\n
				<a href=\"msgs.php?edit&mid=" . $row['id'] . "\" />edit</a /></small />\n
				<br />\n
				</tr />\n
				\n";
			}
		}
}

function getmsg($id) {
	//auth($id, "1"); //we should always auth even if we don't need to, that way you cant fake usernames with cookies. 
	$id = addslashes($id);

	//Get messages for user
	$result = q("SELECT * FROM messages WHERE id='$id'");
	if(dbcount($result)) $msg = dbarray($result);
	//---------------------
	$tid = $msg['tid'];
	$fid = $msg['fid'];
	//get session
	$result = q("SELECT session FROM users WHERE id='$tid'");
	if ($result) $profile = dbarray($result); 
	//-----------

}

function editmsg($id, $tid, $fid, $msg, $type="4") {
	//auth($id, "1"); //we should always auth even if we don't need to, that way you cant fake usernames with cookies. 
	$id = addslashes($id);
	$tid = addslashes($tid);
	$fid = addslashes($fid);
	$msg = addslashes($msg);
	$type = addslashes($type);

	//get session
	$result = q("SELECT session FROM users WHERE id='$fid'");

	if ($result) {
	//-----------
		$result = q("UPDATE messages SET 

 		tid='$tid',
 		fid='$fid',
 		msg='$msg',
 		type='$type'

		WHERE id='$id'");
		}
}


function delmsg($id) {
	//auth($id, "2"); //we should always auth even if we don't need to, that way you cant fake usernames with cookies. 
	$id = addslashes($id);

	//Get messages for user
	$result = q("SELECT tid,fid FROM messages WHERE id='$id'");
	if(dbcount($result)) {
		$result = q("DELETE FROM messages WHERE id='$id'");

		}

}


function sendmsg($tid, $fid, $msg, $type="4") {
	//auth($id, "1"); //we should always auth even if we don't need to, that way you cant fake usernames with cookies. 
	$result = q("SELECT * FROM messages");
	$id = dbcount($result) + 1;
	$tid = addslashes($tid);
	$fid = addslashes($fid);
	$msg = addslashes($msg);
	$type = addslashes($type);

	$result = q("INSERT INTO messages ( id,tid,fid,msg,type ) VALUES ('$id','$tid','$fid','$msg','$type')
	");
}

function makeplaylist($id,$pid) {

	//make new array for function
	if($pid == "") {
	$result = q("SELECT * FROM playlists WHERE owner='$id'"); 
	}
	else if(isset($pid)) {
	$result = q("SELECT * FROM playlists WHERE id='$pid'"); 
	}
	else if(isset($you)) {
	$result = q("SELECT * FROM playlists WHERE owner='$you'");
	}
	else {
	$result = q("SELECT * FROM playlists WHERE id='$pid' AND owner='$id'");
	//---------------------------
	}
		if(dbcount($result)) {

		while($row = dbrows($result)) {
			echo "<a href=\"javascript:popup('".$row['id']."');\">" .$row['title']. "</a /><br />";
			}
		}
if($pid == "") {
echo "<br><br><div id=\"fb-root\"></div><center>
	<script src=\"http://connect.facebook.net/en_US/all.js#appId=177894922232847&amp;xfbml=1\"></script>
	<fb:comments xid=\"$id\" numposts=\"10\" width=\"425\" publish_feed=\"true\"></fb:comments></center>";
}
else {
echo "<br><br><div id=\"fb-root\"></div><center>
	<script src=\"http://connect.facebook.net/en_US/all.js#appId=177894922232847&amp;xfbml=1\"></script>
	<fb:comments xid=\"$pid\" numposts=\"10\" width=\"425\" publish_feed=\"true\"></fb:comments></center>";
}

}

function lookup($id, $type='name') { //not sure what we will use this for yet but still want, admin.php references this

	$id = addslashes($id);

	//make new array for function
	$result = q("SELECT * FROM users WHERE id='$id'");
	if (dbcount($result)) $info = dbarray($result); 
	//---------------------------

	if($info['level'] == "4" && $type == "name") {
		$return = "System";
	}
	
	else {
		$return = $info[$type];
	}

	return $return;

}

function friendselector($id) { //make option values of friends. may be deprecated by Facebook API

	//make new array for function
	$result = q("SELECT friends FROM users WHERE id='$id'");
	if (dbcount($result)) $info = dbarray($result); 
	//---------------------------

	$friends = explode('.',$info['friends']);

	for($i=0;$i<count($friends);$i++) {

	//make new array for function
	$result = q("SELECT * FROM users WHERE id='$friends[$i]'");
	//echo "SELECT * FROM users WHERE id='$friends[$i]'";
	if (dbcount($result)) $info = dbarray($result); 
	//---------------------------

		$test .= "	<option value=\"" . $friends[$i] . "\">" . $info['name'] . "</option />\n";
	}

	return $test;
}

function friends($id) {

	//make new array for function
	$result = q("SELECT friends FROM users WHERE id='$id'");
	if (dbcount($result)) $info = dbarray($result); 
	//---------------------------

	$friends = explode('.',$info['friends']);

	for($i=0;$i<count($friends);$i++) { //can't return teh $friends array, so 
		$new[$i] = $friends[$i]; //we will move the contents to a temp new array
	}
	return $new;
}

function isonline($id) {
	//make new array for function
	$result = q("SELECT lastvisit FROM users WHERE id='$id'");
	if (dbcount($result)) $date = dbarray($result); 
	//---------------------------
	
	if($date['lastvisit']+5 > time()) {
		return true;
	} 
	else {
		return false;
	}
}

function isadmin($id) {

	$id = addslashes($id);

	//make new array for function
	$result = q("SELECT * FROM users WHERE id='$id'");
	if (dbcount($result)) $info = dbarray($result); 
	//---------------------------
	if($info['level'] > '2') {
		return true;
	}
	else {
		return false;
	}
}

function getlevel($level) {
	if($level == '1') {
		return "User";
	}
	else if($level == '2') {
		return "Artist";
	}
	else if($level == '3') {
		return "Admin";
	}
	else if($level == '4') {
		return "RWAVE";
	}
}

?>