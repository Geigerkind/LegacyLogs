<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $server = "";
	private $name = "";
	private $type = 0;
	private $teamData = array();
	private $faction = -1;
	private $rankingType = array(
		0 => "2vs2",
		1 => "3vs3",
		2 => "5vs5",
	);
	private $factionById = array(
		1 => "alliance",
		-1 => "horde"
	);
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
	private $gender = array(
		1 => "male",
		2 => "male",
		3 => "female",
	);
	private $race = array(
		1 => "human",
		2 => "dwarf",
		3 => "nightelf",
		4 => "gnome",
		5 => "orc",
		6 => "undead",
		7 => "troll",
		8 => "tauren",
		9 => "draenei",
		10 => "bloodelf"
	);
	
	private function getTeamInformation($db){
		$q = $db->query('SELECT a.* FROM `armory-arenateams-tbc` a LEFT JOIN servernames b ON a.serverid = b.id WHERE b.expansion=1 AND b.name = "'.$this->server.'" AND a.name = "'.$this->name.'" ORDER BY arenaid DESC')->fetch();
		$this->type = $q->type;
		$this->teamData = $q;
		$this->faction = $db->query('SELECT a.faction FROM chars a LEFT JOIN `armory-honor-tbc` b ON a.id=b.charid WHERE b.arena'.($this->type+1).'='.$this->teamData->arenaid.' LIMIT 1')->fetch()->faction;
	}
	
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
	
	private function jsToAdd(){
		$time = explode(",", $this->teamData->time);
		$val = explode(",",$this->teamData->val);
		$content .= "
	      google.charts.load('current', {'packages':['corechart']});
		  google.charts.setOnLoadCallback(drawChart);
		
		  function drawChart() {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Time');
			data.addColumn('number', 'Rating');
			data.addRows([
		";
		foreach($time as $k => $v){
			$content .="
				['".gmdate('d.m.y H:i', $v)."', ".$val[$k]."],
			";
		}
		$content .= "
			]);

			var options = {
			  curveType: 'function',
			  legend: { position: 'bottom', 'textStyle': { 'color': 'white' } },
			  chartArea: {top: 25,right: 20,height: '70%', width: '90%'},
			  backgroundColor: {'fill': 'transparent' },
			  hAxis: {textStyle:{color: '#FFF'}},
			  vAxis: {textStyle:{color: '#FFF'},viewWindow: {min:0}},
			  series: {
				0: { color: '#f1ca3a' },
				1: { color: '#e2431e' },
				2: { color: '#e7711b' },
				3: { color: '#6f9654' },
			  },
			};

			var chart = new google.visualization.LineChart(document.getElementById('graph'));

			chart.draw(data, options);
			 var columns = [];
			var series = {};
			for (var i = 0; i < data.getNumberOfColumns(); i++) {
				columns.push(i);
				if (i > 0) {
					series[i - 1] = {};
				}
			}
		  }
		";
		return $content;
	}
	
	private function getRanks(){
		$global=0; $server=0;
		$double = array();
		foreach($this->db->query('SELECT arenaid, serverid, GROUP_CONCAT(c.charid) as mem FROM `armory-arenateams-tbc` a LEFT JOIN `armory-honor-tbc` c ON c.arena'.($this->type+1).' = a.arenaid GROUP BY a.arenaid ORDER BY rating DESC') as $row){
			if (!isset($double[$row->serverid][$row->arenaid]) && $row->mem != ""){
				$global++;
				if ($row->serverid==$this->teamData->serverid)
					$server++;
				$double[$row->serverid][$row->arenaid] = true;
			}
			if ($row->arenaid==$this->teamData->arenaid)
				break;
		}
		return array(0=>$global,1=>$server);
	}
	
	public function content(){
		$this->addJs($this->jsToAdd());
		$ranks = $this->getRanks();
		$content = '
		<div class="container cont" id="container">
			<section class="centredNormal table toptop">
				<div class="right">
					<section class="top">
						<img src="{path}TBC/Team/img/'.$this->factionById[$this->faction].'.png" /> '.$this->name.' &lt;'.$this->server.'&gt;
					</section>
					<a href="{path}TBC/'.$this->rankingType[$this->type].'"><button class="pseudoButton">Rankings</button></a>
				</div>
				<div id="graph"></div>
			</section>
			<section class="centredNormal">
				<table class="half" cellspacing="0">
					<tr>
						<th colspan="2">Stats</th>
					</tr>
					<tr>
						<td>Global rank:</td>
						<td>'.$ranks[0].'</td>
					</tr>
					<tr>
						<td>Server rank:</td>
						<td>'.$ranks[1].'</td>
					</tr>
					<tr>
						<td>Rating:</td>
						<td>'.$this->teamData->rating.'</td>
					</tr>
					<tr>
						<td>Games:</td>
						<td>'.$this->teamData->games.'</td>
					</tr>
					<tr>
						<td>Wins:</td>
						<td>'.$this->teamData->wins.'</td>
					</tr>
					<tr>
						<td>Loses:</td>
						<td>'.($this->teamData->games-$this->teamData->wins).'</td>
					</tr>
					<tr>
						<td>Last update:</td>
						<td>'.$this->getSeenString(end(explode(",",$this->teamData->time))).'</td>
					</tr>
				</table>
				<table class="half" cellspacing="0">
					<tr>
						<th colspan="3">Member</th>
					</tr>
		';
		foreach($this->db->query('SELECT a.classid, a.name, c.seen, d.name as gname, c.gender, c.race FROM chars a LEFT JOIN `armory-honor-tbc` b ON a.id=b.charid LEFT JOIN `armory` c ON a.id = c.charid LEFT JOIN guilds d ON a.guildid = d.id WHERE b.arena'.($this->type+1).' = '.$this->teamData->arenaid) as $row){
			$content .= '
					<tr>
						<td class="charlong"><img src="{path}Database/racegender/Ui-charactercreate-races_'.$this->race[$row->race].'-'.$this->gender[$row->gender].'-small.png" /><img src="{path}Database/classes/c'.$row->classid.'.png" /><a class="color-'.$this->classById[$row->classid].'" href="{path}TBC/Armory/'.$this->server.'/'.$row->name.'/0">'.$row->name.'</a></td>
						<td><a class="'.$this->factionById[$this->faction].'" href="{path}TBC/Guild/'.$this->server.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
						<td>'.$this->getSeenString($row->seen).'</td>
					</tr>
			';
		}
		$content .= '
				</table>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $server, $name){
		$this->addJsLink("https://www.gstatic.com/charts/loader.js", true);
		$this->server = $this->antiSQLInjection($server);
		$this->name = $this->antiSQLInjection($name);
		$this->getTeamInformation($db);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["server"], $_GET["name"]);

?>