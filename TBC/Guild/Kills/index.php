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
	public $bossPos = Array(18728 => 1, 17711 => 2, 22887 => 3, 22898 => 4, 22841 => 5, 22871 => 6, 22948 => 7, 50002 => 8, 22947 => 9, 23426 => 10, 22917 => 11, 21216 => 12, 21217 => 13, 21215 => 14, 21214 => 15, 21213 => 16, 21212 => 17, 15550 => 18, 15687 => 19, 50001 => 20, 16457 => 21, 15691 => 22, 15688 => 23, 16524 => 24, 15689 => 25, 15690 => 26, 17225 => 27, 18831 => 28, 19044 => 29, 17257 => 30, 23576 => 31, 23578 => 32, 23574 => 33, 23577 => 34, 23863 => 35, 19514 => 36, 19516 => 37, 18805 => 38, 19622 => 39, 17767 => 40, 17808 => 41, 17888 => 42, 17842 => 43, 17968 => 44, 24850 => 45, 24882 => 46, 25038 => 47, 50000 => 48, 25741 => 49, 25608 => 50, 24239 => 51); 
	
	private function getRankingsLink($id){
		$link = "0";
		for ($i=1; $i<$this->bossPos[$id]; $i++){
			$link .= "0";
		}
		$link .= "1";
		return $link;
	}
	
	private function getInformation($db){
		$this->info = $db->query('SELECT a.id FROM guilds a LEFT JOIN servernames b ON b.id = a.serverid WHERE a.name = "'.$this->name.'" AND b.name = "'.$this->sname.'" AND expansion = 1')->fetch();
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
							<th class="char">Boss</th>
						</tr>
		';
		$count = $this->db->query('SELECT a.id FROM `tbc-raids-attempts` a LEFT JOIN `tbc-raids` b ON a.rid = b.id LEFT JOIN tbc_npcs c ON a.npcid = c.id WHERE c.type = 1 AND b.guildid = "'.$this->info->id.'" AND b.rdy = 1 AND a.type = 1;')->rowCount();
		$max = floor($count/15+1);
		$i = 0;
		foreach ($this->db->query('SELECT c.name as boss, a.id, a.time, b.id as rid, a.npcid, b.nameid FROM `tbc-raids-attempts` a LEFT JOIN `tbc-raids` b ON a.rid = b.id LEFT JOIN tbc_npcs c ON a.npcid = c.id WHERE c.type = 1 AND b.guildid = "'.$this->info->id.'" AND b.rdy = 1 AND a.type = 1 ORDER BY a.time DESC LIMIT '.(($this->page-1)*15).', 15') as $row){
			$content .= '
						<tr>
							<td>'.($count-$i-$this->page*15+15).'</td>
							<td><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->id.'">'.date('d.m.y H:i', $row->time).'</a></td>
							<td class="char"><img src="{path}TBC/Guild/img/'.$row->nameid.'.png" /><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->raidsById[$row->nameid].'</a></td>
							<td><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->boss.'</a></td>
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
					<a href="{path}TBC/Guild/Kills/'.$this->sname.'/'.$this->name.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}TBC/Guild/Kills/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}TBC/Guild/Kills/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}TBC/Guild/Kills/'.$this->sname.'/'.$this->name.'/'.$max.'"><button class="icon-button icon-darrowright"></button></a>
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