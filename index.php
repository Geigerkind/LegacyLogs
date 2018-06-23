<?php
require(dirname(__FILE__)."/init.php");

class Home extends Site{
	
	public function content(){
		$content = '
			<div class="container" id="container">
				<header>
					<div class="newsbox">
						<h1>News</h1>
						<div class="text">
							Please visit Legacy Logs on <a href="https://twitter.com/LegacyLogs" target="_blank">Twitter</a> for the latest news, updates and notices! <br /><br />
							If you don\'t want to see advertisements, please activate ADBlocker or consider becoming an <a href="https://patreon.com/legacylogs">patreon</a>. <br />
							I appreatiate your support very much. Thank you. <br />
							If you want to know how to contribute data, <a href="{path}Contribute">click here</a>!
						</div>
					</div>
					<div class="newsbox right">
						<h1>Supporting</h1>
						<div class="text">
							This website is financed by donations. If you like my projects I would appreciate a <a href="{path}Donate">donation</a> very much or consider becoming an <a href="https://patreon.com/legacylogs" target="_blank">patreon</a>. (<a href="{path}Donators">Full list</a>)
							<table cellspacing="0">
		';
		foreach($this->db->query('SELECT name, amount, time FROM donators ORDER BY id DESC LIMIT 3') as $row){
			$content .= '
								<tr>
									<td>'.$row->name.'</td>
									<td>'.$row->amount.'€</td>
									<td>'.date('d.m.y H:i', $row->time).'</td>
								</tr>
			';
		}
		$content .= '
							</table>
						</div>
					</div>
				</header>
			</div>
			<section class="white-box searchbar">
				<form action="{path}Search">
					<input type="search" placeholder="Press enter to search" name="val" required />
					<select name="realm">
						<option value="0">Any realm</option>
			';
				foreach($this->db->query('SELECT * FROM servernames') as $row){
					$content .= '
						<option value="'.$row->id.'">'.$row->name.'</option>
					';
				}	
			$content .= '
					</select>
					<select name="faction">
						<option value="0">Any faction</option>
						<option value="1" class="alliance">Alliance</option>
						<option value="-1" class="horde">Horde</option>
					</select>
					<select name="class">
						<option value="0">Any class</option>
						<option value="1" class="color-warrior">Warrior</option>
						<option value="2" class="color-rogue">Rogue</option>
						<option value="3" class="color-priest">Priest</option>
						<option value="4" class="color-hunter">Hunter</option>
						<option value="5" class="color-druid">Druid</option>
						<option value="6" class="color-mage">Mage</option>
						<option value="7" class="color-warlock">Warlock</option>
						<option value="8" class="color-paladin">Paladin</option>
						<option value="9" class="color-shaman">Shaman</option>
						<option value="10" class="color-deathknight">Death Knight</option>
					</select>
				</form>
			</section>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir){
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__);

?>