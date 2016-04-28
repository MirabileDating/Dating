<?php
	require_once '/home/html/dating/libs/functions.php';
	$_POST = codeClean($_POST);
	$_GET = codeClean($_GET);	
	$country=$_GET['country'];
	$state=$_GET['state'];
	
	$sql = "SELECT locId,city FROM cities,regions,countries WHERE regions.region = '$state' and countries.countryname = '$country' and regions.region = cities.region and cities.country = countries.country and regions.country=countries.country order by city";	
	$data = array();
	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());

	while ($a_row = sqlFetchArray($res)) {
		$data[] = $a_row; 
	}
	echo json_encode($data);


	
?>