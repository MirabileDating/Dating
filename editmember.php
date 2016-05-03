<?php
	ini_set('display_errors', 1);
	require_once 'libs/functions.php';
	require_once 'libs/editmember.php';
	
	$logged_in=0;
	$_POST = codeClean($_POST);
	$_GET = codeClean($_GET);
	if (isset($_SESSION["sessionid"]) && $myid=isloggedin($_SESSION["sessionid"])) {
	
		$logged_in=1;
		if (isset($_POST["submit"])) {
			$name=$_POST["name"];
			$country=$_POST["country"];
			$region=$_POST["state"];
			$city=$_POST["city"];
			$res = updateUser($myid,$name,$country,$region,$city);			
		}
		
		
		$profile=getProfile($myid);
		$countrylist= getCountryList();
		$statelist=getStateList($profile['country']);
		$citylist=getCityList($profile['country'],$profile['state']);
		$T = new View('templates/editmember.tpl');
		$T->loadDefault($logged_in,$myid);
		
		$T->setglobals(array(
					'profile'=>$profile
		));	
		echo $T->display(array(
			'logged_in'=>$logged_in,'A1'=>_('Edit profile information'), 'A2'=>_('Gender'), 'A3'=>_('Name'), 'A4'=>_('Country'), 'A5'=>_('State')
			, 'A6'=>_('City'),'editprofile'=>1,'A7'=>'Save','countrylist'=>$countrylist, 'statelist'=>$statelist, 'citylist'=>$citylist
			,'A8'=>_('Choose country'),'A9'=>_('Choose state'),'A10'=>_('Choose city')			
			));	
	} else {
		header("Location: login.php");
		return;
	}

?>
