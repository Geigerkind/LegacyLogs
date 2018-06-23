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
	
	private function getUptime($a){
		if ($a > 100)
			return 100;
		return $a;
	}
	
	// spells can be removed because it is being executed in template
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
		if ($this->player)
			$con .= ' AND a.charid = "'.$this->player.'"';
		if ($this->tarid)
			$con .= ' AND a.tarid = '.$this->tarid;
		if ($this->player){
			$offset = explode(",", $this->raidinfo->casts);
			foreach($this->db->query('SELECT a.abilityid, a.amount, a.tarid, a.attemptid FROM `wotlk-raids-casts` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.' ORDER BY a.amount DESC') as $row){
				$t[1][$row->abilityid][$row->tarid] += $row->amount;
				$t[2][$row->abilityid][$row->tarid] .= $row->attemptid.',';
				$t[3][$row->abilityid][$row->tarid] = Array(1 => $this->spells[$row->abilityid]->name, 2 => $this->spells[$row->abilityid]->icon, 3 => $this->npcsById[$row->tarid]->name);
				$t[4][$row->abilityid] += $row->amount;
				$t[7] += $row->amount;
				$t[6][$row->abilityid] = Array(1 => $this->spells[$row->abilityid]->name, 2 => $this->spells[$row->abilityid]->icon, 3 => $this->npcsById[$row->tarid]->name);
				$t[5][$row->tarid] += $row->amount;
				$t[8][$row->tarid] = Array(1 => $this->spells[$row->abilityid]->name, 2 => $this->spells[$row->abilityid]->icon, 3 => $this->npcsById[$row->tarid]->name);
				$t[9][$row->tarid] .= $row->attemptid.',';
			} 
			arsort($t[4]);
			arsort($t[5]);
		}else{
			$offset = explode(",", $this->raidinfo->casts);
			foreach($this->db->query('SELECT a.abilityid, a.amount FROM `wotlk-raids-casts` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.' ORDER BY a.amount DESC') as $row){
				$t[1][$this->spells[$row->abilityid]->type][$row->abilityid] += $row->amount;
				$t[3][$this->spells[$row->abilityid]->type][$row->abilityid] = Array(1 => $this->spells[$row->abilityid]->name, 2 => $this->spells[$row->abilityid]->icon);
			}
		}
		return $t;
	}
	
	public function content(){
		$content = $this->getSame(999, true);
		$table = $this->getTable();
		$content .= '
			<script>function Toggle(id, elem){for (var i=0; i<elem.length; i++){ document.getElementById(elem[i]).style.display = "none"; document.getElementById("n"+elem[i]).style.color = "#fff"; }; document.getElementById(id).style.display = "block"; document.getElementById("n"+id).style.color = "#f28f45";}</script>
		';
		if ($this->player){
		$content .= '
			<section class="ttitle newmargin semibig raidcomp">
				<ul>
					<li id="nosel">Casts</li>
					<li class="sel" id="ndmg" onclick="Toggle(\'dmg\', [\'def\', \'hps\', \'dmg\']);">by ability</li>
					<li id="ndef" onclick="Toggle(\'def\', [\'def\', \'hps\', \'dmg\']);">by target</li>
					<li id="nhps" onclick="Toggle(\'hps\', [\'def\', \'hps\', \'dmg\']);">by abillity and target</li>
				</ul>
			</section>
			<section class="table tees">
				<div id="dmg">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th colspan="3">Amount</th>
								<th class="fill">&nbsp;</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
		foreach ($table[4] as $key => $var){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								<td><img src="{path}Database/icons/small/'.$table[6][$key][2].'.jpg" /><a rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$table[6][$key][1].'</a></td>
								<td>'.round(100*$var/$table[7], 2).'%</td>
								<td><div class="amount-sbar border-round"><div class="amount-sbar-progress bgcolor-" style="width: '.(100*$var/$table[7]).'%;"></div></div></td>
								<td>'.$this->mnReadable($var).'</td>
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
								<th colspan="3">Amount</th>
								<th class="fill">&nbsp;</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
		foreach ($table[5] as $key => $var){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								<td><img src="img/c0.png" /><a href="{path}WOTLK/Raids/Evaluation/Casts/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$table[9][$key].'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode='.$this->mode.'">'.$table[8][$key][3].'</a></td>
								<td>'.round(100*$var/$table[7], 2).'%</td>
								<td><div class="amount-sbar border-round"><div class="amount-sbar-progress bgcolor-" style="width: '.(100*$var/$table[7]).'%;"></div></div></td>
								<td>'.$this->mnReadable($var).'</td>
							</tr>
			';
				$count++;
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
								<th>Ability</th>
								<th>Target</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
			foreach($table[1] as $key => $var){
				foreach($var as $k => $v){
					$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								<td><img src="{path}Database/icons/small/'.$table[3][$key][$k][2].'.jpg" /><a rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$table[3][$key][$k][1].'</a></td>
								<td><img src="img/c0.png" /><a href="{path}WOTLK/Raids/Evaluation/Casts/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$table[2][$key][$k].'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode='.$this->mode.'">'.$table[3][$key][$k][3].'</a></td>
								<td>'.$this->mnReadable($v).'</td>
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
		}else{
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
				$content .= '
					<tr>
						<td class="count">'.$count.'</td>
						<td><img src="{path}Database/icons/small/'.$table[3][1][$key][2].'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$table[3][1][$key][1].'</a></td>
						<td>'.$this->mnReadable($var).'</td>
						<td>'.$this->getUptime(round(100*$table[2][1][$key]/$this->atmpts[1], 2)).'%</td>
						<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}WOTLK/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
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
								<th>Uptime</th>
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
						<td><img src="{path}Database/icons/small/'.$table[3][2][$key][2].'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$table[3][2][$key][1].'</a></td>
						<td>'.$this->mnReadable($var).'</td>
						<td>'.$this->getUptime(round(100*$table[2][2][$key]/$this->atmpts[1], 2)).'%</td>
						<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}WOTLK/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
					</tr>
				';
				$count++;
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
				$content .= '
					<tr>
						<td class="count">'.$count.'</td>
						<td><img src="{path}Database/icons/small/'.$table[3][3][$key][2].'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$table[3][3][$key][1].'</a></td>
						<td>'.$this->mnReadable($var).'</td>
						<td>'.$this->getUptime(round(100*$table[2][3][$key]/$this->atmpts[1], 2)).'%</td>
						<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}WOTLK/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
					</tr>
				';
				$count++;
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
				$content .= '
					<tr>
						<td class="count">'.$count.'</td>
						<td><img src="{path}Database/icons/small/'.$table[3][5][$key][2].'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$table[3][5][$key][1].'</a></td>
						<td>'.$this->mnReadable($var).'</td>
						<td>'.$this->getUptime(round(100*$table[2][5][$key]/$this->atmpts[1], 2)).'%</td>
						<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}WOTLK/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
					</tr>
				';
				$count++;
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
				$content .= '
					<tr>
						<td class="count">'.$count.'</td>
						<td><img src="{path}Database/icons/small/'.$table[3][4][$key][2].'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.$table[3][4][$key][1].'</a></td>
						<td>'.$this->mnReadable($var).'</td>
						<td>'.$this->getUptime(round(100*$table[2][4][$key]/$this->atmpts[1], 2)).'%</td>
						<td>'.($r = ($this->spells[$key]->sourceid==0) ? 'Source not set. <a href="{path}WOTLK/SetSpellSource/?id='.$key.'">Set source.' : $this->sourceById[$this->spells[$key]->sourceid]).'</td>
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
		}
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid){
		parent::__construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid);
	}
}

new Home($db, __DIR__, $_GET["rid"], $_GET["attempts"], $_GET["player"], $_GET["sel"], $_GET["mode"], $_GET["pet"], $_GET["events"], $_GET["tarid"]);

?>