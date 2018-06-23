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
						Legacy Logs is an advanced combat evaluation site developed by Shino (Geigerkind) and inspired by Kronos-Logs, Realmplayers, Worldoflogs and Warcraftlogs. In an effort to provide you with the tools to peruse and disect the information accrued by my latest AddOn, DPSMate, I am releasing Legacy Logs, its web-based companion. While still a work-in-progress, the site should finally grant us the ability to find definitive answers to some of the most hard to pin down dillemas concerning Class, Gear and Encounter mechanics.
					</p>
					<h1>How does it work</h1>
					<p>
						Legacy Logs is highly dependent on voluntary collected and uploaded data. Once the data is uploaded, it will be processed. That can take several minutes depending on the que and will be made available, once it is finished.
						<br />If you want to learn more about how to upload data, please click <a href="{path}Contribute">here</a>.
					</p>
					<h1>Data contributors</h1>
					<p>
						You can find a list of all data contributors <a href="{path}Contributors">here</a>!
					</p>
					<h1>Extra thanks</h1>
					<p>
						<b>Weasel</b> - Thank you for providing the name "Legacy Logs".<br />
						<b>Dalloway</b> - Thank you for testing the page, correcting my bad english and telling me useful features. <br />
						<b>Terrorpuschl</b> - Thank you for a lot of suggestions, test logs and help to test DPSMate and this site. <br />
						<b>Epia</b> - Thank you for a lot of bugreports and logs. <br />
						<b>Kryptik</b> - Thank you for a lot of bugreports and logs. <br />
						<b>Badorr</b> - Thank you for a lot of bugreports and logs. <br />
						<b>Inheritance</b> - Thank you guys for providing me with the logs!<br />
						<b>Neo</b> - Thanks you for providing this awesome design! <br />
						<b>Nether</b> - Thank you for helping me with pretty much anything. Without you I could\'t have released TBC so early! <br />
						<b>Bandyto</b> - Thank you for answering stupid questions and providing me with logs and suggestions! <br />
						<b>Dreamstate</b> - Thank you guys for beta testing DPSMate and providing me with test logs I can use! <br />
						<b>All donators</b> - Thank you so much! I appreatiate the support a lot!<br /><br />
						
						Huge thanks to <b>TwinStar</b> for letting me use their database to generate tooltips.<br />
						<a href="http://www.twinstar.cz/"><img src="{path}About/twinstar.png" /></a>
					</p>
					<h1>Changelogs</h1>
					<p>
						The changelog of Legacy Logs can be found <a href="{path}Service/Changelog">here</a> and the changelog for the addons can be found <a href="{path}Addons">here</a>.
					</p>
					<h1>Contact</h1>
					<p>
						If you\'d like to submit an suggestions, please use <a href="{path}Service/Suggestions">this formular</a>. <br />
						If you want to submit an bugreport, please use <a href="{path}Service/Bugtracker">this formular</a>. <br />
						If you want to contact me because of something else, please use <a href="{path}Service/Contact">this formular</a>.
					</p>
					<h1>Donate</h1>
					<p>
						If you like the project, I will be happy about any donation. The donations will keep the project alive and will help improving it. <br />
						Please visit <a href="{path}Donate">this page</a>, if you want to learn more about it.
					</p>
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir){
		$this->siteTitle = "About";
		$this->keyWords = "about, information, donate, contact";
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__);

?>