<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $raidsById = array(
		14 => "Hellfire Peninsula",
		15 => "Shadowmoon Valley",
		16 => "Black Temple",
		17 => "Serpentshrine Cavern",
		18 => "Karazhan",
		19 => "Gruul's Lair",
		20 => "Magtheridon's Lair",
		21 => "Zul'Aman",
		22 => "The Eye",
		23 => "Hyjal Summit",
		24 => "Sunwell Plateau",
	);
	public $raidBosses = array( // update npc db to match those ids
		2 => array( //0
			"Doom Lord Kazzak" => 18728,
			"Doomwalker" => 17711,
			"Magtheridon" => 17257,
		),
		15 => array( //1
			"Doomwalker" => 17711,
		),
		16 => array( //2
			"High Warlord Naj'entus" => 22887,
			"Supremus" => 22898,
			"Shade of Akama" => 22841,
			"Teron Gorefiend" => 22871,
			"Gurtogg Bloodboil" => 22948,
			"Reliquary of Souls" => 50002, // Group Boss
			"Mother Shahraz" => 22947,
			"The Illidari Council" => 23426, // This is the group health pool // GROUP BOSS
			"Illidan Stormrage" => 22917,
		),
		17 => array( //11
			"Hydross the Unstable" => 21216,
			"The Lurker Below" => 21217,
			"Leotheras the Blind" => 21215,
			"Fathom-Lord Karathress" => 21214,
			"Morogrim Tidewalker" => 21213,
			"Lady Vashj" => 21212,
		),
		18 => array( //17
			"Attumen the Huntsman" => 15550,
			"Moroes" => 15687,
			"Opera event" => 50001,
			"Maiden of Virtue" => 16457,
			"The Curator" => 15691,
			"Terestian Illhoof" => 15688,
			"Shade of Aran" => 16524,
			"Netherspite" => 15689,
			"Prince Malchezaar" => 15690,
			"Nightbane" => 17225,
		),
		19 => array( //27
			"High King Maulgar" => 18831, // Group Boss tho
			"Gruul the Dragonkiller" => 19044,
		),
		20 => array( //29
			"Magtheridon" => 17257,
		),
		21 => array( //30
			"Nalorakk" => 23576,
			"Jan'alai" => 23578,
			"Akil'zon" => 23574,
			"Halazzi" => 23577,
			"Hex Lord Malacrass" => 24239, // Group Boss?
			"Zul'jin" => 23863,
		),
		22 => array( //35
			"Al'ar" => 19514,
			"Void Reaver" => 19516,
			"High Astromancer Solarian" => 18805,
			"Kael'thas Sunstrider" => 19622,
		),
		23 => array( //39
			"Rage Winterchill" => 17767,
			"Anetheron" => 17808,
			"Kaz'rogal" => 17888,
			"Azgalor" => 17842,
			"Archimonde" => 17968,
		),
		24 => array( //44
			"Kalecgos" => 24850, // despawns, you dont rly kill him
			"Brutallus" => 24882,
			"Felmyst" => 25038,
			"Eredar Twins" => 50000,
			"M'uru" => 25741,
			"Kil'Jaeden" => 25608, // Not sure here! Confirmation!
		),
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
	public $bossPos = Array(18728 => 1, 17711 => 2, 22887 => 3, 22898 => 4, 22841 => 5, 22871 => 6, 22948 => 7, 50002 => 8, 22947 => 9, 23426 => 10, 22917 => 11, 21216 => 12, 21217 => 13, 21215 => 14, 21214 => 15, 21213 => 16, 21212 => 17, 15550 => 18, 15687 => 19, 50001 => 20, 16457 => 21, 15691 => 22, 15688 => 23, 16524 => 24, 15689 => 25, 15690 => 26, 17225 => 27, 18831 => 28, 19044 => 29, 17257 => 30, 23576 => 31, 23578 => 32, 23574 => 33, 23577 => 34, 23863 => 35, 19514 => 36, 19516 => 37, 18805 => 38, 19622 => 39, 17767 => 40, 17808 => 41, 17888 => 42, 17842 => 43, 17968 => 44, 24850 => 45, 24882 => 46, 25038 => 47, 50000 => 48, 25741 => 49, 25608 => 50, 24239 => 51); 
	private $instanceLink = Array(
		2 => "0110000000000000000000000000001",
		14 => "01",
		15 => "001",
		16 => "000111111111",
		17 => "000000000000111111",
		18 => "0000000000000000001111111111",
		19 => "000000000000000000000000000011",
		20 => "0000000000000000000000000000001",
		21 => "000000000000000000000000000000011111",
		22 => "0000000000000000000000000000000000001111",
		23 => "000000000000000000000000000000000000000011111",
		24 => "000000000000000000000000000000000000000000000111111"
	);
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
		$q = $db->query('SELECT a.id, b.id as sid, a.classid, a.guildid, c.name as gname, a.faction FROM chars a LEFT JOIN servernames b ON a.serverid = b.id LEFT JOIN guilds c ON a.guildid = c.id WHERE b.name = "'.$server.'" AND a.name = "'.$name.'" AND b.expansion = 1')->fetch();
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
		16 => array(1),
		17 => array(2),
		18 => array(3,4),
		19 => array(3,4),
		20 => array(3),
		22 => array(2),
		23 => array(1),
		24 => array(1),
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
			foreach($db->query('SELECT a.type, a.'.$this->prefix[1][$this->mode].'val as val, b.time, a.'.$this->prefix[2][$this->mode].'attemptid as attemptid, a.charid, c.classid, b.rid, c.serverid, a.bossid, a.id FROM `tbc-rankings` a LEFT JOIN `tbc-raids-attempts` b ON a.'.$this->prefix[2][$this->mode].'attemptid = b.id LEFT JOIN chars c ON a.charid = c.id WHERE '.($r = ($this->typee == 0) ? "" : "a.type=".$this->typee." AND ").'a.'.$this->prefix[1][$this->mode].'val>400 ORDER BY a.'.$this->prefix[1][$this->mode].'val DESC') as $row){
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
		1 => "HYJAL+SWP+BT",
		2 => "SSC+TK",
		3 => "KARA+GRUUL+MAG",
		4 => "KARA+GRUUL",
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
		for($i=16; $i<25; $i++){
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
		for ($i=1; $i<5; $i++){
			foreach(array(-1, 1) as $k){
				arsort($this->mixedValues[$i][$k]);
			}
		}
		
		// assigning mixedResult
		$counter = array();
		for ($i=1; $i<5; $i++){
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
					<img src="{path}TBC/Character/img/'.$this->faction.'.png"> <span class="color-'.$this->classById[$this->classid].'">'.$this->name.'</span> <span><a class="'.$this->faction.'" href="{path}TBC/Guild/'.$this->sname.'/'.$this->gname.'/0">&lt;'.$this->gname.'&gt;</a></span> on '.$this->sname.'
				</div>
				<a href="{path}TBC/Armory/'.$this->sname.'/'.$this->name.'"><div class="pseudoButton">Armory</div></a>
				<select onchange="window.location.replace(\'{path}/TBC/Character/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/\'+this.value);">
					<option value="0"'.($r = ($this->typee==0) ? " selected" : "").'>Any type</option>
					<option value="-1"'.($r = ($this->typee==-1) ? " selected" : "").'>DPS</option>
					<option value="1"'.($r = ($this->typee==1) ? " selected" : "").'>HPS</option>
				</select>
				<select onchange="window.location.replace(\'{path}/TBC/Character/'.$this->sname.'/'.$this->name.'/\'+this.value+\'/'.$this->typee.'\');">
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
								<th class="fulllist"><a href="{path}TBC/Character/Raids/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
			';
			$strids = "0";
			foreach ($this->db->query('SELECT a.tsstart, a.nameid, b.name, a.id FROM `tbc-raids` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN `tbc-raids-participants` c ON a.id = c.rid WHERE (c.dps LIKE "%'.$this->charid.'%" or c.healers LIKE "%'.$this->charid.'%" or c.tanks LIKE "%'.$this->charid.'%") AND a.rdy = 1 ORDER BY a.id DESC LIMIT 10') as $row){
				$content .= '
							<tr>
								<td class="nlstring pve"><img src="{path}TBC/Character/img/'.$row->nameid.'.png" /><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->raidsById[$row->nameid].'</a></td>
								<td class="nlstring"><img src="{path}TBC/Character/img/'.$this->faction.'.png" /><a class="'.$this->faction.'" href="{path}TBC/Guild/'.$this->sname.'/'.$row->name.'/0">'.$row->name.'</a></td>
								<td class="nsstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$row->id.'">'.date("d.m.y H:i", $row->tsstart).'</a></td>
							</tr>
				';
				$strids .= ",".$row->id;
			}
			$content .= '
						</table>
						<table cellspacing="0" class="margin marginbot">
							<tr>
								<th colspan="2">Recent kills</th>
								<th class="fulllist"><a href="{path}TBC/Character/Kills/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
			';
			foreach ($this->db->query('SELECT b.npcid, d.name as boss, c.name as gname, c.id as gid, a.id as rid, b.id as attemptid, b.time, a.nameid FROM `tbc-raids` a LEFT JOIN `tbc-raids-attempts` b ON a.id = b.rid LEFT JOIN guilds c ON a.guildid = c.id LEFT JOIN tbc_npcs d ON b.npcid = d.id WHERE a.id IN ('.$strids.') AND d.type = 1 AND a.rdy = 1 AND b.type=1 ORDER BY b.time DESC LIMIT 10') as $row){
				$content .= '
							<tr>
								<td class="nlstring pve"><img src="{path}TBC/Character/img/'.$row->nameid.'.png" /><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->boss.'</a></td>
								<td class="nlstring"><img src="{path}TBC/Character/img/'.$this->faction.'.png" /><a class="'.$this->faction.'" href="{path}TBC/Guild/'.$this->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
								<td class="nsstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->attemptid.'">'.date("d.m.y H:i", $row->time).'</a></td>
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
Only records above 400 are taken into account!">
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
								<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(19)){
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
Only records above 400 are taken into account!">
								<th colspan="10">Gruul\'s Lair*</th>
							</tr>
			';
		foreach($this->raidBosses[19] as $k => $v){
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
								<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(18)){
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
Only records above 400 are taken into account!">
								<th colspan="10">Karazhan*</th>
							</tr>
			';
		foreach($this->raidBosses[18] as $k => $v){
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
								<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(21)){
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
Only records above 400 are taken into account!">
								<th colspan="10">Zul\'Aman*</th>
							</tr>
			';
		foreach($this->raidBosses[21] as $k => $v){
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
								<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
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
Only records above 400 are taken into account!">
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
								<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$this->kpByName[$key].'</a></td>
								<td class="sstring">'.date("d.m.y H:i", $var[8]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(24)){
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
Only records above 400 are taken into account!">
								<th colspan="10">Sunwell Plateau*</th>
							</tr>
			';
		foreach($this->raidBosses[24] as $k => $v){
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
								<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(23)){
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
Only records above 400 are taken into account!">
								<th colspan="10">Hyjal Summit*</th>
							</tr>
			';
		foreach($this->raidBosses[23] as $k => $v){
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
								<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(16)){
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
Only records above 400 are taken into account!">
								<th colspan="10">Black Temple*</th>
							</tr>
			';
		foreach($this->raidBosses[16] as $k => $v){
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
								<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(17)){
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
Only records above 400 are taken into account!">
								<th colspan="10">Serpentshrine Cavern*</th>
							</tr>
			';
		foreach($this->raidBosses[17] as $k => $v){
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
								<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->checkIfAny(22)){
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
Only records above 400 are taken into account!">
								<th colspan="10">The Eye*</th>
							</tr>
			';
		foreach($this->raidBosses[22] as $k => $v){
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
								<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
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