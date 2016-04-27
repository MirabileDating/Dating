<?PHP
function getProfile($userid) {
		
	$sql = "select name,city,state,country,gender,blocked,birthdate, w_gender from users where ids='$userid' limit 1";
	
	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());

	
	while ($a_row = sqlFetchArray($res)) {

		 
		$records["name"] = $a_row["name"];
		$records["city"] = $a_row["city"];
		$records["state"] = $a_row["state"];
		$records["country"] = $a_row["country"];
		if ($a_row["gender"] ==1) 
			$gender=_("Male");
		else 
			$gender=_("Female");
		if ($a_row["blocked"] ==0) 
			$approved=_("Approved");
		else 
			$approved=_("Waiting for approval before getting listed");		
		$from = new DateTime( $a_row["birthdate"]);
		$to   = new DateTime('today');
		
		$records["gender"] = $gender;
	    $records["approved"] = $approved;
		$records["age"] = $from->diff($to)->y." "._("years");


		if ($a_row["w_gender"] ==1) 
			$gender=_("Male");
		else 
			$gender=_("Female");
		$records["w_gender"] = $gender;
		
		
	}

	sqlFreeResult($res);

	if (!empty($records)) {
		return $records;
	}
}
?>