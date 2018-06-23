<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<script>function selectAll(p, obj){var g=document.getElementById(obj).checked;p.forEach(function(entry){document.getElementById(entry).checked=g;});}</script>
		<script>function submit(){if (document.getElementById("opt").value == "0"){var id = "0";for(var i = 0; i <= 59; i++){if(document.getElementById(i)){id = id + Number(document.getElementById(i).checked);}else{id=id+"0"}}document.cookie = id+"=true";window.location.replace("../Table/?server=0&faction=0&type=-1&mode=0&id="+id+"&diff="+document.getElementById("mode").value);}else{window.location.replace("../Table/?server=0&faction=0&type=-1&mode=0&id="+document.getElementById("opt").value+"&diff="+document.getElementById("mode").value);}}</script>
		<div class="container" id="container">
			<div class="centredNormal formular">
				<select id="mode">
					<option value="0">10 NHC</option>
					<option value="1">25 NHC</option>
					<option value="2">10 HC</option>
					<option value="3">25 HC</option>
				</select>
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
							<th>ONY</th>
							<th>NAXX</th>
							<th>EYE</th>
							<th>VOA</th>
							<th>TOS</th>
							<th>ULDUAR</th>
							<th>TOTC</th>
							<th>ICC</th>
							<th>TRS</th>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="mc" onclick="selectAll([1], \'mc\')" />
								<label for="mc">All</label>
							</td>
							<td>
								<input type="checkbox" id="bwl" onclick="selectAll([2,3,4,5,6,7,8,9,10,11,12,13,14,15,16], \'bwl\')" />
								<label for="bwl">All</label>
							</td>
							<td>
								<input type="checkbox" id="sb" onclick="selectAll([17], \'sb\')" />
								<label for="sb">All</label>
							</td>
							<td>
								<input type="checkbox" id="zg" onclick="selectAll([18,19,20,21], \'zg\')" />
								<label for="zg">All</label>
							</td>
							<td>
								<input type="checkbox" id="aq20" onclick="selectAll([25], \'aq20\')" />
								<label for="aq20">All</label>
							</td>
							<td>
								<input type="checkbox" id="aq40" onclick="selectAll([26,27,28,29,30,31,32,33,34,35,36,37,38], \'aq40\')" />
								<label for="aq40">All</label>
							</td>
							<td>
								<input type="checkbox" id="naxx" onclick="selectAll([39,40,41,42,43], \'naxx\')" />
								<label for="naxx">All</label>
							</td>
							<td>
								<input type="checkbox" id="hyjal" onclick="selectAll([44,45,46,47,48,49,50,51,52,53,54,55], \'hyjal\')" />
								<label for="hyjal">All</label>
							</td>
							<td>
								<input type="checkbox" id="swp" onclick="selectAll([56,57,58,59], \'swp\')" />
								<label for="swp">All</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="1" />
								<label for="1">Onyxia</label>
							</td>
							<td>
								<input type="checkbox" id="2" />
								<label for="2">Patchwerk</label>
							</td>
							<td>
								<input type="checkbox" id="17" />
								<label for="17">Malygos</label>
							</td>
							<td>
								<input type="checkbox" id="18" />
								<label for="18">Archavon</label>
							</td>
							<td>
								<input type="checkbox" id="25" />
								<label for="25">Sapphiron</label>
							</td>
							<td>
								<input type="checkbox" id="26" />
								<label for="26">Ignis</label>
							</td>
							<td>
								<input type="checkbox" id="39" />
								<label for="39">Beasts</label>
							</td>
							<td>
								<input type="checkbox" id="44" />
								<label for="44">Marrowgar</label>
							</td>
							<td>
								<input type="checkbox" id="56" />
								<label for="56">Saviana</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="3" />
								<label for="3">Grobbulus</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="19" />
								<label for="19">Emalon</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="27" />
								<label for="27">Razorscale</label>
							</td>
							<td>
								<input type="checkbox" id="40" />
								<label for="40">Jaraxxus</label>
							</td>
							<td>
								<input type="checkbox" id="45" />
								<label for="45">Deathwhisper</label>
							</td>
							<td>
								<input type="checkbox" id="57" />
								<label for="57">Baltharus</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="4" />
								<label for="4">Gluth</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="20" />
								<label for="20">Koralon</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="28" />
								<label for="28">XT-002</label>
							</td>
							<td>
								<input type="checkbox" id="41" />
								<label for="41">Champions</label>
							</td>
							<td>
								<input type="checkbox" id="46" />
								<label for="46">Gunship Battle</label>
							</td>
							<td>
								<input type="checkbox" id="58" />
								<label for="58">Zarithrian</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="5" />
								<label for="5">Thaddius</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="21" />
								<label for="21">Toravon</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="29" />
								<label for="29">Assembly</label>
							</td>
							<td>
								<input type="checkbox" id="42" />
								<label for="42">Twin Val\'kyr</label>
							</td>
							<td>
								<input type="checkbox" id="47" />
								<label for="47">Saurfang</label>
							</td>
							<td>
								<input type="checkbox" id="59" />
								<label for="59">Halion</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="6" />
								<label for="6">Anub\'Rekhan</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="30" />
								<label for="30">Kologarn</label>
							</td>
							<td>
								<input type="checkbox" id="43" />
								<label for="43">Anub\'arak</label>
							</td>
							<td>
								<input type="checkbox" id="48" />
								<label for="48">Festergut</label>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="7" />
								<label for="7">Faerllina</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="31" />
								<label for="31">Auriaya</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="49" />
								<label for="49">Rotface</label>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="8" />
								<label for="8">Maexxna</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="32" />
								<label for="32">Mimiron</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="50" />
								<label for="50">Prof. Putricide</label>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="9" />
								<label for="9">Razuvious</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="33" />
								<label for="33">Freya</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="51" />
								<label for="51">Council</label>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="10" />
								<label for="10">Gothik</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="34" />
								<label for="34">Thorim</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="52" />
								<label for="52">Lana\'thel</label>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="11" />
								<label for="11">Four Horsemen</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="35" />
								<label for="35">Hodir</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="53" />
								<label for="53">Dreamwalker</label>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="12" />
								<label for="12">Noth</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="36" />
								<label for="36">Vezax</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="54" />
								<label for="54">Sindragosa</label>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="13" />
								<label for="13">Heigan</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="37" />
								<label for="37">Yogg-Saron</label>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="55" />
								<label for="55">The Lich King</label>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="14" />
								<label for="14">Loatheb</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="38" />
								<label for="38">Algalon</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="15" />
								<label for="15">Sapphiron</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="16" />
								<label for="16">Kel\'Thuzad</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
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