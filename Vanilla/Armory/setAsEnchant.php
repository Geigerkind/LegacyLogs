<?php
$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$pdo2 = new PDO('mysql:host=localhost;dbname=world_vanilla', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

error_reporting(0);

// Gettings all parsed items
$spells = array();
foreach($pdo->query('SELECT seteffectids FROM `v-itemsets`') as $row){
	foreach(explode(",", $row["seteffectids"]) as $var){
		$spells[$var] = true;
	}
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
$items = array();
foreach($spells as $k => $v){
		if (!isset($items[$k]))
			$items[$k] = array();
		
		$g = array();
		preg_match("/\"Increased Hit Chance (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["hit"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Critical (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["crit"] += $g[1];
		
		$g = array();
		preg_match("/\"Attack Power (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["apower"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Dodge (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["dodge"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Parry (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["parry"] += $g[1];
		
		$g = array();
		preg_match("/\"Block Value (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["block"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Spell Dam (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellpower"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Healing (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["healpower"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Holy Dam (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellholy"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Fire Dam (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellfire"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Frost Dam (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellfrost"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Nature Dam (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellnature"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Shadow Dam (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellshadow"] += $g[1];
		
		$g = array();
		preg_match("/\"Increase Arcane Dam (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellarcane"] += $g[1];
		
		if (preg_match("/\"Increased Mana Regen\"/", $spellDBC[$k]["Field121"])){
			if (!isset($getSpellManaRegenByHack[$k]))
				$getSpellManaRegenByHack[$k] = array();
			array_push($getSpellManaRegenByHack[$k], $k);
		}
		
		if (preg_match("/\"Increased Defense\"/", $spellDBC[$k]["Field121"])){
			if (!isset($getSpellDefenseByHack[$k]))
				$getSpellDefenseByHack[$k] = array();
			array_push($getSpellDefenseByHack[$k], $k);
		}
		
		$g = array();
		preg_match("/\"Increased Spell Hit Chance (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spellhit"] += $g[1];
		
		if (preg_match("/\"Increased Critical Spell\"/", $spellDBC[$k]["Field121"])){
			if (!isset($getSpellSpellCriticalByHack[$k]))
				$getSpellSpellCriticalByHack[$k] = array();
			array_push($getSpellSpellCriticalByHack[$k], $k);
		}
		
		$g = array();
		preg_match("/\"Attack Power Ranged (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["rangedapower"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Block (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["blockchance"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Stamina (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["stamina"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Agility (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["agility"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Strength (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["strength"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Intellect (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["intellect"] += $g[1];
		
		$g = array();
		preg_match("/\"Increased Spirit (\d+)\"/", $spellDBC[$k]["Field121"], $g);
		if (!empty($g))
			$items[$k]["spirit"] += $g[1];
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
print 'INSERT INTO `armory-enchantmentstats` (`enchid`, `armor`,`res_holy`,`res_fire`,`res_nature`,`res_frost`,`res_shadow`,`res_arcane`,`hit`,`crit`,`apower`,`dodge`,`block`,`spellpower`,`healpower`,`spellholy`,`spellfrost`,`spellnature`,`spellshadow`,`spellarcane`,`spellfire`,`manaregen`,`defense`,`spellhit`,`spellcrit`,`rangedapower`,`blockchance`,`strength`,`agility`,`stamina`,`intellect`,`spirit`) VALUES <br />';
foreach($items as $k => $v){
	if ($k>0){
		print '(';
		print '"'.$k.'",';
		print '"'.intval($items[$k]["armor"]).'",';
		print '"'.intval($items[$k]["holy_res"]).'",';
		print '"'.intval($items[$k]["fire_res"]).'",';
		print '"'.intval($items[$k]["nature_res"]).'",';
		print '"'.intval($items[$k]["frost_res"]).'",';
		print '"'.intval($items[$k]["shadow_res"]).'",';
		print '"'.intval($items[$k]["arcane_res"]).'",';
		print '"'.intval($items[$k]["hit"]).'",';
		print '"'.intval($items[$k]["crit"]).'",';
		print '"'.intval($items[$k]["apower"]).'",';
		print '"'.intval($items[$k]["dodge"]).'",';
		//print '"'.intval($items[$k]["parry"]).'",';
		print '"'.intval($items[$k]["block"]).'",';
		print '"'.intval($items[$k]["spellpower"]).'",';
		print '"'.intval($items[$k]["healpower"]).'",';
		print '"'.intval($items[$k]["spellholy"]).'",';
		print '"'.intval($items[$k]["spellfrost"]).'",';
		print '"'.intval($items[$k]["spellnature"]).'",';
		print '"'.intval($items[$k]["spellshadow"]).'",';
		print '"'.intval($items[$k]["spellarcane"]).'",';
		print '"'.intval($items[$k]["spellfire"]).'",';
		print '"'.intval($items[$k]["manaregen"]).'",';
		print '"'.intval($items[$k]["defense"]).'",';
		print '"'.intval($items[$k]["spellhit"]).'",';
		print '"'.intval($items[$k]["spellcrit"]).'",';
		print '"'.intval($items[$k]["rangedapower"]).'",';
		print '"'.intval($items[$k]["blockchance"]).'",';
		print '"'.intval($items[$k]["strength"]).'",';
		print '"'.intval($items[$k]["agility"]).'",';
		print '"'.intval($items[$k]["stamina"]).'",';
		print '"'.intval($items[$k]["intellect"]).'",';
		print '"'.intval($items[$k]["spirit"]).'"';
		print '), <br />';
	}
}



?>