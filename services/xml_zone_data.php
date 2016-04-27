<?php


	require_once '/home/html/dating/libs/functions.php';
	$country=$_GET['country'];
	$sql = "SELECT regionname,region FROM regions,countries WHERE countries.countryname = '$country' and regions.country=countries.country order by regionname";
	$data = array();
	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());

	while ($a_row = sqlFetchArray($res)) {
		$data[] = $a_row; 
	}
	echo json_encode($data);


?>