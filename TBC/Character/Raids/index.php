<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $page = 1;
	private $name = "";
	private $sname = "";
	private $info = array();
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
	private $instanceLink = Array(
		2 => "0110000000000000000000000000001",
		14 => "01",
		15 => "001",
		16 => "000111111111",
		17 => "000000000000111111",
		18 => "0000000000000000001111111111",
		19 => "000000000000000000000000000011",
		20 => "0000000000000000000000000000001",
		21 => "000000000000000000000000000000011111",
		22 => "0000000000000000000000000000000000001111",
		23 => "000000000000000000000000000000000000000011111",
		24 => "000000000000000000000000000000000000000000000111111"
	);
	
	private function getInformation($db){
		$this->info = $db->query('SELECT a.id, b.id as sid, a.classid, a.guildid, c.name as gname, a.faction FROM chars a LEFT JOIN servernames b ON a.serverid = b.id LEFT JOIN guilds c ON a.guildid = c.id WHERE b.expansion=1 AND b.name = "'.$this->sname.'" AND a.name = "'.$this->name.'"')->fetch();
	}
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th>#</th>
							<th>Date</th>
							<th class="char">Instance</th>
						</tr>
		';
		$count = $this->db->query('SELECT a.id FROM `tbc-raids` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN `tbc-raids-participants` c ON a.id = c.rid WHERE (c.dps LIKE "%'.$this->info->id.'%" or c.healers LIKE "%'.$this->info->id.'%" or c.tanks LIKE "%'.$this->info->id.'%") AND a.rdy = 1')->rowCount();
		$max = floor($count/15+1);
		$i = 0;
		foreach ($this->db->query('SELECT a.tsstart, a.nameid, b.name, a.id FROM `tbc-raids` a LEFT JOIN guilds b ON a.guildid = b.id LEFT JOIN `tbc-raids-participants` c ON a.id = c.rid WHERE (c.dps LIKE "%'.$this->info->id.'%" or c.healers LIKE "%'.$this->info->id.'%" or c.tanks LIKE "%'.$this->info->id.'%") AND a.rdy = 1 ORDER BY a.id DESC LIMIT '.(($this->page-1)*15).', 15') as $row){
			$content .= '
						<tr>
							<td>'.($count-$i-$this->page*15+15).'</td>
							<td><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$row->id.'">'.date('d.m.y H:i', $row->tsstart).'</a></td>
							<td class="char"><img src="{path}TBC/Guild/img/'.$row->nameid.'.png" /><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->raidsById[$row->nameid].'</a></td>
						</tr>
			';
			$i++;
		}
		$content .= '
					</table>
				</div>
			</section>
			<footer class="pager">
				<div class="pleft">
					<a href="{path}TBC/Character/Raids/'.$this->sname.'/'.$this->name.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}TBC/Character/Raids/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}TBC/Character/Raids/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}TBC/Character/Raids/'.$this->sname.'/'.$this->name.'/'.$max.'"><button class="icon-button icon-darrowright"></button></a>
				</div>
			</footer>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $page, $server, $name){
		$this->page = intval($page);
		$this->sname = $this->antiSQLInjection($server);
		$this->name = $this->antiSQLInjection($name);
		if ($this->page <= 0)
			$this->page = 1;
		$this->getInformation($db);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["page"], $_GET["server"], $_GET["name"]);

?>