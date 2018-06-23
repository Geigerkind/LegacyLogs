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
							<tr>
								<td>Onyxia</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=0">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=1">25 NHC</a></td>
								<td></td><td></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/naxx.png" title="Click to toggle" onclick="toggle(\'naxx\')" />
						<div>Naxxramas</div>
						<table id="naxx">
							<tr>
								<td>Patchwerk</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=2">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=17">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Grobbulus</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=3">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=18">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Gluth</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=4">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=19">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Thaddius</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=5">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=20">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Anub\'Rekhan</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=6">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=21">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Grand Widow Faerllina</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=7">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=22">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Maexxna</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=8">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=23">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Instructor Razuvious</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=9">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=24">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Gothik the Harvester</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=10">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=25">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>The Four Horsemen</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=11">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=26">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Noth the Plaguebringer</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=12">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=27">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Heigan the Unclean</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=13">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=28">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Loatheb</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=14">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=29">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Sapphiron</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=15">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=30">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Kel\'Thuzad</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=16">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=31">25 NHC</a></td>
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
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=32">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=33">25 NHC</a></td>
								<td></td><td></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/totc.png" title="Click to toggle" onclick="toggle(\'totc\')" />
						<div>Trial of the Crusader</div>
						<table id="totc">
							<tr>
								<td>Beasts of Northrend</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=76">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=81">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=86">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=91">25 HC</a></td>
							</tr>
							<tr>
								<td>Lord Jaraxxus</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=77">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=82">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=87">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=92">25 HC</a></td>
							</tr>
							<tr>
								<td>Faction Champions</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=78">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=83">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=88">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=93">25 HC</a></td>
							</tr>
							<tr>
								<td>Twin Val\'kyr</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=79">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=84">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=89">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=94">25 HC</a></td>
							</tr>
							<tr>
								<td>Anub\'arak</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=80">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=85">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=90">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=95">25 HC</a></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<img src="img/trs.png" title="Click to toggle" onclick="toggle(\'trs\')" />
						<div>Ruby Sanctum</div>
						<table id="trs">
							<tr>
								<td>Saviana Ragefire</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=144">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=148">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=152">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=156">25 HC</a></td>
							</tr>
							<tr>
								<td>Baltharus the Warborn</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=145">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=149">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=153">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=157">25 HC</a></td>
							</tr>
							<tr>
								<td>General Zarithrian</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=146">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=150">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=154">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=158">25 HC</a></td>
							</tr>
							<tr>
								<td>Halion</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=147">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=151">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=155">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=159">25 HC</a></td>
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
								<td>Archavon the Stone Watcher</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=34">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=38">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Emalon the Storm Watcher</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=35">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=39">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Koralon the Flame Watcher</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=36">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=40">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Toravon the Ice Watcher</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=37">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=41">25 NHC</a></td>
								<td></td><td></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Obsidian Sanctum</div>
						<img src="img/tos.png" title="Click to toggle" onclick="toggle(\'tos\')" />
						<table id="tos">
							<tr>
								<td>Sapphiron</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=45">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=49">25 NHC</a></td>
								<td></td><td></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Ulduar</div>
						<img src="img/ulduar.png" title="Click to toggle" onclick="toggle(\'ulduar\')" />
						<table id="ulduar">
							<tr>
								<td>Ignis the Furnace Master</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=50">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=63">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Razorscale</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=51">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=64">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>XT-002 Deconstructor</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=52">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=65">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>The Assembly of Iron</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=53">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=66">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Kologarn</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=54">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=67">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Auriaya</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=55">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=68">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Mimiron</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=56">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=69">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Freya</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=57">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=70">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Thorim</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=58">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=71">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Hodir</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=59">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=72">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>General Vezax</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=60">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=73">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Yogg-Saron</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=61">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=74">25 NHC</a></td>
								<td></td><td></td>
							</tr>
							<tr>
								<td>Algalon the Observer</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=62">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=75">25 NHC</a></td>
								<td></td><td></td>
							</tr>
						</table>
					</div>
					<div class="ref-button unselectable">
						<div>Icecrown Citadel</div>
						<img src="img/icc.png" title="Click to toggle" onclick="toggle(\'icc\')" />
						<table id="icc">
							<tr>
								<td>Lord Marrowgar</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=96">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=108">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=120">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=132">25 HC</a></td>
							</tr>
							<tr>
								<td>Lady Deathwhisper</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=97">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=109">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=121">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=133">25 HC</a></td>
							</tr>
							<tr>
								<td>Gunship Battle</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=98">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=110">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=122">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=134">25 HC</a></td>
							</tr>
							<tr>
								<td>Deathbringer Saurfang</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=99">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=111">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=123">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=135">25 HC</a></td>
							</tr>
							<tr>
								<td>Festergut</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=100">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=112">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=124">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=136">25 HC</a></td>
							</tr>
							<tr>
								<td>Rotface</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=101">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=113">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=125">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=137">25 HC</a></td>
							</tr>
							<tr>
								<td>Professor Putricide</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=102">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=114">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=126">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=138">25 HC</a></td>
							</tr>
							<tr>
								<td>Blood Prince Council</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=103">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=115">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=127">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=139">25 HC</a></td>
							</tr>
							<tr>
								<td>Blood-Queen Lana\'thel</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=104">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=116">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=128">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=140">25 HC</a></td>
							</tr>
							<tr>
								<td>Valithria Dreamwalker</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=105">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=117">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=129">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=141">25 HC</a></td>
							</tr>
							<tr>
								<td>Sindragosa</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=106">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=118">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=130">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=142">25 HC</a></td>
							</tr>
							<tr>
								<td>The Lich King</td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=107">10 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=119">25 NHC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=131">10 HC</a></td>
								<td><a href="Ranking/?server=0&faction=0&mode=0&id=143">25 HC</a></td>
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