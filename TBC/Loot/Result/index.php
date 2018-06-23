<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $item = 0;
	private $bossPos = Array(18728 => 1, 17711 => 2, 22887 => 3, 22898 => 4, 22841 => 5, 22871 => 6, 22948 => 7, 50002 => 8, 22947 => 9, 23426 => 10, 22917 => 11, 21216 => 12, 21217 => 13, 21215 => 14, 21214 => 15, 21213 => 16, 21212 => 17, 15550 => 18, 15687 => 19, 50001 => 20, 16457 => 21, 15691 => 22, 15688 => 23, 16524 => 24, 15689 => 25, 15690 => 26, 17225 => 27, 18831 => 28, 19044 => 29, 19703 => 30, 23576 => 31, 23578 => 32, 23574 => 33, 23577 => 34, 23863 => 35, 19514 => 36, 19516 => 37, 18805 => 38, 19622 => 39, 17767 => 40, 17808 => 41, 17888 => 42, 17842 => 43, 17968 => 44, 24850 => 45, 24882 => 46, 25038 => 47, 50000 => 48, 25741 => 49, 25608 => 50); 
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
				foreach($this->db->query('SELECT a.loot, b.npcid, c.guildid, b.time, d.name as npc, e.name, b.rid, f.name as sname, a.attemptid, e.faction FROM `tbc-raids-loot` a LEFT JOIN `tbc-raids-attempts` b ON a.attemptid = b.id LEFT JOIN `tbc-raids` c ON b.rid = c.id LEFT JOIN tbc_npcs d ON b.npcid = d.id LEFT JOIN guilds e ON c.guildid = e.id LEFT JOIN servernames f ON e.serverid = f.id WHERE f.expansion=1 AND a.loot = "'.$this->item.'" LIMIT 10') as $row){
					$fac = ($row->faction == 1) ? "alliance" : "horde";
					$content .= '
								<tr>
									<td class="lstring"><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->npc.'</a></td>
									<td class="lstring guild"><img src="../../Raids/img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}TBC/Guild/'.$row->sname.'/'.$row->name.'/0">'.$row->name.'</a></td>
									<td class="sstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->attemptid.'">'.date("d.m.y H:i", $row->time).'</a></td>
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
				foreach($this->db->query('SELECT d.name, COUNT(a.id) AS amount, e.name AS sname, d.faction FROM `tbc-raids-loot` a LEFT JOIN `tbc-raids-attempts` b ON a.`attemptid` = b.id LEFT JOIN `tbc-raids` c ON b.rid = c.id LEFT JOIN guilds d ON c.`guildid` = d.id LEFT JOIN servernames e ON d.`serverid` = e.id WHERE e.expansion=1 AND a.loot = "'.$this->item.'" GROUP BY d.`name`;') as $row){
					$fac = ($row->faction == 1) ? "alliance" : "horde";
					$content .= '
								<tr>
									<td class="guild"><img src="../../Raids/img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}TBC/Guild/'.$row->sname.'/'.$row->name.'/0">'.$row->name.'</a></td>
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
				foreach($this->db->query('SELECT d.name, COUNT(a.id) AS amount, b.npcid FROM `tbc-raids-loot` a LEFT JOIN `tbc-raids-attempts` b ON a.`attemptid` = b.id LEFT JOIN tbc_npcs d ON b.`npcid` = d.id WHERE a.loot = "'.$this->item.'" GROUP BY d.`name`;') as $row){
					$content .= '
								<tr>
									<td><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->name.'</a></td>
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
				foreach ($this->db->query('SELECT f.name AS sname, d.name AS cname, b.time, b.rid, a.`attemptid`, d.`classid`, e.`name` AS gname, d.classid, d.faction FROM `tbc-raids-loot` a LEFT JOIN `tbc-raids-attempts` b ON a.`attemptid` = b.`id` LEFT JOIN `tbc-raids` c ON b.`rid` = c.`id` LEFT JOIN chars d ON a.`charid` = d.`id` LEFT JOIN guilds e ON d.`guildid` = e.`id` LEFT JOIN servernames f ON d.`serverid` = f.`id` WHERE f.expansion=1 AND a.loot = "'.$this->item.'"') as $row){
					$fac = ($row->faction == 1) ? "alliance" : "horde";
					$content .= '
								<tr>
									<td class="sstring char"><img src="../../../Database/classes/c'.$row->classid.'.png" /><a class="color-'.$this->classById[$row->classid].'" href="{path}TBC/Character/'.$row->sname.'/'.$row->cname.'/0">'.($r = ($row->cname) ? $row->cname : "Unknown").'</a></td>
									<td class="sstring guild"><img src="../../Raids/img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}TBC/Guild/'.$row->sname.'/'.$row->sname.'/0">'.($r = ($row->gname) ? $row->gname : "-").'</a></td>
									<td class="vstring">'.($r = ($row->sname) ? $row->sname : "Unknown").'</td>
									<td class="vstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->attemptid.'">'.date("d.m.y H:i", $row->time).'</a></td>
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