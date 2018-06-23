<?php
set_time_limit(100000);
$pdo = new PDO('mysql:host=localhost;dbname=legacylo_shino', 'shino', 'P.r!UTIrK##mq[%+1M', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); // Need to change it later for live db
//$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); // Need to change it later for live db
$bossesById = Array (0 => 12118, 1 => 11982, 2 => 12259, 3 => 12057, 4 => 12056, 5 => 12264, 6 => 12098, 7 => 11988, 8 => 12018, 9 => 11502, 10 => 10184, 11 => 12397, 12 => 6109, 13 => 14889, 14 => 14887, 15 => 14888, 16 => 14890, 17 => 12435, 18 => 13020, 19 => 12017, 20 => 11983, 21 => 14601, 22 => 11981, 23 => 14020, 24 => 11583, 25 => 14517, 26 => 14507, 27 => 14510, 28 => 11382, 29 => 15082, 30 => 15083, 31 => 15085, 32 => 15114, 33 => 14509, 34 => 14515, 35 => 11380, 36 => 14834, 37 => 15348, 38 => 15341, 39 => 15340, 40 => 15370, 41 => 15369, 42 => 15339, 43 => 15263, 44 => 50000, 45 => 15516, 46 => 15510, 47 => 15299, 48 => 15509, 49 => 50001, 50 => 15517, 51 => 15727, 52 => 16028, 53 => 15931, 54 => 15932, 55 => 15928, 56 => 15956, 57 => 15953, 58 => 15952, 59 => 16061, 60 => 16060, 61 => 50002, 62 => 15954, 63 => 15936, 64 => 16011, 65 => 15989, 66 => 15990);
	
// Manually remove unrealistic speed-runs, speed-kills

// Getting corrupted player names
// Double Names without ownerid e.g. Searing Tote class=0 faction=0 guildid=0
// Names like Benvolio's S
// Names like 	Minashira'
// Names like PedingtonbÃ¤
$CorruptedPlayer = array();
foreach($pdo->query('SELECT id FROM chars WHERE name LIKE "%\'s%" or name LIKE "%\'%" or (classid=0 AND faction=0 AND guildid=0 AND name REGEXP "^[^ ]+[ ]+[^ ]+$" and ownerid=0)') as $row){
	array_push($CorruptedPlayer, $row["id"]);
}
$var = "0";
foreach($CorruptedPlayer as $val){
	if ($val) 
		$var .= ",".$val;
}
// Deleting everything in the database concering those ids
// $pdo->query('DELETE FROM `v-raids`;');
// $pdo->query('DELETE FROM `v-raids-attempts`;');
// $pdo->query('DELETE FROM `v-raids-buffs`;');
$pdo->query('DELETE FROM `v-raids-deaths` WHERE charid IN ('.$var.');');
// $pdo->query('DELETE FROM `v-raids-debuffs`;');
// $pdo->query('DELETE FROM `v-raids-debuffsbyplayer`;');
// $pdo->query('DELETE FROM `v-raids-dispels`;');
// $pdo->query('DELETE FROM `v-raids-dmgdonetoenemy`;');
// $pdo->query('DELETE FROM `v-raids-dmgdonebyability`;');
// $pdo->query('DELETE FROM `v-raids-dmgdonebysource` WHERE charid IN ('.$var.');');
//$pdo->query('DELETE FROM `v-raids-dmgdonetofriendly` WHERE charid IN ('.$var.');');
// // $pdo->query('DELETE FROM `v-raids-dmgtakenbysource` WHERE charid IN ('.$var.');');
// $pdo->query('DELETE FROM `v-raids-dmgtakenfromability`;');
// $pdo->query('DELETE FROM `v-raids-dmgtakenfromsource`;');
// $pdo->query('DELETE FROM `v-raids-healingbyability`;');
// $pdo->query('DELETE FROM `v-raids-healingbysource` WHERE charid IN ('.$var.');');
// $pdo->query('DELETE FROM `v-raids-healingtofriendly` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-interruptsmissed` WHERE targetid IN ('.$var.');');
// $pdo->query('DELETE FROM `v-raids-interruptsmissedsum`;');
// $pdo->query('DELETE FROM `v-raids-interruptssum` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-loot` WHERE charid IN ('.$var.');');
// $pdo->query('DELETE FROM `v-raids-participants`;'); // To be checked
// $pdo->query('DELETE FROM `v-raids-procs`;');
$pdo->query('DELETE FROM `v-raids-records` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-uploader` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-rankings` WHERE charid IN ('.$var.');');
// $pdo->query('DELETE FROM `v-speed-kills`;');
// $pdo->query('DELETE FROM `v-speed-runs`;');
$pdo->query('DELETE FROM `v-raids-individual-buffs` WHERE charid IN ('.$var.');');
//$pdo->query('DELETE FROM `v-raids-individual-buffsbyplayer` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-debuffsbyplayer` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-death` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-debuffs` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-dmgdonetoenemy` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-dmgdonebyability` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-dmgtakenfromability` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-dmgtakenbyplayer` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-dmgtakenfromsource` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-healingbyability` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-healingtofriendly` WHERE charid IN ('.$var.') or tarid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-interrupts` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-procs` WHERE charid IN ('.$var.');');
$pdo->query('DELETE FROM `contributors` WHERE charid IN ('.$var.');');
// $pdo->query('DELETE FROM `guilds`;');
// $pdo->query('DELETE FROM `v-raids-graph-dmgdone`');
// $pdo->query('DELETE FROM `v-raids-graph-dmgtaken`');
// $pdo->query('DELETE FROM `v-raids-graph-healingdone`');
$pdo->query('DELETE FROM `v-raids-graph-individual-dmgdone` WHERE charid IN ('.$var.')');
$pdo->query('DELETE FROM `v-raids-graph-individual-dmgtaken` WHERE charid IN ('.$var.')');
//$pdo->query('DELETE FROM `v-raids-graph-individual-healingdone` WHERE charid IN ('.$var.')');
$pdo->query('DELETE FROM `v-raids-graph-individual-healingreceived` WHERE charid IN ('.$var.')');
$pdo->query('DELETE FROM `v-raids-casts` WHERE charid IN ('.$var.')');
$pdo->query('DELETE FROM `v-raids-newbuffs` WHERE charid IN ('.$var.')');
$pdo->query('DELETE FROM `v-raids-newdebuffs` WHERE charid IN ('.$var.')');
$pdo->query('DELETE FROM `chars` WHERE id IN ('.$var.');');

print "DONE 1!";

// Merging players with same name and server for both player and pets
$MergedPlayer = array();
foreach($pdo->query('SELECT id, GROUP_CONCAT(DISTINCT id ORDER BY id) AS groups FROM chars GROUP BY name,serverid,ownerid,classid,faction HAVING COUNT(id)>1') as $row){
	$MergedPlayer[$row["id"]] = $row["groups"];
}

foreach($MergedPlayer as $key => $var){
// Updating charids everywhere
// $pdo->query('UPDATE `v-raids`;');
// $pdo->query('UPDATE `v-raids-attempts`;');
// $pdo->query('UPDATE `v-raids-buffs`;');
$pdo->query('UPDATE `v-raids-deaths` SET charid = '.$key.' WHERE charid IN ('.$var.');');
// $pdo->query('UPDATE `v-raids-debuffs`;');
// $pdo->query('UPDATE `v-raids-debuffsbyplayer`;');
// $pdo->query('UPDATE `v-raids-dispels`;');
// $pdo->query('UPDATE `v-raids-dmgdonetoenemy`;');
// $pdo->query('UPDATE `v-raids-dmgdonebyability`;');
// $pdo->query('UPDATE `v-raids-dmgdonebysource` SET charid = '.$key.' WHERE charid IN ('.$var.');');
//$pdo->query('UPDATE `v-raids-dmgdonetofriendly` SET charid = '.$key.' WHERE charid IN ('.$var.');');
// $pdo->query('UPDATE `v-raids-dmgtakenbysource` SET charid = '.$key.' WHERE charid IN ('.$var.');');
// $pdo->query('UPDATE `v-raids-dmgtakenfromability`;');
// $pdo->query('UPDATE `v-raids-dmgtakenfromsource`;');
// $pdo->query('UPDATE `v-raids-healingbyability`;');
// $pdo->query('UPDATE `v-raids-healingbysource` SET charid = '.$key.' WHERE charid IN ('.$var.');');
// $pdo->query('UPDATE `v-raids-healingtofriendly` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-interruptsmissed` SET targetid = '.$key.' WHERE targetid IN ('.$var.');');
// $pdo->query('UPDATE `v-raids-interruptsmissedsum`;');
// $pdo->query('UPDATE `v-raids-interruptssum` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-loot` SET charid = '.$key.' WHERE charid IN ('.$var.');');
// $pdo->query('UPDATE `v-raids-participants`;'); // To be checked
// $pdo->query('UPDATE `v-raids-procs`;');
$pdo->query('UPDATE `v-raids-records` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-uploader` SET charid = '.$key.' WHERE charid IN ('.$var.');');
// $pdo->query('UPDATE `v-speed-kills`;');
// $pdo->query('UPDATE `v-speed-runs`;');
$pdo->query('UPDATE `v-raids-individual-buffs` SET charid = '.$key.' WHERE charid IN ('.$var.');');
//$pdo->query('UPDATE `v-raids-individual-buffsbyplayer` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-debuffsbyplayer` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-death` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-debuffs` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-dmgdonetoenemy` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-dmgdonebyability` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-dmgtakenfromability` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-dmgtakenbyplayer` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-dmgtakenfromsource` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-healingbyability` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-healingtofriendly` SET charid = '.$key.' WHERE charid IN ('.$var.') or tarid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-healingtofriendly` SET tarid = '.$key.' WHERE tarid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-interrupts` SET charid = '.$key.' WHERE charid IN ('.$var.');');
$pdo->query('UPDATE `v-raids-individual-procs` SET charid = '.$key.' WHERE charid IN ('.$var.');');
// $pdo->query('UPDATE `guilds`;');
// $pdo->query('UPDATE `v-raids-graph-dmgdone`');
// $pdo->query('UPDATE `v-raids-graph-dmgtaken`');
// $pdo->query('UPDATE `v-raids-graph-healingdone`');
$pdo->query('UPDATE `v-raids-graph-individual-dmgdone` SET charid = '.$key.' WHERE charid IN ('.$var.')');
$pdo->query('UPDATE `v-raids-graph-individual-dmgtaken` SET charid = '.$key.' WHERE charid IN ('.$var.')');
//$pdo->query('UPDATE `v-raids-graph-individual-healingdone` SET charid = '.$key.' WHERE charid IN ('.$var.')');
$pdo->query('UPDATE `v-raids-graph-individual-healingreceived` SET charid = '.$key.' WHERE charid IN ('.$var.')');
$pdo->query('UPDATE `v-raids-newbuffs` SET charid = '.$key.' WHERE charid IN ('.$var.')');
$pdo->query('UPDATE `v-raids-newdebuffs` SET charid = '.$key.' WHERE charid IN ('.$var.')');
$pdo->query('UPDATE `v-raids-casts` SET charid = '.$key.' WHERE charid IN ('.$var.')');

$tempInfo = $pdo->query('SELECT * FROM `contributors` WHERE charid IN ('.$var.') LIMIT 1')->fetch();
$pdo->query('DELETE FROM `contributors` WHERE charid IN ('.$var.');');
if ($tempInfo["charid"]){
	$pdo->query('INSERT INTO `contributors` (charid, time) VALUES ('.$key.', '.$tempInfo["time"].')');
}
foreach($bossesById as $v){
	foreach(array(1,-1) as $q){
		$tempInfo = $pdo->query('SELECT * FROM `v-rankings` WHERE charid IN ('.$var.') AND bossid = '.$v.' AND type = '.$q.' ORDER BY boval DESC LIMIT 1')->fetch();
		if ($tempInfo["charid"]){
			$pdo->query('DELETE FROM `v-rankings` WHERE charid IN ('.$var.') AND bossid = '.$v.' AND type = '.$q);
			$pdo->query('INSERT INTO `v-rankings` (bossid, type, charid, boval, aoval, bmval, amval, botime, aotime, bmtime, amtime, oattemptid, mattemptid, bochange, aochange, bmchange, amchange, aoamount, boamount) VALUES ("'.$v.'", "'.$q.'", "'.$key.'", "'.$tempInfo["boval"].'", "'.$tempInfo["aoval"].'", "'.$tempInfo["bmval"].'", "'.$tempInfo["amval"].'", "'.$tempInfo["botime"].'", "'.$tempInfo["aotime"].'", "'.$tempInfo["bmtime"].'", "'.$tempInfo["amtime"].'", "'.$tempInfo["oattemptid"].'", "'.$tempInfo["mattemptid"].'", "'.$tempInfo["bochange"].'", "'.$tempInfo["aochange"].'", "'.$tempInfo["bmchange"].'", "'.$tempInfo["amchange"].'", "'.$tempInfo["aoamount"].'", "'.$tempInfo["boamount"].'");');
		}
	}
}

$pdo->query('DELETE FROM `chars` WHERE id IN ('.$var.') AND id != '.$key.';');
}

print "DONE 2!";

// Delete all logs and rankings marked with -1
$DisabledRaids = array();
foreach($pdo->query('SELECT a.id, GROUP_CONCAT(DISTINCT b.id ORDER BY b.id) AS groups FROM `v-raids` a LEFT JOIN `v-raids-attempts` b ON a.id = b.rid WHERE a.rdy = -1 AND ('.time().'-a.tsend)>=50000 GROUP BY a.id') as $row){
	$DisabledRaids[$row["id"]] = $row["groups"];
}

$var = "0";
foreach($DisabledRaids as $key => $val){
	if ($key) 
		$var .= ",".$key;
}

$var2 = "0";
foreach($DisabledRaids as $key => $val){
	if ($val) 
		$var2 .= ",".$val;
}

$pdo->query('DELETE FROM `v-raids` WHERE id IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-attempts` WHERE id IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-buffs` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-deaths` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-debuffs` WHERE attemptid IN ('.$var2.');');
//$pdo->query('DELETE FROM `v-raids-debuffsbyplayer` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-dispels` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-dmgdonetoenemy` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-dmgdonebyability` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-dmgdonebysource` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-dmgdonetofriendly` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-dmgtakenbysource` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-dmgtakenfromability` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-dmgtakenfromsource` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-healingbyability` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-healingbysource` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-healingtofriendly` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-interruptsmissed` WHERE targetid IN ('.$var.');');
// $pdo->query('DELETE FROM `v-raids-interruptsmissedsum` WHERE attemptid IN ('.$var2.');');
// pdo->query('DELETE FROM `v-raids-interruptssum` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-loot` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-participants` WHERE rid IN ('.$var.');');
// $pdo->query('DELETE FROM `v-raids-procs` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-records` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-uploader` WHERE rid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-buffs` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-individual-buffsbyplayer` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-individual-debuffsbyplayer` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-individual-death` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-individual-debuffs` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-individual-dmgdonetoenemy` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-individual-dmgdonebyability` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-individual-dmgtakenfromability` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-individual-dmgtakenbyplayer` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-individual-dmgtakenfromsource` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-individual-healingbyability` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-individual-healingtofriendly` WHERE attemptid IN ('.$var2.') or tarid IN ('.$var.');');
$pdo->query('DELETE FROM `v-raids-individual-interrupts` WHERE attemptid IN ('.$var2.');');
$pdo->query('DELETE FROM `v-raids-individual-procs` WHERE attemptid IN ('.$var2.');');
// $pdo->query('DELETE FROM `v-raids-graph-dmgdone` WHERE attemptid IN ('.$var2.')');
// $pdo->query('DELETE FROM `v-raids-graph-dmgtaken` WHERE attemptid IN ('.$var2.')');
// $pdo->query('DELETE FROM `v-raids-graph-healingdone` WHERE attemptid IN ('.$var2.')');
$pdo->query('DELETE FROM `v-raids-graph-individual-dmgdone` WHERE attemptid IN ('.$var2.')');
$pdo->query('DELETE FROM `v-raids-graph-individual-dmgtaken` WHERE attemptid IN ('.$var2.')');
// $pdo->query('DELETE FROM `v-raids-graph-individual-healingdone` WHERE attemptid IN ('.$var2.')');
$pdo->query('DELETE FROM `v-raids-graph-individual-healingreceived` WHERE attemptid IN ('.$var2.')');
$pdo->query('DELETE FROM `v-raids-casts` WHERE attemptid IN ('.$var2.')');
$pdo->query('DELETE FROM `v-raids-newbuffs` WHERE rid IN ('.$var.')');
$pdo->query('DELETE FROM `v-raids-newdebuffs` WHERE rid IN ('.$var.')');

$pdo->query('DELETE FROM `v-speed-kills` WHERE oraidid IN ('.$var.') or mraidid IN ('.$var.');');
$pdo->query('DELETE FROM `v-speed-runs` WHERE oraidid IN ('.$var.') or mraidid IN ('.$var.');');
$pdo->query('DELETE FROM `v-rankings` WHERE oattemptid IN ('.$var2.') or mattemptid IN ('.$var2.');');

// Reset Guild history
$pdo->query('DELETE FROM `armory-guildhistory`');

print "DONE COMPLETLY!";

?>