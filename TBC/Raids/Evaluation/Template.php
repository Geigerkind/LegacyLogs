<?php
require(dirname(__FILE__)."/../../../init.php");

abstract class Template extends Site{
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
	public $classById = array(
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
	public $raidBosses = array( // update npc db to match those ids
		14 => array( //0
			"Doom Lord Kazzak" => 18728, 
		),
		15 => array( //1
			"Doomwalker" => 17711,
		),
		16 => array( //2
			"High Warlord Naj'entus" => 22887,
			"Supremus" => 22898,
			"Shade of Akama" => 22841,
			"Teron Gorefiend" => 21867,
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
	public $bossPos = Array(18728 => 1, 17711 => 2, 22887 => 3, 22898 => 4, 22841 => 5, 22871 => 6, 22948 => 7, 50002 => 8, 22947 => 9, 23426 => 10, 22917 => 11, 21216 => 12, 21217 => 13, 21215 => 14, 21214 => 15, 21213 => 16, 21212 => 17, 15550 => 18, 15687 => 19, 50001 => 20, 16457 => 21, 15691 => 22, 15688 => 23, 16524 => 24, 15689 => 25, 15690 => 26, 17225 => 27, 18831 => 28, 19044 => 29, 17257 => 30, 23576 => 31, 23578 => 32, 23574 => 33, 23577 => 34, 23863 => 35, 19514 => 36, 19516 => 37, 18805 => 38, 19622 => 39, 17767 => 40, 17808 => 41, 17888 => 42, 17842 => 43, 17968 => 44, 24850 => 45, 24882 => 46, 25038 => 47, 50000 => 48, 25741 => 49, 25608 => 50, 24239 => 51); 
	private function getRaidInformation($db){
		$t = $db->query('SELECT a.abilities, a.nameid, b.faction, a.guildid, a.tsstart, a.tsend, b.name as gname, c.name as sname, d.dps, d.healers, d.tanks, b.serverid, a.casts, a.deaths, a.dispels, a.graphdmg, a.graphdmgt, a.graphheal, a.inddeath, a.inddbp, a.indddba, a.indddte, a.inddtbp, a.inddtfa, a.inddtfs, a.indhba, a.indhtf, a.indint, a.indprocs, a.indintm, a.newbuffs, a.newdebuffs, a.indrecords, a.loot, a.graphff FROM `tbc-raids` a LEFT JOIN guilds b on a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `tbc-raids-participants` d ON a.id = d.rid WHERE a.id = '.$this->rid.';')->fetch();
		$t->uploader = array();
		foreach($db->query('SELECT charid FROM `tbc-raids-uploader` WHERE rid = '.$this->rid.' AND rdy = 1;') as $row){
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
		foreach($db->query('SELECT id, name, type, cat, icon, sourceid FROM tbc_spells WHERE id BETWEEN '.$offset[0].' AND  '.$offset[1]) as $row){
			$t[$row->id] = $row;
		}
		return $t;
	}
	
	private function getNPCS($db){
		$t = array();
		foreach($db->query('SELECT id, name, type, family FROM tbc_npcs') as $row){
			$t[$row->id] = $row;
		}
		return $t;
	}
	
	private function getAttempts($db, $a){
		$t = array();
		$i = "Unknown";
		$akeys = array_keys($this->raidBosses[$a]);
		$aLength = sizeOf($this->raidBosses[$a]);
		foreach ($db->query('SELECT a.id, a.type, a.time, a.cbt, a.cbtend, a.duration, a.npcid, b.name, a.npcs FROM `tbc-raids-attempts` a LEFT JOIN tbc_npcs b ON a.npcid = b.id WHERE rid ='.$this->rid.' AND rdy = 1;') as $row){
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
				<div class="semibig" id="c"><a class="'.($r = ($this->raidinfo->faction==1) ? "alliance" : "horde").'" href="{path}TBC/Guild/'.$this->raidinfo->sname.'/'.$this->raidinfo->gname.'/0">'.$this->raidinfo->gname.'</a> - '.$this->raidinfo->sname.'</span></div>
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
				<a href="{path}TBC/Rankings/Table/?server='.$this->raidinfo->serverid.'&faction=0&type=0&mode=0&id='.$this->getRankingsButtonLink().'"><button class="rButton">Rankings</button></a>
				<div class="ttitle b-nav semibig newBNav semiBigEdge">
					<div><a href="{path}TBC/Raids/Evaluation/Compare/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Compare">Compare</a></div>
					<div><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Evaluation">Analyze</a></div>
				</div>
			</section>
			<section class="ttitle c-nav c-navEdge">
				<ul>
					<li><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" '.($r = ($type==0) ? 'id="mode0"' : '').'>Summary</a></li>
					<li><span'.($r = ($type==4) ? ' id="mode'.$_GET["mode"].'"' : '').'>Damage done</span>
						<ol>
							<li><a href="{path}TBC/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==4) ? 'id="mode0"' : '').'>By Source</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==4) ? 'id="mode1"' : '').'>To Enemy</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==4) ? 'id="mode2"' : '').'>By Ability</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=3" '.($r = ($type==4) ? 'id="mode3"' : '').'>Friendly fire</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==10) ? ' id="mode'.$_GET["mode"].'"' : '').'>Damage taken</span>
						<ol>
							<li><a href="{path}TBC/Raids/Evaluation/DmgTaken/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==10) ? 'id="mode0"' : '').'>By player</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/DmgTaken/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==10) ? 'id="mode1"' : '').'>From source</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/DmgTaken/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==10) ? 'id="mode2"' : '').'>From ability</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==6) ? ' id="mode'.$_GET["mode"].'"' : '').'>Healing</span>
						<ol>
							<li><a href="{path}TBC/Raids/Evaluation/Healing/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==6) ? 'id="mode0"' : '').'>By source</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/Healing/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==6) ? 'id="mode1"' : '').'>To friendly</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/Healing/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==6) ? 'id="mode2"' : '').'>By ability</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==1) ? ' id="mode'.$_GET["mode"].'"' : '').'>Buffs</span>
						<ol>
							<li><a href="{path}TBC/Raids/Evaluation/Buffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==1) ? 'id="mode0"' : '').'>Gained by friendly</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/Buffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==1) ? 'id="mode1"' : '').'>Procs</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==2) ? ' id="mode'.$_GET["mode"].'"' : '').'>Debuffs</span>
						<ol>
							<li><a href="{path}TBC/Raids/Evaluation/Debuffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==2) ? 'id="mode0"' : '').'>Gained by friendly</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/Debuffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==2) ? 'id="mode1"' : '').'>Cast by friendly</a></li>
						</ol>
					</li>
					<li><a href="{path}TBC/Raids/Evaluation/Deaths/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Deaths">Deaths</a></li>
					<li><a href="{path}TBC/Raids/Evaluation/Interrupts/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Interrupts">Interrupts</a></li>
					<li><span'.($r = ($type==3) ? ' id="mode'.$_GET["mode"].'"' : '').'>Dispels</span>
						<ol>
							<li><a href="{path}TBC/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==3) ? 'id="mode0"' : '').'>All Types</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=5" '.($r = ($type==3) ? 'id="mode5"' : '').'>Curse</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=3" '.($r = ($type==3) ? 'id="mode3"' : '').'>Poison</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=4" '.($r = ($type==3) ? 'id="mode4"' : '').'>Disease</a></li>
							<li><a href="{path}TBC/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==3) ? 'id="mode2"' : '').'>Magic</a></li>
						</ol>
					</li>
					<li><a href="{path}TBC/Raids/Evaluation/Casts/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Casts">Casts</a></li>
					<li><a href="{path}TBC/Raids/Evaluation/Survivability/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Survivability">Survivability</a></li>
					<li><a href="{path}TBC/Raids/Evaluation/Fails/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Fails">Fails</a></li>
					<li>
						<div style="background-image: url(\'{path}TBC/Raids/Evaluation/img/config.png\');">
							<ol id="cogwheel">
								<li><img src="{path}TBC/Raids/Evaluation/img/check'.$this->pet.'.png" /><a href="index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->toggle($this->pet).'">Merge pets</a></li>
								<li><img src="{path}TBC/Raids/Evaluation/img/check'.$this->events.'.png" /><a href="index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&events='.$this->toggle($this->events).'">Encounter</a></li>
								<li><img src="{path}TBC/Raids/Evaluation/img/check'.$this->compact.'.png" /><a href="index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&compact='.$this->toggle($this->compact).'">Compact</a></li>
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