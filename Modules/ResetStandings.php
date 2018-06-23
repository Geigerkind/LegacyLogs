<?php
	if (date("w")==6 || date("w")==5 || date("w")==0){
$pdo = new PDO('mysql:host=localhost;dbname=legacylo_shino', 'shino', 'P.r!UTIrK##mq[%+1M', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); // Need to change it later for live db
		//$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$pdo->query('UPDATE `armory-honor` SET curstanding = 0');
		print "DONE!";
	}
?>