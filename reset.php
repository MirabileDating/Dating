<?PHP
	ini_set('display_errors', 1);

	require_once 'libs/functions.php';
	require_once 'libs/reset.php';
	require_once 'libs/register.php';
	require_once 'libs/login.php';
	require_once 'libs/mail.inc.php';

	$tokenphase=0;
	$validtoken=0;
	$token="";
	$password1="";
	$password2="";
	//User is logged in and wants to change password
	$success="";
	$error=0;
	$error_message="";
	$myid="";
	$email="";
	$logged_in="";
	//Clean POST & GET
	$_POST = codeClean($_POST);
	$_GET = codeClean($_GET);
	if (isset($_SESSION["sessionid"]) && $myid=isloggedin($_SESSION["sessionid"])) {
		$logged_in=1;
	}
	if (isset($_GET["token"])) {
		$tokenphase=1;
		$token=$_GET["token"];
		
		if (verifyToken($token)) {
			$validtoken=1;
		} else { 
			$error_message=_('Token is invalid!'); 
			$error=1; 
		}
	} elseif (isset($_POST["change"]) && $logged_in) {
		$password1=$_POST["password1"];
		$password2=$_POST["password2"];
	
		
		if (strlen(trim($password1)) > 3) {
			if (strcmp($password1,$password2) ) {			
				$error_message=_('You must give the same password twice!'); 	
			} else {
				updatePass($myid,$_POST["password1"]);
				$success=_('You have successfully updated your password.');				
			}
		}
		else {
			$error=1; 
			$error_message=_('New password too short or not accepted.');
		}
	} elseif (isset($_POST["submit"])) {
		
		//Used token reset
		if (isset($_POST["token"])) {
			$token=$_POST["token"];
			$password1=$_POST["password1"];
			$password2=$_POST["password2"];
			if (strcmp($password1,$password2) ) {			
				$error_message=_('You must give the same password twice!'); 	
				$tokenphase=1;
				$validtoken=1;

			} else  {
				if (strlen(trim($password1))>3) {
					tokenUpdatePassword($token,$password1);
					$success=_('You have successfully updated your password.');			
				} else {
					$tokenphase=1;
					$validtoken=1;

					$error_message=_('Password must be more than 3 characters.'); 		
				}
				
			}

		} else {
			
		
		
			//if user not logged in show forgot password form
			if (validateEmail($_POST["email"])) {
				$email=	 $_POST["email"]; 
				$sql = "SELECT email,ids FROM users WHERE email = '" . $email . "'";
				$res = sqlQuery($sql);// or die(sqlErrorReturn());
			
				$a_row = sqlFetchArray($res);
				$email = $a_row["email"];

				if (!empty($email)) {
					$token=gen_uuid();
					$link =SERVERURL.WWWROOT.'/reset.php?token='.$token;
					//updatePass($myid,$pass,$email);
					
					$admin_name=EMAILNAME;
					$admin_email=EMAIL;
					//build email to be sent from lang file
					$body = preg_replace("!%USERNAME%!","$email",_('<br /><br />Hi %USERNAME%, click on %LINK% to set a new password.<br /><br />'));
					$body = preg_replace("!%LINK%!","$link", $body);
					$subject = preg_replace("!%URL%!",SERVERURL.WWWROOT,_('Forgotten username or password from %URL%'));
					if (storeToken($a_row["email"],$a_row["ids"],$token)) {
						$success=_('You will soon recieve an E-mail with password change instructions.');				
						sendEmail($email,$subject,$body,$admin_name,$admin_email);	
					} else {
						$error_message=_('You have already requested password reset, wait 1 hour between retries'); 
					}
					

				} else {	
					$error_message=$email._('That email do not exist as our user'); 
					$smail_error=1; 
				}
			} else {	
				$error_message=_('You must provide a valid E-mail.'); 
				$mail_error=1; 
			}
		}
	}


	$T = new View('templates/reset.tpl');

	$T->loadDefault($logged_in);
	$T->setglobals(array('token'=>$token
	));
	echo $T->display(array('A3' => _('Forgotten password')
		,'tokenphase'=>$tokenphase,'validtoken'=>$validtoken,'reset'=>1
		,'A2' => _('Reset'),'A4' => _('Your Email'),'error' => $error
		,'A5' => _('Did you forget your password? Provide us with the E-mail address you created your account with and your details will be sent to you.')
		,'A6' => _('Reset your forgotten password.'),'error_message' => $error_message,'success' => $success,'index' => 1, 'logged_in'=>$logged_in
		,'A1'=>_('Change your password.'),'A11'=>_('Update your password here. Just enter your old password, and your new password.')
		,'A7'=>_('Change your existing password.'),'A8'=>_('Submit'), 'A10'=>_('Old Password'),'A9'=>_('New Password'),'A12'=>_('Repeat Password')
		,'A13'=>_('Just enter your new password twice')
		));


?>