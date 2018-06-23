<?php

require '../Database/Mysql.php';
class WipeQuarter{
	private $db = null;
	
	private function commit(){
		$this->db->query('UPDATE `v-rankings` SET bmtime = 0, amtime = 0, bmchange = 0, amchange = 0, bmval = 0, amval = 0, mattemptid = 0, boamount = 0');
		$this->db->query('UPDATE `v-speed-kills` SET fmtime = 0, fmatime = 0, fmchange = 0, fmachange = 0, mraidid = 0, fmamount = 0');
		$this->db->query('UPDATE `v-speed-runs` SET fmtime = 0, fmboss = 0, fmatime = 0, fmaboss = 0, mraidid = 0, fmchange = 0, fmachange = 0, fmamount = 0');
		$this->db->query('UPDATE `v-immortal-runs` SET modeaths = 0, moadeaths = 0, mochange = 0, moachange = 0, morid = 0, moarid = 0, moamount = 0, moaamount = 0');
		
		$this->db->query('UPDATE `tbc-rankings` SET bmtime = 0, amtime = 0, bmchange = 0, amchange = 0, bmval = 0, amval = 0, mattemptid = 0, boamount = 0');
		$this->db->query('UPDATE `tbc-speed-kills` SET fmtime = 0, fmatime = 0, fmchange = 0, fmachange = 0, mraidid = 0, fmamount = 0');
		$this->db->query('UPDATE `tbc-speed-runs` SET fmtime = 0, fmboss = 0, fmatime = 0, fmaboss = 0, mraidid = 0, fmchange = 0, fmachange = 0, fmamount = 0');
		$this->db->query('UPDATE `tbc-immortal-runs` SET modeaths = 0, moadeaths = 0, mochange = 0, moachange = 0, morid = 0, moarid = 0, moamount = 0, moaamount = 0');
		
		$this->db->query('UPDATE `wotlk-rankings` SET bmtime = 0, amtime = 0, bmchange = 0, amchange = 0, bmval = 0, amval = 0, mattemptid = 0, boamount = 0');
		$this->db->query('UPDATE `wotlk-speed-kills` SET fmtime = 0, fmatime = 0, fmchange = 0, fmachange = 0, mraidid = 0, fmamount = 0');
		$this->db->query('UPDATE `wotlk-speed-runs` SET fmtime = 0, fmboss = 0, fmatime = 0, fmaboss = 0, mraidid = 0, fmchange = 0, fmachange = 0, fmamount = 0');
		$this->db->query('UPDATE `wotlk-immortal-runs` SET modeaths = 0, moadeaths = 0, mochange = 0, moachange = 0, morid = 0, moarid = 0, moamount = 0, moaamount = 0');
	}
	
	public function __construct($db){
		$this->db = $db;
		$this->commit();
	}
}

$keyData = new KeyData();
$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

new WipeQuarter($db);

?>