<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<script>function selectAll(p, obj){var g=document.getElementById(obj).checked;p.forEach(function(entry){document.getElementById(entry).checked=g;});}</script>
		<script>function submit(){if (document.getElementById("opt").value == "0"){var id = "0";for(var i = 0; i <= 50; i++){id = id + Number(document.getElementById(i).checked);}document.cookie = id+"=true";window.location.replace("../Table/?server=0&faction=0&type=-1&mode=0&id="+id);}else{window.location.replace("../Table/?server=0&faction=0&type=-1&mode=0&id="+document.getElementById("opt").value);}}</script>
		<div class="container" id="container">
			<div class="centredNormal formular">
				<select id="opt">
					<option value="0">New configuration</option>
		';
		foreach ($_COOKIE as $k => $var){
			if (strlen($k)>40 && strlen($k)<60){
				$content .= '
					<option value="'.$k.'">'.$k.'</option>
				';
			}
		}
		$content .= '
				</select>
				<input type="submit" value="Generate" onclick="submit()" />
			</div>
			<div class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th>Karazhan</th>
							<th>Single Bosses</th>
							<th>Gruul</th>
							<th>Zul\'Aman</th>
							<th>Serpentshrine</th>
							<th>The Eye</th>
							<th>Black Temple</th>
							<th>Hyjal</th>
							<th>Sunwell</th>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="mc" onclick="selectAll([17,18,19,20,21,22,23,24,25,26], \'mc\')" />
								<label for="mc">All</label>
							</td>
							<td>
								<input type="checkbox" id="bwl" onclick="selectAll([0,1,29], \'bwl\')" />
								<label for="bwl">All</label>
							</td>
							<td>
								<input type="checkbox" id="sb" onclick="selectAll([27,28], \'sb\')" />
								<label for="sb">All</label>
							</td>
							<td>
								<input type="checkbox" id="zg" onclick="selectAll([30,31,32,33,34,50], \'zg\')" />
								<label for="zg">All</label>
							</td>
							<td>
								<input type="checkbox" id="aq20" onclick="selectAll([11,12,13,14,15,16], \'aq20\')" />
								<label for="aq20">All</label>
							</td>
							<td>
								<input type="checkbox" id="aq40" onclick="selectAll([35,36,37,38], \'aq40\')" />
								<label for="aq40">All</label>
							</td>
							<td>
								<input type="checkbox" id="naxx" onclick="selectAll([2,3,4,5,6,7,8,9,10], \'naxx\')" />
								<label for="naxx">All</label>
							</td>
							<td>
								<input type="checkbox" id="hyjal" onclick="selectAll([39,40,41,42,43], \'hyjal\')" />
								<label for="hyjal">All</label>
							</td>
							<td>
								<input type="checkbox" id="swp" onclick="selectAll([44,45,46,47,48,49], \'swp\')" />
								<label for="swp">All</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="17" />
								<label for="17">Attumen</label>
							</td>
							<td>
								<input type="checkbox" id="0" />
								<label for="0">Kazzak</label>
							</td>
							<td>
								<input type="checkbox" id="27" />
								<label for="27">Maulgar</label>
							</td>
							<td>
								<input type="checkbox" id="30" />
								<label for="30">Nalorakk</label>
							</td>
							<td>
								<input type="checkbox" id="11" />
								<label for="11">Hydross</label>
							</td>
							<td>
								<input type="checkbox" id="35" />
								<label for="35">Al\'ar</label>
							</td>
							<td>
								<input type="checkbox" id="2" />
								<label for="2">Naj\'entus</label>
							</td>
							<td>
								<input type="checkbox" id="39" />
								<label for="39">Winterchill</label>
							</td>
							<td>
								<input type="checkbox" id="44" />
								<label for="44">Kalecgos</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="18" />
								<label for="18">Moroes</label>
							</td>
							<td>
								<input type="checkbox" id="1" />
								<label for="1">Doomwalker</label>
							</td>
							<td>
								<input type="checkbox" id="28" />
								<label for="28">Gruul</label>
							</td>
							<td>
								<input type="checkbox" id="31" />
								<label for="31">Jan\'alai</label>
							</td>
							<td>
								<input type="checkbox" id="12" />
								<label for="12">Lurker Below</label>
							</td>
							<td>
								<input type="checkbox" id="36" />
								<label for="36">Void Reaver</label>
							</td>
							<td>
								<input type="checkbox" id="3" />
								<label for="3">Supremus</label>
							</td>
							<td>
								<input type="checkbox" id="40" />
								<label for="40">Anetheron</label>
							</td>
							<td>
								<input type="checkbox" id="45" />
								<label for="45">Brutallus</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="19" />
								<label for="19">Opera event</label>
							</td>
							<td>
								<input type="checkbox" id="29" />
								<label for="29">Magtheridon</label>
							</td>
							<td> </td>
							<td>
								<input type="checkbox" id="32" />
								<label for="32">Akil\'zon</label>
							</td>
							<td>
								<input type="checkbox" id="13" />
								<label for="13">Leotheras</label>
							</td>
							<td>
								<input type="checkbox" id="37" />
								<label for="37">Solarian</label>
							</td>
							<td>
								<input type="checkbox" id="4" />
								<label for="4">Shade of Akama</label>
							</td>
							<td>
								<input type="checkbox" id="41" />
								<label for="41">Kaz\'rogal</label>
							</td>
							<td>
								<input type="checkbox" id="46" />
								<label for="46">Felmyst</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="20" />
								<label for="20">Maiden of Virtue</label>
							</td>
							<td> </td>
							<td> </td>
							<td>
								<input type="checkbox" id="33" />
								<label for="33">Halazzi</label>
							</td>
							<td>
								<input type="checkbox" id="14" />
								<label for="14">Karathress</label>
							</td>
							<td>
								<input type="checkbox" id="38" />
								<label for="38">Kael\'thas</label>
							</td>
							<td>
								<input type="checkbox" id="5" />
								<label for="5">Teron Gorefiend</label>
							</td>
							<td>
								<input type="checkbox" id="42" />
								<label for="42">Azgalor</label>
							</td>
							<td>
								<input type="checkbox" id="47" />
								<label for="47">Eredar Twins</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="21" />
								<label for="21">The Curator</label>
							</td>
							<td> </td>
							<td> </td>
							<td>
								<input type="checkbox" id="50" />
								<label for="50">Malacrass</label>
							</td>
							<td>
								<input type="checkbox" id="15" />
								<label for="15">Morogrim</label>
							</td>
							<td> </td>
							<td>
								<input type="checkbox" id="6" />
								<label for="6">Gurtogg</label>
							</td>
							<td>
								<input type="checkbox" id="43" />
								<label for="43">Archimonde</label>
							</td>
							<td>
								<input type="checkbox" id="48" />
								<label for="48">M\'uru</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="22" />
								<label for="22">Terestian Illhoof</label>
							</td>
							<td> </td>
							<td> </td>
							<td>
								<input type="checkbox" id="34" />
								<label for="34">Zul\'jin</label>
							</td>
							<td>
								<input type="checkbox" id="16" />
								<label for="16">Lady Vashj</label>
							</td>
							<td> </td>
							<td>
								<input type="checkbox" id="7" />
								<label for="7">Reliquary</label>
							</td>
							<td> </td>
							<td>
								<input type="checkbox" id="49" />
								<label for="49">Kil\'Jaeden</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="23" />
								<label for="23">Shade of Aran</label>
							</td>
							<td> </td>
							<td> </td>
							<td> </td>
							<td> </td>
							<td> </td>
							<td>
								<input type="checkbox" id="8" />
								<label for="8">Mother Shahraz</label>
							</td>
							<td> </td>
							<td> </td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="24" />
								<label for="24">Netherspite</label>
							</td>
							<td> </td>
							<td> </td>
							<td> </td>
							<td> </td>
							<td> </td>
							<td>
								<input type="checkbox" id="9" />
								<label for="9">Illidari Council</label>
							</td>
							<td> </td>
							<td> </td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="25" />
								<label for="25">Malchezaar</label>
							</td>
							<td> </td>
							<td> </td>
							<td> </td>
							<td> </td>
							<td> </td>
							<td>
								<input type="checkbox" id="10" />
								<label for="10">Illidan</label>
							</td>
							<td> </td>
							<td> </td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="26" />
								<label for="26">Nightbane</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td> </td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td> </td>
							<td> </td>
							<td> </td>
						</tr>
					</table>
				</div>
			</div>
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