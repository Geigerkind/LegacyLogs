<?php
//set_time_limit(100000);
//ini_set('memory_limit', '-1');
error_reporting(E_ERROR);

require("Parser.php");

class Process extends LuaParser{
	private $db = null;
	private $spike = 20000;
	
	private $abilities = array();
	private $user = array();
	private $dmg = array();
	private $dmgtaken = array();
	private $edt = array();
	private $edd = array();
	private $dispels = array();
	private $interrupts = array();
	private $deaths = array();
	private $ehealing = array();
	private $thealing = array();
	private $overhealing = array();
	private $thealingtaken = array();
	private $ehealingtaken = array();
	private $absorbs = array();
	private $auras = array();
	private $cbt = array();
	private $atmt = array();
	
	private $instanceDebuffs = array(
		"Rend" => true,
		"Net" => true,
		"Poison" => true,
		"Blizzard" => true,
		"Winter's Chill" => true,
		"Chilled" => true,
		"Frostbolt" => true,
		"Frostbite" => true,
		"Cone of Cold" => true,
		"Frost Nova" => true,
		"Dazed" => true,
		"Volatile Infection" => true,
		"Disarm" => true,
		"Psychic Scream" => true,
		"Corrosive Acid Spit" => true,
		"Poison Mind" => true,
		"Knockdown" => true,
		"Smite" => true,
		"Mind Flay" => true,
		"Withering Heat" => true,
		"Ancient Dread" => true,
		"Ignite Mana" => true,
		"Ground Stomp" => true,
		"Blast Wave" => true,
		"Lucifron's Curse" => true,
		"Hand of Ragnaros" => true,
		"Demoralizing Shout" => true,
		"Incite Flames" => true,
		"Magma Shackles" => true,
		"Sunder Armor" => true,
		"Melt Armor" => true,
		"Rain of Fire" => true,
		"Serrated Bite" => true,
		"Ancient Hysteria" => true,
		"Shazzrah's Curse" => true,
		"Fist of Ragnaros" => true,
		"Magma Spit" => true,
		"Pyroclast Barrage" => true,
		"Gehennas' Curse" => true,
		"Impending Doom" => true,
		"Conflagration" => true,
		"Living Bomb" => true,
		"Mangle" => true,
		"Panic" => true,
		"Immolate" => true,
		"Magma Splash" => true,
		"Weakened Soul" => true,
		"Elemental Fire" => true,
		"Shadow Word: Pain" => true,
		"Soul Burn" => true,
		"Consecration" => true,
		"Judgement of the Crusader" => true,
		"Curse of Agony" => true,
		"Judgement of Wisdom" => true,
		"Hunter's Mark" => true,
		"Siphon Life" => true,
		"Challenging Shout" => true,
		"Vampiric Embrace" => true,
		"Mocking Blow" => true,
		"Scorpid Sting" => true,
		"Deep Wound" => true,
		"Drain Life" => true,
		"Expose Weakness" => true,
		"Serpent Sting" => true,
		"Faerie Fire (Feral)" => true,
		"Rupture" => true,
		"Rake" => true,
		"Taunt" => true,
		"Thunderfury" => true,
		"Rip" => true,
		"Corruption" => true,
		"Moonfire" => true,
		"Judgement of Light" => true,
		"Shadow Vulnerability" => true,
		"Forbearance" => true,
		"Flamestrike" => true,
		"Intercept Stun" => true,
		"Volley" => true,
		"Pyroclasm" => true,
		"Curse of Recklessness" => true,
		"Hellfire" => true,
		"Essence of the Red" => true,
		"Growing Flames" => true,
		"Brood Affliction: Blue" => true,
		"Brood Affliction: Green" => true,
		"Brood Affliction: Red" => true,
		"Brood Affliction: Black" => true,
		"Brood Affliction: Bronze" => true,
		"Brood Power: Green" => true,
		"Brood Power: Red" => true,
		"Brood Power: Blue" => true,
		"War Stomp" => true,
		"Thunderclap" => true,
		"Veil of Shadow" => true,
		"Flame Buffet" => true,
		"Flame Shock" => true,
		"Suppression Aura" => true,
		"Burning Adrenaline" => true,
		"Flame Breath" => true,
		"Bottle of Poison" => true,
		"Shadow of Ebonroc" => true,
		"Tail Lash" => true,
		"Dropped Weapon" => true,
		"Bellowing Roar" => true,
		"greatest Polymorph" => true,
		"Ignite Flesh" => true,
		"Mortal Strike" => true,
		"Corrupted Healing" => true,
		"Inferno Effect" => true,
		"Time Lapse" => true,
		"Frost Trap Aura" => true,
		"Thorium Grenade" => true,
		"Kreeg's Stout Beatdown" => true,
		"Mark of Detonation" => true,
		"Shadow Command" => true,
		"Curse of Tongues" => true,
		"Fear" => true,
		"Siphon Blessing" => true,
		"Recently Bandaged" => true,
		"Blind" => true,
		"Involuntary Transformation" => true,
		"Polymorph: Pig" => true,
		"Stunning Blow" => true,
		"Silence" => true,
		"Touch of Weakness" => true,
		"Shadow Flame" => true,
		"Demoralizing Roar" => true,
		"Pyroblast" => true,
		"Cauterizing Flames" => true,
		"Poisonous Blood" => true,
		"Poison Bolt Volley" => true,
		"Venom Spit" => true,
		"Delusions of Jin'do" => true,
		"Intimidating Roar" => true,
		"Poison Cloud" => true,
		"Hex" => true,
		"Enveloping Webs" => true,
		"Will of Hakkar" => true,
		"Polymorph" => true,
		"Brain Wash" => true,
		"Whirling Trip" => true,
		"Gouge" => true,
		"Threatening Gaze" => true,
		"Corrupted Blood" => true,
		"Cause Insanity" => true,
		"Curse of Weakness" => true,
		"Death Coil" => true,
		"Entangling Roots" => true,
		"Curse of Shadow" => true,
		"Mark of Arlokk" => true,
		"Corrosive Poison" => true,
		"Charge" => true,
		"Scatter Shot" => true,
		"Blood Siphon" => true,
		"Axe Flurry" => true,
		"Fixate" => true,
		"Sonic Burst" => true,
		"Fall down" => true,
		"Curse of Blood" => true,
		"Shrink" => true,
		"Parasitic Serpent" => true,
		"Shield Slam" => true,
		"Fireball" => true,
		"Soul Tap" => true,
		"Pierce Armor" => true,
		"Holy Fire" => true,
		"Slowing Poison" => true,
		"Web Spin" => true,
		"Infected Bite" => true,
		"Tranquilizing Poison" => true,
		"Intoxicating Venom" => true,
		"Concussion Blow" => true,
		"Faerie Fire" => true,
		"Explosive Trap Effect" => true,
		"Mind Control" => true,
		"Ancient Despair" => true,
		"Detect Magic" => true,
		"Curse of the Elements" => true,
		"Sand Trap" => true,
		"Hive'Zara Catalyst" => true,
		"Intimidating Shout" => true,
		"Creeping Plague" => true,
		"Sundering Cleave" => true,
		"Poison Bolt" => true,
		"Curse of Doom" => true,
		"Consume" => true,
		"Shadowburn" => true,
		"Ignite" => true,
		"Deadly Poison V" => true,
		"Dreamless Sleep" => true,
		"Corrosive Acid" => true,
		"Chromatic Mutation" => true,
		"Insect Swarm" => true,
		"Greater Polymorph" => true,
		"Brood Power: Bronze" => true,
		"Sacrifice" => true,
		"Toxic Volley" => true,
		"Mortal Wound" => true,
		"Impale" => true,
		"Noxious Poison" => true,
		"Unbalancing Strike" => true,
		"True Fulfillment" => true,
		"Acid Spit" => true,
		"Debilitating Charge" => true,
		"Plague" => true,
		"Crippling Poison" => true,
		"Entangle" => true,
		"Mind-numbing Poison" => true,
		"Toxic Vapors" => true,
		
		"Frost Burn" => true,
		"Wild Magic" => true,
		"Paralyze" => true,
		"Hammer of Justice" => true,
		"Flame Lash" => true,
		"Blinding Light" => true,
		"Wild Polymorph" => true,
		"Mind Vision" => true,
		"Berserk" => true,
		"Summon Infernals" => true,
		"Spell Vulnerability" => true,
		"Wyvern Sting" => true,
		"Hurricane" => true,
		"Ravage" => true,
		"Greater Dreamless Sleep" => true,
		"Speed Slash" => true,
		"Deafening Screech" => true,
		"Mother's Milk" => true,
		"Acid Splash" => true,
		"Snap Kick" => true,
		"Disease Cloud" => true,
		"Blood Craze" => true,
		"Charge Stun" => true,
		"Swoop" => true,
		"Deadly Poison IV" => true,
		"Unholy Frenzy" => true,
		"Mortal Cleave" => true,
		"Freezing Trap Effect" => true,
		"Garrote" => true,
		"Hamstring" => true,
		"Cheap Shot" => true,
		"Kidney Shot" => true,
		"Shield Bash - Silenced" => true,
		"Improved Concussive Shot" => true,
		"Sleep" => true,
		"Consuming Shadows" => true,
		"Frost Breath" => true,
		"Spell Blasting" => true,
		"Tendon Rip" => true,
		"Soul Siphon" => true,
		"Evil Twin" => true,
		"Counterspell - Silenced" => true,
		"Toxin" => true,
		"Mana Burn" => true,
		"Dust Cloud" => true,
		"Digestive Acid" => true,
		"Sand Blast" => true,
		"Wing Clip" => true,
		"Fire Vulnerability" => true,
		"Fel Energy" => true,
		"Hemorrhage" => true,
		"Harvest Soul" => true,
		"Whirlwind" => true,
		"Mark of Korth'azz" => true,
		"Shadow Mark" => true,
		"Chilling Touch" => true,
		"Stomp" => true,
		"Flesh Rot" => true,
		"Infected Wound" => true,
		"Terrifying Roar" => true,
		"Slime" => true,
		"Shockwave" => true,
		"Itch" => true,
		"Enveloping Winds" => true,
		"Test Sunder Armor" => true,
		"Dismember" => true,
		"Harsh Winds" => true,
		"Daze" => true,
		"Diminish Soul" => true,
		"Attack Order" => true,
		"Lightning Cloud" => true,
		"Devouring Plague" => true,
	);
	private $interruptableSpells = array(
		// BWL
		"Flamestrike" => true,
		"Shadow Bolt" => true,
		"Shadow Bolt Volley" => true,
		"Fireball Volley" => true,
		
		// AQ 40
		"Arcane Explosion" => true,
		"Great Heal" => true, // Bugtrio
		
		// German
		"Flammenstoß" => true,
		"Schattenblitz" => true,
		"Schattenblitzsalve" => true,
		"Feuerballsalve" => true,
		"Arkane Explosion" => true,
		"Große Heilung" => true,
	);
	private $instanceBosses = array(
		"Avalanchion" => true,
		"The Windreaver" => true,
		"Baron Charr" => true,
		"Princess Tempestria" => true,
		//"Grethok the Controller" => true,
		"Patchwerk" => true,
		"Grobbulus" => true,
		"Gluth" => true,
		"Feugen" => true,
		"Stalagg" => true,
		"Thaddius" => true,
		"Anub'Rekhan" => true,
		"Grand Widow Faerlina" => true,
		"Maexxna" => true,
		"Instructor Razuvious" => true,
		//"Deathknight Understudy" => true,
		"Gothik the Harvester" => true,
		//"Highlord Mograine" => true,
		//"Thane Korth'azz" => true,
		//"Lady Blaumeux" => true,
		//"Sir Zeliek" => true,
		"The Four Horsemen" => true,
		"Noth the Plaguebringer" => true,
		"Heigan the Unclean" => true,
		"Loatheb" => true,
		"Sapphiron" => true,
		"Kel'Thuzad" => true,
		"Lord Victor Nefarius" => true,
		"Nefarian" => true,
		"Vaelastrasz the Corrupt" => true,
		"Razorgore the Untamed" => true,
		"Broodlord Lashlayer" => true,
		"Chromaggus" => true,
		"Ebonroc" => true,
		"Firemaw" => true,
		"Flamegor" => true,
		"Majordomo Executus" => true,
		"Ragnaros" => true,
		"Baron Geddon" => true,
		"Golemagg the Incinerator" => true,
		"Garr" => true,
		"Sulfuron Harbinger" => true,
		"Shazzrah" => true,
		"Lucifron" => true,
		"Gehennas" => true,
		"Magmadar" => true,
		"Onyxia" => true,
		"Azuregos" => true,
		"Lord Kazzak" => true,
		"Ysondre" => true,
		"Emeriss" => true,
		"Taerar" => true,
		"Lethon" => true,
		"High Priestess Jeklik" => true,
		"High Priest Venoxis" => true,
		"High Priest Thekal" => true,
		"High Priestess Arlokk" => true,
		"High Priestess Mar'li" => true,
		"Jin'do the Hexxer" => true,
		"Bloodlord Mandokir" => true,
		"Gahz'ranka" => true,
		"Gri'lek" => true,
		"Hazza'rah" => true,
		"Renataki" => true,
		"Wushoolay" => true,
		"Hakkar" => true,
		"Ayamiss the Hunter" => true,
		"Buru the Gorger" => true,
		"General Rajaxx" => true,
		"Lieutenant General Andorov" => true,
		"Moam" => true,
		"Ossirian the Unscarred" => true,
		//"Lord Kri" => true,
		//"Princess Yauj" => true,
		//"Vem" => true,
		"The Bug Family" => true,
		"C'Thun" => true,
		"Fankriss the Unyielding" => true,
		"Princess Huhuran" => true,
		"Ouro" => true,
		"Battleguard Sartura" => true,
		"The Prophet Skeram" => true,
		//"Emperor Vek'lor" => true,
		//"Emperor Vek'nilash" => true,
		"The Twin Emperors" => true,
		"Viscidus" => true,
		"Alzzin the Wildshaper" => true,
		"Ambassador Flamelash" => true,
		"Anger'rel" => true,
		"Archivist Galford" => true,
		"Atal'alarion" => true,
		"Avatar of Hakkar" => true,
		"Bael'Gar" => true,
		"Balnazzar" => true,
		"Baroness Anastari" => true,
		"Baron Rivendare" => true,
		"Cannon Master Willey" => true,
		"Captain Kromcrush" => true,
		"Celebras the Cursed" => true,
		"Crystal Fang" => true,
		"Darkmaster Gandling" => true,
		"Doctor Theolen Krastinov" => true,
		"Doom'rel" => true,
		"Dope'rel" => true,
		"Dreamscythe" => true,
		"Emperor Dagran Thaurissan" => true,
		"Fineous Darkvire" => true,
		"Gasher" => true,
		"General Angerforge" => true,
		"General Drakkisath" => true,
		"Gloom'rel" => true,
		"Golem Lord Argelmach" => true,
		"Goraluk Anvilcrack" => true,
		"Guard Fengus" => true,
		"Guard Mol'dar" => true,
		"Guard Slip'kik" => true,
		"Gyth" => true,
		"Halycon" => true,
		"Hate'rel" => true,
		"Hazzas" => true,
		"Hearthsinger Forresten" => true,
		"High Interrogator Gerstahn" => true,
		"Highlord Omokk" => true,
		"Hukku" => true,
		"Hurley Blackbreath" => true,
		"Hydrospawn" => true,
		"Illyanna Ravenoak" => true,
		"Immol'thar" => true,
		"Instructor Malicia" => true,
		"Jammal'an the Prophet" => true,
		"Jandice Barov" => true,
		"King Gordok" => true,
		"Kirtonos the Herald" => true,
		"Lady Illucia Barov" => true,
		"Landslide" => true,
		"Lethtendris" => true,
		"Lord Alexei Barov" => true,
		"Lord Incendius" => true,
		"Lord Vyletongue" => true,
		"Lorekeeper Polkelt" => true,
		"Loro" => true,
		"Magister Kalendris" => true,
		"Magistrate Barthilas" => true,
		"Magmus" => true,
		"Maleki the Pallid" => true,
		"Marduk Blackpool" => true,
		"Meshlok the Harvester" => true,
		"Mijan" => true,
		"Morphaz" => true,
		"Mother Smolderweb" => true,
		"Nerub'enkan" => true,
		"Noxxion" => true,
		"Ogom the Wretched" => true,
		"Overlord Wyrmthalak" => true,
		"Phalanx" => true,
		"Plugger Spazzring" => true,
		"Postmaster Malown" => true,
		"Princess Moira Bronzebeard" => true,
		"Princess Theradras" => true,
		"Prince Tortheldrin" => true,
		"Pusillin" => true,
		"Pyroguard Emberseer" => true,
		"Ramstein the Gorger" => true,
		"Ras Frostwhisper" => true,
		"Rattlegore" => true,
		"Razorlash" => true,
		"Warchief Rend Blackhand" => true,
		"Ribbly Screwspigot" => true,
		"Rotgrip" => true,
		"Seeth'rel" => true,
		"Shade of Eranikus" => true,
		"Shadow Hunter Vosh'gajin" => true,
		"Solakar Flamewreath" => true,
		"Stomper Kreeg" => true,
		"Tendris Warpwood" => true,
		"The Beast" => true,
		"The Ravenian" => true,
		"Timmy the Cruel" => true,
		"Tinkerer Gizlock" => true,
		"Tsu'zee" => true,
		"Vectus" => true,
		"Vile'rel" => true,
		"War Master Voone" => true,
		"Weaver" => true,
		"Zevrim Thornhoof" => true,
		"Zolo" => true,
		"Zul'Lor" => true,
		
		// From Mendeleev
		"Cho'Rush the Observer" => true,
		"Lord Hel'nurath" => true,
		"Pimgib" => true,
		"Knot Thimblejack's Cache" => true,
		"Cannonmaster Willey" => true,
		"Emperor Dagran Thaurissian" => true,
		"Archmage Arugal" => true,
		"Archmage Arugal's Voidwalker" => true,
		"Baron Silverlaine" => true,
		"Commander Springvale" => true,
		"Deathsworn Captain" => true,
		"Fenrus the Devourer" => true,
		"Odo the Blindwatcher" => true,
		"Razorclaw the Butcher" => true,
		"Wolf Master Nandos" => true,
		"Rend Blackhand" => true,
		"Kurinnaxx" => true,
	);
	private $userById = array();
	private $abilitiesById = array();
	private $participantKeys = array();
	private $attempts = array();
	private $attemptsWithNpcId = array();
	private $attemptsWithDbId = array();
	
	private $participants = array();
	private $dmgDoneBySource = array();
	private $dmgDoneByAbility = array();
	private $dmgDoneToEnemy = array();
	private $dmgDoneToFriendly = array();
	private $individualDmgDoneByAbility = array();
	private $individualDmgDoneToEnemy = array();
	private $dmgTakenBySource = array();
	private $dmgTakenFromSource = array();
	private $dmgTakenFromAbility = array();
	private $individualDmgTakenByAbility = array();
	private $individualDmgTakenBySource = array();
	private $individualDmgTakenByPlayer = array();
	private $healingBySource = array();
	private $healingByAbility = array();
	private $healingToFriendly = array();
	private $individualHealingToFriendly = array();
	private $individualHealingByAbility = array();
	private $buffs = array();
	private $procs = array();
	private $individualBuffs = array();
	private $individualBuffsByPlayer = array();
	private $debuffs = array();
	private $individualDebuffs = array();
	private $individualDebuffsByPlayer = array();
	private $deathsBySource = array();
	private $individualDeath = array();
	private $missedInterrupts = array();
	private $successfullInterruptsSum = array();
	private $missedInterruptsSum = array();
	private $individualInterrupts = array();
	private $dispelsByAbility = array();
	private $dispelsByFriendly = array();
	private $individualDispelsByAbility = array();
	private $individualDispelsByTarget = array();
	private $recordsDamageDone = array();
	
	private $totalDmgDone = array();
	private $totalDmgTaken = array();
	private $totalEHealingDone = array();
	private $totalEHealingTaken = array();
	private $totalTHealingDone = array();
	private $totalTHealingTaken = array();
	private $totalEDTTable = array();
	private $totalEDDTable = array();
	
	/*
	* Sorts those tables by their Id instead of the ability name.
	*/
	private function sortById($p){
		$t = array();
		foreach($p as $key => $val){
			$t[$val[1]] = $val;
			$t[$val[1]][1] = $key;
		}
		return $t;
	}
	
	private function getTotalTables(){
		foreach($this->dmg as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i" and $va["i"]){
					foreach($va["i"] as $k => $v){
						if (!isset($this->totalDmgDone[$key]))
							$this->totalDmgDone[$key] = array();
						if (isset($this->totalDmgDone[$key][$k]))
							$this->totalDmgDone[$key][$k]+= $v;
						else
							$this->totalDmgDone[$key][$k] = $v;
					}
				}
			}
		}
		foreach($this->ehealing as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i" and $va["i"]){
					foreach($va["i"] as $k => $v){
						if (!isset($this->totalEHealingDone[$key]))
							$this->totalEHealingDone[$key] = array();
						if (isset($this->totalEHealingDone[$key][$k]))
							$this->totalEHealingDone[$key][$k]+= $v;
						else
							$this->totalEHealingDone[$key][$k] = $v;
					}
				}
			}
		}
		foreach($this->ehealingtaken as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i"){
					foreach($va as $q => $s){
						if ($s["i"]){
							foreach($s["i"] as $k => $v){
								if (!isset($this->totalEHealingTaken[$key]))
									$this->totalEHealingTaken[$key] = array();
								if (isset($this->totalEHealingTaken[$key][$k]))
									$this->totalEHealingTaken[$key][$k]+= $v;
								else
									$this->totalEHealingTaken[$key][$k] = $v;
							}
						}
					}
				}
			}
		}
		foreach($this->thealing as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i" and $va["i"]){
					foreach($va["i"] as $k => $v){
						if (!isset($this->totalTHealingDone[$key]))
							$this->totalTHealingDone[$key] = array();
						if (isset($this->totalTHealingDone[$key][$k]))
							$this->totalTHealingDone[$key][$k] += $v;
						else
							$this->totalTHealingDone[$key][$k] = $v;
					}
				}
			}
		}
		foreach($this->thealingtaken as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i"){
					foreach($va as $q => $s){
						if ($s["i"]){
							foreach($s["i"] as $k => $v){
								if (!isset($this->totalTHealingTaken[$key]))
									$this->totalTHealingTaken[$key] = array();
								if (isset($this->totalTHealingTaken[$key][$k]))
									$this->totalTHealingTaken[$key][$k] += $v;
								else
									$this->totalTHealingTaken[$key][$k] = $v;
							}
						}
					}
				}
			}
		}
		foreach($this->dmgtaken as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i"){
					foreach($va as $q => $s){
						if ($s["i"]){
							foreach($s["i"] as $k => $v){
								if (!isset($this->totalDmgTaken[$key]))
									$this->totalDmgTaken[$key] = array();
								if (isset($this->totalDmgTaken[$key][$k]))
									$this->totalDmgTaken[$key][$k]+= $v;
								else
									$this->totalDmgTaken[$key][$k] = $v;
							}
						}
					}
				}
			}
		}
		foreach($this->edt as $key => $var){
			if (!isset($this->totalEDTTable[$key]))
				$this->totalEDTTable[$key] = array();
			foreach($var as $ke => $va){
				if (!isset($this->totalEDTTable[$key][$ke]))
					$this->totalEDTTable[$key][$ke] = array();
				foreach($va as $q => $s){
					if ($q != "i" && $s["i"]){
						foreach($s["i"] as $k => $v){
							if (isset($this->totalEDTTable[$key][$ke][$k]))
								$this->totalEDTTable[$key][$ke][$k] += $v;
							else
								$this->totalEDTTable[$key][$ke][$k] = $v;
						}
					}
				}
			}
		}
		foreach($this->edd as $key => $var){
			if (!isset($this->totalEDDTable[$key]))
				$this->totalEDDTable[$key] = array();
			foreach($var as $ke => $va){
				if (!isset($this->totalEDDTable[$key][$ke]))
					$this->totalEDDTable[$key][$ke] = array();
				foreach($va as $q => $s){
					if ($q != "i" && $s["i"]){
						foreach($s["i"] as $k => $v){
							if (isset($this->totalEDDTable[$key][$ke][$k]))
								$this->totalEDDTable[$key][$ke][$k] += $v;
							else
								$this->totalEDDTable[$key][$ke][$k] = $v;
						}
					}
				}
			}
		}
		foreach($this->totalDmgDone as $key => $var){
			ksort($this->totalDmgDone[$key]);
		}
		foreach($this->totalDmgTaken as $key => $var){
			ksort($this->totalDmgTaken[$key]);
		}
		foreach($this->totalEHealingDone as $key => $var){
			ksort($this->totalEHealingDone[$key]);
		}
		foreach($this->totalEHealingTaken as $key => $var){
			ksort($this->totalEHealingTaken[$key]);
		}
		foreach($this->totalTHealingDone as $key => $var){
			ksort($this->totalTHealingDone[$key]);
		}
		foreach($this->totalTHealingTaken as $key => $var){
			ksort($this->totalTHealingTaken[$key]);
		}
		foreach($this->totalEDTTable as $key => $var){
			foreach($var as $ke => $va){
				ksort($this->totalEDTTable[$key][$ke]);
			}
		}
		foreach($this->totalEDDTable as $key => $var){
			foreach($var as $ke => $va){
				ksort($this->totalEDDTable[$key][$ke]);
			}
		}
	}
	
	/*
	* Returns a list of participants that is sorted by role.
	* Example: Array ( [Tanks] => Array ( ) [DPS] => Array ( [0] => 1262 [1] => 1264 ) [Healer] => Array ( [0] => 1335 ) ) 
	* Note: Pets
	*/
	private function findFirstTraceOfCharacter($arr, $time){
		$out = -1;
		foreach($arr as $k => $v){
			if ($k>=$time){
				if ($out==-1 or $out>$k)
					$out = $k;
			}
		}
		return $out;
	}
	
	private function findLastTraceOfCharacter($arr, $time){
		$out = -1;
		foreach($arr as $k => $v){
			if ($k<=$time){
				if ($out<$k)
					$out = $k;
			}
		}
		return $out;
	}
	
	
	private function getParticipants($spellsTra, $npcs){
		$temp = array();
		foreach ($this->atmt as $k => $v){
			if (sizeOf($v)>0){
				if (!isset($temp[$k])){
					$temp[$k] = array();
				}
				foreach($v as $key => $var){
					if (isset($var[4])){
						if (!isset($temp[$k][1]) or $var[4]>=$temp[$k][1]){
							$temp[$k][1] = $var[4];
						}
					}
					if (isset($var[2])){
						if (!isset($temp[$k][2]) or $var[2]<=$temp[$k][2]){
							$temp[$k][2] = $var[2];
						}
					}
				}
			}
		}
		foreach ($temp as $k => $v){
			if ($v[1] && $v[2]){
				foreach ($this->thealing as $key => $var){
					if (!$npcs[$this->userById[$key][1]] && (in_array($this->userById[$key][2], array("paladin", "druid", "priest", "shaman")) or !isset($this->userById[$key][2])) && $var["i"]>1000 && (isset($this->cbt["effective"][1][$this->userById[$key][1]]) && $this->cbt["effective"][1][$this->userById[$key][1]]>5)){
						$isInRaid = false;
						foreach($this->totalTHealingDone[$key] as $pk => $ok){
							if ($v[1]>$pk && $v[2]<$pk){
								$isInRaid = true;
								break 1;
							}
						}
						if ($isInRaid == true){
							if (!isset($this->participants[$k]))
								$this->participants[$k] = array(
									"Tanks" => array(),
									"DPS" => array(),
									"Healer" => array()
								);
							if (in_array($key, $this->participants[$k]["Healer"]) == false && in_array($key, $this->participants[$k]["DPS"]) == false && in_array($key, $this->participants[$k]["Tanks"]) == false)
								array_push($this->participants[$k]["Healer"], $key);
							if (!in_array($key, $this->participantKeys))
								array_push($this->participantKeys, $key);
						}
					}
				}
				foreach ($this->dmg as $key => $var){
					if (($var["i"] >= ($this->findLastTraceOfCharacter($this->totalDmgDone[$key], $v[1])-$this->findFirstTraceOfCharacter($this->totalDmgDone[$key], $v[2]))*20 && !$npcs[$this->userById[$key][1]] && $var["i"]>1000 && (isset($this->cbt["effective"][1][$this->userById[$key][1]]) && $this->cbt["effective"][1][$this->userById[$key][1]]>10)) || (isset($this->userById[$key][4]) && $this->userById[$key][4])){
						$isInRaid = false;
						foreach($this->totalDmgDone[$key] as $pk => $ok){
							if ($v[1]>$pk && $v[2]<$pk){
								$isInRaid = true;
								break 1;
							}
						}
						//print $this->userById[$key][1]."<br/>";
						if ($isInRaid == true){
							//print $this->userById[$key][1]."IN THE RAID<br/>";
							$isTank = false;
							foreach ($var as $pk => $ok){
								if (isset($this->abilitiesById[$pk][1])){
									if ($this->abilitiesById[$pk][1] == $spellsTra["Shield Slam"] or $this->abilitiesById[$pk][1] == "Shield Slam" or $this->abilitiesById[$pk][1] == $spellsTra["Holy Shield"] or $this->abilitiesById[$pk][1] == "Holy Shield"){
										$isTank = true;
										break 1;
									}
								}
							}
							// more conditions to determine a tank
							// using auras that were collected
							if (!$isTank){
								foreach($this->auras[$key] as $qqq => $uuu){
									if (in_array($this->abilitiesById[$qqq][1], array($spellsTra["Frenzied Regeneration"], "Frenzied Regeneration", $spellsTra["Holy Shield"], "Holy Shield", $spellsTra["Last Stand"], "Last Stand"))){
										$isTank = true;
										break 1;
									}
								}
							}
							
							if (!isset($this->participants[$k]))
								$this->participants[$k] = array(
									"Tanks" => array(),
									"DPS" => array(),
									"Healer" => array()
								);
							if ($isTank == true){
								if (in_array($key, $this->participants[$k]["Healer"]) == false && in_array($key, $this->participants[$k]["DPS"]) == false && in_array($key, $this->participants[$k]["Tanks"]) == false)
									array_push($this->participants[$k]["Tanks"], $key);
							}else{
								if (in_array($key, $this->participants[$k]["Healer"]) == false && in_array($key, $this->participants[$k]["DPS"]) == false && in_array($key, $this->participants[$k]["Tanks"]) == false)
									array_push($this->participants[$k]["DPS"], $key);
							}
							if (!in_array($key, $this->participantKeys))
								array_push($this->participantKeys, $key);
							//print $this->userById[$key][1];
						}
					}
				}
			}
		}
	}
	
	private function addValues(&$arr, $val){
		foreach($val as $key => $var){
			if (isset($var)){
				if (isset($arr[$key])){
					$arr[$key] += $var;
				}else{
					$arr[$key] = $var;
				}
			}
		}
	}
	
	/*
	* dmgDoneBySource[attemptid][charid] = Array(1 => value, 2 => active);
	* dmgDoneByAbility[attemptid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 => resist); //potential block
	* dmgDoneToEnemy[attemptid][npcid] = Array(1 => amount, 2 => active);
	* To test => dmgDoneToFriendly[attemptid][charid(the victim)] = amount;
	* To test => individualDmgDoneByAbility[attemptid][charid][abilityid] = Array(1 => casts, 2 => hits, 3 => amount, 4 => average, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 => resist);
	* To test => individualDmgDoneToEnemy[attemptid][npcid][charid] = Array(1 => amount, 2 => active);
	*/
	private $linkedBoss = array(
		// Molten Core
		"Lucifron" => array(
			"Lucifron",
			"Flamewaker Protector"
		),
		"Gehennas" => array(
			"Gehennas",
			"Flamewaker"
		),
		"Garr" => array(
			"Garr",
			"Firesworn"
		),
		"Sulfuron Harbinger" => array(
			"Sulfuron Harbinger",
			"Flamewaker Priest"
		),
		"Golemagg the Incinerator" => array(
			"Golemagg the Incinerator",
			//"Core Rager"
		),
		"Majordomo Executus" => array(
			"Majordomo Executus",
			"Flamewaker Healer",
			"Flamewaker Elite",
		),
		"Ragnaros" => array(
			"Ragnaros",
			"Son of Flame"
		),
		// Blackwing Lair
		"Razorgore the Untamed" => array(
			"Razorgore the Untamed",
			"Blackwing Legionnaire",
			"Blackwing Mage",
			"Death Talon Dragonspawn"
		),
		"Broodlord Lashlayer" => array(
			"Broodlord Lashlayer",
			"Corrupted Red Whelp",
			"Corrupted Blue Whelp",
			"Corrupted Bronze Whelp",
			"Corrupted Green Whelp",
		),
		"Nefarian" => array(
			"Nefarian",
			"Corrupted Infernal",
			"Corrupted Fire Nova Totem V",
			"Corrupted Windfury Totem III",
			"Corrupted Healing Stream Totem V",
			"Corrupted Stoneskin Totem VI",
			"Chromatic Drakonid",
			"Blue Drakonid",
			"Black Drakonid",
			"Bronze Drakonid",
			"Green Drakonid",
			"Red Drakonid",
			"Bone Construct"
		),
		// Onyxia
		"Onyxia" => array(
			"Onyxia",
			"Onyxian Whelp"
		),
		// ZG
		"High Priestess Jeklik" => array(
			"High Priestess Jeklik",
			"Frenzied Bloodseeker Bat"
		),
		"High Priest Venoxis" => array(
			"High Priest Venoxis",
			"Razzashi Cobra"
		),
		"High Priestess Mar'li" => array(
			"High Priestess Mar'li",
			"Spawn of Mar'li",
			"Witherbark Speaker"
		),
		"Bloodlord Mandokir" => array(
			"Bloodlord Mandokir",
			"Vilebranch Speaker",
			"Ohgan"
		),
		"Hazza'rah" => array(
			"Hazza'rah",
			"NIghtmare Illusion"
		),
		"High Priest Thekal" => array(
			"High Priest Thekal",
			"Zealot Zath",
			"Zealot Lor'khan",
			"Zulian Guardian"
		),
		"High Priestess Arlokk" => array(
			"High Priestess Arlokk",
			"Zulian Prowler"
		),
		"Jin'do the Hexxer" => array(
			"Jin'do the Hexxer",
			"Brain Wash Totem",
			"Powerful Healing Ward",
			"Shade of Jin'do",
			"Sacrificed Troll"
		),
		"Hakkar" => array(
			"Hakkar",
			"Son of Hakkar"
		),
		// AQ 20
		"Moam" => array(
			"Moam",
			"Mana Fiend"
		),
		"Buru the Gorger" => array(
			"Buru the Gorger",
			"Hive'Zara Hatchling",
			"Buru Egg"
		),
		"Ayamiss the Hunter" => array(
			"Ayamiss the Hunter",
			"Hive'Zara Larva",
			"Hive'Zara Swarmer",
			"Hive'Zara Wasp"
		),
		"Ossirian the Unscarred" => array(
			"Ossirian the Unscarred",
			"Ossirian Crystal Trigger",
			"Sand Vortex"
		),
		// AQ 40
		"The Bug Family" => array(
			"Lord Kri",
			"Princess Yauj",
			"Vem",
			"Yauj Brood"
		),
		"Battleguard Sartura" => array(
			"Battleguard Sartura",
			"Satura's Royal Guard"
		),
		"Fankriss the Unyielding" => array(
			"Fankriss the Unyielding",
			"Vekniss Drone",
			"Vekniss Hatchling",
			"Spawn of Fankriss"
		),
		"Viscidus" => array(
			"Viscidus",
			"Glob of Viscidus"
		),
		"The Twin Emperors" => array(
			"Emperor Vek'lor",
			"Emperor Vek'nilash",
			"Qiraji Scarab",
			"Qiraji Scorpion"
		),
		"Ouro" => array(
			"Ouro",
			"Ouro Scarab",
			"Dirt Mound"
		),
		"C'Thun" => array(
			"Eye of C'Thun",
			"Eye Tentacle",
			"C'Thun",
			"Flesh Tentacle",
			"Giant Claw Tentacle",
			"Giant Eye Tentacle"
		),
		// Naxx
		"Grobbulus" => array(
			"Grobbulus",
			"Fallout Slime",
			"Grobbulus Cloud"
		),
		"Gluth" => array(
			"Gluth",
			"Zombie Chow"
		),
		"Thaddius" => array(
			"Thaddius",
			"Stalagg",
			"Feugen"
		),
		"Anub'Rekhan" => array(
			"Anub'Rekhan",
			"Crypt Guard"
		),
		"Grand Widow Faerlina" => array(
			"Grand Widow Faerlina",
			"Naxxramas Follower"
		),
		"Maexxna" => array(
			"Maexxna",
			"Web Wrap",
			"Maexxna Spiderling"
		),
		"Instructor Razuvious" => array(
			"Instructor Razuvious",
			"Deathknight Understudy"
		),
		"Gothik the Harvester" => array(
			"Gothik the Harvester",
			"Unrelenting Trainee",
			"Unrelenting Deathknight",
			"Unrelenting Rider",
			"Spectral Trainee",
			"Spectral Deathknight",
			"Spectral Rider",
			"Spectral Horse"
		),
		"The Four Horsemen" => array(
			"Highlord Mograine",
			"Thane Korth'azz",
			"Sir Zeliek",
			"Lady Blaumeux"
		),
		"Noth the Plaguebringer" => array(
			"Noth the Plaguebringer",
			"Plagued Warrior",
			"Plagued Champion",
			"Plagued Guardian",
			"Plagued Construct"
		),
		"Loatheb" => array(
			"Loatheb",
			"Spore"
		),
		"Kel'Thuzad" => array(
			"Kel'Thuzad",
			//"Soldier of the Frozen Wastes",
			//"Unstoppable Abomination",
			"Soul Weaver",
			"Guardian of Icecrown"
		)
	);
	
	private function returnLinkedBoss($name, $npcRevTra){
		if (isset($this->linkedBoss[$name]))
			return $this->linkedBoss[$name];
		if (isset($this->linkedBoss[$npcRevTra[$name]]))
			return $this->linkedBoss[$npcRevTra[$name]];
		return array($name);
	}
	/*
	* individualDebuffsByPlayer[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
	* casts[attemptid][charid][tarid][abilityid] = amount
	*/
	
	private function theAlphaGame(&$alpha, &$other){
		if ($alpha>0){
			if (($alpha-$other)<0){
				$other = $alpha;
				$alpha = 0;
			}else{
				$alpha -= $other;
			}
		}else{
			$other = 0;
		}
	}
	
	private function getChancesByCompare($hits, $casts, $miss, $parry, $dodge, $resist){
		$alpha = round($casts)-round($hits);
		$this->theAlphaGame($alpha, $resist);
		$this->theAlphaGame($alpha, $miss);
		$this->theAlphaGame($alpha, $dodge);
		$this->theAlphaGame($alpha, $parry);
		if ($alpha>0){
			$p = 0;
			if ($resist>0)
				$p++;
			if ($miss>0)
				$p++;
			if ($parry>0)
				$p++;
			if ($dodge>0)
				$p++;
			if ($resist>0)
				$resist += floor($alpha/$p);
			if ($miss>0)
				$miss += floor($alpha/$p);
			if ($dodge>0)
				$dodge += floor($alpha/$p);
			if ($parry>0)
				$parry += floor($alpha/$p);
		}
		return array(1=>$miss/$casts,2=>$parry/$casts,3=>$dodge/$casts,4=>$resist/$casts);
	}
	
	private $graphdmgdone = array();
	private $graphindividualdmgdone = array();
	private $graphindividualfriendlyfire = array();
	private $casts = array();
	private function getDmgDone($npcRevTra, $npcTra, $spellRevTra, $npcs){
		foreach($this->participantKeys as $val){
			foreach($this->attempts as $pk => $ok){
				$dmg = 0;
				$active = 0;
				foreach(($r = ($this->instanceBosses[$npcTra[$ok[2]]]) ?  array($ok[2]) : $ok[10]) as $nam){
					foreach($this->returnLinkedBoss($nam, $npcRevTra) as $m){
						if (!isset($this->user[$m]) && isset($npcTra[$m]))
							$m = $npcTra[$m];
						if (isset($this->user[$m])){
							if (isset($this->edt[$this->user[$m][1]][$val]) && $this->totalEDTTable[$this->user[$m][1]][$val]){
								$idmg = 0;
								$iactive = 0;
								$last = $ok[3];
								//$leech = array();
								foreach($this->totalEDTTable[$this->user[$m][1]][$val] as $k => $v){
									if ($k>=$ok[3] && $k<=$ok[5] && $v<=$this->spike){
										$idmg += $v;
										if (($k-$last)<=3)
											$iactive += ($k-$last);
										$last = $k;
										//$leech[$k] = $v;
									}
								}
								//$this->addValues($this->graphdmgdone[$pk][$this->user[$m][1]], $leech);
								if ($idmg >0){
									if ($iactive>$active)
										$active = $iactive;
									/*$dmg += $idmg;
									if (!isset($this->dmgDoneToEnemy[$pk][$this->user[$m][1]]))
										$this->dmgDoneToEnemy[$pk][$this->user[$m][1]] = array(
											1 => 0,
											2 => 0
										);
									$this->dmgDoneToEnemy[$pk][$this->user[$m][1]][1] += $idmg;
									if (isset($this->dmgDoneToEnemy[$pk][$this->user[$m][1]][2])){
										$this->dmgDoneToEnemy[$pk][$this->user[$m][1]][2] = ($this->dmgDoneToEnemy[$pk][$this->user[$m][1]][2] + $iactive)/2;
									}else{
										$this->dmgDoneToEnemy[$pk][$this->user[$m][1]][2] = $iactive;
									}*/
									$this->individualDmgDoneToEnemy[$pk][$this->user[$m][1]][$val] = Array(
											1 => $idmg,
											2 => $iactive
										);
								}
							}
						}
					}
				}
				/*if ($dmg > 0){
					$this->dmgDoneBySource[$pk][$val] = Array(
						1 => $dmg,
						2 => $active
					);
				}*/
				foreach(($r = ($this->instanceBosses[$npcTra[$ok[2]]]) ?  array($ok[2]) : $ok[10]) as $nam){
					foreach($this->returnLinkedBoss($nam, $npcRevTra) as $m){
						if (!isset($this->user[$m]) && isset($npcTra[$m]))
							$m = $npcTra[$m];
						if (isset($this->user[$m])){
							if (isset($this->edt[$this->user[$m][1]][$val])){
								foreach($this->edt[$this->user[$m][1]][$val] as $key => $var){
									if (isset($var[13])){
										if ($key != "i" && $var[13] > 0){
											$indAbDmg = 0;
											$leech = array();
											foreach($var["i"] as $qq => $pp){
												if ($qq>=$ok[3] && $qq<=$ok[5] && $pp<=$this->spike){
													$indAbDmg += $pp;
													if (isset($leech[$qq]))
														$leech[$qq] += $pp;
													else
														$leech[$qq] = $pp;
												}
											}
											if ($indAbDmg>0){
												$this->addValues($this->graphindividualdmgdone[$val][$pk][$this->user[$m][1]][$key], $leech);
												if (!isset($this->individualDmgDoneToEnemy[$pk][$this->user[$m][1]][$val][1]))
													$this->individualDmgDoneToEnemy[$pk][$this->user[$m][1]][$val][1] = 0;
												$coeff = $this->individualDmgDoneToEnemy[$pk][$this->user[$m][1]][$val][1]/$this->edt[$this->user[$m][1]][$val]["i"];
												$hits = $var[1]+$var[5]+$var[14]+$var[18];
												$casts = $hits+$var[9]+$var[10]+$var[11]+$var[12];
												$average = round(($var[4]+$var[8]+$var[17]+$var[21])/$hits);
												/*if (!isset($this->dmgDoneByAbility[$pk]))
													$this->dmgDoneByAbility[$pk] = array();
												if (!isset($this->dmgDoneByAbility[$pk][$key]))
													$this->dmgDoneByAbility[$pk][$key] = array(
														1 => 0,
														2 => 0,
														3 => 0,
														4 => 0,
														5 => 0,
														6 => 0,
														7 => 0,
														8 => 0,
														9 => 0
													);
												$this->dmgDoneByAbility[$pk][$key][1] += $indAbDmg;
												$this->dmgDoneByAbility[$pk][$key][2] = ($this->dmgDoneByAbility[$pk][$key][4]*$this->dmgDoneByAbility[$pk][$key][2]+$hits*$average)/($this->dmgDoneByAbility[$pk][$key][4]+$hits);
												$this->dmgDoneByAbility[$pk][$key][3] += $var[22]*$coeff;
												$this->dmgDoneByAbility[$pk][$key][4] += $hits*$coeff;
												$this->dmgDoneByAbility[$pk][$key][5] = ($this->dmgDoneByAbility[$pk][$key][5]+round($var[5]/$casts, 2))/2;
												$this->dmgDoneByAbility[$pk][$key][6] = ($this->dmgDoneByAbility[$pk][$key][6]+round($var[9]/$casts, 2))/2;
												$this->dmgDoneByAbility[$pk][$key][7] = ($this->dmgDoneByAbility[$pk][$key][7]+round($var[10]/$casts, 2))/2;
												$this->dmgDoneByAbility[$pk][$key][8] = ($this->dmgDoneByAbility[$pk][$key][8]+round($var[11]/$casts, 2))/2;
												$this->dmgDoneByAbility[$pk][$key][9] = ($this->dmgDoneByAbility[$pk][$key][9]+round($var[12]/$casts, 2))/2;*/
												
												
												if (!isset($this->individualDmgDoneByAbility[$pk]))
													$this->individualDmgDoneByAbility[$pk] = array();
												if (!isset($this->individualDmgDoneByAbility[$pk][$val]))
													$this->individualDmgDoneByAbility[$pk][$val] = array();
												if (!isset($this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key]))
													$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key] = array(
														1 => 0,
														2 => 0,
														3 => 0,
														4 => 0,
														5 => 0,
														6 => 0,
														7 => 0,
														8 => 0,
														9 => 0
													);
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key][1] += $casts*$coeff;
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key][2] += $hits*$coeff;
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key][3] += $indAbDmg;
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key][4] = $average;
												$ch = $this->getChancesByCompare($this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key][2], $this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key][1], $var[9], $var[10], $var[11], $var[12]);
												//if ($ok[2]=="Golemagg der Verbrenner")
													//print round($this->individualDmgDoneByAbility[$pk][$val][$key][1])."/".round($this->individualDmgDoneByAbility[$pk][$val][$key][2])."/".$ch[1]."/".$ch[2]."/".$ch[3]."/".$ch[4]."<br />";
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key][5] = round($var[5]/$casts, 2);
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key][6] = round($ch[1], 2);
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key][7] = round($ch[2], 2);
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key][8] = round($ch[3], 2);
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][1]][$key][9] = round($ch[4], 2);
											}
											
											if (!isset($this->individualDebuffsByPlayer[$pk][$val][$this->user[$m][1]][$key]))
												$this->individualDebuffsByPlayer[$pk][$val][$this->user[$m][1]][$key] = array(
													1 => 0,
													2 => 0
												);
											if (isset($this->instanceDebuffs[$spellRevTra[$this->abilitiesById[$key][1]]]))
												$this->individualDebuffsByPlayer[$pk][$val][$this->user[$m][1]][$key][1] += $var[22]*$coeff;
											if (!isset($this->casts[$pk][$val][$this->user[$m][1]][$key]))
												$this->casts[$pk][$val][$this->user[$m][1]][$key] = 0;
											if (isset($this->casts[$pk][$val][$this->user[$m][1]][$key]))
												$this->casts[$pk][$val][$this->user[$m][1]][$key] += $var[22]*$coeff;
										}
									}
								}
							}
						}
					}
				}
				if (!isset($npcs[$val])){
					foreach($this->edt[$val] as $k => $v){
						if (in_array($k, $this->participantKeys) && !$npcs[$k]){
							//print $this->userById[$k][1]."<br />";
							$dmg = 0;
							foreach($v as $qq => $ss){
								$leech = array();
								foreach($ss["i"] as $key => $vaal){
									if ($key>=$ok[3] && $key<=$ok[5] && $vaal<=$this->spike){
										$dmg += $vaal;
										if (isset($leech[$key]))
											$leech[$key] += $vaal;
										else
											$leech[$key] = $vaal;
									}
								}
								if (!empty($leech))
									$this->addValues($this->graphindividualfriendlyfire[$val][$pk][$k][$qq], $leech);
							}
							if($dmg > 0){
								if (isset($this->dmgDoneToFriendly[$pk][$k]))
									$this->dmgDoneToFriendly[$pk][$k] += $dmg;
								else
									$this->dmgDoneToFriendly[$pk][$k] = $dmg;
							}
						}
					}
				}
			}	
		}
	}
	
	/*
	* All of them have to be tested
	* Note: DmgTaken is very similiar to dmg done
	*
	* dmgTakenBySource[attemptid][charid] = Array(1 => amount, 2 => active);
	* dmgTakenFromAbility[attemptid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 =>resist, 10 => crush, 11 => block);
	* dmgTakenFromSource[attemptid][npcid/charid] = Array(1 => type(char or npc), 2 => amount, 3 => active);
	* individualDmgTakenByAbility[attemptid][charid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => block, 6 => crit, 7 => miss, 8 => parry, 9 => dodge, 10 => resist, 11 => crush);
	* individualDmgTakenBySource[attemptid][npcid][charid] = Array(1 => amount, 2 => active);
	* individualDmgTakenByPlayer[attemptid][charid][culpritid] = amount;
	*/
	private $graphdmgtaken = array();
	private $graphindividualdmgtaken = array();
	private function getDmgTaken($npcRevTra, $npcTra, $npcs){
		foreach($this->attempts as $pk => $ok){
			foreach($this->participantKeys as $val){
				$dmg = 0;
				$active = 0;
				foreach(($r = ($this->instanceBosses[$npcTra[$ok[2]]]) ?  array($ok[2]) : $ok[10]) as $nam){
					foreach($this->returnLinkedBoss($nam, $npcRevTra) as $m){
						if (!isset($this->user[$m]) && isset($npcTra[$m]))
							$m = $npcTra[$m];
						if (isset($this->user[$m])){
							if (isset($this->edd[$this->user[$m][1]])){
								if (isset($this->edd[$this->user[$m][1]][$val]) && $this->totalEDDTable[$this->user[$m][1]][$val]){
									$idmg = 0;
									$iactive = 0;
									$last = $ok[3];
									$leech = array();
									foreach($this->totalEDDTable[$this->user[$m][1]][$val] as $k => $v){
										if ($k>=$ok[3] && ($k-2)<=$ok[5] && $v<=$this->spike){
											$idmg += $v;
											if (($k-$last)<=5)
												$iactive += ($k-$last);
											$last = $k;
											$leech[$k] = $v;
										}
									}
									$this->addValues($this->graphdmgtaken[$pk][$this->user[$m][1]], $leech);
									if ($iactive>$active)
										$active = $iactive;
									$dmg += $idmg;
									if (!isset($this->dmgTakenFromSource[$pk][$this->user[$m][1]]))
										$this->dmgTakenFromSource[$pk][$this->user[$m][1]] = array(
											1 => 0,
											2 => 0,
											3 => 0
										);
									$this->dmgTakenFromSource[$pk][$this->user[$m][1]][1] = -1;
									$this->dmgTakenFromSource[$pk][$this->user[$m][1]][2] += $idmg;
									$this->dmgTakenFromSource[$pk][$this->user[$m][1]][3] += $iactive;
									$this->individualDmgTakenBySource[$pk][$this->user[$m][1]][$val] = Array(
										1 => $idmg,
										2 => $iactive
									);
								}
							}else{
								//print $m."<br />";
							}
						}else{
							//print $m."<br />";
						}
					}
				}
				$this->dmgTakenBySource[$pk][$val] = Array(
					1 => $dmg,
					2 => $active
				);
				foreach(($r = ($this->instanceBosses[$npcTra[$ok[2]]]) ?  array($ok[2]) : $ok[10]) as $nam){
					foreach($this->returnLinkedBoss($nam, $npcRevTra) as $m){
						if (!isset($this->user[$m]) && isset($npcTra[$m]))
							$m = $npcTra[$m];
						if (isset($this->user[$m])){
							if (isset($this->edd[$this->user[$m][1]])){
								if (isset($this->edd[$this->user[$m][1]][$val])){
									foreach($this->edd[$this->user[$m][1]][$val] as $key => $var){
										if ($key != "i"){
											$indAbDmg = 0;
											$leech = array();
											ksort($var["i"]);
											foreach($var["i"] as $qq => $pp){
												if ($qq>=$ok[3] && $qq<=$ok[5] && $pp<=$this->spike){
													$indAbDmg += $pp;
													if (isset($leech[$qq]))
														$leech[$qq] += $pp;
													else
														$leech[$qq] = $pp;
												}
											}
											if ($indAbDmg>0){
												if (!isset($this->graphindividualdmgtaken[$val][$pk][$key][$this->user[$m][1]]))
													$this->graphindividualdmgtaken[$val][$pk][$key][$this->user[$m][1]] = array();
												$this->addValues($this->graphindividualdmgtaken[$val][$pk][$key][$this->user[$m][1]], $leech);
												if ($this->edd[$this->user[$m][1]][$val]["i"] == 0)
													$coeff = 0;
												else
													$coeff = $this->individualDmgTakenBySource[$pk][$this->user[$m][1]][$val][1]/$this->edd[$this->user[$m][1]][$val]["i"];
												$hits = $var[1]+$var[5]+$var[14]+$var[18];
												$casts = $hits+$var[9]+$var[10]+$var[11]+$var[12];
												if ($hits == 0)
													$average = 0;
												else
													$average = round(($var[4]+$var[8]+$var[17]+$var[21])/$hits);
												if (!isset($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]]))
													$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]] = array(
														1 => 0,
														2 => 0,
														3 => 0,
														4 => 0,
														5 => 0,
														6 => 0,
														7 => 0,
														8 => 0,
														9 => 0,
														10 => 0,
														11 => 0
													);
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][1] += $indAbDmg;
												if ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][4]+$hits == $this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][4]+$hits)
													$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][2] = 0;
												else
													$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][2] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][4]*$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][2]+$hits*$average)/($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][4]+$hits);
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][3] += ceil($var[22]*$coeff);
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][4] += ceil($hits*$coeff);
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][5] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][5]+round($var[5]/$casts, 2))/2;
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][6] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][6]+round($var[9]/$casts, 2))/2;
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][7] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][7]+round($var[10]/$casts, 2))/2;
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][8] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][8]+round($var[11]/$casts, 2))/2;
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][9] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][1]][9]+round($var[12]/$casts, 2))/2;
												
												if (!isset($this->individualDmgTakenByAbility[$pk]))
													$this->individualDmgTakenByAbility[$pk] = array();
												if (!isset($this->individualDmgTakenByAbility[$pk][$val]))
													$this->individualDmgTakenByAbility[$pk][$val] = array();
												if (!isset($this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]]))
													$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]] = array(
														1 => 0,
														2 => 0,
														3 => 0,
														4 => 0,
														5 => 0,
														6 => 0,
														7 => 0,
														8 => 0,
														9 => 0,
														10 => 0,
														11 => 0
													);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]][1] += ceil($casts*$coeff);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]][2] += ceil($hits*$coeff);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]][3] += $indAbDmg;
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]][4] = $average;
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]][5] = round($var[5]/$casts, 2);
												$ch = $this->getChancesByCompare($this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]][2], $this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]][1], $var[9], $var[10], $var[11], $var[12]);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]][6] = round($ch[1], 2);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]][7] = round($ch[2], 2);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]][8] = round($ch[3], 2);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][1]][9] = round($ch[4], 2);
											}
										}
									}
								}
							}
						}
					}
				}
				if (!isset($npcs[$val])){
					foreach($this->edt[$val] as $k => $v){
						if (in_array($k, $this->participantKeys) && !$npcs[$k]){
							$dmg = 0;
							foreach($v as $qq => $ss){
								foreach($ss["i"] as $key => $vaal){
									if ($key>=$ok[3] && $key<=$ok[5] && $vaal<=$this->spike)
										$dmg += $vaal;
								}
							}
							if($dmg > 0){
								if (isset($this->individualDmgTakenByPlayer[$pk][$k][$val]))
									$this->individualDmgTakenByPlayer[$pk][$k][$val] += $dmg;
								else
									$this->individualDmgTakenByPlayer[$pk][$k][$val] = $dmg;
							}
						}
					}
				}
			}
		}
	}
	
	/*
	* All of them have to be tested
	*
	* healingBySource[attemptid][charid] = Array(1 => tamount, 2 => eamount, 3 => absorbed, 4 => active);
	* healingByAbility[attemptid][abilityid] = Array(1 => casts, 2 => tamount, 3 => eamount, 4 => average, 5 => crit);
	* healingToFriendly[attemptid][charid] = Array(1 => tamount, 2 => eamount, 3 => absorbed, 4 => active);
	* individualHealingToFriendly[attemptid][charid][tarid] = Array(1 => tamount, 2 => eamount, 3=> absorbs, 4 => active);
	* individualHealingByAbility[attemptid][charid][abilityid] = Array(1 => tamount, 2 => eamount, 3 => taverage, 4 => eaverage, 5 => hits, 6 => crit);
	*/
	private function getAbsorbedDamage($val, $pk){
		foreach($this->absorbs as $k => $v){
			if ($k == $val){
				$amount = 0;
				if (isset($v["i"])){
					foreach($v["i"] as $var){
						if ($this->attempts[$pk][3]<=$var[1] && $this->attempts[$pk][5]>=$var[1]){
							if (isset($this->edd[$var[4]][$val][$var[3]][13])){
								$amount += $this->edd[$var[4]][$val][$var[3]][13];
							}else{
								$amount += 5;
							}
						}
					}
				}
				return $amount;
			}
		}
		return 0;
	}
	
	private function getAbsorbedDamageTaken($val, $pk, $owner){
		if (isset($this->absorbs[$val][$owner]["i"]))
			foreach($this->absorbs[$val][$owner]["i"] as $k => $var){
				$amount = 0;
				if ($this->attempts[$pk][3]<=$var[1] && $this->attempts[$pk][5]>=$var[1]){
					if (!isset($var[4])){
						if (isset($this->edd[$var[2]][$val][$var[3]][13])){
							$amount += $this->edd[$var[2]][$val][$var[3]][13];
						}else{
							$amount += 5;
						}
					}else{
						$amount += $var[4];
					}
				}
				return $amount;
			}
		return 0;
	}
	
	private $graphhealingdone = array();
	private $graphindividualhealingdone = array();
	private $graphindividualhealingreceived = array();
	private $individualHealingByAbilityTaken = array();
	private $shieldAbsorbs = array(
		"Power Word: Shield" => 1000, // All
		"Ice Barrier" => 818, // All
		"The Burrower's Shell" => 900, // All
		"Aura of Protection" => 1000, // All
		"Damage Absorb" => 550, // All
		"Physical Protection" => 500, // Meele
		"Harm Prevention Belt" => 500, // All
		"Mana Shield" => 570, // Meele
		"Frost Protection" => 2500, // Frost
		"Frost Resistance" => 600, // Frost
		"Frost Ward" => 920, // Frost
		"Fire Protection" => 2500, // Fire
		"Fire Ward" => 920, // Fire
		"Nature Protection" => 2500, // Nature
		"Shadow Protection" => 2500, // Shadow
		"Arcane Protection" => 2500, // Arcane
		"Holy Protection" => 2500, // Holy
	);
	private function getHealing($npcs, $spellRevTra){
		foreach($this->participantKeys as $val){
			foreach($this->attempts as $pk => $ok){
				if (isset($this->ehealing[$val]) && isset($this->thealing[$val])){
					$theal = 0;
					$active = 0;
					$last = $ok[3];
					foreach($this->totalTHealingDone[$val] as $k => $v){
						if ($k>=$ok[3] && $k<=$ok[5] && $v<=$this->spike){
							$theal += $v;
							if (($k-$last)<=5)
								$active += ($k-$last);
							$last = $k;
						}
					}
					$tcoeff = $theal/$this->thealing[$val]["i"];
					$eheal = 0;
					$leech = array();
					foreach($this->totalEHealingDone[$val] as $k => $v){
						if ($k>=$ok[3] && $k<=$ok[5] && $v<=$this->spike){
							$eheal += $v;
							$leech[$k] = $v;
						}
					}
					$this->addValues($this->graphhealingdone[$pk], $leech);
					$ecoeff = $eheal/$this->ehealing[$val]["i"];
					$this->healingBySource[$pk][$val] = Array(
						1 => $theal,
						2 => $eheal,
						3 => $this->getAbsorbedDamage($val, $pk),
						4 => $active
					);
					/*foreach($this->thealing[$val] as $key => $var){
						if ($key != "i"){
							$indAbAmount = 0;
							foreach($var["i"] as $qq => $pp){
								if ($qq>=$ok[3] && $qq<=$ok[5] && $pp<=$this->spike){
									$indAbAmount += $pp;
								}
							}
							if ($indAbAmount>0){
								/*if (!isset($this->healingByAbility[$pk][$key]))
									$this->healingByAbility[$pk][$key] = array(
										1 => 0,
										2 => 0,
										3 => 0
									);
								$this->healingByAbility[$pk][$key][1] += ceil(($var[2]+$var[3])*$tcoeff);
								$this->healingByAbility[$pk][$key][2] += $indAbAmount;
								if (isset($this->healingByAbility[$pk][$key][4]))
									$this->healingByAbility[$pk][$key][4] = ($this->healingByAbility[$pk][$key][4]+$indAbAmount)/2;
								else
									$this->healingByAbility[$pk][$key][4] = $indAbAmount;
								if (isset($this->healingByAbility[$pk][$key][5]))
									$this->healingByAbility[$pk][$key][5] = ($this->healingByAbility[$pk][$key][5]+round($var[3]/($var[2]+$var[3]), 2))/2;
								else
									$this->healingByAbility[$pk][$key][5] = round($var[3]/($var[2]+$var[3]), 2);
								
								if (!isset($this->individualHealingByAbility[$pk][$val][$key]))
									$this->individualHealingByAbility[$pk][$val][$key] = array(
										1 => 0,
										2 => 0,
										3 => 0,
										4 => 0,
										5 => 0,
										6 => 0,
									);
								$this->individualHealingByAbility[$pk][$val][$key][1] = $indAbAmount;
								$this->individualHealingByAbility[$pk][$val][$key][3] = ($var[2]*$var[4]+$var[3]*$var[5])/($var[2]+$var[3]);
								$this->individualHealingByAbility[$pk][$val][$key][5] = ceil(($var[2]+$var[3])*$tcoeff);
								$this->individualHealingByAbility[$pk][$val][$key][6] = round($var[3]/($var[2]+$var[3]), 2);/
							}
						}
					}
					foreach($this->ehealing[$val] as $key => $var){
						if ($key != "i"){
							$indAbAmount = 0;
							$leech = array();
							foreach($var["i"] as $qq => $pp){
								if ($qq>=$ok[3] && $qq<=$ok[5] && $pp<=$this->spike){
									$indAbAmount += $pp;
									if (isset($leech[$qq]))
										$leech[$qq] += $pp;
									else
										$leech[$qq] = $pp;
								}
							}
							if ($indAbAmount>0){
								//$this->addValues($this->graphindividualhealingdone[$val][$pk][$key], $leech);
								//$this->healingByAbility[$pk][$key][3] += $indAbAmount;
								//$this->individualHealingByAbility[$pk][$val][$key][2] = $indAbAmount;
								//$this->individualHealingByAbility[$pk][$val][$key][4] = ($var[2]*$var[4]+$var[3]*$var[5])/($var[2]+$var[3]);
							}
						}
					}*/
				}
				if (isset($this->absorbs[$val])){
					foreach($this->absorbs[$val] as $k => $v){ // owner
						foreach($v["i"] as $key => $var){
							if ($var[1]>=$ok[3] && $var[1]<=$ok[5] && $var[1]<=$this->spike && isset($var[5])){
								$amount = 0;
								if (isset($this->edd[$var[2]][$val][$var[5]][13])){
									$amount += $this->edd[$var[2]][$val][$var[5]][13];
									if ($amount>$this->shieldAbsorbs[$spellRevTra[$this->abilitiesById[$var[5]][1]]])
										$amount = $this->shieldAbsorbs[$spellRevTra[$this->abilitiesById[$var[5]][1]]];
								}else{
									$amount += (1/15)*$this->shieldAbsorbs[$spellRevTra[$this->abilitiesById[$var[5]][1]]]*0.33;
								}
								if (isset($var[4])){
									$amount += $var[4];
								}
								if ($amount>0){
									$this->addValues($this->graphindividualhealingreceived[$val][$pk][$var[5]][$k], array($var[1] => ceil($amount)));
									
									if (!isset($this->individualHealingByAbility[$pk][$k][$val][$var[5]]))
										$this->individualHealingByAbility[$pk][$k][$val][$var[5]] = array(
											1 => 0,
											2 => 0,
											3 => 0,
											4 => 0,
											5 => 0,
											6 => 0,
										);
									$this->individualHealingByAbility[$pk][$k][$val][$var[5]][1]+=$amount;
									$this->individualHealingByAbility[$pk][$k][$val][$var[5]][2]+=$amount;
									$this->individualHealingByAbility[$pk][$k][$val][$var[5]][5]+=1;
									$this->individualHealingByAbility[$pk][$k][$val][$var[5]][6]=0;
									if (!isset($this->individualHealingToFriendly[$pk][$k][$val]))
										$this->individualHealingToFriendly[$pk][$val][$k] = array(
											1 => 0,
											2 => 0,
											3 => 0,
											4 => 0,
											5 => 0,
											6 => 0
										);
									$this->individualHealingToFriendly[$pk][$val][$k][4] += $amount;
								}
							}
						}
					}
				}
				if (isset($this->thealingtaken[$val]) && isset($this->ehealingtaken[$val]) && !isset($npcs[$val])){
					/*if (!isset($this->healingToFriendly[$pk][$val]))
						$this->healingToFriendly[$pk][$val] = Array(
							1 => 0,
							2 => 0,
							3 => 0,
							4 => 0
						);*/
					foreach($this->thealingtaken[$val] as $key => $var){
						if ($key != "i" && !isset($npcs[$key])){
							$tindDmg = 0;
							$active = 0;
							$numAbDone = 0;
							foreach($var as $ke => $va){
								ksort($va["i"]);
								$abTakenNum = 0; $tindAbNum = 0;
								$last = $ok[3];
								foreach($va["i"] as $k => $v){
									if ($k>=$ok[3] && $k<=$ok[5] && $v<=$this->spike){
										$tindDmg += $v;
										$tindAbNum += $v;
										$numAbDone++;
										$abTakenNum++;
										if (($k-$last)<=5)
											$active += ($k-$last);
										$last = $k;
									}
								}
								if ($tindAbNum>0){
									if (!isset($this->individualHealingByAbilityTaken[$pk][$val][$ke]))
										$this->individualHealingByAbilityTaken[$pk][$val][$ke] = Array(
											1 => 0,
											2 => 0
										);
									$this->individualHealingByAbilityTaken[$pk][$val][$ke][1] += $abTakenNum;
									$this->individualHealingByAbilityTaken[$pk][$val][$ke][2] += $tindAbNum;
									
									if (!isset($this->individualHealingByAbility[$pk][$val][$key]))
										$this->individualHealingByAbility[$pk][$val][$key] = array(
											1 => 0,
											2 => 0,
											3 => 0,
											4 => 0,
											5 => 0,
											6 => 0,
										);
									$tcoeff = $tindAbNum/$this->thealingtaken[$val]["i"];
									$this->individualHealingByAbility[$pk][$key][$val][$ke][1] = $tindAbNum;
									$this->individualHealingByAbility[$pk][$key][$val][$ke][3] = ($va[4]+$va[5])/($va[2]+$va[3]);
									$this->individualHealingByAbility[$pk][$key][$val][$ke][5] = ceil(($va[2]+$va[3])*$tcoeff);
									$this->individualHealingByAbility[$pk][$key][$val][$ke][6] = round($va[3]/($va[2]+$va[3]), 2);
									
									if (!isset($this->casts[$pk][$key][$val][$ke]))
										$this->casts[$pk][$key][$val][$ke] = 0;
									if (isset($this->casts[$pk][$key][$val][$ke]))
										$this->casts[$pk][$key][$val][$ke] += ceil(($va[2]+$va[3])*$tcoeff);;
								}
							}
							if ($tindDmg>0){
								if (isset($this->individualHealingToFriendly[$pk][$val][$key][1]))
									$this->individualHealingToFriendly[$pk][$val][$key][1] += $tindDmg;
								else
									$this->individualHealingToFriendly[$pk][$val][$key][1] = $tindDmg;
								if (isset($this->individualHealingToFriendly[$pk][$val][$key][3]))
									$this->individualHealingToFriendly[$pk][$val][$key][3] += $numAbDone;
								else
									$this->individualHealingToFriendly[$pk][$val][$key][3] = $numAbDone;
								//$this->individualHealingToFriendly[$pk][$val][$key][4] = $this->getAbsorbedDamageTaken($key, $pk, $val);
								if (isset($this->individualHealingToFriendly[$pk][$val][$key][5]))
									$this->individualHealingToFriendly[$pk][$val][$key][5] += $active;
								else
									$this->individualHealingToFriendly[$pk][$val][$key][5] = $active;
								/*$this->healingToFriendly[$pk][$val][1] += $tindDmg;
								$this->healingToFriendly[$pk][$val][3] = $this->getAbsorbedDamageTaken($val, $pk);
								$this->healingToFriendly[$pk][$val][4] += $active;*/
							}
						}
					}
					foreach($this->ehealingtaken[$val] as $key => $var){
						if ($key != "i" && !isset($npcs[$key])){
							$eindDmg = 0;
							foreach($var as $ke => $va){
								$leech = array();
								$eabnum = 0;
								foreach($va["i"] as $k => $v){
									if ($k>=$ok[3] && $k<=$ok[5] && $v<=$this->spike){
										$eindDmg += $v;
										$eabnum += $v;
										if (isset($leech[$k]))
											$leech[$k] += $v;
										else
											$leech[$k] = $v;
									}
								}
								$this->addValues($this->graphindividualhealingreceived[$val][$pk][$ke][$key], $leech);
								if ($eabnum > 0){
									$this->individualHealingByAbility[$pk][$key][$val][$ke][2] = $eabnum;
									$this->individualHealingByAbility[$pk][$key][$val][$ke][4] = ($va[4]+$va[5])/($va[2]+$va[3]);
								}
							}
							if ($eindDmg>0){
								if (isset($this->individualHealingToFriendly[$pk][$val][$key][2]))
									$this->individualHealingToFriendly[$pk][$val][$key][2] += $eindDmg;
								else
									$this->individualHealingToFriendly[$pk][$val][$key][2] = $eindDmg;
								
								$this->healingToFriendly[$pk][$val][2] += $eindDmg;
							}
						}
					}
				}
			}
		}
	}
	
	/*
	* All of them have to be tested.
	*
	* buffs[attemptid][abilityid] = Array(1 => amount, 2 => active);
	* procs[attemptid][abilityid] = Array(1 => amount, 2 => chance);
	* individualBuffs[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
	* individualProcs[attemptid][charid][abilityid] = Array(1 => amount, 2 => chance);
	* individualBuffsByPlayer[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
	* debuffs[attemptid][abilityid] = Array(1 => amount, 2 => active);
	* individualDebuffs[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
	* individualDebuffsByPlayer[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
	*/
	
	private $nonProcProcs = Array(
		"Holy Strength" => true,
		"Felstriker" => true,
		"Sanctuary" => true,
		"Fury of Forgewright" => true,
		"Primal Blessing" => true,
		"Spinal Reaper" => true,
		"Netherwind Focus" => true,
		"Parry" => true,
		"Untamed Fury" => true,
		"Aura of the Blue Dragon" => true,
		"Invigorate" => true,
		"Head Rush" => true,
		"Enigma Resist Bonus" => true,
		"Enigma Blizzard Bonus" => true,
		"Not There" => true,
		"Epiphany" => true,
		"Inspiration" => true,
		"Blessed Recovery" => true,
		"Focused Casting" => true,
		"Clearcasting" => true,
		"Nature's Grace" => true,
		"Battlegear of Eternal Justice" => true,
		"Redoubt" => true,
		"Vengeance" => true,
		"Stormcaller's Wrath" => true,
		"Ancestral Healing" => true,
		"Vampirism" => true,
		"Nightfall" => true,
		"Cheat Death" => true,
		"Flurry" => true,
		"Enrage" => true,
		"Quick Shots" => true,
	);
	private $nonProcProcsButWorthTracking = Array(
		"Holy Strength" => true,
		"Felstriker" => true,
		"Primal Blessing" => true,
		"Spinal Reaper" => true,
		"Untamed Fury" => true,
		"Vengeance" => true,
		"Flurry" => true,
		"Enrage" => true,
		"Quick Shots" => true,
	);
	private $specialSnowflakes = Array(
		"Relentless Strikes Effect" => Array(
			"Eviscerate" => true,
			"Slice and Dice" => true,
			"Kidney Shot" => true,
			"Rupture" => true,
		),
		"Ruthlessness" => Array(
			"Eviscerate" => true,
			"Slice and Dice" => true,
			"Kidney Shot" => true,
			"Rupture" => true,
		),
		"Netherwind Focus" => Array(
			"Arcane Missiles" => true,
			"Fireball" => true,
			"Frostbolt" => true,
		),
		"Head Rush" => Array(
			"Sinister Strike" => true,
			"Backstab" => true,
			"Hemorrhage" => true,
		),
		"Enigma Resist Bonus" => Array(
			"Arcane Missiles" => true,
			"Fireball" => true,
			"Frostbolt" => true,
		),
		"Enigma Blizzard Bonus" => Array(
			"Blizzard" => true,
		),
		"Not There" => Array(
			"Arcane Missiles" => true,
			"Fireball" => true,
			"Frostbolt" => true,
		),
		"Clearcasting" => Array(
			"Arcane Missiles" => true,
			"Fireball" => true,
			"Frostbolt" => true,
			"Lightning Bolt" => true,
			"Chain Lightning" => true,
			"Earth Shock" => true,
			"Flame Shock" => true,
			"Frost Shock" => true,
		),
		"Battlegear of Eternal Justice" => Array(
			"Judgement" => true,
		),
		"Stormcaller's Wrath" => Array(
			"Lightning Bolt" => true,
			"Chain Lightning" => true,
			"Earth Shock" => true,
			"Flame Shock" => true,
			"Frost Shock" => true,
		),
		"Vampirism" => Array(
			"Shadow Bolt" => true,
		),
		"Nightfall" => Array(
			"Corruption" => true,
			"Drain Life" => true,
		),
		"Quick Shots" => Array(
			"Auto Shot" => true,
		)
	);
	private $specialSnowflakesDmgTaken = Array(
		1 => Array( // All
			"Cheat Death" => true,
			"Redoubt" => true,
		), // Just crits
		2 => Array(
			"Enrage" => true,
			"Blessed Recovery" => true,
			"Focused Casting" => true,
		)
	);
	private $specialSnowflakesHealTaken = Array(
		"Inspiration" => Array(
			"Flash Heal" => true,
			"Greater Heal" => true,
			"Heal" => true,
			"Prayer of Healing" => true,
			"Lesser Heal" => true,
			"Desperate Prayer" => true,
		),
		"Ancestral Spirit" => Array(
			"Chain Heal" => true,
			"Healing Wave" => true,
			"Lesser Healing Wave" => true,
		)
	);
	private $specialSnowflakesHealDone = array(
		"Aura of the Blue Dragon" => Array(
			"Flash Heal" => true,
			"Greater Heal" => true,
			"Heal" => true,
			"Prayer of Healing" => true,
			"Lesser Heal" => true,
			"Desperate Prayer" => true,
			"Flash of Light" => true,
			"Holy Light" => true,
			"Holy Shock" => true,
			"Regrowth" => true,
			"Swiftmend" => true,
			"Healing Touch" => true,
			"Chain Heal" => true,
			"Healing Wave" => true,
			"Lesser Healing Wave" => true,
		),
		"Nature's Grace" => Array(
			"Regrowth" => true,
			"Swiftmend" => true,
			"Healing Touch" => true,
			//"Starfire" => true,
			//"Wrath" => true,
			//"Moonfire" => true,
		),
		"Epiphany" => Array(
			"Flash Heal" => true,
			"Greater Heal" => true,
			"Heal" => true,
			"Prayer of Healing" => true,
			"Lesser Heal" => true,
			"Desperate Prayer" => true,
		)
	);
	private $mab = Array("AutoAttack" => true, "Sinister Strike" => true, "Eviscerate" => true, "Execute" => true, "Overpower" => true, "Bloodthirst" => true, "Mortal Strike" => true, "Heroic Strike" => true, "Cleave" => true, "Whirlwind" => true, "Backstab" => true, "Shield Slam" => true, "Revenge" => true, "Sunder Armor" => true, "Hamstring" => true); // I have probably forgotten a few
	
	private function getNumMeeleHitsByAbility($ab, $spellTra, $pk, $ok, $spellRevTra){
		$pl = array();
		$num = 0;
		$abname = $spellRevTra[$this->abilitiesById[$ab][1]];
		foreach($this->participantKeys as $val){
			if (isset($this->auras[$val])){
				if (isset($this->auras[$val][$ab])){
					if (!in_array($val, $pl))
						array_push($pl, $val);
				}
			}
		}
		if ($this->specialSnowflakes[$abname]){
			foreach($pl as $val){
				if (isset($this->individualDmgDoneByAbility[$pk][$val])){
					foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							if (isset($this->specialSnowflakes[$abname][$spellRevTra[$this->abilitiesById[$k][1]]])){
								$num += $v[2];
							}
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesDmgTaken[1][$abname]){
			foreach($pl as $val){
				if (isset($this->individualDmgTakenByAbility[$pk][$val])){
					foreach($this->individualDmgTakenByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							if (isset($this->mab[$spellRevTra[$this->abilitiesById[$ke][1]]])){
								$num += $v[4];
							}
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesDmgTaken[2][$abname]){
			foreach($pl as $val){
				if (isset($this->individualDmgTakenByAbility[$pk][$val])){
					foreach($this->individualDmgTakenByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							$num += $v[4]*$v[6];
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesHealTaken[$abname]){
			foreach($pl as $val){
				if (isset($this->individualHealingByAbilityTaken[$pk][$val])){
					foreach($this->individualHealingByAbilityTaken[$pk][$val] as $k => $v){ // attemptid
						if (isset($this->specialSnowflakesHealTaken[$abname][$spellRevTra[$this->abilitiesById[$k][1]]])){
							$num += $v[1];
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesHealDone[$abname]){
			foreach($pl as $val){
				if (isset($this->individualHealingByAbility[$pk][$val])){
					foreach($this->individualHealingByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							if (isset($this->specialSnowflakesHealDone[$abname][$spellRevTra[$this->abilitiesById[$k][1]]])){
								$num += $v[5];
							}
						}
					}
				}
			}
		}elseif ($abname == "Vengeance" or $abname == "Flurry"){
			foreach($pl as $val){
				if (isset($this->individualDmgDoneByAbility[$pk][$val])){
					foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							$num += $v[2]*$v[5];
						}
					}
				}
			}
		}else{
			foreach($pl as $val){
				if (isset($this->individualDmgDoneByAbility[$pk][$val])){
					foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							if (isset($this->mab[$spellRevTra[$this->abilitiesById[$k][1]]])){
								$num += $v[2];
							}
						}
					}
				}
			}
		}
		if ($abname == "Relentless Strikes Effect"){
			foreach($pl as $val){
				foreach($this->specialSnowflake[$abname] as $k => $v){
					if (isset($this->auras[$val][$this->abilities[$spellTra[$k]][1]][1])){
						foreach($this->auras[$val][$this->abilities[$spellTra[$k]][1]][1] as $key => $var){
							if ($var>=$ok[3] && $var<=$ok[5])
								$num++;
						}
					}
				}
			}
		}
		if ($num < 1)
			return 1;
		return ceil($num);
	}
	
	private function getNumMeeleHitsByAbilityByPlayer($ab, $spellTra, $pk, $ok, $val, $spellRevTra){
		$num = 0;
		$abname = $spellRevTra[$this->abilitiesById[$ab][1]];
		if ($this->specialSnowflakes[$abname]){
			//print "1: ".$abname."<br />";
			if (isset($this->individualDmgDoneByAbility[$pk][$val])){
				foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
					foreach($va as $k => $v){
						if (isset($this->specialSnowflakes[$abname][$spellRevTra[$this->abilitiesById[$k][1]]])){
							$num += $v[2];
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesDmgTaken[1][$abname]){
			//print "2: ".$abname."<br />";
			if (isset($this->individualDmgTakenByAbility[$pk][$val])){
				foreach($this->individualDmgTakenByAbility[$pk][$val] as $ke => $va){ // attemptid
					foreach($va as $k => $v){
						if (isset($this->mab[$spellRevTra[$this->abilitiesById[$ke][1]]])){
							$num += $v[4];
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesDmgTaken[2][$abname]){
			//print "3: ".$abname."<br />";
			if (isset($this->individualDmgTakenByAbility[$pk][$val])){
				foreach($this->individualDmgTakenByAbility[$pk][$val] as $ke => $va){ // attemptid
					foreach($va as $k => $v){
						$num += $v[4]*$v[6];
					}
				}
			}
		}elseif ($this->specialSnowflakesHealTaken[$abname]){
			//print "4: ".$abname."<br />";
			if (isset($this->individualHealingByAbilityTaken[$pk][$val])){
				foreach($this->individualHealingByAbilityTaken[$pk][$val] as $k => $v){ // attemptid
					if (isset($this->specialSnowflakesHealTaken[$abname][$spellRevTra[$this->abilitiesById[$k][1]]])){
						$num += $v[1];
					}
				}
			}
		}elseif ($this->specialSnowflakesHealDone[$abname]){
			if (isset($this->individualHealingByAbility[$pk][$val])){
				foreach($this->individualHealingByAbility[$pk][$val] as $ke => $va){ // attemptid
					foreach($va as $k => $v){
						if (isset($this->specialSnowflakesHealDone[$abname][$spellRevTra[$this->abilitiesById[$k][1]]])){
							$num += $v[5];
						}
					}
				}
			}
		}elseif ($abname == "Vengeance" or $abname == "Flurry"){
			//print "5: ".$abname."<br />";
			if (isset($this->individualDmgDoneByAbility[$pk][$val])){
				foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
					foreach($va as $k => $v){
						$num += $v[2]*$v[5];
					}
				}
			}
		}else{
			//print "6: ".$abname."<br />";
			if (isset($this->individualDmgDoneByAbility[$pk][$val])){
				foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
					//print $this->abilitiesById[$k][1]."<br />";+
					foreach($va as $k => $v){
						if (isset($this->mab[$spellRevTra[$this->abilitiesById[$k][1]]])){
							$num += $v[2];
							//print $v[2]."<br />";
						}
					}
				}
			}
		}
		if ($abname == "Relentless Strikes Effect"){
			foreach($this->specialSnowflake[$abname] as $k => $v){
				if (isset($this->auras[$val][$this->abilities[$spellTra[$k]][1]][1])){
					foreach($this->auras[$val][$this->abilities[$spellTra[$k]][1]][1] as $key => $var){
						if ($var>=$ok[3] && $var<=$ok[5])
							$num++;
					}
				}
			}
		}
		if ($num<1)
			return 1;
		return ceil($num);
	}
	
	private function getInstanceId($cbt){
		$last = 0; $id = "";
		foreach($this->instanceStart as $k => $v){
			if ($last == 0 || ($cbt>$v and ($cbt-$v)<($cbt-$last))){
				$id = $k;
				$last = $v;
			}
		}
		return $id;
	}
	
	private $newBuffs = array();
	private $newDebuffs = array();
	private function getAuras($spellTra, $spellRevTra){
		foreach($this->participantKeys as $val){
			if (isset($this->auras[$val])){
				// New buffsystem => More Raw Data
				foreach($this->auras[$val] as $k => $v){
					if (isset($this->instanceDebuffs[$spellRevTra[$this->abilitiesById[$k][1]]])){
						if (!isset($this->newDebuffs[$val][$k]))
							$this->newDebuffs[$val][$k] = array();
						foreach($v[1] as $key => $var){
							$id = $this->getInstanceId($var);
							if (!isset($this->newDebuffs[$val][$k][$id]))
								$this->newDebuffs[$val][$k][$id] = array(
									1 => "",
									2 => "",
								);
							$this->newDebuffs[$val][$k][$id][1] .= ($r = ($this->newDebuffs[$val][$k][$id][1] != "") ? "," : "").round($var, 1);
						}
						foreach($v[2] as $key => $var){
							$id = $this->getInstanceId($var);
							if (!isset($this->newDebuffs[$val][$k][$id]))
								$this->newDebuffs[$val][$k][$id] = array(
									1 => "",
									2 => "",
								);
							$this->newDebuffs[$val][$k][$id][2] .= ($r = ($this->newDebuffs[$val][$k][$id][2] != "") ? "," : "").round($var, 1);
						}
					}else{
						if ((isset($v[4]) && $v[4] === true) or (isset($this->nonProcProcs[$spellRevTra[$this->abilitiesById[$k][1]]]) && !isset($this->nonProcProcsButWorthTracking[$spellRevTra[$this->abilitiesById[$k][1]]]))){
							
						}else{
							if (!isset($this->newBuffs[$val][$k]))
								$this->newBuffs[$val][$k] = array();
							foreach($v[1] as $key => $var){
								$id = $this->getInstanceId($var);
								if (!isset($this->newBuffs[$val][$k][$id]))
									$this->newBuffs[$val][$k][$id] = array(
										1 => "",
										2 => "",
									);
								$this->newBuffs[$val][$k][$id][1] .= ($r = ($this->newBuffs[$val][$k][$id][1] != "") ? "," : "").round($var, 1);
							}
							foreach($v[2] as $key => $var){
								$id = $this->getInstanceId($var);
								if (!isset($this->newBuffs[$val][$k][$id]))
									$this->newBuffs[$val][$k][$id] = array(
										1 => "",
										2 => "",
									);
								$this->newBuffs[$val][$k][$id][2] .= ($r = ($this->newBuffs[$val][$k][$id][2] != "") ? "," : "").round($var, 1);
							}
						}
					}
				}
				
				// Have to remove old processing, once new is in place properly
				foreach($this->attempts as $pk => $ok){
					foreach($this->auras[$val] as $k => $v){
						$num = sizeOf($v[1]);
						$active = 0;
						$buffs =  0;
						$debuffs = 0;
						foreach($v[1] as $key => $var){
							if (($ok[3]-0.01)<=$var && ($ok[5]-0.01)>=$var){
								if (!isset($v[2][$key]))
									$v[2][$key] = $ok[5];
								$active += ($v[2][$key]-$var);
								if (isset($this->instanceDebuffs[$spellRevTra[$this->abilitiesById[$k][1]]])){
									$debuffs += 1;
								}else{
									$buffs += 1;
								}
							}
						}
						if (!isset($this->instanceDebuffs[$spellRevTra[$this->abilitiesById[$k][1]]])){
							if ($buffs > 0){
								if ((isset($v[4]) && $v[4] === true) or isset($this->nonProcProcs[$spellRevTra[$this->abilitiesById[$k][1]]])){
									if (!isset($this->procs[$pk][$k]))
										$this->procs[$pk][$k] = array(
											1 => 0,
											2 => 0
										);
									$this->procs[$pk][$k][1] += $buffs;
									//$this->procs[$pk][$k][2] += $this->getNumMeeleHitsByAbility($k, $spellTra, $pk, $ok, $spellRevTra);

									$this->individualProcs[$pk][$val][$k] = Array(
										1 => $buffs,
										2 => $this->getNumMeeleHitsByAbilityByPlayer($k, $spellTra, $pk, $ok, $val, $spellRevTra)
									);
									if ($this->individualProcs[$pk][$val][$k][1]>$this->individualProcs[$pk][$val][$k][2])
										$this->individualProcs[$pk][$val][$k][2] = $this->individualProcs[$pk][$val][$k][1];
								}
							}
						}
					}
				}
			}
		}
	}
	
	/*
	* All of them have to be tested
	* 
	* deathsBySource[attemptid][charid][cbt] = Array(1 => killingblow(abilityid), 2 => time);
	* individualDeath[attemptid][charid][cbt][abilityid] = Array(1 => dmg, 2 => heal, 3 => time, 4 => npcid, 5 => type(hit/crit/crush));
	*/
	private function getDeaths(){
		foreach($this->participantKeys as $val){
			if (isset($this->deaths[$val])){
				foreach($this->attempts as $pk => $ok){
					foreach($this->deaths[$val] as $k => $v){
						if ($v["i"][1]==1){
							if ($ok[3]<=$v[1][6] && $ok[5]>=$v[1][6]){
								$i = 1;
								while (isset($v[$i][3])){
									if ($v[$i][3]>0 && $v[$i][5]==0)
										break 1;
									else
										$i++;
								}
								if (isset($v[$i][6])){
									for($p=1;$p<=20;$p++){
										if (!isset($v[$p]))
											break 1;
										$this->individualDeath[$pk][$val][$v[$i][6]][$p] = Array(
											1 => ($r = ($v[$p][5] == 0) ? $v[$p][3] : 0),
											2 => ($r = ($v[$p][5] == 1) ? $v[$p][3] : 0),
											3 => $v[$p][7],
											4 => $v[$p][1],
											5 => $v[$p][4],
											6 => $v[$p][2],
											7 => ($r = (isset($this->userById[$v[$p][1]][2])) ? -1 : 1),
											8 => $v[$p][6]
										);
									}
									$this->deathsBySource[$pk][$val][$v[$i][6]] = Array(
										1 => $v[$i][2],
										2 => $v["i"][2],
										3 => $v[$i][1],
										4 => ($r = (isset($this->userById[$v[$i][1]][2])) ? -1 : 1)
									);
								}
							}
						}
					}
				}
			}
		}
	}
	
	/*
	* All of them have to be tested (STILL TODO -> Time missing, also cbt?)
	* 
	* missedInterrupts[attemptid][npcid][charid] = Array(1 => abilityid, 2 => amount);
	* successfullInterruptsSum[attemptid][charid] = amount
	* missedInterruptsSum[attemptid][abilityid] = amount
	* individualInterrtups[attemptid][charid][cbt] = Array(1 => time, 2 => abilityid, 3 => npcid);
	*/
	private function getInterrupts($spellRevTra, $npcRevTra){
		foreach($this->participantKeys as $val){
			foreach($this->attempts as $pk => $ok){
				if (isset($this->interrupts[$val])){
					$num = 0;
					foreach($this->interrupts[$val]["i"][2] as $k => $v){
						if ($v[1]>=$ok[3] && $v[1]<=$ok[5]){
							$num += 1;
							$this->individualInterrupts[$pk][$val][$v[1]] = Array(
								1 => $v[2],
								2 => $v[3],
								3 => $v[4]
							);
						}
					}
					$this->successfullInterruptsSum[$pk][$val] = $num;
				}
				foreach($this->edd as $k => $v){
					if (isset($v[$val])){
						foreach($v[$val] as $key => $var){
							if ($key != "i"){
								if (isset($this->interruptableSpells[$spellRevTra[$this->abilitiesById[$key][1]]]) && !isset($this->instanceBosses[$npcRevTra[$this->userById[$k][1]]])){
									if (isset($this->missedInterruptsSum[$pk][$key]))
										$this->missedInterruptsSum[$pk][$key] += $var[1]+$var[5];
									else
										$this->missedInterruptsSum[$pk][$key] = $var[1]+$var[5];
									$this->missedInterrupts[$pk][$k][$val] = Array(
										1 => $key,
										2 => $var[1]+$var[5]
									);
								}
							}
						}
					}
				}
			}
		}
	}
	
	/*
	* All of these have to be tested
	*
	* dispelsByAbility[attemptid][abilityid] = amount
	* dispelsByFriendly[attemptid][charid] = amount
	* individualDispelsByTarget[attemptid][charid][tarid] = amount;
	* individualDispelsByAbility[attemptid][charid][abilityid(the dispelled ability)] = amount;
	*/
	private function getDispels(){
		foreach($this->participantKeys as $val){
			if (isset($this->dispels[$val])){
				foreach($this->attempts as $pk => $ok){
					$amount = 0;
					foreach($this->dispels[$val]["i"][2] as $k => $v){
						if ($v[1]>=$ok[3] && $v[1]<=$ok[5]){
							$amount += 1;	
							if (!isset($this->individualDispelsByTarget[$pk][$val][$v[3]][$v[2]]))
								$this->individualDispelsByTarget[$pk][$val][$v[3]][$v[2]] = 0;
							$this->individualDispelsByTarget[$pk][$val][$v[3]][$v[2]] += 1;
						}
					}
				}
			}
		}
	}
	
	/*
	* individualHealingToFriendly[attemptid][charid][tarid] = Array(1 => tamount, 2 => eamount);
	* individualDmgDoneToEnemy[attemptid][npcid][charid] = Array(1 => amount, 2 => active);
	* healingBySource[attemptid][charid] = Array(1 => tamount, 2 => eamount, 3 => absorbed, 4 => active);
	* 
	* potentialDmgDoneRecords[charid] = array(1 => attemptid, 2 => dps);
	* potentialHealingDoneRecords[charid] = array(1 => attemptid, 2 => dps);
	*/
	private function aasort($array) {
		$sort = array();
		$p = array();
		foreach($array as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					$sort[$k][$ke][$key] = $var[1];
				}
				arsort($sort[$k][$ke]);
			}
		}
		foreach ($sort as $k => $v){
			foreach($v as $ke => $va){
				foreach ($va as $key => $var){
					$p[$k][$ke][$key] = $array[$k][$ke][$key];
				}
			}
		}
		return $p;
	}
	
	private function getImmortalRuns($attemptsArr, $guildid, $npcsById, $npcRevTra, $chars){
		// Will add the rest later
		$bossesByZone = Array(
			1 => array(
				"Lucifron" => false,
				"Magmadar" => false,
				"Gehennas" => false,
				"Garr" => false,
				"Baron Geddon" => false,
				"Shazzrah" => false,
				"Sulfuron Harbinger" => false, // maybe not?
				"Golemagg the Incinerator" => false,
				"Ragnaros" => false
			),
			3 => array(
				"Vaelastrasz the Corrupt" => false,
				"Broodlord Lashlayer" => false,
				"Firemaw" => false,
				"Flamegor" => false,
				"Ebonroc" => false,
				"Chromaggus" => false,
				"Nefarian" => false
			),
			2 => array(
				"Onyxia" => false,
			),
			4 => array(
				"High Priestess Jeklik" => false,
				"High Priest Venoxis" => false,
				"High Priestess Mar'li" => false,
				"Bloodlord Mandokir" => false,
				"High Priest Thekal" => false,
				"High Priestess Arlokk" => false,
				"Jin'do the Hexxer" => false,
				"Hakkar" => false,
			),
			5 => array(
				"Kurinnaxx" => false,
				//"General Rajaxx" => false,
				"Moam" => false,
				//"Buru the Gorger" => false,
				"Ayamiss the Hunter" => false,
				"Ossirian the Unscarred" => false,
			),
			6 => array(
				"The Prophet Skeram" => false,
				"Battleguard Sartura" => false,
				"Fankriss the Unyielding" => false,
				"Viscidus" => false,
				"Princess Huhuran" => false,
				"Ouro" => false,
				"C'Thun" => false,
			),
			7 => array(
				"Patchwerk" => false,
				"Grobbulus" => false,
				"Gluth" => false,
				"Thaddius" => false,
				"Anub'Rekhan" => false,
				"Grand Widow Faerlina" => false,
				"Maexxna" => false,
				"Instructor Razuvious" => false,
				"Gothik the Harvester" => false,
				"Noth the Plaguebringer" => false,
				"Heigan the Unclean" => false,
				"Loatheb" => false,
				"Sapphiron" => false,
				"Kel'Thuzad" => false,
			),
		);
		
		$VRankings = array();
		foreach($this->db->query('SELECT * FROM `v-immortal-runs` WHERE guildid = '.$guildid) as $row){
			$VRankings[$row->raidnameid] = Array(
				1 => $row->fodeaths,
				2 => $row->foadeaths,
				3 => $row->modeaths,
				4 => $row->moadeaths,
				5 => $row->fochange,
				6 => $row->foachange,
				7 => $row->mochange,
				8 => $row->moachange,
				9 => $row->forid,
				10 => $row->foarid,
				11 => $row->morid,
				12 => $row->moarid,
				13 => $row->foamount,
				14 => $row->foaamount,
				15 => false, // new Overall?
				16 => false, // new Rest?
				17 => $row->moamount,
				18 => $row->moaamount
			);
		}
		$deathsByRaid = array();
		foreach($attemptsArr as $k => $v){
			if (!isset($deathsByRaid[$v[8]]) && isset($v[8]) && $v[8] != '' && isset($v[2]))
				$deathsByRaid[$v[8]] = array(1=>0, 2=>$v[2]);
			if ($bossesByZone[$v[8]]){
				$bossesByZone[$v[8]][$npcRevTra[$npcsById[$v[3]]]] = true;
			}
		}
		foreach($this->deathsBySource as $k => $v){ // attemptids
			foreach($v as $ke => $va){ // player ids
				foreach($va as $key => $var){ // deaths
					if (!isset($npcsById[$ke]) && isset($chars[$ke]) && (!isset($this->userById[$ke][4]) or $this->userById[$ke][4] === false)){ 
						$nameid = $attemptsArr[$k][8];
						if (!isset($nameid)){
							foreach($attemptsArr as $kee => $vaa){
								if (isset($vaa[8])){
									$nameid = $vaa[8];
									break 1;
								}
							}
						}
						$deathsByRaid[$nameid][1]++;
					}
				}
			}
		}
		
		foreach($deathsByRaid as $k => $v){
			if ($this->allBossesKilled($bossesByZone[$k])){
				if (isset($VRankings[$k])){
					// overall and month best
					if ($VRankings[$k][1]>$v[1]){
						$VRankings[$k][5] = -($VRankings[$k][1]-$v[1]);
						$VRankings[$k][1] = $v[1];
						$VRankings[$k][9] = $v[2];
						$VRankings[$k][13] = 1;
					}
					if ($VRankings[$k][1]==$v[1]){
						$VRankings[$k][13]++;
						$VRankings[$k][5]=0;
					}
					if ($VRankings[$k][3]>$v[1]){
						$VRankings[$k][7] = -($VRankings[$k][3]-$v[1]);
						$VRankings[$k][3] = $v[1];
						$VRankings[$k][11] = $v[2];
						$VRankings[$k][17] = 1;
					}
					if ($VRankings[$k][3]==$v[1]){
						$VRankings[$k][17]++;
						$VRankings[$k][7]=0;
					}
					
					// overall and month average
					$VRankings[$k][6] = -($VRankings[$k][2] - ($VRankings[$k][2]*($VRankings[$k][14]/($VRankings[$k][14]+1)) + $v[1]*(1/($VRankings[$k][14]+1))));
					$VRankings[$k][2] = $VRankings[$k][2]*($VRankings[$k][14]/($VRankings[$k][14]+1)) + $v[1]*(1/($VRankings[$k][14]+1));
					$VRankings[$k][10] = $v[2];
					$VRankings[$k][14]++;
					
					$VRankings[$k][8] = -($VRankings[$k][4] - ($VRankings[$k][4]*($VRankings[$k][18]/($VRankings[$k][18]+1)) + $v[1]*(1/($VRankings[$k][18]+1))));
					$VRankings[$k][4] = $VRankings[$k][4]*($VRankings[$k][18]/($VRankings[$k][18]+1)) + $v[1]*(1/($VRankings[$k][18]+1));
					$VRankings[$k][12] = $v[2];
					$VRankings[$k][18]++;
					$VRankings[$k][15] = true;
				}else{
					$VRankings[$k] = array(
						1 => $v[1],
						2 => $v[1],
						3 => $v[1],
						4 => $v[1],
						5 => $v[1],
						6 => $v[1],
						7 => $v[1],
						8 => $v[1],
						9 => $v[2],
						10 => $v[2],
						11 => $v[2],
						12 => $v[2],
						13 => 1,
						14 => 1,
						15 => true,
						16 => true,
						17 => 1,
						18 => 1
					);
				}
			}else{
				
			}
		}
		return $VRankings;
	}
	
	/*
	$attemptsWithDbIdByNpcId[$v[2]] = array(
		1 => $id,
		2 => $raidsByZone[$v[1]], // raid id
		3 => $v[2],
		4 => $v[3],
		5 => $v[5],
		6 => $v[6], // kill attempt
		7 => $v[8], // 1 => boss
		8 => $raids[$v[1]], // raidnameid
		9 => $v[4], // time
		10 => $v[1],
		11 => $v[9]
	);
	*/
	
	private function getSimiliarAttemptId($attemptids, $npcid, $npcsById, $npcRevTra, $npcTra){
		if (isset($attemptids[$npcid]))
			return $attemptids[$npcid][1];
		$someid = 0;
		if (isset($npcsById[$npcid])){
			$bossname = $npcsById[$npcid];
			foreach($attemptids as $key => $var){
				if (isset($this->attempts[$var[1]])){
				$someid = $var[1];
				if (isset($this->attempts[$var[1]][2])){
					if ($this->attempts[$var[1]][2]==$bossname || (isset($npcRevTra[$this->attempts[$var[1]][2]]) && $npcRevTra[$this->attempts[$var[1]][2]] == $bossname) || (isset($npcTra[$this->attempts[$var[1]][2]]) && $npcTra[$this->attempts[$var[1]][2]] == $bossname))
						return $var[1];
					if (isset($this->attempts[$var[1]][10])){
						foreach($this->attempts[$var[1]][10] as $ke => $va){
							if (isset($va)){
								if ($va==$bossname || (isset($npcRevTra[$va]) && $npcRevTra[$va]==$bossname) || (isset($npcTra[$va]) && $npcTra[$va]==$bossname))
									return $var[1];
							}
						}
					}
				}
				}
			}
		}
		return $someid;
	}
	
	private function getVRankings($chars, $npcs, $attemptsids, $serverid, $classes, $npcRevTra, $npcTra, $npcsById){
		// Getting old records for reference
		$VRankings = array();
		if (!implode(",", $chars))
			return $VRankings;
		foreach($this->db->query('SELECT * FROM `v-rankings` a INNER JOIN chars b ON a.charid = b.id WHERE b.id IN ('.implode(",", $chars).')') as $row){
			$VRankings[$row->bossid][$row->type][$row->charid] = Array(
				1 => $row->boval,
				2 => $row->aoval,
				3 => $row->bmval,
				4 => $row->amval,
				5 => $row->botime,
				6 => $row->aotime,
				7 => $row->bmtime,
				8 => $row->amtime,
				9 => $row->oattemptid,
				10 => $row->mattemptid,
				11 => $row->bochange,
				12 => $row->aochange,
				13 => $row->bmchange,
				14 => $row->amchange,
				15 => false, // new Overall?
				16 => false, // new Rest?
				17 => $row->serverid,
				18 => $row->classid,
				19 => $row->aoamount,
				20 => $row->boamount
			);
		}
		
		// Damage done
		$temp = array();
		foreach($this->attempts as $pk => $ok){
			if ($ok[6]==true && (isset($this->instanceBosses[$ok[2]]) || isset($this->instanceBosses[$npcRevTra[$ok[2]]]) || isset($this->instanceBosses[$npcTra[$ok[2]]]))){
				$npcid = $npcs[$this->user[$ok[2]][1]];
				if (intval($npcid)==0)
					$npcid = $npcs[$this->user[$npcRevTra[$ok[2]]][1]];
				if (intval($npcid)==0)
					$npcid = $npcs[$this->user[$npcTra[$ok[2]]][1]];
				if (intval($npcid)>0){
					foreach($this->individualDmgDoneToEnemy[$pk] as $ke => $va){ //npcid
						foreach($va as $key => $var){ // charid
							if ($var[1]>0){
								if (isset($this->userById[$key][6]) && $this->userById[$key][6]!=0){ // pet dmg
									if (isset($temp[$npcid][$this->userById[$key][6]][1]))
										$temp[$npcid][$this->userById[$key][6]][1] += $var[1];
									else
										$temp[$npcid][$this->userById[$key][6]][1] = $var[1];
								}else{
									if (!isset($temp[$npcid][$key]))
										$temp[$npcid][$key] = array(
											1 => $var[1],
											2 => $ok[7]
										);
									else
										$temp[$npcid][$key][1] += $var[1];
								}
							}
						}
					}
				}
			}
		}
		
		// Healing done
		$tempHeal = array();
		foreach($this->attempts as $pk => $ok){
			if ($ok[6] && !$ok[8] && isset($this->instanceBosses[$npcRevTra[$ok[2]]]) && !isset($tempHeal[$npcs[$this->user[$ok[2]][1]]])){
				foreach($this->healingBySource[$pk] as $key => $var){ //charid
					if (($var[2]+$var[3])>0){
						$tempHeal[$npcs[$this->user[$ok[2]][1]]][$key][1] = ($var[2]+$var[3]);
						$tempHeal[$npcs[$this->user[$ok[2]][1]]][$key][2] = $ok[7];
					}
				}
			}
		}
		
		foreach($temp as $k => $v){
			foreach ($v as $ke => $va){
				if (isset($va[2]) && isset($va[1]) && isset($k)){
					if (!isset($tempHeal[$k][$ke]) || $tempHeal[$k][$ke][1]<$va[1]){
						$val = $va[1]/$va[2];
						$atmtid = $this->getSimiliarAttemptId($attemptsids, $k, $npcsById, $npcRevTra, $npcTra);
						if (isset($VRankings[$k][-1][$chars[$ke]])){
							if ($VRankings[$k][-1][$chars[$ke]][1]<$val){
								$VRankings[$k][-1][$chars[$ke]][11] = $val-$VRankings[$k][-1][$chars[$ke]][1];
								$VRankings[$k][-1][$chars[$ke]][1] = $val;
								$VRankings[$k][-1][$chars[$ke]][5] = $va[2];
								$VRankings[$k][-1][$chars[$ke]][9] = $atmtid;
								$VRankings[$k][-1][$chars[$ke]][15] = true;
							}
							if ($VRankings[$k][-1][$chars[$ke]][3]<$val){
								$VRankings[$k][-1][$chars[$ke]][13] = $val-$VRankings[$k][-1][$chars[$ke]][3];
								$VRankings[$k][-1][$chars[$ke]][3] = $val;
								$VRankings[$k][-1][$chars[$ke]][7] = $va[2];
								$VRankings[$k][-1][$chars[$ke]][10] = $atmtid;
							}
							if ($VRankings[$k][-1][$chars[$ke]][2] == 0){
								$VRankings[$k][-1][$chars[$ke]][12] = $val;
								$VRankings[$k][-1][$chars[$ke]][2] = $val;
								$VRankings[$k][-1][$chars[$ke]][6] = $va[2];
								$VRankings[$k][-1][$chars[$ke]][19] = 1;
							}else{
								$VRankings[$k][-1][$chars[$ke]][12] = -($VRankings[$k][-1][$chars[$ke]][2] - ($VRankings[$k][-1][$chars[$ke]][2]*($VRankings[$k][-1][$chars[$ke]][19]/($VRankings[$k][-1][$chars[$ke]][19]+1)) + $val*(1/($VRankings[$k][-1][$chars[$ke]][19]+1))));
								$VRankings[$k][-1][$chars[$ke]][2] = $VRankings[$k][-1][$chars[$ke]][2]*($VRankings[$k][-1][$chars[$ke]][19]/($VRankings[$k][-1][$chars[$ke]][19]+1)) + $val*(1/($VRankings[$k][-1][$chars[$ke]][19]+1));
								$VRankings[$k][-1][$chars[$ke]][6] = $VRankings[$k][-1][$chars[$ke]][6]*($VRankings[$k][-1][$chars[$ke]][19]/($VRankings[$k][-1][$chars[$ke]][19]+1)) + $va[2]*(1/($VRankings[$k][-1][$chars[$ke]][19]+1));
								$VRankings[$k][-1][$chars[$ke]][19]++;
							}
							if ($VRankings[$k][-1][$chars[$ke]][4] == 0){
								$VRankings[$k][-1][$chars[$ke]][14] = $val;
								$VRankings[$k][-1][$chars[$ke]][4] = $val;
								$VRankings[$k][-1][$chars[$ke]][8] = $va[2];
								$VRankings[$k][-1][$chars[$ke]][20] = 1;
							}else{
								$VRankings[$k][-1][$chars[$ke]][14] = -($VRankings[$k][-1][$chars[$ke]][4] - ($VRankings[$k][-1][$chars[$ke]][4]*($VRankings[$k][-1][$chars[$ke]][20]/($VRankings[$k][-1][$chars[$ke]][20]+1)) + $val*(1/($VRankings[$k][-1][$chars[$ke]][20]+1))));
								$VRankings[$k][-1][$chars[$ke]][4] = $VRankings[$k][-1][$chars[$ke]][4]*($VRankings[$k][-1][$chars[$ke]][20]/($VRankings[$k][-1][$chars[$ke]][20]+1)) + $val*(1/($VRankings[$k][-1][$chars[$ke]][20]+1));
								$VRankings[$k][-1][$chars[$ke]][8] = $VRankings[$k][-1][$chars[$ke]][8]*($VRankings[$k][-1][$chars[$ke]][20]/($VRankings[$k][-1][$chars[$ke]][20]+1)) + $va[2]*(1/($VRankings[$k][-1][$chars[$ke]][20]+1));
								$VRankings[$k][-1][$chars[$ke]][20]++;
							}
							$VRankings[$k][-1][$chars[$ke]][16] = true;
						}else{
							$VRankings[$k][-1][$chars[$ke]] = Array(
								1 => $val,
								2 => $val,
								3 => $val,
								4 => $val,
								5 => $va[2],
								6 => $va[2],
								7 => $va[2],
								8 => $va[2],
								9 => $atmtid,
								10 => $atmtid,
								11 => $val,
								12 => $val,
								13 => $val,
								14 => $val,
								15 => true,
								16 => true,
								17 => $serverid,
								18 => ($r = (isset($this->userById[$ke][2])) ? $classes[$this->userById[$ke][2]] : 0),
								19 => 1,
								20 => 1
							);
						}
					}
				}
			}
		}

		foreach($tempHeal as $k => $v){
			foreach ($v as $ke => $va){
				if (isset($va[2]) && isset($va[1]) && isset($k)){
					if (!isset($temp[$k][$ke]) || $temp[$k][$ke][1]<$va[1]){
						$val = $va[1]/$va[2];
						if (isset($VRankings[$k][1][$chars[$ke]])){
							if ($VRankings[$k][1][$chars[$ke]][1]<$val){
								$VRankings[$k][1][$chars[$ke]][11] = $val-$VRankings[$k][1][$chars[$ke]][1];
								$VRankings[$k][1][$chars[$ke]][1] = $val;
								$VRankings[$k][1][$chars[$ke]][5] = $va[2];
								$VRankings[$k][1][$chars[$ke]][9] = $attemptsids[$k][1];
								$VRankings[$k][1][$chars[$ke]][15] = true;
							}
							if ($VRankings[$k][1][$chars[$ke]][3]<$val){
								$VRankings[$k][1][$chars[$ke]][13] = $val-$VRankings[$k][1][$chars[$ke]][3];
								$VRankings[$k][1][$chars[$ke]][3] = $val;
								$VRankings[$k][1][$chars[$ke]][7] = $va[2];
								$VRankings[$k][1][$chars[$ke]][10] = $attemptsids[$k][1];
							}
							if ($VRankings[$k][1][$chars[$ke]][2] == 0){
								$VRankings[$k][1][$chars[$ke]][12] = $val;
								$VRankings[$k][1][$chars[$ke]][2] = $val;
								$VRankings[$k][1][$chars[$ke]][6] = $va[2];
								$VRankings[$k][1][$chars[$ke]][19] = 1;
							}else{
								$VRankings[$k][1][$chars[$ke]][12] = -($VRankings[$k][1][$chars[$ke]][2] - ($VRankings[$k][1][$chars[$ke]][2]*($VRankings[$k][1][$chars[$ke]][19]/($VRankings[$k][1][$chars[$ke]][19]+1)) + $val*(1/($VRankings[$k][1][$chars[$ke]][19]+1))));
								$VRankings[$k][1][$chars[$ke]][2] = $VRankings[$k][1][$chars[$ke]][2]*($VRankings[$k][1][$chars[$ke]][19]/($VRankings[$k][1][$chars[$ke]][19]+1)) + $val*(1/($VRankings[$k][1][$chars[$ke]][19]+1));
								$VRankings[$k][1][$chars[$ke]][6] = $VRankings[$k][1][$chars[$ke]][6]*($VRankings[$k][1][$chars[$ke]][19]/($VRankings[$k][1][$chars[$ke]][19]+1)) + $va[2]*(1/($VRankings[$k][1][$chars[$ke]][19]+1));
								$VRankings[$k][1][$chars[$ke]][19]++;
							}
							if ($VRankings[$k][1][$chars[$ke]][4] == 0){
								$VRankings[$k][1][$chars[$ke]][14] = $val;
								$VRankings[$k][1][$chars[$ke]][4] = $val;
								$VRankings[$k][1][$chars[$ke]][8] = $va[2];
								$VRankings[$k][1][$chars[$ke]][20] = 1;
							}else{
								$VRankings[$k][1][$chars[$ke]][14] = -($VRankings[$k][1][$chars[$ke]][4] - ($VRankings[$k][1][$chars[$ke]][4]*($VRankings[$k][1][$chars[$ke]][20]/($VRankings[$k][1][$chars[$ke]][20]+1)) + $val*(1/($VRankings[$k][1][$chars[$ke]][20]+1))));
								$VRankings[$k][1][$chars[$ke]][4] = $VRankings[$k][1][$chars[$ke]][4]*($VRankings[$k][1][$chars[$ke]][20]/($VRankings[$k][1][$chars[$ke]][20]+1)) + $val*(1/($VRankings[$k][1][$chars[$ke]][20]+1));
								$VRankings[$k][1][$chars[$ke]][8] = $VRankings[$k][1][$chars[$ke]][8]*($VRankings[$k][1][$chars[$ke]][20]/($VRankings[$k][1][$chars[$ke]][20]+1)) + $va[2]*(1/($VRankings[$k][1][$chars[$ke]][20]+1));
								$VRankings[$k][1][$chars[$ke]][20]++;
							}
							$VRankings[$k][1][$chars[$ke]][16] = true;
						}else{
							$VRankings[$k][1][$chars[$ke]] = Array(
								1 => $val,
								2 => $val,
								3 => $val,
								4 => $val,
								5 => $va[2],
								6 => $va[2],
								7 => $va[2],
								8 => $va[2],
								9 => $attemptsids[$k][1],
								10 => $attemptsids[$k][1],
								11 => $val,
								12 => $val,
								13 => $val,
								14 => $val,
								15 => true,
								16 => true,
								17 => $serverid,
								18 => $classes[$this->userById[$ke][2]],
								19 => 1,
								20 => 1
							);
						}
					}
				}
			}
		}
		
		return $this->aasort($VRankings);
	}
	
	private function allBossesKilled($arr){
		foreach($arr as $key => $var){
			if ($var == false){
				//print $key."<br />";
				return false;
			}
		}
		return isset($arr);
	}
	
	private function getSpeedRunRanking($attemptsArr, $guildid, $npcsById, $npcRevTra){
		$instanceTra = array(
			"Geschmolzener Kern" => "Molten Core",
			"Pechschwingenhort" => "Blackwing Lair",
			"Zul'Gurub" => "Zul'Gurub",
			"Ruinen von Ahn'Qiraj" => "Ruins of Ahn'Qiraj",
			"Tempel von Ahn'Qiraj" => "Temple of Ahn'Qiraj",
			"Ahn'Qiraj" => "Ahn'Qiraj",
			"Naxxramas" => "Naxxramas",
		);
		// Will add the rest later
		$bossesByZone = Array(
			"Molten Core" => array(
				"Lucifron" => false,
				"Magmadar" => false,
				"Gehennas" => false,
				"Garr" => false,
				"Baron Geddon" => false,
				"Shazzrah" => false,
				"Sulfuron Harbinger" => false, // maybe not?
				"Golemagg the Incinerator" => false,
				"Ragnaros" => false
			),
			"Blackwing Lair" => array(
				"Vaelastrasz the Corrupt" => false,
				"Broodlord Lashlayer" => false,
				"Firemaw" => false,
				"Flamegor" => false,
				"Ebonroc" => false,
				"Chromaggus" => false,
				"Nefarian" => false
			),
			"Onyxia's Lair" => array(
				"Onyxia" => false,
			),
			"Zul'Gurub" => array(
				"High Priestess Jeklik" => false,
				"High Priest Venoxis" => false,
				"High Priestess Mar'li" => false,
				"Bloodlord Mandokir" => false,
				"High Priest Thekal" => false,
				"High Priestess Arlokk" => false,
				"Jin'do the Hexxer" => false,
				"Hakkar" => false,
			),
			"Ruins of Ahn'Qiraj" => array(
				"Kurinnaxx" => false,
				//"General Rajaxx" => false,
				"Moam" => false,
				//"Buru the Gorger" => false,
				"Ayamiss the Hunter" => false,
				"Ossirian the Unscarred" => false,
			),
			"Ahn'Qiraj" => array(
				"The Prophet Skeram" => false,
				"Battleguard Sartura" => false,
				"Fankriss the Unyielding" => false,
				"Viscidus" => false,
				"Princess Huhuran" => false,
				"Ouro" => false,
				"The Twin Emperors" => false,
				"The Bug Family" => false,
				"C'Thun" => false,
			),
			"Temple of Ahn'Qiraj" => array(
				"The Prophet Skeram" => false,
				"Battleguard Sartura" => false,
				"Fankriss the Unyielding" => false,
				"Viscidus" => false,
				"Princess Huhuran" => false,
				"Ouro" => false,
				"The Twin Emperors" => false,
				"The Bug Family" => false,
				"C'Thun" => false,
			),
			"Naxxramas" => array(
				"Patchwerk" => false,
				"Grobbulus" => false,
				"Gluth" => false,
				"Thaddius" => false,
				"Anub'Rekhan" => false,
				"Grand Widow Faerlina" => false,
				"Maexxna" => false,
				"Instructor Razuvious" => false,
				"Gothik the Harvester" => false,
				"Noth the Plaguebringer" => false,
				"Heigan the Unclean" => false,
				"Loatheb" => false,
				"Sapphiron" => false,
				"Kel'Thuzad" => false,
			),
		);
		
		$SpeedRun = array();
		foreach($this->db->query('SELECT * FROM `v-speed-runs` WHERE guildid = "'.$guildid.'"') as $row){
			$SpeedRun[$row->raidnameid] = array(
				1 => $row->fotime,
				2 => $row->foboss,
				4 => $row->foatime,
				5 => $row->foaboss,
				7 => $row->fmtime,
				8 => $row->fmboss,
				10 => $row->fmatime,
				11 => $row->fmaboss,
				13 => $row->oraidid,
				14 => $row->mraidid,
				15 => $row->fochange,
				16 => $row->foachange,
				17 => $row->fmchange,
				18 => $row->fmachange,
				19 => false,
				20 => $row->foamount,
				21 => $row->fmamount
			);
		}
		
		// Summarize raids
		$raids = array();
		foreach($attemptsArr as $key => $var){
			// setting it up to check if its cleared
			// only check bosses hence it should only count time from the very first to the last boss.
			if (isset($var[10]) && (isset($bossesByZone[$var[10]]) or isset($bossesByZone[$instanceTra[$var[10]]])) && isset($var[6]) && (isset($bossesByZone[$var[10]][$npcRevTra[$npcsById[$var[3]]]]) or isset($bossesByZone[$instanceTra[$var[10]]][$npcRevTra[$npcsById[$var[3]]]]))){
				$ts = strtotime($var[9]);
				$start = $ts;
				$end = $ts+($var[5]-$var[4]);
				if(!isset($raids[$var[8]][1]) || $raids[$var[8]][1]>$start)
					$raids[$var[8]][1] = $start;
				if(!isset($raids[$var[8]][2]) || $raids[$var[8]][2]<$end)
					$raids[$var[8]][2] = $end;
				$raids[$var[8]][3] = $var[2]; // raid id
				if ($var[7] == 1){
					if (!isset($raids[$var[8]][4]))
						$raids[$var[8]][4] = ($var[5]-$var[4]);
					else
						$raids[$var[8]][4] += ($var[5]-$var[4]); // boss fight time
				}
				if (isset($bossesByZone[$var[10]])){
					$bossesByZone[$var[10]][$npcRevTra[$npcsById[$var[3]]]] = true;
				}else{
					$bossesByZone[$instanceTra[$var[10]]][$npcRevTra[$npcsById[$var[3]]]] = true;
				}
				if (isset($instanceTra[$var[10]]))
					$raids[$var[8]][5] = $instanceTra[$var[10]];
				else
					$raids[$var[8]][5] = $var[10];
			}
		}
		
		
		
		foreach($raids as $key => $var){
			$now = time() + 43200;
			if ($now<$var[1])
				$var[1] = strtotime("yesterday ".date("H:i:s", $var[1]));
			if ($now<$var[2])
				$var[2] = strtotime("yesterday ".date("H:i:s", $var[2]));
			if ($var[2]<$var[1])
				$var[1] = strtotime("yesterday ".date("H:i:s", $var[1]));
			if (isset($var[5])){
				if ($this->allBossesKilled($bossesByZone[$var[5]])){
					$duration = $var[2]-$var[1];
					if (isset($SpeedRun[$key])){
						if ($SpeedRun[$key][1]>$duration){
							$SpeedRun[$key][15] = $duration-$SpeedRun[$key][1];
							$SpeedRun[$key][1] = $duration;
							$SpeedRun[$key][2] = $var[4];
							$SpeedRun[$key][3] = $duration-$var[4];
							$SpeedRun[$key][13] = $var[3];
						}
						if ($SpeedRun[$key][7]>$duration){
							$SpeedRun[$key][17] = $duration-$SpeedRun[$key][7];
							$SpeedRun[$key][7] = $duration;
							$SpeedRun[$key][8] = $var[4];
							$SpeedRun[$key][9] = $duration-$var[4];
							$SpeedRun[$key][14] = $var[3];
						}
						if ($SpeedRun[$key][4] == 0){
							$SpeedRun[$key][16] = $duration;
							$SpeedRun[$key][4] = $duration;
							$SpeedRun[$key][5] = $var[4];
							$SpeedRun[$key][20] = 1;
						}else{
							$SpeedRun[$key][16] = -($SpeedRun[$key][4] - ($SpeedRun[$key][4]*($SpeedRun[$key][20]/($SpeedRun[$key][20]+1)) + $duration*(1/($SpeedRun[$key][20]+1))));
							$SpeedRun[$key][4] = $SpeedRun[$key][4]*($SpeedRun[$key][20]/($SpeedRun[$key][20]+1)) + $duration*(1/($SpeedRun[$key][20]+1));
							$SpeedRun[$key][5] = $SpeedRun[$key][5]*($SpeedRun[$key][20]/($SpeedRun[$key][20]+1)) + $var[4]*(1/($SpeedRun[$key][20]+1));
							$SpeedRun[$key][20]++;
						}
						if ($SpeedRun[$key][10] == 0){
							$SpeedRun[$key][18] = $duration;
							$SpeedRun[$key][10] = $duration;
							$SpeedRun[$key][11] = $var[4];
							$SpeedRun[$key][21] = 1;
						}else{
							$SpeedRun[$key][18] = -($SpeedRun[$key][10] - ($SpeedRun[$key][10]*($SpeedRun[$key][21]/($SpeedRun[$key][21]+1)) + $duration*(1/($SpeedRun[$key][21]+1))));
							$SpeedRun[$key][10] = $SpeedRun[$key][10]*($SpeedRun[$key][21]/($SpeedRun[$key][21]+1)) + $duration*(1/($SpeedRun[$key][21]+1));
							$SpeedRun[$key][11] = $SpeedRun[$key][11]*($SpeedRun[$key][21]/($SpeedRun[$key][21]+1)) + $var[4]*(1/($SpeedRun[$key][21]+1));
							$SpeedRun[$key][21]++;
						}
						$SpeedRun[$key][19] = true;
					}else{
						$SpeedRun[$key] = array(
							1 => $duration,
							2 => $var[4],
							4 => $duration,
							5 => $var[4],
							7 => $duration,
							8 => $var[4],
							10 => $duration,
							11 => $var[4],
							13 => $var[3],
							14 => $var[3],
							15 => $duration,
							16 => $duration,
							17 => $duration,
							18 => $duration,
							19 => true,
							20 => 1,
							21 => 1
						);
					}
				}
			}			
		}
		return $SpeedRun;
	}
	
	private function getSpeedKillRanking($attemptsArr, $guildid){
		$SpeedKillRanking = array();
		foreach($this->db->query('SELECT * FROM `v-speed-kills` WHERE guildid = "'.$guildid.'"') as $row){
			$SpeedKillRanking[$row->bossid] = array(
				1 => $row->fotime,
				2 => $row->foatime,
				3 => $row->fmtime,
				4 => $row->fmatime,
				5 => $row->fochange,
				6 => $row->foachange,
				7 => $row->fmchange,
				8 => $row->fmachange,
				9 => $row->oraidid,
				10 => $row->mraidid,
				11 => false,
				12 => $row->foamount,
				13 => $row->fmamount
			);
		}
		
		$kills = array();
		foreach($attemptsArr as $key => $var){
			if (isset($var[6]) && $var[7] == 1){
				$kills[$var[3]] = Array(
					1 => $var[5]-$var[4],
					2 => $var[2]
				);
			}
		}
		
		foreach($kills as $key => $var){
			if (isset($SpeedKillRanking[$key])){
				if ($SpeedKillRanking[$key][1]>$var[1]){
					$SpeedKillRanking[$key][5] = $var[1]-$SpeedKillRanking[$key][1];
					$SpeedKillRanking[$key][1] = $var[1];
					$SpeedKillRanking[$key][9] = $var[2];
				}
				if ($SpeedKillRanking[$key][3]>$var[1]){
					$SpeedKillRanking[$key][7] = $var[1]-$SpeedKillRanking[$key][3];
					$SpeedKillRanking[$key][3] = $var[1];
					$SpeedKillRanking[$key][10] = $var[2];
				}
				if ($SpeedKillRanking[$key][2] == 0){
					$SpeedKillRanking[$key][6] = $var[1];
					$SpeedKillRanking[$key][2] = $var[1];
					$SpeedKillRanking[$key][12] = 1;
				}else{
					$SpeedKillRanking[$key][6] = -($SpeedKillRanking[$key][2] - ($SpeedKillRanking[$key][2]*($SpeedKillRanking[$key][12]/($SpeedKillRanking[$key][12]+1)) + $var[1]*(1/($SpeedKillRanking[$key][12]+1))));
					$SpeedKillRanking[$key][2] = $SpeedKillRanking[$key][2]*($SpeedKillRanking[$key][12]/($SpeedKillRanking[$key][12]+1)) + $var[1]*(1/($SpeedKillRanking[$key][12]+1));
					$SpeedKillRanking[$key][12]++;
				}
				if ($SpeedKillRanking[$key][4] == 0){
					$SpeedKillRanking[$key][8] = $var[1];
					$SpeedKillRanking[$key][4] = $var[1];
					$SpeedKillRanking[$key][13] = 1;
				}else{
					$SpeedKillRanking[$key][8] = -($SpeedKillRanking[$key][4] - ($SpeedKillRanking[$key][4]*($SpeedKillRanking[$key][13]/($SpeedKillRanking[$key][13]+1)) + $var[1]*(1/($SpeedKillRanking[$key][13]+1))));
					$SpeedKillRanking[$key][4] = $SpeedKillRanking[$key][4]*($SpeedKillRanking[$key][13]/($SpeedKillRanking[$key][13]+1)) + $var[1]*(1/($SpeedKillRanking[$key][13]+1));
					$SpeedKillRanking[$key][13]++;
				}
				$SpeedKillRanking[$key][11] = true;
			}else{
				$SpeedKillRanking[$key] = Array(
					1 => $var[1],
					2 => $var[1],
					3 => $var[1],
					4 => $var[1],
					5 => $var[1],
					6 => $var[1],
					7 => $var[1],
					8 => $var[1],
					9 => $var[2],
					10 => $var[2],
					11 => true,
					12 => 1,
					13 => 1
				);
			}
		}
		
		return $SpeedKillRanking;
	}
	
	private function in_array($arr, $val){
		if (isset($val)){
			foreach($arr as $key => $var){
				if ($key == $val || $var == $val)
					return true;
			}
		}
		return false;
	}
	
	private function getBossBeginn($arr, $alt){
		$first = 0;
		foreach($arr as $val){
			foreach($this->totalEDTTable[$val] as $var){
				foreach($var as $k => $v){
					if (($first == 0 || $k<$first) && $k>=$alt)
						$first = $k;
				}
			}
		}
		if ($first != 0)
			return $first;
		return $alt;
	}
	
	private function getLatestPointInSub($arr, $old){
		$latest = $old;
		foreach($arr as $k => $v){
			if ($v[2]>$latest)
				$latest = $v[2];
		}
		return $latest;
	}
	
	private $instanceStart = array();
	private function getAttempts($npcsTra, $npcsTraRev){
		$bossBeginnArray = array(
			$npcsTra["Majordomo Executus"] => array(
				$npcsTra["Flamewaker Elite"],
				$npcsTra["Flamewaker Healer"],
			),
			$npcsTra["Nefarian"] => array(
				$npcsTra["Red Drakonid"],
				$npcsTra["Green Drakonid"],
				$npcsTra["Bronze Drakonid"],
				$npcsTra["Black Drakonid"],
				$npcsTra["Blue Drakonid"],
				$npcsTra["Bone Construct"],
				$npcsTra["Nefarian"],
			),
			$npcsTra["C'Thun"] => array(
				$npcsTra["Claw Tentacle"],
				$npcsTra["Eye Tentacle"],
				$npcsTra["Eye of C'Thun"],
				$npcsTra["Giant Claw Tentacle"],
				$npcsTra["Giant Eye Tentacle"],
				$npcsTra["C'Thun"],
			),
			$npcsTra["The Bug Family"] => array(
				$npcsTra["Lord Kri"],
				$npcsTra["Vem"],
				$npcsTra["Princess Yauj"],
			),
			$npcsTra["The Twin Emperors"] => array(
				$npcsTra["Emperor Vek'lor"],
				$npcsTra["Emperor Vek'nilash"],
			),
			$npcsTra["The Four Horsemen"] => array(
				$npcsTra["Thane Korth'azz"],
				$npcsTra["Highlord Mograine"],
				$npcsTra["Lady Blaumeux"],
				$npcsTra["Sir Zeliek"],
			),
		);
		$bossToGroup = array(
			"Emperor Vek'lor" => $npcsTra["The Twin Emperors"],
			"Emperor Vek'nilash" => $npcsTra["The Twin Emperors"],
			"Vem" => $npcsTra["The Bug Family"],
			"Lord Kri" => $npcsTra["The Bug Family"],
			"Princess Yauj" => $npcsTra["The Bug Family"],
			"Thane Korth'azz" => $npcsTra["The Four Horsemen"],
			"Highlord Mograine" => $npcsTra["The Four Horsemen"],
			"Lady Blaumeux" => $npcsTra["The Four Horsemen"],
			"Sir Zeliek" => $npcsTra["The Four Horsemen"],
			"Flamewaker Healer" => $npcsTra["Majordomo Executus"],
			"Flamewaker Elite" => $npcsTra["Majordomo Executus"],
		);
		$GroupBoss = array(
			"The Bug Family" => true,
			"The Twin Emperors" => true,
			"The Four Horsemen" => true,
			"Majordomo Executus" => true,
		);
		//Fix attempt unknowns
		foreach($this->atmt as $k => $v){
			foreach($v as $key => $var){
				if (($var[1]=="Unknown" or $var[1]=="Unbekannt") && !empty($var[6])){
					foreach($var[6] as $ke => $va){
						$this->atmt[$k][$key][1] = $va[2];
						if (isset($this->instanceBosses[$npcsTraRev[$va[2]]]) or isset($this->instanceBosses[$va[2]]))
							break 1;
					}
				}
			}
		}
		
		foreach($this->atmt as $k => $v){
			if (sizeOf($v)>0){
				$bool = false;
				foreach($v as $key => $var){
					if (!$bool){
						foreach($bossBeginnArray as $qk => $qv){
							if (isset($this->instanceBosses[$npcsTraRev[$var[1]]]) or isset($this->instanceBosses[$var[1]]) or in_array($npcsTraRev[$var[1]], $qv) or in_array($var[1], $qv))
								$bool = true;
							if (!$bool){
								foreach($var[6] as $ke => $va){
									if (isset($this->instanceBosses[$npcsTraRev[$va[2]]]) or isset($this->instanceBosses[$va[2]]) or $bool or in_array($npcsTraRev[$va[2]], $qv)){
										$bool = true;
										break 1;
									}
								}
							}
							if ($bool)
								break 1;
						}
					}else{
						break 1;
					}
				}
				if ($bool){
					$unknownArr = array();
					$unTime = "";
					foreach($v as $key => $var){
						if ((isset($var[1]) && ($var[1] != "Unknown" or $var[1] != "Unbekannt")) or (($var[1] == "Unknown" or $var[1] == "Unbekannt") && !empty($var[6])) or (empty($var[6]) && ($var[1] != "Unknown" or $var[1] != "Unbekannt"))){
							if (!isset($this->instanceStart[$k]) || $this->instanceStart[$k]>$var[2])
								$this->instanceStart[$k] = $var[2];
							$sub = array();
							foreach($var[6] as $pk => $ok){
								if ($ok[2] != $npcsTra["Majordomo Executus"] and $ok[2] != "Majordomo Executus"){
									if (!isset($sub[$ok[2]][1]) || $sub[$ok[2]][1]>$ok[1])
										$sub[$ok[2]][1] = $ok[1];
									if (!isset($sub[$ok[2]][2]) || $sub[$ok[2]][2]<$ok[1])
										$sub[$ok[2]][2] = $ok[1];
								}
							}
							// Extra code to track Nefarian trys
							if ($this->in_array($sub, $npcsTra["Red Drakonid"]) || $this->in_array($sub, $npcsTra["Green Drakonid"]) || $this->in_array($sub, $npcsTra["Bronze Drakonid"]) || $this->in_array($sub, $npcsTra["Black Drakonid"]) || $this->in_array($sub, $npcsTra["Blue Drakonid"]) || $this->in_array($sub, "Red Drakonid") || $this->in_array($sub, "Green Drakonid") || $this->in_array($sub, "Bronze Drakonid") || $this->in_array($sub, "Black Drakonid") || $this->in_array($sub, "Blue Drakonid")){
								foreach($sub as $pk => $ok){
									$pk = $npcsTra["Nefarian"];
									if (!isset($sub[$pk][1]) || $sub[$pk][1]>$ok[1])
										$sub[$pk][1] = $ok[1];
									if (!isset($sub[$pk][2]) || $sub[$pk][2]<$ok[2])
										$sub[$pk][2] = $ok[2];
								}
								if (!isset($this->user[$npcsTra["Nefarian"]])){
									$this->user[$npcsTra["Nefarian"]] = array(1=>100005);
									$this->userById[100005] = array(1=>$npcsTra["Nefarian"]);
								}
							}
							// Extra code to track C'Thun trys
							if ($this->in_array($sub, $npcsTra["Claw Tentacle"]) || $this->in_array($sub, $npcsTra["Eye Tentacle"]) || $this->in_array($sub, $npcsTra["Eye of C'Thun"]) || $this->in_array($sub, $npcsTra["Giant Claw Tentacle"]) || $this->in_array($sub, $npcsTra["Giant Eye Tentacle"]) || $this->in_array($sub, "Claw Tentacle") || $this->in_array($sub, "Eye Tentacle") || $this->in_array($sub, "Eye of C'Thun") || $this->in_array($sub, "Giant Claw Tentacle") || $this->in_array($sub, "Giant Eye Tentacle")){
								foreach($sub as $pk => $ok){
									$pk = $npcsTra["C'Thun"];
									if (!isset($sub[$pk][1]) || $sub[$pk][1]>$ok[1])
										$sub[$pk][1] = $ok[1];
									if (!isset($sub[$pk][2]) || $sub[$pk][2]<$ok[2])
										$sub[$pk][2] = $ok[2];
								}
								if (!isset($this->user[$npcsTra["C'Thun"]])){
									$this->user[$npcsTra["C'Thun"]] = array(1=>100006);
									$this->userById[100006] = array(1=>$npcsTra["C'Thun"]);
								}
							}
							// Extra Code for Majorhomo
							if ($this->in_array($sub, $npcsTra["Flamewaker Elite"]) || $this->in_array($sub, $npcsTra["Flamewaker Healer"]) || $this->in_array($sub, "Flamewaker Elite")){
								foreach($sub as $pk => $ok){
									$pk = $npcsTra["Majordomo Executus"];
									if (!isset($sub[$pk][1]) || $sub[$pk][1]>$ok[1])
										$sub[$pk][1] = $ok[1];
									if (!isset($sub[$pk][2]) || $sub[$pk][2]<$ok[2])
										$sub[$pk][2] = $ok[2];
								}
								$this->user[$npcsTra["Majordomo Executus"]] = array(1=>100000);
								$this->userById[100000] = array(1=>$npcsTra["Majordomo Executus"]);
							}
							// Extra code for the Bug Family
							if (($this->in_array($sub, $npcsTra["Lord Kri"]) && $this->in_array($sub, $npcsTra["Vem"]) && $this->in_array($sub, $npcsTra["Princess Yauj"])) || ($this->in_array($sub, "Lord Kri") && $this->in_array($sub, "Vem") && $this->in_array($sub, "Princess Yauj"))){
								foreach($sub as $pk => $ok){
									$pk = $npcsTra["The Bug Family"];
									if (!isset($sub[$pk][1]) || $sub[$pk][1]>$ok[1])
										$sub[$pk][1] = $ok[1];
									if (!isset($sub[$pk][2]) || $sub[$pk][2]<$ok[2])
										$sub[$pk][2] = $ok[2];
								}
								$this->user[$npcsTra["The Bug Family"]] = array(1=>100001);
								$this->userById[100001] = array(1=>$npcsTra["The Bug Family"]);
							}
							// Extra code for Twin Emps
							if (($this->in_array($sub, $npcsTra["Emperor Vek'lor"]) || $this->in_array($sub, $npcsTra["Emperor Vek'nilash"])) || ($this->in_array($sub, "Emperor Vek'lor") || $this->in_array($sub, "Emperor Vek'nilash"))){
								foreach($sub as $pk => $ok){
									$pk = $npcsTra["The Twin Emperors"];
									if (!isset($sub[$pk][1]) || $sub[$pk][1]>$ok[1])
										$sub[$pk][1] = $ok[1];
									if (!isset($sub[$pk][2]) || $sub[$pk][2]<$ok[2])
										$sub[$pk][2] = $ok[2];
								}
								$this->user[$npcsTra["The Twin Emperors"]] = array(1=>100002);
								$this->userById[100002] = array(1=>$npcsTra["The Twin Emperors"]);
							}
							// Extra code for Four Horsemen
							if (($this->in_array($sub, $npcsTra["Thane Korth'azz"]) && $this->in_array($sub, $npcsTra["Highlord Mograine"]) && $this->in_array($sub, $npcsTra["Lady Blaumeux"]) && $this->in_array($sub, $npcsTra["Sir Zeliek"])) || ($this->in_array($sub, "Thane Korth'azz") && $this->in_array($sub, "Highlord Mograine") && $this->in_array($sub, "Lady Blaumeux") && $this->in_array($sub, "Sir Zeliek"))){
								foreach($sub as $pk => $ok){
									$pk = $npcsTra["The Four Horsemen"];
									if (!isset($sub[$pk][1]) || $sub[$pk][1]>$ok[1])
										$sub[$pk][1] = $ok[1];
									if (!isset($sub[$pk][2]) || $sub[$pk][2]<$ok[2])
										$sub[$pk][2] = $ok[2];
								}
								$this->user[$npcsTra["The Four Horsemen"]] = array(1=>100003);
								$this->userById[100003] = array(1=>$npcsTra["The Four Horsemen"]);
							}
							
							// Extra code for General Rajaxx
							if ($this->in_array($sub, $npcsTra["General Rajaxx"])){
								foreach($sub as $pk => $ok){
									$pk = $npcsTra["General Rajaxx"];
									if (!isset($sub[$pk][1]) || $sub[$pk][1]>$ok[1])
										$sub[$pk][1] = $ok[1];
									if (!isset($sub[$pk][2]) || $sub[$pk][2]<$ok[2])
										$sub[$pk][2] = $ok[2];
								}
								if (!isset($this->user[$npcsTra["General Rajaxx"]])){
									$this->user[$npcsTra["General Rajaxx"]] = array(1=>100007);
									$this->userById[100007] = array(1=>$npcsTra["General Rajaxx"]);
								}
							}
							$bossend = 0;
							$bossname = "";
							foreach($sub as $pk => $ok){
								if ($ok){
									if ((isset($this->instanceBosses[$npcsTraRev[$pk]]) && !isset($GroupBoss[$npcsTraRev[$pk]])) or isset($bossToGroup[$npcsTraRev[$pk]])){
										if ($ok[2]>$bossend or $bossend == 0){
											$bossend = $ok[2];
											$bossname = (isset($bossToGroup[$npcsTraRev[$pk]])) ? $bossToGroup[$npcsTraRev[$pk]] : $pk; // Getting always the last
											//print $bossname." // ".$bossend."<br />";
										}
									}
								}
							}
							foreach($sub as $pk => $ok){
								if ($ok){
									if (!isset($this->instanceBosses[$npcsTraRev[$pk]])){
										if ($bossend==0)
											$sub[$pk][1] = $var[2];
									}
								}
							}
							if ($bossend>0 && $bossname != ""){
								// Boss Array
								$tname = array();
								$bossbeginn = $this->getBossBeginn($r = (isset($bossBeginnArray[$bossname])) ? $bossBeginnArray[$bossname] : array($this->user[$bossname][1]), $var[2]);
								$preBossTrash = array();
								$preBossBoss = null;
								foreach($sub as $pk => $ok){
									if (!isset($GroupBoss[$npcsTraRev[$pk]]) && $pk!="Unknown" && $pk!="Unbekannt"){
										if ($ok[1]>=$bossbeginn){
											if (!in_array($pk, $tname))
												array_push($tname, $pk);
										}else{
											if (!isset($this->instanceBosses[$pk]) && !isset($this->instanceBosses[$npcsTraRev[$pk]])){
												if (!in_array($pk, $preBossTrash))
													array_push($preBossTrash, $pk);
											}else{
												$preBossBoss = $pk;
											}
										}
									}
								}
								
								// Trash after boss death
								foreach($tname as $pk => $ok){
									$sub[$ok] = null;
								}
								$tname = array();
								foreach($sub as $pk => $ok){
									if ($pk == $bossname){
										$sub[$bossname] = null;
									}else{
										if (!in_array($pk, $tname))
											array_push($tname, $pk);
									}
								}
								$var[4] = $this->getLatestPointInSub($sub, $var[4]);
								if ($var[4]>$bossend && $tname[0]){
									array_push($this->attempts, Array(
										1 => $k,
										2 => $tname[0],
										3 => $bossend,
										4 => $var[3],
										5 => $var[4],
										6 => true,
										7 => ($var[4] - $bossend),
										9 => ($r = (isset($var[5]) && $var[5] === true) ? true : false), // wipe
										10 => $tname,
										11 => $key,
									));
								}
								
								if (!isset($GroupBoss[$npcsTraRev[$bossname]])){
									if (!in_array($bossname, $tname))
										array_push($tname, $bossname);
								}
								
								$bypass = false;
								foreach($this->attempts as $uu){
									if ($uu[2]==$bossname && $bossname != "Majordomo Executus" && $bossname != $npcsTra["Majordomo Executus"]){
										$bypass = true;
										break 1;
									}										
								}
								
								if (($bossend - $bossbeginn)>5){
									$bossInArray = false;
									foreach($var[6] as $qqqv){
										if ($qqqv[2]==$bossname or (isset($bossToGroup[$npcsTraRev[$qqqv[2]]]) && $bossToGroup[$npcsTraRev[$qqqv[2]]] == $bossname)){
											$bossInArray = true;
											break 1;
										}
									}
									array_push($this->attempts, Array(
										1 => $k,
										2 => $bossname,
										3 => $bossbeginn,
										4 => $var[3],
										5 => $bossend,
										6 => true,
										7 => ($bossend - $bossbeginn),
										9 => ($r = ((isset($var[5]) && $var[5] === true && !$bossInArray) or $bypass or (isset($var[5]) && $var[5] === false && !$bossInArray)) ? true : false), // wipe
										10 => $tname,
										11 => $key
									));
								}
									
								if (isset($preBossTrash[0]) or $preBossBoss){
									array_push($this->attempts, Array(
										1 => $k,
										2 => $preBossTrash[0],
										3 => $var[2],
										4 => $var[3],
										5 => $bossbeginn,
										6 => true,
										7 => ($bossbeginn - $var[2]),
										9 => false, // wipe
										10 => $preBossTrash,
										11 => $key
									));
								}
								
							}else{
								$var[4] = $this->getLatestPointInSub($sub, $var[4]);
								// Some extra code for wipes at group bosses
								// Bugfamily
								$tempBool = false;
								if (in_array($var[1], array($npcsTra["Lord Kri"], $npcsTra["Vem"], $npcsTra["Princess Yauj"], "Lord Kri", "Vem", "Princess Yauj"))){
									$namees = array();
									foreach($sub as $pk => $ok){
										if (!in_array($pk, $namees))
											array_push($namees, $pk);
									}
									if (!in_array($npcsTra["Lord Kri"], $namees))
										array_push($namees, $npcsTra["Lord Kri"]);
									if (!in_array($npcsTra["Vem"], $namees))
										array_push($namees, $npcsTra["Vem"]);
									if (!in_array($npcsTra["Princess Yauj"], $namees))
										array_push($namees, $npcsTra["Princess Yauj"]);
									if (!in_array($npcsTra["Lord Kri"], $namees))
										array_push($namees, "Lord Kri");
									if (!in_array("Vem", $namees))
										array_push($namees, "Vem");
									if (!in_array("Princess Yauj", $namees))
										array_push($namees, "Princess Yauj");
									$this->user[$npcsTra["The Bug Family"]] = array(1=>100001);
									$this->userById[100001] = array(1=>$npcsTra["The Bug Family"]);
									array_push($this->attempts, Array(
										1 => $k,
										2 => $npcsTra["The Bug Family"],
										3 => $var[2],
										4 => $var[3],
										5 => $var[4],
										6 => true,
										7 => ($var[4] - $var[2]),
										9 => true, // wipe
										10 => $namees, 
										11 => $key,
									));
									$tempBool = true;
								}
								// Twin Emps
								if (in_array($var[1], array($npcsTra["Emperor Vek'lor"], $npcsTra["Emperor Vek'nilash"], "Emperor Vek'lor", "Emperor Vek'nilash"))){
									$namees = array();
									foreach($sub as $pk => $ok){
										if (!in_array($pk, $namees))
											array_push($namees, $pk);
									}
									if (!in_array($npcsTra["Emperor Vek'lor"], $namees))
										array_push($namees, $npcsTra["Emperor Vek'lor"]);
									if (!in_array($npcsTra["Emperor Vek'nilash"], $namees))
										array_push($namees, $npcsTra["Emperor Vek'nilash"]);
									if (!in_array("Emperor Vek'lor", $namees))
										array_push($namees, "Emperor Vek'lor");
									if (!in_array("Emperor Vek'nilash", $namees))
										array_push($namees, "Emperor Vek'nilash");
									$this->user[$npcsTra["The Twin Emperors"]] = array(1=>100002);
									$this->userById[100002] = array(1=>$npcsTra["The Twin Emperors"]);
									array_push($this->attempts, Array(
										1 => $k,
										2 => $npcsTra["The Twin Emperors"],
										3 => $var[2],
										4 => $var[3],
										5 => $var[4],
										6 => true,
										7 => ($var[4] - $var[2]),
										9 => true, // wipe
										10 => $namees, 
										11 => $key,
									));
									$tempBool = true;
								}
								// Four Horsemen
								if (in_array($var[1], array($npcsTra["Thane Korth'azz"], $npcsTra["Highlord Mograine"], $npcsTra["Lady Blaumeux"], $npcsTra["Sir Zeliek"], "Thane Korth'azz", "Highlord Mograine", "Lady Blaumeux", "Sir Zeliek"))){
									$namees = array();
									foreach($sub as $pk => $ok){
										if (!in_array($pk, $namees))
											array_push($namees, $pk);
									}
									if (!in_array($npcsTra["Thane Korth'azz"], $namees))
										array_push($namees, $npcsTra["Thane Korth'azz"]);
									if (!in_array($npcsTra["Highlord Mograine"], $namees))
										array_push($namees, $npcsTra["Highlord Mograine"]);
									if (!in_array($npcsTra["Lady Blaumeux"], $namees))
										array_push($namees, $npcsTra["Lady Blaumeux"]);
									if (!in_array($npcsTra["Sir Zeliek"], $namees))
										array_push($namees, $npcsTra["Sir Zeliek"]);
									if (!in_array("Thane Korth'azz", $namees))
										array_push($namees, "Thane Korth'azz");
									if (!in_array("Highlord Mograine", $namees))
										array_push($namees, "Highlord Mograine");
									if (!in_array("Lady Blaumeux", $namees))
										array_push($namees, "Lady Blaumeux");
									if (!in_array("Sir Zeliek", $namees))
										array_push($namees, "Sir Zeliek");
									$this->user[$npcsTra["The Four Horsemen"]] = array(1=>100003);
									$this->userById[100003] = array(1=>$npcsTra["The Four Horsemen"]);
									array_push($this->attempts, Array(
										1 => $k,
										2 => $npcsTra["The Four Horsemen"],
										3 => $var[2],
										4 => $var[3],
										5 => $var[4],
										6 => true,
										7 => ($var[4] - $var[2]),
										9 => true, // wipe
										10 => $namees, 
										11 => $key,
									));
									$tempBool = true;
								}
								// C'Thun
								if (in_array($var[1], array($npcsTra["Claw Tentacle"], $npcsTra["Eye Tentacle"], $npcsTra["Eye of C'Thun"], $npcsTra["Giant Claw Tentacle"], $npcsTra["Giant Eye Tentacle"], "Claw Tentacle", "Eye Tentacle", "Eye of C'Thun", "Giant Claw Tentacle", "Giant Eye Tentacle"))){
									$namees = array();
									foreach($sub as $pk => $ok){
										if (!in_array($pk, $namees))
											array_push($namees, $pk);
									}
									if (!in_array($npcsTra["Claw Tentacle"], $namees))
										array_push($namees, $npcsTra["Claw Tentacle"]);
									if (!in_array($npcsTra["Eye Tentacle"], $namees))
										array_push($namees, $npcsTra["Eye Tentacle"]);
									if (!in_array($npcsTra["Eye of C'Thun"], $namees))
										array_push($namees, $npcsTra["Eye of C'Thun"]);
									if (!in_array($npcsTra["Giant Claw Tentacle"], $namees))
										array_push($namees, $npcsTra["Giant Claw Tentacle"]);
									if (!in_array("Claw Tentacle", $namees))
										array_push($namees, "Claw Tentacle");
									if (!in_array("Eye Tentacle", $namees))
										array_push($namees, "Eye Tentacle");
									if (!in_array("Eye Tentacle", $namees))
										array_push($namees, "Eye Tentacle");
									if (!in_array("Giant Claw Tentacle", $namees))
										array_push($namees, "Giant Claw Tentacle");
									$this->user[$npcsTra["C'Thun"]] = array(1=>100006);
									$this->userById[100006] = array(1=>$npcsTra["C'Thun"]);
									array_push($this->attempts, Array(
										1 => $k,
										2 => $npcsTra["C'Thun"],
										3 => $var[2],
										4 => $var[3],
										5 => $var[4],
										6 => true,
										7 => ($var[4] - $var[2]),
										9 => true, // wipe
										10 => $namees, 
										11 => $key,
									));
									$tempBool = true;
								}
								
								// General Rajaxx
								if (in_array($var[1], array($npcsTra["General Rajaxx"]))){
									$namees = array();
									foreach($sub as $pk => $ok){
										if (!in_array($pk, $namees))
											array_push($namees, $pk);
									}
									if (!in_array($npcsTra["General Rajaxx"], $namees))
										array_push($namees, $npcsTra["General Rajaxx"]);
									$this->user[$npcsTra["General Rajaxx"]] = array(1=>100006);
									$this->userById[100006] = array(1=>$npcsTra["General Rajaxx"]);
									array_push($this->attempts, Array(
										1 => $k,
										2 => $npcsTra["General Rajaxx"],
										3 => $var[2],
										4 => $var[3],
										5 => $var[4],
										6 => true,
										7 => ($var[4] - $var[2]),
										9 => true, // wipe
										10 => $namees, 
										11 => $key,
									));
									$tempBool = true;
								}
								
								if (!$tempBool){
									if ($var[1]=="Unknown" or $var[1]=="Unbekannt"){
										foreach($sub as $pk => $ok){
											$var[1]=$pk;
										}
									}
									if (isset($this->instanceBosses[$npcsTraRev[$var[1]]]))
										$bossbeginn = $this->getBossBeginn($r = (isset($bossBeginnArray[$var[1]])) ? $bossBeginnArray[$var[1]] : array($this->user[$var[1]][1]), $var[2]);
									else
										$bossbeginn = $var[2];
									$namees = array();
									foreach($sub as $pk => $ok){
										if (!isset($GroupBoss[$npcsTraRev[$pk]]) && $pk!="Unknown" && $pk!="Unbekannt"){
											if (!in_array($pk, $namees))
												array_push($namees, $pk);
										}
									}
									if (!isset($GroupBoss[$npcsTraRev[$var[1]]]) && $var[1]!="Unknown" && $var[1]!="Unbekannt"){
										if (!in_array($var[1], $namees))
											array_push($namees, $var[1]);
									}
									$bypass = false;
									if (isset($this->instanceBosses[$npcsTraRev[$var[1]]])){
										foreach($this->attempts as $ke => $va){
											if ($va[2]==$var[1]){
												$bypass = true;
												break 1;
											}
										}
										foreach($namees as $qqqv){
											if ($qqqv==$var[1] or (isset($bossToGroup[$npcsTraRev[$qqqv]]) && $bossToGroup[$npcsTraRev[$qqqv]] == $var[1]) or $qqqv==$npcsTraRev[$var[1]]){
												$bypass = true;
												break 1;
											}
										}
										if (sizeOf($namees)==0)
											$bypass = true;
									}
									array_push($this->attempts, Array(
										1 => $k,
										2 => $var[1],
										3 => $bossbeginn,
										4 => $var[3],
										5 => $var[4],
										6 => true,
										7 => ($var[4] - $bossbeginn),
										9 => ($r = ((isset($var[5]) && $var[5] === true) or $bypass) ? true : false), // wipe
										10 => $namees, 
										11 => $key,
									));
								}
							}
						}else{
							if ($var[2]==1){
								foreach($var[6] as $pk => $ok){
									if (!in_array($ok[2], $unknownArr))
										array_push($unknownArr, $ok[2]);
								}
								$unTime = $var[3];
							}
						}
					}
					if (isset($unknownArr[0])){
						array_push($this->attempts, Array(
							1 => $k,
							2 => "Unknown",
							3 => 0,
							4 => $unTime,
							5 => 0,
							6 => true,
							7 => 1,
							9 => false, // wipe
							10 => $unknownArr, 
							11 => $key,
						));
					}
				}
			}
		}
	}
	
	private function sortAttemptsToNpc(){
		foreach($this->attempts as $k => $v){
			if (isset($v[2])){
				$this->attemptsWithNpcId[$k] = $v;
				$q = $this->db->query('SELECT id, type FROM npcs WHERE name = "'.$v[2].'" or deDE = "'.$v[2].'" or frFR = "'.$v[2].'" or ruRU = "'.$v[2].'" or zhCN = "'.$v[2].'"')->fetch();
				if (isset($q->id)){
					$this->attemptsWithNpcId[$k][2] = $q->id;
					$this->attemptsWithNpcId[$k][8] = $q->type; // 1 => Boss
				}else{
					print "NOT FOUND => ".$v[2]."<br />";
				}
			}
		}
	}
	
	private $resetByServer = array(
		0 => "Wednesday",
		1 => "Wednesday",
		2 => "Wednesday",
		3 => "Friday",
		4 => "Wednesday",
		5 => "Wednesday",
		6 => "Wednesday",
		7 => "Wednesday",
		8 => "Wednesday",
		9 => "Wednesday",
		10 => "Wednesday",
		11 => "Wednesday",
		12 => "Wednesday",
		13 => "Wednesday",
		14 => "Wednesday"
	);
	private $lastOnyReset = array(
		0 => 1464915600,
		1 => 1464915600,
		2 => 1464915600,
		3 => 1464829200,
		4 => 1464915600,
		5 => 1464915600,
		6 => 1464915600,
		7 => 1464915600,
		8 => 1464915600,
		9 => 1464915600,
		10 => 1464915600,
		11 => 1464915600,
		12 => 1464915600,
		13 => 1464915600,
		14 => 1464915600
	);
	private $lastZgAqReset = array(
		0 => 1464742800,
		1 => 1464742800,
		2 => 1464742800,
		3 => 1464829200,
		4 => 1464742800,
		5 => 1464742800,
		6 => 1464742800,
		7 => 1464742800,
		8 => 1464742800,
		9 => 1464742800,
		10 => 1464742800,
		11 => 1464742800,
		12 => 1464742800,
		13 => 1464742800,
		14 => 1464742800
	);
	
	private function getLastReset($raidnameid, $serverid){
		if ($raidnameid == 2){
			$days = floor(((time()-$this->lastOnyReset[$serverid])/86400)/3)*3;
			return date("l", $this->lastOnyReset[$serverid]+$days*86400);
		}elseif ($raidnameid == 5 or $raidnameid == 4){
			$days = floor(((time()-$this->lastZgAqReset[$serverid])/86400)/3)*3;
			return date("l", $this->lastZgAqReset[$serverid]+$days*86400);
		}else{
			return $this->resetByServer[$serverid];
		}
	}
	
	private function returnStartTimeStamp($raidnameid, $serverid, $end){
		if (date("l") == $this->getLastReset($raidnameid, $serverid) && strtotime("today 03:00:00")<=$end){
			return strtotime("today 03:00:00");
		}
		if (($end-strtotime("last ".$this->getLastReset($raidnameid, $serverid)))>=50000){
			return $end-50000; // Preventing uploads that cause to corrupt the logs
		}else{
			return strtotime("last ".$this->getLastReset($raidnameid, $serverid));
		}
	}
	
	private function isNewLog($raidnameid, $end, $participants, $serverid){
		// If today were wednesday. What would last wednesday be? This or literally last wednesday?
		$now = time();
		if ($this->db->query('SELECT * FROM `v-raids` WHERE nameid = "'.$raidnameid.'" AND tsstart BETWEEN "'.$this->returnStartTimeStamp($raidnameid, $serverid, $end).'" AND "'.$end.'"')->rowCount() > 0){
			//print "Test";
			foreach($this->db->query('SELECT a.id as rid, b.tanks, b.dps, b.healers FROM `v-raids` a LEFT JOIN `v-raids-participants` b ON a.id = b.rid WHERE nameid = "'.$raidnameid.'" AND tsstart BETWEEN "'.$this->returnStartTimeStamp($raidnameid, $serverid, $end).'" AND "'.$end.'"') as $row){
				$arr = explode(",", $row->tanks.$row->dps.$row->healers);
				$attempts = array();
				$attemptsWithIds = array();
				$extraTime = $this->getExtraTime($row->rid, null, $raidnameid);
				foreach($this->db->query('SELECT a.id,a.npcid,a.cbtend,a.rid,a.cbt,a.type,c.type,b.nameid,c.type as boss,a.time FROM `v-raids-attempts` a LEFT JOIN `v-raids` b ON a.rid = b.id LEFT JOIN npcs c ON a.npcid = c.id WHERE a.rid = '.$row->rid) as $q){
					// Getting the next attempt id judging by npcid and combat time
					$aid = 0; $lastCBT = -1;
					foreach($this->attemptsWithNpcId as $k => $v){ // attempt id // array(1=>Instance, 2=>npcid,3=>bossbeginn,4=>TimeString,5=>cbtent,6=>wipe?,7=>duration,8=>isBoss?,9=>wipe?,10=>namearr);
						if ($v[2]==$q->npcid){
							$tsss = $this->GetRealTS(strtotime($v[4]), $now);
							if (($lastCBT == -1 || abs($tsss-$q->time)<=$lastCBT)){
								$aid = $k;
								$lastCBT = abs($tsss-$q->time);
							}
						}
					}
					
					if ($lastCBT != -1 && $lastCBT<=300){
						$attempts[$aid] = $q->id;
						$attemptsWithIds[$aid] = Array(
							1 => $q->id,
							2 => $q->rid,
							3 => $q->npcid,
							4 => $q->cbt+$extraTime,
							5 => $q->cbtend+$extraTime,
							6 => $q->type,
							7 => $q->boss,
							8 => $q->nameid,
							9 => date("H:i", $q->time)
						);
					}
				}
				$count = 0;
				foreach($participants as $k => $v){
					if ($v && $v != ""){
						if (in_array($v, $arr)){
							$count += 1;
						}
						if ($count >= 20){
							return array(1 => $row->rid, 2=> $attempts, 3 => $attemptsWithIds);
						}
					}
				}
			}
		}
		return array(1 => 0, 2 => array(), 3 => array());
	}
	
	private function getGuild(){
		$num = 0;
		$t = array();
		foreach($this->participantKeys as $k => $v){
			if (isset($this->userById[$v][7])){
				if ($this->userById[$v][7] != "" && $this->userById[$v][7] != " "){
					$name = $this->userById[$v][7];
					if (!isset($t[$name]))
						$t[$name] = 0;
					$t[$name] += 1;
				}
				$num++;
			}
		}
		foreach($t as $k => $v){
			if ($k){
				if ($v>floor($num*0.7))
					return $k;
			}
		}
		return "PugRaid";
	}
	
	private function getServerId(){
		$id = $this->db->query('SELECT id FROM servernames WHERE expansion=0 AND name = "'.$this->pinfo[4].'"')->fetch()->id;
		if ($this->pinfo[4] == "Warsong 1.12.1 [8x] Blizzlike")
			$id = 8;
		if ($this->pinfo[4] == "Zeth'Kur")
			$id = 39;
		if ($this->pinfo[4] == "Zeth'Dare")
			$id = 36;
		if ($this->pinfo[4] == "NostalGeek 1.12")
			$id = 7;
		if (!$id)
			$id = 1;
		return $id;
	}
	
	private function getTimeStamp($v1, $v2){
		$const = time() + 43200;
		$time = strtotime($v1);
		$t2 = strtotime($v2);
		if ($const<$time)
			$time = strtotime("yesterday ".$v1);
		if ($const<$t2)
			$t2 = strtotime("yesterday ".$v2);
		if ($time>$t2)
			$t2 = strtotime($v2);
		return array(1 => $time, 2 => $t2);
	}
	
	private function GetRealTS($ts, $now){
		if ($ts>$now)
			return strtotime("yesterday ".date("H:i:s", $ts));
		return $ts;
	}
	
	private function getTses($kk, $serverid, $now, $tries){
		$min = null; $max = null;
		$atmtsize = sizeOf($this->atmt[$kk]);
		if ($atmtsize==1 || $tries > 30){
			$min = $this->GetRealTS(strtotime($this->atmt[$kk][1][3]), $now);
			$max = $min + $this->cbt["total"];
			return array(1 => ceil($min), 2 => ceil($max));
		}
		
		$min = $this->GetRealTS(strtotime($this->atmt[$kk][$atmtsize][3]), $now);
		$max = $this->GetRealTS(strtotime($this->atmt[$kk][1][3])+($this->atmt[$kk][1][4]-$this->atmt[$kk][1][2]), $now);
		if (abs($max-$min)>37000){
			// Case 1: min>max
			if ($min>$max)
				$max += 86400;
			// Case 2: One of them is in the future
			if (($min>$now || $max>$now) && ($now-time())<=86400)
				return $this->getTses($kk, $serverid, $now+600, $tries + 1);
			// something went wrong
			if (abs($max-$min)>37000)
				return array(1 => ceil($min), 2 => ceil($min + $this->cbt["total"]));
		}
		return array(1 => ceil($min), 2 => ceil($max));
	}
	
	private function getAttemptIdByCBTTime($cbt, $attemptsWithDbId, $npcs, $npcsRevTra){
		$last = 0;
		$delta = null;
		foreach($attemptsWithDbId as $k => $v){
			if (isset($this->instanceBosses[$npcsRevTra[$npcs[$v[3]]]]) && $v[11]===false){
				if (!$delta || $delta>abs($v[5]-$cbt+10)){
					$last = $v[1];
					$delta = abs($v[5]-$cbt+10);
				}
			}
		}
		return $last;
	}
	
	private function getLootArray($attempts, $npcs, $npcsRevTra){
		$t = array();
		foreach($this->loot as $k => $v){
			foreach($v as $ke => $va){
				$key = $this->getAttemptIdByCBTTime($va[1], $attempts, $npcs, $npcsRevTra);
				if ($key != 0){
					if (!isset($t[$key]))
						$t[$key] = array();
					array_push($t[$key], array(1 => $va[2], 2 => $this->user[$va[4]][1]));
				}
			}
		}
		return $t;
	}
	
	private $QQraidBosses = array(
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
			50002 => true,
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
		)
	);
	
	private $extraTimeArray = array();
	private function getExtraTime($isMerge, $nameid, $othernameid){
		if (isset($this->extraTimeArray[$isMerge][$othernameid])){
			return $this->extraTimeArray[$isMerge][$othernameid];
		}elseif (isset($this->extraTimeArray[$isMerge][$nameid])){
			return $this->extraTimeArray[$isMerge][$nameid];
		}else{
			$extraTime = 0;
			// Gettings first boss id
			$firstBoss = 0; $fbTime = 0; $fbId = 0;
			foreach($this->attemptsWithNpcId as $k => $v){
				if (($fbTime == 0 or $fbTime>$v[3]) && $v[8] == 1){
					$fbTime = $v[3];
					$firstBoss = $v[2];
					$fbId = $k;
				}
			}
			// Checking if he already exists
			if ($firstBoss != 0 && $isMerge){
				$q = $this->db->query('SELECT cbt FROM `v-raids-attempts` WHERE npcid = "'.$firstBoss.'" AND rid = "'.$isMerge.'" AND rdy = 1 ORDER BY cbt DESC LIMIT 1')->fetch();
				// If it exists what is the difference
				// If it does not exist what is the last killed boss then in the db?
				if (isset($q->cbt)){
					if (abs($q->cbt-$fbTime)>=20)
						$extraTime = abs($q->cbt-$fbTime) + 20;
				}else{
					// Gettings last killed boss
					$qq = $this->db->query('SELECT a.cbt, b.name, a.npcid FROM `v-raids-attempts` a LEFT JOIN npcs b ON a.npcid = b.id WHERE a.rid = "'.$isMerge.'" AND b.type = 1 AND a.rdy = 1 ORDER BY a.cbt DESC LIMIT 1')->fetch();
					if (isset($qq->cbt)){
						// Check if the boss is before or after the first boss
						if (!isset($nameid)){
							$offset = array_search($firstBoss, array_keys($this->QQraidBosses[$othernameid]));
							$offset2 = array_search($qq->npcid, array_keys($this->QQraidBosses[$othernameid]));							
						}else{
							$offset = array_search($firstBoss, array_keys($this->QQraidBosses[$nameid[$fbId][8]]));
							$offset2 = array_search($qq->npcid, array_keys($this->QQraidBosses[$nameid[$fbId][8]]));
						}
						if ($offset>$offset2){
							if (abs($qq->cbt-$fbTime)>=20)
								$extraTime = abs($qq->cbt-$fbTime) + 20;
						}
					}
				}
			}
			if ($isMerge){
				if (!isset($nameid)){
					$this->extraTimeArray[$isMerge][$othernameid] = $extraTime;
				}else{
					$this->extraTimeArray[$isMerge][$nameid] = $extraTime;
				}
			}
			return $extraTime;
		}
	}
	
	private function BossesAreBefore($nameid, $isMerge, $othernameid, $lastboss){
		if (isset($nameid) or isset($othernameid)){
			$qq = $this->db->query('SELECT a.cbt, b.name, a.npcid FROM `v-raids-attempts` a LEFT JOIN npcs b ON a.npcid = b.id WHERE a.rid = "'.$isMerge.'" AND b.type = 1 AND a.rdy = 1 ORDER BY a.cbt LIMIT 1')->fetch();
			//$LB = $this->db->query('SELECT name FROM npcs WHERE id = '.$lastboss)->fetch()->name;
			if (!isset($nameid)){
				$offset = array_search($lastboss, array_keys($this->QQraidBosses[$othernameid]));
				$offset2 = array_search($qq->npcid, array_keys($this->QQraidBosses[$othernameid]));							
			}else{
				$offset = array_search($lastboss, array_keys($this->QQraidBosses[$nameid]));
				$offset2 = array_search($qq->npcid, array_keys($this->QQraidBosses[$nameid]));
			}
			if ($offset<$offset2){
				return true;
			}
		}
		return false;
	}
	
	// Have to find a point to add to
	// i.E: If Boss A-C has been uploaded and then D-Z with a new reset it has to add on to it
	private $alreadyUpdatedNameIds = array();
	private function getGraphStrings($arr, $isMerge, $nameid, $othernameid){
		$newArr = array();
		$raidsById = array(
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
			13 => "Hinterlands"
		);
		$extraTime = $this->getExtraTime($isMerge, $nameid, $othernameid);
		if ($isMerge){
			// Exception if bosses are added before the first boss. Increase the time of the existing logs based on max time of added log.
			// i.E. Second half was uploaded and first half is being merged.
			// Update those only once!
			if (!isset($this->alreadyUpdatedNameIds[$isMerge])){
				$lastboss = 0; $beforeTime = 0;
				foreach($this->attemptsWithNpcId as $k => $v){
					if ($v[8]==1){
						$lastboss = $v[2];
						$beforeTime = $v[5];
						break 1;
					}
				}
				if ($lastboss>0){
					if ($this->BossesAreBefore($nameid, $isMerge, $othernameid, $lastboss)){
						// Update those graphes now
						$cbtstart = array();
						$cbtend = array();
						$rnid = (isset($nameid)) ? $raidsById[$nameid] : $raidsById[$othernameid];
						foreach($this->db->query('SELECT a.* FROM `v-raids-graph-individual-dmgdone` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE b.rid = '.$isMerge) as $row){
							$t1 = explode(",", $row->time);
							$newTimeString = '';
							foreach($t1 as $qqq => $kkk){
								if (isset($kkk) && $kkk != ''){
									if (!isset($cbtstart[$row->attemptid]) or $cbtstart[$row->attemptid]>(intval($kkk)+$beforeTime))
										$cbtstart[$row->attemptid] = (intval($kkk)+$beforeTime-$this->instanceStart[$rnid]);
									if (!isset($cbtend[$row->attemptid]) or $cbtend[$row->attemptid]<(intval($kkk)+$beforeTime))
										$cbtend[$row->attemptid] = (intval($kkk)+$beforeTime-$this->instanceStart[$rnid]);
									$newTimeString .= (intval($kkk)+$beforeTime-$this->instanceStart[$rnid]).',';
								}else{
									$newTimeString .= ',';
								}
							}
							$this->db->query('UPDATE `v-raids-graph-individual-dmgdone` SET time = "'.$newTimeString.'" WHERE id = '.$row->id);
						}
						foreach($this->db->query('SELECT a.* FROM `v-raids-graph-individual-dmgtaken` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE b.rid = '.$isMerge) as $row){
							$t1 = explode(",", $row->time);
							$newTimeString = '';
							foreach($t1 as $qqq => $kkk){
								if (isset($kkk) && $kkk != ''){
									$newTimeString .= (intval($kkk)+$beforeTime-$this->instanceStart[$rnid]).',';
								}else{
									$newTimeString .= ',';
								}
							}
							$this->db->query('UPDATE `v-raids-graph-individual-dmgtaken` SET time = "'.$newTimeString.'" WHERE id = '.$row->id);
						}
						foreach($this->db->query('SELECT a.* FROM `v-raids-graph-individual-healingreceived` a LEFT JOIN `v-raids-attempts` b ON a.attemptid = b.id WHERE b.rid = '.$isMerge) as $row){
							$t1 = explode(",", $row->time);
							$newTimeString = '';
							foreach($t1 as $qqq => $kkk){
								if (isset($kkk) && $kkk != ''){
									$newTimeString .= (intval($kkk)+$beforeTime-$this->instanceStart[$rnid]).',';
								}else{
									$newTimeString .= ',';
								}
							}
							$this->db->query('UPDATE `v-raids-graph-individual-healingreceived` SET time = "'.$newTimeString.'" WHERE id = '.$row->id);
						}
						foreach($cbtstart as $k => $v){
							$this->db->query('UPDATE `v-raids-attempts` SET cbt = "'.$v.'", cbtend = "'.$cbtend[$k].'", duration = "'.($cbtend[$k]-$v).'" WHERE id = '.$k);
						}
						$this->alreadyUpdatedNameIds[$isMerge] = true;
					}
				}
			}
			if ($extraTime > 0){
				$rnid = (isset($nameid)) ? $raidsById[$nameid] : $raidsById[$othernameid];
				foreach($arr as $k => $v){
					foreach($v as $key => $var){
						$newArr[$k][$key+$extraTime-$this->instanceStart[$rnid]] = $var;
					}
				}
			}
		}
		if (!empty($newArr)){
			$u = $newArr;
		}else{
			$u = $arr;
		}
		
		$t = array();
		foreach($u as $k => $v){
			$num = sizeOf($v);
			$coeff = floor($num/100);
			if ($coeff >= 2){
				$ltime = 0; $lam = 0; $i = 0;
				foreach($v as $key => $var){
					if ($i == $coeff){
						$t[$k][$ltime] = $lam;
						$ltime = 0; $lam = 0; $i = 0;
					}else{
						if ($ltime == 0)
							$ltime = $key;
						else
							$ltime = ($ltime+$key)/2;
						$lam += $var;
						$i++;
					}
					
				}
			}else{
				$t[$k] = $v;
			}
			if (isset($t[$k]))
				ksort($t[$k]);
		}
		
		$p = array();
		if (isset($t)){
			foreach($t as $k => $v){
				if (isset($v)){
					foreach($v as $key => $var){
						$ptime = $key;
						$instance = $this->getInstanceId($key);
						$istartCBT = $this->instanceStart[$instance];
						if ($isMerge && $extraTime==0)
							$istartCBT = 0;
						if (($key-$istartCBT)>=0){
							$ptime = $key-$istartCBT;
						}
						if (!isset($p[$k])){
							$p[$k] = array(1=>round($ptime, 2),2=>round($var, 2));
						}else{
							$p[$k][1] .= ",".round($ptime, 2);
							$p[$k][2] .= ",".round($var, 2);
						}
					}
				}
			}
		}
		return $p;
	}
	
	
	// Have to find a common point and start from there on
	private function mergeGraphs($q, $v){
		$oldTimes = explode(",", $q->time);
		$oldAmounts = explode(",", $q->amount);
		$newTimes = explode(",", $v[1]);
		$newAmounts = explode(",", $v[2]);
		
		$old = array();
		foreach($oldTimes as $k => $v){
			$old[$v] = $oldAmounts[$k];
		}
		ksort($old);
		
		foreach($old as $k => $v){
			foreach ($newTimes as $key => $var){
				if (($k+0.5)>=$var && ($k-0.5)<=$var){
					$old[$k] = ($old[$k]+$newAmounts[$key])/2;
				}
			}
		}
		$timesString = ""; $amountsString = "";
		foreach ($old as $k => $v){
			$timesString .= $k.",";
			$amountsString .= $v.",";
		}
		return array(1=>$timesString, 2=>$amountsString);
	}
	
	// $bosses => list of bosses
	// 0 => amount, counted towards 0, 1 => timeList, 2 => min dmg done to this group
	// timeframe to kill the rest after first mob died
	// -1 whole attempt
	// $except => list of exceptions
	// $extra => list of bosses that have to be killed not depending on conditions
	private function npcsKilledInTime($attemptsWithDbId, $npcRevTra, $bosses, $timeframe, $except, $extra){
		$renew = $bosses;
		foreach($this->atmt as $pkey => $pvar){ // instance name
			foreach($pvar as $ke => $va){ // attempt key
				if (isset($va[6])){
					$bosses = $renew;
					$cont = false;
					foreach($va[6] as $k => $v){ // every kill within the attempt
						$dmgToCheck = -1; $name = "";
						if (isset($bosses[$npcRevTra[$v[2]]])){
							$bosses[$npcRevTra[$v[2]]][0]--;
							array_push($bosses[$npcRevTra[$v[2]]][1], $v[1]);
							$dmgToCheck = $bosses[$npcRevTra[$v[2]]][2];
							$name = $npcRevTra[$v[2]];
						}elseif (isset($bosses[$v[2]])){
							$bosses[$v[2]][0]--;
							array_push($bosses[$v[2]][1], $v[1]);
							$dmgToCheck = $bosses[$v[2]][2];
							$name = $v[2];
						}
						if (isset($except[$npcRevTra[$v[2]]]) || isset($except[$v[2]]))
							$cont = true;
						if (isset($extra[$npcRevTra[$v[2]]])){
							$extra[$npcRevTra[$v[2]]] = true;
						}elseif(isset($extra[$v[2]])){
							$extra[$v[2]] = true;
						}
						if ($dmgToCheck>0){ // If required check if the group of enemys received this damage in this attempt
							if ($name != "" && isset($this->user[$name])){
								// Getting a list of attempts to check
								$attempts = array();
								foreach($attemptsWithDbId as $qqke => $qqva){
									if ($qqva[12]==$ke)
										array_push($attempts, $qqke);
								}
								foreach($attempts as $qqva){ // qqva => internal attemptid
									$accDmg = 0;
									if (isset($this->individualDmgDoneToEnemy[$qqva][$this->user[$name][1]])){
										foreach($this->individualDmgDoneToEnemy[$qqva][$this->user[$name][1]] as $user){
											$accDmg += $user[1];
										}
									}
								}
								if ($dmgToCheck<=$accDmg)
									$cont=true;
							}
						}
					}
					$minTime = 0; $maxTime = -1;
					if ($timeframe>0){
						foreach($bosses as $var){
							for ($i=abs($var[0])+1; $i<=sizeOf($var[1]); $i++){
								if ($minTime==0 || $minTime>$var[1][$i])
									$minTime=$var[1][$i];
								if ($maxTime<$var[1][$i])
									$maxTime=$var[1][$i];
							}
						}
					}
					foreach($bosses as $var){
						if (!$var[0]>0)
							$cont = true;
					}
					foreach($extra as $var){
						if (!$var)
							$cont = true;
					}
					if ($cont || $timeframe>($maxTime-$minTime))
						continue;
					$attemptid = 0; // attempting to get the last recorded attemptid of this kind
					foreach($attemptsWithDbId as $qvar){
						if ($qvar[12] == $ke)
							$attemptid = $qvar[1];
					}
					return $attemptid; // I'd rather have the attempt id returned
				}
			}
		}
		return false;
	}
	
	/*
	* $abilities => String -> Int
	* $bosses => String -> Boolean
	*
	* individualDmgTakenByAbility[attemptid][charid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => block, 6 => crit, 7 => miss, 8 => parry, 9 => dodge, 10 => resist, 11 => crush);
	*/
	private function takeDmgByAbilityAndKillBoss($npcRevTra, $attemptsWithDbId, $spellTra, $bosses, $abilities){
		$renew = $bosses; $renewAb = $abilities;
		foreach($this->atmt as $pkey => $pvar){ // instance name
			foreach($pvar as $ke => $va){ // attempt key
				if (isset($va[6])){
					$bosses = $renew;
					$abilities = $renewAb;
					$cont = false;
					foreach($va[6] as $k => $v){ // every kill within the attempt
						if (isset($bosses[$npcRevTra[$v[2]]])){
							$bosses[$npcRevTra[$v[2]]] = true;
						}elseif (isset($bosses[$v[2]])){
							$bosses[$v[2]] = true;
						}
					}
					$attempts = array();
					foreach($attemptsWithDbId as $qqke => $qqva){
						if ($qqva[12]==$ke)
							array_push($attempts, $qqke);
					}
					foreach ($attempts as $qvar){
						foreach($this->individualDmgTakenByAbility[$qvar] as $qva){
							foreach ($abilities as $abname => $abamount){
								if (isset($this->abilities[$abname]) && isset($qva[$abname])){
									$abilities[$abname] -= $qva[$this->abilities[$abname][1]][4];
								}elseif (isset($this->abilities[$spellTra[$abname]]) && isset($qva[$spellTra[$abname]])){
									$abilities[$abname] -= $qva[$this->abilities[$spellTra[$abname]][1]][4];
								}
							}
						}
					}
					foreach($abilities as $num){
						if ($num>0)
							$cont = true;
					}
					foreach($bosses as $bool){
						if (!$bool)
							$cont = true;
					}
					if ($cont)
						continue;
					$attemptid = 0; // attempting to get the last recorded attemptid of this kind
					foreach($attemptsWithDbId as $qvar){
						if ($qvar[12] == $ke)
							$attemptid = $qvar[1];
					}
					return $attemptid; // I'd rather have the attempt id returned
				}
			}
		}
		return false;
	}
	
	private function clearedDungeonByNum($instance, $num, $npcRevTra, $classid){
		// check correct num of player
		$realNum = array();
		foreach($this->participantKeys as $id){
			if (isset($this->userById[$id])
				&& intval($this->userById[$id][2])>0
				&& (!isset($this->userById[$id][4]) || !$this->userById[$id][4])
				&& $id != 0 && $id!=""){
				if (intval($classid)>0 && $classid!=$this->userById[$id][2])
					return false;
				$realNum[$id] = true;
			}
		}
		if (sizeOf($realNum)>$num) // check num players that participated
			return false;
			
		// check if the instance has been cleared
		$instanceTra = array(
			"Molten Core" => "Geschmolzener Kern",
			"Blackwing Lair" => "Pechschwingenhort",
			"Zul'Gurub" => "Zul'Gurub",
			"Ruins of Ahn'Qiraj" => "Ruinen von Ahn'Qiraj",
			"Temple of Ahn'Qiraj" => "Tempel von Ahn'Qiraj",
			"Ahn'Qiraj" => "Ahn'Qiraj",
			"Naxxramas" => "Naxxramas",
		);
		
		$name = nil;
		if (isset($this->atmt[$instance]))
			$name = $instace;
		if (isset($this->atmt[$instanceTra[$instance]]))
			$name = $instanceTra[$instance];
		
		if (isset($name)){
			$bossesByZone = Array(
				"Molten Core" => array(
					"Lucifron" => false,
					"Magmadar" => false,
					"Gehennas" => false,
					"Garr" => false,
					"Baron Geddon" => false,
					"Shazzrah" => false,
					"Sulfuron Harbinger" => false, // maybe not?
					"Golemagg the Incinerator" => false,
					"Ragnaros" => false
				),
				"Blackwing Lair" => array(
					"Vaelastrasz the Corrupt" => false,
					"Broodlord Lashlayer" => false,
					"Firemaw" => false,
					"Flamegor" => false,
					"Ebonroc" => false,
					"Chromaggus" => false,
					"Nefarian" => false
				),
				"Onyxia's Lair" => array(
					"Onyxia" => false,
				),
				"Zul'Gurub" => array(
					"High Priestess Jeklik" => false,
					"High Priest Venoxis" => false,
					"High Priestess Mar'li" => false,
					"Bloodlord Mandokir" => false,
					"High Priest Thekal" => false,
					"High Priestess Arlokk" => false,
					"Jin'do the Hexxer" => false,
					"Hakkar" => false,
				),
				"Ruins of Ahn'Qiraj" => array(
					"Kurinnaxx" => false,
					//"General Rajaxx" => false,
					"Moam" => false,
					//"Buru the Gorger" => false,
					"Ayamiss the Hunter" => false,
					"Ossirian the Unscarred" => false,
				),
				"Ahn'Qiraj" => array(
					"The Prophet Skeram" => false,
					"Battleguard Sartura" => false,
					"Fankriss the Unyielding" => false,
					"Viscidus" => false,
					"Princess Huhuran" => false,
					"Ouro" => false,
					"The Twin Emperors" => false,
					"The Bug Family" => false,
					"C'Thun" => false,
				),
				"Temple of Ahn'Qiraj" => array(
					"The Prophet Skeram" => false,
					"Battleguard Sartura" => false,
					"Fankriss the Unyielding" => false,
					"Viscidus" => false,
					"Princess Huhuran" => false,
					"Ouro" => false,
					"The Twin Emperors" => false,
					"The Bug Family" => false,
					"C'Thun" => false,
				),
				"Naxxramas" => array(
					"Patchwerk" => false,
					"Grobbulus" => false,
					"Gluth" => false,
					"Thaddius" => false,
					"Anub'Rekhan" => false,
					"Grand Widow Faerlina" => false,
					"Maexxna" => false,
					"Instructor Razuvious" => false,
					"Gothik the Harvester" => false,
					"Noth the Plaguebringer" => false,
					"Heigan the Unclean" => false,
					"Loatheb" => false,
					"Sapphiron" => false,
					"Kel'Thuzad" => false,
				),
			);
			
			foreach($this->atmt[$name] as $fights){
				if (isset($fight[6])){
					foreach($fight[6] as $death){
						if (isset($bossesByZone[$instance][$death[2]]))
							$bossesByZone[$instance][$death[2]] = true;
						if (isset($bossesByZone[$instance][$npcRevTra[$death[2]]]))
							$bossesByZone[$instance][$npcRevTra[$death[2]]] = true;
					}
				}
			}
			
			foreach($bossesByZone[$instance] as $bool){
				if (!$bool)
					return false;
			}
			return true;
		}
		
		return false;
	}
	
	private function isValidSpeedRun($instance, $npcRevTra, $time){
		// check if the instance has been cleared
		$instanceTra = array(
			"Molten Core" => "Geschmolzener Kern",
			"Blackwing Lair" => "Pechschwingenhort",
			"Zul'Gurub" => "Zul'Gurub",
			"Ruins of Ahn'Qiraj" => "Ruinen von Ahn'Qiraj",
			"Temple of Ahn'Qiraj" => "Tempel von Ahn'Qiraj",
			"Ahn'Qiraj" => "Ahn'Qiraj",
			"Naxxramas" => "Naxxramas",
		);
		
		$name = nil;
		if (isset($this->atmt[$instance]))
			$name = $instace;
		if (isset($this->atmt[$instanceTra[$instance]]))
			$name = $instanceTra[$instance];
		
		if (isset($name)){
			$bossesByZone = Array(
				"Molten Core" => array(
					"Lucifron" => false,
					"Magmadar" => false,
					"Gehennas" => false,
					"Garr" => false,
					"Baron Geddon" => false,
					"Shazzrah" => false,
					"Sulfuron Harbinger" => false, // maybe not?
					"Golemagg the Incinerator" => false,
					"Ragnaros" => false
				),
				"Blackwing Lair" => array(
					"Vaelastrasz the Corrupt" => false,
					"Broodlord Lashlayer" => false,
					"Firemaw" => false,
					"Flamegor" => false,
					"Ebonroc" => false,
					"Chromaggus" => false,
					"Nefarian" => false
				),
				"Onyxia's Lair" => array(
					"Onyxia" => false,
				),
				"Zul'Gurub" => array(
					"High Priestess Jeklik" => false,
					"High Priest Venoxis" => false,
					"High Priestess Mar'li" => false,
					"Bloodlord Mandokir" => false,
					"High Priest Thekal" => false,
					"High Priestess Arlokk" => false,
					"Jin'do the Hexxer" => false,
					"Hakkar" => false,
				),
				"Ruins of Ahn'Qiraj" => array(
					"Kurinnaxx" => false,
					//"General Rajaxx" => false,
					"Moam" => false,
					//"Buru the Gorger" => false,
					"Ayamiss the Hunter" => false,
					"Ossirian the Unscarred" => false,
				),
				"Ahn'Qiraj" => array(
					"The Prophet Skeram" => false,
					"Battleguard Sartura" => false,
					"Fankriss the Unyielding" => false,
					"Viscidus" => false,
					"Princess Huhuran" => false,
					"Ouro" => false,
					"The Twin Emperors" => false,
					"The Bug Family" => false,
					"C'Thun" => false,
				),
				"Temple of Ahn'Qiraj" => array(
					"The Prophet Skeram" => false,
					"Battleguard Sartura" => false,
					"Fankriss the Unyielding" => false,
					"Viscidus" => false,
					"Princess Huhuran" => false,
					"Ouro" => false,
					"The Twin Emperors" => false,
					"The Bug Family" => false,
					"C'Thun" => false,
				),
				"Naxxramas" => array(
					"Patchwerk" => false,
					"Grobbulus" => false,
					"Gluth" => false,
					"Thaddius" => false,
					"Anub'Rekhan" => false,
					"Grand Widow Faerlina" => false,
					"Maexxna" => false,
					"Instructor Razuvious" => false,
					"Gothik the Harvester" => false,
					"Noth the Plaguebringer" => false,
					"Heigan the Unclean" => false,
					"Loatheb" => false,
					"Sapphiron" => false,
					"Kel'Thuzad" => false,
				),
			);
			
			$min = 0; $max = 0;
			foreach($this->atmt[$name] as $fights){
				if (isset($fight[6])){
					foreach($fight[6] as $death){
						if (isset($bossesByZone[$instance][$death[2]])){
							$bossesByZone[$instance][$death[2]] = true;
							if ($min==0 || $death[1]<$min)
								$min = $death[1];
							if ($max<$death[1])
								$max = $death[1];
						}
						if (isset($bossesByZone[$instance][$npcRevTra[$death[2]]])){
							$bossesByZone[$instance][$npcRevTra[$death[2]]] = true;
							if ($min==0 || $death[1]<$min)
								$min = $death[1];
							if ($max<$death[1])
								$max = $death[1];
						}
					}
				}
			}
			
			foreach($bossesByZone[$instance] as $bool){
				if (!$bool)
					return false;
			}
			
			// check timespan
			if ($time>($max-$min) || $max == 0)
				return false;
			return true;
		}
		return false;
	}
	
	private function isImmortalRun($immortalRuns, $instance){
		$raids = array( // What about World bosses?
			"Molten Core" => 1,
			"Onyxia's Lair" => 2,
			"Blackwing Lair" => 3,
			"Zul'Gurub" => 4,
			"Ruins of Ahn'Qiraj" => 5,
			"Temple of Ahn'Qiraj" => 14,
			"Naxxramas" => 7,
			"Feralas" => 8,
			"Azshara" => 9,
			"Blasted Lands" => 10,
			"Ashenvale" => 11,
			"Duskwood" => 12,
			"Hinterlands" => 13,
			"Ahn'Qiraj" => 6,
			"Geschmolzener Kern" => 1,
			"Onyxias Hort" => 2,
			"Pechschwingenhort" => 3,
			"Ruinen von Ahn'Qiraj" => 5,
			"Tempel von Ahn'Qiraj" => 14,
			"Verwüstete Lande" => 10,
			"Düsterwald" => 12,
			"Hinterlande" => 13
		);
		if (isset($immortalRuns[$raids[$instance]]) && $immortalRuns[$raids[$instance]][1]==0)
			return true;
		return false;
	}
	
	private function dmgOrAuraTakenAtBoss($npcRevTra, $attemptsWithDbId, $spellTra, $abilities, $boss, $num){
		foreach($this->atmt as $var){
			foreach($var as $va){   
				if (isset($va[6])){
					$found = false;
					foreach($va[6] as $qvar){
						if ($qvar[2]==$boss || $qvar[2]==$npcRevTra[$boss])
							$found = true;
					}
					if ($found){
						$attempts = array();
						foreach($attemptsWithDbId as $qqke => $qqva){
							if ($qqva[12]==$ke)
								array_push($attempts, array(1=>$qqke,2=>$qqva[4],3=>$qqva[5]));
						}
						foreach ($attempts as $qvar){
							if (isset($this->individualDmgTakenByAbility[$qvar[1]])){
								foreach($this->individualDmgTakenByAbility[$qvar[1]] as $qva){
									foreach ($abilities as $abname => $abamount){
										if ((isset($this->abilities[$abname]) && isset($qva[$this->abilities[$abname][1]])) || (isset($this->abilities[$spellTra[$abname]]) && isset($qva[$this->abilities[$spellTra[$abname]][1]])))
											$abilities[$abname] = true;
									}
								}
							}
						}
						foreach($abilities as $bool){
							if (!$bool)
								return false; // In General this should be fine but who know what corner cases will come
						}
						
						foreach($this->newDebuffs as $qvar){
							foreach($abilities as $abname => $qva){
								if (!$qva){
									if (isset($this->abilities[$abname]) && isset($qvar[$this->abilities[$abname][1]])){
										foreach(explode(",", $qvar[$this->abilities[$abname][1]][1]) as $timeStart){
											if ($timeStart>=$qvar[2] && $timesStart<=$qvar[3]){
												$abilities[$abname] = true;
												break 1;
											}
										}
									}
									if (isset($this->abilities[$spellTra[$abname]]) && isset($qvar[$this->abilities[$spellTra[$abname]][1]])){
										foreach(explode(",", $qvar[$this->abilities[$spellTra[$abname]][1]][2]) as $timeEnd){
											if ($timeEnd>=$qvar[2] && $timesEnd<=$qvar[3]){
												$abilities[$abname] = true;
												break 1;
											}
										}
									}
								}
							}
						}
						foreach($this->newBuffs as $qvar){
							foreach($abilities as $abname => $qva){
								if (!$qva){
									if (isset($this->abilities[$abname]) && isset($qvar[$this->abilities[$abname][1]])){
										foreach(explode(",", $qvar[$this->abilities[$abname][1]][1]) as $timeStart){
											if ($timeStart>=$qvar[2] && $timesStart<=$qvar[3]){
												$abilities[$abname] = true;
												break 1;
											}
										}
									}
									if (isset($this->abilities[$spellTra[$abname]]) && isset($qvar[$this->abilities[$spellTra[$abname]][1]])){
										foreach(explode(",", $qvar[$this->abilities[$spellTra[$abname]][1]][1]) as $timeEnd){
											if ($timeEnd>=$qvar[2] && $timesEnd<=$qvar[3]){
												$abilities[$abname] = true;
												break 1;
											}
										}
									}
								}
							}
						}
						
						// Hardcode
						if (isset($abilities["Aspect of Thekal"]) && (isset($this->abilities["Aspect of Thekal"]) || isset($this->abilities[$spellTra["Aspect of Thekal"]])))
							$abilities["Aspect of Thekal"] = true;
						
						$numSucc = 0;
						foreach($abilities as $bool){
							if ($bool)
								$numSucc++;
						}
						if ($numSucc<$num)
							return false;
						return end($attempts);
					}
				}
			}
		}
		return false;
	}
	
	// $this->deathsBySource
	// [3] => id, [4] => -1 if player
	private function friendlyFireKills($attemptsWithDbId, $npcRevTra, $spellTra, $boss, $abilities){
		
	}
	
	private function lootReceived($items){
		foreach($this->loot as $var){
			foreach($var as $va){
				if (isset($items[$va[1]]))
					$items[$va[1]]--;
			}
		}
		foreach($items as $num){
			if ($num>0)
				return false;
		}
		return true;
	}
	
	private function processAchievements($npcRevTra, $guild, $userList, $attemptsWithDbId, $spellTra, $immortalRuns){
		$achList = array(
			2 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Garr" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Baron Geddon" => array(
						0 => 1, 1 => array(), 2 => -1
					),
				),	
				-1,array(),array()
			),
			3 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Lucifron" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Magmadar" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Gehennas" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Garr" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Baron Geddon" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Shazzrah" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Sulfuron Harbinger" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Golemagg the Incinerate" => array(
						0 => 1, 1 => array(), 2 => -1
					),
				),
				60,array(),array()
			),
			4 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Core Hound" => array(
						0 => 21, 1 => array(), 2 => -1
					),
					"Magmadar" => array(
						0 => 1, 1 => array(), 2 => -1
					),
				),	
				15,array(),array()
			),
			5 => $this->takeDmgByAbilityAndKillBoss($npcRevTra, $attemptsWithDbId, $spellTra,
				array(
					"Garr" => false,
				),
				array(
					"Eruption" => 160,
				)
			),
			
			6 => false, // disabled
			
			7 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Sulfuron Harbinger" => array(
						0 => 21, 1 => array(), 2 => -1
					),
				),	
				-1,array(
					"Flamewaker Priest" => true,
				),array()
			),
			8 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Majordomo Executus" => array(
						0 => 0, 1 => array(), 2 => 650000
					),
					"Flamewaker Elite" => array(
						0 => 2, 1 => array(), 2 => -1
					),
					"Flamewaker Healer" => array(
						0 => 2, 1 => array(), 2 => -1
					),
				),	
				-1,array(),array()
			),
			9 => $this->isValidSpeedRun("Molten Core", $npcRevTra, 1800),
			10 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Son of Flame" => array(
						0 => 55, 1 => array(), 2 => -1
					),
					"Ragnaros" => array(
						0 => 1, 1 => array(), 2 => -1
					),
				),	
				-1,array(),array()
			),
			11 => $this->isValidSpeedRun("Molten Core", $npcRevTra, 1200),
			12 => $this->isValidSpeedRun("Molten Core", $npcRevTra, 900),
			
			13 => false, // disabled
			14 => false, // disabled
			
			15 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Onyxian Whelp" => array(
						0 => 111, 1 => array(), 2 => -1
					),
				),	
				15,array(),array(
					"Onyxia" => false,
				)
			),
			16 => $this->isValidSpeedRun("Onyxia's Lair", $npcRevTra, 120), // Probably an issue if several attempts are uploaded 
			17 => $this->isValidSpeedRun("Onyxia's Lair", $npcRevTra, 60),
			18 => $this->takeDmgByAbilityAndKillBoss($npcRevTra, $attemptsWithDbId, $spellTra,
				array(
					"Onyxia" => false,
				),
				array(
					"Tail Sweep" => 300,
				)
			),
			19 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Onyxian Warder" => array(
						0 => 4, 1 => array(), 2 => -1
					),
					"Onyxia" => array(
						0 => 1, 1 => array(), 2 => -1
					),
				),	
				10,array(),array()
			),
			20 => $this->clearedDungeonByNum("Onyxia's Lair", 6, $npcRevTra),
			21 => $this->clearedDungeonByNum("Onyxia's Lair", 5, $npcRevTra),
			22 => $this->clearedDungeonByNum("Onyxia's Lair", 4, $npcRevTra),
			23 => $this->clearedDungeonByNum("Onyxia's Lair", 99, $npcRevTra, 5),
			24 => $this->clearedDungeonByNum("Onyxia's Lair", 99, $npcRevTra, 1),
			25 => $this->clearedDungeonByNum("Onyxia's Lair", 99, $npcRevTra, 2),
			26 => $this->clearedDungeonByNum("Onyxia's Lair", 99, $npcRevTra, 3),
			27 => $this->clearedDungeonByNum("Onyxia's Lair", 99, $npcRevTra, 4),
			28 => $this->clearedDungeonByNum("Onyxia's Lair", 99, $npcRevTra, 6),
			29 => $this->clearedDungeonByNum("Onyxia's Lair", 99, $npcRevTra, 7),
			30 => $this->clearedDungeonByNum("Onyxia's Lair", 99, $npcRevTra, 8),
			31 => $this->clearedDungeonByNum("Onyxia's Lair", 99, $npcRevTra, 9),
			32 => $this->isImmortalRun($immortalRuns, "Onyxia's Lair"),
			33 => $this->lootReceived(array(18861=>5)),
			34 => $this->clearedDungeonByNum("Molten Core", 10, $npcRevTra),
			35 => $this->clearedDungeonByNum("Molten Core", 7, $npcRevTra),
			36 => $this->clearedDungeonByNum("Molten Core", 5, $npcRevTra),
			37 => $this->isImmortalRun($immortalRuns, "Molten Core"),
			38 => $this->lootReceived(array(18563=>1, 18564=>1)),
			39 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Garr" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Ancient Core Hound" => array(
						0 => 2, 1 => array(), 2 => 180000
					),
					"Lava Annihilator" => array(
						0 => 1, 1 => array(), 2 => 80000
					),
					"Molten Destroyer" => array(
						0 => 2, 1 => array(), 2 => 260000
					),
				),	
				-1,array(),array()
			),
			40 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Baron Geddon" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Ancient Core Hound" => array(
						0 => 1, 1 => array(), 2 => 90000
					),
					"Firewalker" => array(
						0 => 1, 1 => array(), 2 => 70000
					),
					"Flameguard" => array(
						0 => 1, 1 => array(), 2 => 70000
					),
					"Lava Elemental" => array(
						0 => 2, 1 => array(), 2 => 140000
					),
				),	
				-1,array(),array()
			),
			41 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Golemagg the Incinerator" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Ancient Core Hound" => array(
						0 => 1, 1 => array(), 2 => 90000
					),
					"Lava Annihilator" => array(
						0 => 1, 1 => array(), 2 => 80000
					),
					"Firelord" => array(
						0 => 1, 1 => array(), 2 => 85000
					),
				),	
				-1,array(),array()
			),
			42 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"High Priest Thekal" => array(
						0 => 1, 1 => array(), 2 => -1
					),
				),	
				-1,array(
					"Zulian Tiger" => true,
					"Zulian Guardian" => true,
				),array()
			),
			43 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"High Priestess Arlokk" => array(
						0 => 1, 1 => array(), 2 => -1
					),
				),	
				-1,array(
					"Zulian Panther" => true,
					"Zulian Guardian" => true,
				),array()
			),
			44 => $this->dmgOrAuraTakenAtBoss($npcRevTra, $attemptsWithDbId, $spellTra, array("Aspect of Jeklik"=>false,"Aspect of Venoxis"=>false,"Aspect of Arlokk"=>false,"Aspect of Thekal"=>false,"Aspect of Mar'li"=>false), "Hakkar", 1),
			45 => $this->dmgOrAuraTakenAtBoss($npcRevTra, $attemptsWithDbId, $spellTra, array("Aspect of Jeklik"=>false,"Aspect of Venoxis"=>false,"Aspect of Arlokk"=>false,"Aspect of Thekal"=>false,"Aspect of Mar'li"=>false), "Hakkar", 2),
			46 => $this->dmgOrAuraTakenAtBoss($npcRevTra, $attemptsWithDbId, $spellTra, array("Aspect of Jeklik"=>false,"Aspect of Venoxis"=>false,"Aspect of Arlokk"=>false,"Aspect of Thekal"=>false,"Aspect of Mar'li"=>false), "Hakkar", 3),
			47 => $this->dmgOrAuraTakenAtBoss($npcRevTra, $attemptsWithDbId, $spellTra, array("Aspect of Jeklik"=>false,"Aspect of Venoxis"=>false,"Aspect of Arlokk"=>false,"Aspect of Thekal"=>false,"Aspect of Mar'li"=>false), "Hakkar", 4),
			48 => $this->dmgOrAuraTakenAtBoss($npcRevTra, $attemptsWithDbId, $spellTra, array("Aspect of Jeklik"=>false,"Aspect of Venoxis"=>false,"Aspect of Arlokk"=>false,"Aspect of Thekal"=>false,"Aspect of Mar'li"=>false), "Hakkar", 5),
			50 => $this->isValidSpeedRun("Zul'Gurub", $npcRevTra, 2100),
			51 => $this->isValidSpeedRun("Zul'Gurub", $npcRevTra, 1800),
			52 => $this->isValidSpeedRun("Zul'Gurub", $npcRevTra, 1500),
			53 => $this->isImmortalRun($immortalRuns, "Zul'Gurub"),
			54 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Flamegor" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Ebonroc" => array(
						0 => 1, 1 => array(), 2 => -1
					),
				),	
				10,array(),array()
			),
			55 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Flamegor" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Ebonroc" => array(
						0 => 1, 1 => array(), 2 => -1
					),
					"Firemaw" => array(
						0 => 1, 1 => array(), 2 => -1
					),
				),	
				10,array(),array()
			),
			56 => $this->isImmortalRun($immortalRuns, "Blackwing Lair"),
			57 => $this->isValidSpeedRun("Blackwing Lair", $npcRevTra, 2400),
			58 => $this->isValidSpeedRun("Blackwing Lair", $npcRevTra, 2100),
			59 => $this->isValidSpeedRun("Blackwing Lair", $npcRevTra, 1800),
			60 => $this->isImmortalRun($immortalRuns, "Ruins of Ahn'Qiraj"),
			61 => $this->npcsKilledInTime($attemptsWithDbId, $npcRevTra,
				array(
					"Buru the Gorger" => array(
						0 => 1, 1 => array(), 2 => -1
					),
				),	
				-1,array(
					"Buru Egg" => true,
				),array()
			),
			62 => $this->isImmortalRun($immortalRuns, "Temple of Ahn'Qiraj"),
			64 => $this->isImmortalRun($immortalRuns, "Naxxramas"),
		);
		
		// Awarding the achievements to everyone in the raid and to the guild
		foreach($achList as $id => $attemptid){
			if ($attemptid){
				// guild
				
				// participants
				foreach($this->participantKeys as $userid){
					if (intval($this->userById[$userid][2])>0 && (!isset($this->userById[$userid][4]) || $this->userById[$userid][2]==false)){
						
					}
				}
			}
		}
		
	}
	
	// do sth against corrupted logs
	private $supersuperstate = true;
	private function writeIntoDB($spells, $npcs, $npcsById, $npcsTra, $npcRevTra, $spellsTra, $spellsRevTra, $cronid){
		$classes = array(
			"warrior" => 1,
			"rogue" => 2,
			"priest" => 3,
			"hunter" => 4,
			"druid" => 5,
			"mage" => 6,
			"warlock" => 7,
			"paladin" => 8,
			"shaman" => 9
		);
		$classesReverse = array(
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
		$realmtype = array(
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
		$raids = array( // What about World bosses?
			"Molten Core" => 1,
			"Onyxia's Lair" => 2,
			"Blackwing Lair" => 3,
			"Zul'Gurub" => 4,
			"Ruins of Ahn'Qiraj" => 5,
			"Temple of Ahn'Qiraj" => 14,
			"Naxxramas" => 7,
			"Feralas" => 8,
			"Azshara" => 9,
			"Blasted Lands" => 10,
			"Ashenvale" => 11,
			"Duskwood" => 12,
			"Hinterlands" => 13,
			"Ahn'Qiraj" => 6,
			"Geschmolzener Kern" => 1,
			"Onyxias Hort" => 2,
			"Pechschwingenhort" => 3,
			"Ruinen von Ahn'Qiraj" => 5,
			"Tempel von Ahn'Qiraj" => 14,
			"Verwüstete Lande" => 10,
			"Düsterwald" => 12,
			"Hinterlande" => 13
		);
		/*// Delete all (temporary)     
		$this->db->query('DELETE FROM `v-immortal-runs`');
		$this->db->query('DELETE FROM `v-raids-newbuffs`');
		$this->db->query('DELETE FROM `v-raids-newdebuffs`');
		$this->db->query('DELETE FROM `v-raids`;');
		$this->db->query('DELETE FROM `v-raids-attempts`;');
		$this->db->query('DELETE FROM `v-raids-buffs`;');
		$this->db->query('DELETE FROM `v-raids-deaths`;');
		$this->db->query('DELETE FROM `v-raids-debuffs`;');
		$this->db->query('DELETE FROM `v-raids-dispels`;');
		//$this->db->query('DELETE FROM `v-raids-dmgdonetofriendly`;');
		$this->db->query('DELETE FROM `v-raids-interruptsmissed`;');
		$this->db->query('DELETE FROM `v-raids-loot`;');
		$this->db->query('DELETE FROM `v-raids-participants`;');
		$this->db->query('DELETE FROM `v-raids-records`;');
		$this->db->query('DELETE FROM `v-raids-uploader`;');
		$this->db->query('DELETE FROM `v-rankings`;');
		$this->db->query('DELETE FROM `v-speed-kills`;');
		$this->db->query('DELETE FROM `v-speed-runs`;');
		$this->db->query('DELETE FROM `v-raids-individual-buffs`;');
		$this->db->query('DELETE FROM `v-raids-individual-debuffsbyplayer`;');
		$this->db->query('DELETE FROM `v-raids-individual-death`;');
		$this->db->query('DELETE FROM `v-raids-individual-debuffs`;');
		$this->db->query('DELETE FROM `v-raids-individual-dmgdonetoenemy`;');
		$this->db->query('DELETE FROM `v-raids-individual-dmgdonebyability`;');
		$this->db->query('DELETE FROM `v-raids-individual-dmgtakenfromability`;');
		$this->db->query('DELETE FROM `v-raids-individual-dmgtakenbyplayer`;');
		$this->db->query('DELETE FROM `v-raids-individual-dmgtakenfromsource`;');
		$this->db->query('DELETE FROM `v-raids-individual-healingbyability`;');
		$this->db->query('DELETE FROM `v-raids-individual-healingtofriendly`;');
		$this->db->query('DELETE FROM `v-raids-individual-interrupts`;');
		$this->db->query('DELETE FROM `v-raids-individual-procs`;');
		$this->db->query('DELETE FROM `chars`;');
		$this->db->query('DELETE FROM `contributors`;');
		$this->db->query('DELETE FROM `guilds`;');
		$this->db->query('DELETE FROM `v-raids-graph-individual-dmgdone`');
		$this->db->query('DELETE FROM `v-raids-graph-individual-friendlyfire`');
		$this->db->query('DELETE FROM `v-raids-graph-individual-dmgtaken`');
		$this->db->query('DELETE FROM `v-raids-graph-individual-healingreceived`');
		$this->db->query('DELETE FROM `v-raids-casts`');
		// TEMPORARY*/

		//$this->db->query('SET NAMES latin1');
		
		$guildsByKeys = array();
		$guildname = $this->getGuild();
		$serverid = $this->getServerId(); 
		if ($this->db->query('SELECT id FROM guilds WHERE name = "'.$guildname.'" AND serverid = "'.$serverid.'" AND faction = "'.$this->pinfo[3].'"')->rowCount() == 0)
			$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$guildname.'", "'.$serverid.'", "'.$this->pinfo[3].'")'); // Just to be on the save site
		$guildid = $this->db->query('SELECT id FROM guilds WHERE name = "'.$guildname.'" AND serverid = '.$serverid.' AND faction = "'.$this->pinfo[3].'" LIMIT 1')->fetch()->id;
		if (isset($this->pinfo[5]) && $this->pinfo[5] != "" && $this->pinfo[5] != " " && $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->pinfo[5].'" AND serverid = "'.$serverid.'" AND faction = "'.$this->pinfo[3].'"')->rowCount() == 0)
			$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$this->pinfo[5].'", "'.$serverid.'", "'.$this->pinfo[3].'")'); // Just to be on the save site
		$this->pinfo[6] = $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->pinfo[5].'" AND serverid = '.$serverid.' AND faction = "'.$this->pinfo[3].'" LIMIT 1')->fetch()->id;
		/*if ($guildname == "PugRaid"){
			if ($this->db->query('SELECT id FROM guilds WHERE name = "'.$guildname.'" AND serverid = "'.$serverid.'" AND faction = "'.$this->pinfo[3].'"')->rowCount() == 0)
				$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$guildname.'", "'.$serverid.'", "'.$this->pinfo[3].'")'); // Just to be on the save site
			$guildid = $this->db->query('SELECT id FROM guilds WHERE name = "'.$guildname.'" AND serverid = '.$serverid.' AND faction = "'.$this->pinfo[3].'"')->fetch()->id;
			if (isset($this->pinfo[5]) && $this->pinfo[5] != "" && $this->pinfo[5] != " " && $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->pinfo[5].'" AND serverid = "'.$serverid.'" AND faction = "'.$this->pinfo[3].'"')->rowCount() == 0)
				$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$this->pinfo[5].'", "'.$serverid.'", "'.$this->pinfo[3].'")'); // Just to be on the save site
			$this->pinfo[6] = $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->pinfo[5].'" AND serverid = '.$serverid)->fetch()->id;
		}else{
			if ($this->db->query('SELECT id FROM guilds WHERE name = "'.$guildname.'" AND serverid = "'.$serverid.'"')->rowCount() == 0)
				$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$guildname.'", "'.$serverid.'", "'.$this->pinfo[3].'")'); // Just to be on the save site
			$guildid = $this->db->query('SELECT id FROM guilds WHERE name = "'.$guildname.'" AND serverid = '.$serverid)->fetch()->id;
			if (isset($this->pinfo[5]) && $this->pinfo[5] != "" && $this->pinfo[5] != " " && $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->pinfo[5].'" AND serverid = "'.$serverid.'"')->rowCount() == 0)
				$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$this->pinfo[5].'", "'.$serverid.'", "'.$this->pinfo[3].'")'); // Just to be on the save site
			$this->pinfo[6] = $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->pinfo[5].'" AND serverid = '.$serverid)->fetch()->id;
		}*/
		if ($this->db->query('SELECT id FROM chars WHERE name = "'.$this->pinfo[1].'" AND serverid = "'.$serverid.'"')->rowCount() == 0)
			$this->db->query('INSERT INTO chars (name, classid, faction, guildid, serverid) VALUES ("'.$this->pinfo[1].'", "'.$classes[strtolower($this->pinfo[2])].'", "'.$this->pinfo[3].'", "'.($r = (isset($this->pinfo[6])) ? $this->pinfo[6] : 0).'", "'.$serverid.'")'); // Just to be on the save site
		$pid = $this->db->query('SELECT id FROM chars WHERE name = "'.$this->pinfo[1].'" AND serverid = "'.$serverid.'"')->fetch()->id;
		
		$this->db->query('UPDATE cronjob SET progress = 51 WHERE id = '.$cronid);
		$charsByKey = array();
		foreach($this->participantKeys as $k => $v){
			// guilds
			if (isset($this->userById[$v][7]) && $this->userById[$v][7]!="" && $this->userById[$v][7]!=" "){
				if ($this->db->query('SELECT id FROM guilds WHERE name = "'.$this->userById[$v][7].'" AND serverid = "'.$serverid.'"')->rowCount() == 0)
					$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$this->userById[$v][7].'", "'.$serverid.'", "'.$this->pinfo[3].'")');
				$guildsByKeys[$v] = $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->userById[$v][7].'" AND serverid = '.$serverid)->fetch()->id;
			}
			// chars
			if (!$npcs[$v] and !$this->userById[$v][4]){
				$q = $this->db->query('SELECT id, classid, guildid FROM chars WHERE name = "'.$this->userById[$v][1].'" AND serverid = "'.$serverid.'" AND ownerid = 0');
				$f = $q->fetch();
				//print $this->userById[$v][1]."HAS GOTTEN HERE<br />";
				if ($q->rowCount() == 0){
					$this->db->query('INSERT INTO chars (name, classid, faction, guildid, serverid, ownerid) VALUES ("'.$this->userById[$v][1].'", "'.($r = (isset($this->userById[$v][2])) ? $classes[$this->userById[$v][2]] : 0).'", "'.($this->pinfo[3]).'", "'.($r = (isset($guildsByKeys[$v])) ? $guildsByKeys[$v] : 0).'", "'.$serverid.'", "0")');
					$charsByKey[$v] = $this->db->query('SELECT id FROM chars WHERE name = "'.$this->userById[$v][1].'" AND serverid = "'.$serverid.'" AND ownerid = 0')->fetch()->id;
				}else{
					if ($f->classid != 0 && intval($classes[$this->userById[$v][2]]) != 0 && $f->classid != intval($classes[$this->userById[$v][2]])){
						// If the character changes everything has to be cleared
						$this->db->query('DELETE FROM `v-rankings` WHERE charid = "'.$f->id.'";');
						$this->db->query('DELETE FROM `armory` WHERE charid = "'.$f->id.'";');
						$this->db->query('DELETE FROM `armory-itemsets` WHERE charid = "'.$f->id.'";');
						$this->db->query('DELETE FROM `armory-guildhistory` WHERE charid = "'.$f->id.'";');
						$this->db->query('DELETE FROM `armory-itemhistory` WHERE charid = "'.$f->id.'";');
						$this->db->query('UPDATE `chars` SET classid = "'.intval($classes[$this->userById[$v][2]]).'" WHERE id = "'.$f->id.'";');
					}
					if ($f->classid == 0 && $f->classid != intval($classes[$this->userById[$v][2]]))
						$this->db->query('UPDATE chars SET classid = "'.$classes[$this->userById[$v][2]].'" WHERE name = "'.$this->userById[$v][1].'" AND serverid = "'.$serverid.'" AND ownerid = 0');
					if ($f->guildid == 0 && $f->guildid != intval($guildsByKeys[$v]) && intval($guildsByKeys[$v]) != 0)
						$this->db->query('UPDATE chars SET guildid = "'.$guildsByKeys[$v].'" WHERE name = "'.$this->userById[$v][1].'" AND serverid = "'.$serverid.'"');
					$charsByKey[$v] = $f->id;
				}
			}
		}
		$this->db->query('UPDATE cronjob SET progress = 53 WHERE id = '.$cronid);
		
		$knownPets = array();
		$knownPetNames = array();
		$petOwner = array();
		foreach($charsByKey as $key => $var){
			if (gettype($this->userById[$key][5])=="string" && $this->userById[$key][5]!="" && isset($this->user[$this->userById[$key][5]])){
				$knownPetNames[] = '"'.str_replace(array('"', '\\'), "", $this->userById[$key][5]).'"';
				$petOwner[] = $var;
			}
		}
		
		
		if (!empty($petOwner) && !empty($knownPetNames)){;
			foreach($this->db->query('SELECT id, name FROM chars WHERE ownerid IN ('.implode(",",$petOwner).') AND name IN ('.implode(",",$knownPetNames).');') as $row){
				if (isset($this->user[$row->name][1]) && !isset($charsByKey[$this->user[$row->name][1]]))
					$charsByKey[$this->user[$row->name][1]] = intval($row->id);
			}
		}
		
		// pets
		foreach($this->participantKeys as $k => $v){
			if (isset($this->userById[$v][4]) && isset($this->userById[$v][6]) && isset($charsByKey[$this->userById[$v][6]]) && $this->userById[$v][4] == true && !isset($npcs[$v]) && !isset($charsByKey[$v])){
				if ($this->db->query('SELECT id, classid, guildid FROM chars WHERE name = "'.$this->userById[$v][1].'" AND serverid = "'.$serverid.'" AND ownerid != 0')->rowCount() == 0)
					$this->db->query('INSERT INTO chars (name, classid, faction, guildid, serverid, ownerid) VALUES ("'.$this->userById[$v][1].'", "0", "'.$this->userById[$this->userById[$v][6]][3].'", "0", "'.$serverid.'", "'.$charsByKey[$this->userById[$v][6]].'")');
				$charsByKey[$v] = intval($this->db->query('SELECT id FROM chars WHERE name = "'.$this->userById[$v][1].'" AND serverid = "'.$serverid.'" AND ownerid != 0')->fetch()->id);
			}
		}
		
		print "34 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 55 WHERE id = '.$cronid);
		
		//v-raids // v-attempts
		$raidsByZone = array();
		$attemptsWithDbId = array();
		$attemptsWithDbIdByNpcId = array();
		//$raidExists = array(); //Deprecated
		$raidExistsAttempts = array();
		$raidExistsAttemptsWithIds = array();
		$mergeBoolean = false;
		foreach($this->atmt as $k => $v){
			if (isset($raids[$k]) && $this->isValidLog($k, $npcRevTra)){ // Worldboss issue
				$tses = $this->getTses($k, $serverid, time(), 0);
				$newLog = $this->isNewLog($raids[$k], $tses[2], $charsByKey, $serverid);
				foreach($newLog[2] as $qq => $ss){
					$raidExistsAttempts[$qq] = $ss;
				}
				foreach($newLog[3] as $qq => $ss){
					$raidExistsAttemptsWithIds[$qq] = $ss;
				}
				if ((sizeOf($charsByKey)>0) || $newLog[1] == 0){
					$this->db->query('INSERT INTO `v-raids` (nameid, guildid, tsstart, tsend) VALUES ("'.$raids[$k].'", "'.$guildid.'", "'.$tses[1].'", "'.$tses[2].'")');
					$raidsByZone[$k] = $this->db->query('SELECT id FROM `v-raids` WHERE nameid = "'.$raids[$k].'" AND guildid = "'.$guildid.'" AND tsstart = "'.$tses[1].'" AND tsend = "'.$tses[2].'"')->fetch()->id;
					$this->db->query('UPDATE cronjob SET merge = "'.$raidsByZone[$k].'", mergetype = 0 WHERE id = "'.$cronid.'"');
				}else{
					$mergeBoolean = $newLog[1];
						// Hackfix because that kills the server
						$this->supersuperstate = true;
						return true;
					// Exit to avoid double attempts
					if ($this->db->query('SELECT id FROM cronjob WHERE merge = "'.$newLog[1].'" AND expansion = 0')->rowCount()>0){
						$this->supersuperstate = false;
						return false;
					}
					$q = $this->db->query('SELECT a.guildid, a.id, c.name, a.tsstart, a.tsend FROM `v-raids` a LEFT JOIN `v-raids-attempts` b ON a.id = b.rid LEFT JOIN guilds c ON a.guildid = c.id WHERE a.nameid = "'.$raids[$k].'" AND a.id = "'.$mergeBoolean.'"')->fetch();
					if ($q->name == "PugRaid" && $guildname != "PugRaid")
						$this->db->query('UPDATE `v-raids` SET guildid = "'.$guildid.'" WHERE id = "'.$q->id.'";');
					if ($q->tsend<$tses[2])
						$this->db->query('UPDATE `v-raids` SET tsend = "'.$tses[2].'" WHERE id = "'.$q->id.'";');
					if ($q->tsstart>$tses[1] && $tses[1] != 0)
						$this->db->query('UPDATE `v-raids` SET tsstart = "'.$tses[1].'" WHERE id = "'.$q->id.'";');
					$raidsByZone[$k] = $q->id;
					$this->db->query('UPDATE cronjob SET merge = "'.$raidsByZone[$k].'", mergetype = 1 WHERE id = "'.$cronid.'"');
				}
				if ($this->db->query('SELECT id FROM `v-raids-uploader` WHERE rid = "'.$raidsByZone[$k].'" AND charid = "'.$pid.'"')->rowCount() == 0){
					$this->db->query('INSERT INTO `v-raids-uploader` (rid, charid) VALUES ("'.$raidsByZone[$k].'", "'.$pid.'")');
				}
			}
		}
		
		// maybe change it to double at some time
		$instanceStartById = array();
		$this->db->query('UPDATE cronjob SET progress = 56 WHERE id = '.$cronid);
		foreach($this->attemptsWithNpcId as $k => $v){
			if (isset($v[2]) && $v[2] != 0 && $v[2] != "" && !isset($raidExistsAttempts[$k])){
				$ts = $this->getTimeStamp($v[4], $v[4]);
				$extraTime = $this->getExtraTime($mergeBoolean, null, $raids[$v[1]]);
				$npcstr = "";
				foreach($v[10] as $q => $s){
					if (isset($npcs[$this->user[$s][1]]))
						$npcstr .= ($r = ($npcstr != "") ? "," : "").$npcs[$this->user[$s][1]];
				}
				$istartCBT = $this->instanceStart[$v[1]];
				if ($mergeBoolean && $extraTime==0)
					$istartCBT = 0;
				//print $v[2]." // ".$k."<br />";
				$this->db->query('INSERT IGNORE INTO `v-raids-attempts` (npcid, rid, type, time, cbt, cbtend, duration, npcs) VALUES ("'.$v[2].'", "'.$raidsByZone[$v[1]].'", "'.($r = (!$v[9]) ? 1 : -1).'", "'.$ts[1].'", "'.floor($v[3]-$istartCBT+$extraTime).'", "'.floor($v[5]-$istartCBT+$extraTime).'", "'.$v[7].'", "'.$npcstr.'")');
				$id = $this->db->query('SELECT id FROM `v-raids-attempts` WHERE npcid = "'.$v[2].'" AND rid = "'.$raidsByZone[$v[1]].'" AND cbt = "'.floor($v[3]-$istartCBT+$extraTime).'"')->fetch()->id;
				if (intval($id)==0)
					$id = $this->db->query('SELECT id FROM `v-raids-attempts` WHERE LOCATE("'.$v[2].'", npcs) AND rid = "'.$raidsByZone[$v[1]].'" AND cbt >= "'.floor($v[3]-$istartCBT+$extraTime-1).'" AND cbt <= "'.floor($v[3]-$istartCBT+$extraTime+1).'" ORDER BY id DESC LIMIT 1')->fetch()->id;
				$attemptsWithDbId[$k] = Array(
					1 => $id, // attemptid
					2 => $raidsByZone[$v[1]], // raid id
					3 => $v[2], // npcid
					4 => $v[3], // cbt start
					5 => $v[5], // cbt end
					6 => $v[6], // kill attempt
					7 => $v[8], // 1 => boss
					8 => $raids[$v[1]], // raidnameid
					9 => $v[4], // time
					10 => $v[1],
					11 => $v[9],
					12 => $v[11],
				);
				$attemptsWithDbIdByNpcId[$v[2]] = array(
					1 => $id,
					2 => $raidsByZone[$v[1]], // raid id
					3 => $v[2],
					4 => $v[3],
					5 => $v[5],
					6 => $v[6], // kill attempt
					7 => $v[8], // 1 => boss
					8 => $raids[$v[1]], // raidnameid
					9 => $v[4], // time
					10 => $v[1],
					11 => $v[9]
				);
				$instanceStartById[$k] = $istartCBT;
			}
		}
		// contributors 
		if ($this->db->query('SELECT id FROM contributors WHERE charid = "'.$pid.'"')->rowCount() == 0)
			$this->db->query('INSERT INTO contributors (charid, time) VALUES ("'.$pid.'", "'.time().'")');
		
		// v-raids-participants
		$participantsArr = array();
		foreach($this->participants as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($charsByKey[$var]) && !isset($npcs[$var])){
						if (isset($participantsArr[$k][$ke]))
							$participantsArr[$k][$ke] .= $charsByKey[$var].",";
						else
							$participantsArr[$k][$ke] = $charsByKey[$var].",";
					}
				}
			}
		}
		print "35 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 58 WHERE id = '.$cronid);
		foreach($raidsByZone as $k => $v){
			if (isset($participantsArr[$k])){
				$q = $this->db->query('SELECT * FROM `v-raids-participants` WHERE rid = "'.$v.'"');
				if ($q->rowCount() == 0){
					$this->db->query('INSERT INTO `v-raids-participants` (rid, tanks, dps, healers) VALUES ("'.$v.'", "'.$participantsArr[$k]["Tanks"].'", "'.$participantsArr[$k]["DPS"].'", "'.$participantsArr[$k]["Healer"].'")');
				}else{
					$f = $q->fetch();
					$tanks = explode(",", $f->tanks);
					$dps = explode(",", $f->dps);
					$healers = explode(",", $f->healers);
					$tanksNew = explode(",", $participantsArr[$k]["Tanks"]);
					foreach($tanksNew as $key => $var){
						if (isset($var) and $var != ""){
							if (!in_array($var, $tanks) && !in_array($var, $dps) && !in_array($var, $healers))
								array_push($tanks, $var);
						}
					}
					$dpsNew = explode(",", $participantsArr[$k]["DPS"]);
					foreach($dpsNew as $key => $var){
						if (isset($var) and $var != ""){
							if (!in_array($var, $tanks) && !in_array($var, $dps) && !in_array($var, $healers))
								array_push($dps, $var);
						}
					}
					$healersNew = explode(",", $participantsArr[$k]["Healer"]);
					foreach($healersNew as $key => $var){
						if (isset($var) and $var != ""){
							if (!in_array($var, $tanks) && !in_array($var, $dps) && !in_array($var, $healers))
								array_push($healers, $var);
						}
					}
					$dpsString = "";
					foreach($dps as $ke => $va){
						if (isset($va) and $va != "")
							$dpsString .= $va.",";
					}
					$tanksString = "";
					foreach($tanks as $ke => $va){
						if (isset($va) and $va != "")
							$tanksString .= $va.",";
					}
					$healersString = "";
					foreach($healers as $ke => $va){
						if (isset($va) and $va != "")
							$healersString .= $va.",";
					}
					$this->db->query('UPDATE `v-raids-participants` SET tanks = "'.$tanksString.'", dps = "'.$dpsString.'", healers = "'.$healersString.'" WHERE rid = "'.$v.'"');
				}
			}
		}
		
		//v-raids-loot
		foreach($this->getLootArray($attemptsWithDbId, $npcsById, $npcRevTra) as $k => $v){
			foreach($v as $key => $var){
				if ($mergeBoolean)
					$qqqwe = $this->db->query('SELECT * FROM `v-raids-loot` WHERE charid = "'.$charsByKey[$var[2]].'" AND loot = "'.$var[1].'"');
				if (!isset($qqqwe) || (isset($qqqwe) && $qqqwe->rowCount() == 0)){
					$this->db->query('INSERT INTO `v-raids-loot` (attemptid, loot, charid) VALUES ("'.$k.'", "'.$var[1].'", "'.($r = (isset($charsByKey[$var[2]])) ? $charsByKey[$var[2]] : 0).'")');
				}
			}
		}
		print "36 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 60 WHERE id = '.$cronid);
		
		// Freeing memory
		unset($this->dmg);
		unset($this->dmgtaken);
		unset($this->edt);
		unset($this->edd);
		unset($this->dispels);
		unset($this->interrupts);
		unset($this->deaths);
		unset($this->ehealing);
		unset($this->thealing);
		unset($this->overhealing);
		unset($this->absorbs);
		unset($this->auras);
		unset($this->totalDmgDone);
		unset($this->totalDmgTaken);
		unset($this->totalEDDTable);
		unset($this->totalEDTTable);
		unset($this->totalEHealingDone);
		unset($this->totalEHealingTaken);
		unset($this->totalTHealingDone);
		unset($this->totalTHealingTaken);
		////gc_collect_cycles();
		
		// Damage done
		/*
		* dmgDoneBySource[attemptid][charid] = Array(1 => value, 2 => active);
		* dmgDoneByAbility[attemptid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 => resist); //potential block
		* dmgDoneToEnemy[attemptid][npcid] = Array(1 => amount, 2 => active);
		* To test => dmgDoneToFriendly[attemptid][charid(the victim)] = amount;
		* To test => individualDmgDoneByAbility[attemptid][charid][abilityid] = Array(1 => casts, 2 => hits, 3 => amount, 4 => average, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 => resist);
		* To test => individualDmgDoneToEnemy[attemptid][npcid][charid] = Array(1 => amount, 2 => active);
		*/
		/*// v-raids-dmgdonebyability
		$sql = 'INSERT INTO `v-raids-dmgdonebyability` (attemptid, abilityid, amount, casts, hits, crit, miss, parry, dodge, resist) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-dmgdonebyability` SET 
								casts = IF(?>amount, ?, casts),
								hits = IF(?>amount, ?, hits),
								crit = IF(?>amount, ?, crit),
								miss = IF(?>amount, ?, miss),
								parry = IF(?>amount, ?, parry),
								dodge = IF(?>amount, ?, dodge),
								resist = IF(?>amount, ?, resist),
								amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->dmgDoneByAbility as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset($spells[$key])){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[3], $var[1], $var[4], $var[1], $var[5], $var[1], $var[6], $var[1], $var[7], $var[1], $var[8], $var[1], $var[9], $var[1], $raidExistsAttempts[$k], $spells[$key]));
						}else{
							$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $spells[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[3];
							$insertData[] = $var[4];
							$insertData[] = $var[5];
							$insertData[] = $var[6];
							$insertData[] = $var[7];
							$insertData[] = $var[8];
							$insertData[] = $var[9];
							//$this->db->query('INSERT INTO `v-raids-dmgdonebyability` (attemptid, abilityid, amount, average, casts, hits, crit, miss, parry, dodge, resist) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'", "'.$var[5].'", "'.$var[6].'", "'.$var[7].'", "'.$var[8].'", "'.$var[9].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-dmgdonebysource
		$sql = 'INSERT INTO `v-raids-dmgdonebysource` (attemptid, charid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-dmgdonebysource` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND charid = ?');
		foreach($this->dmgDoneBySource as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset($charsByKey[$key])){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `v-raids-dmgdonebysource` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							//$this->db->query('INSERT INTO `v-raids-dmgdonebysource` (attemptid, charid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-dmgdonetoenemy
		$sql = 'INSERT INTO `v-raids-dmgdonetoenemy` (attemptid, npcid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-dmgdonetoenemy` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND npcid = ?');
		foreach($this->dmgDoneToEnemy as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1])){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $npcs[$key]));
							//$this->db->query('UPDATE `v-raids-dmgdonetoenemy` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND npcid = "'.$npcs[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $npcs[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							if (!$npcs[$key])
								print $this->userById[$key][1]."<br />";
							//$this->db->query('INSERT INTO `v-raids-dmgdonetoenemy` (attemptid, npcid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$npcs[$key].'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-dmgdonetofriendly
		$sql = 'INSERT INTO `v-raids-dmgdonetofriendly` (attemptid, charid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		// New updating mechanic || Given we want to merge
		// 1. Get table
		// 2. Check table for existing and non existing stuff
		// 3. If exist put statement into buffer
		// 4. If not exist put statement into the other buffer
		// => Replacing the update function reducing the amount of queries that have to be executed significantly for the price of lots of memory. RIP provider server :P
		// Step 1
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-dmgdonetofriendly`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, amount) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->dmgDoneToFriendly as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					$toUpdateTable[$row->attemptid][$row->charid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `v-raids-dmgdonetofriendly` SET amount = greatest(?, amount) WHERE attemptid = ? AND charid = ?');
		foreach($this->dmgDoneToFriendly as $k => $v){
			foreach($v as $key => $var){
				if (isset($var) && isset($charsByKey[$key])){
					if ($var>0){
						if (isset($toUpdateTable[$raidExistsAttempts[$k]]) && isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]) && $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]->amount<$var){
							$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]->id;
							$insertQueryUpdate[] = '(?, ?, ?, ?)';
							$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]->id;
							$insertDataUpdate[] = $raidExistsAttempts[$k];
							$insertDataUpdate[] = $charsByKey[$key];
							$insertDataUpdate[] = $var;
							//$ustmt->execute(array($var, $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `v-raids-dmgdonetofriendly` SET amount = greatest("'.$var.'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var;
							//$this->db->query('INSERT INTO `v-raids-dmgdonetofriendly` (attemptid, charid, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var.'")');
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		
		// v-raids-individual-dmgdonetoenemy
		$sql = 'INSERT INTO `v-raids-individual-dmgdonetoenemy` (attemptid, charid, npcid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-individual-dmgdonetoenemy`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, npcid, amount, active) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDmgDoneToEnemy as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->npcid] = $row;
				}
			}
		}
		//$ustmt = $this->db->prepare('UPDATE `v-raids-individual-dmgdonetoenemy` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND charid = ? AND npcid = ?');
		foreach($this->individualDmgDoneToEnemy as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1])){
						if ($var[1]>0){
							if (isset($npcs[$ke]) && isset($charsByKey[$key])){
								if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]) 
								&& ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount<$var[1] or $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active<$var[2])){
									if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id, $toDeleteUpdate)){
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id;
										$insertQueryUpdate[] = '(?,?,?,?,?,?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charsByKey[$key];
										$insertDataUpdate[] = $npcs[$ke];
										$insertDataUpdate[] = ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount<$var[1]) ? $var[1] : $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount;
										$insertDataUpdate[] = ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active<$var[2]) ? $var[2] : $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active;
									}
									
									//$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $charsByKey[$key], $npcs[$ke]));
									//$this->db->query('UPDATE `v-raids-individual-dmgdonetoenemy` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'" AND npcid = "'.$npcs[$ke].'"');
								}else{
									if (isset($attemptsWithDbId[$k][1])){
										$insertQuery[] = '(?, ?, ?, ?, ?)';
										$insertData[] = $attemptsWithDbId[$k][1];
										$insertData[] = $charsByKey[$key];
										$insertData[] = $npcs[$ke];
										$insertData[] = $var[1];
										$insertData[] = $var[2];
									}
									//$this->db->query('INSERT INTO `v-raids-individual-dmgdonetoenemy` (attemptid, charid, npcid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$npcs[$ke].'", "'.$var[1].'", "'.$var[2].'")');
								}
							}else{
								//print $this->userById[$ke][1]."<br />";
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		
		// v-raids-individual-dmgdonebyability
		$sql = 'INSERT INTO `v-raids-individual-dmgdonebyability` (attemptid, charid, abilityid, casts, hits, amount, crit, miss, parry, dodge, resist, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-individual-dmgdonebyability`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, abilityid, casts, hits, amount, crit, miss, parry, dodge, resist, npcid) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDmgDoneByAbility as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->npcid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->npcid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->npcid][$row->abilityid] = $row;
				}
			}
		}
		
		/*$ustmt = $this->db->prepare('UPDATE `v-raids-individual-dmgdonebyability` SET 
								casts = IF(?>amount, ?, casts),
								hits = IF(?>amount, ?, hits),
								crit = IF(?>amount, ?, crit),
								miss = IF(?>amount, ?, miss),
								parry = IF(?>amount, ?, parry),
								dodge = IF(?>amount, ?, dodge),
								resist = IF(?>amount, ?, resist),
								amount = greatest(?, amount) WHERE attemptid = ? AND charid = ? AND abilityid = ? AND npcid = ?');*/
		foreach($this->individualDmgDoneByAbility as $k => $v){ // attemptid
			foreach($v as $ke => $va){ // charid
				if (isset($charsByKey[$ke])){
					foreach($va as $qq => $ss){ //npcid
						if (isset($npcs[$qq])){
							//$ddteid = $this->db->query('SELECT id FROM `v-raids-individual-dmgdonetoenemy` WHERE attemptid = '.$attemptsWithDbId[$k][1].' AND npcid = '.$npcs[$qq].' AND charid = '.$charsByKey[$ke])->fetch()->id;
							foreach($ss as $key => $var){ // abilityid
								if (isset($var[3]) && isset($spells[$key])){
									if ($var[3]>0){
										if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
										&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
										&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]]) 
										&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][$spells[$key]]) 
										&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][$spells[$key]]->amount<$var[3]){
											if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][$spells[$key]]->id, $toDeleteUpdate)){
												$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][$spells[$key]]->id;
												$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][$spells[$key]]->id;
												$insertDataUpdate[] = $raidExistsAttempts[$k];
												$insertDataUpdate[] = $charsByKey[$ke];
												$insertDataUpdate[] = $spells[$key];
												$insertDataUpdate[] = $var[1];
												$insertDataUpdate[] = $var[2];
												$insertDataUpdate[] = $var[3];
												$insertDataUpdate[] = $var[5];
												$insertDataUpdate[] = $var[6];
												$insertDataUpdate[] = $var[7];
												$insertDataUpdate[] = $var[8];
												$insertDataUpdate[] = $var[9];
												$insertDataUpdate[] = $npcs[$qq];
											}
											
											//$ustmt->execute(array($var[3], $var[1], $var[3], $var[2], $var[3], $var[5], $var[3], $var[6], $var[3], $var[7], $var[3], $var[8], $var[3], $var[9], $var[3], $attemptsWithDbId[$k][1], $charsByKey[$ke], $spells[$key], $npcs[$qq]));
										}else{
											if (isset($attemptsWithDbId[$k][1]) && isset($charsByKey[$ke]) && isset($spells[$key]) && $spells[$key]<105000){
											$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
											$insertData[] = $attemptsWithDbId[$k][1];
											$insertData[] = $charsByKey[$ke];
											if ($spells[$key]<0 || $spells[$key]>60000)
												print $spells[$key]."<br />";
											$insertData[] = $spells[$key];
											$insertData[] = $var[1];
											$insertData[] = $var[2];
											$insertData[] = $var[3];
											$insertData[] = $var[5];
											$insertData[] = $var[6];
											$insertData[] = $var[7];
											$insertData[] = $var[8];
											$insertData[] = $var[9];
											$insertData[] = $npcs[$qq];
											}
											//$this->db->query('INSERT INTO `v-raids-individual-dmgdonebyability` (attemptid, charid, abilityid, casts, hits, amount, average, crit, miss, parry, dodge, resist) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'", "'.$var[5].'", "'.$var[6].'", "'.$var[7].'", "'.$var[8].'", "'.$var[9].'")');
										}
									}
								}else{
									print $this->abilitiesById[$key][1]."<br />";
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		
		/*// v-raids-graph-dmgdone
		$sql = 'INSERT INTO `v-raids-graph-dmgdone` (attemptid, time, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('SELECT * FROM `v-raids-graph-dmgdone` WHERE attemptid = ?');
		$ustmtw = $this->db->prepare('UPDATE `v-raids-graph-dmgdone` SET time = ?, amount = ? WHERE attemptid = ?;');
		foreach($this->getGraphStrings($this->graphdmgdone, $mergeBoolean, $attemptsWithDbId) as $k => $v){
			if (!isset($raidExistsAttempts[$k])){
				$insertQuery[] = '(?, ?, ?)';
				$insertData[] = $attemptsWithDbId[$k][1];
				$insertData[] = $v[1];
				$insertData[] = $v[2];
				//$this->db->query('INSERT INTO `v-raids-graph-dmgdone` (attemptid, time, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$v[1].'", "'.$v[2].'")');
			/*}else{
				$ustmt->execute(array($raidExistsAttempts[$k]));
				$q = $ustmt->fetch();
				//$q = $this->db->query('SELECT * FROM `v-raids-graph-dmgdone` WHERE attemptid = "'.$raidExistsAttempts[$k].'"')->fetch();
				if (isset($q->time)){
					$strings = $this->mergeGraphs($q, $v);
					$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$k]));
					//$this->db->query('UPDATE `v-raids-graph-dmgdone` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$k].'";');
				}/
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		
		// v-raids-graph-individual-dmgdone
		$sql = 'INSERT INTO `v-raids-graph-individual-dmgdone` (attemptid, time, amount, charid, abilityid, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		//$ustmt = $this->db->prepare('SELECT * FROM `v-raids-graph-individual-dmgdone` WHERE attemptid = ? AND charid = ? AND abilityid = ?');
		//$ustmtw = $this->db->prepare('UPDATE `v-raids-graph-individual-dmgdone` SET time = ?, amount = ? WHERE attemptid = ? AND charid = ? AND abilityid = ?;');
		foreach($this->graphindividualdmgdone as $k => $v){
			if (isset($charsByKey[$k])){
				foreach($v as $ke => $va){
					foreach($va as $keys => $vars){
						foreach($this->getGraphStrings($vars, $mergeBoolean, null, $attemptsWithDbId[$ke][8]) as $key => $var){
							if (!isset($raidExistsAttempts[$ke]) && isset($attemptsWithDbId[$ke][1]) && isset($npcs[$keys])){
								$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$ke][1];
								$insertData[] = $var[1];
								$insertData[] = $var[2];
								$insertData[] = $charsByKey[$k];
								$insertData[] = $spells[$key];
								$insertData[] = $npcs[$keys];
								//$this->db->query('INSERT INTO `v-raids-graph-individual-dmgdone` (attemptid, time, amount, charid) VALUES ("'.$attemptsWithDbId[$key][1].'", "'.$var[1].'", "'.$var[2].'", "'.$charsByKey[$k].'")');
							/*}else{
								$ustmt->execute(array($raidExistsAttempts[$ke], $charsByKey[$k], $spells[$key]));
								$q = $ustmt->fetch();
								//$q = $this->db->query('SELECT * FROM `v-raids-graph-individual-dmgdone` WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'"')->fetch();
								if (isset($q->time)){
									$strings = $this->mergeGraphs($q, $var);
									$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$ke], $charsByKey[$k], $spells[$key]));
									//$this->db->query('UPDATE `v-raids-graph-individual-dmgdone` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'";');
								}*/
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		////gc_collect_cycles();
		
		//graphindividualfriendlyfire
		$sql = 'INSERT INTO `v-raids-graph-individual-friendlyfire` (attemptid, time, amount, charid, abilityid, culpritid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		//$ustmt = $this->db->prepare('SELECT * FROM `v-raids-graph-individual-dmgdone` WHERE attemptid = ? AND charid = ? AND abilityid = ?');
		//$ustmtw = $this->db->prepare('UPDATE `v-raids-graph-individual-dmgdone` SET time = ?, amount = ? WHERE attemptid = ? AND charid = ? AND abilityid = ?;');
		foreach($this->graphindividualfriendlyfire as $k => $v){
			if (isset($charsByKey[$k])){
				foreach($v as $ke => $va){
					foreach($va as $keys => $vars){
						foreach($this->getGraphStrings($vars, $mergeBoolean, null, $attemptsWithDbId[$ke][8]) as $key => $var){
							if (!isset($raidExistsAttempts[$ke]) && isset($attemptsWithDbId[$ke][1])){
								$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$ke][1];
								$insertData[] = $var[1];
								$insertData[] = $var[2];
								$insertData[] = $charsByKey[$k];
								$insertData[] = $spells[$key];
								$insertData[] = $charsByKey[$keys];
								//$this->db->query('INSERT INTO `v-raids-graph-individual-dmgdone` (attemptid, time, amount, charid) VALUES ("'.$attemptsWithDbId[$key][1].'", "'.$var[1].'", "'.$var[2].'", "'.$charsByKey[$k].'")');
							/*}else{
								$ustmt->execute(array($raidExistsAttempts[$ke], $charsByKey[$k], $spells[$key]));
								$q = $ustmt->fetch();
								//$q = $this->db->query('SELECT * FROM `v-raids-graph-individual-dmgdone` WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'"')->fetch();
								if (isset($q->time)){
									$strings = $this->mergeGraphs($q, $var);
									$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$ke], $charsByKey[$k], $spells[$key]));
									//$this->db->query('UPDATE `v-raids-graph-individual-dmgdone` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'";');
								}*/
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		////gc_collect_cycles();
		
		
		
		$sql = 'INSERT INTO `v-raids-casts` (attemptid, charid, tarid, abilityid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-casts`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, tarid, abilityid, amount) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->casts as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->tarid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->tarid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->tarid][$row->abilityid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `v-raids-casts` SET amount = greatest(?, amount) WHERE attemptid = ? AND charid = ? AND tarid = ? AND abilityid = ?');
		foreach($this->casts as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						foreach($var as $keys => $vars){
							if (isset($spells[$keys]) && floor($vars) > 0 && $this->abilitiesById[$keys][1] != $spellsTra["AutoAttack"] && $this->abilitiesById[$keys][1] != $spellsTra["Auto Shot"]){
								$npppcid = (isset($npcs[$key])) ? $npcs[$key] : $charsByKey[$key];
								if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid][$spells[$keys]]) 
								&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid][$spells[$keys]]->amount<$vars){
									if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid][$spells[$keys]]->id, $toDeleteUpdate)){
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid][$spells[$keys]]->id;
										$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid][$spells[$keys]]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charsByKey[$ke];
										$insertDataUpdate[] = $npppcid;
										$insertDataUpdate[] = $spells[$keys];
										$insertDataUpdate[] = $vars;
									}
								}else{
									if (isset($attemptsWithDbId[$k][1])){
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = $npppcid;
									$insertData[] = $spells[$keys];
									$insertData[] = $vars;
									}
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		print "37 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 70 WHERE id = '.$cronid);
		
		// Damage taken
		/*
		* All of them have to be tested
		* Note: DmgTaken is very similiar to dmg done
		*
		* dmgTakenBySource[attemptid][charid] = Array(1 => amount, 2 => active);
		* dmgTakenFromAbility[attemptid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 =>resist, 10 => crush, 11 => block);
		* dmgTakenFromSource[attemptid][npcid/charid] = Array(1 => type(char or npc), 2 => amount, 3 => active);
		* individualDmgTakenByAbility[attemptid][charid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => block, 6 => crit, 7 => miss, 8 => parry, 9 => dodge, 10 => resist, 11 => crush);
		* individualDmgTakenBySource[attemptid][npcid][charid] = Array(1 => amount, 2 => active);
		* individualDmgTakenByPlayer[attemptid][charid][culpritid] = amount;
		*/
		/*// v-raids-dmgtakenbysource
		$sql = 'INSERT INTO `v-raids-dmgtakenbysource` (attemptid, charid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-dmgtakenbysource` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND charid = ?');
		foreach($this->dmgTakenBySource as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset($charsByKey[$key])){
					if ($var[1]>0){ 
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `v-raids-dmgtakenbysource` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							//$this->db->query('INSERT INTO `v-raids-dmgtakenbysource` (attemptid, charid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-dmgtakenfromability
		$sql = 'INSERT INTO `v-raids-dmgtakenfromability` (attemptid, abilityid, amount, casts, hits, crit, miss, parry, dodge, resist, crush, block, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-dmgtakenfromability` SET 
								casts = IF(?>amount, ?, casts),
								hits = IF(?>amount, ?, hits),
								crit = IF(?>amount, ?, crit),
								miss = IF(?>amount, ?, miss),
								parry = IF(?>amount, ?, parry),
								dodge = IF(?>amount, ?, dodge),
								resist = IF(?>amount, ?, resist),
								crush = IF(?>amount, ?, crush),
								block = IF(?>amount, ?, block),
								amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ? AND npcid = ?');
		foreach($this->dmgTakenFromAbility as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1])){
						if ($var[1]>0){
							if (isset($raidExistsAttempts[$k])){
								$ustmt->execute(array($var[1], $var[3], $var[1], $var[4], $var[1], $var[5], $var[1], $var[6], $var[1], $var[7], $var[1], $var[8], $var[1], $var[9], $var[1], $var[10], $var[1], $var[11], $var[1], $raidExistsAttempts[$k], $spells[$ke], $npcs[$key]));
								/*$this->db->query('UPDATE `v-raids-dmgtakenfromability` SET 
									average = IF("'.$var[1].'">amount, "'.$var[2].'", average),
									casts = IF("'.$var[1].'">amount, "'.$var[3].'", casts),
									hits = IF("'.$var[1].'">amount, "'.$var[4].'", hits),
									crit = IF("'.$var[1].'">amount, "'.$var[5].'", crit),
									miss = IF("'.$var[1].'">amount, "'.$var[6].'", miss),
									parry = IF("'.$var[1].'">amount, "'.$var[7].'", parry),
									dodge = IF("'.$var[1].'">amount, "'.$var[8].'", dodge),
									resist = IF("'.$var[1].'">amount, "'.$var[9].'", resist),
									crush = IF("'.$var[1].'">amount, "'.$var[10].'", crush),
									block = IF("'.$var[1].'">amount, "'.$var[11].'", block),
									amount = greatest("'.$var[1].'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'"');/
							}else{
								$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$k][1];
								$insertData[] = $spells[$ke];
								$insertData[] = $var[1];
								$insertData[] = $var[3];
								$insertData[] = $var[4];
								$insertData[] = $var[5];
								$insertData[] = $var[6];
								$insertData[] = $var[7];
								$insertData[] = $var[8];
								$insertData[] = $var[9];
								$insertData[] = $var[10];
								$insertData[] = $var[11];
								$insertData[] = $npcs[$key];
								//$this->db->query('INSERT INTO `v-raids-dmgtakenfromability` (attemptid, abilityid, amount, average, casts, hits, crit, miss, parry, dodge, resist, crush, block) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'", "'.$var[5].'", "'.$var[6].'", "'.$var[7].'" ,"'.$var[8].'", "'.$var[9].'", "'.$var[10].'", "'.$var[11].'")');
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-dmgtakenfromsource
		$sql = 'INSERT INTO `v-raids-dmgtakenfromsource` (attemptid, type, typeid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-dmgtakenfromsource` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND typeid = ?');
		foreach($this->dmgTakenFromSource as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[2])){
					if ($var[2]>0){
						if (isset($raidExistsAttempts[$k])){
							// I did not use type here.
							$ustmt->execute(array($var[2], $var[3], $raidExistsAttempts[$k], $npcs[$key]));
							//$this->db->query('UPDATE `v-raids-dmgtakenfromsource` SET amount = greatest("'.$var[2].'", amount), active = greatest("'.$var[3].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND typeid = "'.$npcs[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $var[1];
							$insertData[] = $npcs[$key];
							$insertData[] = $var[2];
							$insertData[] = $var[3];
							//$this->db->query('INSERT INTO `v-raids-dmgtakenfromsource` (attemptid, type, typeid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$var[1].'", "'.$npcs[$key].'", "'.$var[2].'", "'.$var[3].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-individual-dmgtakenbyability
		$sql = 'INSERT INTO `v-raids-individual-dmgtakenfromability` (attemptid, charid, abilityid, casts, hits, amount, block, crit, miss, parry, dodge, resist, crush, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-individual-dmgtakenfromability`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, abilityid, casts, hits, amount, block, crit, miss, parry, dodge, resist, crush, npcid) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDmgTakenByAbility as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->npcid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->npcid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->npcid][$row->abilityid] = $row;
				}
			}
		}
		
		/*$ustmt = $this->db->prepare('UPDATE `v-raids-individual-dmgtakenfromability` SET 
								casts = IF(?>amount, ?, casts),
								hits = IF(?>amount, ?, hits),
								crit = IF(?>amount, ?, crit),
								miss = IF(?>amount, ?, miss),
								parry = IF(?>amount, ?, parry),
								dodge = IF(?>amount, ?, dodge),
								resist = IF(?>amount, ?, resist),
								crush = IF(?>amount, ?, crush),
								block = IF(?>amount, ?, block),
								amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ? AND charid = ? AND npcid = ?');*/
		foreach($this->individualDmgTakenByAbility as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						foreach($var as $keys => $vars){
							if (isset($vars[3])){
								if ($vars[3]>0){
									if (isset($raidExistsAttempts[$k]) && isset($toUpdateTable[$raidExistsAttempts[$k]]) 
									&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
									&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]]) 
									&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]][$spells[$key]]) 
									&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]][$spells[$key]]->amount<$vars[3]){
										if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]][$spells[$key]]->id, $toDeleteUpdate)){
											$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]][$spells[$key]]->id;
											$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
											$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]][$spells[$key]]->id;
											$insertDataUpdate[] = $raidExistsAttempts[$k];
											$insertDataUpdate[] = $charsByKey[$ke];
											$insertDataUpdate[] = $spells[$key];
											$insertDataUpdate[] = $vars[1];
											$insertDataUpdate[] = $vars[2];
											$insertDataUpdate[] = $vars[3];
											$insertDataUpdate[] = $vars[5];
											$insertDataUpdate[] = $vars[6];
											$insertDataUpdate[] = $vars[7];
											$insertDataUpdate[] = $vars[8];
											$insertDataUpdate[] = $vars[9];
											$insertDataUpdate[] = $vars[10];
											$insertDataUpdate[] = $vars[11];
											$insertDataUpdate[] = $npcs[$keys];
										}
										
										
										//$ustmt->execute(array($vars[3], $vars[1], $vars[3], $vars[2], $vars[3], $vars[6], $vars[3], $vars[7], $vars[3], $vars[8], $vars[3], $vars[9], $vars[3], $vars[10], $vars[3], $vars[11], $vars[3], $vars[5], $vars[3], $raidExistsAttempts[$k], $spells[$key], $charsByKey[$ke], $npcs[$keys]));
										/*$this->db->query('UPDATE `v-raids-individual-dmgtakenfromability` SET 
										average = IF("'.$vars[3].'">amount, "'.$vars[4].'", average),
										casts = IF("'.$vars[3].'">amount, "'.$vars[1].'", casts),
										hits = IF("'.$vars[3].'">amount, "'.$vars[2].'", hits),
										crit = IF("'.$vars[3].'">amount, "'.$vars[6].'", crit),
										miss = IF("'.$vars[3].'">amount, "'.$vars[7].'", miss),
										parry = IF("'.$vars[3].'">amount, "'.$vars[8].'", parry),
										dodge = IF("'.$vars[3].'">amount, "'.$vars[9].'", dodge),
										resist = IF("'.$vars[3].'">amount, "'.$vars[10].'", resist),
										crush = IF("'.$vars[3].'">amount, "'.$vars[11].'", crush),
										block = IF("'.$vars[3].'">amount, "'.$vars[5].'", block),
										amount = greatest("'.$vars[3].'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'" AND charid = "'.$charsByKey[$ke].'"');*/
									}else{
										if (isset($attemptsWithDbId[$k][1])){
											$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
											$insertData[] = $attemptsWithDbId[$k][1];
											$insertData[] = $charsByKey[$ke];
											$insertData[] = $spells[$key];
											$insertData[] = $vars[1];
											$insertData[] = $vars[2];
											$insertData[] = $vars[3];
											$insertData[] = $vars[5];
											$insertData[] = $vars[6];
											$insertData[] = $vars[7];
											$insertData[] = $vars[8];
											$insertData[] = $vars[9];
											$insertData[] = $vars[10];
											$insertData[] = $vars[11];
											$insertData[] = $npcs[$keys];
										}
										//$this->db->query('INSERT INTO `v-raids-individual-dmgtakenfromability` (attemptid, charid, abilityid, casts, hits, amount, average, block, crit, miss, parry, dodge, resist, crush) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$spells[$key].'", "'.$vars[1].'", "'.$vars[2].'", "'.$vars[3].'", "'.$vars[4].'", "'.$vars[5].'", "'.$vars[6].'", "'.$vars[7].'", "'.$vars[8].'", "'.$vars[9].'", "'.$vars[10].'", "'.$vars[11].'")');
									}
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		// v-raids-individual-dmgtakenbyplayer
		$sql = 'INSERT INTO `v-raids-individual-dmgtakenbyplayer` (attemptid, charid, culpritid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-individual-dmgtakenbyplayer`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, culpritid, amount) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDmgTakenByPlayer as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->culpritid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `v-raids-individual-dmgtakenbyplayer` SET amount = greatest(?, amount) WHERE attemptid = ? AND charid = ? AND culpritid = ?');
		foreach($this->individualDmgTakenByPlayer as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var) && isset($charsByKey[$ke]) && isset($charsByKey[$key])){
						if ($var>0 && isset($attemptsWithDbId[$k][1])){
							if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]]) 
							&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]]->amount<$var){
								if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]]->id, $toDeleteUpdate)){
									$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]]->id;
									$insertQueryUpdate[] = '(?, ?, ?, ?, ?)';
									$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]]->id;
									$insertDataUpdate[] = $raidExistsAttempts[$k];
									$insertDataUpdate[] = $charsByKey[$ke];
									$insertDataUpdate[] = $charsByKey[$key];
									$insertDataUpdate[] = $var;
								}
								
								//$ustmt->execute(array($var, $raidExistsAttempts[$k], $charsByKey[$ke], $charsByKey[$key]));
								//$this->db->query('UPDATE `v-raids-individual-dmgtakenbyplayer` SET amount = greatest("'.$var.'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$ke].'" AND culpritid = "'.$charsByKey[$key].'"');
							}else{
								if (isset($attemptsWithDbId[$k][1])){
								$insertQuery[] = '(?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$k][1];
								$insertData[] = $charsByKey[$ke];
								$insertData[] = $charsByKey[$key];
								$insertData[] = $var;
								}
								//$this->db->query('INSERT INTO `v-raids-individual-dmgtakenbyplayer` (attemptid, charid, culpritid, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$charsByKey[$key].'", "'.$var.'")');
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		// v-raids-individual-dmgtakenbysource
		$sql = 'INSERT INTO `v-raids-individual-dmgtakenfromsource` (attemptid, charid, npcid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-individual-dmgtakenfromsource`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, npcid, amount, active) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDmgTakenBySource as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->npcid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `v-raids-individual-dmgtakenfromsource` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND charid = ? AND npcid = ?');
		foreach($this->individualDmgTakenBySource as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1]) && isset($charsByKey[$key])){
						if ($var[1]>0){
							if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]) 
							&& ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount<$var[1] or $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active<$var[2])){
								if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id, $toDeleteUpdate)){
									$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id;
									$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
									$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id;
									$insertDataUpdate[] = $raidExistsAttempts[$k];
									$insertDataUpdate[] = $charsByKey[$key];
									$insertDataUpdate[] = $npcs[$ke];
									$insertDataUpdate[] = ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount<$var[1]) ? $var[1] : $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount;
									$insertDataUpdate[] = ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active<$var[2]) ? $var[2] : $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active;
								}
								//$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $charsByKey[$key], $npcs[$ke]));
								//$this->db->query('UPDATE `v-raids-individual-dmgtakenfromsource` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'" AND typeid = "'.$npcs[$ke].'"');
							}else{
								if (isset($attemptsWithDbId[$k][1])){
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$key];
									$insertData[] = $npcs[$ke];
									$insertData[] = $var[1];
									$insertData[] = $var[2];
								}
								//$this->db->query('INSERT INTO `v-raids-individual-dmgtakenfromsource` (attemptid, charid, typeid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$npcs[$ke].'", "'.$var[1].'", "'.$var[2].'")');
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		/*// v-raids-graph-dmgtaken
		$sql = 'INSERT INTO `v-raids-graph-dmgtaken` (attemptid, time, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('SELECT * FROM `v-raids-graph-dmgtaken` WHERE attemptid = ?');
		$ustmtw = $this->db->prepare('UPDATE `v-raids-graph-dmgtaken` SET time = ?, amount = ? WHERE attemptid = ?;');
		foreach($this->getGraphStrings($this->graphdmgtaken, $mergeBoolean, $attemptsWithDbId) as $k => $v){
			if (!isset($raidExistsAttempts[$k])){
				$insertQuery[] = '(?, ?, ?)';
				$insertData[] = $attemptsWithDbId[$k][1];
				$insertData[] = $v[1];
				$insertData[] = $v[2];
				//$this->db->query('INSERT INTO `v-raids-graph-dmgtaken` (attemptid, time, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$v[1].'", "'.$v[2].'")');
			/*}else{
				$ustmt->execute(array($raidExistsAttempts[$k]));
				$q = $ustmt->fetch();
				//$q = $this->db->query('SELECT * FROM `v-raids-graph-dmgtaken` WHERE attemptid = "'.$raidExistsAttempts[$k].'"')->fetch();
				if (isset($q->time)){
					$strings = $this->mergeGraphs($q, $v);
					$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$k]));
					//$this->db->query('UPDATE `v-raids-graph-dmgtaken` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$k].'";');
				}/
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-graph-individual-dmgtaken
		$sql = 'INSERT INTO `v-raids-graph-individual-dmgtaken` (attemptid, time, amount, charid, abilityid, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		//$ustmt = $this->db->prepare('SELECT * FROM `v-raids-graph-individual-dmgtaken` WHERE attemptid = ? AND charid = ? AND abilityid = ?');
		//$ustmtw = $this->db->prepare('UPDATE `v-raids-graph-individual-dmgtaken` SET time = ?, amount = ? WHERE attemptid = ? AND charid = ? AND abilityid = ?;');
		foreach($this->graphindividualdmgtaken as $k => $v){
			if (isset($charsByKey[$k])){
				foreach($v as $ke => $va){
					foreach($va as $keys => $vars){
						foreach($this->getGraphStrings($vars, $mergeBoolean, null, $attemptsWithDbId[$ke][8]) as $key => $var){
							if (!isset($raidExistsAttempts[$ke]) && isset($attemptsWithDbId[$ke][1])){
								$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$ke][1];
								$insertData[] = $var[1];
								$insertData[] = $var[2];
								$insertData[] = $charsByKey[$k];
								$insertData[] = $spells[$keys];
								$insertData[] = $npcs[$key];
								//$this->db->query('INSERT INTO `v-raids-graph-individual-dmgtaken` (attemptid, time, amount, charid) VALUES ("'.$attemptsWithDbId[$key][1].'", "'.$var[1].'", "'.$var[2].'", "'.$charsByKey[$k].'")');
							/*}else{
								$ustmt->execute(array($raidExistsAttempts[$ke], $charsByKey[$k], $spells[$key]));
								$q = $ustmt->fetch();
								//$q = $this->db->query('SELECT * FROM `v-raids-graph-individual-dmgtaken` WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'"')->fetch();
								if (isset($q->time)){
									$strings = $this->mergeGraphs($q, $var);
									$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$ke], $charsByKey[$k], $spells[$key]));
									//$this->db->query('UPDATE `v-raids-graph-individual-dmgtaken` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'";');
								}*/
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		////gc_collect_cycles();
		print "38 done <br />";
		
		// Healing done
		/*
		* All of them have to be tested
		*
		* healingBySource[attemptid][charid] = Array(1 => tamount, 2 => eamount, 3 => absorbed, 4 => active);
		* healingByAbility[attemptid][abilityid] = Array(1 => casts, 2 => tamount, 3 => eamount, 4 => average, 5 => crit);
		* healingToFriendly[attemptid][charid] = Array(1 => tamount, 2 => eamount, 3 => absorbed, 4 => active);
		* individualHealingToFriendly[attemptid][charid][tarid] = Array(1 => tamount, 2 => eamount);
		* individualHealingByAbility[attemptid][charid][abilityid] = Array(1 => tamount, 2 => eamount, 3 => taverage, 4 => eaverage, 5 => hits, 6 => crit);
		*/
		/*// v-raids-healingbyability
		$sql = 'INSERT INTO `v-raids-healingbyability` (attemptid, abilityid, casts, tamount, eamount, crit) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-healingbyability` SET 
								casts = IF(?>tamount, ?, casts),
								crit = IF(?>tamount, ?, crit),
								tamount = greatest(?, tamount), 
								eamount = greatest(?, eamount) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->healingByAbility as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[2]) and isset($var[3]) && isset($spells[$key])){
					if ($var[2]>0 || $var[3]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[2], $var[1], $var[2], $var[5], $var[2], $var[3], $raidExistsAttempts[$k], $spells[$key]));
							/*$this->db->query('UPDATE `v-raids-healingbyability` SET 
								casts = IF("'.$var[2].'">tamount, "'.$var[1].'", casts),
								average = IF("'.$var[2].'">tamount, "'.$var[4].'", average),
								crit = IF("'.$var[2].'">tamount, "'.$var[5].'", crit),
								tamount = greatest("'.$var[2].'", tamount), 
								eamount = greatest("'.$var[3].'", eamount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'"');/
						}else{
							$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $spells[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $var[3];
							$insertData[] = $var[5];
							//$this->db->query('INSERT INTO `v-raids-healingbyability` (attemptid, abilityid, casts, tamount, eamount, average, crit) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'" , "'.$var[4].'", "'.$var[5].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-healingbysource
		$sql = 'INSERT INTO `v-raids-healingbysource` (attemptid, charid, tamount, eamount, absorbed, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-healingbysource` SET tamount = greatest(?, tamount), eamount = greatest(?, eamount), absorbed = greatest(?, absorbed), active = greatest(?, active) WHERE attemptid = ? AND charid = ?');
		foreach($this->healingBySource as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) and isset($var[2]) && isset($charsByKey[$key])){
					if ($var[1]>0 || $var[2]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $var[3], $var[4], $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `v-raids-healingbysource` SET tamount = greatest("'.$var[1].'", tamount), eamount = greatest("'.$var[2].'", eamount), absorbed = greatest("'.$var[3].'", absorbed), active = greatest("'.$var[4].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $var[3];
							$insertData[] = $var[4];
							//$this->db->query('INSERT INTO `v-raids-healingbysource` (attemptid, charid, tamount, eamount, absorbed, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-healingtofriendly
		$sql = 'INSERT INTO `v-raids-healingtofriendly` (attemptid, charid, tamount, eamount, absorbed, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-healingtofriendly` SET tamount = greatest(?, tamount), eamount = greatest(?, eamount), absorbed = greatest(?, absorbed), active = greatest(?, active) WHERE attemptid = ? AND charid = ?');
		foreach($this->healingToFriendly as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) and isset($var[2]) && isset($charsByKey[$key])){
					if ($var[1]>0 and $var[2]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $var[3], $var[4], $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `v-raids-healingtofriendly` SET tamount = greatest("'.$var[1].'", tamount), eamount = greatest("'.$var[2].'", eamount), absorbed = greatest("'.$var[3].'", absorbed), active = greatest("'.$var[4].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $var[3];
							$insertData[] = $var[4];
							//$this->db->query('INSERT INTO `v-raids-healingtofriendly` (attemptid, charid, tamount, eamount, absorbed, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-individual-healingbyability
		$sql = 'INSERT INTO `v-raids-individual-healingbyability` (attemptid, charid, abilityid, tamount, eamount, casts, crit, tarid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-individual-healingbyability`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, abilityid, tamount, eamount, casts, crit, tarid) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualHealingByAbility as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->tarid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->tarid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->tarid][$row->abilityid] = $row;
				}
			}
		}
		
		/*$ustmt = $this->db->prepare('UPDATE `v-raids-individual-healingbyability` SET 
									casts = IF(?>tamount, ?, casts),
									crit = IF(?>tamount, ?, crit),
									tamount = greatest(?, tamount), 
									eamount = greatest(?, eamount) WHERE attemptid = ? AND abilityid = ? AND charid = ? AND tarid = ?');*/
		foreach($this->individualHealingByAbility as $k => $v){
			foreach($v as $ke => $va){ // charid
				foreach($va as $qq => $ss){ //tarid
					foreach($ss as $key => $var){
						if (isset($var[1]) and isset($var[2]) && isset($spells[$key])){
							if ($var[1]>0 and $var[2]>0){
								if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][$spells[$key]]) 
								&& ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][$spells[$key]]->tamount<$var[1] or $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][$spells[$key]]->eamount<$var[2])){
									if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][$spells[$key]]->id, $toDeleteUpdate)){
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][$spells[$key]]->id;
										$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][$spells[$key]]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charsByKey[$ke];
										$insertDataUpdate[] = $spells[$key];
										$insertDataUpdate[] = $var[1];
										$insertDataUpdate[] = $var[2];
										$insertDataUpdate[] = $var[5];
										$insertDataUpdate[] = $var[6];
										$insertDataUpdate[] = $charsByKey[$qq];
									}
									//$ustmt->execute(array($var[1], $var[5], $var[1], $var[6], $var[1], $var[2], $raidExistsAttempts[$k], $spells[$key], $charsByKey[$ke], $charsByKey[$qq]));
									/*$this->db->query('UPDATE `v-raids-individual-healingbyability` SET 
										casts = IF("'.$var[1].'">tamount, "'.$var[5].'", casts),
										average = IF("'.$var[1].'">tamount, "'.$var[3].'", average),
										crit = IF("'.$var[1].'">tamount, "'.$var[6].'", crit),
										tamount = greatest("'.$var[1].'", tamount), 
										eamount = greatest("'.$var[2].'", eamount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'" AND charid = "'.$charsByKey[$ke].'"');*/
								}else{
									if (isset($attemptsWithDbId[$k][1])){
									if (isset($charsByKey[$ke])){
									$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = $spells[$key];
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									$insertData[] = $var[5];
									$insertData[] = $var[6];
									$insertData[] = $charsByKey[$qq];
									
									}}
									//$this->db->query('INSERT INTO `v-raids-individual-healingbyability` (attemptid, charid, abilityid, tamount, eamount, average, casts, crit) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[5].'", "'.$var[6].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		// v-raids-individual-healingtofriendly
		$sql = 'INSERT INTO `v-raids-individual-healingtofriendly` (attemptid, charid, tarid, tamount, eamount, absorbed, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-individual-healingtofriendly`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, tarid, tamount, eamount, absorbed, active) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualHealingToFriendly as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->tarid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `v-raids-individual-healingtofriendly` SET tamount = greatest(?, tamount), eamount = greatest(?, eamount) WHERE attemptid = ? AND charid = ? AND tarid = ?');
		foreach($this->individualHealingToFriendly as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1]) and isset($var[2])){
						if (($var[1]>0 and $var[2]>0) or $var[4]>0){
							$charid1 = (isset($charsByKey[$key])) ? $charsByKey[$key] : 0;
							$charid2 = (isset($charsByKey[$ke])) ? $charsByKey[$ke] : 0;
							if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charid1]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]) 
							&& ($toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]->tamount<$var[1] or $toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]->eamount<$var[2])){
								if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]->id, $toDeleteUpdate)){
									if (isset($raidExistsAttempts[$k])){
										if (!isset($var[4]))
											$var[4] = 0;
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]->id;
										$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?, ?, ?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charid1;
										$insertDataUpdate[] = $charid2;
										$insertDataUpdate[] = $var[1];
										$insertDataUpdate[] = $var[2];
										$insertDataUpdate[] = $var[4];
										$insertDataUpdate[] = $var[5];
									}
								}
								
								//$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $charsByKey[$ke], $charsByKey[$key]));
								//$this->db->query('UPDATE `v-raids-individual-healingtofriendly` SET tamount = greatest("'.$var[1].'", tamount), eamount = greatest("'.$var[2].'", eamount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$ke].'" AND tarid = "'.$charsByKey[$key].'"');
							}else{
								if (isset($attemptsWithDbId[$k][1])){
									if (!isset($var[4]))
										$var[4] = 0;
									$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charid1;
									$insertData[] = $charid2;
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									$insertData[] = $var[4];
									$insertData[] = $var[5];
								}
								//$this->db->query('INSERT INTO `v-raids-individual-healingtofriendly` (attemptid, charid, tarid, tamount, eamount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.($r = (isset($charsByKey[$ke])) ? $charsByKey[$ke] : 0).'", "'.$var[1].'", "'.$var[2].'")');
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		
		/*// v-raids-graph-healingdone
		$sql = 'INSERT INTO `v-raids-graph-healingdone` (attemptid, time, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('SELECT * FROM `v-raids-graph-healingdone` WHERE attemptid = ?');
		$ustmtw = $this->db->prepare('UPDATE `v-raids-graph-healingdone` SET time = ?, amount = ? WHERE attemptid = ?;');
		foreach($this->getGraphStrings($this->graphhealingdone, $mergeBoolean, $attemptsWithDbId) as $k => $v){
			if (!isset($raidExistsAttempts[$k])){
				$insertQuery[] = '(?, ?, ?)';
				$insertData[] = $attemptsWithDbId[$k][1];
				$insertData[] = $v[1];
				$insertData[] = $v[2];
				//$this->db->query('INSERT INTO `v-raids-graph-healingdone` (attemptid, time, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$v[1].'", "'.$v[2].'")');
			/*}else{
				$ustmt->execute(array($raidExistsAttempts[$k]));
				$q = $ustmt->fetch();
				//$q = $this->db->query('SELECT * FROM `v-raids-graph-healingdone` WHERE attemptid = "'.$raidExistsAttempts[$k].'"')->fetch();
				if (isset($q->time)){
					$strings = $this->mergeGraphs($q, $v);
					$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$k]));
					//$this->db->query('UPDATE `v-raids-graph-healingdone` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$k].'";');
				}/
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-graph-individual-healingdone
		$sql = 'INSERT INTO `v-raids-graph-individual-healingdone` (attemptid, time, amount, charid, abilityid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('SELECT * FROM `v-raids-graph-individual-healingdone` WHERE attemptid = ? AND charid = ? AND abilityid = ?');
		$ustmtw = $this->db->prepare('UPDATE `v-raids-graph-individual-healingdone` SET time = ?, amount = ? WHERE attemptid = ? AND charid = ? AND abilityid = ?;');
		foreach($this->graphindividualhealingdone as $k => $v){
			if (isset($charsByKey[$k])){
				foreach($v as $ke => $va){
					foreach($this->getGraphStrings($va, $mergeBoolean, null, $attemptsWithDbId[$ke][8]) as $key => $var){
						if (!isset($raidExistsAttempts[$ke])){
							$insertQuery[] = '(?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$ke][1];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $charsByKey[$k];
							$insertData[] = $spells[$key];
							//$this->db->query('INSERT INTO `v-raids-graph-individual-healingdone` (attemptid, time, amount, charid) VALUES ("'.$attemptsWithDbId[$key][1].'", "'.$var[1].'", "'.$var[2].'", "'.$charsByKey[$k].'")');
						/*}else{
							$ustmt->execute(array($raidExistsAttempts[$ke], $charsByKey[$k], $spells[$key]));
							$q = $ustmt->fetch();
							//$q = $this->db->query('SELECT * FROM `v-raids-graph-individual-healingdone` WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'"')->fetch();
							if (isset($q->time)){
								$strings = $this->mergeGraphs($q, $var);
								$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$ke], $charsByKey[$k], $spells[$key]));
								//$this->db->query('UPDATE `v-raids-graph-individual-healingdone` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'";');
							}/
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-graph-individual-healingreceived
		$sql = 'INSERT INTO `v-raids-graph-individual-healingreceived` (attemptid, time, amount, charid, abilityid, sourceid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		//$ustmt = $this->db->prepare('SELECT * FROM `v-raids-graph-individual-healingreceived` WHERE attemptid = ? AND charid = ? AND abilityid = ?');
		//$ustmtw = $this->db->prepare('UPDATE `v-raids-graph-individual-healingreceived` SET time = ?, amount = ? WHERE attemptid = ? AND charid = ? AND abilityid = ?;');
		foreach($this->graphindividualhealingreceived as $k => $v){ // user
			if (isset($charsByKey[$k])){
				foreach($v as $ke => $va){ // attemptid
					foreach($va as $key => $var){ // abilityid
						foreach($this->getGraphStrings($var, $mergeBoolean, null, $attemptsWithDbId[$ke][8]) as $keys => $vars){
							if (!isset($raidExistsAttempts[$ke]) && isset($attemptsWithDbId[$ke][1]) && isset($charsByKey[$keys])){
								$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$ke][1];
								$insertData[] = $vars[1];
								$insertData[] = $vars[2];
								$insertData[] = $charsByKey[$k];
								$insertData[] = $spells[$key];
								$insertData[] = $charsByKey[$keys];
								//$this->db->query('INSERT INTO `v-raids-graph-individual-healingreceived` (attemptid, time, amount, charid) VALUES ("'.$attemptsWithDbId[$key][1].'", "'.$var[1].'", "'.$var[2].'", "'.$charsByKey[$k].'")');
							/*}else{
								$ustmt->execute(array($raidExistsAttempts[$ke], $charsByKey[$k], $spells[$key]));
								$q = $ustmt->fetch();
								//$q = $this->db->query('SELECT * FROM `v-raids-graph-individual-healingreceived` WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'"')->fetch();
								if (isset($q->time)){
									$strings = $this->mergeGraphs($q, $var);
									$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$ke], $charsByKey[$k], $spells[$key]));
									//$this->db->query('UPDATE `v-raids-graph-individual-healingreceived` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'";');
								}*/
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		////gc_collect_cycles();
		
		print "38 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 80 WHERE id = '.$cronid);
		
		// Auras
		/*
		* All of them have to be tested.
		*
		* buffs[attemptid][abilityid] = Array(1 => amount, 2 => active);
		* procs[attemptid][abilityid] = Array(1 => amount, 2 => chance);
		* individualBuffs[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
		* individualProcs[attemptid][charid][abilityid] = Array(1 => amount, 2 => chance);
		* individualBuffsByPlayer[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
		* debuffs[attemptid][abilityid] = Array(1 => amount, 2 => active);
		* individualDebuffs[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
		* individualDebuffsByPlayer[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
		*/
		// v-raids-buffs
		// New Buffsystem
		
		// How does merging work here?
		// If the second half of the log is uploaded first and then the first half, this might have issues here with merging. Lets see.
		$sql = 'INSERT INTO `v-raids-newbuffs` (charid, abilityid, cbtstart, cbtend, rid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$sqlUpdate = 'INSERT INTO `v-raids-newbuffs` (charid, abilityid, cbtstart, cbtend, rid) VALUES ';
		$cacheUpdateArray = array();
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		
		if ($mergeBoolean){
			foreach($this->db->query('SELECT * FROM `v-raids-newbuffs` WHERE rid = '.$mergeBoolean) as $row){
				if (!isset($cacheUpdateArray[$row->charid]))
					$cacheUpdateArray[$row->charid] = array();
				if (!isset($cacheUpdateArray[$row->charid][$row->abilityid]))
					$cacheUpdateArray[$row->charid][$row->abilityid] = $row;
			}
		}
		
		foreach($this->newBuffs as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1]) && isset($var[2]) && $var[1] != "" && $var[2] != "" && isset($spells[$ke]) && isset($charsByKey[$k]) && $key != ""){
						if (!isset($raidsByZone[$key]))
							$raidsByZone[$key] = 0;
						if ($mergeBoolean){
							$extraTime = $this->getExtraTime($mergeBoolean, null, $raids[$key]);
							if (isset($cacheUpdateArray[$charsByKey[$k]][$spells[$ke]])){
								$f = $q->fetch();
								$qq = array();
								$qq[1] = explode(",",$cacheUpdateArray[$charsByKey[$k]][$spells[$ke]]->cbtstart);
								$qq[2] = explode(",",$var[1]);
								$qq[3] = explode(",",$var[2]);
								$qq[4] = explode(",",$cacheUpdateArray[$charsByKey[$k]][$spells[$ke]]->cbtend);
								if (sizeOf($qq[1])>sizeOf($qq[4]))
									$f->cbtend .= ",0";
								
								$last = -1;
								foreach ($qq[1] as $kk => $oo){
									if ($oo>$last)
										$last = $oo;
								}
								$newcbtstart = $cacheUpdateArray[$charsByKey[$k]][$spells[$ke]]->cbtstart;
								$newcbtend = $cacheUpdateArray[$charsByKey[$k]][$spells[$ke]]->cbtend;
								foreach($qq[2] as $qw => $qe){
									if ((intval($qe)+$extraTime)>$last){
										$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qe))];
										if ($extraTime==0)
											$iStartCBT = 0;
										$newcbtstart .= ",".round(intval($qe)+$extraTime-$iStartCBT,1);
										$newcbtend .= ",".round(intval($qq[3][$qw])+$extraTime-$iStartCBT,1);
									}
								}
								
								$insertQueryUpdate[] = '(?,?,?,?,?)';
								$insertDataUpdate[] = $charsByKey[$k];
								$insertDataUpdate[] = $spells[$ke];
								$insertDataUpdate[] = $newcbtstart;
								$insertDataUpdate[] = $newcbtend;
								$insertDataUpdate[] = $mergeBoolean;
							}else{
								$qp1 = explode(",",$var[1]);
								$qp2 = explode(",",$var[2]);
								$newcbtstart = "";
								$newcbtend = "";
								foreach($qp1 as $qw => $qr){
									$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qr))];
									if ($extraTime==0)
										$iStartCBT = 0;
									$newcbtstart .= ($r = ($newcbtstart != "") ? "," : "").round(intval($qr)+$extraTime-$iStartCBT, 1);
								}
								foreach($qp2 as $qw => $qr){
									$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qr))];
									if ($extraTime==0)
										$iStartCBT = 0;
									$newcbtend .= ($r = ($newcbtend != "") ? "," : "").round(intval($qr)+$extraTime-$iStartCBT, 1);
								}
								$insertQuery[] = '(?,?,?,?,?)';
								$insertData[] = $charsByKey[$k];
								$insertData[] = $spells[$ke];
								$insertData[] = $newcbtstart;
								$insertData[] = $newcbtend;
								$insertData[] = $raidsByZone[$key];
							}
						}else{
							$insertQuery[] = '(?,?,?,?,?)';
							$insertData[] = $charsByKey[$k];
							$insertData[] = $spells[$ke];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $raidsByZone[$key];
						}
					}
				}
			}
		}
		
		if (!empty($insertQueryUpdate)) {
			$this->db->query('DELETE FROM `v-raids-newbuffs` WHERE rid = '.$mergeBoolean);
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		unset($cacheUpdateArray);
		////gc_collect_cycles();
		$sql = 'INSERT INTO `v-raids-newdebuffs` (charid, abilityid, cbtstart, cbtend, rid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$sqlUpdate = 'INSERT INTO `v-raids-newdebuffs` (charid, abilityid, cbtstart, cbtend, rid) VALUES ';
		$cacheUpdateArray = array();
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		
		if ($mergeBoolean){
			foreach($this->db->query('SELECT * FROM `v-raids-newdebuffs` WHERE rid = '.$mergeBoolean) as $row){
				if (!isset($cacheUpdateArray[$row->charid]))
					$cacheUpdateArray[$row->charid] = array();
				if (!isset($cacheUpdateArray[$row->charid][$row->abilityid]))
					$cacheUpdateArray[$row->charid][$row->abilityid] = $row;
			}
		}
		
		foreach($this->newDebuffs as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1]) && isset($var[2]) && $var[1] != "" && $var[2] != "" && isset($spells[$ke]) && isset($charsByKey[$k]) && $key != ""){
						if ($mergeBoolean){
							$extraTime = $this->getExtraTime($mergeBoolean, null, $raids[$key]);
							if (isset($cacheUpdateArray[$charsByKey[$k]][$spells[$ke]])){
								$f = $q->fetch();
								$qq = array();
								$qq[1] = explode(",",$cacheUpdateArray[$charsByKey[$k]][$spells[$ke]]->cbtstart);
								$qq[2] = explode(",",$var[1]);
								$qq[3] = explode(",",$var[2]);
								$qq[4] = explode(",",$cacheUpdateArray[$charsByKey[$k]][$spells[$ke]]->cbtend);
								if (sizeOf($qq[1])>sizeOf($qq[4]))
									$f->cbtend .= ",0";
								
								$last = -1;
								foreach ($qq[1] as $kk => $oo){
									if ($oo>$last)
										$last = $oo;
								}
								$newcbtstart = $cacheUpdateArray[$charsByKey[$k]][$spells[$ke]]->cbtstart;
								$newcbtend = $cacheUpdateArray[$charsByKey[$k]][$spells[$ke]]->cbtend;
								foreach($qq[2] as $qw => $qe){
									if ((intval($qe)+$extraTime)>$last){
										$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qe))];
										if ($extraTime==0)
											$iStartCBT = 0;
										$newcbtstart .= ",".round(intval($qe)+$extraTime-$iStartCBT,1);
										$newcbtend .= ",".round(intval($qq[3][$qw])+$extraTime-$iStartCBT,1);
									}
								}
								
								$insertQueryUpdate[] = '(?,?,?,?,?)';
								$insertDataUpdate[] = $charsByKey[$k];
								$insertDataUpdate[] = $spells[$ke];
								$insertDataUpdate[] = $newcbtstart;
								$insertDataUpdate[] = $newcbtend;
								$insertDataUpdate[] = $mergeBoolean;
							}else{
								$qp1 = explode(",",$var[1]);
								$qp2 = explode(",",$var[2]);
								$newcbtstart = "";
								$newcbtend = "";
								foreach($qp1 as $qw => $qr){
									$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qr))];
									if ($extraTime==0)
										$iStartCBT = 0;
									$newcbtstart .= ($r = ($newcbtstart != "") ? "," : "").round(intval($qr)+$extraTime-$iStartCBT, 1);
								}
								foreach($qp2 as $qw => $qr){
									$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qr))];
									if ($extraTime==0)
										$iStartCBT = 0;
									$newcbtend .= ($r = ($newcbtend != "") ? "," : "").round(intval($qr)+$extraTime-$iStartCBT, 1);
								}
								$insertQuery[] = '(?,?,?,?,?)';
								$insertData[] = $charsByKey[$k];
								$insertData[] = $spells[$ke];
								$insertData[] = $newcbtstart;
								$insertData[] = $newcbtend;
								$insertData[] = $raidsByZone[$key];
							}
						}else{
							$insertQuery[] = '(?,?,?,?,?)';
							$insertData[] = $charsByKey[$k];
							$insertData[] = $spells[$ke];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $raidsByZone[$key];
						}
					}
				}
			}
		}
		
		if (!empty($insertQueryUpdate)) {
			$this->db->query('DELETE FROM `v-raids-newdebuffs` WHERE rid = '.$mergeBoolean);
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		unset($cacheUpdateArray);
		////gc_collect_cycles();
		
		/*$sql = 'INSERT INTO `v-raids-buffs` (attemptid, abilityid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-buffs` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->buffs as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset($spells[$key])){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $spells[$key]));
							//$this->db->query('UPDATE `v-raids-buffs` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $spells[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							//$this->db->query('INSERT INTO `v-raids-buffs` (attemptid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-procs
		$sql = 'INSERT INTO `v-raids-procs` (attemptid, abilityid, amount, chance) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-procs` SET amount = greatest(?, amount), chance = greatest(?, chance) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->procs as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset($spells[$key])){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $spells[$key]));
							//$this->db->query('UPDATE `v-raids-procs` SET amount = greatest("'.$var[1].'", amount), chance = greatest("'.$var[2].'", chance) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $spells[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							//$this->db->query('INSERT INTO `v-raids-procs` (attemptid, abilityid, amount, chance) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-debuffs
		$sql = 'INSERT INTO `v-raids-debuffs` (attemptid, abilityid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-debuffs` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->debuffs as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset($spells[$key])){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $spells[$key]));
							//$this->db->query('UPDATE `v-raids-debuffs` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $spells[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							//$this->db->query('INSERT INTO `v-raids-debuffs` (attemptid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-individual-buffs
		$sql = 'INSERT INTO `v-raids-individual-buffs` (attemptid, charid, abilityid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-individual-buffs` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND abilityid = ? AND charid = ?');
		foreach($this->individualBuffs as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (isset($var[1]) && isset($spells[$key])){
							if ($var[1]>0){
								if (isset($raidExistsAttempts[$k])){
									$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $spells[$key], $charsByKey[$ke]));
									//$this->db->query('UPDATE `v-raids-individual-buffs` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'" AND charid = "'.$charsByKey[$ke].'"');
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = $spells[$key];
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									//$this->db->query('INSERT INTO `v-raids-individual-buffs` (attemptid, charid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-individual-buffsbyplayer
		$sql = 'INSERT INTO `v-raids-individual-buffsbyplayer` (attemptid, charid, abilityid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-individual-buffsbyplayer` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND abilityid = ? AND charid = ?');
		foreach($this->individualBuffsByPlayer as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (isset($var[1]) && isset($spells[$key])){
							if ($var[1]>0){
								if (isset($raidExistsAttempts[$k])){
									$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $spells[$key], $charsByKey[$ke]));
									//$this->db->query('UPDATE `v-raids-individual-buffsbyplayer` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'" AND charid = "'.$charsByKey[$ke].'"');
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = $spells[$key];
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									//$this->db->query('INSERT INTO `v-raids-individual-buffsbyplayer` (attemptid, charid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-individual-debuffs
		$sql = 'INSERT INTO `v-raids-individual-debuffs` (attemptid, charid, abilityid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-individual-debuffs` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND abilityid = ? AND charid = ?');
		foreach($this->individualDebuffs as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (isset($var[1]) && isset($spells[$key])){
							if ($var[1]>0){
								if (isset($raidExistsAttempts[$k])){
									$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $spells[$key], $charsByKey[$ke]));
									//$this->db->query('UPDATE `v-raids-individual-debuffs` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'" AND charid = "'.$charsByKey[$ke].'"');
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = $spells[$key];
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									//$this->db->query('INSERT INTO `v-raids-individual-debuffs` (attemptid, charid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-individual-debuffsbyplayer
		$sql = 'INSERT INTO `v-raids-individual-debuffsbyplayer` (attemptid, charid, abilityid, amount, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-individual-debuffsbyplayer`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, abilityid, amount, npcid) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDebuffsByPlayer as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->npcid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->npcid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->npcid][$row->abilityid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `v-raids-individual-debuffsbyplayer` SET amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ? AND charid = ? AND npcid = ?');
		foreach($this->individualDebuffsByPlayer as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $qq => $ss){
						foreach($ss as $key => $var){
							if (isset($var[1]) && isset($spells[$key])){
								if ($var[1]>0){
									if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
									&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
									&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][$spells[$key]]) 
									&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][$spells[$key]]->amount<$var[1]){
										if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][$spells[$key]]->id, $toDeleteUpdate)){
											$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][$spells[$key]]->id;
											$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
											$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][$spells[$key]]->id;
											$insertDataUpdate[] = $raidExistsAttempts[$k];
											$insertDataUpdate[] = $charsByKey[$ke];
											$insertDataUpdate[] = $spells[$key];
											$insertDataUpdate[] = $var[1];
											$insertDataUpdate[] = $npcs[$qq];
										}
										
										//$ustmt->execute(array($var[1], $raidExistsAttempts[$k], $spells[$key], $charsByKey[$ke], $npcs[$qq]));
										//$this->db->query('UPDATE `v-raids-individual-debuffsbyplayer` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'" AND charid = "'.$charsByKey[$ke].'"');
									}else{
										$insertQuery[] = '(?, ?, ?, ?, ?)';
										$insertData[] = $attemptsWithDbId[$k][1];
										$insertData[] = $charsByKey[$ke];
										$insertData[] = $spells[$key];
										$insertData[] = $var[1];
										$insertData[] = $npcs[$qq];
										//$this->db->query('INSERT INTO `v-raids-individual-debuffsbyplayer` (attemptid, charid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'")');
									}
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		// v-raids-individual-procs
		// Maybe removing chance from update?
		$sql = 'INSERT INTO `v-raids-individual-procs` (attemptid, charid, abilityid, amount, chance) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-individual-procs`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, abilityid, amount, chance) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualProcs as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->abilityid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `v-raids-individual-procs` SET amount = greatest(?, amount), chance = greatest(?, chance) WHERE attemptid = ? AND abilityid = ? AND charid = ?');
		foreach($this->individualProcs as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (isset($var[1]) && isset($charsByKey[$ke]) && isset($spells[$key])){
							if ($var[1]>0){
								if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$spells[$key]]) 
								&& ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$spells[$key]]->amount<$var[1] or $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$spells[$key]]->chance<$var[2])){
									if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$spells[$key]]->id, $toDeleteUpdate)){
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$spells[$key]]->id;
										$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$spells[$key]]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charsByKey[$ke];
										$insertDataUpdate[] = $spells[$key];
										$insertDataUpdate[] = $var[1];
										$insertDataUpdate[] = $var[2];
									}
									
									//$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $spells[$key], $charsByKey[$ke]));
									//$this->db->query('UPDATE `v-raids-individual-procs` SET amount = greatest("'.$var[1].'", amount), chance = greatest("'.$var[2].'", chance) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'" AND charid = "'.$charsByKey[$ke].'"');
								}else{
									if (isset($attemptsWithDbId[$k][1])){
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = $spells[$key];
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									}
									//$this->db->query('INSERT INTO `v-raids-individual-procs` (attemptid, charid, abilityid, amount, chance) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$spells[$key].'", "'.$var[1].'", "'.$var[2].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		
		print "39 done <br />";
		
		// Deaths
		/*
		* All of them have to be tested
		* What happens if someone dies twice in an attempt?
		* 
		* deathsBySource[attemptid][charid][cbt] = Array(1 => killingblow(abilityid), 2 => time);
		* individualDeath[attemptid][charid][cbt][abilityid] = Array(1 => dmg, 2 => heal, 3 => time, 4 => npcid, 5 => type(hit/crit/crush));
		*/
		// v-raids-deaths
		$deathsByCBT = array();
		foreach($this->deathsBySource as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (!isset($raidExistsAttempts[$k]) && isset($spells[$var[1]]) && isset($attemptsWithDbId[$k][1])){
							$ts = $this->getTimeStamp($var[2], $var[2]);
							$extraTime = $this->getExtraTime($mergeBoolean, null, $attemptsWithDbId[$k][8]);
							$this->db->query('INSERT INTO `v-raids-deaths` (attemptid, charid, cbt, killingblow, time, flagid, flag) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.($key-$instanceStartById[$k]+$extraTime).'", "'.$spells[$var[1]].'", "'.intval($ts[1]).'", "'.($r = ($var[4] == 1 && isset($npcs[$var[3]])) ? intval($npcs[$var[3]]) : (isset($charsByKey[$var[3]])) ? intval($charsByKey[$var[3]]) : 0).'", "'.$var[4].'")');
							$deathsByCBT[$k][$ke][round(($key-$instanceStartById[$k]+$extraTime))] = $this->db->query('SELECT id FROM `v-raids-deaths` WHERE attemptid = "'.$attemptsWithDbId[$k][1].'" AND cbt = "'.round(($key-$instanceStartById[$k]+$extraTime)).'" AND charid = "'.$charsByKey[$ke].'"')->fetch()->id;
						}
					}
				}
			}
		}
		// v-raids-individual-death
		$sql = 'INSERT INTO `v-raids-individual-death` (attemptid, deathid, charid, cbt, abilityid, dmg, heal, time, flagid, type, flag) VALUES ';
		$insertQuery = array();
		$insertData = array();
		foreach($this->individualDeath as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						foreach($var as $keys => $vars){
							if (!isset($raidExistsAttempts[$k]) && isset($spells[$vars[6]]) && isset($attemptsWithDbId[$k][1]) && isset($deathsByCBT[$k][$ke][round(($key-$instanceStartById[$k]+$extraTime))])){
								$extraTime = $this->getExtraTime($mergeBoolean, null, $attemptsWithDbId[$k][8]);
								$ts = $this->getTimeStamp($vars[3], $vars[3]);
								$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$k][1];
								$insertData[] = $deathsByCBT[$k][$ke][round(($key-$instanceStartById[$k]+$extraTime))];
								$insertData[] = $charsByKey[$ke];
								$insertData[] = ((round($vars[8]-$instanceStartById[$k]+$extraTime))>0) ? round($vars[8]-$instanceStartById[$k]+$extraTime) : 0;
								$insertData[] = $spells[$vars[6]];
								$insertData[] = $vars[1];
								$insertData[] = $vars[2];
								$insertData[] = intval($ts[1]);
								$insertData[] = ($r = ($vars[7] == 1) ? intval($npcs[$vars[4]]) : intval($charsByKey[$vars[4]]));
								$insertData[] = $vars[5];
								$insertData[] = $vars[7];
								//$this->db->query('INSERT INTO `v-raids-individual-death` (attemptid, deathid, charid, cbt, abilityid, dmg, heal, time, flagid, type, flag) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$deathsByCBT[$k][$ke][round(($key-$instanceStartById[$k]))].'","'.$charsByKey[$ke].'", "'.($vars[8]-$instanceStartById[$k]).'", "'.$spells[$vars[6]].'", "'.$vars[1].'", "'.$vars[2].'", "'.$ts[1].'", "'.($r = ($vars[7] == 1) ? $npcs[$vars[4]] : $charsByKey[$vars[4]]).'", "'.$vars[5].'", "'.$vars[7].'")');
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		////gc_collect_cycles();
		
		print "40 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 90 WHERE id = '.$cronid);
		
		// Interrupts
		/*
		* All of them have to be tested (STILL TODO -> Time missing, also cbt?)
		* 
		* missedInterrupts[attemptid][npcid][charid] = Array(1 => abilityid, 2 => amount);
		* successfullInterruptsSum[attemptid][charid] = amount
		* missedInterruptsSum[attemptid][abilityid] = amount
		* individualInterrtups[attemptid][charid][cbt] = Array(1 => time, 2 => abilityid, 3 => npcid);
		*/
		// v-raids-interruptsmissed
		$sql = 'INSERT INTO `v-raids-interruptsmissed` (attemptid, npcid, abilityid, targetid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-interruptsmissed`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, npcid, abilityid, targetid, amount) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->missedInterrupts as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->npcid]))
						$toUpdateTable[$row->attemptid][$row->npcid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->npcid][$row->targetid]))
						$toUpdateTable[$row->attemptid][$row->npcid][$row->targetid] = array();
					$toUpdateTable[$row->attemptid][$row->npcid][$row->targetid][$row->abilityid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `v-raids-interruptsmissed` SET amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ? AND npcid = ? AND targetid = ?');
		foreach($this->missedInterrupts as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[2])){
						if ($var[2]>0 && isset($npcs[$ke])){
							if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]][$charsByKey[$key]][$spells[$var[1]]]) 
							&& $toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]][$charsByKey[$key]][$spells[$var[1]]]->amount<$var[2]){
								if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]][$charsByKey[$key]][$spells[$var[1]]]->id, $toDeleteUpdate)){
									$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]][$charsByKey[$key]][$spells[$var[1]]]->id;
									$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
									$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]][$charsByKey[$key]][$spells[$var[1]]]->id;
									$insertDataUpdate[] = $raidExistsAttempts[$k];
									$insertDataUpdate[] = $npcs[$ke];
									$insertDataUpdate[] = $spells[$var[1]];
									$insertDataUpdate[] = $charsByKey[$key];
									$insertDataUpdate[] = $var[2];
								}
								
								//$ustmt->execute(array($var[2], $raidExistsAttempts[$k], $spells[$var[1]], $npcs[$ke], $charsByKey[$key]));
								//$this->db->query('UPDATE `v-raids-interruptsmissed` SET amount = greatest("'.$var[2].'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$var[1]].'" AND npcid = "'.$npcs[$ke].'" AND targetid = "'.$charsByKey[$key].'"');
							}else{
								if (isset($attemptsWithDbId[$k][1]) && isset($charsByKey[$key])){
								$insertQuery[] = '(?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$k][1];
								$insertData[] = $npcs[$ke];
								$insertData[] = $spells[$var[1]];
								$insertData[] = $charsByKey[$key];
								$insertData[] = $var[2];
								}
								//$this->db->query('INSERT INTO `v-raids-interruptsmissed` (attemptid, npcid, abilityid, targetid, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$npcs[$ke].'", "'.$spells[$var[1]].'", "'.$charsByKey[$key].'", "'.$var[2].'")');
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		/*// v-raids-interruptssum
		$sql = 'INSERT INTO `v-raids-interruptssum` (attemptid, charid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-interruptssum` SET amount = greatest(?, amount) WHERE attemptid = ? AND charid = ?');
		foreach($this->successfullInterruptsSum as $k => $v){
			foreach($v as $key => $var){
				if (isset($var) && isset($charsByKey[$key])){
					if ($var>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var, $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `v-raids-interruptssum` SET amount = greatest("'.$var.'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var;
							//$this->db->query('INSERT INTO `v-raids-interruptssum` (attemptid, charid, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var.'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-individual-interrupts
		$sql = 'INSERT INTO `v-raids-individual-interrupts` (attemptid, charid, abilityid, npcid, cbt, time) VALUES ';
		$insertQuery = array();
		$insertData = array();
		foreach($this->individualInterrupts as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (!isset($raidExistsAttempts[$k]) && isset($attemptsWithDbId[$k][1]) && isset($npcs[$var[3]])){
							$extraTime = $this->getExtraTime($mergeBoolean, null, $attemptsWithDbId[$k][8]);
							$ts = $this->getTimeStamp($var[1], $var[1]);
							$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$ke];
							$insertData[] = $spells[$var[2]];
							$insertData[] = $npcs[$var[3]];
							$insertData[] = round($key-$instanceStartById[$k]+$extraTime);
							$insertData[] = $ts[1];
							//$this->db->query('INSERT INTO `v-raids-individual-interrupts` (attemptid, charid, abilityid, npcid, cbt, time) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$spells[$var[2]].'", "'.$npcs[$var[3]].'", "'.($key-$instanceStartById[$k]).'", "'.$ts[1].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		////gc_collect_cycles();
		/*// v-raids-interruptsmissedsum
		$sql = 'INSERT INTO `v-raids-interruptsmissedsum` (attemptid, abilityid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `v-raids-interruptsmissedsum` SET amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->missedInterruptsSum as $k => $v){
			foreach($v as $key => $var){
				if (isset($var)){
					if ($var>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var, $raidExistsAttempts[$k], $spells[$key]));
							//$this->db->query('UPDATE `v-raids-interruptsmissedsum` SET amount = greatest("'.$var.'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.$spells[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $spells[$key];
							$insertData[] = $var;
							//$this->db->query('INSERT INTO `v-raids-interruptsmissedsum` (attemptid, abilityid, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$spells[$key].'", "'.$var.'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		
		print "41 done <br />";
		// Dispels
		/*
		* All of these have to be tested
		*
		* dispelsByAbility[attemptid][abilityid] = amount
		* dispelsByFriendly[attemptid][charid] = amount
		* individualDispelsByTarget[attemptid][charid][tarid] = amount;
		* individualDispelsByAbility[attemptid][charid][abilityid(the dispelled ability)] = amount;
		*/
		// v-raids-individual-dispelbytarget
		$sql = 'INSERT INTO `v-raids-dispels` (attemptid, charid, targetid, amount, abilityid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`v-raids-dispels`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, targetid, amount, abilityid) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDispelsByTarget as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->targetid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->targetid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->targetid][$row->abilityid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `v-raids-dispels` SET amount = greatest(?, amount) WHERE attemptid = ? AND targetid = ? AND charid = ? AND abilityid = ?');
		foreach($this->individualDispelsByTarget as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					foreach($var as $keys => $vars){
						if (isset($vars) && isset($charsByKey[$key]) && isset($charsByKey[$ke])){
							if ($vars>0){
								if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]][$spells[$keys]]) 
								&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]][$spells[$keys]]->amount<$vars){
									if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]][$spells[$keys]]->id, $toDeleteUpdate)){
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]][$spells[$keys]]->id;
										$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]][$spells[$keys]]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charsByKey[$ke];
										$insertDataUpdate[] = $charsByKey[$key];
										$insertDataUpdate[] = $vars;
										$insertDataUpdate[] = $spells[$keys];
									}
									
									//$ustmt->execute(array($vars, $raidExistsAttempts[$k], $charsByKey[$key], $charsByKey[$ke], $spells[$keys]));
									//$this->db->query('UPDATE `v-raids-dispels` SET amount = greatest("'.$vars.'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND targetid = "'.$charsByKey[$key].'" AND charid = "'.$charsByKey[$ke].'" AND abilityid = "'.$spells[$keys].'"');
								}else{
									if (isset($attemptsWithDbId[$k][1]) && isset($spells[$keys])){
										$insertQuery[] = '(?, ?, ?, ?, ?)';
										$insertData[] = $attemptsWithDbId[$k][1];
										$insertData[] = $charsByKey[$ke];
										$insertData[] = $charsByKey[$key];
										$insertData[] = $vars;
										$insertData[] = $spells[$keys];
									}
									//$this->db->query('INSERT INTO `v-raids-dispels` (attemptid, charid, targetid, amount, abilityid) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$charsByKey[$key].'", "'.$vars.'", "'.$spells[$keys].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($toUpdateTable);
		unset($toDeleteUpdate);
		unset($insertQueryUpdate);
		unset($insertDataUpdate);
		////gc_collect_cycles();
		
		print "42 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 95 WHERE id = '.$cronid);
		// Records
		// How about unrealistic values?
		// Fixing merges is required here.
		// v-rankings
		
		//private function writeIntoDB($spells, $npcs, $npcsById, $npcsTra, $npcRevTra, $spellsTra, $spellsRevTra, $cronid){
		
		$VRankings = $this->getVRankings($charsByKey, $npcs, $attemptsWithDbIdByNpcId, $serverid, $classes, $npcRevTra, $npcsTra, $npcsById); // I have to sort it before, so I gotta check this later.
		$counter = array();
		$sql = 'INSERT INTO `v-raids-records` (attemptid, type, realm, realmclass, realmtype, charid) VALUES ';
		$sql2 = 'INSERT INTO `v-rankings` (bossid, type, charid, boval, aoval, bmval, amval, botime, aotime, bmtime, amtime, oattemptid, mattemptid, bochange, aochange, bmchange, amchange, aoamount, boamount) VALUES ';
		$insertQuery = array();
		$insertQuery2 = array();
		$insertQuery3 = array();
		$insertData = array();
		$insertData2 = array();
		$insertData3 = array();
		$deleting = array();
		$deleting2 = array();
		$bufferi = 1;
		foreach($VRankings as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (!isset($counter[$k][$ke][$var[17]]))
						$counter[$k][$ke][$var[17]] = array(
							1 => 0,
							2 => array(),
							3 => array()
						);
					if (!isset($counter[$k][$ke][$var[17]][2][$var[18]]))
						$counter[$k][$ke][$var[17]][2][$var[18]] = 0;
					if (!isset($counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]]))
						$counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]] = 0;
					$counter[$k][$ke][$var[17]][1] += 1; // Realm counter
					$counter[$k][$ke][$var[17]][2][$var[18]] += 1; // realm class counter
					$counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]] += 1;
					if (isset($var[15]) && isset($var[9]) && intval($var[9])>0 && isset($key) && $key != "" && $var[9] != "" && intval($var[10])>0){
						if ($counter[$k][$ke][$var[17]][1]<=50 || $counter[$k][$ke][$var[17]][2][$var[18]] <= 50 || $counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]]<= 50){
							if (!isset($deleting[$var[9]]))
								$deleting[$var[9]] = array();
							$deleting[$var[9]][] = $key;
							//$deleting[1] .= ($r = (isset($deleting[1]) && $deleting[1] != '') ? ',' : '').$var[9];
							//$deleting[2] .= ($r = (isset($deleting[2]) && $deleting[2] != '') ? ',' : '').$key;
							//$this->db->query('DELETE FROM `v-raids-records` WHERE attemptid = "'.$var[9].'" AND type = "'.$ke.'" AND charid = "'.$key.'"');
							$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
							$insertData[] = $var[9];
							$insertData[] = $ke;
							$insertData[] = $counter[$k][$ke][$var[17]][1];
							$insertData[] = $counter[$k][$ke][$var[17]][2][$var[18]];
							$insertData[] = $counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]];
							$insertData[] = $key;
							//$this->db->query('INSERT INTO `v-raids-records` (attemptid, type, realm, realmclass, realmtype, charid) VALUES ("'.$var[9].'", "'.$ke.'", "'.$counter[$k][$ke][$var[17]][1].'", "'.$counter[$k][$ke][$var[17]][2][$var[18]].'", "'.$counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]].'", "'.$key.'")');
						}
					}
					if (isset($var[16]) && $var[16]==true && isset($key) && isset($k) && $key != "" and $k != "" && intval($var[9])>0 && intval($var[10])>0){
						if (!isset($deleting2[$k]))
								$deleting2[$k] = array();
						$deleting2[$k][] = $key;
						//$deleting2[1] .= ($r = (isset($deleting2[1]) && $deleting2[1] != '') ? ',' : '').$key;
						//$deleting2[2] .= ($r = (isset($deleting2[2]) && $deleting2[2] != '') ? ',' : '').$k;
						//$this->db->query('DELETE FROM `v-rankings` WHERE charid = "'.$key.'" AND type = "'.$ke.'" AND bossid = "'.$k.'"');
						if ($bufferi>30000){
							$insertQuery3[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
							$insertData3[] = $k;
							$insertData3[] = $ke;
							$insertData3[] = $key;
							$insertData3[] = $var[1];
							$insertData3[] = $var[2];
							$insertData3[] = $var[3];
							$insertData3[] = $var[4];
							$insertData3[] = $var[5];
							$insertData3[] = $var[6];
							$insertData3[] = $var[7];
							$insertData3[] = $var[8];
							$insertData3[] = $var[9];
							$insertData3[] = $var[10];
							$insertData3[] = $var[11];
							$insertData3[] = $var[12];
							$insertData3[] = $var[13];
							$insertData3[] = $var[14];
							$insertData3[] = $var[19];
							$insertData3[] = $var[20];
	
						}else{
							$insertQuery2[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
							$insertData2[] = $k;
							$insertData2[] = $ke;
							$insertData2[] = $key;
							$insertData2[] = $var[1];
							$insertData2[] = $var[2];
							$insertData2[] = $var[3];
							$insertData2[] = $var[4];
							$insertData2[] = $var[5];
							$insertData2[] = $var[6];
							$insertData2[] = $var[7];
							$insertData2[] = $var[8];
							$insertData2[] = $var[9];
							$insertData2[] = $var[10];
							$insertData2[] = $var[11];
							$insertData2[] = $var[12];
							$insertData2[] = $var[13];
							$insertData2[] = $var[14];
							$insertData2[] = $var[19];
							$insertData2[] = $var[20];
						}
						$bufferi++;
						//$this->db->query('INSERT INTO `v-rankings` (bossid, type, charid, boval, aoval, bmval, amval, botime, aotime, bmtime, amtime, oattemptid, mattemptid, bochange, aochange, bmchange, amchange) VALUES ("'.$k.'", "'.$ke.'", "'.$key.'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'", "'.$var[5].'", "'.$var[6].'", "'.$var[7].'", "'.$var[8].'", "'.$var[9].'", "'.$var[10].'", "'.$var[11].'", "'.$var[12].'", "'.$var[13].'", "'.$var[14].'")');
					}
				}
			}
		}
		if (!empty($deleting)){
			foreach($deleting as $k => $v)
				$this->db->query('DELETE FROM `v-raids-records` WHERE attemptid = '.$k.' AND charid IN('.implode(",", $v).')');
		}
		if (!empty($deleting2)){
			foreach($deleting2 as $k => $v)
				$this->db->query('DELETE FROM `v-rankings` WHERE bossid = '.$k.' AND charid IN('.implode(",", $v).')');
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		if (!empty($insertQuery2)) {
			$sql2 .= implode(', ', $insertQuery2);
			$stmt = $this->db->prepare($sql2);
			$stmt->execute($insertData2);
		}
		if (!empty($insertQuery3)) {
			$sql2 .= implode(', ', $insertQuery3);
			$stmt = $this->db->prepare($sql2);
			$stmt->execute($insertData3);
		}
		unset($insertQuery);
		unset($insertData);
		unset($insertQuery2);
		unset($insertData2);
		unset($insertQuery3);
		unset($insertData3);
		unset($deleting1);
		unset($deleting2);
		////gc_collect_cycles();
		
		// speed-runs
		$SpeedRunRanking = $this->getSpeedRunRanking($attemptsWithDbIdByNpcId, $guildid, $npcsById, $npcRevTra);
		$sql = 'INSERT INTO `v-speed-runs` (raidnameid, guildid, fotime, foboss, foatime, foaboss, fmtime, fmboss, fmatime, fmaboss, oraidid, mraidid, fochange, foachange, fmchange, fmachange, foamount, fmamount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$deleting = array();
		foreach($SpeedRunRanking as $key => $var){
			if (isset($var[19]) && $var[19] && isset($key)){
				$deleting[1] .= ($r = (isset($deleting[1]) && $deleting[1] != '') ? ',' : '').$guildid;
				$deleting[2] .= ($r = (isset($deleting[2]) && $deleting[2] != '') ? ',' : '').$key;
				//$this->db->query('DELETE FROM `v-speed-runs` WHERE guildid = "'.$guildid.'" AND raidnameid = "'.$key.'"');
				$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
				$insertData[] = $key;
				$insertData[] = $guildid;
				$insertData[] = $var[1];
				$insertData[] = $var[2];
				$insertData[] = $var[4];
				$insertData[] = $var[5];
				$insertData[] = $var[7];
				$insertData[] = $var[8];
				$insertData[] = $var[10];
				$insertData[] = $var[11];
				$insertData[] = intval($var[13]);
				$insertData[] = intval($var[14]);
				$insertData[] = $var[15];
				$insertData[] = $var[16];
				$insertData[] = $var[17];
				$insertData[] = $var[18];
				$insertData[] = $var[20];
				$insertData[] = $var[21];
				//$this->db->query('INSERT INTO `v-speed-runs` (raidnameid, guildid, fotime, foboss, foatime, foaboss, fmtime, fmboss, fmatime, fmaboss, oraidid, mraidid, fochange, foachange, fmchange, fmachange) VALUES ("'.$key.'", "'.$guildid.'", "'.$var[1].'", "'.$var[2].'", "'.$var[4].'", "'.$var[5].'", "'.$var[7].'", "'.$var[8].'", "'.$var[10].'", "'.$var[11].'", "'.$var[13].'", "'.$var[14].'", "'.$var[15].'", "'.$var[16].'", "'.$var[17].'", "'.$var[18].'")');
			}
		}
		if (!empty($deleting)){
			$this->db->query('DELETE FROM `v-speed-runs` WHERE guildid IN ('.$deleting[1].') AND raidnameid IN ('.$deleting[2].')');
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($deleting);
		////gc_collect_cycles();
		
		// speed-kills
		$SpeedKillRanking = $this->getSpeedKillRanking($attemptsWithDbIdByNpcId, $guildid, $npcsById, $npcRevTra);
		$sql = 'INSERT INTO `v-speed-kills` (bossid, guildid, fotime, foatime, fmtime, fmatime, fochange, foachange, fmchange, fmachange, oraidid, mraidid, foamount, fmamount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$deleting = array();
		foreach($SpeedKillRanking as $key => $var){
			if (isset($var[11]) && isset($key) && $key != '' && isset($var[9]) && isset($var[10])){
				$deleting[1] .= ($r = (isset($deleting[1]) && $deleting[1] != '') ? ',' : '').$guildid;
				$deleting[2] .= ($r = (isset($deleting[2]) && $deleting[2] != '') ? ',' : '').$key;
				//$this->db->query('DELETE FROM `v-speed-kills` WHERE guildid = "'.$guildid.'" AND bossid = "'.$key.'"');
				$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
				$insertData[] = $key;
				$insertData[] = $guildid;
				$insertData[] = $var[1];
				$insertData[] = $var[2];
				$insertData[] = $var[3];
				$insertData[] = $var[4];
				$insertData[] = $var[5];
				$insertData[] = $var[6];
				$insertData[] = $var[7];
				$insertData[] = $var[8];
				$insertData[] = $var[9];
				$insertData[] = $var[10];
				$insertData[] = $var[12];
				$insertData[] = $var[13];
				//$this->db->query('INSERT INTO `v-speed-kills` (bossid, guildid, fotime, foatime, fmtime, fmatime, fochange, foachange, fmchange, fmachange, oraidid, mraidid) VALUES ("'.$key.'", "'.$guildid.'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'", "'.$var[5].'", "'.$var[6].'", "'.$var[7].'", "'.$var[8].'", "'.$var[9].'", "'.$var[10].'")');
			}
		}
		if (!empty($deleting)){
			$this->db->query('DELETE FROM `v-speed-kills` WHERE guildid IN ('.$deleting[1].') AND bossid IN ('.$deleting[2].')');
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		$this->db->query('UPDATE cronjob SET progress = 98 WHERE id = '.$cronid);
		
		//immortal runs
		$immortalRuns = $this->getImmortalRuns($attemptsWithDbId, $guildid, $npcsById, $npcRevTra, $charsByKey);
		$sql = 'INSERT INTO `v-immortal-runs` (fodeaths, foadeaths, modeaths, moadeaths, fochange, foachange, mochange, moachange, forid, foarid, morid, moarid, foamount, foaamount, moamount, moaamount, guildid, raidnameid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$deleting = array();
		foreach($immortalRuns as $k => $v){
			if ($v[15] && isset($k) && isset($guildid) && $k != '' && $guildid != ''){
				$deleting[1] .= ($r = (isset($deleting[1]) && $deleting[1] != '') ? ',' : '').$guildid;
				$deleting[2] .= ($r = (isset($deleting[2]) && $deleting[2] != '') ? ',' : '').$k;
				$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
				$insertData[] = $v[1];
				$insertData[] = $v[2];
				$insertData[] = $v[3];
				$insertData[] = $v[4];
				$insertData[] = $v[5];
				$insertData[] = $v[6];
				$insertData[] = $v[7];
				$insertData[] = $v[8];
				$insertData[] = intval($v[9]);
				$insertData[] = intval($v[10]);
				$insertData[] = intval($v[11]);
				$insertData[] = intval($v[12]);
				$insertData[] = $v[13];
				$insertData[] = $v[14];
				$insertData[] = $v[17];
				$insertData[] = $v[18];
				$insertData[] = intval($guildid);
				$insertData[] = intval($k);
			}
		}
		if (!empty($deleting)){
			$this->db->query('DELETE FROM `v-immortal-runs` WHERE guildid IN ('.$deleting[1].') AND raidnameid IN ('.$deleting[2].')');
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		unset($insertQuery);
		unset($insertData);
		unset($deleting);
		////gc_collect_cycles();
		
		print "43 done <br />";
		
		$this->db->query('UPDATE cronjob SET progress = 99 WHERE id = '.$cronid);
		
		// Get armory professions and talent specs
		// Check professions
		/// Engineering Thorium Grenades
		$isEngineer = array();
		foreach($this->dmg as $k => $v){ // charid
			if (isset($charsByKey[$k]) && !isset($npcs[$k])){
				foreach($v as $ke => $va){ // abilityid
					if ($ke != "i"){
						if ($this->abilitiesById[$ke][1]==$spellsTra["Thorium Grenade"] or $this->abilitiesById[$ke][1]==$spellsTra["Goblin Sapper Charge"] or $this->abilitiesById[$ke][1]==$spellsTra["Force Reactive Disk"]){
							$isEngineer[$charsByKey[$k]] = true;
							break 1;
						}
					}
				}
			}
		}
		
		// Get talent specs
		// Rogues
		// Combat: Blade Flurry/Adrenaline Rush
		// Subtletly: Hemorrhage
		// Assasination: Backstab and not those above // Cold Blood
		// Warrior
		// Protection: Shield Slam
		// Fury: Bloodthirst/ Death Wish
		// Arms: Sweeping Strikes/Mortal Strike/ not above
		// Priest:
		// Holy: Holy Nova // not Disci and not Shadow
		// Discipline: Power Infusion
		// Shadow: Shadow Form
		// Druid:
		// Feral: Majority of time in cat or bear
		// Boomkin: Majority of time in Boomkin
		// Resto: Did more than X heal
		// Hunter:
		// Marksman: Trueshot aura => kinda hacky but oh well
		// Survival: Deterrence
		// Beast Master: Not those above
		// Mage:
		// FRost: Majortiy of dmg is frostbolt
		// Fire: Majority of dmg is Fireball and Incinerate / Ice Barrier
		// Arcane: If not above / Combustion
		// Warlock:
		// Affliction: Not those below
		// Demonology: Soul Link / Demonic Sacrifice
		// Destruction: Conflagrate / Shadowburn
		// Paladin:
		// Retri: Vengeance / Seal of Command
		// Holy: Divine Favor / Holy Shock // Healed lots
		// Protection: Holy Shield
		// Shamen
		// Elemental: Elemental Mastery // Did majority of dmg with Lightning Bolt and Chain Lightning
		// Enhancment: Stormstrike // Flurry // Did Parry
		// Resto: CHAIN HEAL LOL // natures Swiftness // Mana Tide Totem
		
		// Checking Buffs
		$talentSpec = array();
		foreach($this->auras as $k => $v){ // user
			if (isset($charsByKey[$k]) && !isset($npcs[$k])){
				foreach($v as $ke => $va){ // ability
					// Rogue
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Blade Flurry"], $spellsTra["Adrenaline Rush"]))){
						$talentSpec[$k] = 2;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Cold Blood"]))){
						$talentSpec[$k] = 1;
						break 1; 
					}
					// Warrior
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Sweeping Strikes"]))){
						$talentSpec[$k] = 1;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Death Wish"], $spellsTra["Enrage"], $spellsTra["Flurry"]))){
						$talentSpec[$k] = 2;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Last Stand"]))){
						$talentSpec[$k] = 3;
						break 1; 
					}
					// Shamen
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Elemental Mastery"]))){
						$talentSpec[$k] = 1;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Flurry"]))){
						$talentSpec[$k] = 2;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Nature's Swiftness"]))){
						$talentSpec[$k] = 3;
						break 1; 
					}
					// Druid
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Moonkin Form"]))){
						$talentSpec[$k] = 1;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Frenzied Regeneration"]))){
						$talentSpec[$k] = 2;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Nature's Swiftness"]))){
						$talentSpec[$k] = 3;
						break 1; 
					}
					// Priest
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Power Infusion"])) && $this->userById[$k][2]=="priest"){
						$talentSpec[$k] = 1;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Shadowform"]))){
						$talentSpec[$k] = 3;
						break 1; 
					}
					// Hunter
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Trueshot Aura"])) && $this->userById[$k][2]=="hunter"){
						$talentSpec[$k] = 2;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Deterrence"]))){
						$talentSpec[$k] = 3;
						break 1; 
					}
					// Mage
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Arcane Power"], $spellsTra["Presence of Mind"]))){
						$talentSpec[$k] = 1;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Combustion"]))){
						$talentSpec[$k] = 2;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Ice Block"], $spellsTra["Ice Barrier"]))){
						$talentSpec[$k] = 3;
						break 1; 
					}
					// Warlock
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Soul Link"], $spellsTra["Demonic Sacrifice"]))){
						$talentSpec[$k] = 2;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Nightfall"], $spellsTra["Amplify Curse"]))){
						$talentSpec[$k] = 1;
						break 1; 
					}
					// Paladin
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Divine Favor"]))){
						$talentSpec[$k] = 1;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Holy Shield"]))){
						$talentSpec[$k] = 2;
						break 1; 
					}
					if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Vengeance"], $spellsTra["Seal of Command"]))){
						$talentSpec[$k] = 3;
						break 1; 
					}
				}
			}
		}
		
		// Checking Dmgdone
		foreach($this->dmg as $k => $v){
			if (isset($charsByKey[$k]) && !isset($npcs[$k])){
				if (!isset($talentSpec[$k])){
					// Rogue
					foreach($v as $ke => $va){
						if ($ke!="i"){
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Backstab"]))){
								$talentSpec[$k] = 1;
								break 1;
							}
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Sinister Strike"]))){
								$talentSpec[$k] = 2;
								break 1;
							}
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Hemorrhage"]))){
								$talentSpec[$k] = 3;
								break 1;
							}
							// Warrior
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Mortal Strike"]))){
								$talentSpec[$k] = 1;
								break 1;
							}
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Bloodthirst"]))){
								$talentSpec[$k] = 2;
								break 1;
							}
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Shield Slam"]))){
								$talentSpec[$k] = 3;
								break 1;
							}
							// Mage
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Ignite"]))){
								$talentSpec[$k] = 2;
								break 1;
							}
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Frostbolt"]))){
								$talentSpec[$k] = 3;
								break 1;
							}
							// Warlock
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Shadowburn"], $spellsTra["Conflagrate"]))){
								$talentSpec[$k] = 3;
								break 1;
							}
							// Shaman
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Stormstrike"]))){
								$talentSpec[$k] = 2;
								break 1;
							}
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Lightning Bolt"], $spellsTra["Chain Lightning"]))){
								$talentSpec[$k] = 1;
								break 1;
							}
							// Hunter
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Scatter Shot"]))){
								$talentSpec[$k] = 2;
								break 1;
							}
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Wyvern Sting"]))){
								$talentSpec[$k] = 3;
								break 1;
							}
							// Paladin
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Holy Shock"]))){
								$talentSpec[$k] = 1;
								break 1;
							}
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Holy Shield"]))){
								$talentSpec[$k] = 2;
								break 1;
							}
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Seal of Command"]))){
								$talentSpec[$k] = 3;
								break 1;
							}
							// Priest
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Mind Flay"], $spellsTra["Vampiric Embrace"]))){
								$talentSpec[$k] = 3;
								break 1;
							}
							// Druid
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Starfire"]))){
								$talentSpec[$k] = 1;
								break 1;
							}
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Maul"]))){
								$talentSpec[$k] = 2;
								break 1;
							}
						}
					}
				}
			}
		}
		
		// Checking heal
		foreach($this->thealing as $k => $v){
			if (isset($charsByKey[$k]) && !isset($npcs[$k])){
				if (!isset($talentSpec[$k])){
					foreach($v as $ke => $va){
						if ($ke!="i"){
							// Priest
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Holy Nova"]))){
								$talentSpec[$k] = 2;
								break 1;
							}
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Vampiric Embrace"]))){
								$talentSpec[$k] = 3;
								break 1;
							}
							// Paladin
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Holy Shock"], $spellsTra["Flash of Light"], $spellsTra["Holy Light"]))){
								$talentSpec[$k] = 1;
								break 1;
							}
							// Druid
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Swiftmend"], $spellsTra["Regrowth"], $spellsTra["Rejuvenation"], $spellsTra["Healing Touch"]))){
								$talentSpec[$k] = 3;
								break 1;
							}
							// Shaman
							if (in_array($this->abilitiesById[$ke][1], array($spellsTra["Healing Wave"], $spellsTra["Chain Heal"], $spellsTra["Lesser Healing Wave"]))){
								$talentSpec[$k] = 3;
								break 1;
							}
						}
					}
				}
			}
		}
		
		foreach($charsByKey as $k => $v){
			if (isset($k) && $k!="" && isset($v) && $v!=""){
				if (!isset($talentSpec[$k])){
					switch($this->userById[$k][2]){
						case "warrior" :
							$talentSpec[$k] = 2;
							break;
						case "rogue" :
							$talentSpec[$k] = 2;
							break;
						case "priest" :
							$talentSpec[$k] = 2;
							break;
						case "shaman" :
							$talentSpec[$k] = 3;
							break;
						case "paladin" :
							$talentSpec[$k] = 1;
							break;
						case "warlock" :
							$talentSpec[$k] = 1;
							break;
						case "hunter" :
							$talentSpec[$k] = 1;
							break;
						case "druid" :
							$talentSpec[$k] = 2;
							break;
						case "mage" :
							$talentSpec[$k] = 1;
							break;
					}
				}
			}
		}
		
		// Putting this shieet into DB
		foreach($charsByKey as $k => $v){
			if (isset($k) && $k!="" && isset($v) && $v!=""){
				// talents
				if (isset($talentSpec[$k]) or isset($isEngineer[$v]))
					$this->db->query('UPDATE `armory` SET talent = '.($r = (isset($talentSpec[$k])) ? '"'.$talentSpec[$k].'"' : "talent").', prof1 = '.($r = (isset($isEngineer[$v])) ? "202" : "prof1").' WHERE charid ='.$v);
			}
		}
		
		
		// Achievement system
		//$this->processAchievements($immortalRuns);
		
		
 		
		foreach($raidsByZone as $var){
			// Get Database Offsets
			// Get all attempts used in this raid
			$offsets = array();
			$offlimits = array();
			$aids = $this->db->query('SELECT group_concat(id) as aids FROM `v-raids-attempts` WHERE rid = "'.$var.'"')->fetch()->aids;
			if ($aids != ""){
				// Getting an idea where it may be
				$idea = $this->db->query('SELECT * FROM `v-raids` WHERE rdy = 1 AND id<'.intval($var-10).' ORDER BY id DESC LIMIT 1')->fetch();
				$offlimits[1] = explode(",", $idea->casts);
				$offlimits[2] = explode(",", $idea->deaths);
				$offlimits[3] = explode(",", $idea->dispels);
				$offlimits[4] = explode(",", $idea->graphdmg);
				$offlimits[5] = explode(",", $idea->graphdmgt);
				$offlimits[6] = explode(",", $idea->graphheal);
				$offlimits[7] = explode(",", $idea->inddeath);
				$offlimits[8] = explode(",", $idea->inddbp);
				$offlimits[9] = explode(",", $idea->indddba);
				$offlimits[10] = explode(",", $idea->indddte);
				$offlimits[11] = explode(",", $idea->inddtbp);
				$offlimits[12] = explode(",", $idea->inddtfa);
				$offlimits[13] = explode(",", $idea->inddtfs);
				$offlimits[14] = explode(",", $idea->indhba);
				$offlimits[15] = explode(",", $idea->indhtf);
				$offlimits[16] = explode(",", $idea->indint);
				$offlimits[17] = explode(",", $idea->indprocs);
				$offlimits[18] = explode(",", $idea->indintm);
				$offlimits[19] = explode(",", $idea->newbuffs);
				$offlimits[20] = explode(",", $idea->newdebuffs);
				$offlimits[21] = explode(",", $idea->indrecords);
				$offlimits[22] = explode(",", $idea->loot);
				$offlimits[23] = explode(",", $idea->graphff);
				
				/*UPDATE `v-raids` SET 
				casts = "0,99999999999",
				deaths = "0,99999999999",
				dispels = "0,99999999999",
				graphdmg = "0,99999999999",
				graphdmgt = "0,99999999999",
				inddbp = "0,99999999999",
				graphheal = "0,99999999999",
				inddeath = "0,99999999999",
				inddtbp = "0,99999999999",
				indddba = "0,99999999999",
				indddte = "0,99999999999",
				inddtfa = "0,99999999999",
				inddtfs = "0,99999999999",
				indhba = "0,99999999999",
				indhtf = "0,99999999999",
				indint = "0,99999999999",
				indprocs = "0,99999999999",
				indintm = "0,99999999999",
				newbuffs = "0,99999999999",
				newdebuffs = "0,99999999999",
				indrecords = "0,99999999999",
				loot = "0,99999999999",
				graphff = "0,99999999999" WHERE rdy = -1
				*/
				if (substr($aids, -1) == ",")
				{
					$aids = substr($aids, 0, -1);
				}
				
				//print 'SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-casts` WHERE id>'.intval($offlimits[1][0]).' AND attemptid IN ('.$aids.')';
				$offsets[1] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-casts` WHERE id>'.intval($offlimits[1][0]).' AND attemptid IN ('.$aids.')')->fetch();
				$offsets[2] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-deaths` WHERE id>'.intval($offlimits[2][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[3] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-dispels` WHERE id>'.intval($offlimits[3][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[4] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-graph-individual-dmgdone` WHERE id>'.intval($offlimits[4][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[5] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-graph-individual-dmgtaken` WHERE id>'.intval($offlimits[5][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[6] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-graph-individual-healingreceived` WHERE id>'.intval($offlimits[6][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[7] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-individual-death` WHERE id>'.intval($offlimits[7][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[8] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-individual-debuffsbyplayer` WHERE id>'.intval($offlimits[8][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[9] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-individual-dmgdonebyability` WHERE id>'.intval($offlimits[9][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[10] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-individual-dmgdonetoenemy` WHERE id>'.intval($offlimits[10][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[11] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-individual-dmgtakenbyplayer` WHERE id>'.intval($offlimits[11][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[12] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-individual-dmgtakenfromability` WHERE id>'.intval($offlimits[12][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[13] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-individual-dmgtakenfromsource` WHERE id>'.intval($offlimits[13][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[14] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-individual-healingbyability` WHERE id>'.intval($offlimits[14][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[15] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-individual-healingtofriendly` WHERE id>'.intval($offlimits[15][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[16] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-individual-interrupts` WHERE id>'.intval($offlimits[16][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[17] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-individual-procs` WHERE id>'.intval($offlimits[17][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[18] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-interruptsmissed` WHERE id>'.intval($offlimits[18][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[19] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-newbuffs` WHERE id>'.intval($offlimits[19][0]).' AND  rid = "'.$var.'"')->fetch();
				$offsets[20] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-newdebuffs` WHERE id>'.intval($offlimits[20][0]).' AND  rid = "'.$var.'"')->fetch();
				$offsets[21] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-records` WHERE id>'.intval($offlimits[21][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[22] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-graph-individual-friendlyfire` WHERE id>'.intval($offlimits[23][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[23] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `v-raids-loot` WHERE id>'.intval($offlimits[22][0]).' AND  attemptid IN ('.$aids.')')->fetch();
			
				for ($i=1; $i<24; $i++){
					if (intval($offsets[$i]->min)==0)
						$offsets[$i]->min = 0;
					if (intval($offsets[$i]->max)==0)
						$offsets[$i]->max = 0;
				}
				
				$this->db->query('UPDATE `v-raids` SET rdy = "1", 
					casts = "'.$offsets[1]->min.','.$offsets[1]->max.'",
					deaths = "'.$offsets[2]->min.','.$offsets[2]->max.'",
					dispels = "'.$offsets[3]->min.','.$offsets[3]->max.'",
					graphdmg = "'.$offsets[4]->min.','.$offsets[4]->max.'",
					graphdmgt = "'.$offsets[5]->min.','.$offsets[5]->max.'",
					graphheal = "'.$offsets[6]->min.','.$offsets[6]->max.'",
					inddeath = "'.$offsets[7]->min.','.$offsets[7]->max.'",
					inddbp = "'.$offsets[8]->min.','.$offsets[8]->max.'",
					indddba = "'.$offsets[9]->min.','.$offsets[9]->max.'",
					indddte = "'.$offsets[10]->min.','.$offsets[10]->max.'",
					inddtbp = "'.$offsets[11]->min.','.$offsets[11]->max.'",
					inddtfa = "'.$offsets[12]->min.','.$offsets[12]->max.'",
					inddtfs = "'.$offsets[13]->min.','.$offsets[13]->max.'",
					indhba = "'.$offsets[14]->min.','.$offsets[14]->max.'",
					indhtf = "'.$offsets[15]->min.','.$offsets[15]->max.'",
					indint = "'.$offsets[16]->min.','.$offsets[16]->max.'",
					indprocs = "'.$offsets[17]->min.','.$offsets[17]->max.'",
					indintm = "'.$offsets[18]->min.','.$offsets[18]->max.'",
					newbuffs = "'.$offsets[19]->min.','.$offsets[19]->max.'",
					newdebuffs = "'.$offsets[20]->min.','.$offsets[20]->max.'",
					indrecords = "'.$offsets[21]->min.','.$offsets[21]->max.'",
					graphff = "'.$offsets[22]->min.','.$offsets[22]->max.'",
					loot = "'.$offsets[23]->min.','.$offsets[23]->max.'"
				WHERE id = "'.$var.'";');
				$this->db->query('UPDATE `v-raids-uploader` SET rdy = "1" WHERE rid = "'.$var.'";');
				$this->db->query('UPDATE `v-raids-attempts` SET rdy = "1" WHERE rid = "'.$var.'";');
			}
		}
		
		print "DONE!<br />";
		
		// Templates
		// v-raids-individual-
		/*foreach($this-> as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					$this->db->query('INSERT INTO v-raids-individual- () VALUES ("'..'")');
				}
			}
		}
		// v-raids-
		foreach($this-> as $k => $v){
			foreach($v as $key => $var){
				$this->db->query('INSERT INTO v-raids- () VALUES ("'..'")');
			}
		}*/
	}
	
	private function isValidLog($kk, $npcsRevTra){
		foreach($this->attempts as $k => $v){
			if ((isset($this->instanceBosses[$v[2]]) or isset($this->instanceBosses[$npcsRevTra[$v[2]]])) && $v[1]==$kk)
				return true;
		}
		return false;
	}
	
	private function validLog($npcsRevTra){
		foreach($this->attempts as $k => $v){
			if (isset($this->instanceBosses[$v[2]]) or isset($this->instanceBosses[$npcsRevTra[$v[2]]]))
				return true;
		}
		return false;
	}
	
	private function isOldLog(){
		foreach($this->dmg as $key => $var){
			foreach($var as $ke => $va){
				if ($ke == "i"){
					$try = false;
					foreach($va as $k => $v){
						$try = true;
					}
					if ($try == true)
						return true;
				}
			}
		}
		return false;
	}
	
	public $superState = true;
	public function __construct($file, $db, $id){
		parent::__construct();
		$this->db = $db;
		
		if ($file == ""){
			$this->superState = true;
			return true;
		}
		// Parse all files and assign them to a variable
		$arr = $this->makePhpArray($file);
		$this->abilities = $arr["DPSMateAbility"];
		print "1 done <br />";
		$this->user = $arr["DPSMateUser"];
		print "2 done <br />";
		$this->dmg = $arr["DPSMateDamageDone"][1];
		print "3 done <br />";
		$this->dmgtaken = $arr["DPSMateDamageTaken"][1];
		print "4 done <br />";
		$this->edt = $arr["DPSMateEDT"][1];
		print "5 done <br />";
		$this->edd = $arr["DPSMateEDD"][1];
		print "6 done <br />";
		$this->dispels = $arr["DPSMateDispels"][1];
		print "7 done <br />";
		$this->interrupts = $arr["DPSMateInterrupts"][1];
		print "8 done <br />";
		$this->deaths = $arr["DPSMateDeaths"][1];
		print "9 done <br />";
		$this->ehealing = $arr["DPSMateEHealing"][1];
		print "10 done <br />";
		$this->thealing = $arr["DPSMateTHealing"][1];
		print "11 done <br />";
		$this->overhealing = $arr["DPSMateOverhealing"][1];
		print "12 done <br />";
		$this->thealingtaken = $arr["DPSMateHealingTaken"][1];
		print "13 done <br />";
		$this->ehealingtaken = $arr["DPSMateEHealingTaken"][1];
		print "14 done <br />";
		$this->absorbs = $arr["DPSMateAbsorbs"][1];
		print "15 done <br />";
		$this->auras = $arr["DPSMateAurasGained"][1];
		print "16 done <br />";
		$this->cbt = $arr["DPSMateCombatTime"];
		print "17 done <br />";
		$this->atmt = $arr["DPSMateAttempts"];
		print "18 done <br />";
		$this->loot = $arr["DPSMateLoot"];
		print "19 done <br />";
		$this->pinfo = $arr["DPSMatePlayer"];
		print "20 done <br />";

		echo "not real: ".(memory_get_peak_usage(false)/1024/1024)." MiB\n";
  		echo "real: ".(memory_get_peak_usage(true)/1024/1024)." MiB\n\n";

		unset($arr);	
		////gc_collect_cycles();

		echo "not real: ".(memory_get_peak_usage(false)/1024/1024)." MiB\n";
  		echo "real: ".(memory_get_peak_usage(true)/1024/1024)." MiB\n\n";

		if (!isset($this->dmg) || !isset($this->thealing) || !isset($this->atmt) || !isset($this->pinfo)){
			$this->superState = true;
			return true;
		}
		$db->query('UPDATE cronjob SET progress = 10 WHERE id = '.$id);
		
		$this->userById = $this->sortById($this->user);
		print "21 done <br />";
		$this->abilitiesById = $this->sortById($this->abilities);
		$this->getTotalTables();
		print "22 done <br />";
		$spells = array();
		$spellsTra = array();
		$spellsRevTra = array();
		foreach($this->db->query('SELECT id, name, deDE, frFR, ruRU, zhCN FROM spells') as $row){
			if (isset($this->abilities[$row->name])){
				$spells[$this->abilities[$row->name][1]] = intval($row->id);
				$spellsTra[$row->name] = $row->name;
				$spellsRevTra[$row->name] = $row->name;
			} 
			if (isset($this->abilities[$row->deDE])){
				$spells[$this->abilities[$row->deDE][1]] = intval($row->id);
				$spellsTra[$row->name] = $row->deDE;
				$spellsRevTra[$row->deDE] = $row->name;
			} 
			if (isset($this->abilities[$row->frFR])){
				$spells[$this->abilities[$row->frFR][1]] = intval($row->id);
				$spellsTra[$row->name] = $row->frFR;
				$spellsRevTra[$row->frFR] = $row->name;
			} 
			if (isset($this->abilities[$row->name."(Periodic)"])){
				$spells[$this->abilities[$row->name."(Periodic)"][1]] = intval($row->id);
				$spellsTra[$row->name."(Periodic)"] = $row->name."(Periodic)";
				$spellsRevTra[$row->name."(Periodic)"] = $row->name."(Periodic)";
			} 
			if (isset($this->abilities[$row->deDE."(Periodisch)"])){
				$spells[$this->abilities[$row->deDE."(Periodisch)"][1]] = intval($row->id);
				$spellsTra[$row->name."(Periodic)"] = $row->deDE."(Periodisch)";
				$spellsRevTra[$row->deDE."(Periodisch)"] = $row->name."(Periodic)";
			} 
			if (isset($this->abilities[$row->frFR."(Périodique)"])){
				$spells[$this->abilities[$row->frFR."(Périodique)"][1]] = intval($row->id);
				$spellsTra[$row->name."(Periodic)"] = $row->frFR."(Périodique)";
				$spellsRevTra[$row->frFR."(Périodique)"] = $row->name."(Periodic)";
			} 
			if (isset($this->abilities[$row->ruRU."(периодический)"])){
				$spells[$this->abilities[$row->ruRU."(периодический)"][1]] = intval($row->id);
				$spellsTra[$row->name."(Periodic)"] = $row->ruRU."(периодический)";
				$spellsRevTra[$row->ruRU."(периодический)"] = $row->name."(Periodic)";
			} 
			if (isset($this->abilities[$row->zhCN."(周期的)"])){
				$spells[$this->abilities[$row->zhCN."(周期的)"][1]] = intval($row->id);
				$spellsTra[$row->name."(Periodic)"] = $row->zhCN."(周期的)";
				$spellsRevTra[$row->zhCN."(周期的)"] = $row->name."(Periodic)";
			} 
		}
		
		
		$npcs = array();
		$npcsById = array();
		$npcsTra = array();
		$npcsTraRev = array();
		foreach($this->db->query('SELECT id, name, deDE, frFR, ruRU, zhCN FROM npcs') as $row){
			if (isset($this->user[$row->name]) || $row->id == 50000 || $row->id == 50001 || $row->id == 50002){
				$npcs[$this->user[$row->name][1]] = intval($row->id);
				$npcsById[$row->id] = $row->name;
				$npcsTra[$row->name] = $row->name;
				$npcsTraRev[$row->name] = $row->name;
			}
			if (isset($this->user[$row->deDE]) || (($row->id == 50000 || $row->id == 50001 || $row->id == 50002) && $this->pinfo[6] == "deDE")){
				$npcs[$this->user[$row->deDE][1]] = intval($row->id);
				$npcsById[$row->id] = $row->deDE;
				$npcsTra[$row->name] = $row->deDE;
				$npcsTraRev[$row->deDE] = $row->name;
			}
			if (isset($this->user[$row->frFR]) || (($row->id == 50000 || $row->id == 50001 || $row->id == 50002) && $this->pinfo[6] == "frFR")){
				$npcs[$this->user[$row->frFR][1]] = intval($row->id);
				$npcsById[$row->id] = $row->frFR;
				$npcsTra[$row->name] = $row->frFR;
				$npcsTraRev[$row->frFR] = $row->name;
			}
			if (isset($this->user[$row->ruRU]) || (($row->id == 50000 || $row->id == 50001 || $row->id == 50002) && $this->pinfo[6] == "ruRU")){
				$npcs[$this->user[$row->ruRU][1]] = intval($row->id);
				$npcsById[$row->id] = $row->ruRU;
				$npcsTra[$row->name] = $row->ruRU;
				$npcsTraRev[$row->ruRU] = $row->name;
			}
			if (isset($this->user[$row->zhCN]) || (($row->id == 50000 || $row->id == 50001 || $row->id == 50002) && $this->pinfo[6] == "zhCN")){
				$npcs[$this->user[$row->zhCN][1]] = intval($row->id);
				$npcsById[$row->id] = $row->zhCN;
				$npcsTra[$row->name] = $row->zhCN;
				$npcsTraRev[$row->zhCN] = $row->name;
			}
		}
		$npcs[100001] = 50000;
		$npcs[100002] = 50001;
		$npcs[100003] = 50002;
		$db->query('UPDATE cronjob SET progress = 20 WHERE id = '.$id);
		$this->getAttempts($npcsTra, $npcsTraRev);
		if (!$this->validLog($npcsTraRev)){
			$this->superState = true;
			print "Rejected here!!";
			return true;
		}
		print "23 done <br />";
		$this->sortAttemptsToNpc();
		print "24 done <br />";
		$this->getParticipants($spellsTra, $npcs);
		print "25 done <br />";
		$this->getDmgDone($npcsTraRev, $npcsTra, $spellsRevTra, $npcs);
		print "26 done <br />";
		$db->query('UPDATE cronjob SET progress = 30 WHERE id = '.$id);
		$this->getDmgTaken($npcsTraRev, $npcsTra, $npcs);
		$db->query('UPDATE cronjob SET progress = 34 WHERE id = '.$id);
		print "27 done <br />";
		$this->getHealing($npcs, $spellRevTra);
		$db->query('UPDATE cronjob SET progress = 38 WHERE id = '.$id);
		print "28 done <br />";
		$this->getAuras($spellsTra, $spellsRevTra);
		print "29 done <br />";
		$db->query('UPDATE cronjob SET progress = 40 WHERE id = '.$id);
		$this->getDeaths();
		print "30 done <br />";
		$this->getInterrupts($spellsTra, $spellsRevTra);
		$db->query('UPDATE cronjob SET progress = 45 WHERE id = '.$id);
		print "31 done <br />";
		$this->getDispels($spellsTra, $spellsRevTra);
		print "32 done <br />";
		$db->query('UPDATE cronjob SET progress = 50 WHERE id = '.$id);
		
		//echo "not real: ".(memory_get_peak_usage(false)/1024/1024)." MiB\n";
  		//echo "real: ".(memory_get_peak_usage(true)/1024/1024)." MiB\n\n";

		////gc_collect_cycles();
		$this->writeIntoDB($spells, $npcs, $npcsById, $npcsTra, $npcsTraRev, $spellsTra, $spellsRevTra, $id);
		$this->superState = $this->supersuperstate;
		return $this->supersuperstate;
	}
}


?>