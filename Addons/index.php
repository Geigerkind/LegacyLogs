<?php
require(dirname(__FILE__)."/../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="centredNormal cont">
				<div class="table">
					<div class="right">
						<h1>DPSMate - A combat analyzation tool</h1>
						<p>
							DPSMate is not only a meter which shows numbers of the raid, such as damage done, damage taken, dispells etc., it is moreover an analyzing tool to review the raid or the previous fight as accurately as possible. This data can help to improve the gameplay or to judge better over someones performance. It is also being used in order to collect data for Legacy Logs.
						</p>
					</div>
				</div>
				<div class="table info">
					<div class="right">
						<img src="img/dpsmate.png" />
						<table cellspacing="0">
							<tr>
								<th></th>
								<th>Vanilla</th>
								<th>TBC</th>
								<th>WOTLK</th>
							</tr>
							<tr>
								<td>Overview</td>
								<td><a href="https://github.com/Geigerkind/dpsmate" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/dpsmatetbc" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/dpsmatewotlk" target="_blank">click</a></td>
							</tr>
							<tr>
								<td>Changelog</td>
								<td><a href="https://github.com/Geigerkind/dpsmate/commits/master" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/dpsmatetbc/commits/master" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/dpsmatewotlk/commits/master" target="_blank">click</a></td>
							</tr>
							<tr>
								<td>Bugtracker</td>
								<td><a href="https://github.com/Geigerkind/dpsmate/issues" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/dpsmatetbc/issues" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/dpsmatewotlk/issues" target="_blank">click</a></td>
							</tr>
							<tr>
								<td>Download</td>
								<td><a href="https://github.com/Geigerkind/dpsmate/releases" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/dpsmatetbc/releases" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/dpsmatewotlk/releases" target="_blank">click</a></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="table">
					<div class="right">
						<h1>ModifiedPowerAuras</h1>
						<p>
							Modified Power Auras is the advanced version of the AddOn Power Auras. It is a lot more powerful and provides every possible function that could be backported from cataclysm. Plus it provides some custom features that are very helpful.
						</p>
					</div>
				</div>
				<div class="table info">
					<div class="right">
						<img src="img/mpowa.png" />
						<table cellspacing="0">
							<tr>
								<th></th>
								<th>Vanilla</th>
								<th>TBC</th>
							</tr>
							<tr>
								<td>Overview</td>
								<td><a href="https://github.com/Geigerkind/modifiedpowerauras/overview" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/modifiedpoweraurastbc/overview" target="_blank">click</a></td>
							</tr>
							<tr>
								<td>Changelog</td>
								<td><a href="https://github.com/Geigerkind/modifiedpowerauras/commits/master" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/modifiedpoweraurastbc/commits/master" target="_blank">click</a></td>
							</tr>
							<tr>
								<td>Bugtracker</td>
								<td><a href="https://github.com/Geigerkind/modifiedpowerauras/issues" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/modifiedpoweraurastbc/issues" target="_blank">click</a></td>
							</tr>
							<tr>
								<td>Download</td>
								<td><a href="https://github.com/Geigerkind/modifiedpowerauras/releases" target="_blank">click</a></td>
								<td><a href="https://github.com/Geigerkind/modifiedpoweraurastbc/releases" target="_blank">click</a></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="table">
					<div class="right">
						<h1>Vanilla Consolidated Buffframes (VCB)</h1>
						<p>
							Vanilla Consolidate Buff-Frames (VCB) is a smart system to manage your auras. The AddOn provides a lot functions to customize it to your tastes and adds a lot of helpful functions for a better overview, which is its purpose in the first place anyway.
						</p>
					</div>
				</div>
				<div class="table info">
					<div class="right">
						<img src="img/vcb.png" />
						<table cellspacing="0">
							<tr>
								<th></th>
								<th>Vanilla</th>
								<th>TBC</th>
							</tr>
							<tr>
								<td>Overview</td>
								<td><a href="https://github.com/Geigerkind/vcb/overview" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Changelog</td>
								<td><a href="https://github.com/Geigerkind/vcb/commits/" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Bugtracker</td>
								<td><a href="https://github.com/Geigerkind/vcb/issues" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Download</td>
								<td><a href="https://github.com/Geigerkind/vcb/releases" target="_blank">click</a></td>
								<td>-</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="table">
					<div class="right">
						<h1>DebuffListCheck</h1>
						<p>
							DebuffListCheck checks the current master target for its buffs and reporting to everyone using the addon which important debuffs are or are not applied.
						</p>
					</div>
				</div>
				<div class="table info">
					<div class="right">
						<img src="img/dlc.png" />
						<table cellspacing="0">
							<tr>
								<th></th>
								<th>Vanilla</th>
								<th>TBC</th>
							</tr>
							<tr>
								<td>Overview</td>
								<td><a href="https://github.com/Geigerkind/debufflistcheck" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Changelog</td>
								<td><a href="https://github.com/Geigerkind/debufflistcheck/commits/master" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Bugtracker</td>
								<td><a href="https://github.com/Geigerkind/debufflistcheck/admin/issues" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Download</td>
								<td><a href="https://github.com/Geigerkind/debufflistcheck/releases" target="_blank">click</a></td>
								<td>-</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="table">
					<div class="right">
						<h1>BuffCounter</h1>
						<p>
							A simple Addon giving you a frame that shows you either how many buffs you can still get or many you have currently.
						</p>
					</div>
				</div>
				<div class="table info">
					<div class="right">
						<img src="img/buffcounter.png" />
						<table cellspacing="0">
							<tr>
								<th></th>
								<th>Vanilla</th>
								<th>TBC</th>
							</tr>
							<tr>
								<td>Overview</td>
								<td><a href="https://github.com/Geigerkind/buffcounter" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Changelog</td>
								<td><a href="https://github.com/Geigerkind/buffcounter/commits/master" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Bugtracker</td>
								<td><a href="https://github.com/Geigerkind/buffcounter/issues" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Download</td>
								<td><a href="https://github.com/Geigerkind/buffcounter/releases" target="_blank">click</a></td>
								<td>-</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="table">
					<div class="right">
						<h1>ExpandAssist</h1>
						<p>
							A small addon to allow the raid officer to do the same as the raid leader.
						</p>
					</div>
				</div>
				<div class="table info">
					<div class="right">
						<img src="img/ea.png" />
						<table cellspacing="0">
							<tr>
								<th></th>
								<th>Vanilla</th>
								<th>TBC</th>
							</tr>
							<tr>
								<td>Overview</td>
								<td><a href="https://github.com/Geigerkind/expandassist" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Changelog</td>
								<td><a href="https://github.com/Geigerkind/expandassist/commits/master" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Bugtracker</td>
								<td><a href="https://github.com/Geigerkind/expandassist/issues" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Download</td>
								<td><a href="https://github.com/Geigerkind/expandassist/releases" target="_blank">click</a></td>
								<td>-</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="table">
					<div class="right">
						<h1>StopWatch</h1>
						<p>
							Just a simple stopwatch.
						</p>
					</div>
				</div>
				<div class="table info">
					<div class="right">
						<img src="img/stw.png" />
						<table cellspacing="0">
							<tr>
								<th></th>
								<th>Vanilla</th>
								<th>TBC</th>
							</tr>
							<tr>
								<td>Overview</td>
								<td><a href="https://github.com/Geigerkind/stopwatch" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Changelog</td>
								<td><a href="https://github.com/Geigerkind/stopwatch/commits/master" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Bugtracker</td>
								<td><a href="https://github.com/Geigerkind/stopwatch/issues" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Download</td>
								<td><a href="https://github.com/Geigerkind/stopwatch/releases" target="_blank">click</a></td>
								<td>-</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="table">
					<div class="right">
						<h1>OneButtonHunter</h1>
						<p>
							An addon to execute the rotation of an hunter with one button. Aimed Shot, Multi-Shot and Auto Shot are required to be in the actionbars.
						</p>
					</div>
				</div>
				<div class="table info">
					<div class="right">
						<img src="img/hunter.png" />
						<table cellspacing="0">
							<tr>
								<th></th>
								<th>Vanilla</th>
								<th>TBC</th>
							</tr>
							<tr>
								<td>Overview</td>
								<td><a href="https://github.com/Geigerkind/onebuttonhunter" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Changelog</td>
								<td><a href="https://github.com/Geigerkind/onebuttonhunter/commits/master" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Bugtracker</td>
								<td><a href="https://github.com/Geigerkind/onebuttonhunter/issues" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Download</td>
								<td><a href="https://github.com/Geigerkind/onebuttonhunter/releases" target="_blank">click</a></td>
								<td>-</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="table">
					<div class="right">
						<h1>RogueRota</h1>
						<p>
							An addon to execute the rotation of a rogue. It will take health, energy, buffs and timers into account.
						</p>
					</div>
				</div>
				<div class="table info">
					<div class="right">
						<img src="img/rogue.jpg" />
						<table cellspacing="0">
							<tr>
								<th></th>
								<th>Vanilla</th>
								<th>TBC</th>
							</tr>
							<tr>
								<td>Overview</td>
								<td><a href="https://github.com/Geigerkind/roguerota" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Changelog</td>
								<td><a href="https://github.com/Geigerkind/roguerota/commits/master" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Bugtracker</td>
								<td><a href="https://github.com/Geigerkind/roguerota/issues" target="_blank">click</a></td>
								<td>-</td>
							</tr>
							<tr>
								<td>Download</td>
								<td><a href="https://github.com/Geigerkind/roguerota/releases" target="_blank">click</a></td>
								<td>-</td>
							</tr>
						</table>
					</div>
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