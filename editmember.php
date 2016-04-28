<?php
	ini_set('display_errors', 1);
	require_once 'libs/functions.php';
	require_once 'libs/editmember.php';
function dayList() {
	$daylist[0]["name"] = "..";
	$daylist[0]["value"] = 0;
	for ($d=1;$d<=31;$d++) {
		$daylist[$d]["name"] = "Finland";
		$daylist[$d]["value"] = "Finland";
	}
	return $daylist;
}	
	$logged_in=0;
	$_POST = codeClean($_POST);
	$_GET = codeClean($_GET);
	if (isset($_SESSION["sessionid"]) && $myid=isloggedin($_SESSION["sessionid"])) {
	
		$logged_in=1;
		
		$profile=getProfile($myid);
		
		
		$T = new View('templates/editmember.tpl');
		$T->loadDefault($logged_in,$myid);

		$daylist=dayList();			


		
		foreach ($daylist as $i_name) {
			$T->block('/daylist', array('name' => $i_name["name"],'value'=>$i_name["value"] ),TRUE);
		}
		
		$T->setglobals(array(
			'logged_in'=>$logged_in,'A1'=>_('Edit profile information'), 'A2'=>_('Gender'), 'A3'=>_('Name'), 'A4'=>_('Country'), 'A5'=>_('State')
			, 'A6'=>_('City'),'editprofile'=>1
		));	
		echo $T->display(array(
			'profile'=>$profile
			));	
	} else {
		header("Location: login.php");
		return;
	}

?>
