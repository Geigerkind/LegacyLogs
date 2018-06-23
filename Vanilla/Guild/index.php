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
		1 => "Molten Core",
		2 => "Onyxia's Lair",
		3 => "Blackwing Lair",
		4 => "Zul'Gurub",
		5 => "Ruins of Ahn'Qiraj",
		6 => "Ahn'Qiraj",
		7 => "Naxxramas",
		8 => "Feralas",
		9 => "Azshara",
		10 => "Blasted Lands",
		11 => "Ashenvale",
		12 => "Duskwood",
		13 => "Hinterlands",
		14 => "Temple of Ahn'Qiraj"
	);
	private $sRaidsById = array(
		1 => "MC",
		2 => "ONY",
		3 => "BWL",
		4 => "ZG",
		5 => "AQ20",
		6 => "AQ40",
		7 => "NAXX",
		8 => "NMD",
		9 => "AZU",
		10 => "KAZ",
		11 => "NMD",
		12 => "NMD",
		13 => "NMD",
		14 => "AQ40"
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
			9 => 2
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
			9 => 2
		)
	);
	private $raidBosses = array(
		1 => array(
			12118 => true,
			11982 => true,
			12259 => true,
			12057 => true,
			12056 => true,
			12264 => true,
			12098 => true,
			11988 => true,
			12018 => true,
			11502 => true,
		),
		2 => array(
			10184 => true,
		),
		3 => array(
			12435 => true,
			13020 => true,
			12017 => true,
			11983 => true,
			14601 => true,
			11981 => true,
			14020 => true,
			11583 => true,
		),
		4 => array(
			14517 => true,
			14507 => true,
			14510 => true,
			11382 => true,
			15082 => true,
			15083 => true,
			15085 => true,
			15114 => true,
			14509 => true,
			14515 => true,
			11380 => true,
			14834 => true,
		),
		5 => array(
			15348 => true,
			15341 => true,
			15340 => true,
			15370 => true,
			15369 => true,
			15339 => true,
		),
		6 => array(
			15263 => true,
			50000 => true,
			15516 => true,
			15510 => true,
			15299 => true,
			15509 => true,
			50001 => true,
			15517 => true,
			15727 => true,
		),
		7 => array(
			16028 => true,
			15931 => true,
			15932 => true,
			15928 => true,
			15956 => true,
			15953 => true,
			15952 => true,
			16061 => true,
			16060 => true,
			16064 => true,
			15954 => true,
			15936 => true,
			16011 => true,
			15989 => true,
			15990 => true,
		),
		8 => array(
			12397 => true,
			6109 => true,
			14889 => true,
			14887 => true,
			14888 => true,
			14890 => true,
		),
		9 => array(
			12397 => true,
			6109 => true,
			14889 => true,
			14887 => true,
			14888 => true,
			14890 => true,
		),
		10 => array(
			12397 => true,
			6109 => true,
			14889 => true,
			14887 => true,
			14888 => true,
			14890 => true,
		),
		11 => array(
			12397 => true,
			6109 => true,
			14889 => true,
			14887 => true,
			14888 => true,
			14890 => true,
		),
		12 => array(
			12397 => true,
			6109 => true,
			14889 => true,
			14887 => true,
			14888 => true,
			14890 => true,
		),
		13 => array(
			12397 => true,
			6109 => true,
			14889 => true,
			14887 => true,
			14888 => true,
			14890 => true,
		)
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
		9 => "shaman"
	);
	private $bossPos = Array(12118 => 1, 11982 => 2, 12259 => 3, 12057 => 4, 12056 => 5, 12264 => 6, 12098 => 7, 11988 => 8, 12018 => 9, 11502 => 10, 10184 => 11, 12397 => 12, 6109 => 13, 14889 => 14, 14887 => 15, 14888 => 16, 14890 => 17, 12435 => 18, 13020 => 19, 12017 => 20, 11983 => 21, 14601 => 22, 11981 => 23, 14020 => 24, 11583 => 25, 14517 => 26, 14507 => 27, 14510 => 28, 11382 => 29, 15082 => 30, 15083 => 31, 15085 => 32, 15114 => 33, 14509 => 34, 14515 => 35, 11380 => 36, 14834 => 37, 15348 => 38, 15341 => 39, 15340 => 40, 15370 => 41, 15369 => 42, 15339 => 43, 15263 => 44, 50000 => 45, 15516 => 46, 15510 => 47, 15299 => 48, 15509 => 49, 50001 => 50, 15517 => 51, 15727 => 52, 16028 => 53, 15931 => 54, 15932 => 55, 15928 => 56, 15956 => 57, 15953 => 58, 15952 => 59, 16061 => 60, 16060 => 61, 50002 => 62, 15954 => 63, 15936 => 64, 16011 => 65, 15989 => 66, 15990 => 67);
	private $instanceLink = Array(1 => "01111111111", 2 => "00000000001", 3 => "00000000000000000011111111", 4 => "00000000000000000000000000111111111111", 5 => "00000000000000000000000000000000000000111111", 6 => "00000000000000000000000000000000000000000000111111111", 7 => "00000000000000000000000000000000000000000000000000000111111111111111", 8 => "000000000000001111", 9 => "00000000000001", 10 => "0000000000001", 11 => "000000000000001111", 12 => "000000000000001111", 13 => "000000000000001111", 14 => "00000000000000000000000000000000000000000000111111111");
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
		8 => "Tauren"
	);
	private $page = 1;
	
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
		$q = $this->db->query('SELECT a.id, b.id as sid, a.faction FROM guilds a LEFT JOIN servernames b ON a.serverid = b.id WHERE b.expansion=0 AND b.name = "'.$this->sname.'" AND a.name = "'.$this->name.'"')->fetch();
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
	
	private function getProgress(){
		$t = array();
		foreach($this->db->query('SELECT a.npcid FROM `v-raids-attempts` a LEFT JOIN `v-raids` b ON a.rid = b.id WHERE b.guildid = "'.$this->gid.'" AND a.npcid IN (12118,11982,12259,12057,12056,12264,12098,11988,12018,11502,10184,12397,6109,14889,14887,14888,14890,12435,13020,12017,11983,14601,11981,14020,11583,14517,14507,14510,11382,15082,15083,15085,15114,14509,14515,11380,14834,15348,15341,15340,15370,15369,15339,15263,50000,15516,15510,15299,15509,50001,15517,15727,16028,15931,15932,15928,15956,15953,15952,16061,16060,50002,15954,15936,16011,15989,15990 ) GROUP BY a.npcid') as $row){
			unset($this->raidBosses[1][$row->npcid], $this->raidBosses[2][$row->npcid], $this->raidBosses[3][$row->npcid], $this->raidBosses[4][$row->npcid], $this->raidBosses[5][$row->npcid], $this->raidBosses[6][$row->npcid], $this->raidBosses[7][$row->npcid], $this->raidBosses[8][$row->npcid]);
		}
		$t[1] = 10-sizeOf($this->raidBosses[1]);
		$t[2] = 1-sizeOf($this->raidBosses[2]);
		$t[3] = 8-sizeOf($this->raidBosses[3]);
		$t[4] = 12-sizeOf($this->raidBosses[4]);
		$t[5] = 6-sizeOf($this->raidBosses[5]);
		$t[6] = 9-sizeOf($this->raidBosses[6]);
		$t[7] = 15-sizeOf($this->raidBosses[7]);
		$t[8] = 6-sizeOf($this->raidBosses[8]);
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
		foreach($this->db->query('SELECT nameid, tsend FROM `v-raids` WHERE guildid = "'.$this->gid.'" AND tsend BETWEEN '.(time()-1420000).' AND '.time()) as $row){
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
					<img src="{path}Vanilla/Guild/img/'.$this->faction.'.png"> &lt;'.$this->name.'&gt;
				</div>
				<a href=""><div class="pseudoButton">Achievements</div></a>
				<select id="sdung" multiple="multiple">
					<option value="1"'.($r = (strpos($this->instance, '1') !== FALSE or !$this->instance) ? " selected" : "").'>Molten Core</option>
					<option value="2"'.($r = (strpos($this->instance, '2') !== FALSE or !$this->instance) ? " selected" : "").'>Onyxia\'s Lair</option>
					<option value="4"'.($r = (strpos($this->instance, '4') !== FALSE or !$this->instance) ? " selected" : "").'>Zul\'Gurub</option>
					<option value="3"'.($r = (strpos($this->instance, '3') !== FALSE or !$this->instance) ? " selected" : "").'>Blackwing Lair</option>
					<option value="5"'.($r = (strpos($this->instance, '5') !== FALSE or !$this->instance) ? " selected" : "").'>Ruins of Ahn\'Qiraj</option>
					<option value="6"'.($r = (strpos($this->instance, '6') !== FALSE or !$this->instance) ? " selected" : "").'>Temple of Ahn\'Qiraj</option>
					<option value="7"'.($r = (strpos($this->instance, '7') !== FALSE or !$this->instance) ? " selected" : "").'>Naxxramas</option>
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
				</select>
				<select onchange="window.location.replace(\'{path}Vanilla/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/\'+this.value+\'/'.$this->instance.'/'.$this->page.'\')">
					<option value="0"'.($r = ($this->typee==0) ? " selected" : "").'>Any type</option>
					<option value="-1"'.($r = ($this->typee==-1) ? " selected" : "").'>DPS</option>
					<option value="1"'.($r = ($this->typee==1) ? " selected" : "").'>HPS</option>
				</select>
				<select id="mode" onchange="window.location.replace(\'{path}Vanilla/Guild/'.$this->sname.'/'.$this->name.'/\'+this.value+\'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/'.$this->page.'\')">
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
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[8], 6).'"><img src="{path}Vanilla/Guild/img/8.png" />World Bosses</td>
								<td class="datee '.$this->getProgressColor($pg[8], 6).'">'.$pg[8].'/6</td>
								<td class="tooltip">
									<div><img src="{path}Vanilla/Guild/img/8.png" /></div>
									<h1>World Bosses</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[8][6109])) ? ' class="clear"' : ' class="none"').'>Azuregos</li>
										<li'.($r = (!isset($this->raidBosses[8][12397])) ? ' class="clear"' : ' class="none"').'>Kazzak</li>
										<li'.($r = (!isset($this->raidBosses[8][14888])) ? ' class="clear"' : ' class="none"').'>Lethon</li>
										<li'.($r = (!isset($this->raidBosses[8][14889])) ? ' class="clear"' : ' class="none"').'>Emeriss</li>
										<li'.($r = (!isset($this->raidBosses[8][14887])) ? ' class="clear"' : ' class="none"').'>Ysondre</li>
										<li'.($r = (!isset($this->raidBosses[8][14890])) ? ' class="clear"' : ' class="none"').'>Taerer</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[1], 10).'"><img src="{path}Vanilla/Guild/img/1.png" />Molten Core</td>
								<td class="datee '.$this->getProgressColor($pg[1], 10).'">'.$pg[1].'/10</td>
								<td class="tooltip" id="mc">
									<div><img src="{path}Vanilla/Guild/img/1.png" /></div>
									<h1>Molten Core</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[1][12118])) ? ' class="clear"' : ' class="none"').'>Lucifron</li>
										<li'.($r = (!isset($this->raidBosses[1][11982])) ? ' class="clear"' : ' class="none"').'>Magmadar</li>
										<li'.($r = (!isset($this->raidBosses[1][12259])) ? ' class="clear"' : ' class="none"').'>Gehennas</li>
										<li'.($r = (!isset($this->raidBosses[1][12057])) ? ' class="clear"' : ' class="none"').'>Garr</li>
										<li'.($r = (!isset($this->raidBosses[1][12056])) ? ' class="clear"' : ' class="none"').'>Baron Geddon</li>
										<li'.($r = (!isset($this->raidBosses[1][12264])) ? ' class="clear"' : ' class="none"').'>Shazzrah</li>
										<li'.($r = (!isset($this->raidBosses[1][12098])) ? ' class="clear"' : ' class="none"').'>Sulfuron Harbinger</li>
										<li'.($r = (!isset($this->raidBosses[1][11988])) ? ' class="clear"' : ' class="none"').'>Golemagg</li>
										<li'.($r = (!isset($this->raidBosses[1][12018])) ? ' class="clear"' : ' class="none"').'>Majordomo Executus</li>
										<li'.($r = (!isset($this->raidBosses[1][11502])) ? ' class="clear"' : ' class="none"').'>Ragnaros</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[2], 1).'"><img src="{path}Vanilla/Guild/img/2.png" />Onyxia\'s Lair</td>
								<td class="datee '.$this->getProgressColor($pg[2], 1).'">'.$pg[2].'/1</td>
								<td class="tooltip" id="ony">
									<div><img src="{path}Vanilla/Guild/img/2.png" /></div>
									<h1>Onyxia\'s Lair</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[2][10184])) ? ' class="clear"' : ' class="none"').'>Onyxia</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[4], 12).'"><img src="{path}Vanilla/Guild/img/4.png" />Zul\'Gurub</td>
								<td class="datee '.$this->getProgressColor($pg[4], 12).'">'.$pg[4].'/12</td>
								<td class="tooltip" id="zg">
									<div><img src="{path}Vanilla/Guild/img/4.png" /></div>
									<h1>Zul\'Gurub</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[4][14517])) ? ' class="clear"' : ' class="none"').'>High Priestess Jeklik</li>
										<li'.($r = (!isset($this->raidBosses[4][14507])) ? ' class="clear"' : ' class="none"').'>High Priest Venoxis</li>
										<li'.($r = (!isset($this->raidBosses[4][14510])) ? ' class="clear"' : ' class="none"').'>High Priestess Mar\'li</li>
										<li'.($r = (!isset($this->raidBosses[4][11382])) ? ' class="clear"' : ' class="none"').'>Bloodlord Mandokir</li>
										<li'.($r = (!isset($this->raidBosses[4][15082])) ? ' class="clear"' : ' class="none"').'>Gri\'lek</li>
										<li'.($r = (!isset($this->raidBosses[4][15083])) ? ' class="clear"' : ' class="none"').'>Hazza\'rah</li>
										<li'.($r = (!isset($this->raidBosses[4][15085])) ? ' class="clear"' : ' class="none"').'>Wushoolay</li>
										<li'.($r = (!isset($this->raidBosses[4][15114])) ? ' class="clear"' : ' class="none"').'>Gahz\'ranka</li>
										<li'.($r = (!isset($this->raidBosses[4][14509])) ? ' class="clear"' : ' class="none"').'>High Priest Thekal</li>
										<li'.($r = (!isset($this->raidBosses[4][14515])) ? ' class="clear"' : ' class="none"').'>High Priestess Arlokk</li>
										<li'.($r = (!isset($this->raidBosses[4][11380])) ? ' class="clear"' : ' class="none"').'>Jin\'do the Hexxer</li>
										<li'.($r = (!isset($this->raidBosses[4][14834])) ? ' class="clear"' : ' class="none"').'>Hakkar</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[3], 8).'"><img src="{path}Vanilla/Guild/img/3.png" />Blackwing Lair</td>
								<td class="datee '.$this->getProgressColor($pg[3], 8).'">'.$pg[3].'/8</td>
								<td class="tooltip" id="bwl">
									<div><img src="{path}Vanilla/Guild/img/3.png" /></div>
									<h1>Blackwing Lair</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[3][12435])) ? ' class="clear"' : ' class="none"').'>Razorgore</li>
										<li'.($r = (!isset($this->raidBosses[3][13020])) ? ' class="clear"' : ' class="none"').'>Vaelastraz</li>
										<li'.($r = (!isset($this->raidBosses[3][12017])) ? ' class="clear"' : ' class="none"').'>Broodlord Lashlayer</li>
										<li'.($r = (!isset($this->raidBosses[3][11983])) ? ' class="clear"' : ' class="none"').'>Firemaw</li>
										<li'.($r = (!isset($this->raidBosses[3][14601])) ? ' class="clear"' : ' class="none"').'>Ebonroc</li>
										<li'.($r = (!isset($this->raidBosses[3][11981])) ? ' class="clear"' : ' class="none"').'>Flamegor</li>
										<li'.($r = (!isset($this->raidBosses[3][14020])) ? ' class="clear"' : ' class="none"').'>Chromaggus</li>
										<li'.($r = (!isset($this->raidBosses[3][11583])) ? ' class="clear"' : ' class="none"').'>Nefarian</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[5], 6).'"><img src="{path}Vanilla/Guild/img/5.png" />Ruins of Ahn\'Qiraj</td>
								<td class="datee '.$this->getProgressColor($pg[5], 6).'">'.$pg[5].'/6</td>
								<td class="tooltip">
									<div><img src="{path}Vanilla/Guild/img/5.png" /></div>
									<h1>Ahn\'Qiraj 20</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[5][15348])) ? ' class="clear"' : ' class="none"').'>Kurinnaxx</li>
										<li'.($r = (!isset($this->raidBosses[5][15341])) ? ' class="clear"' : ' class="none"').'>General Rajaxx</li>
										<li'.($r = (!isset($this->raidBosses[5][15340])) ? ' class="clear"' : ' class="none"').'>Moam</li>
										<li'.($r = (!isset($this->raidBosses[5][15370])) ? ' class="clear"' : ' class="none"').'>Buru the Gorger</li>
										<li'.($r = (!isset($this->raidBosses[5][15369])) ? ' class="clear"' : ' class="none"').'>Ayamiss the Hunter</li>
										<li'.($r = (!isset($this->raidBosses[5][15339])) ? ' class="clear"' : ' class="none"').'>Ossirian the Unscarred</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[6], 9).'"><img src="{path}Vanilla/Guild/img/6.png" />Temple of Ahn\'Qiraj</td>
								<td class="datee '.$this->getProgressColor($pg[6], 9).'">'.$pg[6].'/9</td>
								<td class="tooltip" id="aq">
									<div><img src="{path}Vanilla/Guild/img/6.png" /></div>
									<h1>Ahn\'Qiraj 40</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[6][15263])) ? ' class="clear"' : ' class="none"').'>The Prophet Skeram</li>
										<li'.($r = (!isset($this->raidBosses[6][15516])) ? ' class="clear"' : ' class="none"').'>Battleguard Sartura</li>
										<li'.($r = (!isset($this->raidBosses[6][15510])) ? ' class="clear"' : ' class="none"').'>Fankriss</li>
										<li'.($r = (!isset($this->raidBosses[6][15509])) ? ' class="clear"' : ' class="none"').'>Princess Huhuran</li>
										<li'.($r = (!isset($this->raidBosses[6][50001])) ? ' class="clear"' : ' class="none"').'>The Twin Emperors</li>
										<li'.($r = (!isset($this->raidBosses[6][15517])) ? ' class="clear"' : ' class="none"').'>Ouro</li>
										<li'.($r = (!isset($this->raidBosses[6][15727])) ? ' class="clear"' : ' class="none"').'>C\'Thun</li>
										<li'.($r = (!isset($this->raidBosses[6][15299])) ? ' class="clear"' : ' class="none"').'>Viscidus</li>
										<li'.($r = (!isset($this->raidBosses[6][50000])) ? ' class="clear"' : ' class="none"').'>The Bug Family</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[7], 15).'"><img src="{path}Vanilla/Guild/img/7.png" />Naxxramas</td>
								<td class="datee '.$this->getProgressColor($pg[7], 15).'">'.$pg[7].'/15</td>
								<td class="tooltip" id="naxx">
									<div><img src="{path}Vanilla/Guild/img/7.png" /></div>
									<h1>Naxxramas</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[7][16028])) ? ' class="clear"' : ' class="none"').'>Patchwerk</li>
										<li'.($r = (!isset($this->raidBosses[7][15931])) ? ' class="clear"' : ' class="none"').'>Grobbulus</li>
										<li'.($r = (!isset($this->raidBosses[7][15932])) ? ' class="clear"' : ' class="none"').'>Gluth</li>
										<li'.($r = (!isset($this->raidBosses[7][15928])) ? ' class="clear"' : ' class="none"').'>Thaddius</li>
										<li'.($r = (!isset($this->raidBosses[7][15956])) ? ' class="clear"' : ' class="none"').'>Anub\'Rekhan</li>
										<li'.($r = (!isset($this->raidBosses[7][15953])) ? ' class="clear"' : ' class="none"').'>Grand Widow Faerlina</li>
										<li'.($r = (!isset($this->raidBosses[7][15952])) ? ' class="clear"' : ' class="none"').'>Maexxna</li>
										<li'.($r = (!isset($this->raidBosses[7][16061])) ? ' class="clear"' : ' class="none"').'>Instructor Razuvious</li>
										<li'.($r = (!isset($this->raidBosses[7][16060])) ? ' class="clear"' : ' class="none"').'>Gothik the Harvester</li>
										<li'.($r = (!isset($this->raidBosses[7][16064])) ? ' class="clear"' : ' class="none"').'>The Four Horsemen</li>
										<li'.($r = (!isset($this->raidBosses[7][15954])) ? ' class="clear"' : ' class="none"').'>Noth</li>
										<li'.($r = (!isset($this->raidBosses[7][15936])) ? ' class="clear"' : ' class="none"').'>Heigan the Unclean</li>
										<li'.($r = (!isset($this->raidBosses[7][16011])) ? ' class="clear"' : ' class="none"').'>Loatheb</li>
										<li'.($r = (!isset($this->raidBosses[7][15989])) ? ' class="clear"' : ' class="none"').'>Sapphiron</li>
										<li'.($r = (!isset($this->raidBosses[7][15990])) ? ' class="clear"' : ' class="none"').'>Kel\'Thuzad</li>
									</ul>
								</td>
							</tr>
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
								<th class="fulllist"><a href="{path}Vanilla/Guild/Raids/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
			';
		foreach ($this->db->query('SELECT id, tsstart, nameid FROM `v-raids` WHERE guildid = "'.$this->gid.'" AND rdy = 1 AND nameid IN ('.$this->instance.') ORDER BY id DESC LIMIT 10;') as $row){
			$content .= '
							<tr>
								<td class="name pve"><img src="{path}Vanilla/Guild/img/'.$row->nameid.'.png" /><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->raidsById[$row->nameid].'</a></td>
								<td class="date"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$row->id.'">'.date("d.m.y H:i", $row->tsstart).'</a></td>
							</tr>
			';
		}
		$content .= '
						</table>
						<table cellspacing="0" style="margin-top: 12px;">
							<tr>
								<th>Recent kills</th>
								<th class="fulllist"><a href="{path}Vanilla/Guild/Kills/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
		';
		foreach ($this->db->query('SELECT c.name as boss, a.id, a.time, b.id as rid, a.npcid, b.nameid FROM `v-raids-attempts` a LEFT JOIN `v-raids` b ON a.rid = b.id LEFT JOIN npcs c ON a.npcid = c.id WHERE c.type = 1 AND b.guildid = "'.$this->gid.'" AND b.rdy = 1 AND a.type = 1 AND b.nameid IN ('.$this->instance.') ORDER BY a.time DESC LIMIT 10') as $row){
			$content .= '
							<tr>
								<td class="name pve"><img src="{path}Vanilla/Guild/img/'.$row->nameid.'.png" /><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->boss.'</a></td>
								<td class="date"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->id.'">'.date("d.m.y H:i", $row->time).'</a></td>
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
		foreach ($this->db->query('SELECT b.guildid, a.type, b.classid, b.serverid, a.'.$this->prefix[1][$this->mode].'val as val, b.name, b.id as charid, a.id, d.name as npcname, c.time, a.'.$this->prefix[2][$this->mode].'attemptid as attemptid, c.rid, a.bossid, e.nameid FROM `v-rankings` a 
			LEFT JOIN chars b ON a.charid = b.id 
			LEFT JOIN `v-raids-attempts` c ON a.'.$this->prefix[2][$this->mode].'attemptid = c.id
			LEFT JOIN npcs d ON a.bossid = d.id
			LEFT JOIN `v-raids` e ON c.rid = e.id
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
								<td class="sstring"><img src="{path}Database/classes/c'.$var[1]->classid.'.png"><a href="{path}Vanilla/Character/'.$this->sname.'/'.$var[1]->name.'/0" class="color-'.$this->classById[$var[1]->classid].'">'.$var[1]->name.'</a></td>
								<td class="pve"><img src="{path}Vanilla/Guild/img/'.$var[8].'.png" /><a href="{path}Vanilla/Rankings/Table/?server=0&faction=0&type='.$var[1]->type.'&mode=0&id='.$this->getRankingsLink($var[1]->bossid).'">'.$var[1]->npcname.'</a></td>
								<td class="sstring"><a href="{path}Vanilla/Raids/Evaluation/index.php?rid='.$var[1]->rid.'&attempts='.$var[1]->attemptid.'">'.date("d.m.y H:i", $var[1]->time).'</a></td>
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
								<td class="pve"><img src="{path}Database/racegender/Ui-charactercreate-races_'.str_replace(" ", "",strtolower($this->race[$row->race])).'-'.strtolower($this->gender[$row->gender]).'-small.png" /><img src="{path}Database/classes/c'.$row->classid.'.png"><a href="{path}Vanilla/Character/'.$this->sname.'/'.$row->name.'/0" class="color-'.$this->classById[$row->classid].'">'.$row->name.'</a></td>
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
								<a href="{path}Vanilla/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}Vanilla/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
							</div>
							<div class="pright">
								<div class="pseudoButton">Page '.$this->page.'</div><a href="{path}Vanilla/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/'.($this->page+1).'"><button class="icon-button icon-arrowright"></button></a>
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
					window.location.replace(\'{path}Vanilla/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/\'+$(\'#sdung\').multipleSelect(\'getSelects\')+\'/'.$this->page.'\');
				},
				allSelected: \'Any raid\'
			});
			$(\'#sclass\').multipleSelect({
				onClose: function() {
					window.location.replace(\'{path}Vanilla/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/\'+$(\'#sclass\').multipleSelect(\'getSelects\')+\'/'.$this->typee.'/'.$this->instance.'/'.$this->page.'\');
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
			$this->classe = "1,2,3,4,5,6,7,8,9";
		$this->instance = $this->antiSQLInjection($instance);
		if (!$this->instance)
			$this->instance = "1,2,3,4,5,6,7";
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