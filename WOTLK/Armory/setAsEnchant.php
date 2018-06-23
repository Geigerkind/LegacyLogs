<?php
$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$pdo2 = new PDO('mysql:host=localhost;dbname=world_vanilla', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

error_reporting(0);

// Gettings all parsed items
$spells = array();
foreach($pdo->query('SELECT seteffectids FROM `wotlk-itemsets`') as $row){
	foreach(explode(",", $row["seteffectids"]) as $var){
		$spells[$var] = true;
	}
}

// Gettings all parsed items
$items = array();

// Getting SpellDCB
$spellDBC = array();
foreach($pdo->query('SELECT column_1, column_81, column_82, column_171 as column_162 FROM spelldbc_wotlk') as $row){
	$spellDBC[$row["column_1"]] = $row;
}

function setUpVal(&$val, $num){
	if (!isset($val))
		$val = $num;
	else
		$val += $num;
}

// Setting itemValues
$getSpellDefenseByHack = array();
$getSpellManaRegenByHack = array();
$getSpellSpellCriticalByHack = array();
foreach($spells as $k => $v){
		if (!isset($items[$k]))
			$items[$k] = array();
		
		$str = strtolower($spellDBC[$k]["column_162"]);
		$num = intval($spellDBC[$k]["column_81"])+1;
		$num2 = intval($spellDBC[$k]["column_82"])+1;
		if (strpos($str, "spell haste")){
			setUpVal($items[$k]["haste"], $num);
			continue;
		}
		
		if (strpos($str, "haste")){
			setUpVal($items[$k]["haste"], $num);
			continue;
		}
		
		if (strpos($str, "dodge")){
			setUpVal($items[$k]["dodge"], $num);
			continue;
		}
		
		if (strpos($str, "parry")){
			setUpVal($items[$k]["parry"], $num);
			continue;
		}
		
		if (strpos($str, "resilience")){
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
		
		if (strpos($str, "spell power")){
			setUpVal($items[$k]["spellpower"], $num);
			continue;
		}
		
		if (strpos($str, "spell damage")){
			setUpVal($items[$k]["spellpower"], $num);
			continue;
		}
		
		if (strpos($str, "spell critical strike")){
			setUpVal($items[$k]["crit"], $num);
			continue;
		}
		
		if (strpos($str, "critical strike")){
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
		
		if (strpos($str, "expertise")){
			setUpVal($items[$k]["expertise"], $num);
			continue;
		}
		
		if (strpos($str, "spell hit")){
			setUpVal($items[$k]["hit"], $num);
			continue;
		}
		
		if (strpos($str, "hit rating")){
			setUpVal($items[$k]["hit"], $num);
			continue;
		}
		
		if (strpos($str, "attacks ignore")){
			setUpVal($items[$k]["armorpen"], $num);
			continue;
		}
		
		if (strpos($str, "attacks ignore")){
			setUpVal($items[$k]["armorpen"], $num);
			continue;
		}
		
		if (strpos($str, "armor penetration")){
			setUpVal($items[$k]["armorpen"], $num);
			continue;
		}
		
		if (strpos($str, "spell penetration")){
			setUpVal($items[$k]["spellpen"], $num);
			continue;
		}
		
		if (strpos($str, "+ strength")){
			setUpVal($items[$k]["strength"], $num);
			continue;
		}
		
		if (strpos($str, "+ stamina")){
			setUpVal($items[$k]["stamina"], $num);
			continue;
		}
		if (strpos($str, "+ intellect")){
			setUpVal($items[$k]["intellect"], $num);
			continue;
		}
		if (strpos($str, "+ spirit")){
			setUpVal($items[$k]["spirit"], $num);
			continue;
		}
		if (strpos($str, "+ agility")){
			setUpVal($items[$k]["agility"], $num);
			continue;
		}
}
// Update this shiet!
$toDelete = array();
print 'INSERT INTO `armory-enchantmentstats-wotlk (`enchid`, `armor`,`res_holy`,`res_fire`,`res_nature`,`res_frost`,`res_shadow`,`res_arcane`,`hit`,`crit`,`apower`,`dodge`,`block`,`spellpower`,`healpower`,`manaregen`,`defense`,`blockchance`,`strength`,`agility`,`stamina`,`intellect`,`spirit`, `resilience`, `haste`, `expertise`) VALUES <br />';
foreach($items as $k => $v){
	$toDelete[] = $k;
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
		print '"'.intval($items[$k]["manaregen"]).'",';
		print '"'.intval($items[$k]["defense"]).'",';
		//print '"'.intval($items[$k]["rangedapower"]).'",';
		print '"'.intval($items[$k]["blockchance"]).'",';
		print '"'.intval($items[$k]["strength"]).'",';
		print '"'.intval($items[$k]["agility"]).'",';
		print '"'.intval($items[$k]["stamina"]).'",';
		print '"'.intval($items[$k]["intellect"]).'",';
		print '"'.intval($items[$k]["spirit"]).'",';
		print '"'.intval($items[$k]["resilience"]).'",';
		print '"'.intval($items[$k]["haste"]).'",';
		print '"'.intval($items[$k]["expertise"]).'"';
		print '), <br />';
	}
}

print 'DELETE FROM `armory-enchantmentstats-tbc` WHERE enchid IN ('.implode(",",$toDelete).')';


?>