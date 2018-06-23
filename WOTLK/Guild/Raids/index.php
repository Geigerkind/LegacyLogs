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
		9 => "shaman",
		10 => "deathknight",
	);
	private $raidsById = array(
		2 => "Single Bosses",
		25 => "Onyxia's Lair 10", // 10 
		26 => "Onyxia's Lair 25", // 25
		27 => "Naxxramas 10", // 10
		28 => "Naxxramas 25", // 25
		29 => "The Eye of Eternity 10", // 10
		30 => "The Eye of Eternity 25", // 25
		31 => "Vault of Archavon 10", // 10
		32 => "Vault of Archavon 25", // 25
		33 => "The Obsidian Sanctum 10", // 10
		34 => "The Obsidian Sanctum 25", // 25
		35 => "Ulduar 10", // 10
		36 => "Ulduar 25", // 25
		37 => "Trial of the Crusader 10 NHC", // 10
		38 => "Trial of the Crusader 25 NHC", // 25
		39 => "Trial of the Crusader 10 HC", // 10 HC
		40 => "Trial of the Crusader 25 HC", // 25 HC
		41 => "Icecrown Citadel 10 NHC", // 10
		42 => "Icecrown Citadel 25 NHC", // 25
		43 => "Icecrown Citadel 10 HC", // 10 HC
		44 => "Icecrown Citadel 25 HC", // 25 HC
		45 => "The Ruby Sanctum 10 NHC", // 10
		46 => "The Ruby Sanctum 25 NHC", // 25
		47 => "The Ruby Sanctum 10 HC", // 10 HC
		48 => "The Ruby Sanctum 25 HC", // 25 HC
	);
	public $instanceLink = Array(
		25 => "01",
		26 => "01",
		27 => "00111111111111111",
		28 => "00111111111111111",
		29 => "000000000000000001",
		30 => "000000000000000001",
		31 => "0000000000000000001111",
		32 => "0000000000000000001111",
		33 => "00000000000000000000000001",
		34 => "00000000000000000000000001",
		35 => "000000000000000000000000001111111111111",
		36 => "000000000000000000000000001111111111111",
		37 => "00000000000000000000000000000000000000011111",
		38 => "00000000000000000000000000000000000000011111",
		39 => "00000000000000000000000000000000000000011111",
		40 => "00000000000000000000000000000000000000011111",
		41 => "00000000000000000000000000000000000000000000111111111111",
		42 => "00000000000000000000000000000000000000000000111111111111",
		43 => "00000000000000000000000000000000000000000000111111111111",
		44 => "00000000000000000000000000000000000000000000111111111111",
		45 => "000000000000000000000000000000000000000000000000000000001111",
		46 => "000000000000000000000000000000000000000000000000000000001111",
		47 => "000000000000000000000000000000000000000000000000000000001111",
		48 => "000000000000000000000000000000000000000000000000000000001111",
	);
	
	private function getInformation($db){
		$this->info = $db->query('SELECT a.id FROM guilds a LEFT JOIN servernames b ON b.id = a.serverid WHERE a.name = "'.$this->name.'" AND b.name = "'.$this->sname.'" AND expansion = 2')->fetch();
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
		$count = $this->db->query('SELECT id FROM `wotlk-raids` WHERE guildid = "'.$this->info->id.'" AND rdy = 1;')->rowCount();
		$max = floor($count/15+1);
		$i = 0;
		foreach ($this->db->query('SELECT id, tsstart, nameid FROM `wotlk-raids` WHERE guildid = "'.$this->info->id.'" AND rdy = 1 ORDER BY id DESC LIMIT '.(($this->page-1)*15).', 15') as $row){
			$content .= '
						<tr>
							<td>'.($count-$i-$this->page*15+15).'</td>
							<td><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$row->id.'">'.date('d.m.y H:i', $row->tsstart).'</a></td>
							<td class="char"><img src="{path}WOTLK/Guild/img/'.$row->nameid.'.png" /><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->raidsById[$row->nameid].'</a></td>
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
					<a href="{path}WOTLK/Guild/Raids/'.$this->sname.'/'.$this->name.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}WOTLK/Guild/Raids/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}WOTLK/Guild/Raids/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}WOTLK/Guild/Raids/'.$this->sname.'/'.$this->name.'/'.$max.'"><button class="icon-button icon-darrowright"></button></a>
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