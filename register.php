<?php

	require_once 'libs/functions.php';
	require_once 'libs/register.php';
	$email_error=0;
	$password_error=0;
	$name_error=0;
	$success="";
	$birthday_error=0;
	$gender_error=0;
	$error_message="";
	$email="";
	$name="";
	$gender=2;	
	if (isset($_SESSION["sessionid"]) && isloggedin($_SESSION["sessionid"])) {
		$logged_in=1;
		header("Location: member.php");
		return;
	} else {

		$T = new View('templates/register.tpl');
		$yearlist=yearList();
		$monthlist=monthList();
		$daylist=dayList();			
		$T->loadDefault(0);


		foreach ($yearlist as $i_name) {
			$T->block('/yearlist', array('name' => $i_name["name"],'value'=>$i_name["value"]));
		}
		foreach ($monthlist as $i_name) {
			$T->block('/monthlist', array('name' => _($i_name["name"]),'value'=>$i_name["value"]));
		}
		foreach ($daylist as $i_name) {
			$T->block('/daylist', array('name' => $i_name["name"],'value'=>$i_name["value"] ),TRUE);
		}
		echo $T->display(array('register' => 1,'success'=>$success,'name_error'=>$name_error,
		'password_error'=>$password_error,'email_error'=>$email_error,'error_message'=>$error_message,'gender_error'=>$gender_error,'birthday_error'=>$birthday_error,
		'email'=>$email,'gender'=>$gender,'name'=>$name,'A1'=>_('Register a new user'),
						'A2'=>_('Before you can join, you must give your name, age and email. Your email can not be seen. Your name and age is visible. The password is sent to your email') ,'A3'=>_('Nickname:')
						
		
		));
		
	}
?>
