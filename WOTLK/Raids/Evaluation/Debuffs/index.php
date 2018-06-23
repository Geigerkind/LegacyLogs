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
	
	private function getUptime($a){
		if (is_nan($a))
			return 0;
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
		$offset = explode(",", $this->raidinfo->newdebuffs);
		foreach($this->db->query('SELECT * FROM `wotlk-raids-newdebuffs` WHERE id BETWEEN '.$offset[0].' AND '.$offset[1].' AND '.$con.'rid = '.$this->rid) as $row){
			$p[$this->spells[$row->abilityid]->type][$row->abilityid][$row->charid][1] .= ",".$row->cbtstart;
			$p[$this->spells[$row->abilityid]->type][$row->abilityid][$row->charid][2] .= ",".$row->cbtend;
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
			if ($this->tarid)
			$con .= ' AND a.npcid = '.$this->tarid;
			$offset = explode(",", $this->raidinfo->inddbp);
			foreach($this->db->query('SELECT a.abilityid, a.amount FROM `wotlk-raids-individual-debuffsbyplayer` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.' ORDER BY a.amount') as $row){
				$type = $this->spells[$row->abilityid]->type;
				$this->average($t[2][$type][$row->abilityid], $row->active, $t[1][$type][$row->abilityid], $row->amount);
				$t[1][$type][$row->abilityid] += $row->amount;
				$t[3][$type][$row->abilityid] = Array(1 => $this->spells[$row->abilityid]->name, 2 => $this->spells[$row->abilityid]->icon);
			}
		}
		return $t;
	}
	
	private function getGraphValues($tab){
		$t = array();
		$p = array();
		if ($tab){
			$p = $tab;
		}else{
		$con = '';
			if ($this->player)
				$con = 'charid = '.$this->player.' AND ';
			$offset = explode(",", $this->raidinfo->newdebuffs);
			foreach($this->db->query('SELECT * FROM `wotlk-raids-newdebuffs` WHERE id BETWEEN '.$offset[0].' AND '.$offset[1].' AND '.$con.'rid = '.$this->rid) as $row){
				$p[$row->abilityid][$row->charid][1] .= ",".$row->cbtstart;
				$p[$row->abilityid][$row->charid][2] .= ",".$row->cbtend;
			}
		}
		$start = 0; $end = 0;
		foreach($p as $k => $v){
			foreach($v as $ke => $va){
				foreach(explode(",",$va[1]) as $var){
					if ($var && $var != "" && ($var>=$this->atmpts[9] and $var<=$this->atmpts[10])){
						if ($start == 0 or $var<$start)
							$start = $var;
					}
				}
				foreach(explode(",",$va[2]) as $var){
					if ($var && $var != "" && ($var>=$this->atmpts[9] and $var<=$this->atmpts[10])){
						if ($end == 0 or $var>$end)
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
		if ($this->mode==1){
			$content = $this->getSame(2, true);
		}else{
			$content = $this->getSame(2, false);
			$this->addJs($this->jsToAdd());
		}
		$table = $this->getTable();
		$content .= '
			<script>function Toggle(id, elem){for (var i=0; i<elem.length; i++){ document.getElementById(elem[i]).style.display = "none"; document.getElementById("n"+elem[i]).style.color = "#fff"; }; document.getElementById(id).style.display = "block"; document.getElementById("n"+id).style.color = "#f28f45";}</script>
		';
		$content .= '
			<section class="ttitle newmargin semibig raidcomp">
				<ul>
					<li class="sel" id="ndmg" onclick="Toggle(\'dmg\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\']);">Physical</li>
					<li id="ndef" onclick="Toggle(\'def\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\']);">Magic</li>
					<li id="nhps" onclick="Toggle(\'hps\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\']);">Poison</li>
					<li id="nmov" onclick="Toggle(\'mov\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\']);"">Curse</li>
					<li id="nraid" onclick="Toggle(\'raid\', [\'def\', \'hps\', \'dmg\', \'mov\', \'raid\']);"">Disease</li>
				</ul>
			</section>
			<section class="table tees">
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
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][1][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][1][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}WOTLK/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
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
			arsort($table[1][2]);	
			foreach ($table[1][2] as $key => $var){
				if ($var>0){
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][2][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][2][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}WOTLK/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
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
			arsort($table[1][3]);
			foreach ($table[1][3] as $key => $var){
				if ($var>0){
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][3][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][3][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}WOTLK/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
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
			arsort($table[1][5]);
			foreach ($table[1][5] as $key => $var){
				if ($var>0){
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][5][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][5][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}WOTLK/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
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
			arsort($table[1][4]);
			foreach ($table[1][4] as $key => $var){
				if ($var>0){
					$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$this->spells[$key]->name.'</a></td>
							<td>'.$this->mnReadable($var).'</td>
							<td>'.$this->getUptime(round(100*$table[2][4][$key]/(($this->atmpts[10]-$this->atmpts[9])*$table[10][4][$key]), 2)).'%</td>
							<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}WOTLK/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
						</tr>
					';
					$count++;
				}
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
	
	public function __construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid){
		$this->addJsLink("https://www.gstatic.com/charts/loader.js", true);
		parent::__construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid);
	}
}

new Home($db, __DIR__, $_GET["rid"], $_GET["attempts"], $_GET["player"], $_GET["sel"], $_GET["mode"], $_GET["pet"], $_GET["events"], $_GET["tarid"]);

?>