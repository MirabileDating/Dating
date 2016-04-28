<?PHP
ini_set('display_errors', 1);
	require_once 'libs/functions.php';
	
	$_POST = codeClean($_POST);
	$_GET = codeClean($_GET);	
$site_lang="";

if (!isset($_SESSION)) {
	session_name('love');
	ini_set('session.cookie_domain', DOMAIN);
	ini_set('session.save_path', TEMPDIR);
	session_start();
}
function current_page_url(){
    $page_url   = 'http';
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
        $page_url .= 's';
    }
    return $page_url.'://'.$_SERVER['SERVER_NAME'];
}
if (isset($_GET["setLocale"])) {
	$site_lang=$_GET['setLocale'];
	setcookie("lang",$site_lang , time() + (60*60*24*30*3));	
	$_SESSION['lang']=$site_lang;
}

$server=isset($_SERVER['HTTP_REFERER']);
if ($server) {$server=strval($_SERVER['HTTP_REFERER']);} else {$server=current_page_url();};
header("Location: ".$server);
?>