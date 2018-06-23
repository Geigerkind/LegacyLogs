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
		0 => "Unknown",
		1 => "Molten Core",
		2 => "Onyxia's Lair",
		3 => "Blackwing Lair",
		4 => "Zul'Gurub",
		5 => "Ruins of Ahn'Qiraj",
		6 => "Temple of Ahn'Qiraj",
		7 => "Naxxramas"
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
					<option value="1" '.($r = ($this->mode==1) ? " selected" : "").'">Best all time</option>
					<option value="2" '.($r = ($this->mode==2) ? " selected" : "").'">Average this quarter</option>
					<option value="3" '.($r = ($this->mode==3) ? " selected" : "").'">Best this quarter</option>
				</select>
				<select name="realm" id="srealm" multiple="multiple">
		';
		$serverList = explode(",", $this->server);
		foreach($this->db->query('SELECT * FROM servernames WHERE expansion=0') as $row){
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
					<option value="1"'.($r = ($this->rid==1) ? " selected" : "").'>Molten Core</option>
					<option value="2"'.($r = ($this->rid==2) ? " selected" : "").'>Onyxia\'s Lair</option>
					<option value="4"'.($r = ($this->rid==4) ? " selected" : "").'>Zul\'Gurub</option>
					<option value="3"'.($r = ($this->rid==3) ? " selected" : "").'>Blackwing Lair</option>
					<option value="5"'.($r = ($this->rid==5) ? " selected" : "").'>Ruins of Ahn\'Qiraj</option>
					<option value="6"'.($r = ($this->rid==6) ? " selected" : "").'>Temple of Ahn\'Qiraj</option>
					<option value="7"'.($r = ($this->rid==7) ? " selected" : "").'>Naxxramas</option>
				</select>
				<a href="{path}Vanilla/Immortal-Runs/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid>1) ? ($this->rid-1) : $this->rid).'"><button class="icon-button icon-arrowleft" title="Previous"></button></a>
				<a href="{path}Vanilla/Immortal-Runs/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid<7) ? ($this->rid+1) : $this->rid).'"><button class="icon-button icon-arrowright" title="Next"></button></a>
			</section>
			<section class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th class="rank">Rank</th>
							<th class="timg">Guild</th>
							<th class="fstring">Server</th>
							<th class="fstring">Deaths</th>
							<th class="fstring">Date</th>
							<th class="rank" title="The development in the selected mode. In general it is the difference of the previous and the current value.">Change*</th>
						</tr>
		';
		$counter = 0;
		foreach ($this->db->query('SELECT a.'.$this->prefix[1].'deaths as deaths, a.'.$this->prefix[1].'change as changed, a.'.$this->prefix[2].'rid as raidid, c.name as sname, b.name as gname, d.tsend, b.serverid, b.faction, a.'.$this->prefix[1].'amount as aamount FROM `v-immortal-runs` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `v-raids` d ON a.'.$this->prefix[2].'rid = d.id WHERE a.raidnameid = '.$this->rid.' '.$this->getConditions().' ORDER BY a.'.$this->prefix[1].'deaths LIMIT 50') as $row){
			$fac = ($row->faction == 1) ? "alliance" : "horde";
			$counter += 1;
			$content .= '
						<tr>
							<td class="rank">'.$counter.'</td>
							<td><img src="img/'.$fac.'.png"><a class="'.$fac.'" href="{path}Vanilla/Guild/'.$row->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
							<td class="fstring">'.$row->sname.'</td>
							<td class="fstring" title="'.$row->aamount.' times">'.round($row->deaths, 2).'*</td>
							<td class="fstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$row->raidid.'">'.date("d.m.y H:i:s", $row->tsend).'</a></td>
							<td class="rank"><img src="img/'.$this->getPic($row->changed).'.png" />'.round($row->changed, 1).'</td>
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
				$this->prefix[2] = "foa";
				break;
			case 1 :
				$this->prefix[1] = "fo";
				$this->prefix[2] = "fo";
				break;
			case 2 :
				$this->prefix[1] = "moa";
				$this->prefix[2] = "moa";
				break;
			case 3 :
				$this->prefix[1] = "mo";
				$this->prefix[2] = "mo";
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