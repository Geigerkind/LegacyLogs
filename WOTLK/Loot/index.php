<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $item = "";
	private $page = 1;
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="centredNormal formular">
				<form action="index.php">
					<input type="search" name="item" placeholder="Press enter to search" />
				</form>
				<a href="'.($r = ($this->item!="") ? '{path}WOTLK/Loot/?item='.$this->item.'&page='.($r = (($this->page-1)>=1) ? ($this->page-1) : 1) : '').'"><button class="icon-button icon-arrowleft"></button></a>
				<a href="'.($r = ($this->item!="") ? '{path}WOTLK/Loot/?item='.$this->item.'&page='.($this->page+1) : '').'"><button class="icon-button icon-arrowright"></button></a>
			</section>
		';
		if ($this->item && $this->item != ""){
			$content .= '
			<section class="table ts">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th>Results for loot items</th>
						</tr>
			';
			foreach($this->db->query('SELECT b.rarity, a.loot, b.name, b.icon FROM `wotlk-raids-loot` a JOIN items b ON a.loot = b.id WHERE b.name LIKE "%'.$this->item.'%" GROUP BY b.id LIMIT '.(($this->page-1)*15).', 15') as $row){
				$content .= '
					<tr>
						<td class="pve"><img class="qe'.$row->rarity.'" src="{path}Database/icons/small/'.$row->icon.'.jpg"><a class="q'.$row->rarity.'" rel="item='.$row->loot.'" href="{path}WOTLK/Loot/Result/index.php?item='.$row->loot.'">['.$row->name.']</a></td>
					</tr>
				';
			}
			$content .= '
					</table>
					<table cellspacing="0">
						<tr>
							<th>Results for armory items</th>
						</tr>
			';
			foreach($this->db->query('SELECT b.quality as rarity, b.entry as loot, b.name, b.icon, d.name as sname FROM `armory-itemhistory` a JOIN `items-search-wotlk` b ON a.item = b.entry LEFT JOIN chars c ON a.charid = c.id LEFT JOIN servernames d ON c.serverid = d.id WHERE d.expansion=2 AND b.name LIKE "%'.$this->item.'%" GROUP BY b.entry, d.id ORDER BY b.quality DESC LIMIT '.(($this->page-1)*15).', 15') as $row){
				$content .= '
					<tr>
						<td class="pve"><img class="qe'.$row->rarity.'" src="{path}Database/icons/small/'.$row->icon.'.jpg"><a class="q'.$row->rarity.'" rel="item='.$row->loot.'" href="{path}WOTLK/Armory/Items/'.$row->sname.'/'.$row->loot.'">['.$row->name.']</a></td>
					</tr>
				';
			}
			$content .= '
					</table>
				</div>
			</section>
			';
		}
		$content .= '
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $item){
		$this->item = $this->antiSQLInjection($item);
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js");
		$this->addJsLink("{path}External/TwinheadTooltip/functions.js");
		$this->addJsLink("{path}External/TwinheadTooltip/tooltip.js");
		$this->addJsLink("{path}External/TwinheadTooltip/twinhead_tooltip.js");
		$this->addCssLink("{path}External/TwinheadTooltip/twinhead_tooltip.css");
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["item"]);

?>