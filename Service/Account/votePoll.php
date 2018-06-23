<?php

require '../../Database/Mysql.php';
class votePoll{
	private $cred = array();
	
	private function antiSQLInjection($str){
		return str_replace(array(';', '"', '\'', '<', '>', '=', '*', 'DELETE FROM', '`'), "", $str);
	}
	
	private function goHome(){
		header('Location: index.php?s=3');
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
	
	private function commit($db, $name, $pid){
		if ($this->validUser($db)){
			$accid = $db->query('SELECT id FROM `user` WHERE name = "'.$this->cred[0].'" AND pass = "'.$this->cred[1].'" AND level >= 3;')->fetch()->id;
			$db->query('DELETE FROM `poll-votes` WHERE accid = "'.intval($accid).'" AND pollid = "'.$pid.'";');
			if ($name>0)
				$db->query('INSERT INTO `poll-votes` (pollid, accid, optionid) VALUES ("'.$pid.'", "'.intval($accid).'", "'.$name.'");'); // optionid => num
		}
	}
	
	public function __construct($db, $pid){
		$name = 0;
		for ($i=1; $i<=10; $i++){
			if (isset($_POST["option-".$i])){
				$name = $i;
				break;
			}
		}
		$this->commit($db, $name, intval($this->antiSQLInjection($pid)));
		$this->goHome();
	}
}

$keyData = new KeyData();
$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

new votePoll($db, $_POST["pid"]);

?>