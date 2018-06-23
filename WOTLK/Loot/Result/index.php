<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $item = 0;
	public $bossPos = array(10184=>1,16028=>2,15931=>3,15932=>4,15928=>5,15956=>6,15953=>7,15952=>8,16061=>9,16060=>10,50005=>11,15954=>12,15936=>13,16011=>14,15989=>15,15990=>16,28859=>17,31125=>18,33993=>19,35013=>20,38433=>21,30451=>22,30452=>23,30449=>24,28860=>25,33118=>26,33186=>27,33293=>28,50000=>29,32930=>30,33515=>31,33244=>32,32906=>33,32865=>34,32845=>35,33271=>36,33288=>37,32871=>38,50001=>39,34780=>40,50002=>41,50003=>42,34564=>43,36612=>44,36855=>45,50007=>46,37813=>47,36626=>48,36627=>49,36678=>50,50004=>51,37955=>52,37950=>53,36853=>54,36597=>55,39823=>56,39751=>57,39805=>58,39863=>59,36538=>1,31099=>2,29373=>3,29417=>4,29448=>5,29249=>6,29268=>7,29278=>8,29940=>9,29955=>10,50021=>11,29615=>12,29701=>13,29718=>14,29991=>15,30061=>16,31734=>17,31722=>18,33994=>19,35360=>20,38462=>21,31520=>22,31534=>23,31535=>24,31311=>25,33190=>26,33724=>27,33885=>28,50008=>29,33909=>30,34175=>31,50025=>32,33360=>33,33147=>34,32846=>35,33449=>36,33955=>37,33070=>38,50009=>39,35216=>40,50012=>41,50015=>42,34566=>43,37957=>44,38106=>45,50022=>46,38402=>47,37504=>48,38390=>49,38431=>50,50018=>51,38434=>52,38174=>53,38265=>54,39166=>55,39747=>56,39899=>57,39746=>58,40142=>59,50010=>39,35268=>40,50013=>41,50016=>42,35615=>43,37958=>44,38296=>45,50023=>46,38582=>47,37505=>48,38549=>49,38585=>50,50019=>51,38435=>52,38589=>53,38266=>54,39167=>55,39864=>59,50011=>39,35269=>40,50014=>41,50017=>42,35616=>43,37959=>44,38297=>45,50024=>46,38583=>47,37506=>48,38550=>49,38586=>50,50020=>51,38436=>52,38590=>53,38267=>54,39168=>55,40143=>59);
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
		
	private function getRankingsLink($id){
		$link = "0";
		for ($i=1; $i<$this->bossPos[$id]; $i++){
			$link .= "0";
		}
		$link .= "1";
		return $link;
	}
	
	public function content(){
		$info = $this->db->query('SELECT * FROM items WHERE id = "'.$this->item.'";')->fetch();
		$content = '
		<div class="container" id="container">
			<section class="ttitle">
				Item: <a href="index.php?item='.$this->item.'">'.$info->name.'</a>
			</section>
			<section class="centredNormal">
				<div class="sepbox">
					<div class="table half ts">
						<div class="right">
							<table>
								<tr>
									<th colspan="3">Recent drops</th>
								</tr>
			';
				foreach($this->db->query('SELECT a.loot, b.npcid, c.guildid, b.time, d.name as npc, e.name, b.rid, f.name as sname, a.attemptid, e.faction FROM `wotlk-raids-loot` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id LEFT JOIN `wotlk-raids` c ON b.rid = c.id LEFT JOIN tbc_npcs d ON b.npcid = d.id LEFT JOIN guilds e ON c.guildid = e.id LEFT JOIN servernames f ON e.serverid = f.id WHERE f.expansion=2 AND a.loot = "'.$this->item.'" LIMIT 10') as $row){
					$fac = ($row->faction == 1) ? "alliance" : "horde";
					$content .= '
								<tr>
									<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->npc.'</a></td>
									<td class="lstring guild"><img src="../../Raids/img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}WOTLK/Guild/'.$row->sname.'/'.$row->name.'/0">'.$row->name.'</a></td>
									<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->attemptid.'">'.date("d.m.y H:i", $row->time).'</a></td>
								</tr>
					';
				}
			$content .= '
							</table>
						</div>
					</div>
					<div class="table quarter ts">
						<div class="right">
							<table>
								<tr>
									<th colspan="2">Drops for guilds</th>
								</tr>
			';
				foreach($this->db->query('SELECT d.name, COUNT(a.id) AS amount, e.name AS sname, d.faction FROM `wotlk-raids-loot` a LEFT JOIN `wotlk-raids-attempts` b ON a.`attemptid` = b.id LEFT JOIN `wotlk-raids` c ON b.rid = c.id LEFT JOIN guilds d ON c.`guildid` = d.id LEFT JOIN servernames e ON d.`serverid` = e.id WHERE e.expansion=2 AND a.loot = "'.$this->item.'" GROUP BY d.`name`;') as $row){
					$fac = ($row->faction == 1) ? "alliance" : "horde";
					$content .= '
								<tr>
									<td class="guild"><img src="../../Raids/img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}WOTLK/Guild/'.$row->sname.'/'.$row->name.'/0">'.$row->name.'</a></td>
									<td class="num">'.$row->amount.'</td>
								</tr>
					';
				}
			$content .= '
							</table>
						</div>
					</div>
					<div class="table quarter margin-half ts">
						<div class="right">
							<table>
								<tr>
									<th colspan="2">Drops by bosses</th>
								</tr>
			';
				foreach($this->db->query('SELECT d.name, COUNT(a.id) AS amount, b.npcid FROM `wotlk-raids-loot` a LEFT JOIN `wotlk-raids-attempts` b ON a.`attemptid` = b.id LEFT JOIN tbc_npcs d ON b.`npcid` = d.id WHERE a.loot = "'.$this->item.'" GROUP BY d.`name`;') as $row){
					$content .= '
								<tr>
									<td><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->name.'</a></td>
									<td class="num">'.$row->amount.'</td>
								</tr>
					';
				}
			$content .= '
							</table>
						</div>
					</div>
				</div>
				<div class="sepbox margin-half ts">
					<div class="table half">
						<div class="right">
							<table>
								<tr>
									<th colspan="4">Player received</th>
								</tr>
			';
				foreach ($this->db->query('SELECT f.name AS sname, d.name AS cname, b.time, b.rid, a.`attemptid`, d.`classid`, e.`name` AS gname, d.classid, d.faction FROM `wotlk-raids-loot` a LEFT JOIN `wotlk-raids-attempts` b ON a.`attemptid` = b.`id` LEFT JOIN `wotlk-raids` c ON b.`rid` = c.`id` LEFT JOIN chars d ON a.`charid` = d.`id` LEFT JOIN guilds e ON d.`guildid` = e.`id` LEFT JOIN servernames f ON d.`serverid` = f.`id` WHERE f.expansion=2 AND a.loot = "'.$this->item.'"') as $row){
					$fac = ($row->faction == 1) ? "alliance" : "horde";
					$content .= '
								<tr>
									<td class="sstring char"><img src="../../../Database/classes/c'.$row->classid.'.png" /><a class="color-'.$this->classById[$row->classid].'" href="{path}WOTLK/Character/'.$row->sname.'/'.$row->cname.'/0">'.($r = ($row->cname) ? $row->cname : "Unknown").'</a></td>
									<td class="sstring guild"><img src="../../Raids/img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}WOTLK/Guild/'.$row->sname.'/'.$row->sname.'/0">'.($r = ($row->gname) ? $row->gname : "-").'</a></td>
									<td class="vstring">'.($r = ($row->sname) ? $row->sname : "Unknown").'</td>
									<td class="vstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->attemptid.'">'.date("d.m.y H:i", $row->time).'</a></td>
								</tr>
					';
				}
			$content .= '
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $item){
		$this->item = intval($this->antiSQLInjection($item));
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js");
		$this->addJsLink("{path}External/TwinheadTooltip/functions.js?ts=1");
		$this->addJsLink("{path}External/TwinheadTooltip/tooltip.js?ts=1");
		$this->addJsLink("{path}External/TwinheadTooltip/twinhead_tooltip.js?ts=1");
		$this->addCssLink("{path}External/TwinheadTooltip/twinhead_tooltip.css?ts=1");
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["item"]);

?>