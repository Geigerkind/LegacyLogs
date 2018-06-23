<?php
$info = explode(",", htmlentities($_POST["info"]));
if (!empty($info)){
	if (isset($info[0]) && isset($info[1])){
		$serverByName = array(
			"Unknown" => 1,
			"Kronos" => 2,
			"Nefarian" => 3,
			"Kronos II" => 4,
			"Rebirth" => 5,
			"VanillaGaming" => 6,
			"NostalGeek" => 7,
			"Warsong 1.12.1 [8x] Blizzlike" => 8,
			"Elysium" => 9,
			"Warsong" => 8,
			"Kul Tiras" => 10,
			"Zul'Dare" => 36,
			"Anathema" => 38,
			"Zeth'Kur" => 39,
			"Darrowshire" => 40,
		);
		if (isset($serverByName[$info[0]])){
			$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'shino', 'Celerion1234567890', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$q = $pdo->query('SELECT id, name FROM chars WHERE serverid = "'.$serverByName[$info[0]].'" AND name = "'.htmlentities($info[1]).'";')->fetch();
			if (intval($q["id"])!=0){
				move_uploaded_file($_FILES["img"]["tmp_name"], '../img/'.$info[0].'/'.$q["name"].'.png');
				$pdo->query('UPDATE armory SET toConfirm = 1 WHERE charid = "'.$q["id"].'";');
				header('Location: http://legacy-logs.com/Vanilla/Armory/SetAvatar/'.$info[0].'/'.$q["name"].'/1');
				exit();
			}
		}
	}
}
header('Location: http://legacy-logs.com/Vanilla/Armory/SetAvatar/'.$info[0].'/'.$info[1].'/0');
exit();

?>