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
						If you are looking for submitting an suggestion towards Legacy Logs, please use <a href="{path}Service/Suggestions">this formular</a>.<br />
						If you are looking for submitting an bug report, please use <a href="{path}Service/Bugtracker">this formular</a>.<br />
						'.($r = ($_GET["s"] == 1 && $_GET["s"] != null) ? "<span id=\"success\">Your message has been send successfully.</span>" : "").($r = ($_GET["s"] == -1 && $_GET["s"] != null) ? "<span id=\"failure\">Your message could not be send.</span>" : "").'
					</p>
				</div>
			</section>
			<section class="centredNormal formular">
				<form action="work.php" method="post">
					<input type="text" name="name" placeholder="Your name..." required/><br />
					<input type="text" name="mail" placeholder="Your mail address..." required/><br />
					<input type="text" name="subject" placeholder="Subject..." required/><br />
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