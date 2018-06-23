<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $classById = array(
		1 => "Warrior",
		2 => "Rogue",
		3 => "Priest",
		4 => "Hunter",
		5 => "Druid",
		6 => "Mage",
		7 => "Warlock",
		8 => "Paladin",
		9 => "Shaman"
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
	private $professions = array(
		0 => "inv_misc_questionmark",
		202 => "trade_engineering",
		164 => "trade_blacksmithing",
		171 => "trade_alchemy",
		333 => "trade_engraving",
		182 => "trade_herbalism",
		755 => "inv_misc_gem_02",
		165 => "inv_misc_armorkit_17",
		186 => "trade_mining",
		393 => "inv_misc_pelt_wolf_01",
		197 => "trade_tailoring"
	);
	private $classSpecs = array(
		0 => array(0=>"Unknown"),
		1 => array(
			0 => "Unknown",
			1 => "Arms",
			2 => "Fury",
			3 => "Protection"
		),
		2 => array(
			0 => "Unknown",
			1 => "Assasination",
			2 => "Combat",
			3 => "Subtlety"
		),
		3 => array(
			0 => "Unknown",
			1 => "Discipline",
			2 => "Holy",
			3 => "Shadow"
		),
		4 => array(
			0 => "Unknown",
			1 => "Beast Mastery",
			2 => "Marksmanship",
			3 => "Survival"
		),
		5 => array(
			0 => "Unknown",
			1 => "Balance",
			2 => "Feral",
			3 => "Restoration"
		),
		6 => array(
			0 => "Unknown",
			1 => "Arcane",
			2 => "Fire",
			3 => "Frost"
		),
		7 => array(
			0 => "Unknown",
			1 => "Affliction",
			2 => "Demonology",
			3 => "Destruction"
		),
		8 => array(
			0 => "Unknown",
			1 => "Holy",
			2 => "Protection",
			3 => "Retribution"
		),
		9 => array(
			0 => "Unknown",
			1 => "Elemental",
			2 => "Enhancement",
			3 => "Restoration"
		),
	);
	private $classSpecsIcons = array(
		0 => array(0=>"inv_misc_questionmark"),
		1 => array(
			0 => "inv_misc_questionmark",
			1 => "ability_warrior_savageblow",
			2 => "ability_warrior_innerrage",
			3 => "inv_shield_06"
		),
		2 => array(
			0 => "inv_misc_questionmark",
			1 => "RogueAssassination",
			2 => "ability_marksmanship",
			3 => "ability_stealth"
		),
		3 => array(
			0 => "inv_misc_questionmark",
			1 => "spell_holy_powerwordshield",
			2 => "spell_holy_renew",
			3 => "spell_shadow_shadowwordpain"
		),
		4 => array(
			0 => "inv_misc_questionmark",
			1 => "ability_druid_ferociousbite",
			2 => "inv_spear_07",
			3 => "inv_spear_02"
		),
		5 => array(
			0 => "inv_misc_questionmark",
			1 => "spell_nature_starfall",
			2 => "ability_racial_bearform",
			3 => "spell_nature_magicimmunity"
		),
		6 => array(
			0 => "inv_misc_questionmark",
			1 => "spell_holy_magicalsentry",
			2 => "spell_fire_firebolt02",
			3 => "spell_frost_frostbolt02"
		),
		7 => array(
			0 => "inv_misc_questionmark",
			1 => "spell_shadow_deathcoil",
			2 => "spell_shadow_metamorphosis",
			3 => "spell_shadow_rainoffire"
		),
		8 => array(
			0 => "inv_misc_questionmark",
			1 => "spell_holy_holybolt",
			2 => "inv_shield_06",
			3 => "spell_holy_auraoflight"
		),
		9 => array(
			0 => "inv_misc_questionmark",
			1 => "spell_nature_lightning",
			2 => "spell_nature_lightningshield",
			3 => "spell_nature_magicimmunity"
		),
	);
	private $classid = 1;
	private $raceid = 1;
	private $genderid = 3;
	private $talentid = 0;
	private $itemTemplate = array();
	private $enchTemplate = array();
	private $itemSet = array();
	private $statValues = array();
	private $enchants = "";
	private $powerbartype = "mana";
	private $itemSets = array();
	private $items = array();
	private $enchantids = array();
	
	private function getItemTemplate($db){
		foreach($db->query('SELECT a.itemset, a.entry, a.name, a.quality, a.icon, a.armor, a.holy_res, a.fire_res, a.nature_res, a.frost_res, a.shadow_res, a.arcane_res, a.hit, a.crit, a.apower, a.dodge, a.parry, a.block, a.spellpower, a.healpower, a.spellholy, a.spellfire, a.spellfrost, a.spellnature, a.spellshadow, a.spellarcane, a.manaregen, a.defense, a.spellhit, a.spellcrit, a.rangedapower, a.blockchance, a.strength, a.agility, a.spirit, a.intellect, a.stamina, b.* FROM item_template a LEFT JOIN `v-itemsets` b ON a.itemset = b.id WHERE a.entry IN ('.implode(",",$this->items).')') as $row){
			$this->itemTemplate[$row->entry] = $row;
			$this->itemSets[$row->itemset] = $row;
		}
	}
	
	private function getEnchantmentTemplate($db){
		foreach($db->query('SELECT * FROM `armory-enchantmentstats` WHERE enchid IN ('.implode(",", $this->enchantids).')') as $row){
			$this->enchTemplate[$row->enchid] = $row;
		}
	}
	
	private function getGuildRank(){
		return "";
	}
	
	private function getNameString(){
		return "";
	}
	
	private function levelCoeff(){
		return 1;
	}
	
	private function getStatValues(){
		for ($i=1; $i<60; $i++){
			$this->statValues[$i] = 0;
		} 
		//enchantment stats
		for ($i=1; $i<20; $i++){
			if ($i==19){
				$this->statValues[53] += $this->enchTemplate[$this->enchantids[$i]]->hit;
			}else{
				if (isset($this->enchantids[$i])){
					$this->statValues[0] += $this->enchTemplate[$this->enchantids[$i]]->manaregen;
					$this->statValues[3] += $this->enchTemplate[$this->enchantids[$i]]->agility;
					$this->statValues[4] += $this->enchTemplate[$this->enchantids[$i]]->strength;
					$this->statValues[5] += $this->enchTemplate[$this->enchantids[$i]]->intellect;
					$this->statValues[6] += $this->enchTemplate[$this->enchantids[$i]]->spirit;
					$this->statValues[7] += $this->enchTemplate[$this->enchantids[$i]]->stamina;
					$this->statValues[12] += $this->enchTemplate[$this->enchantids[$i]]->defense;
					$this->statValues[13] += $this->enchTemplate[$this->enchantids[$i]]->dodge;
					$this->statValues[15] += $this->enchTemplate[$this->enchantids[$i]]->block;
					$this->statValues[26] += $this->enchTemplate[$this->enchantids[$i]]->blockchance;
					$this->statValues[16] += $this->enchTemplate[$this->enchantids[$i]]->hit;
					$this->statValues[18] += $this->enchTemplate[$this->enchantids[$i]]->spellhit;
					$this->statValues[19] += $this->enchTemplate[$this->enchantids[$i]]->crit;
					$this->statValues[21] += $this->enchTemplate[$this->enchantids[$i]]->spellcrit;
					$this->statValues[22] += $this->enchTemplate[$this->enchantids[$i]]->spellpower;
					$this->statValues[23] += $this->enchTemplate[$this->enchantids[$i]]->healpower;
					$this->statValues[24] += $this->enchTemplate[$this->enchantids[$i]]->apower;
					$this->statValues[25] += $this->enchTemplate[$this->enchantids[$i]]->rangedapower;
					$this->statValues[38] += $this->enchTemplate[$this->enchantids[$i]]->armor;
					$this->statValues[39] += $this->enchTemplate[$this->enchantids[$i]]->res_holy;
					$this->statValues[40] += $this->enchTemplate[$this->enchantids[$i]]->res_fire;
					$this->statValues[41] += $this->enchTemplate[$this->enchantids[$i]]->res_nature;
					$this->statValues[42] += $this->enchTemplate[$this->enchantids[$i]]->res_frost;
					$this->statValues[43] += $this->enchTemplate[$this->enchantids[$i]]->res_shadow;
					$this->statValues[44] += $this->enchTemplate[$this->enchantids[$i]]->res_arcane;
					$this->statValues[45] += $this->enchTemplate[$this->enchantids[$i]]->health;
					$this->statValues[46] += $this->enchTemplate[$this->enchantids[$i]]->mana;
					$this->statValues[47] += $this->enchTemplate[$this->enchantids[$i]]->spellholy;
					$this->statValues[48] += $this->enchTemplate[$this->enchantids[$i]]->spellfrost;
					$this->statValues[49] += $this->enchTemplate[$this->enchantids[$i]]->spellnature;
					$this->statValues[50] += $this->enchTemplate[$this->enchantids[$i]]->spellfire;
					$this->statValues[51] += $this->enchTemplate[$this->enchantids[$i]]->spellarcane;
					$this->statValues[52] += $this->enchTemplate[$this->enchantids[$i]]->spellshadow;
				}
			}
			$this->enchants .= '
				savedEnchants['.$this->items[$i].'] = "'.$this->enchTemplate[$this->enchantids[$i]]->name.'"';
		}
		// item stats
		for ($i=1; $i<20; $i++){
			$this->statValues[0] += $this->itemTemplate[$this->items[$i]]->manaregen;
			$this->statValues[3] += $this->itemTemplate[$this->items[$i]]->agility;
			$this->statValues[4] += $this->itemTemplate[$this->items[$i]]->strength;
			$this->statValues[5] += $this->itemTemplate[$this->items[$i]]->intellect;
			$this->statValues[6] += $this->itemTemplate[$this->items[$i]]->spirit;
			$this->statValues[7] += $this->itemTemplate[$this->items[$i]]->stamina;
			$this->statValues[12] += $this->itemTemplate[$this->items[$i]]->defense;
			$this->statValues[13] += $this->itemTemplate[$this->items[$i]]->dodge;
			$this->statValues[14] += $this->itemTemplate[$this->items[$i]]->parry;
			$this->statValues[15] += $this->itemTemplate[$this->items[$i]]->block;
			$this->statValues[26] += $this->itemTemplate[$this->items[$i]]->blockchance;
			$this->statValues[16] += $this->itemTemplate[$this->items[$i]]->hit;
			$this->statValues[18] += $this->itemTemplate[$this->items[$i]]->spellhit;
			$this->statValues[19] += $this->itemTemplate[$this->items[$i]]->crit;
			$this->statValues[21] += $this->itemTemplate[$this->items[$i]]->spellcrit;
			$this->statValues[22] += $this->itemTemplate[$this->items[$i]]->spellpower;
			$this->statValues[23] += $this->itemTemplate[$this->items[$i]]->healpower;
			$this->statValues[24] += $this->itemTemplate[$this->items[$i]]->apower;
			$this->statValues[25] += $this->itemTemplate[$this->items[$i]]->rangedapower;
			$this->statValues[38] += $this->itemTemplate[$this->items[$i]]->armor;
			$this->statValues[39] += $this->itemTemplate[$this->items[$i]]->holy_res;
			$this->statValues[40] += $this->itemTemplate[$this->items[$i]]->fire_res;
			$this->statValues[41] += $this->itemTemplate[$this->items[$i]]->nature_res;
			$this->statValues[42] += $this->itemTemplate[$this->items[$i]]->frost_res;
			$this->statValues[43] += $this->itemTemplate[$this->items[$i]]->shadow_res;
			$this->statValues[44] += $this->itemTemplate[$this->items[$i]]->arcane_res;
			$this->statValues[47] += $this->itemTemplate[$this->items[$i]]->spellholy;
			$this->statValues[48] += $this->itemTemplate[$this->items[$i]]->spellfrost;
			$this->statValues[49] += $this->itemTemplate[$this->items[$i]]->spellnature;
			$this->statValues[50] += $this->itemTemplate[$this->items[$i]]->spellfire;
			$this->statValues[51] += $this->itemTemplate[$this->items[$i]]->spellarcane;
			$this->statValues[52] += $this->itemTemplate[$this->items[$i]]->spellshadow;
		}
		
		$this->statValues[12] += 300;
		$this->statValues[19] += 5;
		if ($this->raceid==3)
			$this->statValues[13] += 1;
		switch($this->classid){
			case 1 :
				// Taking Human warrior stats
				$this->powerbartype = "rage";
				$this->statValues[26] += 5*$this->levelCoeff();
				$this->statValues[14] += 5*$this->levelCoeff();
				$this->statValues[3] += 80*$this->levelCoeff();
				$this->statValues[4] += 120*$this->levelCoeff();
				$this->statValues[5] += 30*$this->levelCoeff();
				$this->statValues[6] += 43*$this->levelCoeff();
				$this->statValues[7] += 110*$this->levelCoeff();
				$this->statValues[24] += 160*$this->levelCoeff();
				$this->statValues[45] = 1509*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.05;
				$this->statValues[38] += ceil($this->statValues[3]*(2.4-0.001564*$this->statValues[3]))+104;
				$this->statValues[13] += round($this->statValues[3]*0.05, 2);
				
				if ($this->talentid != 3)
					$this->statValues[19] += 5;
				if ($this->talentid == 3){
					$this->statValues[12] += 10;
					$this->statValues[38] = ceil($this->statValues[38]*1.1); // 10% more armor?
				}
				
				$defense = $this->statValues[12]-300; // Gotta add this for vanilla
				$this->statValues[13] += $defense*0.02;
				$this->statValues[14] += $defense*0.02;
				$this->statValues[26] += $defense*0.02;
				$this->statValues[15] += $this->statValues[4]/2;
				
				if ($this->raceid==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05);
				if ($this->raceid==1){
					$this->statValues[19] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				if ($this->raceid==5)
					$this->statValues[19] += 0.2;
				if ($this->race==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] = 100;
				break;
			case 2 :
				// Taking human rogue stats
				$this->powerbartype = "energy";
				$this->statValues[14] += 5*$this->levelCoeff();
				$this->statValues[13] += 5*$this->levelCoeff();
				$this->statValues[3] += 130*$this->levelCoeff();
				$this->statValues[4] += 80*$this->levelCoeff();
				$this->statValues[5] += 35*$this->levelCoeff();
				$this->statValues[6] += 51*$this->levelCoeff();
				$this->statValues[7] += 75*$this->levelCoeff();
				$this->statValues[24] += 85*$this->levelCoeff();
				if ($this->raceid==1){
					$this->statValues[19] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				if ($this->raceid==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05);
				
				$this->statValues[24] += $this->statValues[3]+$this->statValues[4];
				if ($this->talentid==2){
					$this->statValues[16] += 5;
					$this->statValues[19] += 0.2;
				}
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]))+260;
				$this->statValues[19] += round($this->statValues[3]*0.034875, 2);
				$this->statValues[13] += round($this->statValues[3]*0.06, 2);
				$this->statValues[45] = 1293*$this->levelCoeff();
				$this->statValues[46] = 100;
				break;
			case 3 :
				// Taking human priest stats
				$this->statValues[13] += 3*$this->levelCoeff();
				$this->statValues[3] += 40*$this->levelCoeff();
				$this->statValues[4] += 35*$this->levelCoeff();
				$this->statValues[5] += 120*$this->levelCoeff();
				$this->statValues[6] += 130*$this->levelCoeff();
				$this->statValues[7] += 50*$this->levelCoeff();
				$this->statValues[24] += -15*$this->levelCoeff();
				$this->statValues[45] = 1207*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4];
				$this->statValues[19] += $this->statValues[3]*0.05;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.05, 2);
				$this->statValues[21] += $this->statValues[5]*0.016863406;
				
				$this->statValues[46] += 1004*$this->levelCoeff();
				
				$this->statValues[21] += 5; // Talent
				
				if ($this->talentid==1){
					$this->statValues[46] = ceil($this->statValues[46]*1.1);
					$this->statValues[21] += 5;
				}
				if ($this->talentid==3){
					$this->statValues[21] -= 5;
				}
			
				if ($this->raceid==1){
					$this->statValues[19] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				break;
			case 4 :
				// Taking Night Elf Hunter stats
				$this->statValues[14] += 5*$this->levelCoeff();
				$this->statValues[3] += 130*$this->levelCoeff();
				$this->statValues[4] += 52*$this->levelCoeff();
				$this->statValues[5] += 65*$this->levelCoeff();
				$this->statValues[6] += 70*$this->levelCoeff();
				$this->statValues[7] += 89*$this->levelCoeff();
				$this->statValues[24] += 100*$this->levelCoeff();
				$this->statValues[45] = 1180*$this->levelCoeff();
				
				if ($this->talentid==3){
					$this->statValues[45] = ceil($this->statValues[45]*1.1);
					$this->statValues[19] += 5;
					$this->statValues[3] = ceil($this->statValues[3]*1.15);
				}
				
				$this->statValues[24] += $this->statValues[3]*2; //ranged attack power
				$this->statValues[19] += $this->statValues[3]*0.018867924;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.03733333, 2);
				$this->statValues[21] += $this->statValues[5]*0.01679449;
				
				$this->statValues[19] += 5; // Talent
				
				if ($this->raceid==7)
					$this->statValues[19] += 0.2;
				if ($this->race==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] += 1004*$this->levelCoeff();
				break;
			case 5 :
				// Taking tauren druid stats
				$this->statValues[13] += 1.7;
				$this->statValues[3] += 55*$this->levelCoeff();
				$this->statValues[4] += 70*$this->levelCoeff();
				$this->statValues[5] += 95*$this->levelCoeff();
				$this->statValues[6] += 112*$this->levelCoeff();
				$this->statValues[7] += 72*$this->levelCoeff();
				$this->statValues[24] += 50*$this->levelCoeff();
				$this->statValues[45] = 1337*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.05;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.05, 2);
				
				$this->statValues[21] += $this->statValues[5]*0.166666666;
				
				if ($this->talentid==2)
					$this->statValues[5] = ceil($this->statValues[5]*1.2);
				
				if ($this->race==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] += 964*$this->levelCoeff();
				$this->statValues[14] = 0;
				break;
			case 6 :
				// Taking gnome mage stats
				$this->statValues[3] += 38*$this->levelCoeff();
				$this->statValues[4] += 25*$this->levelCoeff();
				$this->statValues[5] += 132*$this->levelCoeff();
				$this->statValues[6] += 120*$this->levelCoeff();
				$this->statValues[7] += 44*$this->levelCoeff();
				$this->statValues[24] += -10*$this->levelCoeff();
				$this->statValues[45] = 1180*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4];
				$this->statValues[19] += $this->statValues[3]*0.05;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.09, 2);
				$this->statValues[21] += $this->statValues[5]*0.01679449;
				
				$this->statValues[18] += 6; // Talent
				$this->statValues[46] += 1008*$this->levelCoeff();
				
				if ($this->talentid==1)
					$this->statValues[21] += 6;
				if ($this->talentid==2){
					$this->statValues[21] += 6;
				}
				if ($this->talentid==3)
					$this->statValues[18] += 4;
			
				if ($this->raceid==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05);
				if ($this->raceid==1){
					$this->statValues[19] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				$this->statValues[14] = 0;
				break;
			case 7 :
				// Taking human warlock stats
				$this->statValues[3] += 50*$this->levelCoeff();
				$this->statValues[4] += 45*$this->levelCoeff();
				$this->statValues[5] += 110*$this->levelCoeff();
				$this->statValues[6] += 108*$this->levelCoeff();
				$this->statValues[7] += 65*$this->levelCoeff();
				$this->statValues[24] += -10*$this->levelCoeff();
				$this->statValues[45] = 1204*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4];
				$this->statValues[19] += $this->statValues[3]*0.05;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.09, 2);
				$this->statValues[21] += $this->statValues[5]*0.01679449;
				
				if ($this->talentid==2){
					$this->statValues[7] = ceil($this->statValues[7]*1.15);
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				if ($this->talentid==3)
					$this->statValues[21] += 5;
				
				if ($this->raceid==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05); // Gnome intellect bonus
				if ($this->raceid==1){
					$this->statValues[19] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				$this->statValues[46] += 1093*$this->levelCoeff();
				$this->statValues[14] = 0;
				break;
			case 8 :
				// Taking dwarf paladin stats
				$this->statValues[21] += 2.7;
				$this->statValues[15] += 5*$this->levelCoeff();
				$this->statValues[3] += 61*$this->levelCoeff();
				$this->statValues[4] += 107*$this->levelCoeff();
				$this->statValues[5] += 75*$this->levelCoeff();
				$this->statValues[6] += 43*$this->levelCoeff();
				$this->statValues[7] += 103*$this->levelCoeff();
				$this->statValues[24] += 160*$this->levelCoeff();
				$this->statValues[45] = 1101*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.05;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.05, 2);
				$this->statValues[21] += $this->statValues[5]*0.01679449;
				
				if ($this->talentid==1){
					$this->statValues[21] += 5;
					$this->statValues[5] = ceil($this->statValues[5]*1.1);
				}
				if ($this->talentid!=1)
					$this->statValues[4] = ceil($this->statValues[4]*1.1);
				if ($this->talentid==3)
					$this->statValues[19] += 5;
				if ($this->talentid==2){
					$this->statValues[12] += 10;
					$this->statValues[38] = ceil($this->statValues[38]*1.1); // 10% more armor?
				}	
				
				$this->statValues[15] += $this->statValues[4]/2;
				
				if ($this->raceid==1){
					$this->statValues[19] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				$this->statValues[46] += 1232*$this->levelCoeff();
				break;
			case 9 :
				// Taking Troll shamen stats
				$this->statValues[15] += 5*$this->levelCoeff();
				$this->statValues[3] += 52*$this->levelCoeff();
				$this->statValues[4] += 88*$this->levelCoeff();
				$this->statValues[5] += 87*$this->levelCoeff();
				$this->statValues[6] += 103*$this->levelCoeff();
				$this->statValues[7] += 97*$this->levelCoeff();
				$this->statValues[24] += 100*$this->levelCoeff();
				$this->statValues[45] = 1100*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.05;
				$this->statValues[21] += $this->statValues[5]*0.01669449;
				$this->statValues[38] += ceil($this->statValues[3]*2);
				$this->statValues[13] += round($this->statValues[3]*0.05, 2);
				
				if ($this->talentid==1)
					$this->statValues[21] += 6;
				if ($this->talentid==2){
					$this->statValues[19] += 5;
					$this->statValues[14] += 5;
				}
				if ($this->talentid!=3){
					$this->statValues[16] += 3;
					$this->statValues[18] += 3;
				}
				if ($this->talentid!=2)
					$this->statValues[14] = 0;	
				
				if ($this->raceid==5)
					$this->statValues[19] += 0.2;
				if ($this->raceid==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] = 1240*$this->levelCoeff();
				if ($this->talentid==3){
					$this->statValues[46] += ceil($this->statValues[46]*1.05);
					$this->statValues[21] += 5;
				}
				
				$this->statValues[15] += $this->statValues[4]/2;
				break;
		}
		$this->statValues[45] += $this->statValues[7]*10;
		if ($this->classid!=2 && $this->classid!=1)
			$this->statValues[46] += $this->statValues[5]*15;
		if (($this->userData->talent==2 or $this->userData->talent==1) && $this->classid==6)
			$this->statValues[46] = ceil($this->statValues[46]*1.1);
		if ($this->raceid==8 or $this->raceid==3)
			$this->statValues[41] += 10;
		if ($this->raceid==2)
			$this->statValues[42] += 10;
		if ($this->raceid==6)
			$this->statValues[43] += 10;
	}
	
	public function content(){
		$content = '
		<style type="text/css">
			#dummy';
		$existingItems = array();
		for ($i=1; $i<=19;$i++){
			if (isset($this->itemTemplate[$this->items[$i]]->entry)){
				$content .= ',#item'.$this->itemTemplate[$this->items[$i]]->entry;
				$existingItems[$this->itemTemplate[$this->items[$i]]->entry] = true;
			}
		}
		$content .= '{color:#1eff00!important;}
			.set0';
		$existSet = array();
		for ($i=1; $i<=19;$i++){
			if (intval($this->itemTemplate[$this->items[$i]]->itemset)>0){
				if (!isset($existSet[$this->itemTemplate[$this->items[$i]]->itemset])){
					$count = 0;
					$setids = explode(",", $this->itemTemplate[$this->items[$i]]->setids);
					foreach($setids as $var){
						if (isset($existingItems[$var]))
							$count++;
					}
					$content .= ', .set'.$this->itemTemplate[$this->items[$i]]->itemset.$count;
					$existSet[$this->itemTemplate[$this->items[$i]]->itemset] = $count;
				}
			}
		}
		$content .= '{color:#1eff00!important;}';
		
		// Hacky adding stats of enchantment setbonuses
		foreach($existSet as $k => $v){
			$effectnames = explode(",",$this->itemSets[$k]->seteffectnames);
			$effectids = explode(",",$this->itemSets[$k]->seteffectids);
			foreach($effectnames as $key => $var){
				$num = intval(substr($var,1,1));
				if ($num>=$v){
					$this->statValues[0] += $this->enchTemplate[$effectids[$key]]->manaregen;
					$this->statValues[3] += $this->enchTemplate[$effectids[$key]]->agility;
					$this->statValues[4] += $this->enchTemplate[$effectids[$key]]->strength;
					$this->statValues[5] += $this->enchTemplate[$effectids[$key]]->intellect;
					$this->statValues[6] += $this->enchTemplate[$effectids[$key]]->spirit;
					$this->statValues[7] += $this->enchTemplate[$effectids[$key]]->stamina;
					$this->statValues[12] += $this->enchTemplate[$effectids[$key]]->defense;
					$this->statValues[13] += $this->enchTemplate[$effectids[$key]]->dodge;
					$this->statValues[15] += $this->enchTemplate[$effectids[$key]]->block;
					$this->statValues[26] += $this->enchTemplate[$effectids[$key]]->blockchance;
					$this->statValues[16] += $this->enchTemplate[$effectids[$key]]->hit;
					$this->statValues[18] += $this->enchTemplate[$effectids[$key]]->spellhit;
					$this->statValues[19] += $this->enchTemplate[$effectids[$key]]->crit;
					$this->statValues[21] += $this->enchTemplate[$effectids[$key]]->spellcrit;
					$this->statValues[22] += $this->enchTemplate[$effectids[$key]]->spellpower;
					$this->statValues[23] += $this->enchTemplate[$effectids[$key]]->healpower;
					$this->statValues[24] += $this->enchTemplate[$effectids[$key]]->apower;
					$this->statValues[25] += $this->enchTemplate[$effectids[$key]]->rangedapower;
					$this->statValues[38] += $this->enchTemplate[$effectids[$key]]->armor;
					$this->statValues[39] += $this->enchTemplate[$effectids[$key]]->res_holy;
					$this->statValues[40] += $this->enchTemplate[$effectids[$key]]->res_fire;
					$this->statValues[41] += $this->enchTemplate[$effectids[$key]]->res_nature;
					$this->statValues[42] += $this->enchTemplate[$effectids[$key]]->res_frost;
					$this->statValues[43] += $this->enchTemplate[$effectids[$key]]->res_shadow;
					$this->statValues[44] += $this->enchTemplate[$effectids[$key]]->res_arcane;
					$this->statValues[45] += $this->enchTemplate[$effectids[$key]]->health+$this->enchTemplate[$effectids[$key]]->stamina*10;
					$this->statValues[46] += $this->enchTemplate[$effectids[$key]]->mana+$this->enchTemplate[$effectids[$key]]->intellect*15;
					$this->statValues[47] += $this->enchTemplate[$effectids[$key]]->spellholy;
					$this->statValues[48] += $this->enchTemplate[$effectids[$key]]->spellfrost;
					$this->statValues[49] += $this->enchTemplate[$effectids[$key]]->spellnature;
					$this->statValues[50] += $this->enchTemplate[$effectids[$key]]->spellfire;
					$this->statValues[51] += $this->enchTemplate[$effectids[$key]]->spellarcane;
					$this->statValues[52] += $this->enchTemplate[$effectids[$key]]->spellshadow;
				}
			}
		}
		$content .= '
		</style>
		<script>
			var savedEnchants = new Array();
			'.$this->enchants.'
		</script>
		<div class="container cont" id="container">
			<form action="generateLink.php" method="post">
			<section class="centredNormal" style="overflow: hidden;">
				<section class="sleft">
					<div class="desRow">
						<div>Head</div>
						<input type="text" name="inv1" placeholder="Enter itemid" value="'.($r = ($this->items[1]) ? $this->items[1] : "").'" />
						<select name="ench1">
							<option value="0"'.($r = ($this->enchantids[1]==0) ? "selected" : "").'>None</option>
							<option value="1483"'.($r = ($this->enchantids[1]==1483) ? "selected" : "").'>Mana +150</option>
							<option value="1503"'.($r = ($this->enchantids[1]==1503) ? "selected" : "").'>HP +100</option>
							<option value="1505"'.($r = ($this->enchantids[1]==1505) ? "selected" : "").'>+20 Fire Resistance</option>
							<option value="1506"'.($r = ($this->enchantids[1]==1506) ? "selected" : "").'>Strength +8</option>
							<option value="1507"'.($r = ($this->enchantids[1]==1507) ? "selected" : "").'>Stamina +8</option>
							<option value="1508"'.($r = ($this->enchantids[1]==1508) ? "selected" : "").'>Agility +8</option>
							<option value="1509"'.($r = ($this->enchantids[1]==1509) ? "selected" : "").'>Intellect +8</option>
							<option value="1510"'.($r = ($this->enchantids[1]==1510) ? "selected" : "").'>Spirit +8</option>
							<option value="2543"'.($r = ($this->enchantids[1]==2543) ? "selected" : "").'>Attack Speed +1%</option>
							<option value="2544"'.($r = ($this->enchantids[1]==2544) ? "selected" : "").'>Healing and Spell Damage +8</option>
							<option value="2545"'.($r = ($this->enchantids[1]==2545) ? "selected" : "").'>Dodge +1%</option>
							<option value="2583"'.($r = ($this->enchantids[1]==2583) ? "selected" : "").'>Defense +7/Stamina +10/Block Value +15</option>
							<option value="2584"'.($r = ($this->enchantids[1]==2584) ? "selected" : "").'>Defense +7/Stamina +10/Healing Spells +24</option>
							<option value="2585"'.($r = ($this->enchantids[1]==2585) ? "selected" : "").'>Attack Power +28/Dodge +1%</option>
							<option value="2586"'.($r = ($this->enchantids[1]==2586) ? "selected" : "").'>Ranged Attack Power +24/Stamina +10/Hit +1%</option>
							<option value="2587"'.($r = ($this->enchantids[1]==2587) ? "selected" : "").'>Healing and Spell Damage +13/Intellect +15</option>
							<option value="2588"'.($r = ($this->enchantids[1]==2588) ? "selected" : "").'>Healing and Spell Damage +18/Spell Hit +1%</option>
							<option value="2589"'.($r = ($this->enchantids[1]==2589) ? "selected" : "").'>Healing and Spell Damage +18/Stamina +10</option>
							<option value="2590"'.($r = ($this->enchantids[1]==2590) ? "selected" : "").'>Mana Regen +4/Stamina +10/Healing Spells +24</option>
							<option value="2591"'.($r = ($this->enchantids[1]==2591) ? "selected" : "").'>Intellect +10/Stamina +10/Healing Spells +24</option>
							<option value="2681"'.($r = ($this->enchantids[1]==2681) ? "selected" : "").'>+10 Nature Resistance</option>
							<option value="2682"'.($r = ($this->enchantids[1]==2682) ? "selected" : "").'>+10 Frost Resistance</option>
							<option value="2683"'.($r = ($this->enchantids[1]==2683) ? "selected" : "").'>+10 Shadow Resistance</option>
						</select>
					</div>
					<div class="desRow">
						<div>Necklace</div>
						<input type="text" name="inv2" placeholder="Enter itemid" value="'.($r = ($this->items[2]) ? $this->items[2] : "").'" />
					</div>
					<div class="desRow">
						<div>Shoulder</div>
						<input type="text" name="inv3" placeholder="Enter itemid" value="'.($r = ($this->items[3]) ? $this->items[3] : "").'" />
						<select name="ench3">
							<option value="0"'.($r = ($this->enchantids[3]==0) ? "selected" : "").'>None</option>
							<option value="2483"'.($r = ($this->enchantids[3]==2483) ? "selected" : "").'>+5 Fire Resistance</option>
							<option value="2484"'.($r = ($this->enchantids[3]==2484) ? "selected" : "").'>+5 Frost Resistance</option>
							<option value="2485"'.($r = ($this->enchantids[3]==2485) ? "selected" : "").'>+5 Arcane Resistance</option>
							<option value="2486"'.($r = ($this->enchantids[3]==2486) ? "selected" : "").'>+5 Nature Resistance</option>
							<option value="2487"'.($r = ($this->enchantids[3]==2487) ? "selected" : "").'>+5 Shadow Resistance</option>
							<option value="2488"'.($r = ($this->enchantids[3]==2488) ? "selected" : "").'>+5 All Resistances</option>
							<option value="2604"'.($r = ($this->enchantids[3]==2604) ? "selected" : "").'>+33 Healing Spells</option>
							<option value="2605"'.($r = ($this->enchantids[3]==2605) ? "selected" : "").'>+18 Spell Damage and Healing</option>
							<option value="2606"'.($r = ($this->enchantids[3]==2606) ? "selected" : "").'>+30 Attack Power</option>
						</select>
					</div>
					<div class="desRow">
						<div>Back</div>
						<input type="text" name="inv15" placeholder="Enter itemid" value="'.($r = ($this->items[15]) ? $this->items[15] : "").'" />
						<select name="ench15">
							<option value="0"'.($r = ($this->enchantids[15]==0) ? "selected" : "").'>None</option>
							<option value="65"'.($r = ($this->enchantids[15]==65) ? "selected" : "").'>+1 All Resistances</option>
							<option value="247"'.($r = ($this->enchantids[15]==247) ? "selected" : "").'>Agility +1</option>
							<option value="256"'.($r = ($this->enchantids[15]==256) ? "selected" : "").'>+5 Fire Resistance</option>
							<option value="744"'.($r = ($this->enchantids[15]==744) ? "selected" : "").'>Armor +20</option>
							<option value="783"'.($r = ($this->enchantids[15]==783) ? "selected" : "").'>Armor +10</option>
							<option value="804"'.($r = ($this->enchantids[15]==804) ? "selected" : "").'>+10 Shadow Resistance</option>
							<option value="848"'.($r = ($this->enchantids[15]==848) ? "selected" : "").'>Armor +30</option>
							<option value="849"'.($r = ($this->enchantids[15]==849) ? "selected" : "").'>Agility +3</option>
							<option value="884"'.($r = ($this->enchantids[15]==884) ? "selected" : "").'>Armor +50</option>
							<option value="903"'.($r = ($this->enchantids[15]==903) ? "selected" : "").'>+3 All Resistances</option>
							<option value="910"'.($r = ($this->enchantids[15]==910) ? "selected" : "").'>Increased Stealth</option>
							<option value="1888"'.($r = ($this->enchantids[15]==1888) ? "selected" : "").'>+5 All Resistances</option>
							<option value="1889"'.($r = ($this->enchantids[15]==1889) ? "selected" : "").'>Armor +70</option>
							<option value="2463"'.($r = ($this->enchantids[15]==2463) ? "selected" : "").'>+7 Fire Resistance</option>
							<option value="2619"'.($r = ($this->enchantids[15]==2619) ? "selected" : "").'>+15 Fire Resistance</option>
							<option value="2620"'.($r = ($this->enchantids[15]==2620) ? "selected" : "").'>+15 Nature Resistance</option>
							<option value="2621"'.($r = ($this->enchantids[15]==2621) ? "selected" : "").'>Subtlety</option>
							<option value="2622"'.($r = ($this->enchantids[15]==2622) ? "selected" : "").'>Dodge +1%</option>
						</select>
					</div>
					<div class="desRow">
						<div>Chest</div>
						<input type="text" name="inv5" placeholder="Enter itemid" value="'.($r = ($this->items[5]) ? $this->items[5] : "").'" />
						<select name="ench5">
							<option value="0"'.($r = ($this->enchantids[5]==0) ? "selected" : "").'>None</option>
							<option value="15"'.($r = ($this->enchantids[5]==15) ? "selected" : "").'>Reinforced Armor +8</option>
							<option value="16"'.($r = ($this->enchantids[5]==16) ? "selected" : "").'>Reinforced Armor +16</option>
							<option value="17"'.($r = ($this->enchantids[5]==17) ? "selected" : "").'>Reinforced Armor +24</option>
							<option value="18"'.($r = ($this->enchantids[5]==18) ? "selected" : "").'>Reinforced Armor +32</option>
							<option value="24"'.($r = ($this->enchantids[5]==24) ? "selected" : "").'>Mana +5</option>
							<option value="41"'.($r = ($this->enchantids[5]==41) ? "selected" : "").'>Health +5</option>
							<option value="44"'.($r = ($this->enchantids[5]==44) ? "selected" : "").'>Absorption (10)</option>
							<option value="63"'.($r = ($this->enchantids[5]==63) ? "selected" : "").'>Absorption (25)</option>
							<option value="242"'.($r = ($this->enchantids[5]==242) ? "selected" : "").'>Health +15</option>
							<option value="246"'.($r = ($this->enchantids[5]==246) ? "selected" : "").'>Mana +20</option>
							<option value="254"'.($r = ($this->enchantids[5]==254) ? "selected" : "").'>Health +25</option>
							<option value="843"'.($r = ($this->enchantids[5]==843) ? "selected" : "").'>Mana +30</option>
							<option value="847"'.($r = ($this->enchantids[5]==847) ? "selected" : "").'>All Stats +1</option>
							<option value="850"'.($r = ($this->enchantids[5]==850) ? "selected" : "").'>Health +35</option>
							<option value="857"'.($r = ($this->enchantids[5]==857) ? "selected" : "").'>Mana +50</option>
							<option value="866"'.($r = ($this->enchantids[5]==866) ? "selected" : "").'>All Stats +2</option>
							<option value="908"'.($r = ($this->enchantids[5]==908) ? "selected" : "").'>Health +50</option>
							<option value="913"'.($r = ($this->enchantids[5]==913) ? "selected" : "").'>Mana +65</option>
							<option value="928"'.($r = ($this->enchantids[5]==928) ? "selected" : "").'>All Stats +3</option>
							<option value="1843"'.($r = ($this->enchantids[5]==1843) ? "selected" : "").'>Reinforced Armor +40</option>
							<option value="1891"'.($r = ($this->enchantids[5]==1891) ? "selected" : "").'>All Stats +4</option>
							<option value="1892"'.($r = ($this->enchantids[5]==1892) ? "selected" : "").'>Health +100</option>
							<option value="1893"'.($r = ($this->enchantids[5]==1893) ? "selected" : "").'>Mana +100</option>
							<option value="2503"'.($r = ($this->enchantids[5]==2503) ? "selected" : "").'>Defense +3</option>
						</select>
					</div>
					<div class="desRow">
						<div>Wrist</div>
						<input type="text" name="inv9" placeholder="Enter itemid" value="'.($r = ($this->items[9]) ? $this->items[9] : "").'" />
						<select name="ench9">
							<option value="0"'.($r = ($this->enchantids[9]==0) ? "selected" : "").'>None</option>
							<option value="41"'.($r = ($this->enchantids[9]==41) ? "selected" : "").'>Health +5</option>
							<option value="66"'.($r = ($this->enchantids[9]==66) ? "selected" : "").'>Stamina +1</option>
							<option value="243"'.($r = ($this->enchantids[9]==243) ? "selected" : "").'>Spirit +1</option>
							<option value="247"'.($r = ($this->enchantids[9]==247) ? "selected" : "").'>Agility +1</option>
							<option value="248"'.($r = ($this->enchantids[9]==248) ? "selected" : "").'>Strength +1</option>
							<option value="255"'.($r = ($this->enchantids[9]==255) ? "selected" : "").'>Spirit +3</option>
							<option value="723"'.($r = ($this->enchantids[9]==723) ? "selected" : "").'>Intellect +3</option>
							<option value="724"'.($r = ($this->enchantids[9]==724) ? "selected" : "").'>Stamina +3</option>
							<option value="823"'.($r = ($this->enchantids[9]==823) ? "selected" : "").'>Strength +3</option>
							<option value="851"'.($r = ($this->enchantids[9]==851) ? "selected" : "").'>Spirit +5</option>
							<option value="852"'.($r = ($this->enchantids[9]==852) ? "selected" : "").'>Stamina +5</option>
							<option value="856"'.($r = ($this->enchantids[9]==856) ? "selected" : "").'>Strength +5</option>
							<option value="905"'.($r = ($this->enchantids[9]==905) ? "selected" : "").'>Intellect +5</option>
							<option value="907"'.($r = ($this->enchantids[9]==907) ? "selected" : "").'>Spirit +7</option>
							<option value="923"'.($r = ($this->enchantids[9]==923) ? "selected" : "").'>Defense +3</option>
							<option value="924"'.($r = ($this->enchantids[9]==924) ? "selected" : "").'>Defense +1</option>
							<option value="927"'.($r = ($this->enchantids[9]==927) ? "selected" : "").'>Strength +7</option>
							<option value="929"'.($r = ($this->enchantids[9]==929) ? "selected" : "").'>Stamina +7</option>
							<option value="1883"'.($r = ($this->enchantids[9]==1883) ? "selected" : "").'>Intellect +7</option>
							<option value="1884"'.($r = ($this->enchantids[9]==1884) ? "selected" : "").'>Spirit +9</option>
							<option value="1885"'.($r = ($this->enchantids[9]==1885) ? "selected" : "").'>Strength +9</option>
							<option value="1886"'.($r = ($this->enchantids[9]==1886) ? "selected" : "").'>Stamina +9</option>
							<option value="2565"'.($r = ($this->enchantids[9]==2565) ? "selected" : "").'>Mana Regen 4 per 5 sec.</option>
							<option value="2566"'.($r = ($this->enchantids[9]==2566) ? "selected" : "").'>Healing Spells +24</option>
						</select>
					</div>
					<div class="desRow">
						<div>Gloves</div>
						<input type="text" name="inv10" placeholder="Enter itemid" value="'.($r = ($this->items[10]) ? $this->items[10] : "").'" />
						<select name="ench10">
							<option value="0"'.($r = ($this->enchantids[10]==0) ? "selected" : "").'>None</option>
							<option value="15"'.($r = ($this->enchantids[10]==15) ? "selected" : "").'>Reinforced Armor +8</option>
							<option value="16"'.($r = ($this->enchantids[10]==16) ? "selected" : "").'>Reinforced Armor +16</option>
							<option value="17"'.($r = ($this->enchantids[10]==17) ? "selected" : "").'>Reinforced Armor +24</option>
							<option value="18"'.($r = ($this->enchantids[10]==18) ? "selected" : "").'>Reinforced Armor +32</option>
							<option value="844"'.($r = ($this->enchantids[10]==844) ? "selected" : "").'>Mining +2</option>
							<option value="845"'.($r = ($this->enchantids[10]==845) ? "selected" : "").'>Herbalism +2</option>
							<option value="846"'.($r = ($this->enchantids[10]==846) ? "selected" : "").'>Fishing +2</option>
							<option value="856"'.($r = ($this->enchantids[10]==856) ? "selected" : "").'>Strength +5</option>
							<option value="865"'.($r = ($this->enchantids[10]==865) ? "selected" : "").'>Skinning +5</option>
							<option value="904"'.($r = ($this->enchantids[10]==904) ? "selected" : "").'>Agility +5</option>
							<option value="906"'.($r = ($this->enchantids[10]==906) ? "selected" : "").'>Mining +5</option>
							<option value="909"'.($r = ($this->enchantids[10]==909) ? "selected" : "").'>Herbalism +5</option>
							<option value="927"'.($r = ($this->enchantids[10]==927) ? "selected" : "").'>Strength +7</option>
							<option value="930"'.($r = ($this->enchantids[10]==930) ? "selected" : "").'>Minor Mount Speed Increase</option>
							<option value="931"'.($r = ($this->enchantids[10]==931) ? "selected" : "").'>Attack Speed +1%</option>
							<option value="1843"'.($r = ($this->enchantids[10]==1843) ? "selected" : "").'>Reinforced Armor +40</option>
							<option value="1887"'.($r = ($this->enchantids[10]==1887) ? "selected" : "").'>Agility +7</option>
							<option value="2503"'.($r = ($this->enchantids[10]==2503) ? "selected" : "").'>Defense +3</option>
							<option value="2564"'.($r = ($this->enchantids[10]==2564) ? "selected" : "").'>Agility +15</option>
							<option value="2613"'.($r = ($this->enchantids[10]==2613) ? "selected" : "").'>Threat +2%</option>
							<option value="2614"'.($r = ($this->enchantids[10]==2614) ? "selected" : "").'>Shadow Damage +20</option>
							<option value="2615"'.($r = ($this->enchantids[10]==2615) ? "selected" : "").'>Frost Damage +20</option>
							<option value="2616"'.($r = ($this->enchantids[10]==2616) ? "selected" : "").'>Fire Damage +20</option>
							<option value="2617"'.($r = ($this->enchantids[10]==2617) ? "selected" : "").'>Healing Spells +30</option>
						</select>
					</div>
					<div class="desRow">
						<div>Belt</div>
						<input type="text" name="inv6" placeholder="Enter itemid" value="'.($r = ($this->items[6]) ? $this->items[6] : "").'" />
					</div>
					<div class="desRow">
						<div>Legs</div>
						<input type="text" name="inv7" placeholder="Enter itemid" value="'.($r = ($this->items[7]) ? $this->items[7] : "").'" />
						<select name="ench7">
							<option value="0"'.($r = ($this->enchantids[7]==0) ? "selected" : "").'>None</option>
							<option value="15"'.($r = ($this->enchantids[7]==15) ? "selected" : "").'>Reinforced Armor +8</option>
							<option value="16"'.($r = ($this->enchantids[7]==16) ? "selected" : "").'>Reinforced Armor +16</option>
							<option value="17"'.($r = ($this->enchantids[7]==17) ? "selected" : "").'>Reinforced Armor +24</option>
							<option value="18"'.($r = ($this->enchantids[7]==18) ? "selected" : "").'>Reinforced Armor +32</option>
							<option value="1483"'.($r = ($this->enchantids[7]==1483) ? "selected" : "").'>Mana +150</option>
							<option value="1503"'.($r = ($this->enchantids[7]==1503) ? "selected" : "").'>HP +100</option>
							<option value="1505"'.($r = ($this->enchantids[7]==1505) ? "selected" : "").'>+20 Fire Resistance</option>
							<option value="1506"'.($r = ($this->enchantids[7]==1506) ? "selected" : "").'>Strength +8</option>
							<option value="1507"'.($r = ($this->enchantids[7]==1507) ? "selected" : "").'>Stamina +8</option>
							<option value="1508"'.($r = ($this->enchantids[7]==1508) ? "selected" : "").'>Agility +8</option>
							<option value="1509"'.($r = ($this->enchantids[7]==1509) ? "selected" : "").'>Intellect +8</option>
							<option value="1843"'.($r = ($this->enchantids[7]==1843) ? "selected" : "").'>Reinforced Armor +40</option>
							<option value="2503"'.($r = ($this->enchantids[7]==2503) ? "selected" : "").'>Defense +3</option>
							<option value="2543"'.($r = ($this->enchantids[7]==2543) ? "selected" : "").'>Attack Speed +1%</option>
							<option value="2544"'.($r = ($this->enchantids[7]==2544) ? "selected" : "").'>Healing and Spell Damage +8</option>
							<option value="2545"'.($r = ($this->enchantids[7]==2545) ? "selected" : "").'>Dodge +1%</option>
							<option value="2583"'.($r = ($this->enchantids[7]==2583) ? "selected" : "").'>Defense +7/Stamina +10/Block Value +15</option>
							<option value="2584"'.($r = ($this->enchantids[7]==2584) ? "selected" : "").'>Defense +7/Stamina +10/Healing Spells +24</option>
							<option value="2585"'.($r = ($this->enchantids[7]==2585) ? "selected" : "").'>Attack Power +28/Dodge +1%</option>
							<option value="2586"'.($r = ($this->enchantids[7]==2586) ? "selected" : "").'>Ranged Attack Power +24/Stamina +10/Hit +1%</option>
							<option value="2587"'.($r = ($this->enchantids[7]==2587) ? "selected" : "").'>Healing and Spell Damage +13/Intellect +15</option>
							<option value="2588"'.($r = ($this->enchantids[7]==2588) ? "selected" : "").'>Healing and Spell Damage +18/Spell Hit +1%</option>
							<option value="2589"'.($r = ($this->enchantids[7]==2589) ? "selected" : "").'>Healing and Spell Damage +18/Stamina +10</option>
							<option value="2590"'.($r = ($this->enchantids[7]==2590) ? "selected" : "").'>Mana Regen +4/Stamina +10/Healing Spells +24</option>
							<option value="2591"'.($r = ($this->enchantids[7]==2591) ? "selected" : "").'>Intellect +10/Stamina +10/Healing Spells +24</option>
							<option value="2681"'.($r = ($this->enchantids[7]==2681) ? "selected" : "").'>+10 Nature Resistance</option>
							<option value="2682"'.($r = ($this->enchantids[7]==2682) ? "selected" : "").'>+10 Frost Resistance</option>
							<option value="2683"'.($r = ($this->enchantids[7]==2683) ? "selected" : "").'>+10 Shadow Resistance</option>
						</select>
					</div>
					<div class="desRow">
						<div>Feet</div>
						<input type="text" name="inv8" placeholder="Enter itemid" value="'.($r = ($this->items[8]) ? $this->items[8] : "").'" />
						<select name="ench8">
							<option value="0"'.($r = ($this->enchantids[8]==0) ? "selected" : "").'>None</option>
							<option value="15"'.($r = ($this->enchantids[8]==15) ? "selected" : "").'>Reinforced Armor +8</option>
							<option value="16"'.($r = ($this->enchantids[8]==16) ? "selected" : "").'>Reinforced Armor +16</option>
							<option value="17"'.($r = ($this->enchantids[8]==17) ? "selected" : "").'>Reinforced Armor +24</option>
							<option value="18"'.($r = ($this->enchantids[8]==18) ? "selected" : "").'>Reinforced Armor +32</option>
							<option value="66"'.($r = ($this->enchantids[8]==66) ? "selected" : "").'>Stamina +1</option>
							<option value="255"'.($r = ($this->enchantids[8]==255) ? "selected" : "").'>Spirit +3</option>
							<option value="464"'.($r = ($this->enchantids[8]==464) ? "selected" : "").'>Mithril Spurs</option>
							<option value="724"'.($r = ($this->enchantids[8]==724) ? "selected" : "").'>Stamina +3</option>
							<option value="849"'.($r = ($this->enchantids[8]==849) ? "selected" : "").'>Agility +3</option>
							<option value="851"'.($r = ($this->enchantids[8]==851) ? "selected" : "").'>Spirit +5</option>
							<option value="852"'.($r = ($this->enchantids[8]==852) ? "selected" : "").'>Stamina +5</option>
							<option value="904"'.($r = ($this->enchantids[8]==904) ? "selected" : "").'>Agility +5</option>
							<option value="911"'.($r = ($this->enchantids[8]==911) ? "selected" : "").'>Minor Speed Increase</option>
							<option value="929"'.($r = ($this->enchantids[8]==929) ? "selected" : "").'>Stamina +7</option>
							<option value="1843"'.($r = ($this->enchantids[8]==1843) ? "selected" : "").'>Reinforced Armor +40</option>
							<option value="1887"'.($r = ($this->enchantids[8]==1887) ? "selected" : "").'>Agility +7</option>
							<option value="2503"'.($r = ($this->enchantids[8]==2503) ? "selected" : "").'>Defense +3</option>
						</select>
					</div>
					<div class="desRow">
						<div>Ring 1</div>
						<input type="text" name="inv11" placeholder="Enter itemid" value="'.($r = ($this->items[11]) ? $this->items[11] : "").'" />
					</div>
					<div class="desRow">
						<div>Ring 2</div>
						<input type="text" name="inv12" placeholder="Enter itemid" value="'.($r = ($this->items[12]) ? $this->items[12] : "").'" />
					</div>
					<div class="desRow">
						<div>Trinket 1</div>
						<input type="text" name="inv13" placeholder="Enter itemid" value="'.($r = ($this->items[13]) ? $this->items[13] : "").'" />
					</div>
					<div class="desRow">
						<div>Trinket 2</div>
						<input type="text" name="inv14" placeholder="Enter itemid" value="'.($r = ($this->items[14]) ? $this->items[14] : "").'" />
					</div>
					<div class="desRow">
						<div>Main Hand</div>
						<input type="text" name="inv16" placeholder="Enter itemid" value="'.($r = ($this->items[16]) ? $this->items[16] : "").'" />
						<select name="ench16">
							<option value="0"'.($r = ($this->enchantids[16]==0) ? "selected" : "").'>None</option>
							<option value="34"'.($r = ($this->enchantids[16]==34) ? "selected" : "").'>Counterweight +3% Attack Speed</option>
							<option value="36"'.($r = ($this->enchantids[16]==36) ? "selected" : "").'>Enchant: Fiery Blaze</option>
							<option value="37"'.($r = ($this->enchantids[16]==37) ? "selected" : "").'>Weapon Chain - Immune Disarm</option>
							<option value="241"'.($r = ($this->enchantids[16]==241) ? "selected" : "").'>Weapon Damage +2</option>
							<option value="249"'.($r = ($this->enchantids[16]==249) ? "selected" : "").'>Beastslaying +2</option>
							<option value="250"'.($r = ($this->enchantids[16]==250) ? "selected" : "").'>Weapon Damage +1 </option>
							<option value="255"'.($r = ($this->enchantids[16]==255) ? "selected" : "").'>Spirit +3</option>
							<option value="723"'.($r = ($this->enchantids[16]==723) ? "selected" : "").'>Intellect +3</option>
							<option value="803"'.($r = ($this->enchantids[16]==803) ? "selected" : "").'>Fiery Weapon</option>
							<option value="805"'.($r = ($this->enchantids[16]==805) ? "selected" : "").'>Weapon Damage +4</option>
							<option value="853"'.($r = ($this->enchantids[16]==853) ? "selected" : "").'>Beastslaying +6</option>
							<option value="854"'.($r = ($this->enchantids[16]==854) ? "selected" : "").'>Elemental Slayer +6</option>
							<option value="912"'.($r = ($this->enchantids[16]==912) ? "selected" : "").'>Demonslaying</option>
							<option value="943"'.($r = ($this->enchantids[16]==943) ? "selected" : "").'>Weapon Damage +3</option>
							<option value="963"'.($r = ($this->enchantids[16]==963) ? "selected" : "").'>Weapon Damage +7</option>
							<option value="1894"'.($r = ($this->enchantids[16]==1894) ? "selected" : "").'>Icy Weapon</option>
							<option value="1896"'.($r = ($this->enchantids[16]==1896) ? "selected" : "").'>Weapon Damage +9</option>
							<option value="1897"'.($r = ($this->enchantids[16]==1897) ? "selected" : "").'>Weapon Damage +5</option>
							<option value="1898"'.($r = ($this->enchantids[16]==1898) ? "selected" : "").'>Lifestealing</option>
							<option value="1899"'.($r = ($this->enchantids[16]==1899) ? "selected" : "").'>Unholy Weapon</option>
							<option value="1900"'.($r = ($this->enchantids[16]==1900) ? "selected" : "").'>Crusader</option>
							<option value="1903"'.($r = ($this->enchantids[16]==1903) ? "selected" : "").'>Spirit +9</option>
							<option value="1904"'.($r = ($this->enchantids[16]==1904) ? "selected" : "").'>Intellect +9</option>
							<option value="2443"'.($r = ($this->enchantids[16]==2443) ? "selected" : "").'>Frost Spell Damage +7</option>
							<option value="2504"'.($r = ($this->enchantids[16]==2504) ? "selected" : "").'>Spell Damage +30</option>
							<option value="2505"'.($r = ($this->enchantids[16]==2505) ? "selected" : "").'>Healing Spells +55</option>
							<option value="2563"'.($r = ($this->enchantids[16]==2563) ? "selected" : "").'>Strength +15</option>
							<option value="2564"'.($r = ($this->enchantids[16]==2564) ? "selected" : "").'>Agility +15</option>
							<option value="2567"'.($r = ($this->enchantids[16]==2567) ? "selected" : "").'>Spirit +20</option>
							<option value="2568"'.($r = ($this->enchantids[16]==2568) ? "selected" : "").'>Intellect +22</option>
							<option value="2646"'.($r = ($this->enchantids[16]==2646) ? "selected" : "").'>Agility +25</option>
						</select>
					</div>
					<div class="desRow">
						<div>Off Hand</div>
						<input type="text" name="inv17" placeholder="Enter itemid" value="'.($r = ($this->items[17]) ? $this->items[17] : "").'" />
						<select name="ench17">
							<option value="0"'.($r = ($this->enchantids[17]==0) ? "selected" : "").'>None</option>
							<option value="36"'.($r = ($this->enchantids[17]==36) ? "selected" : "").'>Enchant: Fiery Blaze</option>
							<option value="37"'.($r = ($this->enchantids[17]==37) ? "selected" : "").'>Weapon Chain - Immune Disarm</option>
							<option value="66"'.($r = ($this->enchantids[17]==66) ? "selected" : "").'>Stamina +1</option>
							<option value="241"'.($r = ($this->enchantids[17]==241) ? "selected" : "").'>Weapon Damage +2</option>
							<option value="249"'.($r = ($this->enchantids[17]==249) ? "selected" : "").'>Beastslaying +2</option>
							<option value="250"'.($r = ($this->enchantids[17]==250) ? "selected" : "").'>Weapon Damage +1 </option>
							<option value="463"'.($r = ($this->enchantids[17]==463) ? "selected" : "").'>Mithril Spike (16-20)</option>
							<option value="724"'.($r = ($this->enchantids[17]==724) ? "selected" : "").'>Stamina +3</option>
							<option value="803"'.($r = ($this->enchantids[17]==803) ? "selected" : "").'>Fiery Weapon</option>
							<option value="805"'.($r = ($this->enchantids[17]==805) ? "selected" : "").'>Weapon Damage +4</option>
							<option value="852"'.($r = ($this->enchantids[17]==852) ? "selected" : "").'>Stamina +5</option>
							<option value="863"'.($r = ($this->enchantids[17]==863) ? "selected" : "").'>Blocking +2%</option>
							<option value="907"'.($r = ($this->enchantids[17]==907) ? "selected" : "").'>Spirit +7</option>
							<option value="912"'.($r = ($this->enchantids[17]==912) ? "selected" : "").'>Demonslaying</option>
							<option value="929"'.($r = ($this->enchantids[17]==929) ? "selected" : "").'>Stamina +7</option>
							<option value="943"'.($r = ($this->enchantids[17]==943) ? "selected" : "").'>Weapon Damage +3</option>
							<option value="1704"'.($r = ($this->enchantids[17]==1704) ? "selected" : "").'>Thorium Spike (20-30)</option>
							<option value="1890"'.($r = ($this->enchantids[17]==1890) ? "selected" : "").'>Spirit +9</option>
							<option value="1894"'.($r = ($this->enchantids[17]==1894) ? "selected" : "").'>Icy Weapon</option>
							<option value="1897"'.($r = ($this->enchantids[17]==1897) ? "selected" : "").'>Weapon Damage +5</option>
							<option value="1898"'.($r = ($this->enchantids[17]==1898) ? "selected" : "").'>Lifestealing</option>
							<option value="1900"'.($r = ($this->enchantids[17]==1900) ? "selected" : "").'>Crusader</option>
							<option value="2443"'.($r = ($this->enchantids[17]==2443) ? "selected" : "").'>Frost Spell Damage +7</option>
							<option value="2504"'.($r = ($this->enchantids[17]==2504) ? "selected" : "").'>Spell Damage +30</option>
							<option value="2563"'.($r = ($this->enchantids[17]==2563) ? "selected" : "").'>Strength +15</option>
							<option value="2564"'.($r = ($this->enchantids[17]==2564) ? "selected" : "").'>Agility +15</option>
						</select>
					</div>
					<div class="desRow">
						<div>Ranged</div>
						<input type="text" name="inv18" placeholder="Enter itemid" value="'.($r = ($this->items[18]) ? $this->items[18] : "").'" />
						<select name="ench18">
							<option value="0"'.($r = ($this->enchantids[18]==0) ? "selected" : "").'>None</option>
							<option value="30"'.($r = ($this->enchantids[18]==30) ? "selected" : "").'>Scope (+1 Damage)</option>
							<option value="32"'.($r = ($this->enchantids[18]==32) ? "selected" : "").'>Scope (+2 Damage)</option>
							<option value="33"'.($r = ($this->enchantids[18]==33) ? "selected" : "").'>Scope (+3 Damage)</option>
							<option value="663"'.($r = ($this->enchantids[18]==663) ? "selected" : "").'>Scope (+5 Damage)</option>
							<option value="664"'.($r = ($this->enchantids[18]==664) ? "selected" : "").'>Scope (+7 Damage)</option>
							<option value="2523"'.($r = ($this->enchantids[18]==2523) ? "selected" : "").'>+3% Hit</option>
						</select>
					</div>
				</section>
				<section class="sright" style="background-image: url(\'{path}Vanilla/CharacterDesigner/img/'.strtolower($this->gender[$this->genderid]).strtolower($this->race[$this->raceid]).'.png\');">
					<div class="urlbar">
						<input type="text" onClick="this.select();" value="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" name="url" readonly/>
						<select name="race">
							<option class="alliance" value="1"'.($r = ($this->raceid==1) ? "selected" : "").'>Human</option>
							<option class="alliance" value="2"'.($r = ($this->raceid==2) ? "selected" : "").'>Dwarf</option>
							<option class="alliance" value="3"'.($r = ($this->raceid==3) ? "selected" : "").'>Night Elf</option>
							<option class="alliance" value="4"'.($r = ($this->raceid==4) ? "selected" : "").'>Gnome</option>
							<option class="horde" value="5"'.($r = ($this->raceid==5) ? "selected" : "").'>Orc</option>
							<option class="horde" value="6"'.($r = ($this->raceid==6) ? "selected" : "").'>Undead</option>
							<option class="horde" value="7"'.($r = ($this->raceid==7) ? "selected" : "").'>Troll</option>
							<option class="horde" value="8"'.($r = ($this->raceid==8) ? "selected" : "").'>Tauren</option>
						</select>
						<select name="gender">
							<option value="3"'.($r = ($this->genderid==3) ? "selected" : "").'>Female</option>
							<option value="2"'.($r = ($this->genderid==2) ? "selected" : "").'>Male</option>
						</select>
						<select name="class">
							<option value="1" class="color-warrior"'.($r = ($this->classid==1) ? "selected" : "").'>Warrior</option>
							<option value="2" class="color-rogue"'.($r = ($this->classid==2) ? "selected" : "").'>Rogue</option>
							<option value="3" class="color-priest"'.($r = ($this->classid==3) ? "selected" : "").'>Priest</option>
							<option value="4" class="color-hunter"'.($r = ($this->classid==4) ? "selected" : "").'>Hunter</option>
							<option value="5" class="color-druid"'.($r = ($this->classid==5) ? "selected" : "").'>Druid</option>
							<option value="6" class="color-mage"'.($r = ($this->classid==6) ? "selected" : "").'>Mage</option>
							<option value="7" class="color-warlock"'.($r = ($this->classid==7) ? "selected" : "").'>Warlock</option>
							<option value="8" class="color-paladin"'.($r = ($this->classid==8) ? "selected" : "").'>Paladin</option>
							<option value="9" class="color-shaman"'.($r = ($this->classid==9) ? "selected" : "").'>Shaman</option>
						</select>
						<select name="talent">
							<option value="0"'.($r = ($this->talentid==0) ? "selected" : "").'>No spec</option>
							<option value="1"'.($r = ($this->talentid==1) ? "selected" : "").'>Tree 1</option>
							<option value="2"'.($r = ($this->talentid==2) ? "selected" : "").'>Tree 2</option>
							<option value="3"'.($r = ($this->talentid==3) ? "selected" : "").'>Tree 3</option>
						</select>
						<input type="submit" value="Generate" />
					</div>
					<div class="gearframe">
						<div class="gleft">
							<div class="item qe'.$this->itemTemplate[$this->items[1]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[1]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[1].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[2]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[2]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[2].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[3]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[3]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[3].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[15]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[15]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[15].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[5]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[5]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[5].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[4]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[4]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[4].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[19]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[19]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[19].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[9]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[9]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[9].'" target="_blank"><div class="b"></div></a>
							</div>
						</div>
						<div class="gmiddle">
							<div class="description">
								'.$this->getNameString().$this->getGuildRank().'
							</div>
							<div class="resistances">
								<div>'.$this->statValues[40].'</div>
								<div>'.$this->statValues[41].'</div>
								<div>'.$this->statValues[44].'</div>
								<div>'.$this->statValues[42].'</div>
								<div>'.$this->statValues[43].'</div>
							</div>
							<div class="powerbars">
								<div id="health">'.ceil($this->statValues[45]).'</div>
								<div id="'.$this->powerbartype.'">'.ceil($this->statValues[46]).'</div>
							</div>
						</div>
						<div class="gright">
							<div class="item qe'.$this->itemTemplate[$this->items[10]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[10]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[10].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[6]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[6]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[6].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[7]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[7]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[7].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[8]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[8]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[8].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[11]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[11]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[11].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[12]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[12]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[12].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[13]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[13]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[13].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[14]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[14]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[14].'" target="_blank"><div class="b"></div></a>
							</div>
						</div>
						<div class="gbottom">
							<div class="item qe'.$this->itemTemplate[$this->items[16]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[16]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[16].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[17]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[17]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[17].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[18]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[18]]->icon.'.jpg\');">
								<a href="https://vanilla-twinhead.twinstar.cz/?item='.$this->items[18].'" target="_blank"><div class="b"></div></a>
							</div>
						</div>
					</div>
					<div class="stats table">
						<script>function next(a){for(i=1; i<4; i++){document.getElementById("stat"+i).style.display = "none";};document.getElementById(a).style.display="block";}</script>
						<div class="right">
							<table cellspacing="0" class="ts half">
								<thead>
									<th colspan="2" title="The stats might not be 100% accurate, due to missing information.">Attributes*</th>
								</thead>
								<tbody>
									<tr>
										<td>Strength</td>
										<td>'.ceil($this->statValues[4]).'</td>
									</tr>
									<tr>
										<td>Agility</td>
										<td>'.ceil($this->statValues[3]).'</td>
									</tr>
									<tr>
										<td>Stamina</td>
										<td>'.ceil($this->statValues[7]).'</td>
									</tr>
									<tr>
										<td>Intellect</td>
										<td>'.ceil($this->statValues[5]).'</td>
									</tr>
									<tr>
										<td>Spirit</td>
										<td>'.ceil($this->statValues[6]).'</td>
									</tr>
								</tbody>
							</table>
							<table cellspacing="0" class="ts half tablemargin" id="stat1">
								<thead>
									<th colspan="2">
										Defense
										<div class="next" onClick="next(\'stat2\')">&gt;</div>
										<div class="prev" onClick="next(\'stat3\')">&lt;</div>
									</th>
								</thead>
								<tbody>
									<tr>
										<td>Armor</td>
										<td>'.ceil($this->statValues[38]).'</td>
									</tr>
									<tr>
										<td>Defense</td>
										<td>'.ceil($this->statValues[12]).'</td>
									</tr>
									<tr>
										<td>Dodge</td>
										<td>'.round($this->statValues[13], 2).'%</td>
									</tr>
									<tr>
										<td>Parry</td>
										<td>'.round($this->statValues[14], 2).'%</td>
									</tr>
									<tr id="block">
										<td>
											Block
											<table class="static-tooltip">
												<tr>
													<td>Blockvalue</td>
													<td>'.ceil($this->statValues[15]).'</td>
												</tr>
											</table>
										</td>
										<td>'.round($this->statValues[26], 2).'%</td>
									</tr>
								</tbody>
							</table>
							<table cellspacing="0" class="ts half tablemargin hidden" id="stat2">
								<thead>
									<th colspan="2">
										Meele/Ranged
										<div class="next" onClick="next(\'stat3\')">&gt;</div>
										<div class="prev" onClick="next(\'stat1\')">&lt;</div>
									</th>
								</thead>
								<tbody>
									<tr>
										<td>Attackpower</td>
										<td>'.ceil($r = ($this->statValues[24]>$this->statValues[25]) ? $this->statValues[24] : $this->statValues[25]).'</td>
									</tr>
									<tr>
										<td>Hit</td>
										<td title="Meele/Ranged">'.round($this->statValues[16], 2).'%/'.round($this->statValues[16]+$this->statValues[53], 2).'%</td>
									</tr>
									<tr>
										<td>Crit</td>
										<td>'.round($this->statValues[19], 2).'%</td>
									</tr>
								</tbody>
							</table>
							<table cellspacing="0" class="ts half tablemargin hidden" id="stat3">
								<thead>
									<th colspan="2">
										Spell
										<div class="next" onClick="next(\'stat1\')">&gt;</div>
										<div class="prev" onClick="next(\'stat2\')">&lt;</div>
									</th>
								</thead>
								<tbody>
									<tr id="spellpower">
										<td>
											Spellpower
											<table class="static-tooltip">
												<tr>
													<td>Fire</td>
													<td>'.ceil($this->statValues[50]).'</td>
												</tr>
												<tr>
													<td id="nature">Nature</td>
													<td>'.ceil($this->statValues[49]).'</td>
												</tr>
												<tr>
													<td id="arcane">Arcane</td>
													<td>'.ceil($this->statValues[51]).'</td>
												</tr>
												<tr>
													<td id="frost">Frost</td>
													<td>'.ceil($this->statValues[48]).'</td>
												</tr>
												<tr>
													<td id="shadow">Shadow</td>
													<td>'.ceil($this->statValues[52]).'</td>
												</tr>
											</table>
										</td>
										<td>'.ceil($this->statValues[22]).'</td>
									</tr>
									<tr>
										<td>Bonus healing</td>
										<td>'.ceil($this->statValues[23]).'</td>
									</tr>
									<tr>
										<td>Hit</td>
										<td>'.round($this->statValues[18], 2).'%</td>
									</tr>
									<tr>
										<td>Crit</td>
										<td>'.round($this->statValues[21], 2).'%</td>
									</tr>
									<tr>
										<td>Mana regeneration</td>
										<td>'.ceil($this->statValues[0]).'</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</section>
			</section>
			</form>
		</div>
		<script>
		';
		if (in_array($this->classid, array(1,2,4)))
			$content .= 'next(\'stat2\');';
		else
			$content .= 'next(\'stat3\');';
		$content .= '
			pnext(\'pstat5\');
		</script>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $items, $enchants, $misc){
		$items = $this->antiSQLInjection($items);
		$enchants = $this->antiSQLInjection($enchants);
		$misc = $this->antiSQLInjection($misc);
		$misc = explode(",",$misc);
		$this->raceid = intval($misc[0]);
		if ($this->raceid==0)
			$this->raceid=1;
		$this->genderid = intval($misc[1]);
		if ($this->genderid==0)
			$this->genderid=3;
		$this->classid = intval($misc[2]);
		if ($this->classid==0)
			$this->classid=1;
		$this->talentid = intval($misc[3]);
		$items = explode(",", $items);
		$enchants = explode(",", $enchants);
		for ($i=1; $i<=19;$i++){
			$this->items[$i] = intval($items[$i-1]);
			$this->enchantids[$i] = intval($enchants[$i-1]);
		}
		
		$this->getItemTemplate($db);
		$this->getEnchantmentTemplate($db);
		$this->getStatValues();
		$this->siteTitle = " - Character Designer";
		$this->keyWords = "character designer";
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js");
		$this->addJsLink("{path}External/TwinheadTooltip/functions.js");
		$this->addJsLink("{path}External/TwinheadTooltip/tooltip.js");
		$this->addJsLink("{path}External/TwinheadTooltip/twinhead_tooltip.js");
		$this->addCssLink("{path}External/TwinheadTooltip/twinhead_tooltip.css");
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["items"], $_GET["enchants"], $_GET["misc"]);

?>