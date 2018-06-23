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
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000001111111111">Karazhan</a></div>
						<table id="kara">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000001">Attumen the Huntsman</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000001">Moroes</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000001">Opera event</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000001">Maiden of Virtue</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000001">The Curator</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000001">Terestian Illhoof</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000001">Shade of Aran</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000001">Netherspite</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000001">Prince Malchezaar</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000001">Nightbane</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/mag.png" title="Click to toggle" onclick="toggle(\'mag\')" />
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0110000000000000000000000000001">Single bosses</a></div>
						<table id="mag">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=01">Doom Lord Kazzak</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=001">Doomwalker</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000001">Magtheridon</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/gruul.png" title="Click to toggle" onclick="toggle(\'gruul\')" />
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000011">Gruul\'s Lair</a></div>
						<table id="gruul">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000001">High King Maulgar</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000001">Gruul the Dragonkiller</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/eye.png" title="Click to toggle" onclick="toggle(\'eye\')" />
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000001111">The Eye</a></div>
						<table id="eye">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000001">Al\'ar</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000001">Void Reaver</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000001">High Astromancer Solarian</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000001">Kael\'thas Sunstrider</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/bt.png" title="Click to toggle" onclick="toggle(\'bt\')" />
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000111111111">Black Temple</a></div>
						<table id="bt">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0001">High Warlord Naj\'entus</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00001">Supremus</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000001">Shade of Akama</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000001">Teron Gorefiend</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000001">Gurtogg Bloodboil</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000001">Reliquary of Souls</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000001">Mother Shahraz</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000001">The Illidari Council</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000001">Illidan Stormrage</a></td></tr>
						</table>
					</div>
					<a href="Table/?server=0&faction=0&type=-1&mode=0&id=000111111111000000000000000000000000000011111111111">
						<div class="ref-button unselectable">
							<img src="img/btswphyjal.png" />
							<div>HJ+SWP+BT</div>
						</div>
					</a>
					<a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000001111111110111">
						<div class="ref-button unselectable">
							<img src="img/karagruulmag.png" />
							<div>GRUUL+KARA+MAG</div>
						</div>
					</a>
				</div>
				<div class="right margin-half">
					<div class="ref-button unselectable">
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000111111">Serpentshrine Cavern</a></div>
						<img src="img/ssc.png" title="Click to toggle" onclick="toggle(\'ssc\')" />
						<table id="ssc">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000001">Hydross the Unstable</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000001">The Lurker Below</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000001">Leotheras the Blind</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000001">Fathom-Lord Karathress</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000001">Morogrim Tidewalker</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000001">Lady Vashj</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000011111">Zul\'Aman</a></div>
						<img src="img/za.png" title="Click to toggle" onclick="toggle(\'za\')" />
						<table id="za">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000001">Nalorakk</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000001">Jan\'alai</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000001">Akil\'zon</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000001">Halazzi</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000000000000001">Hex Lord Malacrass</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000001">Zul\'jin</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000011111">Hyjal Summit</a></div>
						<img src="img/hyjal.png" title="Click to toggle" onclick="toggle(\'hyjal\')" />
						<table id="hyjal">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000001">Rage Winterchill</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000001">Anetheron</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000001">Kaz\'rogal</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000001">Azgalor</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000001">Archimonde</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000111111">Sunwell Plateau</a></div>
						<img src="img/swp.png" title="Click to toggle" onclick="toggle(\'swp\')" />
						<table id="swp">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000000001">Kalecgos</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000001">Brutallus</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000001">Felmyst</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000000000001">Eredar Twins</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000000001">M\'uru</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000000001">Kil\'Jaeden</a></td></tr>
						</table>
					</div>
					<a href="Custom">
						<div class="ref-button margin-half unselectable">
							<div>Custom</div>
							<img src="img/custom.png" />
						</div>
					</a>
					<a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000001111110000000000000000001111">
						<div class="ref-button margin-half unselectable">
							<div>TK+SSC</div>
							<img src="img/ssctk.png" />
						</div>
					</a>
					<a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000111111111011">
						<div class="ref-button margin-half unselectable">
							<div>GRUUL+KARA</div>
							<img src="img/karagruul.png" />
						</div>
					</a>
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