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
						Hey! You\'d like to contribute some data? That is great! Legacy Logs is highly dependent on voluntary collected and uploaded data. Once the data is uploaded, it will be processed. That can take several minutes depending on the que. However once it is done, the data will be available for an permanent time, allowing complex analyzation and advanced e-penis comparison.
					</p>
					<h1>How to upload data</h1>
					<p>
						In order to upload data you need 2 tools for it. One being the <a href="{path}Addons">newest version of DPSMate</a>, the addon you will collect the data with, and a <a href="{path}Client.zip">client</a> that you will have to launch the game with, which will upload your collected data upon closing the client to Legacy Logs. 
						<br />Make sure to disable automatic data resets, so no data is lost until you logout. Be aware that the file that DPSMate is saving upon logout is very big (up to 20mb). Therefore it might take up to 2 minutes.
					</p>
					<h1>Armory</h1>
					<p>
						Since the 10th of August, Legacy Logs does have an Armory system to provide a more information for analyzation. The collection addons for the evaluation and the armory are <b>split</b>. That gives you the possibility to decide whether you want to upload armory data or not.<br />
						To upload the armory data you will need the LegacyLogsArmory (<a href="{path}LegacyLogsArmory.zip">Vanilla</a> / <a href="{path}LegacyLogsArmoryTBC.zip">TBC</a> / <a href="{path}LegacyLogsArmoryWOTLK.zip">WOTLK</a>)-Addon and the <a href="{path}Client.zip">launcher</a>. With those you\'d have to launch wow with the launcher and leave the addon running in the background. Don\'t worry, it doesn\'t eat ressources at all. Upon closing the launcher, the data will be uploaded automatically.
					</p>
					<h1>Step by step guide</h1>
					<p>
						0. Make sure to install the current version of Java and Java Runtime Environment. <br />
						1. Download <a href="{path}Addons" target="_blank">DPSMate</a> and the <a href="{path}Client.zip">client</a>. (Rename the extracted addonfolder to "DPSMate") <br />
						2. Download the LegacyLogsArmory (<a href="{path}LegacyLogsArmory.zip">Vanilla</a> / <a href="{path}LegacyLogsArmoryTBC.zip">TBC</a> / <a href="{path}LegacyLogsArmoryWOTLK.zip">WOTLK</a>)-Addon if you want to upload armory data aswell. <br />
						3. Choose the client for your system. (In the zip file is jar and two exe files. The Java ones require Java Development kit.) <br />
						4. Launch the client. <br />
						<img src="img/1.png" class="img"><br />
						5. Select the path to WoW.exe <br />
						6. Click on Launch. <br />
						7. After closing WoW.exe, the logs will be uploaded automatically. Therefore the program will ask you if it may use your network. That you have to accept. <br />
						8. Wait for the upload to complete. Do not start a second launcher during the upload!
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