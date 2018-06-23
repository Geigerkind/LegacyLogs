<?php

require '../../Database/Mysql.php';
class changeSettings{
	private $cred = array();
	private $mail = "";
	private $pass = "";
	private $newpass = "";
	private $passconf = "";
	private $mode = 0;
	
	private function goHome(){
		header('Location: index.php');
		exit();
	}
	
	private function antiSQLInjection($str){
		return str_replace(array(';', '"', '\'', '<', '>', '=', '*', 'DELETE FROM', '`'), "", $str);
	}
	
	private function validUser($db){
		if (isset($_COOKIE["lluser"])){
			$this->cred = explode(",", base64_decode($_COOKIE["lluser"]));
			$this->cred[0] = str_replace(array(';', '"', '\'', '<', '>', '=', '@', '*', 'DELETE FROM', '`'), "", $this->cred[0]);
			$this->cred[1] = str_replace(array(';', '"', '\'', '<', '>', '=', '@', '*', 'DELETE FROM', '`'), "", $this->cred[1]);
			if ($this->cred[0]!="" && $this->cred[1]!="" && $db->query('SELECT id FROM `user` WHERE name = "'.$this->cred[0].'" AND pass = "'.$this->cred[1].'";')->rowCount()==0){
				setcookie("lluser", null, time()-1000, "/", "legacy-logs.com", true);
				$_COOKIE["lluser"] = null;
				return false;
			}else{
				setcookie("lluser", base64_encode($this->cred[0].",".$this->cred[1]), time()+2600000, "/", "legacy-logs.com", true);
				return true;
			}
		}
		return false;
	}
	
	private function commit($db){
		if ($this->validUser($db)){
			if ($this->cred[1]==md5($this->pass)){
				if ($this->mode==1 && !filter_var($this->mail, FILTER_VALIDATE_EMAIL) === false){
					$db->query('UPDATE `user` SET mail = "'.$this->mail.'" WHERE name = "'.$this->cred[0].'" AND pass = "'.$this->cred[1].'";');
				}elseif ($this->mode==2 && $this->newpass == $this->passconf && $this->newpass != ""){
					$db->query('UPDATE `user` SET pass = "'.md5($this->newpass).'" WHERE name = "'.$this->cred[0].'" AND pass = "'.$this->cred[1].'";');
				}
			}
		}
	}
	
	public function __construct($db){
		if (isset($_POST["chmail"])){
			$this->mail = $this->antiSQLInjection($_POST["mail"]);
			$this->pass = $this->antiSQLInjection($_POST["pass"]);
			$this->mode = 1;
		}elseif (isset($_POST["chpass"])){
			$this->newpass = $this->antiSQLInjection($_POST["passnew"]);
			$this->passconf = $this->antiSQLInjection($_POST["passnewconf"]);
			$this->pass = $this->antiSQLInjection($_POST["oldpass"]);
			$this->mode = 2;
		}else{
			$this->goHome();
		}
		$this->commit($db);
		$this->goHome();
	}
}

$keyData = new KeyData();
$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

new changeSettings($db);

?>