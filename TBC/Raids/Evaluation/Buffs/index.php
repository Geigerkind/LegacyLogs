<?php
require(dirname(__FILE__)."/../Template.php");

class Home extends Template{
	private $sourceById = array(
		1 => "Player",
		2 => "World",
		3 => "Set-Bonus",
		4 => "Pet",
		5 => "Trinket",
		6 => "Weapon",
		7 => "Enchantment",
		8 => "Alchemy",
		9 => "Item",
		10 => "Engineering",
		11 => "Blacksmithing",
		12 => "Leatherworking",
		13 => "NPC",
		14 => "Racial",
		15 => "Other"
	);
	
	private function average(&$t, $t2, $mC, $c){
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
	
	private function getUptime($a){
		if ($a > 100)
			return 100;
		return $a;
	}
	
	private function getTable(){
		$t = array();
		if ($this->mode == 0){
			$p = array();
			$con = '';
			if ($this->player)
				$con = 'charid = '.$this->player.' AND ';
			$offset = explode(",", $this->raidinfo->newbuffs);
			foreach($this->db->query('SELECT * FROM `tbc-raids-newbuffs` WHERE id BETWEEN '.$offset[0].' AND '.$offset[1].' AND '.$con.'rid = '.$this->rid) as $row){
				$p[$this->spells[$row->abilityid]->cat][$row->abilityid][$row->charid][1] .= ",".$row->cbtstart;
				$p[$this->spells[$row->abilityid]->cat][$row->abilityid][$row->charid][2] .= ",".$row->cbtend;
				$t[11][$row->abilityid][$row->charid][1] .= ",".$row->cbtstart;
				$t[11][$row->abilityid][$row->charid][2] .= ",".$row->cbtend;
				//if (sizeOf(explode(",",$row->cbtstart))>sizeOf(explode(",", $row->cbtend)))
					//$p[$this->spells[$row->abilityid]->cat][$row->abilityid][$row->charid][2] .= ",0";
			}
			foreach($p as $k => $v){
				foreach($v as $ke => $va){
					foreach($va as $key => $var){
						$p[$k][$ke][$key][3] = explode(",", $p[$k][$ke][$key][1]);
						$p[$k][$ke][$key][4] = explode(",", $p[$k][$ke][$key][2]);
						asort($p[$k][$ke][$key][3]);
					}
				}
			}
			foreach($p as $k => $v){
				foreach($v as $ke => $va){
					if (!isset($t[1][$k][$ke]))
						$t[1][$k][$ke] = 0;
					if (!isset($t[2][$k][$ke]))
						$t[2][$k][$ke] = 0;
					if (!isset($t[3][$k][$ke]))
						$t[10][$k][$ke] = 0;
					foreach($va as $q => $s){
						$t[10][$k][$ke]++;
						foreach($s[3] as $key => $var){
							if ($var and $var != ""){
								if (($var>=$this->atmpts[9] and $var<=$this->atmpts[10]) 
									or ($p[$k][$ke][$q][4][$key] and ($p[$k][$ke][$q][4][$key]>=$this->atmpts[9] and $p[$k][$ke][$q][4][$key]<=$this->atmpts[10])) 
									or ($p[$k][$ke][$q][4][$key] and ($var<=$this->atmpts[9] and $p[$k][$ke][$q][4][$key]>=$this->atmpts[10]))
									or (isset($p[$k][$ke][$q][4][$key]) && $var<=$this->atmpts[9] && ($p[$k][$ke][$q][4][$key]>=$this->atmpts[9] and $p[$k][$ke][$q][4][$key]<=$this->atmpts[10])) // is the starting point before but the end point in the frame
									){
										$t[1][$k][$ke]++;
										if ($p[$k][$ke][$q][4][$key] and $p[$k][$ke][$q][4][$key]>$var){
											$t[2][$k][$ke] += ($p[$k][$ke][$q][4][$key]-$var);
										}
										if (!isset($p[$k][$ke][$q][4][$key])){
											$t[2][$k][$ke] += ($this->atmpts[10]-$var);
										}
								}
							}
						}
					}
				}
			}
		}else{
			$con = '';
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
				$con .= ' AND a.charid = "'.$this->player.'"';
			$offset = explode(",", $this->raidinfo->indprocs);
			foreach($this->db->query('SELECT a.abilityid, a.amount, a.chance FROM `tbc-raids-individual-procs` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.' ORDER BY amount') as $row){
				$cat = $this->spells[$row->abilityid]->cat;
				if ($cat>2)
					$cat = 2; 
				$t[4][$cat][$row->abilityid] += $row->chance;
				$t[1][$cat][$row->abilityid] += $row->amount;
				$t[3][$cat][$row->abilityid] = Array(1 => $this->spells[$row->abilityid]->name, 2 => $this->spells[$row->abilityid]->icon);
			}
			foreach($t[4] as $k => $v){
				foreach ($v as $ke => $va){
					$t[2][$k][$ke] = $t[1][$k][$ke]/$va;
					if ($t[2][$k][$ke]>1)
						$t[2][$k][$ke] = 1;
				}
			}
		}
		return $t;
	}
	
	private function getGraphValues($tab){
		$t = array();
		$p = array();
		$con = '';
		if ($tab){
			$p = $tab;
		}else{
			if ($this->player)
				$con = 'charid = '.$this->player.' AND ';
			$offset = explode(",", $this->raidinfo->newbuffs);
			foreach($this->db->query('SELECT * FROM `tbc-raids-newbuffs` WHERE id BETWEEN '.$offset[0].' AND '.$offset[1].' AND '.$con.'rid = '.$this->rid) as $row){
				$p[$row->abilityid][$row->charid][1] .= ",".$row->cbtstart;
				$p[$row->abilityid][$row->charid][2] .= ",".$row->cbtend;
			}
		}
		$start = 1000000000; $end = -1;
		foreach($p as $k => $v){
			foreach($v as $ke => $va){
				foreach(explode(",",$va[1]) as $var){
					if ($var && $var != "" && ($var>=$this->atmpts[9] and $var<=$this->atmpts[10])){
						if ($var<$start)
							$start = $var;
					}
				}
				foreach(explode(",",$va[2]) as $var){
					if ($var && $var != "" && ($var>=$this->atmpts[9] and $var<=$this->atmpts[10])){
						if ($var>$end)
							$end = $var;
					}
				}
			}
		}
		$space = ($end-$start)/56;
		//print $start."//".$end."//".$space."//".$this->atmpts[9];
		$time = array();
		$val = array();
		$abs = array();
		for ($i=1; $i<57; $i++){
			$time[$i] = $i*$space+$this->atmpts[9];
			$val[$i] = array();
		}
		foreach($p as $k => $v){
			foreach($v as $ke => $va){
				$temp = explode(",", $va[2]);
				$temp2 = explode(",",$va[1]);
				
				foreach($time as $key => $var){
					$count = 0;
					foreach($temp2 as $qr => $qq){
						if ($qq && $qq != ""){
							if (($qq<=($var) && $qq>=($var-$space)) or ($temp[$qr]<=($var) && $temp[$qr]>=($var-$space)))
								$count++;
						}
					}
					if (!isset($val[$key][$k]) && $count > 0)
						$val[$key][$k] = 0;
					if ($count > 0)
						$val[$key][$k] += $count;
					if (!isset($abs[$k]) && $count > 0)
						$abs[$k] = true;
				}
			}
		}
		$t[1] = $space;
		$t[2] = $val;
		$t[3] = $abs;
		return $t;
	}
	
	private function jsToAdd($tab){
		$t = $this->getGraphValues($tab);
		$content = "
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = google.visualization.arrayToDataTable([
		";
			$content .= "['Time'";
			foreach($t[3] as $key => $var){
				$content .= ", '".($r = ($this->spells[$key]) ? str_replace("'", "\'", $this->spells[$key]->name) : "Unknown")."'";
			}
			$content .= "],
			";
		foreach($t[2] as $ke => $va){
			$content .= "['".gmdate("H:i:s", $ke*$t[1]+$this->atmpts[9])."'";
			foreach($t[3] as $key => $var){
				$content .= ",".($r = ($va[$key]) ? $va[$key] : "0");
			}
			$content .= "],
			";
		}
		$content .= "
				]);
				var options = {
				  isStacked: true,
				  chartArea: {top: 25,right: 20,height: '70%', width: '92%'},
				  backgroundColor: {'fill': 'transparent' },
				  hAxis: {textStyle:{color: '#FFF'}},
				  vAxis: {textStyle:{color: '#FFF'},viewWindow: {min:0}},
				};

				var chart = new google.visualization.SteppedAreaChart(document.getElementById('graph'));

				chart.draw(data, options);
			}
		";
		return $content;
	}
	
	public function content(){
		if ($this->mode==0){
			$content = $this->getSame(1);
			$this->addJs($this->jsToAdd($table[11]));
		}else{
			$content = $this->getSame(1, true);
		}
		$table = $this->getTable();
		$content .= '
			<script>function Toggle(id, elem){for (var i=0; i<elem.length; i++){ document.getElementById(elem[i]).style.display = "none"; document.getElementById("n"+elem[i]).style.color = "#fff"; }; document.getElementById(id).style.display = "block"; document.getElementById("n"+id).style.color = "#f28f45";}</script>
		';
		$content .= '
			<section class="ttitle newmargin semibig raidcomp">
				<ul>
		';
		if ($this->mode==0){
			$content .= '
					<li class="sel" id="ndmg" onclick="Toggle(\'dmg\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\', \'seal\', \'misc\']);">Offensive</li>
					<li id="ndef" onclick="Toggle(\'def\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\', \'seal\', \'misc\']);">Defensive</li>
					<li id="nhps" onclick="Toggle(\'hps\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\', \'seal\', \'misc\']);">Healing</li>
					<li id="nmov" onclick="Toggle(\'mov\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\', \'seal\', \'misc\']);"">Movement</li>
					<li id="nraid" onclick="Toggle(\'raid\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\', \'seal\', \'misc\']);"">Raid</li>
					<li id="nseal" onclick="Toggle(\'seal\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\', \'seal\', \'misc\']);"">Seals & Stances</li>
					<li id="nmisc" onclick="Toggle(\'misc\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\', \'seal\', \'misc\']);"">Miscellaneous</li>
			';
		}else{
			$content .= '
					<li class="sel" id="ndmg" onclick="Toggle(\'dmg\', [\'def\', \'dmg\']);">Offensive</li>
					<li id="ndef" onclick="Toggle(\'def\', [\'def\', \'dmg\']);">Defensive</li>
			';
		}
		$content .= '
				</ul>
			</section>
			<section class="table tees">
		';
		if ($this->mode == 0){
			$content .= '
				<div id="dmg">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th>Count</th>
								<th>Uptime</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
			arsort($table[1][1]);
			foreach ($table[1][1] as $key => $var){
				if ($var>0){
					//print $table[2][1][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[3][1][$key])." // ".$table[3][1][$key]."<br />";
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://tbc-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][1][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][1][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}TBC/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
						</tr>
					';
				$count++;
				}
			}
			$content .= '
						</tbody>
					</table>
				</div>
				<div id="def">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th>Count</th>
								<th>Uptime</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
			arsort($table[1][5]);
			foreach ($table[1][5] as $key => $var){
				if ($var>0){
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://tbc-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][5][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][5][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}TBC/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
						</tr>
					';
				$count++;
				}
			}
			$content .= '
						</tbody>
					</table>
				</div>
				<div id="hps">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th>Count</th>
								<th>Uptime</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
			arsort($table[1][2]);
			foreach ($table[1][2] as $key => $var){
				if ($var>0){
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://tbc-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][2][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][2][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}TBC/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
						</tr>
					';
				$count++;
				}
			}
			$content .= '
						</tbody>
					</table>
				</div>
				<div id="mov">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th>Count</th>
								<th>Uptime</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
			arsort($table[1][6]);
			foreach ($table[1][6] as $key => $var){
				if ($var>0){
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://tbc-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][6][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][6][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}TBC/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
						</tr>
					';
				$count++;
				}
			}
			$content .= '
						</tbody>
					</table>
				</div>
				<div id="raid">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th>Count</th>
								<th>Uptime</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
			arsort($table[1][3]);
			foreach ($table[1][3] as $key => $var){
				if ($var>0){
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://tbc-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][3][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][3][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}TBC/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
						</tr>
					';
				$count++;
				}
			}
			$content .= '
						</tbody>
					</table>
				</div>
				<div id="seal">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th>Count</th>
								<th>Uptime</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
			arsort($table[1][7]);
			foreach ($table[1][7] as $key => $var){
				if ($var>0){
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://tbc-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][7][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][7][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}TBC/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
						</tr>
					';
				$count++;
				}
			}
			$content .= '
						</tbody>
					</table>
				</div>
				<div id="misc">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th>Count</th>
								<th>Uptime</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
			arsort($table[1][4]);
			foreach ($table[1][4] as $key => $var){
				if ($var>0){
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://tbc-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][4][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][4][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}TBC/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
						</tr>
					';
				$count++;
				}
			}
			$content .= '
						</tbody>
					</table>
				</div>
			';
		}else{
			$content .= '
				<div id="dmg">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th>Count</th>
								<th>Chance</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
			arsort($table[1][1]);
			foreach ($table[1][1] as $key => $var){
				$content .= '
					<tr>
						<td class="count">'.$count.'</td>
						<td><img src="{path}Database/icons/small/'.$table[3][1][$key][2].'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://tbc-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$table[3][1][$key][1].'</a></td>
						<td>'.$this->mnReadable($var).'</td>
						<td>'.round(100*$table[2][1][$key], 2).'%</td>
						<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}TBC/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
					</tr>
				';
				$count++;
			}
			$content .= '
						</tbody>
					</table>
				</div>
				<div id="def">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th>Count</th>
								<th>Chance</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
			arsort($table[1][2]);
			foreach ($table[1][2] as $key => $var){
				$content .= '
					<tr>
						<td class="count">'.$count.'</td>
						<td><img src="{path}Database/icons/small/'.$table[3][2][$key][2].'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://tbc-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$table[3][2][$key][1].'</a></td>
						<td>'.$this->mnReadable($var).'</td>
						<td>'.round(100*$table[2][2][$key], 2).'%</td>
						<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}TBC/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
					</tr>
				';
				$count++;
			}
			$content .= '
						</tbody>
					</table>
				</div>
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