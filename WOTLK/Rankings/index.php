<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	
	private function generateLink($id){
		$str = "0";
		for($i=1; $i<$id; $i++){
			$str .= "0";
		}
		return $str."1";
	}
	
	public function content(){
		$content = '<script type="text/javascript">function display(elem) {if (elem.style.display) {return elem.style.display;}if (elem.currentStyle) {return elem.currentStyle.display;}if (document.defaultView.getComputedStyle) {return document.defaultView.getComputedStyle(elem, null).getPropertyValue("display");}return "";}function toggle(id){var elements = ["eye", "tos", "icc", "totc", "trs", "ulduar", "ony", "naxx", "voa", "cus1", "cus2", "cus3", "cus4"];for (var i = 0, len = elements.length; i < len; i++) {if (document.getElementById(elements[i])){if (elements[i] != id){document.getElementById(elements[i]).style.display = "none";}}}if (display(document.getElementById(id)) == "none"){document.getElementById(id).style.display = "block";}else{document.getElementById(id).style.display = "none";}}</script>
		<div class="container" id="container">
			<section class="centredNormal">
				<div class="left">
					<div class="ref-button unselectable">
						<img src="img/ony.png" title="Click to toggle" onclick="toggle(\'ony\')" />
						<div>Onyxia\'s Lair</div>
						<table id="ony">
							<tr>
								<td>Onyxia</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(1).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(1).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/naxx.png" title="Click to toggle" onclick="toggle(\'naxx\')" />
						<div>Naxxramas</div>
						<table id="naxx">
							<tr>
								<td>Whole instance</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00111111111111111&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00111111111111111&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Patchwerk</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(2).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(2).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Grobbulus</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(3).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(3).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Gluth</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(4).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(4).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Thaddius</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(5).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(5).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Anub\'Rekhan</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(6).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(6).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Grand Widow Faerllina</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(7).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(7).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Maexxna</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(8).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(8).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Instructor Razuvious</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(9).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(9).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Gothik the Harvester</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(10).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(10).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>The Four Horsemen</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(11).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(11).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Noth the Plaguebringer</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(12).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(12).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Heigan the Unclean</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(13).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(13).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Loatheb</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(14).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(14).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Sapphiron</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(15).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(15).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Kel\'Thuzad</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(16).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(16).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/eoe.png" title="Click to toggle" onclick="toggle(\'eye\')" />
						<div>Eye of Eternity</div>
						<table id="eye">
							<tr>
								<td>Malygos</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(17).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(17).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/totc.png" title="Click to toggle" onclick="toggle(\'totc\')" />
						<div>Trial of the Crusader</div>
						<table id="totc">
							<tr>
								<td>Whole Instance</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000011111&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000011111&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000011111&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000011111&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Beasts of Northrend</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(39).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(39).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(39).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(39).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Lord Jaraxxus</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(40).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(40).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(40).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(40).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Faction Champions</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(41).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(41).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(41).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(41).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Twin Val\'kyr</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(42).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(42).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(42).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(42).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Anub\'arak</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(43).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(43).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(43).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(43).'&diff=3">25 HC</a></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/trs.png" title="Click to toggle" onclick="toggle(\'trs\')" />
						<div>Ruby Sanctum</div>
						<table id="trs">
							<tr>
								<td>Whole instance</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000000000000001111&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000000000000001111&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000000000000001111&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000000000000000001111&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Saviana Ragefire</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(56).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(56).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(56).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(56).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Baltharus the Warborn</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(57).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(57).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(57).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(57).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>General Zarithrian</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(58).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(58).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(58).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(58).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Halion</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(59).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(59).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(59).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(59).'&diff=3">25 HC</a></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/totculduar.png" title="Click to toggle" onclick="toggle(\'cus3\')" />
						<div>TOTC+ULDUAR</div>
						<table id="cus3">
							<tr>
								<td>Mode</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000111111111111111111&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000111111111111111111&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000111111111111111111&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000111111111111111111&diff=3">25 HC</a></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/ulduarnaxx.png" title="Click to toggle" onclick="toggle(\'cus4\')" />
						<div>NAXX+ULDUAR</div>
						<table id="cus4">
							<tr>
								<td>Mode</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=001111111111111110000000001111111111111&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=001111111111111110000000001111111111111&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="right margin-half">
					<div class="ref-button unselectable">
						<div>Vault of Archavon</div>
						<img src="img/voa.png" title="Click to toggle" onclick="toggle(\'voa\')" />
						<table id="voa">
							<tr>
								<td>Whole instance</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000001111&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000001111&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000001111&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=0000000000000000001111&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Archavon the Stone Watcher</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(18).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(18).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(18).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(18).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Emalon the Storm Watcher</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(19).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(19).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(19).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(19).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Koralon the Flame Watcher</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(20).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(20).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(20).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(20).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Toravon the Ice Watcher</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(21).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(21).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(21).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(21).'&diff=3">25 HC</a></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Obsidian Sanctum</div>
						<img src="img/tos.png" title="Click to toggle" onclick="toggle(\'tos\')" />
						<table id="tos">
							<tr>
								<td>Sartharion</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(25).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(25).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Ulduar</div>
						<img src="img/ulduar.png" title="Click to toggle" onclick="toggle(\'ulduar\')" />
						<table id="ulduar">
							<tr>
								<td>Whole instance</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000001111111111111&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000001111111111111&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Ignis the Furnace Master</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(26).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(26).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Razorscale</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(27).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(27).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>XT-002 Deconstructor</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(28).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(28).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>The Assembly of Iron</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(29).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(29).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Kologarn</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(30).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(30).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Auriaya</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(31).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(31).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Mimiron</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(32).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(32).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Freya</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(33).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(33).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Thorim</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(34).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(34).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Hodir</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(35).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(35).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>General Vezax</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(36).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(36).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Yogg-Saron</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(37).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(37).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Algalon the Observer</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(38).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(38).'&diff=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Icecrown Citadel</div>
						<img src="img/icc.png" title="Click to toggle" onclick="toggle(\'icc\')" />
						<table id="icc">
							<tr>
								<td>Whole instance</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000111111111111&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000111111111111&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000111111111111&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=00000000000000000000000000000000000000000000111111111111&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Lord Marrowgar</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(44).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(44).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(44).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(44).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Lady Deathwhisper</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(45).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(45).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(45).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(45).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Gunship Battle</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(46).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(46).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(46).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(46).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Deathbringer Saurfang</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(47).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(47).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(47).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(47).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Festergut</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(48).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(48).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(48).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(48).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Rotface</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(49).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(49).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(49).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(49).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Professor Putricide</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(50).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(50).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(50).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(50).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Blood Prince Council</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(51).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(51).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(51).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(51).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Blood-Queen Lana\'thel</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(52).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(52).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(52).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(52).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Valithria Dreamwalker</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(53).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(53).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(53).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(53).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>Sindragosa</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(54).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(54).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(54).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(54).'&diff=3">25 HC</a></td>
							</tr>
							<tr>
								<td>The Lich King</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(55).'&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(55).'&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(55).'&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id='.$this->generateLink(55).'&diff=3">25 HC</a></td>
							</tr>
						</table>
					</div>
					<a href="Custom"><div class="ref-button unselectable">
						<div>Custom</div>
						<img src="img/custom.png" />
					</div></a>
					<div class="ref-button unselectable">
						<div>RUBY+ICC+TOTC</div>
						<img src="img/rubyicctotc.png" title="Click to toggle" onclick="toggle(\'cus1\')" />
						<table id="cus1">
							<tr>
								<td>Mode</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000111111111111111111111&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000111111111111111111111&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000111111111111111111111&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000111111111111111111111&diff=3">25 HC</a></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>RUBY+ICC</div>
						<img src="img/rubyicc.png" title="Click to toggle" onclick="toggle(\'cus2\')" />
						<table id="cus2">
							<tr>
								<td>Mode</td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000001111111111111111&diff=0">10 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000001111111111111111&diff=1">25 NHC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000001111111111111111&diff=2">10 HC</a></td>
								<td><a href="Table/?server=0&faction=0&type=-1&mode=0&id=000000000000000000000000000000000000000000001111111111111111&diff=3">25 HC</a></td>
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