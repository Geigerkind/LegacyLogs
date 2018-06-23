<?php

require "../../Database/Mysql.php";

class work{
	private $db = null;
	private $user = "";
	private $pass = "";
	
	private function antiSQLInjection($str){
		return str_replace(array(';', '"', '\'', '<', '>', '=', '@', '*', 'DELETE FROM', '`'), "", $str);
	}
	
	private function commit(){
		$q = $this->db->query("SELECT id, name, pass FROM `user` WHERE name = '".$this->user."' AND pass = '".md5($this->pass)."';")->fetch();
		if (intval($q->id)>0){
			setcookie("lluser", base64_encode($q->name.",".$q->pass), time()+2600000, "/", "legacy-logs.com", true);
			header('Location: ../Account');
		}else{
			header('Location: index.php?s=1'); // Wrong username or password
		}
		exit();
	}
	
	public function __construct($db, $user, $pass){
		$this->user = $this->antiSQLInjection($user);
		$this->pass = $this->antiSQLInjection($pass);
		if ($this->user=="" || $this->pass==""){
			header('Location: index.php?s=1'); // Wrong username or password
			exit();
		}
		$this->db = $db;
		$this->commit();
	}
}

$keyData = new KeyData();
$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
new work($db, $_POST["user"], $_POST["pass"]);

?>