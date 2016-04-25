<?PHP
	ini_set('display_errors', 1);

	require_once 'libs/functions.php';
	require_once 'libs/token.php';


	//User is logged in and wants to change password
	$success="";
	$pass_error=0;
	$error_message="";
	$myid="";
	$email="";
	$validtoken=0;

	if (isset($_SESSION["sessionid"]) && $myid=isloggedin($_SESSION["sessionid"])) {
		$logged_in=1;
	}

	if (isset($_GET["token"])) {
		$_POST = codeClean($_POST);
		
		if (verifyToken($_GET["token"])) {
		$validtoken=1;
		
		} else { 
			$error_message=_('Your old password does not match.'); 
			$pass_error=1; 
		}
	} 



	$T = new View('templates/token.tpl');

	$T->loadDefault($validtoken);

	echo $T->display(array('A3' => _('Forgotten password'),
		'A2' => _('Reset'),'A4' => _('Your Email'),'pass_error' => $pass_error, 
		'A5' => _('Did you forget your password? Provide us with the E-mail address you created your account with and your details will be sent to you.'),
		'A6' => _('Reset your forgotten password.'),'error_message' => $error_message,'success' => $success,'index' => 1, 'validtoken'=>$validtoken, 
		'A1'=>_('Change your password.'),'A11'=>_('Update your password here. Just enter your old password, and your new password.'),
		'A7'=>_('Change your existing password.'),'A8'=>_('Submit'), 'A10'=>_('Password'),'A9'=>_('Repeat password')
		));


?>