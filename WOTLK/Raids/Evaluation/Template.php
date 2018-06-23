<?php
require(dirname(__FILE__)."/../../../init.php");

abstract class Template extends Site{
	private $raidsById = array(
		25 => "Onyxia's Lair 10", // 10 
		26 => "Onyxia's Lair 25", // 25
		27 => "Naxxramas 10", // 10
		28 => "Naxxramas 25", // 25
		29 => "Eye of Eternity 10", // 10
		30 => "Eye of Eternity 25", // 25
		31 => "Vault of Archavon 10", // 10
		32 => "Vault of Archavon 25", // 25
		33 => "Obsidian Sanctum 10", // 10
		34 => "Obsidian Sanctum 25", // 25
		35 => "Ulduar 10", // 10
		36 => "Ulduar 25", // 25
		37 => "TotC 10 NHC", // 10
		38 => "TotC 25 NHC", // 25
		39 => "TotC 10 HC", // 10 HC
		40 => "TotC 25 HC", // 25 HC
		41 => "ICC 10 NHC", // 10
		42 => "ICC 25 NHC", // 25
		43 => "ICC 10 HC", // 10 HC
		44 => "ICC 25 HC", // 25 HC
		45 => "Ruby Sanctum 10 NHC", // 10
		46 => "Ruby Sanctum 25 NHC", // 25
		47 => "Ruby Sanctum 10 HC", // 10 HC
		48 => "Ruby Sanctum 25 HC", // 25 HC
	);
	public $classById = array(
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
	public $raidBosses = array( // update npc db to match those ids
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

	public $loadBossOnly = false;
	public $rid = 0;
	public $attemptid = null;
	public $attempts = "";
	public $player = null;
	public $sel = null;
	public $pet = 0;
	public $tarid = null;
	public $atmpts = array();
	public $raidinfo = array();
	public $events = 1;
	public $compact = 0;
	public $participants = array();
	public $spells = array();
	public $npcsById = array();
	public $mode = 0;
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
	
	private function getRaidInformation($db){
		$t = $db->query('SELECT a.abilities, a.nameid, b.faction, a.guildid, a.tsstart, a.tsend, b.name as gname, c.name as sname, d.dps, d.healers, d.tanks, b.serverid, a.casts, a.deaths, a.dispels, a.graphdmg, a.graphdmgt, a.graphheal, a.inddeath, a.inddbp, a.indddba, a.indddte, a.inddtbp, a.inddtfa, a.inddtfs, a.indhba, a.indhtf, a.indint, a.indprocs, a.indintm, a.newbuffs, a.newdebuffs, a.indrecords, a.loot, a.graphff FROM `wotlk-raids` a LEFT JOIN guilds b on a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `wotlk-raids-participants` d ON a.id = d.rid WHERE a.id = '.$this->rid.';')->fetch();
		$t->uploader = array();
		foreach($db->query('SELECT charid FROM `wotlk-raids-uploader` WHERE rid = '.$this->rid.' AND rdy = 1;') as $row){
			$t->uploader[] = $row->charid;
		}
		return $t;
	}
	
	public function getRankingsButtonLink(){
		if ($this->attempts){
			foreach($this->attemptid as $var){
				if (isset($var)){
					if (isset($this->bossPos[$this->atmpts[8][$var]])){
						return $this->getRankingsLink($this->atmpts[8][$var]);
					}
				}
			}
		}
		return $this->instanceLink[$this->raidinfo->nameid];
	}
	
	public function getRankingsLink($id){
		$link = "0";
		for ($i=1; $i<$this->bossPos[$id]; $i++){
			$link .= "0";
		}
		$link .= "1";
		return $link;
	}
	
	private function getParticipants($db){
		$t = array();
		$player = "";
		foreach(explode(",", $this->raidinfo->tanks) as $var){
			if ($var != "" && $var){
				$t[1][$var] = true;
				$player .= ($r = ($player != "") ? "," : "").$var;
			}
		}
		foreach(explode(",", $this->raidinfo->dps) as $var){
			if ($var != "" && $var){
				$t[2][$var] = true;
				$player .= ($r = ($player != "") ? "," : "").$var;
			}
		}
		foreach(explode(",", $this->raidinfo->healers) as $var){
			if ($var != "" && $var){
				$t[3][$var] = true;
				$player .= ($r = ($player != "") ? "," : "").$var;
			}
		}
		if ($player){
			foreach($db->query('SELECT * FROM chars WHERE id IN ('.$player.','.implode(",",$this->raidinfo->uploader).')') as $row){
				if (isset($t[1][$row->id]))
					$t[1][$row->id] = $row;
				if (isset($t[2][$row->id]))
					$t[2][$row->id] = $row;
				if (isset($t[3][$row->id]))
					$t[3][$row->id] = $row;
				$t[4][$row->id] = $row;
				$t[5][$row->id] = $row->name;
			}
		}else{
			print "If you see this, you have encountered a bug. Please upload the DPSMate.lua in your saved Variables of this raid, if you still have it and contact Shino.";
		}
		asort($t[5], SORT_REGULAR);
		return $t;
	}
	
	public function toggle($var){
		if ($var == 0)
			return 1;
		return 0;
	}
	
	private function getSpells($db){
		$t = array();
		$offset = explode(",",$this->raidinfo->abilities);
		foreach($db->query('SELECT id, name, type, cat, icon, sourceid FROM wotlk_spells WHERE id BETWEEN '.$offset[0].' AND  '.$offset[1]) as $row){
			$t[$row->id] = $row;
		}
		return $t;
	}
	
	private function getNPCS($db){
		$t = array();
		foreach($db->query('SELECT id, name, type, family FROM wotlk_npcs') as $row){
			$t[$row->id] = $row;
		}
		return $t;
	}
	
	private function getAttempts($db, $a){
		$t = array();
		$i = "Unknown";
		$akeys = array_keys($this->raidBosses[$a]);
		$aLength = sizeOf($this->raidBosses[$a]);
		foreach ($db->query('SELECT a.id, a.type, a.time, a.cbt, a.cbtend, a.duration, a.npcid, b.name, a.npcs FROM `wotlk-raids-attempts` a LEFT JOIN wotlk_npcs b ON a.npcid = b.id WHERE rid ='.$this->rid.' AND rdy = 1;') as $row){
			if (!$row->name)
				$row->name = "Unknown";
			if ($this->raidBosses[$a][$row->name]){
				$i = $row->name;
				$curName = $row->name;
				$id = array_search($row->name, $akeys);
			}else{
				$id = array_search($i, $akeys) + $aLength;
				$curName = "Trash before ".$i;
			}
			$t[8][$row->id] = $row->npcid;
			$t[2][$id][$row->id] = Array(
				1 => $row->type,
				2 => $row->time,
				3 => $row->cbt,
				4 => $row->cbtend,
				5 => $row->duration,
				6 => $row->npcid,
				7 => $row->name
			);
			$t[7][$id] = $curName;
			if ($t[3][$id]){
				$t[3][$id] .= ",".$row->id;
			}else{
				$t[3][$id] = $row->id;
			}
			if (!$t[6][$id] || $t[6][$id]>$row->time)
				$t[6][$id] = $row->time;
			if ($this->attemptid){
				if ($this->sel){
					if ($this->sel==$row->id){
						$t[1] += $row->duration;
						$t[9] = $row->cbt;
						$t[10] = $row->cbtend;
						foreach(explode(",",$row->npcs) as $qq => $ss){
							$t[11][$ss] = true;
							if (isset($t[12][$ss]))
								$t[12][$ss] .= ",".$row->id;
							else
								$t[12][$ss] = $row->id;
						}
					}
				}else{
					if ($this->in_array($this->attemptid, $row->id)){
						$t[1] += $row->duration;
						if (!isset($t[9]) or $t[9]>=$row->cbt)
							$t[9] = $row->cbt;
						if (!isset($t[10]) or $t[10]<$row->cbtend)
							$t[10] = $row->cbtend;
						foreach(explode(",",$row->npcs) as $qq => $ss){
							$t[11][$ss] = true;
							if (isset($t[12][$ss]))
								$t[12][$ss] .= ",".$row->id;
							else
								$t[12][$ss] = $row->id;
						}
					}
				}
			}else{
				if ($this->sel){
					if ($this->sel==$row->id){
						$t[1] += $row->duration;
						$t[9] = $row->cbt;
						$t[10] = $row->cbtend;
						foreach(explode(",",$row->npcs) as $qq => $ss){
							$t[11][$ss] = true;
							if (isset($t[12][$ss]))
								$t[12][$ss] .= ",".$row->id;
							else
								$t[12][$ss] = $row->id;
						}
					}
				}else{
					$t[1] += $row->duration;
					if (!isset($t[9]) or $t[9]>=$row->cbt)
						$t[9] = $row->cbt;
					if (!isset($t[10]) or $t[10]<$row->cbtend)
						$t[10] = $row->cbtend;
					foreach(explode(",",$row->npcs) as $qq => $ss){
						$t[11][$ss] = true;
						if (isset($t[12][$ss]))
							$t[12][$ss] .= ",".$row->id;
						else
							$t[12][$ss] = $row->id;
					}
				}
			}
			if ($this->in_array($this->raidBosses[$a], $row->npcid)){
				if ($t[4]){
					$t[4] .= ",".$row->id;
				}else{
					$t[4] = $row->id;
				}
			}else{
				if ($t[5]){
					$t[5] .= ",".$row->id;
				}else{
					$t[5] = $row->id;
				}
			}
		}
		ksort($t[2]);
		return $t;
	}
	
	public function getSame($type, $bool){
		if ($type==6 or $type==3){
			if (!$this->participants[4][$this->tarid])
				$this->tarid = null;
		}else{
			if (!$this->atmpts[11][$this->tarid])
				$this->tarid = null;
		}
		$boos = (isset($this->raidBosses[$this->raidinfo->nameid][$this->npcsById[$this->atmpts[8][$this->sel]]->name])) ? $this->npcsById[$this->atmpts[8][$this->sel]]->name : $this->npcsById[$this->atmpts[8][intval($this->attempts)]]->name;
		$content = '
		<div class="container cont" id="container">
			<section class="ttitle">
				<div class="big" id="a">'.(((intval($this->sel) || (intval($this->attempts) && !strpos($this->attempts, ","))) && isset($this->raidBosses[$this->raidinfo->nameid][$boos])) ? ((intval($this->player) && isset($this->participants[5][$this->player])) ? $this->participants[5][$this->player]." vs. ".$boos : $boos) : ((intval($this->player) && isset($this->participants[5][$this->player])) ? ($this->participants[5][$this->player]." vs. ".$this->raidsById[$this->raidinfo->nameid]) : $this->raidsById[$this->raidinfo->nameid])).'</div>
				<div id="b"> - Uploaded by 
		';
		$num = sizeOf($this->raidinfo->uploader);
		if ($num>1){
			$content .= '<a class="color-'.$this->classById[$this->participants[4][$this->raidinfo->uploader[0]]->classid].'" href="{path}Vanilla/Character/'.$this->raidinfo->sname.'/'.$this->participants[4][$this->raidinfo->uploader[0]]->name.'/0">'.$this->participants[4][$this->raidinfo->uploader[0]]->name.'</a> and <a href="#" title="';
			for ($i=1; $i<$num; $i++){
				$content .= $this->participants[4][$this->raidinfo->uploader[$i]]->name.'
';
			}
			$content .= '">'.($num-1).' more</a>';
		}else{
			foreach($this->raidinfo->uploader as $row){
				$content .= ($next) ? ', ' : '';
				$content .= '<a class="color-'.$this->classById[$this->participants[4][$row]->classid].'" href="{path}Vanilla/Character/'.$this->raidinfo->sname.'/'.$this->participants[4][$row]->name.'/0">'.$this->participants[4][$row]->name.'</a>';
				$next = true;
			}
		}
		$content .= '
				between '.date("d.m.y H:i:s", $this->raidinfo->tsstart).' and '.date("d.m.y H:i:s", $this->raidinfo->tsend).' ('.gmdate("H:i:s", $this->raidinfo->tsend-$this->raidinfo->tsstart).' min).</div>
				<div class="semibig" id="c"><a class="'.($r = ($this->raidinfo->faction==1) ? "alliance" : "horde").'" href="{path}WOTLK/Guild/'.$this->raidinfo->sname.'/'.$this->raidinfo->gname.'/0">'.$this->raidinfo->gname.'</a> - '.$this->raidinfo->sname.'</span></div>
			</section>
			<section class="centredNormal e-nav">
				<select onchange="window.location.replace(\'?rid='.$this->rid.'&attempts=\'+this.value+\'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode='.$this->mode.'\')">
					<option value="">Boss & Trash</option>
					<option class="marked" value="'.$this->atmpts[4].'" '.($r = ($this->attempts==$this->atmpts[4]) ? "selected" : "").'>Boss only</option>
					<option value="'.$this->atmpts[5].'" '.($r = ($this->attempts==$this->atmpts[5]) ? "selected" : "").'>Trash only</option>
		';
		foreach($this->atmpts[2] as $k => $v){
			$content .= '
					<option'.($r = ($this->raidBosses[$this->raidinfo->nameid][$this->atmpts[7][$k]]) ? ' class="marked"' : '').' value="'.$this->atmpts[3][$k].'" '.($r = ($this->attempts=="".$this->atmpts[3][$k]) ? "selected" : "").'>'.$this->atmpts[7][$k].date(" - H:i", $this->atmpts[6][$k]).'</option>
			';
		}
		$content .= '
				</select>
				<select onchange="window.location.replace(\'?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel=\'+this.value+\'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode='.$this->mode.'\')">
		';
		$num = 0;
		if ($this->attemptid){
			foreach($this->atmpts[2] as $k => $v){
				foreach($v as $key => $var){
					if ($this->in_array($this->attemptid, $key))
						$num++;
				}
			}
			if ($num>1){
				$content .= '
					<option value="">'.($r = ($this->sel=="") ? gmdate("H:i:s",$this->atmpts[10]-$this->atmpts[9])." - " : "").'All attempts</option>
				';
			}
		}else{
			$content .= '
					<option value="">'.($r = ($this->sel=="") ? gmdate("H:i:s",$this->atmpts[10]-$this->atmpts[9])." - " : "").'All attempts</option>
			';
		}
		foreach($this->atmpts[2] as $k => $v){
			foreach($v as $key => $var){
				if ($this->attemptid){
					if ($this->in_array($this->attemptid, $key)){
						$content .= '
							<option'.($r = ($this->raidBosses[$this->raidinfo->nameid][$this->atmpts[7][$k]]) ? ' class="marked"' : '').' value="'.$key.'" '.($r = ($this->sel==$key) ? "selected" : "").'>'.($r = ($this->sel===$key || $this->attempts===$key || $num==1) ? gmdate("i:s",$this->atmpts[10]-$this->atmpts[9])." - " : "").$var[7].date(" - H:i", $var[2]).($u = (isset($this->raidBosses[$this->raidinfo->nameid][$this->atmpts[7][$k]])) ? (($r = ($var[1] == 1) ? " - Kill" : " - Attempt")) : "").'</option>
						';
					}
				}else{
					$content .= '
							<option'.($r = ($this->raidBosses[$this->raidinfo->nameid][$this->atmpts[7][$k]]) ? ' class="marked"' : '').' value="'.$key.'" '.($r = ($this->sel==$key) ? "selected" : "").'>'.($r = ($this->sel===$key || $this->attempts===$key || $num==1) ? gmdate("i:s",$this->atmpts[10]-$this->atmpts[9])." - " : "").$var[7].date(" - H:i", $var[2]).($u = (isset($this->raidBosses[$this->raidinfo->nameid][$this->atmpts[7][$k]])) ? (($r = ($var[1] == 1) ? " - Kill" : " - Attempt")) : "").'</option>
					';
				}
			}
		}
		$content .= '
				</select>
				<select onchange="window.location.replace(\'?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid=\'+this.value+\'&mode='.$this->mode.'\')">
		';
		if (sizeOf($this->atmpts[11])>1 or $type == 6 or $type==3)
			$content .= '
					<option value="">All targets</option>
			';
		if ($type==6 or $type==3){
			foreach($this->participants[5] as $k => $v){
				if ($this->pet == 1 or ($type != 0 and $type != 4)){
					$content .= '<option class="color-'.$this->classById[$this->participants[4][$k]->classid].'" value="'.$k.'" '.($r = ($this->tarid==$k) ? "selected" : "").'>'.$v.'</option>';
				}else{
					if (!$this->participants[4][$k]->ownerid)
						$content .= '<option class="color-'.$this->classById[$this->participants[4][$k]->classid].'" value="'.$k.'" '.($r = ($this->tarid==$k) ? "selected" : "").'>'.$v.'</option>';
				}
			}
		}else{
			foreach($this->atmpts[11] as $k => $v){
				if ($k)
					$content .= '
						<option value="'.$k.'"'.($r = ($k==$this->tarid) ? " selected" : "").'>'.$this->npcsById[$k]->name.'</option>
					';
			}
		}
		$content .= '
				</select>
				<select onchange="window.location.replace(\'?rid='.$this->rid.'&attempts='.$this->attempts.'&player=\'+this.value+\'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode='.$this->mode.'\')">
					<option value="">All player</option>
		';
		foreach($this->participants[5] as $k => $v){
			if ($this->pet == 1 or ($type != 0 and $type != 4)){
				$content .= '<option class="color-'.$this->classById[$this->participants[4][$k]->classid].'" value="'.$k.'" '.($r = ($this->player==$k) ? "selected" : "").'>'.$v.'</option>';
			}else{
				if (!$this->participants[4][$k]->ownerid)
					$content .= '<option class="color-'.$this->classById[$this->participants[4][$k]->classid].'" value="'.$k.'" '.($r = ($this->player==$k) ? "selected" : "").'>'.$v.'</option>';
			}
		}
		$content .= '
				</select>
				<a href="{path}WOTLK/Rankings/Table/?server='.$this->raidinfo->serverid.'&faction=0&type=0&mode=0&id='.$this->getRankingsButtonLink().'"><button class="rButton">Rankings</button></a>
				<div class="ttitle b-nav semibig newBNav semiBigEdge">
					<div><a href="{path}WOTLK/Raids/Evaluation/Compare/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Compare">Compare</a></div>
					<div><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Evaluation">Analyze</a></div>
				</div>
			</section>
			<section class="ttitle c-nav c-navEdge">
				<ul>
					<li><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" '.($r = ($type==0) ? 'id="mode0"' : '').'>Summary</a></li>
					<li><span'.($r = ($type==4) ? ' id="mode'.$_GET["mode"].'"' : '').'>Damage done</span>
						<ol>
							<li><a href="{path}WOTLK/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==4) ? 'id="mode0"' : '').'>By Source</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==4) ? 'id="mode1"' : '').'>To Enemy</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==4) ? 'id="mode2"' : '').'>By Ability</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=3" '.($r = ($type==4) ? 'id="mode3"' : '').'>Friendly fire</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==10) ? ' id="mode'.$_GET["mode"].'"' : '').'>Damage taken</span>
						<ol>
							<li><a href="{path}WOTLK/Raids/Evaluation/DmgTaken/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==10) ? 'id="mode0"' : '').'>By player</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/DmgTaken/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==10) ? 'id="mode1"' : '').'>From source</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/DmgTaken/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==10) ? 'id="mode2"' : '').'>From ability</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==6) ? ' id="mode'.$_GET["mode"].'"' : '').'>Healing</span>
						<ol>
							<li><a href="{path}WOTLK/Raids/Evaluation/Healing/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==6) ? 'id="mode0"' : '').'>By source</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/Healing/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==6) ? 'id="mode1"' : '').'>To friendly</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/Healing/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==6) ? 'id="mode2"' : '').'>By ability</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==1) ? ' id="mode'.$_GET["mode"].'"' : '').'>Buffs</span>
						<ol>
							<li><a href="{path}WOTLK/Raids/Evaluation/Buffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==1) ? 'id="mode0"' : '').'>Gained by friendly</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/Buffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==1) ? 'id="mode1"' : '').'>Procs</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==2) ? ' id="mode'.$_GET["mode"].'"' : '').'>Debuffs</span>
						<ol>
							<li><a href="{path}WOTLK/Raids/Evaluation/Debuffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==2) ? 'id="mode0"' : '').'>Gained by friendly</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/Debuffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==2) ? 'id="mode1"' : '').'>Cast by friendly</a></li>
						</ol>
					</li>
					<li><a href="{path}WOTLK/Raids/Evaluation/Deaths/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Deaths">Deaths</a></li>
					<li><a href="{path}WOTLK/Raids/Evaluation/Interrupts/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Interrupts">Interrupts</a></li>
					<li><span'.($r = ($type==3) ? ' id="mode'.$_GET["mode"].'"' : '').'>Dispels</span>
						<ol>
							<li><a href="{path}WOTLK/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==3) ? 'id="mode0"' : '').'>All Types</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=5" '.($r = ($type==3) ? 'id="mode5"' : '').'>Curse</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=3" '.($r = ($type==3) ? 'id="mode3"' : '').'>Poison</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=4" '.($r = ($type==3) ? 'id="mode4"' : '').'>Disease</a></li>
							<li><a href="{path}WOTLK/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==3) ? 'id="mode2"' : '').'>Magic</a></li>
						</ol>
					</li>
					<li><a href="{path}WOTLK/Raids/Evaluation/Casts/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Casts">Casts</a></li>
					<li><a href="{path}WOTLK/Raids/Evaluation/Survivability/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Survivability">Survivability</a></li>
					<li><a href="{path}WOTLK/Raids/Evaluation/Fails/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Fails">Fails</a></li>
					<li>
						<div style="background-image: url(\'{path}WOTLK/Raids/Evaluation/img/config.png\');">
							<ol id="cogwheel">
								<li><img src="{path}WOTLK/Raids/Evaluation/img/check'.$this->pet.'.png" /><a href="index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->toggle($this->pet).'">Merge pets</a></li>
								<li><img src="{path}WOTLK/Raids/Evaluation/img/check'.$this->events.'.png" /><a href="index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&events='.$this->toggle($this->events).'">Encounter</a></li>
								<li><img src="{path}WOTLK/Raids/Evaluation/img/check'.$this->compact.'.png" /><a href="index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&compact='.$this->toggle($this->compact).'">Compact</a></li>
							</ol>
						</div>
					</li>
				</ul>
			</section>
		';
		if (!$bool)
			$content .= '<section class="table" id="graph"></section>';
		return $content;
	}
	
	public function __construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid){
		if (!isset($npcid) && !isset($mode) && !isset($pet))
			$this->loadBossOnly = true;

		$this->mode = intval($this->antiSQLInjection($mode));
		$this->rid = intval($this->antiSQLInjection($rid));
		$this->sel = intval($this->antiSQLInjection($attemptid));
		if ($attempts){
			$this->attemptid = explode(",", $this->antiSQLInjection($attempts));
			$this->attempts = $this->antiSQLInjection($attempts);
			if (!$this->in_array($this->attemptid, $this->sel))
				$this->sel = "";
		}
		if ($player)
			$this->player = intval($this->antiSQLInjection($player));
		if ((!isset($pet) or $pet=="") && $_COOKIE["CWPET"])
			$this->pet = $_COOKIE["CWPET"];
		else
			$this->pet = intval($this->antiSQLInjection($pet));
		if ((!isset($events) or $events=="") && isset($_COOKIE["CWEVENTS"]))
			$this->events = $_COOKIE["CWEVENTS"];
		else
			$this->events = intval($this->antiSQLInjection($events));
		if ($npcid)
			$this->tarid = intval($this->antiSQLInjection($npcid));
		if (isset($_GET["compact"])){
			$this->compact = intval($this->antiSQLInjection($_GET["compact"]));
			setcookie("compact", $this->compact, time()+2600000);
		}else{
			if (isset($_COOKIE["compact"]))
				$this->compact = intval($this->antiSQLInjection($_COOKIE["compact"]));
		}
		setcookie("CWPET", $this->pet, time()+2600000);
		setcookie("CWEVENTS", $this->events, time()+2600000);
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js");
		$this->addJsLink("{path}External/TwinheadTooltip/functions.js");
		$this->addJsLink("{path}External/TwinheadTooltip/tooltip.js");
		$this->addJsLink("{path}External/TwinheadTooltip/twinhead_tooltip.js");
		$this->addCssLink("{path}External/TwinheadTooltip/twinhead_tooltip.css");
		$this->raidinfo = $this->getRaidInformation($db);
		$this->participants = $this->getParticipants($db);
		$this->atmpts = $this->getAttempts($db, $this->raidinfo->nameid);
		if ($this->loadBossOnly){
			$this->attempts = $this->atmpts[4];
			$this->attemptid = explode(",", $this->attempts);
			$this->atmpts = $this->getAttempts($db, $this->raidinfo->nameid);
		}
		if ($this->atmpts[12][$this->tarid]=="")
			$this->tarid = 0;
		$this->spells = $this->getSpells($db);
		$this->npcsById = $this->getNPCS($db);
		$this->siteTitle = " - Evaluation - ".$this->raidsById[$this->raidinfo->nameid]." by ".$this->raidinfo->gname." on ".$this->raidinfo->sname." on ".date("l",$this->raidinfo->tsend).date(" d. \of F Y", $this->raidinfo->tsend);
		$this->keyWords = "Participants: ";
		foreach($this->participants[4] as $v){
			$this->keyWords .= ($r = ($this->keyWords != "Participants: ") ? ", " : "").$v->name;
		}		
		parent::__construct($db, $dir);
	}
}

?>