<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	
	public function content(){
		$content = '<script type="text/javascript">function display(elem) {if (elem.style.display) {return elem.style.display;}if (elem.currentStyle) {return elem.currentStyle.display;}if (document.defaultView.getComputedStyle) {return document.defaultView.getComputedStyle(elem, null).getPropertyValue("display");}return "";}function toggle(id){var elements = ["mc", "bwl", "ony", "zg", "aq20", "aq40", "naxx"];for (var i = 0, len = elements.length; i < len; i++) {if (document.getElementById(elements[i])){if (elements[i] != id){document.getElementById(elements[i]).style.display = "none";}}}if (display(document.getElementById(id)) == "none"){document.getElementById(id).style.display = "block";}else{document.getElementById(id).style.display = "none";}}</script>
		<div class="container" id="container">
			<section class="centredNormal">
				<div class="left">
					<div class="ref-button unselectable">
						<img src="img/mc.png" title="Click to toggle" onclick="toggle(\'mc\')" />
						<div>Molten Core</div>
						<table id="mc">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=0">Lucifron</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=1">Magmadar</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=2">Gehennas</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=3">Garr</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=4">Baron Geddon</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=5">Shazzrah</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=6">Sulfuron Harbinger</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=7">Golemagg the Incinerator</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=8">Majordomo Executus</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=9">Ragnaros</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/ony.png" title="Click to toggle" onclick="toggle(\'ony\')" />
						<div>Single bosses</div>
						<table id="ony">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=10">Onyxia</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=11">Doomlord Kazzak</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=12">Azuregos</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=13">Emeriss</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=15">Lethon</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=14">Ysondre</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=16">Taerar</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/aq20.png" title="Click to toggle" onclick="toggle(\'aq20\')" />
						<div>Ruins of Ahn\'Qiraj</div>
						<table id="aq20">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=37">Kurinnaxx</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=38">General Rajaxx</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=39">Moam</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=40">Buru the Gorger</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=41">Ayamiss the Hunter</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=42">Ossirian the Unscarred</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/naxx.png" title="Click to toggle" onclick="toggle(\'naxx\')" />
						<div>Naxxramas</div>
						<table id="naxx">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=52">Patchwerk</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=53">Grobbulus</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=54">Gluth</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=55">Thaddius</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=56">Anub\'Rekhan</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=57">Grand Widow Faerlina</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=58">Maexxna</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=59">Instructor Razuvious</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=60">Gothik the Harvester</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=61">The Four Horsemen</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=62">Noth the Plaguebringer</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=63">Heigan the Unclean</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=64">Loatheb</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=65">Sapphiron</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=66">Kel\'Thuzad</a></td></tr>
						</table>
					</div>
				</div>
				<div class="right margin-half">
					<div class="ref-button unselectable">
						<div>Blackwing Lair</div>
						<img src="img/bwl.png" title="Click to toggle" onclick="toggle(\'bwl\')" />
						<table id="bwl">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=17">Razorgore the Untamed</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=18">Vaelastrasz the Corrupt</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=19">Broodlord Lashlayer</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=20">Firemaw</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=21">Ebonroc</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=22">Flamegor</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=23">Chromaggus</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=24">Nefarian</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Zul\'Gurub</div>
						<img src="img/zg.png" title="Click to toggle" onclick="toggle(\'zg\')" />
						<table id="zg">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=25">High Priestess Jeklik</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=26">High Priest Venoxis</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=27">High Priestess Mar\'li</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=28">Bloodlord Mandokir</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=29">Gri\'lek of the Iron Blood</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=30">Hazza\'rah the Dreamwaver</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=31">Wushoolay the Storm Witch</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=32">Gahz\'ranka</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=33">High Priest Thekal</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=34">High Priestess Arlokk</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=35">Jin\'do the Hexxer</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=36">Hakkar</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Temple of Ahn\'Qiraj</div>
						<img src="img/aq40.png" title="Click to toggle" onclick="toggle(\'aq40\')" />
						<table id="aq40">
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=43">The Prophet Skeram</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=44">The Bug Family</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=45">Battleguard Sartura</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=46">Fankriss the Unyielding</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=47">Viscidus</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=48">Princess Huhuran</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=49">The Twin Emperors</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=50">Ouro</a></td></tr>
							<tr><td><a href="Ranking/?server=0&faction=0&mode=0&id=51">C\'Thun</a></td></tr>
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