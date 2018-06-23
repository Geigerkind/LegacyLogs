<?php
require(dirname(__FILE__)."/../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>Backup</h1>
					<img src="yoda.png" />
					<p>
						We are currently writing the database backup. <br />
						It will just take a minute... <br /><br />
						<a href="'.$_COOKIE["lasturl"].'">Click here to try again.</a><br /><br /><br /><br />
						<span style="font-size: 6px">Or the server died...</span>
					</p>
				</div>
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