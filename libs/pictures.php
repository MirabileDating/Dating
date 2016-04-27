<?PHP
function folderlist() {
	$folderlist[1]["name"] = _('Public');
	$folderlist[1]["id"] = "0";
	$folderlist[2]["name"] = _('Private');
	$folderlist[2]["id"] = "1";
	if (isset($folderlist))
		return $folderlist;
}
function makemainUserImage($uid, $imagefull,$image,$imagethumb)
{
	
	if (!empty($image)) {
	
			
			$sql = "UPDATE users SET image = '$image', imagefull='$imagefull', imagethumb='$imagethumb' WHERE ids='$uid'";
			
			$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());

		return 99;
	} else {
		return false;
	}
}
function deleteUserImage($uid, $imageid)
{
	
	if (!empty($uid) && !empty($imageid) ) {
		//look up image path then remove the files before preceding
		$sql = "SELECT image FROM userimages WHERE idkey = '$uid' and id = '$imageid'";
		
		$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
		$num = sqlNumRows($res);
		if (!empty($num)) {
			$row = sqlFetchAssoc($res);
			$imagepath = $row["image"];
			$imagethumbpath = str_replace(".","_thumb.",$imagepath);
		} else {
			return false;
		}
	}
	
	if (!empty($imagepath)) {
	
		unlink($imagepath);
		unlink($imagethumbpath);

		$sql = "DELETE FROM userimages WHERE idkey = '$uid' and id = '$imageid'";
		
		$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());

		//if the listing image was not the mainimage return true for delete record
		return 99;
	} else {
		return false;
	}
}


function openImage($file)
{
	// Get extension and return it
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	switch(strtolower($ext)) {
		case 'jpg':
		case 'jpeg':
			$im = @imagecreatefromjpeg($file);
			break;
		case 'gif':
			$im = @imagecreatefromgif($file);
			break;
		case 'png':
			$im = @imagecreatefrompng($file);
			break;
		default:
			$im = false;
			break;
	}
	return $im;
}

function createThumb($file, $ext, $width)
{
	$im = '';
	$im = openImage($file);

	if (empty($im)) {
		return false;
	}

	$old_x = imagesx($im);
   	$old_y = imagesy($im);
	

    $new_w = (int)$width;

	if (($new_w <= 0) or ($new_w > $old_x)) {
		$new_w = $old_x;
   	}

   	$new_h = ($old_x * ($new_w / $old_x));

    if ($old_x > $old_y) {
        $thumb_w = $new_w;
        $thumb_h = $old_y * ($new_h / $old_x);
    }
    if ($old_x < $old_y) {
        $thumb_w = $old_x * ($new_w / $old_y);
        $thumb_h = $new_h;
    }
    if ($old_x == $old_y) {
		$thumb_w = $new_w;
		$thumb_h = $new_h;
    }
	
	$thumb = imagecreatetruecolor($thumb_w,$thumb_h);

	if ($ext == 'png') {
		imagealphablending($thumb, false);
		$colorTransparent = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
       	imagefill($thumb, 0, 0, $colorTransparent);
       	imagesavealpha($thumb, true);
	} elseif ($ext == 'gif') {
    	$trnprt_indx = imagecolortransparent($im);
        if ($trnprt_indx >= 0) {
        	//its transparent
           	$trnprt_color = imagecolorsforindex($im, $trnprt_indx);
           	$trnprt_indx = imagecolorallocate($thumb, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
           	imagefill($thumb, 0, 0, $trnprt_indx);
           	imagecolortransparent($thumb, $trnprt_indx);
		}
	}

	imagecopyresampled($thumb,$im,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);

	//choose which image program to use
	switch(strtolower($ext)) {
		case 'jpg':
		case 'jpeg':
			imagejpeg($thumb,$file);
			break;
		case 'gif':
			imagegif($thumb,$file);
			break;
		case 'png':
			imagepng($thumb,$file);
			break;
		default:
			return false;
			break;
	}

	imagedestroy($im);
    imagedestroy($thumb);
}
function moveUploadImage($path, $file, $tmpfile, $max)
{
	//upload your image and give it a random name so no conflicts occour
	$rand = rand(1000,9000);
	$save_path = $path . $file;

	//prep file for db and gd manipulation
	$bad_char_arr = array(' ', '&', '(', ')', '*', '[', ']', '<', '>', '{', '}');
	$replace_char_arr = array('-', '_', '', '', '', '', '', '', '', '', '');
	$save_path = str_replace($bad_char_arr, $replace_char_arr, $save_path);

	//move the temp file to the proper place
	if (move_uploaded_file($tmpfile, $save_path)) {
		$ext = pathinfo($save_path, PATHINFO_EXTENSION);
		$base = pathinfo($save_path, PATHINFO_FILENAME);
		$dir = pathinfo($save_path, PATHINFO_DIRNAME);
		$base_path = "$dir/$base";

		copy($save_path, "$base_path" . "_thumb" . "." . "$ext");
		createThumb(     "$base_path" . "_thumb" . "." . "$ext", $ext, 150);
		createThumb("$base_path" . "." . "$ext", $ext, 640);

		return $file;//$save_path;
	}
	unlink($tmpfile);
	return false;
}
//Image functions
function checkImageSize($tmpfile, $max)
{
	//check the tmpimage file size and see if it is to big returns true if to large
	$size = filesize($tmpfile);
	if ($size > $max) {
		return true;
	}
	$image_info = getimagesize($tmpfile);
	$image_width = $image_info[0];
	$image_height = $image_info[1];
	if ($image_width < 10 || $image_height < 10)
	{
		return true;
	}
	return false;
}

function checkAllowedExt($file)
{
	//check file for allowed extensions returns true if wrong type
	$temp = strtolower($file);
	$ext = pathinfo($temp, PATHINFO_EXTENSION);

	$allowed = array('gif', 'jpg', 'jpeg', 'png');
	
	if (!in_array($ext, $allowed))
		return true;
	return false;
}


function uploadUserImage($file, $tmpfile, $max, $userid,$private,$title,$description)
{
		
	$uniquepath=md5(date('Y-m-d H:i:s:u'));
       if (empty($file))
          return false;
       if (!getimagesize($tmpfile))
          return false;		
		  
       if (checkImageSize($tmpfile, $max))
          return 1;
       if (checkAllowedExt($file))
          return 2;

	$filenr = time();
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	$filename = "$filenr.$ext";
	$urldir=getMemberdir($userid);
	 
// MOVE

	$image_path = $urldir;
	$image_fullpath = $image_path . $filename;

	if (move_uploaded_file($tmpfile, $image_fullpath)) {
		$ext = pathinfo($image_fullpath, PATHINFO_EXTENSION);
		$base = pathinfo($image_fullpath, PATHINFO_FILENAME);
		$thumbname = $base . "_thumb." . $ext;	
		$thumb_fullpath = $image_path . $thumbname;
		copy($image_fullpath,  $thumb_fullpath);
		createThumb($thumb_fullpath , $ext, 150);
		createThumb($image_fullpath, $ext, 640);

	} else {
		unlink($tmpfile);
	}
// MOVE
	if (!empty($filename)) {
		
				
		
		if ($private==0) {
			$sql = "UPDATE users SET image = '" . $urldir.$filename . "', imagethumb = '" . $urldir.$thumbname . "' WHERE ids = '" . $userid . "' ";
			
			$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
			
		} 
			$sql = "INSERT INTO userimages SET private='$private', description='$description', title='$title', imagethumb = '" . $urldir.$thumbname . "', image = '" . $urldir.$filename . "', idkey = '" . $userid . "' ";
			$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());

		if ($res) {
			return 99;
		} else {
		}
	}
	
	return false;
}


?>