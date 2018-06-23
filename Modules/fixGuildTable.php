<?php
require '../Database/Mysql.php';
$keyData = new KeyData();
$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// Getting a list of all double guilds
$dguild = array();
foreach($db->query('SELECT name, serverid FROM guilds WHERE name != "PugRaid" GROUP BY name, serverid HAVING count(name)>1 ORDER BY COUNT(name) DESC') as $row){
	$dguild[] = array(1=>$row->name,2=>$row->serverid);
}

foreach($dguild as $var){
	// Getting list of all guilds with the same name
	$tarid = false;
	$guilds = array();
	foreach($db->query('SELECT id, faction FROM guilds WHERE name = "'.$var[1].'" AND serverid="'.$var[2].'";') as $row){
		if ($row->faction>0)
			$tarid = $row->id;
		$guilds[] = $row->id;
	}
	if (!$tarid)
		$tarid = $guilds[0];
	if ($tarid && !empty($guilds) && sizeOf($guilds)>1){
		$nGuilds = array();
		foreach($guilds as $va){
			if ($va!=$tarid){
				$nGuilds[] = $va;
			}
		}
		$guildsimp = implode(",",$nGuilds);
		$db->query('UPDATE chars SET guildid = "'.$tarid.'" WHERE guildid IN ('.$guildsimp.')');
		$db->query('UPDATE `v-speed-runs` SET guildid = "'.$tarid.'" WHERE guildid IN ('.$guildsimp.')');
		$db->query('UPDATE `v-speed-kills` SET guildid = "'.$tarid.'" WHERE guildid IN ('.$guildsimp.')');
		$db->query('UPDATE `v-immortal-runs` SET guildid = "'.$tarid.'" WHERE guildid IN ('.$guildsimp.')');
		$db->query('UPDATE `v-raids` SET guildid = "'.$tarid.'" WHERE guildid IN ('.$guildsimp.')');
		$db->query('UPDATE `tbc-speed-runs` SET guildid = "'.$tarid.'" WHERE guildid IN ('.$guildsimp.')');
		$db->query('UPDATE `tbc-speed-kills` SET guildid = "'.$tarid.'" WHERE guildid IN ('.$guildsimp.')');
		$db->query('UPDATE `tbc-immortal-runs` SET guildid = "'.$tarid.'" WHERE guildid IN ('.$guildsimp.')');
		$db->query('UPDATE `tbc-raids` SET guildid = "'.$tarid.'" WHERE guildid IN ('.$guildsimp.')');
		
		$db->query('UPDATE `armory-guildhistory` SET guildid = "'.$tarid.'" WHERE guildid IN ('.$guildsimp.')');
		$db->query('DELETE FROM guilds WHERE id IN ('.$guildsimp.')');
	}
}

?>