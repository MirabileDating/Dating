<?php
	ini_set('display_errors', 1);
	require_once 'libs/functions.php';
	//require_once 'libs/member.php';
	$logged_in=0;

	if (isset($_SESSION["sessionid"]) && $myid=isloggedin($_SESSION["sessionid"])) {
	
		$logged_in=1;
		$T = new View('templates/member.tpl');
		$T->loadDefault($logged_in,$myid);


		echo $T->display(array('logged_in'=>$logged_in,'A1'=>_('No new profiles near you, look back later')
			));	
	} else {
		header("Location: login.php");
		return;
	}

?>
