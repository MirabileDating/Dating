<?php

require_once 'class.phpmailer.php';

function checkSMTP() 
{
	return 1;
}

function getSMTPSettings() 
{

	//get mail settings from env table in DB
	$settings["Host"]       = "localhost";  // SMTP server
	$settings["SMTPDebug"]  = 0; //SMTP debug information (for testing)
								 // 1 = errors and messages
								 // 2 = messages only
	$settings["Port"]       = 25;  // set the SMTP port
	$settings["Username"]   = "root";  // SMTP account username
	$settings["Password"]   = "123edcqq"; 

	if (!empty($settings)) {
		return $settings;
	} else {
		return false;
	}
}

function sendEmail($ToEmail,$Subject,$Body,$From,$FromEmail)
{

	$Body = preg_replace("!<br \/>!","\n",$Body);



	$mail = new PHPMailer();
	$mail->ContentType = 'text/plain';
	
	//setup mailer enviorment
	$mail->IsHTML(false);
	$mail->CharSet = DOCUMENT_CHARSET;
	
	//setup to and from
	$mail->AddAddress($ToEmail);
	$mail->SetFrom("$FromEmail", "$From");
	$mail->AddReplyTo("$FromEmail", "$From");
	

	if (checkSMTP()) {
		$mail->IsSMTP();                           // telling the class to use SMTP
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		
		$mailer = getSMTPSettings();               // get local settings from function
		$mail->Host       = $mailer["Host"]; 	   // SMTP server
		$mail->SMTPDebug  = $mailer["SMTPDebug"];  // enables SMTP debug information (for testing)
	    	                                       // 1 = errors and messages
	        	                                   // 2 = messages only
	
		$mail->Port       = $mailer["Port"];       // set the SMTP port for the GMAIL server
		$mail->Username   = $mailer["Username"];   // SMTP account username
		$mail->Password   = $mailer["Password"];   // SMTP account password
	}
	
	$mail->Subject = "$Subject";
	$mail->Body = "$Body";

	
	$mail->Send();
	

}

//check contact us form for submission errors
function checkSubmitForm($from_email,$from_name,$subject,$msg,$captcha,$security_code)
{
	$error = '';
	if (!validateEmail($from_email)){
		$error[] = 1;
	}
	if (empty($from_name)) {
		$error[] = 2; 
	}
	if (empty($subject)) {
		$error[] = 3;
	}
	if (empty($msg)) {
		$error[] = 4;
	}
	if (!empty($security_code) && $security_code !== $captcha) {
		$error[] = 5;
	}
	if (empty($captcha)) {
		$error[] = 6;
	} 
	if ($error) {
		return $error;
	} else {
		return 99;
	}
}

?>
