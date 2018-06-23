<?php
require(dirname(__FILE__)."/../Template.php");

class Home extends Template{
	
	public function content(){
		$content = $this->getSame(99, true);
		$content .= '
		<div class="table newmargin">
			To be added! 
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $rid, $attempts, $player, $attemptid, $pet, $mode, $events, $npcid){
		parent::__construct($db, $dir, $rid, $attempts, $player, $attemptid, $mode, $pet, $events, $npcid);
	}
}

new Home($db, __DIR__, $_GET["rid"], $_GET["attempts"], $_GET["player"], $_GET["sel"], $_GET["pet"], $_GET["mode"], $_GET["events"], $_GET["tarid"]);

?>