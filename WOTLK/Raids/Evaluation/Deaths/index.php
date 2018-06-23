<?php
require(dirname(__FILE__)."/../Template.php");

class Home extends Template{
	private $typeById = array(
		0 => "Hit",
		1 => "Crit",
		2 => "Crush"
	);
	private $buffer = array();
	private $byAmount = array();
	private $sum = 0;
	private $max = 0;
	
	private function getTable(){
		$t = array();
		if ($this->attempts){
			$con = ' c.id IN ('.$this->attempts.')';
			if ($this->sel)
				$con = 'c.id = "'.$this->sel.'"';
		}elseif ($this->sel){
			$con = ' c.id = "'.$this->sel.'"';
		}else{
			$con = ' c.rid = "'.$this->rid.'"';
		}
		if ($this->player)
			$con .= ' AND b.charid = "'.$this->player.'"';
		if ($this->tarid)
			$con .= ' AND a.flagid = '.$this->tarid;
		if ($this->player){
			$offset = explode(",", $this->raidinfo->deaths);
			foreach($this->db->query('SELECT b.deathid, a.attemptid, a.flagid as kblower, a.flag kblowerflag, b.id, b.flagid, b.flag, b.dmg, b.heal, b.type, b.abilityid, b.cbt, c.time FROM `wotlk-raids-deaths` a LEFT JOIN `wotlk-raids-individual-death` b ON a.id = b.deathid LEFT JOIN `wotlk-raids-attempts` c ON a.attemptid = c.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND c.rdy = 1 AND '. $con) as $row){
				$name = ($row->kblowerflag == 1) ? $this->npcsById[$row->kblower]->name : $this->participants[4][$row->kblower]->name;
				$t[$row->deathid][$row->attemptid][(isset($name)) ? $name : "Unknown"][$row->id] = $row;
			}
		}else{
			$offset = explode(",", $this->raidinfo->deaths);
			foreach($this->db->query('SELECT a.id, c.id AS attemptid, a.killingblow, a.cbt, b.abilityid, b.dmg, b.heal, b.id as did, b.charid, a.flagid FROM `wotlk-raids-deaths` a JOIN `wotlk-raids-individual-death` b ON a.id = b.deathid LEFT JOIN `wotlk-raids-attempts` c ON a.attemptid = c.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND c.rdy = 1 AND '.$con.' ORDER BY a.cbt, b.id') as $row){
				if (!$this->buffer[$row->id]){
					$this->buffer[$row->id] = 0;
					if (!isset($this->byAmount[$row->charid]))
						$this->byAmount[$row->charid] = 1;
					else
						$this->byAmount[$row->charid]++;
					$this->sum++;
					if ($this->byAmount[$row->charid]>$this->max) {
						$this->max = $this->byAmount[$row->charid];
					}
				}
				if ($this->buffer[$row->id]<3){
					$t[$row->id][$row->attemptid][$row->charid][$row->did] = array("kblow" => $row->killingblow, "abilityid" => $row->abilityid, "cbt" => $row->cbt, "dmg" => $row->dmg, "heal" => $row->heal, "flagid" => $row->flagid);
					$this->buffer[$row->id]++;
				}
			}
		}
		return $t;
	}
	
	public function content(){
		$content = $this->getSame(100, true);
		$table = $this->getTable();
		if ($this->player){
			$content .= '
				<section class="ttitle semibig newmargin raidcomp">
					<ul>
						<li id="nosel">Deaths by</li>
			';
			$elem = '';
			$shorten = false;
			if (sizeOf($table)>4){
				$shorten = true;
			}
			foreach($table as $k => $v){
		foreach($v as $ke => $va){
			foreach($va as $key => $var){
				if ($key){
					$content .= '
						<li id="n'.$k.'"'.($r = ($elem == '') ? ' class="sel"' : '').' onclick="Toggle(\''.$k.'\');">'.($r = ($shorten) ? substr($key, 0, 4) : $key).'</li>
					';
					$elem .= ($r = ($elem != '') ? ',' : '').'"'.$k.'"';
				}
			}
			}}
			$content .= '
					</ul>
				</section>
				<script>function Toggle(id){elem = ['.$elem.']; for (var i=0; i<elem.length; i++){ document.getElementById(elem[i]).style.display = "none"; document.getElementById("n"+elem[i]).style.color = "#fff"; }; document.getElementById(id).style.display = "block"; document.getElementById("n"+id).style.color = "#f28f45";}</script>
				<section class="table tees">
			';
			foreach($table as $k => $v){
		foreach($v as $ke => $va){
			foreach($va as $key => $var){
				if ($key){
					$content .= '
					<div class="ibox" id="'.$k.'">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th class="num">Time</th>
								<th class="num">CB-Time</th>
								<th class="vstring">Cause</th>
								<th class="vstring">Ability</th>
								<th class="num">Type</th>
								<th class="num">Dmg taken</th>
								<th class="num">Healing</th>
								<th class="fill">&nbsp;</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
			';
			$count=1;
		foreach($var as $keys => $vars){
			$npcname = ($vars->flag == 1) ? $this->npcsById[$vars->flagid]->name : $this->participants[4][$vars->flagid]->name;
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								<td class="num">'.date("H:i", $vars->time).'</td>
								<td class="num">'.$vars->cbt.'s</td>
								<td class="vstring color-'.$this->classById[$this->participants[4][$vars->flagid]->classid].'"><img src="'.($r = ($this->participants[4][$vars->flagid]) ? '{path}Database/classes/c'.$this->participants[4][$vars->flagid]->classid.'.png' : '{path}Database/type/'.$this->npcsById[$vars->flagid]->family.'.png').'" />'.($r = (isset($npcname)) ? $npcname : "Unknown").'</td>
								<td class="vstring"><img src="{path}Database/icons/small/'.$this->spells[$vars->abilityid]->icon.'.jpg" /><a rel="spell='.$vars->abilityid.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$vars->abilityid.'">'.$this->spells[$vars->abilityid]->name.'</a></td>
								<td class="num">'.$this->typeById[$vars->type].'</td>
								<td class="num neg">-'.$this->mnReadable($vars->dmg).'</td>
								<td class="num pos">+'.$this->mnReadable($vars->heal).'</td>
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
			}}}
			$content .= '
				</section>
			';
		}else{
			$content .= '
				<section class="ttitle semibig newmargin raidcomp">
					<ul>
						<li id="nosel">Deaths (<span class="sel">'.$this->sum.'</span>)</li>
						<li class="sel" id="ntime" onclick="Toggle(\'time\');">By time</li>
						<li id="namount" onclick="Toggle(\'amount\');">By Amount</li>
					</ul>
				</section>
				<script>function Toggle(id){elem = ["time", "amount"]; for (var i=0; i<elem.length; i++){ document.getElementById(elem[i]).style.display = "none"; document.getElementById("n"+elem[i]).style.color = "#fff"; }; document.getElementById(id).style.display = "block"; document.getElementById("n"+id).style.color = "#f28f45";}</script>
				<section class="table tees">
					<table cellspacing="0" id="time">
						<thead>
							<tr>
								<th class="count">#</th>
								<th class="num">Time</th>
								<th class="vvstring">Name</th>
								<th class="sstring">Cause</th>
								<th class="sstring">Killing blow</th>
								<th class="num">Over</th>
								<th class="lstring">Last three hits</th>
								<th class="num">Dmg taken</th>
								<th class="num">Healing</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
			';
			$count=1;
		foreach ($table as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					$abilities = array();
					$abilities[2] = array();
					foreach($var as $keys => $vars){
						$abilities[1] = $vars["kblow"];
						array_push($abilities[2], $vars["abilityid"]);
						if (!isset($abilities[3]))
							$abilities[3] = $vars["cbt"];
						$abilities[4] += $vars["dmg"];
						$abilities[5] += $vars["heal"];
						if (!$abilities[6] || $vars["cbt"]<$abilities[6])
							$abilities[6] = $vars["cbt"];
						if (!$abilities[7] || $vars["cbt"]>$abilities[7])
							$abilities[7] = $vars["cbt"];
						$abilities[8] = $vars["flagid"];
					}
					$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								<td class="num">'.gmdate("H:i:s", $abilities[3]).'</td>
								<td class="vvstring"><img src="{path}Database/classes/c'.$this->participants[4][$key]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$key]->classid].'" href="{path}WOTLK/Raids/Evaluation/Deaths/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$key.'&sel='.$this->sel.'">'.$this->participants[4][$key]->name.'</a></td>
								<td class="sstring"><img src="'.($r = ($this->npcsById[$abilities[8]]) ? '{path}Database/type/'.$this->npcsById[$abilities[8]]->family.'.png' : '{path}Database/classes/c'.$this->participants[4][$abilities[8]]->classid.'.png' ).'" />'.($r = ($this->npcsById[$abilities[8]]) ? $this->npcsById[$abilities[8]]->name : $this->participants[4][$abilities[8]]->name).'</td>
								<td class="sstring"><img src="{path}Database/icons/small/'.$this->spells[$abilities[1]]->icon.'.jpg" /><a target="_blank" rel="spell='.$abilities[1].'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$abilities[1].'">'.$this->spells[$abilities[1]]->name.'</a></td>
								<td class="num">'.($abilities[7]-$abilities[6]).'s</td>
								<td class="lstring">
					';
					$next = false;
					foreach($abilities[2] as $keys => $vars){
						$content .= ($r = ($next) ? ", " : "").'<a target="_blank" rel="spell='.$vars.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$vars]->id.'">'.$this->spells[$vars]->name.'</a>';
						$next = true;
					}
					$content .= '
								</td>
								<td class="num neg">-'.$this->mnReadable($abilities[4]).'</td>
								<td class="num pos">+'.$this->mnReadable($abilities[5]).'</td>
							</tr>
					
					';
				$count++;
				}
			}
		}
		$content .= '
						</tbody>
					</table>
					<table cellspacing="0" id="amount">
						<thead>
							<tr>
								<th class="count">#</th>
								<th class="char">Name</th>
								<th class="amount">Amount</th>
								<th class="fill">&nbsp;</th>
								<th class="fill">&nbsp;</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
		arsort($this->byAmount);
			$count=1;
		foreach($this->byAmount as $k => $v){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								<td class="char"><img src="{path}Database/classes/c'.$this->participants[4][$k]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$k]->classid].'" href="{path}WOTLK/Raids/Evaluation/Deaths/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$k.'&sel='.$this->sel.'">'.$this->participants[4][$k]->name.'</a></td>
								<td>'.round(100*$v/$this->sum, 2).'%</td>
								<td><div class="amount-sbar border-round"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$k]->classid].'" style="width: '.(100*$v/$this->max).'%;"></div></div></td>
								<td>'.$this->mnReadable($v).'</td>
							</tr>
			';
				$count++;
		}
		$content .= '
						</tbody>
					</table>
				</section>
			</div>
			';		
		}
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $rid, $attempts, $player, $attemptid, $pet, $mode, $events, $npcid){
		parent::__construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid);
	}
}

new Home($db, __DIR__, $_GET["rid"], $_GET["attempts"], $_GET["player"], $_GET["sel"], $_GET["pet"], $_GET["mode"], $_GET["events"], $_GET["tarid"]);

?>