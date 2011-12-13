<?php
include "connect.php";
include "site_include.php";
include "theme.php";
$pid = $_REQUEST['pid'];
?>
<script type='text/javascript' src='mediaplayer/swfobject.js'></script>

<div id='mediaplayer'></div>

<script type="text/javascript">
    var so = new SWFObject('mediaplayer/player.swf','playerID','320','300','9');
    so.addParam('allowfullscreen','true');
    so.addParam('allowscriptaccess','always');
    so.addVariable('autostart','true');
    so.addVariable('playlistfile', 'playlist.php?pid=<?php echo $pid; ?>');
    so.addVariable('playlist.position', 'over');
   
    so.write('mediaplayer');
</script>


