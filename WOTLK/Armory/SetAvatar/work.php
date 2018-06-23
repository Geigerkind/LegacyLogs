<?php
$info = explode(",", htmlentities($_POST["info"]));
if (!empty($info)){
	if (isset($info[0]) && isset($info[1])){
		$serverByName = array(
			"Unknown" => 19,
			"Frostmourne" => 20,
			"Lordaeron" => 21,
			"Icecrown" => 22,
			"Blackrock [Pvp only]" => 23,
			"Hyperion" => 24,
			"TrueWoW" => 25,
			"Algalon" => 26,
			"Algalon - Main Realm" => 26,
			"Kirin Tor" => 27,
			"Legacy" => 28,
			"Legacy - Instant 80" => 28,
			"Elysium" => 29,
			"Redemption" => 30,
			"WoW Circle 3.3.5 x10" => 31,
			"WoW Circle 3.3.5 x25" => 32,
			"WoW Circle 3.3.5 x5" => 33,
			"WoW Circle 3.3.5 x1" => 34,
			"Rising-Gods" => 35,
			"Heroes Of Wow (3.3.5)" => 41,
			"Feronis" => 42,
		);
		if (isset($serverByName[$info[0]])){
			$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'shino', 'Celerion1234567890', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$q = $pdo->query('SELECT id, name FROM chars WHERE serverid = "'.$serverByName[$info[0]].'" AND name = "'.htmlentities($info[1]).'";')->fetch();
			if (intval($q["id"])!=0){
				move_uploaded_file($_FILES["img"]["tmp_name"], '../img/'.$info[0].'/'.$q["name"].'.png');
				$pdo->query('UPDATE armory SET toConfirm = 1 WHERE charid = "'.$q["id"].'";');
				header('Location: http://legacy-logs.com/TBC/Armory/SetAvatar/'.$info[0].'/'.$q["name"].'/1');
				exit();
			}
		}
	}
}
header('Location: http://legacy-logs.com/TBC/Armory/SetAvatar/'.$info[0].'/'.$info[1].'/0');
exit();

?>