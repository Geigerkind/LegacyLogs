<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$pdo2 = new PDO('mysql:host=localhost;dbname=world_tbc', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// Gettings all parsed items
$itemsNew = array();
foreach($pdo->query('SELECT * FROM `item_template-tbc`') as $row){
	$itemsNew[$row["entry"]] = $row;
}


// Gettings all non parsed items
$itemsNon = array();
foreach($pdo2->query('SELECT * FROM item_template') as $row){
	$itemsNon[$row["entry"]] = $row;
}

// Getting SpellDCB
$spellDBC = array();
foreach($pdo->query('SELECT column_1, column_81, column_82, column_128, column_162 FROM spelldbc') as $row){
	$spellDBC[$row["column_1"]] = $row;
}

function setUpVal(&$val, $num){
	if (!isset($val))
		$val = $num;
	else
		$val += $num;
}

// Setting itemValues
$items = array();
foreach($itemsNon as $k => $v){
	if (!isset($items[$k]))
		$items[$k] = array();
	for ($i=1; $i<6; $i++){
		if ($itemsNon[$k]["spellid_".$i] == 0)
			break 1;
		$str = strtolower($spellDBC[$itemsNon[$k]["spellid_".$i]]["column_162"]);
		$num = intval($spellDBC[$itemsNon[$k]["spellid_".$i]]["column_81"])+1;
		$num2 = intval($spellDBC[$itemsNon[$k]["spellid_".$i]]["column_82"])+1;
		
		if (strpos($str, " for "))
			continue;
		if (strlen($str)>100)
			continue;
		
		if (strpos($str, "spell haste rating")){
			setUpVal($items[$k]["spellhaste"], $num);
			continue;
		}
		
		if (strpos($str, "haste rating")){
			setUpVal($items[$k]["haste"], $num);
			continue;
		}
		
		if (strpos($str, "dodge rating")){
			setUpVal($items[$k]["dodge"], $num);
			continue;
		}
		
		if (strpos($str, "parry rating")){
			setUpVal($items[$k]["parry"], $num);
			continue;
		}
		
		if (strpos($str, "resilience rating")){
			setUpVal($items[$k]["resilience"], $num);
			continue;
		}
		
		if (strpos($str, "damage done and healing done")){
			setUpVal($items[$k]["healpower"], $num);
			setUpVal($items[$k]["spellpower"], $num);
			continue;
		}
		
		if (strpos($str, "healing done") && strpos($str, "damage done")){
			setUpVal($items[$k]["healpower"], $num);
			setUpVal($items[$k]["spellpower"], $num2);
			continue;
		}
		
		if (strpos($str, "damage and healing done")){
			setUpVal($items[$k]["healpower"], $num);
			setUpVal($items[$k]["spellpower"], $num);
			continue;
		}
		
		if (strpos($str, "damage done by shadow")){
			setUpVal($items[$k]["spellshadow"], $num);
			continue;
		}
		
		if (strpos($str, "damage done by holy")){
			setUpVal($items[$k]["spellholy"], $num);
			continue;
		}
		
		if (strpos($str, "damage done by nature")){
			setUpVal($items[$k]["spellnature"], $num);
			continue;
		}
		
		if (strpos($str, "damage done by fire")){
			setUpVal($items[$k]["spellfire"], $num);
			continue;
		}
		
		if (strpos($str, "damage done by frost")){
			setUpVal($items[$k]["spellfrost"], $num);
			continue;
		}
		
		if (strpos($str, "damage done by arcane")){
			setUpVal($items[$k]["spellarcane"], $num);
			continue;
		}
		
		if (strpos($str, "spell critical strike rating")){
			setUpVal($items[$k]["spellcrit"], $num);
			continue;
		}
		
		if (strpos($str, "critical strike rating")){
			setUpVal($items[$k]["crit"], $num);
			continue;
		}
		
		if (strpos($str, "attack power")){
			setUpVal($items[$k]["apower"], $num);
			continue;
		}
		
		if (strpos($str, "mana per")){
			setUpVal($items[$k]["manaregen"], $num);
			continue;
		}
		
		if (strpos($str, "block value")){
			setUpVal($items[$k]["block"], $num);
			continue;
		}
		
		if (strpos($str, "defense rating")){
			setUpVal($items[$k]["defense"], $num);
			continue;
		}
		
		if (strpos($str, "block rating")){
			setUpVal($items[$k]["blockchance"], $num);
			continue;
		}
		
		if (strpos($str, "expertise rating")){
			setUpVal($items[$k]["expertise"], $num);
			continue;
		}
		
		if (strpos($str, "spell hit rating")){
			setUpVal($items[$k]["spellhit"], $num);
			continue;
		}
		
		if (strpos($str, "hit rating")){
			setUpVal($items[$k]["hit"], $num);
			continue;
		}
		
		if (strpos($str, "attacks ignore")){
			setUpVal($items[$k]["armorpen"], $num*(-1));
			continue;
		}
	}
	
	for ($i=1; $i<11; $i++){
		$num = intval($itemsNon[$k]["stat_value".$i]);
		switch($itemsNon[$k]["stat_type".$i]){
			case 0 :
				setUpVal($items[$k]["mana"], $num);
				break 1;
			case 1 :
				setUpVal($items[$k]["health"], $num);
				break 1;
			case 3 :
				setUpVal($items[$k]["agility"], $num);
				break 1;
			case 4 :
				setUpVal($items[$k]["strength"], $num);
				break 1;
			case 5 :
				setUpVal($items[$k]["intellect"], $num);
				break 1;
			case 6 :
				setUpVal($items[$k]["spirit"], $num);
				break 1;
			case 7 :
				setUpVal($items[$k]["stamina"], $num);
				break 1;
			case 12 :
				setUpVal($items[$k]["defense"], $num);
				break 1;
			case 13 :
				setUpVal($items[$k]["dodge"], $num);
				break 1;
			case 14 :
				setUpVal($items[$k]["parry"], $num);
				break 1;
			case 15 :
				setUpVal($items[$k]["blockchance"], $num);
				break 1;
			case 16 :
				setUpVal($items[$k]["hit"], $num);
				break 1;
			case 17 :
				setUpVal($items[$k]["hit"], $num);
				break 1;
			case 18 :
				setUpVal($items[$k]["spellhit"], $num);
				break 1;
			case 19 :
				setUpVal($items[$k]["crit"], $num);
				break 1;
			case 20 :
				setUpVal($items[$k]["crit"], $num);
				break 1;
			case 21 :
				setUpVal($items[$k]["spellcrit"], $num);
				break 1;
			case 28 :
				setUpVal($items[$k]["haste"], $num);
				break 1;
			case 29 :
				setUpVal($items[$k]["haste"], $num);
				break 1;
			case 30 :
				setUpVal($items[$k]["spellhaste"], $num);
				break 1;
			case 31 :
				setUpVal($items[$k]["hit"], $num);
				setUpVal($items[$k]["spellhit"], $num);
				break 1;
			case 32 :
				setUpVal($items[$k]["crit"], $num);
				setUpVal($items[$k]["spellcrit"], $num);
				break 1;
			case 35 :
				setUpVal($items[$k]["resilience"], $num);
				break 1;
			case 36 :
				setUpVal($items[$k]["haste"], $num);
				setUpVal($items[$k]["spellhaste"], $num);
				break 1;
			case 37 :
				setUpVal($items[$k]["expertise"], $num);
				break 1;
			case 38 :
				setUpVal($items[$k]["apower"], $num);
				break 1;
			case 39 :
				setUpVal($items[$k]["apower"], $num);
				break 1;
			case 41 :
				setUpVal($items[$k]["healpower"], $num);
				break 1;
			case 42 :
				setUpVal($items[$k]["spellpower"], $num);
				break 1;
			case 43 :
				setUpVal($items[$k]["manaregen"], $num);
				break 1;
			case 44 :
				setUpVal($items[$k]["armorpen"], $num*(-1));
				break 1;
			case 45 :
				setUpVal($items[$k]["spellpower"], $num);
				break 1;
			case 47 :
				setUpVal($items[$k]["spellpen"], $num);
				break 1;
			case 48 :
				setUpVal($items[$k]["block"], $num);
				break 1;
		}
	}
	
	setUpVal($items[$k]["block"], $itemsNon[$k]["block"]);
	setUpVal($items[$k]["armor"], $itemsNon[$k]["armor"]);
	setUpVal($items[$k]["holy_res"], $itemsNon[$k]["holy_res"]);
	setUpVal($items[$k]["fire_res"], $itemsNon[$k]["fire_res"]);
	setUpVal($items[$k]["nature_res"], $itemsNon[$k]["nature_res"]);
	setUpVal($items[$k]["frost_res"], $itemsNon[$k]["frost_res"]);
	setUpVal($items[$k]["shadow_res"], $itemsNon[$k]["shadow_res"]);
	setUpVal($items[$k]["arcane_res"], $itemsNon[$k]["arcane_res"]);
	$items[$k]["name"] = $itemsNon[$k]["name"];
	$items[$k]["icon"] = $itemsNew[$k]["icon"];
	$items[$k]["extraTooltip"] = $itemsNew[$k]["extraTooltip"];
	$items[$k]["quality"] = $itemsNon[$k]["Quality"];
	$items[$k]["inventorytype"] = $itemsNon[$k]["InventoryType"];
	$items[$k]["class"] = $itemsNon[$k]["class"];
	$items[$k]["subclass"] = $itemsNon[$k]["subclass"];
	$items[$k]["RequiredLevel"] = $itemsNon[$k]["RequiredLevel"];
	$items[$k]["bonding"] = $itemsNon[$k]["bonding"];
	$items[$k]["sheath"] = $itemsNon[$k]["sheath"];
	$items[$k]["itemset"] = $itemsNon[$k]["itemset"];
	$items[$k]["Flags"] = $itemsNon[$k]["Flags"];
	$items[$k]["MaxDurability"] = $itemsNon[$k]["MaxDurability"];
	$items[$k]["ItemLevel"] = $itemsNon[$k]["ItemLevel"];
	$items[$k]["delay"] = $itemsNon[$k]["delay"];
	$items[$k]["dmg_min1"] = $itemsNon[$k]["dmg_min1"];
	$items[$k]["dmg_max1"] = $itemsNon[$k]["dmg_max1"];
	$items[$k]["dmg_type1"] = $itemsNon[$k]["dmg_type1"];
	$items[$k]["dmg_min2"] = $itemsNon[$k]["dmg_min2"];
	$items[$k]["dmg_max2"] = $itemsNon[$k]["dmg_max2"];
	$items[$k]["dmg_type2"] = $itemsNon[$k]["dmg_type2"];
	$items[$k]["dmg_min3"] = $itemsNon[$k]["dmg_min3"];
	$items[$k]["dmg_max3"] = $itemsNon[$k]["dmg_max3"];
	$items[$k]["dmg_type3"] = $itemsNon[$k]["dmg_type3"];
	$items[$k]["socketColor_1"] = $itemsNon[$k]["socketColor_1"];
	$items[$k]["socketColor_2"] = $itemsNon[$k]["socketColor_2"];
	$items[$k]["socketColor_3"] = $itemsNon[$k]["socketColor_3"];
	$items[$k]["socketBonus"] = $itemsNon[$k]["socketBonus"];
}

// Update this shiet!

$pdo->query('DELETE FROM `item_template-tbc`');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$sql = 'INSERT INTO `item_template-tbc` (entry, name, icon, quality, inventorytype, armor, holy_res, fire_res, nature_res, frost_res, shadow_res, arcane_res, hit, crit, apower, dodge, parry, block, spellpower, healpower, manaregen, defense, spellhit, spellcrit, blockchance, strength, agility, stamina, intellect, spirit, resilience, haste, spellhaste, armorpen, expertise, spellpen,
class,subclass,RequiredLevel,bonding,sheath,itemset,Flags,MaxDurability,ItemLevel,delay,dmg_min1,dmg_max1,dmg_type1,dmg_min2,dmg_max2,dmg_type2,dmg_min3,dmg_max3,dmg_type3,socketColor_1,socketColor_2,socketColor_3,socketBonus, extraTooltip, spellshadow, spellholy, spellnature, spellfire, spellfrost, spellarcane) VALUES ';
$insertQuery = array();
$insertData = array();
foreach($items as $k => $v){
	$insertQuery[] = '(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
	$insertData[] = $k;
	$insertData[] = $v["name"];
	$insertData[] = $v["icon"];
	$insertData[] = intval($v["quality"]);
	$insertData[] = intval($v["inventorytype"]);
	$insertData[] = intval($v["armor"]);
	$insertData[] = intval($v["holy_res"]);
	$insertData[] = intval($v["fire_res"]);
	$insertData[] = intval($v["nature_res"]);
	$insertData[] = intval($v["frost_res"]);
	$insertData[] = intval($v["shadow_res"]);
	$insertData[] = intval($v["arcane_res"]);
	$insertData[] = intval($v["hit"]);
	$insertData[] = intval($v["crit"]);
	$insertData[] = intval($v["apower"]);
	$insertData[] = intval($v["dodge"]);
	$insertData[] = intval($v["parry"]);
	$insertData[] = intval($v["block"]);
	$insertData[] = intval($v["spellpower"]);
	$insertData[] = intval($v["healpower"]);
	$insertData[] = intval($v["manaregen"]);
	$insertData[] = intval($v["defense"]);
	$insertData[] = intval($v["spellhit"]);
	$insertData[] = intval($v["spellcrit"]);
	$insertData[] = intval($v["blockchance"]);
	$insertData[] = intval($v["strength"]);
	$insertData[] = intval($v["agility"]);
	$insertData[] = intval($v["stamina"]);
	$insertData[] = intval($v["intellect"]);
	$insertData[] = intval($v["spirit"]);
	$insertData[] = intval($v["resilience"]);
	$insertData[] = intval($v["haste"]);
	$insertData[] = intval($v["spellhaste"]);
	$insertData[] = intval($v["armorpen"]);
	$insertData[] = intval($v["expertise"]);
	$insertData[] = intval($v["spellpen"]);
	$insertData[] = intval($v["class"]);
	$insertData[] = intval($v["subclass"]);
	$insertData[] = intval($v["RequiredLevel"]);
	$insertData[] = intval($v["bonding"]);
	$insertData[] = intval($v["sheath"]);
	$insertData[] = intval($v["itemset"]);
	$insertData[] = intval($v["Flags"]);
	$insertData[] = intval($v["MaxDurability"]);
	$insertData[] = intval($v["ItemLevel"]);
	$insertData[] = intval($v["delay"]);
	$insertData[] = intval($v["dmg_min1"]);
	$insertData[] = intval($v["dmg_max1"]);
	$insertData[] = intval($v["dmg_type1"]);
	$insertData[] = intval($v["dmg_min2"]);
	$insertData[] = intval($v["dmg_max2"]);
	$insertData[] = intval($v["dmg_type2"]);
	$insertData[] = intval($v["dmg_min3"]);
	$insertData[] = intval($v["dmg_max3"]);
	$insertData[] = intval($v["dmg_type3"]);
	$insertData[] = intval($v["socketColor_1"]);
	$insertData[] = intval($v["socketColor_2"]);
	$insertData[] = intval($v["socketColor_3"]);
	$insertData[] = intval($v["socketBonus"]);
	$insertData[] = $v["extraTooltip"];
	$insertData[] = intval($v["spellshadow"]);
	$insertData[] = intval($v["spellholy"]);
	$insertData[] = intval($v["spellnature"]);
	$insertData[] = intval($v["spellfire"]);
	$insertData[] = intval($v["spellfrost"]);
	$insertData[] = intval($v["spellarcane"]);
}

if (!empty($insertQuery)) {
	$sql .= implode(', ', $insertQuery);
	$stmt = $pdo->prepare($sql);
	$stmt->execute($insertData);
}





?>