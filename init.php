<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

session_start();
date_default_timezone_set('Europe/Berlin');
mb_internal_encoding("UTF-8");

require 'Database/Mysql.php';
require 'External/phpQuery/phpQuery.php';

$keyData = new KeyData();
$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// checking user
if (isset($_COOKIE["lluser"])){
	$cred = explode(",", base64_decode($_COOKIE["lluser"]));
	$cred[0] = str_replace(array(';', '"', '\'', '<', '>', '=', '@', '*', 'DELETE FROM', '`'), "", $cred[0]);
	$cred[1] = str_replace(array(';', '"', '\'', '<', '>', '=', '@', '*', 'DELETE FROM', '`'), "", $cred[1]);
	$q = $db->query('SELECT id, level, ads FROM `user` WHERE name = "'.$cred[0].'" AND pass = "'.$cred[1].'";')->fetch();
	if ($cred[0]!="" && $cred[1]!="" && !isset($q->id)){
		setcookie("lluser", null, time()-1000, "/", "legacy-logs.com", true);
		$_COOKIE["lluser"] = null;
	}else{
		setcookie("lluser", base64_encode($cred[0].",".$cred[1]), time()+2600000, "/", "legacy-logs.com", true);
		define("USERLEVEL", $q->level);
		define("USERADS", $q->ads);
	}
}

require 'Modules/Site.php';

?>