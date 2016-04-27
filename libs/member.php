<?PHP
function sqlGetUserImages($userid,$private) {

	$sql = "SELECT * FROM userimages WHERE idkey = '" . $userid . "' and private='" . $private . "' ";

	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
	$c=0;
	while ($a_row = sqlFetchArray($res)) {
		if ($a_row["private"]=="1") {
			$records[$c]["id"] = $a_row["id"];
			$records[$c]["image"] = $a_row["image"];
			$records[$c]["imagethumb"] = $a_row["imagethumb"];
			$records[$c]["title"] = $a_row["title"];
			$records[$c]["description"] = $a_row["description"];
		} else {
			$records[$c]["id"] = $a_row["id"];
			$records[$c]["image"] = $a_row["image"];
			$records[$c]["imagethumb"] = $a_row["imagethumb"];
			$records[$c]["title"] = $a_row["title"];
			$records[$c]["description"] = $a_row["description"];
		}

		++$c;
	}
	
	sqlFreeResult($res);

		if (!empty($records)) {
			return $records;
		}	else {
			$records[0]["title"]  ="No image";
			$records[0]["description"] ="This user have no image.<br><a href='useredit.php'>"._('Add as Main image')."</a>";
			$records[0]["image"] = "/images/no_user.jpg";
			$records[0]["imagethumb"] = "/images/no_user.jpg";
			return $records;
		}


}
?>