<?PHP
function updatePass($userid,$pass,$email="")
{
	
	//Encrypt password for database
	$salt = 's+(_a*';

	$new_password = md5($pass.$salt);
	//if userid logged in change their session password 
	if (isset($_SESSION["pass"])) {
		$_SESSION["pass"] = "$new_password";
	}

	//if remember me function already set
	//change cookie for remember me
	if (isset($_COOKIE["pass"])) {
		
		setcookie("pass", "$pass", time() + (60*60*24*30));
	}

	//perform sqlQuery and update userid info in the database
	if (strlen(trim($email))>0) {
		$sql = "UPDATE users SET password = '" . $new_password . "' WHERE email = '" . $email . "'";
	} else
	{
		$sql = "UPDATE users SET password = '" . $new_password . "' WHERE idkey = '" . $userid . "'";
	}
	
 	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
}


?>
