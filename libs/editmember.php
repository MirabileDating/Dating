<?PHP
//Get option information lists
function getCountryList()
{
		
	$sql = "SELECT * FROM countries ORDER by countryname"; 
	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());

	$c=0;
	while ($a_row = sqlFetchArray($res)) {
		 $countrylist[$c]["country"] = $a_row["country"];
		 $countrylist[$c]["countryname"] = $a_row["countryname"];
	++$c;
    }
	if (isset($countrylist))
		return $countrylist;
}
function getStateList($country)
{

	$sql = "SELECT regionname,region FROM regions,countries WHERE countries.countryname = '$country' and regions.country=countries.country order by regionname";

	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
	
	$c=0;
	while ($a_row = sqlFetchArray($res)) {
		 $stateslist[$c]["id"] = $a_row["region"];
		 $stateslist[$c]["name"] = utf8_encode(html_entity_decode($a_row["regionname"]));
	++$c;
    }
	if (isset($stateslist))
		return $stateslist;
}
function getCityList($country,$state)
{
	$sql = "SELECT * FROM cities,regions,countries WHERE regions.regionname = '$state' and countries.countryname = '$country' and regions.region = cities.region and cities.country = countries.country and regions.country=countries.country order by city";
	
	
	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
	
	$c=0;
	while ($a_row = sqlFetchArray($res)) {
		 $citylist[$c]["id"] = $a_row["locId"];
		 $citylist[$c]["name"] =$a_row["city"];// utf8_encode(html_entity_decode($a_row["city"]));
	++$c;
    }
	if (isset($citylist))
		return $citylist;
}
function updateUser( $userid,  $name,$country,$region,$city)
{

	
	/*if (!validateName($nickname)) {
		return 3;
	}*/ 
		// Get remote IP

		//$location = getLocation($cityid);

		$sql = "UPDATE users SET name = '$name',country = '$country',state = '$region',city = '$city' WHERE ids ='$userid'" ;		
	
		$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
	return $res;
	
}

?>