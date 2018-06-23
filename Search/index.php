<?php
require(dirname(__FILE__)."/../init.php");

class Home extends Site{
	private $val = "";
	private $realm = 0;
	private $faction = 0;
	private $classById = 0;
	private $classesById = array(
		1 => "warrior",
		2 => "rogue",
		3 => "priest",
		4 => "hunter",
		5 => "druid",
		6 => "mage",
		7 => "warlock",
		8 => "paladin",
		9 => "shaman",
		10 => "deathknight",
	);
	private $check = array();
	private $page = 1;
	private $expansion = array(
		0 => "Vanilla",
		1 => "TBC",
		2 => "WOTLK",
	);
	private $gender = array(
		1 => "male",
		2 => "male",
		3 => "female",
	);
	private $race = array(
		1 => "human",
		2 => "dwarf",
		3 => "nightelf",
		4 => "gnome",
		5 => "orc",
		6 => "undead",
		7 => "troll",
		8 => "tauren",
		9 => "draenei",
		10 => "bloodelf"
	);
	
	private function getName(){
		if ($this->val and $this->val != ""){
			$this->check[1] = true;
			return 'WHERE a.name LIKE "%'.$this->val.'%" ';
		}
		return '';
	}
	
	private function getRealm(){
		if ($this->realm and $this->realm != 0){
			$this->check[2] = true;
			return ($r = ($this->check[1]) ? "AND " : "").'a.serverid = '.$this->realm.' ';
		}
		return '';
	}
	
	private function getFaction(){
		if ($this->faction and $this->faction != 0){
			$this->check[3] = true;
			return ($r = ($this->check[2] or ($this->check[1] and !$this->check[2])) ? "AND " : "").'a.faction = '.$this->faction.' ';
		}
		return '';
	}
	
	private function getClass(){
		if ($this->classById and $this->classById != 0)
			return ($r = ($this->check[3] or ($this->check[1] and !$this->check[2] and !$this->check[3]) or (!$this->check[1] and $this->check[2] and !$this->check[3])) ? "AND " : "").'a.classid = '.$this->classById.' ';
		return '';
	}
	
	private function getSeenString($time){
		if ($time==0)
			return "-";
		$days = floor((time()-$time)/86400);
		if ($days==0)
			return "today";
		if ($days==1)
			return "1 day ago";
		if ($days>30 && $days<60)
			return "1 month ago";
		if ($days>=60)
			return floor($days/30)." months ago";
		return $days." days ago";
	}
	
	public function content(){
		$q1 = $this->db->query('SELECT b.name as servername, a.name, a.faction, b.expansion FROM guilds a JOIN servernames b ON a.serverid = b.id '.$this->getName().$this->getRealm().$this->getFaction().' LIMIT '.(($this->page-1)*14).', 14');
		$q2 = $this->db->query('SELECT b.name as servername, a.name, a.classid, a.faction, c.name as gname, seen, b.expansion, d.gender, d.race FROM chars a JOIN servernames b ON a.serverid = b.id LEFT JOIN guilds c ON a.guildid = c.id LEFT JOIN armory d ON a.id = d.charid '.$this->getName().$this->getRealm().$this->getFaction().$this->getClass().' ORDER BY d.seen DESC LIMIT '.(($this->page-1)*14).', 14');
		$q3 = $this->db->query('SELECT b.name as servername, a.name, a.classid, a.faction, c.name as gname, seen FROM chars a JOIN servernames b ON a.serverid = b.id LEFT JOIN guilds c ON a.guildid = c.id LEFT JOIN armory d ON a.id = d.charid '.$this->getName().$this->getRealm().$this->getFaction().$this->getClass());
		$q4 = $this->db->query('SELECT b.name as servername, a.name, a.faction FROM guilds a JOIN servernames b ON a.serverid = b.id '.$this->getName().$this->getRealm().$this->getFaction());
		$max = ceil($q3->rowCount()/14);
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>Search results for "'.$this->val.'" ('.($q3->rowCount()+$q4->rowCount()).')</h1>
					<p>
						This list contains the guilds/players with the name matching "'.$this->val.'". The search includes all servers and factions.
					</p>
					
				</div>
			</section>
			<section class="centredNormal top">
				<form action="{path}Search">
					<select name="realm">
						<option value="0"'.($r = ($this->realm==0) ? " selected" : "").'>Any realm</option>
			';
				foreach($this->db->query('SELECT * FROM servernames') as $row){
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
					<select name="class">
						<option value="0"'.($r = ($this->classById==0) ? " selected" : "").'>Any class</option>
						<option value="1"'.($r = ($this->classById==1) ? " selected" : "").' class="color-warrior">Warrior</option>
						<option value="2"'.($r = ($this->classById==2) ? " selected" : "").' class="color-rogue">Rogue</option>
						<option value="3"'.($r = ($this->classById==3) ? " selected" : "").' class="color-priest">Priest</option>
						<option value="4"'.($r = ($this->classById==4) ? " selected" : "").' class="color-hunter">Hunter</option>
						<option value="5"'.($r = ($this->classById==5) ? " selected" : "").' class="color-druid">Druid</option>
						<option value="6"'.($r = ($this->classById==6) ? " selected" : "").' class="color-mage">Mage</option>
						<option value="7"'.($r = ($this->classById==7) ? " selected" : "").' class="color-warlock">Warlock</option>
						<option value="8"'.($r = ($this->classById==8) ? " selected" : "").' class="color-paladin">Paladin</option>
						<option value="9"'.($r = ($this->classById==9) ? " selected" : "").' class="color-shaman">Shaman</option>
						<option value="10"'.($r = ($this->classById==10) ? " selected" : "").' class="color-deathknight">Death Knight</option>
					</select>
					<input type="search" placeholder="Press enter to search" name="val" value="'.$this->val.'" required />
				</form>
				<div class="pleft">
					<a href="{path}Search/?realm='.$this->realm.'&faction='.$this->faction.'&class='.$this->classById.'&val='.$this->val.'&page=1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}Search/?realm='.$this->realm.'&faction='.$this->faction.'&class='.$this->classById.'&val='.$this->val.'&page='.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}Search/?realm='.$this->realm.'&faction='.$this->faction.'&class='.$this->classById.'&val='.$this->val.'&page='.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}Search/?realm='.$this->realm.'&faction='.$this->faction.'&class='.$this->classById.'&val='.$this->val.'&page='.$max.'"><button class="icon-button icon-darrowright"></button></a>
				</div>
			</section>
			<section class="centredNormal cont">
				<div class="table half">
					<div class="right">
						<table cellspacing="0">
							<tr>
								<th colspan="2">Guilds matching "'.$this->val.'" ('.$q4->rowCount().')</th>
							</tr>
		';
		foreach ($q1 as $row){
			$fac = ($row->faction == 1) ? "alliance" : "horde";
			$content .= '
							<tr>
								<td class="lstring char"><img src="img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}'.$this->expansion[$row->expansion].'/Guild/'.$row->servername.'/'.$row->name.'/0">'.$row->name.'</a></td>
								<td class="sstring">'.$row->servername.'</td>
							</tr>
			';
		}
		$content .= '
						</table>
					</div>
				</div>
				<div class="table half h-margin">
					<div class="right">
						<table cellspacing="0" class="plata">
							<tr>
								<th colspan="4">Players matching "'.$this->val.'" ('.$q3->rowCount().')</th>
							</tr>
		';
		foreach ($q2 as $row){
			$fac = ($row->faction == 1) ? "alliance" : "horde";
			$content .= '
							<tr>
								<td class="cha chaar"><img src="../Database/racegender/Ui-charactercreate-races_'.$this->race[$row->race].'-'.$this->gender[$row->gender].'-small.png" /><img src="img/c'.$row->classid.'.png" /><a class="color-'.$this->classesById[$row->classid].'" href="{path}'.$this->expansion[$row->expansion].'/Armory/'.$row->servername.'/'.$row->name.'/0">'.$row->name.'</a></td>
								<td class="gui char"><img src="img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}'.$this->expansion[$row->expansion].'/Guild/'.$row->servername.'/'.$row->gname.'/0">'.substr($row->gname, 0, 18).'</a></td>
								<td class="rel">'.$row->servername.'</td>
								<td class="seen" title="Last update">'.$this->getSeenString($row->seen).'</td>
							</tr>
			';
		}
		$content .= '
						</table>
					</div>
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $val, $realm, $faction, $class, $page){
		$this->val = $this->antiSQLInjection($val);
		$this->realm = intval($this->antiSQLInjection($realm));
		$this->faction = intval($this->antiSQLInjection($faction));
		$this->classById = intval($this->antiSQLInjection($class));
		$this->page = intval($this->antiSQLInjection($page));
		if ($this->page==0)
			$this->page=1;
		$this->siteTitle = "Search";
		$this->keyWords = "search, armory search, information";
		$this->metadesc = "Search for character and guilds in the Legacy Logs database. This provides you easy access to the character and guild's stats and armory.";
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["val"], $_GET["realm"], $_GET["faction"], $_GET["class"], $_GET["page"]);

?>