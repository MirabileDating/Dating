<?php
ini_set('display_errors', 1);
	require_once 'libs/functions.php';
	require_once 'libs/register.php';
	require_once 'libs/mail.inc.php';
	$email_error=0;
	$repeatemail_error=0;
	$password_error=0;
	$name_error=0;
	$success="";
	$res=0;
	$birthday_error=0;
	$gender_error=0;
	$error_message="";
	$email="";
	$repeatemail="";
	$name="";
	$gender=2;	
	$day=0;
	$birthdate=0;
	$month=0;
	$year=0;	
	$secerror=0;
	$errMess="";
	if (isset($_SESSION["sessionid"]) && isloggedin($_SESSION["sessionid"])) {
		$logged_in=1;
		header("Location: member.php");
		return;
	} else {

		if (isset($_POST["submit"])) {
			$_POST = codeClean($_POST);
			$day=viewOnPage($_POST["day"]);
			$month=viewOnPage($_POST["month"]);
			$year=viewOnPage($_POST["year"]);
			$name=viewOnPage($_POST["nickname"]);			
			$email=viewOnPage($_POST["email"]);
			$repeatemail=viewOnPage($_POST["repeatemail"]);
	
			if (isset($_POST["gender"])) $gender=viewOnPage($_POST["gender"]);
			else {
				$gender_error=1;
				$errMess= $errMess.'<li>'._('Your gender must be given').'</li>';
			}
			if ($_POST["captcha"] != $_SESSION["security_code"]) 
			{
				$errMess= $errMess.'<li>'._('Code is wrong').'</li>';
				$secerror=1;
			} 
	
			if ($name === "") 
			{
				$name_error=1;
				$errMess= $errMess.'<li>'._('Name can not be empty').'</li>';
			} 
						
			if ($email === "") 
			{
				$errMess= $errMess.'<li>'._('Email can not be emprty').'</li>';
				$email_error=1;
			} elseif (!validateEmail($email)) {
				$email_error=1;
				$errMess= $errMess.'<li>'._('Email is in a wrong format').'</li>';
			}
			if ($email != $repeatemail) 
			{
				$errMess= $errMess.'<li>'._('Both email do not match').'</li>';
				$repeatemail_error=1;
			} 
	
			if (!isDateValid ($year,$month,$day))	{
				$birthday_error=1;
				$errMess= $errMess.'<li>'._('Birthdate must be filled').'</li>';
			} else {
				$birthdate = date("Y/m/d",mktime(0,0,0,$month,$day,$year));
			}

			if ($repeatemail_error ||$email_error ||$name_error || $secerror || $birthday_error) {
				//Do nothing
			} else {
				//Attempt to create profile
				$res = registerUser($name, $email,$gender,$birthdate   );
				switch ($res[0]) {
					case 1:
						$success=_('Successfully created your new profile, check your email for password. (also check SPAM folder). Good luck with searching');
						break;
					case 6:
						$email_error=1;
						$errMess= $errMess.'<li>'._('Email already exist as profile, choose a new email').'</li>';
						break;
				}
				
			}
			if ($res<>1) {
				$error_message=_('Failed to create profile, please fix all fields marked with red');
				$error_message=$error_message.'<br><ul>'.$errMess.'</ul>';
			}	
		} 
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
		$T->setGlobals(array('day'=>intval($day),'month'=>intval($month),'year'=>intval($year)));
		echo $T->display(array('register' => 1,'success'=>$success,'name_error'=>$name_error,'secerror'=>$secerror,'repeatemail_error'=>$repeatemail_error,'repeatemail'=>$repeatemail
		,'password_error'=>$password_error,'email_error'=>$email_error,'error_message'=>$error_message,'gender_error'=>$gender_error,'birthday_error'=>$birthday_error
		,'email'=>$email,'gender'=>$gender,'name'=>$name,'A1'=>_('Register a new user')
		,'A2'=>_('Before you can join, you must give your name, age and email. Your email can not be seen. Your name and age is visible. The password is sent to your email') ,'A3'=>_('Your name')
		,'A4'=>_('Birthday'),'A5'=>_('Gender'),'A6'=>_('Man'),'A7'=>_('Kvinna'),'A8'=>_('Email'),'A9'=>_('Repeat Email'),'A10'=>_('* denotes a required field.')
		,'A11'=>_('Repeat email'),'A12'=>_('Create account'),'A13'=>_('Enter Code')
		));
		
	}
?>
