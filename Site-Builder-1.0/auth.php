<?php

	if($sfb == "notConnected") {
	//not logged in From Facebook.com
	$id = "notConnected";
	}
	else {
	//Logged in From Facebook.com
	$id = $sfb;
	}	

if(isset($cookie)) {
	//logged in From RWaveChicago.com
	$id = $cookie['uid'];
}
else {
	//not logged in From RWaveChicago.com
	$id = "";
}

function newHash($id, $fid) {
		$makhash = md5(sha1($id . time()));
		
		$result = q("SELECT * FROM fsession WHERE hash='$makhash'");
		if(!dbcount($result)) {
			$result = q("INSERT INTO fsession(id,f2,hash) VALUES('$id','$fid','$makhash')");
		}

}

function checkHash($id, $session) {

	$session = addslashes($session);
	
	$result = q("SELECT hash FROM fsession WHERE id='$id'");
	if(dbcount($result)) $info = dbarray($result);

	if($info['hash'] == $session ) { //session check function.
		return true;
	}
	else {
		return false;
	}
}


function auth($id, $level) {

		$result = q("SELECT session,level FROM users WHERE id='".$id."'");

		if (dbcount($result)) $auth = dbarray($result);
			//verify our session

			//the verify our id, will die to your profile if $id is not the same as your cookie.
			if($auth['level'] < $level) {
				exit("auth failure");
			}

}
/*
function check($id, $type) {

		$result = q("SELECT session,level FROM users WHERE id='".$id."'");

		if (dbcount($result)) $auth = dbarray($result);
				if($type == 'edit') {
					return "<a href=\"profile.php?id=" . $id . "&edit\"> edit</a />"; //
				}
				
			
	


}
*/
function isprivate($id) {
		$result = q("SELECT profile FROM users WHERE id='".$id."'");
		if (dbcount($result)) $auth = dbarray($result);

			if($auth['profile'] == 1) {
				//if profile is set to private
				return true;
			}
		else { // else
		return false;
		}
}


?>