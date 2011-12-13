/*

if($id == $session['uid']) {
	$result = q("UPDATE users SET 


 	profile='$isprivate',
 
 	status='$status'

	WHERE id='".$id."'");
}

*/

/* uploading stuff
//upload a file if it is sent and add it to profile pic
	$ext = substr($_FILES['pic']['name'], strripos($_FILES['pic']['name'], '.'));
	$path = getcwd() . "/images/";
	$basename = $id . "_" . basename($_FILES['pic']['name'], $ext);
	$filename = $basename . $ext; 
	$tpath = $path . $filename;

if(is_uploaded_file($_FILES['pic']['tmp_name'])) {

	if($_FILES['pic']['size'] > 4194304) {
		echo "<h1>Image must be smaller than 4MB</h1 />";
		makeprofile($id);
	}

	if($ext == ("png" || "gif" || "jpg" || "bmp" || "jpeg")) {
		if(!file_exists($tpath)) {

			if(@move_uploaded_file($_FILES['pic']['tmp_name'], $tpath)) {
				$result = q("SELECT * FROM images");
	 			$pid = dbcount($result) + 1;
				$result = q("UPDATE users SET profile_pic='$pid' WHERE id='".$id."'");
				$result = q("INSERT INTO images(id,image,isprivate) VALUES('".$pid."', '".$filename."','0')");
			} 
			else{
    				echo "<h1>The profile image upload failed.</h1 />";
				makeprofile($id);
			}
		}
		else {
			//echo "<h1>The image already exists.</h1 />";
			//makeprofile($id);
		}
	}
	else {
		echo "<h1>Bad image</h1 />";
		makeprofile($id);
	}
}
*/