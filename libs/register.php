<?PHP
function dayList() {
	$daylist[0]["name"] = "..";
	$daylist[0]["value"] = 0;
	for ($d=1;$d<=31;$d++) {
		$daylist[$d]["name"] = "$d";
		$daylist[$d]["value"] = $d;
	}
	return $daylist;
}

function monthList() {

	$monthlist[0]["name"] = ".."; 
	$monthlist[0]["value"] = "0";
    for( $i = 1; $i <= 12; $i++ ) {
        $monthlist[$i]["value"] = $i;
        $monthlist[$i]["name"] = date( 'F', mktime( 0, 0, 0, $i , 1  ) );
	}	
	return $monthlist;
}

function yearList() {
	$maxAge = "99";
	$minAge = "18";
	$thisYear = strftime("%Y",time()) - $minAge;
	$thatYear = $thisYear - $maxAge;
	 
	$yearlist[0]["name"] = "..";
	$yearlist[0]["value"] = 0;
	$c=1;
	for ($y=$thisYear;$y>=$thatYear;$y--) {
		$yearlist[$c]["name"] = "$y";
		$yearlist[$c]["value"] = $y;
		$c++;
	}
	return $yearlist;
}
function isDateValid($year,$month,$day)
{
	$isValid = checkdate($month, $day, $year);
	return $isValid;
}
function validateName($name)
{
	$first = substr($name, 0, 1);
	if ($first == '.' || $first == '-' || $first == '_') {
		return false;
	}

	//if slashes are added remove them since this doesn't go in the db and we don't want names with \
	$name = str_replace('\\', '', $name);
	$valueStrLen = strlen($name);
    if ($valueStrLen < 3) {
        return false;
    }

	if (preg_match('!^[a-zA-Z\']+$!', $name))
    	return true;
	return false;
}
function validateEmail($email)
{
	if (preg_match("!^[a-zA-Z0-9]+([_\\.-][a-zA-Z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,4}$!", $email))
   		return true;
	return false;
}
function checkIfGender($gender)
{
	if ($gender=="") {
		return false;
	} else {
		return true;
	}
}
function isEmpty($value)
{
	$valueStrLen = strlen($value);
    if ($valueStrLen < 1) {
        return TRUE;
    }  else {
        return FALSE;
    }

}
function generatePassword($len)
{
	$password = "";
	$char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

	$c=0;
	while ($c <= $len) {
		$random = rand(1,strlen($char));
		$password .= substr($char,$random -1,1);
	++$c;
	}

	if (!empty($password))
	    return $password;//echo $password;
}
function checkIfEmail($email)
{

		$sql = "SELECT * FROM users WHERE email = '" . $email ."' ";

	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
	$num = sqlNumRows($res);

	if ($num > 0)
		return true;
	return false;	
}
function getCityID($cityid,$special)
{

	if ($special==1) {

		$sql = "SELECT locId,city,longitude,latitude FROM g_location WHERE city='".getenv("GEOIP_CITY")."' AND region='".getenv("GEOIP_REGION")."' AND country='".getenv("GEOIP_COUNTRY_CODE")."'" ;

	} else {
		$sql = "SELECT locId,city,longitude,latitude FROM g_location WHERE locId='$cityid'" ;
	}

	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());

		$records[0]["locId"] = "";
		$records[0]["city"] = "";
		$records[0]["longitude"] = "";
		$records[0]["latitude"] = "";


	$c=0;
	while ($a_row = sqlFetchArray($res)) {
		$records[$c]["locId"] = $a_row["locId"];
		$records[$c]["city"] = $a_row["city"];
		$records[$c]["longitude"] = $a_row["longitude"];
		$records[$c]["latitude"] = $a_row["latitude"];
	++$c;
    }
	if (!empty($records))
	    return $records;
}
function registerUser($name,  $email, $gender,$birthdate)
{
	global $admin_name;
	global $admin_email;
	$imagelarge="";
	$imagethumb="";
	$image="";
	
	//todo work out better error handling routine
	if (!validateName($name))	{
		$error[] = 2;
	} 
	   
    $then = strtotime($birthdate);
   
    $min = strtotime('+18 years', $then);
   
    if(time() < $min)  {
        $error[] = 3;
    }
	if (!validateEmail($email)) {
	
		$error[] = 4;
	} 
	$reg_date = date("Y-m-d H:i:s");	
	if($gender=="2") $error[] = 5;

	if (checkIfEmail($email)) {
		$error[] = 6;
	} 
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	
	if ($error) {

		return $error;
	} else {

		//if blank password one is generated then the details are emailed
		
		$pass = generatePassword(6);

		//$body = preg_replace("!%USERNAME%!", "$email", ACCT_SIGNUP_BODY);
		$body = __('Hi %1$s. <br/>Your password is %2$s. <br/><br/>Please login at %3$s',$name,$pass,'http://www.onnea.net/dating');
	
		//build email to be sent from lang file
		$body = preg_replace("!%PASSWORD%!", "$pass", $body);
		//$body = preg_replace("!%URL%!", "$site_url/login.php", $body);
		$body = preg_replace("!%URL%!", OAC_SERVER_PATH."login.php", $body);
		//$subject = preg_replace("!%URL%!", "$site_url", _('Welcome to Soccer manager'));
		$subject = preg_replace("!%URL%!", OAC_SERVER_PATH, _('Welcome to Onnea - Dating'));
		$subject = preg_replace("!%USERNAME%!", "$email", $subject);
		//The last part of the email is at the bottom!!

		$reg_date = date("Y-m-d H:i:s");
		
		
	  	//Encrypt password for database
	    $salt = 's+(_a*';
		
		$pass = md5($pass.$salt);
	
		// get default values
		$ip = getenv('HTTP_CLIENT_IP')?:
			getenv('HTTP_X_FORWARDED_FOR')?:
			getenv('HTTP_X_FORWARDED')?:
			getenv('HTTP_FORWARDED_FOR')?:
			getenv('HTTP_FORWARDED')?:
			getenv('REMOTE_ADDR');
		$info = geoip_record_by_name($ip);
		$GEOIP_CITY = $info['city'];
		$GEOIP_COUNTRY_NAME = $info['country_name'];
		$GEOIP_COUNTRY_CODE= $info['country_code'];
		$GEOIP_REGION = $info['region'];
		$GEOIP_LATITUDE = $info['latitude'];
		$GEOIP_LONGITUDE = $info['longitude'];
		
		$GEOIP_CONTINENT_CODE = $info['continent_code'];
		$GEOIP_METRO_CODE = $info['continent_code'];
		$GEOIP_DMA_CODE = $info['dma_code'];
		$GEOIP_AREA_CODE = $info['area_code'];
		$GEOIP_POSTAL_CODE = $info['postal_code'];
		$tz= geoip_time_zone_by_country_and_region($GEOIP_COUNTRY_CODE, $GEOIP_REGION);
		if (strlen(trim($GEOIP_COUNTRY_CODE)) >0 and strlen(trim($GEOIP_REGION)) >0)
		{
			
			$GEOIP_REGION_NAME = geoip_region_name_by_code($GEOIP_COUNTRY_CODE, $GEOIP_REGION);
		} else {
			
			$GEOIP_REGION_NAME="";
		}	
				
		if ($GEOIP_COUNTRY_NAME == "") { $GEOIP_COUNTRY_NAME = "Germany";}
		//$locId = getCityID($GEOIP_CITY,1);
		//get default user level set by admin and insert
		if ($gender==1) {
			$gender=1;
			$wantgender=0;
		} else {
			$gender=0;
			$wantgender=1;
		}
		$ids=gen_uuid();
		$sql = "INSERT INTO users ".
		"(ids, password, email, name,gender,w_gender) ".
		"VALUES ('$ids','$pass','$email', '$name', '$gender','$wantgender')"; 
		
		//
		try {
			$res = sqlQuery($sql); 
			$error[] = 1;
			$sql = "INSERT INTO userimages (imagethumb,image,imagebig,mainimage,idkey) VALUES ('$imagethumb','$image','$imagelarge',1,'$ids')";
		//	$res = sqlQuery($sql); 	
		} 
		catch (MySQLDuplicateKeyException $e) {
			$error[] = 8;
			return $error;
		}
		catch (MySQLException $e) {
			$error[] = 8;
			return $error;

		}
		catch (Exception $e) {
			$error[] = 8;
			return $error;
		}		

		
		sendEmail($email,$subject,$body,$admin_name,$admin_email);
		return $error;
	}
}
?>