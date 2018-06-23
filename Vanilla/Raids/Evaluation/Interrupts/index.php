<?php
require(dirname(__FILE__)."/../Template.php");

class Home extends Template{
	
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
		if ($this->tarid)
			$con .= ' AND a.npcid = '.$this->tarid;
		if ($this->player){
			$con .= ' AND a.charid = "'.$this->player.'"';
			$offset = explode(",", $this->raidinfo->indint);
			foreach($this->db->query('SELECT a.id, a.npcid, a.cbt, a.charid,a.abilityid FROM `v-raids-individual-interrupts` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con) as $row){
				$t[$row->id] = $row;
			}
		}else{
			$offset = explode(",", $this->raidinfo->indintm);
			foreach($this->db->query('SELECT a.amount, a.targetid, a.abilityid, a.npcid FROM `v-raids-interruptsmissed` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.' ORDER BY a.amount DESC') as $row){
				$t[7] += $row->amount;
				$t[8][$row->npcid][$row->targetid][$row->abilityid] += $row->amount;
				if (!$t[9] || $t[9]<$t[8][$row->npcid][$row->targetid][$row->abilityid])
					$t[9] = $t[8][$row->npcid][$row->targetid][$row->abilityid];
				
				$t[4] += $row->amount;
				$t[5][$row->abilityid] += $row->amount;
				if (!$t[6] || $t[6]<$t[5][$row->abilityid])
					$t[6] = $t[5][$row->abilityid];
			}
			$offset = explode(",", $this->raidinfo->indint);
			foreach($this->db->query('SELECT a.id, a.charid, a.abilityid, a.cbt FROM `v-raids-individual-interrupts` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.' ORDER BY a.cbt') as $row){
				$t[10] += 1;
				$t[11][$row->id] = $row;
				
				if (isset($t[1]))
					$t[1]++;
				else
					$t[1] = 1;
				if (isset($t[2][$row->charid]))
					$t[2][$row->charid]++;
				else
					$t[2][$row->charid] = 1;
				if (!$t[3] || $t[3]<$t[2][$row->charid])
					$t[3] = $t[2][$row->charid];
			}
			arsort($t[2]);
			arsort($t[5]);
		}
		return $t;
	}
	
	public function content(){
		$content = $this->getSame(99, true);
		$table = $this->getTable();
		if ($this->player){
		$content .= '
			<section class="ttitle semibig newmargin">
				Successful kicks
			</section>
			<section class="centredNormal tees">
				<table cellspacing="0">
					<thead>
						<tr>
							<th class="count">#</th>
							<th>Time</th>
							<th>Name</th>
							<th>Spell</th>
						</tr>
					</thead>
					<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
		foreach ($table as $key => $var){
			$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td>'.gmdate("H:i:s", $var->cbt).'</td>
							<td><img src="{path}Database/classes/c'.$this->participants[4][$var->charid]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$var->charid]->classid].'" href="{path}Vanilla/Raids/Evaluation/Interrupts/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$var->charid.'&sel='.$this->sel.'&pet='.$this->pet.'">'.$this->participants[4][$var->charid]->name.'</a></td>
							<td><img src="{path}Database/icons/small/'.$this->spells[$var->abilityid]->icon.'.jpg" /><a rel="spell='.$var->abilityid.'" href="https://vanilla-twinhead.twinstar.cz/?spell='.$var->abilityid.'" target="_blank">'.$this->spells[$var->abilityid]->name.'</a></td>
						</tr>
			';
			$count++;
		}
		$content .= '
					</tbody>
				</table>
			</section>
		';
		}else{
		$content .= '
			<script>function Toggle(id, elem){for (var i=0; i<elem.length; i++){ document.getElementById(elem[i]).style.display = "none"; document.getElementById("n"+elem[i]).style.color = "#fff"; }; document.getElementById(id).style.display = "block"; document.getElementById("n"+id).style.color = "#f28f45";}</script>
		';
		$content .= '
			<section class="ttitle raidcomp semibig newmargin">
				<ul>
					<li class="sel" id="nsko" onclick="Toggle(\'sko\', [\'sko\', \'ski\', \'mko\', \'mki\']);">Successful kicks overall</li>
					<li id="nski" onclick="Toggle(\'ski\', [\'sko\', \'ski\', \'mko\', \'mki\']);">Successful kicks individual</li>
					<li id="nmko" onclick="Toggle(\'mko\', [\'sko\', \'ski\', \'mko\', \'mki\']);">Missed kicks overall</li>
					<li id="nmki" onclick="Toggle(\'mki\', [\'sko\', \'ski\', \'mko\', \'mki\']);">Missed kicks individual</li>
				</ul>
			</section>
			<section class="table tees">
				<div id="sko">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th colspan="3">Amount</th>
								<th class="fill"></th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
		foreach ($table[2] as $key => $var){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								<td><img src="{path}Database/classes/c'.$this->participants[4][$key]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$key]->classid].'" href="{path}Vanilla/Raids/Evaluation/Interrupts/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$key.'&sel='.$this->sel.'&pet='.$this->pet.'">'.$this->participants[4][$key]->name.'</a></td>
								<td>'.round(100*$var/$table[1], 2).'%</td>
								<td><div class="amount-sbar border-round"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$key]->classid].'" style="width: '.(100*$var/$table[3]).'%;"></div></div></td>
								<td>'.$this->mnReadable($var).'</td>
							</tr>
			';
			$count++;
		}
		$content .= '
						</tbody>
					</table>
				</div>
				<div id="ski">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Time</th>
								<th>Name</th>
								<th>Spell</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
		foreach ($table[11] as $key => $var){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								<td>'.gmdate("H:i:s", $var->cbt).'</td>
								<td><img src="{path}Database/classes/c'.$this->participants[4][$var->charid]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$var->charid]->classid].'" href="{path}Vanilla/Raids/Evaluation/Interrupts/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$var->charid.'&sel='.$this->sel.'&pet='.$this->pet.'">'.$this->participants[4][$var->charid]->name.'</a></td>
								<td><img src="{path}Database/icons/small/'.$this->spells[$var->abilityid]->icon.'.jpg" /><a rel="spell='.$var->abilityid.'" href="https://vanilla-twinhead.twinstar.cz/?spell='.$var->abilityid.'" target="_blank">'.$this->spells[$var->abilityid]->name.'</a></td>
							</tr>
			';
			$count++;
		}
		$content .= '
						</tbody>
					</table>
				</div>
				<div id="mki">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th>Target</th>
								<th>Spell</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
		foreach ($table[8] as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								<td><img src="{path}Database/type/'.$this->npcsById[$k]->family.'.png" />'.$this->npcsById[$k]->name.'</td>
								<td><img src="{path}Database/classes/c'.$this->participants[4][$ke]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$ke]->classid].'" href="{path}Vanilla/Character/'.$raidinfo->sname.'/'.$this->participants[4][$ke]->name.'/0">'.$this->participants[4][$ke]->name.'</a></td>
								<td><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a rel="spell='.$key.'" href="https://vanilla-twinhead.twinstar.cz/?spell='.$this->spells[$key]->realspellid.'" target="_blank">'.$this->spells[$key]->name.'</a></td>
								<td>'.$this->mnReadable($var).'</td>
							</tr>
			';
			$count++;
				}
			}
		}
		$content .= '
						</tbody>
					</table>
				</div>
				<div id="mko">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th class="nchar">Name</th>
								<th>Amount</th>
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
								<td class="nchar"><img src="{path}Database/icons/small/'.$this->spells[$key]->icon.'.jpg" /><a rel="spell='.$key.'" href="https://vanilla-twinhead.twinstar.cz/?spell='.$this->spells[$key]->realspellid.'" target="_blank">'.$this->spells[$key]->name.'</a></td>
								<td>'.round(100*$var/$table[4], 2).'%</td>
								<td><div class="amount-sbar border-round"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$key]->classid].'" style="width: '.(100*$var/$table[6]).'%;"></div></div></td>
								<td>'.$this->mnReadable($var).'</td>
							</tr>
			';
			$count++;
		}
		$content .= '
						</tbody>
					</table>
				</div>
			</section>
		';
		}
		$content .= '
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $rid, $attempts, $player, $attemptid, $pet, $mode, $events, $npcid){
		parent::__construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid);
	}
}

new Home($db, __DIR__, $_GET["rid"], $_GET["attempts"], $_GET["player"], $_GET["sel"], $_GET["pet"], $_GET["mode"], $_GET["events"], $_GET["tarid"]);

?>