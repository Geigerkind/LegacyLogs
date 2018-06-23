<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	
	public function content(){
		$content = '<script type="text/javascript">function display(elem) {if (elem.style.display) {return elem.style.display;}if (elem.currentStyle) {return elem.currentStyle.display;}if (document.defaultView.getComputedStyle) {return document.defaultView.getComputedStyle(elem, null).getPropertyValue("display");}return "";}function toggle(id){var elements = ["eye", "tos", "icc", "totc", "trs", "ulduar", "ony", "naxx", "voa"];for (var i = 0, len = elements.length; i < len; i++) {if (document.getElementById(elements[i])){if (elements[i] != id){document.getElementById(elements[i]).style.display = "none";}}}if (display(document.getElementById(id)) == "none"){document.getElementById(id).style.display = "block";}else{document.getElementById(id).style.display = "none";}}</script>
		<div class="container" id="container">
			<section class="centredNormal">
				<div class="left">
					<div class="ref-button unselectable">
						<img src="img/ony.png" title="Click to toggle" onclick="toggle(\'ony\')" />
						<div>Onyxia\'s Lair</div>
						<table id="ony">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=25">10 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=26">25 NHC</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/naxx.png" title="Click to toggle" onclick="toggle(\'naxx\')" />
						<div>Naxxramas</div>
						<table id="naxx">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=27">10 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=28">25 NHC</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/eoe.png" title="Click to toggle" onclick="toggle(\'eye\')" />
						<div>Eye of Eternity</div>
						<table id="eye">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=29">10 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=30">25 NHC</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/totc.png" title="Click to toggle" onclick="toggle(\'totc\')" />
						<div>Trial of the Crusader</div>
						<table id="totc">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=37">10 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=39">10 HC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=38">25 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=40">25 HC</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/trs.png" title="Click to toggle" onclick="toggle(\'trs\')" />
						<div>Ruby Sanctum</div>
						<table id="trs">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=45">10 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=47">10 HC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=46">25 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=48">25 HC</a></td></tr>
						</table>
					</div>
				</div>
				<div class="right margin-half">
					<div class="ref-button unselectable">
						<div>Vault of Archavon</div>
						<img src="img/voa.png" title="Click to toggle" onclick="toggle(\'voa\')" />
						<table id="voa">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=31">10 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=32">25 NHC</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Obsidian Sanctum</div>
						<img src="img/tos.png" title="Click to toggle" onclick="toggle(\'tos\')" />
						<table id="tos">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=33">10 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=34">25 NHC</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Ulduar</div>
						<img src="img/ulduar.png" title="Click to toggle" onclick="toggle(\'ulduar\')" />
						<table id="ulduar">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=35">10 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=36">25 NHC</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Icecrown Citadel</div>
						<img src="img/icc.png" title="Click to toggle" onclick="toggle(\'icc\')" />
						<table id="icc">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=41">10 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=43">10 HC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=42">25 NHC</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=44">25 HC</a></td></tr>
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