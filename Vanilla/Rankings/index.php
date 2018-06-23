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
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=01111111111">Molten Core</a></div>
						<table id="mc">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=01">Lucifron</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=001">Magmadar</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0001">Gehennas</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00001">Garr</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000001">Baron Geddon</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000001">Shazzrah</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000001">Sulfuron Harbinger</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000001">Golemagg the Incinerator</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000001">Majordomo Executus</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000001">Ragnaros</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/ony.png" title="Click to toggle" onclick="toggle(\'ony\')" />
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000001111111">Single bosses</a></div>
						<table id="ony">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000001">Onyxia</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000001">Doomlord Kazzak</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000001">Azuregos</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000001">Emeriss</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000001">Lethon</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000001">Ysondre</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000001">Taerar</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/aq20.png" title="Click to toggle" onclick="toggle(\'aq20\')" />
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000111111">Ruins of Ahn\'Qiraj</a></div>
						<table id="aq20">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000001">Kurinnaxx</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000001">General Rajaxx</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000001">Moam</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000001">Buru the Gorger</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000001">Ayamiss the Hunter</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000001">Ossirian the Unscarred</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/naxx.png" title="Click to toggle" onclick="toggle(\'naxx\')" />
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000000000000111111111111111">Naxxramas</a></div>
						<table id="naxx">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000000000001">Patchwerk</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000000000000000001">Grobbulus</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000000000000001">Gluth</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000000000000001">Thaddius</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000000000000000000001">Anub\'Rekhan</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000000000000000001">Grand Widow Faerlina</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000000000000000001">Maexxna</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000000000000000000000001">Instructor Razuvious</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000000000000000000001">Gothik the Harvester</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000000000000000000001">The Four Horsemen</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000000000000000000000000001">Noth the Plaguebringer</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000000000000000000000001">Heigan the Unclean</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000000000000000000000001">Loatheb</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000000000000000000000000000001">Sapphiron</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000000000000000000000000001">Kel\'Thuzad</a></td></tr>
						</table>
					</div>
					<a href="Table/?server=0&faction=0&type=-1&mode=0&id=01111111111000000011111111000000000000000000111111111111111111111111">
						<div class="ref-button unselectable">
							<img src="img/m-naxxaq40bwlmc.png" />
							<div>NAXX+AQ+BWL+MC</div>
						</div>
					</a>
					<a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000011111111000000000000000000111111111111111111111111">
						<div class="ref-button unselectable">
							<img src="img/m-naxxaqbwl.png" />
							<div>NAXX+AQ+BWL</div>
						</div>
					</a>
					<a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000111111111111111111111111">
						<div class="ref-button unselectable">
							<img src="img/m-naxxaq40.png" />
							<div>NAXX+AQ</div>
						</div>
					</a>
				</div>
				<div class="right margin-half">
					<div class="ref-button unselectable">
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000011111111">Blackwing Lair</a></div>
						<img src="img/bwl.png" title="Click to toggle" onclick="toggle(\'bwl\')" />
						<table id="bwl">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000001">Razorgore the Untamed</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000001">Vaelastrasz the Corrupt</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000001">Broodlord Lashlayer</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000001">Firemaw</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000001">Ebonroc</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000001">Flamegor</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000001">Chromaggus</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000001">Nefarian</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000111111111111">Zul\'Gurub</a></div>
						<img src="img/zg.png" title="Click to toggle" onclick="toggle(\'zg\')" />
						<table id="zg">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000001">High Priestess Jeklik</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000001">High Priest Venoxis</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000001">High Priestess Mar\'li</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000001">Bloodlord Mandokir</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000001">Gri\'lek of the Iron Blood</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000001">Hazza\'rah the Dreamwaver</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000001">Wushoolay the Storm Witch</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000001">Gahz\'ranka</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000001">High Priest Thekal</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000001">High Priestess Arlokk</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000001">Jin\'do the Hexxer</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000001">Hakkar</a></td></tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000111111111">Temple of Ahn\'Qiraj</a></div>
						<img src="img/aq40.png" title="Click to toggle" onclick="toggle(\'aq40\')" />
						<table id="aq40">
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000001">The Prophet Skeram</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000000001">The Bug Family</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000001">Battleguard Sartura</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000001">Fankriss the Unyielding</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000000000001">Viscidus</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000000001">Princess Huhuran</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000000001">The Twin Emperors</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000000000000000000000000000000000000001">Ouro</a></td></tr>
							<tr><td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000000000001">C\'Thun</a></td></tr>
						</table>
					</div>
					<a href="Custom">
						<div class="ref-button unselectable">
							<div>Custom</div>
							<img src="img/m-custom.png" />
						</div>
					</a>
					<a href="Table/?server=0&faction=0&type=-1&mode=0&id=01111111111000000011111111000000000000000000111111111">
						<div class="ref-button unselectable">
							<div>AQ+BWL+MC</div>
							<img src="img/m-aq40bwlmc.png" />
						</div>
					</a>
					<a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000011111111000000000000000000111111111">
						<div class="ref-button unselectable">
							<div>AQ+BWL</div>
							<img src="img/m-aqbwl.png" />
						</div>
					</a>
					<a href="Table/?server=0&faction=0&type=-1&mode=0&id=01111111111000000011111111">
						<div class="ref-button unselectable">
							<div>BWL+MC</div>
							<img src="img/m-mcbwl.png" />
						</div>
					</a>
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir){
		$this->siteTitle = " - Rankings";
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__);

?>