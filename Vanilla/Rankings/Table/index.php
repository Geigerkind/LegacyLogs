<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $mode = 0;
	private $faction = 0;
	private $server = "";
	private $type = -1;
	private $classe = "";
	private $id = "";
	private $bossesById = Array (0 => 12118, 1 => 11982, 2 => 12259, 3 => 12057, 4 => 12056, 5 => 12264, 6 => 12098, 7 => 11988, 8 => 12018, 9 => 11502, 10 => 10184, 11 => 12397, 12 => 6109, 13 => 14889, 14 => 14887, 15 => 14888, 16 => 14890, 17 => 12435, 18 => 13020, 19 => 12017, 20 => 11983, 21 => 14601, 22 => 11981, 23 => 14020, 24 => 11583, 25 => 14517, 26 => 14507, 27 => 14510, 28 => 11382, 29 => 15082, 30 => 15083, 31 => 15085, 32 => 15114, 33 => 14509, 34 => 14515, 35 => 11380, 36 => 14834, 37 => 15348, 38 => 15341, 39 => 15340, 40 => 15370, 41 => 15369, 42 => 15339, 43 => 15263, 44 => 50000, 45 => 15516, 46 => 15510, 47 => 15299, 48 => 15509, 49 => 50001, 50 => 15517, 51 => 15727, 52 => 16028, 53 => 15931, 54 => 15932, 55 => 15928, 56 => 15956, 57 => 15953, 58 => 15952, 59 => 16061, 60 => 16060, 61 => 50002, 62 => 15954, 63 => 15936, 64 => 16011, 65 => 15989, 66 => 15990);
	private $prefix = array(
		1 => "ao",
		2 => "o"
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
	private $bossList = array(
		1 => array(1=>"01111111111",2=>"Molten Core"),
		2 => array(1=>"01",2=>"Lucifron"),
		3 => array(1=>"001",2=>"Magmadar"),
		4 => array(1=>"0001",2=>"Gehennas"),
		5 => array(1=>"00001",2=>"Garr"),
		6 => array(1=>"000001",2=>"Baron Geddon"),
		7 => array(1=>"0000001",2=>"Shazzrah"),
		8 => array(1=>"00000001",2=>"Sulfuron Harbinger"),
		9 => array(1=>"000000001",2=>"Golemagg the Incinerator"),
		10 => array(1=>"0000000001",2=>"Majordomo Executus"),
		11 => array(1=>"00000000001",2=>"Ragnaros"),
		12 => array(1=>"000000000001111111",2=>"Single bosses"),
		13 => array(1=>"000000000001",2=>"Onyxia"),
		14 => array(1=>"0000000000001",2=>"Doomlord Kazzak"),
		15 => array(1=>"00000000000001",2=>"Azuregos"),
		16 => array(1=>"000000000000001",2=>"Emeriss"),
		17 => array(1=>"0000000000000001",2=>"Ysondre"),
		18 => array(1=>"00000000000000001",2=>"Lethon"),
		19 => array(1=>"000000000000000001",2=>"Taerar"),
		20 => array(1=>"00000000000000000011111111",2=>"Blackwing Lair"),
		21 => array(1=>"0000000000000000001",2=>"Razorgore the Untamed"),
		22 => array(1=>"00000000000000000001",2=>"Vaelastrasz the Corrupt"),
		23 => array(1=>"000000000000000000001",2=>"Broodlord Lashlayer"),
		24 => array(1=>"0000000000000000000001",2=>"Firemaw"),
		25 => array(1=>"00000000000000000000001",2=>"Ebonroc"),
		26 => array(1=>"000000000000000000000001",2=>"Flamegor"),
		27 => array(1=>"0000000000000000000000001",2=>"Chromaggus"),
		28 => array(1=>"00000000000000000000000001",2=>"Nefarian"),
		29 => array(1=>"00000000000000000000000000111111111111",2=>"Zul'Gurub"),
		30 => array(1=>"000000000000000000000000001",2=>"High Priestess Jeklik"),
		31 => array(1=>"0000000000000000000000000001",2=>"High Priest Venoxis"),
		32 => array(1=>"00000000000000000000000000001",2=>"High Priestess Mar'li"),
		33 => array(1=>"000000000000000000000000000001",2=>"Bloodlord Mandokir"),
		34 => array(1=>"0000000000000000000000000000001",2=>"Gri'lek of the Iron Blood"),
		35 => array(1=>"00000000000000000000000000000001",2=>"Hazza'rah the Dreamwaver"),
		36 => array(1=>"000000000000000000000000000000001",2=>"Wushoolay the Storm Witch"),
		37 => array(1=>"0000000000000000000000000000000001",2=>"Gahz'ranka"),
		38 => array(1=>"00000000000000000000000000000000001",2=>"High Priest Thekal"),
		39 => array(1=>"000000000000000000000000000000000001",2=>"High Priestess Arlokk"),
		40 => array(1=>"0000000000000000000000000000000000001",2=>"Jin'do the Hexxer"),
		41 => array(1=>"00000000000000000000000000000000000001",2=>"Hakkar"),
		42 => array(1=>"00000000000000000000000000000000000000111111",2=>"Ruins of Ahn'Qiraj"),
		43 => array(1=>"000000000000000000000000000000000000001",2=>"Kurinnaxx"),
		44 => array(1=>"0000000000000000000000000000000000000001",2=>"General Rajaxx"),
		45 => array(1=>"00000000000000000000000000000000000000001",2=>"Moam"),
		46 => array(1=>"000000000000000000000000000000000000000001",2=>"Buru the Gorger"),
		47 => array(1=>"0000000000000000000000000000000000000000001",2=>"Ayamiss the Hunter"),
		48 => array(1=>"00000000000000000000000000000000000000000001",2=>"Ossirian the Unscarred"),
		49 => array(1=>"00000000000000000000000000000000000000000000111111111",2=>"Temple of Ahn'Qiraj"),
		50 => array(1=>"000000000000000000000000000000000000000000001",2=>"The Prophet Skeram"),
		51 => array(1=>"0000000000000000000000000000000000000000000001",2=>"The Bug Family"),
		52 => array(1=>"00000000000000000000000000000000000000000000001",2=>"Battleguard Sartura"),
		53 => array(1=>"000000000000000000000000000000000000000000000001",2=>"Fankriss the Unyielding"),
		54 => array(1=>"0000000000000000000000000000000000000000000000001",2=>"Viscidus"),
		55 => array(1=>"00000000000000000000000000000000000000000000000001",2=>"Princess Huhuran"),
		56 => array(1=>"000000000000000000000000000000000000000000000000001",2=>"The Twin Emperors"),
		57 => array(1=>"0000000000000000000000000000000000000000000000000001",2=>"Ouro"),
		58 => array(1=>"00000000000000000000000000000000000000000000000000001",2=>"C'Thun"),
		59 => array(1=>"00000000000000000000000000000000000000000000000000000111111111111111",2=>"Naxxramas"),
		60 => array(1=>"000000000000000000000000000000000000000000000000000001",2=>"Patchwerk"),
		61 => array(1=>"0000000000000000000000000000000000000000000000000000001",2=>"Grobbulus"),
		62 => array(1=>"00000000000000000000000000000000000000000000000000000001",2=>"Gluth"),
		63 => array(1=>"000000000000000000000000000000000000000000000000000000001",2=>"Thaddius"),
		64 => array(1=>"0000000000000000000000000000000000000000000000000000000001",2=>"Anub'Rekhan"),
		65 => array(1=>"00000000000000000000000000000000000000000000000000000000001",2=>"Grand Widow Faerlina"),
		66 => array(1=>"000000000000000000000000000000000000000000000000000000000001",2=>"Maexxna"),
		67 => array(1=>"0000000000000000000000000000000000000000000000000000000000001",2=>"Instructor Razuvious"),
		68 => array(1=>"00000000000000000000000000000000000000000000000000000000000001",2=>"Gothik the Harvester"),
		69 => array(1=>"000000000000000000000000000000000000000000000000000000000000001",2=>"The Four Horsemen"),
		70 => array(1=>"0000000000000000000000000000000000000000000000000000000000000001",2=>"Noth the Plaguebringer"),
		71 => array(1=>"00000000000000000000000000000000000000000000000000000000000000001",2=>"Heigan the Unclean"),
		72 => array(1=>"000000000000000000000000000000000000000000000000000000000000000001",2=>"Loatheb"),
		73 => array(1=>"0000000000000000000000000000000000000000000000000000000000000000001",2=>"Sapphiron"),
		74 => array(1=>"00000000000000000000000000000000000000000000000000000000000000000001",2=>"Kel'Thuzad"),
		75 => array(1=>"01111111111000000011111111000000000000000000111111111111111111111111",2=>"NAXX+AQ+BWL+MC"),
		76 => array(1=>"00000000000000000011111111000000000000000000111111111111111111111111",2=>"NAXX+AQ+BWL"),
		77 => array(1=>"00000000000000000000000000000000000000000000111111111111111111111111",2=>"NAXX+AQ"),
		78 => array(1=>"01111111111000000011111111000000000000000000111111111",2=>"AQ+BWL+MC"),
		79 => array(1=>"00000000000000000011111111000000000000000000111111111",2=>"AQ+BWL"),
		80 => array(1=>"01111111111000000011111111",2=>"BWL+MC")
	);
	private $realmtype = array(
		-1 => array(
			0 => 1,
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
			0 => 1,
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
	private $gender = array(
		1 => "male",
		2 => "male",
		3 => "female",
	);
	private $race = array(
		1 => "human",
		2 => "dwarf",
		3 => "nightelf",
		4 => "gnome",
		5 => "orc",
		6 => "undead",
		7 => "troll",
		8 => "tauren"
	);
	
	//11111111111111111111111111111111111111111111111111111111111111
	//11111111111111111111111
	//111111111 
	//11111111
	//1111111111111
	private function getName(){
		$rname = "";
		$next = false;
		$in = array();
		if ($this->id == "01111111111000000011111111000000000000000000111111111111111111111111")
			return "NAXX+AQ+BWL+MC";
		if ($this->id == "00000000000000000011111111000000000000000000111111111111111111111111")
			return "NAXX+AQ+BWL";
		if ($this->id == "00000000000000000000000000000000000000000000111111111111111111111111")
			return "NAXX+AQ";
		if ($this->id == "01111111111000000011111111000000000000000000111111111")
			return "AQ+BWL+MC";
		if ($this->id == "00000000000000000011111111000000000000000000111111111")
			return "AQ+BWL";
		if ($this->id == "01111111111000000011111111")
			return "BWL+MC";
		if (substr($this->id, 1, 10) == "1111111111"){
			$rname .= "Molten Core";
			$next = true;
		}else{
			$in[1] = 9;
		}
		if (substr($this->id, 11, 7) == "1111111"){
			$rname .= ($r = ($next) ? ", " : "")."Single bosses";
			$next = true;
		}else{
			$in[11] = 6;
		}
		if (substr($this->id, 18, 8) == "11111111"){
			$rname .= ($r = ($next) ? ", " : "")."Blackwing Lair";
			$next = true;
		}else{
			$in[18] = 7;
		}
		if (substr($this->id, 26, 12) == "111111111111"){
			$rname .= ($r = ($next) ? ", " : "")."Zul'Gurub";
			$next = true;
		}else{
			$in[26] = 11;
		}
		if (substr($this->id, 38, 6) == "111111"){
			$rname .= ($r = ($next) ? ", " : "")."Ruins of Ahn'Qiraj";
			$next = true;
		}else{
			$in[38] = 4;
		}
		if (substr($this->id, 44, 8) == "11111111"){
			$rname .= ($r = ($next) ? ", " : "")."Temple of Ahn'Qiraj";
			$next = true;
		}else{
			$in[44] = 8;
		}
		if (substr($this->id, 53, 15) == "111111111111111"){
			$rname .= ($r = ($next) ? ", " : "")."Naxxramas";
			$next = true;
		}else{
			$in[53] = 14;
		}
		$left = array();
		foreach($in as $key => $var){
			for($i=$key; $i<=($key+$var); $i++){
				if (substr($this->id, $i, 1) == "1"){
					if ($this->bossesById[$i-1]){
						array_push($left, $this->db->query('SELECT name FROM npcs WHERE id = '.$this->bossesById[$i-1])->fetch()->name);
					}
				}
			}
		}
		foreach($left as $var){
			$rname .= ($r = ($next) ? ", " : "").$var;
			$next = true;
		}
		if ($rname == "")
			return "Unknown";
		return ($r = (strlen($rname)> 220) ? substr($rname, 0, 220)."..." : $rname);
	}
	
	private function getConditions(){
		$con = "";
		if ($this->faction && $this->faction != 0)
			$con .= ' AND b.faction = '.$this->faction; 
		if ($this->server)
			$con .= ' AND b.serverid IN ('.$this->server.')';
		if ($this->type && $this->type != 0)
			$con .= ' AND a.type = '.$this->type; 
		if ($this->classe){
			$con .= ' AND b.classid IN ('.$this->classe.')';
		}
		return $con;
	}
	
	private function getBosses(){
		$t = array();
		for ($i=1; $i<=67; $i++){
			if (substr($this->id, $i, 1) == "1"){
				array_push($t, $this->bossesById[($i-1)]);
			}
		}
		return $t;
	}
	
	private function killedAllBosses($byPlayer,$toKill){
		foreach($toKill as $key => $var){
			if (!isset($byPlayer[$key])){
				return false;
			}
		}
		return true;
	}
	
	private function getValues(){
		$t = array();
		$i = array();
		$r = array();
		$bossid = "0";
		$toKill = array();
		$killedByPlayer = array();
		$ecept = array(15082=>true, 15083=>true, 15085=>true);
		foreach($this->getBosses() as $v){
			if (!$ecept[$v]){
				$bossid .= ",".$v;
				$toKill[$v] = true;
			}
		}
		//print 'SELECT a.charid, a.'.$this->prefix[1].'val as val, c.name as sname, b.name as charname, b.classid, e.name as gname, b.faction, a.'.$this->prefix[1].'time as time, d.time as tsend, a.'.$this->prefix[1].'change as changed, d.rid, a.'.$this->prefix[2].'attemptid as attemptid FROM `v-rankings` a LEFT JOIN chars b ON a.charid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `v-raids-attempts` d ON a.'.$this->prefix[2].'attemptid = d.id LEFT JOIN guilds e ON b.guildid = e.id WHERE a.bossid IN ('.$bossid.')'.$this->getConditions().';';
		foreach($this->db->query('SELECT f.race, f.gender, a.charid, a.'.$this->prefix[1].'val as val, c.name as sname, b.name as charname, b.classid, e.name as gname, b.faction, a.'.$this->prefix[1].'time as time, d.time as tsend, a.'.$this->prefix[1].'change as changed, d.rid, a.'.$this->prefix[2].'attemptid as attemptid, a.'.$this->prefix[3].'amount as aoamount, a.bossid FROM `v-rankings` a LEFT JOIN chars b ON a.charid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `v-raids-attempts` d ON a.'.$this->prefix[2].'attemptid = d.id LEFT JOIN guilds e ON b.guildid = e.id LEFT JOIN `armory` f ON a.charid = f.charid WHERE a.bossid IN ('.$bossid.')'.$this->getConditions().';') as $row){
			if ($t[$row->charid])
				$t[$row->charid] += $row->val;
			else
				$t[$row->charid] = $row->val;
			$killedByPlayer[$row->charid][$row->bossid] = true;
			if (!isset($i[$row->charid]))
				$i[$row->charid] = Array(
					1 => $row->sname,
					2 => $row->charname,
					3 => $row->classid,
					4 => $row->gname,
					5 => $row->faction,
					9 => $row->rid,
					10 => $row->attemptid,
					11 => 0,
					12 => 0,
					13 => (!isset($row->gender)) ? 1 : $row->gender,
					14 => ($row->faction==1) ? ($rq = (!isset($row->race)) ? 1 : $row->race) : ($rq = (!isset($row->race)) ? 5 : $row->race)
				);
			
			if ($i[$row->charid][6]) // time
				$i[$row->charid][6] = ($i[$row->charid][6]+$row->time)/2;
			else
				$i[$row->charid][6] = $row->time;
			
			if ($i[$row->charid][7]<$row->tsend or !$i[$row->charid][7])
				$i[$row->charid][7] = $row->tsend;
			
			if ($i[$row->charid][8])
				$i[$row->charid][8] += $row->changed;
			else
				$i[$row->charid][8] = $row->changed;
			$i[$row->charid][11] += $row->aoamount;
			$i[$row->charid][12]++;
		}
		
		foreach($t as $k => $v){
			$t[$k]= $v/$i[$k][12];
			$i[$k][8] = $i[$k][8]/$i[$k][12];
		}
		
		arsort($t);
		
		foreach($t as $key => $var){
			if ($key>0 && $this->killedAllBosses($killedByPlayer[$key], $toKill)){
				array_push($r, array(
					1 => $key,
					2 => $var,
					3 => $i[$key][1],
					4 => $i[$key][2],
					5 => $i[$key][3],
					6 => $i[$key][4],
					7 => $i[$key][5],
					8 => $i[$key][6],
					9 => $i[$key][7],
					10 => $i[$key][8],
					11 => $i[$key][9],
					12 => $i[$key][10],
					13 => $i[$key][11],
					14 => $i[$key][13],
					15 => $i[$key][14]
				));
			}
		}
		return $r;
	}
	
	private function getPic($i){
		if ($i>0)
			return 1;
		return 0;
	}
	
	private function getId($i){
		foreach($this->bossList as $k => $v){
			if ($i==$v[2])
				return $k;
		}
	}
	
	public function content(){
		$content = '
		<div class="container cont" id="container">
			<section class="centredNormal formular">
				<select name="mode" onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode=\'+this.value+\'&type='.$this->type.'&id='.$this->id.'&class='.$this->classe.'\');">
					<option value="0" '.($r = ($this->mode==0) ? " selected" : "").'">Average all time</option>
					<option value="1" '.($r = ($this->mode==1) ? " selected" : "").'">Best all time</option>
					<option value="2" '.($r = ($this->mode==2) ? " selected" : "").'">Average this quarter</option>
					<option value="3" '.($r = ($this->mode==3) ? " selected" : "").'">Best this quarter</option>
				</select>
				<select id="srealm" multiple="multiple">
			';
			$serverList = explode(",", $this->server);
			foreach($this->db->query('SELECT * FROM servernames WHERE expansion = 0') as $row){
				$content .= '
						<option value="'.$row->id.'"'.($r = (in_array($row->id, $serverList) || !$this->server) ? " selected" : "").'>'.$row->name.'</option>
				';
			}	
			$content .= '
				</select>
				<select onchange="window.location.replace(\'?server='.$this->server.'&faction=\'+this.value+\'&mode='.$this->mode.'&type='.$this->type.'&id='.$this->id.'&class='.$this->classe.'\');">
					<option value="0"'.($r = ($this->faction==0) ? " selected" : "").'>Any faction</option>
					<option value="-1"'.($r = ($this->faction==-1) ? " selected" : "").'>Horde</option>
					<option value="1"'.($r = ($this->faction==1) ? " selected" : "").'>Alliance</option>
				</select>
				<select onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type=\'+this.value+\'&id='.$this->id.'&class='.$this->classe.'\');">
					<option value="-1"'.($r = ($this->type==-1) ? " selected" : "").'>DPS</option>
					<option value="1"'.($r = ($this->type==1) ? " selected" : "").'>HPS</option>
				</select>
				<select id="sclass" multiple="multiple">
					<option value="1"'.($r = (strpos($this->classe, "1") !== FALSE or !$this->classe) ? " selected" : "").' class="color-warrior">Warrior</option>
					<option value="2"'.($r = (strpos($this->classe, "2") !== FALSE or !$this->classe) ? " selected" : "").' class="color-rogue">Rogue</option>
					<option value="3"'.($r = (strpos($this->classe, "3") !== FALSE or !$this->classe) ? " selected" : "").' class="color-priest">Priest</option>
					<option value="4"'.($r = (strpos($this->classe, "4") !== FALSE or !$this->classe) ? " selected" : "").' class="color-hunter">Hunter</option>
					<option value="5"'.($r = (strpos($this->classe, "5") !== FALSE or !$this->classe) ? " selected" : "").' class="color-druid">Druid</option>
					<option value="6"'.($r = (strpos($this->classe, "6") !== FALSE or !$this->classe) ? " selected" : "").' class="color-mage">Mage</option>
					<option value="7"'.($r = (strpos($this->classe, "7") !== FALSE or !$this->classe) ? " selected" : "").' class="color-warlock">Warlock</option>
					<option value="8"'.($r = (strpos($this->classe, "8") !== FALSE or !$this->classe) ? " selected" : "").' class="color-paladin">Paladin</option>
					<option value="9"'.($r = (strpos($this->classe, "9") !== FALSE or !$this->classe) ? " selected" : "").' class="color-shaman">Shaman</option>
				</select>
				<select onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id=\'+this.value+\'&class='.$this->classe.'\');">
				';
				foreach($this->bossList as $k => $v){
					$content .= '
						<option value="'.$v[1].'"'.($r = ($this->getName()==$v[2]) ? " selected" : "").'>'.$v[2].'</option>
					';
				}
				$curId = $this->getId($this->getName($this->id));
				$content .= '
				</select>
				<a href="{path}Vanilla/Rankings/Table/?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.($r = ($curId>1) ? $this->bossList[$curId-1][1] : $this->id).'&class='.$this->classe.'"><button class="icon-button icon-arrowleft" title="Previous"></button></a>
				<a href="{path}Vanilla/Rankings/Table/?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.($r = ($curId<sizeOf($this->bossList)) ? $this->bossList[$curId+1][1] : $this->id).'&class='.$this->classe.'"><button class="icon-button icon-arrowright" title="Next"></button></a>
			</section>
			<section class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th class="rank">Overall</th>
							<th class="rank">Classrank</th>
							<th class="rank">Typerank</th>
							<th class="timg char">Character</th>
							<th class="timg guild">Guild</th>
							<th class="server">Server</th>
							<th class="rank">Value</th>
							<th class="fstring">Date</th>
							<th class="rank" title="The development in the selected mode. In general it is the difference of the previous and the current value.">Change*</th>
						</tr>
		';
		$counter = array();
		foreach ($this->getValues() as $key => $var){
			if ($key==100)
				break;
			$fac = ($var[7] == 1) ? "alliance" : "horde";
			$counter[1][$var[5]] += 1; // o class
			$counter[2][$this->realmtype[$this->type][$var[5]]] += 1; // realm class
			$content .= '
						<tr>
							<td class="rank" title="Overall rank">'.($key+1).'</td>
							<td class="rank" title="Overall class rank">'.$counter[1][$var[5]].'</td>
							<td class="rank" title="Overall type rank">'.$counter[2][$this->realmtype[$this->type][$var[5]]].'</td>
							<td class="char"><img src="{path}Database/racegender/Ui-charactercreate-races_'.$this->race[$var[15]].'-'.$this->gender[$var[14]].'-small.png" /><img src="img/c'.$var[5].'.png"><a href="{path}Vanilla/Character/'.$var[3].'/'.$var[4].'/0" class="color-'.$this->classById[$var[5]].'">'.$var[4].'</a></td>
							<td class="guild"><img src="img/'.$fac.'.png"><a class="'.$fac.'" href="{path}Vanilla/Guild/'.$var[3].'/'.$var[6].'/0">'.$var[6].'</a></td>
							<td class="server">'.$var[3].'</td>
							<td class="rank"'.($r = ($this->mode==0 or $this->mode==2) ? ' title="'.$var[13].' attempts"' : '').'>'.$this->mReadable($var[2], 1).($r = ($this->mode==0 or $this->mode==2) ? "*" : "").'</td>
							<td class="fstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$var[11].'&attempts='.$var[12].'">'.date("d.m.y H:i", $var[9]).'</a></td>
							<td class="rank"><img src="img/'.$this->getPic($var[10]).'.png" />'.round($var[10], 1).'</td>
						</tr>
			';
		}
		$content .= '
					</table>
				</div>
			</section>
		</div>
		<script>
		$(\'#sclass\').multipleSelect({
			onClose: function() {
				window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.$this->id.'&class=\'+$(\'#sclass\').multipleSelect(\'getSelects\'));
			},
			allSelected: \'Any class\'
		});
		$(\'#srealm\').multipleSelect({
			onClose: function() {
				window.location.replace(\'?server=\'+$(\'#srealm\').multipleSelect(\'getSelects\')+\'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.$this->id.'&class='.$this->classe.'\');
			},
			allSelected: \'Any realm\'
		});
		</script>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $server, $faction, $mode, $type, $id, $classe){
		$this->mode = intval($this->antiSQLInjection($mode));
		$this->server = $this->antiSQLInjection($server);
		$this->faction = intval($this->antiSQLInjection($faction));
		$this->type = intval($this->antiSQLInjection($type));
		$this->classe = $this->antiSQLInjection($classe);
		if ($this->type == 0)
			$this->type = -1;
		$this->id = $this->antiSQLInjection($id);
		switch ($this->mode){
			case 0 :
				$this->prefix[1] = "ao";
				$this->prefix[2] = "o";
				$this->prefix[3] = "ao";
				break;
			case 1 :
				$this->prefix[1] = "bo";
				$this->prefix[2] = "o";
				$this->prefix[3] = "ao";
				break;
			case 2 :
				$this->prefix[1] = "am";
				$this->prefix[2] = "m";
				$this->prefix[3] = "bo";
				break;
			case 3 :
				$this->prefix[1] = "bm";
				$this->prefix[2] = "m";
				$this->prefix[3] = "bo";
				break;
		}
		$i = 1;
		foreach($_COOKIE as $k => $v){
			if (strlen($k)>65){
				$this->bossList[$i] = array(
					1 => $k,
					2 => "Custom: ".$this->getName($k)
				);
				$i++;
			}
		}
		$this->addCssLink("{path}External/multipleselect/multiple-select.css");
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js", true);
		$this->addJsLink("{path}External/multipleselect/multiple-select.js", true);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["server"], $_GET["faction"], $_GET["mode"], $_GET["type"], $_GET["id"], $_GET["class"]);

?>