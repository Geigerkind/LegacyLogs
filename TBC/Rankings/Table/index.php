<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $mode = 0;
	private $faction = 0;
	private $server = "";
	private $type = -1;
	private $classe = "";
	private $id = "";
	private $bossesById = Array(0 => 18728, 1 => 17711, 2 => 22887, 3 => 22898, 4 => 22841, 5 => 21867, 6 => 22948, 7 => 50002, 8 => 22947, 9 => 23426, 10 => 22917, 11 => 21216, 12 => 21217, 13 => 21215, 14 => 21214, 15 => 21213, 16 => 21212, 17 => 15550, 18 => 15687, 19 => 50001, 20 => 16457, 21 => 15691, 22 => 15688, 23 => 16524, 24 => 15689, 25 => 15690, 26 => 17225, 27 => 18831, 28 => 19044, 29 => 17257, 30 => 23576, 31 => 23578, 32 => 23574, 33 => 23577, 34 => 23863, 35 => 19514, 36 => 19516, 37 => 18805, 38 => 19622, 39 => 17767, 40 => 17808, 41 => 17888, 42 => 17842, 43 => 17968, 44 => 24850, 45 => 24882, 46 => 25038, 47 => 50000, 48 => 25741, 49 => 25608, 50 => 24239); 
	private $prefix = array(
		1 => "ao",
		2 => "o"
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
	private $bossList = array(
		1 => array(1=>"0110000000000000000000000000001",2=>"Single Bosses"),
		2 => array(1=>"01",2=>"Doom Lord Kazzak"),
		3 => array(1=>"001",2=>"Doomwalker"),
		4 => array(1=>"0000000000000000000000000000001",2=>"Magtheridon"),
		5 => array(1=>"000111111111",2=>"Black Temple"),
		6 => array(1=>"0001",2=>"High Warlord Naj'entus"),
		7 => array(1=>"00001",2=>"Supremus"),
		8 => array(1=>"000001",2=>"Shade of Akama"),
		9 => array(1=>"0000001",2=>"Teron Gorefiend"),
		10 => array(1=>"00000001",2=>"Gurtogg Bloodboil"),
		11 => array(1=>"000000001",2=>"Reliquary of Souls"),
		12 => array(1=>"0000000001",2=>"Mother Shahraz"),
		13 => array(1=>"00000000001",2=>"The Illidari Council"),
		14 => array(1=>"000000000001",2=>"Illidan Stormrage"),
		15 => array(1=>"000000000000111111",2=>"Serpentshrine Cavern"),
		16 => array(1=>"0000000000001",2=>"Hydross the Unstable"),
		17 => array(1=>"00000000000001",2=>"The Lurker Below"),
		18 => array(1=>"000000000000001",2=>"Leotheras the Blind"),
		19 => array(1=>"0000000000000001",2=>"Fathom-Lord Karathress"),
		20 => array(1=>"00000000000000001",2=>"Morogrim Tidewalker"),
		21 => array(1=>"000000000000000001",2=>"Lady Vashj"),
		22 => array(1=>"0000000000000000001111111111",2=>"Karazhan"),
		23 => array(1=>"0000000000000000001",2=>"Attumen the Huntsman"),
		24 => array(1=>"00000000000000000001",2=>"Moroes"),
		25 => array(1=>"000000000000000000001",2=>"Opera event"),
		26 => array(1=>"0000000000000000000001",2=>"Maiden of Virtue"),
		27 => array(1=>"00000000000000000000001",2=>"The Curator"),
		28 => array(1=>"000000000000000000000001",2=>"Terestian Illhoof"),
		29 => array(1=>"0000000000000000000000001",2=>"Shade of Aran"),
		30 => array(1=>"00000000000000000000000001",2=>"Netherspite"),
		31 => array(1=>"000000000000000000000000001",2=>"Prince Malchezaar"),
		32 => array(1=>"0000000000000000000000000001",2=>"Nightbane"),
		33 => array(1=>"000000000000000000000000000011",2=>"Gruul's Lair"),
		34 => array(1=>"00000000000000000000000000001",2=>"High King Maulgar"),
		35 => array(1=>"000000000000000000000000000001",2=>"Gruul the Dragonkiller"),
		36 => array(1=>"000000000000000000000000000000011111",2=>"Zul'Aman"),
		37 => array(1=>"00000000000000000000000000000001",2=>"Nalorakk"),
		38 => array(1=>"000000000000000000000000000000001",2=>"Jan'alai"),
		39 => array(1=>"0000000000000000000000000000000001",2=>"Akil'zon"),
		40 => array(1=>"00000000000000000000000000000000001",2=>"Halazzi"),
		41 => array(1=>"0000000000000000000000000000000000000000000000000001",2=>"Hex Lord Malacrass"),
		42 => array(1=>"000000000000000000000000000000000001",2=>"Zul'jin"),
		43 => array(1=>"0000000000000000000000000000000000001111",2=>"The Eye"),
		44 => array(1=>"0000000000000000000000000000000000001",2=>"Al'ar"),
		45 => array(1=>"00000000000000000000000000000000000001",2=>"Void Reaver"),
		46 => array(1=>"000000000000000000000000000000000000001",2=>"High Astromancer Solarian"),
		47 => array(1=>"0000000000000000000000000000000000000001",2=>"Kael'thas Sunstrider"),
		48 => array(1=>"000000000000000000000000000000000000000011111",2=>"Hyjal Summit"),
		49 => array(1=>"00000000000000000000000000000000000000001",2=>"Rage Winterchill"),
		50 => array(1=>"000000000000000000000000000000000000000001",2=>"Anetheron"),
		51 => array(1=>"0000000000000000000000000000000000000000001",2=>"Kaz'rogal"),
		52 => array(1=>"00000000000000000000000000000000000000000001",2=>"Azgalor"),
		53 => array(1=>"000000000000000000000000000000000000000000001",2=>"Archimonde"),
		54 => array(1=>"000000000000000000000000000000000000000000000111111",2=>"Sunwell Plateau"),
		55 => array(1=>"0000000000000000000000000000000000000000000001",2=>"Kalecgos"),
		56 => array(1=>"00000000000000000000000000000000000000000000001",2=>"Brutallus"),
		57 => array(1=>"000000000000000000000000000000000000000000000001",2=>"Felmyst"),
		58 => array(1=>"0000000000000000000000000000000000000000000000001",2=>"Eredar Twins"),
		59 => array(1=>"00000000000000000000000000000000000000000000000001",2=>"M'uru"),
		60 => array(1=>"000000000000000000000000000000000000000000000000001",2=>"Kil'Jaeden"),
		61 => array(1=>"000111111111000000000000000000000000000011111111111",2=>"HYJAL+SWP+BT"),
		62 => array(1=>"0000000000001111110000000000000000001111",2=>"SSC+TK"),
		63 => array(1=>"000000000000000000111111111011",2=>"KARA+GRUUL"),
		64 => array(1=>"0000000000000000001111111110111",2=>"KARA+GRUUL+MAG"),
	);
	private $realmtype = array(
		-1 => array(
			0 => 1,
			1 => 1,
			2 => 1,
			3 => 2,
			4 => 2,
			5 => 1,
			6 => 2,
			7 => 2,
			8 => 1,
			9 => 2
		),
		1 => array(
			0 => 1,
			1 => 1,
			2 => 1,
			3 => 2,
			4 => 2,
			5 => 2,
			6 => 2,
			7 => 2,
			8 => 2,
			9 => 2
		)
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
	
	//11111111111111111111111111111111111111111111111111111111111111
	//11111111111111111111111
	//111111111 
	//11111111
	//1111111111111
	private $nameee;
	private function getName(){
		if (isset($nameee))
			return $nameee;
		foreach($this->bossList as $v){
			if ($v[1]===$this->id){
				$nameee = $v[2];
				return $v[2];
			}
		}
		$nameee = "Custom";
		return "Custom";
	}
	
	private function getConditions(){
		$con = "";
		if ($this->faction && $this->faction != 0)
			$con .= ' AND b.faction = '.$this->faction; 
		if ($this->server)
			$con .= ' AND b.serverid IN ('.$this->server.')';
		if ($this->type && $this->type != 0)
			$con .= ' AND a.type = '.$this->type; 
		if ($this->classe){
			$con .= ' AND b.classid IN ('.$this->classe.')';
		}
		return $con;
	}
	
	private function getBosses(){
		$t = array();
		for ($i=1; $i<=51; $i++){
			if (substr($this->id, $i, 1) == "1"){
				array_push($t, $this->bossesById[($i-1)]);
			}
		}
		return $t;
	}
	
	private function killedAllBosses($byPlayer,$toKill){
		foreach($toKill as $key => $var){
			if (!isset($byPlayer[$key])){
				return false;
			}
		}
		return true;
	}
	
	private function getValues(){
		$t = array();
		$i = array();
		$r = array();
		$bossid = "0";
		$toKill = array();
		$killedByPlayer = array();
		$ecept = array(15082=>true, 15083=>true, 15085=>true);
		foreach($this->getBosses() as $v){
			if (!$ecept[$v]){
				$bossid .= ",".$v;
				$toKill[$v] = true;
			}
		}
		foreach($this->db->query('SELECT f.gender, f.race, a.charid, a.'.$this->prefix[1].'val as val, c.name as sname, b.name as charname, b.classid, e.name as gname, b.faction, a.'.$this->prefix[1].'time as time, d.time as tsend, a.'.$this->prefix[1].'change as changed, d.rid, a.'.$this->prefix[2].'attemptid as attemptid, a.'.$this->prefix[3].'amount as aoamount, a.bossid FROM `tbc-rankings` a LEFT JOIN chars b ON a.charid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `tbc-raids-attempts` d ON a.'.$this->prefix[2].'attemptid = d.id LEFT JOIN guilds e ON b.guildid = e.id LEFT JOIN `armory` f ON a.charid = f.charid WHERE a.bossid IN ('.$bossid.')'.$this->getConditions().';') as $row){
			if ($t[$row->charid])
				$t[$row->charid] += $row->val;
			else
				$t[$row->charid] = $row->val;
			$killedByPlayer[$row->charid][$row->bossid] = true;
			if (!isset($i[$row->charid]))
				$i[$row->charid] = Array(
					1 => $row->sname,
					2 => $row->charname,
					3 => $row->classid,
					4 => $row->gname,
					5 => $row->faction,
					9 => $row->rid,
					10 => $row->attemptid,
					11 => 0,
					12 => 0,
					13 => (!isset($row->gender)) ? 1 : $row->gender,
					14 => ($row->faction==1) ? ($rq = (!isset($row->race)) ? 1 : $row->race) : ($rq = (!isset($row->race)) ? 5 : $row->race)
				);
			
			if ($i[$row->charid][6]) // time
				$i[$row->charid][6] = ($i[$row->charid][6]+$row->time)/2;
			else
				$i[$row->charid][6] = $row->time;
			
			if ($i[$row->charid][7]<$row->tsend or !$i[$row->charid][7])
				$i[$row->charid][7] = $row->tsend;
			
			if ($i[$row->charid][8])
				$i[$row->charid][8] += $row->changed;
			else
				$i[$row->charid][8] = $row->changed;
			$i[$row->charid][11] += $row->aoamount;
			$i[$row->charid][12]++;
		}
		
		foreach($t as $k => $v){
			$t[$k]= $v/$i[$k][12];
			$i[$k][8] = $i[$k][8]/$i[$k][12];
		}
		
		arsort($t);
		
		foreach($t as $key => $var){
			if ($key>0 && $this->killedAllBosses($killedByPlayer[$key], $toKill)){
				array_push($r, array(
					1 => $key,
					2 => $var,
					3 => $i[$key][1],
					4 => $i[$key][2],
					5 => $i[$key][3],
					6 => $i[$key][4],
					7 => $i[$key][5],
					8 => $i[$key][6],
					9 => $i[$key][7],
					10 => $i[$key][8],
					11 => $i[$key][9],
					12 => $i[$key][10],
					13 => $i[$key][11],
					14 => $i[$key][13],
					15 => $i[$key][14]
				));
			}
		}
		return $r;
	}
	
	private function getPic($i){
		if ($i>0)
			return 1;
		return 0;
	}
	
	private function getId($i){
		foreach($this->bossList as $k => $v){
			if ($i==$v[2])
				return $k;
		}
	}
	
	public function content(){
		$content = '
		<div class="container cont" id="container">
			<section class="centredNormal formular">
				<select name="mode" onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode=\'+this.value+\'&type='.$this->type.'&id='.$this->id.'&class='.$this->classe.'\');">
					<option value="0" '.($r = ($this->mode==0) ? " selected" : "").'">Average all time</option>
					<option value="1" '.($r = ($this->mode==1) ? " selected" : "").'">Best all time</option>
					<option value="2" '.($r = ($this->mode==2) ? " selected" : "").'">Average this quarter</option>
					<option value="3" '.($r = ($this->mode==3) ? " selected" : "").'">Best this quarter</option>
				</select>
				<select id="srealm" multiple="multiple">
			';
			$serverList = explode(",", $this->server);
			foreach($this->db->query('SELECT * FROM servernames WHERE expansion = 1') as $row){
				$content .= '
						<option value="'.$row->id.'"'.($r = (in_array($row->id, $serverList) || !$this->server) ? " selected" : "").'>'.$row->name.'</option>
				';
			}	
			$content .= '
				</select>
				<select onchange="window.location.replace(\'?server='.$this->server.'&faction=\'+this.value+\'&mode='.$this->mode.'&type='.$this->type.'&id='.$this->id.'&class='.$this->classe.'\');">
					<option value="0"'.($r = ($this->faction==0) ? " selected" : "").'>Any faction</option>
					<option value="-1"'.($r = ($this->faction==-1) ? " selected" : "").'>Horde</option>
					<option value="1"'.($r = ($this->faction==1) ? " selected" : "").'>Alliance</option>
				</select>
				<select onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type=\'+this.value+\'&id='.$this->id.'&class='.$this->classe.'\');">
					<option value="-1"'.($r = ($this->type==-1) ? " selected" : "").'>DPS</option>
					<option value="1"'.($r = ($this->type==1) ? " selected" : "").'>HPS</option>
				</select>
				<select id="sclass" multiple="multiple">
					<option value="1"'.($r = (strpos($this->classe, "1") !== FALSE or !$this->classe) ? " selected" : "").' class="color-warrior">Warrior</option>
					<option value="2"'.($r = (strpos($this->classe, "2") !== FALSE or !$this->classe) ? " selected" : "").' class="color-rogue">Rogue</option>
					<option value="3"'.($r = (strpos($this->classe, "3") !== FALSE or !$this->classe) ? " selected" : "").' class="color-priest">Priest</option>
					<option value="4"'.($r = (strpos($this->classe, "4") !== FALSE or !$this->classe) ? " selected" : "").' class="color-hunter">Hunter</option>
					<option value="5"'.($r = (strpos($this->classe, "5") !== FALSE or !$this->classe) ? " selected" : "").' class="color-druid">Druid</option>
					<option value="6"'.($r = (strpos($this->classe, "6") !== FALSE or !$this->classe) ? " selected" : "").' class="color-mage">Mage</option>
					<option value="7"'.($r = (strpos($this->classe, "7") !== FALSE or !$this->classe) ? " selected" : "").' class="color-warlock">Warlock</option>
					<option value="8"'.($r = (strpos($this->classe, "8") !== FALSE or !$this->classe) ? " selected" : "").' class="color-paladin">Paladin</option>
					<option value="9"'.($r = (strpos($this->classe, "9") !== FALSE or !$this->classe) ? " selected" : "").' class="color-shaman">Shaman</option>
				</select>
				<select onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id=\'+this.value+\'&class='.$this->classe.'\');">
				';
				foreach($this->bossList as $k => $v){
					$content .= '
						<option value="'.$v[1].'"'.($r = ($this->getName()==$v[2]) ? " selected" : "").'>'.$v[2].'</option>
					';
				}
				if ($this->getName()=="Custom")
					$content .= '<option value="'.$this->id.'" selected>Custom</option>';
				$curId = $this->getId($this->getName());
				$content .= '
				</select>
				<a href="{path}TBC/Rankings/Table/?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.($r = ($curId>1) ? $this->bossList[$curId-1][1] : $this->id).'&class='.$this->classe.'"><button class="icon-button icon-arrowleft" title="Previous"></button></a>
				<a href="{path}TBC/Rankings/Table/?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.($r = ($curId<sizeOf($this->bossList)) ? $this->bossList[$curId+1][1] : $this->id).'&class='.$this->classe.'"><button class="icon-button icon-arrowright" title="Next"></button></a>
			</section>
			<section class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th class="rank">Overall</th>
							<th class="rank">Classrank</th>
							<th class="rank">Typerank</th>
							<th class="timg char">Character</th>
							<th class="timg guild">Guild</th>
							<th class="server">Server</th>
							<th class="rank">Value</th>
							<th class="fstring">Date</th>
							<th class="rank" title="The development in the selected mode. In general it is the difference of the previous and the current value.">Change*</th>
						</tr>
		';
		$counter = array();
		foreach ($this->getValues() as $key => $var){
			if ($key==100)
				break;
			$fac = ($var[7] == 1) ? "alliance" : "horde";
			$counter[1][$var[5]] += 1; // o class
			$counter[2][$this->realmtype[$this->type][$var[5]]] += 1; // realm class
			$content .= '
						<tr>
							<td class="rank" title="Overall rank">'.($key+1).'</td>
							<td class="rank" title="Overall class rank">'.$counter[1][$var[5]].'</td>
							<td class="rank" title="Overall type rank">'.$counter[2][$this->realmtype[$this->type][$var[5]]].'</td>
							<td class="char"><img src="{path}Database/racegender/Ui-charactercreate-races_'.$this->race[$var[15]].'-'.$this->gender[$var[14]].'-small.png" /><img src="img/c'.$var[5].'.png"><a href="{path}TBC/Character/'.$var[3].'/'.$var[4].'/0" class="color-'.$this->classById[$var[5]].'">'.$var[4].'</a></td>
							<td class="guild"><img src="img/'.$fac.'.png"><a class="'.$fac.'" href="{path}TBC/Guild/'.$var[3].'/'.$var[6].'/0">'.$var[6].'</a></td>
							<td class="server">'.$var[3].'</td>
							<td class="rank"'.($r = ($this->mode==0 or $this->mode==2) ? ' title="'.$var[13].' attempts"' : '').'>'.$this->mReadable($var[2], 1).($r = ($this->mode==0 or $this->mode==2) ? "*" : "").'</td>
							<td class="fstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$var[11].'&attempts='.$var[12].'">'.date("d.m.y H:i", $var[9]).'</a></td>
							<td class="rank"><img src="img/'.$this->getPic($var[10]).'.png" />'.round($var[10], 1).'</td>
						</tr>
			';
		}
		$content .= '
					</table>
				</div>
			</section>
		</div>
		<script>
		$(\'#sclass\').multipleSelect({
			onClose: function() {
				window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.$this->id.'&class=\'+$(\'#sclass\').multipleSelect(\'getSelects\'));
			},
			allSelected: \'Any class\'
		});
		$(\'#srealm\').multipleSelect({
			onClose: function() {
				window.location.replace(\'?server=\'+$(\'#srealm\').multipleSelect(\'getSelects\')+\'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.$this->id.'&class='.$this->classe.'\');
			},
			allSelected: \'Any realm\'
		});
		</script>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $server, $faction, $mode, $type, $id, $classe){
		$this->mode = intval($this->antiSQLInjection($mode));
		$this->server = $this->antiSQLInjection($server);
		$this->faction = intval($this->antiSQLInjection($faction));
		$this->type = intval($this->antiSQLInjection($type));
		$this->classe = $this->antiSQLInjection($classe);
		if ($this->type == 0)
			$this->type = -1;
		$this->id = $this->antiSQLInjection($id);
		switch ($this->mode){
			case 0 :
				$this->prefix[1] = "ao";
				$this->prefix[2] = "o";
				$this->prefix[3] = "ao";
				break;
			case 1 :
				$this->prefix[1] = "bo";
				$this->prefix[2] = "o";
				$this->prefix[3] = "ao";
				break;
			case 2 :
				$this->prefix[1] = "am";
				$this->prefix[2] = "m";
				$this->prefix[3] = "bo";
				break;
			case 3 :
				$this->prefix[1] = "bm";
				$this->prefix[2] = "m";
				$this->prefix[3] = "bo";
				break;
		}
		$this->addCssLink("{path}External/multipleselect/multiple-select.css");
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js", true);
		$this->addJsLink("{path}External/multipleselect/multiple-select.js", true);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["server"], $_GET["faction"], $_GET["mode"], $_GET["type"], $_GET["id"], $_GET["class"]);

?>