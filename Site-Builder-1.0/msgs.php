<?php 
define("Profile","true");
include "connect.php";
include "site_include.php";
include "theme.php";
makenav($id, $logoutUrl);

$mid = $_REQUEST['mid'];
$tid = $_REQUEST['tid'];
$fid = $_REQUEST['fid'];
$msg = $_REQUEST['msg'];
$type = $_REQUEST['type'];

	echo "<table align=\"right\" valign=\"top\">\n
	<td align=\"right\" valign=\"top\" width=\"220px\" height=\"330px\" />\n
	<small><b>Outbox</b /><table><br />\n";

	outbox($id);

	echo "</table /></td />
	</table />
	<table align=\"right\" valign=\"top\">\n
	<td align=\"right\" valign=\"top\" width=\"220px\" height=\"330px\" />\n
	<small /><b>Inbox</b /></small /><table /><br />\n";
	
	listmsgs($id);
	
	echo "</table /></td />\n
	</table />";
	



if(isset($_REQUEST['send'])) {
	sendmsg($tid, $id, $msg, 4);
	header("Location: msgs.php");	
}

else if(isset($_REQUEST['save']) && isset($mid)) {

			editmsg($mid, $tid, $id, $msg);
			header("Location: msgs.php");
			
}

else if(isset($_REQUEST['delete']) && isset($mid)) {

	delmsg($mid);
	header("Location: msgs.php");



}

else if(isset($_REQUEST['edit']) && isset($mid)) {

		/*Get messages for user*/
		$result = q("SELECT msg,tid FROM messages WHERE id='$mid'");

		if(dbcount($result)) $msg = dbarray($result);
		/*---------------------*/

echo "<table align=\"left\" valign=\"top\"/>
		<td align=\"left\" valign=\"top\" width=\"220px\" height=\"330px\" />
		<tr /><table>
		<div id=\"compose\" />Edit message<br />\n
				<form action=\"msgs.php?save&mid=" . $mid . "\" / method=\"post\" />\n
							To: <select name=\"tid\" />\n" . 
							friendselector($id)
							. "	</select />\n
							<tr />
							<td />\n
							<textarea name=\"msg\" cols=\"25\" rows=\"5\" />" . $msg['msg'] . "</textarea /><br />\n
							<input type=\"submit\" name=\"save\" value=\"Send\" />\n
				</form />\n
					</div />\n
					</td />\n
					</table />\n
					</tr />\n
				</table />\n";
	}

else if(isset($mid)) {
		echo "<table align=\"left\" valign=\"top\"/>
		<td align=\"left\" valign=\"top\" width=\"220px\" height=\"330px\" />
		<tr /><table>
		<div id=\"compose\" />REPLY[[[TODO]]]<br />\n
				<form action=\"msgs.php?send\" method=\"post\" />\n
							To: <select name=\"tid\" />\n" . 
							friendselector($id)
							. "	</select />\n
							<tr />
							<td />\n
							<textarea name=\"msg\" cols=\"25\" rows=\"5\" /></textarea /><br />\n
							<input type=\"submit\" name=\"send\" value=\"Send\" />\n
				</form />\n
					</div />\n
					</td />\n
					</table />\n
					</tr />\n
				</table />\n 
				<table align=\"right\" valign=\"top\">\n
					<td align=\"left\" valign=\"top\" width=\"220px\" height=\"330px\" />
					<tr /><br /><br />"
		.  		getmsg($mid) . 
				"<br />\n";
				
}

else {
				echo "<table align=\"left\" valign=\"top\"/>
		<td align=\"left\" valign=\"top\" width=\"220px\" height=\"330px\" />
		<tr /><table>
		<div id=\"compose\" />Compose message<br />\n
				<form action=\"msgs.php?send\" method=\"post\" />\n
							To: <select name=\"tid\" />\n" . 
							friendselector($id)
							. "	</select />\n
							<tr />
							<td />\n
							<textarea name=\"msg\" cols=\"25\" rows=\"5\" /></textarea /><br />\n
							<input type=\"submit\" name=\"send\" value=\"Send\" />\n
				</form />\n
					</div />\n
					</td />\n
					</table />\n
					</tr />\n
				</table />\n";
		echo "
		</tr />
		</td />
		\n";
	

}

include "foot.php";
?>