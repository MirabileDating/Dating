<?PHP
	ini_set('display_errors', 1);
	require_once 'libs/functions.php';
	require_once 'libs/pictures.php';
	require_once 'libs/member.php';
	$logged_in=0;
	$irows=0;
	$error_message="";
	$success="";
	$_POST = codeClean($_POST);
	$_GET = codeClean($_GET);	
	if (isset($_GET["erri"]) && $_GET["erri"]) {
			$error_message=_('Max error');
	}	

	if (isset($_SESSION["sessionid"]) && $myid=isloggedin($_SESSION["sessionid"]) ) {
		$logged_in=1;
		
		
		if (isset($_POST["makemain"]))  {
			if (makemainUserImage($myid,$_POST["imagefull"],$_POST["image"],$_POST["imagethumb"])) {
				$success=_('You changed main picture');
			} else {
				$error_message=_('Failed to set new main picture');
			}
		}
		if (isset($_POST["delete"]))  {
		
			if (deleteUserImage($myid,$_POST["id"])) {
				$success=_('Deleted picture');
			} else {
				$error_message=_('Delete error');
			}
		}
		if (isset($_POST["addimage"]) && $error_message=="") {
			$_POST = codeClean($_POST);
			
			$res = uploadUserImage($_FILES["file"]["name"], $_FILES["file"]["tmp_name"], 2097152, $myid,$_POST["folder"],$_POST["title"],$_POST["description"]);
			if ($res == 99) {
				$success=_('Uploaded your new picture');
			} elseif ($res == 1) {
				$error_message=_('You can only have 6 public and 6 pictures');
			} elseif ($res == 2) {
				$error_message=_('Bad extension');
			} else {
				$error_message=_('Error uploading picture');
			}
		}
		$T = new View('templates/pictures.tpl');
		$T->loadDefault($logged_in);
		
		$userinfo=getProfile($myid);
		foreach (sqlGetUserImages($myid,0) as $i_name) {
			$irows++;
			if ($irows == 3) {
	
					$irows=0;
					$newrow=true;
			} else {
				$newrow=false;
			}
			if ($i_name['imagethumb']===$userinfo['imagethumb']) $mainpic=1;
			else $mainpic=0;
			$T->block('/gallerypubimg', array('name' => $i_name,'newrow'=>$newrow,'mainpic'=>$mainpic));
		}
		$irows=0;
		foreach (sqlGetUserImages($myid,1) as $i_name) {
			$irows++;
		
			if ($irows == 3) {
					$irows=0;
					$newrow=true;
			} else {
			$newrow=false;
			}
			$T->block('/galleryprivimg', array('name' => $i_name,'newrow'=>$newrow));
		}
		echo $T->display(array(
			'logged_in'=>$logged_in,'pictures'=>1,'folderlist'=>folderlist(),'error_message'=>$error_message
			,'success'=>$success,'SUBMIT'=>_('Save picture'),'EDIT_PROFILE_IMAGE_LEGEND'=>_('Upload pictures')
			,'YOUR_IMAGE'=>_('Your image'),'IMGTITLE'=>_('Image title'),'IMGDESC'=>_('Image description')
			,'FOLDER'=>_('Folder')
			));


	} else {
		header("Location: login.php");
		return;
	}
?>
