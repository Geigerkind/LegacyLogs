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
		9 => "Shaman",
		10 => "deathknight",
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
	private $socketids = array();
	
	private function getItemTemplate($db){
		foreach($db->query('SELECT a.itemset, a.entry, a.name, a.quality, a.icon, a.armor, a.holy_res, a.fire_res, a.nature_res, a.frost_res, a.shadow_res, a.arcane_res, a.hit, a.crit, a.apower, a.dodge, a.parry, a.block, a.spellpower, a.healpower, a.spellholy, a.spellfire, a.spellfrost, a.spellnature, a.spellshadow, a.spellarcane, a.manaregen, a.defense, a.blockchance, a.strength, a.agility, a.spirit, a.intellect, a.stamina, a.resilience, a.haste, a.expertise, a.armorpen, a.spellpen, b.* FROM `item_template-wotlk` a LEFT JOIN `wotlk-itemsets` b ON a.itemset = b.id WHERE a.entry IN ('.implode(",",$this->items).')') as $row){
			$this->itemTemplate[$row->entry] = $row;
			$this->itemSets[$row->itemset] = $row;
		}
	}
	
	private function getEnchantmentTemplate($db){
		foreach($db->query('SELECT * FROM `armory-enchantmentstats-wotlk` WHERE enchid IN ('.implode(",", $this->enchantids).','.implode(",",$this->socketids).')') as $row){
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
					$this->statValues[18] += $this->enchTemplate[$this->enchantids[$i]]->hit;
					$this->statValues[19] += $this->enchTemplate[$this->enchantids[$i]]->crit;
					$this->statValues[21] += $this->enchTemplate[$this->enchantids[$i]]->crit;
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
					$this->statValues[55] += $this->enchTemplate[$this->enchantids[$i]]->armorpen;
					$this->statValues[56] += $this->enchTemplate[$this->enchantids[$i]]->spellpen;
					$this->statValues[57] += $this->enchTemplate[$this->enchantids[$i]]->expertise;
					$this->statValues[58] += $this->enchTemplate[$this->enchantids[$i]]->haste;
					$this->statValues[59] += $this->enchTemplate[$this->enchantids[$i]]->haste;
					$this->statValues[60] += $this->enchTemplate[$this->enchantids[$i]]->resilience;
				}
			}
			$this->enchants .= '
				savedEnchants['.$this->items[$i].'] = "'.$this->enchTemplate[$this->enchantids[$i]]->name.'"';
		}
		
		// gems
		for ($i=1; $i<20; $i++){
			for ($p=1;$p<=3;$p++){
				$var = $this->socketids[$i*3-3+$p];
				$bool = false; $valid = true;
				if (isset($this->enchTemplate[$var])){
					$bool = true;
					if (($this->enchTemplate[$var]->flag!=$this->itemTemplate[$this->items[$i]]->{"socketColor_".$p} && !isset($socketColors[$this->enchTemplate[$var]->flag-$this->itemTemplate[$this->items[$i]]->{"socketColor_".$p}]) && ($this->enchTemplate[$var]->flag-$this->itemTemplate[$this->items[$i]]->{"socketColor_".$p})!=0) && $this->itemTemplate[$this->items[$i]]->{"socketColor_".$p} != 1)
						$valid = false;
					$this->statValues[0] += $this->enchTemplate[$var]->manaregen;
					$this->statValues[54] += $this->enchTemplate[$var]->manaregen;
					$this->statValues[3] += $this->enchTemplate[$var]->agility;
					$this->statValues[4] += $this->enchTemplate[$var]->strength;
					$this->statValues[5] += $this->enchTemplate[$var]->intellect;
					$this->statValues[6] += $this->enchTemplate[$var]->spirit;
					$this->statValues[7] += $this->enchTemplate[$var]->stamina;
					$this->statValues[12] += $this->enchTemplate[$var]->defense;
					$this->statValues[13] += $this->enchTemplate[$var]->dodge;
					$this->statValues[15] += $this->enchTemplate[$var]->block;
					$this->statValues[26] += $this->enchTemplate[$var]->blockchance;
					$this->statValues[16] += $this->enchTemplate[$var]->hit;
					$this->statValues[18] += $this->enchTemplate[$var]->hit;
					$this->statValues[19] += $this->enchTemplate[$var]->crit;
					$this->statValues[21] += $this->enchTemplate[$var]->crit;
					$this->statValues[22] += $this->enchTemplate[$var]->spellpower;
					$this->statValues[23] += $this->enchTemplate[$var]->healpower;
					$this->statValues[24] += $this->enchTemplate[$var]->apower;
					$this->statValues[25] += $this->enchTemplate[$var]->rangedapower;
					$this->statValues[38] += $this->enchTemplate[$var]->armor;
					$this->statValues[39] += $this->enchTemplate[$var]->res_holy;
					$this->statValues[40] += $this->enchTemplate[$var]->res_fire;
					$this->statValues[41] += $this->enchTemplate[$var]->res_nature;
					$this->statValues[42] += $this->enchTemplate[$var]->res_frost;
					$this->statValues[43] += $this->enchTemplate[$var]->res_shadow;
					$this->statValues[44] += $this->enchTemplate[$var]->res_arcane;
					$this->statValues[45] += $this->enchTemplate[$var]->health;
					$this->statValues[46] += $this->enchTemplate[$var]->mana;
					$this->statValues[47] += $this->enchTemplate[$var]->spellholy;
					$this->statValues[48] += $this->enchTemplate[$var]->spellfrost;
					$this->statValues[49] += $this->enchTemplate[$var]->spellnature;
					$this->statValues[50] += $this->enchTemplate[$var]->spellfire;
					$this->statValues[51] += $this->enchTemplate[$var]->spellarcane;
					$this->statValues[52] += $this->enchTemplate[$var]->spellshadow;
					$this->statValues[55] += $this->enchTemplate[$var]->armorpen;
					$this->statValues[56] += $this->enchTemplate[$var]->spellpen;
					$this->statValues[57] += $this->enchTemplate[$var]->expertise;
					$this->statValues[58] += $this->enchTemplate[$var]->haste;
					$this->statValues[59] += $this->enchTemplate[$var]->haste;
					$this->statValues[60] += $this->enchTemplate[$var]->resilience;
				}
			}
			if ($bool && $valid){
				$var = intval($this->itemTemplate[$this->items[$i]]->socketBonus);
				if ($var>0){
					$this->statValues[0] += $this->enchTemplate[$var]->manaregen;
					$this->statValues[54] += $this->enchTemplate[$var]->manaregen;
					$this->statValues[3] += $this->enchTemplate[$var]->agility;
					$this->statValues[4] += $this->enchTemplate[$var]->strength;
					$this->statValues[5] += $this->enchTemplate[$var]->intellect;
					$this->statValues[6] += $this->enchTemplate[$var]->spirit;
					$this->statValues[7] += $this->enchTemplate[$var]->stamina;
					$this->statValues[12] += $this->enchTemplate[$var]->defense;
					$this->statValues[13] += $this->enchTemplate[$var]->dodge;
					$this->statValues[15] += $this->enchTemplate[$var]->block;
					$this->statValues[26] += $this->enchTemplate[$var]->blockchance;
					$this->statValues[16] += $this->enchTemplate[$var]->hit;
					$this->statValues[18] += $this->enchTemplate[$var]->hit;
					$this->statValues[19] += $this->enchTemplate[$var]->crit;
					$this->statValues[21] += $this->enchTemplate[$var]->crit;
					$this->statValues[22] += $this->enchTemplate[$var]->spellpower;
					$this->statValues[23] += $this->enchTemplate[$var]->healpower;
					$this->statValues[24] += $this->enchTemplate[$var]->apower;
					$this->statValues[25] += $this->enchTemplate[$var]->rangedapower;
					$this->statValues[38] += $this->enchTemplate[$var]->armor;
					$this->statValues[39] += $this->enchTemplate[$var]->res_holy;
					$this->statValues[40] += $this->enchTemplate[$var]->res_fire;
					$this->statValues[41] += $this->enchTemplate[$var]->res_nature;
					$this->statValues[42] += $this->enchTemplate[$var]->res_frost;
					$this->statValues[43] += $this->enchTemplate[$var]->res_shadow;
					$this->statValues[44] += $this->enchTemplate[$var]->res_arcane;
					$this->statValues[45] += $this->enchTemplate[$var]->health;
					$this->statValues[46] += $this->enchTemplate[$var]->mana;
					$this->statValues[47] += $this->enchTemplate[$var]->spellholy;
					$this->statValues[48] += $this->enchTemplate[$var]->spellfrost;
					$this->statValues[49] += $this->enchTemplate[$var]->spellnature;
					$this->statValues[50] += $this->enchTemplate[$var]->spellfire;
					$this->statValues[51] += $this->enchTemplate[$var]->spellarcane;
					$this->statValues[52] += $this->enchTemplate[$var]->spellshadow;
					$this->statValues[55] += $this->enchTemplate[$var]->armorpen;
					$this->statValues[56] += $this->enchTemplate[$var]->spellpen;
					$this->statValues[57] += $this->enchTemplate[$var]->expertise;
					$this->statValues[58] += $this->enchTemplate[$var]->haste;
					$this->statValues[59] += $this->enchTemplate[$var]->haste;
					$this->statValues[60] += $this->enchTemplate[$var]->resilience;
				}
			}
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
			$this->statValues[18] += $this->itemTemplate[$this->items[$i]]->hit;
			$this->statValues[19] += $this->itemTemplate[$this->items[$i]]->crit;
			$this->statValues[21] += $this->itemTemplate[$this->items[$i]]->crit;
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
			$this->statValues[55] += $this->itemTemplate[$this->items[$i]]->armorpen;
			$this->statValues[56] += $this->itemTemplate[$this->items[$i]]->spellpen;
			$this->statValues[57] += $this->itemTemplate[$this->items[$i]]->expertise;
			$this->statValues[58] += $this->itemTemplate[$this->items[$i]]->haste;
			$this->statValues[59] += $this->itemTemplate[$this->items[$i]]->haste;
			$this->statValues[60] += $this->itemTemplate[$this->items[$i]]->resilience;
		}
		
		$this->statValues[12] += $this->userData->level*5;
		switch($this->classid){
			case 1 :
				// Taking human warrior stats (80)
				// Every haste point equals 0.063396226%
				$this->powerbartype = "rage";
				// Tank stats
				$this->statValues[13] = $this->statValues[13]*0.022125;
				$this->statValues[14] = $this->statValues[14]*0.022068965;
				$this->statValues[26] = $this->statValues[26]*0.022068965; // CHANGE THIS FOR TBC! AND VANILLA!
				
				$this->statValues[16] = $this->statValues[16]*0.030470588;
				$this->statValues[19] = $this->statValues[19]*0.021730769;
				
				$this->statValues[19] += 3.195;
				$this->statValues[14] += 5;
				$this->statValues[13] += 3.62;
				$this->statValues[26] += 5;
				$this->statValues[3] += 113*$this->levelCoeff();
				$this->statValues[4] += 184*$this->levelCoeff();
				$this->statValues[5] += 36*$this->levelCoeff();
				$this->statValues[6] += 61*$this->levelCoeff();
				$this->statValues[7] += 168*$this->levelCoeff();
				$this->statValues[24] += 220*$this->levelCoeff();
				$this->statValues[45] = 7941*$this->levelCoeff();
				
				// Talents 1
				if ($this->talentid==1)
					$this->statValues[4] += ceil($this->statValues[4]*0.04); // T1
				if ($this->talentid==2)
					$this->statValues[4] += ceil($this->statValues[4]*0.2); // T1
				if ($this->talentid==3)
					$this->statValues[4] += ceil($this->statValues[4]*0.06); // T1
			
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.015974025;
				$this->statValues[38] += ceil($this->statValues[3]*(2.0-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.012207792, 2);
				if ($this->raceid==3)
					$this->statValues[13] += 2;
				
				// Talents 2
				if ($this->talentid!=3){
					$this->statValues[19] += 5;
				}
				if ($this->talentid==1){
					$this->statValues[7] += ceil($this->statValues[7]*0.04);
					$this->statValues[57] += 34;
					$this->statValues[58] += 253;
				}
				if ($this->talentid==2){
					$this->statValues[16] += 3;
					$this->statValues[19] += 5;
				}
				if ($this->talentid==3){
					$this->statValues[26] += 5;
					$this->statValues[13] += 5;
					$this->statValues[38] += ceil($this->statValues[38]*0.1);
					$this->statValues[7] += ceil($this->statValues[7]*0.09);
					$this->statValues[57] += 51;
				}
				
				$defense = $this->statValues[12]-400; // Gotta add this for vanilla
				$this->statValues[13] += $defense*0.008;
				$this->statValues[14] += $defense*0.008;
				$this->statValues[26] += $defense*0.008;
				
				$this->statValues[15] += $this->statValues[4]*0.5;
				
				if ($this->talentid==3){
					$this->statValues[15] += ceil($this->statValues[15]*0.3);
				}
				
				if ($this->raceid==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05);
				if ($this->raceid==1){
					$this->statValues[57] += 25.5;
					$this->statValues[6] = ceil($this->statValues[6]*1.03);
				}
				if ($this->raceid==5){
					$this->statValues[57] += 25.5;
				}
				if ($this->raceid==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] = 100;
				break;
			case 2 :
				// Taking blood elf rogue stats
				// haste scales 0.050875 per point
				$this->powerbartype = "energy";
				$this->statValues[16] = $this->statValues[16]*0.030470588;
				$this->statValues[19] = $this->statValues[19]*0.021730769;
				$this->statValues[19] += -0.298;
				$this->statValues[14] += 5;
				$this->statValues[13] += 2.1044;
				$this->statValues[3] += 189*$this->levelCoeff();
				$this->statValues[4] += 113*$this->levelCoeff();
				$this->statValues[5] += 43*$this->levelCoeff();
				$this->statValues[6] += 71*$this->levelCoeff();
				$this->statValues[7] += 109*$this->levelCoeff();
				$this->statValues[24] += 140*$this->levelCoeff();
				if ($this->raceid==1){
					$this->statValues[57] += 25.5;
					$this->statValues[6] = ceil($this->statValues[6]*1.03);
				}
				if ($this->raceid==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05);
				if ($this->raceid==3)
					$this->statValues[13] += 2;
				
				if ($this->talentid==3)
					$this->statValues[3] += ceil($this->statValues[3]*0.15);
				$this->statValues[24] += $this->statValues[3]+$this->statValues[4];
				
				$this->statValues[19] += 5;
				$this->statValues[16] += 5;
				if ($this->talentid==2){
					// 5% dagger and fist weapon crit
					$this->statValues[13] += 6;
					$this->statValues[58] += 304;
					$this->statValues[57] += 85;
					$this->statValues[24] += ceil($this->statValues[24]*0.06);
				}
				if ($this->talentid==3){
					$this->statValues[55] += 126;
					$this->statValues[24] += ceil($this->statValues[24]*0.1);
					
				}
				
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[19] += round($this->statValues[3]*0.012, 2);
				$this->statValues[13] += round($this->statValues[3]*0.020823529, 2);
				$this->statValues[45] = 7424*$this->levelCoeff();
				$this->statValues[46] = 100;
				break;
			case 3 :
				// Taking troll priest stats
				// spellhaste castings speed 0.0625% per point
				$this->statValues[16] = $this->statValues[16]*0.030470588;
				$this->statValues[19] = $this->statValues[19]*0.021730769;
				$this->statValues[21] = $this->statValues[21]*0.021730769;
				$this->statValues[18] = $this->statValues[18]*0.038117647;
				
				$this->statValues[19] += 3.182;
				$this->statValues[21] += 1.23228;
				$this->statValues[13] += 3.41;
				
				$this->statValues[3] += 51*$this->levelCoeff();
				$this->statValues[4] += 43*$this->levelCoeff();
				$this->statValues[5] += 174*$this->levelCoeff();
				$this->statValues[6] += 191*$this->levelCoeff();
				$this->statValues[7] += 67*$this->levelCoeff();
				$this->statValues[24] += -10*$this->levelCoeff();
				$this->statValues[45] = 5710*$this->levelCoeff();
				
				if ($this->raceid==1)
					$this->statValues[6] = ceil($this->statValues[6]*1.03);
				// Talents 1 
				if ($this->talentid!=3)
					$this->statValues[21] += 5;
				if ($this->talentid==1){
					$this->statValues[5] += ceil($this->statValues[5]*0.15);
					$this->statValues[6] += ceil($this->statValues[6]*0.06);
					$this->statValues[59] += 196;
					$this->statValues[22] += ceil($this->statValues[22]*0.04);
					$this->statValues[23] += ceil($this->statValues[23]*0.04);
					$this->statValues[21] += 3;
				}
				if ($this->talentid==2){
					$this->statValues[22] += ceil($this->statValues[6]*0.25);
					$this->statValues[23] += ceil($this->statValues[6]*0.25);
					$this->statValues[23] += ceil($this->statValues[23]*0.1);
					$this->statValues[23] += ceil($this->statValues[23]*0.03);
				}
				if ($this->talentid==3){
					$this->statValues[52] += ceil($this->statValues[22]*0.1); // 10% Shadow damage
					$this->statValues[18] += 3;
					//$this->statValues[21] += 4; // Gedankenschmelzen
					$this->statValues[52] += ceil($this->statValues[22]*0.15); // Schattengestalt
					$this->statValues[22] += ceil($this->statValues[6]*0.2);
					$this->statValues[23] += ceil($this->statValues[6]*0.2);
				}
				
				$this->statValues[24] += $this->statValues[4];
				$this->statValues[19] += $this->statValues[3]*0.01917647;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.016823529, 2);
				$this->statValues[21] += $this->statValues[5]*0.0060214;
				
				$this->statValues[46] += 3583*$this->levelCoeff();
				
				if ($this->raceid==3)
					$this->statValues[13] += 2;
				break;
			case 4 :
				// Taking tauren Hunter stats
				// haste 0.063375% per point ranged haste // Guess it scales for all classes the same
				$this->statValues[16] = $this->statValues[16]*0.030470588;
				$this->statValues[19] = $this->statValues[19]*0.021730769;
				$this->statValues[21] = $this->statValues[21]*0.021730769;
				$this->statValues[18] = $this->statValues[18]*0.038117647;
				
				$this->statValues[19] += -1.559;
				$this->statValues[13] = 0; // That must be wrong
				$this->statValues[21] = 3.6;
				$this->statValues[14] += 5;
				
				$this->statValues[3] += 193*$this->levelCoeff();
				$this->statValues[4] += 71*$this->levelCoeff();
				$this->statValues[5] += 93*$this->levelCoeff();
				$this->statValues[6] += 97*$this->levelCoeff();
				$this->statValues[7] += 127*$this->levelCoeff();
				$this->statValues[24] += 150*$this->levelCoeff();
				$this->statValues[45] = 7144*$this->levelCoeff();
				
				// Talents
				if ($this->talentid==2){
					$this->statValues[3] += ceil($this->statValues[3]*0.04);
					$this->statValues[5] += ceil($this->statValues[5]*0.04);
					$this->statValues[19] += 5;
				}
				if ($this->talentid==3){
					$this->statValues[14] += 3;
					$this->statValues[7] += ceil($this->statValues[7]*0.1);
					$this->statValues[19] += 3;
					$this->statValues[24] += ceil($this->statValues[7]*0.3);
					$this->statValues[3] += ceil($this->statValues[3]*0.15);
					$this->statValues[3] += ceil($this->statValues[3]*0.03);
				}
				$this->statValues[19] += 5;
				$this->statValues[24] += $this->statValues[5];
				if ($this->talentid==1){
					$this->statValues[7] += ceil($this->statValues[7]*0.05);
					// $this->statValues[13] += 3;
					$this->statValues[58] += 487;
				}
				
				$this->statValues[24] += $this->statValues[3]; //ranged attack power
				$this->statValues[19] += $this->statValues[3]*0.012117647;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				//$this->statValues[13] += round($this->statValues[3]*0.04, 2);
				$this->statValues[21] += $this->statValues[5]*0.006;
				
				if ($this->raceid==3)
					$this->statValues[13] += 2;
				if ($this->raceid==7)
					$this->statValues[19] += 1;
				if ($this->raceid==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] += 4766*$this->levelCoeff();
				break;
			case 5 :
				// Taking tauren druid stats
				$this->statValues[13] = $this->statValues[13]*0.022125;
				
				$this->statValues[16] = $this->statValues[16]*0.030470588;
				$this->statValues[19] = $this->statValues[19]*0.021730769;
				$this->statValues[21] = $this->statValues[21]*0.021730769;
				$this->statValues[18] = $this->statValues[18]*0.038117647;
				
				$this->statValues[19] += 6.83524;
				$this->statValues[21] += 1.849;
				$this->statValues[13] += 3.59;
				$this->statValues[14] = 0;
				$this->statValues[15] = 0;
				$this->statValues[26] = 0;
				
				$this->statValues[3] += 87*$this->levelCoeff();
				$this->statValues[4] += 86*$this->levelCoeff();
				$this->statValues[5] += 143*$this->levelCoeff();
				$this->statValues[6] += 159*$this->levelCoeff();
				$this->statValues[7] += 97*$this->levelCoeff();
				$this->statValues[24] += -20*$this->levelCoeff();
				$this->statValues[45] = 7237*$this->levelCoeff();
				
				// Talents 1
				if ($this->talentid==1){
					$this->statValues[59] += 98;
					$this->statValues[22] += ceil($this->statValues[5]*0.12);
					$this->statValues[18] += 4;
					$this->statValues[22] += ceil($this->statValues[22]*0.06);
				}
				if ($this->talentid==2){
					$this->statValues[3] += ceil($this->statValues[3]*0.06);
					$this->statValues[4] += ceil($this->statValues[4]*0.06);
					$this->statValues[5] += ceil($this->statValues[5]*0.06);
					$this->statValues[6] += ceil($this->statValues[6]*0.06);
					$this->statValues[7] += ceil($this->statValues[7]*0.06);
					$this->statValues[5] += ceil($this->statValues[5]*0.2);
				}
				if ($this->talentid==3){
					$this->statValues[23] += ceil($this->statValues[23]*0.1);
					$this->statValues[21] += 3;
					$this->statValues[6] += ceil($this->statValues[6]*0.15);
					$this->statValues[59] += 327;
				}
				
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.01948051;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.021168831, 2);
				
				$this->statValues[21] += $this->statValues[5]*0.006;
				
				$defense = $this->statValues[12]-400; // Gotta add this for vanilla
				$this->statValues[13] += $defense*0.008;
				
				// Talents 2
				if ($this->talentid==2){
					$this->statValues[38] += ceil($this->statValues[38]*0.12);
					$this->statValues[57] += 85;
				}
				
				if ($this->raceid==3)
					$this->statValues[13] += 2;
				if ($this->raceid==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] += 3216*$this->levelCoeff();
				break;
			case 6 :
				// Taking troll mage stats
				$this->statValues[16] = $this->statValues[16]*0.030470588;
				$this->statValues[19] = $this->statValues[19]*0.021730769;
				$this->statValues[21] = $this->statValues[21]*0.021730769;
				$this->statValues[18] = $this->statValues[18]*0.038117647;
				
				$this->statValues[19] += 3.44;
				$this->statValues[21] += 0.872;
				$this->statValues[13] = 3.65;
				
				$this->statValues[3] += 43*$this->levelCoeff();
				$this->statValues[4] += 36*$this->levelCoeff();
				$this->statValues[5] += 181*$this->levelCoeff();
				$this->statValues[6] += 184*$this->levelCoeff();
				$this->statValues[7] += 59*$this->levelCoeff();
				$this->statValues[24] += -10*$this->levelCoeff();
				$this->statValues[45] = 6783*$this->levelCoeff();
				
				// Talents 1
				$this->statValues[18] += 3;
				if ($this->talentid==1){
					$this->statValues[6] += ceil($this->statValues[6]*0.12);
					$this->statValues[5] += ceil($this->statValues[5]*0.15);
					$this->statValues[21] += 3;
					$this->statValues[22] += ceil($this->statValues[5]*0.15);
					$this->statValues[59] += 196;
					$this->statValues[21] += 3; // Verbrennung
				}
				if ($this->talentid==2){
					$this->statValues[21] += 3;
					$this->statValues[21] += 6;
					$this->statValues[22] += ceil($this->statValues[22]*0.03);
					$this->statValues[50] += ceil($this->statValues[22]*0.1); // 10% Firedamage
					$this->statValues[21] += 3;
				}
				if ($this->talentid==3){
					$this->statValues[18] += 3;
					$this->statValues[48] += ceil($this->statValues[22]*0.06); // 6% Frostdamage?
					$this->statValues[21] += 3;
					$this->statValues[48] += ceil($this->statValues[22]*0.05); // 5% Frostdamage?
				}
				
				$this->statValues[24] += $this->statValues[4];
				$this->statValues[19] += $this->statValues[3]*0.019480519;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.017142857, 2);
				$this->statValues[21] += $this->statValues[5]*0.006175;
				
				$this->statValues[46] += 2988*$this->levelCoeff();
				if ($this->raceid==3)
					$this->statValues[13] += 1;
				if ($this->raceid==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05);
				if ($this->raceid==1)
					$this->statValues[6] = ceil($this->statValues[6]*1.03);
				
				// Talents 2
				
				
				$this->statValues[14] = 0;
				$this->statValues[15] = 0;
				break;
			case 7 :
				// Taking human warlock stats
				$this->statValues[16] = $this->statValues[16]*0.030470588;
				$this->statValues[19] = $this->statValues[19]*0.021730769;
				$this->statValues[21] = $this->statValues[21]*0.021730769;
				$this->statValues[18] = $this->statValues[18]*0.038117647;
				
				$this->statValues[19] += 2.6274;
				$this->statValues[21] += 1.668;
				$this->statValues[13] += 2.4123;
				
				$this->statValues[3] += 67*$this->levelCoeff();
				$this->statValues[4] += 59*$this->levelCoeff();
				$this->statValues[5] += 159*$this->levelCoeff();
				$this->statValues[6] += 175*$this->levelCoeff();
				$this->statValues[7] += 97*$this->levelCoeff();
				$this->statValues[24] += -10*$this->levelCoeff();
				$this->statValues[45] = 6956*$this->levelCoeff();
				
				// Talents 1
				$this->statValues[21] += 3;
				if ($this->talentid==1){
					$this->statValues[52] += ceil($this->statValues[22]*0.15); // Schattenbeherschung
					$this->statValues[21] += 9; // Nur regelmäßige
					$this->statValues[22] += ceil($this->statValues[22]*0.03);
				}
				if ($this->talentid==2){
					$this->statValues[7] += ceil($this->statValues[7]*0.12);
					// 12% zm for stamina of active pet
					$this->statValues[21] += 10;
					$this->statValues[22] += ceil($this->statValues[22]*0.1);
				}
				if ($this->talentid==3)
					$this->statValues[21] += 8;
				
				$this->statValues[24] += $this->statValues[4];
				$this->statValues[19] += $this->statValues[3]*0.019740259;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.016883116, 2);
				$this->statValues[21] += $this->statValues[21]*0.006175;
				
				if ($this->raceid==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05); // Gnome intellect bonus
				if ($this->raceid==1)
					$this->statValues[6] = ceil($this->statValues[6]*1.03);
				
				$this->statValues[46] += 2576*$this->levelCoeff();
				
				$this->statValues[14] = 0;
				$this->statValues[15] = 0;
				break;
			case 8 :
				// Taking bloodelf paladin stats (80)
				// Tank stats
				$this->statValues[13] = $this->statValues[13]*0.022125;
				$this->statValues[14] = $this->statValues[14]*0.022068965;
				$this->statValues[26] = $this->statValues[26]*0.022068965; // CHANGE THIS FOR TBC! AND VANILLA!
				
				$this->statValues[16] = $this->statValues[16]*0.030470588;
				$this->statValues[19] = $this->statValues[19]*0.021730769;
				$this->statValues[21] = $this->statValues[21]*0.021730769;
				$this->statValues[18] = $this->statValues[18]*0.038117647;
				
				$this->statValues[19] += 3.3262156;
				$this->statValues[21] += 3.3338;
				$this->statValues[13] += 3.45;
				$this->statValues[14] = 5;
				$this->statValues[26] = 5;
				
				$this->statValues[3] += 92*$this->levelCoeff();
				$this->statValues[4] += 147*$this->levelCoeff();
				$this->statValues[5] += 102*$this->levelCoeff();
				$this->statValues[6] += 104*$this->levelCoeff();
				$this->statValues[7] += 141*$this->levelCoeff();
				$this->statValues[24] += 220*$this->levelCoeff();
				$this->statValues[45] = 6754*$this->levelCoeff();
				
				// TAlents 1
				$this->statValues[5] += ceil($this->statValues[5]*0.1);
				if ($this->talentid!=1)
					$this->statValues[4] += ceil($this->statValues[4]*0.15);
				
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.019215686;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.012207792, 2);
				$this->statValues[21] += $this->statValues[5]*0.006; // REPLACE IT WITH INT! TBC!
				
				// Talents 2
				if ($this->talentid==1){
					$this->statValues[21] += 5;
					$this->statValues[22] += ceil($this->statValues[5]*0.2);
					$this->statValues[23] += ceil($this->statValues[5]*0.2);
				}
				if ($this->talentid==2){
					$this->statValues[13] += 5;
					$this->statValues[14] += 5;
					$this->statValues[38] += ceil($this->statValues[38]*0.1);
					$this->statValues[7] += ceil($this->statValues[7]*0.04);
					$this->statValues[22] += ceil($this->statValues[4]*0.6);
					$this->statValues[23] += ceil($this->statValues[4]*0.6);
				}
				if ($this->talentid==3){
					$this->statValues[14] += 1;
					$this->statValues[19] += 8;
					$this->statValues[21] += 8;
					$this->statValues[58] += 76;
					$this->statValues[59] += 98;
					$this->statValues[22] += ceil($this->statValues[24]*0.3);
					$this->statValues[23] += ceil($this->statValues[24]*0.3);
				}
				
				$defense = $this->statValues[12]-400; // Gotta add this for vanilla
				$this->statValues[13] += $defense*0.00740740;
				$this->statValues[14] += $defense*0.00740740;
				$this->statValues[26] += $defense*0.00740740;
				
				$this->statValues[15] += $this->statValues[4]*0.5;
				if ($this->raceid==1){
					$this->statValues[57] += 25.5;
					$this->statValues[6] = ceil($this->statValues[6]*1.03);
				}
				$this->statValues[46] += 4114*$this->levelCoeff();
				break;
			case 9 :
				// Taking Troll shamen stats
				// Tank stats
				$this->statValues[13] = $this->statValues[13]*0.022125;
				$this->statValues[14] = $this->statValues[14]*0.022068965;
				$this->statValues[26] = $this->statValues[26]*0.022068965; // CHANGE THIS FOR TBC! AND VANILLA!
				
				$this->statValues[16] = $this->statValues[16]*0.030470588;
				$this->statValues[19] = $this->statValues[19]*0.021730769;
				$this->statValues[21] = $this->statValues[21]*0.021730769;
				$this->statValues[18] = $this->statValues[18]*0.038117647;
				
				$this->statValues[19] += 2.9;
				$this->statValues[21] += 2.2;
				$this->statValues[13] += 2.1;
				$this->statValues[14] = 5;
				$this->statValues[26] = 5;
				
				$this->statValues[3] += 71*$this->levelCoeff();
				$this->statValues[4] += 121*$this->levelCoeff();
				$this->statValues[5] += 141*$this->levelCoeff();
				$this->statValues[6] += 145*$this->levelCoeff();
				$this->statValues[7] += 135*$this->levelCoeff();
				$this->statValues[24] += 90*$this->levelCoeff();
				$this->statValues[45] = 6759*$this->levelCoeff();
				
				// Talents 1
				$this->statValues[5] += ceil($this->statValues[5]*0.05);
				$this->statValues[21] += 5;
				$this->statValues[19] += 5;
				if ($this->talentid==1){
					$this->statValues[51] += ceil($this->statValues[22]*0.05); // 5% more dmg by main spells
					$this->statValues[21] += 5;
					$this->statValues[0] += ceil($this->statValues[5]*0.12);
					$this->statValues[21] += 3;
				}
				if ($this->talentid==2){
					$this->statValues[24] += $this->statValues[5];
					$this->statValues[57] += 76.5;
					$this->statValues[16] += 6;
				}
				if ($this->talentid==3){
					$this->statValues[21] += 5;
					$this->statValues[23] += ceil($this->statValues[23]*0.1);
					$this->statValues[23] += ceil($this->statValues[5]*0.15);
				}
				
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.012077922;
				$this->statValues[21] += $this->statValues[5]*0.006;
				$this->statValues[38] += ceil($this->statValues[3]*2);
				$this->statValues[13] += round($this->statValues[3]*0.016753246, 2);
				$this->statValues[15] += $this->statValues[4]*0.5;
				
				// Talents 2
				if ($this->talentid==2){
					$this->statValues[24] += ceil($this->statValues[24]*0.12);
					$this->statValues[22] += ceil($this->statValues[24]*0.3);
				}
				
				if ($this->raceid==5)
					$this->statValues[57] += 25.5;
				if ($this->raceid==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] = 4116*$this->levelCoeff();
				break;
			case 10 :
				// Taking human warrior stats (80)
				// Every haste point equals 0.063396226%
				$this->powerbartype = "rune";
				// Tank stats
				// Strength scales as parry rating
				$this->statValues[14] += $this->statValues[4]*0.25;
				
				$this->statValues[13] = $this->statValues[13]*0.022125;
				$this->statValues[14] = $this->statValues[14]*0.022068965;
				
				$this->statValues[16] = $this->statValues[16]*0.030470588;
				$this->statValues[19] = $this->statValues[19]*0.021730769;
				
				$this->statValues[19] += 3.191;
				$this->statValues[14] += 5.03;
				$this->statValues[13] += 3.62;
				
				$this->statValues[26] = 0;
				$this->statValues[15] = 0;
				
				$this->statValues[3] += 112*$this->levelCoeff();
				$this->statValues[4] += 180*$this->levelCoeff();
				$this->statValues[5] += 35*$this->levelCoeff();
				$this->statValues[6] += 61*$this->levelCoeff();
				$this->statValues[7] += 160*$this->levelCoeff();
				$this->statValues[24] += 220*$this->levelCoeff();
				$this->statValues[45] = 7941*$this->levelCoeff();
				
				// Talents 1
				$this->statValues[16] += 3;
				if ($this->talentid==1){
					$this->statValues[19] += 9;
					$this->statValues[19] += 5;
					$this->statValues[21] += 5;
					$this->statValues[4] += ceil($this->statValues[4]*0.06);
					$this->statValues[7] += ceil($this->statValues[7]*0.03);
					$this->statValues[57] += 51;
					$this->statValues[4] += ceil($this->statValues[4]*0.02);
					$this->statValues[55] += 140;
				}
				if ($this->talentid==2){
					$this->statValues[16] += 3;
					$this->statValues[21] += 3;
					$this->statValues[19] += 3;
					$this->statValues[58] += 608;
					$this->statValues[57] += 42.5;
				}
				if ($this->talentid==3){
					$this->statValues[21] += 6;
					$this->statValues[4] += ceil($this->statValues[4]*0.03);
					$this->statValues[19] += 3;
					$this->statValues[21] += 3;
					$this->statValues[57] += 42.5;
				}
			
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.015974025;
				$this->statValues[38] += ceil($this->statValues[3]*(2.0-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.012207792, 2);
				if ($this->raceid==3)
					$this->statValues[13] += 2;
				
				// Talents 2
				if ($this->talentid!=3){
					$this->statValues[38] += ceil($this->statValues[38]*0.1);
				}
				if ($this->talentid==1){
					$this->userData[24] += ceil($this->statValues[38]/180*5);
					$this->userData[24] += ceil($this->userData[24]*0.1);
				}
				if ($this->talentid==2){
					$this->statValues[48] += ceil($this->statValues[22]*0.1);
					$this->statValues[52] += ceil($this->statValues[22]*0.1);
				}
				if ($this->talentid==3){
					$this->statValues[24] += ceil($this->statValues[24]*0.2); // Angriffskraftbonus von Zaubern?
				}
				
				
				$defense = $this->statValues[12]-400; // Gotta add this for vanilla
				$this->statValues[13] += $defense*0.008;
				$this->statValues[14] += $defense*0.008;
				
				if ($this->talentid==3){
					$this->statValues[15] += ceil($this->statValues[15]*0.3);
				}
				
				if ($this->raceid==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05);
				if ($this->raceid==1){
					$this->statValues[57] += 25.5;
					$this->statValues[6] = ceil($this->statValues[6]*1.03);
				}
				if ($this->raceid==5){
					$this->statValues[57] += 25.5;
				}
				if ($this->raceid==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] = 100;
				break;
		}
		$this->statValues[45] += $this->statValues[7]*10;
		if ($this->classid!=2 && $this->classid!=1){
			$this->statValues[46] += $this->statValues[5]*15;
			// Mana regen outfight
			$this->statValues[54] += $this->statValues[46]*0.00004822*$this->statValues[6];
			if ($this->classid==7 && $this->talentid==2){
				$this->statValues[46] += ceil($this->statValues[46]*0.03);
				$this->statValues[45] += ceil($this->statValues[45]*0.03);
			}
		}
		
		// Deprecated?
		if ($this->raceid==9){
			$this->statValues[13] += 1;
			$this->statValues[18] += 1;
		}
	}
	
	private function buildSocketArr($num){
		return '
			<option value="0"'.($r = ($this->socketids[$num]==0) ? "selected" : "").'>No socket</option>
			<option value="2690"'.($r = ($this->socketids[$num]==2690) ? "selected" : "").'>+13 Healing and +5 Spell Damage</option>
			<option value="2705"'.($r = ($this->socketids[$num]==2705) ? "selected" : "").'>+7 Healing +3 Spell Damage and +3 Intellect</option>
			<option value="2707"'.($r = ($this->socketids[$num]==2707) ? "selected" : "").'>+1 Mana every 5 Sec and +3 Intellect</option>
			<option value="2708"'.($r = ($this->socketids[$num]==2708) ? "selected" : "").'>+4 Spell Damage and +4 Stamina</option>
			<option value="2709"'.($r = ($this->socketids[$num]==2709) ? "selected" : "").'>+7 Healing +3 Spell Damage and +1 Mana per 5 Secon</option>
			<option value="2725"'.($r = ($this->socketids[$num]==2725) ? "selected" : "").'>+8 Strength</option>
			<option value="2726"'.($r = ($this->socketids[$num]==2726) ? "selected" : "").'>+8 Agility</option>
			<option value="2727"'.($r = ($this->socketids[$num]==2727) ? "selected" : "").'>+18 Healing and +6 Spell Damage</option>
			<option value="2728"'.($r = ($this->socketids[$num]==2728) ? "selected" : "").'>+9 Spell Damage</option>
			<option value="2730"'.($r = ($this->socketids[$num]==2730) ? "selected" : "").'>+8 Dodge Rating</option>
			<option value="2731"'.($r = ($this->socketids[$num]==2731) ? "selected" : "").'>+12 Stamina</option>
			<option value="2732"'.($r = ($this->socketids[$num]==2732) ? "selected" : "").'>+8 Spirit</option>
			<option value="2734"'.($r = ($this->socketids[$num]==2734) ? "selected" : "").'>+8 Intellect</option>
			<option value="2735"'.($r = ($this->socketids[$num]==2735) ? "selected" : "").'>+8 Critical Strike Rating</option>
			<option value="2736"'.($r = ($this->socketids[$num]==2736) ? "selected" : "").'>+8 Spell Critical Rating</option>
			<option value="2738"'.($r = ($this->socketids[$num]==2738) ? "selected" : "").'>+4 Strength and +6 Stamina</option>
			<option value="2739"'.($r = ($this->socketids[$num]==2739) ? "selected" : "").'>+4 Agility and +6 Stamina</option>
			<option value="2740"'.($r = ($this->socketids[$num]==2740) ? "selected" : "").'>+5 Spell Damage and +6 Stamina</option>
			<option value="2741"'.($r = ($this->socketids[$num]==2741) ? "selected" : "").'>+9 Healing +3 Spell Damage and +2 Mana every 5 sec</option>
			<option value="2742"'.($r = ($this->socketids[$num]==2742) ? "selected" : "").'>+9 Healing +3 Spell Damage and +4 Intellect</option>
			<option value="2743"'.($r = ($this->socketids[$num]==2743) ? "selected" : "").'>+4 Defense Rating and +6 Stamina</option>
			<option value="2744"'.($r = ($this->socketids[$num]==2744) ? "selected" : "").'>+4 Intellect and +2 Mana every 5 seconds</option>
			<option value="2753"'.($r = ($this->socketids[$num]==2753) ? "selected" : "").'>+4 Critical Strike Rating and +4 Strength</option>
			<option value="2755"'.($r = ($this->socketids[$num]==2755) ? "selected" : "").'>+3 Hit Rating and +3 Agility</option>
			<option value="2756"'.($r = ($this->socketids[$num]==2756) ? "selected" : "").'>+4 Hit Rating and +4 Agility</option>
			<option value="2758"'.($r = ($this->socketids[$num]==2758) ? "selected" : "").'>+4 Critical Strike Rating and +6 Stamina</option>
			<option value="2761"'.($r = ($this->socketids[$num]==2761) ? "selected" : "").'>+4 Spell Critical Rating and +5 Spell Damage</option>
			<option value="2763"'.($r = ($this->socketids[$num]==2763) ? "selected" : "").'>+4 Spell Critical Rating and +5 Spell Penetration</option>
			<option value="2764"'.($r = ($this->socketids[$num]==2764) ? "selected" : "").'>+8 Hit Rating</option>
			<option value="2829"'.($r = ($this->socketids[$num]==2829) ? "selected" : "").'>+24 Attack Power and Minor Run Speed Increase</option>
			<option value="2831"'.($r = ($this->socketids[$num]==2831) ? "selected" : "").'>+18 Stamina & 5% Stun Resist</option>
			<option value="2832"'.($r = ($this->socketids[$num]==2832) ? "selected" : "").'>+26 Healing +9 Spell Damage and 2% Reduced Threat</option>
			<option value="2833"'.($r = ($this->socketids[$num]==2833) ? "selected" : "").'>+12 Defense Rating & Chance to Restore Health on h</option>
			<option value="2835"'.($r = ($this->socketids[$num]==2835) ? "selected" : "").'>+12 Intellect & Chance to restore mana on spellcas</option>
			<option value="2913"'.($r = ($this->socketids[$num]==2913) ? "selected" : "").'>+10 Critical Strike Rating</option>
			<option value="2942"'.($r = ($this->socketids[$num]==2942) ? "selected" : "").'>+6 Critical Strike Rating</option>
			<option value="2945"'.($r = ($this->socketids[$num]==2945) ? "selected" : "").'>+20 Attack Power</option>
			<option value="2946"'.($r = ($this->socketids[$num]==2946) ? "selected" : "").'>+10 Attack Power</option>
			<option value="2958"'.($r = ($this->socketids[$num]==2958) ? "selected" : "").'>+9 Healing and +3 Spell Damage</option>
			<option value="2960"'.($r = ($this->socketids[$num]==2960) ? "selected" : "").'>+8 Attack Power</option>
			<option value="2971"'.($r = ($this->socketids[$num]==2971) ? "selected" : "").'>+12 Attack Power</option>
			<option value="3046"'.($r = ($this->socketids[$num]==3046) ? "selected" : "").'>+11 Healing +4 Spell Damage and +4 Intellect</option>
			<option value="3047"'.($r = ($this->socketids[$num]==3047) ? "selected" : "").'>+6 Stamina and +5 Spell Crit Rating</option>
			<option value="3048"'.($r = ($this->socketids[$num]==3048) ? "selected" : "").'>+5 Agility and +6 Stamina</option>
			<option value="3049"'.($r = ($this->socketids[$num]==3049) ? "selected" : "").'>+5 Critical Strike Rating and +2 mana per 5 sec.</option>
			<option value="3050"'.($r = ($this->socketids[$num]==3050) ? "selected" : "").'>+6 Spell Damage and +4 Intellect </option>
			<option value="3053"'.($r = ($this->socketids[$num]==3053) ? "selected" : "").'>+5 Defense Rating and +4 Dodge Rating</option>
			<option value="3054"'.($r = ($this->socketids[$num]==3054) ? "selected" : "").'>+6 Spell Damage and +6 Stamina</option>
			<option value="3055"'.($r = ($this->socketids[$num]==3055) ? "selected" : "").'>+5 Agility and +4 Hit Rating</option>
			<option value="3060"'.($r = ($this->socketids[$num]==3060) ? "selected" : "").'>+5 Dodge Rating and +6 Stamina</option>
			<option value="3061"'.($r = ($this->socketids[$num]==3061) ? "selected" : "").'>+6 Spell Damage and +5 Spell Hit Rating</option>
			<option value="3062"'.($r = ($this->socketids[$num]==3062) ? "selected" : "").'>+6 Critical Rating and +5 Dodge Rating</option>
			<option value="3064"'.($r = ($this->socketids[$num]==3064) ? "selected" : "").'>+5 Spirit and +9 Healing +3 Spell Damage</option>
			<option value="3066"'.($r = ($this->socketids[$num]==3066) ? "selected" : "").'>+6 Spell Damage and +5 Spell Penetration</option>
			<option value="3067"'.($r = ($this->socketids[$num]==3067) ? "selected" : "").'>+10 Attack Power and +6 Stamina</option>
			<option value="3068"'.($r = ($this->socketids[$num]==3068) ? "selected" : "").'>+5 Dodge Rating and +4 Hit Rating</option>
			<option value="3070"'.($r = ($this->socketids[$num]==3070) ? "selected" : "").'>+8 Attack Power and +5 Critical Rating</option>
			<option value="3072"'.($r = ($this->socketids[$num]==3072) ? "selected" : "").'>+5 Strength and +4 Critical Rating</option>
			<option value="3081"'.($r = ($this->socketids[$num]==3081) ? "selected" : "").'>+11 Healing +4 Spell Damage and +4 Spell Critical </option>
			<option value="3086"'.($r = ($this->socketids[$num]==3086) ? "selected" : "").'>+11 Healing +4 Spell Damage and 2 mana per 5 sec.</option>
			<option value="3088"'.($r = ($this->socketids[$num]==3088) ? "selected" : "").'>+5 Spell Hit Rating and +6 Stamina</option>
			<option value="3089"'.($r = ($this->socketids[$num]==3089) ? "selected" : "").'>+5 Spell Hit Rating and 2 mana per 5 sec.</option>
			<option value="3091"'.($r = ($this->socketids[$num]==3091) ? "selected" : "").'>+5 Spell Critical Rating and +5 Spell Penetration</option>
			<option value="3099"'.($r = ($this->socketids[$num]==3099) ? "selected" : "").'>+6 Spell Damage and +6 Stamina</option>
			<option value="3100"'.($r = ($this->socketids[$num]==3100) ? "selected" : "").'>+11 Healing +4 Spell Damage and +6 Stamina</option>
			<option value="3105"'.($r = ($this->socketids[$num]==3105) ? "selected" : "").'>+8 Spell Hit Rating</option>
			<option value="3111"'.($r = ($this->socketids[$num]==3111) ? "selected" : "").'>+4 Spell Hit Rating and +5 Spell Damage</option>
			<option value="3115"'.($r = ($this->socketids[$num]==3115) ? "selected" : "").'>+10 Strength</option>
			<option value="3116"'.($r = ($this->socketids[$num]==3116) ? "selected" : "").'>+10 Agility</option>
			<option value="3117"'.($r = ($this->socketids[$num]==3117) ? "selected" : "").'>+22 Healing and +8 Spell Damage</option>
			<option value="3118"'.($r = ($this->socketids[$num]==3118) ? "selected" : "").'>+12 Spell Damage</option>
			<option value="3120"'.($r = ($this->socketids[$num]==3120) ? "selected" : "").'>+10 Dodge Rating</option>
			<option value="3121"'.($r = ($this->socketids[$num]==3121) ? "selected" : "").'>+10 Parry Rating</option>
			<option value="3122"'.($r = ($this->socketids[$num]==3122) ? "selected" : "").'>+15 Stamina</option>
			<option value="3127"'.($r = ($this->socketids[$num]==3127) ? "selected" : "").'>+10 Critical Strike Rating</option>
			<option value="3128"'.($r = ($this->socketids[$num]==3128) ? "selected" : "").'>+10 Hit Rating</option>
			<option value="3133"'.($r = ($this->socketids[$num]==3133) ? "selected" : "").'>+5 Strength and +7 Stamina</option>
			<option value="3134"'.($r = ($this->socketids[$num]==3134) ? "selected" : "").'>+5 Agility and +7 Stamina</option>
			<option value="3137"'.($r = ($this->socketids[$num]==3137) ? "selected" : "").'>+6 Spell Damage and +7 Stamina</option>
			<option value="3138"'.($r = ($this->socketids[$num]==3138) ? "selected" : "").'>+11 Healing +4 Spell Damage and +2 Mana every 5 se</option>
			<option value="3139"'.($r = ($this->socketids[$num]==3139) ? "selected" : "").'>+5 Critical Strike Rating and +5 Strength</option>
			<option value="3140"'.($r = ($this->socketids[$num]==3140) ? "selected" : "").'>+5 Spell Critical Rating and +6 Spell Damage</option>
			<option value="3142"'.($r = ($this->socketids[$num]==3142) ? "selected" : "").'>+5 Hit Rating and +5 Agility</option>
			<option value="3144"'.($r = ($this->socketids[$num]==3144) ? "selected" : "").'>+5 Critical Strike Rating and +10 Attack Power</option>
			<option value="3145"'.($r = ($this->socketids[$num]==3145) ? "selected" : "").'>+5 Defense Rating and +7 Stamina</option>
			<option value="3148"'.($r = ($this->socketids[$num]==3148) ? "selected" : "").'>+5 Critical Strike Rating and +7 Stamina</option>
			<option value="3154"'.($r = ($this->socketids[$num]==3154) ? "selected" : "").'>+12 Agility & 3% Increased Critical Damage</option>
			<option value="3201"'.($r = ($this->socketids[$num]==3201) ? "selected" : "").'>+7 Healing +3 Spell Damage and +3 Spirit</option>
			<option value="3202"'.($r = ($this->socketids[$num]==3202) ? "selected" : "").'>+9 Healing +3 Spell Damage and +4 Spirit</option>
			<option value="3211"'.($r = ($this->socketids[$num]==3211) ? "selected" : "").'>+26 Healing and +9 Spell Damage</option>
			<option value="3217"'.($r = ($this->socketids[$num]==3217) ? "selected" : "").'>+12 Spell Critical Rating</option>
			<option value="3220"'.($r = ($this->socketids[$num]==3220) ? "selected" : "").'>+12 Critical Strike Rating</option>
			<option value="3221"'.($r = ($this->socketids[$num]==3221) ? "selected" : "").'>+12 Defense Rating</option>
			<option value="3261"'.($r = ($this->socketids[$num]==3261) ? "selected" : "").'>+12 Spell Critical & 3% Increased Critical Damage</option>
			<option value="3280"'.($r = ($this->socketids[$num]==3280) ? "selected" : "").'>+4 Dodge Rating and +6 Stamina</option>
			<option value="3285"'.($r = ($this->socketids[$num]==3285) ? "selected" : "").'>+5 Spell Haste Rating and +7 Stamina</option>
			<option value="3286"'.($r = ($this->socketids[$num]==3286) ? "selected" : "").'>+5 Spell Haste Rating and +6 Spell Damage</option>
			<option value="3287"'.($r = ($this->socketids[$num]==3287) ? "selected" : "").'>+10 Spell Haste Rating</option>
		';
	}
	
	private function getSocketString($num){
		return '&sockets='.$this->socketids[$num*3-3+1].','.$this->socketids[$num*3-3+2].','.$this->socketids[$num*3-3+3];
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
					$this->statValues[13] += $this->enchTemplate[$effectids[$key]]->dodge*0.022068965;
					$this->statValues[15] += $this->enchTemplate[$effectids[$key]]->block;
					$this->statValues[26] += $this->enchTemplate[$effectids[$key]]->blockchance*0.022068965;
					$this->statValues[16] += $this->enchTemplate[$effectids[$key]]->hit*0.030470588;
					$this->statValues[18] += $this->enchTemplate[$effectids[$key]]->hit*0.038117647;
					$this->statValues[19] += $this->enchTemplate[$effectids[$key]]->crit*0.021730769;
					$this->statValues[21] += $this->enchTemplate[$effectids[$key]]->crit*0.021730769;
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
					$this->statValues[55] += $this->enchTemplate[$effectids[$key]]->armorpen;
					$this->statValues[56] += $this->enchTemplate[$effectids[$key]]->spellpen;
					$this->statValues[57] += $this->enchTemplate[$effectids[$key]]->expertise;
					$this->statValues[58] += $this->enchTemplate[$effectids[$key]]->haste;
					$this->statValues[59] += $this->enchTemplate[$effectids[$key]]->haste;
					$this->statValues[60] += $this->enchTemplate[$effectids[$key]]->resilience;
				}
			}
		}
		$this->statValues[57] = floor($this->statValues[57]/8.5);
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
							<option value="2583"'.($r = ($this->enchantids[1]==2583) ? "selected" : "").'>+10 Defense Rating/+10 Stamina/+15 Block Value</option>
							<option value="2841"'.($r = ($this->enchantids[1]==2841) ? "selected" : "").'>+10 Stamina</option>
							<option value="2999"'.($r = ($this->enchantids[1]==2999) ? "selected" : "").'>+16 Defense Rating and +17 Dodge Rating</option>
							<option value="3001"'.($r = ($this->enchantids[1]==3001) ? "selected" : "").'>+35 Healing +12 Spell Damage and 7 Mana Per 5 sec.</option>
							<option value="3002"'.($r = ($this->enchantids[1]==3002) ? "selected" : "").'>+22 Spell Power and +14 Spell Hit Rating</option>
							<option value="3003"'.($r = ($this->enchantids[1]==3003) ? "selected" : "").'>+34 Attack Power and +16 Hit Rating</option>
							<option value="3004"'.($r = ($this->enchantids[1]==3004) ? "selected" : "").'>+18 Stamina and +20 Resilience Rating</option>
							<option value="3008"'.($r = ($this->enchantids[1]==3008) ? "selected" : "").'>+20 Frost Resistance</option>
							<option value="3096"'.($r = ($this->enchantids[1]==3096) ? "selected" : "").'>+17 Strength and +16 Intellect</option>
						</select>
						<select name="soc1x1" class="dessocket">
							'.$this->buildSocketArr(1).'
						</select>
						<select name="soc1x2" class="dessocket">
							'.$this->buildSocketArr(2).'
						</select>
						<select name="soc1x3" class="dessocket">
							'.$this->buildSocketArr(3).'
						</select>
					</div>
					<div class="desRow">
						<div>Necklace</div>
						<input type="text" name="inv2" placeholder="Enter itemid" value="'.($r = ($this->items[2]) ? $this->items[2] : "").'" />
						<div class="placeholderElement"></div>
						<select name="soc2x1" class="dessocket">
							'.$this->buildSocketArr(4).'
						</select>
						<select name="soc2x2" class="dessocket">
							'.$this->buildSocketArr(5).'
						</select>
						<select name="soc2x3" class="dessocket">
							'.$this->buildSocketArr(6).'
						</select>
					</div>
					<div class="desRow">
						<div>Shoulder</div>
						<input type="text" name="inv3" placeholder="Enter itemid" value="'.($r = ($this->items[3]) ? $this->items[3] : "").'" />
						<select name="ench3">
							<option value="0"'.($r = ($this->enchantids[3]==0) ? "selected" : "").'>None</option>
							<option value="2715"'.($r = ($this->enchantids[3]==2715) ? "selected" : "").'>+31 Healing +11 Spell Damage and 5 mana per 5 sec.</option>
							<option value="2716"'.($r = ($this->enchantids[3]==2716) ? "selected" : "").'>+16 Stamina and +100 Armor</option>
							<option value="2717"'.($r = ($this->enchantids[3]==2717) ? "selected" : "").'>+26 Attack Power and +14 Critical Strike Rating</option>
							<option value="2721"'.($r = ($this->enchantids[3]==2721) ? "selected" : "").'>+15 Spell Damage and +14 Spell Critical Rating</option>
							<option value="2841"'.($r = ($this->enchantids[3]==2841) ? "selected" : "").'>+10 Stamina</option>
							<option value="2977"'.($r = ($this->enchantids[3]==2977) ? "selected" : "").'>+13 Dodge Rating</option>
							<option value="2978"'.($r = ($this->enchantids[3]==2978) ? "selected" : "").'>+15 Dodge Rating and +10 Defense Rating</option>
							<option value="2979"'.($r = ($this->enchantids[3]==2979) ? "selected" : "").'>+29 Healing and +10 Spell Damage</option>
							<option value="2980"'.($r = ($this->enchantids[3]==2980) ? "selected" : "").'>+33 Healing and +11 Spell Damage and +4 Mana Regen</option>
							<option value="2981"'.($r = ($this->enchantids[3]==2981) ? "selected" : "").'>+15 Spell Power</option>
							<option value="2982"'.($r = ($this->enchantids[3]==2982) ? "selected" : "").'>+18 Spell Power and +10 Spell Critical Strike Rati</option>
							<option value="2983"'.($r = ($this->enchantids[3]==2983) ? "selected" : "").'>+26 Attack Power</option>
							<option value="2986"'.($r = ($this->enchantids[3]==2986) ? "selected" : "").'>+30 Attack Power and +10 Critical Strike Rating</option>
							<option value="2990"'.($r = ($this->enchantids[3]==2990) ? "selected" : "").'>+13 Defense Rating</option>
							<option value="2991"'.($r = ($this->enchantids[3]==2991) ? "selected" : "").'>+15 Defense Rating and +10 Dodge Rating</option>
							<option value="2992"'.($r = ($this->enchantids[3]==2992) ? "selected" : "").'>+5 Mana Regen</option>
							<option value="2993"'.($r = ($this->enchantids[3]==2993) ? "selected" : "").'>+6 Mana Regen and +22 Healing</option>
							<option value="2994"'.($r = ($this->enchantids[3]==2994) ? "selected" : "").'>+13 Spell Critical Strike Rating</option>
							<option value="2995"'.($r = ($this->enchantids[3]==2995) ? "selected" : "").'>+15 Spell Critical Strike Rating and +12 Spell Dam</option>
							<option value="2996"'.($r = ($this->enchantids[3]==2996) ? "selected" : "").'>+13 Critical Strike Rating</option>
							<option value="2997"'.($r = ($this->enchantids[3]==2997) ? "selected" : "").'>+15 Critical Strike Rating and +20 Attack Power</option>
							<option value="2998"'.($r = ($this->enchantids[3]==2998) ? "selected" : "").'>+7 All Resistances</option>
						</select>
						<select name="soc3x1" class="dessocket">
							'.$this->buildSocketArr(7).'
						</select>
						<select name="soc3x2" class="dessocket">
							'.$this->buildSocketArr(8).'
						</select>
						<select name="soc3x3" class="dessocket">
							'.$this->buildSocketArr(9).'
						</select>
					</div>
					<div class="desRow">
						<div>Back</div>
						<input type="text" name="inv15" placeholder="Enter itemid" value="'.($r = ($this->items[15]) ? $this->items[15] : "").'" />
						<select name="ench15">
							<option value="0"'.($r = ($this->enchantids[15]==0) ? "selected" : "").'>None</option>
							<option value="65"'.($r = ($this->enchantids[15]==65) ? "selected" : "").'>+1 All Resistances</option>
							<option value="368"'.($r = ($this->enchantids[15]==368) ? "selected" : "").'>+12 Agility</option>
							<option value="783"'.($r = ($this->enchantids[15]==783) ? "selected" : "").'>+10 Armor</option>
							<option value="884"'.($r = ($this->enchantids[15]==884) ? "selected" : "").'>+50 Armor</option>
							<option value="903"'.($r = ($this->enchantids[15]==903) ? "selected" : "").'>+3 All Resistances</option>
							<option value="910"'.($r = ($this->enchantids[15]==910) ? "selected" : "").'>Increased Stealth</option>
							<option value="1441"'.($r = ($this->enchantids[15]==1441) ? "selected" : "").'>+15 Shadow Resistance</option>
							<option value="1888"'.($r = ($this->enchantids[15]==1888) ? "selected" : "").'>+5 All Resistances</option>
							<option value="2619"'.($r = ($this->enchantids[15]==2619) ? "selected" : "").'>+15 Fire Resistance</option>
							<option value="2621"'.($r = ($this->enchantids[15]==2621) ? "selected" : "").'>Subtlety</option>
							<option value="2622"'.($r = ($this->enchantids[15]==2622) ? "selected" : "").'>+12 Dodge Rating</option>
							<option value="2648"'.($r = ($this->enchantids[15]==2648) ? "selected" : "").'>+12 Defense Rating</option>
							<option value="2662"'.($r = ($this->enchantids[15]==2662) ? "selected" : "").'>+120 Armor</option>
							<option value="2664"'.($r = ($this->enchantids[15]==2664) ? "selected" : "").'>+7 Resist All</option>
							<option value="2938"'.($r = ($this->enchantids[15]==2938) ? "selected" : "").'>+20 Spell Penetration</option>
						</select>
						<select name="soc15x1" class="dessocket">
							'.$this->buildSocketArr(43).'
						</select>
						<select name="soc15x2" class="dessocket">
							'.$this->buildSocketArr(44).'
						</select>
						<select name="soc15x3" class="dessocket">
							'.$this->buildSocketArr(45).'
						</select>
					</div>
					<div class="desRow">
						<div>Chest</div>
						<input type="text" name="inv5" placeholder="Enter itemid" value="'.($r = ($this->items[5]) ? $this->items[5] : "").'" />
						<select name="ench5">
							<option value="0"'.($r = ($this->enchantids[5]==0) ? "selected" : "").'>None</option>
							<option value="17"'.($r = ($this->enchantids[5]==17) ? "selected" : "").'>Reinforced (+24 Armor)</option>
							<option value="850"'.($r = ($this->enchantids[5]==850) ? "selected" : "").'>+35 Health</option>
							<option value="857"'.($r = ($this->enchantids[5]==857) ? "selected" : "").'>+50 Mana</option>
							<option value="866"'.($r = ($this->enchantids[5]==866) ? "selected" : "").'>+2 All Stats</option>
							<option value="908"'.($r = ($this->enchantids[5]==908) ? "selected" : "").'>+50 Health</option>
							<option value="928"'.($r = ($this->enchantids[5]==928) ? "selected" : "").'>+3 All Stats</option>
							<option value="1144"'.($r = ($this->enchantids[5]==1144) ? "selected" : "").'>+15 Spirit</option>
							<option value="1893"'.($r = ($this->enchantids[5]==1893) ? "selected" : "").'>+100 Mana</option>
							<option value="1950"'.($r = ($this->enchantids[5]==1950) ? "selected" : "").'>+15 Defense Rating</option>
							<option value="2659"'.($r = ($this->enchantids[5]==2659) ? "selected" : "").'>+150 Health</option>
							<option value="2661"'.($r = ($this->enchantids[5]==2661) ? "selected" : "").'>+6 All Stats</option>
							<option value="2792"'.($r = ($this->enchantids[5]==2792) ? "selected" : "").'>+8 Stamina</option>
							<option value="2841"'.($r = ($this->enchantids[5]==2841) ? "selected" : "").'>+10 Stamina</option>
							<option value="2933"'.($r = ($this->enchantids[5]==2933) ? "selected" : "").'>+15 Resilience Rating</option>
							<option value="3150"'.($r = ($this->enchantids[5]==3150) ? "selected" : "").'>+6 mana every 5 sec.</option>
						</select>
						<select name="soc5x1" class="dessocket">
							'.$this->buildSocketArr(13).'
						</select>
						<select name="soc5x2" class="dessocket">
							'.$this->buildSocketArr(14).'
						</select>
						<select name="soc5x3" class="dessocket">
							'.$this->buildSocketArr(15).'
						</select>
					</div>
					<div class="desRow">
						<div>Wrist</div>
						<input type="text" name="inv9" placeholder="Enter itemid" value="'.($r = ($this->items[9]) ? $this->items[9] : "").'" />
						<select name="ench9">
							<option value="0"'.($r = ($this->enchantids[9]==0) ? "selected" : "").'>None</option>
							<option value="369"'.($r = ($this->enchantids[9]==369) ? "selected" : "").'>+12 Intellect</option>
							<option value="851"'.($r = ($this->enchantids[9]==851) ? "selected" : "").'>+5 Spirit</option>
							<option value="852"'.($r = ($this->enchantids[9]==852) ? "selected" : "").'>+5 Stamina</option>
							<option value="927"'.($r = ($this->enchantids[9]==927) ? "selected" : "").'>+7 Strength</option>
							<option value="929"'.($r = ($this->enchantids[9]==929) ? "selected" : "").'>+7 Stamina</option>
							<option value="1593"'.($r = ($this->enchantids[9]==1593) ? "selected" : "").'>+24 Attack Power</option>
							<option value="1883"'.($r = ($this->enchantids[9]==1883) ? "selected" : "").'>+7 Intellect</option>
							<option value="1891"'.($r = ($this->enchantids[9]==1891) ? "selected" : "").'>+4 All Stats</option>
							<option value="2617"'.($r = ($this->enchantids[9]==2617) ? "selected" : "").'>+30 Healing and +10 Spell Damage</option>
							<option value="2647"'.($r = ($this->enchantids[9]==2647) ? "selected" : "").'>+12 Strength</option>
							<option value="2648"'.($r = ($this->enchantids[9]==2648) ? "selected" : "").'>+12 Defense Rating</option>
							<option value="2649"'.($r = ($this->enchantids[9]==2649) ? "selected" : "").'>+12 Stamina</option>
							<option value="2650"'.($r = ($this->enchantids[9]==2650) ? "selected" : "").'>+15 Spell Damage</option>
							<option value="2679"'.($r = ($this->enchantids[9]==2679) ? "selected" : "").'>6 Mana per 5 Sec.</option>
						</select>
						<select name="soc9x1" class="dessocket">
							'.$this->buildSocketArr(25).'
						</select>
						<select name="soc9x2" class="dessocket">
							'.$this->buildSocketArr(26).'
						</select>
						<select name="soc9x3" class="dessocket">
							'.$this->buildSocketArr(27).'
						</select>
					</div>
					<div class="desRow">
						<div>Gloves</div>
						<input type="text" name="inv10" placeholder="Enter itemid" value="'.($r = ($this->items[10]) ? $this->items[10] : "").'" />
						<select name="ench10">
							<option value="0"'.($r = ($this->enchantids[10]==0) ? "selected" : "").'>None</option>
							<option value="17"'.($r = ($this->enchantids[10]==17) ? "selected" : "").'>Reinforced (+24 Armor)</option>
							<option value="684"'.($r = ($this->enchantids[10]==684) ? "selected" : "").'>+15 Strength</option>
							<option value="930"'.($r = ($this->enchantids[10]==930) ? "selected" : "").'>+2% Mount Speed</option>
							<option value="1594"'.($r = ($this->enchantids[10]==1594) ? "selected" : "").'>+26 Attack Power</option>
							<option value="1887"'.($r = ($this->enchantids[10]==1887) ? "selected" : "").'>+7 Agility</option>
							<option value="2322"'.($r = ($this->enchantids[10]==2322) ? "selected" : "").'>+35 Healing Spells and +12 Damage Spells</option>
							<option value="2564"'.($r = ($this->enchantids[10]==2564) ? "selected" : "").'>+15 Agility</option>
							<option value="2613"'.($r = ($this->enchantids[10]==2613) ? "selected" : "").'>+2% Threat</option>
							<option value="2792"'.($r = ($this->enchantids[10]==2792) ? "selected" : "").'>+8 Stamina</option>
							<option value="2793"'.($r = ($this->enchantids[10]==2793) ? "selected" : "").'>+8 Defense Rating</option>
							<option value="2841"'.($r = ($this->enchantids[10]==2841) ? "selected" : "").'>+10 Stamina</option>
							<option value="2934"'.($r = ($this->enchantids[10]==2934) ? "selected" : "").'>+10 Spell Critical Strike Rating</option>
							<option value="2935"'.($r = ($this->enchantids[10]==2935) ? "selected" : "").'>+15 Spell Hit Rating</option>
							<option value="2937"'.($r = ($this->enchantids[10]==2937) ? "selected" : "").'>+20 Spell Damage</option>
							<option value="3260"'.($r = ($this->enchantids[10]==3260) ? "selected" : "").'>+240 Armor</option>
						</select>
						<select name="soc10x1" class="dessocket">
							'.$this->buildSocketArr(28).'
						</select>
						<select name="soc10x2" class="dessocket">
							'.$this->buildSocketArr(29).'
						</select>
						<select name="soc10x3" class="dessocket">
							'.$this->buildSocketArr(30).'
						</select>
					</div>
					<div class="desRow">
						<div>Belt</div>
						<input type="text" name="inv6" placeholder="Enter itemid" value="'.($r = ($this->items[6]) ? $this->items[6] : "").'" />
						<div class="placeholderElement"></div>
						<select name="soc6x1" class="dessocket">
							'.$this->buildSocketArr(16).'
						</select>
						<select name="soc6x2" class="dessocket">
							'.$this->buildSocketArr(17).'
						</select>
						<select name="soc6x3" class="dessocket">
							'.$this->buildSocketArr(18).'
						</select>
					</div>
					<div class="desRow">
						<div>Legs</div>
						<input type="text" name="inv7" placeholder="Enter itemid" value="'.($r = ($this->items[7]) ? $this->items[7] : "").'" />
						<select name="ench7">
							<option value="0"'.($r = ($this->enchantids[7]==0) ? "selected" : "").'>None</option>
							<option value="17"'.($r = ($this->enchantids[7]==17) ? "selected" : "").'>Reinforced (+24 Armor)</option>
							<option value="18"'.($r = ($this->enchantids[7]==18) ? "selected" : "").'>Reinforced (+32 Armor)</option>
							<option value="1843"'.($r = ($this->enchantids[7]==1843) ? "selected" : "").'>Reinforced (+40 Armor)</option>
							<option value="2745"'.($r = ($this->enchantids[7]==2745) ? "selected" : "").'>+46 Healing +16 Spell Damage and +15 Stamina</option>
							<option value="2746"'.($r = ($this->enchantids[7]==2746) ? "selected" : "").'>+66 Healing +22 Spell Damage and +20 Stamina</option>
							<option value="2747"'.($r = ($this->enchantids[7]==2747) ? "selected" : "").'>+25 Spell Damage and +15 Stamina</option>
							<option value="2748"'.($r = ($this->enchantids[7]==2748) ? "selected" : "").'>+35 Spell Damage and +20 Stamina</option>
							<option value="2792"'.($r = ($this->enchantids[7]==2792) ? "selected" : "").'>+8 Stamina</option>
							<option value="2841"'.($r = ($this->enchantids[7]==2841) ? "selected" : "").'>+10 Stamina</option>
							<option value="3010"'.($r = ($this->enchantids[7]==3010) ? "selected" : "").'>+40 Attack Power and +10 Critical Strike Rating</option>
							<option value="3011"'.($r = ($this->enchantids[7]==3011) ? "selected" : "").'>+30 Stamina and +10 Agility</option>
							<option value="3012"'.($r = ($this->enchantids[7]==3012) ? "selected" : "").'>+50 Attack Power and +12 Critical Strike Rating</option>
							<option value="3013"'.($r = ($this->enchantids[7]==3013) ? "selected" : "").'>+40 Stamina and +12 Agility</option>
						</select>
						<select name="soc7x1" class="dessocket">
							'.$this->buildSocketArr(19).'
						</select>
						<select name="soc7x2" class="dessocket">
							'.$this->buildSocketArr(20).'
						</select>
						<select name="soc7x3" class="dessocket">
							'.$this->buildSocketArr(21).'
						</select>
					</div>
					<div class="desRow">
						<div>Feet</div>
						<input type="text" name="inv8" placeholder="Enter itemid" value="'.($r = ($this->items[8]) ? $this->items[8] : "").'" />
						<select name="ench8">
							<option value="0"'.($r = ($this->enchantids[8]==0) ? "selected" : "").'>None</option>
							<option value="17"'.($r = ($this->enchantids[8]==17) ? "selected" : "").'>Reinforced (+24 Armor)</option>
							<option value="464"'.($r = ($this->enchantids[8]==464) ? "selected" : "").'>+4% Mount Speed</option>
							<option value="724"'.($r = ($this->enchantids[8]==724) ? "selected" : "").'>+3 Stamina</option>
							<option value="851"'.($r = ($this->enchantids[8]==851) ? "selected" : "").'>+5 Spirit</option>
							<option value="852"'.($r = ($this->enchantids[8]==852) ? "selected" : "").'>+5 Stamina</option>
							<option value="904"'.($r = ($this->enchantids[8]==904) ? "selected" : "").'>+5 Agility</option>
							<option value="911"'.($r = ($this->enchantids[8]==911) ? "selected" : "").'>Minor Speed Increase</option>
							<option value="929"'.($r = ($this->enchantids[8]==929) ? "selected" : "").'>+7 Stamina</option>
							<option value="1887"'.($r = ($this->enchantids[8]==1887) ? "selected" : "").'>+7 Agility</option>
							<option value="2649"'.($r = ($this->enchantids[8]==2649) ? "selected" : "").'>+12 Stamina</option>
							<option value="2656"'.($r = ($this->enchantids[8]==2656) ? "selected" : "").'>Vitality</option>
							<option value="2657"'.($r = ($this->enchantids[8]==2657) ? "selected" : "").'>+12 Agility</option>
							<option value="2658"'.($r = ($this->enchantids[8]==2658) ? "selected" : "").'>Surefooted</option>
							<option value="2792"'.($r = ($this->enchantids[8]==2792) ? "selected" : "").'>+8 Stamina</option>
							<option value="2793"'.($r = ($this->enchantids[8]==2793) ? "selected" : "").'>+8 Defense Rating</option>
							<option value="2794"'.($r = ($this->enchantids[8]==2794) ? "selected" : "").'>+3 Mana restored per 5 seconds</option>
							<option value="2841"'.($r = ($this->enchantids[8]==2841) ? "selected" : "").'>+10 Stamina</option>
							<option value="2939"'.($r = ($this->enchantids[8]==2939) ? "selected" : "").'>Minor Speed and +6 Agility</option>
							<option value="2940"'.($r = ($this->enchantids[8]==2940) ? "selected" : "").'>Minor Speed and +9 Stamina</option>
						</select>
						<select name="soc8x1" class="dessocket">
							'.$this->buildSocketArr(22).'
						</select>
						<select name="soc8x2" class="dessocket">
							'.$this->buildSocketArr(23).'
						</select>
						<select name="soc8x3" class="dessocket">
							'.$this->buildSocketArr(24).'
						</select>
					</div>
					<div class="desRow">
						<div>Ring 1</div>
						<input type="text" name="inv11" placeholder="Enter itemid" value="'.($r = ($this->items[11]) ? $this->items[11] : "").'" />
						<select name="ench11">
							<option value="0"'.($r = ($this->enchantids[11]==0) ? "selected" : "").'>None</option>
							<option value="2928"'.($r = ($this->enchantids[11]==2928) ? "selected" : "").'>+12 Spell Damage</option>
							<option value="2930"'.($r = ($this->enchantids[11]==2930) ? "selected" : "").'>+20 Healing and +7 Spell Damage</option>
							<option value="2931"'.($r = ($this->enchantids[11]==2931) ? "selected" : "").'>+4 All Stats</option>
						</select>
						<select name="soc11x1" class="dessocket">
							'.$this->buildSocketArr(31).'
						</select>
						<select name="soc11x2" class="dessocket">
							'.$this->buildSocketArr(32).'
						</select>
						<select name="soc11x3" class="dessocket">
							'.$this->buildSocketArr(33).'
						</select>
					</div>
					<div class="desRow">
						<div>Ring 2</div>
						<input type="text" name="inv12" placeholder="Enter itemid" value="'.($r = ($this->items[12]) ? $this->items[12] : "").'" />
						<select name="ench12">
							<option value="0"'.($r = ($this->enchantids[11]==0) ? "selected" : "").'>None</option>
							<option value="2928"'.($r = ($this->enchantids[11]==2928) ? "selected" : "").'>+12 Spell Damage</option>
							<option value="2930"'.($r = ($this->enchantids[11]==2930) ? "selected" : "").'>+20 Healing and +7 Spell Damage</option>
							<option value="2931"'.($r = ($this->enchantids[11]==2931) ? "selected" : "").'>+4 All Stats</option>
						</select>
						<select name="soc12x1" class="dessocket">
							'.$this->buildSocketArr(34).'
						</select>
						<select name="soc12x2" class="dessocket">
							'.$this->buildSocketArr(35).'
						</select>
						<select name="soc12x3" class="dessocket">
							'.$this->buildSocketArr(36).'
						</select>
					</div>
					<div class="desRow specialSnowflake">
						<div>Trinket 1</div>
						<input type="text" name="inv13" placeholder="Enter itemid" value="'.($r = ($this->items[13]) ? $this->items[13] : "").'" />
					</div>
					<div class="desRow specialSnowflake">
						<div>Trinket 2</div>
						<input type="text" name="inv14" placeholder="Enter itemid" value="'.($r = ($this->items[14]) ? $this->items[14] : "").'" />
					</div>
					<div class="desRow">
						<div>Main Hand</div>
						<input type="text" name="inv16" placeholder="Enter itemid" value="'.($r = ($this->items[16]) ? $this->items[16] : "").'" />
						<select name="ench16">
							<option value="0"'.($r = ($this->enchantids[16]==0) ? "selected" : "").'>None</option>
							<option value="250"'.($r = ($this->enchantids[16]==250) ? "selected" : "").'>+1  Weapon Damage</option>
							<option value="723"'.($r = ($this->enchantids[16]==723) ? "selected" : "").'>+3 Intellect</option>
							<option value="943"'.($r = ($this->enchantids[16]==943) ? "selected" : "").'>+3 Weapon Damage</option>
							<option value="963"'.($r = ($this->enchantids[16]==963) ? "selected" : "").'>+7 Weapon Damage</option>
							<option value="1894"'.($r = ($this->enchantids[16]==1894) ? "selected" : "").'>Icy Weapon</option>
							<option value="1899"'.($r = ($this->enchantids[16]==1899) ? "selected" : "").'>Unholy Weapon</option>
							<option value="1900"'.($r = ($this->enchantids[16]==1900) ? "selected" : "").'>Crusader</option>
							<option value="2343"'.($r = ($this->enchantids[16]==2343) ? "selected" : "").'>+81 Healing Spells and +27 Damage Spells</option>
							<option value="2666"'.($r = ($this->enchantids[16]==2666) ? "selected" : "").'>+30 Intellect</option>
							<option value="2667"'.($r = ($this->enchantids[16]==2667) ? "selected" : "").'>Savagery</option>
							<option value="2668"'.($r = ($this->enchantids[16]==2668) ? "selected" : "").'>+20 Strength</option>
							<option value="2669"'.($r = ($this->enchantids[16]==2669) ? "selected" : "").'>+40 Spell Damage</option>
							<option value="2670"'.($r = ($this->enchantids[16]==2670) ? "selected" : "").'>+35 Agility</option>
							<option value="2671"'.($r = ($this->enchantids[16]==2671) ? "selected" : "").'>Sunfire</option>
							<option value="2672"'.($r = ($this->enchantids[16]==2672) ? "selected" : "").'>Soulfrost</option>
							<option value="2673"'.($r = ($this->enchantids[16]==2673) ? "selected" : "").'>Mongoose</option>
							<option value="3222"'.($r = ($this->enchantids[16]==3222) ? "selected" : "").'>+20 Agility</option>
							<option value="3225"'.($r = ($this->enchantids[16]==3225) ? "selected" : "").'>Executioner</option>
						</select>
						<select name="soc16x1" class="dessocket">
							'.$this->buildSocketArr(46).'
						</select>
						<select name="soc16x2" class="dessocket">
							'.$this->buildSocketArr(47).'
						</select>
						<select name="soc16x3" class="dessocket">
							'.$this->buildSocketArr(48).'
						</select>
					</div>
					<div class="desRow">
						<div>Off Hand</div>
						<input type="text" name="inv17" placeholder="Enter itemid" value="'.($r = ($this->items[17]) ? $this->items[17] : "").'" />
						<select name="ench17">
							<option value="0"'.($r = ($this->enchantids[17]==0) ? "selected" : "").'>None</option>
							<option value="241"'.($r = ($this->enchantids[17]==241) ? "selected" : "").'>+2 Weapon Damage</option>
							<option value="724"'.($r = ($this->enchantids[17]==724) ? "selected" : "").'>+3 Stamina</option>
							<option value="1071"'.($r = ($this->enchantids[17]==1071) ? "selected" : "").'>+18 Stamina</option>
							<option value="1894"'.($r = ($this->enchantids[17]==1894) ? "selected" : "").'>Icy Weapon</option>
							<option value="1900"'.($r = ($this->enchantids[17]==1900) ? "selected" : "").'>Crusader</option>
							<option value="2653"'.($r = ($this->enchantids[17]==2653) ? "selected" : "").'>+18 Block Value</option>
							<option value="2654"'.($r = ($this->enchantids[17]==2654) ? "selected" : "").'>+12 Intellect</option>
							<option value="2668"'.($r = ($this->enchantids[17]==2668) ? "selected" : "").'>+20 Strength</option>
							<option value="2673"'.($r = ($this->enchantids[17]==2673) ? "selected" : "").'>Mongoose</option>
							<option value="2714"'.($r = ($this->enchantids[17]==2714) ? "selected" : "").'>Felsteel Spike (26-38)</option>
							<option value="3222"'.($r = ($this->enchantids[17]==3222) ? "selected" : "").'>+20 Agility</option>
							<option value="3225"'.($r = ($this->enchantids[17]==3225) ? "selected" : "").'>Executioner</option>
							<option value="3229"'.($r = ($this->enchantids[17]==3229) ? "selected" : "").'>+12 Resilience Rating</option>
						</select>
						<select name="soc17x1" class="dessocket">
							'.$this->buildSocketArr(49).'
						</select>
						<select name="soc17x2" class="dessocket">
							'.$this->buildSocketArr(50).'
						</select>
						<select name="soc17x3" class="dessocket">
							'.$this->buildSocketArr(51).'
						</select>
					</div>
					<div class="desRow">
						<div>Ranged</div>
						<input type="text" name="inv18" placeholder="Enter itemid" value="'.($r = ($this->items[18]) ? $this->items[18] : "").'" />
						<select name="ench18">
							<option value="0"'.($r = ($this->enchantids[18]==0) ? "selected" : "").'>None</option>
							<option value="32"'.($r = ($this->enchantids[18]==32) ? "selected" : "").'>Scope (+2 Damage)</option>
							<option value="664"'.($r = ($this->enchantids[18]==664) ? "selected" : "").'>Scope (+7 Damage)</option>
							<option value="2722"'.($r = ($this->enchantids[18]==2722) ? "selected" : "").'>Scope (+10 Damage)</option>
							<option value="2723"'.($r = ($this->enchantids[18]==2723) ? "selected" : "").'>Scope (+12 Damage)</option>
							<option value="2724"'.($r = ($this->enchantids[18]==2724) ? "selected" : "").'>Scope (+28 Critical Strike Rating)</option>
						</select>
						<select name="soc18x1" class="dessocket">
							'.$this->buildSocketArr(52).'
						</select>
						<select name="soc18x2" class="dessocket">
							'.$this->buildSocketArr(53).'
						</select>
						<select name="soc18x3" class="dessocket">
							'.$this->buildSocketArr(54).'
						</select>
					</div>
				</section>
				<section class="sright" style="background-image: url(\'{path}WOTLK/CharacterDesigner/img/'.strtolower($this->gender[$this->genderid]).strtolower($this->race[$this->raceid]).'.png\');">
					<div class="urlbar">
						<input type="text" onClick="this.select();" value="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" name="url" readonly/>
						<select name="race">
							<option class="alliance" value="1"'.($r = ($this->raceid==1) ? "selected" : "").'>Human</option>
							<option class="alliance" value="2"'.($r = ($this->raceid==2) ? "selected" : "").'>Dwarf</option>
							<option class="alliance" value="3"'.($r = ($this->raceid==3) ? "selected" : "").'>Night Elf</option>
							<option class="alliance" value="4"'.($r = ($this->raceid==4) ? "selected" : "").'>Gnome</option>
							<option class="alliance" value="9"'.($r = ($this->raceid==9) ? "selected" : "").'>Draenei</option>
							<option class="horde" value="5"'.($r = ($this->raceid==5) ? "selected" : "").'>Orc</option>
							<option class="horde" value="6"'.($r = ($this->raceid==6) ? "selected" : "").'>Undead</option>
							<option class="horde" value="7"'.($r = ($this->raceid==7) ? "selected" : "").'>Troll</option>
							<option class="horde" value="8"'.($r = ($this->raceid==8) ? "selected" : "").'>Tauren</option>
							<option class="horde" value="10"'.($r = ($this->raceid==10) ? "selected" : "").'>Blood Elf</option>
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
							<option value="10" class="color-deathknight"'.($r = ($this->classid==10) ? "selected" : "").'>Death Knight</option>
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
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[1].$this->getSocketString(1).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[2]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[2]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[2].$this->getSocketString(2).'&sockets='.$this->socketids[4].','.$this->socketids[5].','.$this->socketids[6].'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[3]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[3]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[3].$this->getSocketString(3).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[15]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[15]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[15].$this->getSocketString(15).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[5]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[5]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[5].$this->getSocketString(5).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[4]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[4]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[4].$this->getSocketString(4).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[19]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[19]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[19].$this->getSocketString(19).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[9]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[9]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[9].$this->getSocketString(9).'" target="_blank"><div class="b"></div></a>
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
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[10].$this->getSocketString(10).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[6]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[6]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[6].$this->getSocketString(6).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[7]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[7]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[7].$this->getSocketString(7).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[8]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[8]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[8].$this->getSocketString(8).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[11]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[11]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[11].$this->getSocketString(11).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[12]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[12]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[12].$this->getSocketString(12).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[13]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[13]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[13].$this->getSocketString(13).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[14]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[14]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[14].$this->getSocketString(14).'" target="_blank"><div class="b"></div></a>
							</div>
						</div>
						<div class="gbottom">
							<div class="item qe'.$this->itemTemplate[$this->items[16]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[16]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[16].$this->getSocketString(16).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[17]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[17]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[17].$this->getSocketString(17).'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->items[18]]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->items[18]]->icon.'.jpg\');">
								<a href="https://wotlk-twinhead.twinstar.cz/?item='.$this->items[18].$this->getSocketString(18).'" target="_blank"><div class="b"></div></a>
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
										<td title="Resilience: '.ceil($this->statValues[60]).'">Defense*</td>
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
										<td title="Haste: '.$this->statValues[58].'">Attackpower*</td>
										<td>'.ceil($r = ($this->statValues[24]>$this->statValues[25]) ? $this->statValues[24] : $this->statValues[25]).'</td>
									</tr>
									<tr>
										<td>Hit</td>
										<td>'.round($this->statValues[16], 2).'%</td>
									</tr>
									<tr>
										<td>Crit</td>
										<td>'.round($this->statValues[19], 2).'%</td>
									</tr>
									<tr>
										<td>Armor Penetration</td>
										<td>'.ceil($this->statValues[55]).'</td>
									</tr>
									<tr>
										<td>Expertise</td>
										<td>'.ceil($this->statValues[57]).'</td>
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
										<td title="Haste: '.$this->statValues[59].'">
											Spellpower*
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
										<td title="Spell Penetration: '.ceil($this->statValues[56]).'">Hit*</td>
										<td>'.round($this->statValues[18], 2).'%</td>
									</tr>
									<tr>
										<td>Crit</td>
										<td>'.round($this->statValues[21], 2).'%</td>
									</tr>
									<tr>
										<td title="Infight/Outfight">Mana regeneration*</td>
										<td>'.ceil($this->statValues[0])."/".ceil($this->statValues[54]).'</td>
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
	
	public function __construct($db, $dir, $items, $enchants, $misc, $socketids){
		$items = $this->antiSQLInjection($items);
		$enchants = $this->antiSQLInjection($enchants);
		$socketids = $this->antiSQLInjection($socketids);
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
		$socketids = explode(",", $socketids);
		for ($i=1; $i<=19;$i++){
			$this->items[$i] = intval($items[$i-1]);
			$this->enchantids[$i] = intval($enchants[$i-1]);
			for ($p=1;$p<=3;$p++){
				$this->socketids[$i*3-3+$p] = intval($socketids[$i*3-4+$p]);
			}
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

new Home($db, __DIR__, $_GET["items"], $_GET["enchants"], $_GET["misc"], $_GET["sockets"]);

?>