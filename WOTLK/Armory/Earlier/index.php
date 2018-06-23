<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $page = 1;
	private $serverById = array(
		19 => "Unknown",
		20 => "Frostmourne",
		21 => "Lordaeron",
		22 => "Icecrown",
		23 => "Blackrock",
		24 => "Hyperion",
		25 => "TrueWoW",
		26 => "Algalon",
		27 => "Kirin Tor",
		28 => "Legacy",
		29 => "Elysium",
		30 => "Redemption",
		31 => "WoW Circle x10",
		32 => "WoW Circle x25",
		33 => "WoW Circle x5",
		34 => "WoW Circle x1",
		35 => "Rising-Gods",
		41 => "Heroes Of Wow (3.3.5)",
		42 => "Feronis",
	);
	private $serverByNames = array(
		"Unknown" => 19,
		"Frostmourne" => 20,
		"Lordaeron" => 21,
		"Icecrown" => 22,
		"Blackrock [Pvp only]" => 23,
		"Hyperion" => 24,
		"TrueWoW" => 25,
		"Algalon" => 26,
		"Algalon - Main Realm" => 26,
		"Kirin Tor" => 27,
		"Legacy" => 28,
		"Legacy - Instant 80" => 28,
		"Elysium" => 29,
		"Redemption" => 30,
		"WoW Circle 3.3.5 x10" => 31,
		"WoW Circle 3.3.5 x25" => 32,
		"WoW Circle 3.3.5 x5" => 33,
		"WoW Circle 3.3.5 x1" => 34,
		"Rising-Gods" => 35,
		"Heroes Of Wow (3.3.5)" => 41,
		"Feronis" => 42,
	);
	private $classById = array(
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
	private $servername = "Unknown";
	private $name = "Unknown";
	private $userData = array();
	
	private function getUserInfo($db){
		$this->userData = $db->query('SELECT id, classid, faction FROM chars WHERE name = "'.$this->name.'" AND serverid = "'.$this->serverByNames[$this->servername].'";')->fetch();
	}
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>Itemhistory of <a class="color-'.$this->classById[$this->userData->classid].'" href="{path}WOTLK/Armory/'.$this->servername.'/'.$this->name.'">'.$this->name.'</a> on '.$this->servername.'</h1>
					<p>
						Listing all items that were collected and used by this character, sorted by data collection date.
					</p>
				</div>
			</section>
			<section class="table rt ts">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th class="date">Date</th>
							<th class="mes">Item</th>
						</tr>
		';
		foreach($this->db->query('SELECT item, timestamp, b.name, b.icon, b.quality FROM `armory-itemhistory` a LEFT JOIN `item_template-wotlk` b ON a.item = b.entry WHERE charid = "'.$this->userData->id.'" ORDER BY id DESC LIMIT '.(($this->page-1)*15).', 15;') as $row){
			$content .= '
				<tr>
					<td class="date">'.date("d.m.y H:i:s", $row->timestamp).'</td>
					<td class="pve rest"><img class="qe'.$row->quality.'" src="{path}Database/icons/small/'.$row->icon.'.jpg" /><a class="q'.$row->quality.'" href="https://wotlk-twinhead.twinstar.cz/?item='.$row->item.'">'.$row->name.'</a></td>
				</tr>
			';
		}
		$max = ceil($this->db->query('SELECT id FROM `armory-itemhistory` WHERE charid = "'.$this->userData->id.'";')->rowCount()/15);
		$content .= '
					</table>
				</div>
			</section>
			<footer class="pager">
				<div class="pleft">
					<a href="{path}WOTLK/Armory/Earlier/'.$this->servername.'/'.$this->name.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}WOTLK/Armory/Earlier/'.$this->servername.'/'.$this->name.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}WOTLK/Armory/Earlier/'.$this->servername.'/'.$this->name.'/'.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}WOTLK/Armory/Earlier/'.$this->servername.'/'.$this->name.'/'.$max.'"><button class="icon-button icon-darrowright"></button></a>
				</div>
			</footer>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $page){
		$this->page = intval($page);
		$this->servername = $this->antiSQLInjection($_GET["server"]);
		$this->name = $this->antiSQLInjection($_GET["name"]);
		$this->getUserInfo($db);
		if ($this->page <= 0)
			$this->page = 1;
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js");
		$this->addJsLink("{path}External/TwinheadTooltip/functions.js");
		$this->addJsLink("{path}External/TwinheadTooltip/tooltip.js");
		$this->addJsLink("{path}External/TwinheadTooltip/twinhead_tooltip.js");
		$this->addCssLink("{path}External/TwinheadTooltip/twinhead_tooltip.css");
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["page"]);

?>