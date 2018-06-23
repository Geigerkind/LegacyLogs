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
						Your suggestions will help improving this website, so please use this formular and tell me your thoughts! Suggestions or bug reports for Addons can be submited <a href="{path}/Addons">here</a>.<br />
						'.($r = ($_GET["s"] == 1 && $_GET["s"] != null) ? "<span id=\"success\">Your message has been send successfully.</span>" : "").($r = ($_GET["s"] == -1 && $_GET["s"] != null) ? "<span id=\"failure\">Your message could not be send.</span>" : "").'
					</p>
				</div>
			</section>
			<section class="centredNormal formular">
				<form action="work.php" method="post">
					<select name="cat" class="mright"><br />
						<option value="1">Evaluation</option>
						<option value="2">Style</option>
						<option value="3">Enhancement</option>
						<option value="4">Ranking</option>
						<option value="5">Loading</option>
						<option value="6">Other</option>
					</select>
					<select name="prio"><br />
						<option value="1">Low</option>
						<option value="2">Middle</option>
						<option value="3">High</option>
						<option value="4">Urgent</option>
					</select>
					<textarea placeholder="Your message..." name="text" required></textarea><br />
					<input type="submit" value="Send message" name="submit" />
				</form>
			</section>
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