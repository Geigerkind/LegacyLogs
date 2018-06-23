<?php
require(dirname(__FILE__)."/../Template.php");

class Home extends Template{
	private $modes = array(
		0 => "by player",
		1 => "from source",
		2 => "by ability"
	);
	private $beneficial = array(
		// General
		"Frost Protection" => true,
		"Nature Protection" => true,
		"Fire Protection" => true,
		"Holy Protection" => true,
		"Shadow Protection" => true,
		"Arcane Protection" => true,
		
	
		"Parry" => true, // To test
		"Glyph of Deflection" => true,
		"Badge of the Swarmguard" => true,
		"Persistent Shield" => true,
		"The Burrower's Shell" => true,
		"Free Action" => true,
		"Living Free Action" => true,
		"Restoration" => true,
		"Speed" => true,
		"Invulnerability" => true,
		"Healing Potion" => true,
		"Major Rejuvenation Potion" => true,
		"Mana Potion" => true,
		"Restore Mana" => true,
		"Dreamless Sleep" => true,
		
		
		// Rogue
		"Sprint" => true,
		"Vanish" => true,
		"Invigorate" => true,
		"Evasion" => true,
		
		// Mage
		"Not There" => true,
		"Ice Block" => true,
		"Mana Shield" => true,
		"Ice Barrier" => true,
		
		// Priest
		"Epiphany" => true,
		"Aegis of Preservation" => true,
		"Inspiration" => true,
		"Blessed Recovery" => true,
		"Power Word: Shield" => true,
		
		// Paladin
		"Divine Shield" => true,
		"Redoubt" => true,
		"Holy Shield" => true,
		"Vengeance" => true,
		"Blessing of Freedom" => true,
		"Blessing of Sacrifice" => true,
		"Blessing of Protection" => true,
		
		"Reincarnation" => true,
		
		// Warlock
		"Vampirism" => true,
		"Soul Link" => true,
		
		// Warrior
		"Cheat Death" => true,
		"Gift of Life" => true,
		"Bloodrage" => true,
		"Enrage" => true,
		"Death Wish" => true,
		"Berserker Rage" => true,
		"Shield Wall" => true,
		"Shield Block" => true,
		"Last Stand" => true,
	);
	private $nonbeneficial = array(
		// Boss Spells
		"Lucifron's Curse" => true,
		"Gehennas' Curse" => true,
		"Panic" => true,
		"Living Bomb" => true,
		"Brood Affliction: Bronze" => true,
		"Bellowing Roar" => true,
		"Fear" => true,
		"Entangle" => true,
		"Digestive Acid" => true,
		"Locust Swarm" => true,
		"Web Wrap" => true,
		"Mutating Injection" => true,
		"Terrifying Roar" => true,
	);
	
	private function average(&$t, $t2, $mC, $c, $name){
		$tot = $mC+$c;
		if (isset($mC) && isset($c) && isset($t2)){
			if (!$t && $t != 0){
				$t = $t2;
			}else{
				if ($mC>0)
					$t = $t*$mC/$tot+$t2*$c/$tot;
			}
		}else{
			$t = $t2;
		}
	}
	
	private function getTable(){
		$t = array();
		if ($this->attempts){
			$con = 'b.id IN ('.$this->attempts.')';
			if ($this->sel)
				$con = 'b.id = "'.$this->sel.'"';
		}elseif ($this->sel){
			$con = 'b.id = "'.$this->sel.'"';
		}else{
			$con = 'b.rid = "'.$this->rid.'"';
		}
		if ($this->player){
			$con .= ' AND a.charid = "'.$this->player.'"';
		}
		if ($this->tarid){
			$con2 = ' AND a.npcid = "'.$this->tarid.'"';
		}
		switch ($this->mode){
			case 0 :
				if ($this->player){
					$offset = explode(",", $this->raidinfo->inddtbp);
					$con = 'a.culpritid = '.$this->player;
					foreach ($this->db->query('SELECT * FROM `v-raids-individual-dmgtakenbyplayer` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con) as $row){
						$t[1] += $row->amount;
						$t[2][$row->charid] += $row->amount;
						$t[3][$row->charid] += $row->active;
						if (!$t[4] || $t[2][$row->charid]>$t[4])
							$t[4] = $t[2][$row->charid];
					}
				}else{
					$offset = explode(",", $this->raidinfo->inddtfs);
					foreach ($this->db->query('SELECT * FROM `v-raids-individual-dmgtakenfromsource` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
						$t[1] += $row->amount;
						$t[2][$row->charid] += $row->amount;
						$t[3][$row->charid] += $row->active;
						if (!$t[4] || $t[2][$row->charid]>$t[4])
							$t[4] = $t[2][$row->charid];
					}
				}
				break;
			case 1 :
				$offset = explode(",", $this->raidinfo->inddtfs);
				foreach ($this->db->query('SELECT a.npcid as typeid, a.amount, a.active, b.duration, a.attemptid FROM `v-raids-individual-dmgtakenfromsource` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$t[1] += $row->amount;
					$t[2][$row->typeid] += $row->amount;
					$t[3][$row->typeid] += $row->active;
					$t[6][$row->typeid] += $row->duration;
					$t[7][$row->typeid] = $row->attemptid;
					if (!$t[4] || $t[2][$row->typeid]>$t[4])
						$t[4] = $t[2][$row->typeid];
				}
				break;
			case 2 : 
				$offset = explode(",", $this->raidinfo->inddtfa);
				foreach ($this->db->query('SELECT a.abilityid, a.amount, a.casts, a.hits, a.crit, a.miss, a.parry, a.dodge, a.resist FROM `v-raids-individual-dmgtakenfromability` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2.' ORDER BY a.casts') as $row){
					$t[1] += $row->amount;
					$t[2][$row->abilityid] += $row->amount;
					$t[3][$row->abilityid] += $row->active;
					$t[5][$row->abilityid] = Array(1=>$this->spells[$row->abilityid]->name, 2=>$this->spells[$row->abilityid]->icon);
					$this->average($t[7][$row->abilityid], $row->crit, $t[12][$row->abilityid], $row->casts);
					$this->average($t[8][$row->abilityid], $row->miss, $t[12][$row->abilityid], $row->casts);
					$this->average($t[9][$row->abilityid], $row->parry, $t[12][$row->abilityid], $row->casts);
					$this->average($t[10][$row->abilityid], $row->dodge, $t[12][$row->abilityid], $row->casts);
					$this->average($t[11][$row->abilityid], $row->resist, $t[12][$row->abilityid], $row->casts);
					$t[12][$row->abilityid] += $row->casts;
					$t[13][$row->abilityid] += $row->hits;
					$t[14] += $row->casts;
					$t[15] += $row->hits;
					$this->average($t[16], $t[6][$row->abilityid]);
					if (!$t[4] || $t[2][$row->abilityid]>$t[4])
						$t[4] = $t[2][$row->abilityid];
				}
				break;
		}
		arsort($t[2]);
		return $t;
	}
	
	private function getGraphValues(){
		$p = array();
		$q = array();
		$e = array();
		if ($this->attempts){
			$con = 'b.id IN ('.$this->attempts.')';
			if ($this->sel)
				$con = 'b.id = "'.$this->sel.'"';
		}elseif ($this->sel){
			$con = 'b.id = "'.$this->sel.'"';
		}else{
			$con = 'b.rid = "'.$this->rid.'"';
		}
		if ($this->tarid)
			$con2 = ' AND a.npcid = "'.$this->tarid.'"';
		$offset = explode(",", $this->raidinfo->graphdmgt);
		if ($this->player){
			$con .= ' AND a.charid = "'.$this->player.'"';
			$offset2 = explode(",", $this->raidinfo->newbuffs);
			foreach($this->db->query('SELECT abilityid, cbtstart, cbtend FROM `v-raids-newbuffs` WHERE id BETWEEN '.$offset2[0].' AND '.$offset2[1].' AND rid = '.$this->rid.' AND charid = '.$this->player) as $row){
				if (!isset($buffs[$row->abilityid]))
					$buffs[$row->abilityid] = array(1=>"",2=>"");
				$buffs[$row->abilityid][1] .= $row->cbtstart.",";
				$buffs[$row->abilityid][2] .= $row->cbtend.",";
			}
			$offset2 = explode(",", $this->raidinfo->newdebuffs);
			foreach($this->db->query('SELECT abilityid, cbtstart, cbtend FROM `v-raids-newdebuffs` WHERE id BETWEEN '.$offset2[0].' AND '.$offset2[1].' AND rid = '.$this->rid.' AND charid = '.$this->player) as $row){
				if (!isset($debuffs[$row->abilityid]))
					$debuffs[$row->abilityid] = array(1=>"",2=>"");
				$debuffs[$row->abilityid][1] .= $row->cbtstart.",";
				$debuffs[$row->abilityid][2] .= $row->cbtend.",";
			}
			if (($this->tarid && $this->mode!=0) or $this->mode==2){
				foreach ($this->db->query('SELECT a.time, a.amount, a.abilityid FROM `v-raids-graph-individual-dmgtaken` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$q[$row->abilityid][1] .= $row->time.",";
					$q[$row->abilityid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q, false, $buffs, $debuffs);
			}elseif($this->mode==0){
				$offset = explode(",", $this->raidinfo->graphff);
				$con2 = '';
				foreach ($this->db->query('SELECT a.time, a.amount, a.culpritid, a.abilityid FROM `v-raids-graph-individual-friendlyfire` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$q[$row->culpritid][$row->abilityid][1] .= $row->time.",";
					$q[$row->culpritid][$row->abilityid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q, true, $buffs, $debuffs);
			}else{
				foreach ($this->db->query('SELECT a.time, a.amount, a.npcid, a.abilityid FROM `v-raids-graph-individual-dmgtaken` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$q[$row->npcid][$row->abilityid][1] .= $row->time.",";
					$q[$row->npcid][$row->abilityid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q, true, $buffs, $debuffs);	
			}
		}elseif ($this->tarid){
			if ($this->mode==2){
				foreach ($this->db->query('SELECT a.time, a.amount, a.charid, a.abilityid FROM `v-raids-graph-individual-dmgtaken` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$q[$row->abilityid][1] .= $row->time.",";
					$q[$row->abilityid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q);
			}else{
				foreach ($this->db->query('SELECT a.time, a.amount, a.charid, a.abilityid FROM `v-raids-graph-individual-dmgtaken` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$q[$row->charid][$row->abilityid][1] .= $row->time.",";
					$q[$row->charid][$row->abilityid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q, true);
			}
		}else{
			if ($this->mode==1){
				foreach ($this->db->query('SELECT a.time, a.amount, a.npcid FROM `v-raids-graph-individual-dmgtaken` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$q[$row->npcid][1] .= $row->time.",";
					$q[$row->npcid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q);
			}elseif ($this->mode==2){
				foreach ($this->db->query('SELECT a.time, a.amount, a.abilityid FROM `v-raids-graph-individual-dmgtaken` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$q[$row->abilityid][1] .= $row->time.",";
					$q[$row->abilityid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q);
			}else{
				foreach ($this->db->query('SELECT a.time, a.amount, a.charid FROM `v-raids-graph-individual-dmgtaken` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$p[1] .= $row->time.",";
					$p[2] .= $row->amount.",";
					$q[$row->charid][1] .= $row->time.",";
					$q[$row->charid][2] .= $row->amount.",";
				}
			}
		}
		foreach($q as $key => $var){
			$q = $this->evalGraphValues($var);
			if ($q)
				$e[$key] = $q;
		}
		return array(1 => $this->evalGraphValues($p), 2 => $e);
	}
	
	private function evalStackedGraphValues($q, $bool, $buffs, $debuffs){
		if ($bool){
			$p = array(); $low = 10000000; $max = 0;
			foreach($q as $ke => $va){
				foreach($va as $key => $var){
					$temp = explode(",", $var[1]);
					$temp2 = explode(",", $var[2]);
					foreach($temp as $k => $v){
						if ($v && $v<=40000){
							if (isset($p[$ke][$key][$v]))
								$p[$ke][$key][$v] += $temp2[$k];
							else
								$p[$ke][$key][$v] = $temp2[$k];
							if ($v<$low)
								$low = $v;
							if ($v>$max)
								$max = $v;
						}
					}
				}
			}
			if (isset($buffs) && isset($debuffs)){
				$buffArr = array(1=>array(),2=>array());
				foreach($buffs as $key => $var){
					if (isset($this->beneficial[$this->spells[$key]->name])){
						$buffArr[1][$key] = explode(",", $var[1]);
						$buffArr[2][$key] = explode(",", $var[2]);
						asort($buffArr[1][$key]);
						// Sort out buffs that are to high and to low
						foreach($buffArr[1][$key] as $k => $v){
							if (($v<=$low && $buffArr[2][$key][$k]<=$low) or $v>=$max)
								unset($buffArr[1][$key][$k]);
						}
					}
				}
				$debuffArr = array(1=>array(),2=>array());
				foreach($debuffs as $key => $var){
					if (isset($this->nonbeneficial[$this->spells[$key]->name])){
						$debuffArr[1][$key] = explode(",", $var[1]);
						$debuffArr[2][$key] = explode(",", $var[2]);
						asort($debuffArr[1][$key]);
						foreach($debuffArr[1][$key] as $k => $v){
							if (($v<=$low && $buffArr[2][$key][$k]<=$low) or $v>=$max)
								unset($debuffArr[1][$key][$k]);
						}
					}
				}
			}
			foreach($p as $ke => $va){
				foreach($va as $key => $var){
					ksort($p[$ke][$key]);
				}
			}
			$e = array();
			$eab = array();
			$auras = array(1=>array(), 2=>array());
			$time = array();
			$space = (($max-$low)/50);
			foreach($p as $ke => $va){
				foreach($va as $key => $var){
					if ($space > 1){
						if (!isset($e[$ke]))
							$e[$ke] = array();
						if (!isset($eab[$ke][$key]))
							$eab[$ke][$key] = array();
						foreach($var as $k => $v){
							for ($i=1; $i<=50; $i++){
								if ($k<=($i*$space+$low) && $k>=(($i-1)*$space+$low) && $k<=20000 && $v<=40000){
									if (!isset($e[$ke][$low+$i*$space]))
										$e[$ke][$low+$i*$space] = $v;
									else
										$e[$ke][$low+$i*$space] += $v;
									if (!isset($eab[$ke][$key][$low+$i*$space]))
										$eab[$ke][$key][$low+$i*$space] = $v;
									else
										$eab[$ke][$key][$low+$i*$space] += $v;
									$time[$low+$i*$space] = true;
								}
							}
						}
					}else{
						foreach($var as $k => $v){
							$e[$ke][$k] = $v;
							$eab[$ke][$key][$k] = $v;
							$time[$k] = true;
						}
					}
				}
			}
			if (isset($buffs)){
				for ($i=1; $i<=50; $i++){
					foreach($buffArr[1] as $qq => $rr){ // ability
						foreach($rr as $tt => $zz){ // timestamp
							if ($zz<=($i*$space+$low) && $zz>=(($i-1)*$space+$low)){
								$auras[1][$low+$i*$space][$qq] = true;
							}
						}
					}
					foreach($debuffArr[1] as $qq => $rr){ // ability
						foreach($rr as $tt => $zz){ // timestamp
							if ($zz<=($i*$space+$low) && $zz>=(($i-1)*$space+$low)){
								$auras[2][$low+$i*$space][$qq] = true;
							}
						}
					}
				}
			}
			ksort($time);
			return array(1=>$e,2=>$eab,3=>$time, 4=>$auras);
		}else{
			$p = array(); $low = 10000000; $max = 0;
			foreach($q as $key => $var){
				$temp = explode(",", $var[1]);
				$temp2 = explode(",", $var[2]);
				foreach($temp as $k => $v){
					if ($v && $v<=40000){
						if (isset($p[$key][$v]))
							$p[$key][$v] += $temp2[$k];
						else
							$p[$key][$v] = $temp2[$k];
						if ($v<$low)
							$low = $v;
						if ($v>$max)
							$max = $v;
					}
				}
			}
			if (isset($buffs) && isset($debuffs)){
				$buffArr = array(1=>array(),2=>array());
				foreach($buffs as $key => $var){
					if (isset($this->beneficial[$this->spells[$key]->name])){
						$buffArr[1][$key] = explode(",", $var[1]);
						$buffArr[2][$key] = explode(",", $var[2]);
						asort($buffArr[1][$key]);
						// Sort out buffs that are to high and to low
						foreach($buffArr[1][$key] as $k => $v){
							if (($v<=$low && $buffArr[2][$key][$k]<=$low) or $v>=$max)
								unset($buffArr[1][$key][$k]);
						}
					}
				}
				$debuffArr = array(1=>array(),2=>array());
				foreach($debuffs as $key => $var){
					if (isset($this->nonbeneficial[$this->spells[$key]->name])){
						$debuffArr[1][$key] = explode(",", $var[1]);
						$debuffArr[2][$key] = explode(",", $var[2]);
						asort($debuffArr[1][$key]);
						foreach($debuffArr[1][$key] as $k => $v){
							if (($v<=$low && $buffArr[2][$key][$k]<=$low) or $v>=$max)
								unset($debuffArr[1][$key][$k]);
						}
					}
				}
			}
			foreach($p as $key => $var){
				ksort($p[$key]);
			}
			$e = array();
			$auras = array(1=>array(), 2=>array());
			$space = (($max-$low)/50);
			foreach($p as $key => $var){
				if ($space > 1){
					if (!isset($e[$key]))
						$e[$key] = array();
					foreach($var as $k => $v){
						for ($i=1; $i<=50; $i++){
							if ($k<=($i*$space+$low) && $k>=(($i-1)*$space+$low) && $k<=20000 && $v<=40000){
								if (!isset($e[$key][$low+$i*$space]))
									$e[$key][$low+$i*$space] = $v;
								else
									$e[$key][$low+$i*$space] += $v;
								$time[$low+$i*$space] = true;
							}
						}
					}
				}else{
					foreach($var as $k => $v){
						$e[$key][$k] = $v;
						$time[$k] = true;
					}
				}
			}
			if (isset($buffs)){
				for ($i=1; $i<=50; $i++){
					foreach($buffArr[1] as $qq => $rr){ // ability
						foreach($rr as $tt => $zz){ // timestamp
							if ($zz<=($i*$space+$low) && $zz>=(($i-1)*$space+$low)){
								$auras[1][$low+$i*$space][$qq] = true;
							}
						}
					}
					foreach($debuffArr[1] as $qq => $rr){ // ability
						foreach($rr as $tt => $zz){ // timestamp
							if ($zz<=($i*$space+$low) && $zz>=(($i-1)*$space+$low)){
								$auras[2][$low+$i*$space][$qq] = true;
							}
						}
					}
				}
			}
			ksort($time);
			return array(1=>$e, 2=>$time, 3=>$auras);
		}
	}
	
	private function evalGraphValues($q){
		// getting the end value
		$q[1] = explode(",", $q[1]);
		$q[2] = explode(",", $q[2]);
		asort($q[1]);
		$end = 0; $start = null;
		foreach($q[1] as $var){
			if ($var && $var<=40000){
				if ($var>$end)
					$end = $var;
				if ($var<$start || !$start)
					$start = $var;
			}
		}
		
		// test if there are enough values else make more
		$t = array();
		$last = $start;
		foreach ($q[1] as $key => $var){
			if ($var){
				$time = ($var-$last)/10;
				$am = ceil($q[2][$key]/10);
				for ($p=0; $p<=10; $p++){
					$t[$last+$time*$p] += $am;
				}
				$last = $var;
			}
		}
		
		$e = array();
		$num = sizeOf($t);
		$coeff = ceil($num/56);
		$ltime = 0; $lam = 0; $i = 0;
		foreach($t as $key => $var){
			if ($key<=20000 && $coeff>1){
				if ($i == $coeff){
					$e[$ltime] = $lam;
					$ltime = 0; $lam = 0; $i = 0;
				}else{
					if ($ltime == 0)
						$ltime = $key;
					else
						$ltime = ($ltime+$key)/2;
					if ($var<=300000)
						$lam += $var;
					$i++;
				}
			}
			if ($coeff<=1){
				$e[$key] = $var;
			}
		}
		
		// allign them to same space
		$space = (($end-$start)/50);
		$c = array();
		foreach($e as $key => $var){
			if ($space>1){
				for($i=0; $i<=50; $i++){
					if ($key<($i*$space+$start) && $key>(($i-1)*$space+$start)){
						if (isset($c[$start+$i*$space]))
							$c[$start+$i*$space] += $var;
						else
							$c[$start+$i*$space] = $var;
					}
				}
			}else{
				$c[$key] = $var;
			}
		}
		return $c;
	}
	
	private function jsToAdd(){
		$t = $this->getGraphValues();
		if (($this->player or $this->tarid) or ((!$this->player && !$this->tarid) && $this->mode>0)){
			$content = "
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawChart);
				function drawChart() {
			";
			if (($this->mode==0 && !$this->tarid && !$this->player) or ($this->tarid && !$this->player && $this->mode != 2) or ($this->mode==1 && !$this->tarid && $this->player) or ($this->mode==0 && $this->player && !$this->target)){
				$content .= "
					var data = new google.visualization.DataTable();
					data.addColumn('string', 'Time');
				";
				foreach($t[1] as $key => $var){
					if ($this->mode==0 && $this->player && !$this->target)
						$content .= "
						data.addColumn('number', '".($rr = (isset($this->participants[4][$key])) ? str_replace("'", "\'", $this->participants[4][$key]->name) : "Unknown")."');
						data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});";
					else
						$content .= "
						data.addColumn('number', '".($rr = (isset($this->npcsById[$key])) ? str_replace("'", "\'", $this->npcsById[$key]->name) : ($r = ($this->participants[4][$key]) ? $this->participants[4][$key]->name : "Unknown"))."');
						data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});";
				}
				$content .= "
					data.addRows([
				";
				foreach ($t[3] as $key => $var){
					$content .= "
						['".($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00')."'";
					$activeAuras = '<tr><th colspan="2">Beneficial: <\/th><\/tr>';
					foreach($t[4][1][$key] as $k => $v){
						$activeAuras .= '<tr><td colspan="2">'.str_replace("'", "\'", $this->spells[$k]->name).'<\/td><\/tr>';
					}
					$activeAuras2 = '<tr><th colspan="2">Non-Beneficial: <\/th><\/tr>';
					foreach($t[4][2][$key] as $k => $v){
						$activeAuras2 .= '<tr><td colspan="2">'.str_replace("'", "\'", $this->spells[$k]->name).'<\/td><\/tr>';
					}
					foreach($t[1] as $k => $v){
						$bool = false;
						if ($this->mode<2 && !$this->tarid && $this->player)
							$tooltip = '<table class="tooltip"><tr><th colspan="2">'.($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00').'<\/th><\/tr><tr><td>'.($rr = isset($this->participants[4][$k]) ? $this->participants[4][$k]->name : ($r = ($this->npcsById[$k]) ? str_replace("'", "\'", $this->npcsById[$k]->name) : "Unknown")).': <\/td><th>'.($r = ($v[$key]) ? $this->mnReadable($v[$key]) : "0").'<\/th><\/tr><tr><th colspan="2">Abilities: <\/th><\/tr>';
						else
							$tooltip = '<table class="tooltip"><tr><th colspan="2">'.($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00').'<\/th><\/tr><tr><td>'.($r = ($this->participants[4][$k]) ? $this->participants[4][$k]->name : "Unknown").': <\/td><th>'.($r = ($v[$key]) ? $this->mnReadable($v[$key]) : "0").'<\/th><\/tr><tr><th colspan="2">Abilities: <\/th><\/tr>';
						foreach($t[2][$k] as $q => $s){
							if (isset($s[$key]) && $s[$key]>0)
								$tooltip .= '<tr><td>'.($r = ($this->spells[$q]) ? str_replace("'", "\'", $this->spells[$q]->name) : "Unknown").': <\/td><th>'.$this->mnReadable($s[$key]).'<\/th><\/tr>';
						}
						if ($activeAuras != '<tr><th colspan="2">Beneficial: <\/th><\/tr>')
							$tooltip .= $activeAuras;
						if ($activeAuras2 != '<tr><th colspan="2">Non-Beneficial: <\/th><\/tr>')
							$tooltip .= $activeAuras2;
						$tooltip .= '<\/table>';
						foreach($v as $ke => $va){
							if ($ke == $key){
								$content .= ",".($r = ($v[$key]) ? $v[$key] : "0").",'".$tooltip."'";
								$bool = true;
							}
						}
						if (!$bool)
							$content .= ",0, '<span style=\"color:black;\">No data<\/span>'";
					}
					$content .= "],";
				}
				$content .= "
					]);
				";
			}else{
				$content .= "
					var data = new google.visualization.DataTable();
					data.addColumn('string', 'Time');
				";
				foreach($t[1] as $key => $var){
					$content .= "data.addColumn('number', '";
					if ((!$this->player && !$this->tarid) && $this->mode==1){
						$content .= ($r = ($this->npcsById[$key]) ? str_replace("'", "\'", $this->npcsById[$key]->name) : "Unknown")."');";
					}elseif ($this->mode==0 && $this->player){
						$content .= ($r = ($this->participants[4][$key]) ? str_replace("'", "\'", $this->participants[4][$key]->name) : "Unknown")."');";
					}else{
						$content .= ($r = ($this->spells[$key]) ? str_replace("'", "\'", $this->spells[$key]->name) : "Unknown")."');";
					}
					$content .= "data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});";
				}
				$content .= "
					data.addRows([
				";
				foreach ($t[2] as $key => $var){
					$content .= "['".($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00')."'";
					$activeAuras = '<tr><th colspan="2">Beneficial: <\/th><\/tr>';
					foreach($t[3][1][$key] as $k => $v){
						$activeAuras .= '<tr><td colspan="2">'.str_replace("'", "\'", $this->spells[$k]->name).'<\/td><\/tr>';
					}
					$activeAuras2 = '<tr><th colspan="2">Non-Beneficial: <\/th><\/tr>';
					foreach($t[3][2][$key] as $k => $v){
						$activeAuras2 .= '<tr><td colspan="2">'.str_replace("'", "\'", $this->spells[$k]->name).'<\/td><\/tr>';
					}
					foreach($t[1] as $k => $v){
						$bool = false;
						$tooltip = '<table class="tooltip"><tr><th colspan="2">'.($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00').'<\/th><\/tr><tr><td><\/td><th><\/th><\/tr>';
						foreach($v as $ke => $va){
							if ($ke == $key){
								$tooltip .= '<tr><td>'.str_replace("'", "\'", ($rr = ($this->mode==0 && $this->player) ? $this->participants[4][$k]->name : ($r = ((!$this->player && !$this->tarid) && $this->mode==1) ? $this->npcsById[$k]->name : $this->spells[$k]->name))).': <\/td><th>'.$this->mnReadable($va).'<\/th><\/tr>';
								if ($activeAuras != '<tr><th colspan="2">Beneficial: <\/th><\/tr>')
									$tooltip .= $activeAuras;
								if ($activeAuras2 != '<tr><th colspan="2">Non-Beneficial: <\/th><\/tr>')
									$tooltip .= $activeAuras2;
								$tooltip .= '<\/table>';
								$content .= ",".$va.",'".$tooltip."'";
								$bool = true;
							}
						}
						if (!$bool)
							$content .= ",0,'<span style=\"color:black;\">No data</span>'";
					}
					$content .= "],
					";
				}
				$content .= "
					]);
				";
			}
			$content .= "
					var options = {
					  isStacked: true,
					  chartArea: {top: 25,right: 20,height: '70%', width: '90%'},
					  backgroundColor: {'fill': 'transparent' },
					  hAxis: {textStyle:{color: '#FFF'}},
					  vAxis: {textStyle:{color: '#FFF'},viewWindow: {min:0}},
					  tooltip: {isHtml: true}
					};

					var chart = new google.visualization.SteppedAreaChart(document.getElementById('graph'));

					chart.draw(data, options);
				}
			";
		}else{
			$time = array();
			$dps = array();
			$player = array();
			$playerdata = array();
			$p = 1;
			foreach($t[2] as $k => $v){
				$i = 1;
				if ($p<=40){
					$player[$p] = $k;
					foreach($v as $key => $var){
						$time[$i] = $key;
						$dps[$i] += $var;
						$playerdata[$p][$i] = $var;
						$i++;
					}
					$p++;
				}
			}
			$content .= "
			  google.charts.load('current', {'packages':['corechart']});
			  google.charts.setOnLoadCallback(drawChart);
			
			  function drawChart() {
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Time');
			";
			if ($this->player){
				$content .= "
					data.addColumn('number', 'Damage taken');
					data.addColumn({type:'string', role:'annotation'});
				";
			}else{
				$content .= "
					data.addColumn('number', 'Total');
					data.addColumn({type:'string', role:'annotation'});
				";
				foreach($player as $k => $v){
					$content .= "data.addColumn('number', '".$this->participants[4][$v]->name."');
					";
				}
			}
			$content .= "
				data.addRows([
			";
			foreach($time as $k => $v){
				$content .="['".gmdate('H:i:s', $v)."',  ".($r = (isset($dps[$k])) ? $dps[$k] : 0).", ".($r = (isset($this->eventPoints[$v]) and $this->events == 0) ? "'".$this->eventPoints[$v]."'" : "null");
				if (!$this->player){
					for($i=1; $i<$p; $i++){
						if (isset($playerdata[$i][$k]))
							$content .= ",".$playerdata[$i][$k];
						else
							$content .= ",0";
					}
				}
				$content .="],
				";
			}
			$content .= "
				]);

				var options = {
				  curveType: 'function',
				  legend: { position: 'bottom', 'textStyle': { 'color': 'white' } },
				  chartArea: {top: 25,right: 20,height: '70%', width: '90%'},
				  backgroundColor: {'fill': 'transparent' },
				  hAxis: {textStyle:{color: '#FFF'}},
				  vAxis: {textStyle:{color: '#FFF'},viewWindow: {min:0}},
				  series: {
					0: { color: '#f1ca3a' },
					1: { color: '#e2431e' },
					2: { color: '#e7711b' },
					3: { color: '#6f9654' },
				  }
				};

				var chart = new google.visualization.LineChart(document.getElementById('graph'));

				chart.draw(data, options);
				 var columns = [];
				var series = {};
				for (var i = 0; i < data.getNumberOfColumns(); i++) {
					columns.push(i);
					if (i > 0) {
						series[i - 1] = {};
					}
				}
				
				google.visualization.events.addListener(chart, 'select', function () {
					var sel = chart.getSelection();
					// if selection length is 0, we deselected an element
					if (sel.length > 0) {
						// if row is undefined, we clicked on the legend
						if (sel[0].row === null) {
							var col = sel[0].column;
							if (columns[col] == col) {
								// hide the data series
								columns[col] = {
									label: data.getColumnLabel(col),
									type: data.getColumnType(col),
									calc: function () {
										return null;
									}
								};
								
								// grey out the legend entry
								series[col - 1].color = '#CCCCCC';
							}
							else {
								// show the data series
								columns[col] = col;
								series[col - 1].color = null;
							}
							var view = new google.visualization.DataView(data);
							view.setColumns(columns);
							chart.draw(view, options);
						}
					}
				});
			  }
			";
		}
		return $content;
	}
	
	public function content(){
		$content = $this->getSame(10);
		$table = $this->getTable();
		$this->addJs($this->jsToAdd());
		$content .= '
			<section class="ttitle semibig newmargin">Damage taken '.$this->modes[$this->mode].'</section>
			<section class="table tees">
		';
		if ($this->mode == 2){
			$content .= '
				<table cellspacing="0">
					<thead>
						<tr>
							<th class="count">#</th>
							<th class="a-char">Name</th>
							<th class="a-amount">Amount</th>
							<th class="cbt">DTPS</th>
							<th class="average">Average</th>
							<th class="hits">Casts</th>
							<th class="hits">Hits</th>
							<th class="perc">Crit</th>
							<th class="perc">Miss</th>
							<th class="perc">Parry</th>
							<th class="perc">Dodge</th>
							<th class="perc">Resist</th>
							<th class="fill">&nbsp;</th>
						</tr>
					</thead>
					<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
		$count=1;
		foreach ($table[2] as $key => $var){
			$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td class="a-char"><img src="{path}Database/icons/small/'.$table[5][$key][2].'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://vanilla-twinhead.twinstar.cz/?spell='.$this->spells[$key]->realspellid.'">'.($r = ($table[5][$key][1]) ? $table[5][$key][1] : "Unknown").'</a></td>
							<td class="a-amount">
								<div>'.round(100*$var/$table[1], 2).'%</div>
								<div class="amount-sbar"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$key]->classid].'" style="width: '.(100*$var/$table[4]).'%;"></div></div>
								<div>'.$this->mnReadable($var).'</div>
							</td>
							<td class="cbt">'.$this->mReadable($var/$this->atmpts[1], 2).'</td>
							<td class="average">'.$this->mReadable($var/$table[13][$key], 2).'</td>
							<td class="hits">'.$this->mnReadable($table[12][$key]).'</td>
							<td class="hits">'.$this->mnReadable($table[13][$key]).'</td>
							<td class="perc">'.round(100*$table[7][$key], 2).'%</td>
							<td class="perc">'.round(100*$table[8][$key], 2).'%</td>
							<td class="perc">'.round(100*$table[9][$key], 2).'%</td>
							<td class="perc">'.round(100*$table[10][$key], 2).'%</td>
							<td class="perc">'.round(100*$table[11][$key], 2).'%</td>
						</tr>
			';
			$count++;
		}
		$content .= '
					</tbody>
					<tfoot>
						<tr>
							<th class="a-char">Total</th>
							<th class="a-amount"><div>100%</div><div class="amount-sbar"></div><div>'.$this->mnReadable($table[1]).'</div></th>
							<th class="cbt">'.$this->mReadable($table[1]/$this->atmpts[1], 2).'</th>
							<th class="average">&nbsp;</th>
							<th class="hits">'.$this->mnReadable($table[14]).'</th>
							<th class="hits">'.$this->mnReadable($table[15]).'</th>
							<th class="perc">&nbsp;</th>
							<th class="perc">&nbsp;</th>
							<th class="perc">&nbsp;</th>
							<th class="perc">&nbsp;</th>
							<th class="perc">&nbsp;</th>
							<th class="fill">&nbsp;</th>
						</tr>
					</tfoot>
				</table>
			';
		}else{
			$content .= '
				<table cellspacing="0">
					<thead>
						<tr>
							<th class="count">#</th>
							<th class="char">Name</th>
							<th class="amount">Amount</th>
							<th class="active">'.($r = ($this->mode==0 && $this->player) ? "": "Active").'</th>
							<th class="cbt">DTPS</th>
							<th class="fill">&nbsp;</th>
						</tr>
					</thead>
					<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
		$count=1;
		foreach ($table[2] as $k => $v){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								'.($rr = ($this->mode==1) ? '<td class="char"><img src="{path}Database/type/'.$this->npcsById[$k]->family.'.png" /><a href="{path}Vanilla/Raids/Evaluation/DmgTaken/?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$table[7][$k].'&pet='.$this->pet.'&tarid='.$k.'&mode=2">'.($r = ($this->npcsById[$k]) ? $this->npcsById[$k]->name : "Unknown").'</a></td>' : '<td class="char"><img src="{path}Database/classes/c'.$this->participants[4][$k]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$k]->classid].'" href="{path}Vanilla/Raids/Evaluation/DmgTaken/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$k.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1">'.$this->participants[4][$k]->name.'</a></td>').'
								<td class="amount">
									<div>'.round(100*$v/$table[1], 2).'%</div>
									<div class="amount-sbar"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$k]->classid].'" style="width: '.(100*$v/$table[4]).'%;"></div></div>
									<div>'.$this->mnReadable($v).'</div>
								</td>
								<td class="active">'.($r = ($this->mode==0 && $this->player) ? "": round(100*$table[3][$k]/$this->atmpts[1], 2)."%").'</td>
								<td class="cbt">'.$this->mReadable($v/$this->atmpts[1], 2).'</td>
							</tr>
			';
			$count++;
		}
		$content .= '
						</tbody>
						<tfoot>
							<tr>
								<th class="char">Total</th>
								<th class="amount"><div>100%</div><div class="amount-sbar"></div><div>'.$this->mnReadable($table[1]).'</div></th>
								<th class="active">&nbsp;</th>
								<th class="cbt">'.$this->mReadable($table[1]/$this->atmpts[1], 2).'</th>
							<th class="fill">&nbsp;</th>
							</tr>
						</tfoot>
				</table>
			';
		}
		$content .= '
			</section>
			</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid){
		$this->addJsLink("https://www.gstatic.com/charts/loader.js", true);
		parent::__construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid);
	}
}

new Home($db, __DIR__, $_GET["rid"], $_GET["attempts"], $_GET["player"], $_GET["sel"], $_GET["mode"], $_GET["pet"], $_GET["events"], $_GET["tarid"]);

?>