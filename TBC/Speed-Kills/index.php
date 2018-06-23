<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	
	public function content(){
		$content = '<script type="text/javascript">function display(elem) {if (elem.style.display) {return elem.style.display;}if (elem.currentStyle) {return elem.currentStyle.display;}if (document.defaultView.getComputedStyle) {return document.defaultView.getComputedStyle(elem, null).getPropertyValue("display");}return "";}function toggle(id){var elements = ["kara", "mag", "swp", "bt", "ssc", "gruul", "hyjal", "eye"];for (var i = 0, len = elements.length; i < len; i++) {if (document.getElementById(elements[i])){if (elements[i] != id){document.getElementById(elements[i]).style.display = "none";}}}if (display(document.getElementById(id)) == "none"){document.getElementById(id).style.display = "block";}else{document.getElementById(id).style.display = "none";}}</script>
		<div class="container" id="container">
			<section class="centredNormal">
				<div class="left">
					<div class="ref-button unselectable">
						<img src="img/kara.png" title="Click to toggle" onclick="toggle(\'kara\')" />
						<div>Karazhan</div>
						<table id="kara">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=17">Attumen the Huntsman</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=18">Moroes</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=19">Opera event</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=20">Maiden of Virtue</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=21">The Curator</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=22">Terestian Illhoof</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=23">Shade of Aran</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=24">Netherspite</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=25">Prince Malchezaar</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=26">Nightbane</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/mag.png" title="Click to toggle" onclick="toggle(\'mag\')" />
						<div>Single bosses</div>
						<table id="mag">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=0">Doom Lord Kazzak</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=1">Doomwalker</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=29">Magtheridon</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/gruul.png" title="Click to toggle" onclick="toggle(\'gruul\')" />
						<div>Gruul\'s Lair</div>
						<table id="gruul">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=27">High King Maulgar</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=28">Gruul the Dragonkiller</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/eye.png" title="Click to toggle" onclick="toggle(\'eye\')" />
						<div>The Eye</div>
						<table id="eye">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=35">Al\'ar</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=36">Void Reaver</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=37">High Astromancer Solarian</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=38">Kael\'thas Sunstrider</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/bt.png" title="Click to toggle" onclick="toggle(\'bt\')" />
						<div>Black Temple</div>
						<table id="bt">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=2">High Warlord Naj\'entus</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=3">Supremus</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=4">Shade of Akama</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=5">Teron Gorefiend</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=6">Gurtogg Bloodboil</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=7">Reliquary of Souls</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=8">Mother Shahraz</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=9">The Illidari Council</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=10">Illidan Stormrage</a></td></tr>
						</table>
					</div>
				</div>
				<div class="right margin-half">
					<div class="ref-button unselectable">
						<div>Serpentshrine Cavern</div>
						<img src="img/ssc.png" title="Click to toggle" onclick="toggle(\'ssc\')" />
						<table id="ssc">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=11">Hydross the Unstable</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=12">The Lurker Below</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=13">Leotheras the Blind</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=14">Fathom-Lord Karathress</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=15">Morogrim Tidewalker</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=16">Lady Vashj</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Zul\'Aman</div>
						<img src="img/za.png" title="Click to toggle" onclick="toggle(\'za\')" />
						<table id="za">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=30">Nalorakk</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=31">Jan\'alai</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=32">Akil\'zon</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=33">Halazzi</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=50">Hex Lord Malacrass</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=34">Zul\'jin</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Hyjal Summit</div>
						<img src="img/hyjal.png" title="Click to toggle" onclick="toggle(\'hyjal\')" />
						<table id="hyjal">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=39">Rage Winterchill</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=40">Anetheron</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=41">Kaz\'rogal</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=42">Azgalor</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=43">Archimonde</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Sunwell Plateau</div>
						<img src="img/swp.png" title="Click to toggle" onclick="toggle(\'swp\')" />
						<table id="swp">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=44">Kalecgos</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=45">Brutallus</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=46">Felmyst</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=47">Eredar Twins</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=48">M\'uru</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=49">Kil\'Jaeden</a></td></tr>
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