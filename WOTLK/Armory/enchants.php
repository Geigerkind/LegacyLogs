<?php
$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// Get enchantment template
$template = array();
foreach($pdo->query('SELECT column_1 as Field01, column_2 as Field02, column_3 as Field03, column_5 as Field05, column_8 as Field08, column_11 as Field11, column_12 as Field12, column_15 as Field14 FROM enchantmentdbc_wotlk') as $row){
	$template[$row["Field01"]] = $row;
}

$pdo->query('DELETE FROM `armory-enchantmentstats-wotlk`');

// translate dbc
$sql = 'INSERT INTO `armory-enchantmentstats-wotlk` (`enchid`, `name`, `stamina`, `strength`, `intellect`, `spirit`, `agility`, `apower`, `dodge`, `blockchance`, `block`, `spellpower`, `healpower`, `hit`, `crit`, `defense`, `res_nature`, `res_holy`, `res_fire`, `res_frost`, `res_shadow`, `res_arcane`, `manaregen`, `mana`, `health`, `armor`, `haste`, `spellpen`, `resilience`, `expertise`, `armorpen`) VALUES ';
$insertQuery = array();
$insertData = array();

foreach($template as $k => $v){
	if (intval($k)!=0){
		$template["name"] = str_replace('"', "", $v["Field14"]);
		$template["stamina"] = 0;
		$template["strength"] = 0;
		$template["intellect"] = 0;
		$template["spirit"] = 0;
		$template["agility"] = 0;
		$template["apower"] = 0;
		$template["dodge"] = 0;
		$template["blockchance"] = 0;
		$template["block"] = 0;
		$template["spellpower"] = 0;
		$template["healpower"] = 0;
		$template["rangedapower"] = 0;
		$template["hit"] = 0;
		$template["crit"] = 0;
		$template["defense"] = 0;
		$template["spellhit"] = 0;
		$template["spellcrit"] = 0;
		$template["spellshadow"] = 0;
		$template["spellfrost"] = 0;
		$template["spellfire"] = 0;
		$template["spellnature"] = 0;
		$template["spellarcane"] = 0;
		$template["spellholy"] = 0;
		$template["res_nature"] = 0;
		$template["res_holy"] = 0;
		$template["res_fire"] = 0;
		$template["res_frost"] = 0;
		$template["res_shadow"] = 0;
		$template["res_arcane"] = 0;
		$template["manaregen"] = 0;
		$template["mana"] = 0;
		$template["health"] = 0;
		$template["armor"] = 0;
		$template["expertise"] = 0;
		$template["spellpen"] = 0;
		$template["resilience"] = 0;
		$template["haste"] = 0;
		$template["spellhaste"] = 0;
		$template["armorpen"] = 0;
		
		$g = array();
		preg_match("/All Stats \+(\d+)/", $v["Field14"], $g);
		if (!empty($g)){
			$template["stamina"] = $g[1];
			$template["strength"] = $g[1];
			$template["intellect"] = $g[1];
			$template["spirit"] = $g[1];
			$template["agility"] = $g[1];
		}
		
		$g = array();
		preg_match("/\+(\d+) Stamina/", $v["Field14"], $g);
		if (!empty($g))
			$template["stamina"] = $g[1];
		
		$g = array();
		preg_match("/Stamina \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["stamina"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Strength/", $v["Field14"], $g);
		if (!empty($g))
			$template["strength"] = $g[1];
		
		$g = array();
		preg_match("/Strength \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["strength"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Intellect/", $v["Field14"], $g);
		if (!empty($g))
			$template["intellect"] = $g[1];
		
		$g = array();
		preg_match("/Intellect \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["intellect"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Spirit/", $v["Field14"], $g);
		if (!empty($g))
			$template["spirit"] = $g[1];
		
		$g = array();
		preg_match("/Spirit \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spirit"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Agility/", $v["Field14"], $g);
		if (!empty($g))
			$template["agility"] = $g[1];
		
		$g = array();
		preg_match("/Agility \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["agility"] = $g[1];
		
		$g = array();
		preg_match("/Attack Power \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["apower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Attack Power/", $v["Field14"], $g);
		if (!empty($g))
			$template["apower"] = $g[1];
		
		$g = array();
		preg_match("/Ranged Attack Power \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["apower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Ranged Attack Power/", $v["Field14"], $g);
		if (!empty($g))
			$template["apower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+)\% Dodge/", $v["Field14"], $g);
		if (!empty($g))
			$template["dodge"] = $g[1];
		
		$g = array();
		preg_match("/Dodge \+(\d+)\%/", $v["Field14"], $g);
		if (!empty($g))
			$template["dodge"] = $g[1];
		
		$g = array();
		preg_match("/Block \+(\d+)\%/", $v["Field14"], $g);
		if (!empty($g))
			$template["blockchance"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Block Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["blockchance"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Shield Block Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["blockchance"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Defense Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["defense"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Parry Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["parry"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Dodge Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["dodge"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Resilience Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["resilience"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Expertise Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["expertise"] = $g[1];
		
		$g = array();
		preg_match("/Blocking \+(\d+)\%/", $v["Field14"], $g);
		if (!empty($g))
			$template["blockchance"] = $g[1];
		
		$g = array();
		preg_match("/Block Level \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["block"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Damage and Healing Spells/", $v["Field14"], $g);
		if (!empty($g)){
			$template["spellpower"] = $g[1];
			$template["healpower"] = $g[1];
		}
		
		$g = array();
		preg_match("/\+(\d+) Spell Damage and Healing/", $v["Field14"], $g);
		if (!empty($g)){
			$template["spellpower"] = $g[1];
			$template["healpower"] = $g[1];
		}
		
		$g = array();
		preg_match("/Healing and Spell Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g)){
			$template["spellpower"] = $g[1];
			$template["healpower"] = $g[1];
		}
		
		$g = array();
		preg_match("/\+(\d+) Healing and Spell Damage/", $v["Field14"], $g);
		if (!empty($g)){
			$template["spellpower"] = $g[1];
			$template["healpower"] = $g[1];
		}
		
		$g = array();
		preg_match("/Increase Spell Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Spell Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Spell Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Damage Spells/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Healing Spells \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["healpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Healing Spells/", $v["Field14"], $g);
		if (!empty($g))
			$template["healpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Healing/", $v["Field14"], $g);
		if (!empty($g))
			$template["healpower"] = $g[1];
		
		$g = array();
		preg_match("/Frost Spell Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Increases Frost Effects \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Increases Fire Effects \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Increases Nature Effects \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Increases Holy Effects \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Increases Shadow Effects \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Increases arcane Effects \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Frost Spell Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Frost Spell Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Nature Spell Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Nature Spell Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Holy Spell Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Holy Spell Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Shadow Spell Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Shadow Spell Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Fire Spell Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Fire Spell Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Arcane Spell Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Arcane Spell Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		
		$g = array();
		preg_match("/Frost Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Frost Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Nature Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Nature Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Holy Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Holy Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Shadow Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Shadow Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Fire Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Fire Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/Arcane Damage \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Arcane Damage/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpower"] = $g[1];
		
		
		$g = array();
		preg_match("/\+(\d+) Arcane Resistance/", $v["Field14"], $g);
		if (!empty($g))
			$template["res_arcane"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Fire Resistance/", $v["Field14"], $g);
		if (!empty($g))
			$template["res_fire"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Holy Resistance/", $v["Field14"], $g);
		if (!empty($g))
			$template["res_holy"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Shadow Resistance/", $v["Field14"], $g);
		if (!empty($g))
			$template["res_shadow"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Nature Resistance/", $v["Field14"], $g);
		if (!empty($g))
			$template["res_nature"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Frost Resistance/", $v["Field14"], $g);
		if (!empty($g))
			$template["res_frost"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) All Resistances/", $v["Field14"], $g);
		if (!empty($g)){
			$template["res_arcane"] = $g[1];
			$template["res_holy"] = $g[1];
			$template["res_frost"] = $g[1];
			$template["res_fire"] = $g[1];
			$template["res_nature"] = $g[1];
			$template["res_shadow"] = $g[1];
		}
		
		$g = array();
		preg_match("/\+(\d+) mana every 5 sec/", $v["Field14"], $g);
		if (!empty($g))
			$template["manaregen"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Mana every 5 sec/", $v["Field14"], $g);
		if (!empty($g))
			$template["manaregen"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) mana per 5 sec/", $v["Field14"], $g);
		if (!empty($g))
			$template["manaregen"] = $g[1];
		
		$g = array();
		preg_match("/Mana Regen (\d+) per 5 sec/", $v["Field14"], $g);
		if (!empty($g))
			$template["manaregen"] = $g[1];
		
		$g = array();
		preg_match("/Mana Regen \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["manaregen"] = $g[1];
		
		$g = array();
		preg_match("/Mana \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["mana"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Mana/", $v["Field14"], $g);
		if (!empty($g)){
			if (!strpos($v["Field14"], "every"))
				$template["mana"] = $g[1];
		}
		
		$g = array();
		preg_match("/Health \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["health"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Health/", $v["Field14"], $g);
		if (!empty($g))
			$template["health"] = $g[1];
		
		$g = array();
		preg_match("/Armor \+(\d+)/", $v["Field14"], $g);
		if (!empty($g))
			$template["armor"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+) Armor/", $v["Field14"], $g);
		if (!empty($g))
			$template["armor"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+)\ Hit Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["hit"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+)\ Spell Hit Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellhit"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+)\ Haste Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["haste"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+)\ Spell Haste Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellhaste"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+)\ Armor Penetration Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["armorpen"] = $g[1];
		
		$g = array();
		preg_match("/\"Hit \+(\d+)\%\"/", $v["Field14"], $g);
		if (!empty($g))
			$template["hit"] = $g[1];
		
		$g = array();
		preg_match("/\/Hit \+(\d+)\%\"/", $v["Field14"], $g);
		if (!empty($g))
			$template["hit"] = $g[1];
		
		$g = array();
		preg_match("/Spell Hit \+(\d+)\%/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellhit"] = $g[1];
		
		$g = array();
		preg_match("/Critical Hit \+(\d+)\%/", $v["Field14"], $g);
		if (!empty($g))
			$template["crit"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+)\ Critical Strike Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["crit"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+)\ Spell Critical Rating/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellcrit"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+)\ Spell Penetration/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellpen"] = $g[1];
		
		$g = array();
		preg_match("/\+(\d+)\% Spell Critical Strike/", $v["Field14"], $g);
		if (!empty($g))
			$template["spellcrit"] = $g[1];
		
		$insertQuery[] = '(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'; // Abgleichen
		$insertData[] = $k;
		$insertData[] = $template["name"];
		$insertData[] = $template["stamina"];
		$insertData[] = $template["strength"];
		$insertData[] = $template["intellect"];
		$insertData[] = $template["spirit"];
		$insertData[] = $template["agility"];
		$insertData[] = $template["apower"];
		$insertData[] = $template["dodge"];
		$insertData[] = $template["blockchance"];
		$insertData[] = $template["block"];
		$insertData[] = $template["spellpower"];
		$insertData[] = $template["healpower"];
		$insertData[] = $template["hit"];
		$insertData[] = $template["crit"];
		$insertData[] = $template["defense"];
		$insertData[] = $template["res_nature"];
		$insertData[] = $template["res_holy"];
		$insertData[] = $template["res_fire"];
		$insertData[] = $template["res_frost"];
		$insertData[] = $template["res_shadow"];
		$insertData[] = $template["res_arcane"];
		$insertData[] = $template["manaregen"];
		$insertData[] = $template["mana"];
		$insertData[] = $template["health"];
		$insertData[] = $template["armor"];
		$insertData[] = $template["haste"];
		$insertData[] = $template["spellpen"];
		$insertData[] = $template["resilience"];
		$insertData[] = $template["expertise"];
		$insertData[] = $template["armorpen"];
	}
}

$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
if (!empty($insertQuery)) {
		$sql .= implode(', ', $insertQuery);
		$stmt = $pdo->prepare($sql);
		$stmt->execute($insertData);
	}


?>