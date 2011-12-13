<?php

/*-----------------------------------------------------------------------
Useful functions by Zachary Padove
-----------------------------------------------------------------------*/

/*--------------------------------------------
------------BEGIN File Functions--------------
--------------------------------------------*/

function write($data, $filename, $type='w') {

    if (!$handle = fopen($filename, $type)) {
    }
        if (fwrite($handle, $data) === FALSE) {
        }
    fclose($handle);
}



function truncate($filename, $length='0') {

    if (!$handle = fopen($filename, 'r+')) {
    }
    if(ftruncate($handle, $length)) {
        return true;
    }

    else {
        return false;
    }
    fclose($handle);
}


function highlight($data, $text, $color='#ffff00') {

    $data= str_replace($text, '<span style="background-color: ' . $color . '">' . $text . '</span>', $data);
    echo $data;
}



function read($filename) {
    if(!file_exists($filename)) {
        exit("$filename doesn't exist");
    }

    else if(filesize($filename) == 0) {
        exit("$filename is null");
    }

    $handle = fopen($filename, "r");
    $contents = fread($handle, filesize($filename));
    fclose($handle);
    return $contents;
}

function noparse($code) {
$code = str_replace('<' , '&lt;', $code);
$code = str_replace('>' , '&gt;' , $code);
return $code;
} 

function stream($link) {
    $stream = fopen($link, 'r');
    $content = stream_get_contents($stream, -1, 0);
    return $content;
    fclose($stream);
} 

function line($filename, $linex='1') {
    $lines = file($filename);
    foreach ($lines as $line_num => $line) {
            if($line_num == $linex) {
            return $line;
        }
    }
}

function file_check($filename, $check='accessed') {
    if(file_exists($filename)) {

        if($check == 'accessed') {
            return fileatime($filename);
        }

        else if($check == 'modified') {
            return filemtime($filename);
        }

        else if($check == 'owner') {
            return fileowner($filename);
        }

        else if($check == 'permissions') {
            return substr(sprintf('%o', fileperms($filename)), -4);
        }

        else if($check == 'group') {
            return filegroup($filename);
        }

        else if($check == 'size') {
            return filesize($filename);
        }

        else if($check == 'type') {
            return filetype($filename);
        }
        
        else {
            return "$check not a valid value";
        }

    }
    
    else {
        return "$filename doesn't exist";
    }
}

/*----------------------------------------
-----------END File Functions-------------
----------------------------------------*/

/*----------------------------------------
--------BEGIN Directory Functions---------
----------------------------------------*/
function read_dir($directory, $recursive='false') {

    $array_items = array();
        if ($handle = opendir($directory)) {
             while (false !== ($file = readdir($handle))) {
                 if ($file != "." && $file != "..") { 
                    if (is_dir($directory. "/" . $file)) {
                         if($recursive) {
                             $array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive)); 
                        }
                         $file = $file; $array_items[] = preg_replace("/\/\//si", "/", $file); 
                        sort($array_items);
                    }

                     else { 
                        $file = $file; $array_items[] = preg_replace("/\/\//si", "/", $file); 
                        sort($array_items);
                    }
                } 
            }
             closedir($handle); 
        }
    return $array_items;

}

function delete_dir($directory) {

    if(substr($directory,-1) == '/') {
        $directory = substr($directory,0,-1);
    }
    if(!file_exists($directory) || !is_dir($directory)) {
        die("Directory invalid");
    }
    elseif(is_readable($directory)) {
        $handle = opendir($directory);
        while (FALSE !== ($item = readdir($handle))) {
            if($item != '.' && $item != '..') {
                $path = $directory.'/'.$item;
                if(is_dir($path)) {
                    delete_dir($path);
                }
                else {
                    unlink($path);
                }
            }
        }
        closedir($handle);
    }
             if(!rmdir($directory)) {
                 return false;
             }
    return true;

}

/*----------------------------------------
---------END Directory Functions----------
----------------------------------------*/

/*----------------------------------------
----------BEGIN Image Functions-----------
----------------------------------------*/

function watermark($imagesource, $wmgif, $type='corner') {

    $filetype = substr($imagesource,strlen($imagesource)-4,4);
    $filetype = strtolower($filetype);

    if($filetype == ".gif") { 
        $image = @imagecreatefromgif($imagesource);
    } 
    if($filetype == ".jpg") { 
        $image = @imagecreatefromjpeg($imagesource);
    }
    if($filetype == ".png") { 
        $image = @imagecreatefrompng($imagesource);
    }

    if (!$image) {
        die();
    }
    $watermark = @imagecreatefromgif($wmgif);
    $imagewidth = imagesx($image);
    $imageheight = imagesy($image);  
    $watermarkwidth =  imagesx($watermark);
    $watermarkheight =  imagesy($watermark);

    if($type == 'center') {
        $startwidth = (($imagewidth - $watermarkwidth)/2);
        $startheight = (($imageheight - $watermarkheight)/2);
    }

    else if($type == 'corner') {
        $startwidth = (($imagewidth - $watermarkwidth)-5);
        $startheight = (($imageheight - $watermarkheight)-5);
    }
    imagecopy($image, $watermark,  $startwidth, $startheight, 0, 0, $watermarkwidth, $watermarkheight);
    return imagejpeg($image);
    imagedestroy($image);
    imagedestroy($watermark); 
}

function captcha($code="RAWR", $background, $r=0, $g=0, $b=0) {

    $filetype = substr($background,strlen($background)-4,4);
    $filetype = strtolower($filetype);

    if($filetype == ".gif") { 
        $image = @imagecreatefromgif($background);
    } 
    if($filetype == ".jpg") { 
        $image = @imagecreatefromjpeg($background);
    }
    if($filetype == ".png") { 
        $image = @imagecreatefrompng($background);
    }

    $color = imagecolorallocate($image, $r, $g, $b);
    imagestring($image, 2, 4, 0, $code, $color);
    return imagepng($image);
    imagedestroy($image);
}


function image($filename, $check='type') {
    if(file_exists($filename)) {

        if($check == 'type') {
            $type = exif_imagetype($filename);
            $types = array('GIF', 'JPEG', 'PNG', 'SWF', 'PSD', 'BMP', 'TIFF_II', 'TIFF_MM', 'JPC', 'JP2', 'JPX', 'JB2', 'SWC', 'IFF', 'WBMP', 'XBM');

            return $types[$type];
        }

        else if($check == 'size') {
            list($width, $height) = getimagesize($filename);
	    $info['h'] = $height;
	    $info['w'] = $width;
            return $info;
        }

        else if($check == 'exif') {
            return exif_read_data($filename, 0, true);
        }
        
        else {
            return "$check not a valid value";
        }

    }
    
    else {
        return "$filename doesn't exist";
    }
}

function resize($filename, $w, $h, $transparent=false) {

    $filetype = substr($filename,strlen($filename)-4,4);
    $filetype = strtolower($filetype);

    list($width, $height) = getimagesize($filename);

    $resize = imagecreatetruecolor($w, $h);

        if($filetype == ".gif") { 
            $image = @imagecreatefromgif($filename);
            if($transparent) {
                $colorTransparent = @imagecolortransparent($resize);
                @imagepalettecopy($image, $resize);
                @imagefill($resize, 0, 0, $colorTransparent);
                @imagecolortransparent($resize, $colorTransparent);

                @imagetruecolortopalette($resize, true, 256);
            }
            $rawr = @imagecopyresampled($resize, $image, 0, 0, 0, 0, $w, $h, $width, $height);
            $resized = @imagegif($resize);
        } 

        if($filetype == ".jpg") { 
            $image = @imagecreatefromjpeg($filename);
            if($transparent) {
                $colorTransparent = @imagecolortransparent($resize);
                @imagepalettecopy($image, $resize);
                @imagefill($resize, 0, 0, $colorTransparent);
                @imagecolortransparent($resize, $colorTransparent);

                @imagetruecolortopalette($resize, true, 256);
            }
            $rawr = @imagecopyresampled($resize, $image, 0, 0, 0, 0, $w, $h, $width, $height);
            $resized = @imagejpeg($resize);
        }

        if($filetype == ".png") { 
            $image = @imagecreatefrompng($filename);
            if($transparent) {
                $colorTransparent = @imagecolortransparent($resize);
                @imagepalettecopy($image, $resize);
                @imagefill($resize, 0, 0, $colorTransparent);
                @imagecolortransparent($resize, $colorTransparent);

                @imagetruecolortopalette($resize, true, 256);
            }
            $rawr = @imagecopyresampled($resize, $image, 0, 0, 0, 0, $w, $h, $width, $height);
            $resized = @imagepng($resize);
        }

    return $resized;

}

function filter($image, $filter='invert', $arg1=null, $arg2=null, $arg3=null) {

    $filetype = substr($image,strlen($image)-4,4);
    $filetype = strtolower($filetype);

    if($filetype == ".gif") { 
        $resource = imagecreatefromgif($image);
    } 
    if($filetype == ".jpg") { 
        $resource = imagecreatefromjpeg($image);
    }
    if($filetype == ".png") { 
        $resource = imagecreatefrompng($image);
    }

        if($filter == 'invert') {
            $setfilter = @imagefilter($resource, IMG_FILTER_NEGATE);
        }

        else if($filter == 'grayscale') {
                $setfilter = @imagefilter($resource, IMG_FILTER_GRAYSCALE);
        }

        else if($filter == 'brightness') {
                $setfilter = @imagefilter($resource, IMG_FILTER_BRIGHTNESS, $arg1);
        }

        else if($filter == 'contrast') {
                $setfilter = @imagefilter($resource, IMG_FILTER_CONTRAST, $arg1);
        }

        else if($filter == 'color') {
                $setfilter = @imagefilter($resource, IMG_FILTER_COLORIZE, $arg1, $arg2, $arg3);
        }

        else if($filter == 'edge') {
                $setfilter = @imagefilter($resource, IMG_FILTER_EDGEDETECT);
        }

        else if($filter == 'emboss') {
                $setfilter = @imagefilter($resource, IMG_FILTER_EMBOSS);
        }

        else if($filter == 'blur1') {
                $setfilter = @imagefilter($resource, IMG_FILTER_GAUSSIAN_BLUR);
        }

        else if($filter == 'blur2') {
                $setfilter = @imagefilter($resource, IMG_FILTER_SELECTIVE_BLUR);
        }

        else if($filter == 'sketch') {
                $setfilter = @imagefilter($resource, IMG_FILTER_MEAN_REMOVAL);
        }

        else if($filter == 'smooth') {
                $setfilter = @imagefilter($resource, IMG_FILTER_SMOOTH, $arg1);
        }

        else if($filter == 'rotate') {
                $resource = imagerotate($resource, $arg1, 0);
        }

        else {
                die("$filter not valid");
        }

    if($filetype == ".gif") { 
        $img = @imagegif($resource);
                imagedestroy($resource);
    } 
    if($filetype == ".jpg") { 
        $img = @imagejpeg($resource);
                imagedestroy($resource);
    }
    if($filetype == ".png") { 
        $img = @imagepng($resource);
                imagedestroy($resource);
    }

}
/*----------------------------------------
-----------END Image Functions------------
----------------------------------------*/

/*----------------------------------------
-----------Begin DB Functions-------------
----------------------------------------*/

function q($SQL) {
	$result = @mysql_query($SQL);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		return $result;
	}
}

function dbrows($result) {
	$row = mysql_fetch_array($result);
	return $row;

}

function dbresult($query, $row) {
	$result = @mysql_result($query, $row);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		return $result;
	}
}

function dbcount($query) {
	$result = @mysql_num_rows($query);
	return $result;
}

function dbarray($query) {
	$result = @mysql_fetch_assoc($query);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		return $result;
	}
}

function connect($db_host, $db_user, $db_pass, $db_name) {
	$db_connect = @mysql_connect($db_host, $db_user, $db_pass);
	$db_select = @mysql_select_db($db_name);
	if (!$db_connect) {
		die("Server Issues.");
	} elseif (!$db_select) {
		die("Server Issues.");
	}
}

/*----------------------------------------
------------End DB Functions--------------
----------------------------------------*/

?>
