<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>

<?php //site_include.php must be included before theme.php, it relies on variables

$you = addslashes($_REQUEST['id']);
if(isset($you)) {
$result = q("SELECT status,theme_bgcolor,theme_fontcolor FROM users WHERE id='$you'");
}
else {
$result = q("SELECT status,theme_bgcolor,theme_fontcolor FROM users WHERE id='$id'");
}
if(dbcount($result)) $profile = dbarray($result);
$status = $profile['status'];
$fontcolor = $profile['theme_fontcolor'];
$bgcolor = $profile['theme_bgcolor'];

if(isset($bg) && isset($font)) {
$fontcolor = $font;
$bgcolor = $bg;
}

	echo "<head>\n
	<title>" . stripslashes($status) . "</title />\n
	<style type=\"text/css\">\n
	body,table {\n
		color: " . $fontcolor . ";\n
		font-family: " . $font . ";\n
		font-size: 12;\n
	}\n
	a {\n
		color: #0000FF;\n
	}\n
	a:visited {\n
		color: #DFDFDF;\n
	}\n
	a:hover {\n
		color:#FFDFDF;\n
	}\n
	</style>\n
	<script src=\"HTTPRequest.js\" /></script />\n
	</head>\n
	<body bgcolor=\"" . $bgcolor . "\">\n";

?>