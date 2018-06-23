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
	private $instanceLink = Array(1 => "01111111111", 2 => "00000000001", 3 => "00000000000000000011111111", 4 => "00000000000000000000000000111111111111", 5 => "00000000000000000000000000000000000000111111", 6 => "00000000000000000000000000000000000000000000111111111", 7 => "00000000000000000000000000000000000000000000000000000111111111111111", 8 => "000000000000001111", 9 => "00000000000001", 10 => "0000000000001", 11 => "000000000000001111", 12 => "000000000000001111", 13 => "000000000000001111", 14 => "00000000000000000000000000000000000000000000111111111");
	
	
	private function getInformation($db){
		$this->info = $db->query('SELECT a.id FROM guilds a LEFT JOIN servernames b ON b.id = a.serverid WHERE a.name = "'.$this->name.'" AND b.name = "'.$this->sname.'"')->fetch();
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
		$count = $this->db->query('SELECT id FROM `v-raids` WHERE guildid = "'.$this->info->id.'" AND rdy = 1;')->rowCount();
		$max = floor($count/15+1);
		$i = 0;
		foreach ($this->db->query('SELECT id, tsstart, nameid FROM `v-raids` WHERE guildid = "'.$this->info->id.'" AND rdy = 1 ORDER BY id DESC LIMIT '.(($this->page-1)*15).', 15') as $row){
			$content .= '
						<tr>
							<td>'.($count-$i-$this->page*15+15).'</td>
							<td><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$row->id.'">'.date('d.m.y H:i', $row->tsstart).'</a></td>
							<td class="char"><img src="{path}Vanilla/Guild/img/'.$row->nameid.'.png" /><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->raidsById[$row->nameid].'</a></td>
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
					<a href="{path}Vanilla/Guild/Raids/'.$this->sname.'/'.$this->name.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}Vanilla/Guild/Raids/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}Vanilla/Guild/Raids/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}Vanilla/Guild/Raids/'.$this->sname.'/'.$this->name.'/'.$max.'"><button class="icon-button icon-darrowright"></button></a>
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