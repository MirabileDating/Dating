<?PHP
class Pager {
	const PAGESIZE=5; //Rows per page
	const MAXRANGE = 10; //Max pages
	private static $instance;
	private $m_sSQL="";
	private $prop1 = "";
	private $m_iPage=0;
	private $m_iRows=0;
	public static function getInstance() {
		if(!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	public function rows($rows) {
		$this->m_iRows=$rows;
	}
	public function page($page) {
		$this->m_iPage = $page;
	}
	public function setsql($data) {
		$this->m_sSQL=rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}
	public function endpage() {
		return self::PAGESIZE;
	}
	public function startpage($page) {
		$thepage=intval($page);
		if ($thepage<2) {
			return 0;
		} else {
			return $thepage*self::PAGESIZE-self::PAGESIZE;
		}
	}

    public function getProperty()
    {
		$line="";
		$currentpage=$this->m_iPage;
		$range=ceil($this->m_iRows/self::PAGESIZE);
		if ($range > self::MAXRANGE) { $range=self::MAXRANGE;}
		for ($x = ($currentpage - $range); $x < (($currentpage + $range)  + 1); $x++) {
			if ($x==1) {
				if ($x == $currentpage) {

				} else {
					$line= $line . " <a href='{$_SERVER['PHP_SELF']}?page=1&data=".$this->m_sSQL."'><</a> ";
					$line= $line . " <a href='{$_SERVER['PHP_SELF']}?page=".($currentpage-1)."&data=".$this->m_sSQL."'><<</a> ";
				}

			}
			if (($x > 0) && ($x <= $range)) {
				if ($x == $currentpage) {
					$line= $line . " [<b>$x</b>] ";
				} else {
					$line= $line . " <a href='{$_SERVER['PHP_SELF']}?page=$x&data=".$this->m_sSQL."'>$x</a> ";
				}
			}
			if ($x==$range) {
				if ($x == $currentpage) {

				} else {
					$line= $line . " <a href='{$_SERVER['PHP_SELF']}?page=".($currentpage+1)."&data=".$this->m_sSQL."'>>></a> ";
					$line= $line . " <a href='{$_SERVER['PHP_SELF']}?page=$range&data=".$this->m_sSQL."'>></a> ";
				}
			}
		}
        return "Found:" . $this->m_iRows . " " . $line ;
    }
}

function getSearchList($genderid) {
	$searchlist[0]["name"] = _("Male"); 
	$searchlist[0]["value"] = "1";
	$searchlist[1]["name"] = _("Female"); 
	$searchlist[1]["value"] = "0";
	$searchlist[2]["name"] = _("Couple"); 
	$searchlist[2]["value"] = "3";
	return $searchlist;
}
function getAgeList($fromage) {

	if ($fromage) {
		$iFrom = 18;
		$iTo=51;
	} else {
		$iFrom = 25;
		$iTo=120;		
	}
	for ($d=$iFrom;$d<=$iTo;$d++) {
		$agelist[$d]["value"] = $d;
	}
	return $agelist;
}
function searchUsers($id='all', $page, $longitude,$latitude,$fromage,$toage,$lookingfor,$data='')
{
	
	$count = '';
	$sqlgender="";
	$sqlage ="";
	
	$gender=0;
	$uid=0;


	if (intval($page) > PAGER::MAXRANGE) { $page=PAGER::MAXRANGE;}
	if (intval($page) < 0) { $page=1;}
	
	if (!empty($id) && $id == "all" && empty($data)) {
		if ($lookingfor==2) {
			$sqlgender = "(gender=0 OR gender=1)";
		} else {
			$sqlgender = "gender = $lookingfor";
		}
	
		$age1 = $fromage;
		$age2 = $toage;
		$sqlage = "birthdate BETWEEN DATE_ADD(CURDATE(), INTERVAL -{$age2} YEAR) AND DATE_ADD(CURDATE(), INTERVAL -{$age1} YEAR)";	
	}
	
	if (!empty($id) && $id == "all" || !empty($page) && $id == 'search') {
		//smarty paginate class used for users list in admin and also vehicle listings
		$page_limits = "LIMIT ". PAGER::getInstance()->startpage($page). ", ".PAGER::getInstance()->endpage();
	}
	

		$distance ="WHERE $sqlgender AND (w_gender=$gender OR w_gender=2) AND users.id<>$uid AND $sqlage order by distance";

	
	if(!empty($data)) {
		$distance= base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	} 
	
	if ($id == 'all' or $id == 'search') {
		$sql = "SELECT *,users.id as id,(((acos(sin((".$latitude."*pi()/180)) * sin((`Latitude`*pi()/180))+cos((".$latitude."*pi()/180)) * cos((`Latitude`*pi()/180)) * cos(((".$longitude."- `Longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance FROM users $distance $page_limits";		
		$count= "SELECT *,(((acos(sin((".$latitude."*pi()/180)) * sin((`Latitude`*pi()/180))+cos((".$latitude."*pi()/180)) * cos((`Latitude`*pi()/180)) * cos(((".$longitude."- `Longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance FROM users $distance";		
	} else {
		$sql = "SELECT *,(((acos(sin((".$latitude."*pi()/180)) * sin((`Latitude`*pi()/180))+cos((".$latitude."*pi()/180)) * cos((`Latitude`*pi()/180)) * cos(((".$longitude."- `Longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance FROM users WHERE id = " . $id . "";
	}

	
	if ($count) {
	
		$count_res = sqlQuery($count); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
		$row_count['0'] = mysqli_num_rows($count_res);
		PAGER::getInstance()->rows($row_count['0']);
		PAGER::getInstance()->page($page);
		PAGER::getInstance()->setsql($distance);
		sqlFreeResult($count_res);
	}	
	
	$res = sqlQuery($sql); if(sqlErrorReturn()) sqlDebug(__FILE__,__LINE__,sqlErrorReturn());
	
	$c=0;
	while ($a_row = sqlFetchArray($res)) {
	
		$records[$c]["id"] = $a_row["id"];
		$records[$c]["name"] = $a_row["name"];
		$records[$c]["distance"] = round($a_row["distance"]);
		$records[$c]["image"] = $a_row["image"];
		$records[$c]["city"] = $a_row["city"];
		$records[$c]["state"] = $a_row["state"];
		$records[$c]["country"] = $a_row["country"];
		$records[$c]["birthdate"] = $a_row["birthdate"];
		$records[$c]["w_gender"] = $a_row["w_gender"];
	++$c;
	}
	sqlFreeResult($res);

	if (!empty($id) && $id == "all" || !empty($page) && $id == 'search') {
		//set total row count to count from query else defaults to 0
		//$paginate->setTotal(!empty($row_count['0']) ? $row_count['0'] : 0);
		if (!empty($records)) {
    		//return array_slice($records, $paginate->getCurrentIndex(), $paginate->getLimit());
			return $records; 
		}
	} elseif (isset($records)) {
		return $records; 
	}
	
}
?>