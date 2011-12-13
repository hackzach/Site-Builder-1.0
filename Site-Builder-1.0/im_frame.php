<?php
define("chat", "true");
define("theme", "true");
include "site_include.php";
$fid = $_GET['fid'];
?>

<script>
getmsg(<?php echo $id; ?>,<?php echo $fid; ?>);
</script />

<div id="get"></div>

