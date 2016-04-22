<?php
// user defined. corresponding MySQL errno for duplicate key entry
const MYSQL_DUPLICATE_KEY_ENTRY = 1062;

// user defined MySQL exceptions
class MySQLException extends Exception {}
class MySQLDuplicateKeyException extends MySQLException {}


//CHANGE THESE PARAMS
$socket="/run/mysqld/mysqld.sock";
define('DOMAIN', '.onnea.net');
define('TEMPDIR', '/tmp');
$port=0;
$dbhost = "p:localhost";
$dbuser = "dating";
$dbpass = "dating";
$dbname = "dating";
//END

$db_link = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $port, $socket);

if (mysqli_connect_error()) {
	die(_('Failed to connect to the database'));
	exit();
}
if (!@mysqli_select_db($db_link,$dbname)) {
	die(_('Could not find the database'));
	exit();
}
	sqlQuery("SET profiling = 1;");
function gen_uuid() {
    return sprintf( '%04x%04x%04x%04x%04x%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}
function sqlDebug($file,$line,$error)
{
	global $setSQLDebug;
	$err1 = "INSERT INTO php_errors (file, row, description, period) VALUES ('$file', '$line', '".sqlEscapeString(trim($error))."', ".time().")";

	sqlQuery($err1);
	
	if ($setSQLDebug == 1) {
		die("<h1>Fatal Error:</h1><p>Error File: " . $file . " on line: " . $line . " : " . $error . "</p>");
	} else {
		return false;
	}
}


// SQL remapper take and create functions for different types of databses
function sqlEscapeString($var)
{
	global $db_link;
	$res = mysqli_real_escape_string($db_link,$var);
	return $res;
}

function sqlQuery($sql)
{
	global $db_link;
	$res = @mysqli_query($db_link,$sql);
	   if (!$res) {
        $errno = mysqli_errno($db_link);
        $error = mysqli_error($db_link);
	
        switch ($errno) {
        case MYSQL_DUPLICATE_KEY_ENTRY:
            throw new MySQLDuplicateKeyException($error, $errno);
            break;
        default:
            throw new MySQLException($error, $errno);
            break;
        }
       
            
 
    }
	return $res;
}
function sqlQuery1($sql)
{
	global $db_link;
	$res = @mysqli_query($db_link,$sql);
	return $res;
}
function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}
function sqlAffectedRows()
{
	global $db_link;
	$num=mysqli_affected_rows($db_link);
	return $num;
}

function sqlFetchRow($res)
{
	$row = mysqli_fetch_row($res);
	return $row;
}

function sqlFetchAssoc($sql)
{
	$res = mysqli_fetch_assoc($sql);
	return $res;
}

function sqlFetchArray($res)
{
	$array = mysqli_fetch_array($res);
	return $array;
}

function sqlNumRows($res)
{
	$num = mysqli_num_rows($res);
	return $num;
}
function sqlErrorNr()
{
	global $db_link;
	$res = mysqli_errno($db_link);
	return $res;
}
function sqlErrorReturn()
{
	global $db_link;
	$res = mysqli_error($db_link);
	return $res;
}
function sqlClose()
{
	global $db_link;
	$res=mysqli_close($db_link);
	return $res;
}

function sqlFreeResult($res)
{
	$res = mysqli_free_result($res);
	return $res;
}

function sqlLastInsert()
{
	global $db_link;
	$res = mysqli_insert_id($db_link);
	return $res;
}
?>