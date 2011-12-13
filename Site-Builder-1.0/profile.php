<?php
include "connect.php"; //filefunc facebook
include "site_include.php";//cookie auth
include "theme.php";

// check to see if the profile is private first

$name = addslashes($_REQUEST['name']);
$email = addslashes($_REQEST['email']);
$isprivate = addslashes($_REQUEST['isprivate']);
$status = addslashes($_REQUEST['status']);
$pid = addslashes($_REQUEST['pid']);
$bgcolor = addslashes($_REQUEST['bgcolor']);
$fontcolor = addslashes($_REQUEST['fontcolor']);
$you = $_REQUEST['id'];
$pid = $_REQUEST['pid'];


if(isset($_REQUEST['save'])) {

	if(isset($name) && isset($email) && isset($isprivate) && isset($status) && isset($bgcolor) && isset($fontcolor)) {
	$result = q("UPDATE users SET 

	name='$name',
	email='$email',
	
 	profile='$isprivate',
	theme_bgcolor='$bgcolor',
	theme_fontcolor='$fontcolor',
 
 	status='$status'

	WHERE id='$id'");
	echo "<script>window.location='profile.php?id=$id&pid=$pid'</script>";
	}
}
else if(isset($_REQUEST['edit'])) {
?>
<html>
<head>
	   <script>
  window.fbAsyncInit = function() {
    FB.init({appId  : '177894922232847', status : true, cookie : true, xfbml : true });
      FB.Event.subscribe('auth.login', function(response) {
FB.Canvas.setAutoResize();
      });
	  FB.login(function(response) {
  if (response.session) {
  } else {
    // user cancelled login
  }
});
};

</script>
         <fb:registration
            fields="[{'name':'name'}, {'name':'email'},
            {'name':'location'},{'name' : 'gender'}, {'name' : 'birthday'}, {'name' : 'password' , 'description':'Password',
            'type':'text', 'view' : 'not_prefilled'}]" redirect-uri="http://www.rwavechicago.com/profile.php?save" >
    </fb:registration>
	<br />
<script src="pass.js"></script />
<script src="color.js"></script />
</head /><body>
<table align="center" onload="bgcolor('<?php echo $bgcolor; ?>');fontcolor('<?php echo $fontcolor; ?>');">
<tr>
<td><h1>Edit Account</h1 />
<form name="create" enctype="multipart/form-data" action="profile.php?id=<?php echo $id; ?>&save" method="POST" onSubmit="return validate();" />
<p align="right">Name: <input type="text" name="name" value="<?php echo $profile['name']; ?>" /><br />
Password:<input type="password" name="password" /><br />
Password(again): <input type="password" name="password_test" /><br />
E-mail: <input type="text" name="email" value="<?php echo $profile['email']; ?>" /><br />Hide Email?<select name="hide_email">
<option value="1" <?php if($profile['hide_email'] == '1') {echo "selected";} ?>>Yes</option />
<option value="0" <?php if($profile['hide_email'] == '0') {echo "selected";} ?>>No</option />
</select /><br />
Location: <input type="text" name="location" value="<?php echo $profile['location']; ?>" /><br />
Birthdate: <input type="text" name="birthdate" value="<?php echo $profile['birthdate']; ?>" /><br />
AIM: <input type="text" name="aim" value="<?php echo $profile['aim']; ?>" /><br />
Make Profile private?<select name="profile">
<option value="1" <?php if($profile['profile'] == '1') {echo "selected";} ?>>Yes</option />
<option value="0" <?php if($profile['profile'] == '0') {echo "selected";} ?>>No</option />
</select />
Font size:<select name="fontsize">
<option value="10" <?php if($profile['theme_fontsize'] == '10') {echo "selected";} ?>>10</option />
<option value="12" <?php if($profile['theme_fontsize'] == '12') {echo "selected";} ?>>12</option />
<option value="14" <?php if($profile['theme_fontsize'] == '14') {echo "selected";} ?>>14</option />
<option value="16" <?php if($profile['theme_fontsize'] == '16') {echo "selected";} ?>>16</option />
<option value="18" <?php if($profile['theme_fontsize'] == '18') {echo "selected";} ?>>18</option />
</select /><br />
<table border width="250" height="50">
<tr>
<td id="curcolor" name="curcolor" align="center">Current Colors</td />
<td><a href="javascript:advanced();">Show advanced</a>
<div id="advanced">
<input type="hidden" name="bgcolor" value="<?php echo $bgcolor; ?>" /><br />
<input type="hidden" name="fontcolor" value="<?php echo $fontcolor; ?>"/><br />
</div>
</td />
</tr />
</table />
<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
Profile pic: <input name="pic" type="file" /><br />
Status: <textarea name="status" rows="2"><?php echo stripslashes($profile['status']); ?></textarea /><br />
<input type="submit" name="save" value="Save" /><br /></p />
</form>
</td />
<td>
<div id="colorb" style="">
Choose a Background color
<table border width="220" height="330">
<tr>
<td align="center" bgcolor="#FFFAFA" onclick="javascript:bgcolor('#FFFAFA');"></td />
<td align="center" bgcolor="#F8F8FF" onclick="javascript:bgcolor('#F8F8FF');"></td />
<td align="center" bgcolor="#F5F5F5" onclick="javascript:bgcolor('#F5F5F5');"></td />
<td align="center" bgcolor="#DCDCDC" onclick="javascript:bgcolor('#DCDCDC');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFFAF0" onclick="javascript:bgcolor('#FFFAF0');"></td />
<td align="center" bgcolor="#FDF5E6" onclick="javascript:bgcolor('#FDF5E6');"></td />
<td align="center" bgcolor="#FAF0E6" onclick="javascript:bgcolor('#FAF0E6');"></td />
<td align="center" bgcolor="#FAEBD7" onclick="javascript:bgcolor('#FAEBD7');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFEFD5" onclick="javascript:bgcolor('#FFEFD5');"></td />
<td align="center" bgcolor="#FFEBCD" onclick="javascript:bgcolor('#FFEBCD');"></td />
<td align="center" bgcolor="#FFE4C4" onclick="javascript:bgcolor('#FFE4C4');"></td />
<td align="center" bgcolor="#FFDAB9" onclick="javascript:bgcolor('#FFDAB9');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFDEAD" onclick="javascript:bgcolor('#FFDEAD');"></td />
<td align="center" bgcolor="#FFE4B5" onclick="javascript:bgcolor('#FFE4B5');"></td />
<td align="center" bgcolor="#FFF8DC" onclick="javascript:bgcolor('#FFF8DC');"></td />
<td align="center" bgcolor="#FFFFF0" onclick="javascript:bgcolor('#FFFFF0');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFFACD" onclick="javascript:bgcolor('#FFFACD');"></td />
<td align="center" bgcolor="#FFF5EE" onclick="javascript:bgcolor('#FFF5EE');"></td />
<td align="center" bgcolor="#F0FFF0" onclick="javascript:bgcolor('#F0FFF0');"></td />
<td align="center" bgcolor="#F5FFFA" onclick="javascript:bgcolor('#F5FFFA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#F0FFFF" onclick="javascript:bgcolor('#F0FFFF');"></td />
<td align="center" bgcolor="#F0F8FF" onclick="javascript:bgcolor('#F0F8FF');"></td />
<td align="center" bgcolor="#E6E6FA" onclick="javascript:bgcolor('#E6E6FA');"></td />
<td align="center" bgcolor="#FFF0F5" onclick="javascript:bgcolor('#FFF0F5');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFE4E1" onclick="javascript:bgcolor('#FFE4E1');"></td />
<td align="center" bgcolor="#FFFFFF" onclick="javascript:bgcolor('#FFFFFF');"></td />
<td align="center" bgcolor="#000000" onclick="javascript:bgcolor('#000000');"></td />
<td align="center" bgcolor="#2F4F4F" onclick="javascript:bgcolor('#2F4F4F');"></td />
</tr />
<tr>
<td align="center" bgcolor="#696969" onclick="javascript:bgcolor('#696969');"></td />
<td align="center" bgcolor="#708090" onclick="javascript:bgcolor('#708090');"></td />
<td align="center" bgcolor="#778899" onclick="javascript:bgcolor('#778899');"></td />
<td align="center" bgcolor="#BEBEBE" onclick="javascript:bgcolor('#BEBEBE');"></td />
</tr />
<tr>
<td align="center" bgcolor="#D3D3D3" onclick="javascript:bgcolor('#D3D3D3');"></td />
<td align="center" bgcolor="#191970" onclick="javascript:bgcolor('#191970');"></td />
<td align="center" bgcolor="#000080" onclick="javascript:bgcolor('#000080');"></td />
<td align="center" bgcolor="#222222" onclick="javascript:bgcolor('#222222');"></td />
</tr />
<tr>
<td align="center" bgcolor="#6495ED" onclick="javascript:bgcolor('#6495ED');"></td />
<td align="center" bgcolor="#483D8B" onclick="javascript:bgcolor('#483D8B');"></td />
<td align="center" bgcolor="#6A5ACD" onclick="javascript:bgcolor('#6A5ACD');"></td />
<td align="center" bgcolor="#7B68EE" onclick="javascript:bgcolor('#7B68EE');"></td />
</tr />
<tr>
<td align="center" bgcolor="#8470FF" onclick="javascript:bgcolor('#8470FF');"></td />
<td align="center" bgcolor="#0000CD" onclick="javascript:bgcolor('#0000CD');"></td />
<td align="center" bgcolor="#4169E1" onclick="javascript:bgcolor('#4169E1');"></td />
<td align="center" bgcolor="#0000FF" onclick="javascript:bgcolor('#0000FF');"></td />
</tr />
<tr>
<td align="center" bgcolor="#1E90FF" onclick="javascript:bgcolor('#1E90FF');"></td />
<td align="center" bgcolor="#00BFFF" onclick="javascript:bgcolor('#00BFFF');"></td />
<td align="center" bgcolor="#87CEEB" onclick="javascript:bgcolor('#87CEEB');"></td />
<td align="center" bgcolor="#87CEFA" onclick="javascript:bgcolor('#87CEFA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#4682B4" onclick="javascript:bgcolor('#4682B4');"></td />
<td align="center" bgcolor="#B0C4DE" onclick="javascript:bgcolor('#B0C4DE');"></td />
<td align="center" bgcolor="#ADD8E6" onclick="javascript:bgcolor('#ADD8E6');"></td />
<td align="center" bgcolor="#B0E0E6" onclick="javascript:bgcolor('#B0E0E6');"></td />
</tr />
<tr>
<td align="center" bgcolor="#AFEEEE" onclick="javascript:bgcolor('#AFEEEE');"></td />
<td align="center" bgcolor="#00CED1" onclick="javascript:bgcolor('#00CED1');"></td />
<td align="center" bgcolor="#48D1CC" onclick="javascript:bgcolor('#48D1CC');"></td />
<td align="center" bgcolor="#40E0D0" onclick="javascript:bgcolor('#40E0D0');"></td />
</tr />
<tr>
<td align="center" bgcolor="#00FFFF" onclick="javascript:bgcolor('#00FFFF');"></td />
<td align="center" bgcolor="#E0FFFF" onclick="javascript:bgcolor('#E0FFFF');"></td />
<td align="center" bgcolor="#5F9EA0" onclick="javascript:bgcolor('#5F9EA0');"></td />
<td align="center" bgcolor="#66CDAA" onclick="javascript:bgcolor('#66CDAA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#7FFFD4" onclick="javascript:bgcolor('#7FFFD4');"></td />
<td align="center" bgcolor="#006400" onclick="javascript:bgcolor('#006400');"></td />

<td align="center" bgcolor="#556B2F" onclick="javascript:bgcolor('#556B2F');"></td />
<td align="center" bgcolor="#8FBC8F" onclick="javascript:bgcolor('#8FBC8F');"></td />
</tr /></tr />
</table />
</div>
</td />
<td>
<div id="colorf" style="">
Choose a Font color
<table border width="220" height="330">
<tr>
<td align="center" bgcolor="#FFFAFA" onclick="javascript:fontcolor('#FFFAFA');"></td />
<td align="center" bgcolor="#F8F8FF" onclick="javascript:fontcolor('#F8F8FF');"></td />
<td align="center" bgcolor="#F5F5F5" onclick="javascript:fontcolor('#F5F5F5');"></td />
<td align="center" bgcolor="#DCDCDC" onclick="javascript:fontcolor('#DCDCDC');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFFAF0" onclick="javascript:fontcolor('#FFFAF0');"></td />
<td align="center" bgcolor="#FDF5E6" onclick="javascript:fontcolor('#FDF5E6');"></td />
<td align="center" bgcolor="#FAF0E6" onclick="javascript:fontcolor('#FAF0E6');"></td />
<td align="center" bgcolor="#FAEBD7" onclick="javascript:fontcolor('#FAEBD7');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFEFD5" onclick="javascript:fontcolor('#FFEFD5');"></td />
<td align="center" bgcolor="#FFEBCD" onclick="javascript:fontcolor('#FFEBCD');"></td />
<td align="center" bgcolor="#FFE4C4" onclick="javascript:fontcolor('#FFE4C4');"></td />
<td align="center" bgcolor="#FFDAB9" onclick="javascript:fontcolor('#FFDAB9');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFDEAD" onclick="javascript:fontcolor('#FFDEAD');"></td />
<td align="center" bgcolor="#FFE4B5" onclick="javascript:fontcolor('#FFE4B5');"></td />
<td align="center" bgcolor="#FFF8DC" onclick="javascript:fontcolor('#FFF8DC');"></td />
<td align="center" bgcolor="#FFFFF0" onclick="javascript:fontcolor('#FFFFF0');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFFACD" onclick="javascript:fontcolor('#FFFACD');"></td />
<td align="center" bgcolor="#FFF5EE" onclick="javascript:fontcolor('#FFF5EE');"></td />
<td align="center" bgcolor="#F0FFF0" onclick="javascript:fontcolor('#F0FFF0');"></td />
<td align="center" bgcolor="#F5FFFA" onclick="javascript:fontcolor('#F5FFFA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#F0FFFF" onclick="javascript:fontcolor('#F0FFFF');"></td />
<td align="center" bgcolor="#F0F8FF" onclick="javascript:fontcolor('#F0F8FF');"></td />
<td align="center" bgcolor="#E6E6FA" onclick="javascript:fontcolor('#E6E6FA');"></td />
<td align="center" bgcolor="#FFF0F5" onclick="javascript:fontcolor('#FFF0F5');"></td />
</tr />
<tr>
<td align="center" bgcolor="#FFE4E1" onclick="javascript:fontcolor('#FFE4E1');"></td />
<td align="center" bgcolor="#FFFFFF" onclick="javascript:fontcolor('#FFFFFF');"></td />
<td align="center" bgcolor="#000000" onclick="javascript:fontcolor('#000000');"></td />
<td align="center" bgcolor="#2F4F4F" onclick="javascript:fontcolor('#2F4F4F');"></td />
</tr />
<tr>
<td align="center" bgcolor="#696969" onclick="javascript:fontcolor('#696969');"></td />
<td align="center" bgcolor="#708090" onclick="javascript:fontcolor('#708090');"></td />
<td align="center" bgcolor="#778899" onclick="javascript:fontcolor('#778899');"></td />
<td align="center" bgcolor="#BEBEBE" onclick="javascript:fontcolor('#BEBEBE');"></td />
</tr />
<tr>
<td align="center" bgcolor="#D3D3D3" onclick="javascript:fontcolor('#D3D3D3');"></td />
<td align="center" bgcolor="#191970" onclick="javascript:fontcolor('#191970');"></td />
<td align="center" bgcolor="#000080" onclick="javascript:fontcolor('#000080');"></td />
<td align="center" bgcolor="#222222" onclick="javascript:fontcolor('#222222');"></td />
</tr />
<tr>
<td align="center" bgcolor="#6495ED" onclick="javascript:fontcolor('#6495ED');"></td />
<td align="center" bgcolor="#483D8B" onclick="javascript:fontcolor('#483D8B');"></td />
<td align="center" bgcolor="#6A5ACD" onclick="javascript:fontcolor('#6A5ACD');"></td />
<td align="center" bgcolor="#7B68EE" onclick="javascript:fontcolor('#7B68EE');"></td />
</tr />
<tr>
<td align="center" bgcolor="#8470FF" onclick="javascript:fontcolor('#8470FF');"></td />
<td align="center" bgcolor="#0000CD" onclick="javascript:fontcolor('#0000CD');"></td />
<td align="center" bgcolor="#4169E1" onclick="javascript:fontcolor('#4169E1');"></td />
<td align="center" bgcolor="#0000FF" onclick="javascript:fontcolor('#0000FF');"></td />
</tr />
<tr>
<td align="center" bgcolor="#1E90FF" onclick="javascript:fontcolor('#1E90FF');"></td />
<td align="center" bgcolor="#00BFFF" onclick="javascript:fontcolor('#00BFFF');"></td />
<td align="center" bgcolor="#87CEEB" onclick="javascript:fontcolor('#87CEEB');"></td />
<td align="center" bgcolor="#87CEFA" onclick="javascript:fontcolor('#87CEFA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#4682B4" onclick="javascript:fontcolor('#4682B4');"></td />
<td align="center" bgcolor="#B0C4DE" onclick="javascript:fontcolor('#B0C4DE');"></td />
<td align="center" bgcolor="#ADD8E6" onclick="javascript:fontcolor('#ADD8E6');"></td />
<td align="center" bgcolor="#B0E0E6" onclick="javascript:fontcolor('#B0E0E6');"></td />
</tr />
<tr>
<td align="center" bgcolor="#AFEEEE" onclick="javascript:fontcolor('#AFEEEE');"></td />
<td align="center" bgcolor="#00CED1" onclick="javascript:fontcolor('#00CED1');"></td />
<td align="center" bgcolor="#48D1CC" onclick="javascript:fontcolor('#48D1CC');"></td />
<td align="center" bgcolor="#40E0D0" onclick="javascript:fontcolor('#40E0D0');"></td />
</tr />
<tr>
<td align="center" bgcolor="#00FFFF" onclick="javascript:fontcolor('#00FFFF');"></td />
<td align="center" bgcolor="#E0FFFF" onclick="javascript:fontcolor('#E0FFFF');"></td />
<td align="center" bgcolor="#5F9EA0" onclick="javascript:fontcolor('#5F9EA0');"></td />
<td align="center" bgcolor="#66CDAA" onclick="javascript:fontcolor('#66CDAA');"></td />
</tr />
<tr>
<td align="center" bgcolor="#7FFFD4" onclick="javascript:fontcolor('#7FFFD4');"></td />
<td align="center" bgcolor="#006400" onclick="javascript:fontcolor('#006400');"></td />

<td align="center" bgcolor="#556B2F" onclick="javascript:fontcolor('#556B2F');"></td />
<td align="center" bgcolor="#8FBC8F" onclick="javascript:fontcolor('#8FBC8F');"></td />
</tr /></tr />
</table />
</div>
</td />
</tr />
</table />
</body>
</html>
<?php


}
else {
	if(isset($you)) {
		makenav(addslashes($you),$facebook->getLogoutUrl());
		makeplaylist(addslashes($you),$pid);
	}
	else {
		makenav($id,$facebook->getLogoutUrl());
		makeplaylist($id,$pid);
	}
}
include "foot.php";

?>