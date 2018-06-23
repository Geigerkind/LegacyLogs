<?php
require(dirname(__FILE__)."/../Template.php");

class Home extends Template{
	private $modes = array(
		0 => "by source",
		1 => "to friendly",
		2 => "by ability"
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
	
	private function getTable($cbt){
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
		if ($this->player)
			$con3 .= ' AND a.charid = "'.$this->player.'"';
		if ($this->tarid)
			$con4 = ' AND a.tarid = '.$this->tarid;
		switch ($this->mode){
			case 0 :
				$offset = explode(",", $this->raidinfo->indhtf);
				if ($this->player){
					if ($this->tarid)
						$con4 = ' AND a.charid = '.$this->tarid;
					foreach($this->db->query('SELECT a.charid, a.tamount, a.active, a.eamount, a.absorbed, a.tarid FROM `tbc-raids-individual-healingtofriendly` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con4.' AND a.tarid = "'.$this->player.'"') as $row){
						$t[1] += $row->tamount+$row->absorbed;
						$t[2][$row->charid] += $row->tamount+$row->absorbed;
						if ($t[8][$row->charid][$row->attemptid]<=$this->atmpts[1]){
							if ($row->active>$row->duration or (($t[8][$row->charid][$row->attemptid]+$row->active)>$row->duration))
								$t[8][$row->charid][$row->attemptid] = $row->duration;
							else
								$t[8][$row->charid][$row->attemptid] += $row->active;
						}
						if (!isset($t[8][$row->charid][$row->attemptid]))
							$t[8][$row->charid][$row->attemptid] = $row->active;
						$t[6][$row->charid] += $row->eamount;
						$t[7][$row->charid] += $row->absorbed;
						$t[17] += $row->absorbed;
						$t[18] += $row->absorbed + $row->eamount;
						if (!$t[4] || $t[2][$row->charid]>$t[4])
							$t[4] = $t[2][$row->charid];
					}
				}else{
					foreach ($this->db->query('SELECT a.tamount, a.eamount, a.absorbed, a.charid, a.active, a.tarid, a.attemptid, b.duration FROM `tbc-raids-individual-healingtofriendly` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con3.$con4) as $row){
						$t[1] += $row->tamount+$row->absorbed;
						$t[2][$row->charid] += $row->tamount+$row->absorbed;
						if ($t[8][$row->charid][$row->attemptid]<=$this->atmpts[1]){
							if ($row->active>$row->duration or (($t[8][$row->charid][$row->attemptid]+$row->active)>$row->duration))
								$t[8][$row->charid][$row->attemptid] = $row->duration;
							else
								$t[8][$row->charid][$row->attemptid] += $row->active;
						}
						if (!isset($t[8][$row->charid][$row->attemptid]))
							$t[8][$row->charid][$row->attemptid] = $row->active;
						$t[6][$row->charid] += $row->eamount;
						$t[7][$row->charid] += $row->absorbed;
						$t[17] += $row->absorbed;
						$t[18] += $row->absorbed + $row->eamount;
						if (!$t[4] || $t[2][$row->charid]>$t[4])
							$t[4] = $t[2][$row->charid];
					}
				}
				foreach($t[8] as $k => $v){
					foreach($v as $ke => $va){
						$t[3][$k] += $va;
					}
				}
				break;
			case 1 :
				$offset = explode(",", $this->raidinfo->indhtf);
				foreach ($this->db->query('SELECT a.tarid as uid, a.active, a.absorbed, a.tamount, a.eamount, a.charid, b.duration, a.attemptid FROM `tbc-raids-individual-healingtofriendly` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con3.$con4) as $row){
					$t[1] += $row->tamount+$row->absorbed;
					$t[2][$row->uid] += $row->tamount+$row->absorbed;
					if ($t[8][$row->uid][$row->attemptid]<=$this->atmpts[1]){
						if ($row->active>$row->duration or (($t[8][$row->uid][$row->attemptid]+$row->active)>$row->duration))
							$t[8][$row->uid][$row->attemptid] = $row->duration;
						else
							$t[8][$row->uid][$row->attemptid] += $row->active;
					}
					if (!isset($t[8][$row->uid][$row->attemptid]))
						$t[8][$row->uid][$row->attemptid] = $row->active;
					$t[6][$row->uid] += $row->eamount;
					$t[7][$row->uid] += $row->absorbed;
					$t[17] += $row->absorbed;
					$t[18] += $row->absorbed + $row->eamount;
					if (!$t[4] || $t[2][$row->uid]>$t[4])
						$t[4] = $t[2][$row->uid];
				}
				foreach($t[8] as $k => $v){
					foreach($v as $ke => $va){
						$t[3][$k] += $va;
					}
				}
				break;
			case 2 : 
				$offset = explode(",", $this->raidinfo->indhba);
				foreach ($this->db->query('SELECT a.abilityid, a.eamount, a.tamount, a.casts, a.crit FROM `tbc-raids-individual-healingbyability` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con3.$con4) as $row){
					$t[1] += $row->tamount;
					$t[2][$row->abilityid] += $row->tamount;
					$t[3][$row->abilityid] += $row->active;
					$t[5][$row->abilityid] = Array(1=>$this->spells[$row->abilityid]->name, 2=>$this->spells[$row->abilityid]->icon);
					$t[8][$row->abilityid] += $row->eamount;
					$t[9] += $row->eamount;
					$t[10][$row->abilityid] += $row->absorbed;
					$t[11] += $row->absorbed;
					$this->average($t[16], $t[6][$row->abilityid], $t[12][$row->abilityid], $row->casts);
					$this->average($t[7][$row->abilityid], $row->crit, $t[12][$row->abilityid], $row->casts);
					$t[12][$row->abilityid] += $row->casts;
					$t[14] += $row->casts;
					$t[17] += $row->absorbed;
					$t[18] += $row->absorbed + $row->eamount;
					if (!$t[4] || $t[2][$row->abilityid]>$t[4])
						$t[4] = $t[2][$row->abilityid];
				}
				break;
		}
		arsort($t[2]);
		if ($this->mode != 2){
			$offset = explode(",", $this->raidinfo->indrecords);
			foreach ($this->db->query('SELECT a.id, a.charid, a.realm, a.charid, a.realmtype, a.realmclass, b.npcid FROM `tbc-raids-records` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND a.type = 1 AND '.$con.$con3.' ORDER BY a.realm, a.realmtype, a.realmclass LIMIT 12') as $row){
				$t[10][$row->id] = $row;
			}
		}
		return $t;
	}
	
	private function evalStackedGraphValues($q, $bool){
		if ($bool){
			$p = array(); $low = 10000000; $max = 0;
			foreach($q as $ke => $va){
				foreach($va as $key => $var){
					$temp = explode(",", $var[1]);
					$temp2 = explode(",", $var[2]);
					foreach($temp as $k => $v){
						if ($v && $v<=100000){
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
			foreach($p as $ke => $va){
				foreach($va as $key => $var){
					ksort($p[$ke][$key]);
				}
			}
			$e = array();
			$eab = array();
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
								if ($k<=($i*$space+$low) && $k>=(($i-1)*$space+$low) && $k<=20000 && $v<=2000000){
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
			ksort($time);
			return array(1=>$e,2=>$eab,3=>$time);
		}else{
			$p = array(); $low = 10000000; $max = 0;
			foreach($q as $key => $var){
				$temp = explode(",", $var[1]);
				$temp2 = explode(",", $var[2]);
				foreach($temp as $k => $v){
					if ($v && $v<=100000){
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
			foreach($p as $key => $var){
				ksort($p[$key]);
			}
			$e = array();
			$space = (($max-$low)/50);
			foreach($p as $key => $var){
				if ($space > 1){
					if (!isset($e[$key]))
						$e[$key] = array();
					foreach($var as $k => $v){
						for ($i=1; $i<=50; $i++){
							if ($k<=($i*$space+$low) && $k>=(($i-1)*$space+$low) && $k<=20000 && $v<=2000000){
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
			ksort($time);
			return array(1=>$e, 2=>$time);
		}
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
		if ($this->tarid){
			$con4 = ' AND a.sourceid = '.$this->tarid;
			$con5 = ' AND a.charid = '.$this->tarid;
		}
		$offset = explode(",", $this->raidinfo->graphheal);
		if ($this->player){
			$con2 = ' AND a.charid = "'.$this->player.'"';
			$con3 = ' AND a.sourceid = "'.$this->player.'"';
			if ($this->tarid){
				if ($this->mode==0){
					foreach ($this->db->query('SELECT a.time, a.amount, a.abilityid FROM `tbc-raids-graph-individual-healingreceived` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2.$con4) as $row){
						$q[$row->abilityid][1] .= $row->time.",";
						$q[$row->abilityid][2] .= $row->amount.",";
					}
				}else{
					foreach ($this->db->query('SELECT a.time, a.amount, a.abilityid FROM `tbc-raids-graph-individual-healingreceived` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con3.$con5) as $row){
						$q[$row->abilityid][1] .= $row->time.",";
						$q[$row->abilityid][2] .= $row->amount.",";
					}
				}
				return $this->evalStackedGraphValues($q);
			}else{
				if ($this->mode==1){
					foreach ($this->db->query('SELECT a.time, a.amount, a.abilityid, a.charid FROM `tbc-raids-graph-individual-healingreceived` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con3.$con5) as $row){
						$q[$row->charid][$row->abilityid][1] .= $row->time.",";
						$q[$row->charid][$row->abilityid][2] .= $row->amount.",";
					}
				}elseif($this->mode==2){
					foreach ($this->db->query('SELECT a.time, a.amount, a.abilityid FROM `tbc-raids-graph-individual-healingreceived` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con3.$con5) as $row){
						$q[$row->abilityid][1] .= $row->time.",";
						$q[$row->abilityid][2] .= $row->amount.",";
					}
					return $this->evalStackedGraphValues($q);
				}else{
					foreach ($this->db->query('SELECT a.time, a.amount, a.sourceid, a.abilityid FROM `tbc-raids-graph-individual-healingreceived` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2.$con4) as $row){
						$q[$row->sourceid][$row->abilityid][1] .= $row->time.",";
						$q[$row->sourceid][$row->abilityid][2] .= $row->amount.",";
					}	
				}
				return $this->evalStackedGraphValues($q, true);
			}
		}elseif($this->tarid){
			if ($this->mode==2){
				foreach ($this->db->query('SELECT a.time, a.amount, a.abilityid FROM `tbc-raids-graph-individual-healingreceived` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con3.$con5) as $row){
					$q[$row->abilityid][1] .= $row->time.",";
					$q[$row->abilityid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q);
			}else{
				foreach ($this->db->query('SELECT a.time, a.amount, a.sourceid, a.abilityid FROM `tbc-raids-graph-individual-healingreceived` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con5) as $row){
					$q[$row->sourceid][$row->abilityid][1] .= $row->time.",";
					$q[$row->sourceid][$row->abilityid][2] .= $row->amount.",";
				}	
				return $this->evalStackedGraphValues($q, true);
			}
		}else{
			if ($this->mode==1){
				foreach ($this->db->query('SELECT a.time, a.amount, a.charid FROM `tbc-raids-graph-individual-healingreceived` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con3.$con5) as $row){
					$q[$row->charid][1] .= $row->time.",";
					$q[$row->charid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q);
			}elseif($this->mode==2){
				foreach ($this->db->query('SELECT a.time, a.amount, a.abilityid FROM `tbc-raids-graph-individual-healingreceived` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con3.$con5) as $row){
					$q[$row->abilityid][1] .= $row->time.",";
					$q[$row->abilityid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q);
			}else{
				foreach ($this->db->query('SELECT a.time, a.amount, a.sourceid FROM `tbc-raids-graph-individual-healingreceived` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con3.$con5) as $row){
					$p[1] .= $row->time.",";
					$p[2] .= $row->amount.",";
					$q[$row->sourceid][1] .= $row->time.",";
					$q[$row->sourceid][2] .= $row->amount.",";
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
	
	private function evalGraphValues($q){
		// getting the end value
		$q[1] = explode(",", $q[1]);
		$q[2] = explode(",", $q[2]);
		asort($q[1]);
		$end = 0; $start = null;
		foreach($q[1] as $var){
			if ($var && $var<=20000){
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
					if ($var<=100000)
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
			if (($this->mode==0 && !$this->tarid && !$this->player) or ($this->mode != 2 && $this->tarid && !$this->player) or ($this->mode != 2 && $this->player && !$this->tarid)){
				$content .= "
					var data = new google.visualization.DataTable();
					data.addColumn('string', 'Time');
				";
				foreach($t[1] as $key => $var){
					$content .= "
					data.addColumn('number', '".($r = ($this->participants[4][$key]) ? $this->participants[4][$key]->name : "Unknown")."');
					data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});";
				}
				$content .= "
					data.addRows([
				";
				foreach ($t[3] as $key => $var){
					$content .= "
						['".($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00')."'";
					foreach($t[1] as $k => $v){
						$bool = false;
						$tooltip = '<table class="tooltip"><tr><th colspan="2">'.($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00').'<\/th><\/tr><tr><td>'.($r = ($this->participants[4][$k]) ? $this->participants[4][$k]->name : "Unknown").': <\/td><th>'.($r = ($v[$key]) ? $this->mnReadable($v[$key]) : "0").'<\/th><\/tr><tr><th colspan="2">Abilities: <\/th><\/tr>';
						foreach($t[2][$k] as $q => $s){
							if (isset($s[$key]) && $s[$key]>0)
								$tooltip .= '<tr><td>'.($r = ($this->spells[$q]) ? str_replace("'", "\'", $this->spells[$q]->name) : "Unknown").': <\/td><th>'.$this->mnReadable($s[$key]).'<\/th><\/tr>';
						}
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
					if ((!$this->player && !$this->tarid) && $this->mode==1)
						$content .= ($r = ($this->npcsById[$key]) ? str_replace("'", "\'", $this->participants[4][$key]->name) : "Unknown")."');";
					else
						$content .= ($r = ($this->spells[$key]) ? str_replace("'", "\'", $this->spells[$key]->name) : "Unknown")."');";
					$content .= "data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});";
				}
				$content .= "
					data.addRows([
				";
				foreach ($t[2] as $key => $var){
					$content .= "['".($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00')."'";
					foreach($t[1] as $k => $v){
						$bool = false;
						$tooltip = '<table class="tooltip"><tr><th colspan="2">'.($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00').'<\/th><\/tr><tr><td><\/td><th><\/th><\/tr>';
						foreach($v as $ke => $va){
							if ($ke == $key){
								$tooltip .= '<tr><td>'.str_replace("'", "\'", ($r = ((!$this->player && !$this->tarid) && $this->mode==1) ? $this->participants[4][$k]->name : $this->spells[$k]->name)).': <\/td><th>'.$this->mnReadable($va).'<\/th><\/tr><\/table>';
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
					data.addColumn('number', 'Effective healing');
					data.addColumn({type:'string', role:'annotation'});
				";
			}else{
				$content .= "
					data.addColumn('number', 'Total');
					data.addColumn({type:'string', role:'annotation'});
				";
				foreach($player as $k => $v){
					$content .= "data.addColumn('number', '".($r = ($this->participants[4][$v]) ? $this->participants[4][$v]->name : "Unknown")."');
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
				  },
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
		$content = $this->getSame(6);
		$table = $this->getTable();
		$this->addJs($this->jsToAdd());
		$content .= '
			<div class="centredNormal newmargin">
			<div class="hackleft'.($r = ($this->mode==2) ? ' long' : '').'">
			<section class="ttitle semibig'.($r = ($this->mode != 2) ? ' short' : '').'">Healing '.($r = ($this->mode == 0 && $this->player) ? "received" : "done").' '.$this->modes[$this->mode].'</section>
			<section class="table tees'.($r = ($this->mode != 2) ? ' short' : '').'">
		';
		if ($this->mode == 2){
			$content .= '
				<table cellspacing="0">
					<thead>
						<tr>
							<th class="count">#</th>
							<th class="a-char">Name</th>
							<th class="a-amount">Amount</th>
							<th class="cbt">HPS</th>
							<th class="average">Average</th>
							<th class="hits">Casts</th>
							<th class="perc">Crit</th>
							<th class="perc">OHeal</th>
							<th class="perc">EHeal</th>
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
							<td class="a-char"><img src="{path}Database/icons/small/'.$table[5][$key][2].'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://tbc-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.($r = ($table[5][$key][1]) ? $table[5][$key][1] : "Unknown").'</a></td>
							<td class="a-amount">
								<div>'.round(100*$var/$table[1], 2).'%</div>
								<div class="amount-sbar"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$key]->classid].'" style="width: '.(100*$var/$table[4]).'%;"></div></div>
								<div>'.$this->mnReadable($var).'</div>
							</td>
							<td class="cbt">'.$this->mReadable($var/$this->atmpts[1], 2).'</td>
							<td class="average">'.$this->mReadable($var/$table[12][$key], 2).'</td>
							<td class="hits">'.$this->mnReadable($table[12][$key]).'</td>
							<td class="perc">'.round(100*$table[7][$key], 2).'%</td>
							<td class="perc">'.round(100*(1-$table[8][$key]/$var), 2).'%</td>
							<td class="perc">'.$this->mnReadable($table[8][$key]+$table[10][$key]).'</td>
						</tr>
			';
			$count++;
		}
		$content .= '
					</tbody>
					<tfoot>
						<tr>
							<th class="a-char">Total</th>
							<th class="a-amount"><div>100%</div><div class="amount-sbar"></div><div class="shortt">'.$this->mnReadable($table[1]).'</div></th>
							<th class="cbt">'.$this->mReadable($table[1]/$this->atmpts[1], 2).'</th>
							<th class="average">&nbsp;</th>
							<th class="hits">'.$this->mnReadable($table[14]).'</th>
							<th class="perc">&nbsp;</th>
							<th class="perc">'.round(100*(1-$table[18]/$table[1]), 2).'%</th>
							<th class="perc">'.$this->mnReadable($table[18]).'</th>
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
							<th class="active">Active</th>
							<th class="cbt">HPS</th>
							<th class="cbt">OHeal</th>
							<th class="cbt">Absd</th>
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
								<td class="char"><img src="{path}Database/classes/c'.$this->participants[4][$k]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$k]->classid].'" href="{path}TBC/Raids/Evaluation/Healing/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$k.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode='.($r = ($this->mode==1) ? 0 : 1).'">'.($r = ($this->participants[4][$k]) ? $this->participants[4][$k]->name : "Unknown").'</a></td>
								<td class="amount">
									<div>'.round(100*$v/$table[1], 2).'%</div>
									<div class="amount-sbar"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$k]->classid].'" style="width: '.(100*$v/$table[4]).'%;"></div></div>
									<div>'.$this->mnReadable($v).'</div>
								</td>
								<td class="active">'.round(100*$table[3][$k]/$this->atmpts[1], 2).'%</td>
								<td class="cbt">'.$this->mReadable($v/$this->atmpts[1], 2).'</td>
								<td class="cbt">'.round(100*(1-$table[6][$k]/$v), 2).'%</td>
								<td class="cbt">'.round(100*$table[7][$k]/$v, 2).'%</td>
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
								<th class="cbt">'.round(100*(1-$table[18]/$table[1]), 2).'%</th>
								<th class="cbt">'.round(100*$table[17]/$table[1], 2).'%</th>
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
		if ($this->mode != 2){
			$content .= '
			<div class="hackright">
				<section class="table records">
					<table cellspacing="0">
						<thead>
							<tr title="Realm rank | Realm-Class rank | Realm-Type rank | Name | Bossname 
Realm rank: The rank you achieved among the realm. 
Realm-Class rank: The rank you achieved on your realm among your class. 
Realm-Type rank: The rank you achieved among the caster or meele on your realm.">
								<th colspan="5">Records*</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
			';
			foreach ($table[10] as $var){
				$content .= '
							<tr>
								<td class="num">'.$var->realm.'</td>
								<td class="num">'.$var->realmclass.'</td>
								<td class="num">'.$var->realmtype.'</td>
								<td class="lstring"><img src="{path}Database/classes/c'.$this->participants[4][$var->charid]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$var->charid]->classid].'" href="{path}TBC/Character/'.$raidinfo->sname.'/'.$this->participants[4][$var->charid]->name.'/0">'.$this->participants[4][$var->charid]->name.'</a></td>
								<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type=-1&tarid='.$this->tarid.'&mode=0&id='.$this->getRankingsLink($var->npcid).'">'.$this->npcsById[$var->npcid]->name.'</a></td>
							</tr>
				';
			}
			$content .= '
						</tbod>
					</table>
				</section>
			</div>
			';
		}
		$content .= '
			</div>
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