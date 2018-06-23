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
	
	private $name 	= "";
	private $server = "";
	private $sname = "";
	private $sid = 0;
	private $charid = 0;
	private $classid = 0;
	private $gid = 0;
	private $gname = "";
	private $faction = "";
	private $itemTemplate = array();
	private $enchTemplate = array();
	private $userData = array();
	private $itemSet = array();
	private $mode = null;
	private $statValues = array();
	private $enchants = "";
	private $powerbartype = "mana";
	private $arena = array();
	private $ranks = array(
		1 => array(
			0 => "None",
			1 => "Private",
			2 => "Corporal",
			3 => "Sergeant",
			4 => "Master Sergeant",
			5 => "Sergeant Major",
			6 => "Knight",
			7 => "Knight-Lieutenant",
			8 => "Knight-Captain",
			9 => "Knight-Champion",
			10 => "Lt. Commander",
			11 => "Commander",
			12 => "Marshal",
			13 => "Field Marshal",
			14 => "Grand Marshal"
		),
		-1 => array(
			0 => "None",
			1 => "Scout",
			2 => "Grunt",
			3 => "Sergeant",
			4 => "Senior Sergeant",
			5 => "First Sergeant",
			6 => "Stone Guard",
			7 => "Blood Guard",
			8 => "Legionnaire",
			9 => "Centurion",
			10 => "Champion",
			11 => "Lt. General",
			12 => "General",
			13 => "Warlord",
			14 => "High Warlord",
		)
	);
	private $itemSets = array();
	private $itemString = array();
	private $enchantString = array();
	private $socketString = array();
	
	private function getUserData($db, $server, $name){
		$this->sname = $server;
		$this->name = $name;
		$q = $db->query('SELECT a.id as chaaarid, b.id as sid, a.classid, a.guildid, c.name as gname, a.faction, d.*, e.* FROM chars a LEFT JOIN servernames b ON a.serverid = b.id LEFT JOIN guilds c ON a.guildid = c.id LEFT JOIN `armory` d ON a.id = d.charid LEFT JOIN `armory-honor-tbc` e ON d.charid = e.charid WHERE b.expansion=1 AND b.name = "'.$server.'" AND a.name = "'.$name.'";')->fetch();
		$this->sid = $q->sid;
		$this->charid = $q->chaaarid;
		$this->classid = $q->classid;
		$this->gid = $q->guildid;
		$this->gname = $q->gname;
		$this->faction = ($q->faction==1) ? "alliance" : "horde";
		$this->userData = $q;
		if (!isset($this->userData->currank))
			$this->userData->currank = 0;
		if (!isset($this->userData->liferank))
			$this->userData->liferank = 4;
		$this->itemSet = $db->query('SELECT * FROM `armory-itemsets-tbc` WHERE charid = "'.$this->charid.'" AND `index` = "'.intval($this->mode).'";')->fetch();
		if (isset($this->userData->arena1)){
			foreach($db->query('SELECT * FROM `armory-arenateams-tbc` WHERE arenaid IN ('.$this->userData->arena1.','.$this->userData->arena2.','.$this->userData->arena3.')') as $row){
				$this->arena[$row->type] = $row;
			}
		}
	}
	
	private function getItemTemplate($db){
		foreach($db->query('SELECT a.itemset, a.entry, a.name, a.quality, a.icon, a.armor, a.holy_res, a.fire_res, a.nature_res, a.frost_res, a.shadow_res, a.arcane_res, a.hit, a.crit, a.apower, a.dodge, a.parry, a.block, a.spellpower, a.healpower, a.spellholy, a.spellfire, a.spellfrost, a.spellnature, a.spellshadow, a.spellarcane, a.manaregen, a.defense, a.spellhit, a.spellcrit, a.blockchance, a.strength, a.agility, a.spirit, a.intellect, a.stamina, a.resilience, a.haste, a.spellhaste, a.expertise, a.armorpen, a.spellpen, b.* FROM `item_template-tbc` a LEFT JOIN `tbc-itemsets` b ON a.itemset = b.id') as $row){
			$this->itemTemplate[$row->entry] = $row;
			$this->itemSets[$row->itemset] = $row;
		}
		foreach($db->query('SELECT item, COUNT(item) as am FROM `armory-itemhistory` a LEFT JOIN chars b ON a.charid = b.id WHERE serverid = '.$this->sid.' GROUP BY item') as $row){
			$this->itemTemplate[$row->item]->amount = $row->am;
		}
	}
	
	private function getEnchantmentTemplate($db){
		foreach($db->query('SELECT * FROM `armory-enchantmentstats-tbc` a LEFT JOIN `gemproperties-tbc` b ON a.enchid = b.gemid') as $row){
			$this->enchTemplate[$row->enchid] = $row;
		}
	}
	
	private function getGuildRank(){
		if (isset($this->userData->grankname) && $this->userData->grankname != "" && isset($this->gname) && $this->gname != "")
			return $this->userData->grankname.' of <span class="'.$this->faction.'">'.$this->gname.'</span>';
		if (isset($this->userData->level))
			return "";
		else
			return "No data yet";
	}
	
	private function getNameString(){
		if (isset($this->userData->gender) && $this->userData->gender != "")
			return ($r = ($this->userData->title!="") ? $this->userData->title."<br />" : "").'Level '.$this->userData->level.' '.$this->gender[$this->userData->gender].' '.$this->race[$this->userData->race].' <span class="color-'.strtolower($this->classById[$this->classid]).'">'.$this->classById[$this->classid].'</span><br />';
		return ($r = ($this->userData->title!="") ? $this->userData->title."<br />" : "").'Level 70 <span class="color-'.$this->classById[$this->classid].'">'.$this->classById[$this->classid].'</span><br />';
	}
	
	private function levelCoeff(){
		if (!isset($this->userData->level) || $this->userData->level==0)
			return 1;
		return $this->userData->level/70;
	}
	
	private function getStatValues(){
		for ($i=1; $i<60; $i++){
			$this->statValues[$i] = 0;
		} 
		//enchantment stats
		for ($i=1; $i<20; $i++){
			$this->itemString[] = intval($this->itemSet->{"item".$i});
			$this->enchantString[] = intval($this->itemSet->{"ench".$i});
			
			if ($i==19){
				$this->statValues[53] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->hit;
			}else{
				if (isset($this->itemSet->{"ench".$i})){
					$this->statValues[0] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->manaregen;
					$this->statValues[54] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->manaregen;
					$this->statValues[3] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->agility;
					$this->statValues[4] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->strength;
					$this->statValues[5] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->intellect;
					$this->statValues[6] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spirit;
					$this->statValues[7] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->stamina;
					$this->statValues[12] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->defense;
					$this->statValues[13] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->dodge;
					$this->statValues[15] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->block;
					$this->statValues[26] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->blockchance;
					$this->statValues[16] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->hit;
					$this->statValues[18] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spellhit;
					$this->statValues[19] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->crit;
					$this->statValues[21] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spellcrit;
					$this->statValues[22] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spellpower;
					$this->statValues[23] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->healpower;
					$this->statValues[24] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->apower;
					$this->statValues[25] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->rangedapower;
					$this->statValues[38] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->armor;
					$this->statValues[39] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->res_holy;
					$this->statValues[40] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->res_fire;
					$this->statValues[41] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->res_nature;
					$this->statValues[42] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->res_frost;
					$this->statValues[43] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->res_shadow;
					$this->statValues[44] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->res_arcane;
					$this->statValues[45] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->health;
					$this->statValues[46] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->mana;
					$this->statValues[47] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spellholy;
					$this->statValues[48] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spellfrost;
					$this->statValues[49] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spellnature;
					$this->statValues[50] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spellfire;
					$this->statValues[51] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spellarcane;
					$this->statValues[52] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spellshadow;
					$this->statValues[55] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->armorpen;
					$this->statValues[56] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spellpen;
					$this->statValues[57] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->expertise;
					$this->statValues[58] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->haste;
					$this->statValues[59] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->spellhaste;
					$this->statValues[60] += $this->enchTemplate[$this->itemSet->{"ench".$i}]->resilience;
				}
			}
			$this->enchants .= '
				savedEnchants['.$this->itemSet->{"item".$i}.'] = "'.$this->enchTemplate[$this->itemSet->{"ench".$i}]->name.'"';
		}
		
		// gems
		for ($i=1; $i<=19; $i++){
			if (isset($this->itemSet->{"gem".$i})){
				$bool = false; $valid = true; $p = 0;
				foreach(explode(":",$this->itemSet->{"gem".$i}) as $var){
					if ($p<3)
						$this->socketString[] = intval($var);
					$p++;
					$bool = true;
					if (isset($this->enchTemplate[$var])){
						if (($this->enchTemplate[$var]->flag!=$this->itemTemplate[$this->itemSet->{"item".$i}]->{"socketColor_".($p+1)} && !isset($socketColors[$this->enchTemplate[$var]->flag-$this->itemTemplate[$this->itemSet->{"item".$i}]->{"socketColor_".($p+1)}]) && ($this->enchTemplate[$var]->flag-$this->itemTemplate[$this->itemSet->{"item".$i}]->{"socketColor_".($p+1)})!=0) && $this->itemTemplate[$this->itemSet->{"item".$i}]->{"socketColor_".($p+1)} != 1)
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
						$this->statValues[18] += $this->enchTemplate[$var]->spellhit;
						$this->statValues[19] += $this->enchTemplate[$var]->crit;
						$this->statValues[21] += $this->enchTemplate[$var]->spellcrit;
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
						$this->statValues[59] += $this->enchTemplate[$var]->spellhaste;
						$this->statValues[60] += $this->enchTemplate[$var]->resilience;
					}
				}
				for($qq=$p;$qq<3;$qq++){
					$this->socketString[] = 0;
				}
				if ($bool && $valid){
					$var = intval($this->itemTemplate[$this->itemSet->{"item".$i}]->socketBonus);
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
						$this->statValues[18] += $this->enchTemplate[$var]->spellhit;
						$this->statValues[19] += $this->enchTemplate[$var]->crit;
						$this->statValues[21] += $this->enchTemplate[$var]->spellcrit;
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
						$this->statValues[59] += $this->enchTemplate[$var]->spellhaste;
						$this->statValues[60] += $this->enchTemplate[$var]->resilience;
					}
				}
			}else{
				$this->socketString[] = 0;
				$this->socketString[] = 0;
				$this->socketString[] = 0;
			}
		}
		
		// item stats
		for ($i=1; $i<20; $i++){
			$this->statValues[0] += $this->itemTemplate[$this->itemSet->{"item".$i}]->manaregen;
			$this->statValues[54] += $this->itemTemplate[$this->itemSet->{"item".$i}]->manaregen;
			$this->statValues[3] += $this->itemTemplate[$this->itemSet->{"item".$i}]->agility;
			$this->statValues[4] += $this->itemTemplate[$this->itemSet->{"item".$i}]->strength;
			$this->statValues[5] += $this->itemTemplate[$this->itemSet->{"item".$i}]->intellect;
			$this->statValues[6] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spirit;
			$this->statValues[7] += $this->itemTemplate[$this->itemSet->{"item".$i}]->stamina;
			$this->statValues[12] += $this->itemTemplate[$this->itemSet->{"item".$i}]->defense;
			$this->statValues[13] += $this->itemTemplate[$this->itemSet->{"item".$i}]->dodge;
			$this->statValues[14] += $this->itemTemplate[$this->itemSet->{"item".$i}]->parry;
			$this->statValues[15] += $this->itemTemplate[$this->itemSet->{"item".$i}]->block;
			$this->statValues[26] += $this->itemTemplate[$this->itemSet->{"item".$i}]->blockchance;
			$this->statValues[16] += $this->itemTemplate[$this->itemSet->{"item".$i}]->hit;
			$this->statValues[18] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spellhit;
			$this->statValues[19] += $this->itemTemplate[$this->itemSet->{"item".$i}]->crit;
			$this->statValues[21] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spellcrit;
			$this->statValues[22] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spellpower;
			$this->statValues[23] += $this->itemTemplate[$this->itemSet->{"item".$i}]->healpower;
			$this->statValues[24] += $this->itemTemplate[$this->itemSet->{"item".$i}]->apower;
			$this->statValues[25] += $this->itemTemplate[$this->itemSet->{"item".$i}]->rangedapower;
			$this->statValues[38] += $this->itemTemplate[$this->itemSet->{"item".$i}]->armor;
			$this->statValues[39] += $this->itemTemplate[$this->itemSet->{"item".$i}]->holy_res;
			$this->statValues[40] += $this->itemTemplate[$this->itemSet->{"item".$i}]->fire_res;
			$this->statValues[41] += $this->itemTemplate[$this->itemSet->{"item".$i}]->nature_res;
			$this->statValues[42] += $this->itemTemplate[$this->itemSet->{"item".$i}]->frost_res;
			$this->statValues[43] += $this->itemTemplate[$this->itemSet->{"item".$i}]->shadow_res;
			$this->statValues[44] += $this->itemTemplate[$this->itemSet->{"item".$i}]->arcane_res;
			$this->statValues[47] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spellholy;
			$this->statValues[48] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spellfrost;
			$this->statValues[49] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spellnature;
			$this->statValues[50] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spellfire;
			$this->statValues[51] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spellarcane;
			$this->statValues[52] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spellshadow;
			$this->statValues[55] += $this->itemTemplate[$this->itemSet->{"item".$i}]->armorpen;
			$this->statValues[56] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spellpen;
			$this->statValues[57] += $this->itemTemplate[$this->itemSet->{"item".$i}]->expertise;
			$this->statValues[58] += $this->itemTemplate[$this->itemSet->{"item".$i}]->haste;
			$this->statValues[59] += $this->itemTemplate[$this->itemSet->{"item".$i}]->spellhaste;
			$this->statValues[60] += $this->itemTemplate[$this->itemSet->{"item".$i}]->resilience;
		}
		
		$this->statValues[12] += $this->userData->level*5;
		switch($this->classid){
			case 1 :
				// Taking orc warrior stats
				// Every haste point equals 0.063396226%
				$this->powerbartype = "rage";
				// Tank stats
				$this->statValues[13] = $this->statValues[13]*0.052857;
				$this->statValues[14] = $this->statValues[14]*0.42380952;
				$this->statValues[26] = $this->statValues[26]*0.126842105;
				
				$this->statValues[16] = $this->statValues[16]/15.7895;
				$this->statValues[19] = $this->statValues[19]*0.045263;
				$this->statValues[19] += 1.17;
				$this->statValues[14] += 5;
				$this->statValues[13] += 0.7345;
				$this->statValues[26] += 5;
				$this->statValues[3] += 93*$this->levelCoeff();
				$this->statValues[4] += 148*$this->levelCoeff();
				$this->statValues[5] += 30*$this->levelCoeff();
				$this->statValues[6] += 54*$this->levelCoeff();
				$this->statValues[7] += 135*$this->levelCoeff();
				$this->statValues[24] += 190*$this->levelCoeff();
				$this->statValues[45] = 4264*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.03;
				$this->statValues[38] += ceil($this->statValues[3]*(2.0-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.0335, 2);
				if ($this->userData->race==3)
					$this->statValues[13] += 1;
				
				if ($this->userData->talent==1)
					$this->statValues[19] += 5;
				if ($this->userData->talent != 3)
					$this->statValues[19] += 5;
				if ($this->userData->talent == 3){
					$this->statValues[12] += 20;
					$this->statValues[38] = ceil($this->statValues[38]*1.1); // 10% more armor?
					$this->statValues[7] += $this->statValues[7]*0.05;
					$this->statValues[4] += $this->statValues[4]*0.1;
				}
				$defense = $this->statValues[12]-350; // Gotta add this for vanilla
				$this->statValues[13] += $defense*0.04;
				$this->statValues[14] += $defense*0.04;
				$this->statValues[26] += $defense*0.04;
				
				
				$this->statValues[15] += $this->statValues[4]*0.04945;
				
				if ($this->userData->race==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05);
				if ($this->userData->race==1){
					$this->statValues[19] += 0.2;
					$this->statValues[14] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				if ($this->userData->race==5){
					$this->statValues[19] += 0.2;
					$this->statValues[14] += 0.2;
				}
				if ($this->userData->race==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] = 100;
				break;
			case 2 :
				// Taking blood elf rogue stats
				// haste scales 0.050875 per point
				$this->powerbartype = "energy";
				$this->statValues[16] = $this->statValues[16]/15.75;
				$this->statValues[19] = $this->statValues[19]*0.045263157;
				$this->statValues[19] += -0.29;
				$this->statValues[14] += 5;
				$this->statValues[13] += -0.59;
				$this->statValues[3] += 160*$this->levelCoeff();
				$this->statValues[4] += 92*$this->levelCoeff();
				$this->statValues[5] += 43*$this->levelCoeff();
				$this->statValues[6] += 57*$this->levelCoeff();
				$this->statValues[7] += 88*$this->levelCoeff();
				$this->statValues[24] += 120*$this->levelCoeff();
				if ($this->userData->race==1){
					$this->statValues[19] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				if ($this->userData->race==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05);
				
				if ($this->userData->talent==2){
					$this->statValues[16] += 5;
					$this->statValues[57] += 40;
					$this->statValues[3] += $this->statValues[3]*0.02;
				}
				if ($this->userData->race==3)
					$this->statValues[13] += 1;
				
				if ($this->userData->talent==3){
					$this->statValues[3] += $this->statValues[3]*0.15;
				}
				$this->statValues[24] += $this->statValues[3]+$this->statValues[4];
				if ($this->userData->talent==3){
					$this->statValues[24] += $this->statValues[24]*0.1;
				}
				
				$this->statValues[19] += 5; // Talents
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[19] += round($this->statValues[3]*0.025, 2);
				$this->statValues[13] += round($this->statValues[3]*0.05, 2);
				$this->statValues[45] = 3524*$this->levelCoeff();
				$this->statValues[46] = 100;
				break;
			case 3 :
				// Taking troll priest stats
				// spellhaste castings speed 0.0625% per point
				$this->statValues[21] = $this->statValues[21]*0.045454545454545;
				$this->statValues[18] = $this->statValues[18]*0.079411764;
				$this->statValues[19] += -5.06;
				$this->statValues[21] += 1.25824;
				$this->statValues[3] += 47*$this->levelCoeff();
				$this->statValues[4] += 40*$this->levelCoeff();
				$this->statValues[5] += 141*$this->levelCoeff();
				$this->statValues[6] += 152*$this->levelCoeff();
				$this->statValues[7] += 59*$this->levelCoeff();
				$this->statValues[24] += -10*$this->levelCoeff();
				$this->statValues[45] = 3211*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4];
				$this->statValues[19] += $this->statValues[3]*0.107659574;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.107659574, 2);
				$this->statValues[21] += $this->statValues[5]*0.012352941;
				
				$this->statValues[46] += 2340*$this->levelCoeff();
				
				if ($this->userData->talent!=3)
					$this->statValues[21] += 5; // Talent
				if ($this->userData->race==3)
					$this->statValues[13] += 1;
				if ($this->userData->race==1){
					$this->statValues[19] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				if ($this->userData->talent==1){
					$this->statValues[46] = ceil($this->statValues[46]*1.1);
					$this->statValues[21] += 5;
					$this->statValues[18] += 4;
					$this->statValues[5] += $this->statValues[5]*0.05;
					$this->statValues[6] += $this->statValues[6]*0.05;
					$this->statValues[7] += $this->statValues[7]*0.05;
				}
				if ($this->userData->talent==2){
					$this->statValues[6] += $this->statValues[6]*0.05;
					$this->statValues[22] += $this->statValues[6]*0.25;
					$this->statValues[23] += $this->statValues[6]*0.25;
				}
				break;
			case 4 :
				// Taking tauren Hunter stats
				// haste 0.063375% per point ranged haste // Guess it scales for all classes the same
				$this->statValues[16] = $this->statValues[16]*0.063333333333;
				$this->statValues[19] = $this->statValues[19]*0.045263157;
				$this->statValues[19] += -1.535;
				$this->statValues[13] = -5.45;
				$this->statValues[21] = 3.8;
				$this->statValues[14] += 5;
				
				$this->statValues[3] += 146*$this->levelCoeff();
				$this->statValues[4] += 69*$this->levelCoeff();
				$this->statValues[5] += 72*$this->levelCoeff();
				$this->statValues[6] += 85*$this->levelCoeff();
				$this->statValues[7] += 110*$this->levelCoeff();
				$this->statValues[24] += 130*$this->levelCoeff();
				$this->statValues[45] = 3388*$this->levelCoeff();
				
				if ($this->userData->talent==3){
					$this->statValues[45] = ceil($this->statValues[45]*1.1);
					$this->statValues[3] = ceil($this->statValues[3]*1.15);
					$this->statValues[16] += 3;
					$this->statValues[19] += 3;
				}
				if ($this->userData->talent==2){
					$this->statValues[3] += $this->statValues[3]*0.03;
					$this->statValues[5] += $this->statValues[5]*0.09;
					$this->statValues[24] += 0.45*$this->statValues[5];
					$this->statValues[24] += $this->statValues[24]*0.1;
				}
				
				$this->statValues[24] += $this->statValues[3]; //ranged attack power
				$this->statValues[19] += $this->statValues[3]*0.025;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.04, 2);
				$this->statValues[21] += $this->statValues[5]*0.0125;
				
				$this->statValues[19] += 5; // Talent
				if ($this->userData->race==3)
					$this->statValues[13] += 1;
				if ($this->userData->race==7)
					$this->statValues[19] += 1;
				if ($this->userData->race==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] += 3103*$this->levelCoeff();
				break;
			case 5 :
				// Taking tauren druid stats
				$this->statValues[13] = $this->statValues[13]*0.052894736;
				$this->statValues[16] = $this->statValues[16]*0.063333333;
				$this->statValues[19] = $this->statValues[19]*0.045263157;
				$this->statValues[21] = $this->statValues[21]*0.045554545454545;
				$this->statValues[18] = $this->statValues[18]*0.0794444444;
				
				$this->statValues[19] += 0.9;
				$this->statValues[21] += 1.8662;
				$this->statValues[13] += -1.87;
				$this->statValues[14] = 0;
				$this->statValues[15] = 0;
				
				$this->statValues[3] += 65*$this->levelCoeff();
				$this->statValues[4] += 81*$this->levelCoeff();
				$this->statValues[5] += 115*$this->levelCoeff();
				$this->statValues[6] += 135*$this->levelCoeff();
				$this->statValues[7] += 85*$this->levelCoeff();
				$this->statValues[24] += -5*$this->levelCoeff();
				$this->statValues[45] = 3434*$this->levelCoeff();
				
				if ($this->userData->talent==2){
					$this->statValues[3] += $this->statValues[3]*0.03;
					$this->statValues[4] += $this->statValues[4]*0.03;
					$this->statValues[5] += $this->statValues[5]*0.03;
					$this->statValues[6] += $this->statValues[6]*0.03;
					$this->statValues[7] += $this->statValues[7]*0.03;
					$this->statValues[5] += $this->statValues[5]*0.2;
				}
				
				$this->statValues[24] += $this->statValues[4]*1.818181818181;
				$this->statValues[19] += $this->statValues[3]*0.04;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.068, 2);
				
				$this->statValues[21] += $this->statValues[5]*0.012380952;
				
				$defense = $this->statValues[12]-350; // Gotta add this for vanilla
				$this->statValues[13] += $defense*0.016842104;
				
				if ($this->userData->talent==1){
					$this->statValues[21] += 4;
					$this->statValues[22] += $this->statValues[5]*0.24;
					$this->statValues[23] += $this->statValues[5]*0.24;
					$this->statValues[18] += 4;
				}
				
				if ($this->userData->talent==2){
					$this->statValues[5] = ceil($this->statValues[5]*1.2);
					$this->statValues[38] += $this->statValues[38]*0.12;
				}
				
				if ($this->userData->talent==3){
					$this->statValues[21] += 3;
					$this->statValues[6] += $this->statValues[6]*0.15;
				}
				if ($this->userData->race==3)
					$this->statValues[13] += 1;
				if ($this->userData->race==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] += 2090*$this->levelCoeff();
				break;
			case 6 :
				// Taking troll mage stats
				$this->statValues[21] = $this->statValues[21]*0.045545454545;
				$this->statValues[18] = $this->statValues[18]*0.07933333333;
				$this->statValues[19] += -5.1;
				$this->statValues[21] += 0.85;
				$this->statValues[3] += 41*$this->levelCoeff();
				$this->statValues[4] += 34*$this->levelCoeff();
				$this->statValues[5] += 147*$this->levelCoeff();
				$this->statValues[6] += 146*$this->levelCoeff();
				$this->statValues[7] += 52*$this->levelCoeff();
				$this->statValues[24] += -10*$this->levelCoeff();
				$this->statValues[45] = 3213*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4];
				$this->statValues[19] += $this->statValues[3]*0.124390243;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.124390243, 2);
				$this->statValues[21] += $this->statValues[5]*0.012857142;
				
				$this->statValues[18] += 6; // Talent
				$this->statValues[46] += 1961*$this->levelCoeff();
				
				if ($this->userData->talent==1){
					$this->statValues[5] += $this->statValues[5]*0.15;
					$this->statValues[21] += 3;
					$this->statValues[22] += $this->statValues[22]*0.03;
					$this->statValues[22] += $this->statValues[5]*0.25;
				}
				if ($this->userData->talent==2){
					$this->statValues[22] += $this->statValues[22]*0.03;
					$this->statValues[21] += 9;
				}
				if ($this->userData->race==3)
					$this->statValues[13] += 1;
				if ($this->userData->race==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05);
				if ($this->userData->race==1){
					$this->statValues[19] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				$this->statValues[14] = 0;
				$this->statValues[15] = 0;
				break;
			case 7 :
				// Taking human warlock stats
				$this->statValues[21] = $this->statValues[21]*0.045545454545;
				$this->statValues[18] = $this->statValues[18]*0.07933333333;
				$this->statValues[19] += -4.28;
				$this->statValues[21] += 1.699;
				$this->statValues[3] += 56*$this->levelCoeff();
				$this->statValues[4] += 50*$this->levelCoeff();
				$this->statValues[5] += 131*$this->levelCoeff();
				$this->statValues[6] += 136*$this->levelCoeff();
				$this->statValues[7] += 77*$this->levelCoeff();
				$this->statValues[24] += -10*$this->levelCoeff();
				$this->statValues[45] = 3310*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4];
				$this->statValues[19] += $this->statValues[3]*0.076428571;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.076428571, 2);
				$this->statValues[21] += $this->statValues[5]*0.0122222222;
				
				if ($this->userData->talent==2){
					$this->statValues[7] = ceil($this->statValues[7]*1.15);
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				if ($this->userData->talent==3)
					$this->statValues[21] += 8;
				if ($this->userData->race==3)
					$this->statValues[13] += 1;
				if ($this->userData->race==4)
					$this->statValues[5] = ceil($this->statValues[5]*1.05); // Gnome intellect bonus
				if ($this->userData->race==1){
					$this->statValues[19] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				$this->statValues[46] += 2335*$this->levelCoeff();
				
				$this->statValues[14] = 0;
				$this->statValues[15] = 0;
				break;
			case 8 :
				// Taking blooelf paladin stats
				// Tank stats
				$this->statValues[13] = $this->statValues[13]*0.052857;
				$this->statValues[14] = $this->statValues[14]*0.42380952;
				$this->statValues[26] = $this->statValues[26]*0.126842105;
				
				$this->statValues[13] = $this->statValues[13]*0.052894736;
				$this->statValues[16] = $this->statValues[16]*0.063333333;
				$this->statValues[19] = $this->statValues[19]*0.045263157;
				$this->statValues[21] = $this->statValues[21]*0.045554545454545;
				$this->statValues[18] = $this->statValues[18]*0.0794444444;
				
				$this->statValues[19] += 0.65;
				$this->statValues[21] += 3.3255;
				$this->statValues[13] += 0.65;
				$this->statValues[14] = 5;
				$this->statValues[26] = 5;
				
				$this->statValues[3] += 79*$this->levelCoeff();
				$this->statValues[4] += 123*$this->levelCoeff();
				$this->statValues[5] += 87*$this->levelCoeff();
				$this->statValues[6] += 88*$this->levelCoeff();
				$this->statValues[7] += 119*$this->levelCoeff();
				$this->statValues[24] += 190*$this->levelCoeff();
				$this->statValues[45] = 3197*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.04;
				$this->statValues[38] += ceil($this->statValues[3]*(2-0.001564*$this->statValues[3]));
				$this->statValues[13] += round($this->statValues[3]*0.04, 2);
				$this->statValues[21] += $this->statValues[5]*0.012580645;
				
				if ($this->userData->talent==1){
					$this->statValues[21] += 5;
					$this->statValues[5] = ceil($this->statValues[5]*1.1);
				}
				if ($this->userData->talent!=1){
					$this->statValues[4] = ceil($this->statValues[4]*1.1);
					$this->statValues[16] += 3;
				}
				if ($this->userData->talent==3){
					$this->statValues[19] += 8;
					$this->statValues[21] += 3;
				}
				if ($this->userData->talent==2){
					$this->statValues[12] += 20;
					$this->statValues[38] = ceil($this->statValues[38]*1.1); // 10% more armor?
					$this->statValues[7] += $this->statValues[7]*0.16;
					$this->statValues[14] += 0.2;
					$this->statValues[19] += 0.2;
				}	
				
				$defense = $this->statValues[12]-350; // Gotta add this for vanilla
				$this->statValues[13] += $defense*0.015384615;
				$this->statValues[14] += $defense*0.015384615;
				$this->statValues[26] += $defense*0.015384615;
				
				$this->statValues[15] += $this->statValues[4]*0.055555555555;
				if ($this->userData->race==3)
					$this->statValues[13] += 1;
				if ($this->userData->race==1){
					$this->statValues[19] += 0.2;
					$this->statValues[6] = ceil($this->statValues[6]*1.05);
				}
				$this->statValues[46] += 2673*$this->levelCoeff();
				break;
			case 9 :
				// Taking Troll shamen stats
				// Tank stats
				$this->statValues[13] = $this->statValues[13]*0.052857;
				$this->statValues[14] = $this->statValues[14]*0.42380952;
				$this->statValues[26] = $this->statValues[26]*0.126842105;
				
				$this->statValues[16] = $this->statValues[16]*0.063333333;
				$this->statValues[19] = $this->statValues[19]*0.045263157;
				$this->statValues[21] = $this->statValues[21]*0.045554545454545;
				$this->statValues[18] = $this->statValues[18]*0.0794444444;
				
				$this->statValues[19] += 1.67;
				$this->statValues[21] += 2.19;
				$this->statValues[13] += 1.67;
				$this->statValues[14] = 5;
				$this->statValues[26] = 5;
				
				$this->statValues[3] += 66*$this->levelCoeff();
				$this->statValues[4] += 103*$this->levelCoeff();
				$this->statValues[5] += 104*$this->levelCoeff();
				$this->statValues[6] += 121*$this->levelCoeff();
				$this->statValues[7] += 115*$this->levelCoeff();
				$this->statValues[24] += 120*$this->levelCoeff();
				$this->statValues[45] = 2979*$this->levelCoeff();
				
				$this->statValues[24] += $this->statValues[4]*2;
				$this->statValues[19] += $this->statValues[3]*0.04;
				$this->statValues[21] += $this->statValues[5]*0.012592592;
				$this->statValues[38] += ceil($this->statValues[3]*2);
				$this->statValues[13] += round($this->statValues[3]*0.04, 2);
				$this->statValues[15] += $this->statValues[4]*0.055555555555;
				
				if ($this->userData->talent==1){
					$this->statValues[21] += 5;
					$this->statValues[18] += 6;
				}
				if ($this->userData->talent==2){
					$this->statValues[19] += 5;
					$this->statValues[13] += 6;
				}
				if ($this->userData->talent!=3){
					$this->statValues[16] += 3;
					$this->statValues[18] += 3;
				}
				if ($this->userData->talent!=2)
					$this->statValues[14] = 0;	
				
				if ($this->userData->race==5)
					$this->statValues[19] += 0.2;
				if ($this->userData->race==8)
					$this->statValues[45] = ceil($this->statValues[45]*1.05);
				$this->statValues[46] = 2678*$this->levelCoeff();
				if ($this->userData->talent==3){
					$this->statValues[46] += ceil($this->statValues[46]*1.05);
					$this->statValues[21] += 5;
				}
				if ($this->userData->race==3)
					$this->statValues[13] += 1;
				break;
		}
		$this->statValues[45] += $this->statValues[7]*10;
		if ($this->classid!=2 && $this->classid!=1){
			$this->statValues[46] += $this->statValues[5]*15;
			// Mana regen outfight
			$this->statValues[54] += $this->statValues[46]*0.0002580376887*$this->statValues[6];
			if ($this->userData->classid==6 && $this->userData->talent==1)
				$this->statValues[0] += $this->statValues[54]*0.3;
		}
		if ($this->userData->race==8 or $this->userData->race==3)
			$this->statValues[41] += 10;
		if ($this->userData->race==2)
			$this->statValues[42] += 10;
		if ($this->userData->race==6)
			$this->statValues[43] += 10;
		if ($this->userData->race==9){
			$this->statValues[13] += 1;
			$this->statValues[18] += 1;
		}
		if ($this->userData->race==10){
			$this->statValues[39] += 5;
			$this->statValues[40] += 5;
			$this->statValues[41] += 5;
			$this->statValues[42] += 5;
			$this->statValues[43] += 5;
			$this->statValues[44] += 5; 
		}
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
	
	public function content(){
		$content = '
		<style type="text/css">
			#dummy';
		$existingItems = array();
		for ($i=1; $i<=19;$i++){
			if (isset($this->itemTemplate[$this->itemSet->{"item".$i}]->entry)){
				$content .= ',#item'.$this->itemTemplate[$this->itemSet->{"item".$i}]->entry;
				$existingItems[$this->itemTemplate[$this->itemSet->{"item".$i}]->entry] = true;
			}
		}
		$content .= '{color:#1eff00!important;}
			.set0';
		$existSet = array();
		for ($i=1; $i<=19;$i++){
			if (intval($this->itemTemplate[$this->itemSet->{"item".$i}]->itemset)>0){
				if (!isset($existSet[$this->itemTemplate[$this->itemSet->{"item".$i}]->itemset])){
					$count = 0;
					$setids = explode(",", $this->itemTemplate[$this->itemSet->{"item".$i}]->setids);
					foreach($setids as $var){
						if (isset($existingItems[$var]))
							$count++;
					}
					$content .= ', .set'.$this->itemTemplate[$this->itemSet->{"item".$i}]->itemset.$count;
					$existSet[$this->itemTemplate[$this->itemSet->{"item".$i}]->itemset] = $count;
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
					$this->statValues[13] += $this->enchTemplate[$effectids[$key]]->dodge*0.052857;
					$this->statValues[15] += $this->enchTemplate[$effectids[$key]]->block;
					$this->statValues[26] += $this->enchTemplate[$effectids[$key]]->blockchance*0.126842105;
					$this->statValues[16] += $this->enchTemplate[$effectids[$key]]->hit*0.063333333;
					$this->statValues[18] += $this->enchTemplate[$effectids[$key]]->spellhit*0.0794444444;
					$this->statValues[19] += $this->enchTemplate[$effectids[$key]]->crit*0.045263157;
					$this->statValues[21] += $this->enchTemplate[$effectids[$key]]->spellcrit*0.045454545454545;
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
					$this->statValues[59] += $this->enchTemplate[$effectids[$key]]->spellhaste;
					$this->statValues[60] += $this->enchTemplate[$effectids[$key]]->resilience;
				}
			}
		}
		//$this->statValues[58] = $this->statValues[58]*0.053875;
		//$this->statValues[59] = $this->statValues[59]*0.0625;
		$this->statValues[57] = floor($this->statValues[57]/4);
		$talentvt = explode(",",$this->userData->talentvt);
		$content .= '
		</style>
		<div class="container cont" id="container">
			<section class="centredNormal top">
				<div class="ttitle">
					<img src="{path}TBC/Character/img/'.$this->faction.'.png"> <span class="color-'.strtolower($this->classById[$this->classid]).'">'.$this->name.'</span> <span><a class="'.$this->faction.'" href="{path}TBC/Guild/'.$this->sname.'/'.$this->gname.'/0">&lt;'.substr($this->gname, 0, 22).'&gt;</a></span> on '.$this->sname.'
				</div>
				<a href="{path}TBC/CharacterDesigner/index.php?items='.implode(",", $this->itemString).'&enchants='.implode(",", $this->enchantString).'&sockets='.implode(",", $this->socketString).'&misc='.intval($this->userData->race).','.intval($this->userData->gender).','.intval($this->userData->classid).','.intval($this->userData->talent).'"><div class="pseudoButton" style="width:100px">Designer</div></a>
				<a href=""><div class="pseudoButton">Achievements</div></a>
				<a href="{path}TBC/Character/'.$this->sname.'/'.$this->name.'/0"><div class="pseudoButton">Raidstats</div></a>
				<select onchange="window.location.replace(\'{path}TBC/Armory/'.$this->sname.'/'.$this->name.'/\'+this.value);">
					<option value="0"'.($r = ($this->mode==0) ? " selected" : "").'>Last Itemset</option>
					<option value="1"'.($r = ($this->mode==1) ? " selected" : "").'>Itemset 1</option>
					<option value="2"'.($r = ($this->mode==2) ? " selected" : "").'>Itemset 2</option>
					<option value="3"'.($r = ($this->mode==3) ? " selected" : "").'>Itemset 3</option>
				</select>
			</section>
			<section class="centredNormal" style="overflow: hidden;">
				<section class="sleft">
					<table cellspacing="0" class="ts nhalf">
						<thead>
							<tr>
								<th>Talent specialization</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="pve"><img src="{path}Database/icons/medium/'.$this->classSpecsIcons[$this->classid][intval($this->userData->talent)].'.jpg" />'.$this->classSpecs[$this->classid][intval($this->userData->talent)].' ('.$talentvt[0].'|'.$talentvt[1].'|'.$talentvt[2].')</td>
							</tr>
						</tbody>
					</table>
					<table cellspacing="0" class="ts nhalf tablemargin">
						<thead>
							<tr>
								<th colspan="2">Professions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<tr style="text-align: center;">
									<td class="pve"><img src="{path}Database/icons/medium/'.$this->professions[intval($this->userData->prof1)].'.jpg" /></td>
									<td class="pve"><img src="{path}Database/icons/medium/'.$this->professions[intval($this->userData->prof2)].'.jpg" /></td>
								</tr>
							</tr>
						</tbody>
					</table>
					<table cellspacing="0" class="ts margin-top">
						<thead>
							<tr>
								<th>Guildhistory</th>
							</tr>
						</thead>
						<tbody>
							<tr>
		';
		foreach($this->db->query('SELECT guildid, name, faction FROM `armory-guildhistory` a LEFT JOIN guilds b ON a.guildid = b.id WHERE charid = "'.$this->charid.'"') as $row){
			$fac = ($row->faction==-1) ? "horde" : "alliance";
			$content .= '
								<tr>
									<td class="'.$fac.'"><img src="{path}TBC/Armory/img/'.$fac.'.png" />'.$row->name.'</td>
								</tr>
			';
		}
		$content .= '
							</tr>
						</tbody>
					</table>
					<table cellspacing="0" class="ts margin-top">
						<thead>
							<tr>
								<th colspan="2">Itemhistory</th>
							</tr>
						</thead>
						<tbody>
							<tr>
		';
		foreach($this->db->query('SELECT group_concat(item) as items, timestamp FROM `armory-itemhistory` WHERE charid = "'.$this->charid.'" GROUP BY timestamp ORDER BY timestamp DESC LIMIT 9') as $row){
			$content .= '
								<tr>
									<td class="items">
			';
			foreach(explode(",", $row->items) as $var){
				$content .= '
										<div class="item qe'.$this->itemTemplate[$var]->quality.'" style="background-image: url(\'{path}Database/icons/medium/'.$this->itemTemplate[$var]->icon.'.jpg\');">
											<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$var.'"><div class="a">'.$this->itemTemplate[$var]->amount.'</div></a>
											<a href="https://TBC-twinhead.twinstar.cz/?item='.$var.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
										</div>
				';
			}
			$content .= '
									</td>
									<td class="date">'.date("d.m.y", $row->timestamp).'</td>
								</tr>
			';
		}
		$content .= '
								<tr>
									<td class="earlier" colspan="2"><a href="{path}TBC/Armory/Earlier/'.$this->sname.'/'.$this->name.'">View earlier</a></td>
								</tr>
							</tr>
						</tbody>
					</table>
				</section>
				<section class="sright" style="background-image: url(\'{path}TBC/Armory/img/'.($r = ($this->userData->pic==1) ? $this->sname.'/'.$this->name : strtolower($this->gender[$this->userData->gender]).strtolower($this->race[$this->userData->race])).'.png\');">
					<div class="gearframe">
						<div class="gleft">
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item1]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item1]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item1.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item1]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item1.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item2]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item2]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item2.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item2]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item2.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item3]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item3]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item3.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item3]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item3.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item15]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item15]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item15.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item15]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item15.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item5]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item5]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item5.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item5]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item5.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item4]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item4]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item4.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item4]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item4.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item19]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item19]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item19.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item19]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item19.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item9]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item9]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item9.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item9]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item9.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
						</div>
						<div class="gmiddle">
							<div class="description">
								'.$this->getNameString().$this->getGuildRank().'
							</div>
							<div class="resistances">
								<a href="{path}TBC/Armory/SetAvatar/'.$this->sname.'/'.$this->name.'"><div id="setavatar" title="Set custom wallpaper"></div></a>
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
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item10]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item10]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item10.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item10]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item10.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item6]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item6]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item6.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item6]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item6.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item7]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item7]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item7.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item7]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item7.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item8]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item8]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item8.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item8]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item8.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item11]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item11]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item11.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item11]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item11.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item12]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item12]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item12.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item12]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item12.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item13]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item13]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item13.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item13]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item13.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item14]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item14]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item14.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item14]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item14.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
						</div>
						<div class="gbottom">
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item16]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item16]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item16.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item16]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item16.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item17]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item17]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item17.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item17]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item17.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
							</div>
							<div class="item qe'.$this->itemTemplate[$this->itemSet->item18]->quality.' large" style="background-image: url(\'{path}Database/icons/large/'.$this->itemTemplate[$this->itemSet->item18]->icon.'.jpg\');">
								<a href="{path}TBC/Armory/Items/'.$this->sname.'/'.$this->itemSet->item18.'"><div class="a">'.$this->itemTemplate[$this->itemSet->item18]->amount.'</div></a>
								<a href="https://TBC-twinhead.twinstar.cz/?item='.$this->itemSet->item18.'&armory='.$this->userData->charid.'" target="_blank"><div class="b"></div></a>
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
					<div class="stats table">
						<script>function pnext(a){for(i=1; i<4; i++){document.getElementById("pstat"+i).style.display = "none";};document.getElementById(a).style.display="block";}</script>
						<div class="right">
							<table cellspacing="0" class="ts half">
								<thead>
									<th colspan="2" title="Last updated: '.$this->getSeenString($this->userData->seen).'">PvP Stats*</th>
								</thead>
								<tbody>
									<tr>
										<td>Lifetime HK</td>
										<td>'.$this->userData->lhk.'</td>
									</tr>
									<tr>
										<td>Yesterday HK</td>
										<td>'.$this->userData->yhk.'</td>
									</tr>
									<tr>
										<td>Today HK</td>
										<td>'.$this->userData->thk.'</td>
									</tr>
								</tbody>
							</table>
							<table cellspacing="0" class="ts half tablemargin" id="pstat1">
								<thead>
									<th colspan="2">
										2v2 Arena
										<div class="next" onClick="pnext(\'pstat2\')">&gt;</div>
										<div class="prev" onClick="pnext(\'pstat3\')">&lt;</div>
									</th>
								</thead>
								<tbody>
									<tr>
										<td>Name</td>
										<td><a href="{path}TBC/Team/'.$this->sname.'/'.$this->arena[0]->name.'">'.$this->arena[0]->name.'</a></td>
									</tr>
									<tr>
										<td>Rating</td>
										<td>'.$this->arena[0]->rating.'</td>
									</tr>
									<tr>
										<td>Games</td>
										<td>'.$this->arena[0]->games.'</td>
									</tr>
									<tr>
										<td>Wins</td>
										<td>'.$this->arena[0]->wins.'</td>
									</tr>
								</tbody>
							</table>
							<table cellspacing="0" class="ts half tablemargin hidden" id="pstat2">
								<thead>
									<th colspan="2">
										3v3 Arena
										<div class="next" onClick="pnext(\'pstat3\')">&gt;</div>
										<div class="prev" onClick="pnext(\'pstat1\')">&lt;</div>
									</th>
								</thead>
								<tbody>
									<tr>
										<td>Name</td>
										<td><a href="{path}TBC/Team/'.$this->sname.'/'.$this->arena[1]->name.'">'.$this->arena[1]->name.'</a></td>
									</tr>
									<tr>
										<td>Rating</td>
										<td>'.$this->arena[1]->rating.'</td>
									</tr>
									<tr>
										<td>Games</td>
										<td>'.$this->arena[1]->games.'</td>
									</tr>
									<tr>
										<td>Wins</td>
										<td>'.$this->arena[1]->wins.'</td>
									</tr>
								</tbody>
							</table>
							<table cellspacing="0" class="ts half tablemargin hidden" id="pstat3">
								<thead>
									<th colspan="2">
										5v5 Arena
										<div class="next" onClick="pnext(\'pstat1\')">&gt;</div>
										<div class="prev" onClick="pnext(\'pstat2\')">&lt;</div>
									</th>
								</thead>
								<tbody>
									<tr>
										<td>Name</td>
										<td><a href="{path}TBC/Team/'.$this->sname.'/'.$this->arena[2]->name.'">'.$this->arena[2]->name.'</a></td>
									</tr>
									<tr>
										<td>Rating</td>
										<td>'.$this->arena[2]->rating.'</td>
									</tr>
									<tr>
										<td>Games</td>
										<td>'.$this->arena[2]->games.'</td>
									</tr>
									<tr>
										<td>Wins</td>
										<td>'.$this->arena[2]->wins.'</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</section>
			</section>
		</div>
		<script>
		';
		if (in_array($this->classid, array(1,2,4)))
			$content .= 'next(\'stat2\');';
		else
			$content .= 'next(\'stat3\');';
		$content .= '
		</script>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $server, $name, $mode){
		$name = $this->antiSQLInjection($name);
		$server = $this->antiSQLInjection($server);
		$mode = $this->antiSQLInjection($mode);
		$this->mode = intval($mode);
		$this->getUserData($db, $server, $name);
		$this->getItemTemplate($db);
		$this->getEnchantmentTemplate($db);
		$this->getStatValues();
		$this->siteTitle = " - Armory of ".$name." on ".$server;
		$this->keyWords = $name;
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js");
		$this->addJsLink("{path}External/TwinheadTooltip/functions.js");
		$this->addJsLink("{path}External/TwinheadTooltip/tooltip.js");
		$this->addJsLink("{path}External/TwinheadTooltip/twinhead_tooltip.js");
		$this->addCssLink("{path}External/TwinheadTooltip/twinhead_tooltip.css");
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["server"], $_GET["name"], $_GET["mode"]);

?>