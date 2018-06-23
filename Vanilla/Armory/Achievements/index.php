<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $page = 1;
	private $server = "";
	private $typeById = "";
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
	
	private function getConditions(){
		if ($this->typeById!="")
			return " WHERE type IN (".$this->typeById.") AND disabled = 0";
		return " WHERE disabled = 0";
	}
	
	public function content(){
		$content = '
		<div class="container cont" id="container">
			<section class="centredNormal top">
				<div class="ttitle">
					Achievements catalogue
				</div>
				<div class="pseudoButton">
					AP: 0
				</div>
			</section>
			<section class="centredNormal table">
				<div class="right">
					<div class="nav">
						<a href="{path}Vanilla/Armory/Achievements"><button'.($r = ($this->typeById=="") ? ' class="selected"' : "").'>Summary</button></a>
						<a href="{path}Vanilla/Armory/Achievements/?types=1,2,3,4,5,6,7"><button'.($r = ($this->typeById=="1,2,3,4,5,6,7") ? ' class="selected"' : "").'>Raids</button></a>
						<a href="{path}Vanilla/Armory/Achievements/?types=1"><button class="sub'.($r = ($this->typeById=="1") ? ' selected' : "").'">Onyxia\'s Lair</button></a>
						<a href="{path}Vanilla/Armory/Achievements/?types=2"><button class="sub'.($r = ($this->typeById=="2") ? ' selected' : "").'">Molten Core</button></a>
						<a href="{path}Vanilla/Armory/Achievements/?types=3"><button class="sub'.($r = ($this->typeById=="3") ? ' selected' : "").'">Zul\'Gurub</button></a>
						<a href="{path}Vanilla/Armory/Achievements/?types=4"><button class="sub'.($r = ($this->typeById=="4") ? ' selected' : "").'">Blackwing Lair</button></a>
						<a href="{path}Vanilla/Armory/Achievements/?types=5"><button class="sub'.($r = ($this->typeById=="5") ? ' selected' : "").'">Ruins of Ahn\'Qiraj</button></a>
						<a href="{path}Vanilla/Armory/Achievements/?types=6"><button class="sub'.($r = ($this->typeById=="6") ? ' selected' : "").'">Temple of Ahn\'Qiraj</button></a>
						<a href="{path}Vanilla/Armory/Achievements/?types=7"><button class="sub'.($r = ($this->typeById=="7") ? ' selected' : "").'">Naxxramas</button></a>
						<a href="{path}Vanilla/Armory/Achievements/?types=8"><button'.($r = ($this->typeById=="8") ? ' class="selected"' : "").'>Feats of Strength</button></a>
					</div>
					<div class="achcon">
						<table cellspacing="0">
		';
		foreach($this->db->query('SELECT * FROM `vanilla-achievements`'.$this->getConditions()) as $row){
			$content .= '
							<tr>
								<td>
									<img src="//wow.zamimg.com/images/wow/icons/large/'.$row->icon.'.jpg" />
									<div class="ach-title">'.$row->title.'</div>
									<div class="ach-text">'.$row->text.'</div>
									<div class="ach-points">
										<div>'.$row->points.'</div>
										<div>16-02-16</div>
									</div>
								</td>
							</tr>
			';
		}
		$content .= '
						</table>
					</div>
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $server, $page){
		$this->server = $this->antiSQLInjection($server);
		$this->page = intval($this->antiSQLInjection($page));
		$this->typeById = $this->antiSQLInjection($_GET["types"]);
		if ($this->page==0)
			$this->page=1;
		$this->addCssLink("{path}External/multipleselect/multiple-select.css");
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js", true);
		$this->addJsLink("{path}External/multipleselect/multiple-select.js", true);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["server"], $_GET["page"]);

?>