<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	public $db = null;
	private $name = "";
	private $sname = "";
	private $gid = 0;
	private $sid = 0;
	private $gfac = 0;
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
	private $sRaidsById = array(
		2 => "Single Bosses",
		25 => "ONY10",
		26 => "ONY25",
		27 => "NAXX10",
		28 => "NAXX25",
		29 => "EYE10",
		30 => "EYE25",
		31 => "VOA10",
		32 => "VOA25",
		33 => "TOS10",
		34 => "TOS25",
		35 => "ULDUAR10",
		36 => "ULDUAR25",
		37 => "TOTC10",
		38 => "TOTC25",
		39 => "TOTC10H",
		40 => "TOTC25H",
		41 => "ICC10",
		42 => "ICC25",
		43 => "ICC10H",
		44 => "ICC25H",
		45 => "TRS10",
		46 => "TRS25",
		47 => "TRS10H",
		48 => "TRS25H",
	);
	private $typeById = array(
		-1 => array(
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
	private $raidBosses = array( // update npc db to match those ids
		2 => array(
			10184 => true,
			36538 => true,
			28859 => true,
			31734 => true,
			28860 => true,
			31311 => true,
		),
		25 => array(
			10184 => true,
		),
		26 => array(
			36538 => true,
		),
		27 => array(
			16028 => true,
			15931 => true,
			15932 => true,
			15928 => true,
			15956 => true,
			15953 => true,
			15952 => true,
			16061 => true,
			16060 => true,
			50005 => true,
			15954 => true,
			15936 => true,
			16011 => true,
			15989 => true,
			15990 => true,
		),
		28 => array(
			31099 => true,
			29373 => true,
			29417 => true,
			29448 => true,
			29249 => true,
			29268 => true,
			29278 => true,
			29940 => true,
			29955 => true,
			50021 => true,
			29615 => true,
			29701 => true,
			29718 => true,
			29991 => true,
			30061 => true,
		),
		29 => array(
			28859 => true,
		),
		30 => array(
			31734 => true,
		),
		31 => array(
			31125 => true,
			33993 => true,
			35013 => true,
			38433 => true,
		),
		32 => array(
			31722 => true,
			33994 => true,
			35360 => true,
			38462 => true,
		),
		33 => array(
			30451 => true,
			30452 => true,
			30449 => true,
			28860 => true,
		),
		34 => array(
			31520 => true,
			31534 => true,
			31535 => true,
			31311 => true,
		),
		35 => array(
			33118 => true,
			33186 => true,
			33293 => true,
			50000 => true,
			32930 => true,
			33515 => true,
			33244 => true, // May be wrong
			32906 => true,
			32865 => true,
			32845 => true,
			33271 => true,
			33288 => true,
			32871 => true,
		),
		36 => array(
			33190 => true,
			33724 => true,
			33885 => true,
			50008 => true,
			33909 => true,
			34175 => true,
			50025 => true,
			33360 => true,
			33147 => true,
			32846 => true,
			33449 => true,
			33955 => true,
			33070 => true,
		),
		37 => array(
			50001 => true,
			34780 => true,
			50002 => true,
			50003 => true,
			34564 => true,
		),
		38 => array(
			50009 => true,
			35216 => true,
			50012 => true,
			50015 => true,
			34566 => true,
		),
		39 => array(
			50010 => true,
			35268 => true,
			50013 => true,
			50016 => true,
			35615 => true,
		),
		40 => array(
			50011 => true,
			35269 => true,
			50014 => true,
			50017 => true,
			35616 => true,
		),
		41 => array(
			36612 => true,
			36855 => true,
			50007 => true,
			37813 => true,
			36626 => true,
			36627 => true,
			36678 => true,
			50004 => true,
			37955 => true,
			36789 => true,
			36853 => true,
			36597 => true,
		),
		42 => array(
			37957 => true,
			38106 => true,
			50022 => true,
			38402 => true,
			37504 => true,
			38390 => true,
			38431 => true,
			50018 => true,
			38434 => true,
			38174 => true, // May be the wrong id
			38265 => true,
			39166 => true,
		),
		43 => array(
			37958 => true,
			38296 => true,
			50023 => true,
			38582 => true,
			37505 => true,
			38549 => true,
			38585 => true,
			50019 => true,
			38435 => true,
			38589 => true,
			38266 => true,
			39167 => true,
		),
		44 => array(
			37959 => true,
			38297 => true,
			50024 => true,
			38583 => true,
			37506 => true,
			38550 => true,
			38586 => true,
			50020 => true,
			38436 => true,
			38590 => true,
			38267 => true,
			39168 => true,
		),
		45 => array(
			39823 => true,
			39751 => true,
			39805 => true,
			40143 => true,
		),
		46 => array(
			39747 => true, // May be wrong
			39899 => true,
			39746 => true,
			40142 => true,
		),
		47 => array(
			39823 => true,
			39751 => true,
			39805 => true,
			39864 => true,
		),
		48 => array(
			39747 => true,
			39899 => true,
			39746 => true,
			39863 => true,
		),
	);
	private $type = array(
		-1 => "DPS",
		1 => "HPS"
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
	
	private $mode = 0;
	private $faction = 0;
	private $typee = 0;
	private $classe = "";
	private $instance = "";
	private $prefix = array(
		1 => Array(
			0 => "bo",
			1 => "ao",
			2 => "bm",
			3 => "am"
		),
		2 => Array(
			0 => "o",
			1 => "o",
			2 => "m",
			3 => "m"
		)
	);
	private $gender = array(
		1 => "Unknown",
		2 => "Male",
		3 => "Female"
	);
	private $race = array(
		1 => "Human",
		2 => "Dwarf",
		3 => "Night Elf",
		4 => "Gnome",
		5 => "Orc",
		6 => "Undead",
		7 => "Troll",
		8 => "Tauren",
		9 => "Draenei",
		10 => "Blood Elf"
	);
	private $page = 1;
	private $bossNameById = array(10184 => 'Onyxia 10',36538 => 'Onyxia 25',16028 => 'Patchwerk',15931 => 'Grobbulus',15932 => 'Gluth',15928 => 'Thaddius',15956 => 'Anub\'Rekhan',15953 => 'Grand Widow Faerlina',15952 => 'Maexxna',16061 => 'Instructor Razuvious',16060 => 'Gothik the Harvester',50005 => 'The Four Horsemen',15954 => 'Noth the Plaguebringer',15936 => 'Heigan the Unclean',16011 => 'Loatheb',15989 => 'Sapphiron',15990 => 'Kel\'Thuzad',31099 => 'Patchwerk',29373 => 'Grobbulus',29417 => 'Gluth',29448 => 'Thaddius',29249 => 'Anub\'Rekhan',29268 => 'Grand Widow Faerlina',29278 => 'Maexxna',29940 => 'Instructor Razuvious',29955 => 'Gothik the Harvester',50021 => 'The Four Horsemen',29615 => 'Noth the Plaguebringer',29701 => 'Heigan the Unclean',29718 => 'Loatheb',29991 => 'Sapphiron',30061 => 'Kel\'Thuzad',28859 => 'Malygos 10',31734 => 'Malygos 25',31125 => 'Archavon the Stone Watcher',33993 => 'Emalon the Storm Watcher',35013 => 'Koralon the Flame Watcher',38433 => 'Toravon the Ice Watcher',31722 => 'Archavon the Stone Watcher',33994 => 'Emalon the Storm Watcher',35360 => 'Koralon the Flame Watcher',38462 => 'Toravon the Ice Watcher',30451 => 'Shadron',30452 => 'Tenebron',30449 => 'Vesperon',28860 => 'Sapphiron 10',31520 => 'Shadron',31534 => 'Tenebron',31535 => 'Vesperon',31311 => 'Sapphiron 25',33118 => 'Ignis the Furnace Master',33186 => 'Razorscale',33293 => 'XT-002 Deconstructor',50000 => 'The Assembly of Iron',32930 => 'Kologarn',33515 => 'Auriaya',33244 => 'Mimiron',32906 => 'Freya',32865 => 'Thorim',32845 => 'Hodir',33271 => 'General Vezax',33288 => 'Yogg-Saron',32871 => 'Algalon the Observer',33190 => 'Ignis the Furnace Master',33724 => 'Razorscale',33885 => 'XT-002 Deconstructor',50008 => 'The Assembly of Iron',33909 => 'Kologarn',34175 => 'Auriaya',50025 => 'Mimiron',33360 => 'Freya',33147 => 'Thorim',32846 => 'Hodir',33449 => 'General Vezax',33955 => 'Yogg-Saron',33070 => 'Algalon the Observer',50001 => 'Beasts of Northrend',34780 => 'Lord Jaraxxus',50002 => 'Faction Champions',50003 => 'Twin Val\'kyr',34564 => 'Anub\'arak',50009 => 'Beasts of Northrend',35216 => 'Lord Jaraxxus',50012 => 'Faction Champions',50015 => 'Twin Val\'kyr',34566 => 'Anub\'arak',50010 => 'Beasts of Northrend',35268 => 'Lord Jaraxxus',50013 => 'Faction Champions',50016 => 'Twin Val\'kyr',35615 => 'Anub\'arak',50011 => 'Beasts of Northrend',35269 => 'Lord Jaraxxus',50014 => 'Faction Champions',50017 => 'Twin Val\'kyr',35616 => 'Anub\'arak',36612 => 'Lord Marrowgar',36855 => 'Lady Deathwhisper',50007 => 'Gunship Battle',37813 => 'Deathbringer Saurfang',36626 => 'Festergut',36627 => 'Rotface',36678 => 'Professor Putricide',50004 => 'Blood Prince Council',37955 => 'Blood-Queen Lana\'thel',36789 => 'Valithria Dreamwalker',36853 => 'Sindragosa',36597 => 'The Lich King',37957 => 'Lord Marrowgar',38106 => 'Lady Deathwhisper',50022 => 'Gunship Battle',38402 => 'Deathbringer Saurfang',37504 => 'Festergut',38390 => 'Rotface',38431 => 'Professor Putricide',50018 => 'Blood Prince Council',38434 => 'Blood-Queen Lana\'thel',38174 => 'Valithria Dreamwalker',38265 => 'Sindragosa',39166 => 'The Lich King',37958 => 'Lord Marrowgar',38296 => 'Lady Deathwhisper',50023 => 'Gunship Battle',38582 => 'Deathbringer Saurfang',37505 => 'Festergut',38549 => 'Rotface',38585 => 'Professor Putricide',50019 => 'Blood Prince Council',38435 => 'Blood-Queen Lana\'thel',38589 => 'Valithria Dreamwalker',38266 => 'Sindragosa',39167 => 'The Lich King',37959 => 'Lord Marrowgar',38297 => 'Lady Deathwhisper',50024 => 'Gunship Battle',38583 => 'Deathbringer Saurfang',37506 => 'Festergut',38550 => 'Rotface',38586 => 'Professor Putricide',50020 => 'Blood Prince Council',38436 => 'Blood-Queen Lana\'thel',38590 => 'Valithria Dreamwalker',38267 => 'Sindragosa',39168 => 'The Lich King',39823 => 'Saviana Ragefire',39751 => 'Baltharus the Warborn',39805 => 'General Zarithrian',39863 => 'Halion',39747 => 'Saviana Ragefire',39899 => 'Baltharus the Warborn',39746 => 'General Zarithrian',40142 => 'Halion',39823 => 'Saviana Ragefire',39751 => 'Baltharus the Warborn',39805 => 'General Zarithrian',39864 => 'Halion',39747 => 'Saviana Ragefire',39899 => 'Baltharus the Warborn',39746 => 'General Zarithrian',40143 => 'Halion');  
	
	
	private function getRankingsLink($id){
		$link = "0";
		for ($i=1; $i<$this->bossPos[$id]; $i++){
			$link .= "0";
		}
		$link .= "1";
		return $link;
	}
	
	private function getGuildInfo($name, $server){
		$this->name = $name;
		$this->sname = $server;
		$q = $this->db->query('SELECT a.id, b.id as sid, a.faction FROM guilds a LEFT JOIN servernames b ON a.serverid = b.id WHERE b.name = "'.$this->sname.'" AND a.name = "'.$this->name.'" AND expansion = 2')->fetch();
		$this->gid = $q->id;
		$this->sid = $q->sid;
		$this->gfac = $q->faction;
		$this->faction = ($this->gfac == 1) ? "alliance" : "horde";
	}
	
	private function validConditions($type, $class, $nameid){
		if ((($this->typee != 0 && $this->typee == $type) or $this->typee == 0) and (strpos($this->classe, ''.$class) !== FALSE or !$this->classe) and (strpos($this->instance, ''.$nameid) !== FALSE or !$this->instance)){
			return true;
		}
		return false;
	}
	
	private function areFalse($arr){
		$count=0;
		foreach($arr as $v){
			if ($v)
				$count++;
		}
		return $count;
	}
	
	private function getProgress(){
		$t = array();
		foreach($this->db->query('SELECT a.npcid FROM `wotlk-raids-attempts` a LEFT JOIN `wotlk-raids` b ON a.rid = b.id WHERE b.guildid = "'.$this->gid.'" GROUP BY a.npcid') as $row){
			foreach(array(2,27,28,31,32,35,36,37,38,39,40,41,42,43,44,45,46,47,48) as $var){
				if (isset($this->raidBosses[$var][$row->npcid])){
					$this->raidBosses[$var][$row->npcid] = false;
				}
			}
		}
		foreach(array(2,27,28,31,32,35,36,37,38,39,40,41,42,43,44,45,46,47,48) as $var){
			$t[$var] = sizeOf($this->raidBosses[$var])-$this->areFalse($this->raidBosses[$var]);
		}
		return $t;
	}
	
	private function getProgressColor($n, $b){
		if ($n==0)
			return "none";
		if ($n==$b)
			return "clear";
		return "progress";
	}
	
	private function getRaidSchedule(){
		$RS = array(
			"Monday" => array(),
			"Tuesday" => array(),
			"Wednesday" => array(),
			"Thursday" => array(),
			"Friday" => array(),
			"Saturday" => array(),
			"Sunday" => array()
		);
		foreach($this->db->query('SELECT nameid, tsend FROM `wotlk-raids` WHERE guildid = "'.$this->gid.'" AND tsend BETWEEN '.(time()-1420000).' AND '.time()) as $row){
			$day = date("l", $row->tsend);
			$RS[$day][$row->nameid] = true;
		}
		return $RS;
	}
	
	public function content(){
		$pg = $this->getProgress();
		$RS = $this->getRaidSchedule();
		$content = '
		<div class="container cont" id="container">
			<section class="centredNormal top">
				<div class="ttitle '.$this->faction.'">
					<img src="{path}WOTLK/Guild/img/'.$this->faction.'.png"> &lt;'.$this->name.'&gt;
				</div>
				<a href=""><div class="pseudoButton">Achievements</div></a>
				<select id="sdung" multiple="multiple">
		';
			foreach($this->raidsById as $k => $v){
				$content .= '
					<option value="'.$k.'"'.($r = (strpos($this->instance, ''.$k) !== FALSE or !$this->instance) ? " selected" : "").'>'.$v.'</option>';
			}
		$content .= '
				</select>
				<select id="sclass" multiple="multiple">
					<option value="1"'.($r = (strpos($this->classe, '1') !== FALSE or !$this->classe) ? " selected" : "").' class="color-warrior">Warrior</option>
					<option value="2"'.($r = (strpos($this->classe, '2') !== FALSE or !$this->classe) ? " selected" : "").' class="color-rogue">Rogue</option>
					<option value="3"'.($r = (strpos($this->classe, '3') !== FALSE or !$this->classe) ? " selected" : "").' class="color-priest">Priest</option>
					<option value="4"'.($r = (strpos($this->classe, '4') !== FALSE or !$this->classe) ? " selected" : "").' class="color-hunter">Hunter</option>
					<option value="5"'.($r = (strpos($this->classe, '5') !== FALSE or !$this->classe) ? " selected" : "").' class="color-druid">Druid</option>
					<option value="6"'.($r = (strpos($this->classe, '6') !== FALSE or !$this->classe) ? " selected" : "").' class="color-mage">Mage</option>
					<option value="7"'.($r = (strpos($this->classe, '7') !== FALSE or !$this->classe) ? " selected" : "").' class="color-warlock">Warlock</option>
					<option value="8"'.($r = (strpos($this->classe, '8') !== FALSE or !$this->classe) ? " selected" : "").' class="color-paladin">Paladin</option>
					<option value="9"'.($r = (strpos($this->classe, '9') !== FALSE or !$this->classe) ? " selected" : "").' class="color-shaman">Shaman</option>
					<option value="10"'.($r = (strpos($this->classe, '10') !== FALSE or !$this->classe) ? " selected" : "").' class="color-deathknight">Death Knight</option>
				</select>
				<select onchange="window.location.replace(\'{path}WOTLK/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/\'+this.value+\'/'.$this->instance.'/'.$this->page.'\')">
					<option value="0"'.($r = ($this->typee==0) ? " selected" : "").'>Any type</option>
					<option value="-1"'.($r = ($this->typee==-1) ? " selected" : "").'>DPS</option>
					<option value="1"'.($r = ($this->typee==1) ? " selected" : "").'>HPS</option>
				</select>
				<select id="mode" onchange="window.location.replace(\'{path}WOTLK/Guild/'.$this->sname.'/'.$this->name.'/\'+this.value+\'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/'.$this->page.'\')">
					<option value="0" '.($r = ($this->mode==0) ? "selected" : "").'>Best all time</option>
					<option value="1" '.($r = ($this->mode==1) ? "selected" : "").'>Average all time</option>
					<option value="2" '.($r = ($this->mode==2) ? "selected" : "").'>Best this quarter</option>
					<option value="3" '.($r = ($this->mode==3) ? "selected" : "").'>Average this quarter</option>
				</select>
			</section>
			<section class="table">
				<div class="right">
					<div class="sleft">
						<table cellspacing="0" class="prog">
							<tr>
								<th colspan="2">Progress</th>
							</tr>
			';
			foreach(array(2,27,28,31,32,35,36,37,38,39,40,41,42,43,44,45,46,47,48) as $var){
				$content .= '
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[$var], sizeOf($this->raidBosses[$var])).'"><img src="{path}WOTLK/Guild/img/'.$var.'.png" />'.$this->raidsById[$var].'</td>
								<td class="datee '.$this->getProgressColor($pg[$var], sizeOf($this->raidBosses[$var])).'">'.$pg[$var].'/'.sizeOf($this->raidBosses[$var]).'</td>
								<td class="tooltip" style="height: '.(sizeOf($this->raidBosses[$var])*20+25).'px;">
									<div><img src="{path}WOTLK/Guild/img/'.$var.'.png" /></div>
									<h1>'.$this->sRaidsById[$var].'</h1>
									<ul>
				';
					foreach($this->raidBosses[$var] as $k => $v){
						$content .= '
										<li'.($r = (!$v) ? ' class="clear"' : ' class="none"').'>'.$this->bossNameById[$k].'</li>';
					}
				$content .= '
									</ul>
								</td>
							</tr>
				';
			}
			$content .= '
						</table>
						<table cellspacing="0" style="margin-top: 12px;">
							<tr>
								<th colspan="2">Raid Schedule</th>
							</tr>
		';
		foreach($RS as $k => $v){
			$content .= '
				<tr>
					<td class="date">'.$k.'</td>
					<td class="name">
			';
			$tempstr = "";
			foreach($v as $ke => $va){
				$tempstr .= ($r = ($tempstr != "") ? ", " : "").$this->sRaidsById[$ke];
			}
			$content .= $tempstr;
			$content .= '
					</td>
				</tr>
			';
		}
		$content .= '
						</table>
						<table cellspacing="0" style="margin-top: 12px;">
							<tr>
								<th>Recent raids</th>
								<th class="fulllist"><a href="{path}WOTLK/Guild/Raids/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
			';
		foreach ($this->db->query('SELECT id, tsstart, nameid FROM `wotlk-raids` WHERE guildid = "'.$this->gid.'" AND rdy = 1 AND nameid IN ('.$this->instance.') ORDER BY id DESC LIMIT 10;') as $row){
			$content .= '
							<tr>
								<td class="name pve"><img src="{path}WOTLK/Guild/img/'.$row->nameid.'.png" /><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->sRaidsById[$row->nameid].'</a></td>
								<td class="date"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$row->id.'">'.date("d.m.y H:i", $row->tsstart).'</a></td>
							</tr>
			';
		}
		$content .= '
						</table>
						<table cellspacing="0" style="margin-top: 12px;">
							<tr>
								<th>Recent kills</th>
								<th class="fulllist"><a href="{path}WOTLK/Guild/Kills/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
		';
		foreach ($this->db->query('SELECT c.name as boss, a.id, a.time, b.id as rid, a.npcid, b.nameid FROM `wotlk-raids-attempts` a LEFT JOIN `wotlk-raids` b ON a.rid = b.id LEFT JOIN tbc_npcs c ON a.npcid = c.id WHERE c.type = 1 AND b.guildid = "'.$this->gid.'" AND b.rdy = 1 AND a.type = 1 AND b.nameid IN ('.$this->instance.') ORDER BY a.time DESC LIMIT 10') as $row){
			$content .= '
							<tr>
								<td class="name pve"><img src="{path}WOTLK/Guild/img/'.$row->nameid.'.png" /><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->boss.'</a></td>
								<td class="date"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->id.'">'.date("d.m.y H:i", $row->time).'</a></td>
							</tr>
			';
		}
		$content .= '
						</table>
					</div>
					<div class="sright">
						<script>function goTo(a){var cat = ["ranking", "member"]; for (i=0; i<cat.length; i++){document.getElementById(cat[i]).style.display="none";document.getElementById("n"+cat[i]).style.color="white";};document.getElementById(a).style.display="block";document.getElementById("n"+a).style.color="#f28f45"; var d = new Date(); d.setTime(d.getTime()+180*1000);document.cookie = "gpage="+a+"; expires="+d.toUTCString()+";";};</script>
						<table cellspacing="0" id="navbar">
							<tr>
								<th><a href="javascript:;" id="nranking" class="selected" onClick="goTo(\'ranking\');" title="Global rank | Global-Class rank | Global-Type rank | Realm rank | Realm-Class rank | Realm-Type rank | Category | Value | Name | Bossname | Attempt
Global rank: The rank you achieved on all server.
Global-Class rank: The rank you achieved among your class on all server.
Global-Type rank: The rank you achieved among the caster or meele on all server.
Realm rank: The rank you achieved among the realm. 
Realm-Class rank: The rank you achieved on your realm among your class. 
Realm-Type rank: The rank you achieved among the caster or meele on your realm.
Attempt: The attempt this record was achieved.">Top ranked members*</a></th>
								<th><a href="javascript:;" id="nmember" onClick="goTo(\'member\');">Member</a></th>
								<th colspan="9">&nbsp;</th>
							</tr>
						</table>
						<table cellspacing="0" id="ranking">
		';
		$counter = array();
		$result = array();
		$p = 0;
		foreach ($this->db->query('SELECT b.guildid, a.type, b.classid, b.serverid, a.'.$this->prefix[1][$this->mode].'val as val, b.name, b.id as charid, a.id, d.name as npcname, c.time, a.'.$this->prefix[2][$this->mode].'attemptid as attemptid, c.rid, a.bossid, e.nameid FROM `wotlk-rankings` a 
			LEFT JOIN chars b ON a.charid = b.id 
			LEFT JOIN `wotlk-raids-attempts` c ON a.'.$this->prefix[2][$this->mode].'attemptid = c.id
			LEFT JOIN wotlk_npcs d ON a.bossid = d.id
			LEFT JOIN `wotlk-raids` e ON c.rid = e.id
			ORDER BY a.boval DESC') as $row){
			$counter[$row->bossid][1][$row->type][1] += 1; // overall
			$counter[$row->bossid][1][$row->type][2][$row->classid] += 1; // overall class
			$counter[$row->bossid][1][$row->type][3][$this->typeById[$row->type][$row->classid]] += 1; // overall type
			$counter[$row->bossid][2][$row->serverid][$row->type][1] += 1; // realm
			$counter[$row->bossid][2][$row->serverid][$row->type][2][$row->classid] += 1; // realm class
			$counter[$row->bossid][2][$row->serverid][$row->type][3][$this->typeById[$row->type][$row->classid]] += 1; // realm type
			if ($row->guildid == $this->gid && $this->validConditions($row->type, $row->classid, $row->nameid)){
				$result[$p] = array(1=>$row, 2=>$counter[$row->bossid][1][$row->type][1], 3=>$counter[$row->bossid][1][$row->type][2][$row->classid], 4=>$counter[$row->bossid][1][$row->type][3][$this->typeById[$row->type][$row->classid]], 5 =>$counter[$row->bossid][2][$row->serverid][$row->type][1], 6=>$counter[$row->bossid][2][$row->serverid][$row->type][2][$row->classid], 7 => $counter[$row->bossid][2][$row->serverid][$row->type][3][$this->typeById[$row->type][$row->classid]], 8 => $row->nameid);
				$p++;
				if ($p>$this->page*50)
					break;
			}
		}
		$result = $this->sort_list($result);
		foreach($result as $key => $var){
				if (($this->page-1)*50<=$key && $key<=$this->page*50){
				$content .= '
							<tr>
								<td class="num">'.$var[2].'</td>
								<td class="num">'.$var[3].'</td>
								<td class="num">'.$var[4].'</td>
								<td class="num">'.$var[5].'</td>
								<td class="num">'.$var[6].'</td>
								<td class="num">'.$var[7].'</td>
								<td class="num">'.$this->type[$var[1]->type].'</td>
								<td class="num">'.$this->mReadable($var[1]->val, 2).'</td>
								<td class="sstring"><img src="{path}Database/classes/c'.$var[1]->classid.'.png"><a href="{path}WOTLK/Character/'.$this->sname.'/'.$var[1]->name.'/0" class="color-'.$this->classById[$var[1]->classid].'">'.$var[1]->name.'</a></td>
								<td class="pve"><img src="{path}WOTLK/Guild/img/'.$var[8].'.png" /><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type='.$var[1]->type.'&mode=0&id='.$this->getRankingsLink($var[1]->bossid).'">'.$var[1]->npcname.'</a></td>
								<td class="sstring"><a href="{path}WOTLK/Raids/Evaluation/index.php?rid='.$var[1]->rid.'&attempts='.$var[1]->attemptid.'">'.date("d.m.y H:i", $var[1]->time).'</a></td>
							</tr>
				';
				}
		}
		$content .= '
						</table>
						<table cellspacing="0" id="member">
		';
		foreach($this->db->query('SELECT name, classid, grankname, gender, level, race, seen FROM armory b LEFT JOIN chars a ON a.id = b.charid WHERE guildid = '.$this->gid.' ORDER BY grankindex, seen DESC, name LIMIT '.(($this->page-1)*50).', 50') as $row){
			$content .= '
							<tr>
								<td class="pve"><img src="{path}Database/racegender/Ui-charactercreate-races_'.str_replace(" ", "",strtolower($this->race[$row->race])).'-'.strtolower($this->gender[$row->gender]).'-small.png" /><img src="{path}Database/classes/c'.$row->classid.'.png"><a href="{path}WOTLK/Character/'.$this->sname.'/'.$row->name.'/0" class="color-'.$this->classById[$row->classid].'">'.$row->name.'</a></td>
								<td>'.$row->grankname.'</td>
								<td>Level '.$row->level.' '.$this->gender[$row->gender].' '.$this->race[$row->race].' <span class="color-'.$this->classById[$row->classid].'">'.ucfirst($this->classById[$row->classid]).'</span></td>
								<td>'.($r = (floor((time()-$row->seen)/86400)==0) ? "Seen today" : "Seen ".floor((time()-$row->seen)/86400)." days ago").'</td>
							</tr>
			';
		}
		$content .= '
						</table>
						<footer class="pager">
							<div class="pleft">
								<a href="{path}WOTLK/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}WOTLK/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
							</div>
							<div class="pright">
								<div class="pseudoButton">Page '.$this->page.'</div><a href="{path}WOTLK/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/'.($this->page+1).'"><button class="icon-button icon-arrowright"></button></a>
							</div>
						</footer>
						<script>goTo(\''.($r = (isset($_COOKIE["gpage"])) ? $_COOKIE["gpage"] : "ranking").'\');</script>
					</div>
				</div>
			</section>
		</div>
		<script>
			$(\'#sdung\').multipleSelect({
				onClose: function() {
					window.location.replace(\'{path}WOTLK/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/\'+$(\'#sdung\').multipleSelect(\'getSelects\')+\'/'.$this->page.'\');
				},
				allSelected: \'Any raid\'
			});
			$(\'#sclass\').multipleSelect({
				onClose: function() {
					window.location.replace(\'{path}WOTLK/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/\'+$(\'#sclass\').multipleSelect(\'getSelects\')+\'/'.$this->typee.'/'.$this->instance.'/'.$this->page.'\');
				},
				allSelected: \'Any class\'
			});
		</script>
		';
		pq('#container')->replaceWith($content);
	}
	
	private function iterate(&$arr, &$list){
		$max = 1000000; $val = 0; $result = array(); $k = 0; $max2 = 1000000;
		foreach($arr as $key => $var){
			if ($var[6]<=$max && $var[5]<=$max2){
				if ($var[1]->val>=$val or $var[5]<$max2 or $var[6]<$max){
					$max = $var[6];
					$max2 = $var[5];
					$val = $var[1]->val;
					$k = $key;
					$result = $var;
				}
			}
		}
		if (empty($result))
			return false;
		unset($arr[$k]);
		$list[] = $result;
		$this->iterate($arr, $list);
	}
	
	private function sort_list(&$arr){
		$result = array();
		$this->iterate($arr, $result);
		return $result;
	}
	
	public function __construct($db, $dir, $gname, $server, $mode, $typee, $classe, $instance, $page){
		$this->db = $db;
		$this->mode = intval($mode);
		$this->typee = intval($typee);
		$this->classe = $this->antiSQLInjection($classe);
		if (!$this->classe)
			$this->classe = "1,2,3,4,5,6,7,8,9,10";
		$this->instance = $this->antiSQLInjection($instance);
		if (!$this->instance)
			$this->instance = "25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48";
		if (intval($this->antiSQLInjection($page))==0)
			$this->page=1;
		else
			$this->page = intval($this->antiSQLInjection($page));
		$this->getGuildInfo($gname, $this->antiSQLInjection($server));
		$this->addCssLink("{path}External/multipleselect/multiple-select.css");
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js", true);
		$this->addJsLink("{path}External/multipleselect/multiple-select.js", true);
		$this->siteTitle = " - Guildinformation of ".$this->antiSQLInjection($gname)." on ".$this->antiSQLInjection($server);
		$this->keyWords = $this->antiSQLInjection($gname);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["name"], $_GET["server"], $_GET["mode"], $_GET["type"], $_GET["class"], $_GET["instance"], $_GET["page"]);

?>