<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $mode = 0;
	private $faction = 0;
	private $server = "";
	private $bossesById = array(0 => 10184,1 => 36538,2 => 16028,3 => 15931,4 => 15932,5 => 15928,6 => 15956,7 => 15953,8 => 15952,9 => 16061,10 => 16060,11 => 50005,12 => 15954,13 => 15936,14 => 16011,15 => 15989,16 => 15990,17 => 31099,18 => 29373,19 => 29417,20 => 29448,21 => 29249,22 => 29268,23 => 29278,24 => 29940,25 => 29955,26 => 50005,27 => 29615,28 => 29701,29 => 29718,30 => 29991,31 => 30061,32 => 28859,33 => 31734,34 => 31125,35 => 33993,36 => 35013,37 => 38433,38 => 31722,39 => 33994,40 => 35360,41 => 38462,42 => 30451,43 => 30452,44 => 30449,45 => 28860,46 => 31520,47 => 31534,48 => 31535,49 => 31311,50 => 33118,51 => 33186,52 => 33293,53 => 50000,54 => 32930,55 => 33515,56 => 33244,57 => 32906,58 => 32865,59 => 32845,60 => 33271,61 => 33288,62 => 32871,63 => 33190,64 => 33724,65 => 33885,66 => 50000,67 => 33909,68 => 34175,69 => 33244,70 => 33360,71 => 33147,72 => 32846,73 => 33449,74 => 33955,75 => 33070,76 => 50001,77 => 34780,78 => 50002,79 => 50003,80 => 34564,81 => 50001,82 => 35216,83 => 50002,84 => 50003,85 => 34566,86 => 50001,87 => 35268,88 => 50002,89 => 50003,90 => 35615,91 => 50001,92 => 35269,93 => 50002,94 => 50003,95 => 35616,96 => 36612,97 => 36855,98 => 50007,99 => 37813,100 => 36626,101 => 36627,102 => 36678,103 => 50004,104 => 37955,105 => 37950,106 => 36853,107 => 36597,108 => 37957,109 => 38106,110 => 50007,111 => 38402,112 => 37504,113 => 38390,114 => 38431,115 => 50004,116 => 38434,117 => 38174,118 => 38265,119 => 39166,120 => 37958,121 => 38296,122 => 50007,123 => 38582,124 => 37505,125 => 38549,126 => 38585,127 => 50004,128 => 38435,129 => 38589,130 => 38266,131 => 39167,132 => 37959,133 => 38297,134 => 50007,135 => 38583,136 => 37506,137 => 38550,138 => 38586,139 => 50004,140 => 38436,141 => 38590,142 => 38267,143 => 39168,144 => 39823,145 => 39751,146 => 39805,147 => 39863,148 => 39747,149 => 39899,150 => 39746,151 => 40142,152 => 39823,153 => 39751,154 => 39805,155 => 39864,156 => 39747,157 => 39899,158 => 39746,159 => 40143); 
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
		foreach($this->db->query('SELECT * FROM servernames WHERE expansion = 2') as $row){
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
				<a href="{path}WOTLK/Speed-Kills/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid>0) ? ($this->rid-1) : $this->rid).'"><button class="icon-button icon-arrowleft" title="Previous"></button></a>
				<a href="{path}WOTLK/Speed-Kills/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid<159) ? ($this->rid+1) : $this->rid).'"><button class="icon-button icon-arrowright" title="Next"></button></a>
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
		foreach ($this->db->query('SELECT a.'.$this->prefix[1].'time as time, a.'.$this->prefix[1].'change as changed, a.'.$this->prefix[2].'raidid as raidid, c.name as sname, b.name as gname, d.tsend, b.serverid, b.faction, a.'.$this->prefix[3].'amount as aamount FROM `wotlk-speed-kills` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `wotlk-raids` d ON a.'.$this->prefix[2].'raidid = d.id WHERE a.bossid = '.$this->bossesById[$this->rid].' '.$this->getConditions().' ORDER BY a.'.$this->prefix[1].'time LIMIT 50') as $row){
			$fac = ($row->faction == 1) ? "alliance" : "horde";
			$counter += 1;
			$content .= '
						<tr>
							<td class="rank">'.$counter.'</td>
							<td><img src="img/'.$fac.'.png"><a class="'.$fac.'" href="{path}WOTLK/Guild/'.$row->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
							<td class="fstring">'.$row->sname.'</td>
							<td class="fstring"'.($r = ($this->mode==0 or $this->mode==2) ? ' title="'.$row->aamount.' attempts"' : '').'>'.gmdate("i:s", $row->time).($r = ($this->mode==0 or $this->mode==2) ? "*" : "").'</td>
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
		$this->bossesByEntry = array();
		$temp = array();
		$str = "";
		foreach($this->bossesById as $k => $v){
			if (isset($temp[$v]))
				array_push($temp[$v], $k);
			else
				$temp[$v] = array(0=>$k);
			$str .= ($r = ($str != "") ? "," : "").$v;
		}
		foreach($db->query('SELECT id, name FROM wotlk_npcs WHERE id IN ('.$str.');') as $v){
			foreach($temp[$v->id] as $var){
				$this->bossesByEntry[$var] = $v->name;
			}
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