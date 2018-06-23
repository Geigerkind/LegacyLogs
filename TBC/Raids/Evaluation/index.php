<?php
require(dirname(__FILE__)."/Template.php");

class Home extends Template{
	
	private function getLoot($aids){
		$t = array();
		$con = "b.attemptid IN (".$aids.")";
		if ($this->tarid){
			$con4 = ' AND attemptid IN ('.$this->atmpts[12][$this->tarid].')';
		}
		$offset = explode(",",$this->raidinfo->loot);
		foreach($this->db->query('SELECT b.id, b.loot, c.name, c.icon, c.rarity, b.charid, b.attemptid FROM `tbc-raids-loot` b LEFT JOIN items c ON b.loot = c.id WHERE b.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND '.$con.$con4.' ORDER BY b.id') as $q){
			if ($q->loot)
				$t[$q->attemptid][$q->id] = $q;
		}
		return $t;
	}
	
	private function getPet($pid){
		foreach($this->participants[4] as $key => $var){
			if ($var->ownerid==$pid)
				return ','.$key.'';
		}
		return '';
	}
	
	private function getTable(){
		$p = array();
		$cont2 = ''; $con3 = ''; $con4 = '';
		if ($this->attempts){
			$con = "id IN (".$this->attempts.")";
			if ($this->sel)
				$con = "id = ".$this->sel;
		}else if ($this->sel){
			$con = "id = ".$this->sel;
		}else{
			$con = "rid = ".$this->rid;
		}
		//Okay caching all this here saves 800ms, will definitely do it!
		$aid = $this->db->query('SELECT group_concat(id) as aid FROM `tbc-raids-attempts` WHERE '.$con.' AND rdy = 1;')->fetch()->aid;
		$offsets = array();
		$offsets[4] = explode(",",$this->raidinfo->deaths);
		if ($this->tarid){
			$con2 = ' AND npcid = '.$this->tarid;
			$con3 = ' AND flagid = '.$this->tarid;
			$con4 = ' AND attemptid IN ('.$this->atmpts[12][$this->tarid].')';
		}
		if ($this->player){
			$offsets[1] = explode(",",$this->raidinfo->indddba);
			$offsets[2] = explode(",",$this->raidinfo->inddtfa);
			$offsets[3] = explode(",",$this->raidinfo->indhba);
			foreach($this->db->query('SELECT * FROM `tbc-raids-individual-dmgdonebyability` WHERE id BETWEEN '.$offsets[1][0].' AND '.$offsets[1][1].' AND attemptid IN ('.$aid.') AND charid IN('.$this->player.$this->getPet($this->player).')'.$con2.' ORDER BY amount DESC;') as $q){
				$p[1] += $q->amount;
				$p[2][$q->abilityid] += $q->amount;
				if ($p[3]<$p[2][$q->abilityid] or !$p[3])
					$p[3] = $p[2][$q->abilityid];
			}
			foreach($this->db->query('SELECT * FROM `tbc-raids-individual-dmgtakenfromability` WHERE id BETWEEN '.$offsets[2][0].' AND '.$offsets[2][1].' AND attemptid IN ('.$aid.') AND charid = '.$this->player.''.$con2.' ORDER BY amount DESC;') as $q){
				$p[4] += $q->amount;
				$p[5][$q->abilityid] += $q->amount;
				if ($p[6]<$p[5][$q->abilityid] or !$p[6])
					$p[6] = $p[5][$q->abilityid];
			}
			foreach($this->db->query('SELECT * FROM `tbc-raids-individual-healingbyability` WHERE id BETWEEN '.$offsets[3][0].' AND '.$offsets[3][1].' AND attemptid IN ('.$aid.') AND charid = '.$this->player.$con4.' ORDER BY eamount DESC;') as $q){
				$p[7] += $q->eamount;
				$p[8][$q->abilityid] += $q->eamount;
				if ($p[9]<$p[8][$q->abilityid] or !$p[9])
					$p[9] = $p[8][$q->abilityid];
			}
			foreach($this->db->query('SELECT * FROM `tbc-raids-deaths` WHERE id BETWEEN '.$offsets[4][0].' AND '.$offsets[4][1].' AND attemptid IN ('.$aid.') AND charid = '.$this->player.''.$con3.';') as $q){
				$p[10][$q->id] = Array(
					1 => $q->charid,
					2 => $q->killingblow,
					3 => $q->time,
					4 => $q->cbt
				);
			}
		}else{
			$offsets[1] = explode(",",$this->raidinfo->indddte);
			$offsets[2] = explode(",",$this->raidinfo->inddtfs);
			$offsets[3] = explode(",",$this->raidinfo->indhtf);
			foreach($this->db->query('SELECT amount, charid FROM `tbc-raids-individual-dmgdonetoenemy` WHERE id BETWEEN '.$offsets[1][0].' AND '.$offsets[1][1].' AND attemptid IN ('.$aid.')'.$con2.' ORDER BY amount DESC;') as $q){
				$p[1] += $q->amount;
				if ($this->pet == 0){
					if ($this->participants[4][$q->charid]->ownerid)
						$p[2][$this->participants[4][$q->charid]->ownerid] += $q->amount;
					else
						$p[2][$q->charid] += $q->amount;
				}else{
					$p[2][$q->charid] += $q->amount;
				}
				if ($p[3]<$p[2][$q->charid] or !$p[3])
					$p[3] = $p[2][$q->charid];
				if ($p[3]<$p[2][$this->participants[4][$q->charid]->ownerid] or !$p[3])
					$p[3] = $p[2][$this->participants[4][$q->charid]->ownerid];
			}
			foreach($this->db->query('SELECT amount, charid FROM `tbc-raids-individual-dmgtakenfromsource` WHERE id BETWEEN '.$offsets[2][0].' AND '.$offsets[2][1].' AND attemptid IN ('.$aid.')'.$con2.' ORDER BY amount DESC;') as $q){
				$p[4] += $q->amount;
				$p[5][$q->charid] += $q->amount;
				if ($p[6]<$p[5][$q->charid] or !$p[6])
					$p[6] = $p[5][$q->charid];
			}
			foreach($this->db->query('SELECT eamount, charid FROM `tbc-raids-individual-healingtofriendly` WHERE id BETWEEN '.$offsets[3][0].' AND '.$offsets[3][1].' AND attemptid IN ('.$aid.')'.$con4.' ORDER BY eamount DESC;') as $q){
				$p[7] += $q->eamount;
				$p[8][$q->charid] += $q->eamount;
				if ($p[9]<$p[8][$q->charid] or !$p[9])
					$p[9] = $p[8][$q->charid];
			}
			foreach($this->db->query('SELECT charid, id, killingblow, time, cbt FROM `tbc-raids-deaths` WHERE id BETWEEN '.$offsets[4][0].' AND '.$offsets[4][1].' AND attemptid IN ('.$aid.')'.$con3.' ORDER BY cbt;') as $q){
				$p[10][$q->id] = Array(
					1 => $q->charid,
					2 => $q->killingblow,
					3 => $q->time,
					4 => $q->cbt
				);
			}
		}
		arsort($p[2]);
		arsort($p[5]);
		arsort($p[8]);
		$p[20] = $aid;
		return $p;
	}
	
	private $eventPoints = array();
	private function getGraphValues($q, $q2, $q3, $q4){
		// getting the end value
		$q->time = explode(",", $q->time);
		$q2->time = explode(",", $q2->time);
		$q3->time = explode(",", $q3->time);
		$q4->time = explode(",", $q4->time);
		$q->amount = explode(",", $q->amount);
		$q2->amount = explode(",", $q2->amount);
		$q3->amount = explode(",", $q3->amount);
		$q4->amount = explode(",", $q4->amount);
		asort($q->time);
		asort($q2->time);
		asort($q3->time);
		asort($q4->time);
		$arrTime = array($q->time, $q2->time, $q3->time, $q4->time);
		$amArr = array($q->amount, $q2->amount, $q3->amount, $q4->amount);
		$end = 0; $start = null;
		foreach($arrTime as $v){
			foreach($v as $var){
				if ($var && $var <= 100000){
					if ($var>$end)
						$end = $var;
					if ($var<$start || !$start)
						$start = $var;
				}
			}
		}
		
		// test if there are enough values else make more
		$e = array();
		foreach($arrTime as $k => $v){
			$t = array();
			$last = $start;
			foreach ($v as $key => $var){
				if ($var){
					$time = ($var-$last)/10;
					$am = ceil($amArr[$k][$key]/10);
					for ($p=0; $p<=10; $p++){
						$t[$last+$time*$p] += $am;
					}
					$last = $var;
				}
			}
			
			$num = sizeOf($t);
			$coeff = ceil($num/56);
			$ltime = 0; $lam = 0; $i = 0;
			foreach($t as $key => $var){
				if ($key <= 20000 && $coeff>1){
					if ($i == $coeff){
						$e[$k][$ltime] = $lam;
						$ltime = 0; $lam = 0; $i = 0;
					}else{
						if ($ltime == 0)
							$ltime = $key;
						else
							$ltime = ($ltime+$key)/2;
						if ($var <= 2000000)
							$lam += $var;
						$i++;
					}
				}
				if ($coeff<=1){
					$e[$k][$key] = $var;
				}
			}
		}
		
		// allign them to same space
		//print $start."/".$end;
		$space = (($end-$start)/50);
		$c = array();
		foreach($e as $k => $v){
			if (!isset($c[$k]))
				$c[$k] = array();
			if ($space > 1){
				foreach($v as $key => $var){
					for($i=0; $i<=50; $i++){
						if ($key<($i*$space+$start) && $key>(($i-1)*$space+$start)){
							if (isset($c[$k][$start+$i*$space]))
								$c[$k][$start+$i*$space] += $var;
							else
								$c[$k][$start+$i*$space] = $var;
							break;
						}
					}
				}
			}else{
				foreach($v as $key => $var){
					$c[$k][$key] = $var;
				}
			}
		}
		ksort($c[0]);
		ksort($c[1]);
		ksort($c[2]);
		ksort($c[3]);
		if (!$this->attempts && $this->events == 0 && !$this->sel){
			foreach($this->atmpts[2] as $k => $v){
				if ($this->raidBosses[$this->raidinfo->nameid][$this->atmpts[7][$k]]){
					$last = 0;
					foreach($v as $ke => $va){
						if ($va[1] == 1){
							foreach($c[0] as $key => $var){
								$last = $key;
								if ($va[3]<$key)
									break 1;
							}
						}
					}
					$this->eventPoints[$last] = $this->atmpts[7][$k];
				}
			}
		}
		return $c;
	}
	
	private function jsToAdd($aids, $lastaid){
		$t = "";
		if ($this->player){
			$con = ' AND a.charid ='.$this->player;
			$pet = $this->getPet($this->player);
			if ($pet == '')
				$con2 = ' AND a.charid = '.$this->player;
			else
				$con2 = ' AND a.charid IN ('.$this->player.$pet.')';
			$t = "individual-";
			$con4 = ' AND a.sourceid ='.$this->player;
		}
		if ($this->tarid){
			$con5 = ' AND a.npcid = '.$this->tarid;
			$con6 = ' AND a.attemptid IN ('.$this->atmpts[12][$this->tarid].')';
		}
		$offsets = array();
		$offsets[1] = explode(",", $this->raidinfo->graphdmg);
		$offsets[2] = explode(",", $this->raidinfo->graphdmgt);
		$offsets[3] = explode(",", $this->raidinfo->graphheal);
		if ($this->attempts){
			$con3 = 'a.attemptid IN ('.$this->attempts.')';
			if ($this->sel)
				$con3 = 'a.attemptid = "'.$this->sel.'"';
			//print 'SELECT a.time, a.amount FROM `tbc-raids-graph-individual-dmgdone` a WHERE id BETWEEN '.$offsets[1][0].' AND '.$offsets[1][1].' AND '.$con3.$con2.$con5;
			foreach ($this->db->query('SELECT a.time, a.amount FROM `tbc-raids-graph-individual-dmgdone` a WHERE id BETWEEN '.$offsets[1][0].' AND '.$offsets[1][1].' AND '.$con3.$con2.$con5) as $row){
				$q->time .= $row->time.","; $q->amount .= $row->amount.",";
			}
			foreach ($this->db->query('SELECT a.time, a.amount FROM `tbc-raids-graph-individual-dmgtaken` a WHERE id BETWEEN '.$offsets[2][0].' AND '.$offsets[2][1].' AND '.$con3.$con.$con5) as $row){
				$q2->time .= $row->time.","; $q2->amount .= $row->amount.",";
			}
			foreach ($this->db->query('SELECT a.time, a.amount, a.sourceid FROM `tbc-raids-graph-individual-healingreceived` a WHERE id BETWEEN '.$offsets[3][0].' AND '.$offsets[3][1].' AND '.$con3.$con6) as $row){
				if (($row->sourceid==$this->tarid) or !$this->tarid)
					$q3->time .= $row->time.","; $q3->amount .= $row->amount.",";
				if ($this->player)
					$q4->time .= $row->time; $q4->amount .= $row->amount;
			}
		}elseif ($this->sel){
			foreach($this->db->query('SELECT a.time, a.amount FROM `tbc-raids-graph-individual-dmgdone` a WHERE id BETWEEN '.$offsets[1][0].' AND '.$offsets[1][1].' AND a.attemptid = '.$this->sel.$con2.$con5) as $row){
				$q->time .= $row->time.","; $q->amount .= $row->amount.",";
			}
			foreach($this->db->query('SELECT a.time, a.amount FROM `tbc-raids-graph-individual-dmgtaken` a WHERE id BETWEEN '.$offsets[2][0].' AND '.$offsets[2][1].' AND a.attemptid = '.$this->sel.$con.$con5) as $row){
				$q2->time .= $row->time.","; $q2->amount .= $row->amount.",";
			}
			foreach($this->db->query('SELECT a.time, a.amount, a.sourceid FROM `tbc-raids-graph-individual-healingreceived` a WHERE id BETWEEN '.$offsets[3][0].' AND '.$offsets[3][1].' AND a.attemptid = '.$this->sel.$con6) as $row){
				if (($row->sourceid==$this->tarid) or !$this->tarid)
					$q3->time .= $row->time.","; $q3->amount .= $row->amount.",";
				if ($this->player)
					$q4->time .= $row->time.","; $q4->amount .= $row->amount.",";
			}
		}else{
			foreach($this->db->query('SELECT a.time, a.amount FROM `tbc-raids-graph-individual-dmgdone` a WHERE id BETWEEN '.$offsets[1][0].' AND '.$offsets[1][1].' AND a.attemptid IN ('.$aids.')'.$con2.$con5) as $row){
				$q->time .= $row->time.",";
				$q->amount .= $row->amount.",";
			}
			foreach($this->db->query('SELECT a.time, a.amount FROM `tbc-raids-graph-individual-dmgtaken` a WHERE id BETWEEN '.$offsets[2][0].' AND '.$offsets[2][1].' AND a.attemptid IN ('.$aids.')'.$con.$con5) as $row){
				$q2->time .= $row->time.",";
				$q2->amount .= $row->amount.",";
			}
			foreach($this->db->query('SELECT a.time, a.amount, a.sourceid FROM `tbc-raids-graph-individual-healingreceived` a WHERE id BETWEEN '.$offsets[3][0].' AND '.$offsets[3][1].' AND a.attemptid IN ('.$aids.')'.$con.$con6) as $row){
				if (($row->sourceid==$this->tarid) or !$this->tarid){
					$q3->time .= $row->time.",";
					$q3->amount .= $row->amount.",";
				}
				if ($this->player){
					$q4->time .= $row->time.",";
					$q4->amount .= $row->amount.",";
				}
			}
		}
		$p = $this->getGraphValues($q, $q2, $q3, $q4);
		$time = array();
		$dps = array();
		$hps = array();
		$dtps = array();
		$htps = array();
		$i = 1;
		$interval = null;
		$mooode = 1; $last = 0;
		foreach(array(1=>sizeOf($p[0]), 2=>sizeOf($p[1]), 3=>sizeOf($p[2]), 4=>sizeOf($p[3])) as $k => $v){
			if ($v>$last){
				$mooode = $k;
				$last = $v;
			}
		}
		foreach($p[0] as $k => $v){
			if ($mooode == 1)
				$time[$i] = $k;
			$dps[$i] = $v;
			if (!$interval && $i>2)
				$interval = $k-$time[$i-1];
			$i++;
		}
		$i = 1;
		foreach($p[1] as $k => $v){
			if ($mooode == 2)
				$time[$i] = $k;
			$dtps[$i] = $v;
			$i++;
		}
		$i = 1;
		foreach($p[2] as $k => $v){
			if ($mooode == 3)
				$time[$i] = $k;
			$hps[$i] = $v;
			$i++;
		}
		$i = 1;
		foreach($p[3] as $k => $v){
			if ($mooode == 4)
				$time[$i] = $k;
			$htps[$i] = $v;
			$i++;
		}
		$content .= "
	      google.charts.load('current', {'packages':['corechart']});
		  google.charts.setOnLoadCallback(drawChart);
		
		  function drawChart() {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Time');
			data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
			data.addColumn('number', 'Damage');
			data.addColumn({type:'string', role:'annotation'});
			data.addColumn('number', 'Damage taken');
			data.addColumn('number', 'Healing');
		";
		if ($this->player)
			$content .= "
			data.addColumn('number', 'Healing taken');
		";
		$content .= "
			data.addRows([
		";
		foreach($time as $k => $v){
			$cdps = (isset($dps[$k])) ? $dps[$k] : 0;
			$cdtps = (isset($dtps[$k])) ? $dtps[$k] : 0;
			$chps = (isset($hps[$k])) ? $hps[$k] : 0;
			$chtps = (isset($htps[$k])) ? $htps[$k] : 0;
			$htmlc = '<table class="ctooltip"><tr><th>Time:</th><td>'.gmdate('H:i:s', $v).'</td></tr><tr><th>Interval:</th><td>'.gmdate('i:s', $interval).'</td></tr><tr><th>Damage:</th><td>'.$this->mnReadable($cdps).'</td></tr><tr><th>DPS:</th><td>'.$this->mReadable($cdps/$interval).'</td></tr><tr><th>DmgTaken:</th><td>'.$this->mnReadable($cdtps).'</td></tr><tr><th>DTPS:</th><td>'.$this->mReadable($cdtps/$interval).'</td></tr><tr><th>Healing:</th><td>'.$this->mnReadable($chps).'</td></tr><tr><th>HPS:</th><td>'.$this->mReadable($chps/$interval).'</td></tr>'.($r = ($this->player) ? '<tr><th>HealTaken:</th><td>'.$this->mnReadable($chtps).'</td></tr><tr><th>HTPS:</th><td>'.$this->mReadable($chtps/$interval).'</td></tr>' : '').'</table>';
			$content .="
				['".gmdate('H:i:s', $v)."', '".$htmlc."',  ".$cdps.", ".($r = (isset($this->eventPoints[$v]) and $this->events == 0) ? "'".str_replace("'", "\'", $this->eventPoints[$v])."'" : "null").", ".$cdtps.", ".$chps.($r = ($this->player) ? ','.$chtps : '')."],
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
			  focusTarget: 'category',
			  tooltip: {isHtml: true}
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
		return $content;
	}
	
	private function sortParticipants(){
		for ($p=1; $p<4; $p++){
			$newPart = array();
			for ($i=0; $i<10; $i++){
				foreach($this->participants[$p] as $key => $var){
					if ($var->classid == $i){
						array_push($newPart, $var);
					}
				}
			}
			$this->participants[$p] = $newPart;
		}
	}
	
	public function content(){
		$table = $this->getTable();
		$loot = $this->getLoot($table[20]);
		$this->addJs($this->jsToAdd($table[20], $table[21]));
		$this->sortParticipants();
		$content = $this->getSame(0);
		$content .= '
			<script>function Toggle(id, elem){for (var i=0; i<4; i++){ document.getElementById(elem[i]).style.display = "none"; document.getElementById("n"+elem[i]).style.color = "#fff"; }; document.getElementById(id).style.display = "block"; document.getElementById("n"+id).style.color = "#f28f45";}</script>
		';
		if (sizeOf($loot)>0){
		$content .= '
			<section class="ttitle newmargin semibig">Loot</section>
			<section class="boxWithout"'.($r = ($this->compact==0) ? ' style="padding-left: 0px; padding-top: 10px; padding-right: 10px;"' : '').'>
		';
		foreach($loot as $ke => $va){
			if ($this->compact==0){
			foreach($va as $var){
				$content .= '
					<div class="item qe'.$var->rarity.'" style="background-image: url(\'{path}Database/icons/large/'.$var->icon.'.jpg\');">
						<a rel="item-'.$var->loot.'" href="https://tbc-twinhead.twinstar.cz/?item='.$var->loot.'" target="_blank"><div></div></a>
						<a class="color-'.$this->classById[$this->participants[4][$var->charid]->classid].'" href="{path}TBC/Character/'.$this->raidinfo->sname.'/'.($r = ($this->participants[4][$var->charid]) ? $this->participants[4][$var->charid]->name : "Unknown").'/0">'.($r = ($this->participants[4][$var->charid]) ? $this->participants[4][$var->charid]->name : "Unknown").'</a>
					</div>
				';
			}
			}else{
			$content .= '
			<div class="itemgroup">
				<div class="itemgroupname"><a href="{path}TBC/Raids/Evaluation/?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$ke.'&pet='.$this->pet.'&tarid='.$this->tarid.'">'.$this->npcsById[$this->atmpts[8][$ke]]->name.'</a></div>
				<div class="itemgroupcontainer">
			';
			foreach($va as $var){
				$content .= '
					<div class="item qe'.$var->rarity.'" style="background-image: url(\'{path}Database/icons/large/'.$var->icon.'.jpg\');">
						<a rel="item-'.$var->loot.'" href="https://tbc-twinhead.twinstar.cz/?item='.$var->loot.'" target="_blank"><div></div></a>
						<a class="color-'.$this->classById[$this->participants[4][$var->charid]->classid].'" href="{path}TBC/Character/'.$this->raidinfo->sname.'/'.($r = ($this->participants[4][$var->charid]) ? $this->participants[4][$var->charid]->name : "Unknown").'/0">'.($r = ($this->participants[4][$var->charid]) ? $this->participants[4][$var->charid]->name : "Unknown").'</a>
					</div>
				';
			}
			$content .= '
				</div>
			</div>
			';
			}
		}
		$content .= '
			</section>
		';
		}
		$content .= '
			<section class="ttitle newmargin semibig raidcomp">
				<ul>
					<li class="nosel">Raid Composition (<span>'.(sizeOf($this->participants[1])+sizeOf($this->participants[2])+sizeOf($this->participants[3])).'</span>)</li>
					<li class="sel" id="ntanks" onclick="Toggle(\'tanks\', [\'tanks\', \'dps\', \'healer\', \'pets\']);">Tanks</li>
					<li id="ndps" onclick="Toggle(\'dps\', [\'tanks\', \'dps\', \'healer\', \'pets\']);">DPS</li>
					<li id="nhealer" onclick="Toggle(\'healer\', [\'tanks\', \'dps\', \'healer\', \'pets\']);">Healer</li>
					<li id="npets" onclick="Toggle(\'pets\', [\'tanks\', \'dps\', \'healer\', \'pets\']);"">Pets</li>
				</ul>
			</section>
			<section class="boxWithout" style="padding-left: 0px; padding-top: 10px; padding-right: 10px;">
				<div id="tanks">
		';
		foreach($this->participants[1] as $key => $var){
			if ($var->name)
				$content .= '
					<div class="user"><img src="{path}Database/classes/c'.$var->classid.'.png" /><a class="color-'.$this->classById[$var->classid].'" href="{path}TBC/Character/'.$this->raidinfo->sname.'/'.$var->name.'/0">'.$var->name.'</a></div>
				';
		}
		$content .= '
				</div>
				<div id="dps">
		';
		foreach($this->participants[2] as $key => $var){
			if ($var->ownerid==0 && $var->name)
				$content .= '
					<div class="user"><img src="{path}Database/classes/c'.$var->classid.'.png" /><a class="color-'.$this->classById[$var->classid].'" href="{path}TBC/Character/'.$this->raidinfo->sname.'/'.$var->name.'/0">'.$var->name.'</a></div>
				';
		}
		$content .= '
				</div>
				<div id="healer">
		';
		foreach($this->participants[3] as $key => $var){
			if ($var->name)
				$content .= '
					<div class="user"><img src="{path}Database/classes/c'.$var->classid.'.png" /><a class="color-'.$this->classById[$var->classid].'" href="{path}TBC/Character/'.$this->raidinfo->sname.'/'.$var->name.'/0">'.$var->name.'</a></div>
				';
		}
		$content .= '
				</div>
				<div id="pets">
		';
		foreach($this->participants[2] as $key => $var){
			if ($var->ownerid>0 && $var->name)
				$content .= '
					<div class="user" title="Owner: '.$this->participants[4][$var->ownerid]->name.'"><img src="{path}Database/classes/c'.$var->classid.'.png" /><a class="color-'.$this->classById[$var->classid].'" href="{path}TBC/Character/'.$this->raidinfo->sname.'/'.$var->name.'/0">'.$var->name.'</a></div>
				';
		}
		$content .= '
				</div>
			</section>
			<section class="ttitle newmargin semibig raidcomp">
				<ul>
					<li class="sel" id="ndmg" onclick="Toggle(\'dmg\', [\'dmg\', \'hps\', \'dtps\', \'deaths\']);">Damage done by source</li>
					<li id="nhps" onclick="Toggle(\'hps\', [\'dmg\', \'hps\', \'dtps\', \'deaths\']);">Efficient healing done by source</li>
					<li id="ndtps" onclick="Toggle(\'dtps\', [\'dmg\', \'hps\', \'dtps\', \'deaths\']);">Damage taken by source</li>
					<li id="ndeaths" onclick="Toggle(\'deaths\', [\'dmg\', \'hps\', \'dtps\', \'deaths\']);"">Deaths</li>
				</ul>
			</section>
			<section class="table tees">
				<div id="dmg">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th class="char">Name</th>
								<th class="amount">Amount</th>
								<th class="cbt">DPS</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
		$count=1;
		foreach ($table[2] as $k => $v){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								'.($r = ($this->player) ? '<td class="char"><img src="{path}Database/icons/small/'.$this->spells[$k]->icon.'.jpg"><a target="_blank" rel="spell='.$k.'" href="https://TBC-twinhead.twinstar.cz/?spell='.$this->spells[$k]->id.'" target="_blank">'.$this->spells[$k]->name.'</a></td>' : '<td class="char"><img src="{path}Database/classes/c'.$this->participants[4][$k]->classid.'.png"><a class="color-'.$this->classById[$this->participants[4][$k]->classid].'" href="{path}TBC/Raids/Evaluation/DmgDone/?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$k.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2">'.$this->participants[4][$k]->name.'</a></td>').'
								<td class="amount">
									<div>'.round(100*$v/$table[1], 2).'%</div>
									<div class="amount-sbar"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$k]->classid].'" style="width: '.(100*$v/$table[3]).'%;"></div></div>
									<div>'.$this->mnReadable($v).'</div>
								</td>
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
								<th class="cbt">'.$this->mReadable($table[1]/$this->atmpts[1], 2).'</th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div id="hps">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th class="char">Name</th>
								<th class="amount">Amount</th>
								<th class="cbt">HPS</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
		$count=1;
		foreach ($table[8] as $k => $v){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								'.($r = ($this->player) ? '<td class="char"><img src="{path}Database/icons/small/'.$this->spells[$k]->icon.'.jpg"><a target="_blank" rel="spell='.$k.'" href="https://TBC-twinhead.twinstar.cz/?spell='.$this->spells[$k]->id.'" target="_blank">'.$this->spells[$k]->name.'</a></td>' : '<td class="char"><img src="{path}Database/classes/c'.$this->participants[4][$k]->classid.'.png"><a class="color-'.$this->classById[$this->participants[4][$k]->classid].'" href="{path}TBC/Raids/Evaluation/Healing/?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$k.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1">'.$this->participants[4][$k]->name.'</a></td>').'
								<td class="amount">
									<div>'.round(100*$v/$table[7], 2).'%</div>
									<div class="amount-sbar"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$k]->classid].'" style="width: '.(100*$v/$table[9]).'%;"></div></div>
									<div>'.$this->mnReadable($v).'</div>
								</td>
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
								<th class="amount"><div>100%</div><div class="amount-sbar"></div><div>'.$this->mnReadable($table[7]).'</div></th>
								<th class="cbt">'.$this->mReadable($table[7]/$this->atmpts[1], 2).'</th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div id="dtps">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th class="char">Name</th>
								<th class="amount">Amount</th>
								<th class="cbt">DTPS</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
		$count=1;
		foreach ($table[5] as $k => $v){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								'.($r = ($this->player) ? '<td class="char"><img src="{path}Database/icons/small/'.$this->spells[$k]->icon.'.jpg"><a target="_blank" rel="spell='.$k.'" href="https://TBC-twinhead.twinstar.cz/?spell='.$this->spells[$k]->id.'" target="_blank">'.$this->spells[$k]->name.'</a></td>' : '<td class="char"><img src="{path}Database/classes/c'.$this->participants[4][$k]->classid.'.png"><a class="color-'.$this->classById[$this->participants[4][$k]->classid].'" href="{path}TBC/Raids/Evaluation/DmgTaken/?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$k.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=2">'.$this->participants[4][$k]->name.'</a></td>').'
								<td class="amount">
									<div>'.round(100*$v/$table[4], 2).'%</div>
									<div class="amount-sbar"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$k]->classid].'" style="width: '.(100*$v/$table[6]).'%;"></div></div>
									<div>'.$this->mnReadable($v).'</div>
								</td>
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
								<th class="amount"><div>100%</div><div class="amount-sbar"></div><div>'.$this->mnReadable($table[4]).'</div></th>
								<th class="cbt">'.$this->mReadable($table[4]/$this->atmpts[1], 2).'</th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div id="deaths">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th class="char">Name</th>
								<th class="amount">Killing blow</th>
								<th class="cbt">Time</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
		$count=1;
		foreach ($table[10] as $k => $v){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								<td class="char"><img src="{path}Database/classes/c'.$this->participants[4][$v[1]]->classid.'.png"><a class="color-'.$this->classById[$this->participants[4][$v[1]]->classid].'" href="{path}TBC/Raids/Evaluation/Deaths/?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$v[1].'&sel='.$this->sel.'&pet='.$this->pet.'">'.$this->participants[4][$v[1]]->name.'</a></td>
								<td class="amount"><img src="{path}Database/icons/small/'.$this->spells[$v[2]]->icon.'.jpg" /><a target="_blank" rel="spell='.$v[2].'" href="https://TBC-twinhead.twinstar.cz/?spell='.$this->spells[$v[2]]->id.'" target="_blank">'.$this->spells[$v[2]]->name.'</a></td>
								<td class="cbt">'.gmdate("H:i:s", $v[4]).'</td>
							</tr>
			';
			$count++;
		}
		$content .= '
						</tbody>
					</table>
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $rid, $attempts, $player, $attemptid, $pet, $events, $mode, $npcid){
		$this->addJsLink("https://www.gstatic.com/charts/loader.js", true);
		parent::__construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid);
	}
}

new Home($db, __DIR__, $_GET["rid"], $_GET["attempts"], $_GET["player"], $_GET["sel"], $_GET["pet"], $_GET["events"], $_GET["mode"], $_GET["tarid"]);

?>