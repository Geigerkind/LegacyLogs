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
		if ($this->player)
			$con .= ' AND a.charid = "'.$this->player.'"';
		if ($this->tarid)
			$con .= ' AND a.targetid = '.$this->tarid;
		$offset = explode(",", $this->raidinfo->dispels);
		foreach($this->db->query('SELECT a.charid, a.abilityid, a.amount, a.targetid, c.name, c.icon FROM `tbc-raids-dispels` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id LEFT JOIN tbc_spells c ON a.abilityid = c.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.($r = ($this->mode) ? 'c.type = "'.$this->mode.'" AND' : '').' '.$con.' ORDER BY a.amount DESC;') as $row){
			$t[1] += $row->amount;
			//$t[2][$row->charid][$row->npcid][$row->abilityid] += 1;
			$t[2][$row->charid] += $row->amount;
			if (!$t[3] || $t[3]<$t[2][$row->charid])
				$t[3] = $t[2][$row->charid];
			$t[4][$row->charid][$row->targetid][$row->abilityid] += $row->amount;
			$t[5][$row->abilityid] = Array(1 => $row->name, 2 => $row-> icon);
		}
		arsort($t[2]);
		return $t;
	}
	
	public function content(){
		$content = $this->getSame(3, true);
		$table = $this->getTable();
		$content .= '
			<script>function Toggle(id, elem){for (var i=0; i<elem.length; i++){ document.getElementById(elem[i]).style.display = "none"; document.getElementById("n"+elem[i]).style.color = "#fff"; }; document.getElementById(id).style.display = "block"; document.getElementById("n"+id).style.color = "#f28f45";}</script>
		';
		$content .= '
			<section class="ttitle raidcomp semibig newmargin">
				<ul>
					<li class="sel" id="nsko" onclick="Toggle(\'sko\', [\'sko\', \'ski\']);">Dispels overall</li>
					<li id="nski" onclick="Toggle(\'ski\', [\'sko\', \'ski\']);">Dispels individual</li>
				</ul>
			</section>
			<section class="table tees">
				<div id="sko">
					<table cellspacing="0">
						<thead>
							<tr>
								<th class="count">#</th>
								<th>Name</th>
								<th colspace="3">Amount</th>
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
								<td><img src="{path}Database/classes/c'.$this->participants[4][$key]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$key]->classid].'" href="{path}TBC/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$key.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode='.$this->mode.'">'.$this->participants[4][$key]->name.'</a></td>
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
								<th>Name</th>
								<th>Target</th>
								<th>Spell</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
			$count=1;
		foreach ($table[4] as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								<td><img src="{path}Database/classes/c'.$this->participants[4][$k]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$k]->classid].'" href="{path}TBC/Raids/Evaluation/Dispels/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$k.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode='.$this->mode.'">'.$this->participants[4][$k]->name.'</a></td>
								<td><img src="{path}Database/classes/c'.$this->participants[4][$ke]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$ke]->classid].'" href="{path}TBC/Character/'.$raidinfo->sname.'/'.$this->participants[4][$ke]->name.'/0">'.$this->participants[4][$ke]->name.'</a></td>
								<td><img src="{path}Database/icons/small/'.$table[5][$key][2].'.jpg" /><a rel="spell='.$key.'" href="https://tbc-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'" target="_blank">'.$table[5][$key][1].'</a></td>
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
			</section>
			</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid){
		parent::__construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid);
	}
}

new Home($db, __DIR__, $_GET["rid"], $_GET["attempts"], $_GET["player"], $_GET["sel"], $_GET["mode"], $_GET["pet"], $_GET["events"], $_GET["tarid"]);

?>