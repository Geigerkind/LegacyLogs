<?php

require "../../Database/Mysql.php";

class work{
	private $db = null;
	private $user = "";
	private $pass = "";
	private $mail = "";
	
	private function antiSQLInjection($str){
		return str_replace(array(';', '"', '\'', '<', '>', '=', '*', 'DELETE FROM', '`'), "", $str);
	}
	
	private function commit(){
		if ($this->db->query('SELECT id FROM `user` WHERE LOWER(name) = "'.strtolower($this->user).'";')->rowCount()==0){
			$this->db->query('INSERT INTO `user` (name, pass, mail, level, patreon, ads) VALUES ("'.$this->user.'", "'.$this->pass.'", "'.$this->mail.'", "0", "0", "0");');
			setcookie("lluser", base64_encode($this->user.",".$this->pass), time()+2600000, "/", "legacy-logs.com", true);
			header('Location: ../Account');
		}else{
			header('Location: index.php?s=2'); // Name is already taken
		}
		exit();
	}
	
	public function __construct($db, $user, $mail, $conmail, $pass, $conpass){
		$user = $this->antiSQLInjection($user);
		$mail = $this->antiSQLInjection($mail);
		$conmail = $this->antiSQLInjection($conmail);
		$pass = $this->antiSQLInjection($pass);
		$conpass = $this->antiSQLInjection($conpass);
		
		$banned = array(
			"shino" => true,
			"geigerkind" => true,
			"albea" => true,
			"lucker" => true,
		);
		
		if ($mail!="" && $pass!="" && $mail==$conmail && $pass==$conpass){
			if (isset($banned[strtolower($user)])){
				header('Location: index.php?s=2'); // Name is already taken
				exit();
			}
			if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
				header('Location: index.php?s=3'); // Email is invalid!
				exit();
			}
			$this->pass = md5($pass);
			$this->mail = $mail;
			$this->user = $user;
			$this->db = $db;
			$this->commit();
		}else{
			header('Location: index.php?s=1'); // 1 => Something went wrong, please contact Shino!
			exit();
		}
	}
}

$keyData = new KeyData();
$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
new work($db, $_POST["user"], $_POST["mail"], $_POST["conmail"], $_POST["pass"], $_POST["conpass"]);

?>