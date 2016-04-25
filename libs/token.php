<?PHP
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