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
		$sql = "UPDATE users SET password = '" . $new_password . "' WHERE ids = '" . $userid . "'";
	}
	
 	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
}
function storeToken($email,$ids,$token)
{

		$sql = "INSERT INTO tokenreset ".
		"(idkey, email, token) ".
		"VALUES ('$ids','$email','$token')"; 

		try {
			$res = sqlQuery($sql); 
			$error = 1;
		} 
		catch (MySQLDuplicateKeyException $e) {
			$error = 8;
		}
		catch (MySQLException $e) {
			$error = 8;
		}
		catch (Exception $e) {
			$error = 8;
		
		}	
	
	if ($error > 1) {
		return false;	
	} else {
		return true;
	}
}
function tokenUpdatePassword($token,$password) {
	$sql = "SELECT idkey FROM tokenreset WHERE token = '$token'";
	$res = sqlQuery($sql);// or die(sqlErrorReturn());
	$a_row = sqlFetchArray($res);
	$ids = $a_row["idkey"];
	updatePass($ids,$password);
	deleteToken($token);
}
function deleteToken($token) {
	$sql = "DELETE from tokenreset WHERE token='$token'";
	$res = sqlQuery($sql); 
}
function verifyToken($token)
{

		$sql = "SELECT * FROM tokenreset WHERE token = '" . $token ."' ";

	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
	$num = sqlNumRows($res);

	if ($num > 0)
		return true;
	return false;	
}


?>
