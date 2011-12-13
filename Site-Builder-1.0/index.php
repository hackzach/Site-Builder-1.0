<?php
include "connect.php";
include "site_include.php";

if($id != "notConnected") {
$result = q("SELECT * FROM users WHERE id='$id'");
	if(dbcount($result)) {
	header("Location: profile.php?id=".$id);
	}
	else {
	//create a profile for them
	header("Location: login.php?new");
	}
}

else {

header("Location: profile.php?id=572817251");
}

include "foot.php";

?>