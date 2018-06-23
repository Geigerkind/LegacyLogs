<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $page = 1;
	private $itemInfo = array();
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
	private $item = 0;
	
	private function getItemInfo($db){
		$this->itemInfo = $db->query('SELECT entry, icon, name, quality FROM `item_template-tbc` WHERE entry = "'.$this->item.'";')->fetch();
	}
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1><img class="qe'.$this->itemInfo->quality.'" src="{path}Database/icons/medium/'.$this->itemInfo->icon.'.jpg" /><a class="q'.$this->itemInfo->quality.'" href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemInfo->entry.'">'.$this->itemInfo->name.'</a></h1>
					<p>
						Listing all players that wore this item, sorted by date.
					</p>
				</div>
			</section>
			<section class="table rt ts">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th class="date">First seen</th>
							<th class="mes">Name</th>
							<th class="mes">Guild</th>
						</tr>
		';
		$q = $this->db->query('SELECT a.id FROM `armory-itemhistory` a LEFT JOIN chars b ON a.charid = b.id WHERE b.serverid = "'.$this->serverByNames[$this->servername].'" AND item = "'.$this->item.'";');
		foreach($this->db->query('SELECT a.timestamp, b.name, b.classid, b.faction, c.name as gname FROM `armory-itemhistory` a LEFT JOIN chars b ON a.charid = b.id LEFT JOIN guilds c ON b.guildid = c.id WHERE b.serverid = "'.$this->serverByNames[$this->servername].'" AND item = "'.$this->item.'" ORDER BY a.id LIMIT '.(($this->page-1)*15).', 15;') as $row){
			$fac = ($row->faction==-1) ? "horde" : "alliance";
			$content .= '
				<tr>
					<td>'.date("d.m.y H:i", $row->timestamp).'</td>
					<td class="pve"><img src="{path}Database/classes/c'.$row->classid.'.png" /><a class="color-'.$this->classById[$row->classid].'" href="{path}TBC/Armory/'.$this->servername.'/'.$row->name.'">'.$row->name.'</a></td>
					<td><img class="facicon" src="{path}TBC/Armory/img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}TBC/Guild/'.$this->servername.'/'.$row->gname.'">'.$row->gname.'</a></td>
				</tr>
			';
		}
		$max = ceil($q->rowCount()/15);
		$content .= '
					</table>
				</div>
			</section>
			<footer class="pager">
				<div class="pleft">
					<a href="{path}TBC/Armory/Items/'.$this->servername.'/'.$this->item.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}TBC/Armory/Items/'.$this->servername.'/'.$this->item.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}TBC/Armory/Items/'.$this->servername.'/'.$this->item.'/'.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}TBC/Armory/Items/'.$this->servername.'/'.$this->item.'/'.$max.'"><button class="icon-button icon-darrowright"></button></a>
				</div>
			</footer>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $page, $server){
		$this->item = intval($this->antiSQLInjection($_GET["id"]));
		$this->getItemInfo($db);
		$this->servername = $this->antiSQLInjection($server);
		$this->page = intval($this->antiSQLInjection($page));
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

new Home($db, __DIR__, $_GET["page"], $_GET["server"]);

?>