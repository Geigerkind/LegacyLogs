<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $faction = 0;
	private $server = "";
	private $page = 1;
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
	
	private function getSeenString($time){
		if ($time==0)
			return "-";
		$days = floor((time()-$time)/86400);
		if ($days==0)
			return "today";
		if ($days==1)
			return "1 day ago";
		if ($days>30 && $days<60)
			return "1 month ago";
		if ($days>=60)
			return floor($days/30)." months ago";
		return $days." days ago";
	}
	
	private function getConditions(){
		$con = " ";
		if (isset($this->server) && $this->server != "")
			$con .= "AND a.serverid IN (".$this->server.")";
		if ($this->faction != 0)
			$con .= " AND d.faction = ".$this->faction;
		return $con;
	}

	public function content(){
		$content = '
		<div class="container cont" id="container">
			<section class="centredNormal formular">
				<select id="srealm" multiple="multiple">
			';
			$serverList = explode(",", $this->server);
			foreach($this->db->query('SELECT * FROM servernames WHERE expansion=2') as $row){
				$content .= '
						<option value="'.$row->id.'"'.($r = (in_array($row->id, $serverList) || !$this->server) ? " selected" : "").'>'.$row->name.'</option>
				';
			}	
			$content .= '
				</select>
				<select id="sfaction" onchange="window.location.replace(\'?server='.$this->server.'&faction=\'+this.value+\'&page='.$this->page.'\');">
					<option value="0"'.($r = ($this->faction==0) ? " selected" : "").'>Any faction</option>
					<option value="-1"'.($r = ($this->faction==-1) ? " selected" : "").'>Horde</option>
					<option value="1"'.($r = ($this->faction==1) ? " selected" : "").'>Alliance</option>
				</select>
				<a href="{path}WOTLK/5vs5/?server='.$this->server.'&faction='.$this->faction.'&page='.($this->page+1).'"><button class="icon-button icon-arrowright" title="Next"></button></a>
				<a href="{path}WOTLK/5vs5/?server='.$this->server.'&faction='.$this->faction.'&page='.($r = (($this->page-1)>0) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft" title="Previous"></button></a>
			</section>
			<section class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th class="rank">#Nr</th>
							<th class="timg">Teamname</th>
							<th class="fstring">Member</th>
							<th class="fstring">Rating</th>
							<th class="fstring">Games</th>
							<th class="fstring">Wins</th>
							<th class="fstring">Loses</th>
							<th class="fstring">Server</th>
							<th class="fstring">Seen</th>
						</tr>
		';
		$num = (($this->page-1)*15)+1;
		foreach($this->db->query('SELECT a.*, b.name as sname, group_concat(d.classid) as member, group_concat(d.name) as membernames, group_concat(d.faction) AS faction FROM `armory-arenateams-wotlk` a LEFT JOIN servernames b ON a.serverid = b.id LEFT JOIN `armory-honor-wotlk` c ON c.arena3 = a.arenaid LEFT JOIN chars d ON d.id = c.charid WHERE c.arena3 = a.arenaid AND a.type=2'.$this->getConditions().' GROUP BY a.arenaid ORDER BY a.rating DESC LIMIT '.(($this->page-1)*15).', 15') as $row){
			$row->faction = explode(",",$row->faction)[0];
			$fac = ($row->faction==1) ? "alliance" : "horde";
			$content .= '
						<tr>
							<td class="rank">'.$num.'</td>
							<td class="timg"><img src="img/'.$fac.'.png"><a href="{path}WOTLK/Team/'.$row->sname.'/'.$row->name.'">'.$row->name.'</a></td>
							<td class="lstring char">
			';
			$memNames = explode(",", $row->membernames);
			foreach(explode(",", $row->member) as $memKey => $mem){
				$content .= '<a href="{path}WOTLK/Armory/'.$row->sname.'/'.$memNames[$memKey].'/0"><img src="{path}Database/classes/c'.$mem.'.png" title="'.$memNames[$memKey].'"/></a>';
			}
			$content .= '
							</td>
							<td class="fstring">'.$row->rating.'</td>
							<td class="fstring">'.$row->games.'</td>
							<td class="fstring">'.$row->wins.'</td>
							<td class="fstring">'.($row->games-$row->wins).'</td>
							<td class="fstring">'.$row->sname.'</td>
							<td class="fstring">'.$this->getSeenString(end(explode(",",$row->time))).'</td>
						</tr>
			';
			$num++;
		}
		$content .= '
					</table>
				</div>
			</section>
		</div>
		<script>
		$(\'#srealm\').multipleSelect({
			onClose: function() {
				window.location.replace(\'?server=\'+$(\'#srealm\').multipleSelect(\'getSelects\')+\'&faction='.$this->faction.'&page='.$this->page.'\');
			},
			allSelected: \'Any realm\'
		});
		</script>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $server, $faction, $classe, $page){
		$this->server = $this->antiSQLInjection($server);
		$this->faction = intval($this->antiSQLInjection($faction));
		$this->page = intval($this->antiSQLInjection($page));
		if ($this->page==0)
			$this->page=1;
		$this->addCssLink("{path}External/multipleselect/multiple-select.css");
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js", true);
		$this->addJsLink("{path}External/multipleselect/multiple-select.js", true);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["server"], $_GET["faction"], $_GET["class"], $_GET["page"]);

?>