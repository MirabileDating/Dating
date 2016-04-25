<?PHP
	ini_set('display_errors', 1);

	require_once 'libs/functions.php';
	require_once 'libs/reset.php';
	require_once 'libs/register.php';
	require_once 'libs/mail.inc.php';
	require_once 'libs/token.php';

	//User is logged in and wants to change password
	$success="";
	$pass_error=0;
	$error_message="";
	$myid="";
	$email="";
	$logged_in=0;

	if (isset($_SESSION["sessionid"]) && $myid=isloggedin($_SESSION["sessionid"])) {
		$logged_in=1;
	}

	if (isset($_POST["change"])) {
		$_POST = codeClean($_POST);
		
		if (verifyLogin($myid,$email,$_POST["old_pass"],false,$lang)) {
		
			if (strlen(trim($_POST["new_pass"])) > 2) {
				updatePass($myid,$_POST["new_pass"]);
				$success=_('You have successfully updated your password.');
			}
			else {
				$pass_error=1; 
				$error_message=_('New password too short or not accepted.');
			}
		} else { 
			$error_message=_('Your old password does not match.'); 
			$pass_error=1; 
		}
	} elseif (isset($_POST["submit"])) {
		$_POST = codeClean($_POST);
		//if user not logged in show forgot password form
		if (validateEmail($_POST["email"])) {
			$email = codeClean($_POST["email"]); 
			  
			$sql = "SELECT email,ids FROM users WHERE email = '" . $email . "'";
			$res = sqlQuery($sql);// or die(sqlErrorReturn());
			$a_row = sqlFetchArray($res);
			$email = $a_row["email"];

			if (!empty($email)) {
				$token=gen_uuid();
				$link ='https://www.onnea.net/dating/token.php?token='.$token;
				//updatePass($myid,$pass,$email);
				
				$admin_name="Support";
				$admin_email="support@onnea.net";
				//build email to be sent from lang file
				$body = preg_replace("!%USERNAME%!","$email",_('<br /><br />Hi %USERNAME%, click on %LINK% to set a new password.<br /><br />'));
				$body = preg_replace("!%LINK%!","$link", $body);
				$subject = preg_replace("!%URL%!","http://www.onnea.net/dating",_('Forgotten username or password from %URL%'));
				if (storeToken($a_row["email"],$a_row["ids"],$token)) {
					$success=_('You will soon recieve an E-mail with password change instructions.');				
					sendEmail($email,$subject,$body,$admin_name,$admin_email);	
				} else {
					$error_message=_('You have already requested password reset, wait 1 hour between retries'); 
				}
				

			} else {	
				$error_message=_('That email do not exist as our user'); 
				$smail_error=1; 
			}
		} else {	
			$error_message=_('You must provide a valid E-mail.'); 
			$mail_error=1; 
		}
	}


	$T = new View('templates/reset.tpl');

	$T->loadDefault($logged_in);

	echo $T->display(array('A3' => _('Forgotten password'),
		'A2' => _('Reset'),'A4' => _('Your Email'),'pass_error' => $pass_error, 
		'A5' => _('Did you forget your password? Provide us with the E-mail address you created your account with and your details will be sent to you.'),
		'A6' => _('Reset your forgotten password.'),'error_message' => $error_message,'success' => $success,'index' => 1, 'logged_in'=>$logged_in, 
		'A1'=>_('Change your password.'),'A11'=>_('Update your password here. Just enter your old password, and your new password.'),
		'A7'=>_('Change your existing password.'),'A8'=>_('Submit'), 'A10'=>_('Old Password'),'A9'=>_('New Password')
		));


?>