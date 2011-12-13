<?php
define("image", "true");
include "site_include.php";
$pid = addslashes($_GET['pid']);

$result = q("SELECT image,isprivate FROM images WHERE id='$pid'");
if (dbcount($result)) $image = dbarray($result);

if($image['isprivate'] == 1) {
	die("Image is private");
}

if($pid == "default.gif") {
	$imager = "default.gif";
}
else {
	$imager = $image['image'];
}

$filetype = substr($imager,strlen($imager)-4,4);
$filetype = strtolower($filetype);
ob_start();
if($filetype == ".gif") { 
    header("Content-type: image/gif");
} 
if($filetype == ".jpg") { 
    header("Content-type: image/jpeg");
}
if($filetype == ".png") { 
    header("Content-type: image/png");
}
ob_end_flush();
$ipath = getcwd() . "/images/" . $imager;
echo read($ipath, 'rb');

?> 