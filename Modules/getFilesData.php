<?php
$pdo = new PDO('mysql:host=localhost;dbname=llupload', 'llupload', 'phaum7vait3kahx', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$q = $pdo->query('SELECT id, name FROM files WHERE ('.time().'-ts)>=20 AND isprocessed = -1 ORDER BY id LIMIT 1')->fetch();
print $q["name"];
if (isset($q["name"]) && $q["name"] != ""){
	$pdo->query('UPDATE files SET isprocessed = 1 WHERE id = '.$q["id"]);
}
?>