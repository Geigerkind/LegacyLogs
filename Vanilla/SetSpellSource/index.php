<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>Introduction</h1>
					<p>
						Please choose whatever you think fitts best for this spell.<br />
						'.($r = ($_GET["s"] == 1 && $_GET["s"] != null) ? "<span id=\"success\">The spell has been updated. Thank you for helping!</span>" : "").($r = ($_GET["s"] == -1 && $_GET["s"] != null) ? "<span id=\"failure\">The spell could not be updated. There has been a failure :(</span>" : "").'
					</p>
				</div>
			</section>
		';
		if ($_GET["s"] != 1 && $_GET["s"] == null){
			$obj = $this->db->query('SELECT * FROM spells WHERE sourceid = 0 AND id = "'.intval(str_replace(array("<", ">", ";", "'", "%", "\\"), "", intval($this->antiSQLInjection($_GET["id"])))).'";')->fetch();
			if (isset($obj) and isset($obj->sourceid) and $obj->sourceid==0){
				$content .= '
				<section class="centredNormal formular">
					<form action="work.php" method="post">
						<input type="hidden" name="id" value="'.$obj->id.'" />
						<div class="pseudoButton">'.$obj->name.'</div>
						<select name="cat">
							<option value="1">Player</option>
							<option value="2">World</option>
							<option value="3">Set-Bonus</option>
							<option value="4">Pet</option>
							<option value="5">Trinket</option>
							<option value="6">Weapon</option>
							<option value="7">Enchantment</option>
							<option value="8">Alchemy</option>
							<option value="9">Item</option>
							<option value="10">Engineering</option>
							<option value="11">Blacksmithing</option>
							<option value="12">Leatherworking</option>
							<option value="13">NPC</option>
							<option value="14">Racial</option>
							<option value="15">Other</option>
						</select>
						<input type="submit" value="Update" name="submit" />
					</form>
				</section>
				';
			}
		}
		$content .= '
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir){
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__);

?>