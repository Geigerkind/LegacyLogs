<?php
	$items = array();
	$enchants = array();
	
	function antiSQLInjection($str){
		return str_replace(array(';', '"', '\'', '<', '>', '=', '@', '*', 'DELETE FROM', '`', 'RESET', 'ALL'), "", $str);
	}
	
	for ($i=1; $i<=19; $i++){
		$items[] = intval(antiSQLInjection($_POST["inv".$i]));
		$enchants[] = intval(antiSQLInjection($_POST["ench".$i]));
	}
	
	header('Location: index.php?items='.implode(",",$items).'&enchants='.implode(",",$enchants).'&misc='.intval(antiSQLInjection($_POST["race"])).','.intval(antiSQLInjection($_POST["gender"])).','.intval(antiSQLInjection($_POST["class"])).','.intval(antiSQLInjection($_POST["talent"])));
	exit();
?>