<?php
set_time_limit(100000);
$pdo = new PDO('mysql:host=localhost;dbname=legacylo_shino', 'shino', 'P.r!UTIrK##mq[%+1M', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); // Need to change it later for live db
foreach($pdo->query('SELECT GROUP_CONCAT(id) as aids, rid FROM `v-raids-attempts` WHERE rid>0 GROUP BY rid') as $row){
	$aids = $row["aids"];
	$var = $row["rid"];
	$offsets = array();
	$offsets[1] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-casts` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[2] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-deaths` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[3] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-dispels` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[4] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-graph-individual-dmgdone` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[5] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-graph-individual-dmgtaken` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[6] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-graph-individual-healingreceived` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[7] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-individual-death` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[8] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-individual-debuffsbyplayer` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[9] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-individual-dmgdonebyability` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[10] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-individual-dmgdonetoenemy` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[11] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-individual-dmgtakenbyplayer` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[12] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-individual-dmgtakenfromability` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[13] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-individual-dmgtakenfromsource` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[14] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-individual-healingbyability` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[15] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-individual-healingtofriendly` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[16] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-individual-interrupts` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[17] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-individual-procs` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[18] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-interruptsmissed` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[19] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-newbuffs` WHERE rid = "'.$var.'"')->fetch();
	$offsets[20] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-newdebuffs` WHERE rid = "'.$var.'"')->fetch();
	$offsets[21] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-records` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[22] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-dmgdonetofriendly` WHERE attemptid IN ('.$aids.')')->fetch();
	$offsets[23] = $pdo->query('SELECT IFNULL(MIN(id), 0) as min, IFNULL(MAX(id), 0) as max FROM `v-raids-loot` WHERE attemptid IN ('.$aids.')')->fetch();
	
	$pdo->query('UPDATE `v-raids` SET
		casts = "'.$offsets[1]["min"].','.$offsets[1]["max"].'",
		deaths = "'.$offsets[2]["min"].','.$offsets[2]["max"].'",
		dispels = "'.$offsets[3]["min"].','.$offsets[3]["max"].'",
		ddtf = "'.$offsets[22]["min"].','.$offsets[22]["max"].'",
		graphdmg = "'.$offsets[4]["min"].','.$offsets[4]["max"].'",
		graphdmgt = "'.$offsets[5]["min"].','.$offsets[5]["max"].'",
		graphheal = "'.$offsets[6]["min"].','.$offsets[6]["max"].'",
		inddeath = "'.$offsets[7]["min"].','.$offsets[7]["max"].'",
		inddbp = "'.$offsets[8]["min"].','.$offsets[8]["max"].'",
		indddba = "'.$offsets[9]["min"].','.$offsets[9]["max"].'",
		indddte = "'.$offsets[10]["min"].','.$offsets[10]["max"].'",
		inddtbp = "'.$offsets[11]["min"].','.$offsets[11]["max"].'",
		inddtfa = "'.$offsets[12]["min"].','.$offsets[12]["max"].'",
		inddtfs = "'.$offsets[13]["min"].','.$offsets[13]["max"].'",
		indhba = "'.$offsets[14]["min"].','.$offsets[14]["max"].'",
		indhtf = "'.$offsets[15]["min"].','.$offsets[15]["max"].'",
		indint = "'.$offsets[16]["min"].','.$offsets[16]["max"].'",
		indprocs = "'.$offsets[17]["min"].','.$offsets[17]["max"].'",
		indintm = "'.$offsets[18]["min"].','.$offsets[18]["max"].'",
		newbuffs = "'.$offsets[19]["min"].','.$offsets[19]["max"].'",
		newdebuffs = "'.$offsets[20]["min"].','.$offsets[20]["max"].'",
		indrecords = "'.$offsets[21]["min"].','.$offsets[21]["max"].'",
		loot = "'.$offsets[23]["min"].','.$offsets[23]["max"].'"
	WHERE id = "'.$var.'";');
}	
?>