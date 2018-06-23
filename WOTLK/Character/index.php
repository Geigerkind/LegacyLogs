<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $raidsById = array(
		2 => "Single Bosses",
		25 => "Onyxia's Lair 10", // 10 
		26 => "Onyxia's Lair 25", // 25
		27 => "Naxxramas 10", // 10
		28 => "Naxxramas 25", // 25
		29 => "The Eye of Eternity 10", // 10
		30 => "The Eye of Eternity 25", // 25
		31 => "Vault of Archavon 10", // 10
		32 => "Vault of Archavon 25", // 25
		33 => "The Obsidian Sanctum 10", // 10
		34 => "The Obsidian Sanctum 25", // 25
		35 => "Ulduar 10", // 10
		36 => "Ulduar 25", // 25
		37 => "Trial of the Crusader 10 NHC", // 10
		38 => "Trial of the Crusader 25 NHC", // 25
		39 => "Trial of the Crusader 10 HC", // 10 HC
		40 => "Trial of the Crusader 25 HC", // 25 HC
		41 => "Icecrown Citadel 10 NHC", // 10
		42 => "Icecrown Citadel 25 NHC", // 25
		43 => "Icecrown Citadel 10 HC", // 10 HC
		44 => "Icecrown Citadel 25 HC", // 25 HC
		45 => "The Ruby Sanctum 10 NHC", // 10
		46 => "The Ruby Sanctum 25 NHC", // 25
		47 => "The Ruby Sanctum 10 HC", // 10 HC
		48 => "The Ruby Sanctum 25 HC", // 25 HC
	);
	public $raidBosses = array( // update npc db to match those ids
		2 => array(
			"Onyxia 10" => 10184,
			"Onyxia 25" => 36538,
			"Malygos 10" => 28859,
			"Malygos 25" => 31734,
			"Sapphiron 10" => 28860,
			"Sapphiron 25" => 31311,
			"Halion 10" => 39863,
			"Halion 25" => 40142,
			"Halion 10 HC" => 39864,
			"Halion 25 HC" => 40143,
		),
		25 => array(
			"Onyxia" => 10184,
		),
		26 => array(
			"Onyxia" => 36538,
		),
		27 => array(
			"Patchwerk" => 16028,
			"Grobbulus" => 15931,
			"Gluth" => 15932,
			"Thaddius" => 15928,
			"Anub'Rekhan" => 15956,
			"Grand Widow Faerlina" => 15953,
			"Maexxna" => 15952,
			"Instructor Razuvious" => 16061,
			"Gothik the Harvester" => 16060,
			"The Four Horsemen" => 50005,
			"Noth the Plaguebringer" => 15954,
			"Heigan the Unclean" => 15936,
			"Loatheb" => 16011,
			"Sapphiron" => 15989,
			"Kel'Thuzad" => 15990
		),
		28 => array(
			"Patchwerk" => 31099,
			"Grobbulus" => 29373,
			"Gluth" => 29417,
			"Thaddius" => 29448,
			"Anub'Rekhan" => 29249,
			"Grand Widow Faerlina" => 29268,
			"Maexxna" => 29278,
			"Instructor Razuvious" => 29940,
			"Gothik the Harvester" => 29955,
			"The Four Horsemen" => 50021,
			"Noth the Plaguebringer" => 29615,
			"Heigan the Unclean" => 29701,
			"Loatheb" => 29718,
			"Sapphiron" => 29991,
			"Kel'Thuzad" => 30061
		),
		29 => array(
			"Malygos" => 28859,
		),
		30 => array(
			"Malygos" => 31734,
		),
		31 => array(
			"Archavon the Stone Watcher" => 31125,
			"Emalon the Storm Watcher" => 33993,
			"Koralon the Flame Watcher" => 35013,
			"Toravon the Ice Watcher" => 38433,
		),
		32 => array(
			"Archavon the Stone Watcher" => 31722,
			"Emalon the Storm Watcher" => 33994,
			"Koralon the Flame Watcher" => 35360,
			"Toravon the Ice Watcher" => 38462,
		),
		33 => array(
			"Shadron" => 30451,
			"Tenebron" => 30452,
			"Vesperon" => 30449,
			"Sapphiron" => 28860,
		),
		34 => array(
			"Shadron" => 31520,
			"Tenebron" => 31534,
			"Vesperon" => 31535,
			"Sapphiron" => 31311,
		),
		35 => array(
			"Ignis the Furnace Master" => 33118,
			"Razorscale" => 33186,
			"XT-002 Deconstructor" => 33293,
			"The Assembly of Iron" => 50000,
			"Kologarn" => 32930,
			"Auriaya" => 33515,
			"Mimiron" => 33244, // May be wrong
			"Freya" => 32906,
			"Thorim" => 32865,
			"Hodir" => 32845,
			"General Vezax" => 33271,
			"Yogg-Saron" => 33288,
			"Algalon the Observer" => 32871,
		),
		36 => array(
			"Ignis the Furnace Master" => 33190,
			"Razorscale" => 33724,
			"XT-002 Deconstructor" => 33885,
			"The Assembly of Iron" => 50008,
			"Kologarn" => 33909,
			"Auriaya" => 34175,
			"Mimiron" => 50025,
			"Freya" => 33360,
			"Thorim" => 33147,
			"Hodir" => 32846,
			"General Vezax" => 33449,
			"Yogg-Saron" => 33955,
			"Algalon the Observer" => 33070,
		),
		37 => array(
			"Beasts of Northrend" => 50001,
			"Lord Jaraxxus" => 34780,
			"Faction Champions" => 50002,
			"Twin Val'kyr" => 50003,
			"Anub'arak" => 34564,
		),
		38 => array(
			"Beasts of Northrend" => 50009,
			"Lord Jaraxxus" => 35216,
			"Faction Champions" => 50012,
			"Twin Val'kyr" => 50015,
			"Anub'arak" => 34566,
		),
		39 => array(
			"Beasts of Northrend" => 50010,
			"Lord Jaraxxus" => 35268,
			"Faction Champions" => 50013,
			"Twin Val'kyr" => 50016,
			"Anub'arak" => 35615,
		),
		40 => array(
			"Beasts of Northrend" => 50011,
			"Lord Jaraxxus" => 35269,
			"Faction Champions" => 50014,
			"Twin Val'kyr" => 50017,
			"Anub'arak" => 35616,
		),
		41 => array(
			"Lord Marrowgar" => 36612,
			"Lady Deathwhisper" => 36855,
			"Gunship Battle" => 50007,
			"Deathbringer Saurfang" => 37813,
			"Festergut" => 36626,
			"Rotface" => 36627,
			"Professor Putricide" => 36678,
			"Blood Prince Council" => 50004,
			"Blood-Queen Lana'thel" => 37955,
			"Valithria Dreamwalker" => 36789,
			"Sindragosa" => 36853,
			"The Lich King" => 36597,
		),
		42 => array(
			"Lord Marrowgar" => 37957,
			"Lady Deathwhisper" => 38106,
			"Gunship Battle" => 50022,
			"Deathbringer Saurfang" => 38402,
			"Festergut" => 37504,
			"Rotface" => 38390,
			"Professor Putricide" => 38431,
			"Blood Prince Council" => 50018,
			"Blood-Queen Lana'thel" => 38434,
			"Valithria Dreamwalker" => 38174, // May be the wrong id
			"Sindragosa" => 38265,
			"The Lich King" => 39166,
		),
		43 => array(
			"Lord Marrowgar" => 37958,
			"Lady Deathwhisper" => 38296,
			"Gunship Battle" => 50023,
			"Deathbringer Saurfang" => 38582,
			"Festergut" => 37505,
			"Rotface" => 38549,
			"Professor Putricide" => 38585,
			"Blood Prince Council" => 50019,
			"Blood-Queen Lana'thel" => 38435,
			"Valithria Dreamwalker" => 38589,
			"Sindragosa" => 38266,
			"The Lich King" => 39167,
		),
		44 => array(
			"Lord Marrowgar" => 37959,
			"Lady Deathwhisper" => 38297,
			"Gunship Battle" => 50024,
			"Deathbringer Saurfang" => 38583,
			"Festergut" => 37506,
			"Rotface" => 38550,
			"Professor Putricide" => 38586,
			"Blood Prince Council" => 50020,
			"Blood-Queen Lana'thel" => 38436,
			"Valithria Dreamwalker" => 38590,
			"Sindragosa" => 38267,
			"The Lich King" => 39168,
		),
		45 => array(
			"Saviana Ragefire" => 39823,
			"Baltharus the Warborn" => 39751,
			"General Zarithrian" => 39805,
			"Halion" => 39863,
		),
		46 => array(
			"Saviana Ragefire" => 39747, // May be wrong
			"Baltharus the Warborn" => 39899,
			"General Zarithrian" => 39746,
			"Halion" => 40142,
		),
		47 => array(
			"Saviana Ragefire" => 39823,
			"Baltharus the Warborn" => 39751,
			"General Zarithrian" => 39805,
			"Halion" => 39864,
		),
		48 => array(
			"Saviana Ragefire" => 39747,
			"Baltharus the Warborn" => 39899,
			"General Zarithrian" => 39746,
			"Halion" => 40143,
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
			9 => 2,
			10 => 1,
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
			9 => 2,
			10 => 1,
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
		9 => "shaman",
		10 => "deathknight",
	);
	public $instanceLink = Array(
		25 => "01",
		26 => "01",
		27 => "00111111111111111",
		28 => "00111111111111111",
		29 => "000000000000000001",
		30 => "000000000000000001",
		31 => "0000000000000000001111",
		32 => "0000000000000000001111",
		33 => "00000000000000000000000001",
		34 => "00000000000000000000000001",
		35 => "000000000000000000000000001111111111111",
		36 => "000000000000000000000000001111111111111",
		37 => "00000000000000000000000000000000000000011111",
		38 => "00000000000000000000000000000000000000011111",
		39 => "00000000000000000000000000000000000000011111",
		40 => "00000000000000000000000000000000000000011111",
		41 => "00000000000000000000000000000000000000000000111111111111",
		42 => "00000000000000000000000000000000000000000000111111111111",
		43 => "00000000000000000000000000000000000000000000111111111111",
		44 => "00000000000000000000000000000000000000000000111111111111",
		45 => "000000000000000000000000000000000000000000000000000000001111",
		46 => "000000000000000000000000000000000000000000000000000000001111",
		47 => "000000000000000000000000000000000000000000000000000000001111",
		48 => "000000000000000000000000000000000000000000000000000000001111",
	);
	public $bossPos = array(10184=>1,16028=>2,15931=>3,15932=>4,15928=>5,15956=>6,15953=>7,15952=>8,16061=>9,16060=>10,50005=>11,15954=>12,15936=>13,16011=>14,15989=>15,15990=>16,28859=>17,31125=>18,33993=>19,35013=>20,38433=>21,30451=>22,30452=>23,30449=>24,28860=>25,33118=>26,33186=>27,33293=>28,50000=>29,32930=>30,33515=>31,33244=>32,32906=>33,32865=>34,32845=>35,33271=>36,33288=>37,32871=>38,50001=>39,34780=>40,50002=>41,50003=>42,34564=>43,36612=>44,36855=>45,50007=>46,37813=>47,36626=>48,36627=>49,36678=>50,50004=>51,37955=>52,36789=>53,36853=>54,36597=>55,39823=>56,39751=>57,39805=>58,39863=>59,36538=>1,31099=>2,29373=>3,29417=>4,29448=>5,29249=>6,29268=>7,29278=>8,29940=>9,29955=>10,50021=>11,29615=>12,29701=>13,29718=>14,29991=>15,30061=>16,31734=>17,31722=>18,33994=>19,35360=>20,38462=>21,31520=>22,31534=>23,31535=>24,31311=>25,33190=>26,33724=>27,33885=>28,50008=>29,33909=>30,34175=>31,50025=>32,33360=>33,33147=>34,32846=>35,33449=>36,33955=>37,33070=>38,50009=>39,35216=>40,50012=>41,50015=>42,34566=>43,37957=>44,38106=>45,50022=>46,38402=>47,37504=>48,38390=>49,38431=>50,50018=>51,38434=>52,38174=>53,38265=>54,39166=>55,39747=>56,39899=>57,39746=>58,40142=>59,50010=>39,35268=>40,50013=>41,50016=>42,35615=>43,37958=>44,38296=>45,50023=>46,38582=>47,37505=>48,38549=>49,38585=>50,50019=>51,38435=>52,38589=>53,38266=>54,39167=>55,39864=>59,50011=>39,35269=>40,50014=>41,50017=>42,35616=>43,37959=>44,38297=>45,50024=>46,38583=>47,37506=>48,38550=>49,38586=>50,50020=>51,38436=>52,38590=>53,38267=>54,39168=>55,40143=>59);
	
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
		$q = $db->query('SELECT a.id, b.id as sid, a.classid, a.guildid, c.name as gname, a.faction FROM chars a LEFT JOIN servernames b ON a.serverid = b.id LEFT JOIN guilds c ON a.guildid = c.id WHERE b.name = "'.$server.'" AND a.name = "'.$name.'" AND b.expansion = 2')->fetch();
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
		25 => array(),
		26 => array(),
		27 => array(9),
		28 => array(10),
		29 => array(),
		30 => array(),
		31 => array(),
		32 => array(),
		33 => array(),
		34 => array(),
		35 => array(9,11,13),
		36 => array(10,12,14),
		37 => array(13,1),
		38 => array(14,2),
		39 => array(11,3),
		40 => array(12,4),
		41 => array(1,5),
		42 => array(2,6),
		43 => array(3,7),
		44 => array(4,8),
		45 => array(1,5),
		46 => array(2,6),
		47 => array(3,7),
		48 => array(4,8),
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
			foreach($db->query('SELECT a.type, a.'.$this->prefix[1][$this->mode].'val as val, b.time, a.'.$this->prefix[2][$this->mode].'attemptid as attemptid, a.charid, c.classid, b.rid, c.serverid, a.bossid, a.id FROM `wotlk-rankings` a LEFT JOIN `wotlk-raids-attempts` b ON a.'.$this->prefix[2][$this->mode].'attemptid = b.id LEFT JOIN chars c ON a.charid = c.id WHERE '.($r = ($this->typee == 0) ? "" : "a.type=".$this->typee." AND ").'a.'.$this->prefix[1][$this->mode].'val>1000 ORDER BY a.'.$this->prefix[1][$this->mode].'val DESC') as $row){
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
		1 => "RUBY+ICC+TOTC 10",
		2 => "RUBY+ICC+TOTC 25",
		3 => "RUBY+ICC+TOTC 10 HC",
		4 => "RUBY+ICC+TOTC 25 HC",
		5 => "RUBY+ICC 10",
		6 => "RUBY+ICC 25",
		7 => "RUBY+ICC 10 HC",
		8 => "RUBY+ICC 25 HC",
		9 => "NAXX+ULDUAR 10",
		10 => "NAXX+ULDUAR 25",
		11 => "TOTC+ULDUAR 10 HC",
		12 => "TOTC+ULDUAR 25 HC",
		13 => "TOTC+ULDUAR 10",
		14 => "TOTC+ULDUAR 25",
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
		for($i=25; $i<49; $i++){
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
		for ($i=1; $i<15; $i++){
			foreach(array(-1, 1) as $k){
				arsort($this->mixedValues[$i][$k]);
			}
		}
		
		// assigning mixedResult
		$counter = array();
		for ($i=1; $i<15; $i++){
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
	
	private function isInRaidValue($num){
		foreach($this->raidBosses[$num] as $var){
			if (isset($this->raidValue[$var]))
				return true;
		}
		return false;
	}
	
	public function content(){
		$content = '
		<div class="container cont" id="container">
			<section class="centredNormal top">
				<div class="ttitle">
					<img src="{path}WOTLK/Character/img/'.$this->faction.'.png"> <span class="color-'.$this->classById[$this->classid].'">'.$this->name.'</span> <span><a class="'.$this->faction.'" href="{path}WOTLK/Guild/'.$this->sname.'/'.$this->gname.'/0">&lt;'.$this->gname.'&gt;</a></span> on '.$this->sname.'
				</div>
				<a href="{path}WOTLK/Armory/'.$this->sname.'/'.$this->name.'"><div class="pseudoButton">Armory</div></a>
				<select onchange="window.location.replace(\'{path}/WOTLK/Character/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/\'+this.value);">
					<option value="0"'.($r = ($this->typee==0) ? " selected" : "").'>Any type</option>
					<option value="-1"'.($r = ($this->typee==-1) ? " selected" : "").'>DPS</option>
					<option value="1"'.($r = ($this->typee==1) ? " selected" : "").'>HPS</option>
				</select>
				<select onchange="window.location.replace(\'{path}/WOTLK/Character/'.$this->sname.'/'.$this->name.'/\'+this.value+\'/'.$this->typee.'\');">
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
								<th class="fulllist"><a href="{path}WOTLK/Character/Raids/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
			';
			$strids = "0";
			foreach ($this->db->query('SELECT a.tsstart, a.nameid, b.name, a.id FROM `wotlk-raids` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN `wotlk-raids-participants` c ON a.id = c.rid WHERE (c.dps LIKE "%'.$this->charid.'%" or c.healers LIKE "%'.$this->charid.'%" or c.tanks LIKE "%'.$this->charid.'%") AND a.rdy = 1 ORDER BY a.id DESC LIMIT 10') as $row){
				$content .= '
							<tr>
								<td class="nlstring pve"><img src="{path}WOTLK/Character/img/'.$row->nameid.'.png" /><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->raidsById[$row->nameid].'</a></td>
								<td class="nlstring"><img src="{path}WOTLK/Character/img/'.$this->faction.'.png" /><a class="'.$this->faction.'" href="{path}WOTLK/Guild/'.$this->sname.'/'.$row->name.'/0">'.$row->name.'</a></td>
								<td class="nsstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$row->id.'">'.date("d.m.y H:i", $row->tsstart).'</a></td>
							</tr>
				';
				$strids .= ",".$row->id;
			}
			$content .= '
						</table>
						<table cellspacing="0" class="margin marginbot">
							<tr>
								<th colspan="2">Recent kills</th>
								<th class="fulllist"><a href="{path}WOTLK/Character/Kills/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
			';
			foreach ($this->db->query('SELECT b.npcid, d.name as boss, c.name as gname, c.id as gid, a.id as rid, b.id as attemptid, b.time, a.nameid FROM `wotlk-raids` a LEFT JOIN `wotlk-raids-attempts` b ON a.id = b.rid LEFT JOIN guilds c ON a.guildid = c.id LEFT JOIN wotlk_npcs d ON b.npcid = d.id WHERE a.id IN ('.$strids.') AND d.type = 1 AND a.rdy = 1 AND b.type=1 ORDER BY b.time DESC LIMIT 10') as $row){
				$content .= '
							<tr>
								<td class="nlstring pve"><img src="{path}WOTLK/Character/img/'.$row->nameid.'.png" /><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->boss.'</a></td>
								<td class="nlstring"><img src="{path}WOTLK/Character/img/'.$this->faction.'.png" /><a class="'.$this->faction.'" href="{path}WOTLK/Guild/'.$this->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
								<td class="nsstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->attemptid.'">'.date("d.m.y H:i", $row->time).'</a></td>
							</tr>
				';
			}
			$content .= '
						</table>
			';
			if ($this->isInRaidValue(2)){
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
Only records above 1000 are taken into account!">
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(27)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">Naxxramas 10*</th>
							</tr>
			';
		foreach($this->raidBosses[27] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(28)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">Naxxramas 25*</th>
							</tr>
			';
		foreach($this->raidBosses[28] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(31)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">Vault of Archavon 10*</th>
							</tr>
			';
		foreach($this->raidBosses[31] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(32)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">Vault of Archavon 25*</th>
							</tr>
			';
		foreach($this->raidBosses[32] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(35)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">Ulduar 10*</th>
							</tr>
			';
		foreach($this->raidBosses[35] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(36)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">Ulduar 25*</th>
							</tr>
			';
		foreach($this->raidBosses[36] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
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
Only records above 1000 are taken into account!">
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$this->kpByName[$key].'</a></td>
								<td class="sstring">'.date("d.m.y H:i", $var[8]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(37)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">Trial of the Crusader 10*</th>
							</tr>
			';
		foreach($this->raidBosses[37] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(38)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">Trial of the Crusader 25*</th>
							</tr>
			';
		foreach($this->raidBosses[38] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(39)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">Trial of the Crusader 10 HC*</th>
							</tr>
			';
		foreach($this->raidBosses[39] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(40)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">Trial of the Crusader 25 HC*</th>
							</tr>
			';
		foreach($this->raidBosses[40] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(41)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">ICC 10*</th>
							</tr>
			';
		foreach($this->raidBosses[41] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(42)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">ICC 25*</th>
							</tr>
			';
		foreach($this->raidBosses[42] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(43)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">ICC 10 HC*</th>
							</tr>
			';
		foreach($this->raidBosses[43] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
							</tr>
					';
			}
		}
		$content .= '
						</table>
		';
		}
		if ($this->isInRaidValue(44)){
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
Only records above 1000 are taken into account!">
								<th colspan="10">ICC 25 HC*</th>
							</tr>
			';
		foreach($this->raidBosses[44] as $k => $v){
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
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$key.'&mode=0&id='.$this->getRankingsLink($v).'">'.$k.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[10].'&attempts='.$var[3].'">'.date("d.m.y H:i", $var[2]).'</a></td>
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