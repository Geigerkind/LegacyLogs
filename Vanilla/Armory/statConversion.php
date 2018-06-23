<?php
error_reporting(0);
$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$pdo2 = new PDO('mysql:host=localhost;dbname=world_vanilla', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// Gettings all parsed items
$items = array();
foreach($pdo->query('SELECT * FROM item_template') as $row){
	$items[$row["entry"]] = $row;
}

// Gettings all non parsed items
$itemsNon = array();
foreach($pdo2->query('SELECT * FROM item_template') as $row){
	$itemsNon[$row["entry"]] = $row;
}

// Getting SpellDCB
$spellDBC = array();
foreach($pdo->query('SELECT column_1 as Field01, column_121 as Field121, column_139 as Field139 FROM spelldbc_vanilla') as $row){
	$spellDBC[$row["Field01"]] = $row;
}
// Setting itemValues
$getSpellDefenseByHack = array();
$getSpellManaRegenByHack = array();
$getSpellSpellCriticalByHack = array();
foreach($items as $k => $v){
	$items[$k]["armor"] = 0;
	$items[$k]["holy_res"] = 0;
	$items[$k]["fire_res"] = 0;
	$items[$k]["nature_res"] = 0;
	$items[$k]["shadow_res"] = 0;
	$items[$k]["arcane_res"] = 0;
	$items[$k]["hit"] = 0;
	$items[$k]["crit"] = 0;
	$items[$k]["apower"] = 0;
	$items[$k]["dodge"] = 0;
	$items[$k]["parry"] = 0;
	$items[$k]["block"] = 0;
	$items[$k]["spellpower"] = 0;
	$items[$k]["healpower"] = 0;
	$items[$k]["spellholy"] = 0;
	$items[$k]["spellfire"] = 0;
	$items[$k]["spellfrost"] = 0;
	$items[$k]["spellnature"] = 0;
	$items[$k]["spellshadow"] = 0;
	$items[$k]["spellarcane"] = 0;
	$items[$k]["manaregen"] = 0;
	$items[$k]["defense"] = 0;
	$items[$k]["spellhit"] = 0;
	$items[$k]["spellcrit"] = 0;
	$items[$k]["rangedapower"] = 0;
	$items[$k]["blockchance"] = 0;
	$items[$k]["strength"] = 0;
	$items[$k]["agility"] = 0;
	$items[$k]["stamina"] = 0;
	$items[$k]["intellect"] = 0;
	$items[$k]["spirit"] = 0;
	for ($i=1; $i<6; $i++){
		if ($itemsNon[$k]["spellid_".$i] == 0)
			break 1;
		
		$g = array();
		preg_match("/\"Increased Hit Chance (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["hit"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Critical (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["crit"] += $g[1];
		
		$g = array();
		preg_match("/\"Attack Power (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["apower"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Dodge (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["dodge"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Parry (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["parry"] += $g[1];
		
		$g = array();
		preg_match("/\"Block Value (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["block"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Spell Dam (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellpower"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Healing (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["healpower"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Holy Dam (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellholy"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Fire Dam (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellfire"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Frost Dam (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellfrost"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Nature Dam (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellnature"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Shadow Dam (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellshadow"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Arcane Dam (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellarcane"] += $g[1];
		
		if (preg_match("/\"Increased Mana Regen\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"])){
			if (!isset($getSpellManaRegenByHack[$itemsNon[$k]["spellid_".$i]]))
				$getSpellManaRegenByHack[$itemsNon[$k]["spellid_".$i]] = array();
			array_push($getSpellManaRegenByHack[$itemsNon[$k]["spellid_".$i]], $k);
		}
		
		if (preg_match("/\"Increased Defense\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"])){
			if (!isset($getSpellDefenseByHack[$itemsNon[$k]["spellid_".$i]]))
				$getSpellDefenseByHack[$itemsNon[$k]["spellid_".$i]] = array();
			array_push($getSpellDefenseByHack[$itemsNon[$k]["spellid_".$i]], $k);
		}
		
		$g = array();
		preg_match("/\"Increased Spell Hit Chance (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellhit"] += $g[1];
		
		if (preg_match("/\"Increased Critical Spell\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"])){
			if (!isset($getSpellSpellCriticalByHack[$itemsNon[$k]["spellid_".$i]]))
				$getSpellSpellCriticalByHack[$itemsNon[$k]["spellid_".$i]] = array();
			array_push($getSpellSpellCriticalByHack[$itemsNon[$k]["spellid_".$i]], $k);
		}
		
		$g = array();
		preg_match("/\"Attack Power Ranged (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["rangedapower"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Block (\d+)\"/", $spellDBC[$itemsNon[$k]["spellid_".$i]]["Field121"], $g);
		if (!empty($g))
			$items[$k]["blockchance"] += $g[1];
	}
	
	for ($i=1; $i<11; $i++){
		if ($itemsNon[$k]["stat_type".$i]==3)
			$items[$k]["agility"] += $itemsNon[$k]["stat_value".$i];
		if ($itemsNon[$k]["stat_type".$i]==4)
			$items[$k]["strength"] += $itemsNon[$k]["stat_value".$i];
		if ($itemsNon[$k]["stat_type".$i]==5)
			$items[$k]["intellect"] += $itemsNon[$k]["stat_value".$i];
		if ($itemsNon[$k]["stat_type".$i]==6)
			$items[$k]["spirit"] += $itemsNon[$k]["stat_value".$i];
		if ($itemsNon[$k]["stat_type".$i]==7)
			$items[$k]["stamina"] += $itemsNon[$k]["stat_value".$i];
	}
	
	if ($k==22589)
		print $items[$k]["intellect"]."<br />";
	
	$items[$k]["block"] += $itemsNon[$k]["block"];
}

// Do hack parses
foreach($getSpellDefenseByHack as $k => $v){
	$g = array();
	$str = file_get_contents("http://db.vanillagaming.org/ajax.php?spell=".$k);
	preg_match("/Increased Defense \+(\d+)/", $str, $g);
	if (!empty($g)){
		foreach($v as $var){
			$items[$var]["defense"] += $g[1];
		}
	}
}

foreach($getSpellSpellCriticalByHack as $k => $v){
	$g = array();
	$str = file_get_contents("http://db.vanillagaming.org/ajax.php?spell=".$k);
	preg_match("/Improves your chance to get a critical strike with spells by (\d+)\%/", $str, $g);
	if (!empty($g)){
		foreach($v as $var){
			$items[$var]["spellcrit"] += $g[1];
		}
	}
}

foreach($getSpellManaRegenByHack as $k => $v){
	$g = array();
	$str = file_get_contents("http://db.vanillagaming.org/ajax.php?spell=".$k);
	preg_match("/Restores (\d+) mana per 5 sec\./", $str, $g);
	if (!empty($g)){
		foreach($v as $var){
			$items[$var]["manaregen"] += $g[1];
		}
	}
}

// Update this shiet!
foreach($items as $k => $v){
	$pdo->query('UPDATE item_template SET
		armor = "'.$items[$k]["armor"].'",
		holy_res = "'.$items[$k]["holy_res"].'",
		fire_res = "'.$items[$k]["fire_res"].'",
		nature_res = "'.$items[$k]["nature_res"].'",
		frost_res = "'.$items[$k]["frost_res"].'",
		shadow_res = "'.$items[$k]["shadow_res"].'",
		arcane_res = "'.$items[$k]["arcane_res"].'",
		hit = "'.$items[$k]["hit"].'",
		crit = "'.$items[$k]["crit"].'",
		apower = "'.$items[$k]["apower"].'",
		dodge = "'.$items[$k]["dodge"].'",
		parry = "'.$items[$k]["parry"].'",
		block = "'.$items[$k]["block"].'",
		spellpower = "'.$items[$k]["spellpower"].'",
		healpower = "'.$items[$k]["healpower"].'",
		spellholy = "'.$items[$k]["spellholy"].'",
		spellfrost = "'.$items[$k]["spellfrost"].'",
		spellnature = "'.$items[$k]["spellnature"].'",
		spellshadow = "'.$items[$k]["spellshadow"].'",
		spellarcane = "'.$items[$k]["spellarcane"].'",
		spellfire = "'.$items[$k]["spellfire"].'",
		manaregen = "'.$items[$k]["manaregen"].'",
		defense = "'.$items[$k]["defense"].'",
		spellhit = "'.$items[$k]["spellhit"].'",
		spellcrit = "'.$items[$k]["spellcrit"].'",
		rangedapower = "'.$items[$k]["rangedapower"].'",
		blockchance = "'.$items[$k]["blockchance"].'",
		strength = "'.$items[$k]["strength"].'",
		agility = "'.$items[$k]["agility"].'",
		stamina = "'.$items[$k]["stamina"].'",
		intellect = "'.$items[$k]["intellect"].'",
		spirit = "'.$items[$k]["spirit"].'"
	WHERE entry = '.$k);
}


?>