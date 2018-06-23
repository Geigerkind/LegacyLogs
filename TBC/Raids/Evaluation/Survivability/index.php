<?php
require(dirname(__FILE__)."/../Template.php");

class Home extends Template{
	
	public function content(){
		$content = $this->getSame(99, true);
		$deathTable = array();
		$con = '';
		if ($this->player)
			$con .= ' AND a.charid = '.$this->player;
		if ($this->tarid)
			$con .= ' AND a.flagid = '.$this->tarid;
		foreach($this->db->query('SELECT a.charid, a.attemptid, a.cbt, b.cbtend, b.cbt as cbtstart FROM `tbc-raids-deaths` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id WHERE b.rdy = 1 AND b.rid = "'.$this->rid.'"'.$con) as $row){
			$deathTable[$row->charid][$row->attemptid] = array(1 => $row->cbt, 2 => $row->cbtend, 3 => $row->cbtstart);
		}
		$content .= '
			<section class="table newmargin">
				<div class="right tees">
					<table cellspacing="0">
						<thead>
							<tr>
								<th>Player</th>
		';
		$numBosses = 0;
		foreach($this->atmpts[2] as $k => $v){
			foreach($v as $key => $var){
				if (!$this->attemptid or $this->in_array($this->attemptid, $key)){
					if (isset($this->raidBosses[$this->raidinfo->nameid][$this->atmpts[7][$k]]) && (!$this->tarid or ($this->atmpts[7][$k]==$this->npcsById[$this->tarid]->name)))
						$numBosses++;
				}
			}
		}
		
		foreach($this->atmpts[2] as $k => $v){
			foreach($v as $key => $var){
				if (!$this->attemptid or $this->in_array($this->attemptid, $key)){
					if (isset($this->raidBosses[$this->raidinfo->nameid][$this->atmpts[7][$k]]) && (!$this->tarid or ($this->atmpts[7][$k]==$this->npcsById[$this->tarid]->name)))
						$content .= '<th style="width:'.(1/$numBosses*904).'px!important;max-width:'.(1/$numBosses*904).'px!important;">'.$var[7].'</th>';
				}
			}	
		}
		$content .= '
							</tr>
						</thead>
						<tbody>
		';
		foreach(($r = (!$this->player) ? $this->participants[4] : array($this->player => $this->participants[4][$this->player])) as $k => $v){
			$content .= '
				<tr>
					<td class="color-'.$this->classById[$v->classid].'">'.$v->name.'</td>
			';
		foreach($this->atmpts[2] as $ke => $va){
			foreach($va as $key => $var){
				if (!$this->attemptid or $this->in_array($this->attemptid, $key)){
					if (isset($this->raidBosses[$this->raidinfo->nameid][$this->atmpts[7][$ke]]) && (!$this->tarid or ($this->atmpts[7][$ke]==$this->npcsById[$this->tarid]->name)))
						$content .= '<td>'.($r = (isset($deathTable[$k][$key])) ? ceil(100*(1-(($deathTable[$k][$key][2]-$deathTable[$k][$key][1])/($deathTable[$k][$key][2]-$deathTable[$k][$key][3]))))."%" : "100%").'</td>';
				}
			}	
		}
			$content .= '
				</tr>
			';
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
	
	public function __construct($db, $dir, $rid, $attempts, $player, $attemptid, $pet, $mode, $events, $npcid){
		parent::__construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid);
	}
}

new Home($db, __DIR__, $_GET["rid"], $_GET["attempts"], $_GET["player"], $_GET["sel"], $_GET["pet"], $_GET["mode"], $_GET["events"], $_GET["tarid"]);

?>