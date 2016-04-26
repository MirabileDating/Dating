<?php
	ini_set('display_errors', 1);
	require_once 'libs/functions.php';
	require_once 'libs/search.php';
	$logged_in=0;

	if (isset($_SESSION["sessionid"]) && $myid=isloggedin($_SESSION["sessionid"])) {
	
		$logged_in=1;
		
		$profile=getProfile($myid);
		
		
		$T = new View('templates/search.tpl');
		$T->loadDefault($logged_in,$myid);

		$T->setglobals(array(
			'logged_in'=>$logged_in,'A1'=>_('Profile status'), 'A2'=>_('Gender'), 'A3'=>_('City'), 'A4'=>_('State'), 'A5'=>_('Country'), 'A6'=>_('Name'),'A7'=>_('Age'),'A8'=>_('Looking for a')
		));	
		echo $T->display(array(
			'profile'=>$profile
			));	
	} else {
		header("Location: login.php");
		return;
	}

?>
