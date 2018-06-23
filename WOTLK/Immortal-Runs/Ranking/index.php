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
		25 => "Onyxia's Lair 10", // 10 
		26 => "Onyxia's Lair 25", // 25
		27 => "Naxxramas 10", // 10
		28 => "Naxxramas 25", // 25
		29 => "The Eye of Eternity 10", // 10
		30 => "The Eye of Eternity 25", // 25
		31 => "Vault of Archavon 10", // 10
		32 => "Vault of Archavon 25", // 25
		33 => "The Obsidian Sanctum 10", // 10
		34 => "The Obsidian Sanctum 25", // 25
		35 => "Ulduar 10", // 10
		36 => "Ulduar 25", // 25
		37 => "Trial of the Crusader 10 NHC", // 10
		38 => "Trial of the Crusader 25 NHC", // 25
		39 => "Trial of the Crusader 10 HC", // 10 HC
		40 => "Trial of the Crusader 25 HC", // 25 HC
		41 => "Icecrown Citadel 10 NHC", // 10
		42 => "Icecrown Citadel 25 NHC", // 25
		43 => "Icecrown Citadel 10 HC", // 10 HC
		44 => "Icecrown Citadel 25 HC", // 25 HC
		45 => "The Ruby Sanctum 10 NHC", // 10
		46 => "The Ruby Sanctum 25 NHC", // 25
		47 => "The Ruby Sanctum 10 HC", // 10 HC
		48 => "The Ruby Sanctum 25 HC", // 25 HC
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
		foreach($this->db->query('SELECT * FROM servernames WHERE expansion = 2') as $row){
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
					<option value="25"'.($r = ($this->rid==25) ? " selected" : "").'>Onyxia\'s Lair 10</option>
					<option value="26"'.($r = ($this->rid==26) ? " selected" : "").'>Onyxia\'s Lair 25</option>
					<option value="27"'.($r = ($this->rid==27) ? " selected" : "").'>Naxxramas 10</option>
					<option value="28"'.($r = ($this->rid==28) ? " selected" : "").'>Naxxramas 25</option>
					<option value="29"'.($r = ($this->rid==29) ? " selected" : "").'>The Eye of Eternity 10</option>
					<option value="30"'.($r = ($this->rid==30) ? " selected" : "").'>The Eye of Eternity 25</option>
					<option value="31"'.($r = ($this->rid==31) ? " selected" : "").'>Vault of Archavon 10</option>
					<option value="32"'.($r = ($this->rid==32) ? " selected" : "").'>Vault of Archavon 25</option>
					<option value="33"'.($r = ($this->rid==33) ? " selected" : "").'>The Obsidian Sanctum 10</option>
					<option value="34"'.($r = ($this->rid==34) ? " selected" : "").'>The Obsidian Sanctum 25</option>
					<option value="35"'.($r = ($this->rid==35) ? " selected" : "").'>Ulduar 10</option>
					<option value="36"'.($r = ($this->rid==36) ? " selected" : "").'>Ulduar 25</option>
					<option value="37"'.($r = ($this->rid==37) ? " selected" : "").'>Trial of the Crusader 10 NHC</option>
					<option value="38"'.($r = ($this->rid==38) ? " selected" : "").'>Trial of the Crusader 25 NHC</option>
					<option value="39"'.($r = ($this->rid==39) ? " selected" : "").'>Trial of the Crusader 10 HC</option>
					<option value="40"'.($r = ($this->rid==40) ? " selected" : "").'>Trial of the Crusader 25 HC</option>
					<option value="41"'.($r = ($this->rid==41) ? " selected" : "").'>Icecrown Citadel 10 NHC</option>
					<option value="42"'.($r = ($this->rid==42) ? " selected" : "").'>Icecrown Citadel 25 NHC</option>
					<option value="43"'.($r = ($this->rid==43) ? " selected" : "").'>Icecrown Citadel 10 HC</option>
					<option value="44"'.($r = ($this->rid==44) ? " selected" : "").'>Icecrown Citadel 25 HC</option>
					<option value="45"'.($r = ($this->rid==45) ? " selected" : "").'>The Ruby Sanctum 10 NHC</option>
					<option value="46"'.($r = ($this->rid==46) ? " selected" : "").'>The Ruby Sanctum 25 NHC</option>
					<option value="47"'.($r = ($this->rid==47) ? " selected" : "").'>The Ruby Sanctum 10 HC</option>
					<option value="48"'.($r = ($this->rid==48) ? " selected" : "").'>The Ruby Sanctum 25 HC</option>
				</select>
				<a href="{path}WOTLK/Immortal-Runs/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid>25) ? ($this->rid-1) : $this->rid).'"><button class="icon-button icon-arrowleft" title="Previous"></button></a>
				<a href="{path}WOTLK/Immortal-Runs/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid<48) ? ($this->rid+1) : $this->rid).'"><button class="icon-button icon-arrowright" title="Next"></button></a>
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
		foreach ($this->db->query('SELECT a.'.$this->prefix[1].'deaths as deaths, a.'.$this->prefix[1].'change as changed, a.'.$this->prefix[2].'rid as raidid, c.name as sname, b.name as gname, d.tsend, b.serverid, b.faction, a.'.$this->prefix[1].'amount as aamount FROM `wotlk-immortal-runs` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `wotlk-raids` d ON a.'.$this->prefix[2].'rid = d.id WHERE a.raidnameid = '.$this->rid.' '.$this->getConditions().' ORDER BY a.'.$this->prefix[1].'deaths LIMIT 50') as $row){
			$fac = ($row->faction == 1) ? "alliance" : "horde";
			$counter += 1;
			$content .= '
						<tr>
							<td class="rank">'.$counter.'</td>
							<td><img src="img/'.$fac.'.png"><a class="'.$fac.'" href="{path}WOTLK/Guild/'.$row->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
							<td class="fstring">'.$row->sname.'</td>
							<td class="fstring" title="'.$row->aamount.' times">'.round($row->deaths, 2).'*</td>
							<td class="fstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$row->raidid.'">'.date("d.m.y H:i:s", $row->tsend).'</a></td>
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