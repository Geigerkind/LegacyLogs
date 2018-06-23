<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
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
			foreach($this->db->query('SELECT * FROM servernames WHERE expansion = 1') as $row){
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
						<option value="14"'.($r = ($this->raid==14) ? " selected" : "").'>Hellfire Peninsula</option>
						<option value="15"'.($r = ($this->raid==15) ? " selected" : "").'>Shadowmoon Valley</option>
						<option value="16"'.($r = ($this->raid==16) ? " selected" : "").'>Black Temple</option>
						<option value="17"'.($r = ($this->raid==17) ? " selected" : "").'>Serpentshrine Cavern</option>
						<option value="18"'.($r = ($this->raid==18) ? " selected" : "").'>Karazhan</option>
						<option value="19"'.($r = ($this->raid==19) ? " selected" : "").'>Gruul\'s Lair</option>
						<option value="20"'.($r = ($this->raid==20) ? " selected" : "").'>Magtheridon\'s Lair</option>
						<option value="21"'.($r = ($this->raid==21) ? " selected" : "").'>Zul\'Aman</option>
						<option value="22"'.($r = ($this->raid==22) ? " selected" : "").'>The Eye</option>
						<option value="23"'.($r = ($this->raid==23) ? " selected" : "").'>Hyjal Summit</option>
						<option value="24"'.($r = ($this->raid==24) ? " selected" : "").'>Sunwell Plateau</option>
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
			$count = $this->db->query('SELECT a.id, a.nameid, b.name as gname, c.name as sname, a.tsstart, a.tsend, b.faction FROM `tbc-raids` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id'.$this->getConditions())->rowCount();
			$max = floor($count/15+1);
			foreach ($this->db->query('SELECT a.id, a.nameid, b.name as gname, c.name as sname, a.tsstart, a.tsend, b.faction FROM `tbc-raids` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN servernames c ON b.serverid = c.id'.$this->getConditions().' ORDER BY a.tsend DESC LIMIT '.(($this->page-1)*15).' ,15') as $row){
				$fac = ($row->faction == 1) ? "alliance" : "horde";
				$content .= '
						<tr>
							<td class="num">'.($row->id).'</td>
							<td class="guild"><img src="img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}TBC/Guild/'.$row->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
							<td class="raid"><img src="img/'.$row->nameid.'.png" /><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$row->id.'">'.$this->raidsById[$row->nameid].'</a></td>
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
					<a href="{path}TBC/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page=1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}TBC/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page='.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}TBC/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page='.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}TBC/Raids/?name='.$this->name.'&date='.$this->date.'&duration='.$this->duration.'&realm='.$this->realm.'&faction='.$this->faction.'&raid='.$this->raid.'&page='.$max.'"><button class="icon-button icon-darrowright"></button></a>
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
		
		if ((!isset($name) || $this->name == "") and isset($_COOKIE["troname"]))
			$this->name = $_COOKIE["troname"];
		else
			setcookie("troname", $this->name, time()+8640000);
		if ((!isset($duration) || $this->duration == "") and isset($_COOKIE["troduration"]))
			$this->duration = $_COOKIE["troduration"];
		else
			setcookie("troduration", $this->duration, time()+8640000);
		if (!isset($realm) and isset($_COOKIE["trorealm"]))
			$this->realm = intval($_COOKIE["trorealm"]);
		else
			setcookie("trorealm", $this->realm, time()+8640000);
		if (!isset($faction) and isset($_COOKIE["trofaction"]))
			$this->faction = intval($_COOKIE["trofaction"]);
		else
			setcookie("trofaction", $this->faction, time()+8640000);
		if (!isset($raid) and isset($_COOKIE["troraid"]))
			$this->raid = intval($_COOKIE["troraid"]);
		else
			setcookie("troraid", $this->raid, time()+8640000);
		
		if ($this->page <= 0)
			$this->page = 1;
		$this->siteTitle = " - TBC raids";
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["name"], $_GET["date"], $_GET["duration"], $_GET["realm"], $_GET["faction"], $_GET["raid"], $_GET["page"]);

?>