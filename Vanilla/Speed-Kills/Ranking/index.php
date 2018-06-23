<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $mode = 0;
	private $faction = 0;
	private $server = "";
	private $bossesById = Array (0 => 12118, 1 => 11982, 2 => 12259, 3 => 12057, 4 => 12056, 5 => 12264, 6 => 12098, 7 => 11988, 8 => 12018, 9 => 11502, 10 => 10184, 11 => 12397, 12 => 6109, 13 => 14889, 14 => 14887, 15 => 14888, 16 => 14890, 17 => 12435, 18 => 13020, 19 => 12017, 20 => 11983, 21 => 14601, 22 => 11981, 23 => 14020, 24 => 11583, 25 => 14517, 26 => 14507, 27 => 14510, 28 => 11382, 29 => 15082, 30 => 15083, 31 => 15085, 32 => 15114, 33 => 14509, 34 => 14515, 35 => 11380, 36 => 14834, 37 => 15348, 38 => 15341, 39 => 15340, 40 => 15370, 41 => 15369, 42 => 15339, 43 => 15263, 44 => 50000, 45 => 15516, 46 => 15510, 47 => 15299, 48 => 15509, 49 => 50001, 50 => 15517, 51 => 15727, 52 => 16028, 53 => 15931, 54 => 15932, 55 => 15928, 56 => 15956, 57 => 15953, 58 => 15952, 59 => 16061, 60 => 16060, 61 => 50002, 62 => 15954, 63 => 15936, 64 => 16011, 65 => 15989, 66 => 15990);
	private $prefix = array(
		1 => "foa",
		2 => "o"
	);
	private $mname = "";
	
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
		foreach($this->db->query('SELECT * FROM servernames WHERE expansion = 0') as $row){
			$content .= '
					<option value="'.$row->id.'"'.($r = (in_array($row->id, $serverList) || !$this->server) ? ' selected' : '').'>'.$row->name.'</option>
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
		';
		ksort($this->bossesByEntry);
		foreach($this->bossesByEntry as $k => $v){
			$content .= '
					<option value="'.$k.'"'.($r = ($this->rid==$k) ? " selected" : "").'>'.$v.'</option>
			';
		}
		$content .= '
				</select>
				<a href="{path}Vanilla/Speed-Kills/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid>0) ? ($this->rid-1) : $this->rid).'"><button class="icon-button icon-arrowleft" title="Previous"></button></a>
				<a href="{path}Vanilla/Speed-Kills/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid<66) ? ($this->rid+1) : $this->rid).'"><button class="icon-button icon-arrowright" title="Next"></button></a>
			</section>
			<section class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th class="rank">Rank</th>
							<th class="timg">Guild</th>
							<th class="fstring">Server</th>
							<th class="fstring">Time</th>
							<th class="fstring">Date</th>
							<th class="rank" title="The development in the selected mode. In general it is the difference of the previous and the current value.">Change*</th>
						</tr>
		';
		$counter = 0;
		foreach ($this->db->query('SELECT a.'.$this->prefix[1].'time as time, a.'.$this->prefix[1].'change as changed, a.'.$this->prefix[2].'raidid as raidid, c.name as sname, b.name as gname, d.tsend, b.serverid, b.faction, a.'.$this->prefix[3].'amount as aamount FROM `v-speed-kills` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `v-raids` d ON a.'.$this->prefix[2].'raidid = d.id WHERE a.bossid = '.$this->bossesById[$this->rid].' '.$this->getConditions().' ORDER BY a.'.$this->prefix[1].'time LIMIT 50') as $row){
			$fac = ($row->faction == 1) ? "alliance" : "horde";
			$counter += 1;
			$content .= '
						<tr>
							<td class="rank">'.$counter.'</td>
							<td><img src="img/'.$fac.'.png"><a class="'.$fac.'" href="{path}Vanilla/Guild/'.$row->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
							<td class="fstring">'.$row->sname.'</td>
							<td class="fstring"'.($r = ($this->mode==0 or $this->mode==2) ? ' title="'.$row->aamount.' attempts"' : '').'>'.gmdate("i:s", $row->time).($r = ($this->mode==0 or $this->mode==2) ? "*" : "").'</td>
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
		$this->bossesByEntry = array();
		$temp = array();
		$str = "";
		foreach($this->bossesById as $k => $v){
			$temp[$v] = $k;
			$str .= ($r = ($str != "") ? "," : "").$v;
		}
		foreach($db->query('SELECT id, name FROM npcs WHERE id IN ('.$str.');') as $v){
			$this->bossesByEntry[$temp[$v->id]] = $v->name;
		}
		$this->mname = $this->bossesByEntry[$id];
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