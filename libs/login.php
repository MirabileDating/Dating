<?PHP
//Login functions
function createSession($sessionid,$userid,$setlang)
{           
	
	if(isset($_SERVER["REMOTE_ADDR"])){
        $userip = $_SERVER["REMOTE_ADDR"];
    } else {
		$userip = "0.0.0.0";
	}	
	if(isset($_SERVER["HTTP_USER_AGENT"])){
        $useragent = $_SERVER["HTTP_USER_AGENT"];
    } else {
		$useragent = "";
	}	
    $ip = getenv('HTTP_CLIENT_IP')?:
			getenv('HTTP_X_FORWARDED_FOR')?:
			getenv('HTTP_X_FORWARDED')?:
			getenv('HTTP_FORWARDED_FOR')?:
			getenv('HTTP_FORWARDED')?:
			getenv('REMOTE_ADDR');
				$info = geoip_record_by_name($ip);
	$lastactive = date("Y-m-d H:i:s");
	$country=	$info['country_name'];
	
	$city=$info['city'];
	$referer= getenv('HTTP_REFERER');
	$countrycode=$info['country_code'];
	$regioncode=$info['country_code'];
	if (strlen(trim($countrycode)) >0 and strlen(trim($regioncode)) >0)
	{

		$state = geoip_region_name_by_code($countrycode, $regioncode);
	} else {
		
		$state="";
	}	
	

   if(isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])){
		$lang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
    } else {
		$lang = "";
	}
	$sql = "SELECT id FROM onlineusers where user_id='$userid'";

	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
	$num = sqlNumRows($res);
	if ($num>0) {
		$sql = "DELETE FROM onlineusers where user_id='$userid'";
		$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
	}
	$sql = "INSERT INTO onlineusers (session_id,user_ip,user_agent,last_active,user_id, user_country,user_state,user_city,user_referer,note) VALUES ".
	"('$sessionid','$userip','$useragent', '$lastactive', '$userid','$country','$state','$city','$referer','$countrycode : $lang : $setlang')";
	
	echo $sql;

	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
	$_SESSION["sessionid"] = $sessionid;

}
function verifyLogin($userid,$pass,$thelang)
{

	$num=0;

	if (isset($userid) && isset($pass)) {
		
		//Encrypt password for database verification
		$salt = 's+(_a*';
		$pass = md5($pass.$salt);

		$sql = "SELECT ids FROM users WHERE password = '" . $pass . "' AND (name = '" . $userid ."' OR email='$userid')";
		
		$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
		$num = sqlNumRows($res);
		session_regenerate_id();
	
	} 
	$c=0;
	while ($a_row = sqlFetchArray($res)) {
		createSession(session_id(),$a_row["ids"],$thelang);
		++$c;
    }
	if ($num > 0)
	{
		return true;
	} else {
		return false;	
	}
}
?>