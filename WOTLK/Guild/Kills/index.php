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
	public $bossPos = array(10184=>1,16028=>2,15931=>3,15932=>4,15928=>5,15956=>6,15953=>7,15952=>8,16061=>9,16060=>10,50005=>11,15954=>12,15936=>13,16011=>14,15989=>15,15990=>16,28859=>17,31125=>18,33993=>19,35013=>20,38433=>21,30451=>22,30452=>23,30449=>24,28860=>25,33118=>26,33186=>27,33293=>28,50000=>29,32930=>30,33515=>31,33244=>32,32906=>33,32865=>34,32845=>35,33271=>36,33288=>37,32871=>38,50001=>39,34780=>40,50002=>41,50003=>42,34564=>43,36612=>44,36855=>45,50007=>46,37813=>47,36626=>48,36627=>49,36678=>50,50004=>51,37955=>52,36789=>53,36853=>54,36597=>55,39823=>56,39751=>57,39805=>58,39863=>59,36538=>1,31099=>2,29373=>3,29417=>4,29448=>5,29249=>6,29268=>7,29278=>8,29940=>9,29955=>10,50021=>11,29615=>12,29701=>13,29718=>14,29991=>15,30061=>16,31734=>17,31722=>18,33994=>19,35360=>20,38462=>21,31520=>22,31534=>23,31535=>24,31311=>25,33190=>26,33724=>27,33885=>28,50008=>29,33909=>30,34175=>31,50025=>32,33360=>33,33147=>34,32846=>35,33449=>36,33955=>37,33070=>38,50009=>39,35216=>40,50012=>41,50015=>42,34566=>43,37957=>44,38106=>45,50022=>46,38402=>47,37504=>48,38390=>49,38431=>50,50018=>51,38434=>52,38174=>53,38265=>54,39166=>55,39747=>56,39899=>57,39746=>58,40142=>59,50010=>39,35268=>40,50013=>41,50016=>42,35615=>43,37958=>44,38296=>45,50023=>46,38582=>47,37505=>48,38549=>49,38585=>50,50019=>51,38435=>52,38589=>53,38266=>54,39167=>55,39864=>59,50011=>39,35269=>40,50014=>41,50017=>42,35616=>43,37959=>44,38297=>45,50024=>46,38583=>47,37506=>48,38550=>49,38586=>50,50020=>51,38436=>52,38590=>53,38267=>54,39168=>55,40143=>59);
	
	private function getRankingsLink($id){
		$link = "0";
		for ($i=1; $i<$this->bossPos[$id]; $i++){
			$link .= "0";
		}
		$link .= "1";
		return $link;
	}
	
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
							<th class="char">Boss</th>
						</tr>
		';
		$count = $this->db->query('SELECT a.id FROM `wotlk-raids-attempts` a LEFT JOIN `wotlk-raids` b ON a.rid = b.id LEFT JOIN wotlk_npcs c ON a.npcid = c.id WHERE c.type = 1 AND b.guildid = "'.$this->info->id.'" AND b.rdy = 1 AND a.type = 1;')->rowCount();
		$max = floor($count/15+1);
		$i = 0;
		foreach ($this->db->query('SELECT c.name as boss, a.id, a.time, b.id as rid, a.npcid, b.nameid FROM `wotlk-raids-attempts` a LEFT JOIN `wotlk-raids` b ON a.rid = b.id LEFT JOIN wotlk_npcs c ON a.npcid = c.id WHERE c.type = 1 AND b.guildid = "'.$this->info->id.'" AND b.rdy = 1 AND a.type = 1 ORDER BY a.time DESC LIMIT '.(($this->page-1)*15).', 15') as $row){
			$content .= '
						<tr>
							<td>'.($count-$i-$this->page*15+15).'</td>
							<td><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->id.'">'.date('d.m.y H:i', $row->time).'</a></td>
							<td class="char"><img src="{path}WOTLK/Guild/img/'.$row->nameid.'.png" /><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->raidsById[$row->nameid].'</a></td>
							<td><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->boss.'</a></td>
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
					<a href="{path}WOTLK/Guild/Kills/'.$this->sname.'/'.$this->name.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}WOTLK/Guild/Kills/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}WOTLK/Guild/Kills/'.$this->sname.'/'.$this->name.'/'.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}WOTLK/Guild/Kills/'.$this->sname.'/'.$this->name.'/'.$max.'"><button class="icon-button icon-darrowright"></button></a>
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