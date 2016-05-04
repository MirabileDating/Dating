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
	if (isset($_GET['page'])) {
		$page=$_GET['page'];
	} else {
		$page=1;
	}		
	if (isset($_POST['fromage'])) {
		$fromage=$_POST['fromage'];
	} else {
		$fromage=18;
	}		
	if (isset($_POST['toage'])) {
		$toage=$_POST['toage'];
	} else {
		$toage=110;
	}		
	if (isset($_POST['gender'])) {
		$gender=$_POST['gender'];
	} else {
		$gender=0;
	}		
	if (isset($_GET['gender'])) {
		$gender=$_GET['gender'];
	} 	

		$profile=getProfile($myid);
		$searchlist=getSearchList($genderid);
		$fromagelist=getAgeList(true);
		$toagelist=getAgeList(false);
		$longitude=$profile['longitude'];
		$latitude=$profile['latitude'];
		$listdata=searchUsers('all',$page,$longitude,$latitude,$fromage,$toage,$gender,$data);

		$T = new View('templates/search.tpl');
		$T->loadDefault($logged_in,$myid);		
			if (!empty($listdata)) {

				foreach($listdata as $i_item) {
		
					$T->block('/listdata', $i_item,TRUE);
				}
			} 	


		
		$T->setglobals(array(
			'gender'=>$gender,'fromage'=>$fromage,'toage'=>$toage
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
