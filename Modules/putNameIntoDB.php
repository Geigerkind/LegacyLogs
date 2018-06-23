<?php
$pdo = new PDO('mysql:host=localhost;dbname=llupload', 'llupload', 'phaum7vait3kahx', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
// Get List of already existing objects
$existFiles = array();
foreach($pdo->query('SELECT name FROM files') as $row){
	$existFiles[$row["name"]] = true;
}

$files = glob('Files/*.lua.gz');
array_multisort(array_map( 'filemtime', $files ),SORT_NUMERIC,SORT_DESC,$files);
foreach ($files as $k => $v){
	$name = str_replace(array("../Modules/Files/", "Files/", "/", ".lua.gz", ".lua"), "", $v);
	if (!isset($existFiles[$name])){
		$pdo->query('INSERT INTO files (name, ts) VALUES ("'.$name.'", "'.time().'")');
		$f = gzfile($v);
		$out_file = fopen("Files/".$name.".html", 'wb'); 
		foreach ($f as $line) {
			fwrite($out_file, $line);
		}
		fclose($out_file);
		break;
	}
}

exit();
?>