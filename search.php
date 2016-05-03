<?php
	ini_set('display_errors', 1);
	require_once 'libs/functions.php';
	require_once 'libs/search.php';
	$logged_in=0;
	$genderid="";
	$_POST = codeClean($_POST);
	$_GET = codeClean($_GET);
	if (isset($_SESSION["sessionid"]) && $myid=isloggedin($_SESSION["sessionid"])) {
	
		$logged_in=1;
	if (isset($_GET['data'])) {
		$data=$_GET['data'];
	} else {
		$data="";
	}		
		$profile=getProfile($myid);
		$searchlist=getSearchList($genderid);
		$fromagelist=getAgeList(true);
		$toagelist=getAgeList(false);
		$listdata=searchUsers('all',1,10000,18,99,0,$data);
		
		$T = new View('templates/search.tpl');
		$T->loadDefault($logged_in,$myid);		
			if (!empty($listdata)) {

				foreach($listdata as $i_item) {
		
					$T->block('/listdata', $i_item,TRUE);
				}
			} 	


		
		$T->setglobals(array(
			
		));	
		echo $T->display(array(
			'profile'=>$profile
			,'logged_in'=>$logged_in,'A1'=>_('Search'), 'A2'=>_('Gender'), 'A3'=>_('Age'), 'A4'=>_('State'), 'A5'=>_('Country')
			,'A7'=>_('Age'),'A8'=>_('Looking for a'),'searchlist'=>$searchlist,'fromagelist'=>$fromagelist,'toagelist'=>$toagelist
			,'paginator'=>PAGER::getInstance()->getProperty()
			));	
	} else {
		header("Location: login.php");
		return;
	}

?>
