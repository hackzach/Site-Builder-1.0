<?php
define("notheme", "true");
include "site_include.php";
//unset("notheme");

//dynamic folders
$page = $_GET['page'];

if($page != '') {
	$page = addslashes($page);
	$result = q("SELECT * FROM users WHERE url='$page'");
	if(dbcount($result)) $info = dbarray($result);

	if($info['id'] == 0) {
		header("Location: 404.shtml");
	}
	else {
		$id = $info['id'];
		$fontcolor = $info['theme_fontcolor'];
		$bgcolor = $info['theme_bgcolor'];
		$fontsize = $info['theme_fontsize'];

		include "theme.php";

		include "auth.php";

		isprivate($id);
		makenav($id);
		makeprofile($id);
	}
}
else {
	header("Location: 404.shtml");
}
?>