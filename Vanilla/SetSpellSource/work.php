<?php
$id = $_POST["id"];
$cat = $_POST["cat"];

if (isset($id) && isset($cat)){
	$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'shino', 'Celerion1234567890', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 
	//$pdo = new PDO('mysql:host=localhost;dbname=shino_latin', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 
	$pdo->query('UPDATE spells SET sourceid = "'.$cat.'" WHERE id = "'.$id.'" AND sourceid = 0;');
	header('Location: index.php?s=1');
	exit();
}
header('Location: index.php?s=-1');
exit();
?>