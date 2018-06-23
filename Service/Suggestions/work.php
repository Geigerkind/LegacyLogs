<?php

require "../../Database/Mysql.php";

class work{
	private $db = null;
	private $text = "";
	
	private function antiSQLInjection($str){
		return str_replace(array(';', '"', '\'', '<', '>', '=', '@', '*', 'DELETE FROM', '`'), "", $str);
	}
	
	private function validateValues($text){
		if ($text != ""){
			if (gettype($text) == "string"){
				$this->text = $this->antiSQLInjection($text);
				return true;
			}
		}
		return false;
	}
	
	private function commit($text, $cat, $prio){
		if ($this->validateValues($text)){
			if (intval($cat) != null && intval($prio) != null){
				$this->db->query('INSERT INTO suggestions (cat, prio, text, timestamp) VALUES ("'.intval($this->antiSQLInjection($cat)).'", "'.intval($this->antiSQLInjection($prio)).'", "'.$this->text.'", "'.time().'");');
				header('Location: index.php?s=1');
				exit();
			}
			header('Location: index.php?s=-1');
			exit();
		}
		header('Location: index.php?s=-1');
		exit();
	}
	
	public function __construct($db, $text, $cat, $prio){
		$this->db = $db;
		$this->commit($text, $cat, $prio);
	}
}

$keyData = new KeyData();
$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
new work($db, $_POST["text"], $_POST["cat"], $_POST["prio"]);

?>