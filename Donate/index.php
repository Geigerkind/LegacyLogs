<?php
require(dirname(__FILE__)."/../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>Introduction</h1>
					<p>
						This project is being kept alive by donations. The server costs currently around 15€ per month. However, dependent on the usage of the website, I\'d have to upgrade the server in order to keep loading times as low as possible to maximize the user experience, which will increase the cost. As poor student I can\'t really afford it though, so I would appreatiate your support very much!.
					</p>
					<h1>Purpose</h1>
					<p>
						The donations are being used in order to keep the server up and to improve this project even more.
					</p>
					<h1>Donating</h1>
					<p>
						If you consider to donate for this project, leave a comment with your (ingame)name if you want to have your name shown, else it will list you as anonymous. <br />
						You can find a list of all donators <a href="{path}Donators">here</a>! <br />
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="57SWBZ3B7RTTQ">
							<input type="image" src="https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
							<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
						</form>
						You can also support me on <a href="https://www.patreon.com/legacylogs">patreon</a> and receive nice rewards if you like!<br /><br />
						Thank you very much for supporting this project and keeping it alive!
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