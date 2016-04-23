<?php
ini_set('display_errors', 1);
	require_once 'libs/functions.php';
	require_once 'libs/register.php';
	$email_error=0;
	$repeatemail_error=0;
	$password_error=0;
	$name_error=0;
	$success="";
	$birthday_error=0;
	$gender_error=0;
	$error_message="";
	$email="";
	$repeatemail="";
	$name="";
	$gender=2;	
	$day=0;
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
			
			if ($_POST["nickname"] === "") 
			{
				$name_error=1;
				$errMess= $errMess.'<li>'._('Name can not be empty').'</li>';
			} 
			if ($_POST["email"] === "") 
			{
				$errMess= $errMess.'<li>'._('Email can not be emprty or in wrong format').'</li>';
				$email_error=1;
			} 		
			if ($_POST["repeatemail"] != $_POST["email"]) 
			{
				$errMess= $errMess.'<li>'._('Both email do not match').'</li>';
				$repeatemail_error=1;
		
			} 

			
			if (!isDateValid ($_POST["year"],$_POST["month"],$_POST["day"]))	{
				$birthday_error=1;
				$errMess= $errMess.'<li>'._('Birthdate must be filled').'</li>';
			} 

			if ($repeatemail_error ||$email_error ||$name_error || $secerror || $birthday_error) {
				$error_message=_('Failed to create profile, please fix all fields marked with red');
				$error_message=$error_message.'<br><ul>'.$errMess.'</ul>';
			} else {
				$success=_('Successfully created your new profile, check your email for password. (also check SPAM folder). Good luck with searching');
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
