<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $item = 0;
	private $bossPos = Array(12118 => 1, 11982 => 2, 12259 => 3, 12057 => 4, 12056 => 5, 12264 => 6, 12098 => 7, 11988 => 8, 11502 => 9, 10184 => 10, 12397 => 11, 6109 => 12, 14889 => 13, 14887 => 14, 14888 => 15, 14890 => 16, 13020 => 17, 12017 => 18, 11983 => 19, 14601 => 20, 11981 => 21, 14020 => 22, 11583 => 23, 14517 => 24, 14507 => 25, 14510 => 26, 11382 => 27, 15082 => 28, 15083 => 29, 15085 => 30, 15114 => 31, 14509 => 32, 14515 => 33, 11380 => 34, 14834 => 35, 15348 => 36, 15341 => 37, 15340 => 38, 15370 => 39, 15369 => 40, 15339 => 41, 15263 => 42, 15516 => 43, 15510 => 44, 15299 => 45, 15509 => 46, 15517 => 47, 15729 => 48, 16028 => 49, 15931 => 50, 15932 => 51, 15928 => 52, 15956 => 53, 15953 => 54, 15952 => 55, 16061 => 56, 16060 => 57, 15954 => 58, 15936 => 59, 16011 => 60, 15989 => 61, 15990 => 62);
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
				foreach($this->db->query('SELECT a.loot, b.npcid, c.guildid, b.time, d.name as npc, e.name, b.rid, f.name as sname, a.attemptid, e.faction FROM `v-raids-loot` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id LEFT JOIN `v-raids` c ON b.rid = c.id LEFT JOIN npcs d ON b.npcid = d.id LEFT JOIN guilds e ON c.guildid = e.id LEFT JOIN servernames f ON e.serverid = f.id WHERE f.expansion=0 AND a.loot = "'.$this->item.'" LIMIT 10') as $row){
					$fac = ($row->faction == 1) ? "alliance" : "horde";
					$content .= '
								<tr>
									<td class="lstring"><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->npc.'</a></td>
									<td class="lstring guild"><img src="../../Raids/img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}Vanilla/Guild/'.$row->sname.'/'.$row->name.'/0">'.$row->name.'</a></td>
									<td class="sstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->attemptid.'">'.date("d.m.y H:i", $row->time).'</a></td>
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
				foreach($this->db->query('SELECT d.name, COUNT(a.id) AS amount, e.name AS sname, d.faction FROM `v-raids-loot` a LEFT JOIN `v-raids-attempts` b ON a.`attemptid` = b.id LEFT JOIN `v-raids` c ON b.rid = c.id LEFT JOIN guilds d ON c.`guildid` = d.id LEFT JOIN servernames e ON d.`serverid` = e.id WHERE e.expansion=0 AND a.loot = "'.$this->item.'" GROUP BY d.`name`;') as $row){
					$fac = ($row->faction == 1) ? "alliance" : "horde";
					$content .= '
								<tr>
									<td class="guild"><img src="../../Raids/img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}Vanilla/Guild/'.$row->sname.'/'.$row->name.'/0">'.$row->name.'</a></td>
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
				foreach($this->db->query('SELECT d.name, COUNT(a.id) AS amount, b.npcid FROM `v-raids-loot` a LEFT JOIN `v-raids-attempts` b ON a.`attemptid` = b.id LEFT JOIN npcs d ON b.`npcid` = d.id WHERE a.loot = "'.$this->item.'" GROUP BY d.`name`;') as $row){
					$content .= '
								<tr>
									<td><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->name.'</a></td>
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
				foreach ($this->db->query('SELECT f.name AS sname, d.name AS cname, b.time, b.rid, a.`attemptid`, d.`classid`, e.`name` AS gname, d.classid, d.faction FROM `v-raids-loot` a LEFT JOIN `v-raids-attempts` b ON a.`attemptid` = b.`id` LEFT JOIN `v-raids` c ON b.`rid` = c.`id` LEFT JOIN chars d ON a.`charid` = d.`id` LEFT JOIN guilds e ON d.`guildid` = e.`id` LEFT JOIN servernames f ON d.`serverid` = f.`id` WHERE f.expansion=0 AND a.loot = "'.$this->item.'"') as $row){
					$fac = ($row->faction == 1) ? "alliance" : "horde";
					$content .= '
								<tr>
									<td class="sstring char"><img src="../../../Database/classes/c'.$row->classid.'.png" /><a class="color-'.$this->classById[$row->classid].'" href="{path}Vanilla/Character/'.$row->sname.'/'.$row->cname.'/0">'.($r = ($row->cname) ? $row->cname : "Unknown").'</a></td>
									<td class="sstring guild"><img src="../../Raids/img/'.$fac.'.png" /><a class="'.$fac.'" href="{path}Vanilla/Guild/'.$row->sname.'/'.$row->sname.'/0">'.($r = ($row->gname) ? $row->gname : "-").'</a></td>
									<td class="vstring">'.($r = ($row->sname) ? $row->sname : "Unknown").'</td>
									<td class="vstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->attemptid.'">'.date("d.m.y H:i", $row->time).'</a></td>
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