<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $mode = 0;
	private $faction = 0;
	private $server = "";
	private $bossesById = Array(0 => 18728, 1 => 17711, 2 => 22887, 3 => 22898, 4 => 22841, 5 => 21867, 6 => 22948, 7 => 50002, 8 => 22947, 9 => 23426, 10 => 22917, 11 => 21216, 12 => 21217, 13 => 21215, 14 => 21214, 15 => 21213, 16 => 21212, 17 => 15550, 18 => 15687, 19 => 50001, 20 => 16457, 21 => 15691, 22 => 15688, 23 => 16524, 24 => 15689, 25 => 15690, 26 => 17225, 27 => 18831, 28 => 19044, 29 => 17257, 30 => 23576, 31 => 23578, 32 => 23574, 33 => 23577, 34 => 23863, 35 => 19514, 36 => 19516, 37 => 18805, 38 => 19622, 39 => 17767, 40 => 17808, 41 => 17888, 42 => 17842, 43 => 17968, 44 => 24850, 45 => 24882, 46 => 25038, 47 => 50000, 48 => 25741, 49 => 25608, 50 => 24239); 
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
		foreach($this->db->query('SELECT * FROM servernames WHERE expansion = 1') as $row){
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
				<a href="{path}TBC/Speed-Kills/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid>0) ? ($this->rid-1) : $this->rid).'"><button class="icon-button icon-arrowleft" title="Previous"></button></a>
				<a href="{path}TBC/Speed-Kills/Ranking/?server='.$this->server.'&faction='.$this->faction.'&mode=0&id='.($r = ($this->rid<66) ? ($this->rid+1) : $this->rid).'"><button class="icon-button icon-arrowright" title="Next"></button></a>
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
		foreach ($this->db->query('SELECT a.'.$this->prefix[1].'time as time, a.'.$this->prefix[1].'change as changed, a.'.$this->prefix[2].'raidid as raidid, c.name as sname, b.name as gname, d.tsend, b.serverid, b.faction, a.'.$this->prefix[3].'amount as aamount FROM `tbc-speed-kills` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `tbc-raids` d ON a.'.$this->prefix[2].'raidid = d.id WHERE a.bossid = '.$this->bossesById[$this->rid].' '.$this->getConditions().' ORDER BY a.'.$this->prefix[1].'time LIMIT 50') as $row){
			$fac = ($row->faction == 1) ? "alliance" : "horde";
			$counter += 1;
			$content .= '
						<tr>
							<td class="rank">'.$counter.'</td>
							<td><img src="img/'.$fac.'.png"><a class="'.$fac.'" href="{path}TBC/Guild/'.$row->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
							<td class="fstring">'.$row->sname.'</td>
							<td class="fstring"'.($r = ($this->mode==0 or $this->mode==2) ? ' title="'.$row->aamount.' attempts"' : '').'>'.gmdate("i:s", $row->time).($r = ($this->mode==0 or $this->mode==2) ? "*" : "").'</td>
							<td class="fstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$row->raidid.'">'.date("d.m.y H:i:s", $row->tsend).'</a></td>
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
		foreach($db->query('SELECT id, name FROM tbc_npcs WHERE id IN ('.$str.');') as $v){
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