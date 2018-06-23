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
						You found a bug? That is great. Please submit it in the bugtracker, so I can fix it asap!
					</p>
					<h1>How to write an bug report</h1>
					<p>
						It would help me a lot if you could answer the following questions in your report.<br /><br />
						1. Where has is happened? (Link to the page)<br />
						2. When did it happen?<br />
						3. Under which circumstances did it happen?<br />
						4. Do you know how to reproduce the bug?<br />
						5. Has there been an error message, if so, please provide it
					</p>
					<h1>Ok, where can I report the bug?</h1>
					<p>
						You can find the bugtracker <a href="https://github.com/Geigerkind/Legacy-Logs-Bugtracker/issues" target="_blank">here</a>. <br />
						For issues regarding DPSMate, please use the respective <a href="{path}Addons">bugtracker here</a>.
						<br /><br />
						Thank you very much for reporting this issue!
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