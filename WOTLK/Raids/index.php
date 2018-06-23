<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
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
	private $name = "";
	private $ts = 0;
	private $duration = "";
	private $realm = 0;
	private $faction = 0;
	private $raid = 0;
	private $page = 1;
	
	private function validDuration(){
		if ($this->duration and $this->duration != ""){
			if (preg_match("(&[l|g]t;\s?\d+)", $this->duration)){
				$this->duration = html_entity_decode($this->duration);
				return true;
			}
		}
		return false;
	}
	
	private function getConditions(){
		$con = ' WHERE a.rdy = 1 ';
		$next = true;
		if ($this->name and $this->name != ""){
			$con .= 'AND b.name LIKE "%'.$this->name.'%" ';
			$next = true;
		}
		if ($this->ts and $this->ts != 0){
			$con .= ($r = ($next) ? "AND " : "").'a.tsstart BETWEEN '.$this->ts.' AND '.($this->ts+86399).' ';
			$next = true;
		}
		if ($this->validDuration()){
			$con .= ($r = ($next) ? "AND " : "").'((a.tsend-a.tsstart)/60)'.$this->duration.' ';
			$next = true;
		}
		if ($this->realm and $this->realm != 0){
			$con .= ($r = ($next) ? "AND " : "").'b.serverid = '.$this->realm.' ';
			$next = true;
		}
		if ($this->faction and $this->faction != 0){
			$con .= ($r = ($next) ? "AND " : "").'b.faction = '.$this->faction.' ';
			$next = true;
		}
		if ($this->raid and $this->raid != 0){
			$con .= ($r = ($next) ? "AND " : "").'a.nameid = '.$this->raid.' ';
		}
		if ($con == " WHERE ")
			return '';
		return $con;
	}
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<nav class="rsearch">
				<form action="">
					<input type="text" value="'.$this->name.'" name="name" placeholder="Name of the guild" />
					<input type="text" '.($r = ($this->ts>0) ? 'value="'.date("d-m-Y", $this->ts).'".' : '').' name="date" placeholder="Date: (Format: '.date("d-m-Y").')" />
					<input type="text" value="'.$this->duration.'" name="duration" placeholder="Duration in minutes (e.g. </> 30)" />
					<select name="realm">
						<option value="0"'.($r = ($this->realm==0) ? " selected" : "").'>Any realm</option>
			';
			foreach($this->db->query('SELECT * FROM servernames WHERE expansion = 2') as $row){
				$content .= '
						<option value="'.$row->id.'"'.($r = ($this->realm==$row->id) ? " selected" : "").'>'.$row->name.'</option>
				';
			}	
			$content .= '
					</select>
					<select name="faction">
						<option value="0"'.($r = ($this->faction==0) ? " selected" : "").'>Any faction</option>
						<option value="1" class="alliance"'.($r = ($this->faction==1) ? " selected" : "").'>Alliance</option>
						<option value="-1" class="horde"'.($r = ($this->faction==-1) ? " selected" : "").'>Horde</option>
					</select>
					<select name="raid">
						<option value="0"'.($r = ($this->raid==0) ? " selected" : "").'>Any raid</option>
			';
			foreach($this->raidsById as $k => $v){
				$content .= '
					<option value="'.$k.'"'.($r = ($this->raid==$k) ? " selected" : "").'>'.$v.'</option>';
			}
			$content .= '
					</select>
					<button class="icon-button icon-filter"></button>
				</form>
			</nav>
			<section class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th class="num">#</th>
							<th class="guild">Guild</th>
							<th class="raid">Raid</th>
							<th class="sstring">Start date</th>
							<th class="sstring">End date</th>
							<th class="sdur">Duration</th>
							<th class="sstring">Realm</th>
						</tr>
			';
			$count = $this->db->query('SELECT a.id, a.nameid, b.name as gname, c.name as sname, a.tsstart, a.tsend, b.faction FROM `wotlk-raids` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id'.$this->getConditions())->rowCount();
			$max = floor($count/15+1);
			foreach ($this->db->query('SELECT a.id, a.nameid, b.name as gname, c.name as sname, a.tsstart, a.tsend, b.faction FROM `wotlk-raids` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id'.$this->getConditions().' ORDER BY a.tsend DESC LIMIT '.(($this->page-1)*15).' ,15') as $row){
				$fac = ($row->faction == 1) ? "alliance" : "horde";
				$content .= '
						<tr>
							<td class="num">'.($row->id).'</td>
							<td class="guild"><img src="img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}WOTLK/Guild/'.$row->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
							<td class="raid"><img src="img/'.$row->nameid.'.png" /><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$row->id.'">'.$this->raidsById[$row->nameid].'</a></td>
							<td class="sstring">'.date("d.m.y H:i:s", $row->tsstart).'</td>
							<td class="sstring">'.date("d.m.y H:i:s", $row->tsend).'</td>
							<td class="sdur">'.gmdate("H:i:s", $row->tsend-$row->tsstart).'</td>
							<td class="sstring">'.$row->sname.'</td>
						</tr>
				';
			}
			$content .= '
					</table>
				</div>
			</section>
			<footer class="pager">
				<div class="pleft">
					<a href="{path}WOTLK/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page=1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}WOTLK/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page='.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}WOTLK/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page='.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}WOTLK/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page='.$max.'"><button class="icon-button icon-darrowright"></button></a>
				</div>
			</footer>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $name, $date, $duration, $realm, $faction, $raid, $page){
		$this->name = $this->antiSQLInjection($name);
		$this->ts = strtotime($date);
		$this->duration = $this->antiSQLInjection($duration);
		$this->realm = intval($this->antiSQLInjection($realm));
		$this->faction = intval($this->antiSQLInjection($faction));
		$this->raid = intval($this->antiSQLInjection($raid));
		$this->page = intval($this->antiSQLInjection($page));
		
		if ((!isset($name) || $this->name == "") and isset($_COOKIE["wroname"]))
			$this->name = $_COOKIE["wroname"];
		else
			setcookie("wroname", $this->name, time()+8640000);
		if ((!isset($duration) || $this->duration == "") and isset($_COOKIE["wroduration"]))
			$this->duration = $_COOKIE["wroduration"];
		else
			setcookie("wroduration", $this->duration, time()+8640000);
		if (!isset($realm) and isset($_COOKIE["wrorealm"]))
			$this->realm = intval($_COOKIE["wrorealm"]);
		else
			setcookie("wrorealm", $this->realm, time()+8640000);
		if (!isset($faction) and isset($_COOKIE["wrofaction"]))
			$this->faction = intval($_COOKIE["wrofaction"]);
		else
			setcookie("wrofaction", $this->faction, time()+8640000);
		if (!isset($raid) and isset($_COOKIE["wroraid"]))
			$this->raid = intval($_COOKIE["wroraid"]);
		else
			setcookie("wroraid", $this->raid, time()+8640000);
		
		if ($this->page <= 0)
			$this->page = 1;
		$this->siteTitle = " - WOTLK raids";
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["name"], $_GET["date"], $_GET["duration"], $_GET["realm"], $_GET["faction"], $_GET["raid"], $_GET["page"]);

?>