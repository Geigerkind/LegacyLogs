<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<script>function selectAll(p, obj){var g=document.getElementById(obj).checked;p.forEach(function(entry){document.getElementById(entry).checked=g;});}</script>
		<script>function submit(){if (document.getElementById("opt").value == "0"){var id = "0";for(var i = 0; i <= 66; i++){id = id + Number(document.getElementById(i).checked);}document.cookie = id+"=true";window.location.replace("../Table/?server=0&faction=0&type=-1&mode=0&id="+id);}else{window.location.replace("../Table/?server=0&faction=0&type=-1&mode=0&id="+document.getElementById("opt").value);}}</script>
		<div class="container" id="container">
			<div class="centredNormal formular">
				<select id="opt">
					<option value="0">New configuration</option>
		';
		foreach ($_COOKIE as $k => $var){
			if (strlen($k)>60){
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
							<th>Molten Core</th>
							<th>Blackwing Lair</th>
							<th>Single bosses</th>
							<th>Zul\'Gurub</th>
							<th>Ruins of Ahn\'Qiraj</th>
							<th>Temple of Ahn\'Qiraj</th>
							<th>Naxxramas</th>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="mc" onclick="selectAll([0,1,2,3,4,5,6,7,8,9], \'mc\')" />
								<label for="mc">All</label>
							</td>
							<td>
								<input type="checkbox" id="bwl" onclick="selectAll([17,18,19,20,21,22,23,24], \'bwl\')" />
								<label for="bwl">All</label>
							</td>
							<td>
								<input type="checkbox" id="sb" onclick="selectAll([10,11,12,13,14,15,16], \'sb\')" />
								<label for="sb">All</label>
							</td>
							<td>
								<input type="checkbox" id="zg" onclick="selectAll([25,26,27,28,29,30,31,32,33,34,35,36], \'zg\')" />
								<label for="zg">All</label>
							</td>
							<td>
								<input type="checkbox" id="aq20" onclick="selectAll([37,38,39,40,41,42], \'aq20\')" />
								<label for="aq20">All</label>
							</td>
							<td>
								<input type="checkbox" id="aq40" onclick="selectAll([43,44,45,46,47,48,49,50,51], \'aq40\')" />
								<label for="aq40">All</label>
							</td>
							<td>
								<input type="checkbox" id="naxx" onclick="selectAll([52,53,54,55,56,57,58,59,60,61,62,63,64,65,66], \'naxx\')" />
								<label for="naxx">All</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="0" />
								<label for="0">Lucifron</label>
							</td>
							<td>
								<input type="checkbox" id="17" />
								<label for="17">Razorgore</label>
							</td>
							<td>
								<input type="checkbox" id="10" />
								<label for="10">Onyxia</label>
							</td>
							<td>
								<input type="checkbox" id="25" />
								<label for="25">Jeklik</label>
							</td>
							<td>
								<input type="checkbox" id="37" />
								<label for="37">Kurinnaxx</label>
							</td>
							<td>
								<input type="checkbox" id="43" />
								<label for="43">Prophet Skeram</label>
							</td>
							<td>
								<input type="checkbox" id="52" />
								<label for="52">Patchwerk</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="1" />
								<label for="1">Magmadar</label>
							</td>
							<td>
								<input type="checkbox" id="18" />
								<label for="18">Vaelastrasz</label>
							</td>
							<td>
								<input type="checkbox" id="11" />
								<label for="11">Kazzak</label>
							</td>
							<td>
								<input type="checkbox" id="26" />
								<label for="26">Venoxis</label>
							</td>
							<td>
								<input type="checkbox" id="38" />
								<label for="38">Rajaxx</label>
							</td>
							<td>
								<input type="checkbox" id="44" />
								<label for="44">Bug Family</label>
							</td>
							<td>
								<input type="checkbox" id="53" />
								<label for="53">Grobbulus</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="2" />
								<label for="2">Gehennas</label>
							</td>
							<td>
								<input type="checkbox" id="19" />
								<label for="19">Lashlayer</label>
							</td>
							<td>
								<input type="checkbox" id="12" />
								<label for="12">Azuregos</label>
							</td>
							<td>
								<input type="checkbox" id="27" />
								<label for="27">Mar\'li</label>
							</td>
							<td>
								<input type="checkbox" id="39" />
								<label for="39">Moam</label>
							</td>
							<td>
								<input type="checkbox" id="45" />
								<label for="45">Sartura</label>
							</td>
							<td>
								<input type="checkbox" id="54" />
								<label for="54">Gluth</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="3" />
								<label for="3">Garr</label>
							</td>
							<td>
								<input type="checkbox" id="20" />
								<label for="20">Firemaw</label>
							</td>
							<td>
								<input type="checkbox" id="13" />
								<label for="13">Emeriss</label>
							</td>
							<td>
								<input type="checkbox" id="28" />
								<label for="28">Mandokir</label>
							</td>
							<td>
								<input type="checkbox" id="40" />
								<label for="40">Buru</label>
							</td>
							<td>
								<input type="checkbox" id="46" />
								<label for="46">Fankriss</label>
							</td>
							<td>
								<input type="checkbox" id="55" />
								<label for="55">Thaddius</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="4" />
								<label for="4">Baron Geddon</label>
							</td>
							<td>
								<input type="checkbox" id="21" />
								<label for="21">Ebonroc</label>
							</td>
							<td>
								<input type="checkbox" id="14" />
								<label for="14">Ysondre</label>
							</td>
							<td>
								<input type="checkbox" id="29" />
								<label for="29">Gri\'lek</label>
							</td>
							<td>
								<input type="checkbox" id="41" />
								<label for="41">Ayamiss</label>
							</td>
							<td>
								<input type="checkbox" id="47" />
								<label for="47">Viscidus</label>
							</td>
							<td>
								<input type="checkbox" id="56" />
								<label for="56">Anub\'Rekhan</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="5" />
								<label for="5">Shazzrah</label>
							</td>
							<td>
								<input type="checkbox" id="22" />
								<label for="22">Flamegor</label>
							</td>
							<td>
								<input type="checkbox" id="15" />
								<label for="15">Lethon</label>
							</td>
							<td>
								<input type="checkbox" id="30" />
								<label for="30">Hazza\'rah</label>
							</td>
							<td>
								<input type="checkbox" id="42" />
								<label for="42">Ossirian</label>
							</td>
							<td>
								<input type="checkbox" id="48" />
								<label for="48">Huhuran</label>
							</td>
							<td>
								<input type="checkbox" id="57" />
								<label for="57">Faerlina</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="6" />
								<label for="6">Sulfuron Harbinger</label>
							</td>
							<td>
								<input type="checkbox" id="23" />
								<label for="23">Chromaggus</label>
							</td>
							<td>
								<input type="checkbox" id="16" />
								<label for="16">Taerar</label>
							</td>
							<td>
								<input type="checkbox" id="31" />
								<label for="31">Wushoolay</label>
							</td>
							<td> </td>
							<td>
								<input type="checkbox" id="49" />
								<label for="49">Twin Emperors</label>
							</td>
							<td>
								<input type="checkbox" id="58" />
								<label for="58">Maexxna</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="7" />
								<label for="7">Golemagg</label>
							</td>
							<td>
								<input type="checkbox" id="24" />
								<label for="24">Nefarian</label>
							</td>
							<td> </td>
							<td>
								<input type="checkbox" id="32" />
								<label for="32">Gahz\'ranka</label>
							</td>
							<td> </td>
							<td>
								<input type="checkbox" id="50" />
								<label for="50">Ouro</label>
							</td>
							<td>
								<input type="checkbox" id="59" />
								<label for="59">Razuvious</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="8" />
								<label for="8">Majordomo Executus</label>
							</td>
							<td> </td>
							<td> </td>
							<td>
								<input type="checkbox" id="33" />
								<label for="33">Thekal</label>
							</td>
							<td> </td>
							<td>
								<input type="checkbox" id="51" />
								<label for="51">C\'Thun</label>
							</td>
							<td>
								<input type="checkbox" id="60" />
								<label for="60">Gothik</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" id="9" />
								<label for="9">Ragnaros</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="34" />
								<label for="34">Arlokk</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="61" />
								<label for="61">Four Horseman</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="35" />
								<label for="35">Jin\'do</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="62" />
								<label for="62">Noth</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="36" />
								<label for="36">Hakkar</label>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="63" />
								<label for="63">Heigan</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="64" />
								<label for="64">Loatheb</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="65" />
								<label for="65">Sapphiron</label>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="checkbox" id="66" />
								<label for="66">Kel\'Thuzad</label>
							</td>
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