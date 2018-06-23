<?php
$pdo = new PDO('mysql:host=localhost;dbname=legacylo_shino', 'shino', 'P.r!UTIrK##mq[%+1M', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); // Need to change it later for live db
	//$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); // Need to change it later for live db
	
	// Get Highest ArenaSeason of each server
	$highestSeason = array();
	foreach($pdo->query('SELECT season, serverid FROM `armory-arenateams-tbc`') as $row){
		if (!isset($highestSeason[$row["serverid"]]) || $row["season"]>$highestSeason[$row["serverid"]])
			$highestSeason[$row["serverid"]] = $row["season"];
	}
	
	// Remove all teams from the old season
	foreach($highestSeason as $serverid => $season){
		$pdo->query('DELETE FROM `armory-arenateams-tbc` WHERE season<'.$season.' AND serverid = '.$serverid);
	}
	
	// Get teams that don't have player anymore
	$teams = "0";
	foreach($pdo->query('SELECT arena1, arena2, arena3 FROM `armory-honor-tbc`') as $row){
		if ($row["arena1"]>0)
			$teams.=",".$row["arena1"];
		if ($row["arena2"]>0)
			$teams.=",".$row["arena2"];
		if ($row["arena3"]>0)
			$teams.=",".$row["arena3"];
	}
	
	// DELETE those teams
	$pdo->query('DELETE FROM `armory-arenateams-tbc` WHERE arenaid NOT IN ('.$teams.')');
	
	// WOTLK
	// Get Highest ArenaSeason of each server
	$highestSeason = array();
	foreach($pdo->query('SELECT season, serverid FROM `armory-arenateams-wotlk`') as $row){
		if (!isset($highestSeason[$row["serverid"]]) || $row["season"]>$highestSeason[$row["serverid"]])
			$highestSeason[$row["serverid"]] = $row["season"];
	}
	
	// Remove all teams from the old season
	foreach($highestSeason as $serverid => $season){
		$pdo->query('DELETE FROM `armory-arenateams-wotlk` WHERE season<'.$season.' AND serverid = '.$serverid);
	}
	
	// Get teams that don't have player anymore
	$teams = "0";
	foreach($pdo->query('SELECT arena1, arena2, arena3 FROM `armory-honor-wotlk`') as $row){
		if ($row["arena1"]>0)
			$teams.=",".$row["arena1"];
		if ($row["arena2"]>0)
			$teams.=",".$row["arena2"];
		if ($row["arena3"]>0)
			$teams.=",".$row["arena3"];
	}
	
	// DELETE those teams
	$pdo->query('DELETE FROM `armory-arenateams-wotlk` WHERE arenaid NOT IN ('.$teams.')');
?>