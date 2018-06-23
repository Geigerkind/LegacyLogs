<?php
$pdo = new PDO('mysql:host=localhost;dbname=llupload', 'llupload', 'phaum7vait3kahx', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
// Get List of already existing objects
$existArmory = array();
foreach($pdo->query('SELECT name FROM armory') as $row){
	$existArmory[$row["name"]] = true;
}

$files = glob('Armory/*.lua.gz');
array_multisort(array_map( 'filemtime', $files ),SORT_NUMERIC,SORT_ASC,$files);
foreach ($files as $k => $v){
	$name = str_replace(array("../Modules/Armory/", "Armory/", "/", ".lua.gz", ".lua"), "", $v);
	if (!isset($existArmory[$name])){
		$pdo->query('INSERT INTO armory (name, ts) VALUES ("'.$name.'", "'.time().'")');
		$f = gzfile($v);
		$out_file = fopen("Armory/".$name.".html", 'wb'); 
		foreach ($f as $line) {
			fwrite($out_file, $line);
		}
		fclose($out_file);
		break;
	}
}

exit();
?>