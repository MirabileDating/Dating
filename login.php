<?php
	require_once 'libs/functions.php';
	require_once 'libs/login.php';
	$logoff=0;
	if (isset($_GET["logoff"]) || isset($_POST["logoff"])) {
		$logoff=1;
		logoff();
		header("Location: index.php");
		return;
	}
	
	if (isset($_SESSION["sessionid"]) && isloggedin($_SESSION["sessionid"])) {
		$logged_in=1;
		header("Location: member.php");
		return;
	} else {
		$email = "";
		$pass = "";
		$error_message="";
		$formremember="";
		$email_error="";
		if (isset($_POST["submit"]) ) {
			$_POST = codeClean($_POST);
			if (verifyLogin($_POST["email"],$_POST["pass"],$lang)) {
				//set persistant cookie for remember me function
				if (isset($_POST["remember"])) {
						echo "RREMEMBER";
					setcookie("remember", $_POST["remember"], time() + (60*60*24*30));
					setcookie("pass", $_POST["pass"], time() + (60*60*24*30));
					setcookie("email", $_POST["email"], time() + (60*60*24*30));
				
				} else {
					setcookie("remember", "");
					setcookie("pass", "");
				}

				header("Location: member.php");


			} else {
				if ($_POST["email"] == "") {
					$email_error=$_POST["email"];
					$error_message=_('You must enter a valid email!');
				} else {
					$error_message=_('There was an error with your login please check your username and password then, try again.');
				}

			}
		}
		$T = new View('templates/login.tpl');
		$T->loadDefault(0);
		echo $T->display(array('logout'=>$logoff,'login' => 1,'email_error'=>$email_error,'error_message'=>$error_message,'formremember'=>$formremember,'password'=>$pass,'email'=>$email,'A5'=>_('Password:')
		,'A4'=>_('Email/Name'),'A10'=>_('Retrieve it now'),'A3'=>_('Login')
		,'A2'=>_('Login to find someone!. If you do not already have an account you can register for one. Once you have registered you can come back here and login.')
		,'A1'=>TITLE,'A7'=>_('Enter your email and password to login.'),'A8'=>_('Remember me next time!'),'A9'=>_('Forgot your password?')

		));
	}
?>
