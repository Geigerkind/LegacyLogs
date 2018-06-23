<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $raidsById = array(
		1 => "Molten Core",
		2 => "Onyxia's Lair",
		3 => "Blackwing Lair",
		4 => "Zul'Gurub",
		5 => "Ruins of Ahn'Qiraj",
		6 => "Ahn'Qiraj",
		7 => "Naxxramas",
		8 => "Feralas",
		9 => "Azshara",
		10 => "Blasted Lands",
		11 => "Ashenvale",
		12 => "Duskwood",
		13 => "Hinterlands",
		14 => "Temple of Ahn'Qiraj"
	);
	private $raidBosses = array(
		1 => array(
			"Lucifron" => 12118,
			"Magmadar" => 11982,
			"Gehennas" => 12259,
			"Garr" => 12057,
			"Baron Geddon" => 12056,
			"Shazzrah" => 12264,
			"Sulfuron Harbinger" => 12098,
			"Golemagg the Incinerator" => 11988,
			"Majordomo Executus" => 12018,
			"Ragnaros" => 11502,
		),
		2 => array(
			"Onyxia" => 10184,
			"Lord Kazzak" => 12397,
			"Azuregos" => 6109,
			"Emeriss" => 14889,
			"Ysondre" => 14887,
			"Lethon" => 14888,
			"Taerar" => 14890,
		),
		3 => array(
			"Razorgore the Untamed" => 12435,
			"Vaelastrasz the Corrupt" => 13020,
			"Broodlord Lashlayer" => 12017,
			"Firemaw" => 11983,
			"Ebonroc" => 14601,
			"Flamegor" => 11981,
			"Chromaggus" => 14020,
			"Nefarian" => 11583
		),
		4 => array(
			"High Priestess Jeklik" => 14517,
			"High Priest Venoxis" => 14507,
			"High Priestess Mar'li" => 14510,
			"Bloodlord Mandokir" => 11382,
			"Gri'lek" => 15082,
			"Hazza'rah the Dreamweaver" => 15083,
			"Wushoolay" => 15085,
			"Gahz'ranka" => 15114,
			"High Priest Thekal" => 14509,
			"High Priestess Arlokk" => 14515,
			"Jin'do the Hexxer" => 11380,
			"Hakkar" => 14834
		),
		5 => array(
			"Kurinnaxx" => 15348,
			"General Rajaxx" => 15341,
			"Moam" => 15340,
			"Buru the Gorger" => 15370,
			"Ayamiss the Hunter" => 15369,
			"Ossirian the Unscarred" => 15339
		),
		6 => array(
			"The Prophet Skeram" => 15263,
			"The Bug Family" => 50000,
			"Battleguard Sartura" => 15516,
			"Fankriss the Unyielding" => 15510,
			"Viscidus" => 15299,
			"Princess Huhuran" => 15509,
			"The Twin Emperors" => 50001,
			"Ouro" => 15517,
			"C'Thun" => 15727
		),
		7 => array(
			"Patchwerk" => 16028,
			"Grobbulus" => 15931,
			"Gluth" => 15932,
			"Thaddius" => 15928,
			"Anub'Rekhan" => 15956,
			"Grand Widow Faerlina" => 15953,
			"Maexxna" => 15952,
			"Instructor Razuvious" => 16061,
			"Gothik the Harvester" => 16060,
			"The four Horseman" => 50002,
			"Noth the Plaguebringer" => 15954,
			"Heigan the Unclean" => 15936,
			"Loatheb" => 16011,
			"Sapphiron" => 15989,
			"Kel'Thuzad" => 15990
		),
		8 => array(
			"Emeriss" => 14889,
			"Ysondre" => 14887,
			"Lethon" => 14888,
			"Taerar" => 14890
		),
		9 => array(
			"Azuregos" => 6109,
		),
		10 => array(
			"Lord Kazzak" => 12397,
		),
		11 => array(
			"Emeriss" => 14889,
			"Ysondre" => 14887,
			"Lethon" => 14888,
			"Taerar" => 14890
		),
		12 => array(
			"Emeriss" => 14889,
			"Ysondre" => 14887,
			"Lethon" => 14888,
			"Taerar" => 14890
		),
		13 => array(
			"Emeriss" => 14889,
			"Ysondre" => 14887,
			"Lethon" => 14888,
			"Taerar" => 14890
		),
		14 => array(
			"The Prophet Skeram" => 15263,
			"The Bug Family" => 50000,
			"Battleguard Sartura" => 15516,
			"Fankriss the Unyielding" => 15510,
			"Viscidus" => 15299,
			"Princess Huhuran" => 15509,
			"The Twin Emperors" => 50001,
			"Ouro" => 15517,
			"C'Thun" => 15727
		)
	);
	private $typeById = array(
		-1 => array(
			1 => 1,
			2 => 1,
			3 => 2,
			4 => 2,
			5 => 1,
			6 => 2,
			7 => 2,
			8 => 1,
			9 => 2
		),
		1 => array(
			1 => 1,
			2 => 1,
			3 => 2,
			4 => 2,
			5 => 2,
			6 => 2,
			7 => 2,
			8 => 2,
			9 => 2
		)
	);
	private $type = array(
		-1 => "DPS",
		1 => "HPS"
	);
	private $classById = array(
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
	private $bossPos = Array(12118 => 1, 11982 => 2, 12259 => 3, 12057 => 4, 12056 => 5, 12264 => 6, 12098 => 7, 11988 => 8, 12018 => 9, 11502 => 10, 10184 => 11, 12397 => 12, 6109 => 13, 14889 => 14, 14887 => 15, 14888 => 16, 14890 => 17, 12435 => 18, 13020 => 19, 12017 => 20, 11983 => 21, 14601 => 22, 11981 => 23, 14020 => 24, 11583 => 25, 14517 => 26, 14507 => 27, 14510 => 28, 11382 => 29, 15082 => 30, 15083 => 31, 15085 => 32, 15114 => 33, 14509 => 34, 14515 => 35, 11380 => 36, 14834 => 37, 15348 => 38, 15341 => 39, 15340 => 40, 15370 => 41, 15369 => 42, 15339 => 43, 15263 => 44, 50000 => 45, 15516 => 46, 15510 => 47, 15299 => 48, 15509 => 49, 50001 => 50, 15517 => 51, 15727 => 52, 16028 => 53, 15931 => 54, 15932 => 55, 15928 => 56, 15956 => 57, 15953 => 58, 15952 => 59, 16061 => 60, 16060 => 61, 50002 => 62, 15954 => 63, 15936 => 64, 16011 => 65, 15989 => 66, 15990 => 67);
	private $instanceLink = Array(1 => "01111111111", 2 => "00000000001", 3 => "00000000000000000011111111", 4 => "00000000000000000000000000111111111111", 5 => "00000000000000000000000000000000000000111111", 6 => "00000000000000000000000000000000000000000000111111111", 7 => "00000000000000000000000000000000000000000000000000000111111111111111", 8 => "000000000000001111", 9 => "00000000000001", 10 => "0000000000001", 11 => "000000000000001111", 12 => "000000000000001111", 13 => "000000000000001111", 14 => "00000000000000000000000000000000000000000000111111111");
	private $sname = "";
	private $name = "";
	private $sid = 0;
	private $charid = 0;
	private $classid = 0;
	private $gid = 0;
	private $gname = "";
	private $raids = array();
	private $raidValue = array();
	private $mixed = array();
	private $mode = 0;
	private $faction = "";
	private $typee = 0;
	private $prefix = array(
		1 => Array(
			0 => "bo",
			1 => "ao",
			2 => "bm",
			3 => "am"
		),
		2 => Array(
			0 => "o",
			1 => "o",
			2 => "m",
			3 => "m"
		)
	);
	
	private function getUserData($db, $server, $name){
		$this->sname = $server;
		$this->name = $name;
		$q = $db->query('SELECT a.id, b.id as sid, a.classid, a.guildid, c.name as gname, a.faction FROM chars a LEFT JOIN servernames b ON a.serverid = b.id LEFT JOIN guilds c ON a.guildid = c.id WHERE b.expansion=0 AND b.name = "'.$server.'" AND a.name = "'.$name.'"')->fetch();
		$this->sid = $q->sid;
		$this->charid = $q->id;
		$this->classid = $q->classid;
		$this->gid = $q->guildid;
		$this->gname = $q->gname;
		$this->faction = ($q->faction==1) ? "alliance" : "horde";
	}
	
	private function getRankingsLink($id){
		$link = "0";
		for ($i=1; $i<$this->bossPos[$id]; $i++){
			$link .= "0";
		}
		$link .= "1";
		return $link;
	}
	
	private $kp = array(
		1 => array(1,5,6),
		3 => array(1,2,4,5,6),
		6 => array(1,2,3,4,5),
		7 => array(1,2,3)
	);
	private $mixedInfo = array();
	private function getRaidValues($db){
		$str = "";
		$temp = array();
		foreach ($this->raidBosses as $k => $v){
			foreach ($v as $key => $var){
				$str .= ($r =  ($str != "") ? "," : "").$var;
			}
		}
		if ($str != ""){
			foreach($db->query('SELECT a.type, a.'.$this->prefix[1][$this->mode].'val as val, b.time, a.'.$this->prefix[2][$this->mode].'attemptid as attemptid, a.charid, c.classid, b.rid, c.serverid, a.bossid, a.id FROM `v-rankings` a LEFT JOIN `v-raids-attempts` b ON a.'.$this->prefix[2][$this->mode].'attemptid = b.id LEFT JOIN chars c ON a.charid = c.id WHERE '.($r = ($this->typee == 0) ? "" : "a.type=".$this->typee." AND ").'a.'.$this->prefix[1][$this->mode].'val>200  ORDER BY a.'.$this->prefix[1][$this->mode].'val DESC') as $row){
				if (!isset($temp[$row->bossid]))
					$temp[$row->bossid] = array();
				$temp[$row->bossid][$row->id] = $row;
			}
		}
		
		foreach ($this->raidBosses as $k => $v){
			foreach ($v as $key => $var){
				$counter = array();
				foreach ($temp[$var] as $row){
					$counter[1][$row->type][1] += 1; // overall
					$counter[1][$row->type][2][$row->classid] += 1; // overall class
					$counter[1][$row->type][3][$this->typeById[$row->type][$row->classid]] += 1; // overall type
					$counter[2][$row->serverid][$row->type][1] += 1; // realm
					$counter[2][$row->serverid][$row->type][2][$row->classid] += 1; // realm class
					$counter[2][$row->serverid][$row->type][3][$this->typeById[$row->type][$row->classid]] += 1; // realm type
					foreach($this->kp[$k] as $va){
						if (!$this->mixedInfo[$row->type][$row->charid][$va])
							$this->mixedInfo[$row->type][$row->charid][$va] = Array(1=>$row->time, 2=>$row->classid, 3=>$row->serverid, 4=>array());
						if ($this->mixedInfo[$row->type][$row->charid][$va][1]<$row->time)
							$this->mixedInfo[$row->type][$row->charid][$va][1] = $row->time;
						if (!in_array($row->bossid, $this->mixedInfo[$row->type][$row->charid][$va][4]))
							array_push($this->mixedInfo[$row->type][$row->charid][$va][4], $row->bossid);
					}
					if ($this->mixed[$k][$row->type][$row->charid])
						$this->mixed[$k][$row->type][$row->charid] = ($this->mixed[$k][$row->type][$row->charid]+$row->val)/2;
					else
						$this->mixed[$k][$row->type][$row->charid] = $row->val;
					if ($this->charid == $row->charid){
						if ($row->val > 50){
							$this->raidValue[$var][$row->type] = Array(
								1 => $row->val,
								2 => $row->time,
								3 => $row->attemptid,
								4 => $counter[1][$row->type][1],
								5 => $counter[1][$row->type][2][$row->classid],
								6 => $counter[1][$row->type][3][$this->typeById[$row->type][$row->classid]],
								7 => $counter[2][$row->serverid][$row->type][1],
								8 => $counter[2][$row->serverid][$row->type][2][$row->classid],
								9 => $counter[2][$row->serverid][$row->type][3][$this->typeById[$row->type][$row->classid]],
								10 => $row->rid
							);
						}
					}
				}
			}
		}
	}
	
	private function hasKilledAllBoss($byPlayer, $toKill){
		foreach($toKill as $key => $var){
			if (!in_array($key, $byPlayer)){
				return false;
			}
		}
		return true;
	}
	
	private $mixedValues = array();
	private $mixedResult = array();
	private $kpByName = array(
		1 => "NAXX+AQ+BWL+MC",
		2 => "NAXX+AQ+BWL",
		3 => "NAXX+AQ",
		4 => "AQ+BWL",
		5 => "AQ+BWL+MC",
		6 => "BWL+MC",
	);
	private function createMixedValues(){
		$toKill = array();
		foreach($this->kp as $k => $v){
			foreach($v as $var){
				foreach($this->raidBosses[$k] as $va){
					$toKill[$var][$va] = true;
				}
			}
		}
		
		// Summing them together
		for($i=1; $i<8; $i++){
			foreach($this->mixed[$i] as $k => $v){ // type
				foreach($v as $key => $var){  // charid
					foreach($this->kp[$i] as $va){ // raidids
						if ($this->mixedValues[$va][$k][$key])
							$this->mixedValues[$va][$k][$key] = ($this->mixedValues[$va][$k][$key]+$var)/2;
						else
							$this->mixedValues[$va][$k][$key] = $var;
					}
				}
			}
		}
		
		// Sorting those arrays
		for ($i=1; $i<7; $i++){
			foreach(array(-1, 1) as $k){
				arsort($this->mixedValues[$i][$k]);
			}
		}
		
		// assigning mixedResult
		$counter = array();
		for ($i=1; $i<7; $i++){
			foreach($this->mixedValues[$i] as $k => $v){ //type
				foreach($v as $key => $var){ // charid
					$classid = $this->mixedInfo[$k][$key][$i][2];
					$serverid = $this->mixedInfo[$k][$key][$i][3];
					$counter[$i][1][$k][1] += 1; // overall
					$counter[$i][1][$k][2][$classid] += 1; // overall class
					$counter[$i][1][$k][3][$this->typeById[$k][$classid]] += 1; // overall type
					$counter[$i][2][$serverid][$k][1] += 1; // realm
					$counter[$i][2][$serverid][$k][2][$classid] += 1; // realm class
					$counter[$i][2][$serverid][$k][3][$this->typeById[$k][$classid]] += 1; // realm type
					if ($key == $this->charid && $this->hasKilledAllBoss($this->mixedInfo[$k][$key][$i][4], $toKill[$i])){
						if ($var >= 50){
							$this->mixedResult[$k][$i] = Array( //type, instance
								1 => $counter[$i][1][$k][1],
								2 => $counter[$i][1][$k][2][$classid],
								3 => $counter[$i][1][$k][3][$this->typeById[$k][$classid]],
								4 => $counter[$i][2][$serverid][$k][1],
								5 => $counter[$i][2][$serverid][$k][2][$classid],
								6 => $counter[$i][2][$serverid][$k][3][$this->typeById[$k][$classid]],
								7 => $var,
								8 => $this->mixedInfo[$k][$this->charid][$i][1]
							);
							break 1;
						}
					}
					$p += 1;
				}
			}
		}
	}

	public function checkIfAny($raidId){
		foreach($this->raidBosses[$raidId] as $name => $npcid){
			if (isset($this->raidValue[$npcid]))
				return true;
		}
		return false;
	}
	
	public function content(){
		$content = '
		<div class="container cont" id="container">
			<section class="centredNormal top">
				<div class="ttitle">
					<img src="{path}Vanilla/Character/img/'.$this->faction.'.png"> <span class="color-'.$this->classById[$this->classid].'">'.$this->name.'</span> <span><a class="'.$this->faction.'" href="{path}Vanilla/Guild/'.$this->sname.'/'.$this->gname.'/0">&lt;'.$this->gname.'&gt;</a></span> on '.$this->sname.'
				</div>
				<a href="{path}Vanilla/Armory/'.$this->sname.'/'.$this->name.'"><div class="pseudoButton">Armory</div></a>
				<select onchange="window.location.replace(\'{path}/Vanilla/Character/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/\'+this.value);">
					<option value="0"'.($r = ($this->typee==0) ? " selected" : "").'>Any type</option>
					<option value="-1"'.($r = ($this->typee==-1) ? " selected" : "").'>DPS</option>
					<option value="1"'.($r = ($this->typee==1) ? " selected" : "").'>HPS</option>
				</select>
				<select onchange="window.location.replace(\'{path}/Vanilla/Character/'.$this->sname.'/'.$this->name.'/\'+this.value+\'/'.$this->typee.'\');">
					<option value="0"'.($r = ($this->mode==0) ? " selected" : "").'>Best all time</option>
					<option value="1"'.($r = ($this->mode==1) ? " selected" : "").'>Average all time</option>
					<option value="2"'.($r = ($this->mode==2) ? " selected" : "").'>Best this quarter</option>
					<option value="3"'.($r = ($this->mode==3) ? " selected" : "").'>Average this quarter</option>
				</select>
			</section>
			<section class="table">
				<div class="right">
					<div class="sleft">
						<table cellspacing="0">
							<tr>
								<th colspan="2">Recent raids</th>
								<th class="fulllist"><a href="{path}Vanilla/Character/Raids/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
			';
			$strids = "0";
			foreach ($this->db->query('SELECT a.tsstart, a.nameid, b.name, a.id FROM `v-raids` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN `v-raids-participants` c ON a.id = c.rid WHERE (c.dps LIKE "%'.$this->charid.'%" or c.healers LIKE "%'.$this->charid.'%" or c.tanks LIKE "%'.$this->charid.'%") AND a.rdy = 1 ORDER BY a.id DESC LIMIT 10') as $row){
				$content .= '
							<tr>
								<td class="nlstring pve"><img src="{path}Vanilla/Character/img/'.$row->nameid.'.png" /><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->raidsById[$row->nameid].'</a></td>
								<td class="nlstring"><img src="{path}Vanilla/Character/img/'.$this->faction.'.png" /><a class="'.$this->faction.'" href="{path}Vanilla/Guild/'.$this->sname.'/'.$row->name.'/0">'.$row->name.'</a></td>
								<td class="nsstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$row->id.'">'.date("d.m.y H:i", $row->tsstart).'</a></td>
							</tr>
				';
				$strids .= ",".$row->id;
			}
			$content .= '
						</table>
						<table cellspacing="0" class="margin marginbot">
							<tr>
								<th colspan="2">Recent kills</th>
								<th class="fulllist"><a href="{path}Vanilla/Character/Kills/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
			';
			foreach ($this->db->query('SELECT b.npcid, d.name as boss, c.name as gname, c.id as gid, a.id as rid, b.id as attemptid, b.time, a.nameid FROM `v-raids` a LEFT JOIN `v-raids-attempts` b ON a.id = b.rid LEFT JOIN guilds c ON a.guildid = c.id LEFT JOIN npcs d ON b.npcid = d.id WHERE a.id IN ('.$strids.') AND d.type = 1 AND a.rdy = 1 AND b.type=1 ORDER BY b.time DESC LIMIT 10') as $row){
				$content .= '
							<tr>
								<td class="nlstring pve"><img src="{path}Vanilla/Character/img/'.$row->nameid.'.png" /><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->boss.'</a></td>
								<td class="nlstring"><img src="{path}Vanilla/Character/img/'.$this->faction.'.png" /><a class="'.$this->faction.'" href="{path}Vanilla/Guild/'.$this->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
								<td class="nsstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->attemptid.'">'.date("d.m.y H:i", $row->time).'</a></td>
							</tr>
				';
			}
			$content .= '
						</table>
			';
			if ($this->checkIfAny(2)){
			$content .= '
						<table cellspacing="0" class="ranks marginbot">
							<tr title="Global rank | Global-Class rank | Global-Type rank | Realm rank | Realm-Class rank | Realm-Type rank | Category | Value | Bossname | Attempt
Global rank: The rank you achieved on all server.
Global-Class rank: The rank you achieved among your class on all server.
Global-Type rank: The rank you achieved among the caster or meele on all server.
Realm rank: The rank you achieved among the realm. 
Realm-Class rank: The rank you achieved on your realm among your class. 
Realm-Type rank: The rank you achieved among the caster or meele on your realm.
Attempt: The attempt this record was achieved.
Only records above 200 are taken into account!">
								<th colspan="10">Single bosses*</th>
							</tr>
			';
		foreach($this->raidBosses[2] as $k => $v){
			foreach ($this->raidValue[$v] as $key => $var){
					$content .= '
							<tr>
								<td class="num" title="Overall rank">'.$var[4].'</td>
								<td class="num" title="Overall class rank">'.$var[5].'</td>
								<td class="num" title="Overall type (meele/caster) rank">'.$var[6].'</td>
								<td class="num" title="Realm rank">'.$var[7].'</td>
								<td class="num" title="Realm class rank">'.$var[8].'</td>
								<td class="num" title="Realm type (meele/caster) rank">'.$var[9].'</td>
								<td class="num" title="Type">'.$this->type[$key].'</td>
								<td class="numv" title="Value">'.round($var[1], 2).'</td>
								<td class="lstring"><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(5)){
			$content .= '
						<table cellspacing="0" class="ranks marginbot">
							<tr title="Global rank | Global-Class rank | Global-Type rank | Realm rank | Realm-Class rank | Realm-Type rank | Category | Value | Bossname | Attempt
Global rank: The rank you achieved on all server.
Global-Class rank: The rank you achieved among your class on all server.
Global-Type rank: The rank you achieved among the caster or meele on all server.
Realm rank: The rank you achieved among the realm. 
Realm-Class rank: The rank you achieved on your realm among your class. 
Realm-Type rank: The rank you achieved among the caster or meele on your realm.
Attempt: The attempt this record was achieved.
Only records above 200 are taken into account!">
								<th colspan="10">Ruins of Ahn\'Qiraj*</th>
							</tr>
			';
		foreach($this->raidBosses[5] as $k => $v){
			foreach ($this->raidValue[$v] as $key => $var){
					$content .= '
							<tr>
								<td class="num" title="Overall rank">'.$var[4].'</td>
								<td class="num" title="Overall class rank">'.$var[5].'</td>
								<td class="num" title="Overall type (meele/caster) rank">'.$var[6].'</td>
								<td class="num" title="Realm rank">'.$var[7].'</td>
								<td class="num" title="Realm class rank">'.$var[8].'</td>
								<td class="num" title="Realm type (meele/caster) rank">'.$var[9].'</td>
								<td class="num" title="Type">'.$this->type[$key].'</td>
								<td class="numv" title="Value">'.round($var[1], 2).'</td>
								<td class="lstring"><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(4)){
			$content .= '
						<table cellspacing="0" class="ranks">
							<tr title="Global rank | Global-Class rank | Global-Type rank | Realm rank | Realm-Class rank | Realm-Type rank | Category | Value | Bossname | Attempt
Global rank: The rank you achieved on all server.
Global-Class rank: The rank you achieved among your class on all server.
Global-Type rank: The rank you achieved among the caster or meele on all server.
Realm rank: The rank you achieved among the realm. 
Realm-Class rank: The rank you achieved on your realm among your class. 
Realm-Type rank: The rank you achieved among the caster or meele on your realm.
Attempt: The attempt this record was achieved.
Only records above 200 are taken into account!">
								<th colspan="10">Zul\'Gurub*</th>
							</tr>
			';
		foreach($this->raidBosses[4] as $k => $v){
			foreach ($this->raidValue[$v] as $key => $var){
					$content .= '
							<tr>
								<td class="num" title="Overall rank">'.$var[4].'</td>
								<td class="num" title="Overall class rank">'.$var[5].'</td>
								<td class="num" title="Overall type (meele/caster) rank">'.$var[6].'</td>
								<td class="num" title="Realm rank">'.$var[7].'</td>
								<td class="num" title="Realm class rank">'.$var[8].'</td>
								<td class="num" title="Realm type (meele/caster) rank">'.$var[9].'</td>
								<td class="num" title="Type">'.$this->type[$key].'</td>
								<td class="numv" title="Value">'.round($var[1], 2).'</td>
								<td class="lstring"><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		$content .= '
					</div>
					<div class="sright">
		';
		if (sizeOf($this->mixedResult[1])>0 or sizeOf($this->mixedResult[-1])>0){
			$content .= '
						<table cellspacing="0" class="ranks marginbot">
							<tr title="Global rank | Global-Class rank | Global-Type rank | Realm rank | Realm-Class rank | Realm-Type rank | Category | Value | Instances | Attempt
Global rank: The rank you achieved on all server.
Global-Class rank: The rank you achieved among your class on all server.
Global-Type rank: The rank you achieved among the caster or meele on all server.
Realm rank: The rank you achieved among the realm. 
Realm-Class rank: The rank you achieved on your realm among your class. 
Realm-Type rank: The rank you achieved among the caster or meele on your realm.
Attempt: The attempt this record was achieved.
Only records above 200 are taken into account!">
								<th colspan="10">Mixed*</th>
							</tr>
			';
		foreach(($r = ($this->typee==0) ? array(-1, 1) : array($this->typee)) as $va){
			foreach($this->mixedResult[$va] as $key => $var){
					$content .= '
							<tr>
								<td class="num" title="Overall rank">'.$var[1].'</td>
								<td class="num" title="Overall class rank">'.$var[2].'</td>
								<td class="num" title="Overall type (meele/caster) rank">'.$var[3].'</td>
								<td class="num" title="Realm rank">'.$var[4].'</td>
								<td class="num" title="Realm class rank">'.$var[5].'</td>
								<td class="num" title="Realm type (meele/caster) rank">'.$var[6].'</td>
								<td class="num" title="Type">'.$this->type[$va].'</td>
								<td class="numv" title="Value">'.round($var[7], 2).'</td>
								<td class="lstring"><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$this->kpByName[$key].'</a></td>
								<td class="sstring">'.date("d.m.y H:i", $var[8]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(7)){
			$content .= '
						<table cellspacing="0" class="ranks marginbot">
							<tr title="Global rank | Global-Class rank | Global-Type rank | Realm rank | Realm-Class rank | Realm-Type rank | Category | Value | Bossname | Attempt
Global rank: The rank you achieved on all server.
Global-Class rank: The rank you achieved among your class on all server.
Global-Type rank: The rank you achieved among the caster or meele on all server.
Realm rank: The rank you achieved among the realm. 
Realm-Class rank: The rank you achieved on your realm among your class. 
Realm-Type rank: The rank you achieved among the caster or meele on your realm.
Attempt: The attempt this record was achieved.
Only records above 200 are taken into account!">
								<th colspan="10">Naxxramas*</th>
							</tr>
			';
		foreach($this->raidBosses[7] as $k => $v){
			foreach ($this->raidValue[$v] as $key => $var){
					$content .= '
							<tr>
								<td class="num" title="Overall rank">'.$var[4].'</td>
								<td class="num" title="Overall class rank">'.$var[5].'</td>
								<td class="num" title="Overall type (meele/caster) rank">'.$var[6].'</td>
								<td class="num" title="Realm rank">'.$var[7].'</td>
								<td class="num" title="Realm class rank">'.$var[8].'</td>
								<td class="num" title="Realm type (meele/caster) rank">'.$var[9].'</td>
								<td class="num" title="Type">'.$this->type[$key].'</td>
								<td class="numv" title="Value">'.round($var[1], 2).'</td>
								<td class="lstring"><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(6)){
			$content .= '
						<table cellspacing="0" class="ranks marginbot">
							<tr title="Global rank | Global-Class rank | Global-Type rank | Realm rank | Realm-Class rank | Realm-Type rank | Category | Value | Bossname | Attempt
Global rank: The rank you achieved on all server.
Global-Class rank: The rank you achieved among your class on all server.
Global-Type rank: The rank you achieved among the caster or meele on all server.
Realm rank: The rank you achieved among the realm. 
Realm-Class rank: The rank you achieved on your realm among your class. 
Realm-Type rank: The rank you achieved among the caster or meele on your realm.
Attempt: The attempt this record was achieved.
Only records above 200 are taken into account!">
								<th colspan="10">Temple of Ahn\'Qiraj*</th>
							</tr>
			';
		foreach($this->raidBosses[6] as $k => $v){
			foreach ($this->raidValue[$v] as $key => $var){
					$content .= '
							<tr>
								<td class="num" title="Overall rank">'.$var[4].'</td>
								<td class="num" title="Overall class rank">'.$var[5].'</td>
								<td class="num" title="Overall type (meele/caster) rank">'.$var[6].'</td>
								<td class="num" title="Realm rank">'.$var[7].'</td>
								<td class="num" title="Realm class rank">'.$var[8].'</td>
								<td class="num" title="Realm type (meele/caster) rank">'.$var[9].'</td>
								<td class="num" title="Type">'.$this->type[$key].'</td>
								<td class="numv" title="Value">'.round($var[1], 2).'</td>
								<td class="lstring"><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(3)){
			$content .= '
						<table cellspacing="0" class="ranks marginbot">
							<tr title="Global rank | Global-Class rank | Global-Type rank | Realm rank | Realm-Class rank | Realm-Type rank | Category | Value | Bossname | Attempt
Global rank: The rank you achieved on all server.
Global-Class rank: The rank you achieved among your class on all server.
Global-Type rank: The rank you achieved among the caster or meele on all server.
Realm rank: The rank you achieved among the realm. 
Realm-Class rank: The rank you achieved on your realm among your class. 
Realm-Type rank: The rank you achieved among the caster or meele on your realm.
Attempt: The attempt this record was achieved.
Only records above 200 are taken into account!">
								<th colspan="10">Blackwing Lair*</th>
							</tr>
			';
		foreach($this->raidBosses[3] as $k => $v){
			foreach ($this->raidValue[$v] as $key => $var){
					$content .= '
							<tr>
								<td class="num" title="Overall rank">'.$var[4].'</td>
								<td class="num" title="Overall class rank">'.$var[5].'</td>
								<td class="num" title="Overall type (meele/caster) rank">'.$var[6].'</td>
								<td class="num" title="Realm rank">'.$var[7].'</td>
								<td class="num" title="Realm class rank">'.$var[8].'</td>
								<td class="num" title="Realm type (meele/caster) rank">'.$var[9].'</td>
								<td class="num" title="Type">'.$this->type[$key].'</td>
								<td class="numv" title="Value">'.round($var[1], 2).'</td>
								<td class="lstring"><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(1)){
			$content .= '
						<table cellspacing="0" class="ranks">
							<tr title="Global rank | Global-Class rank | Global-Type rank | Realm rank | Realm-Class rank | Realm-Type rank | Category | Value | Bossname | Attempt
Global rank: The rank you achieved on all server.
Global-Class rank: The rank you achieved among your class on all server.
Global-Type rank: The rank you achieved among the caster or meele on all server.
Realm rank: The rank you achieved among the realm. 
Realm-Class rank: The rank you achieved on your realm among your class. 
Realm-Type rank: The rank you achieved among the caster or meele on your realm.
Attempt: The attempt this record was achieved.
Only records above 200 are taken into account!">
								<th colspan="10">Molten Core*</th>
							</tr>
			';
		foreach($this->raidBosses[1] as $k => $v){
			foreach ($this->raidValue[$v] as $key => $var){
					$content .= '
							<tr>
								<td class="num" title="Overall rank">'.$var[4].'</td>
								<td class="num" title="Overall class rank">'.$var[5].'</td>
								<td class="num" title="Overall type (meele/caster) rank">'.$var[6].'</td>
								<td class="num" title="Realm rank">'.$var[7].'</td>
								<td class="num" title="Realm class rank">'.$var[8].'</td>
								<td class="num" title="Realm type (meele/caster) rank">'.$var[9].'</td>
								<td class="num" title="Type">'.$this->type[$key].'</td>
								<td class="numv" title="Value">'.round($var[1], 2).'</td>
								<td class="lstring"><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		$content .= '
					</div>
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $server, $name, $mode, $type){
		$this->mode = intval($mode);
		$this->typee = intval($type);
		$this->getUserData($db, $this->antiSQLInjection($server), $name);
		$this->getRaidValues($db);
		$this->createMixedValues();
		$this->siteTitle = " - Characterinformation of ".$this->antiSQLInjection($name)." on ".$this->antiSQLInjection($server);
		$this->keyWords = $this->antiSQLInjection($name);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["server"], $_GET["name"], $_GET["mode"], $_GET["type"]);

?>