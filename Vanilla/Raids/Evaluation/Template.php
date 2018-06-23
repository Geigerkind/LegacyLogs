<?php
require(dirname(__FILE__)."/../../../init.php");

abstract class Template extends Site{
	public $raidsById = array(
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
		13 => "Hinterlands"
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
	public $raidBosses = array(
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
			"Hazza'rah" => 15083,
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
			"Battleguard Sartura" => 15516,
			"Fankriss the Unyielding" => 15510,
			"Princess Huhuran" => 15509,
			"The Twin Emperors" => 50001,
			"Ouro" => 15517,
			"C'Thun" => 15727,
			"Viscidus" => 15299,
			"The Bug Family" => 50000,
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
			"The Four Horsemen" => 50002,
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
		)
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
	public $instanceLink = Array(1 => "01111111111", 2 => "00000000001", 3 => "00000000000000000011111111", 4 => "00000000000000000000000000111111111111", 5 => "00000000000000000000000000000000000000111111", 6 => "00000000000000000000000000000000000000000000111111111", 7 => "00000000000000000000000000000000000000000000000000000111111111111111", 8 => "000000000000001111", 9 => "00000000000001", 10 => "0000000000001", 11 => "000000000000001111", 12 => "000000000000001111", 13 => "000000000000001111", 14 => "00000000000000000000000000000000000000000000111111111");
	public $bossPos = Array(12118 => 1, 11982 => 2, 12259 => 3, 12057 => 4, 12056 => 5, 12264 => 6, 12098 => 7, 11988 => 8, 12018 => 9, 11502 => 10, 10184 => 11, 12397 => 12, 6109 => 13, 14889 => 14, 14887 => 15, 14888 => 16, 14890 => 17, 12435 => 18, 13020 => 19, 12017 => 20, 11983 => 21, 14601 => 22, 11981 => 23, 14020 => 24, 11583 => 25, 14517 => 26, 14507 => 27, 14510 => 28, 11382 => 29, 15082 => 30, 15083 => 31, 15085 => 32, 15114 => 33, 14509 => 34, 14515 => 35, 11380 => 36, 14834 => 37, 15348 => 38, 15341 => 39, 15340 => 40, 15370 => 41, 15369 => 42, 15339 => 43, 15263 => 44, 15511 => 45, 15516 => 46, 15510 => 47, 15299 => 48, 15509 => 49, 15276 => 50, 15517 => 51, 15729 => 52, 16028 => 53, 15931 => 54, 15932 => 55, 15928 => 56, 15956 => 57, 15953 => 58, 15952 => 59, 16061 => 60, 16060 => 61, 16064 => 62, 15954 => 63, 15936 => 64, 16011 => 65, 15989 => 66, 15990 => 67);
	
	private function getRaidInformation($db){
		$t = $db->query('SELECT a.nameid, b.faction, a.guildid, a.tsstart, a.tsend, b.name as gname, c.name as sname, d.dps, d.healers, d.tanks, b.serverid, a.casts, a.deaths, a.dispels, a.graphdmg, a.graphdmgt, a.graphheal, a.inddeath, a.inddbp, a.indddba, a.indddte, a.inddtbp, a.inddtfa, a.inddtfs, a.indhba, a.indhtf, a.indint, a.indprocs, a.indintm, a.newbuffs, a.newdebuffs, a.indrecords, a.loot, a.graphff FROM `v-raids` a LEFT JOIN guilds b on a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `v-raids-participants` d ON a.id = d.rid WHERE a.id = '.$this->rid.';')->fetch();
		$t->uploader = array();
		foreach($db->query('SELECT charid FROM `v-raids-uploader` WHERE rid = '.$this->rid.' AND rdy = 1;') as $row){
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
		foreach($db->query('SELECT id, name, type, cat, icon, sourceid, realspellid FROM spells') as $row){
			$t[$row->id] = $row;
		}
		return $t;
	}
	
	private function getNPCS($db){
		$t = array();
		foreach($db->query('SELECT id, name, type, family FROM npcs') as $row){
			$t[$row->id] = $row;
		}
		return $t;
	}
	
	private function getAttempts($db, $a){
		$t = array();
		$i = "Unknown";
		$akeys = array_keys($this->raidBosses[$a]);
		$aLength = sizeOf($this->raidBosses[$a]);
		foreach ($db->query('SELECT a.id, a.type, a.time, a.cbt, a.cbtend, a.duration, a.npcid, b.name, a.npcs FROM `v-raids-attempts` a LEFT JOIN npcs b ON a.npcid = b.id WHERE rid ='.$this->rid.' AND rdy = 1;') as $row){
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
				<div class="semibig" id="c"><a class="'.($r = ($this->raidinfo->faction==1) ? "alliance" : "horde").'" href="{path}Vanilla/Guild/'.$this->raidinfo->sname.'/'.$this->raidinfo->gname.'/0">'.$this->raidinfo->gname.'</a> - '.$this->raidinfo->sname.'</span></div>
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
				<a href="{path}Vanilla/Rankings/Table/?server='.$this->raidinfo->serverid.'&faction=0&type=0&mode=0&id='.$this->getRankingsButtonLink().'"><button class="rButton">Rankings</button></a>
				<div class="ttitle b-nav semibig newBNav edge semiBigEdge">
					<div><a href="{path}Vanilla/Raids/Evaluation/Compare/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Compare">Compare</a></div>
					<div><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Evaluation">Analyze</a></div>
				</div>
			</section>
			<section class="ttitle c-nav c-navEdge">
				<ul>
					<li><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" '.($r = ($type==0) ? 'id="mode0"' : '').'>Summary</a></li>
					<li><span'.($r = ($type==4) ? ' id="mode'.$_GET["mode"].'"' : '').'>Damage done</span>
						<ol>
							<li><a href="{path}Vanilla/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==4) ? 'id="mode0"' : '').'>By Source</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==4) ? 'id="mode1"' : '').'>To Enemy</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==4) ? 'id="mode2"' : '').'>By Ability</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=3" '.($r = ($type==4) ? 'id="mode3"' : '').'>Friendly fire</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==10) ? ' id="mode'.$_GET["mode"].'"' : '').'>Damage taken</span>
						<ol>
							<li><a href="{path}Vanilla/Raids/Evaluation/DmgTaken/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==10) ? 'id="mode0"' : '').'>By player</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/DmgTaken/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==10) ? 'id="mode1"' : '').'>From source</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/DmgTaken/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==10) ? 'id="mode2"' : '').'>From ability</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==6) ? ' id="mode'.$_GET["mode"].'"' : '').'>Healing</span>
						<ol>
							<li><a href="{path}Vanilla/Raids/Evaluation/Healing/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==6) ? 'id="mode0"' : '').'>By source</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/Healing/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==6) ? 'id="mode1"' : '').'>To friendly</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/Healing/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==6) ? 'id="mode2"' : '').'>By ability</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==1) ? ' id="mode'.$_GET["mode"].'"' : '').'>Buffs</span>
						<ol>
							<li><a href="{path}Vanilla/Raids/Evaluation/Buffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==1) ? 'id="mode0"' : '').'>Gained by friendly</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/Buffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==1) ? 'id="mode1"' : '').'>Procs</a></li>
						</ol>
					</li>
					<li><span'.($r = ($type==2) ? ' id="mode'.$_GET["mode"].'"' : '').'>Debuffs</span>
						<ol>
							<li><a href="{path}Vanilla/Raids/Evaluation/Debuffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==2) ? 'id="mode0"' : '').'>Gained by friendly</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/Debuffs/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1" '.($r = ($type==2) ? 'id="mode1"' : '').'>Cast by friendly</a></li>
						</ol>
					</li>
					<li><a href="{path}Vanilla/Raids/Evaluation/Deaths/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Deaths">Deaths</a></li>
					<li><a href="{path}Vanilla/Raids/Evaluation/Interrupts/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Interrupts">Interrupts</a></li>
					<li><span'.($r = ($type==3) ? ' id="mode'.$_GET["mode"].'"' : '').'>Dispels</span>
						<ol>
							<li><a href="{path}Vanilla/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=0" '.($r = ($type==3) ? 'id="mode0"' : '').'>All Types</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=5" '.($r = ($type==3) ? 'id="mode5"' : '').'>Curse</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=3" '.($r = ($type==3) ? 'id="mode3"' : '').'>Poison</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=4" '.($r = ($type==3) ? 'id="mode4"' : '').'>Disease</a></li>
							<li><a href="{path}Vanilla/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2" '.($r = ($type==3) ? 'id="mode2"' : '').'>Magic</a></li>
						</ol>
					</li>
					<li><a href="{path}Vanilla/Raids/Evaluation/Casts/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Casts">Casts</a></li>
					<li><a href="{path}Vanilla/Raids/Evaluation/Survivability/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Survivability">Survivability</a></li>
					<li><a href="{path}Vanilla/Raids/Evaluation/Fails/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'" id="Fails">Fails</a></li>
					<li>
						<div style="background-image: url(\'{path}Vanilla/Raids/Evaluation/img/config.png\');">
							<ol id="cogwheel">
								<li><img src="{path}Vanilla/Raids/Evaluation/img/check'.$this->pet.'.png" /><a href="index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->toggle($this->pet).'">Merge pets</a></li>
								<li><img src="{path}Vanilla/Raids/Evaluation/img/check'.$this->events.'.png" /><a href="index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&events='.$this->toggle($this->events).'">Encounter</a></li>
								<li><img src="{path}Vanilla/Raids/Evaluation/img/check'.$this->compact.'.png" /><a href="index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&compact='.$this->toggle($this->compact).'">Compact</a></li>
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
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js", false);
		$this->addJsLink("{path}External/TwinheadTooltip/functions.js", false);
		$this->addJsLink("{path}External/TwinheadTooltip/tooltip.js", false);
		$this->addJsLink("{path}External/TwinheadTooltip/twinhead_tooltip.js", false);
		$this->addCssLink("{path}External/TwinheadTooltip/twinhead_tooltip.css", false);
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