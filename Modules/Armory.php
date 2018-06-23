<?php
error_reporting(1);

require("Parser.php");

class Armory extends LuaParser{
	private $db = null;
	private $arr = array();
	
	private $serverById = array(
		1 => "Unknown",
		2 => "Kronos",
		3 => "Nefarian",
		4 => "Kronos II",
		5 => "Rebirth",
		6 => "VanillaGaming",
		7 => "NostalGeek",
		8 => "Warsong 1.12.1 [8x] Blizzlike",
		9 => "Elysium",
		10 => "Kul Tiras",
		36 => "Zul'Dare",
		38 => "Anathema",
		39 => "Zeth'Kur",
		40 => "Darrowshire",
		45 => "Nemesis",
		46 => "Nostralia"
	);
	private $serverByName = array(
		"Unknown" => 1,
		"Kronos" => 2,
		"Nefarian" => 3,
		"Kronos II" => 4,
		"Rebirth" => 5,
		"VanillaGaming" => 6,
		"NostalGeek" => 7,
		"Warsong 1.12.1 [8x] Blizzlike" => 8,
		"Elysium" => 9,
		"Warsong" => 8,
		"Kul Tiras" => 10,
		"Zul'Dare" => 36,
		"ZulDare" => 36,
		"Anathema" => 38,
		"Zeth'Kur" => 39,
		"ZethKur" => 39,
		"Darrowshire" => 40,
		"Nemesis" => 45,
		"Nostralia" => 46
	);
	private $classes = array(
		"warrior" => 1,
		"rogue" => 2,
		"priest" => 3,
		"hunter" => 4,
		"druid" => 5,
		"mage" => 6,
		"warlock" => 7,
		"paladin" => 8,
		"shaman" => 9
	);
	private $classesReverse = array(
		1 => "warrior",
		2 => "rogue",
		3 => "priest",
		4 => "hunter",
		5 => "druid",
		6 => "mage",
		7 => "warlock",
		8 => "paladin",
		9 => "shaman"
	);
	private $raceList = array(
		"Human" => 1,
		"Dwarf" => 2,
		"NightElf" => 3,
		"Gnome" => 4,
		"Orc" => 5,
		"Undead" => 6,
		"Troll" => 7,
		"Tauren" => 8,
		"Scourge" => 6,
		"Forsaken" => 6
	);

	public function __construct($file, $db, $id){
		parent::__construct();
		$this->db = $db;
		$arr = $this->makePhpArray($file);
		$this->arr = $arr["LLADATA"];
		unset($arr);
		
		/*$db->query('DELETE FROM `armory`');
		$db->query('DELETE FROM `armory-itemhistory`');
		$db->query('DELETE FROM `armory-itemsets`');
		$db->query('DELETE FROM `armory-guildhistory`');
		//*/
		
		//Get Itemtemplate
		$itemTemplate = array();
		foreach($this->db->query('SELECT * FROM item_template') as $row){
			$itemTemplate[$row->entry] = $row;
		}
		
		// Get characters
		$chars = array();
		foreach($db->query('SELECT id, serverid, name, faction, guildid FROM chars') as $row){
			if (!isset($chars[$row->serverid]))
				$chars[$row->serverid] = array();
			$chars[$row->serverid][$row->name] = array(1=>$row->faction, 2=>$row->id, 3=>$row->guildid);
		}
		
		// Get guilds
		$guilds = array();
		foreach($db->query('SELECT id, name, serverid, faction FROM guilds') as $row){
			if ($row->name != "" && $row->name != " "){
				$guilds[$row->serverid][$row->faction][$row->name] = $row->id;
			}
		}
		
		// Create new guilds
		$sql = 'INSERT INTO `guilds` (name, serverid, faction) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$newGuilds = array();
		foreach($this->arr as $k => $v){
			if (isset($v[2]) && $v[2] != "" && $v[2] != " " && !empty($v[2]) && !isset($newGuilds[$v[2]])){
				$facid = ($v[8]=="Horde") ? -1 : 1;
				if (isset($this->serverByName[$v[9]])){
					if (!isset($guilds[$this->serverByName[$v[9]]][$facid][$v[2]])){
						$insertQuery[] = '(?,?,?)';
						$insertData[] = $v[2];
						$insertData[] = $this->serverByName[$v[9]];
						$insertData[] = $facid; 
						$newGuilds[$v[2]][1] = $this->serverByName[$v[9]];
						$newGuilds[$v[2]][2] = $facid;
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// Put them into the array
		foreach($newGuilds as $k => $v){
			$guilds[$v[1]][$v[2]][$k] = $db->query('SELECT id FROM guilds WHERE name = "'.htmlentities($k).'" AND serverid = '.$v[1].' AND faction =  "'.$v[2].'";')->fetch()->id;
		}
		
		// Parse Items  |cffff8000|Hitem:19019:1900:0:0|h[Thunderfury, Blessed Blade of the Windseeker]|h|r
		foreach($this->arr as $k => $v){
			for ($i=10; $i<29; $i++){
				$g = array();
				preg_match("/\|(.+)\|Hitem:(\d+):(\d+):(\d+):(\d+)\|h\[(.+)\]\|h\|r/", $v[$i], $g);
				$this->arr[$k][$i] = $g;
			}
		}
		
		// Write characters into db
		$sql = 'INSERT INTO `chars` (name, classid, faction, guildid, serverid, ownerid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$newChars = array();
		foreach($this->arr as $k => $v){
			$facid = ($v[8]=="Horde") ? -1 : 1;
			if ($k != "" && $k != "Unknown" && $k != "Unbekannt"){
				if (isset($this->serverByName[$v[9]])){
					if (isset($chars[$this->serverByName[$v[9]]][$k])){
						if ($chars[$this->serverByName[$v[9]]][$k][1] && (($v[8]=="Horde") ? -1 : 1)!=$chars[$this->serverByName[$v[9]]][$k][1])
							$db->query('UPDATE chars SET faction = "'.($r = ($v[8]=="Horde") ? -1 : 1).'" WHERE id = "'.$chars[$this->serverByName[$v[9]]][$k][2].'";');
						if (isset($guilds[$this->serverByName[$v[9]]][$facid][$v[2]]) && $v[2]!="" && $v[2]!=" " && $guilds[$this->serverByName[$v[9]]][$facid][$v[2]]!=$chars[$this->serverByName[$v[9]]][$k][3] && intval($v[10][2])>0 && intval($v[14][2])>0 && intval($v[16][2])>0)
							$db->query('UPDATE chars SET guildid = "'.intval($guilds[$this->serverByName[$v[9]]][$facid][$v[2]]).'" WHERE id = "'.$chars[$this->serverByName[$v[9]]][$k][2].'";');
					}else{
						$insertQuery[] = '(?,?,?,?,?,?)';
						$insertData[] = $k;
						$insertData[] = (isset($this->classes[strtolower($v[5])])) ? $this->classes[strtolower($v[5])] : 0;
						$insertData[] = $facid; 
						$insertData[] = (isset($guilds[$this->serverByName[$v[9]]][$facid][$v[2]]) && $v[2]!="" && $v[2]!=" ") ? $guilds[$this->serverByName[$v[9]]][$facid][$v[2]] : 0;
						$insertData[] = $this->serverByName[$v[9]];
						$insertData[] = 0;
						$newChars[$k] = $this->serverByName[$v[9]];
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// Put them into the array
		foreach($newChars as $k => $v){
			$chars[$v][$k] = array(1=>(($this->arr[$k][8]=="Horde") ? -1 : 1), 2=>$db->query('SELECT id FROM chars WHERE name = "'.htmlentities($k).'" AND serverid = '.$v.';')->fetch()->id);
		}
		
		// GetCurrent Honor ranking data
		$honor = array();
		foreach($db->query('SELECT charid, curpro, currank, liferank, liferanktime FROM `armory-honor`') as $row){
			$honor[$row->charid] = array(1=>$row->curpro,2=>$row->currank,3=>$row->liferank,4=>$row->liferanktime);
		}
		
		// Write armory honor ranking
		$sql = 'INSERT INTO `armory-honor` (charid, currank, curpro, curstanding, curchange, todhk, toddk, yeshk, yeshonor, weekhk, weekhonor, lweekhk, lweekhonor, lifehk, lifedk, liferank, liferanktime) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$toDeleteArray = array();
		foreach($this->arr as $k => $v){
			if (isset($chars[$this->serverByName[$v[9]]][$k]) && $chars[$this->serverByName[$v[9]]][$k][2]>0){
				if (isset($v[40]) && intval($v[40])>0){
					if (intval($v[42])>18)
						$v[42]=0;
					if ($this->serverByName[$v[9]]==3)
						$v[42]=$v[30];
					if ($honor[$chars[$this->serverByName[$v[9]]][$k][2]][3]>$v[42] && $this->serverByName[$v[9]]==3)
						$v[42]=$honor[$chars[$this->serverByName[$v[9]]][$k][2]][2];
					$insertQuery[] = '(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
					$toDeleteArray[] = $chars[$this->serverByName[$v[9]]][$k][2];
					$insertData[] = $chars[$this->serverByName[$v[9]]][$k][2];
					$insertData[] = $v[30];
					$insertData[] = $v[43]*1000;
					$insertData[] = $v[39];
					if (isset($honor[$chars[$this->serverByName[$v[9]]][$k][2]])){
						if (abs(($v[30]*10000+round($v[43]*1000))-($honor[$chars[$this->serverByName[$v[9]]][$k][2]][2]*10000+$honor[$chars[$this->serverByName[$v[9]]][$k][2]][1]))>10)
							$insertData[] = ($v[30]*10000+round($v[43]*1000))-($honor[$chars[$this->serverByName[$v[9]]][$k][2]][2]*10000+$honor[$chars[$this->serverByName[$v[9]]][$k][2]][1]);
						else
							$insertData[] = $honor[$chars[$this->serverByName[$v[9]]][$k][2]][1];
					}else{
						$insertData[] = 0;
					}
					$insertData[] = $v[31];
					$insertData[] = $v[32];
					$insertData[] = $v[33];
					$insertData[] = $v[34];
					$insertData[] = $v[35];
					$insertData[] = $v[36];
					$insertData[] = $v[37];
					$insertData[] = $v[38];
					$insertData[] = $v[40];
					$insertData[] = $v[41];
					$insertData[] = $v[42];
					if ($honor[$chars[$this->serverByName[$v[9]]][$k][2]][3]<$v[42] || $honor[$chars[$this->serverByName[$v[9]]][$k][2]][4]==0 || !isset($honor[$chars[$this->serverByName[$v[9]]][$k][2]][4]))
						$insertData[] = time();
					else
						$insertData[] = $honor[$chars[$this->serverByName[$v[9]]][$k][2]][4];
				}
			}
		}
		if (!empty($insertQuery)) {
			$this->db->query('DELETE FROM `armory-honor` WHERE charid IN ('.implode(', ', $toDeleteArray).');');
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		// Write armory
		// Write Itemhistory
		$sql = 'INSERT INTO `armory-itemhistory` (charid, timestamp, item) VALUES ';
		$insertQuery = array();
		$insertData = array();
		foreach($this->arr as $k => $v){
			if (isset($chars[$this->serverByName[$v[9]]][$k])){
				$itemlist = array();
				foreach($db->query('SELECT item FROM `armory-itemhistory` WHERE charid = "'.$chars[$this->serverByName[$v[9]]][$k][2].'";') as $row){
					$itemlist[$row->item] = true;
				}
				for ($i=10; $i<=29; $i++){
					if (isset($v[$i]) && $v[$i][2]){
						if (!isset($itemlist[$v[$i][2]]) && $v[$i][2]>0){
							$insertQuery[] = '(?, ?, ?)';
							$insertData[] = $chars[$this->serverByName[$v[9]]][$k][2];
							$insertData[] = time();
							$insertData[] = $v[$i][2];
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		// Write item-sets
		$sql = 'INSERT INTO `armory-itemsets` (charid, `index`, item1, ench1, item2, ench2, item3, ench3, item4, ench4, item5, ench5, item6, ench6, item7, ench7, item8, ench8, item9, ench9, item10, ench10, item11, ench11, item12, ench12, item13, ench13, item14, ench14, item15, ench15, item16, ench16, item17, ench17, item18, ench18, item19, ench19) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$delete = array();
		foreach($this->arr as $k => $v){
			if (isset($chars[$this->serverByName[$v[9]]][$k])){
				if ((isset($v[11][2]) && $v[11][2] != 0) || (isset($v[17][2]) && $v[17][2] != 0) || (isset($v[24][2]) && $v[24][2] != 0)){
					$itemsets = array();
					foreach($db->query('SELECT * FROM `armory-itemsets` WHERE charid = "'.$chars[$this->serverByName[$v[9]]][$k][2].'";') as $row){
						$itemsets[$row->index] = json_decode(json_encode($row), true);
					}
					// Check if this itemset exists
					$exists = false;
					foreach($itemsets as $ke => $va){
						if ($v[10][2]!=$va["item1"] or $v[10][3]!=$va["ench1"] or
							$v[11][2]!=$va["item2"] or $v[11][3]!=$va["ench2"] or
							$v[12][2]!=$va["item3"] or $v[12][3]!=$va["ench3"] or
							$v[13][2]!=$va["item4"] or $v[13][3]!=$va["ench4"] or
							$v[14][2]!=$va["item5"] or $v[14][3]!=$va["ench5"] or
							$v[15][2]!=$va["item6"] or $v[15][3]!=$va["ench6"] or
							$v[16][2]!=$va["item7"] or $v[16][3]!=$va["ench7"] or
							$v[17][2]!=$va["item8"] or $v[17][3]!=$va["ench8"] or
							$v[18][2]!=$va["item9"] or $v[18][3]!=$va["ench9"] or
							$v[19][2]!=$va["item10"] or $v[19][3]!=$va["ench10"] or
							$v[20][2]!=$va["item11"] or $v[20][3]!=$va["ench11"] or
							$v[21][2]!=$va["item12"] or $v[21][3]!=$va["ench12"] or
							$v[22][2]!=$va["item13"] or $v[22][3]!=$va["ench13"] or
							$v[23][2]!=$va["item14"] or $v[23][3]!=$va["ench14"] or
							$v[24][2]!=$va["item15"] or $v[24][3]!=$va["ench15"] or
							$v[25][2]!=$va["item16"] or $v[25][3]!=$va["ench16"] or
							$v[26][2]!=$va["item17"] or $v[26][3]!=$va["ench17"] or
							$v[27][2]!=$va["item18"] or $v[27][3]!=$va["ench18"] or
							$v[28][2]!=$va["item19"] or $v[28][3]!=$va["ench19"]){
								$exists = true;
								break;
						}
					}
					if ($exists or sizeOf($itemsets)==0){
						$newitemsets = array();
						foreach($itemsets as $ke => $va){
							$newitemsets[$ke+1] = $va;
						}
						$newitemsets[0] = array(
							"item1" => $v[10][2],
							"ench1" => $v[10][3],
							"item2" => $v[11][2],
							"ench2" => $v[11][3],
							"item3" => $v[12][2],
							"ench3" => $v[12][3],
							"item4" => $v[13][2],
							"ench4" => $v[13][3],
							"item5" => $v[14][2],
							"ench5" => $v[14][3],
							"item6" => $v[15][2],
							"ench6" => $v[15][3],
							"item7" => $v[16][2],
							"ench7" => $v[16][3],
							"item8" => $v[17][2],
							"ench8" => $v[17][3],
							"item9" => $v[18][2],
							"ench9" => $v[18][3],
							"item10" => $v[19][2],
							"ench10" => $v[19][3],
							"item11" => $v[20][2],
							"ench11" => $v[20][3],
							"item12" => $v[21][2],
							"ench12" => $v[21][3],
							"item13" => $v[22][2],
							"ench13" => $v[22][3],
							"item14" => $v[23][2],
							"ench14" => $v[23][3],
							"item15" => $v[24][2],
							"ench15" => $v[24][3],
							"item16" => $v[25][2],
							"ench16" => $v[25][3],
							"item17" => $v[26][2],
							"ench17" => $v[26][3],
							"item18" => $v[27][2],
							"ench18" => $v[27][3],
							"item19" => $v[28][2],
							"ench19" => $v[28][3]
						);
						// rule if weapon is twohanded, ignore the offhand
						if ($itemTemplate[$newitemsets[0]["item16"]]->inventorytype==17){
							$newitemsets[0]["item17"] = 0;
							$newitemsets[0]["ench17"] = 0;
						}
						
						if (isset($chars[$this->serverByName[$v[9]]][$k][2]))
							$delete[] = $chars[$this->serverByName[$v[9]]][$k][2];
						for ($i=0; $i<4; $i++){
							if (!isset($newitemsets[$i]))
								break 1;
							$insertQuery[] = '(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
							$insertData[] = $chars[$this->serverByName[$v[9]]][$k][2];
							$insertData[] = $i;
							$insertData[] = (isset($newitemsets[$i]["item1"])) ? $newitemsets[$i]["item1"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench1"])) ? $newitemsets[$i]["ench1"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item2"])) ? $newitemsets[$i]["item2"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench2"])) ? $newitemsets[$i]["ench2"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item3"])) ? $newitemsets[$i]["item3"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench3"])) ? $newitemsets[$i]["ench3"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item4"])) ? $newitemsets[$i]["item4"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench4"])) ? $newitemsets[$i]["ench4"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item5"])) ? $newitemsets[$i]["item5"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench5"])) ? $newitemsets[$i]["ench5"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item6"])) ? $newitemsets[$i]["item6"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench6"])) ? $newitemsets[$i]["ench6"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item7"])) ? $newitemsets[$i]["item7"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench7"])) ? $newitemsets[$i]["ench7"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item8"])) ? $newitemsets[$i]["item8"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench8"])) ? $newitemsets[$i]["ench8"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item9"])) ? $newitemsets[$i]["item9"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench9"])) ? $newitemsets[$i]["ench9"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item10"])) ? $newitemsets[$i]["item10"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench10"])) ? $newitemsets[$i]["ench10"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item11"])) ? $newitemsets[$i]["item11"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench11"])) ? $newitemsets[$i]["ench11"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item12"])) ? $newitemsets[$i]["item12"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench12"])) ? $newitemsets[$i]["ench12"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item13"])) ? $newitemsets[$i]["item13"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench13"])) ? $newitemsets[$i]["ench13"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item14"])) ? $newitemsets[$i]["item14"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench14"])) ? $newitemsets[$i]["ench14"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item15"])) ? $newitemsets[$i]["item15"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench15"])) ? $newitemsets[$i]["ench15"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item16"])) ? $newitemsets[$i]["item16"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench16"])) ? $newitemsets[$i]["ench16"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item17"])) ? $newitemsets[$i]["item17"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench17"])) ? $newitemsets[$i]["ench17"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item18"])) ? $newitemsets[$i]["item18"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench18"])) ? $newitemsets[$i]["ench18"] : 0;
							$insertData[] = (isset($newitemsets[$i]["item19"])) ? $newitemsets[$i]["item19"] : 0;
							$insertData[] = (isset($newitemsets[$i]["ench19"])) ? $newitemsets[$i]["ench19"] : 0;
						}
					}
				}
			}
		}
		if (!empty($delete)){
			$db->query('DELETE FROM `armory-itemsets` WHERE charid IN ('.implode(",",$delete).')');
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		// Write armory info
		$sql = 'INSERT INTO `armory` (charid, level, gender, race, prof1, prof2, talent, grankindex, grankname, seen) VALUES ';
		$insertQuery = array();
		$insertData = array();
		foreach($this->arr as $k => $v){
			if (isset($chars[$this->serverByName[$v[9]]][$k])){
				if ($db->query('SELECT charid FROM `armory` WHERE charid = "'.$chars[$this->serverByName[$v[9]]][$k][2].'";')->rowCount()>0){
					$db->query('UPDATE `armory` SET level = "'.($r = (!isset($v[1]) || $v[1]==0 || $v[1]=="") ? 60 : $v[1]).'", gender = "'.$v[7].'", race = "'.$this->raceList[$v[6]].'", grankindex = '.($r = (isset($v[3]) && $v[3]!=0) ? '"'.$v[3].'"' : 'grankindex').', grankname = '.($r = (isset($v[4]) && $v[4]!="") ? '"'.$v[4].'"' : 'grankname').', seen = "'.time().'" WHERE charid = '.$chars[$this->serverByName[$v[9]]][$k][2]);
				}else{
					$insertQuery[] = '(?,?,?,?,?,?,?,?,?,?)';
					$insertData[] = $chars[$this->serverByName[$v[9]]][$k][2];
					$insertData[] = (!isset($v[1]) || $v[1]==0 || $v[1]=="") ? 60 : $v[1];
					$insertData[] = $v[7];
					$insertData[] = $this->raceList[$v[6]];
					$insertData[] = 0;
					$insertData[] = 0;
					$insertData[] = 0;
					$insertData[] = (isset($v[4]) && $v[4]!=null && $v[3]!=0) ? $v[3] : 10;
					$insertData[] = (isset($v[4]) && $v[4]!=null && $v[4]!="") ? $v[4] : "";
					$insertData[] = time();
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		// write guild history
		$sql = 'INSERT INTO `armory-guildhistory` (charid, guildid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		foreach($this->arr as $k => $v){
			$facid = ($v[8]=="Horde") ? -1 : 1;
			if (isset($chars[$this->serverByName[$v[9]]][$k]) && isset($guilds[$this->serverByName[$v[9]]][$facid][$v[2]])){
				if ($db->query('SELECT guildid FROM `armory-guildhistory` WHERE charid = "'.$chars[$this->serverByName[$v[9]]][$k][2].'" ORDER BY id DESC LIMIT 1;')->fetch()->guildid!=$guilds[$this->serverByName[$v[9]]][$facid][$v[2]]){
					$insertQuery[] = '(?,?)';
					$insertData[] = $chars[$this->serverByName[$v[9]]][$k][2];
					$insertData[] = $guilds[$this->serverByName[$v[9]]][$facid][$v[2]];
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
	}
}

?>