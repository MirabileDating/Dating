<?php
ini_set('display_errors', 1);
define('ROOT_DIRECTORY', dirname(__FILE__).'/');
include_once ROOT_DIRECTORY.'db.inc.php';
if (!isset($_SESSION)) {
	session_name('love');
	ini_set('session.cookie_domain', DOMAIN);
	ini_set('session.save_path', TEMPDIR);
	session_start();
}
	if (isset($_GET["via_android"])) {
		$android = $_GET["via_android"];
	} else {
		$android = 0;
	}
	require_once('I18N.php');

	$languages=array(
    '/^se((-|_).*?)?$/i' => 'sv_SE',
	'/^fi((-|_).*?)?$/i' => 'fi_FI',
	'/^fr((-|_).*?)?$/i' => 'fr_FR',
	'/^es((-|_).*?)?$/i' => 'es_ES',
	'/^de((-|_).*?)?$/i' => 'de_DE',
	'/^ru((-|_).*?)?$/i' => 'ru_RU',
	'/^ar((-|_).*?)?$/i' => 'ar_EG',
	'/^zh((-|_).*?)?$/i' => 'zh_CN',
	'/^zh((-|_).*?)?$/i' => 'zh_TW',
	'/^ja((-|_).*?)?$/i' => 'ja_JP',
	'/^tl((-|_).*?)?$/i' => 'tl_PH'
		);
	$ipaddress = getenv('HTTP_CLIENT_IP')?:
			getenv('HTTP_X_FORWARDED_FOR')?:
			getenv('HTTP_X_FORWARDED')?:
			getenv('HTTP_FORWARDED_FOR')?:
			getenv('HTTP_FORWARDED')?:
			getenv('REMOTE_ADDR');
	$info = geoip_record_by_name($ipaddress);
	$country=	$info['country_code'];

	if (isset($_COOKIE["lang"])) {
		$lang = $_COOKIE["lang"];
	} else if (isset($_SESSION["lang"])) {
		$lang = $_SESSION["lang"];
	} else {
		$lang = getenv("GEOIP_COUNTRY_CODE");
		$lang =strtolower($lang);
		foreach ($languages as $acceptLanguageRegex => $languageIdentifier) {
			if (preg_match($acceptLanguageRegex, $lang)) {	
				$lang= $languageIdentifier;
			}
		}	
	}
if (strlen(trim($lang))>0) I18N::changeLanguage($lang);	
I18N::init('messages', ROOT_DIRECTORY.'i18n', 'en_US', array(
    '/^sv((-|_).*?)?$/i' => 'sv_SE',
	'/^fi((-|_).*?)?$/i' => 'fi_FI',
	'/^ru((-|_).*?)?$/i' => 'ru_RU'
));
if (isset($_SESSION["i18n_language_preference"])) {
	$lang = $_SESSION["i18n_language_preference"];
} else {
	$lang = "";
}

if (isset($_SESSION["sessionid"])) {
	lastActive($_SESSION["sessionid"],$lang);
} else {
	lastActive("guest",$lang);
}
function safeDir($path)
{
	$dirname = dirname($path);
	return $dirname == '/' ? '' : $dirname;
}

DEFINE("OAC_SERVER_PATH",(getenv("HTTPS")=="on"?"https://":"http://") . getenv("SERVER_NAME") ."" . safeDir($_SERVER['PHP_SELF']) . "/");
DEFINE("SITE_LANGUAGE","$lang");
DEFINE("DOCUMENT_CHARSET","utf-8");
DEFINE("OAC_VER","v1.6.5");

function viewOnPage($var)
{
	$output = '';
	if (is_array($var)) {
		foreach($var as $key => $val) {
			$output[$key] = viewOnPage($val);
    	}
    } else {
    	$var = htmlentities(trim($var), ENT_NOQUOTES, "UTF-8");
		if (function_exists("get_magic_quotes_gpc")) {
		   	$output = get_magic_quotes_gpc() ? stripslashes($var) : $var;
		} else {
			$output = $var;
		}
	}
	return $output;
}
//Check if magic qoutes is on then stripslashes if needed
function codeClean($var)
{
	$output = '';
    if (is_array($var)) {
		foreach($var as $key => $val) {
			$output[$key] = codeClean($val);
    	}
    } else {
		$var = strip_tags(trim($var));
		if (function_exists("get_magic_quotes_gpc")) {
			$output = sqlEscapeString(get_magic_quotes_gpc() ? stripslashes($var) : $var);
		} else {
			$output = sqlEscapeString($var);
		}
	}
	return $output;
}

function isloggedin($sessionid)
{
	$num=0;
	if (isset($sessionid) ) {
		$sql = "SELECT user_id FROM onlineusers WHERE session_id = '" . $sessionid ."'";

		$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
		$num = sqlFetchRow($res);
	}
	if (isset($num))
		return $num['0'];;

		session_destroy();

	if (isset($_COOKIE[session_name()])) {
    	setcookie(session_name(), NULL, time()-3600);
	}

	return false;
}


function logoff()
{
	global $visitor_tracking;

	//when logging off delete from the online users tables if user tracking is enabled
	if (!empty($visitor_tracking) && isset($_SESSION["user"])) {
		$sql = "DELETE FROM onlineusers WHERE user = '" . $_SESSION["user"] . "'";
		$del = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
	}

	// remove all session variables and destroy session
	unset($_SESSION["user"]);
	unset($_SESSION["pass"]);
	unset($_SESSION["sessionid"]);
	unset($_SESSION["logged_in"]);


	session_destroy();

	if (isset($_COOKIE["user"])) {
		setcookie("user", NULL, time()-3600);
		setcookie("pass", NULL, time()-3600);
	}

	if (isset($_COOKIE[session_name()])) {
    	setcookie(session_name(), NULL, time()-3600);
	}
}


//last active
function lastActive($sessionid,$setlang)
{

   if(isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])){
        $lang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
    } else {
		$lang = "";
	}
	if(isset($_SERVER["HTTP_USER_AGENT"])){
        $useragent = $_SERVER["HTTP_USER_AGENT"];
    } else {
		$useragent = "";
	}	
	$current_time = date("Y-m-d H:i:s");

	$ipaddress = getenv('HTTP_CLIENT_IP')?:
			getenv('HTTP_X_FORWARDED_FOR')?:
			getenv('HTTP_X_FORWARDED')?:
			getenv('HTTP_FORWARDED_FOR')?:
			getenv('HTTP_FORWARDED')?:
			getenv('REMOTE_ADDR');
	$info = geoip_record_by_name($ipaddress);

	$country=	$info['country_name'];
	$city=$info['city'];
	if(isset($_SERVER["HTTP_REFERER"])){
        $referer = $_SERVER["HTTP_REFERER"];
    } else {
		$referer = "";
	}	

	if(isset($_SERVER["REQUEST_URI"])){
        $lastaction = $_SERVER["REQUEST_URI"];
    } else {
		$lastaction = "";
	}	
	$state="";
	$countrycode=$info['country_code'];
	if (strlen($countrycode) > 1 && strlen($info['region']) > 1)
	{
		$state=geoip_region_name_by_code($countrycode, $info['region']);
	}
	//check if user is a guest or a logged in user
	//if logged in update the last active time in the users table and if activated the onlineusers table
	//if not logged in update the onlineusers table with correct guest info
	//checks for guest user first then checks if a user is logged in

	if ( $sessionid == 'guest') {
		//guest is viewing check if already listed using their ip address in onlineusers table
		$sql = "SELECT user_ip FROM onlineusers WHERE session_id = '" . $sessionid . "' AND user_ip = '" . $ipaddress . "' AND user_agent ='$useragent'";
		$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
		$num = sqlNumRows($res);
		if ($num > 0) {
			//if check showed result then perform an update to the onlineusers table
			$sql = "UPDATE onlineusers SET note = '$countrycode : $lang : $setlang', user_referer = '$referer', last_active = '" . $current_time . "' WHERE session_id = '" . $sessionid . "' AND user_ip = '" . $ipaddress . "' AND user_agent='$useragent'";
			$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
		} else {
			//if check failed insert result in to the onlineusers table
			$sql = "INSERT INTO onlineusers (session_id,last_active,user_ip,user_agent, user_country,user_state,user_city,user_referer,note) VALUES ".
			"('$sessionid', '$current_time', '$ipaddress','$useragent','$country','$state','$city','$referer','$countrycode : $lang : $setlang')";
			$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
		}
	} elseif ($sessionid == $_SESSION["sessionid"]) {

		$sql = "SELECT id FROM onlineusers WHERE session_id = '" . $sessionid . "'";
		$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
		$num = sqlNumRows($res);
		if ($num > 0) {

			//if check showed result then perform the update to the tables users and onlineusers
			$sql = "UPDATE users,onlineusers SET onlineusers.user_referer = '$referer',users.lastactive = '" . $current_time . "', onlineusers.last_active = '" . $current_time . "' WHERE onlineusers.user_id = users.ids AND session_id='$sessionid'";
			

		$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
		}
	}

	//perform some cleanup actions for the onlineusers table if visitor_tracking is enabled
	
		$sql = "DELETE FROM onlineusers WHERE last_active  < TIMESTAMPADD(HOUR,-24,NOW())";
		$del = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());

	
}

class View extends Blitz {

    function View($tmpl_name) {
		return parent::Blitz($tmpl_name);
    }
	function loadDefault($logged_in,$myid=0) {
		//Header
		global $android;
		$this->set(array('android'=>$android,'SITE_LANGUAGE' => SITE_LANGUAGE,'DOCUMENT_CHARSET' => DOCUMENT_CHARSET, 'OAC_SERVER_PATH' => OAC_SERVER_PATH,
			'H1'=>_('Onnea - dating.'), 'H2'=>_('Onnea - dating'),
			'H3'=>_('online dating, dating, love, online sex, sex, free dating, android dating, matchmaking, mobile dating'),'H9'=>_('Mirabile'),  'SH4'=>_('Start'),
			'H8'=>_('Start page'),'SH5'=>_('Logout'),'SH7'=>_('Register'),'SH6'=>_('Login')
		 ));
		 //Left Sidebar
		$this->set(array('logged_in'=>$logged_in,'S1'=>_('Menu'),'S2' =>_('Your matches'),'S3'=>_('Messages'),'S7'=>_('Profile'),'S9'=>_('Change password')));

		//Right Sidebar
		$this->set(array('logged_in'=>$logged_in,'RS1'=>_('New profiles'),'RS2' =>_('Last Logged in'),'RS3' =>_('Need to be logged in')));

		//Footer
		$this->set(array('F1'=>_('Onnea - dating'),'F3' => _('Copyright&copy;'),'F4' => _('Contact us'),'F2' => _('http://www.onnea.net/dating'),'F5' => _('Terms of Service'),'F6' => _('Privacy Policy')));
	}
}

?>
