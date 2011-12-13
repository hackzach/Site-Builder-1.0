<?php

include "connect.php";
include "site_include.php";
include "theme.php";

makenav($id, $logoutUrl);

if(!isadmin($id)) {
	header("Location: index.php");
}

$aid = $_GET['aid'];

$result = q("SELECT * FROM users WHERE id='$id'");
if(dbcount($result)) $level = dbarray($result);
	

if(isset($_GET['edit'])) {

	if($level['level'] != '3') {
		header("Location: admin.php");
		echo "<script>window.location='admin.php'</script />";	
		exit;
	}

	$result = q("SELECT * FROM users WHERE id='$aid'");
	if(dbcount($result)) $user = dbarray($result);
	echo "<br />
	<table align=\"center\" valign=\"top\"><tr><td><center><b>Edit Admin</b></center /><br /><br>
	<form action=\"admin.php?aid=" . $aid . "&save\" method=\"post\">
	Username :  " .lookup($aid, 'name') . "<br />
	Userlevel:<select name=\"level\" />
	<option value=\"1\""; if($user['level'] == '1') echo " selected"; echo ">" . getlevel(1) . "</option />
	<option value=\"2\""; if($user['level'] == '2') echo " selected"; echo ">" . getlevel(2) . "</option />
	<option value=\"3\""; if($user['level'] == '3') echo " selected"; echo ">" . getlevel(3) . "</option />
	</select /><br />
	<input type=\"submit\" value=\"Save\" />
	</form />
	</td /></tr /></table />";

}
else if(isset($_GET['save'])) {

	if($level['level'] != '3') {
		header("Location: admin.php");
		echo "<script>window.location='admin.php'</script />";	
		exit;
	}

	else if(isset($aid) && isset($_POST['level'])) {

		$level = addslashes($_POST['level']);
			
		$result = q("UPDATE users SET level='$level' WHERE id='$aid'");
		header("Location: admin.php");
		echo "<script>window.location='admin.php?aid='</script />";	
		exit;
	}
}

else {

	echo "
	<table align=\"center\" valign=\"top\" border=\"1\"><tr><center>Pages: ";

	$result = q("SELECT * FROM users");
	$count = dbcount($result);
	$show = 30;
	$pages = ceil($count/$show);

	$limit = $_GET['p'];
	if($limit == NULL) {
		$limit = 1;
	}

	$min = ($limit-1) * $show;
	$max = $limit * $show;

	for($i=1;$i<=$pages;$i++) {
		if($i == $limit) {
			echo "<b>" . $i . "</b /> ";
		}
		else {
			echo " <a href=\"admin.php?p=" . $i . "\">" . $i . "</a /> ";
		}
	}

	echo "</center /><br /><td align=\"left\">";
	$admin = false;
	$result = q("SELECT * FROM users WHERE id='$id'");

	if(dbcount($result)) $user = dbarray($result);

	if($user['level'] == 3) {
		$admin = true;
	}

	if($_GET['t'] == 'a') {
		$t = 'ASC';
	}
	else{
		$t = 'DESC';
	}

	if($_GET['o'] == 'n') {
		$orderby = 'name';
	}
	else if($_GET['o'] == 'u') {
		$orderby = 'level';
	}
	else{
		$orderby = 'id';
	}

	if($t != 'ASC') {
		echo "<small><a href=\"admin.php?o=n&t=a\">Name</a /><br /><br /></small />";
	}
	else {
		echo "<small><a href=\"admin.php?o=n\">Name</a /><br /><br /></small />";
	}
	
	$limit = addslashes($limit);
	$result = q("SELECT * FROM users ORDER BY `users`.`$orderby` $t LIMIT $min,$max");

	while($user = dbrows($result)) {
		if($user['id'] != '0') {
			echo "<a href=\"profile.php?id=" . $user['id'] . "\">" . lookup($user['id'],'name') . "</a /><br />\n";
		}
	}
	echo "</td /><td align=\"right\"><small>Profile</small /><br /><br />";

	$result = q("SELECT * FROM users ORDER BY `users`.`$orderby` $t LIMIT $min,$max");

	while($user = dbrows($result)) {
		if($user['id'] != '0') {
			echo " <a href=\"profile.php?id=" . $user['id'] . "&edit\">edit</a /> <a href=\"friends.php?fid=" . $user['id'] . "\">view friends</a /><br /> ";
		}
	}

	echo "</td /><td align=\"left\">";

	if($t != 'ASC') {
		echo "<div align=\"right\"><small><a href=\"admin.php?o=u&t=a\">Userlevel</a />&nbsp;&nbsp;<br /><br /></small /></div />";
	}
	else {
		echo "<div align=\"right\"><small><a href=\"admin.php?o=u\">Userlevel</a />&nbsp;&nbsp;<br /><br /></small /></div />";
	}

	$result = q("SELECT * FROM users ORDER BY `users`.`$orderby` $t LIMIT $min,$max");

	while($user = dbrows($result)) {
		if($user['id'] != '0') {
			
	
			if($admin) {
				echo "<a href=\"admin.php?aid=" . $user['id'] . "&edit\"><b>" . getlevel($user['level']) . "</b /> edit</a />";
			}
			else if(getlevel($user['level']) != "4") {
				echo "<b>" . getlevel($user['level']) . "</b>";
			}

			echo "<br />\n";
		}
	}
	echo "</td /></tr /></table />";

}

include "foot.php";
?>