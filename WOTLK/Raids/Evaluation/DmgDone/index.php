<?php
require(dirname(__FILE__)."/../Template.php");

class Home extends Template{
	private $modes = array(
		0 => "by source",
		1 => "to enemy",
		2 => "by ability",
		3 => "to friendly"
	);
	private $beneficial = array(
		// General
		"Earthstrike" => true,
		"Juju Flurry" => true,
		"Holy Strength" => true,
		"Ephemeral Power" => true,
		"Chromatic Infusion" => true,
		"Brittle Armor" => true,
		"Unstable Power" => true,
		"Zandalarian Hero Medallion" => true,
		"Ascendance" => true,
		"Essence of Sapphiron" => true,
		"Hand of Justice" => true,
		"Sword Specialization" => true,
		"Bonereaver's Edge" => true,
		
		//New
		"Felstriker" => true,
		"Sanctuary" => true,
		"Fury of Forgewright" => true,
		"Primal Blessing" => true,
		"Spinal Reaper" => true, // To test
		"Netherwind Focus" => true, // To test
		"Parry" => true, // To test
		"Untamed Fury" => true,
		"The Eye of Diminution" => true,
		"Kiss of the Spider" => true,
		"Glyph of Deflection" => true,
		"The Eye of the Dead" => true,
		"Slayer's Crest" => true,
		"Badge of the Swarmguard" => true,
		"Arcane Shroud" => true,
		"Persistent Shield" => true,
		"Jom Gabbar" => true,
		"The Burrower's Shell" => true,
		"Thrash" => true,
		"Free Action" => true,
		"Living Free Action" => true,
		"Restoration" => true,
		"Speed" => true,
		"Invulnerability" => true,
		"Aura of the Blue Dragon" => true, // Mana Darkmoon card
		"Invulnerability" => true,
		"Battle Squawk" => true,
		"Devilsaur Fury" => true,
		"Furious Howl" => true,
		"Healing Potion" => true,
		"Major Rejuvenation Potion" => true,
		"Mana Potion" => true,
		"Restore Mana" => true,
		"Dreamless Sleep" => true,
		
		
		// Rogue
		"Slice and Dice" => true,
		"Blade Flurry" => true,
		"Sprint" => true,
		"Adrenaline Rush" => true,
		"Vanish" => true,
		"Relentless Strikes Effect" => true,
		"Ruthlessness" => true, // To Test!!!!
		"Rogue Armor Energize Effect" => true,
		"Rogue Armor Energize" => true,
		"Invigorate" => true,
		"Head Rush" => true,
		"Venomous Totem" => true,
		"Evasion" => true,
		"Restore Energy" => true,
		"Remorseless Attacks" => true,
		"Combat Potency" => true,
		
		// Mage
		"Arcane Power" => true,
		"Combustion" => true,
		"Mind Quickening" => true,
		"Enigma Resist Bonus" => true,
		"Enigma Blizzard Bonus" => true,
		"Adaptive Warding" => true,
		"Not There" => true,
		"Cold Snap" => true,
		"Presence of Mind" => true,
		"Ice Block" => true,
		
		// Priest
		"Power Infusion" => true,
		"Oracle Healing Bonus" => true,
		"Epiphany" => true,
		"Aegis of Preservation" => true,
		"Inspiration" => true,
		"Blessed Recovery" => true,
		"Focused Casting" => true,
		"Spirit Tap" => true,
		
		// Druid
		"Symbols of Unending Life Finisher Bonus" => true,
		"Metamorphosis Rune" => true,
		"Clearcasting" => true,
		"Nature's Grace" => true,
		
		// Paladin
		"Battlegear of Eternal Justice" => true,
		"Blinding Light" => true,
		"Divine Favor" => true,
		"Divine Shield" => true,
		"Redoubt" => true,
		"Holy Shield" => true,
		"Vengeance" => true,
		"Blessing of Freedom" => true,
		"Blessing of Sacrifice" => true,
		"Blessing of Protection" => true,
		
		// Shaman
		"Stormcaller's Wrath" => true,
		"Nature Aligned" => true,
		"Elemental Mastery" => true,
		"Windfury Weapon" => true,
		"Windfury Totem" => true,
		"Nature's Swiftness" => true,
		"Ancestral Healing" => true,
		"Reincarnation" => true,
		"Elemental Mastery" => true,
		
		// Warlock
		"Vampirism" => true,
		"Nightfall" => true,
		"Soul Link" => true,
		
		// Warrior
		"Cheat Death" => true,
		"Gift of Life" => true,
		"Bloodrage" => true,
		"Flurry" => true,
		"Enrage" => true,
		"Sweeping Strikes" => true,
		"Death Wish" => true,
		"Recklessness" => true,
		"Mighty Rage" => true,
		"Great Rage" => true,
		"Rage" => true,
		"Berserker Rage" => true,
		"Shield Wall" => true,
		"Retaliation" => true,
		"Diamond Flask" => true,
		"Shield Block" => true,
		"Last Stand" => true,
		
		// Hunter
		"Arcane Infused" => true,
		"Quick Shots" => true,
		"Rapid Fire" => true,
		
		"Mana Restore" => true,
		"Ferocious Inperation" => true,
		"Spell Haste" => true,
		"Lightning Speed" => true,
		"Blade Turning" => true,
		"Rampage" => true,
		
		"Drums of Battle" => true,
		"Drums of Panic" => true,
		"Drums of Restoration" => true,
		"Drums of Speed" => true,
		"Drums of War" => true,
		"Fel Strength Elixir" => true,
		"Elixir of Ironskin" => true,
		"Elixir of Draenic Wisdom" => true,
		"Elixir of Mastery" => true,
		"Adept's Elixir" => true,
		"Onslaught Elixir" => true,
		"Haste" => true,
		"Potion of Heroes" => true,
		"Destruction" => true,
		"Surprise Attacks" => true,
		"Shadowstep" => true,
		"The Beast Within" => true,
		"Divine Illumination" => true,
		"Shamanistic Rage" => true,
	);
	private $nonbeneficial = array(
		// Boss Spells
		"Lucifron's Curse" => true,
		"Gehennas' Curse" => true,
		"Panic" => true,
		"Living Bomb" => true,
		"Brood Affliction: Bronze" => true,
		"Bellowing Roar" => true,
		"Fear" => true,
		"Entangle" => true,
		"Digestive Acid" => true,
		"Locust Swarm" => true,
		"Web Wrap" => true,
		"Mutating Injection" => true,
		"Terrifying Roar" => true,
		
		// Kazzak
		"Thunderclap" => true,
		
		//Doomwalker
		"Earthquake" => true,
		
		//BT
		"Impaling Spine" => true,
		
		// SSC
		"Water Tomb" => true,
		"Insidious Whisper" => true,
		"Consuming Madness" => true,
		"Cataclysmic Bolt" => true,
		"Earthbind Totem" => true,
		"Tidal Surge" => true,
		"Tidal Wave" => true, 
		"Panic" => true, 
		
		// Kara
		"Intangible Presence" => true,
		"Berserker Charge" => true,
		"Blind" => true,
		"Gouge" => true,
		"Terrifying Howl" => true,
		"Little Red Riding Hood" => true,
		"Wide Swipe" => true,
		"Frightened Scream" => true,
		"Annoying Yipping" => true,
		"Brain Bash" => true,
		"Cyclone" => true,
		"Powerful Attraction" => true,
		"Backward Lunge" => true,
		"Holy Ground" => true,
		"Repentance" => true,
		"Sacrifice" => true,
		"Counterspell" => true,
		"Blizzard" => true,
		"Slow" => true,
		"Polymorph" => true,
		"Enfeeble" => true,
		"Amplify Damage" => true,
		"Distracting Ash" => true,
		"Tail Sweep" => true,
		
		// Gruul
		"Death Coil" => true,
		"Reverberation" => true,
		"Ground Slam" => true,
		"Stoned" => true,
		
		// Magtheridon
		"Quake" => true,
		"Mind Exhaustion" => true,
		
		// Zul Aman
		"Deafening Roar" => true,
		"Static Disruption" => true,
		"Gust of Wind" => true,
		"Paralyzed" => true,
		
		// Tempest Keep
		"Silence" => true,
		"Remote Toy" => true,
		"Arcane Disruption" => true,
		"Mind Control" => true,
		"Gravity Lapse" => true,
		
		// Hyjal
		"Sleep" => true,
		"Inferno" => true,
		"War Stomp" => true,
		"Howl of Azgalor" => true,
		"Doom" => true,
		"Air Burst" => true,
		
		// SWP
		"Wild Magic" => true,
		"Stomp" => true,
		"Encapsulate" => true,
		"Fog of Corruption" => true,
		"Dark Strike" => true,
		"Void Blast" => true,
	);
	
	private function average(&$t, $t2, $mC, $c, $name){
		$tot = $mC+$c;
		if (isset($mC) && isset($c) && isset($t2)){
			if (!$t && $t != 0){
				$t = $t2;
			}else{
				if ($mC>0)
					$t = $t*$mC/$tot+$t2*$c/$tot;
			}
		}else{
			$t = $t2;
		}
	}
	
	private function getTable(){
		$t = array();
		if ($this->attempts){
			$con = 'b.id IN ('.$this->attempts.')';
			if ($this->sel)
				$con = 'b.id = "'.$this->sel.'"';
		}elseif ($this->sel){
			$con = 'b.id = "'.$this->sel.'"';
		}else{
			$con = 'b.rid = "'.$this->rid.'"';
		}
		if ($this->player)
			$con .= ' AND a.charid IN ("'.$this->player.'"'.$this->getPet($this->db).')';
		if ($this->tarid)
			$con2 = ' AND a.npcid ='.$this->tarid;
		switch ($this->mode){
			case 0 :
				$offset = explode(",", $this->raidinfo->indddte);
				foreach ($this->db->query('SELECT a.charid, a.amount, a.active FROM `wotlk-raids-individual-dmgdonetoenemy` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$t[1] += $row->amount;
					if (!$this->player && $this->pet == 0 && $this->participants[4][$row->charid]->ownerid){
						$t[2][$this->participants[4][$row->charid]->ownerid] += $row->amount;
						$t[3][$this->participants[4][$row->charid]->ownerid] += $row->active;
					}else{
						$t[2][$row->charid] += $row->amount;
						$t[3][$row->charid] += $row->active;
					}
					if (!$t[4] || $t[2][$row->charid]>$t[4])
						$t[4] = $t[2][$row->charid];
					if (!$t[4] || $t[2][$this->participants[4][$row->charid]->ownerid]>$t[4])
						$t[4] = $t[2][$this->participants[4][$row->charid]->ownerid];
					$t[7][$row->charid] = 1;
				}
				break;
			case 1 :
				$offset = explode(",", $this->raidinfo->indddte);
				foreach ($this->db->query('SELECT a.npcid, a.amount, a.active, a.attemptid FROM `wotlk-raids-individual-dmgdonetoenemy` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$t[1] += $row->amount;
					$t[2][$row->npcid] += $row->amount;
					$t[3][$row->npcid] += $row->active;
					$t[5][$row->npcid] = $this->npcsById[$row->npcid]->name;
					$t[6][$row->npcid] = $row->attemptid;
					if (!isset($t[7][$row->npcid]))
						$t[7][$row->npcid] = 0;
					$t[7][$row->npcid]++;
					if (!$t[4] || $t[2][$row->npcid]>$t[4])
						$t[4] = $t[2][$row->npcid];
				}
				break;
			case 2 : 
				$offset = explode(",", $this->raidinfo->indddba);
				foreach ($this->db->query('SELECT a.abilityid, a.amount, a.casts, a.hits, a.crit, a.miss, a.parry, a.dodge, a.resist FROM `wotlk-raids-individual-dmgdonebyability` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2.' ORDER BY a.casts') as $row){
					$t[1] += $row->amount;
					$t[2][$row->abilityid] += $row->amount;
					$t[3][$row->abilityid] += $row->active;
					$t[5][$row->abilityid] = Array(1=>$this->spells[$row->abilityid]->name, 2=>$this->spells[$row->abilityid]->icon);
					$this->average($t[7][$row->abilityid], $row->crit, $t[12][$row->abilityid], $row->casts);
					$this->average($t[8][$row->abilityid], $row->miss, $t[12][$row->abilityid], $row->casts);
					$this->average($t[9][$row->abilityid], $row->parry, $t[12][$row->abilityid], $row->casts);
					$this->average($t[10][$row->abilityid], $row->dodge, $t[12][$row->abilityid], $row->casts);
					$this->average($t[11][$row->abilityid], $row->resist, $t[12][$row->abilityid], $row->casts);
					$t[12][$row->abilityid] += $row->casts;
					$t[13][$row->abilityid] += $row->hits;
					$t[14] += $row->casts;
					$t[15] += $row->hits;
					$this->average($t[16], $t[6][$row->abilityid]);
					if (!$t[4] || $t[2][$row->abilityid]>$t[4])
						$t[4] = $t[2][$row->abilityid];
				}
				break;
			case 3 :
				$offset = explode(",", $this->raidinfo->inddtbp);
				foreach ($this->db->query('SELECT a.charid, a.amount, a.culpritid FROM `wotlk-raids-individual-dmgtakenbyplayer` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con) as $row){
					if ($this->player){
						$t[1] += $row->amount;
						$t[2][$row->culpritid] += $row->amount;
						$t[3][$row->culpritid] += $row->active;
						if (!$t[4] || $t[2][$row->culpritid]>$t[4])
							$t[4] = $t[2][$row->culpritid];
						$t[7][$row->culpritid] = 1;
					}else{
						$t[1] += $row->amount;
						$t[2][$row->charid] += $row->amount;
						$t[3][$row->charid] += $row->active;
						if (!$t[4] || $t[2][$row->charid]>$t[4])
							$t[4] = $t[2][$row->charid];
						$t[7][$row->charid] = 1;
					}
				}
				break;
		}
		arsort($t[2]);
		if ($this->mode != 2){
			$offset = explode(",", $this->raidinfo->indrecords);
			foreach ($this->db->query('SELECT a.id, a.charid, a.realm, a.charid, a.realmtype, a.realmclass, b.npcid FROM `wotlk-raids-records` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND a.type = -1 AND '.$con.' ORDER BY a.realm, a.realmtype, a.realmclass LIMIT 12') as $row){
				$t[10][$row->id] = $row;
			}
		}
		return $t;
	}
	
	private function getGraphValues(){
		$p = array();
		$q = array();
		$e = array();
		if ($this->attempts){
			$con = 'b.id IN ('.$this->attempts.')';
			if ($this->sel)
				$con = 'b.id = "'.$this->sel.'"';
		}elseif ($this->sel){
			$con = 'b.id = "'.$this->sel.'"';
		}else{
			$con = 'b.rid = "'.$this->rid.'"';
		}
		if ($this->tarid)
			$con2 = ' AND a.npcid = "'.$this->tarid.'"';
		if ($this->player){
			$con .= ' AND a.charid IN ("'.$this->player.'"'.$this->getPet().')';
			$offset = explode(",", $this->raidinfo->newbuffs);
			foreach($this->db->query('SELECT abilityid, cbtstart, cbtend FROM `wotlk-raids-newbuffs` WHERE id BETWEEN '.$offset[0].' AND '.$offset[1].' AND rid = '.$this->rid.' AND charid = '.$this->player) as $row){
				if (!isset($buffs[$row->abilityid]))
					$buffs[$row->abilityid] = array(1=>"",2=>"");
				$buffs[$row->abilityid][1] .= $row->cbtstart.",";
				$buffs[$row->abilityid][2] .= $row->cbtend.",";
			}
			$offset = explode(",", $this->raidinfo->newdebuffs);
			foreach($this->db->query('SELECT abilityid, cbtstart, cbtend FROM `wotlk-raids-newdebuffs` WHERE id BETWEEN '.$offset[0].' AND '.$offset[1].' AND rid = '.$this->rid.' AND charid = '.$this->player) as $row){
				if (!isset($debuffs[$row->abilityid]))
					$debuffs[$row->abilityid] = array(1=>"",2=>"");
				$debuffs[$row->abilityid][1] .= $row->cbtstart.",";
				$debuffs[$row->abilityid][2] .= $row->cbtend.",";
			}
			if ($this->tarid){
				if ($this->mode==3){
					$offset = explode(",", $this->raidinfo->graphff);
					foreach ($this->db->query('SELECT a.time, a.amount, a.charid, a.abilityid FROM `wotlk-raids-graph-individual-friendlyfire` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND culpritid = "'.$this->player.'"') as $row){
						$q[$row->abilityid][1] .= $row->time.",";
						$q[$row->abilityid][2] .= $row->amount.",";
					}
					return $this->evalStackedGraphValues($q, false, $buffs, $debuffs);
				}else{
					$offset = explode(",", $this->raidinfo->graphdmg);
					foreach ($this->db->query('SELECT a.time, a.amount, a.npcid, a.abilityid FROM `wotlk-raids-graph-individual-dmgdone` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
						$q[$row->abilityid][1] .= $row->time.",";
						$q[$row->abilityid][2] .= $row->amount.",";
					}
					return $this->evalStackedGraphValues($q, false, $buffs, $debuffs);
				}
			}else{
				$offset = explode(",", $this->raidinfo->graphdmg);
				if ($this->mode>1 && $this->mode!=3){
					foreach ($this->db->query('SELECT a.time, a.amount, a.charid, a.abilityid FROM `wotlk-raids-graph-individual-dmgdone` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
						$q[$row->abilityid][1] .= $row->time.",";
						$q[$row->abilityid][2] .= $row->amount.",";
					}
					return $this->evalStackedGraphValues($q, false, $buffs, $debuffs);
				}elseif ($this->mode==3){
					$offset = explode(",", $this->raidinfo->graphff);
					foreach ($this->db->query('SELECT a.time, a.amount, a.charid, a.abilityid FROM `wotlk-raids-graph-individual-friendlyfire` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND culpritid = "'.$this->player.'"') as $row){
						$q[$row->abilityid][1] .= $row->time.",";
						$q[$row->abilityid][2] .= $row->amount.",";
					}
					return $this->evalStackedGraphValues($q, false, $buffs, $debuffs);
				}else{
					foreach ($this->db->query('SELECT a.time, a.amount, a.npcid, a.abilityid FROM `wotlk-raids-graph-individual-dmgdone` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
						$q[$row->npcid][$row->abilityid][1] .= $row->time.",";
						$q[$row->npcid][$row->abilityid][2] .= $row->amount.",";
					}
					return $this->evalStackedGraphValues($q, true, $buffs, $debuffs);
				}
			}
		}elseif ($this->tarid && $this->mode!=3){
			$offset = explode(",", $this->raidinfo->graphdmg);
			if ($this->mode==2){
				foreach ($this->db->query('SELECT a.time, a.amount, a.charid, a.abilityid FROM `wotlk-raids-graph-individual-dmgdone` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$q[$row->abilityid][1] .= $row->time.",";
					$q[$row->abilityid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q);
			}else{
				foreach ($this->db->query('SELECT a.time, a.amount, a.charid, a.abilityid FROM `wotlk-raids-graph-individual-dmgdone` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$q[$row->charid][$row->abilityid][1] .= $row->time.",";
					$q[$row->charid][$row->abilityid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q, true);
			}
		}else{
			$offset = explode(",", $this->raidinfo->graphdmg);
			if ($this->mode==2){
				foreach ($this->db->query('SELECT a.time, a.amount, a.abilityid FROM `wotlk-raids-graph-individual-dmgdone` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$q[$row->abilityid][1] .= $row->time.",";
					$q[$row->abilityid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q);
			}elseif ($this->mode==1){
				foreach ($this->db->query('SELECT a.time, a.amount, a.npcid FROM `wotlk-raids-graph-individual-dmgdone` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$q[$row->npcid][1] .= $row->time.",";
					$q[$row->npcid][2] .= $row->amount.",";
				}
				return $this->evalStackedGraphValues($q);
			}elseif ($this->mode==3){
				$offset = explode(",", $this->raidinfo->graphff);
				foreach ($this->db->query('SELECT a.time, a.amount, a.culpritid FROM `wotlk-raids-graph-individual-friendlyfire` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con) as $row){
					$p[1] .= $row->time.",";
					$p[2] .= $row->amount.",";
					$q[$row->culpritid][1] .= $row->time.",";
					$q[$row->culpritid][2] .= $row->amount.",";
				}
			}else{
				foreach ($this->db->query('SELECT a.time, a.amount, a.charid FROM `wotlk-raids-graph-individual-dmgdone` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE a.id BETWEEN '.$offset[0].' AND '.$offset[1].' AND b.rdy = 1 AND '.$con.$con2) as $row){
					$p[1] .= $row->time.",";
					$p[2] .= $row->amount.",";
					$q[$row->charid][1] .= $row->time.",";
					$q[$row->charid][2] .= $row->amount.",";
				}
			}
		}
		foreach($q as $key => $var){
			$q = $this->evalGraphValues($var);
			if ($q)
				$e[$key] = $q;
		}
		return array(1 => $this->evalGraphValues($p), 2 => $e);
	}
	
	private function evalStackedGraphValues($q, $bool, $buffs, $debuffs){
		if ($bool){
			$p = array(); $low = 10000000; $max = 0;
			foreach($q as $ke => $va){
				foreach($va as $key => $var){
					$temp = explode(",", $var[1]);
					$temp2 = explode(",", $var[2]);
					foreach($temp as $k => $v){
						if ($v && $v<=100000){
							if (isset($p[$ke][$key][$v]))
								$p[$ke][$key][$v] += $temp2[$k];
							else
								$p[$ke][$key][$v] = $temp2[$k];
							if ($v<$low)
								$low = $v;
							if ($v>$max)
								$max = $v;
						}
					}
				}
			}
			if (isset($buffs) && isset($debuffs)){
				$buffArr = array(1=>array(),2=>array());
				foreach($buffs as $key => $var){
					if (isset($this->beneficial[$this->spells[$key]->name])){
						$buffArr[1][$key] = explode(",", $var[1]);
						$buffArr[2][$key] = explode(",", $var[2]);
						asort($buffArr[1][$key]);
						// Sort out buffs that are to high and to low
						foreach($buffArr[1][$key] as $k => $v){
							if (($v<=$low && $buffArr[2][$key][$k]<=$low) or $v>=$max)
								unset($buffArr[1][$key][$k]);
						}
					}
				}
				$debuffArr = array(1=>array(),2=>array());
				foreach($debuffs as $key => $var){
					if (isset($this->nonbeneficial[$this->spells[$key]->name])){
						$debuffArr[1][$key] = explode(",", $var[1]);
						$debuffArr[2][$key] = explode(",", $var[2]);
						asort($debuffArr[1][$key]);
						foreach($debuffArr[1][$key] as $k => $v){
							if (($v<=$low && $buffArr[2][$key][$k]<=$low) or $v>=$max)
								unset($debuffArr[1][$key][$k]);
						}
					}
				}
			}
			foreach($p as $ke => $va){
				foreach($va as $key => $var){
					ksort($p[$ke][$key]);
				}
			}
			$e = array();
			$eab = array();
			$auras = array(1=>array(), 2=>array());
			$time = array();
			$space = (($max-$low)/50);
			foreach($p as $ke => $va){
				foreach($va as $key => $var){
					if ($space > 1){
						if (!isset($e[$ke]))
							$e[$ke] = array();
						if (!isset($eab[$ke][$key]))
							$eab[$ke][$key] = array();
						foreach($var as $k => $v){
							for ($i=1; $i<=50; $i++){
								if ($k<=($i*$space+$low) && $k>=(($i-1)*$space+$low) && $k<=20000 && $v<=2000000){
									if (!isset($e[$ke][$low+$i*$space]))
										$e[$ke][$low+$i*$space] = $v;
									else
										$e[$ke][$low+$i*$space] += $v;
									if (!isset($eab[$ke][$key][$low+$i*$space]))
										$eab[$ke][$key][$low+$i*$space] = $v;
									else
										$eab[$ke][$key][$low+$i*$space] += $v;
									$time[$low+$i*$space] = true;
								}
							}
						}
					}else{
						foreach($var as $k => $v){
							$e[$ke][$k] = $v;
							$eab[$ke][$key][$k] = $v;
							$time[$k] = true;
						}
					}
				}
			}
			if (isset($buffs)){
				for ($i=1; $i<=50; $i++){
					foreach($buffArr[1] as $qq => $rr){ // ability
						foreach($rr as $tt => $zz){ // timestamp
							if ($zz<=($i*$space+$low) && $zz>=(($i-1)*$space+$low)){
								$auras[1][$low+$i*$space][$qq] = true;
							}
						}
					}
					foreach($debuffArr[1] as $qq => $rr){ // ability
						foreach($rr as $tt => $zz){ // timestamp
							if ($zz<=($i*$space+$low) && $zz>=(($i-1)*$space+$low)){
								$auras[2][$low+$i*$space][$qq] = true;
							}
						}
					}
				}
			}
			ksort($time);
			return array(1=>$e,2=>$eab,3=>$time, 4=>$auras);
		}else{
			$p = array(); $low = 10000000; $max = 0;
			foreach($q as $key => $var){
				$temp = explode(",", $var[1]);
				$temp2 = explode(",", $var[2]);
				foreach($temp as $k => $v){
					if ($v && $v<=2000000){
						if (isset($p[$key][$v]))
							$p[$key][$v] += $temp2[$k];
						else
							$p[$key][$v] = $temp2[$k];
						if ($v<$low)
							$low = $v;
						if ($v>$max)
							$max = $v;
					}
				}
			}
			if (isset($buffs) && isset($debuffs)){
				$buffArr = array(1=>array(),2=>array());
				foreach($buffs as $key => $var){
					if (isset($this->beneficial[$this->spells[$key]->name])){
						$buffArr[1][$key] = explode(",", $var[1]);
						$buffArr[2][$key] = explode(",", $var[2]);
						asort($buffArr[1][$key]);
						// Sort out buffs that are to high and to low
						foreach($buffArr[1][$key] as $k => $v){
							if (($v<=$low && $buffArr[2][$key][$k]<=$low) or $v>=$max)
								unset($buffArr[1][$key][$k]);
						}
					}
				}
				$debuffArr = array(1=>array(),2=>array());
				foreach($debuffs as $key => $var){
					if (isset($this->nonbeneficial[$this->spells[$key]->name])){
						$debuffArr[1][$key] = explode(",", $var[1]);
						$debuffArr[2][$key] = explode(",", $var[2]);
						asort($debuffArr[1][$key]);
						foreach($debuffArr[1][$key] as $k => $v){
							if (($v<=$low && $buffArr[2][$key][$k]<=$low) or $v>=$max)
								unset($debuffArr[1][$key][$k]);
						}
					}
				}
			}
			foreach($p as $key => $var){
				ksort($p[$key]);
			}
			$e = array();
			$auras = array(1=>array(), 2=>array());
			$space = (($max-$low)/50);
			foreach($p as $key => $var){
				if ($space > 1){
					if (!isset($e[$key]))
						$e[$key] = array();
					foreach($var as $k => $v){
						for ($i=1; $i<=50; $i++){
							if ($k<=($i*$space+$low) && $k>=(($i-1)*$space+$low) && $k<=20000 && $v<=2000000){
								if (!isset($e[$key][$low+$i*$space]))
									$e[$key][$low+$i*$space] = $v;
								else
									$e[$key][$low+$i*$space] += $v;
								$time[$low+$i*$space] = true;
							}
						}
					}
				}else{
					foreach($var as $k => $v){
						$e[$key][$k] = $v;
						$time[$k] = true;
					}
				}
			}
			if (isset($buffs)){
				for ($i=1; $i<=50; $i++){
					foreach($buffArr[1] as $qq => $rr){ // ability
						foreach($rr as $tt => $zz){ // timestamp
							if ($zz<=($i*$space+$low) && $zz>=(($i-1)*$space+$low)){
								$auras[1][$low+$i*$space][$qq] = true;
							}
						}
					}
					foreach($debuffArr[1] as $qq => $rr){ // ability
						foreach($rr as $tt => $zz){ // timestamp
							if ($zz<=($i*$space+$low) && $zz>=(($i-1)*$space+$low)){
								$auras[2][$low+$i*$space][$qq] = true;
							}
						}
					}
				}
			}
			ksort($time);
			return array(1=>$e, 2=>$time, 3=>$auras);
		}
	}
	
	private function evalGraphValues($q){
		// getting the end value
		$q[1] = explode(",", $q[1]);
		$q[2] = explode(",", $q[2]);
		asort($q[1]);
		$end = 0; $start = null;
		foreach($q[1] as $var){
			if ($var && $var<=100000){
				if ($var>$end)
					$end = $var;
				if ($var<$start || !$start)
					$start = $var;
			}
		}
		
		// test if there are enough values else make more
		$t = array();
		$last = $start;
		foreach ($q[1] as $key => $var){
			if ($var){
				$time = ($var-$last)/10;
				$am = ceil($q[2][$key]/10);
				for ($p=0; $p<=10; $p++){
					$t[$last+$time*$p] += $am;
				}
				$last = $var;
			}
		}
		
		$e = array();
		$num = sizeOf($t);
		$coeff = ceil($num/56);
		$ltime = 0; $lam = 0; $i = 0;
		foreach($t as $key => $var){
			if ($key<=20000 && $coeff>1){
				if ($i == $coeff){
					$e[$ltime] = $lam;
					$ltime = 0; $lam = 0; $i = 0;
				}else{
					if ($ltime == 0)
						$ltime = $key;
					else
						$ltime = ($ltime+$key)/2;
					if ($var<=2000000)
						$lam += $var;
					$i++;
				}
			}
			if ($coeff<=1){
				$e[$key] = $var;
			}
		}
		
		// allign them to same space
		$space = (($end-$start)/50);
		$c = array();
		foreach($e as $key => $var){
			if ($space>1){
				for($i=0; $i<=50; $i++){
					if ($key<($i*$space+$start) && $key>(($i-1)*$space+$start)){
						if (isset($c[$start+$i*$space]))
							$c[$start+$i*$space] += $var;
						else
							$c[$start+$i*$space] = $var;
					}
				}
			}else{
				$c[$key] = $var;
			}
		}
		return $c;
	}
	
	private function jsToAdd(){
		$t = $this->getGraphValues();
		if (($this->player or $this->tarid or ((!$this->player && !$this->tarid) && ($this->mode==1 or $this->mode==2))) && ($this->mode!=3 or $this->player)){
			$content = "
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawChart);
				function drawChart() {
			";
			if (($this->mode==0 && !$this->tarid && !$this->player) or (($this->tarid && !$this->player) && $this->mode != 2) or ($this->mode<2 && !$this->tarid && $this->player)){
				$content .= "
					var data = new google.visualization.DataTable();
					data.addColumn('string', 'Time');
				";
				foreach($t[1] as $key => $var){
					$content .= "
					data.addColumn('number', '".($rr = (isset($this->npcsById[$key])) ? str_replace("'", "\'", $this->npcsById[$key]->name) : ($r = ($this->participants[4][$key]) ? $this->participants[4][$key]->name : "Unknown"))."');
					data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});";
				}
				$content .= "
					data.addRows([
				";
				foreach ($t[3] as $key => $var){
					$content .= "
						['".($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00')."'";
					$activeAuras = '<tr><th colspan="2">Beneficial: <\/th><\/tr>';
					foreach($t[4][1][$key] as $k => $v){
						$activeAuras .= '<tr><td colspan="2">'.str_replace("'", "\'", $this->spells[$k]->name).'<\/td><\/tr>';
					}
					$activeAuras2 = '<tr><th colspan="2">Non-Beneficial: <\/th><\/tr>';
					foreach($t[4][2][$key] as $k => $v){
						$activeAuras2 .= '<tr><td colspan="2">'.str_replace("'", "\'", $this->spells[$k]->name).'<\/td><\/tr>';
					}
					foreach($t[1] as $k => $v){
						$bool = false;
						if ($this->mode<2 && !$this->tarid && $this->player)
							$tooltip = '<table class="tooltip"><tr><th colspan="2">'.($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00').'<\/th><\/tr><tr><td>'.($r = ($this->npcsById[$k]) ? str_replace("'", "\'", $this->npcsById[$k]->name) : "Unknown").': <\/td><th>'.($r = ($v[$key]) ? $this->mnReadable($v[$key]) : "0").'<\/th><\/tr><tr><th colspan="2">Abilities: <\/th><\/tr>';
						else
							$tooltip = '<table class="tooltip"><tr><th colspan="2">'.($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00').'<\/th><\/tr><tr><td>'.($r = ($this->participants[4][$k]) ? $this->participants[4][$k]->name : "Unknown").': <\/td><th>'.($r = ($v[$key]) ? $this->mnReadable($v[$key]) : "0").'<\/th><\/tr><tr><th colspan="2">Abilities: <\/th><\/tr>';
						foreach($t[2][$k] as $q => $s){
							if (isset($s[$key]) && $s[$key]>0)
								$tooltip .= '<tr><td>'.($r = ($this->spells[$q]) ? str_replace("'", "\'", $this->spells[$q]->name) : "Unknown").': <\/td><th>'.$this->mnReadable($s[$key]).'<\/th><\/tr>';
						}
						if ($activeAuras != '<tr><th colspan="2">Beneficial: <\/th><\/tr>')
							$tooltip .= $activeAuras;
						if ($activeAuras2 != '<tr><th colspan="2">Non-Beneficial: <\/th><\/tr>')
							$tooltip .= $activeAuras2;
						$tooltip .= '<\/table>';
						foreach($v as $ke => $va){
							if ($ke == $key){
								$content .= ",".($r = ($v[$key]) ? $v[$key] : "0").",'".$tooltip."'";
								$bool = true;
							}
						}
						if (!$bool)
							$content .= ",0, '<span style=\"color:black;\">No data<\/span>'";
					}
					$content .= "],";
				}
				$content .= "
					]);
				";
			}else{
				$content .= "
					var data = new google.visualization.DataTable();
					data.addColumn('string', 'Time');
				";
				foreach($t[1] as $key => $var){
					$content .= "data.addColumn('number', '";
					if ((!$this->player && !$this->tarid) && $this->mode==1)
						$content .= ($r = ($this->npcsById[$key]) ? str_replace("'", "\'", $this->npcsById[$key]->name) : "Unknown")."');";
					else
						$content .= ($r = ($this->spells[$key]) ? str_replace("'", "\'", $this->spells[$key]->name) : "Unknown")."');";
					$content .= "data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});";
				}
				$content .= "
					data.addRows([
				";
				foreach ($t[2] as $key => $var){
					$content .= "['".($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00')."'";
					$activeAuras = '<tr><th colspan="2">Beneficial: <\/th><\/tr>';
					foreach($t[3][1][$key] as $k => $v){
						$activeAuras .= '<tr><td colspan="2">'.str_replace("'", "\'", $this->spells[$k]->name).'<\/td><\/tr>';
					}
					$activeAuras2 = '<tr><th colspan="2">Non-Beneficial: <\/th><\/tr>';
					foreach($t[3][2][$key] as $k => $v){
						$activeAuras2 .= '<tr><td colspan="2">'.str_replace("'", "\'", $this->spells[$k]->name).'<\/td><\/tr>';
					}
					foreach($t[1] as $k => $v){
						$bool = false;
						$tooltip = '<table class="tooltip"><tr><th colspan="2">'.($r = ($key) ? gmdate("H:i:s", $key) : '00:00:00').'<\/th><\/tr><tr><td><\/td><th><\/th><\/tr>';
						foreach($v as $ke => $va){
							if ($ke == $key){
								$tooltip .= '<tr><td>'.str_replace("'", "\'", ($r = ((!$this->player && !$this->tarid) && $this->mode==1) ? $this->npcsById[$k]->name : $this->spells[$k]->name)).': <\/td><th>'.$this->mnReadable($va).'<\/th><\/tr>';
								if ($activeAuras != '<tr><th colspan="2">Beneficial: <\/th><\/tr>')
									$tooltip .= $activeAuras;
								if ($activeAuras2 != '<tr><th colspan="2">Non-Beneficial: <\/th><\/tr>')
									$tooltip .= $activeAuras2;
								$tooltip .= '<\/table>';
								$content .= ",".$va.",'".$tooltip."'";
								$bool = true;
							}
						}
						if (!$bool)
							$content .= ",0,'<span style=\"color:black;\">No data</span>'";
					}
					$content .= "],
					";
				}
				$content .= "
					]);
				";
			}
			$content .= "
					var options = {
					  isStacked: true,
					  chartArea: {top: 25,right: 20,height: '70%', width: '90%'},
					  backgroundColor: {'fill': 'transparent' },
					  hAxis: {textStyle:{color: '#FFF'}},
					  vAxis: {textStyle:{color: '#FFF'},viewWindow: {min:0}},
					  tooltip: {isHtml: true}
					};

					var chart = new google.visualization.SteppedAreaChart(document.getElementById('graph'));

					chart.draw(data, options);
				}
			";
		}else{
			$time = array();
			$dps = array();
			$player = array();
			$playerdata = array();
			$p = 1;
			foreach($t[2] as $k => $v){
				$i = 1;
				if ($p<=40){
					$player[$p] = $k;
					foreach($v as $key => $var){
						if (!$time[$i])
							$time[$i] = $key;
						$dps[$i] += $var;
						$playerdata[$p][$i] = $var;
						$i++;
					}
					$p++;
				}
			}
			$content .= "
			  google.charts.load('current', {'packages':['corechart']});
			  google.charts.setOnLoadCallback(drawChart);
			
			  function drawChart() {
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Time');
			";
			if ($this->player){
				$content .= "
					data.addColumn('number', 'Damage done');
					data.addColumn({type:'string', role:'annotation'});
				";
			}else{
				$content .= "
					data.addColumn('number', 'Total');
					data.addColumn({type:'string', role:'annotation'});
				";
				foreach($player as $k => $v){
					$content .= "data.addColumn('number', '".$this->participants[4][$v]->name."');
					";
				}
			}
			$content .= "
				data.addRows([
			";
			foreach($time as $k => $v){
				$content .="['".gmdate('H:i:s', $v)."',  ".($r = (isset($dps[$k])) ? $dps[$k] : 0).", ".($r = (isset($this->eventPoints[$v]) and $this->events == 0) ? "'".$this->eventPoints[$v]."'" : "null");
				if (!$this->player){
					for($i=1; $i<$p; $i++){
						if (isset($playerdata[$i][$k]))
							$content .= ",".$playerdata[$i][$k];
						else
							$content .= ",0";
					}
				}
				$content .="],
				";
			}
			$content .= "
				]);

				var options = {
				  curveType: 'function',
				  legend: { position: 'bottom', 'textStyle': { 'color': 'white' }  },
				  chartArea: {top: 25,right: 20,height: '70%', width: '90%'},
				  backgroundColor: {'fill': 'transparent' },
				  hAxis: {textStyle:{color: '#FFF'}},
				  vAxis: {textStyle:{color: '#FFF'},viewWindow: {min:0}},
				  series: {
					0: { color: '#f1ca3a' },
					1: { color: '#e2431e' },
					2: { color: '#e7711b' },
					3: { color: '#6f9654' },
				  }
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
				
				google.visualization.events.addListener(chart, 'select', function () {
					var sel = chart.getSelection();
					// if selection length is 0, we deselected an element
					if (sel.length > 0) {
						// if row is undefined, we clicked on the legend
						if (sel[0].row === null) {
							var col = sel[0].column;
							if (columns[col] == col) {
								// hide the data series
								columns[col] = {
									label: data.getColumnLabel(col),
									type: data.getColumnType(col),
									calc: function () {
										return null;
									}
								};
								
								// grey out the legend entry
								series[col - 1].color = '#CCCCCC';
							}
							else {
								// show the data series
								columns[col] = col;
								series[col - 1].color = null;
							}
							var view = new google.visualization.DataView(data);
							view.setColumns(columns);
							chart.draw(view, options);
						}
					}
				});
			  }
			";
		}
		return $content;
	}
	
	private function getPet(){
		$q = $this->db->query('SELECT id FROM chars WHERE ownerid = "'.$this->player.'"')->fetch()->id;
		if ($q)
			return ',"'.$q.'"';
		return '';
	}
	
	private function goToHundred($a){
		if (is_nan($a))
			return 0;
		if ($a>100)
			return 100;
		return $a;
	}
	
	public function content(){
		$content = $this->getSame(4);
		$this->addJs($this->jsToAdd());
		$table = $this->getTable();
		$content .= '
			<div class="centredNormal newmargin">
			<div class="hackleft'.($r = ($this->mode==2) ? ' long' : '').'">
			<section class="ttitle semibig'.($r = ($this->mode != 2) ? ' short' : '').'">Damage done '.$this->modes[$this->mode].'</section>
			<section class="table tees'.($r = ($this->mode != 2) ? ' short' : '').'">
		';
		if ($this->mode == 2){
			$content .= '
				<table cellspacing="0">
					<thead>
						<tr>
							<th class="count">#</th>
							<th class="a-char">Name</th>
							<th class="a-amount">Amount</th>
							<th class="cbt">DPS</th>
							<th class="average">Average</th>
							<th class="hits">Casts</th>
							<th class="hits">Hits</th>
							<th class="perc">Crit</th>
							<th class="perc">Miss</th>
							<th class="perc">Parry</th>
							<th class="perc">Dodge</th>
							<th class="perc">Resist</th>
							<th class="fill">&nbsp;</th>
						</tr>
					</thead>
					<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
		$count=1;
		foreach ($table[2] as $key => $var){
			$content .= '
						<tr>
							<td class="count">'.$count.'</td>
							<td class="a-char"><img src="{path}Database/icons/small/'.$table[5][$key][2].'.jpg" /><a target="_blank" rel="spell='.$key.'" href="https://wotlk-twinhead.twinstar.cz/?spell='.$this->spells[$key]->id.'">'.($r = ($table[5][$key][1]) ? $table[5][$key][1] : "Unknown").'</a></td>
							<td class="a-amount">
								<div>'.round(100*$var/$table[1], 2).'%</div>
								<div class="amount-sbar"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$key]->classid].'" style="width: '.(100*$var/$table[4]).'%;"></div></div>
								<div>'.$this->mnReadable($var).'</div>
							</td>
							<td class="cbt">'.$this->mReadable($var/$this->atmpts[1], 2).'</td>
							<td class="average">'.$this->mReadable($var/$table[13][$key], 2).'</td>
							<td class="hits">'.$this->mnReadable($table[12][$key]).'</td>
							<td class="hits">'.$this->mnReadable($table[13][$key]).'</td>
							<td class="perc">'.round(100*$table[7][$key], 2).'%</td>
							<td class="perc">'.round(100*$table[8][$key], 2).'%</td>
							<td class="perc">'.round(100*$table[9][$key], 2).'%</td>
							<td class="perc">'.round(100*$table[10][$key], 2).'%</td>
							<td class="perc">'.round(100*$table[11][$key], 2).'%</td>
						</tr>
			';
			$count++;
		}
		$content .= '
					</tbody>
					<tfoot>
						<tr>
							<th class="a-char">Total</th>
							<th class="a-amount"><div>100%</div><div class="amount-sbar"></div><div>'.$this->mnReadable($table[1]).'</div></th>
							<th class="cbt">'.$this->mReadable($table[1]/$this->atmpts[1], 2).'</th>
							<th class="average">&nbsp;</th>
							<th class="hits">'.$this->mnReadable($table[14]).'</th>
							<th class="hits">'.$this->mnReadable($table[15]).'</th>
							<th class="perc">&nbsp;</th>
							<th class="perc">&nbsp;</th>
							<th class="perc">&nbsp;</th>
							<th class="perc">&nbsp;</th>
							<th class="perc">&nbsp;</th>
							<th class="fill">&nbsp;</th>
						</tr>
					</tfoot>
				</table>
			';
		}else{
			$content .= '
				<table cellspacing="0">
					<thead>
						<tr>
							<th class="count">#</th>
							<th class="char">Name</th>
							<th class="amount">Amount</th>
							<th class="active">'.($r = ($this->mode!=3) ? "Active" : "&nbsp;").'</th>
							<th class="cbt">DPS</th>
							<th class="fill">&nbsp;</th>
						</tr>
					</thead>
					<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
		';
		$count=1;
		foreach ($table[2] as $k => $v){
			$content .= '
							<tr>
								<td class="count">'.$count.'</td>
								'.($rr = ($this->mode==1) ? '<td class="char"><img src="{path}Database/type/'.$this->npcsById[$k]->family.'.png" /><a class="color-" href="{path}WOTLK/Raids/Evaluation/DmgDone/?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$this->player.'&sel='.$table[6][$k].'&pet='.$this->pet.'&tarid='.$k.'&mode=2">'.($r = ($table[5][$k]) ? $table[5][$k] : "Unknown").'</a></td>' : '<td class="char"><img src="{path}Database/classes/c'.$this->participants[4][$k]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$k]->classid].'" href="{path}WOTLK/Raids/Evaluation/DmgDone/index.php?rid='.$this->rid.'&attempts='.$this->attempts.'&player='.$k.'&sel='.$this->sel.'&pet='.$this->pet.'&tarid='.$this->tarid.'&mode=1">'.$this->participants[4][$k]->name.'</a></td>').'
								<td class="amount">
									<div>'.round(100*$v/$table[1], 2).'%</div>
									<div class="amount-sbar"><div class="amount-sbar-progress bgcolor-'.$this->classById[$this->participants[4][$k]->classid].'" style="width: '.(100*$v/$table[4]).'%;"></div></div>
									<div>'.$this->mnReadable($v).'</div>
								</td>
								<td class="active">'.($r = ($this->mode!=3) ? $this->goToHundred(round(100*$table[3][$k]/($this->atmpts[1]*$table[7][$k]), 2))."%" : "&nbsp;").'</td>
								<td class="cbt">'.$this->mReadable($v/$this->atmpts[1], 2).'</td>
							</tr>
			';
			$count++;
		}
		$content .= '
						</tbody>
						<tfoot>
							<tr>
								<th class="char">Total</th>
								<th class="amount"><div>100%</div><div class="amount-sbar"></div><div>'.$this->mnReadable($table[1]).'</div></th>
								<th class="active">&nbsp;</th>
								<th class="cbt">'.$this->mReadable($table[1]/$this->atmpts[1], 2).'</th>
							<th class="fill">&nbsp;</th>
							</tr>
						</tfoot>
				</table>
			';
		}
		$content .= '
			</section>
			</div>
		';
		if ($this->mode != 2){
			$content .= '
			<div class="hackright">
				<section class="table records">
					<table cellspacing="0">
						<thead>
							<tr title="Realm rank | Realm-Class rank | Realm-Type rank | Name | Bossname 
Realm rank: The rank you achieved among the realm. 
Realm-Class rank: The rank you achieved on your realm among your class. 
Realm-Type rank: The rank you achieved among the caster or meele on your realm.">
								<th colspan="5">Records*</th>
							</tr>
						</thead>
						<tbody'.($r = ($this->compact==1) ? ' style="max-height: 90000px !important; overflow: hidden;"' : '').'>
			';
			foreach ($table[10] as $var){
				$content .= '
							<tr>
								<td class="num">'.$var->realm.'</td>
								<td class="num">'.$var->realmclass.'</td>
								<td class="num">'.$var->realmtype.'</td>
								<td class="lstring"><img src="{path}Database/classes/c'.$this->participants[4][$var->charid]->classid.'.png" /><a class="color-'.$this->classById[$this->participants[4][$var->charid]->classid].'" href="{path}WOTLK/Character/'.$raidinfo->sname.'/'.$this->participants[4][$var->charid]->name.'/0">'.$this->participants[4][$var->charid]->name.'</a></td>
								<td class="lstring"><a href="{path}WOTLK/Rankings/Table/?server=0&faction=0&type=-1&tarid='.$this->tarid.'&mode=0&id='.$this->getRankingsLink($var->npcid).'">'.$this->npcsById[$var->npcid]->name.'</a></td>
							</tr>
				';
			}
			$content .= '
						</tbody>
					</table>
				</section>
			</div>
			';
		}
		$content .= '
			</div>
			</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid){
		$this->addJsLink("https://www.gstatic.com/charts/loader.js", true);
		parent::__construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid);
	}
}

new Home($db, __DIR__, $_GET["rid"], $_GET["attempts"], $_GET["player"], $_GET["sel"], $_GET["mode"], $_GET["pet"], $_GET["events"], $_GET["tarid"]);

?>