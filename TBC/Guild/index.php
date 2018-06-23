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
		14 => "Hellfire Peninsula",
		15 => "Shadowmoon Valley",
		16 => "Black Temple",
		17 => "Serpentshrine Cavern",
		18 => "Karazhan",
		19 => "Gruul's Lair",
		20 => "Magtheridon's Lair",
		21 => "Zul'Aman",
		22 => "The Eye",
		23 => "Hyjal Summit",
		24 => "Sunwell Plateau",
	);
	private $sRaidsById = array(
		14 => "WB",
		15 => "WB",
		16 => "BT",
		17 => "SSC",
		18 => "KARA",
		19 => "GRUUL",
		20 => "MAG",
		21 => "ZA",
		22 => "TK",
		23 => "HYJAL",
		24 => "SWP",
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
	private $raidBosses = array( // update npc db to match those ids
		2 => array( //0
			18728 => true,
			17711 => true,
			17257 => true,
		),
		15 => array( //1
			17711 => true,
		),
		16 => array( //2
			22887 => true,
			22898 => true,
			22841 => true,
			22871 => true,
			22948 => true,
			50002 => true, // Group Boss
			22947 => true,
			23426 => true, // This is the group health pool // GROUP BOSS
			22917 => true,
		),
		17 => array( //11
			21216 => true,
			21217 => true,
			21215 => true,
			21214 => true,
			21213 => true,
			21212 => true,
		),
		18 => array( //17
			15550 => true,
			15687 => true,
			50001 => true,
			16457 => true,
			15691 => true,
			15688 => true,
			16524 => true,
			15689 => true,
			15690 => true,
			17225 => true,
		),
		19 => array( //27
			18831 => true, // Group Boss tho
			19044 => true,
		),
		20 => array( //29
			17257 => true,
		),
		21 => array( //30
			23576 => true,
			23578 => true,
			23574 => true,
			23577 => true,
			24239 => true, // Group Boss?
			23863 => true,
		),
		22 => array( //35
			19514 => true,
			19516 => true,
			18805 => true,
			19622 => true,
		),
		23 => array( //39
			17767 => true,
			17808 => true,
			17888 => true,
			17842 => true,
			17968 => true,
		),
		24 => array( //44
			24850 => true, // despawns => true, you dont rly kill him
			24882 => true,
			25038 => true,
			50000 => true,
			25741 => true,
			25608 => true, // Not sure here! Confirmation!
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
		9 => "shaman"
	);
	public $bossPos = Array(18728 => 1, 17711 => 2, 22887 => 3, 22898 => 4, 22841 => 5, 22871 => 6, 22948 => 7, 50002 => 8, 22947 => 9, 23426 => 10, 22917 => 11, 21216 => 12, 21217 => 13, 21215 => 14, 21214 => 15, 21213 => 16, 21212 => 17, 15550 => 18, 15687 => 19, 50001 => 20, 16457 => 21, 15691 => 22, 15688 => 23, 16524 => 24, 15689 => 25, 15690 => 26, 17225 => 27, 18831 => 28, 19044 => 29, 17257 => 30, 23576 => 31, 23578 => 32, 23574 => 33, 23577 => 34, 23863 => 35, 19514 => 36, 19516 => 37, 18805 => 38, 19622 => 39, 17767 => 40, 17808 => 41, 17888 => 42, 17842 => 43, 17968 => 44, 24850 => 45, 24882 => 46, 25038 => 47, 50000 => 48, 25741 => 49, 25608 => 50, 24239 => 51); 
	private $instanceLink = Array(
		2 => "0110000000000000000000000000001",
		14 => "01",
		15 => "001",
		16 => "000111111111",
		17 => "000000000000111111",
		18 => "0000000000000000001111111111",
		19 => "000000000000000000000000000011",
		20 => "0000000000000000000000000000001",
		21 => "000000000000000000000000000000011111",
		22 => "0000000000000000000000000000000000001111",
		23 => "000000000000000000000000000000000000000011111",
		24 => "000000000000000000000000000000000000000000000111111"
	);
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
		$q = $this->db->query('SELECT a.id, b.id as sid, a.faction FROM guilds a LEFT JOIN servernames b ON a.serverid = b.id WHERE b.name = "'.$this->sname.'" AND a.name = "'.$this->name.'" AND expansion = 1')->fetch();
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
		foreach($this->db->query('SELECT a.npcid FROM `tbc-raids-attempts` a LEFT JOIN `tbc-raids` b ON a.rid = b.id WHERE b.guildid = "'.$this->gid.'" GROUP BY a.npcid') as $row){
			unset($this->raidBosses[2][$row->npcid], $this->raidBosses[16][$row->npcid], $this->raidBosses[17][$row->npcid], $this->raidBosses[18][$row->npcid], $this->raidBosses[19][$row->npcid], $this->raidBosses[20][$row->npcid], $this->raidBosses[21][$row->npcid], $this->raidBosses[22][$row->npcid], $this->raidBosses[23][$row->npcid], $this->raidBosses[24][$row->npcid]);
		}
		$t[2] = 3-sizeOf($this->raidBosses[2]);
		$t[18] = 10-sizeOf($this->raidBosses[18]);
		$t[19] = 2-sizeOf($this->raidBosses[19]);
		$t[17] = 6-sizeOf($this->raidBosses[17]);
		$t[22] = 4-sizeOf($this->raidBosses[22]);
		$t[21] = 6-sizeOf($this->raidBosses[21]);
		$t[16] = 9-sizeOf($this->raidBosses[16]);
		$t[23] = 5-sizeOf($this->raidBosses[23]);
		$t[24] = 6-sizeOf($this->raidBosses[24]);
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
		foreach($this->db->query('SELECT nameid, tsend FROM `tbc-raids` WHERE guildid = "'.$this->gid.'" AND tsend BETWEEN '.(time()-1420000).' AND '.time()) as $row){
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
					<img src="{path}TBC/Guild/img/'.$this->faction.'.png"> &lt;'.$this->name.'&gt;
				</div>
				<a href=""><div class="pseudoButton">Achievements</div></a>
				<select id="sdung" multiple="multiple">
					<option value="14"'.($r = (strpos($this->instance, '14') !== FALSE or !$this->instance) ? " selected" : "").'>Hellfire Peninsula</option>
					<option value="15"'.($r = (strpos($this->instance, '15') !== FALSE or !$this->instance) ? " selected" : "").'>Shadowmoon Valley</option>
					<option value="16"'.($r = (strpos($this->instance, '16') !== FALSE or !$this->instance) ? " selected" : "").'>Black Temple</option>
					<option value="17"'.($r = (strpos($this->instance, '17') !== FALSE or !$this->instance) ? " selected" : "").'>Serpentshrine Cavern</option>
					<option value="18"'.($r = (strpos($this->instance, '18') !== FALSE or !$this->instance) ? " selected" : "").'>Karazhan</option>
					<option value="19"'.($r = (strpos($this->instance, '19') !== FALSE or !$this->instance) ? " selected" : "").'>Gruul\'s Lair</option>
					<option value="20"'.($r = (strpos($this->instance, '20') !== FALSE or !$this->instance) ? " selected" : "").'>Magtheridon\'s Lair</option>
					<option value="21"'.($r = (strpos($this->instance, '21') !== FALSE or !$this->instance) ? " selected" : "").'>Zul\'Aman</option>
					<option value="22"'.($r = (strpos($this->instance, '22') !== FALSE or !$this->instance) ? " selected" : "").'>The Eye</option>
					<option value="23"'.($r = (strpos($this->instance, '23') !== FALSE or !$this->instance) ? " selected" : "").'>Hyjal Summit</option>
					<option value="24"'.($r = (strpos($this->instance, '24') !== FALSE or !$this->instance) ? " selected" : "").'>Sunwell Plateau</option>
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
				<select onchange="window.location.replace(\'{path}TBC/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/\'+this.value+\'/'.$this->instance.'/'.$this->page.'\')">
					<option value="0"'.($r = ($this->typee==0) ? " selected" : "").'>Any type</option>
					<option value="-1"'.($r = ($this->typee==-1) ? " selected" : "").'>DPS</option>
					<option value="1"'.($r = ($this->typee==1) ? " selected" : "").'>HPS</option>
				</select>
				<select id="mode" onchange="window.location.replace(\'{path}TBC/Guild/'.$this->sname.'/'.$this->name.'/\'+this.value+\'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/'.$this->page.'\')">
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
								<td class="name pve '.$this->getProgressColor($pg[2], 3).'"><img src="{path}TBC/Guild/img/20.png" />Single Bosses</td>
								<td class="datee '.$this->getProgressColor($pg[2], 3).'">'.$pg[2].'/3</td>
								<td class="tooltip len3">
									<div><img src="{path}TBC/Guild/img/20.png" /></div>
									<h1>Single Bosses</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[2][18728])) ? ' class="clear"' : ' class="none"').'>Doom Lord Kazzak</li>
										<li'.($r = (!isset($this->raidBosses[2][17711])) ? ' class="clear"' : ' class="none"').'>Doomwalker</li>
										<li'.($r = (!isset($this->raidBosses[2][17257])) ? ' class="clear"' : ' class="none"').'>Magtheridon</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[18], 10).'"><img src="{path}TBC/Guild/img/18.png" />Karazhan</td>
								<td class="datee '.$this->getProgressColor($pg[18], 10).'">'.$pg[18].'/10</td>
								<td class="tooltip len10">
									<div><img src="{path}TBC/Guild/img/18.png" /></div>
									<h1>Karazhan</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[18][15550])) ? ' class="clear"' : ' class="none"').'>Attumen</li>
										<li'.($r = (!isset($this->raidBosses[18][15687])) ? ' class="clear"' : ' class="none"').'>Moroes</li>
										<li'.($r = (!isset($this->raidBosses[18][50001])) ? ' class="clear"' : ' class="none"').'>Opera event</li>
										<li'.($r = (!isset($this->raidBosses[18][16457])) ? ' class="clear"' : ' class="none"').'>Maiden of Virtue</li>
										<li'.($r = (!isset($this->raidBosses[18][15691])) ? ' class="clear"' : ' class="none"').'>The Curator</li>
										<li'.($r = (!isset($this->raidBosses[18][15688])) ? ' class="clear"' : ' class="none"').'>Terestian Illhoof</li>
										<li'.($r = (!isset($this->raidBosses[18][16524])) ? ' class="clear"' : ' class="none"').'>Shade of Aran</li>
										<li'.($r = (!isset($this->raidBosses[18][15689])) ? ' class="clear"' : ' class="none"').'>Netherspite</li>
										<li'.($r = (!isset($this->raidBosses[18][15690])) ? ' class="clear"' : ' class="none"').'>Prince Malchezaar</li>
										<li'.($r = (!isset($this->raidBosses[18][17225])) ? ' class="clear"' : ' class="none"').'>Nightbane</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[19], 2).'"><img src="{path}TBC/Guild/img/19.png" />Gruul\'s Lair</td>
								<td class="datee '.$this->getProgressColor($pg[19], 2).'">'.$pg[19].'/2</td>
								<td class="tooltip len2">
									<div><img src="{path}TBC/Guild/img/19.png" /></div>
									<h1>Gruul\'s Lair</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[19][18831])) ? ' class="clear"' : ' class="none"').'>High King Maulgar</li>
										<li'.($r = (!isset($this->raidBosses[19][19044])) ? ' class="clear"' : ' class="none"').'>Gruul the Dragonkiller</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[17], 6).'"><img src="{path}TBC/Guild/img/17.png" />Serpentshrine Cavern</td>
								<td class="datee '.$this->getProgressColor($pg[17], 6).'">'.$pg[17].'/6</td>
								<td class="tooltip len6">
									<div><img src="{path}TBC/Guild/img/17.png" /></div>
									<h1>Serpentshrine</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[17][21216])) ? ' class="clear"' : ' class="none"').'>Hydross the Unstable</li>
										<li'.($r = (!isset($this->raidBosses[17][21217])) ? ' class="clear"' : ' class="none"').'>The Lurker Below</li>
										<li'.($r = (!isset($this->raidBosses[17][21215])) ? ' class="clear"' : ' class="none"').'>Leotheras the Blind</li>
										<li'.($r = (!isset($this->raidBosses[17][21214])) ? ' class="clear"' : ' class="none"').'>Karathress</li>
										<li'.($r = (!isset($this->raidBosses[17][21213])) ? ' class="clear"' : ' class="none"').'>Morogrim Tidewalker</li>
										<li'.($r = (!isset($this->raidBosses[17][21212])) ? ' class="clear"' : ' class="none"').'>Lady Vashj</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[22], 4).'"><img src="{path}TBC/Guild/img/22.png" />The Eye</td>
								<td class="datee '.$this->getProgressColor($pg[22], 4).'">'.$pg[22].'/4</td>
								<td class="tooltip len4">
									<div><img src="{path}TBC/Guild/img/22.png" /></div>
									<h1>The Eye</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[22][19514])) ? ' class="clear"' : ' class="none"').'>Al\'ar</li>
										<li'.($r = (!isset($this->raidBosses[22][19516])) ? ' class="clear"' : ' class="none"').'>Void Reaver</li>
										<li'.($r = (!isset($this->raidBosses[22][18805])) ? ' class="clear"' : ' class="none"').'>High Astromancer Solarian</li>
										<li'.($r = (!isset($this->raidBosses[22][19622])) ? ' class="clear"' : ' class="none"').'>Kael\'thas Sunstrider</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[21], 5).'"><img src="{path}TBC/Guild/img/21.png" />Zul\'Aman</td>
								<td class="datee '.$this->getProgressColor($pg[21], 5).'">'.$pg[21].'/5</td>
								<td class="tooltip len5">
									<div><img src="{path}TBC/Guild/img/21.png" /></div>
									<h1>Zul\'Aman</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[21][23576])) ? ' class="clear"' : ' class="none"').'>Nalorakk</li>
										<li'.($r = (!isset($this->raidBosses[21][23578])) ? ' class="clear"' : ' class="none"').'>Jan\'alai</li>
										<li'.($r = (!isset($this->raidBosses[21][23574])) ? ' class="clear"' : ' class="none"').'>Akil\'zon</li>
										<li'.($r = (!isset($this->raidBosses[21][23577])) ? ' class="clear"' : ' class="none"').'>Halazzi</li>
										<li'.($r = (!isset($this->raidBosses[21][24239])) ? ' class="clear"' : ' class="none"').'>Malacrass</li>
										<li'.($r = (!isset($this->raidBosses[21][23863])) ? ' class="clear"' : ' class="none"').'>Zul\'jin</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[16], 9).'"><img src="{path}TBC/Guild/img/16.png" />Black Temple</td>
								<td class="datee '.$this->getProgressColor($pg[16], 9).'">'.$pg[16].'/9</td>
								<td class="tooltip len9">
									<div><img src="{path}TBC/Guild/img/16.png" /></div>
									<h1>Black Temple</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[16][22887])) ? ' class="clear"' : ' class="none"').'>Naj\'entus</li>
										<li'.($r = (!isset($this->raidBosses[16][22898])) ? ' class="clear"' : ' class="none"').'>Supremus</li>
										<li'.($r = (!isset($this->raidBosses[16][22841])) ? ' class="clear"' : ' class="none"').'>Shade of Akama</li>
										<li'.($r = (!isset($this->raidBosses[16][22871])) ? ' class="clear"' : ' class="none"').'>Teron Gorefiend</li>
										<li'.($r = (!isset($this->raidBosses[16][22948])) ? ' class="clear"' : ' class="none"').'>Gurtogg Bloodboil</li>
										<li'.($r = (!isset($this->raidBosses[16][50002])) ? ' class="clear"' : ' class="none"').'>Reliquary of Souls</li>
										<li'.($r = (!isset($this->raidBosses[16][22947])) ? ' class="clear"' : ' class="none"').'>Mother Shahraz</li>
										<li'.($r = (!isset($this->raidBosses[16][23426])) ? ' class="clear"' : ' class="none"').'>The Illidari Council</li>
										<li'.($r = (!isset($this->raidBosses[16][22917])) ? ' class="clear"' : ' class="none"').'>Illidan Stormrage</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[23], 5).'"><img src="{path}TBC/Guild/img/23.png" />Hyjal Summit</td>
								<td class="datee '.$this->getProgressColor($pg[23], 5).'">'.$pg[23].'/5</td>
								<td class="tooltip len5">
									<div><img src="{path}TBC/Guild/img/23.png" /></div>
									<h1>Hyjal Summit</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[23][17767])) ? ' class="clear"' : ' class="none"').'>Rage Winterchill</li>
										<li'.($r = (!isset($this->raidBosses[23][17808])) ? ' class="clear"' : ' class="none"').'>Anetheron</li>
										<li'.($r = (!isset($this->raidBosses[23][17888])) ? ' class="clear"' : ' class="none"').'>Kaz\'rogal</li>
										<li'.($r = (!isset($this->raidBosses[23][17842])) ? ' class="clear"' : ' class="none"').'>Azgalor</li>
										<li'.($r = (!isset($this->raidBosses[23][17968])) ? ' class="clear"' : ' class="none"').'>Archimonde</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="name pve '.$this->getProgressColor($pg[24], 6).'"><img src="{path}TBC/Guild/img/24.png" />Sunwell Plateau</td>
								<td class="datee '.$this->getProgressColor($pg[24], 6).'">'.$pg[24].'/6</td>
								<td class="tooltip len6">
									<div><img src="{path}TBC/Guild/img/24.png" /></div>
									<h1>Sunwell Plateau</h1>
									<ul>
										<li'.($r = (!isset($this->raidBosses[24][24850])) ? ' class="clear"' : ' class="none"').'>Kalecgos</li>
										<li'.($r = (!isset($this->raidBosses[24][24882])) ? ' class="clear"' : ' class="none"').'>Brutallus</li>
										<li'.($r = (!isset($this->raidBosses[24][25038])) ? ' class="clear"' : ' class="none"').'>Felmyst</li>
										<li'.($r = (!isset($this->raidBosses[24][50000])) ? ' class="clear"' : ' class="none"').'>Eredar Twins</li>
										<li'.($r = (!isset($this->raidBosses[24][25741])) ? ' class="clear"' : ' class="none"').'>M\'uru</li>
										<li'.($r = (!isset($this->raidBosses[24][25608])) ? ' class="clear"' : ' class="none"').'>Kil\'Jaeden</li>
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
								<th class="fulllist"><a href="{path}TBC/Guild/Raids/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
			';
		foreach ($this->db->query('SELECT id, tsstart, nameid FROM `tbc-raids` WHERE guildid = "'.$this->gid.'" AND rdy = 1 AND nameid IN ('.$this->instance.') ORDER BY id DESC LIMIT 10;') as $row){
			$content .= '
							<tr>
								<td class="name pve"><img src="{path}TBC/Guild/img/'.$row->nameid.'.png" /><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->instanceLink[$row->nameid].'">'.$this->raidsById[$row->nameid].'</a></td>
								<td class="date"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$row->id.'">'.date("d.m.y H:i", $row->tsstart).'</a></td>
							</tr>
			';
		}
		$content .= '
						</table>
						<table cellspacing="0" style="margin-top: 12px;">
							<tr>
								<th>Recent kills</th>
								<th class="fulllist"><a href="{path}TBC/Guild/Kills/'.$this->sname.'/'.$this->name.'">Full list</a></th>
							</tr>
		';
		foreach ($this->db->query('SELECT c.name as boss, a.id, a.time, b.id as rid, a.npcid, b.nameid FROM `tbc-raids-attempts` a LEFT JOIN `tbc-raids` b ON a.rid = b.id LEFT JOIN tbc_npcs c ON a.npcid = c.id WHERE c.type = 1 AND b.guildid = "'.$this->gid.'" AND b.rdy = 1 AND a.type = 1 AND b.nameid IN ('.$this->instance.') ORDER BY a.time DESC LIMIT 10') as $row){
			$content .= '
							<tr>
								<td class="name pve"><img src="{path}TBC/Guild/img/'.$row->nameid.'.png" /><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type=-1&mode=0&id='.$this->getRankingsLink($row->npcid).'">'.$row->boss.'</a></td>
								<td class="date"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$row->rid.'&attempts='.$row->id.'">'.date("d.m.y H:i", $row->time).'</a></td>
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
		foreach ($this->db->query('SELECT b.guildid, a.type, b.classid, b.serverid, a.'.$this->prefix[1][$this->mode].'val as val, b.name, b.id as charid, a.id, d.name as npcname, c.time, a.'.$this->prefix[2][$this->mode].'attemptid as attemptid, c.rid, a.bossid, e.nameid FROM `tbc-rankings` a 
			LEFT JOIN chars b ON a.charid = b.id 
			LEFT JOIN `tbc-raids-attempts` c ON a.'.$this->prefix[2][$this->mode].'attemptid = c.id
			LEFT JOIN tbc_npcs d ON a.bossid = d.id
			LEFT JOIN `tbc-raids` e ON c.rid = e.id
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
								<td class="sstring"><img src="{path}Database/classes/c'.$var[1]->classid.'.png"><a href="{path}TBC/Character/'.$this->sname.'/'.$var[1]->name.'/0" class="color-'.$this->classById[$var[1]->classid].'">'.$var[1]->name.'</a></td>
								<td class="pve"><img src="{path}TBC/Guild/img/'.$var[8].'.png" /><a href="{path}TBC/Rankings/Table/?server=0&faction=0&type='.$var[1]->type.'&mode=0&id='.$this->getRankingsLink($var[1]->bossid).'">'.$var[1]->npcname.'</a></td>
								<td class="sstring"><a href="{path}TBC/Raids/Evaluation/index.php?rid='.$var[1]->rid.'&attempts='.$var[1]->attemptid.'">'.date("d.m.y H:i", $var[1]->time).'</a></td>
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
								<td class="pve"><img src="{path}Database/racegender/Ui-charactercreate-races_'.str_replace(" ", "",strtolower($this->race[$row->race])).'-'.strtolower($this->gender[$row->gender]).'-small.png" /><img src="{path}Database/classes/c'.$row->classid.'.png"><a href="{path}TBC/Character/'.$this->sname.'/'.$row->name.'/0" class="color-'.$this->classById[$row->classid].'">'.$row->name.'</a></td>
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
								<a href="{path}TBC/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}TBC/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/'.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
							</div>
							<div class="pright">
								<div class="pseudoButton">Page '.$this->page.'</div><a href="{path}TBC/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/'.$this->instance.'/'.($this->page+1).'"><button class="icon-button icon-arrowright"></button></a>
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
					window.location.replace(\'{path}TBC/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/'.$this->classe.'/'.$this->typee.'/\'+$(\'#sdung\').multipleSelect(\'getSelects\')+\'/'.$this->page.'\');
				},
				allSelected: \'Any raid\'
			});
			$(\'#sclass\').multipleSelect({
				onClose: function() {
					window.location.replace(\'{path}TBC/Guild/'.$this->sname.'/'.$this->name.'/'.$this->mode.'/\'+$(\'#sclass\').multipleSelect(\'getSelects\')+\'/'.$this->typee.'/'.$this->instance.'/'.$this->page.'\');
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
			$this->instance = "14,15,16,17,18,19,20,21,22,23,24";
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