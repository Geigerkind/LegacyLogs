<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $mode = 0;
	private $faction = 0;
	private $server = "";
	private $prefix = array(
		1 => "foa",
		2 => "o"
	);
	private $raidsById = array(
		14 => "Hellfire Peninsula",
		15 => "Shadowmoon Valley",
		16 => "Black Temple",
		17 => "Serpentshrine Cavern",
		18 => "Karazhan",
		19 => "Gruul's Lair",
		20 => "Magtheridon's Lair",
		21 => "Zul'Aman",
		22 => "The Eye",
		23 => "Hyjal Summit",
		24 => "Sunwell Plateau",
	);
	
	private function getConditions(){
		$con = "";
		if ($this->faction && $this->faction != 0){
			$con .= 'AND b.faction ='.$this->faction.' ';
			$next = true;
		}
		if ($this->server)
			$con .= 'AND b.serverid IN ('.$this->server.')';
		return $con;
	}
	
	private function getPic($i){
		if ($i>0)
			return 0;
		return 1;
	}
	
	public function content(){
		$content = '
		<div class="container cont" id="container">
			<section class="centredNormal formular">
				<select name="mode" onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode=\'+this.value+\'&id='.$this->rid.'\');">
					<option value="0" '.($r = ($this->mode==0) ? " selected" : "").'">Average all time</option>
					<option value="1" '.($r = ($this->mode==1) ? " selected" : "").'">Fastest all time</option>
					<option value="2" '.($r = ($this->mode==2) ? " selected" : "").'">Average this quarter</option>
					<option value="3" '.($r = ($this->mode==3) ? " selected" : "").'">Fastest this quarter</option>
				</select>
				<select name="realm" id="srealm" multiple="multiple">
		';
		$serverList = explode(",", $this->server);
		foreach($this->db->query('SELECT * FROM servernames WHERE expansion = 1') as $row){
			$content .= '
					<option value="'.$row->id.'"'.($r = (in_array($row->id, $serverList) || !$this->server) ? " selected" : "").'>'.$row->name.'</option>
			';
		}	
		$content .= '
				</select>
				<select name="faction" onchange="window.location.replace(\'?server='.$this->server.'&faction=\'+this.value+\'&mode='.$this->mode.'&id='.$this->rid.'\');">
					<option value="0"'.($r = ($this->faction==0) ? " selected" : "").'>Any faction</option>
					<option value="-1" class="horde"'.($r = ($this->faction==-1) ? " selected" : "").'>Horde</option>
					<option value="1" class="alliance"'.($r = ($this->faction==1) ? " selected" : "").'>Alliance</option>
				</select>
				<select name="raid" onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&id=\'+this.value);">
					<option value="14"'.($r = ($this->rid==14) ? " selected" : "").'>Hellfire Peninsula</option>
					<option value="15"'.($r = ($this->rid==15) ? " selected" : "").'>Shadowmoon Valley</option>
					<option value="16"'.($r = ($this->rid==16) ? " selected" : "").'>Black Temple</option>
					<option value="17"'.($r = ($this->rid==17) ? " selected" : "").'>Serpentshrine Cavern</option>
					<option value="18"'.($r = ($this->rid==18) ? " selected" : "").'>Karazhan</option>
					<option value="19"'.($r = ($this->rid==19) ? " selected" : "").'>Gruul\'s Lair</option>
					<option value="20"'.($r = ($this->rid==20) ? " selected" : "").'>Magtheridon\'s Lair</option>
					<option value="21"'.($r = ($this->rid==21) ? " selected" : "").'>Zul\'Aman</option>
					<option value="22"'.($r = ($this->rid==22) ? " selected" : "").'>The Eye</option>
					<option value="23"'.($r = ($this->rid==23) ? " selected" : "").'>Hyjal Summit</option>
					<option value="24"'.($r = ($this->rid==24) ? " selected" : "").'>Sunwell Plateau</option>
				</select>
				<a href="{path}TBC/Speed-Runs/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid>14) ? ($this->rid-1) : $this->rid).'"><button class="icon-button icon-arrowleft" title="Previous"></button></a>
				<a href="{path}TBC/Speed-Runs/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid<24) ? ($this->rid+1) : $this->rid).'"><button class="icon-button icon-arrowright" title="Next"></button></a>
			</section>
			<section class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th class="rank">Rank</th>
							<th class="timg">Guild</th>
							<th class="fstring">Server</th>
							<th class="fstring">Time (Boss)</th>
							<th class="fstring">Date</th>
							<th class="rank" title="The development in the selected mode. In general it is the difference of the previous and the current value.">Change*</th>
						</tr>
		';
		$counter = 0;
		foreach ($this->db->query('SELECT a.'.$this->prefix[1].'time as time, a.'.$this->prefix[1].'boss as boss, a.'.$this->prefix[1].'change as changed, a.'.$this->prefix[2].'raidid as raidid, c.name as sname, b.name as gname, d.tsend, b.serverid, b.faction, a.'.$this->prefix[3].'amount as aamount FROM `tbc-speed-runs` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `tbc-raids` d ON a.'.$this->prefix[2].'raidid = d.id WHERE a.raidnameid = '.$this->rid.' '.$this->getConditions().' ORDER BY a.'.$this->prefix[1].'time LIMIT 50') as $row){
			$fac = ($row->faction == 1) ? "alliance" : "horde";
			$counter += 1;
			$content .= '
						<tr>
							<td class="rank">'.$counter.'</td>
							<td><img src="img/'.$fac.'.png"><a class="'.$fac.'" href="{path}TBC/Guild/'.$row->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
							<td class="fstring">'.$row->sname.'</td>
							<td class="fstring"'.($r = ($this->mode==0 or $this->mode==2) ? ' title="'.$row->aamount.' attempts"' : '').'>'.gmdate("H:i:s", $row->time).' ('.gmdate("i:s", $row->boss).')'.($r = ($this->mode==0 or $this->mode==2) ? "*" : "").'</td>
							<td class="fstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$row->raidid.'">'.date("d.m.y H:i:s", $row->tsend).'</a></td>
							<td class="rank"><img src="img/'.$this->getPic($row->changed).'.png" />'.$this->mReadable($row->changed, 1).'</td>
						</tr>
			';
		}
		$content .= '
					</table>
				</div>
			</section>
		</div>
		<script>
			$(\'#srealm\').multipleSelect({
				onClose: function() {
					window.location.replace(\'?server=\'+$(\'#srealm\').multipleSelect(\'getSelects\')+\'&faction='.$this->faction.'&mode='.$this->mode.'&id='.$this->rid.'\');
				},
				allSelected: \'Any realm\'
			});
		</script>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $server, $faction, $mode, $id){
		$this->mode = intval($this->antiSQLInjection($mode));
		$this->server = $this->antiSQLInjection($server);
		$this->faction = intval($this->antiSQLInjection($faction));
		$this->rid = intval($this->antiSQLInjection($id));
		switch ($this->mode){
			case 0 :
				$this->prefix[1] = "foa";
				$this->prefix[2] = "o";
				$this->prefix[3] = "fo";
				break;
			case 1 :
				$this->prefix[1] = "fo";
				$this->prefix[2] = "o";
				$this->prefix[3] = "fo";
				break;
			case 2 :
				$this->prefix[1] = "fma";
				$this->prefix[2] = "m";
				$this->prefix[3] = "fm";
				break;
			case 3 :
				$this->prefix[1] = "fm";
				$this->prefix[2] = "m";
				$this->prefix[3] = "fm";
				break;
		}
		$this->addCssLink("{path}External/multipleselect/multiple-select.css");
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js", true);
		$this->addJsLink("{path}External/multipleselect/multiple-select.js", true);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["server"], $_GET["faction"], $_GET["mode"], $_GET["id"]);

?>