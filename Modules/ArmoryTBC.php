<?php
error_reporting(1);

require("ParserTBC.php");

class Armory{
	private $db = null;
	private $arr = array();
	
	private $serverById = array(
		11 => "Unknown",
		12 => "Hellfire",
		13 => "B2B-TBC",
		14 => "ExcaliburTBC",
		15 => "Ares",
		16 => "HellGround",
		17 => "Smolderforge",
		18 => "Archangel",
		44 => "Outland",
		47 => "Hellfire 2",
		48 => "Hellfire 1",
		49 => "WarGate",
		50 => "Medivh",
	);
	private $serverByName = array(
		"Unknown" => 11,
		"Hellfire" => 12,
		"B2B-TBC" => 13,
		"ExcaliburTBC" => 14,
		"Ares" => 15,
		"HellGround" => 16,
		"Smolderforge" => 17,
		"Archangel" => 18,
		"Archangel [14x] Blizzlike" => 18,
		"Outland" => 44,
		"Medivh" => 50,
		"Hellfire 1" => 47,
		"Hellfire 2" => 48,
		"WarGate" => 49
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
		"Forsaken" => 6,
		"Draenei" => 9,
		"BloodElf" => 10
	);

	public function __construct($file, $db, $id){
		$this->db = $db;
		$pa = new LuaParser(file_get_contents($file));
		$arr = $pa->parse();
		$this->arr = $arr["LLADATA"];
		unset($arr);
		
		/*$db->query('DELETE FROM `armory`');
		$db->query('DELETE FROM `armory-itemhistory`');
		$db->query('DELETE FROM `armory-itemsets-tbc`');
		$db->query('DELETE FROM `armory-guildhistory`');
		$db->query('DELETE FROM `armory-arenateams-tbc`');
		//*/
		
		//Get Itemtemplate
		$itemTemplate = array();
		foreach($this->db->query('SELECT * FROM `item_template-tbc`') as $row){
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
		$guildsFac = array();
		foreach($db->query('SELECT id, name, serverid, faction FROM guilds') as $row){
			if ($row->name != "" && $row->name != " "){
				if (!isset($guilds[$row->serverid]))
					$guilds[$row->serverid] = array();
				if (!isset($guildsFac[$row->serverid]))
					$guildsFac[$row->serverid] = array();
				$guilds[$row->serverid][$row->name] = $row->id;
				$guildsFac[$row->serverid][$row->name] = $row->faction;
			}
		}
		
		$serverid = 1; // Unknown 
		foreach($this->arr as $k => $v){
			if (isset($this->serverByName[$v[8]])){
				$serverid = $this->serverByName[$v[8]];
				break;
			}
		}
		
		// Create new guilds
		$sql = 'INSERT INTO `guilds` (name, serverid, faction) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$newGuilds = array();
		foreach($this->arr as $k => $v){
			if (isset($v[1]) && $v[1] != "" && $v[1] != " " && !empty($v[1]) && !isset($newGuilds[$v[1]])){
				if (isset($this->serverByName[$v[8]])){
					if (!isset($guilds[$this->serverByName[$v[8]]][$v[1]])){
						$insertQuery[] = '(?,?,?)';
						$insertData[] = $v[1];
						$insertData[] = $this->serverByName[$v[8]];
						$insertData[] = ($v[7]=="Horde") ? -1 : 1; 
						$newGuilds[$v[1]] = $this->serverByName[$v[8]];
					}else{
						if ($guildsFac[$this->serverByName[$v[8]]][$v[1]]!=(($v[7]=="Horde") ? -1 : 1))
							$db->query('UPDATE guilds SET faction = "'.($r = ($v[7]=="Horde") ? -1 : 1).'" WHERE id = '.$guilds[$this->serverByName[$v[8]]][$v[1]]);
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
			$guilds[$v][$k] = $db->query('SELECT id FROM guilds WHERE name = "'.htmlentities($k).'" AND serverid = '.$v.';')->fetch()->id;
		}
		
		// Parse Items "|cff1eff00|Hitem:25931:0:0:0:0:0:0:0|h[Cenarion Thicket Circlet]|h|r"
		foreach($this->arr as $k => $v){
			for ($i=9; $i<28; $i++){
				$g = array(); // color, itemid, enchant, gem1, gem2, gem3, gem4, suffix, unique, linklvl, name
				preg_match("/\|(.+)\|Hitem:(\d+):(\d+):(.+):(\d+):(\d+)\|h\[(.+)\]\|h\|r/", $v[$i], $g);
				$this->arr[$k][$i] = $g;
			}
		}
		
		// Write characters into db
		$sql = 'INSERT INTO `chars` (name, classid, faction, guildid, serverid, ownerid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$newChars = array();
		foreach($this->arr as $k => $v){
			if ($k != "" && $k != "Unknown" && $k != "Unbekannt"){
				if (isset($this->serverByName[$v[8]])){
					if (isset($chars[$this->serverByName[$v[8]]][$k])){
						if ($chars[$this->serverByName[$v[8]]][$k][1] && ((strtolower($v[7])=="horde") ? -1 : 1)!=$chars[$this->serverByName[$v[8]]][$k][1])
							$db->query('UPDATE chars SET faction = "'.($r = (strtolower($v[7])=="horde") ? -1 : 1).'" WHERE id = "'.$chars[$this->serverByName[$v[8]]][$k][2].'";');
						if (isset($guilds[$this->serverByName[$v[8]]][$v[1]]) && $v[1]!="" && $v[1]!=" " && $guilds[$this->serverByName[$v[8]]][$v[1]]!=$chars[$this->serverByName[$v[8]]][$k][3] && intval($v[9][2])>0 && intval($v[13][2])>0 && intval($v[15][2])>0)
							$db->query('UPDATE chars SET guildid = "'.intval($guilds[$this->serverByName[$v[8]]][$v[1]]).'" WHERE id = "'.$chars[$this->serverByName[$v[8]]][$k][2].'";');
					}else{
						$insertQuery[] = '(?,?,?,?,?,?)';
						$insertData[] = $k;
						$insertData[] = (isset($this->classes[strtolower($v[4])])) ? $this->classes[strtolower($v[4])] : 0;
						$insertData[] = (strtolower($v[7])=="horde") ? -1 : 1; 
						$insertData[] = (isset($guilds[$this->serverByName[$v[8]]][$v[1]]) && $v[1]!="" && $v[1]!=" ") ? $guilds[$this->serverByName[$v[8]]][$v[1]] : 0;
						$insertData[] = $this->serverByName[$v[8]];
						$insertData[] = 0;
						$newChars[$k] = $this->serverByName[$v[8]];
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
			$chars[$v][$k] = array(1=>(($this->arr[$k][7]=="Horde") ? -1 : 1), 2=>$db->query('SELECT id FROM chars WHERE name = "'.htmlentities($k).'" AND serverid = '.$v.';')->fetch()->id);
		}	
		
		// Get Current Arena Teams
		$arenaTeams = array();
		foreach($db->query('SELECT * FROM `armory-arenateams-tbc` WHERE serverid = '.$serverid) as $row){
			if (!isset($arenaTeams[$row->type]))
				$arenaTeams[$row->type] = array();
			$arenaTeams[$row->type][$row->name] = $row;
		}
		
		// Inserting arena teams first
		$sql = 'INSERT INTO `armory-arenateams-tbc` (type, name, rating, games, wins, time, val, serverid,season) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		// Inserting each team for each bracket
		foreach($this->arr as $k => $v){
			if (isset($this->serverByName[$v[8]]) && isset($chars[$this->serverByName[$v[8]]][$k]) && $chars[$this->serverByName[$v[8]]][$k][2]>0){
				if (isset($v[37]) && strlen($v[37])>3){
					if (isset($arenaTeams[0][$v[37]])){
						if (isset($v["season"]) && intval($v["season"])>intval($arenaTeams[0][$v[37]]->season)){
							$db->query('UPDATE `armory-arenateams-tbc` SET season = "'.intval($v["season"]).'", rating = "'.$v[39].'", games = "'.$v[40].'", wins = "'.$v[41].'", time = "'.time().'", val = "'.$v[39].'" WHERE arenaid = '.$arenaTeams[0][$v[37]]->arenaid);
						}else{
							$db->query('UPDATE `armory-arenateams-tbc` SET rating = "'.$v[39].'", games = "'.$v[40].'", wins = "'.$v[41].'", time = "'.($arenaTeams[0][$v[37]]->time.",".time()).'", val = "'.($arenaTeams[0][$v[37]]->val.",".$v[39]).'" WHERE arenaid = '.$arenaTeams[0][$v[37]]->arenaid);
						}
					}else{
						$insertQuery[] = '(?,?,?,?,?,?,?,?,?)';
						$insertData[] = 0;
						$insertData[] = $v[37];
						$insertData[] = $v[39];
						$insertData[] = $v[40];
						$insertData[] = $v[41];
						$insertData[] = time();
						$insertData[] = $v[39];
						$insertData[] = $this->serverByName[$v[8]];
						$insertData[] = intval($v["season"]);
					}
				}
				if (isset($v[42]) && strlen($v[42])>3){
					if (isset($arenaTeams[1][$v[42]])){
						if (isset($v["season"]) && intval($v["season"])>intval($arenaTeams[1][$v[42]]->season)){
							$db->query('UPDATE `armory-arenateams-tbc` SET season = "'.intval($v["season"]).'", rating = "'.$v[44].'", games = "'.$v[45].'", wins = "'.$v[46].'", time = "'.time().'", val = "'.$v[44].'" WHERE arenaid = '.$arenaTeams[1][$v[42]]->arenaid);
						}else{
							$db->query('UPDATE `armory-arenateams-tbc` SET rating = "'.$v[44].'", games = "'.$v[45].'", wins = "'.$v[46].'", time = "'.($arenaTeams[1][$v[42]]->time.",".time()).'", val = "'.($arenaTeams[1][$v[42]]->val.",".$v[44]).'" WHERE arenaid = '.$arenaTeams[1][$v[42]]->arenaid);
						}
					}else{
						$insertQuery[] = '(?,?,?,?,?,?,?,?,?)';
						$insertData[] = 1;
						$insertData[] = $v[42];
						$insertData[] = $v[44];
						$insertData[] = $v[45];
						$insertData[] = $v[46];
						$insertData[] = time();
						$insertData[] = $v[44];
						$insertData[] = $this->serverByName[$v[8]];
						$insertData[] = intval($v["season"]);
					}
				}
				if (isset($v[47]) && strlen($v[47])>3){
					if (isset($arenaTeams[2][$v[47]])){
						if (isset($v["season"]) && intval($v["season"])>intval($arenaTeams[2][$v[47]]->season)){
							$db->query('UPDATE `armory-arenateams-tbc` SET season = "'.intval($v["season"]).'", rating = "'.$v[49].'", games = "'.$v[50].'", wins = "'.$v[51].'", time = "'.time().'", val = "'.$v[49].'" WHERE arenaid = '.$arenaTeams[2][$v[47]]->arenaid);
						}else{
							$db->query('UPDATE `armory-arenateams-tbc` SET rating = "'.$v[49].'", games = "'.$v[50].'", wins = "'.$v[51].'", time = "'.($arenaTeams[2][$v[47]]->time.",".time()).'", val = "'.($arenaTeams[2][$v[47]]->val.",".$v[49]).'" WHERE arenaid = '.$arenaTeams[2][$v[47]]->arenaid);
						}
					}else{
						$insertQuery[] = '(?,?,?,?,?,?,?,?,?)';
						$insertData[] = 2;
						$insertData[] = $v[47];
						$insertData[] = $v[49];
						$insertData[] = $v[50];
						$insertData[] = $v[51];
						$insertData[] = time();
						$insertData[] = $v[49];
						$insertData[] = $this->serverByName[$v[8]];
						$insertData[] = intval($v["season"]);
					}
				}
			}
		}
		
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		// GetCurrent Honor ranking data
		$honor = array();
		foreach($db->query('SELECT * FROM `armory-honor-tbc`') as $row){
			$honor[$row->charid] = $row;
		}
		
		// Get Current Arena Teams
		$arenaTeams = array();
		foreach($db->query('SELECT * FROM `armory-arenateams-tbc` WHERE serverid = '.$serverid) as $row){
			if (!isset($arenaTeams[$row->type]))
				$arenaTeams[$row->type] = array();
			$arenaTeams[$row->type][$row->name] = $row;
		}
		
		// Write armory honor ranking
		$sql = 'INSERT INTO `armory-honor-tbc` (charid, arena1, arena2, arena3, thk, thonor, yhk, yhonor, lhk) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$toDeleteArray = array();
		foreach($this->arr as $k => $v){
			if (isset($chars[$this->serverByName[$v[8]]][$k]) && $chars[$this->serverByName[$v[8]]][$k][2]>0){
				if (isset($v[36])){
					$toDeleteArray[] = $chars[$this->serverByName[$v[8]]][$k][2];
					$insertQuery[] = '(?,?,?,?,?,?,?,?,?)';
					$insertData[] = $chars[$this->serverByName[$v[8]]][$k][2];
					$insertData[] = ((isset($v[37]) && strlen($v[37])>3) or (isset($v[42]) && strlen($v[42])>3) or (isset($v[47]) && strlen($v[47])>3) or !$honor[$chars[$this->serverByName[$v[8]]][$k][2]]) ? intval($arenaTeams[0][$v[37]]->arenaid) : $honor[$chars[$this->serverByName[$v[8]]][$k][2]]->arena1;
					$insertData[] = ((isset($v[37]) && strlen($v[37])>3) or (isset($v[42]) && strlen($v[42])>3) or (isset($v[47]) && strlen($v[47])>3) or !$honor[$chars[$this->serverByName[$v[8]]][$k][2]]) ? intval($arenaTeams[1][$v[42]]->arenaid) : $honor[$chars[$this->serverByName[$v[8]]][$k][2]]->arena2;
					$insertData[] = ((isset($v[37]) && strlen($v[37])>3) or (isset($v[42]) && strlen($v[42])>3) or (isset($v[47]) && strlen($v[47])>3) or !$honor[$chars[$this->serverByName[$v[8]]][$k][2]]) ? intval($arenaTeams[2][$v[47]]->arenaid) : $honor[$chars[$this->serverByName[$v[8]]][$k][2]]->arena3;
					$insertData[] = intval($v[32]);
					$insertData[] = intval($v[33]);
					$insertData[] = intval($v[34]);
					$insertData[] = intval($v[35]);
					$insertData[] = intval($v[36]);
				}
			}
		}
		if (!empty($insertQuery)) {
			$this->db->query('DELETE FROM `armory-honor-tbc` WHERE charid IN ('.implode(', ', $toDeleteArray).');');
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
			if (isset($chars[$this->serverByName[$v[8]]][$k])){
				$itemlist = array();
				foreach($db->query('SELECT item FROM `armory-itemhistory` WHERE charid = "'.$chars[$this->serverByName[$v[8]]][$k][2].'";') as $row){
					$itemlist[$row->item] = true;
				}
				for ($i=10; $i<=29; $i++){
					if (isset($v[$i-1]) && $v[$i-1][2] && intval($v[$i-1][2])>0){
						if (!isset($itemlist[$v[$i-1][2]])){
							$insertQuery[] = '(?, ?, ?)';
							$insertData[] = $chars[$this->serverByName[$v[8]]][$k][2];
							$insertData[] = time();
							$insertData[] = $v[$i-1][2];
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
		$sql = 'INSERT INTO `armory-itemsets-tbc` (charid, `index`, item1, ench1, item2, ench2, item3, ench3, item4, ench4, item5, ench5, item6, ench6, item7, ench7, item8, ench8, item9, ench9, item10, ench10, item11, ench11, item12, ench12, item13, ench13, item14, ench14, item15, ench15, item16, ench16, item17, ench17, item18, ench18, item19, ench19, gem1, gem2, gem3, gem4, gem5, gem6, gem7, gem8, gem9, gem10, gem11, gem12, gem13, gem14, gem15, gem16, gem17, gem18, gem19) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$delete = array();
		foreach($this->arr as $k => $v){
			if (isset($chars[$this->serverByName[$v[8]]][$k])){
				if ((isset($v[10][2]) && $v[10][2] != 0) || (isset($v[16][2]) && $v[16][2] != 0) || (isset($v[23][2]) && $v[23][2] != 0)){
					$itemsets = array();
					foreach($db->query('SELECT * FROM `armory-itemsets-tbc` WHERE charid = "'.$chars[$this->serverByName[$v[8]]][$k][2].'";') as $row){
						$itemsets[$row->index] = json_decode(json_encode($row), true);
					}
					// Check if this itemset exists
					$exists = false;
					foreach($itemsets as $ke => $va){
						if ($v[10-1][2]!=$va["item1"] or $v[10-1][3]!=$va["ench1"] or
							$v[11-1][2]!=$va["item2"] or $v[11-1][3]!=$va["ench2"] or
							$v[12-1][2]!=$va["item3"] or $v[12-1][3]!=$va["ench3"] or
							$v[13-1][2]!=$va["item4"] or $v[13-1][3]!=$va["ench4"] or
							$v[14-1][2]!=$va["item5"] or $v[14-1][3]!=$va["ench5"] or
							$v[15-1][2]!=$va["item6"] or $v[15-1][3]!=$va["ench6"] or
							$v[16-1][2]!=$va["item7"] or $v[16-1][3]!=$va["ench7"] or
							$v[17-1][2]!=$va["item8"] or $v[17-1][3]!=$va["ench8"] or
							$v[18-1][2]!=$va["item9"] or $v[18-1][3]!=$va["ench9"] or
							$v[19-1][2]!=$va["item10"] or $v[19-1][3]!=$va["ench10"] or
							$v[20-1][2]!=$va["item11"] or $v[20-1][3]!=$va["ench11"] or
							$v[21-1][2]!=$va["item12"] or $v[21-1][3]!=$va["ench12"] or
							$v[22-1][2]!=$va["item13"] or $v[22-1][3]!=$va["ench13"] or
							$v[23-1][2]!=$va["item14"] or $v[23-1][3]!=$va["ench14"] or
							$v[24-1][2]!=$va["item15"] or $v[24-1][3]!=$va["ench15"] or
							$v[25-1][2]!=$va["item16"] or $v[25-1][3]!=$va["ench16"] or
							$v[26-1][2]!=$va["item17"] or $v[26-1][3]!=$va["ench17"] or
							$v[27-1][2]!=$va["item18"] or $v[27-1][3]!=$va["ench18"] or
							$v[28-1][2]!=$va["item19"] or $v[28-1][3]!=$va["ench19"] or
							$v[10-1][4]!=$va["gem1"] or
							$v[11-1][4]!=$va["gem2"] or
							$v[12-1][4]!=$va["gem3"] or
							$v[13-1][4]!=$va["gem4"] or
							$v[14-1][4]!=$va["gem5"] or
							$v[15-1][4]!=$va["gem6"] or
							$v[16-1][4]!=$va["gem7"] or
							$v[17-1][4]!=$va["gem8"] or
							$v[18-1][4]!=$va["gem9"] or
							$v[19-1][4]!=$va["gem10"] or
							$v[20-1][4]!=$va["gem11"] or
							$v[21-1][4]!=$va["gem12"] or
							$v[22-1][4]!=$va["gem13"] or
							$v[23-1][4]!=$va["gem14"] or
							$v[24-1][4]!=$va["gem15"] or
							$v[25-1][4]!=$va["gem16"] or
							$v[26-1][4]!=$va["gem17"] or
							$v[27-1][4]!=$va["gem18"] or
							$v[28-1][4]!=$va["gem19"]){
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
							"item1" => $v[10-1][2],
							"ench1" => $v[10-1][3],
							"item2" => $v[11-1][2],
							"ench2" => $v[11-1][3],
							"item3" => $v[12-1][2],
							"ench3" => $v[12-1][3],
							"item4" => $v[13-1][2],
							"ench4" => $v[13-1][3],
							"item5" => $v[14-1][2],
							"ench5" => $v[14-1][3],
							"item6" => $v[15-1][2],
							"ench6" => $v[15-1][3],
							"item7" => $v[16-1][2],
							"ench7" => $v[16-1][3],
							"item8" => $v[17-1][2],
							"ench8" => $v[17-1][3],
							"item9" => $v[18-1][2],
							"ench9" => $v[18-1][3],
							"item10" => $v[19-1][2],
							"ench10" => $v[19-1][3],
							"item11" => $v[20-1][2],
							"ench11" => $v[20-1][3],
							"item12" => $v[21-1][2],
							"ench12" => $v[21-1][3],
							"item13" => $v[22-1][2],
							"ench13" => $v[22-1][3],
							"item14" => $v[23-1][2],
							"ench14" => $v[23-1][3],
							"item15" => $v[24-1][2],
							"ench15" => $v[24-1][3],
							"item16" => $v[25-1][2],
							"ench16" => $v[25-1][3],
							"item17" => $v[26-1][2],
							"ench17" => $v[26-1][3],
							"item18" => $v[27-1][2],
							"ench18" => $v[27-1][3],
							"item19" => $v[28-1][2],
							"ench19" => $v[28-1][3],
							"gem1" => $v[10-1][4],
							"gem2" => $v[11-1][4],
							"gem3" => $v[12-1][4],
							"gem4" => $v[13-1][4],
							"gem5" => $v[14-1][4],
							"gem6" => $v[15-1][4],
							"gem7" => $v[16-1][4],
							"gem8" => $v[17-1][4],
							"gem9" => $v[18-1][4],
							"gem10" => $v[19-1][4],
							"gem11" => $v[20-1][4],
							"gem12" => $v[21-1][4],
							"gem13" => $v[22-1][4],
							"gem14" => $v[23-1][4],
							"gem15" => $v[24-1][4],
							"gem16" => $v[25-1][4],
							"gem17" => $v[26-1][4],
							"gem18" => $v[27-1][4],
							"gem19" => $v[28-1][4],
						);
						// rule if weapon is twohanded, ignore the offhand
						if ($itemTemplate[$newitemsets[0]["item16"]]->inventorytype==17){
							$newitemsets[0]["item17"] = 0;
							$newitemsets[0]["ench17"] = 0;
						}
						
						if (isset($chars[$this->serverByName[$v[8]]][$k][2]))
							$delete[] = $chars[$this->serverByName[$v[8]]][$k][2];
						for ($i=0; $i<4; $i++){
							if (!isset($newitemsets[$i]))
								break 1;
							$insertQuery[] = '(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
							$insertData[] = $chars[$this->serverByName[$v[8]]][$k][2];
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
							$insertData[] = strval($newitemsets[$i]["gem1"]);
							$insertData[] = strval($newitemsets[$i]["gem2"]);
							$insertData[] = strval($newitemsets[$i]["gem3"]);
							$insertData[] = strval($newitemsets[$i]["gem4"]);
							$insertData[] = strval($newitemsets[$i]["gem5"]);
							$insertData[] = strval($newitemsets[$i]["gem6"]);
							$insertData[] = strval($newitemsets[$i]["gem7"]);
							$insertData[] = strval($newitemsets[$i]["gem8"]);
							$insertData[] = strval($newitemsets[$i]["gem9"]);
							$insertData[] = strval($newitemsets[$i]["gem10"]);
							$insertData[] = strval($newitemsets[$i]["gem11"]);
							$insertData[] = strval($newitemsets[$i]["gem12"]);
							$insertData[] = strval($newitemsets[$i]["gem13"]);
							$insertData[] = strval($newitemsets[$i]["gem14"]);
							$insertData[] = strval($newitemsets[$i]["gem15"]);
							$insertData[] = strval($newitemsets[$i]["gem16"]);
							$insertData[] = strval($newitemsets[$i]["gem17"]);
							$insertData[] = strval($newitemsets[$i]["gem18"]);
							$insertData[] = strval($newitemsets[$i]["gem19"]);
						}
					}
				}
			}
		}
		if (!empty($delete)){
			$db->query('DELETE FROM `armory-itemsets-tbc` WHERE charid IN ('.implode(",",$delete).')');
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		// Write armory info
		$sql = 'INSERT INTO `armory` (charid, level, gender, race, prof1, prof2, grankindex, grankname, seen, title, talent, talentvt) VALUES ';
		$insertQuery = array();
		$insertData = array();
		foreach($this->arr as $k => $v){
			if (isset($chars[$this->serverByName[$v[8]]][$k])){
				$talents = array(1=>$v[29],2=>$v[30],3=>$v[31]);
				$talentvt = intval($v[29]).",".intval($v[30]).",".intval($v[31]);
				$val = max($talents);
				$specKey = array_search($val, $talents);
				if ($val==0)
					$specKey = 0;
				$pdata = $db->query('SELECT charid, prof1, prof2 FROM `armory` WHERE charid = "'.$chars[$this->serverByName[$v[8]]][$k][2].'";')->fetch();
				$profs = array();
				$taken = array();
				foreach($v["profs"] as $kk => $vv){
					$profs[] = $kk;
				}
				for ($i=1; $i<=2; $i++){
					if (intval($pdata->{"prof".$i})>1)
						$taken[$i] = $pdata->{"prof".$i};
				}
				$numTaken = sizeOf($taken);
				$numProfs = sizeOf($profs);
				if (intval($pdata->charid)>1){
					if ($numProfs==2)
						$db->query('UPDATE `armory` SET prof1 = "'.$profs[0].'", prof2 = "'.$profs[1].'" WHERE charid = '.$chars[$this->serverByName[$v[8]]][$k][2]);
					if ($numProfs==1 && $taken[1]!=$profs[0] && $taken[2]!=$profs[0] && $numTaken==2)
						$db->query('UPDATE `armory` SET prof1 = prof2, prof2 = "'.$profs[0].'" WHERE charid = '.$chars[$this->serverByName[$v[8]]][$k][2]);
					if ($numProfs==1 && $taken[1]!=$profs[0] && $numTaken==1)
						$db->query('UPDATE `armory` SET prof2 = "'.$profs[0].'" WHERE charid = '.$chars[$this->serverByName[$v[8]]][$k][2]);
					$db->query('UPDATE `armory` SET talentvt = '.($r = ($talentvt!="" && $talentvt!="0,0,0") ? '"'.$talentvt.'"' : 'talentvt').', title = '.($r = (isset($v[28]) && strlen($v[28])>3) ? '"'.$v[28].'"' : 'title').', talent = '.($r = (intval($specKey)>0) ? '"'.$specKey.'"' : 'talent').', level = "'.($r = (!isset($v[0]) || $v[0]==0 || $v[0]=="") ? 70 : $v[0]).'", gender = "'.$v[6].'", race = "'.$this->raceList[$v[5]].'", grankindex = '.($r = (isset($v[2]) && $v[2]!=0) ? '"'.$v[2].'"' : 'grankindex').', grankname = '.($r = (isset($v[3]) && $v[3]!="") ? '"'.$v[3].'"' : 'grankname').', seen = "'.time().'" WHERE charid = '.$chars[$this->serverByName[$v[8]]][$k][2]);
				}else{
					$insertQuery[] = '(?,?,?,?,?,?,?,?,?,?,?,?)';
					$insertData[] = $chars[$this->serverByName[$v[8]]][$k][2];
					$insertData[] = (!isset($v[0]) || $v[0]==0 || $v[0]=="") ? 70 : $v[0];
					$insertData[] = $v[6];
					$insertData[] = $this->raceList[$v[5]];
					$insertData[] = intval($profs[0]);
					$insertData[] = intval($profs[1]);
					$insertData[] = (isset($v[3]) && $v[3]!=null && $v[2]!=0) ? $v[2] : 10; // ???
					$insertData[] = (isset($v[3]) && $v[3]!=null && $v[3]!="") ? $v[3] : "";
					$insertData[] = time();
					$insertData[] = $v[28];
					$insertData[] = $specKey;
					$insertData[] = $talentvt;
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
			if (isset($chars[$this->serverByName[$v[8]]][$k]) && isset($guilds[$this->serverByName[$v[8]]][$v[1]])){
				if ($db->query('SELECT guildid FROM `armory-guildhistory` WHERE charid = "'.$chars[$this->serverByName[$v[8]]][$k][2].'" ORDER BY id DESC LIMIT 1;')->fetch()->guildid!=$guilds[$this->serverByName[$v[8]]][$v[1]]){
					$insertQuery[] = '(?,?)';
					$insertData[] = $chars[$this->serverByName[$v[8]]][$k][2];
					$insertData[] = $guilds[$this->serverByName[$v[8]]][$v[1]];
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