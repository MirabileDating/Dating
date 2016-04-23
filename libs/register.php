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
?>