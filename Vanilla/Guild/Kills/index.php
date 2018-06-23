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
	private $bossPos = Array(12118 => 1, 11982 => 2, 12259 => 3, 12057 => 4, 12056 => 5, 12264 => 6, 12098 => 7, 11988 => 8, 12018 => 9, 11502 => 10, 10184 => 11, 12397 => 12, 6109 => 13, 14889 => 14, 14887 => 15, 14888 => 16, 14890 => 17, 12435 => 18, 13020 => 19, 12017 => 20, 11983 => 21, 14601 => 22, 11981 => 23, 14020 => 24, 11583 => 25, 14517 => 26, 14507 => 27, 14510 => 28, 11382 => 29, 15082 => 30, 15083 => 31, 15085 => 32, 15114 => 33, 14509 => 34, 14515 => 35, 11380 => 36, 14834 => 37, 15348 => 38, 15341 => 39, 15340 => 40, 15370 => 41, 15369 => 42, 15339 => 43, 15263 => 44, 50000 => 45, 15516 => 46, 15510 => 47, 15299 => 48, 15509 => 49, 50001 => 50, 15517 => 51, 15727 => 52, 16028 => 53, 15931 => 54, 15932 => 55, 15928 => 56, 15956 => 57, 15953 => 58, 15952 => 59, 16061 => 60, 16060 => 61, 50002 => 62, 15954 => 63, 15936 => 64, 16011 => 65, 15989 => 66, 15990 => 67);
	
	private function getRankingsLink($id){
		$link = "0";
		for ($i=1; $i<$this->bossPos[$id]; $i++){
			$link .= "0";
		}
		$link .= "1";
		return $link;
	}
	
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
							<th class="char">Boss</th>
						</tr>
		';
		$count = $this->db->query('SELECT a.id FROM `v-raids-attempts` a LEFT JOIN `v-raids` b ON a.rid = b.id LEFT JOIN npcs c ON a.npcid = c.id WHERE c.type = 1 AND b.guildid = "'.$this->info->id.'" AND b.rdy = 1 AND a.type = 1;')->rowCount();
		$max = floor($count/15+1);
		$i = 0;
		foreach ($this->db->query('SELECT c.name as boss, a.id, a.time, b.id as rid, a.npcid, b.nameid FROM `v-raids-attempts` a LEFT JOIN `v-raids` b ON a.rid = b.id LEFT JOIN npcs c ON a.npcid = c.id WHERE c.type = 1 AND b.guildid = "'.$this->info->id.'" AND b.rdy = 1 AND a.type = 1 ORDER BY a.time DESC LIMIT '.(($this->page-1)*15).', 15') as $row){
			$content .= '
						<tr>
							<td>'.($count-$i-$this->page*15+15).'</td>
							<td><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->id.'">'.date('d.m.y H:i', $row->time).'</a></td>
							<td class="char"><img src="{path}Vanilla/Guild/img/'.$row->nameid.'.png" /><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->raidsById[$row->nameid].'</a></td>
							<td><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->boss.'</a></td>
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
					<a href="{path}Vanilla/Guild/Kills/'.$this->sname.'/'.$this->name.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}Vanilla/Guild/Kills/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}Vanilla/Guild/Kills/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}Vanilla/Guild/Kills/'.$this->sname.'/'.$this->name.'/'.$max.'"><button class="icon-button icon-darrowright"></button></a>
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