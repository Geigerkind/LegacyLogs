<?php

require "../../Database/Mysql.php";

class work{
	private $db = null;
	private $text = "";
	
	private function antiSQLInjection($str){
		return str_replace(array(';', '"', '\'', '<', '>', '=', '@', '*', 'DELETE FROM', '`'), "", $str);
	}
	
	private function validateValues($text, $name, $mail, $subject){
		if ($text != "" && $name != "" && $mail != "" && $subject != ""){
			if (gettype($text) == "string" && gettype($name) == "string" && gettype($mail) == "string" && gettype($subject) == "string"){
				if (filter_var($mail, FILTER_VALIDATE_EMAIL)){
					$this->text = $this->antiSQLInjection($text);
					$this->name = $this->antiSQLInjection($name);
					$this->subject = $this->antiSQLInjection($subject);
					$this->mail = $this->antiSQLInjection($mail);
					return true;
				}
			}
		}
		return false;
	}
	
	private function commit($text, $name, $mail, $subject){
		if ($this->validateValues($text, $name, $mail, $subject)){
			$this->db->query('INSERT INTO contact (name, subject, text, mail, timestamp) VALUES ("'.$this->name.'", "'.$this->subject.'", "'.$this->text.'", "'.$this->mail.'", "'.time().'");');
			header('Location: index.php?s=1');
			exit();
		}
		header('Location: index.php?s=-1');
		exit();
	}
	
	public function __construct($db, $text, $name, $mail, $subject){
		$this->db = $db;
		$this->commit($text, $name, $mail, $subject);
	}
}

$keyData = new KeyData();
$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
new work($db, $_POST["text"], $_POST["name"], $_POST["mail"], $_POST["subject"]);

?>