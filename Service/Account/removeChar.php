<?php

require '../../Database/Mysql.php';
class removeChar{
	private $cred = array();
	
	private function antiSQLInjection($str){
		return str_replace(array(';', '"', '\'', '<', '>', '=', '*', 'DELETE FROM', '`'), "", $str);
	}
	
	private function goHome(){
		header('Location: index.php?s=2');
		exit();
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
	
	private function commit($db, $name){
		if ($name!="" && $this->validUser($db)){
			$accid = $db->query('SELECT id FROM `user` WHERE name = "'.$this->cred[0].'" AND pass = "'.$this->cred[1].'" AND level >= 2;')->fetch()->id;
			$db->query('DELETE FROM `user-silver-chars` WHERE accid = "'.intval($accid).'" AND id = "'.$name.'";');
		}
	}
	
	public function __construct($db){
		$name = "";
		for ($i=1; $i<=10; $i++){
			if (isset($_POST["cid-".$i])){
				$name = $_POST["cidVal-".$i];
				break;
			}
		}
		$this->commit($db, intval($this->antiSQLInjection(base64_decode($name))));
		$this->goHome();
	}
}

$keyData = new KeyData();
$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

new removeChar($db);

?>