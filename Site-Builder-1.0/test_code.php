<center><title>Code Testing page</title>
<body bgcolor="#131212">
<?php

$rand_file = 'temp_' . time();
$c = 'test_code.php';
$codee = $_REQUEST['codee'];
if(isset($codee)) {
$rand_file = $codee;
$c = 'test_code.php?codee=' . $codee;
}

function savefile($data, $file) {
if(!file_exists(getcwd() . '/temp/')) {
mkdir(getcwd() . '/temp/', 0775);
}
    if (!$handle = fopen($file, 'w')) {
}
    if (fwrite($handle, $data) === FALSE) {
}
    fclose($handle);
}
function parse($code) {
$rand_file = 'temp_' . time();
$code = str_replace('<%code%>' , 'post.php?code=' . $rand_file , $code);
$code = str_replace('<%date%>' , date('l dS \of F Y h:i:s A') , $code);
$code = str_replace('<%rand%>' , rand() , $code);
$code = str_replace('<%path%>' , getcwd() , $code);
$code = str_replace('<%IP_S%>' , $_SERVER['SERVER_ADDR'] , $code);
$code = str_replace('<%IP_V%>' , $_SERVER['REMOTE_ADDR'] , $code);
return $code;
}
function noparse($code) {
$code = str_replace('<' , '&lt;', $code);
$code = str_replace('>' , '&gt;' , $code);
return $code;
}

if(!file_exists(getcwd() . '/temp/')) {
mkdir(getcwd() . '/temp/', 0775);
}

$php = $_REQUEST['code'];

if($php != NULL) {
eval(" ?><table border='1' width='600' bgcolor='#dfdfdf'><tr><td><center><h1>Executed Code:</h1></center>" . stripslashes(parse($php)) . "</td></tr></table><?php ");
savefile($php, getcwd() . '/temp/' . $rand_file);
}
?>
<table border='1' width='600'>
<tr>
<td>
<form action="<?php echo $c; ?>" method="post">
<center>
<textarea rows="10" cols="70" name="code"><?php echo stripslashes(noparse($php)); ?></textarea><br>
<input type="submit" value="Execute code"><br><font color='#ffffff'>
Predefined variables<br>
Temporary Code URL: <%code%><br>
Server IP: <%IP_S%><br>
Visitor IP: <%IP_V%><br>
Random Number: <%rand%><br>
Date: <%date%><br>
Current Working Directory: <%path%><br>
<b><u>Files are deleted and replaced hourly</u></b></font><br>
<a href="list.php">List All Queries</a><br>
</center>
</form>
</td>
</tr>
</table>
