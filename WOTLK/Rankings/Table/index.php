<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $mode = 0;
	private $faction = 0;
	private $server = "";
	private $type = -1;
	private $classe = "";
	private $id = "";
	private $bossesById = array(
		0 => array(0=>10184,1=>16028,2=>15931,3=>15932,4=>15928,5=>15956,6=>15953,7=>15952,8=>16061,9=>16060,10=>50005,11=>15954,12=>15936,13=>16011,14=>15989,15=>15990,16=>28859,17=>31125,18=>33993,19=>35013,20=>38433,21=>30451,22=>30452,23=>30449,24=>28860,25=>33118,26=>33186,27=>33293,28=>50000,29=>32930,30=>33515,31=>33244,32=>32906,33=>32865,34=>32845,35=>33271,36=>33288,37=>32871,38=>50001,39=>34780,40=>50002,41=>50003,42=>34564,43=>36612,44=>36855,45=>50007,46=>37813,47=>36626,48=>36627,49=>36678,50=>50004,51=>37955,52=>36789,53=>36853,54=>36597,55=>39823,56=>39751,57=>39805,58=>40143),
		1 => array(0=>36538,1=>31099,2=>29373,3=>29417,4=>29448,5=>29249,6=>29268,7=>29278,8=>29940,9=>29955,10=>50021,11=>29615,12=>29701,13=>29718,14=>29991,15=>30061,16=>31734,17=>31722,18=>33994,19=>35360,20=>38462,21=>31520,22=>31534,23=>31535,24=>31311,25=>33190,26=>33724,27=>33885,28=>50008,29=>33909,30=>34175,31=>50025,32=>33360,33=>33147,34=>32846,35=>33449,36=>33955,37=>33070,38=>50009,39=>35216,40=>50012,41=>50015,42=>34566,43=>37957,44=>38106,45=>50022,46=>38402,47=>37504,48=>38390,49=>38431,50=>50018,51=>38434,52=>38174,53=>38265,54=>39166,55=>39747,56=>39899,57=>39746,58=>40142),
		2 => array(0=>10184,1=>16028,2=>15931,3=>15932,4=>15928,5=>15956,6=>15953,7=>15952,8=>16061,9=>16060,10=>50005,11=>15954,12=>15936,13=>16011,14=>15989,15=>15990,16=>28859,17=>31125,18=>33993,19=>35013,20=>38433,21=>30451,22=>30452,23=>30449,24=>28860,25=>33118,26=>33186,27=>33293,28=>50000,29=>32930,30=>33515,31=>33244,32=>32906,33=>32865,34=>32845,35=>33271,36=>33288,37=>32871,38=>50010,39=>35268,40=>50013,41=>50016,42=>35615,43=>37958,44=>38296,45=>50023,46=>38582,47=>37505,48=>38549,49=>38585,50=>50019,51=>38435,52=>38589,53=>38266,54=>39167,55=>39823,56=>39751,57=>39805,58=>39864),
		3 => array(0=>36538,1=>31099,2=>29373,3=>29417,4=>29448,5=>29249,6=>29268,7=>29278,8=>29940,9=>29955,10=>50021,11=>29615,12=>29701,13=>29718,14=>29991,15=>30061,16=>31734,17=>31722,18=>33994,19=>35360,20=>38462,21=>31520,22=>31534,23=>31535,24=>31311,25=>33190,26=>33724,27=>33885,28=>50008,29=>33909,30=>34175,31=>50025,32=>33360,33=>33147,34=>32846,35=>33449,36=>33955,37=>33070,38=>50011,39=>35269,40=>50014,41=>50017,42=>35616,43=>37959,44=>38297,45=>50024,46=>38583,47=>37506,48=>38550,49=>38586,50=>50020,51=>38436,52=>38590,53=>38267,54=>39168,55=>39747,56=>39899,57=>39746,58=>39863)
	);
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
		9 => "shaman",
		10 => "deathknight",
	);
	
	public function generateLink($id){
		$str = "0";
		for($i=1; $i<$id; $i++){
			$str .= "0";
		}
		return $str."1";
	}
	
	public $bossList = array();
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
			9 => 2,
			10 => 1,
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
			9 => 2,
			10 => 1,
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
	private $diffi = 0;
	
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
		for ($i=1; $i<=59; $i++){
			if (substr($this->id, $i, 1) == "1"){
				array_push($t, $this->bossesById[$this->diffi][($i-1)]);
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
		foreach($this->db->query('SELECT f.gender, f.race, a.charid, a.'.$this->prefix[1].'val as val, c.name as sname, b.name as charname, b.classid, e.name as gname, b.faction, a.'.$this->prefix[1].'time as time, d.time as tsend, a.'.$this->prefix[1].'change as changed, d.rid, a.'.$this->prefix[2].'attemptid as attemptid, a.'.$this->prefix[3].'amount as aoamount, a.bossid FROM `wotlk-rankings` a LEFT JOIN chars b ON a.charid = b.id LEFT JOIN servernames c ON b.serverid = c.id LEFT JOIN `wotlk-raids-attempts` d ON a.'.$this->prefix[2].'attemptid = d.id LEFT JOIN guilds e ON b.guildid = e.id LEFT JOIN `armory` f ON a.charid = f.charid WHERE a.bossid IN ('.$bossid.')'.$this->getConditions().';') as $row){
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
				<select name="diffi" id="diffi" onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.$this->id.'&class='.$this->classe.'&diff=\'+this.value);">
					<option value="0" '.($r = ($this->diffi==0) ? " selected" : "").'>10 NHC</option>
					<option value="1" '.($r = ($this->diffi==1) ? " selected" : "").'>25 NHC</option>
					<option value="2" '.($r = ($this->diffi==2) ? " selected" : "").'>10 HC</option>
					<option value="3" '.($r = ($this->diffi==3) ? " selected" : "").'>25 HC</option>
				</select>
				<select name="mode" onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode=\'+this.value+\'&type='.$this->type.'&id='.$this->id.'&class='.$this->classe.'&diff='.$this->diffi.'\');">
					<option value="0" '.($r = ($this->mode==0) ? " selected" : "").'">Average all time</option>
					<option value="1" '.($r = ($this->mode==1) ? " selected" : "").'">Best all time</option>
					<option value="2" '.($r = ($this->mode==2) ? " selected" : "").'">Average this quarter</option>
					<option value="3" '.($r = ($this->mode==3) ? " selected" : "").'">Best this quarter</option>
				</select>
				<select id="srealm" multiple="multiple">
			';
			$serverList = explode(",", $this->server);
			foreach($this->db->query('SELECT * FROM servernames WHERE expansion = 2') as $row){
				$content .= '
						<option value="'.$row->id.'"'.($r = (in_array($row->id, $serverList) || !$this->server) ? " selected" : "").'>'.$row->name.'</option>
				';
			}	
			$content .= '
				</select>
				<select onchange="window.location.replace(\'?server='.$this->server.'&faction=\'+this.value+\'&mode='.$this->mode.'&type='.$this->type.'&id='.$this->id.'&class='.$this->classe.'&diff='.$this->diffi.'\');">
					<option value="0"'.($r = ($this->faction==0) ? " selected" : "").'>Any faction</option>
					<option value="-1"'.($r = ($this->faction==-1) ? " selected" : "").'>Horde</option>
					<option value="1"'.($r = ($this->faction==1) ? " selected" : "").'>Alliance</option>
				</select>
				<select onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type=\'+this.value+\'&id='.$this->id.'&class='.$this->classe.'&diff='.$this->diffi.'\');">
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
					<option value="10"'.($r = (strpos($this->classe, "10") !== FALSE or !$this->classe) ? " selected" : "").' class="color-deathknight">Death Knight</option>
				</select>
				<select onchange="window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id=\'+this.value+\'&class='.$this->classe.'&diff='.$this->diffi.'\');">
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
				<a href="{path}WOTLK/Rankings/Table/?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.($r = ($curId>1) ? $this->bossList[$curId-1][1] : $this->id).'&class='.$this->classe.'&diff='.$this->diffi.'"><button class="icon-button icon-arrowleft" title="Previous"></button></a>
				<a href="{path}WOTLK/Rankings/Table/?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.($r = ($curId<sizeOf($this->bossList)) ? $this->bossList[$curId+1][1] : $this->id).'&class='.$this->classe.'&diff='.$this->diffi.'"><button class="icon-button icon-arrowright" title="Next"></button></a>
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
							<td class="char"><img src="{path}Database/racegender/Ui-charactercreate-races_'.$this->race[$var[15]].'-'.$this->gender[$var[14]].'-small.png" /><img src="{path}Database/classes/c'.$var[5].'.png"><a href="{path}WOTLK/Character/'.$var[3].'/'.$var[4].'/0" class="color-'.$this->classById[$var[5]].'">'.$var[4].'</a></td>
							<td class="guild"><img src="img/'.$fac.'.png"><a class="'.$fac.'" href="{path}WOTLK/Guild/'.$var[3].'/'.$var[6].'/0">'.$var[6].'</a></td>
							<td class="server">'.$var[3].'</td>
							<td class="rank"'.($r = ($this->mode==0 or $this->mode==2) ? ' title="'.$var[13].' attempts"' : '').'>'.$this->mReadable($var[2], 1).($r = ($this->mode==0 or $this->mode==2) ? "*" : "").'</td>
							<td class="fstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[11].'&attempts='.$var[12].'">'.date("d.m.y H:i", $var[9]).'</a></td>
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
				window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.$this->id.'&class=\'+$(\'#sclass\').multipleSelect(\'getSelects\')+\'&diff='.$this->diffi.'\');
			},
			allSelected: \'Any class\'
		});
		$(\'#srealm\').multipleSelect({
			onClose: function() {
				window.location.replace(\'?server=\'+$(\'#srealm\').multipleSelect(\'getSelects\')+\'&faction='.$this->faction.'&mode='.$this->mode.'&type='.$this->type.'&id='.$this->id.'&class='.$this->classe.'&diff='.$this->diffi.'\');
			},
			allSelected: \'Any realm\'
		});
		</script>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $server, $faction, $mode, $type, $id, $classe, $diffi){
		$this->bossList = array(
			1 => array(1=>$this->generateLink(1), 2=>"Onyxia"),
			2 => array(1=>"00111111111111111", 2=>"Naxxramas"),
			3 => array(1=>$this->generateLink(2), 2=>"Patchwerk"),
			4 => array(1=>$this->generateLink(3), 2=>"Grobbulus"),
			5 => array(1=>$this->generateLink(4), 2=>"Gluth"),
			6 => array(1=>$this->generateLink(5), 2=>"Thaddius"),
			7 => array(1=>$this->generateLink(6), 2=>"Anub'Rekhan"),
			8 => array(1=>$this->generateLink(7), 2=>"Grand Widow Faerllina"),
			9 => array(1=>$this->generateLink(8), 2=>"Maexxna"),
			10 => array(1=>$this->generateLink(9), 2=>"Instructor Razuvious"),
			11 => array(1=>$this->generateLink(10), 2=>"Gothik the Harvester"),
			12 => array(1=>$this->generateLink(11), 2=>"The Four Horsemen"),
			13 => array(1=>$this->generateLink(12), 2=>"Noth the Plaguebringer"),
			14 => array(1=>$this->generateLink(13), 2=>"Heigan the Unclean"),
			15 => array(1=>$this->generateLink(14), 2=>"Loatheb"),
			16 => array(1=>$this->generateLink(15), 2=>"Sapphiron"),
			17 => array(1=>$this->generateLink(16), 2=>"Kel'Thuzad"),
			18 => array(1=>$this->generateLink(17), 2=>"Malygos"),
			19 => array(1=>"0000000000000000001111", 2=>"Vault of Archavon"),
			20 => array(1=>$this->generateLink(18), 2=>"Archavon the Stone Watcher"),
			21 => array(1=>$this->generateLink(19), 2=>"Emalon the Storm Watcher"),
			22 => array(1=>$this->generateLink(20), 2=>"Koralon the Flame Watcher"),
			23 => array(1=>$this->generateLink(21), 2=>"Toravon the Ice Watcher"),
			24 => array(1=>$this->generateLink(25), 2=>"Sartharion"),
			25 => array(1=>"000000000000000000000000001111111111111", 2=>"Ulduar"),
			26 => array(1=>$this->generateLink(26), 2=>"Ignis the Furnace Master"),
			27 => array(1=>$this->generateLink(27), 2=>"Razorscale"),
			28 => array(1=>$this->generateLink(28), 2=>"XT-002 Deconstructor"),
			29 => array(1=>$this->generateLink(29), 2=>"The Assembly of Iron"),
			30 => array(1=>$this->generateLink(30), 2=>"Kologarn"),
			31 => array(1=>$this->generateLink(31), 2=>"Auriaya"),
			32 => array(1=>$this->generateLink(32), 2=>"Mimiron"),
			33 => array(1=>$this->generateLink(33), 2=>"Freya"),
			34 => array(1=>$this->generateLink(34), 2=>"Thorim"),
			35 => array(1=>$this->generateLink(35), 2=>"Hodir"),
			36 => array(1=>$this->generateLink(36), 2=>"General Vezax"),
			37 => array(1=>$this->generateLink(37), 2=>"Yogg-Saron"),
			38 => array(1=>$this->generateLink(38), 2=>"Algalon the Observer"),
			39 => array(1=>"00000000000000000000000000000000000000011111", 2=>"Trial of the Crusader"),
			40 => array(1=>$this->generateLink(39), 2=>"Beasts of Northrend"),
			41 => array(1=>$this->generateLink(40), 2=>"Lord Jaraxxus"),
			42 => array(1=>$this->generateLink(41), 2=>"Faction Champions"),
			43 => array(1=>$this->generateLink(42), 2=>"Twin Val'kyr"),
			44 => array(1=>$this->generateLink(43), 2=>"Anub'arak"),
			45 => array(1=>"00000000000000000000000000000000000000000000111111111111", 2=>"Icecrown Citadel"),
			46 => array(1=>$this->generateLink(44), 2=>"Lord Marrowgar"),
			47 => array(1=>$this->generateLink(45), 2=>"Lady Deathwhisper"),
			48 => array(1=>$this->generateLink(46), 2=>"Gunship Battle"),
			49 => array(1=>$this->generateLink(47), 2=>"Deathbringer Saurfang"),
			50 => array(1=>$this->generateLink(48), 2=>"Festergut"),
			51 => array(1=>$this->generateLink(49), 2=>"Rotface"),
			52 => array(1=>$this->generateLink(50), 2=>"Professor Putricide"),
			53 => array(1=>$this->generateLink(51), 2=>"Blood Prince Council"),
			54 => array(1=>$this->generateLink(52), 2=>"Blood-Queen Lana'thel"),
			55 => array(1=>$this->generateLink(53), 2=>"Valithria Dreamwalker"),
			56 => array(1=>$this->generateLink(54), 2=>"Sindragosa"),
			57 => array(1=>$this->generateLink(55), 2=>"The Lich King"),
			58 => array(1=>"000000000000000000000000000000000000000000000000000000001111", 2=>"Ruby Sanctum"),
			59 => array(1=>$this->generateLink(56), 2=>"Saviana Ragefire"),
			60 => array(1=>$this->generateLink(57), 2=>"Baltharus the Warborn"),
			61 => array(1=>$this->generateLink(58), 2=>"General Zarithrian"),
			62 => array(1=>$this->generateLink(59), 2=>"Halion"),
			63 => array(1=>"000000000000000000000000000000000000000111111111111111111111", 2=>"RUBY+ICC+TOTC"),
			64 => array(1=>"000000000000000000000000000000000000000000001111111111111111", 2=>"RUBY+ICC"),
			65 => array(1=>"00000000000000000000000000111111111111111111", 2=>"TOTC+ULDUAR"),
			66 => array(1=>"001111111111111110000000001111111111111", 2=>"NAXX+ULDUAR"),
		);
		
		$this->mode = intval($this->antiSQLInjection($mode));
		$this->server = $this->antiSQLInjection($server);
		$this->faction = intval($this->antiSQLInjection($faction));
		$this->type = intval($this->antiSQLInjection($type));
		$this->diffi = intval($this->antiSQLInjection($diffi));
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

new Home($db, __DIR__, $_GET["server"], $_GET["faction"], $_GET["mode"], $_GET["type"], $_GET["id"], $_GET["class"], $_GET["diff"]);

?>