<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $page = 1;
	private $serverByNames = array(
		"Unknown" => 11,
		"Hellfire" => 12,
		"B2B-TBC" => 13,
		"ExcaliburTBC" => 14,
		"Ares" => 15,
		"HellGround" => 16,
		"Smolderforge" => 17,
		"Archangel" => 18,
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
		9 => "shaman"
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
					<h1>Itemhistory of <a class="color-'.$this->classById[$this->userData->classid].'" href="{path}TBC/Armory/'.$this->servername.'/'.$this->name.'">'.$this->name.'</a> on '.$this->servername.'</h1>
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
		foreach($this->db->query('SELECT item, timestamp, b.name, b.icon, b.quality FROM `armory-itemhistory` a LEFT JOIN `item_template-tbc` b ON a.item = b.entry WHERE charid = "'.$this->userData->id.'" ORDER BY id DESC LIMIT '.(($this->page-1)*15).', 15;') as $row){
			$content .= '
				<tr>
					<td class="date">'.date("d.m.y H:i:s", $row->timestamp).'</td>
					<td class="pve rest"><img class="qe'.$row->quality.'" src="{path}Database/icons/small/'.$row->icon.'.jpg" /><a class="q'.$row->quality.'" href="https://TBC-twinhead.twinstar.cz/?item='.$row->item.'">'.$row->name.'</a></td>
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
					<a href="{path}TBC/Armory/Earlier/'.$this->servername.'/'.$this->name.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}TBC/Armory/Earlier/'.$this->servername.'/'.$this->name.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}TBC/Armory/Earlier/'.$this->servername.'/'.$this->name.'/'.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}TBC/Armory/Earlier/'.$this->servername.'/'.$this->name.'/'.$max.'"><button class="icon-button icon-darrowright"></button></a>
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