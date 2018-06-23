<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $raidsById = array(
		1 => "Molten Core",
		2 => "Onyxia's Lair",
		3 => "Blackwing Lair",
		4 => "Zul'Gurub",
		5 => "Ruins of Ahn'Qiraj",
		6 => "Ahn'Qiraj",
		7 => "Naxxramas",
		8 => "Feralas",
		9 => "Azshara",
		10 => "Blasted Lands",
		11 => "Ashenvale",
		12 => "Duskwood",
		13 => "Hinterlands",
		14 => "Temple of Ahn'Qiraj"
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
			foreach($this->db->query('SELECT * FROM servernames WHERE expansion = 0') as $row){
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
						<option value="1"'.($r = ($this->raid==1) ? " selected" : "").'>Molten Core</option>
						<option value="2"'.($r = ($this->raid==2) ? " selected" : "").'>Onyxia\'s Lair</option>
						<option value="4"'.($r = ($this->raid==4) ? " selected" : "").'>Zul\'Gurub</option>
						<option value="3"'.($r = ($this->raid==3) ? " selected" : "").'>Blackwing Lair</option>
						<option value="5"'.($r = ($this->raid==5) ? " selected" : "").'>Ruins of Ahn\'Qiraj</option>
						<option value="6"'.($r = ($this->raid==6) ? " selected" : "").'>Temple of Ahn\'Qiraj</option>
						<option value="7"'.($r = ($this->raid==7) ? " selected" : "").'>Naxxramas</option>
						<option value="7"'.($r = ($this->raid==8) ? " selected" : "").'>Feralas</option>
						<option value="7"'.($r = ($this->raid==9) ? " selected" : "").'>Azshara</option>
						<option value="7"'.($r = ($this->raid==10) ? " selected" : "").'>Blasted Lands</option>
						<option value="7"'.($r = ($this->raid==11) ? " selected" : "").'>Ashenvale</option>
						<option value="7"'.($r = ($this->raid==12) ? " selected" : "").'>Duskwood</option>
						<option value="7"'.($r = ($this->raid==13) ? " selected" : "").'>Hinterlands</option>
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
							<th class="sduration">Duration</th>
							<th class="sstring">Realm</th>
						</tr>
			';
			$count = $this->db->query('SELECT a.id, a.nameid, b.name as gname, c.name as sname, a.tsstart, a.tsend, b.faction FROM `v-raids` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id'.$this->getConditions())->rowCount();
			$max = floor($count/15+1);
			foreach ($this->db->query('SELECT a.id, a.nameid, b.name as gname, c.name as sname, a.tsstart, a.tsend, b.faction FROM `v-raids` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id'.$this->getConditions().' ORDER BY a.tsend DESC LIMIT '.(($this->page-1)*15).' ,15') as $row){
				$fac = ($row->faction == 1) ? "alliance" : "horde";
				$content .= '
						<tr>
							<td class="num">'.($row->id).'</td>
							<td class="guild"><img src="img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}Vanilla/Guild/'.$row->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
							<td class="raid"><img src="img/'.$row->nameid.'.png" /><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$row->id.'">'.$this->raidsById[$row->nameid].'</a></td>
							<td class="sstring">'.date("d.m.y H:i:s", $row->tsstart).'</td>
							<td class="sstring">'.date("d.m.y H:i:s", $row->tsend).'</td>
							<td class="sduration">'.gmdate("H:i:s", $row->tsend-$row->tsstart).'</td>
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
					<a href="{path}Vanilla/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page=1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}Vanilla/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page='.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}Vanilla/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page='.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}Vanilla/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page='.$max.'"><button class="icon-button icon-darrowright"></button></a>
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
		
		if ((!isset($name) || $this->name == "") and isset($_COOKIE["vroname"]))
			$this->name = $_COOKIE["vroname"];
		else
			setcookie("vroname", $this->name, time()+8640000);
		if ((!isset($duration) || $this->duration == "") and isset($_COOKIE["vroduration"]))
			$this->duration = $_COOKIE["vroduration"];
		else
			setcookie("vroduration", $this->duration, time()+8640000);
		if (!isset($realm) and isset($_COOKIE["vrorealm"]))
			$this->realm = intval($_COOKIE["vrorealm"]);
		else
			setcookie("vrorealm", $this->realm, time()+8640000);
		if (!isset($faction) and isset($_COOKIE["vrofaction"]))
			$this->faction = intval($_COOKIE["vrofaction"]);
		else
			setcookie("vrofaction", $this->faction, time()+8640000);
		if (!isset($raid) and isset($_COOKIE["vroraid"]))
			$this->raid = intval($_COOKIE["vroraid"]);
		else
			setcookie("vroraid", $this->raid, time()+8640000);
		
		if ($this->page <= 0)
			$this->page = 1;
		$this->siteTitle = " - Classic raids";
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["name"], $_GET["date"], $_GET["duration"], $_GET["realm"], $_GET["faction"], $_GET["raid"], $_GET["page"]);

?>