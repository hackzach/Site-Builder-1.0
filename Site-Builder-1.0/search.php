<?php
include "connect.php";
include "site_include.php";
include "theme.php";

makenav($id, $logoutUrl);
?>

<center><b>Search</b /><br />
<form action="search.php">
<input type="text" name="query" />
<select name="type" />
<option value="title">Name</option />
<option value="id">id</option />
</select />
<input type="submit" value="Search" />
</form />
</center />

<?php

$type = $_GET['type'];
$query = $_GET['query'];

if($query != '') {

	if($query == '*') $query = '_';

	if($type == '') $type = 'title';

	$type = addslashes($type);
	$query = addslashes($query);

	$result = q("SELECT * FROM playlists WHERE $type LIKE '%$query%' AND id <> '0'");
	echo "<center><b>Results for: </b />\"" . $query . "\"<br /><br /></center /><small>";
	if(dbcount($result)) {
		echo "<table align=\"center\" valign=\"top\"><tr><td>";

		while($row = dbrows($result)) {
			echo "<a href=\"javascript:popup('" . $row['id'] . "');\">" . $row['title'] . " </a /><br />";
		}

		echo "</small /></td /></tr /></table />";
	}
	else {
		echo "<center>No results found.</center /></small />";
	}
}

?>