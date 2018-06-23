<?php
//set_time_limit(100000);
//ini_set('memory_limit', '-1');
error_reporting(E_ERROR);

require("ParserTBC.php");

class Process{
	private $db = null;
	private $spike = 100000;
	
	private $abilities = array();
	private $user = array();
	private $dmg = array();
	private $dmgtaken = array();
	private $edt = array();
	private $edd = array();
	private $dispels = array();
	private $interrupts = array();
	private $deaths = array();
	private $ehealing = array();
	private $thealing = array();
	private $overhealing = array();
	private $thealingtaken = array();
	private $ehealingtaken = array();
	private $absorbs = array();
	private $auras = array();
	private $cbt = array();
	private $atmt = array();
	private $interruptableSpells = array(
		// BWL
		"Flamestrike" => true,
		"Shadow Bolt" => true,
		"Shadow Bolt Volley" => true,
		"Fireball Volley" => true,
		
		// AQ 40
		"Arcane Explosion" => true,
		"Great Heal" => true, // Bugtrio
		
		// Mag
		"Shadow Volley" => true,
		"Dark Mending" => true,
		
		// TK
		"Fireball" => true,
		
		// German
		"Flammenstoß" => true,
		"Schattenblitz" => true,
		"Schattenblitzsalve" => true,
		"Feuerballsalve" => true,
		"Arkane Explosion" => true,
		"Große Heilung" => true,
	);
	private $instanceBosses = array(
		"Acidmaw" => true,
		"Admiral Ripsnarl" => true,
		"Aeonus" => true,
		"Aerial Command Unit" => true,
		"Agathelos the Raging" => true,
		"Aggem Thorncurse" => true,
		"Ahune" => true,
		"Akil'zon" => true,
		"Aku'mai" => true,
		"Al'Akir" => true,
		"Al'ar" => true,
		"Algalon the Observer" => true,
		"Alizabal" => true,
		"Altairus" => true,
		"Altarius" => true,
		"Alysrazor" => true,
		"Alzzin the Wildshaper" => true,
		"Amanitar" => true,
		"Ambassador Flamelash" => true,
		"Ambassador Hellmaw" => true,
		"Ammunae" => true,
		"Amnennar the Coldbringer" => true,
		"Ancient Stone Keeper" => true,
		"Anetheron" => true,
		"Anger'rel" => true,
		"Anomalus" => true,
		"Anraphet" => true,
		"Anshal" => true,
		"Antu'sul" => true,
		"Anub'arak" => true,
		"Anubisath Defender" => true,
		"Anubisath Guardian" => true,
		"Anub'Rekhan" => true,
		"Anub'shiah" => true,
		"Anzu" => true,
		"Arcane Watchman" => true,
		"Arcanist Doan" => true,
		"Arcanotron" => true,
		"Archaedas" => true,
		"Archavon the Stone Watcher" => true,
		"Archbishop Benedictus" => true,
		"Archimonde" => true,
		"Archivist Galford" => true,
		"Archmage Arugal" => true,
		"Arcurion" => true,
		"Argaloth" => true,
		"Argent Confessor Paletress" => true,
		"Arion" => true,
		"Arugal's Voidwalker" => true,
		"Asaad" => true,
		"Ascendant Council" => true,
		"Ascendant Lord Obsidius" => true,
		"Asim al Akir" => true,
		"Asira Dawnslayer" => true,
		"Assault Bot" => true,
		"Assembly of Iron" => true,
		"Atal'alarion" => true,
		"Atramedes" => true,
		"Attumen the Huntsman" => true,
		"Auriaya" => true,
		"Avalanchion" => true,
		"Avatar of Hakkar" => true,
		"Ayamiss the Hunter" => true,
		"Azgalor" => true,
		"Azshir the Sleepless" => true,
		"Azuregos" => true,
		"Bael'Gar" => true,
		"Baelog" => true,
		"Baleroc" => true,
		"Balnazzar" => true,
		"Baltharus the Warborn" => true,
		"Bannok Grimaxe" => true,
		"Baron Aquanis" => true,
		"Baron Ashbury" => true,
		"Baron Charr" => true,
		"Baroness Anastari" => true,
		"Baron Geddon" => true,
		"Baron Kazum" => true,
		"Baron Rivendare" => true,
		"Baron Silverlaine" => true,
		"Battleguard Sartura" => true,
		"Bazil Thredd" => true,
		"Bazzalan" => true,
		"Beauty" => true,
		"Beth'tilac" => true,
		"Black Guard Swordsmith" => true,
		"Blackheart the Inciter" => true,
		"Blindeye the Seer" => true,
		"Blind Hunter" => true,
		"Blood Council" => true,
		"Blood Guard Porung" => true,
		"Bloodlord Mandokir" => true,
		"Bloodmage Thalnos" => true,
		"Blood Prince Council" => true,
		"Blood Princes" => true,
		"Blood-Queen Lana'thel" => true,
		"Blood Steward of Kirtonos" => true,
		"Boahn" => true,
		"Bomb Bot" => true,
		"Brain of Yogg-Saron" => true,
		"Brainwashed Noble" => true,
		"Broggok" => true,
		"Brokentoe" => true,
		"Bronjahm" => true,
		"Broodlord Lashlayer" => true,
		"Bruegal Ironknuckle" => true,
		"Brutallus" => true,
		"Burning Felguard" => true,
		"Buru the Gorger" => true,
		"Cache of the Firelord" => true,
		"Cache of the Legion" => true,
		"Cannon Master Willey" => true,
		"\"Captain\" Cookie" => true,
		"Captain Greenskin" => true,
		"Captain Kromcrush" => true,
		"Captain Skarloc" => true,
		"Captain Varo'then" => true,
		"Celebras the Cursed" => true,
		"Charlga Razorflank" => true,
		"Chess Event" => true,
		"Chest of The Seven" => true,
		"Chief Ukorz Sandscalp" => true,
		"Chimaeron" => true,
		"Cho'gall" => true,
		"Cho'Rush the Observer" => true,
		"Chromaggus" => true,
		"Chrono Lord Deja" => true,
		"Chrono-Lord Epoch" => true,
		"Claw" => true,
		"Coilfang Elite" => true,
		"Coilfang Strider" => true,
		"Commander Kolurg" => true,
		"Commander Malor" => true,
		"Commander Sarannis" => true,
		"Commander Springvale" => true,
		"Commander Stoutbeard" => true,
		"Commander Ulthok" => true,
		"Conclave of Wind" => true,
		"Constructor & Controller" => true,
		"Cookie" => true,
		"Corborus" => true,
		"Coren Direbrew" => true,
		"Corla" => true,
		"Cosmic Infuser" => true,
		"Crimson Hammersmith" => true,
		"Crowd Pummeler 9-60" => true,
		"Crystal Fang" => true,
		"C'Thun" => true,
		"Cyanigosa" => true,
		"Daakara" => true,
		"Dalliah the Doomsayer" => true,
		"Dalronn the Controller" => true,
		"Dark Coffer" => true,
		"Dark Iron Ambassador" => true,
		"Darkmaster Gandling" => true,
		"Darkweaver Syth" => true,
		"Deathbound Ward" => true,
		"Deathbringer Saurfang" => true,
		"Death Knight Darkreaver" => true,
		"Death Knight Understudy" => true,
		"Deathspeaker High Priest" => true,
		"Death Speaker Jargba" => true,
		"Deathstalker Visceri" => true,
		"Deathsworn Captain" => true,
		"Devastation" => true,
		"Deviate Faerie Dragon" => true,
		"Devourer of Souls" => true,
		"Dextren Ward" => true,
		"Digmaster Shovelphlange" => true,
		"Doctor Theolen Krastinov" => true,
		"Doom Lord Kazzak" => true,
		"Doom'rel" => true,
		"Doomwalker" => true,
		"Dope'rel" => true,
		"Dorothee" => true,
		"Drahga Shadowburner" => true,
		"Drahga Shodowburner" => true,
		"Drakkari Colossus" => true,
		"Drakos the Interrogator" => true,
		"Dreadscale" => true,
		"Dreamscythe" => true,
		"Dust Covered Chest" => true,
		"Dustwraith" => true,
		"Eadric the Pure" => true,
		"Earthcaller Halmgar" => true,
		"Earthrager Ptah" => true,
		"Ebonroc" => true,
		"Echo of Baine" => true,
		"Echo of Jaina" => true,
		"Echo of Sylvanas" => true,
		"Echo of Tyrande" => true,
		"Eck the Ferocious" => true,
		"Edwin VanCleef" => true,
		"Elder Brightleaf" => true,
		"Elder Ironbranch" => true,
		"Elder Nadox" => true,
		"Elder Stonebark" => true,
		"Electrocutioner 6000" => true,
		"Electron" => true,
		"Elementium Monstrosity" => true,
		"Emalon the Storm Watcher" => true,
		"Emeriss" => true,
		"Emperor Dagran Thaurissan" => true,
		"Emperor Vek'lor" => true,
		"Emperor Vek'nilash" => true,
		"Entropius" => true,
		"Eonar's Gift" => true,
		"Epoch Hunter" => true,
		"Erekem" => true,
		"Eressea Dawnsinger" => true,
		"Eric \"The Swift\"" => true,
		"Erudax" => true,
		"Erunak Stonespeaker" => true,
		"Essence of Anger" => true,
		"Essence of Desire" => true,
		"Essence of Suffering" => true,
		"Eviscerator" => true,
		"Exarch Maladaar" => true,
		"Expedition Commander" => true,
		"Eydis Darkbane" => true,
		"Eye of C'Thun" => true,
		"Faction Champions" => true,
		"Fallen Champion" => true,
		"Falric" => true,
		"Falric and Marwyn" => true,
		"Fankriss the Unyielding" => true,
		"Fathom-Lord Karathress" => true,
		"Felmyst" => true,
		"Feludius" => true,
		"Fenrus the Devourer" => true,
		"Feral Defender" => true,
		"Festergut" => true,
		"Feugen" => true,
		"Fineous Darkvire" => true,
		"Firemaw" => true,
		"Fjola Lightbane" => true,
		"Flamegor" => true,
		"Flame Leviathan" => true,
		"Foe Reaper 5000" => true,
		"Foreman Thistlenettle" => true,
		"Forgemaster Garfrost" => true,
		"Forgemaster Throngus" => true,
		"Four Horsemen Chest" => true,
		"Fras Siabi" => true,
		"Freya" => true,
		"Gahz'ranka" => true,
		"Gahz'rilla" => true,
		"Gal'darah" => true,
		"Galgann Firehammer" => true,
		"Garr" => true,
		"Garrosh Hellscream" => true,
		"Gasher" => true,
		"Gatewatcher Gyro-Kill" => true,
		"Gatewatcher Iron-Hand" => true,
		"Gathios the Shatterer" => true,
		"Gehennas" => true,
		"Gelihast" => true,
		"Gelk" => true,
		"General Angerforge" => true,
		"General Bjarngrim" => true,
		"General Drakkisath" => true,
		"General Husam" => true,
		"General Rajaxx" => true,
		"General Umbriss" => true,
		"General Vezax" => true,
		"General Zarithrian" => true,
		"Ghamoo-ra" => true,
		"Ghaz'an" => true,
		"Ghok Bashguud" => true,
		"Gilnid" => true,
		"Gizrul the Slavener" => true,
		"Gloom'rel" => true,
		"Glubtok" => true,
		"Gluth" => true,
		"Glutton" => true,
		"Golemagg the Incinerator" => true,
		"Golem Lord Argelmach" => true,
		"Goraluk Anvilcrack" => true,
		"Gormok the Impaler" => true,
		"Gorosh the Dervish" => true,
		"Gortok Palehoof" => true,
		"Gothik the Harvester" => true,
		"Grand Astromancer Capernian" => true,
		"Grand Champions" => true,
		"Grand Crusader Dathrohan" => true,
		"Grand Magus Telestra" => true,
		"Grandmaster Vorpil" => true,
		"Grandmother" => true,
		"Grand Vizier Ertan" => true,
		"Grand Warlock Alythess" => true,
		"Grand Warlock Nethekurse" => true,
		"Grand Widow Faerlina" => true,
		"Grethok the Controller" => true,
		"Gri'lek" => true,
		"Grimlok" => true,
		"Grizzle" => true,
		"Grobbulus" => true,
		"Grubbis" => true,
		"Gruul the Dragonkiller" => true,
		"Guard Fengus" => true,
		"Guardian of Yogg-Saron" => true,
		"Guard Mol'dar" => true,
		"Guard Slip'kik" => true,
		"Gurtogg Bloodboil" => true,
		"Gyth" => true,
		"Hadronox" => true,
		"Hagara the Stormbinder" => true,
		"Hakkar" => true,
		"Halazzi" => true,
		"Halfus Wyrmbreaker" => true,
		"Halion" => true,
		"Halycon" => true,
		"Hamhock" => true,
		"Harbinger Skyriss" => true,
		"Hate'rel" => true,
		"Hazza'rah" => true,
		"Hazzas" => true,
		"Headless Horseman" => true,
		"Hearthsinger Forresten" => true,
		"Hedrum the Creeper" => true,
		"Heigan the Unclean" => true,
		"Helix Gearbreaker" => true,
		"Hellfire Channeler" => true,
		"Henry Stern" => true,
		"Herald Volazj" => true,
		"Herod" => true,
		"Hex Lord Malacrass" => true,
		"High Astromancer Solarian" => true,
		"High Botanist Freywinn" => true,
		"High Inquisitor Fairbanks" => true,
		"High Inquisitor Whitemane" => true,
		"High Interrogator Gerstahn" => true,
		"High King Maulgar" => true,
		"Highlord Mograine" => true,
		"Highlord Omokk" => true,
		"High Marshal Whirlaxis" => true,
		"High Nethermancer Zerevor" => true,
		"High Overlord Saurfang" => true,
		"High Priestess Arlokk" => true,
		"High Priestess Azil" => true,
		"High Priestess Jeklik" => true,
		"High Priestess Kilnara" => true,
		"High Priestess Mar'li" => true,
		"High Priestess of Thaurissan" => true,
		"High Priest Thekal" => true,
		"High Priest Venoxis" => true,
		"High Prophet Barim" => true,
		"High Warlord Naj'entus" => true,
		"Hodir" => true,
		"Hogger" => true,
		"Houndmaster Grebmar" => true,
		"Houndmaster Loksey" => true,
		"Hukku" => true,
		"Hungarfen" => true,
		"Hurley Blackbreath" => true,
		"Hyakiss the Lurker" => true,
		"Hydromancer Thespia" => true,
		"Hydromancer Velratha" => true,
		"Hydrospawn" => true,
		"Hydross the Unstable" => true,
		"Icecrown Gunship Battle" => true,
		"Icehowl" => true,
		"Ice Sphere" => true,
		"Ichoron" => true,
		"Ick" => true,
		"Ignacious" => true,
		"Ignis the Furnace Master" => true,
		"Illidan Stormrage" => true,
		"Illidari Council" => true,
		"Illyanna Ravenoak" => true,
		"Immol'thar" => true,
		"Infinite Corruptor" => true,
		"Infinity Blades" => true,
		"Ingvar the Plunderer" => true,
		"Instructor Galford" => true,
		"Instructor Malicia" => true,
		"Instructor Razuvious" => true,
		"Interrogator Vishas" => true,
		"Ionar" => true,
		"Ironaya" => true,
		"Ironspine" => true,
		"Isalien" => true,
		"Isiset" => true,
		"Jade" => true,
		"Jammal'an the Prophet" => true,
		"Jan'alai" => true,
		"Jandice Barov" => true,
		"Jedoga Shadowseeker" => true,
		"Jed Runewatcher" => true,
		"Jergosh the Invoker" => true,
		"Jin'do the Godbreaker" => true,
		"Jin'do the Hexxer" => true,
		"Jormungar Behemoth" => true,
		"Jormungars" => true,
		"Julianne" => true,
		"Junk Bot" => true,
		"Kael'thas Sunstrider" => true,
		"Kalecgos" => true,
		"Kam Deepfury" => true,
		"Karsh Steelbender" => true,
		"Kazkaz the Unholy" => true,
		"Kaz'rogal" => true,
		"Keli'dan the Breaker" => true,
		"Kel'Thuzad" => true,
		"Keristrasza" => true,
		"Kiggler the Crazed" => true,
		"Kil'jaeden" => true,
		"Kil'rek" => true,
		"King Dred" => true,
		"King Gordok" => true,
		"King Llane Piece" => true,
		"King Ymiron" => true,
		"Kirtonos the Herald" => true,
		"Knot Thimblejack's Cache" => true,
		"Kolk" => true,
		"Kologarn" => true,
		"Koralon the Flame Watcher" => true,
		"Kormok" => true,
		"Kresh" => true,
		"Krick" => true,
		"Krick and Ick" => true,
		"Krik'thir the Gatewatcher" => true,
		"Krosh Firehand" => true,
		"Krystallus" => true,
		"Kurinnaxx" => true,
		"Lady Anacondra" => true,
		"Lady Blaumeux" => true,
		"Lady Deathwhisper" => true,
		"Lady Illucia Barov" => true,
		"Lady Malande" => true,
		"Lady Naz'jar" => true,
		"Lady Sacrolash" => true,
		"Lady Sarevess" => true,
		"Lady Vashj" => true,
		"Laj" => true,
		"Landslide" => true,
		"Lavanthor" => true,
		"Left Arm" => true,
		"Leotheras the Blind" => true,
		"Lethon" => true,
		"Lethtendris" => true,
		"Leviathan Mk II" => true,
		"Ley-Guardian Eregos" => true,
		"Lieutenant Drake" => true,
		"Lieutenant General Andorov" => true,
		"Loatheb" => true,
		"Lockmaw" => true,
		"Loken" => true,
		"Lord Alexei Barov" => true,
		"Lord Aurius Rivendare" => true,
		"Lord Cobrahn" => true,
		"Lord Godfrey" => true,
		"Lord Hel'nurath" => true,
		"Lord Incendius" => true,
		"Lord Jaraxxus" => true,
		"Lord Kazzak" => true,
		"Lord Kri" => true,
		"Lord Marrowgar" => true,
		"Lord Overheat" => true,
		"Lord Pythas" => true,
		"Lord Rhyolith" => true,
		"Lord Roccor" => true,
		"Lord Sanguinar" => true,
		"Lord Serpentis" => true,
		"Lord Skwol" => true,
		"Lord Valthalak" => true,
		"Lord Victor Nefarius" => true,
		"Lord Vyletongue" => true,
		"Lord Walden" => true,
		"Lorekeeper Polkelt" => true,
		"Lorgus Jett" => true,
		"Loro" => true,
		"Lucifron" => true,
		"Mad Magglish" => true,
		"Madness of Deathwing" => true,
		"Maexxna" => true,
		"Mage-Lord Urom" => true,
		"Magister Kalendris" => true,
		"Magistrate Barthilas" => true,
		"Magmadar" => true,
		"Magmatron" => true,
		"Magmaw" => true,
		"Magmus" => true,
		"Magra" => true,
		"Magtheridon" => true,
		"Maiden of Grief" => true,
		"Maiden of Virtue" => true,
		"Majordomo Executus" => true,
		"Majordomo Staghelm" => true,
		"Malacrass" => true,
		"Maleki the Pallid" => true,
		"Mal'Ganis" => true,
		"Maloriak" => true,
		"Malygos" => true,
		"Mannoroth" => true,
		"Maraudos" => true,
		"Marduk Blackpool" => true,
		"Marisa du'Paige" => true,
		"Marwyn" => true,
		"Master Engineer Telonicus" => true,
		"Maur Grimtotem" => true,
		"Meathook" => true,
		"Mechano-Lord Capacitus" => true,
		"Medivh" => true,
		"Mekgineer Steamrigger" => true,
		"Mekgineer Thermaplugg" => true,
		"Mennu the Betrayer" => true,
		"Meshlok the Harvester" => true,
		"Midnight" => true,
		"Mijan" => true,
		"Mimiron" => true,
		"Mindbender Ghur'sha" => true,
		"Miner Johnson" => true,
		"Mistress of Pain" => true,
		"Moam" => true,
		"Mogor" => true,
		"Mokra the Skullcrusher" => true,
		"Moorabi" => true,
		"Moragg" => true,
		"Morchok" => true,
		"Mordresh Fire Eye" => true,
		"Mor Grayhoof" => true,
		"Moroes" => true,
		"Morogrim Tidewalker" => true,
		"Morphaz" => true,
		"Mother Shahraz" => true,
		"Mother Smolderweb" => true,
		"Mr. Smite" => true,
		"Muradin Bronzebeard" => true,
		"Murkblood Twin" => true,
		"Murkblood Twins" => true,
		"Murmur" => true,
		"Murozond" => true,
		"Murta Grimgut" => true,
		"M'uru" => true,
		"Mushgog" => true,
		"Mutanus the Devourer" => true,
		"Nalorakk" => true,
		"Nazan" => true,
		"Nefarian" => true,
		"Nefarian's End" => true,
		"Nekrum Gutchewer" => true,
		"Nerub'enkan" => true,
		"Nethermancer Sepethrea" => true,
		"Netherspite" => true,
		"Netherstrand Longbow" => true,
		"Nexus-Prince Shaffar" => true,
		"Nezir" => true,
		"Nightbane" => true,
		"Noth the Plaguebringer" => true,
		"Novos the Summoner" => true,
		"Noxxion" => true,
		"Obsidian Sentinel" => true,
		"Occu'thar" => true,
		"Odo the Blindwatcher" => true,
		"Oggleflint" => true,
		"Ogom the Wretched" => true,
		"Ohgan" => true,
		"Ok'thor the Breaker" => true,
		"Olaf" => true,
		"Old Serra'kis" => true,
		"Olm the Summoner" => true,
		"Omnitron Defense System" => true,
		"Omnotron" => true,
		"Omnotron Defense System" => true,
		"Omor the Unscarred" => true,
		"Onyxia" => true,
		"Opera Event" => true,
		"Orgrim's Hammer" => true,
		"Ormorok the Tree-Shaper" => true,
		"Oro Eyegouge" => true,
		"Ossirian the Unscarred" => true,
		"Ouro" => true,
		"Overlord Ramtusk" => true,
		"Overlord Wyrmthalak" => true,
		"Overmaster Pyron" => true,
		"Overseer Tidewrath" => true,
		"Ozruk" => true,
		"Ozumat" => true,
		"Pandemonius" => true,
		"Panzor the Invincible" => true,
		"Patchwerk" => true,
		"Pathaleon the Calculator" => true,
		"Peroth'arn" => true,
		"Phalanx" => true,
		"Phaseshift Bulwark" => true,
		"Pimgib" => true,
		"Plaguemaw the Rotting" => true,
		"Plugger Spazzring" => true,
		"Postmaster Malown" => true,
		"Priestess Delrissa" => true,
		"Prince Keleseth" => true,
		"Prince Malchezaar" => true,
		"Prince Skaldrenox" => true,
		"Princess Huhuran" => true,
		"Princess Moira Bronzebeard" => true,
		"Princess Tempestria" => true,
		"Princess Theradras" => true,
		"Princess Yauj" => true,
		"Prince Taldaram" => true,
		"Prince Tenris Mirkblood" => true,
		"Prince Tortheldrin" => true,
		"Prince Valanar" => true,
		"Professor Putricide" => true,
		"Pure Spawn of Hydross" => true,
		"Pusillin" => true,
		"Pyroguard Emberseer" => true,
		"Pyromancer Loregrain" => true,
		"Quagmirran" => true,
		"Quartermaster Zigris" => true,
		"Queen Azshara" => true,
		"Rage Winterchill" => true,
		"Ragglesnout" => true,
		"Raging Spirit" => true,
		"Ragnaros" => true,
		"Rajh" => true,
		"Ramstein the Gorger" => true,
		"Randolph Moloch" => true,
		"Ras Frostwhisper" => true,
		"Rattlegore" => true,
		"Razorclaw the Butcher" => true,
		"Razorgore the Untamed" => true,
		"Razorlash" => true,
		"Razorscale" => true,
		"Reliquary of Souls" => true,
		"Renataki" => true,
		"Restless Skeleton" => true,
		"Rethilgore" => true,
		"Revelosh" => true,
		"Rhahk'Zor" => true,
		"Ribbly Screwspigot" => true,
		"Right Arm" => true,
		"Ring of Law" => true,
		"Risen Hammersmith" => true,
		"Roar" => true,
		"Rohash" => true,
		"Rokad the Ravager" => true,
		"Rokdar the Sundered Lord" => true,
		"Rokmar the Crackler" => true,
		"Rom'ogg Bonecrusher" => true,
		"Romulo" => true,
		"Romulo & Julianne" => true,
		"Roogug" => true,
		"Rotface" => true,
		"Rotgrip" => true,
		"Runemaster Molgeim" => true,
		"Runok Wildmane" => true,
		"Ruuzlu" => true,
		"Salramm the Fleshcrafter" => true,
		"Sanctum Sentry" => true,
		"Sandarr Dunereaver" => true,
		"Sandfury Executioner" => true,
		"Sapphiron" => true,
		"Sara" => true,
		"Saronite Animus" => true,
		"Sartharion" => true,
		"Sathrovarr the Corruptor" => true,
		"Saviana Ragefire" => true,
		"Scarlet Commander Mograine" => true,
		"Scourgelord Tyrannus" => true,
		"Seeth'rel" => true,
		"Selin Fireheart" => true,
		"Sergeant Bly" => true,
		"Setesh" => true,
		"Shade of Akama" => true,
		"Shade of Aran" => true,
		"Shade of Eranikus" => true,
		"Shadikith the Glider" => true,
		"Shadow Hunter Vosh'gajin" => true,
		"Shadow of Leotheras" => true,
		"Shadowpriest Sezz'ziz" => true,
		"Shadron" => true,
		"Shannox" => true,
		"Shazzrah" => true,
		"Shirrak the Dead Watcher" => true,
		"Siamat" => true,
		"Sindragosa" => true,
		"Sinestra" => true,
		"Sir Zeliek" => true,
		"Sjonnir The Ironshaper" => true,
		"Skadi the Ruthless" => true,
		"Skarr the Unbreakable" => true,
		"Skarvald the Constructor" => true,
		"Skra'gath" => true,
		"Skul" => true,
		"Skum" => true,
		"Slabhide" => true,
		"Slad'ran" => true,
		"Sneed" => true,
		"Sneed's Shredder" => true,
		"Solakar Flamewreath" => true,
		"Solarium Agent" => true,
		"Solarium Priest" => true,
		"Spine of Deathwing" => true,
		"Spirestone Battle Lord" => true,
		"Spirestone Butcher" => true,
		"Spirestone Lord Magus" => true,
		"Staff of Disintegration" => true,
		"Stalagg" => true,
		"Steelbreaker" => true,
		"Stomper Kreeg" => true,
		"Stonespine" => true,
		"Stormcaller Brundir" => true,
		"Strawman" => true,
		"Sulfuron Harbinger" => true,
		"Supremus" => true,
		"Svala Sorrowgrave" => true,
		"Swamplord Musel'ek" => true,
		"Taerar" => true,
		"Tainted Spawn of Hydross" => true,
		"Talon King Ikiss" => true,
		"Taragaman the Hungerer" => true,
		"Targorr the Dread" => true,
		"Tavarok" => true,
		"Techbot" => true,
		"Temple Guardian Anhuur" => true,
		"Temporus" => true,
		"Tendris Warpwood" => true,
		"Tenebron" => true,
		"Terestian Illhoof" => true,
		"Teron Gorefiend" => true,
		"Terrastra" => true,
		"Thaddius" => true,
		"Thaladred the Darkener" => true,
		"Thane Korth'azz" => true,
		"The Beast" => true,
		"The Beasts of Northrend" => true,
		"The Big Bad Wolf" => true,
		"The Black Knight" => true,
		"The Black Stalker" => true,
		"The Blue Brothers" => true,
		"The Bug Family" => true,
		"The Crone" => true,
		"The Curator" => true,
		"The Eredar Twins" => true,
		"The Four Horsemen" => true,
		"The Illidari Council" => true,
		"The Iron Council" => true,
		"Theka the Martyr" => true,
		"The Lich King" => true,
		"The Lost Dwarves" => true,
		"The Lurker Below" => true,
		"The Maker" => true,
		"The Prophet Skeram" => true,
		"The Prophet Tharon'ja" => true,
		"Theralion" => true,
		"The Ravenian" => true,
		"The Razza" => true,
		"The Seven Dwarves" => true,
		"The Skybreaker" => true,
		"The Tribunal of Ages" => true,
		"The Twin Emperors" => true,
		"The Twin Val'kyr" => true,
		"The Unforgiven" => true,
		"The Windreaver" => true,
		"Thorim" => true,
		"Thorngrin the Tender" => true,
		"Tidewalker Lurker" => true,
		"Timmy the Cruel" => true,
		"Tinhead" => true,
		"Tinkerer Gizlock" => true,
		"Tirion Fordring" => true,
		"Tito" => true,
		"Toravon the Ice Watcher" => true,
		"Toxitron" => true,
		"Trigore the Lasher" => true,
		"Trollgore" => true,
		"Tsu'zee" => true,
		"Tuten'kash" => true,
		"Twilight Lord Kelris" => true,
		"Ultraxion" => true,
		"Urok Doomhowl" => true,
		"Vaelastrasz the Corrupt" => true,
		"Valiona" => true,
		"Valiona and Theralion" => true,
		"Valithria Dreamwalker" => true,
		"Val'kyr Shadowguard" => true,
		"Vanessa VanCleef" => true,
		"Varian Wrynn" => true,
		"Varos Cloudstrider" => true,
		"Vazruden" => true,
		"Vazruden the Herald" => true,
		"Vectus" => true,
		"Vem" => true,
		"Veng" => true,
		"Veras Darkshadow" => true,
		"Verdan the Everliving" => true,
		"Verek" => true,
		"Vesperon" => true,
		"Vexallus" => true,
		"Veyzhak the Cannibal" => true,
		"Vile'rel" => true,
		"Viscidus" => true,
		"Viscous Fallout" => true,
		"Void Reaver" => true,
		"Volkhan" => true,
		"VX-001" => true,
		"Warbringer O'mrogg" => true,
		"Warchief Blackhand Piece" => true,
		"Warchief Kargath Bladefist" => true,
		"Warchief Rend Blackhand" => true,
		"Warden Mellichar" => true,
		"Warder Stilgiss" => true,
		"Warlord Kalithresh" => true,
		"Warlord Zon'ozz" => true,
		"Warmaster Blackhorn" => true,
		"War Master Voone" => true,
		"Warmaul Champion" => true,
		"Warp Slicer" => true,
		"Warp Splinter" => true,
		"Watchkeeper Gargolmar" => true,
		"Weaver" => true,
		"Willey Hopebreaker" => true,
		"Witch Doctor Zum'rah" => true,
		"Wolf Master Nandos" => true,
		"Wrath-Scryer Soccothrates" => true,
		"Wushoolay" => true,
		"Xevozz" => true,
		"XT-002 Deconstructor" => true,
		"Yogg-Saron" => true,
		"Yor" => true,
		"Yor'sahj the Unsleeping" => true,
		"Ysondre" => true,
		"Zanzil" => true,
		"Zekkis" => true,
		"Zelemar the Wrathful" => true,
		"Zereketh the Unbound" => true,
		"Zerillis" => true,
		"Zevrim Thornhoof" => true,
		"Zolo" => true,
		"Zul'Farrak Dead Hero" => true,
		"Zul'jin" => true,
		"Zul'Lor" => true,
		"Zul'tore" => true,
		"Zuramat the Obliterator" => true,
	);
	private $userById = array();
	private $abilitiesById = array();
	private $participantKeys = array();
	private $attempts = array();
	private $attemptsWithNpcId = array();
	private $attemptsWithDbId = array();
	
	private $participants = array();
	private $dmgDoneBySource = array();
	private $dmgDoneByAbility = array();
	private $dmgDoneToEnemy = array();
	private $dmgDoneToFriendly = array();
	private $individualDmgDoneByAbility = array();
	private $individualDmgDoneToEnemy = array();
	private $dmgTakenBySource = array();
	private $dmgTakenFromSource = array();
	private $dmgTakenFromAbility = array();
	private $individualDmgTakenByAbility = array();
	private $individualDmgTakenBySource = array();
	private $individualDmgTakenByPlayer = array();
	private $healingBySource = array();
	private $healingByAbility = array();
	private $healingToFriendly = array();
	private $individualHealingToFriendly = array();
	private $individualHealingByAbility = array();
	private $buffs = array();
	private $procs = array();
	private $individualBuffs = array();
	private $individualBuffsByPlayer = array();
	private $debuffs = array();
	private $individualDebuffs = array();
	private $individualDebuffsByPlayer = array();
	private $deathsBySource = array();
	private $individualDeath = array();
	private $missedInterrupts = array();
	private $successfullInterruptsSum = array();
	private $missedInterruptsSum = array();
	private $individualInterrupts = array();
	private $dispelsByAbility = array();
	private $dispelsByFriendly = array();
	private $individualDispelsByAbility = array();
	private $individualDispelsByTarget = array();
	private $recordsDamageDone = array();
	
	private $totalDmgDone = array();
	private $totalDmgTaken = array();
	private $totalEHealingDone = array();
	private $totalEHealingTaken = array();
	private $totalTHealingDone = array();
	private $totalTHealingTaken = array();
	private $totalEDTTable = array();
	private $totalEDDTable = array();
	private $abByEntry = array();
	private $npcByEntry = array();
	
	/*
	* Sorts those tables by their Id instead of the ability name.
	*/
	private function sortById($p){
		$t = array();
		foreach($p as $key => $val){
			$t[$val[0]] = $val;
			$t[$val[0]][0] = $key;
		}
		return $t;
	}
	
	private function sortByAnotherKey($p, $key){
		$t = array();
		foreach($p as $keys => $val){
			$t[$val[$key]] = $val;
			$t[$val[$key]][$key] = $keys;
		}
		return $t;
	}
	
	private function getTotalTables(){ // I have the feeling that some tables just go missing
		foreach($this->dmg as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i" and $va["i"]){
					foreach($va["i"] as $k => $v){
						if (!isset($this->totalDmgDone[$key]))
							$this->totalDmgDone[$key] = array();
						if (isset($this->totalDmgDone[$key][$k]))
							$this->totalDmgDone[$key][$k]+= $v;
						else
							$this->totalDmgDone[$key][$k] = $v;
					}
				}
			}
		}
		foreach($this->ehealing as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i" and $va["i"]){
					foreach($va["i"] as $k => $v){
						if (!isset($this->totalEHealingDone[$key]))
							$this->totalEHealingDone[$key] = array();
						if (isset($this->totalEHealingDone[$key][$k]))
							$this->totalEHealingDone[$key][$k]+= $v;
						else
							$this->totalEHealingDone[$key][$k] = $v;
					}
				}
			}
		}
		foreach($this->ehealingtaken as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i"){
					foreach($va as $q => $s){
						if ($s["i"]){
							foreach($s["i"] as $k => $v){
								if (!isset($this->totalEHealingTaken[$key]))
									$this->totalEHealingTaken[$key] = array();
								if (isset($this->totalEHealingTaken[$key][$k]))
									$this->totalEHealingTaken[$key][$k]+= $v;
								else
									$this->totalEHealingTaken[$key][$k] = $v;
							}
						}
					}
				}
			}
		}
		foreach($this->thealing as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i" and $va["i"]){
					foreach($va["i"] as $k => $v){
						if (!isset($this->totalTHealingDone[$key]))
							$this->totalTHealingDone[$key] = array();
						if (isset($this->totalTHealingDone[$key][$k]))
							$this->totalTHealingDone[$key][$k] += $v;
						else
							$this->totalTHealingDone[$key][$k] = $v;
					}
				}
			}
		}
		foreach($this->thealingtaken as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i"){
					foreach($va as $q => $s){
						if ($s["i"]){
							foreach($s["i"] as $k => $v){
								if (!isset($this->totalTHealingTaken[$key]))
									$this->totalTHealingTaken[$key] = array();
								if (isset($this->totalTHealingTaken[$key][$k]))
									$this->totalTHealingTaken[$key][$k] += $v;
								else
									$this->totalTHealingTaken[$key][$k] = $v;
							}
						}
					}
				}
			}
		}
		foreach($this->dmgtaken as $key => $var){
			foreach($var as $ke => $va){
				if ($ke != "i"){
					foreach($va as $q => $s){
						if ($s["i"]){
							foreach($s["i"] as $k => $v){
								if (!isset($this->totalDmgTaken[$key]))
									$this->totalDmgTaken[$key] = array();
								if (isset($this->totalDmgTaken[$key][$k]))
									$this->totalDmgTaken[$key][$k]+= $v;
								else
									$this->totalDmgTaken[$key][$k] = $v;
							}
						}
					}
				}
			}
		}
		foreach($this->edt as $key => $var){
			if (!isset($this->totalEDTTable[$key]))
				$this->totalEDTTable[$key] = array();
			foreach($var as $ke => $va){
				if (!isset($this->totalEDTTable[$key][$ke]))
					$this->totalEDTTable[$key][$ke] = array();
				foreach($va as $q => $s){
					if ($q != "i" && $s["i"]){
						foreach($s["i"] as $k => $v){
							if (isset($this->totalEDTTable[$key][$ke][$k]))
								$this->totalEDTTable[$key][$ke][$k] += $v;
							else
								$this->totalEDTTable[$key][$ke][$k] = $v;
						}
					}
				}
			}
		}
		foreach($this->edd as $key => $var){
			if (!isset($this->totalEDDTable[$key]))
				$this->totalEDDTable[$key] = array();
			foreach($var as $ke => $va){
				if (!isset($this->totalEDDTable[$key][$ke]))
					$this->totalEDDTable[$key][$ke] = array();
				foreach($va as $q => $s){
					if ($q != "i" && $s["i"]){
						foreach($s["i"] as $k => $v){
							if (isset($this->totalEDDTable[$key][$ke][$k]))
								$this->totalEDDTable[$key][$ke][$k] += $v;
							else
								$this->totalEDDTable[$key][$ke][$k] = $v;
						}
					}
				}
			}
		}
		foreach($this->totalDmgDone as $key => $var){
			ksort($this->totalDmgDone[$key]);
		}
		foreach($this->totalDmgTaken as $key => $var){
			ksort($this->totalDmgTaken[$key]);
		}
		foreach($this->totalEHealingDone as $key => $var){
			ksort($this->totalEHealingDone[$key]);
		}
		foreach($this->totalEHealingTaken as $key => $var){
			ksort($this->totalEHealingTaken[$key]);
		}
		foreach($this->totalTHealingDone as $key => $var){
			ksort($this->totalTHealingDone[$key]);
		}
		foreach($this->totalTHealingTaken as $key => $var){
			ksort($this->totalTHealingTaken[$key]);
		}
		foreach($this->totalEDTTable as $key => $var){
			foreach($var as $ke => $va){
				ksort($this->totalEDTTable[$key][$ke]);
			}
		}
		foreach($this->totalEDDTable as $key => $var){
			foreach($var as $ke => $va){
				ksort($this->totalEDDTable[$key][$ke]);
			}
		}
	}
	
	/*
	* Returns a list of participants that is sorted by role.
	* Example: Array ( [Tanks] => Array ( ) [DPS] => Array ( [0] => 1262 [1] => 1264 ) [Healer] => Array ( [0] => 1335 ) ) 
	* Note: Pets
	*/
	private function findFirstTraceOfCharacter($arr, $time){
		$out = -1;
		foreach($arr as $k => $v){
			if ($k>=$time){
				if ($out==-1 or $out>$k)
					$out = $k;
			}
		}
		return $out;
	}

	private function findLastTraceOfCharacter($arr, $time){
		$out = -1;
		foreach($arr as $k => $v){
			if ($k<=$time){
				if ($out<$k)
					$out = $k;
			}
		}
		return $out;
	}
	
	private function getParticipants($spellsRevTra, $npcs){
		$temp = array();
		foreach ($this->atmt as $k => $v){
			if (sizeOf($v)>0){
				if (!isset($temp[$k])){
					$temp[$k] = array();
				}
				foreach($v as $key => $var){
					if (isset($var[3])){
						if (!isset($temp[$k][1]) or $var[3]>=$temp[$k][1]){
							$temp[$k][1] = $var[3];
						}
					}
					if (isset($var[2])){
						if (!isset($temp[$k][2]) or $var[1]<=$temp[$k][2]){
							$temp[$k][2] = $var[1];
						}
					}
				}
			}
		}
		foreach ($temp as $k => $v){
			if ($v[1] && $v[2]){
				foreach ($this->thealing as $key => $var){
					if ($var["i"] >= ($this->findLastTraceOfCharacter($this->totalTHealingDone[$key], $v[1])-$this->findFirstTraceOfCharacter($this->totalTHealingDone[$key], $v[2]))*500 && !isset($npcs[$this->userById[$key][0]]) && (in_array($this->userById[$key][1], array("paladin", "druid", "priest", "shaman")) or !isset($this->userById[$key][1])) && $var["i"]>1000 && (isset($this->cbt["effective"][0][$this->userById[$key][0]]) && $this->cbt["effective"][0][$this->userById[$key][0]]>5)){
						$isInRaid = false;
						$isTank = false;
						foreach($this->totalTHealingDone[$key] as $pk => $ok){
							if ($v[1]>$pk && $v[2]<$pk){
								$isInRaid = true;
								break 1;
							}
						}
						foreach($this->auras[$key] as $qqq => $uuu){
							if (in_array($spellsRevTra[$this->abilitiesById[$qqq][3]], array("Holy Shield", "Last Stand", "Bone Shield", "Vampiric Blood", "Blade Barrier", "Argent Defender"))){
								$isTank = true;
								break 1;
							}
						}
						if ($isInRaid == true && $isTank == false){
							if (!isset($this->participants[$k]))
								$this->participants[$k] = array(
									"Tanks" => array(),
									"DPS" => array(),
									"Healer" => array()
								);
							if (in_array($key, $this->participants[$k]["Healer"]) == false && in_array($key, $this->participants[$k]["DPS"]) == false && in_array($key, $this->participants[$k]["Tanks"]) == false)
								array_push($this->participants[$k]["Healer"], $key);
							if (!in_array($key, $this->participantKeys))
								array_push($this->participantKeys, $key);
						}
					}
				}
				foreach ($this->dmg as $key => $var){
					if (($var["i"] >= ($this->findLastTraceOfCharacter($this->totalDmgDone[$key], $v[1])-$this->findFirstTraceOfCharacter($this->totalDmgDone[$key], $v[2]))*30 && !isset($npcs[$this->userById[$key][0]]) && $var["i"]>1000 && (isset($this->cbt["effective"][0][$this->userById[$key][0]]) && $this->cbt["effective"][0][$this->userById[$key][0]]>5)) || (isset($this->userById[$key][3]) && $this->userById[$key][3])){
						$isInRaid = false;
						foreach($this->totalDmgDone[$key] as $pk => $ok){
							if ($v[1]>$pk && $v[2]<$pk){
								$isInRaid = true;
								break 1;
							}
						}
						//print $this->userById[$key][1]."<br/>";
						if ($isInRaid == true){
							$isTank = false;
							foreach ($var as $pk => $ok){
								if (isset($this->abilitiesById[$pk][0])){
									if (in_array($spellsRevTra[$this->abilitiesById[$pk][3]], array("Devastate", "Holy Shield", "Avenger's Shield", "Hammer of the Righteous"))){
										$isTank = true;
										break 1;
									}
								}
							}
							// more conditions to determine a tank
							// using auras that were collected
							if (!$isTank){
								foreach($this->auras[$key] as $qqq => $uuu){
									if (in_array($spellsRevTra[$this->abilitiesById[$qqq][3]], array("Holy Shield", "Last Stand", "Bone Shield", "Vampiric Blood", "Blade Barrier", "Argent Defender"))){
										$isTank = true;
										break 1;
									}
								}
							}
							
							if (!isset($this->participants[$k]))
								$this->participants[$k] = array(
									"Tanks" => array(),
									"DPS" => array(),
									"Healer" => array()
								);
							if ($isTank == true && in_array($this->userById[$key][1], array("paladin", "druid", "warrior", "deathknight"))){
								if (in_array($key, $this->participants[$k]["Healer"]) == false && in_array($key, $this->participants[$k]["DPS"]) == false && in_array($key, $this->participants[$k]["Tanks"]) == false)
									array_push($this->participants[$k]["Tanks"], $key);
							}else{
								if (in_array($key, $this->participants[$k]["Healer"]) == false && in_array($key, $this->participants[$k]["DPS"]) == false && in_array($key, $this->participants[$k]["Tanks"]) == false)
									array_push($this->participants[$k]["DPS"], $key);
							}
							if (!in_array($key, $this->participantKeys))
								array_push($this->participantKeys, $key);
							//print $this->userById[$key][1];
						}
					}
				}
			}
		}
	}
	
	private function addValues(&$arr, $val){
		foreach($val as $key => $var){
			if (isset($var)){
				if (isset($arr[$key])){
					$arr[$key] += $var;
				}else{
					$arr[$key] = $var;
				}
			}
		}
	}
	
	/*
	* dmgDoneBySource[attemptid][charid] = Array(1 => value, 2 => active);
	* dmgDoneByAbility[attemptid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 => resist); //potential block
	* dmgDoneToEnemy[attemptid][npcid] = Array(1 => amount, 2 => active);
	* To test => dmgDoneToFriendly[attemptid][charid(the victim)] = amount;
	* To test => individualDmgDoneByAbility[attemptid][charid][abilityid] = Array(1 => casts, 2 => hits, 3 => amount, 4 => average, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 => resist);
	* To test => individualDmgDoneToEnemy[attemptid][npcid][charid] = Array(1 => amount, 2 => active);
	*/
	private $linkedBoss = array(
		// Ony
		"Onyxia" => array(
			"Onyxia",
			"Onyxian Whelp",
			"Onyxian Lair Guard",
		),
		// Naxx
		"Grobbulus" => array(
			"Grobbulus",
			"Fallout Slime",
			"Grobbulus Cloud"
		),
		"Gluth" => array(
			"Gluth",
			"Zombie Chow"
		),
		"Thaddius" => array(
			"Thaddius",
			"Stalagg",
			"Feugen"
		),
		"Anub'Rekhan" => array(
			"Anub'Rekhan",
			"Crypt Guard"
		),
		"Grand Widow Faerlina" => array(
			"Grand Widow Faerlina",
			"Naxxramas Follower"
		),
		"Maexxna" => array(
			"Maexxna",
			"Web Wrap",
			"Maexxna Spiderling"
		),
		"Instructor Razuvious" => array(
			"Instructor Razuvious",
			"Deathknight Understudy"
		),
		"Gothik the Harvester" => array(
			"Gothik the Harvester",
			"Unrelenting Trainee",
			"Unrelenting Deathknight",
			"Unrelenting Rider",
			"Spectral Trainee",
			"Spectral Deathknight",
			"Spectral Rider",
			"Spectral Horse"
		),
		"The Four Horsemen" => array(
			"Baron Rivendare",
			"Thane Korth'azz",
			"Sir Zeliek",
			"Lady Blaumeux"
		),
		"Noth the Plaguebringer" => array(
			"Noth the Plaguebringer",
			"Plagued Warrior",
			"Plagued Champion",
			"Plagued Guardian",
			"Plagued Construct"
		),
		"Loatheb" => array(
			"Loatheb",
			"Spore"
		),
		"Kel'Thuzad" => array(
			"Kel'Thuzad",
			"Soldier of the Frozen Wastes",
			"Unstoppable Abomination",
			"Soul Weaver",
			"Guardian of Icecrown"
		),
		// Eye of Eternity
		"Malygos" => array(
			"Malygos",
			"Power Spark",
			"Nexus Lord",
			"Scion of Eternity",
		),
		// Vault of Archavon
		"Toravon the Ice Watcher" => array(
			"Toravon the Ice Watcher",
			"Frozen Orb",
		),
		"Emalon the Storm Watcher" => array(
			"Emalon the Storm Watcher",
			"Tempest Minion",
		),
		// The Obsidian Sanctum
		"Shadron" => array(
			"Shadron",
			"Twilight Whelp",
			"Acolyte of Shadron",
			"Disciple of Shadron",
			"Sartharion Twilight Whelp",
			"Onyx Sanctum Guardian",
			"Onyx Blaze Mistress",
			"Onyx Brood General",
			"Onyx Flight Captain",
		),
		"Tenebron" => array(
			"Tenebron",
			"Twilight Whelp",
			"Sartharion Twilight Whelp",
			"Onyx Sanctum Guardian",
			"Onyx Blaze Mistress",
			"Onyx Brood General",
			"Onyx Flight Captain",
		),
		"Vesperon" => array(
			"Vesperon",
			"Twilight Whelp",
			"Acolyte of Vesperon",
			"Disciple of Vesperon",
			"Acolyte of Shadron",
			"Disciple of Shadron",
			"Sartharion Twilight Whelp",
			"Onyx Sanctum Guardian",
			"Onyx Blaze Mistress",
			"Onyx Brood General",
			"Onyx Flight Captain",
		),
		"Sartharion" => array(
			"Sartharion",
			"Shadron",
			"Tenebron",
			"Vesperon",
			"Twilight Whelp",
			"Acolyte of Vesperon",
			"Disciple of Vesperon",
			"Sartharion Twilight Whelp",
			"Onyx Sanctum Guardian",
			"Onyx Blaze Mistress",
			"Onyx Brood General",
			"Onyx Flight Captain",
			"Lava Blaze",
			"Environment",
		),
		// Ulduar
		// Flame Leviathan? How to handle it?
		"Ignis the Furnace Master" => array(
			"Ignis the Furnace Master",
			"Forge Construct",
			"Magma Rager",
			"Molten Colossus",
		),
		"Razorscale" => array(
			"Razorscale",
			"Dark Rune Guardian",
			"Dark Rune Sentinel",
			"Dark Rune Watcher",
		),
		"XT-002 Deconstructor" => array(
			"XT-002 Deconstructor",
			"Parts Recovery Technician",
			"XB-488 Disposalbot",
			"XD-175 Compactobot",
			"XR-949 Salvagebot",
			"Life Spark",
			"Heart of the Deconstructor",
			"XS-013 Scrapbot",
			"XE-321 Boombot",
			"XM-024 Pummeler",
		),
		"Assembly of Iron" => array( // GROUP BOSS!
			"Chamber Overseer",
			"Hardened Iron Golem",
			"Iron Mender",
			"Lightning Charged Iron Dwarf",
			"Rune Etched Sentinel",
			"Steelbreaker",
			"Runemaster Molgeim",
			"Stormcaller Brundir",
		),
		"Kologarn" => array( // Kinda a group boss
			"Kologarn",
			"Left arm",
			"Right arm",
			"Environment",
			"Rubble",
		),
		"Auriaya" => array(
			"Auriaya",
			"Storm Tempered Keeper",
			"Sanctum Sentry",
			"Feral Defender",
		),
		"Mimiron" => array( // GROUP BOSS
			"Arachnopod Destroyer",
			"Boomer XP-500",
			"Clockwork Mechanic",
			"Clockwork Sapper",
			"Environment",
			"Mimiron's Head",
			"Mimiron's Inferno Targetting Reticle",
			"Mimiron's Inferno",
			"Mimiron DB Target",
			"Mimiron Focus Points",
			"Mimiron Image",
			
			"Trash",
			"Mimiron",
			"Leviathan MKII",
			"VX-001",
			"Aerial Command Unit",
			"Assault Bot",
			"Bomb Bot",
			"Trash Bot",
			"V-07-TR-0N",
			"Proximity Mine",
		),
		"Freya" => array(
			"Corrupted Servitor",
			"Forest Swarmer",
			"Guardian Lasher",
			"Guardian of Life",
			"Ironroot Lasher",
			"Mangrove Ent",
			"Misguided Nymph",
			"Nature's Blade",
			
			"Freya",
			"Elder Brightleaf",
			"Elder Stonebark",
			"Elder Ironbranch",
			"Storm Lasher",
			"Ancient Water Spirit",
			"Detonating Lasher",
			"Ancient Conservator",
		),
		"Thorim" => array(
			"Dark Rune Ravager",
			"Dark Rune Thunderer",
			"Lightning Orb",
		
			"Thorim",
			"Sif",
			"Jormungar Behemoth",
			"Dark Rune Acolyte",
			"Captured Mercenary Captain",
			"Captured Mercenary Soldiers",
			"Runic Colossus",
			"Ancient Rune Giant",
			"Dark Rune Warbringer",
			"Dark Rune Evoker",
			"Dark Rune Champion",
			"Dark Rune Commoner",
		),
		"Hodir" => array(
			"Champion of Hodir",
			"Winter Jormungar",
			"Winter Revenant",
			"Winter Rumbler",
			
			"Hodir",
			"Environment",
		),
		"General Vezax" => array(
			"General Vezax",
			"Environment",
			"Saronite Vapors",
		),
		"Yogg-Saron" => array(
			"Yogg-Saron",
			"Guardian of Yogg-Saron",
			"Crusher Tentacle",
			"Corruptor Tentacle",
			"Constrictor Tentacle",
			"Laughing Skull",
			"Influence Tentacle",
			"Influence Tentacle Visual",
			"Brain of Yogg-Saron",
			"Immortal Guardian",
			"Marked Immortal Guardian",
			"Environment",
		),
		"Algalon the Observer" => array(
			"Algalon the Observer",
			"Collapsing Star",
			"Living Constellation",
			"Black Hole",
			"Dark Matter",
			"Dark Matter Target",
			"Unleashed Dark Matter",
		),
		// Trial of the Crusader
		"Beasts of Northrend" => array( // GROUP BOSS!
			"Gormok the Impaler",
			"Snobold Vassal",
			"Acidmaw",
			"Dreadscale",
			"Icehowl",
			"Environment",
		),
		"Lord Jaraxxus" => array(
			"Lord Jaraxxus",
			"Nether Portal",
			"Infernal Volcano",
			"Environment",
			"Mistress of Pain",
			"Felflame Infernal",
		),
		"Faction Champions" => array( // GROUP BOSS!
			"Tyrius Duskblade",
			"Gorgrim Shadowcleave",
			"Kavina Grovesong",
			"Birana Stormhoof",
			"Melador Valestrider",
			"Erin Misthoof",
			"Alyssia Moonstalker",
			"Ruj'kah",
			"Noozle Whizzlestick",
			"Ginselle Blightslinger",
			"Velanaa",
			"Liandra Suncaller",
			"Baelnor Lightbearer",
			"Malithas Brightblade",
			"Anthar Forgemender",
			"Caiphus the Stern",
			"Brienna Nightfell",
			"Vivienne Blackwhisper",
			"Irieth Shadowstep",
			"Maz'dinah",
			"Saamul",
			"Thrakgar",
			"Shaabad",
			"Broln Stouthorn",
			"Serissa Grimdabbler",
			"Harkzog",
			"Zhaagrym",
			"Lioness",
			"Shocuul",
			"Narrhok Steelbreaker",
			"Environment",
		),
		"Twin Val'kyr" => array( // GROUP BOSS!
			"Eydis Darkbane",
			"Fjola Lightbane",
			"Environment",
			"Concentrated Light",
			"Concentrated Darkness",
		),
		"Anub'arak" => array(
			"Anub'arak",
			"Frost Sphere",
			"Nerubian Burrower",
			"Swarm Scarab",
		),
		// ICC
		"Lord Marrowgar" => array(
			"Lord Marrowgar",
			"Environment",
			"Bone Spike",
		),
		"Lady Deathwhisper" => array(
			"Lady Deathwhisper",
			"Environment",
			"Cult Adherent",
			"Empowered Adherent",
			"Reanimated Adherent",
			"Cult Fanatic",
			"Deformed Fanatic",
			"Reanimated Fanatic",
			"Vengeful Shade",
			"Reanimated Fanatic",
		),
		"Gunship Battle" => array(
			"Muradin Bronzebeard",
			"High Overlord Saurfang ",
			"Gunship Cannon",
			"Skybreaker Sorcerer",
			"Kor'kron Battle-Mage",
			"Skybreaker Mortar Soldier",
			"Kor'kron Rocketeer",
			"Skybreaker Sergeant",
			"Kor'kron Sergeant",
			"Skybreaker Marine",
			"Kor'kron Reaver",
			"Skybreaker Rifleman",
			"Kor'kron Axethrower",
			"Environment",
		),
		"Deathbringer Saurfang" => array(
			"Deathbringer Saurfang",
			"Blood Beast",
			"Environment",
		),
		"Festergut" => array(
			"Festergut",
			"Environment",
		),
		"Rotface" => array(
			"Rotface",
			"Environment",
			"Little Ooze",
			"Big Ooze",
		),
		"Professor Putricide" => array(
			"Professor Putricide",
			"Gas Cloud",
			"Environment",
			"Growing Ooze Puddle",
			"Volatile Ooze",
			"Mutated Abomination",
			"Choking Gas",
			"Malleable Ooze Stalker",
			"Malformed Ooze",
			"Sticky Ooze",
			"Growing Ooze Puddle Trigger",
		),
		"Blood Prince Council" => array( // GROUP BOSS!
			"Prince Valanar",
			"Shock Vortex",
			"Environment",
			"Prince Taldaram",
			"Flame Orb",
			"Prince Keleseth",
			"Kinetic Bomb",
			"Kinetic Bomb Target",
		),
		"Blood-Queen Lana'thel" => array(
			"Blood-Queen Lana'thel",
			"Environment",
		),
		"Valithria Dreamwalker" => array( // GROUP BOSS / Not really dmg dependent
			"Valithria Dreamwalker",
			"Blazing Skeleton",
			"Blistering Zombie",
			"Risen Archmage",
			"Gluttonous Abomination",
			"Rot Worm",
			"Suppressor",
			"Environment",
		),
		"Sindragosa" => array(
			"Sindragosa",
			"Environment",
			"Ice Tomb",
			
			"Rimfang",
			"Spinestalker",
		),	
		"The Lich King" => array(
			"The Lich King",
			"Environment",
			"Drudge Ghoul",
			"Shambling Horror",
			"Shadow Trap",
			"Raging Spirit",
			"Val'kyr Shadowguard",
			"Vile Spirit",
			"Spirit Warden",
			"Defile",
		),
		// Ruby Sanctum
		"Halion" => array(
			"Halion",
			"Environment",
			"Flame Orb",
			"Shadow Orb",
			"Combustion",
			"Consumption",
			"Living Inferno",
			"Living Ember",
		),
		"Saviana Ragefire" => array(
			"Saviana Ragefire",
			"Environment",
		),
		"Baltharus the Warborn" => array(
			"Baltharus the Warborn",
			"Environment",
		),
		"Baltharus the Warborn" => array(
			"Baltharus the Warborn",
			"Environment",
			"Onyx Flamecaller",
		),
	);
	
	private function returnLinkedBoss($name){
		if (isset($this->linkedBoss[$name]))
			return $this->linkedBoss[$name];
		return array($name);
	}
	/*
	* individualDebuffsByPlayer[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
	* casts[attemptid][charid][tarid][abilityid] = amount
	*/
	
	private function theAlphaGame(&$alpha, &$other){
		if ($alpha>0){
			if (($alpha-$other)<0){
				$other = $alpha;
				$alpha = 0;
			}else{
				$alpha -= $other;
			}
		}else{
			$other = 0;
		}
	}
	
	private function getChancesByCompare($hits, $casts, $miss, $parry, $dodge, $resist){
		$alpha = round($casts)-round($hits);
		$this->theAlphaGame($alpha, $resist);
		$this->theAlphaGame($alpha, $miss);
		$this->theAlphaGame($alpha, $parry);
		$this->theAlphaGame($alpha, $dodge);
		if ($alpha>0){
			$p = 0;
			if ($resist>0)
				$p++;
			if ($miss>0)
				$p++;
			if ($parry>0)
				$p++;
			if ($dodge>0)
				$p++;
			if ($resist>0)
				$resist += floor($alpha/$p);
			if ($miss>0)
				$miss += floor($alpha/$p);
			if ($parry>0)
				$parry += floor($alpha/$p);
			if ($dodge>0)
				$dodge += floor($alpha/$p);
		}
		return array(1=>$miss/$casts,2=>$parry/$casts,3=>$dodge/$casts,4=>$resist/$casts);
	}
	
	private $graphdmgdone = array();
	private $graphindividualdmgdone = array();
	private $graphindividualfriendlyfire = array();
	private $casts = array();
	private function getDmgDone($npcRevTra, $npcTra, $spellRevTra, $npcs){
		foreach($this->participantKeys as $val){
			foreach($this->attempts as $pk => $ok){
				$dmg = 0;
				$active = 0;
				foreach(($r = ($this->instanceBosses[$npcTra[$this->user[$ok[2]][8]]]) ?  array($npcTra[$this->user[$ok[2]][8]]) : $ok[10]) as $nam){
					foreach($this->returnLinkedBoss($nam) as $m){
						if (!isset($this->user[$m]) && isset($this->npcByEntry[$npcRevTra[$m]][8]))
							$m = $this->npcByEntry[$npcRevTra[$m]][8];
						if (isset($this->user[$m])){
							if (isset($this->edt[$this->user[$m][0]][$val]) && $this->totalEDTTable[$this->user[$m][0]][$val]){
								$idmg = 0;
								$iactive = 0;
								$last = $ok[3];
								//$leech = array();
								foreach($this->totalEDTTable[$this->user[$m][0]][$val] as $k => $v){
									if (($k+1)>=$ok[3] && ($k-1)<=$ok[5] && $v<=$this->spike){
										$idmg += $v;
										if (($k-$last)<=3)
											$iactive += ($k-$last);
										$last = $k;
										//$leech[$k] = $v;
									}
								}
								//$this->addValues($this->graphdmgdone[$pk][$this->user[$m][0]], $leech);
								if ($idmg >0){
									if ($iactive>$active)
										$active = $iactive;
									/*$dmg += $idmg;
									if (!isset($this->dmgDoneToEnemy[$pk][$this->user[$m][0]]))
										$this->dmgDoneToEnemy[$pk][$this->user[$m][0]] = array(
											1 => 0,
											2 => 0
										);
									$this->dmgDoneToEnemy[$pk][$this->user[$m][0]][1] += $idmg;
									if (isset($this->dmgDoneToEnemy[$pk][$this->user[$m][0]][2])){
										$this->dmgDoneToEnemy[$pk][$this->user[$m][0]][2] = ($this->dmgDoneToEnemy[$pk][$this->user[$m][0]][2] + $iactive)/2;
									}else{
										$this->dmgDoneToEnemy[$pk][$this->user[$m][0]][2] = $iactive;
									}*/
									$this->individualDmgDoneToEnemy[$pk][$this->user[$m][0]][$val] = Array(
											1 => $idmg,
											2 => $iactive
										);
								}
							}
						}
					}
				}
				/*if ($dmg > 0){
					$this->dmgDoneBySource[$pk][$val] = Array(
						1 => $dmg,
						2 => $active
					);
				}*/
				foreach(($r = ($this->instanceBosses[$npcTra[$this->user[$ok[2]][8]]]) ?  array($npcTra[$this->user[$ok[2]][8]]) : $ok[10]) as $nam){
					foreach($this->returnLinkedBoss($nam) as $m){
						if (!isset($this->user[$m]) && isset($this->npcByEntry[$npcRevTra[$m]][8]))
							$m = $this->npcByEntry[$npcRevTra[$m]][8];
						if (isset($this->user[$m])){
							if (isset($this->edt[$this->user[$m][0]][$val])){
								foreach($this->edt[$this->user[$m][0]][$val] as $key => $var){
									if (isset($var[12])){
										if ($key != "i" && $var[12] > 0){
											$indAbDmg = 0;
											$leech = array();
											foreach($var["i"] as $qq => $pp){
												if (($qq+1)>=$ok[3] && ($qq-1)<=$ok[5] && $pp<=$this->spike){
													$indAbDmg += $pp;
													if (isset($leech[$qq]))
														$leech[$qq] += $pp;
													else
														$leech[$qq] = $pp;
												}
											}
											if ($indAbDmg>0){
												$this->addValues($this->graphindividualdmgdone[$val][$pk][$this->user[$m][0]][$key], $leech);
												if (!isset($this->individualDmgDoneToEnemy[$pk][$this->user[$m][0]][$val][1]))
													$this->individualDmgDoneToEnemy[$pk][$this->user[$m][0]][$val][1] = 0;
												$coeff = $this->individualDmgDoneToEnemy[$pk][$this->user[$m][0]][$val][1]/$this->edt[$this->user[$m][0]][$val]["i"];
												$hits = $var[0]+$var[4]+$var[13]+$var[17];
												$casts = $hits+$var[8]+$var[9]+$var[10]+$var[11];
												$average = round(($var[0]*$var[3]+$var[4]*$var[7]+$var[13]*$var[16]+$var[17]*$var[20])/$hits);
												/*if (!isset($this->dmgDoneByAbility[$pk]))
													$this->dmgDoneByAbility[$pk] = array();
												if (!isset($this->dmgDoneByAbility[$pk][$key]))
													$this->dmgDoneByAbility[$pk][$key] = array(
														1 => 0,
														2 => 0,
														3 => 0,
														4 => 0,
														5 => 0,
														6 => 0,
														7 => 0,
														8 => 0,
														9 => 0
													);
												$this->dmgDoneByAbility[$pk][$key][1] += $indAbDmg;
												$this->dmgDoneByAbility[$pk][$key][2] = ($this->dmgDoneByAbility[$pk][$key][4]*$this->dmgDoneByAbility[$pk][$key][2]+$hits*$average)/($this->dmgDoneByAbility[$pk][$key][4]+$hits);
												$this->dmgDoneByAbility[$pk][$key][3] += $var[22]*$coeff;
												$this->dmgDoneByAbility[$pk][$key][4] += $hits*$coeff;
												$this->dmgDoneByAbility[$pk][$key][5] = ($this->dmgDoneByAbility[$pk][$key][5]+round($var[5]/$casts, 2))/2;
												$this->dmgDoneByAbility[$pk][$key][6] = ($this->dmgDoneByAbility[$pk][$key][6]+round($var[9]/$casts, 2))/2;
												$this->dmgDoneByAbility[$pk][$key][7] = ($this->dmgDoneByAbility[$pk][$key][7]+round($var[10]/$casts, 2))/2;
												$this->dmgDoneByAbility[$pk][$key][8] = ($this->dmgDoneByAbility[$pk][$key][8]+round($var[11]/$casts, 2))/2;
												$this->dmgDoneByAbility[$pk][$key][9] = ($this->dmgDoneByAbility[$pk][$key][9]+round($var[12]/$casts, 2))/2;*/
												
												
												if (!isset($this->individualDmgDoneByAbility[$pk]))
													$this->individualDmgDoneByAbility[$pk] = array();
												if (!isset($this->individualDmgDoneByAbility[$pk][$val]))
													$this->individualDmgDoneByAbility[$pk][$val] = array();
												if (!isset($this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key]))
													$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key] = array(
														1 => 0,
														2 => 0,
														3 => 0,
														4 => 0,
														5 => 0,
														6 => 0,
														7 => 0,
														8 => 0,
														9 => 0
													);
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key][1] += $var[21]*$coeff;
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key][2] += $hits*$coeff;
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key][3] += $indAbDmg;
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key][4] = $average;
												$ch = $this->getChancesByCompare($this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key][2], $this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key][1], $var[8], $var[9], $var[10], $var[11]);
												//if ($ok[2]=="Golemagg der Verbrenner")
													//print round($this->individualDmgDoneByAbility[$pk][$val][$key][1])."/".round($this->individualDmgDoneByAbility[$pk][$val][$key][2])."/".$ch[1]."/".$ch[2]."/".$ch[3]."/".$ch[4]."<br />";
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key][5] = round($var[4]/$casts, 2);
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key][6] = round($ch[1], 2);
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key][7] = round($ch[2], 2);
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key][8] = round($ch[3], 2);
												$this->individualDmgDoneByAbility[$pk][$val][$this->user[$m][0]][$key][9] = round($ch[4], 2);
											}
											
											if (!isset($this->individualDebuffsByPlayer[$pk][$val][$this->user[$m][0]][$key]))
												$this->individualDebuffsByPlayer[$pk][$val][$this->user[$m][0]][$key] = array(
													1 => 0,
													2 => 0
												);
											if (isset($this->abilitiesById[$key][4]) && $this->abilitiesById[$key][4])
												$this->individualDebuffsByPlayer[$pk][$val][$this->user[$m][0]][$key][1] += $var[21]*$coeff;
											if (!isset($this->casts[$pk][$val][$this->user[$m][0]][$key]))
												$this->casts[$pk][$val][$this->user[$m][0]][$key] = 0;
											if (isset($this->casts[$pk][$val][$this->user[$m][0]][$key]))
												$this->casts[$pk][$val][$this->user[$m][0]][$key] += $var[21]*$coeff;
										}
									}
								}
							}
						}
					}
				}
				if (!isset($npcs[$val])){
					foreach($this->edt[$val] as $k => $v){
						if (in_array($k, $this->participantKeys) && !$npcs[$k]){
							//print $this->userById[$k][1]."<br />";
							$dmg = 0;
							foreach($v as $qq => $ss){
								$leech = array();
								foreach($ss["i"] as $key => $vaal){
									if (($key+1)>=$ok[3] && ($key-1)<=$ok[5] && $vaal<=$this->spike){
										$dmg += $vaal;
										if (isset($leech[$key]))
											$leech[$key] += $vaal;
										else
											$leech[$key] = $vaal;
									}
								}
								if (!empty($leech))
									$this->addValues($this->graphindividualfriendlyfire[$val][$pk][$k][$qq], $leech);
							}
							if($dmg > 0){
								if (isset($this->dmgDoneToFriendly[$pk][$k]))
									$this->dmgDoneToFriendly[$pk][$k] += $dmg;
								else
									$this->dmgDoneToFriendly[$pk][$k] = $dmg;
							}
						}
					}
				}
			}	
		}
	}
	
	/*
	* All of them have to be tested
	* Note: DmgTaken is very similiar to dmg done
	*
	* dmgTakenBySource[attemptid][charid] = Array(1 => amount, 2 => active);
	* dmgTakenFromAbility[attemptid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 =>resist, 10 => crush, 11 => block);
	* dmgTakenFromSource[attemptid][npcid/charid] = Array(1 => gettype(char or npc), 2 => amount, 3 => active);
	* individualDmgTakenByAbility[attemptid][charid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => block, 6 => crit, 7 => miss, 8 => parry, 9 => dodge, 10 => resist, 11 => crush);
	* individualDmgTakenBySource[attemptid][npcid][charid] = Array(1 => amount, 2 => active);
	* individualDmgTakenByPlayer[attemptid][charid][culpritid] = amount;
	*/
	private $graphdmgtaken = array();
	private $graphindividualdmgtaken = array();
	private function getDmgTaken($npcRevTra, $npcTra, $npcs){
		foreach($this->attempts as $pk => $ok){
			foreach($this->participantKeys as $val){
				$dmg = 0;
				$active = 0;
				foreach(($r = ($this->instanceBosses[$npcTra[$this->user[$ok[2]][8]]]) ?  array($npcTra[$this->user[$ok[2]][8]]) : $ok[10]) as $nam){
					foreach($this->returnLinkedBoss($nam) as $m){
						if (!isset($this->user[$m]) && isset($this->npcByEntry[$npcRevTra[$m]][8]))
							$m = $this->npcByEntry[$npcRevTra[$m]][8];
						if (isset($this->user[$m])){
							if (isset($this->edd[$this->user[$m][0]])){
								if (isset($this->edd[$this->user[$m][0]][$val]) && $this->totalEDDTable[$this->user[$m][0]][$val]){
									$idmg = 0;
									$iactive = 0;
									$last = $ok[3];
									$leech = array();
									foreach($this->totalEDDTable[$this->user[$m][0]][$val] as $k => $v){
										if ($k>=$ok[3] && ($k-2)<=$ok[5] && $v<=$this->spike){
											$idmg += $v;
											if (($k-$last)<=5)
												$iactive += ($k-$last);
											$last = $k;
											$leech[$k] = $v;
										}
									}
									$this->addValues($this->graphdmgtaken[$pk][$this->user[$m][0]], $leech);
									if ($iactive>$active)
										$active = $iactive;
									$dmg += $idmg;
									if (!isset($this->dmgTakenFromSource[$pk][$this->user[$m][0]]))
										$this->dmgTakenFromSource[$pk][$this->user[$m][0]] = array(
											1 => 0,
											2 => 0,
											3 => 0
										);
									$this->dmgTakenFromSource[$pk][$this->user[$m][0]][1] = -1;
									$this->dmgTakenFromSource[$pk][$this->user[$m][0]][2] += $idmg;
									$this->dmgTakenFromSource[$pk][$this->user[$m][0]][3] += $iactive;
									$this->individualDmgTakenBySource[$pk][$this->user[$m][0]][$val] = Array(
										1 => $idmg,
										2 => $iactive
									);
								}
							}else{
								//print $m."<br />";
							}
						}else{
							//print $m."<br />";
						}
					}
				}
				$this->dmgTakenBySource[$pk][$val] = Array(
					1 => $dmg,
					2 => $active
				);
				foreach(($r = ($this->instanceBosses[$npcTra[$this->user[$ok[2]][8]]]) ?  array($npcTra[$this->user[$ok[2]][8]]) : $ok[10]) as $nam){
					foreach($this->returnLinkedBoss($nam) as $m){
						if (!isset($this->user[$m]) && isset($this->npcByEntry[$npcRevTra[$m]][8]))
							$m = $this->npcByEntry[$npcRevTra[$m]][8];
						if (isset($this->user[$m])){
							if (isset($this->edd[$this->user[$m][0]])){
								if (isset($this->edd[$this->user[$m][0]][$val])){
									foreach($this->edd[$this->user[$m][0]][$val] as $key => $var){
										if ($key != "i"){
											$indAbDmg = 0;
											$leech = array();
											ksort($var["i"]);
											foreach($var["i"] as $qq => $pp){
												if ($qq>=$ok[3] && $qq<=$ok[5] && $pp<=$this->spike){
													$indAbDmg += $pp;
													if (isset($leech[$qq]))
														$leech[$qq] += $pp;
													else
														$leech[$qq] = $pp;
												}
											}
											if ($indAbDmg>0){
												if (!isset($this->graphindividualdmgtaken[$val][$pk][$key][$this->user[$m][0]]))
													$this->graphindividualdmgtaken[$val][$pk][$key][$this->user[$m][0]] = array();
												$this->addValues($this->graphindividualdmgtaken[$val][$pk][$key][$this->user[$m][0]], $leech);
												if ($this->edd[$this->user[$m][0]][$val]["i"] == 0)
													$coeff = 0;
												else
													$coeff = $this->individualDmgTakenBySource[$pk][$this->user[$m][0]][$val][1]/$this->edd[$this->user[$m][0]][$val]["i"];
												$hits = $var[0]+$var[4]+$var[13]+$var[17];
												$casts = $hits+$var[8]+$var[9]+$var[10]+$var[11];
												if ($hits == 0)
													$average = 0;
												else
													$average = round(($var[0]*$var[3]+$var[4]*$var[7]+$var[13]*$var[16]+$var[17]*$var[20])/$hits);
												if (!isset($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]]))
													$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]] = array(
														1 => 0,
														2 => 0,
														3 => 0,
														4 => 0,
														5 => 0,
														6 => 0,
														7 => 0,
														8 => 0,
														9 => 0,
														10 => 0,
														11 => 0
													);
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][1] += $indAbDmg;
												if ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][4]+$hits == $this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][4]+$hits)
													$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][2] = 0;
												else
													$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][2] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][4]*$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][2]+$hits*$average)/($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][4]+$hits);
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][3] += ceil($var[21]*$coeff);
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][4] += ceil($hits*$coeff);
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][5] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][5]+round($var[5]/$casts, 2))/2;
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][6] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][6]+round($var[9]/$casts, 2))/2;
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][7] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][7]+round($var[10]/$casts, 2))/2;
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][8] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][8]+round($var[11]/$casts, 2))/2;
												$this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][9] = ($this->dmgTakenFromAbility[$pk][$key][$this->user[$m][0]][9]+round($var[12]/$casts, 2))/2;
												
												if (!isset($this->individualDmgTakenByAbility[$pk]))
													$this->individualDmgTakenByAbility[$pk] = array();
												if (!isset($this->individualDmgTakenByAbility[$pk][$val]))
													$this->individualDmgTakenByAbility[$pk][$val] = array();
												if (!isset($this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]]))
													$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]] = array(
														1 => 0,
														2 => 0,
														3 => 0,
														4 => 0,
														5 => 0,
														6 => 0,
														7 => 0,
														8 => 0,
														9 => 0,
														10 => 0,
														11 => 0
													);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]][1] += ceil($var[21]*$coeff);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]][2] += ceil($hits*$coeff);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]][3] += $indAbDmg;
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]][4] = $average;
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]][5] = round($var[4]/$casts, 2);
												$ch = $this->getChancesByCompare($this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]][2], $this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]][1], $var[8], $var[9], $var[10], $var[11]);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]][6] = round($ch[1], 2);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]][7] = round($ch[2], 2);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]][8] = round($ch[3], 2);
												$this->individualDmgTakenByAbility[$pk][$val][$key][$this->user[$m][0]][9] = round($ch[4], 2);
											}
										}
									}
								}
							}
						}
					}
				}
				if (!isset($npcs[$val])){
					foreach($this->edt[$val] as $k => $v){
						if (in_array($k, $this->participantKeys) && !$npcs[$k]){
							$dmg = 0;
							foreach($v as $qq => $ss){
								foreach($ss["i"] as $key => $vaal){
									if ($key>=$ok[3] && $key<=$ok[5] && $vaal<=$this->spike)
										$dmg += $vaal;
								}
							}
							if($dmg > 0){
								if (isset($this->individualDmgTakenByPlayer[$pk][$k][$val]))
									$this->individualDmgTakenByPlayer[$pk][$k][$val] += $dmg;
								else
									$this->individualDmgTakenByPlayer[$pk][$k][$val] = $dmg;
							}
						}
					}
				}
			}
		}
	}
	
	/*
	* All of them have to be tested
	*
	* healingBySource[attemptid][charid] = Array(1 => tamount, 2 => eamount, 3 => absorbed, 4 => active);
	* healingByAbility[attemptid][abilityid] = Array(1 => casts, 2 => tamount, 3 => eamount, 4 => average, 5 => crit);
	* healingToFriendly[attemptid][charid] = Array(1 => tamount, 2 => eamount, 3 => absorbed, 4 => active);
	* individualHealingToFriendly[attemptid][charid][tarid] = Array(1 => tamount, 2 => eamount, 3=> absorbs, 4 => active);
	* individualHealingByAbility[attemptid][charid][abilityid] = Array(1 => tamount, 2 => eamount, 3 => taverage, 4 => eaverage, 5 => hits, 6 => crit);
	*/
	private function getAbsorbedDamage($val, $pk){
		foreach($this->absorbs as $k => $v){
			if ($k == $val){
				$amount = 0;
				if (isset($v["i"])){
					foreach($v["i"] as $var){
						if ($this->attempts[$pk][3]<=$var[0] && $this->attempts[$pk][5]>=$var[0]){
							if (isset($this->edd[$var[3]][$val][$var[2]][12])){
								$amount += $this->edd[$var[3]][$val][$var[2]][12];
							}else{
								$amount += 5;
							}
						}
					}
				}
				return $amount;
			}
		}
		return 0;
	}
	
	private function getAbsorbedDamageTaken($val, $pk, $owner){
		if (isset($this->absorbs[$val][$owner]["i"]))
			foreach($this->absorbs[$val][$owner]["i"] as $k => $var){
				$amount = 0;
				if ($this->attempts[$pk][3]<=$var[0] && $this->attempts[$pk][5]>=$var[0]){
					if (!isset($var[3])){
						if (isset($this->edd[$var[1]][$val][$var[2]][12])){
							$amount += $this->edd[$var[1]][$val][$var[2]][12];
						}else{
							$amount += 5;
						}
					}else{
						$amount += $var[3];
					}
				}
				return $amount;
			}
		return 0;
	}
	
	private $graphhealingdone = array();
	private $graphindividualhealingdone = array();
	private $graphindividualhealingreceived = array();
	private $individualHealingByAbilityTaken = array();
	private function getHealing($npcs, $spellRevTra, $spellsRaw){
		foreach($this->participantKeys as $val){
			foreach($this->attempts as $pk => $ok){
				if (isset($this->ehealing[$val]) && isset($this->thealing[$val])){
					$theal = 0;
					$active = 0;
					$last = $ok[3];
					foreach($this->totalTHealingDone[$val] as $k => $v){
						if ($k>=$ok[3] && $k<=$ok[5] && $v<=$this->spike){
							$theal += $v;
							if (($k-$last)<=5)
								$active += ($k-$last);
							$last = $k;
						}
					}
					$tcoeff = $theal/$this->thealing[$val]["i"];
					$eheal = 0;
					$leech = array();
					foreach($this->totalEHealingDone[$val] as $k => $v){
						if ($k>=$ok[3] && $k<=$ok[5] && $v<=$this->spike){
							$eheal += $v;
							$leech[$k] = $v;
						}
					}
					$this->addValues($this->graphhealingdone[$pk], $leech);
					$ecoeff = $eheal/$this->ehealing[$val]["i"];
					$this->healingBySource[$pk][$val] = Array(
						1 => $theal,
						2 => $eheal,
						3 => $this->getAbsorbedDamage($val, $pk),
						4 => $active
					);
				}
				if (isset($this->absorbs[$val])){
					foreach($this->absorbs[$val] as $k => $v){ // owner
						foreach($v["i"] as $key => $var){ // Ability
							$amount = 0; $leech = array(); $casts = 0;
							foreach($var as $qk => $qv){ // Cause Ability
								foreach($qv as $qkk => $qvv){
									if ($qkk>=$ok[3] && $qkk<=$ok[5]){
										$amount += $qvv;
										$casts += 1;
										if (isset($leech[$qkk]))
											$leech[$qkk] += $qvv;
										else
											$leech[$qkk] = $qvv;
									}
								}
							}
							if ($amount>0){
								$this->addValues($this->graphindividualhealingreceived[$val][$pk][$key][$k], $leech);
								if (!isset($this->individualHealingByAbility[$pk][$k][$val][$key]))
									$this->individualHealingByAbility[$pk][$k][$val][$key] = array(
										1 => 0,
										2 => 0,
										3 => 0,
										4 => 0,
										5 => 0,
										6 => 0,
									);
								$this->individualHealingByAbility[$pk][$k][$val][$key][1]+=$amount;
								$this->individualHealingByAbility[$pk][$k][$val][$key][2]+=$amount;
								$this->individualHealingByAbility[$pk][$k][$val][$key][5]+=$casts;
								$this->individualHealingByAbility[$pk][$k][$val][$key][6]=0;
								if (!isset($this->individualHealingToFriendly[$pk][$k][$val]))
									$this->individualHealingToFriendly[$pk][$val][$k] = array(
										1 => 0,
										2 => 0,
										3 => 0,
										4 => 0,
										5 => 0,
										6 => 0
									);
								$this->individualHealingToFriendly[$pk][$val][$k][4] += $amount;
							}
						}
					}
				}
				if (isset($this->thealingtaken[$val]) && isset($this->ehealingtaken[$val]) && !isset($npcs[$val])){
					/*if (!isset($this->healingToFriendly[$pk][$val]))
						$this->healingToFriendly[$pk][$val] = Array(
							1 => 0,
							2 => 0,
							3 => 0,
							4 => 0
						);*/
					foreach($this->thealingtaken[$val] as $key => $var){
						if ($key != "i" && !isset($npcs[$key])){
							$tindDmg = 0;
							$active = 0;
							$numAbDone = 0;
							foreach($var as $ke => $va){
								ksort($va["i"]);
								$abTakenNum = 0; $tindAbNum = 0;
								$last = $ok[3];
								foreach($va["i"] as $k => $v){
									if ($k>=$ok[3] && $k<=$ok[5] && $v<=$this->spike){
										$tindDmg += $v;
										$tindAbNum += $v;
										$numAbDone++;
										$abTakenNum++;
										if (($k-$last)<=5)
											$active += ($k-$last);
										$last = $k;
									}
								}
								if ($tindAbNum>0){
									if (!isset($this->individualHealingByAbilityTaken[$pk][$val][$ke]))
										$this->individualHealingByAbilityTaken[$pk][$val][$ke] = Array(
											1 => 0,
											2 => 0
										);
									$this->individualHealingByAbilityTaken[$pk][$val][$ke][1] += $abTakenNum;
									$this->individualHealingByAbilityTaken[$pk][$val][$ke][2] += $tindAbNum;
									
									if (!isset($this->individualHealingByAbility[$pk][$val][$key]))
										$this->individualHealingByAbility[$pk][$val][$key] = array(
											1 => 0,
											2 => 0,
											3 => 0,
											4 => 0,
											5 => 0,
											6 => 0,
										);
									$tcoeff = $tindAbNum/$this->thealingtaken[$val]["i"];
									$this->individualHealingByAbility[$pk][$key][$val][$ke][1] = $tindAbNum;
									$this->individualHealingByAbility[$pk][$key][$val][$ke][3] = ($va[1]*$va[3]+$va[2]*$va[4])/($va[1]+$va[2]);
									$this->individualHealingByAbility[$pk][$key][$val][$ke][5] = ceil(($va[1]+$va[2])*$tcoeff);
									$this->individualHealingByAbility[$pk][$key][$val][$ke][6] = round($va[2]/($va[1]+$va[2]), 2);
									
									if (!isset($this->casts[$pk][$key][$val][$ke]))
										$this->casts[$pk][$key][$val][$ke] = 0;
									if (isset($this->casts[$pk][$key][$val][$ke]))
										$this->casts[$pk][$key][$val][$ke] += ceil(($va[1]+$va[2])*$tcoeff);;
								}
							}
							if ($tindDmg>0){
								if (isset($this->individualHealingToFriendly[$pk][$val][$key][1]))
									$this->individualHealingToFriendly[$pk][$val][$key][1] += $tindDmg;
								else
									$this->individualHealingToFriendly[$pk][$val][$key][1] = $tindDmg;
								if (isset($this->individualHealingToFriendly[$pk][$val][$key][3]))
									$this->individualHealingToFriendly[$pk][$val][$key][3] += $numAbDone;
								else
									$this->individualHealingToFriendly[$pk][$val][$key][3] = $numAbDone;
								//$this->individualHealingToFriendly[$pk][$val][$key][4] = $this->getAbsorbedDamageTaken($key, $pk, $val);
								if (isset($this->individualHealingToFriendly[$pk][$val][$key][5]))
									$this->individualHealingToFriendly[$pk][$val][$key][5] += $active;
								else
									$this->individualHealingToFriendly[$pk][$val][$key][5] = $active;
								/*$this->healingToFriendly[$pk][$val][1] += $tindDmg;
								$this->healingToFriendly[$pk][$val][3] = $this->getAbsorbedDamageTaken($val, $pk);
								$this->healingToFriendly[$pk][$val][4] += $active;*/
							}
						}
					}
					foreach($this->ehealingtaken[$val] as $key => $var){
						if ($key != "i" && !isset($npcs[$key])){
							$eindDmg = 0;
							foreach($var as $ke => $va){
								$leech = array();
								$eabnum = 0;
								foreach($va["i"] as $k => $v){
									if ($k>=$ok[3] && $k<=$ok[5] && $v<=$this->spike){
										$eindDmg += $v;
										$eabnum += $v;
										if (isset($leech[$k]))
											$leech[$k] += $v;
										else
											$leech[$k] = $v;
									}
								}
								$this->addValues($this->graphindividualhealingreceived[$val][$pk][$ke][$key], $leech);
								if ($eabnum > 0){
									$this->individualHealingByAbility[$pk][$key][$val][$ke][2] = $eabnum;
									$this->individualHealingByAbility[$pk][$key][$val][$ke][4] = ($va[1]*$va[3]+$va[2]*$va[4])/($va[1]+$va[2]);
								}
							}
							if ($eindDmg>0){
								if (isset($this->individualHealingToFriendly[$pk][$val][$key][2]))
									$this->individualHealingToFriendly[$pk][$val][$key][2] += $eindDmg;
								else
									$this->individualHealingToFriendly[$pk][$val][$key][2] = $eindDmg;
								
								$this->healingToFriendly[$pk][$val][2] += $eindDmg;
							}
						}
					}
				}
			}
		}
	}
	
	/*
	* All of them have to be tested.
	*
	* buffs[attemptid][abilityid] = Array(1 => amount, 2 => active);
	* procs[attemptid][abilityid] = Array(1 => amount, 2 => chance);
	* individualBuffs[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
	* individualProcs[attemptid][charid][abilityid] = Array(1 => amount, 2 => chance);
	* individualBuffsByPlayer[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
	* debuffs[attemptid][abilityid] = Array(1 => amount, 2 => active);
	* individualDebuffs[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
	* individualDebuffsByPlayer[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
	*/
	
	private $nonProcProcs = Array(
		"Holy Strength" => true,
		"Felstriker" => true,
		"Sanctuary" => true,
		"Fury of Forgewright" => true,
		"Primal Blessing" => true,
		"Spinal Reaper" => true,
		"Netherwind Focus" => true,
		"Parry" => true,
		"Untamed Fury" => true,
		"Aura of the Blue Dragon" => true,
		"Invigorate" => true,
		"Head Rush" => true,
		"Enigma Resist Bonus" => true,
		"Enigma Blizzard Bonus" => true,
		"Not There" => true,
		"Epiphany" => true,
		"Inspiration" => true,
		"Blessed Recovery" => true,
		"Focused Casting" => true,
		"Clearcasting" => true,
		"Nature's Grace" => true,
		"Battlegear of Eternal Justice" => true,
		"Redoubt" => true,
		"Vengeance" => true,
		"Stormcaller's Wrath" => true,
		"Ancestral Healing" => true,
		"Vampirism" => true,
		"Nightfall" => true,
		"Cheat Death" => true,
		"Flurry" => true,
		"Enrage" => true,
		"Quick Shots" => true,
		"Mana Restore" => true,
		
		"Lightning Speed" => true,
		"Blade Turning" => true,
	);
	private $nonProcProcsButWorthTracking = Array(
		"Holy Strength" => true,
		"Felstriker" => true,
		"Primal Blessing" => true,
		"Spinal Reaper" => true,
		"Untamed Fury" => true,
		"Vengeance" => true,
		"Flurry" => true,
		"Enrage" => true,
		"Quick Shots" => true,
		
		"Lightning Speed" => true,
		"Blade Turning" => true,
	);
	private $specialSnowflakes = Array(
		"Relentless Strikes Effect" => Array(
			"Eviscerate" => true,
			"Slice and Dice" => true,
			"Kidney Shot" => true,
			"Rupture" => true,
		),
		"Ruthlessness" => Array(
			"Eviscerate" => true,
			"Slice and Dice" => true,
			"Kidney Shot" => true,
			"Rupture" => true,
		),
		"Netherwind Focus" => Array(
			"Arcane Missiles" => true,
			"Fireball" => true,
			"Frostbolt" => true,
		),
		"Head Rush" => Array(
			"Sinister Strike" => true,
			"Backstab" => true,
			"Hemorrhage" => true,
		),
		"Enigma Resist Bonus" => Array(
			"Arcane Missiles" => true,
			"Fireball" => true,
			"Frostbolt" => true,
		),
		"Enigma Blizzard Bonus" => Array(
			"Blizzard" => true,
		),
		"Not There" => Array(
			"Arcane Missiles" => true,
			"Fireball" => true,
			"Frostbolt" => true,
		),
		"Clearcasting" => Array(
			"Arcane Missiles" => true,
			"Fireball" => true,
			"Frostbolt" => true,
			"Lightning Bolt" => true,
			"Chain Lightning" => true,
			"Earth Shock" => true,
			"Flame Shock" => true,
			"Frost Shock" => true,
		),
		"Battlegear of Eternal Justice" => Array(
			"Judgement" => true,
		),
		"Stormcaller's Wrath" => Array(
			"Lightning Bolt" => true,
			"Chain Lightning" => true,
			"Earth Shock" => true,
			"Flame Shock" => true,
			"Frost Shock" => true,
		),
		"Vampirism" => Array(
			"Shadow Bolt" => true,
		),
		"Nightfall" => Array(
			"Corruption" => true,
			"Drain Life" => true,
		),
		"Quick Shots" => Array(
			"Auto Shot" => true,
		)
	);
	private $specialSnowflakesDmgTaken = Array(
		1 => Array( // All
			"Cheat Death" => true,
			"Redoubt" => true,
		), // Just crits
		2 => Array(
			"Enrage" => true,
			"Blessed Recovery" => true,
			"Focused Casting" => true,
		),
		3 => Array( // Only on parry
			"Blade Turning" => true,
		),
	);
	private $specialSnowflakesHealTaken = Array(
		"Inspiration" => Array(
			"Flash Heal" => true,
			"Greater Heal" => true,
			"Heal" => true,
			"Prayer of Healing" => true,
			"Lesser Heal" => true,
			"Desperate Prayer" => true,
		),
		"Ancestral Spirit" => Array(
			"Chain Heal" => true,
			"Healing Wave" => true,
			"Lesser Healing Wave" => true,
		)
	);
	private $specialSnowflakesHealDone = array(
		"Aura of the Blue Dragon" => Array(
			"Flash Heal" => true,
			"Greater Heal" => true,
			"Heal" => true,
			"Prayer of Healing" => true,
			"Lesser Heal" => true,
			"Desperate Prayer" => true,
			"Flash of Light" => true,
			"Holy Light" => true,
			"Holy Shock" => true,
			"Regrowth" => true,
			"Swiftmend" => true,
			"Healing Touch" => true,
			"Chain Heal" => true,
			"Healing Wave" => true,
			"Lesser Healing Wave" => true,
		),
		"Nature's Grace" => Array(
			"Regrowth" => true,
			"Swiftmend" => true,
			"Healing Touch" => true,
			//"Starfire" => true,
			//"Wrath" => true,
			//"Moonfire" => true,
		),
		"Epiphany" => Array(
			"Flash Heal" => true,
			"Greater Heal" => true,
			"Heal" => true,
			"Prayer of Healing" => true,
			"Lesser Heal" => true,
			"Desperate Prayer" => true,
		),
		"Mana Restore" => array(
			"Flash Heal" => true,
			"Greater Heal" => true,
			"Heal" => true,
			"Prayer of Healing" => true,
			"Lesser Heal" => true,
			"Desperate Prayer" => true,
			"Flash of Light" => true,
			"Holy Light" => true,
			"Holy Shock" => true,
			"Regrowth" => true,
			"Swiftmend" => true,
			"Healing Touch" => true,
			"Chain Heal" => true,
			"Healing Wave" => true,
			"Lesser Healing Wave" => true,
		),
	);
	// prob have to update those
	// also have to ass POM etc.
	// all kinds of new spells
	// Its not called Attack anymore...
	private $mab = Array("Attack" => true, "Sinister Strike" => true, "Eviscerate" => true, "Execute" => true, "Overpower" => true, "Bloodthirst" => true, "Mortal Strike" => true, "Heroic Strike" => true, "Cleave" => true, "Whirlwind" => true, "Backstab" => true, "Shield Slam" => true, "Revenge" => true, "Sunder Armor" => true, "Hamstring" => true, "Mangle" => true, "Crusader Strike" => true, "Avenger's Shield" => true, "Mutilate" => true, "Riposte" => true, "Devastate" => true); // I have probably forgotten a few
	
	private function getNumMeeleHitsByAbility($ab, $spellTra, $pk, $ok, $spellsRaw, $spellRevTra, $spells){
		$pl = array();
		$num = 0;
		$abname = $spellsRaw[$this->abilitiesById[$ab][3]];
		foreach($this->participantKeys as $val){
			if (isset($this->auras[$val])){
				if (isset($this->auras[$val][$ab])){
					if (!in_array($val, $pl))
						array_push($pl, $val);
				}
			}
		}
		if ($this->specialSnowflakes[$abname]){
			foreach($pl as $val){
				if (isset($this->individualDmgDoneByAbility[$pk][$val])){
					foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							if (isset($this->specialSnowflakes[$abname][$spellsRaw[($qrs = (intval($this->abilitiesById[$k][3])>10) ? $this->abilitiesById[$k][3] : $spells[$k])]])){
								$num += $v[2];
							}
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesDmgTaken[1][$abname]){
			foreach($pl as $val){
				if (isset($this->individualDmgTakenByAbility[$pk][$val])){
					foreach($this->individualDmgTakenByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							if (isset($this->mab[$spellsRaw[($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])]])){
								$num += $v[4];
							}
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesDmgTaken[2][$abname]){
			foreach($pl as $val){
				if (isset($this->individualDmgTakenByAbility[$pk][$val])){
					foreach($this->individualDmgTakenByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							$num += $v[4]*$v[6];
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesHealTaken[$abname]){
			foreach($pl as $val){
				if (isset($this->individualHealingByAbilityTaken[$pk][$val])){
					foreach($this->individualHealingByAbilityTaken[$pk][$val] as $k => $v){ // attemptid
						if (isset($this->specialSnowflakesHealTaken[$abname][$spellsRaw[($qrs = (intval($this->abilitiesById[$k][3])>10) ? $this->abilitiesById[$k][3] : $spells[$k])]])){
							$num += $v[1];
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesHealDone[$abname]){
			foreach($pl as $val){
				if (isset($this->individualHealingByAbility[$pk][$val])){
					foreach($this->individualHealingByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							if (isset($this->specialSnowflakesHealDone[$abname][$spellsRaw[($qrs = (intval($this->abilitiesById[$k][3])>10) ? $this->abilitiesById[$k][3] : $spells[$k])]])){
								$num += $v[5];
							}
						}
					}
				}
			}
		}elseif ($abname == "Vengeance" or $abname == "Flurry"){
			foreach($pl as $val){
				if (isset($this->individualDmgDoneByAbility[$pk][$val])){
					foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							$num += $v[2]*$v[5];
						}
					}
				}
			}
		}else{
			foreach($pl as $val){
				if (isset($this->individualDmgDoneByAbility[$pk][$val])){
					foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
						foreach($va as $k => $v){
							if (isset($this->mab[$spellsRaw[($qrs = (intval($this->abilitiesById[$k][3])>10) ? $this->abilitiesById[$k][3] : $spells[$k])]])){
								$num += $v[2];
							}
						}
					}
				}
			}
		}
		if ($abname == "Relentless Strikes Effect"){
			foreach($pl as $val){
				foreach($this->specialSnowflake[$abname] as $k => $v){
					if (isset($this->auras[$val][$this->abilities[$spellRevTra[$k]][0]][0])){
						foreach($this->auras[$val][$this->abilities[$spellRevTra[$k]][0]][0] as $key => $var){
							if ($var>=$ok[3] && $var<=$ok[5])
								$num++;
						}
					}
				}
			}
		}
		if ($num < 1)
			return 1;
		return ceil($num);
	}
	
	private function getNumMeeleHitsByAbilityByPlayer($ab, $spellTra, $pk, $ok, $val, $spellsRaw, $spellRevTra, $spells){
		$num = 0;
		$abname = $spellsRaw[$this->abilitiesById[$ab][3]];
		if ($this->specialSnowflakes[$abname]){
			//print "1: ".$abname."<br />";
			if (isset($this->individualDmgDoneByAbility[$pk][$val])){
				foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
					foreach($va as $k => $v){
						if (isset($this->specialSnowflakes[$abname][$spellsRaw[($qrs = (intval($this->abilitiesById[$k][3])>10) ? $this->abilitiesById[$k][3] : $spells[$k])]])){
							$num += $v[2];
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesDmgTaken[1][$abname]){
			//print "2: ".$abname."<br />";
			if (isset($this->individualDmgTakenByAbility[$pk][$val])){
				foreach($this->individualDmgTakenByAbility[$pk][$val] as $ke => $va){ // attemptid
					foreach($va as $k => $v){
						if (isset($this->mab[$spellsRaw[($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])]])){
							$num += $v[4];
						}
					}
				}
			}
		}elseif ($this->specialSnowflakesDmgTaken[2][$abname]){
			//print "3: ".$abname."<br />";
			if (isset($this->individualDmgTakenByAbility[$pk][$val])){
				foreach($this->individualDmgTakenByAbility[$pk][$val] as $ke => $va){ // attemptid
					foreach($va as $k => $v){
						$num += $v[4]*$v[6];
					}
				}
			}
		}elseif ($this->specialSnowflakesDmgTaken[3][$abname]){
			//print "3: ".$abname."<br />";
			if (isset($this->individualDmgTakenByAbility[$pk][$val])){
				foreach($this->individualDmgTakenByAbility[$pk][$val] as $ke => $va){ // attemptid
					foreach($va as $k => $v){
						$num += $v[8];
					}
				}
			}
		}elseif ($this->specialSnowflakesHealTaken[$abname]){
			//print "4: ".$abname."<br />";
			if (isset($this->individualHealingByAbilityTaken[$pk][$val])){
				foreach($this->individualHealingByAbilityTaken[$pk][$val] as $k => $v){ // attemptid
					if (isset($this->specialSnowflakesHealTaken[$abname][$spellsRaw[($qrs = (intval($this->abilitiesById[$k][3])>10) ? $this->abilitiesById[$k][3] : $spells[$k])]])){
						$num += $v[1];
					}
				}
			}
		}elseif ($this->specialSnowflakesHealDone[$abname]){
			if (isset($this->individualHealingByAbility[$pk][$val])){
				foreach($this->individualHealingByAbility[$pk][$val] as $ke => $va){ // attemptid
					foreach($va as $k => $v){
						if (isset($this->specialSnowflakesHealDone[$abname][$spellsRaw[($qrs = (intval($this->abilitiesById[$k][3])>10) ? $this->abilitiesById[$k][3] : $spells[$k])]])){
							$num += $v[5];
						}
					}
				}
			}
		}elseif ($abname == "Vengeance" or $abname == "Flurry"){
			//print "5: ".$abname."<br />";
			if (isset($this->individualDmgDoneByAbility[$pk][$val])){
				foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
					foreach($va as $k => $v){
						$num += $v[2]*$v[5];
					}
				}
			}
		}else{
			//print "6: ".$abname."<br />";
			if (isset($this->individualDmgDoneByAbility[$pk][$val])){
				foreach($this->individualDmgDoneByAbility[$pk][$val] as $ke => $va){ // attemptid
					//print $this->abilitiesById[$k][1]."<br />";+
					foreach($va as $k => $v){
						if (isset($this->mab[$spellsRaw[($qrs = (intval($this->abilitiesById[$k][3])>10) ? $this->abilitiesById[$k][3] : $spells[$k])]])){
							$num += $v[2];
							//print $v[2]."<br />";
						}
					}
				}
			}
		}
		if ($abname == "Relentless Strikes Effect"){
			foreach($this->specialSnowflake[$abname] as $k => $v){
				if (isset($this->auras[$val][$this->abilities[$spellRevTra[$k]][0]][0])){
					foreach($this->auras[$val][$this->abilities[$spellRevTra[$k]][0]][0] as $key => $var){
						if ($var>=$ok[3] && $var<=$ok[5])
							$num++;
					}
				}
			}
		}
		if ($num<1)
			return 1;
		return ceil($num);
	}
	
	private function getInstanceId($cbt){
		$last = 0; $id = "";
		foreach($this->instanceStart as $k => $v){
			if ($last == 0 || ($cbt>$v and ($cbt-$v)<($cbt-$last))){
				$id = $k;
				$last = $v;
			}
		}
		return $id;
	}
	
	private $newBuffs = array();
	private $newDebuffs = array();
	private function getAuras($spellTra, $spellRevTra, $spellsRaw, $spells){
		foreach($this->participantKeys as $val){
			if (isset($this->auras[$val])){
				// New buffsystem => More Raw Data
				foreach($this->auras[$val] as $k => $v){
					if (isset($this->abilitiesById[$k][4]) && $this->abilitiesById[$k][4]){
						if (!isset($this->newDebuffs[$val][$k]))
							$this->newDebuffs[$val][$k] = array();
						foreach($v[0] as $key => $var){
							$id = $this->getInstanceId($var);
							if (!isset($this->newDebuffs[$val][$k][$id]))
								$this->newDebuffs[$val][$k][$id] = array(
									1 => "",
									2 => "",
								);
							$this->newDebuffs[$val][$k][$id][1] .= ($r = ($this->newDebuffs[$val][$k][$id][1] != "") ? "," : "").round($var, 1);
						}
						foreach($v[1] as $key => $var){
							$id = $this->getInstanceId($var);
							if (!isset($this->newDebuffs[$val][$k][$id]))
								$this->newDebuffs[$val][$k][$id] = array(
									1 => "",
									2 => "",
								);
							$this->newDebuffs[$val][$k][$id][2] .= ($r = ($this->newDebuffs[$val][$k][$id][2] != "") ? "," : "").round($var, 1);
						}
					}else{
						if ((isset($v[3]) && $v[3] === true) or (isset($this->nonProcProcs[$spellsRaw[($qrs = (intval($this->abilitiesById[$k][3])>10) ? $this->abilitiesById[$k][3] : $spells[$k])]]) && !isset($this->nonProcProcsButWorthTracking[$spellsRaw[($qrs = (intval($this->abilitiesById[$k][3])>10) ? $this->abilitiesById[$k][3] : $spells[$k])]]))){
							
						}else{
							if (!isset($this->newBuffs[$val][$k]))
								$this->newBuffs[$val][$k] = array();
							foreach($v[0] as $key => $var){
								$id = $this->getInstanceId($var);
								if (!isset($this->newBuffs[$val][$k][$id]))
									$this->newBuffs[$val][$k][$id] = array(
										1 => "",
										2 => "",
									);
								$this->newBuffs[$val][$k][$id][1] .= ($r = ($this->newBuffs[$val][$k][$id][1] != "") ? "," : "").round($var, 1);
							}
							foreach($v[1] as $key => $var){
								$id = $this->getInstanceId($var);
								if (!isset($this->newBuffs[$val][$k][$id]))
									$this->newBuffs[$val][$k][$id] = array(
										1 => "",
										2 => "",
									);
								$this->newBuffs[$val][$k][$id][2] .= ($r = ($this->newBuffs[$val][$k][$id][2] != "") ? "," : "").round($var, 1);
							}
						}
					}
				}
				
				// Have to remove old processing, once new is in place properly
				foreach($this->attempts as $pk => $ok){
					foreach($this->auras[$val] as $k => $v){
						$num = sizeOf($v[0]);
						$active = 0;
						$buffs =  0;
						$debuffs = 0;
						foreach($v[0] as $key => $var){
							if (($ok[3]-0.01)<=$var && ($ok[5]-0.01)>=$var){
								if (!isset($v[2][$key]))
									$v[2][$key] = $ok[5];
								$active += ($v[2][$key]-$var);
								if (isset($this->abilitiesById[$k][4]) && $this->abilitiesById[$k][4]){
									$debuffs += 1;
								}else{
									$buffs += 1;
								}
							}
						}
						if (isset($this->abilitiesById[$k][4]) && $this->abilitiesById[$k][4]){
							if ($debuffs > 0){
								if (!isset($this->debuffs[$pk][$k]))
									$this->debuffs[$pk][$k] = array(
										1 => 0,
										2 => 0
									);
								$this->debuffs[$pk][$k][1] += $debuffs;
								if (isset($this->debuffs[$pk][$k][2]))
									$this->debuffs[$pk][$k][2] = ($this->debuffs[$pk][$k][2]+$active)/2;
								else
									$this->debuffs[$pk][$k][2] = $active;
								$this->individualDebuffs[$pk][$val][$k] = Array(
									1 => $debuffs,
									2 => $active
								);
							}
						}else{
							if ($buffs > 0){
								if ((isset($v[3]) && $v[3] === true) or isset($this->nonProcProcs[$spellsRaw[($qrs = (intval($this->abilitiesById[$k][3])>10) ? $this->abilitiesById[$k][3] : $spells[$k])]])){
									if (!isset($this->procs[$pk][$k]))
										$this->procs[$pk][$k] = array(
											1 => 0,
											2 => 0
										);
									$this->procs[$pk][$k][1] += $buffs;
									//$this->procs[$pk][$k][2] += $this->getNumMeeleHitsByAbility($k, $spellTra, $pk, $ok, $spellRevTra);

									$this->individualProcs[$pk][$val][$k] = Array(
										1 => $buffs,
										2 => $this->getNumMeeleHitsByAbilityByPlayer($k, $spellTra, $pk, $ok, $val, $spellsRaw, $spellRevTra, $spells)
									);
									if ($this->individualProcs[$pk][$val][$k][1]>$this->individualProcs[$pk][$val][$k][2])
										$this->individualProcs[$pk][$val][$k][2] = $this->individualProcs[$pk][$val][$k][1];
								}else{
									if (!isset($this->buffs[$pk][$k]))
										$this->buffs[$pk][$k] = array(
											1 => 0,
											2 => 0
										);
									$this->buffs[$pk][$k][1] += $buffs;
									if ($this->buffs[$pk][$k][2] != 0)
										$this->buffs[$pk][$k][2] = ($this->buffs[$pk][$k][2]+$active)/2;
									else
										$this->buffs[$pk][$k][2] = $active;
									$this->individualBuffs[$pk][$val][$k] = Array(
										1 => $buffs,
										2 => $active
									);
								}
							}
						}
					}
				}
			}
		}
	}
	
	/*
	* All of them have to be tested
	* 
	* deathsBySource[attemptid][charid][cbt] = Array(1 => killingblow(abilityid), 2 => time);
	* individualDeath[attemptid][charid][cbt][abilityid] = Array(1 => dmg, 2 => heal, 3 => time, 4 => npcid, 5 => gettype(hit/crit/crush));
	*/
	private function getDeaths(){
		foreach($this->participantKeys as $val){
			if (isset($this->deaths[$val])){
				foreach($this->attempts as $pk => $ok){
					foreach($this->deaths[$val] as $k => $v){
						if ($v["i"][0]==1){
							if ($ok[3]<=$v[0][5] && $ok[5]>=$v[0][5]){
								$i = 0;
								while (isset($v[$i][2])){
									if ($v[$i][2]>0 && $v[$i][4]==0)
										break 1;
									else
										$i++;
								}
								if (isset($v[$i][5])){
									for($p=0;$p<=20;$p++){
										if (!isset($v[$p]))
											break 1;
										$this->individualDeath[$pk][$val][$v[$i][5]][$p] = Array(
											1 => ($r = ($v[$p][4] == 0) ? $v[$p][2] : 0),
											2 => ($r = ($v[$p][4] == 1) ? $v[$p][2] : 0),
											3 => $v[$p][6],
											4 => $v[$p][0],
											5 => $v[$p][3],
											6 => $v[$p][1],
											7 => ($r = ((isset($this->userById[$v[$p][0]][1]) && $this->userById[$v[$p][0]][1]!="")) ? -1 : 1),
											8 => $v[$p][5]
										);
									}
									
									$this->deathsBySource[$pk][$val][$v[$i][5]] = Array(
										1 => $v[$i][1],
										2 => $v["i"][1],
										3 => $v[$i][0],
										4 => ($r = (isset($this->userById[$v[$i][0]][1]) && $this->userById[$v[$i][0]][1]!="") ? -1 : 1)
									);
								}
							}
						}
					}
				}
			}
		}
	}
	
	/*
	* All of them have to be tested (STILL TODO -> Time missing, also cbt?)
	* 
	* missedInterrupts[attemptid][npcid][charid] = Array(1 => abilityid, 2 => amount);
	* successfullInterruptsSum[attemptid][charid] = amount
	* missedInterruptsSum[attemptid][abilityid] = amount
	* individualInterrtups[attemptid][charid][cbt] = Array(1 => time, 2 => abilityid, 3 => npcid);
	*/
	private function getInterrupts($spellRevTra, $npcRevTra, $spellsRaw, $spells){
		foreach($this->participantKeys as $val){
			foreach($this->attempts as $pk => $ok){
				if (isset($this->interrupts[$val])){
					$num = 0;
					foreach($this->interrupts[$val]["i"][1] as $k => $v){
						if ($v[0]>=$ok[3] && $v[0]<=$ok[5]){
							$num += 1;
							$this->individualInterrupts[$pk][$val][$v[0]] = Array(
								1 => $v[1],
								2 => $v[2],
								3 => $v[3]
							);
						}
					}
					$this->successfullInterruptsSum[$pk][$val] = $num;
				}
				foreach($this->edd as $k => $v){
					if (isset($v[$val])){
						foreach($v[$val] as $key => $var){
							if ($key != "i"){
								if (isset($this->interruptableSpells[$spellsRaw[($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]]) && !isset($this->instanceBosses[$npcRevTra[$this->userById[$k][8]]])){
									if (isset($this->missedInterruptsSum[$pk][$key]))
										$this->missedInterruptsSum[$pk][$key] += $var[0]+$var[4];
									else
										$this->missedInterruptsSum[$pk][$key] = $var[0]+$var[4];
									$this->missedInterrupts[$pk][$k][$val] = Array(
										1 => $key,
										2 => $var[0]+$var[4]
									);
								}
							}
						}
					}
				}
			}
		}
	}
	
	/*
	* All of these have to be tested
	*
	* dispelsByAbility[attemptid][abilityid] = amount
	* dispelsByFriendly[attemptid][charid] = amount
	* individualDispelsByTarget[attemptid][charid][tarid] = amount;
	* individualDispelsByAbility[attemptid][charid][abilityid(the dispelled ability)] = amount;
	*/
	private function getDispels(){
		foreach($this->participantKeys as $val){
			if (isset($this->dispels[$val])){
				foreach($this->attempts as $pk => $ok){
					$amount = 0;
					foreach($this->dispels[$val]["i"][1] as $k => $v){
						if ($v[0]>=$ok[3] && $v[0]<=$ok[5]){
							$amount += 1;	
							if (!isset($this->individualDispelsByTarget[$pk][$val][$v[2]][$v[1]]))
								$this->individualDispelsByTarget[$pk][$val][$v[2]][$v[1]] = 0;
							$this->individualDispelsByTarget[$pk][$val][$v[2]][$v[1]] += 1;
						}
					}
				}
			}
		}
	}
	
	/*
	* individualHealingToFriendly[attemptid][charid][tarid] = Array(1 => tamount, 2 => eamount);
	* individualDmgDoneToEnemy[attemptid][npcid][charid] = Array(1 => amount, 2 => active);
	* healingBySource[attemptid][charid] = Array(1 => tamount, 2 => eamount, 3 => absorbed, 4 => active);
	* 
	* potentialDmgDoneRecords[charid] = array(1 => attemptid, 2 => dps);
	* potentialHealingDoneRecords[charid] = array(1 => attemptid, 2 => dps);
	*/
	private function aasort($array) {
		$sort = array();
		$p = array();
		foreach($array as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					$sort[$k][$ke][$key] = $var[1];
				}
				arsort($sort[$k][$ke]);
			}
		}
		foreach ($sort as $k => $v){
			foreach($v as $ke => $va){
				foreach ($va as $key => $var){
					$p[$k][$ke][$key] = $array[$k][$ke][$key];
				}
			}
		}
		return $p;
	}
	
	private function getImmortalRuns($attemptsArr, $guildid, $npcsById, $npcRevTra, $chars){
		// Will add the rest later
		$bossesByZone = Array(
			25 => array(
				"Onyxia" => false,
			),
			26 => array(
				"Onyxia" => false,
			),
			27 => array(
				"Patchwerk" => false,
				"Grobbulus" => false,
				"Gluth" => false,
				"Thaddius" => false,
				"Anub'Rekhan" => false,
				"Grand Widow Faerlina" => false,
				"Maexxna" => false,
				"Instructor Razuvious" => false,
				"Gothik the Harvester" => false,
				"The Four Horsemen" => false,
				"Noth the Plaguebringer" => false,
				"Heigan the Unclean" => false,
				"Loatheb" => false,
				"Sapphiron" => false,
				"Kel'Thuzad" => false,
			),
			28 => array(
				"Patchwerk" => false,
				"Grobbulus" => false,
				"Gluth" => false,
				"Thaddius" => false,
				"Anub'Rekhan" => false,
				"Grand Widow Faerlina" => false,
				"Maexxna" => false,
				"Instructor Razuvious" => false,
				"Gothik the Harvester" => false,
				"The Four Horsemen" => false,
				"Noth the Plaguebringer" => false,
				"Heigan the Unclean" => false,
				"Loatheb" => false,
				"Sapphiron" => false,
				"Kel'Thuzad" => 30061
			),
			29 => array(
				"Malygos" => false,
			),
			30 => array(
				"Malygos" => false,
			),
			31 => array(
				"Archavon the Stone Watcher" => false,
				"Emalon the Storm Watcher" => false,
				"Koralon the Flame Watcher" => false,
				"Toravon the Ice Watcher" => false,
			),
			32 => array(
				"Archavon the Stone Watcher" => false,
				"Emalon the Storm Watcher" => false,
				"Koralon the Flame Watcher" => false,
				"Toravon the Ice Watcher" => false,
			),
			33 => array(
				//"Shadron" => false,
				//"Tenebron" => false,
				//"Vesperon" => false,
				"Sapphiron" => false,
			),
			34 => array(
				//"Shadron" => false,
				//"Tenebron" => false,
				//"Vesperon" => false,
				"Sapphiron" => false,
			),
			35 => array(
				"Ignis the Furnace Master" => false,
				"Razorscale" => false,
				"XT-002 Deconstructor" => false,
				"The Assembly of Iron" => false,
				"Kologarn" => false,
				"Auriaya" => false,
				"Mimiron" => false, // May be wrong
				"Freya" => false,
				"Thorim" => false,
				"Hodir" => false,
				"General Vezax" => false,
				"Yogg-Saron" => false,
				"Algalon the Observer" => false,
			),
			36 => array(
				"Ignis the Furnace Master" => false,
				"Razorscale" => false,
				"XT-002 Deconstructor" => false,
				"The Assembly of Iron" => false,
				"Kologarn" => false,
				"Auriaya" => false,
				"Mimiron" => false,
				"Freya" => false,
				"Thorim" => false,
				"Hodir" => false,
				"General Vezax" => false,
				"Yogg-Saron" => false,
				"Algalon the Observer" => false,
			),
			37 => array(
				"Beasts of Northrend" => false,
				"Lord Jaraxxus" => false,
				"Faction Champions" => false,
				"Twin Val'kyr" => false,
				"Anub'arak" => false,
			),
			38 => array(
				"Beasts of Northrend" => false,
				"Lord Jaraxxus" => false,
				"Faction Champions" => false,
				"Twin Val'kyr" => false,
				"Anub'arak" => false,
			),
			39 => array(
				"Beasts of Northrend" => false,
				"Lord Jaraxxus" => false,
				"Faction Champions" => false,
				"Twin Val'kyr" => false,
				"Anub'arak" => false,
			),
			40 => array(
				"Beasts of Northrend" => false,
				"Lord Jaraxxus" => false,
				"Faction Champions" => false,
				"Twin Val'kyr" => false,
				"Anub'arak" => false,
			),
			41 => array(
				"Lord Marrowgar" => false,
				"Lady Deathwhisper" => false,
				"Gunship Battle" => false,
				"Deathbringer Saurfang" => false,
				"Festergut" => false,
				"Rotface" => false,
				"Professor Putricide" => false,
				"Blood Prince Council" => false,
				"Blood-Queen Lana'thel" => false,
				"Valithria Dreamwalker" => false,
				"Sindragosa" => false,
				"The Lich King" => false,
			),
			42 => array(
				"Lord Marrowgar" => false,
				"Lady Deathwhisper" => false,
				"Gunship Battle" => false,
				"Deathbringer Saurfang" => false,
				"Festergut" => false,
				"Rotface" => false,
				"Professor Putricide" => false,
				"Blood Prince Council" => false,
				"Blood-Queen Lana'thel" => false,
				"Valithria Dreamwalker" => false, // May be the wrong id
				"Sindragosa" => false,
				"The Lich King" => false,
			),
			43 => array(
				"Lord Marrowgar" => false,
				"Lady Deathwhisper" => false,
				"Gunship Battle" => false,
				"Deathbringer Saurfang" => false,
				"Festergut" => false,
				"Rotface" => false,
				"Professor Putricide" => false,
				"Blood Prince Council" => false,
				"Blood-Queen Lana'thel" => false,
				"Valithria Dreamwalker" => false,
				"Sindragosa" => false,
				"The Lich King" => false,
			),
			44 => array(
				"Lord Marrowgar" => false,
				"Lady Deathwhisper" => false,
				"Gunship Battle" => false,
				"Deathbringer Saurfang" => false,
				"Festergut" => false,
				"Rotface" => false,
				"Professor Putricide" => false,
				"Blood Prince Council" => false,
				"Blood-Queen Lana'thel" => false,
				"Valithria Dreamwalker" => false,
				"Sindragosa" => false,
				"The Lich King" => false,
			),
			45 => array(
				"Saviana Ragefire" => false,
				"Baltharus the Warborn" => false,
				"General Zarithrian" => false,
				"Halion" => false,
			),
			46 => array(
				"Saviana Ragefire" => false, // May be wrong
				"Baltharus the Warborn" => false,
				"General Zarithrian" => false,
				"Halion" => false,
			),
			47 => array(
				"Saviana Ragefire" => false,
				"Baltharus the Warborn" => false,
				"General Zarithrian" => false,
				"Halion" => false,
			),
			48 => array(
				"Saviana Ragefire" => false,
				"Baltharus the Warborn" => false,
				"General Zarithrian" => false,
				"Halion" => false,
			),
		);
		
		$VRankings = array();
		foreach($this->db->query('SELECT * FROM `wotlk-immortal-runs` WHERE guildid = '.$guildid) as $row){
			$VRankings[$row->raidnameid] = Array(
				1 => $row->fodeaths,
				2 => $row->foadeaths,
				3 => $row->modeaths,
				4 => $row->moadeaths,
				5 => $row->fochange,
				6 => $row->foachange,
				7 => $row->mochange,
				8 => $row->moachange,
				9 => $row->forid,
				10 => $row->foarid,
				11 => $row->morid,
				12 => $row->moarid,
				13 => $row->foamount,
				14 => $row->foaamount,
				15 => false, // new Overall?
				16 => false, // new Rest?
				17 => $row->moamount,
				18 => $row->moaamount
			);
		}
		$deathsByRaid = array();
		foreach($attemptsArr as $k => $v){
			if (!isset($deathsByRaid[$v[8]]) && isset($v[8]) && $v[8] != '' && isset($v[2]))
				$deathsByRaid[$v[8]] = array(1=>0, 2=>$v[2]);
			if ($bossesByZone[$v[8]]){
				//print $v[8]." // ".$npcsById[$v[3]]." <br />";
				$bossesByZone[$v[8]][$npcsById[$v[3]]] = true;
			}
		}
		foreach($this->deathsBySource as $k => $v){ // attemptids
			foreach($v as $ke => $va){ // player ids
				foreach($va as $key => $var){ // deaths
					if (!isset($npcsById[$ke]) && isset($chars[$ke]) && (!isset($this->userById[$ke][3]) or $this->userById[$ke][3] === false)){ 
						$nameid = $attemptsArr[$k][8];
						if (!isset($nameid)){
							foreach($attemptsArr as $kee => $vaa){
								if (isset($vaa[8])){
									$nameid = $vaa[8];
									break 1;
								}
							}
						}
						$deathsByRaid[$nameid][1]++;
					}
				}
			}
		}
		
		foreach($deathsByRaid as $k => $v){
			if ($this->allBossesKilled($bossesByZone[$k])){
				if (isset($VRankings[$k])){
					// overall and month best
					if ($VRankings[$k][1]>$v[1]){
						$VRankings[$k][5] = -($VRankings[$k][1]-$v[1]);
						$VRankings[$k][1] = $v[1];
						$VRankings[$k][9] = $v[2];
						$VRankings[$k][13] = 1;
					}
					if ($VRankings[$k][1]==$v[1]){
						$VRankings[$k][13]++;
						$VRankings[$k][5] = 0;
					}
					if ($VRankings[$k][3]>$v[1]){
						$VRankings[$k][7] = -($VRankings[$k][3]-$v[1]);
						$VRankings[$k][3] = $v[1];
						$VRankings[$k][11] = $v[2];
						$VRankings[$k][17] = 1;
					}
					if ($VRankings[$k][3]==$v[1]){
						$VRankings[$k][17]++;
						$VRankings[$k][7] = 0;
					}
					
					// overall and month average
					$VRankings[$k][6] = -($VRankings[$k][2] - ($VRankings[$k][2]*($VRankings[$k][14]/($VRankings[$k][14]+1)) + $v[1]*(1/($VRankings[$k][14]+1))));
					$VRankings[$k][2] = $VRankings[$k][2]*($VRankings[$k][14]/($VRankings[$k][14]+1)) + $v[1]*(1/($VRankings[$k][14]+1));
					$VRankings[$k][10] = $v[2];
					$VRankings[$k][14]++;
					
					$VRankings[$k][8] = -($VRankings[$k][4] - ($VRankings[$k][4]*($VRankings[$k][18]/($VRankings[$k][18]+1)) + $v[1]*(1/($VRankings[$k][18]+1))));
					$VRankings[$k][4] = $VRankings[$k][4]*($VRankings[$k][18]/($VRankings[$k][18]+1)) + $v[1]*(1/($VRankings[$k][18]+1));
					$VRankings[$k][12] = $v[2];
					$VRankings[$k][18]++;
					$VRankings[$k][15] = true;
				}else{
					$VRankings[$k] = array(
						1 => $v[1],
						2 => $v[1],
						3 => $v[1],
						4 => $v[1],
						5 => $v[1],
						6 => $v[1],
						7 => $v[1],
						8 => $v[1],
						9 => $v[2],
						10 => $v[2],
						11 => $v[2],
						12 => $v[2],
						13 => 1,
						14 => 1,
						15 => true,
						16 => true,
						17 => 1,
						18 => 1
					);
				}
			}
		}
		return $VRankings;
	}
	
	private function getVRankings($chars, $npcs, $attemptsids, $serverid, $classes, $npcRevTra, $npcTra){
		// Getting old records for reference
		$VRankings = array();
		foreach($this->db->query('SELECT * FROM `wotlk-rankings` a INNER JOIN chars b ON a.charid = b.id') as $row){
			$VRankings[$row->bossid][$row->type][$row->charid] = Array(
				1 => $row->boval,
				2 => $row->aoval,
				3 => $row->bmval,
				4 => $row->amval,
				5 => $row->botime,
				6 => $row->aotime,
				7 => $row->bmtime,
				8 => $row->amtime,
				9 => $row->oattemptid,
				10 => $row->mattemptid,
				11 => $row->bochange,
				12 => $row->aochange,
				13 => $row->bmchange,
				14 => $row->amchange,
				15 => false, // new Overall?
				16 => false, // new Rest?
				17 => $row->serverid,
				18 => $row->classid,
				19 => $row->aoamount,
				20 => $row->boamount
			);
		}
		
		// Damage done
		$temp = array();
		foreach($this->attempts as $pk => $ok){
			if ($ok[6]==true && isset($this->instanceBosses[$npcTra[$this->user[$ok[2]][8]]]) && !isset($temp[$npcs[$this->user[$ok[2]][0]]])){
				foreach($this->individualDmgDoneToEnemy[$pk] as $ke => $va){ //npcid
					foreach($va as $key => $var){ // charid
						if ($var[1]>0){
							if (intval($this->userById[$key][5])>1){ // pet dmg
								if (isset($temp[$npcs[$this->user[$ok[2]][0]]][$this->userById[$key][5]][1]))
									$temp[$npcs[$this->user[$ok[2]][0]]][$this->userById[$key][5]][1] += $var[1];
								else
									$temp[$npcs[$this->user[$ok[2]][0]]][$this->userById[$key][5]][1] = $var[1];
								if (!isset($temp[$npcs[$this->user[$ok[2]][0]]][$this->userById[$key][5]][2]))
									$temp[$npcs[$this->user[$ok[2]][0]]][$this->userById[$key][5]][2] = $ok[7];
							}else{
								if (!isset($temp[$npcs[$this->user[$ok[2]][0]]][$key]))
									$temp[$npcs[$this->user[$ok[2]][0]]][$key] = array(
										1 => $var[1],
										2 => $ok[7]
									);
								else
									$temp[$npcs[$this->user[$ok[2]][0]]][$key][1] += $var[1];
							}
						}
					}
				}
			}
		}
		
		// Healing done
		$tempHeal = array();
		foreach($this->attempts as $pk => $ok){
			if ($ok[6] && !$ok[8] && isset($this->instanceBosses[$npcTra[$this->user[$ok[2]][8]]]) && !isset($tempHeal[$npcs[$this->user[$ok[2]][0]]])){
				foreach($this->healingBySource[$pk] as $key => $var){ //charid
					if (($var[2]+$var[3])>0){
						$tempHeal[$npcs[$this->user[$ok[2]][0]]][$key][1] = ($var[2]+$var[3]);
						$tempHeal[$npcs[$this->user[$ok[2]][0]]][$key][2] = $ok[7];
					}
				}
			}
		}
		foreach($temp as $k => $v){
			foreach ($v as $ke => $va){
				if (isset($va[2]) && isset($va[1]) && isset($k)){
					if (!isset($tempHeal[$k][$ke]) || $tempHeal[$k][$ke][1]<$va[1]){
						$val = $va[1]/$va[2];
						if (isset($VRankings[$k][-1][$chars[$ke]])){
							if ($VRankings[$k][-1][$chars[$ke]][1]<$val){
								$VRankings[$k][-1][$chars[$ke]][11] = $val-$VRankings[$k][-1][$chars[$ke]][1];
								$VRankings[$k][-1][$chars[$ke]][1] = $val;
								$VRankings[$k][-1][$chars[$ke]][5] = $va[2];
								$VRankings[$k][-1][$chars[$ke]][9] = $attemptsids[$k][1];
								$VRankings[$k][-1][$chars[$ke]][15] = true;
							}
							if ($VRankings[$k][-1][$chars[$ke]][3]<$val){
								$VRankings[$k][-1][$chars[$ke]][13] = $val-$VRankings[$k][-1][$chars[$ke]][3];
								$VRankings[$k][-1][$chars[$ke]][3] = $val;
								$VRankings[$k][-1][$chars[$ke]][7] = $va[2];
								$VRankings[$k][-1][$chars[$ke]][10] = $attemptsids[$k][1];
							}
							if ($VRankings[$k][-1][$chars[$ke]][2] == 0){
								$VRankings[$k][-1][$chars[$ke]][12] = $val;
								$VRankings[$k][-1][$chars[$ke]][2] = $val;
								$VRankings[$k][-1][$chars[$ke]][6] = $va[2];
								$VRankings[$k][-1][$chars[$ke]][19] = 1;
							}else{
								$VRankings[$k][-1][$chars[$ke]][12] = -($VRankings[$k][-1][$chars[$ke]][2] - ($VRankings[$k][-1][$chars[$ke]][2]*($VRankings[$k][-1][$chars[$ke]][19]/($VRankings[$k][-1][$chars[$ke]][19]+1)) + $val*(1/($VRankings[$k][-1][$chars[$ke]][19]+1))));
								$VRankings[$k][-1][$chars[$ke]][2] = $VRankings[$k][-1][$chars[$ke]][2]*($VRankings[$k][-1][$chars[$ke]][19]/($VRankings[$k][-1][$chars[$ke]][19]+1)) + $val*(1/($VRankings[$k][-1][$chars[$ke]][19]+1));
								$VRankings[$k][-1][$chars[$ke]][6] = $VRankings[$k][-1][$chars[$ke]][6]*($VRankings[$k][-1][$chars[$ke]][19]/($VRankings[$k][-1][$chars[$ke]][19]+1)) + $va[2]*(1/($VRankings[$k][-1][$chars[$ke]][19]+1));
								$VRankings[$k][-1][$chars[$ke]][19]++;
							}
							if ($VRankings[$k][-1][$chars[$ke]][4] == 0){
								$VRankings[$k][-1][$chars[$ke]][14] = $val;
								$VRankings[$k][-1][$chars[$ke]][4] = $val;
								$VRankings[$k][-1][$chars[$ke]][8] = $va[2];
								$VRankings[$k][-1][$chars[$ke]][20] = 1;
							}else{
								$VRankings[$k][-1][$chars[$ke]][14] = -($VRankings[$k][-1][$chars[$ke]][4] - ($VRankings[$k][-1][$chars[$ke]][4]*($VRankings[$k][-1][$chars[$ke]][20]/($VRankings[$k][-1][$chars[$ke]][20]+1)) + $val*(1/($VRankings[$k][-1][$chars[$ke]][20]+1))));
								$VRankings[$k][-1][$chars[$ke]][4] = $VRankings[$k][-1][$chars[$ke]][4]*($VRankings[$k][-1][$chars[$ke]][20]/($VRankings[$k][-1][$chars[$ke]][20]+1)) + $val*(1/($VRankings[$k][-1][$chars[$ke]][20]+1));
								$VRankings[$k][-1][$chars[$ke]][8] = $VRankings[$k][-1][$chars[$ke]][8]*($VRankings[$k][-1][$chars[$ke]][20]/($VRankings[$k][-1][$chars[$ke]][20]+1)) + $va[2]*(1/($VRankings[$k][-1][$chars[$ke]][20]+1));
								$VRankings[$k][-1][$chars[$ke]][20]++;
							}
							$VRankings[$k][-1][$chars[$ke]][16] = true;
						}else{
							$VRankings[$k][-1][$chars[$ke]] = Array(
								1 => $val,
								2 => $val,
								3 => $val,
								4 => $val,
								5 => $va[2],
								6 => $va[2],
								7 => $va[2],
								8 => $va[2],
								9 => $attemptsids[$k][1],
								10 => $attemptsids[$k][1],
								11 => $val,
								12 => $val,
								13 => $val,
								14 => $val,
								15 => true,
								16 => true,
								17 => $serverid,
								18 => ($r = (isset($this->userById[$ke][1])) ? $classes[$this->userById[$ke][1]] : 0),
								19 => 1,
								20 => 1
							);
						}
					}
				}
			}
		}

		foreach($tempHeal as $k => $v){
			foreach ($v as $ke => $va){
				if (isset($va[2]) && isset($va[1]) && isset($k)){
					if (!isset($temp[$k][$ke]) || $temp[$k][$ke][1]<$va[1]){
						$val = $va[1]/$va[2];
						if (isset($VRankings[$k][1][$chars[$ke]])){
							if ($VRankings[$k][1][$chars[$ke]][1]<$val){
								$VRankings[$k][1][$chars[$ke]][11] = $val-$VRankings[$k][1][$chars[$ke]][1];
								$VRankings[$k][1][$chars[$ke]][1] = $val;
								$VRankings[$k][1][$chars[$ke]][5] = $va[2];
								$VRankings[$k][1][$chars[$ke]][9] = $attemptsids[$k][1];
								$VRankings[$k][1][$chars[$ke]][15] = true;
							}
							if ($VRankings[$k][1][$chars[$ke]][3]<$val){
								$VRankings[$k][1][$chars[$ke]][13] = $val-$VRankings[$k][1][$chars[$ke]][3];
								$VRankings[$k][1][$chars[$ke]][3] = $val;
								$VRankings[$k][1][$chars[$ke]][7] = $va[2];
								$VRankings[$k][1][$chars[$ke]][10] = $attemptsids[$k][1];
							}
							if ($VRankings[$k][1][$chars[$ke]][2] == 0){
								$VRankings[$k][1][$chars[$ke]][12] = $val;
								$VRankings[$k][1][$chars[$ke]][2] = $val;
								$VRankings[$k][1][$chars[$ke]][6] = $va[2];
								$VRankings[$k][1][$chars[$ke]][19] = 1;
							}else{
								$VRankings[$k][1][$chars[$ke]][12] = -($VRankings[$k][1][$chars[$ke]][2] - ($VRankings[$k][1][$chars[$ke]][2]*($VRankings[$k][1][$chars[$ke]][19]/($VRankings[$k][1][$chars[$ke]][19]+1)) + $val*(1/($VRankings[$k][1][$chars[$ke]][19]+1))));
								$VRankings[$k][1][$chars[$ke]][2] = $VRankings[$k][1][$chars[$ke]][2]*($VRankings[$k][1][$chars[$ke]][19]/($VRankings[$k][1][$chars[$ke]][19]+1)) + $val*(1/($VRankings[$k][1][$chars[$ke]][19]+1));
								$VRankings[$k][1][$chars[$ke]][6] = $VRankings[$k][1][$chars[$ke]][6]*($VRankings[$k][1][$chars[$ke]][19]/($VRankings[$k][1][$chars[$ke]][19]+1)) + $va[2]*(1/($VRankings[$k][1][$chars[$ke]][19]+1));
								$VRankings[$k][1][$chars[$ke]][19]++;
							}
							if ($VRankings[$k][1][$chars[$ke]][4] == 0){
								$VRankings[$k][1][$chars[$ke]][14] = $val;
								$VRankings[$k][1][$chars[$ke]][4] = $val;
								$VRankings[$k][1][$chars[$ke]][8] = $va[2];
								$VRankings[$k][1][$chars[$ke]][20] = 1;
							}else{
								$VRankings[$k][1][$chars[$ke]][14] = -($VRankings[$k][1][$chars[$ke]][4] - ($VRankings[$k][1][$chars[$ke]][4]*($VRankings[$k][1][$chars[$ke]][20]/($VRankings[$k][1][$chars[$ke]][20]+1)) + $val*(1/($VRankings[$k][1][$chars[$ke]][20]+1))));
								$VRankings[$k][1][$chars[$ke]][4] = $VRankings[$k][1][$chars[$ke]][4]*($VRankings[$k][1][$chars[$ke]][20]/($VRankings[$k][1][$chars[$ke]][20]+1)) + $val*(1/($VRankings[$k][1][$chars[$ke]][20]+1));
								$VRankings[$k][1][$chars[$ke]][8] = $VRankings[$k][1][$chars[$ke]][8]*($VRankings[$k][1][$chars[$ke]][20]/($VRankings[$k][1][$chars[$ke]][20]+1)) + $va[2]*(1/($VRankings[$k][1][$chars[$ke]][20]+1));
								$VRankings[$k][1][$chars[$ke]][20]++;
							}
							$VRankings[$k][1][$chars[$ke]][16] = true;
						}else{
							$VRankings[$k][1][$chars[$ke]] = Array(
								1 => $val,
								2 => $val,
								3 => $val,
								4 => $val,
								5 => $va[2],
								6 => $va[2],
								7 => $va[2],
								8 => $va[2],
								9 => $attemptsids[$k][1],
								10 => $attemptsids[$k][1],
								11 => $val,
								12 => $val,
								13 => $val,
								14 => $val,
								15 => true,
								16 => true,
								17 => $serverid,
								18 => $classes[$this->userById[$ke][1]],
								19 => 1,
								20 => 1
							);
						}
					}
				}
			}
		}
		
		return $this->aasort($VRankings);
	}
	
	private function allBossesKilled($arr){
		foreach($arr as $var){
			if ($var == false)
				return false;
		}
		return isset($arr);
	}
	
	private function getSpeedRunRanking($attemptsArr, $guildid, $npcsById, $npcRevTra, $Qraids){
		$bossesByZone = Array(
			25 => array(
				"Onyxia" => false,
			),
			26 => array(
				"Onyxia" => false,
			),
			27 => array(
				"Patchwerk" => false,
				"Grobbulus" => false,
				"Gluth" => false,
				"Thaddius" => false,
				"Anub'Rekhan" => false,
				"Grand Widow Faerlina" => false,
				"Maexxna" => false,
				"Instructor Razuvious" => false,
				"Gothik the Harvester" => false,
				"The Four Horsemen" => false,
				"Noth the Plaguebringer" => false,
				"Heigan the Unclean" => false,
				"Loatheb" => false,
				"Sapphiron" => false,
				"Kel'Thuzad" => false,
			),
			28 => array(
				"Patchwerk" => false,
				"Grobbulus" => false,
				"Gluth" => false,
				"Thaddius" => false,
				"Anub'Rekhan" => false,
				"Grand Widow Faerlina" => false,
				"Maexxna" => false,
				"Instructor Razuvious" => false,
				"Gothik the Harvester" => false,
				"The Four Horsemen" => false,
				"Noth the Plaguebringer" => false,
				"Heigan the Unclean" => false,
				"Loatheb" => false,
				"Sapphiron" => false,
				"Kel'Thuzad" => 30061
			),
			29 => array(
				"Malygos" => false,
			),
			30 => array(
				"Malygos" => false,
			),
			31 => array(
				"Archavon the Stone Watcher" => false,
				"Emalon the Storm Watcher" => false,
				"Koralon the Flame Watcher" => false,
				"Toravon the Ice Watcher" => false,
			),
			32 => array(
				"Archavon the Stone Watcher" => false,
				"Emalon the Storm Watcher" => false,
				"Koralon the Flame Watcher" => false,
				"Toravon the Ice Watcher" => false,
			),
			33 => array(
				//"Shadron" => false,
				//"Tenebron" => false,
				//"Vesperon" => false,
				"Sapphiron" => false,
			),
			34 => array(
				//"Shadron" => false,
				//"Tenebron" => false,
				//"Vesperon" => false,
				"Sapphiron" => false,
			),
			35 => array(
				"Ignis the Furnace Master" => false,
				"Razorscale" => false,
				"XT-002 Deconstructor" => false,
				"The Assembly of Iron" => false,
				"Kologarn" => false,
				"Auriaya" => false,
				"Mimiron" => false, // May be wrong
				"Freya" => false,
				"Thorim" => false,
				"Hodir" => false,
				"General Vezax" => false,
				"Yogg-Saron" => false,
				"Algalon the Observer" => false,
			),
			36 => array(
				"Ignis the Furnace Master" => false,
				"Razorscale" => false,
				"XT-002 Deconstructor" => false,
				"The Assembly of Iron" => false,
				"Kologarn" => false,
				"Auriaya" => false,
				"Mimiron" => false,
				"Freya" => false,
				"Thorim" => false,
				"Hodir" => false,
				"General Vezax" => false,
				"Yogg-Saron" => false,
				"Algalon the Observer" => false,
			),
			37 => array(
				"Beasts of Northrend" => false,
				"Lord Jaraxxus" => false,
				"Faction Champions" => false,
				"Twin Val'kyr" => false,
				"Anub'arak" => false,
			),
			38 => array(
				"Beasts of Northrend" => false,
				"Lord Jaraxxus" => false,
				"Faction Champions" => false,
				"Twin Val'kyr" => false,
				"Anub'arak" => false,
			),
			39 => array(
				"Beasts of Northrend" => false,
				"Lord Jaraxxus" => false,
				"Faction Champions" => false,
				"Twin Val'kyr" => false,
				"Anub'arak" => false,
			),
			40 => array(
				"Beasts of Northrend" => false,
				"Lord Jaraxxus" => false,
				"Faction Champions" => false,
				"Twin Val'kyr" => false,
				"Anub'arak" => false,
			),
			41 => array(
				"Lord Marrowgar" => false,
				"Lady Deathwhisper" => false,
				"Gunship Battle" => false,
				"Deathbringer Saurfang" => false,
				"Festergut" => false,
				"Rotface" => false,
				"Professor Putricide" => false,
				"Blood Prince Council" => false,
				"Blood-Queen Lana'thel" => false,
				"Valithria Dreamwalker" => false,
				"Sindragosa" => false,
				"The Lich King" => false,
			),
			42 => array(
				"Lord Marrowgar" => false,
				"Lady Deathwhisper" => false,
				"Gunship Battle" => false,
				"Deathbringer Saurfang" => false,
				"Festergut" => false,
				"Rotface" => false,
				"Professor Putricide" => false,
				"Blood Prince Council" => false,
				"Blood-Queen Lana'thel" => false,
				"Valithria Dreamwalker" => false, // May be the wrong id
				"Sindragosa" => false,
				"The Lich King" => false,
			),
			43 => array(
				"Lord Marrowgar" => false,
				"Lady Deathwhisper" => false,
				"Gunship Battle" => false,
				"Deathbringer Saurfang" => false,
				"Festergut" => false,
				"Rotface" => false,
				"Professor Putricide" => false,
				"Blood Prince Council" => false,
				"Blood-Queen Lana'thel" => false,
				"Valithria Dreamwalker" => false,
				"Sindragosa" => false,
				"The Lich King" => false,
			),
			44 => array(
				"Lord Marrowgar" => false,
				"Lady Deathwhisper" => false,
				"Gunship Battle" => false,
				"Deathbringer Saurfang" => false,
				"Festergut" => false,
				"Rotface" => false,
				"Professor Putricide" => false,
				"Blood Prince Council" => false,
				"Blood-Queen Lana'thel" => false,
				"Valithria Dreamwalker" => false,
				"Sindragosa" => false,
				"The Lich King" => false,
			),
			45 => array(
				"Saviana Ragefire" => false,
				"Baltharus the Warborn" => false,
				"General Zarithrian" => false,
				"Halion" => false,
			),
			46 => array(
				"Saviana Ragefire" => false, // May be wrong
				"Baltharus the Warborn" => false,
				"General Zarithrian" => false,
				"Halion" => false,
			),
			47 => array(
				"Saviana Ragefire" => false,
				"Baltharus the Warborn" => false,
				"General Zarithrian" => false,
				"Halion" => false,
			),
			48 => array(
				"Saviana Ragefire" => false,
				"Baltharus the Warborn" => false,
				"General Zarithrian" => false,
				"Halion" => false,
			),
		);
		
		$SpeedRun = array();
		foreach($this->db->query('SELECT * FROM `wotlk-speed-runs` WHERE guildid = "'.$guildid.'"') as $row){
			$SpeedRun[$row->raidnameid] = array(
				1 => $row->fotime,
				2 => $row->foboss,
				4 => $row->foatime,
				5 => $row->foaboss,
				7 => $row->fmtime,
				8 => $row->fmboss,
				10 => $row->fmatime,
				11 => $row->fmaboss,
				13 => $row->oraidid,
				14 => $row->mraidid,
				15 => $row->fochange,
				16 => $row->foachange,
				17 => $row->fmchange,
				18 => $row->fmachange,
				19 => false,
				20 => $row->foamount,
				21 => $row->fmamount
			);
		}
		
		// Summarize raids
		$raids = array();
		foreach($attemptsArr as $key => $var){
			if (isset($var[10]) && (isset($bossesByZone[$var[10]]) or isset($bossesByZone[$Qraids[$var[10]]])) && isset($var[6]) && $var[7] == 1 && isset($bossesByZone[$Qraids[$var[10]]][$npcsById[$var[3]]])){
				$ts = strtotime($var[9]);
				$start = $ts;
				$end = $ts+($var[5]-$var[4]);
				if(!isset($raids[$var[8]][1]) || $raids[$var[8]][1]>$start)
					$raids[$var[8]][1] = $start;
				if(!isset($raids[$var[8]][2]) || $raids[$var[8]][2]<$end)
					$raids[$var[8]][2] = $end;
				$raids[$var[8]][3] = $var[2]; // raid id
				if ($var[7] == 1){
					if (!isset($raids[$var[8]][4]))
						$raids[$var[8]][4] = ($var[5]-$var[4]);
					else
						$raids[$var[8]][4] += ($var[5]-$var[4]); // boss fight time
				}
				$bossesByZone[$Qraids[$var[10]]][$npcsById[$var[3]]] = true;
				$raids[$var[8]][5] = $Qraids[$var[10]];
			}
		}
		
		
		
		foreach($raids as $key => $var){
			$now = time() +43200;
			if ($now<$var[1])
				$var[1] = strtotime("yesterday ".date("H:i:s", $var[1]));
			if ($now<$var[2])
				$var[2] = strtotime("yesterday ".date("H:i:s", $var[2]));
			if ($var[2]<$var[1])
				$var[1] = strtotime("yesterday ".date("H:i:s", $var[1]));
			if (isset($var[5])){
				if ($this->allBossesKilled($bossesByZone[$var[5]])){
					$duration = $var[2]-$var[1];
					if (isset($SpeedRun[$key])){
						if ($SpeedRun[$key][1]>$duration){
							$SpeedRun[$key][15] = $duration-$SpeedRun[$key][1];
							$SpeedRun[$key][1] = $duration;
							$SpeedRun[$key][2] = $var[4];
							$SpeedRun[$key][3] = $duration-$var[4];
							$SpeedRun[$key][13] = $var[3];
						}
						if ($SpeedRun[$key][7]>$duration){
							$SpeedRun[$key][17] = $duration-$SpeedRun[$key][7];
							$SpeedRun[$key][7] = $duration;
							$SpeedRun[$key][8] = $var[4];
							$SpeedRun[$key][9] = $duration-$var[4];
							$SpeedRun[$key][14] = $var[3];
						}
						if ($SpeedRun[$key][4] == 0){
							$SpeedRun[$key][16] = $duration;
							$SpeedRun[$key][4] = $duration;
							$SpeedRun[$key][5] = $var[4];
							$SpeedRun[$key][20] = 1;
						}else{
							$SpeedRun[$key][16] = -($SpeedRun[$key][4] - ($SpeedRun[$key][4]*($SpeedRun[$key][20]/($SpeedRun[$key][20]+1)) + $duration*(1/($SpeedRun[$key][20]+1))));
							$SpeedRun[$key][4] = $SpeedRun[$key][4]*($SpeedRun[$key][20]/($SpeedRun[$key][20]+1)) + $duration*(1/($SpeedRun[$key][20]+1));
							$SpeedRun[$key][5] = $SpeedRun[$key][5]*($SpeedRun[$key][20]/($SpeedRun[$key][20]+1)) + $var[4]*(1/($SpeedRun[$key][20]+1));
							$SpeedRun[$key][20]++;
						}
						if ($SpeedRun[$key][10] == 0){
							$SpeedRun[$key][18] = $duration;
							$SpeedRun[$key][10] = $duration;
							$SpeedRun[$key][11] = $var[4];
							$SpeedRun[$key][21] = 1;
						}else{
							$SpeedRun[$key][18] = -($SpeedRun[$key][10] - ($SpeedRun[$key][10]*($SpeedRun[$key][21]/($SpeedRun[$key][21]+1)) + $duration*(1/($SpeedRun[$key][21]+1))));
							$SpeedRun[$key][10] = $SpeedRun[$key][10]*($SpeedRun[$key][21]/($SpeedRun[$key][21]+1)) + $duration*(1/($SpeedRun[$key][21]+1));
							$SpeedRun[$key][11] = $SpeedRun[$key][11]*($SpeedRun[$key][21]/($SpeedRun[$key][21]+1)) + $var[4]*(1/($SpeedRun[$key][21]+1));
							$SpeedRun[$key][21]++;
						}
						$SpeedRun[$key][19] = true;
					}else{
						$SpeedRun[$key] = array(
							1 => $duration,
							2 => $var[4],
							4 => $duration,
							5 => $var[4],
							7 => $duration,
							8 => $var[4],
							10 => $duration,
							11 => $var[4],
							13 => $var[3],
							14 => $var[3],
							15 => $duration,
							16 => $duration,
							17 => $duration,
							18 => $duration,
							19 => true,
							20 => 1,
							21 => 1
						);
					}
				}else{
					//print "FALSE!";
				}
			}			
		}
		return $SpeedRun;
	}
	
	private function getSpeedKillRanking($attemptsArr, $guildid){
		$SpeedKillRanking = array();
		foreach($this->db->query('SELECT * FROM `wotlk-speed-kills` WHERE guildid = "'.$guildid.'"') as $row){
			$SpeedKillRanking[$row->bossid] = array(
				1 => $row->fotime,
				2 => $row->foatime,
				3 => $row->fmtime,
				4 => $row->fmatime,
				5 => $row->fochange,
				6 => $row->foachange,
				7 => $row->fmchange,
				8 => $row->fmachange,
				9 => $row->oraidid,
				10 => $row->mraidid,
				11 => false,
				12 => $row->foamount,
				13 => $row->fmamount
			);
		}
		
		$kills = array();
		foreach($attemptsArr as $key => $var){
			if (isset($var[6]) && $var[7] == 1){
				$kills[$var[3]] = Array(
					1 => $var[5]-$var[4],
					2 => $var[2]
				);
			}
		}
		
		foreach($kills as $key => $var){
			if (isset($SpeedKillRanking[$key])){
				if ($SpeedKillRanking[$key][1]>$var[1]){
					$SpeedKillRanking[$key][5] = $var[1]-$SpeedKillRanking[$key][1];
					$SpeedKillRanking[$key][1] = $var[1];
					$SpeedKillRanking[$key][9] = $var[2];
				}
				if ($SpeedKillRanking[$key][3]>$var[1]){
					$SpeedKillRanking[$key][7] = $var[1]-$SpeedKillRanking[$key][3];
					$SpeedKillRanking[$key][3] = $var[1];
					$SpeedKillRanking[$key][10] = $var[2];
				}
				if ($SpeedKillRanking[$key][2] == 0){
					$SpeedKillRanking[$key][6] = $var[1];
					$SpeedKillRanking[$key][2] = $var[1];
					$SpeedKillRanking[$key][12] = 1;
				}else{
					$SpeedKillRanking[$key][6] = -($SpeedKillRanking[$key][2] - ($SpeedKillRanking[$key][2]*($SpeedKillRanking[$key][12]/($SpeedKillRanking[$key][12]+1)) + $var[1]*(1/($SpeedKillRanking[$key][12]+1))));
					$SpeedKillRanking[$key][2] = $SpeedKillRanking[$key][2]*($SpeedKillRanking[$key][12]/($SpeedKillRanking[$key][12]+1)) + $var[1]*(1/($SpeedKillRanking[$key][12]+1));
					$SpeedKillRanking[$key][12]++;
				}
				if ($SpeedKillRanking[$key][4] == 0){
					$SpeedKillRanking[$key][8] = $var[1];
					$SpeedKillRanking[$key][4] = $var[1];
					$SpeedKillRanking[$key][13] = 1;
				}else{
					$SpeedKillRanking[$key][8] = -($SpeedKillRanking[$key][4] - ($SpeedKillRanking[$key][4]*($SpeedKillRanking[$key][13]/($SpeedKillRanking[$key][13]+1)) + $var[1]*(1/($SpeedKillRanking[$key][13]+1))));
					$SpeedKillRanking[$key][4] = $SpeedKillRanking[$key][4]*($SpeedKillRanking[$key][13]/($SpeedKillRanking[$key][13]+1)) + $var[1]*(1/($SpeedKillRanking[$key][13]+1));
					$SpeedKillRanking[$key][13]++;
				}
				$SpeedKillRanking[$key][11] = true;
			}else{
				$SpeedKillRanking[$key] = Array(
					1 => $var[1],
					2 => $var[1],
					3 => $var[1],
					4 => $var[1],
					5 => $var[1],
					6 => $var[1],
					7 => $var[1],
					8 => $var[1],
					9 => $var[2],
					10 => $var[2],
					11 => true,
					12 => 1,
					13 => 1
				);
			}
		}
		
		return $SpeedKillRanking;
	}
	
	private function in_array($arr, $val){
		if (isset($val)){
			foreach($arr as $key => $var){
				if ($key == $val || $var == $val)
					return true;
			}
		}
		return false;
	}
	
	private function getBossBeginn($arr, $alt){
		$first = 0;
		foreach($arr as $val){
			foreach($this->totalEDTTable[$val] as $var){
				foreach($var as $k => $v){
					if (($first == 0 || $k<$first) && $k>=$alt)
						$first = $k;
				}
			}
		}
		if ($first != 0)
			return $first;
		return $alt;
	}
	
	private function getLatestPointInSub($arr, $old){
		$latest = $old;
		foreach($arr as $k => $v){
			if ($v[2]>$latest)
				$latest = $v[2];
		}
		return $latest;
	}
	
	private function checkArray($arr1, $arr2, $npcsTra){
		foreach($arr1 as $var){
			if (in_array($npcsTra[$this->user[$var][8]], $arr2)) // issues?
				return true;
		}
		return false;
	}
	
	private $instanceStart = array();
	private function getAttempts($npcsTra, $npcsTraRev){
		$bossBeginnArray = array(
			// Ony
			"Onyxia" => array(
				"Onyxia",
				//"Onyxian Whelp",
				//"Onyxian Lair Guard",
			),
			// Naxx
			"Grobbulus" => array(
				"Grobbulus",
				"Fallout Slime",
				"Grobbulus Cloud"
			),
			"Gluth" => array(
				"Gluth",
				"Zombie Chow"
			),
			"Thaddius" => array(
				"Thaddius",
				"Stalagg",
				"Feugen"
			),
			"Anub'Rekhan" => array(
				"Anub'Rekhan",
				"Crypt Guard"
			),
			"Grand Widow Faerlina" => array(
				"Grand Widow Faerlina",
				"Naxxramas Follower"
			),
			"Maexxna" => array(
				"Maexxna",
				"Web Wrap",
				"Maexxna Spiderling"
			),
			"Instructor Razuvious" => array(
				"Instructor Razuvious",
				"Deathknight Understudy"
			),
			"Gothik the Harvester" => array(
				"Gothik the Harvester",
				"Unrelenting Trainee",
				"Unrelenting Deathknight",
				"Unrelenting Rider",
				"Spectral Trainee",
				"Spectral Deathknight",
				"Spectral Rider",
				"Spectral Horse"
			),
			"The Four Horsemen" => array(
				"Baron Rivendare",
				"Thane Korth'azz",
				"Sir Zeliek",
				"Lady Blaumeux"
			),
			"Noth the Plaguebringer" => array(
				"Noth the Plaguebringer",
				"Plagued Warrior",
				"Plagued Champion",
				"Plagued Guardian",
				"Plagued Construct"
			),
			"Loatheb" => array(
				"Loatheb",
			),
			"Kel'Thuzad" => array(
				"Kel'Thuzad",
				"Soldier of the Frozen Wastes",
				"Unstoppable Abomination",
				"Soul Weaver",
				"Guardian of Icecrown"
			),
			// Eye of Eternity
			"Malygos" => array(
				"Malygos",
				"Power Spark",
				"Nexus Lord",
				"Scion of Eternity",
			),
			// Vault of Archavon
			"Toravon the Ice Watcher" => array(
				"Toravon the Ice Watcher",
				"Frozen Orb",
			),
			"Emalon the Storm Watcher" => array(
				"Emalon the Storm Watcher",
				"Tempest Minion",
			),
			// The Obsidian Sanctum
			"Shadron" => array(
				"Shadron",
			),
			"Tenebron" => array(
				"Tenebron",
			),
			"Vesperon" => array(
				"Vesperon",
			),
			"Sartharion" => array(
				"Sartharion",
				//"Environment",
			),
			// Ulduar
			// Flame Leviathan? How to handle it?
			"Ignis the Furnace Master" => array(
				"Ignis the Furnace Master",
				"Forge Construct",
				//"Magma Rager",
				//"Molten Colossus",
			),
			"Razorscale" => array(
				"Razorscale",
				//"Dark Rune Guardian",
				//"Dark Rune Sentinel",
				//"Dark Rune Watcher",
			),
			"XT-002 Deconstructor" => array(
				"XT-002 Deconstructor",
				//"Parts Recovery Technician",
				//"XB-488 Disposalbot",
				//"XD-175 Compactobot",
				//"XR-949 Salvagebot",
				//"Life Spark",
				"Heart of the Deconstructor",
				"XS-013 Scrapbot",
				"XE-321 Boombot",
				"XM-024 Pummeler",
			),
			"Assembly of Iron" => array( // GROUP BOSS!
				"Steelbreaker",
				"Runemaster Molgeim",
				"Stormcaller Brundir",
			),
			"Kologarn" => array( // Kinda a group boss
				"Kologarn",
				"Left arm",
				"Right arm",
				//"Environment",
				"Rubble",
			),
			"Auriaya" => array(
				"Auriaya",
				"Sanctum Sentry",
				"Feral Defender",
			),
			"Mimiron" => array( // GROUP BOSS
				"Trash",
				"Mimiron",
				"Leviathan MKII",
				"VX-001",
				"Aerial Command Unit",
				"Assault Bot",
				"Trash Bot",
				"V-07-TR-0N",
				"Proximity Mine",
			),
			"Freya" => array(
				"Freya",
				"Elder Brightleaf",
				"Elder Stonebark",
				"Elder Ironbranch",
				"Storm Lasher",
				"Ancient Water Spirit",
				"Detonating Lasher",
				"Ancient Conservator",
			),
			"Thorim" => array(
				"Thorim",
				"Sif",
				"Jormungar Behemoth",
				"Dark Rune Acolyte",
				"Captured Mercenary Captain",
				"Captured Mercenary Soldiers",
				"Runic Colossus",
				"Ancient Rune Giant",
				"Dark Rune Warbringer",
				"Dark Rune Evoker",
				"Dark Rune Champion",
				"Dark Rune Commoner",
			),
			"Hodir" => array(
				"Hodir",
				//"Environment",
			),
			"General Vezax" => array(
				"General Vezax",
				//"Environment",
				"Saronite Vapors",
			),
			"Yogg-Saron" => array(
				"Yogg-Saron",
				"Guardian of Yogg-Saron",
				"Crusher Tentacle",
				"Corruptor Tentacle",
				"Constrictor Tentacle",
				"Laughing Skull",
				"Influence Tentacle",
				"Influence Tentacle Visual",
				"Brain of Yogg-Saron",
				"Immortal Guardian",
				"Marked Immortal Guardian",
				//"Environment",
			),
			"Algalon the Observer" => array(
				"Algalon the Observer",
				"Collapsing Star",
				"Living Constellation",
				"Black Hole",
				"Dark Matter",
				"Dark Matter Target",
				"Unleashed Dark Matter",
			),
			// Trial of the Crusader
			"Beasts of Northrend" => array( // GROUP BOSS!
				"Gormok the Impaler",
				"Snobold Vassal",
				"Acidmaw",
				"Dreadscale",
				"Icehowl",
				//"Environment",
			),
			"Lord Jaraxxus" => array(
				"Lord Jaraxxus",
				"Nether Portal",
				"Infernal Volcano",
				//"Environment",
				"Mistress of Pain",
				"Felflame Infernal",
			),
			"Faction Champions" => array( // GROUP BOSS!
				"Tyrius Duskblade",
				"Gorgrim Shadowcleave",
				"Kavina Grovesong",
				"Birana Stormhoof",
				"Melador Valestrider",
				"Erin Misthoof",
				"Alyssia Moonstalker",
				"Ruj'kah",
				"Noozle Whizzlestick",
				"Ginselle Blightslinger",
				"Velanaa",
				"Liandra Suncaller",
				"Baelnor Lightbearer",
				"Malithas Brightblade",
				"Anthar Forgemender",
				"Caiphus the Stern",
				"Brienna Nightfell",
				"Vivienne Blackwhisper",
				"Irieth Shadowstep",
				"Maz'dinah",
				"Saamul",
				"Thrakgar",
				"Shaabad",
				"Broln Stouthorn",
				"Serissa Grimdabbler",
				"Harkzog",
				"Zhaagrym",
				"Lioness",
				"Shocuul",
				"Narrhok Steelbreaker",
				//"Environment",
			),
			"Twin Val'kyr" => array( // GROUP BOSS!
				"Eydis Darkbane",
				"Fjola Lightbane",
				//"Environment",
				"Concentrated Light",
				"Concentrated Darkness",
			),
			"Anub'arak" => array(
				"Anub'arak",
				"Frost Sphere",
				"Nerubian Burrower",
				"Swarm Scarab",
			),
			// ICC
			"Lord Marrowgar" => array(
				"Lord Marrowgar",
				//"Environment",
				//"Bone Spike",
			),
			"Lady Deathwhisper" => array(
				"Lady Deathwhisper",
				"Environment",
				"Cult Adherent",
				"Empowered Adherent",
				"Reanimated Adherent",
				"Cult Fanatic",
				"Deformed Fanatic",
				"Reanimated Fanatic",
				"Vengeful Shade",
				"Reanimated Fanatic",
			),
			"Gunship Battle" => array(
				"Muradin Bronzebeard",
				"High Overlord Saurfang ",
				"Gunship Cannon",
				"Skybreaker Sorcerer",
				"Kor'kron Battle-Mage",
				"Skybreaker Mortar Soldier",
				"Kor'kron Rocketeer",
				"Skybreaker Sergeant",
				"Kor'kron Sergeant",
				"Skybreaker Marine",
				"Kor'kron Reaver",
				"Skybreaker Rifleman",
				"Kor'kron Axethrower",
				//"Environment",
			),
			"Deathbringer Saurfang" => array(
				"Deathbringer Saurfang",
				"Blood Beast",
				//"Environment",
			),
			"Festergut" => array(
				"Festergut",
				//"Environment",
			),
			"Rotface" => array(
				"Rotface",
				//"Environment",
				"Little Ooze",
				"Big Ooze",
			),
			"Professor Putricide" => array(
				"Professor Putricide",
				"Gas Cloud",
				//"Environment",
				"Growing Ooze Puddle",
				"Volatile Ooze",
				"Mutated Abomination",
				"Choking Gas",
				"Malleable Ooze Stalker",
				"Malformed Ooze",
				"Sticky Ooze",
				"Growing Ooze Puddle Trigger",
			),
			"Blood Prince Council" => array( // GROUP BOSS!
				"Prince Valanar",
				"Shock Vortex",
				//"Environment",
				"Prince Taldaram",
				"Flame Orb",
				"Prince Keleseth",
				"Kinetic Bomb",
				"Kinetic Bomb Target",
			),
			"Blood-Queen Lana'thel" => array(
				"Blood-Queen Lana'thel",
				//"Environment",
			),
			"Valithria Dreamwalker" => array( // GROUP BOSS / Not really dmg dependent
				"Valithria Dreamwalker",
				"Blazing Skeleton",
				"Blistering Zombie",
				"Risen Archmage",
				"Gluttonous Abomination",
				"Rot Worm",
				"Suppressor",
				//"Environment",
			),
			"Sindragosa" => array(
				"Sindragosa",
				//"Environment",
				//"Ice Tomb",
				
				//"Rimfang",
				//"Spinestalker",
			),	
			"The Lich King" => array(
				"The Lich King",
				//"Environment",
				"Drudge Ghoul",
				"Shambling Horror",
				"Shadow Trap",
				"Raging Spirit",
				"Val'kyr Shadowguard",
				"Vile Spirit",
				"Spirit Warden",
				"Defile",
			),
			// Ruby Sanctum
			"Halion" => array(
				"Halion",
				//"Environment",
				"Flame Orb",
				"Shadow Orb",
				"Combustion",
				"Consumption",
				"Living Inferno",
				"Living Ember",
			),
			"Saviana Ragefire" => array(
				"Saviana Ragefire",
				//"Environment",
			),
			"Baltharus the Warborn" => array(
				"Baltharus the Warborn",
				//"Environment",
			),
			"Baltharus the Warborn" => array(
				"Baltharus the Warborn",
				//"Environment",
				"Onyx Flamecaller",
			),
		);
		$bossToGroup = array(
			"Steelbreaker" => "Assembly of Iron",
			"Runemaster Molgeim" => "Assembly of Iron",
			"Stormcaller Brundir" => "Assembly of Iron",
			"Left arm" => "Kologarn",
			"Right arm" => "Kologarn",
			"Leviathan MKII" => "Mimiron",
			"VX-001" => "Mimiron",
			"Mimiron's Head" => "Mimiron",
			"Aerial Command Unit" => "Mimiron",
			"Assault Bot" => "Mimiron",
			"V-07-TR-0N" => "Mimiron",
			"Gormok the Impaler" => "Beasts of Northrend",
			"Acidmaw" => "Beasts of Northrend",
			"Dreadscale" => "Beasts of Northrend",
			"Icehowl" => "Beasts of Northrend",
			"Tyrius Duskblade" => "Faction Champions",
			"Gorgrim Shadowcleave" => "Faction Champions",
			"Kavina Grovesong" => "Faction Champions",
			"Birana Stormhoof" => "Faction Champions",
			"Melador Valestrider" => "Faction Champions",
			"Erin Misthoof" => "Faction Champions",
			"Alyssia Moonstalker" => "Faction Champions",
			"Ruj'kah" => "Faction Champions",
			"Noozle Whizzlestick" => "Faction Champions",
			"Ginselle Blightslinger" => "Faction Champions",
			"Velanaa" => "Faction Champions",
			"Liandra Suncaller" => "Faction Champions",
			"Baelnor Lightbearer" => "Faction Champions",
			"Malithas Brightblade" => "Faction Champions",
			"Anthar Forgemender" => "Faction Champions",
			"Caiphus the Stern" => "Faction Champions",
			"Brienna Nightfell" => "Faction Champions",
			"Vivienne Blackwhisper" => "Faction Champions",
			"Irieth Shadowstep" => "Faction Champions",
			"Maz'dinah" => "Faction Champions",
			"Saamul" => "Faction Champions",
			"Thrakgar" => "Faction Champions",
			"Shaabad" => "Faction Champions",
			"Broln Stouthorn" => "Faction Champions",
			"Serissa Grimdabbler" => "Faction Champions",
			"Harkzog" => "Faction Champions",
			"Zhaagrym" => "Faction Champions",
			"Lioness" => "Faction Champions",
			"Shocuul" => "Faction Champions",
			"Narrhok Steelbreaker" => "Faction Champions",
			"Eydis Darkbane" => "Twin Val'kyr",
			"Fjola Lightbane" => "Twin Val'kyr",
			"Prince Valanar" => "Blood Prince Council",
			"Prince Taldaram" => "Blood Prince Council",
			"Prince Keleseth" => "Blood Prince Council",
			"Blazing Skeleton" => "Valithria Dreamwalker",
			"Blistering Zombie" => "Valithria Dreamwalker",
			"Risen Archmage" => "Valithria Dreamwalker",
			"Gluttonous Abomination" => "Valithria Dreamwalker",
			"Rot Worm" => "Valithria Dreamwalker",
			"Suppressor" => "Valithria Dreamwalker",
			"Baron Rivendare" => "The Four Horsemen",
			"Thane Korth'azz" => "The Four Horsemen",
			"Sir Zeliek" => "The Four Horsemen",
			"Lady Blaumeux" => "The Four Horsemen",
 		);
		$GroupBoss = array(
			"Assembly of Iron" => 100000,
			"Kologarn" => 100001,
			"Mimiron" => 100002,
			"Beasts of Northrend" => 100003,
			"Faction Champions" => 100004,
			"Twin Val'kyr" => 100005,
			"Blood Prince Council" => 100006,
			"Valithria Dreamwalker" => 100007,
			"The Four Horsemen" => 100008,
		);
		$iii = 100009;
		
		//Fix attempt unknowns
		foreach($this->atmt as $k => $v){
			foreach($v as $key => $var){
				if (($var[0]=="Unknown" or $var[0]=="Unbekannt") && !empty($var[5])){
					foreach($var[5] as $ke => $va){
						$this->atmt[$k][$key][0] = $va[1];
						if (isset($this->instanceBosses[$npcsTra[$this->user[$va[1]][8]]]) or isset($this->instanceBosses[$va[1]]))
							break 1;
					}
				}
			}
		}
		
		foreach($this->atmt as $k => $v){
			// Fix LK attempts
			// Given there are more than one
			$moreLK = 0;
			foreach($v as $key => $var){
				if ($npcsTra[$this->user[$var[0]][8]] == "The Lich King")
					$moreLK++;
			}
			if ($moreLK>1){
				$lkdied = 0;
				foreach($v as $key => $var){
					foreach($var[5] as $ok => $pk){
						if ($npcsTra[$this->user[$pk[1]][8]] == "The Lich King"){
							$lkdied = intval($var[3]);
							// Remove all attempts until the real attempt is found
							foreach($v as $kk => $vv){
								if ($vv[0]=="Unknown" or $vv[0]=="Unbekannt" or $vv[0]==$pk[1]){
									if ($vv[4]==true && $vv[0]==$pk[1] && ($vv[3]-$vv[1])>=10){
										$this->atmt[$k][$kk][3] = $lkdied;
										$this->atmt[$k][$kk][4] = false;
										array_push($this->atmt[$k][$kk][5], $pk);
										break 1;
									}
									unset($this->atmt[$k][$kk]);
								}
							}
							break 2;
						}
					}
				}
			}
		}
		
		// Fix group boss not listed as killed bug
		foreach($this->atmt as $k => $v){
			foreach($v as $key => $var){
				if ($var[4]==false){
					//print "TEST 1 <br />";
					if ($this->in_array($bossToGroup, $npcsTra[$this->user[$var[0]][8]])){
						//print "TEST 2 <br />";
						$list = array();
						foreach($bossToGroup as $rr => $ee){
							if ($ee==$bossToGroup[$npcsTra[$this->user[$var[0]][8]]])
								array_push($list, $rr);
						}
						foreach($list as $rr){
							if (isset($npcsTraRev[$rr])){
								$inArrr = false;
								$name = $this->npcByEntry[$npcsTraRev[$rr]][8];
								foreach($var[5] as $qqq){
									if ($qqq[1]==$name){
										$inArrr = true;
										break 1;
									}
								}
								if (isset($name) && !$inArrr){
									array_push($this->atmt[$k][$key][5], array(0=>$var[3], 1=>$name));
									//print $rr." => ".$name."<br />";
								}
							}
						}
					}
				}
			}
		}
		
		// Fix Halion attempts Halion Controller
		foreach($this->atmt as $k => $v){
			foreach($v as $key => $var){
				if ($var[4]==false){
					foreach($var[5] as $qk => $qv){
						if ($npcsTra[$this->user[$qv[1]][8]]=="Halion Controller" || $qv[1]=="Halion Controller"){
							$this->atmt[$k][$key][5][$qk][1] = "Halion";
						}
					}
				}
			}
		}
		
		// Add living inferno and ember to Halion attempts
		/*foreach($this->atmt as $k => $v){
			foreach($v as $key => $var){
				if ($npcsTra[$this->user[$var[0]][8]]=="Halion"){
					// checking if those npcs where recorded
					if (isset($this->npcByEntry[40683])) // Living ember
						array_push($this->atmt[$k][$key][5], array(0=>$var[1]+1,1=>$this->npcByEntry[40683][8]));
					if (isset($this->npcByEntry[40684]))
						array_push($this->atmt[$k][$key][5], array(0=>$var[1]+1,1=>$this->npcByEntry[40684][8]));
					if (isset($this->npcByEntry[40681])) // Living ember
						array_push($this->atmt[$k][$key][5], array(0=>$var[1]+1,1=>$this->npcByEntry[40681][8]));
					if (isset($this->npcByEntry[40682]))
						array_push($this->atmt[$k][$key][5], array(0=>$var[1]+1,1=>$this->npcByEntry[40682][8]));
				}
			}
		}*/
		
		// Adding missing npcs to bossfights in general
		foreach($this->atmt as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[5])){
					$bossList = array();
					foreach($var[5] as $qk => $qv){
						$bossList[$npcsTra[$this->user[$qv[1]][8]]] = true;
					}
					foreach($bossBeginnArray as $qk => $qv){
						foreach($qv as $qkk => $qvv){
							if (isset($npcsTraRev[$qvv]) && $npcsTra[$this->user[$var[0]][8]]==$qk && !isset($bossList[$this->npcByEntry[$npcsTraRev[$qvv]][8]])){
								array_push($this->atmt[$k][$key][5], array(0=>$var[1]+1,1=>$this->npcByEntry[$npcsTraRev[$qvv]][8]));
							}
						}
					}
				}
			}
		}
		
		foreach($this->atmt as $k => $v){
			if (sizeOf($v)>0){
				$bool = false;
				foreach($v as $key => $var){
					if (!$bool){
						foreach($bossBeginnArray as $qk => $qv){
							if (isset($this->instanceBosses[$npcsTra[$this->user[$var[0]][8]]]) or isset($this->instanceBosses[$var[0]]) or in_array($npcsTra[$this->user[$var[0]][8]], $qv) or in_array($var[0], $qv))
								$bool = true;
							if (!$bool){
								foreach($var[5] as $ke => $va){
									if (isset($this->instanceBosses[$npcsTra[$this->user[$va[1]][8]]]) or isset($this->instanceBosses[$va[1]]) or $bool or in_array($npcsTra[$this->user[$va[1]][8]], $qv)){
										$bool = true;
										break 1;
									}
								}
							}
							if ($bool)
								break 1;
						}
					}else{
						break 1;
					}
				}
				if ($bool){
					$unknownArr = array();
					$unTime = "";
					foreach($v as $key => $var){
						if (((isset($var[0]) && ($var[0] != "Unknown" or $var[0] != "Unbekannt")) or (($var[0] == "Unknown" or $var[0] == "Unbekannt") && !empty($var[5])) or (empty($var[5]) && ($var[0] != "Unknown" or $var[0] != "Unbekannt"))) && $var){
							if (!isset($this->instanceStart[$k]) || $this->instanceStart[$k]>$var[1])
								$this->instanceStart[$k] = $var[1];
							$sub = array();
							
							foreach($var[5] as $pk => $ok){
								if (!isset($sub[$ok[1]][0]) || $sub[$ok[1]][0]>$ok[0])
									$sub[$ok[1]][0] = $ok[0];
								if (!isset($sub[$ok[1]][1]) || $sub[$ok[1]][1]<$ok[0])
									$sub[$ok[1]][1] = $ok[0];
							}
							
							foreach($bossBeginnArray as $qk => $qv){
								if (isset($qk) && $qk != "" && $qk != " "){
									$bool = false;
									foreach($sub as $pk => $ok){
										if (in_array($npcsTra[$this->user[$pk][8]], $qv)){
											$pk = $qk;
											if (!isset($sub[$pk][0]) || $sub[$pk][0]>$ok[0])
												$sub[$pk][0] = $ok[0];
											if (!isset($sub[$pk][1]) || $sub[$pk][1]<$ok[1])
												$sub[$pk][1] = $ok[1];
											$bool = true;
										}
									}
									//$var[0] = (isset($bossToGroup[$npcsRevTra[$var[0]]])) ? $bossToGroup[$npcsRevTra[$var[0]]] : $var[0];
									if (in_array($npcsTra[$this->user[$var[0]][8]], $qv)){
										$pk = $var[0];
										if (!isset($sub[$pk][0]) || $sub[$pk][0]>$var[1])
											$sub[$pk][0] = $var[1];
										if (!isset($sub[$pk][1]) || $sub[$pk][1]<$var[3])
											$sub[$pk][1] = $var[3];
										$bool = true;
									}
									$name = (isset($this->npcByEntry[$npcsTraRev[$qk]][8])) ? $this->npcByEntry[$npcsTraRev[$qk]][8] : $qk;
									if ($bool && !isset($this->user[$name])){ // May cause issues
										$this->user[$qk] = array(0=>($r = (isset($GroupBoss[$qk])) ? $GroupBoss[$qk] : $iii));
										$this->userById[($r = (isset($GroupBoss[$qk])) ? $GroupBoss[$qk] : $iii)] = array(0=>$qk);
										$iii++;
										break 1;
									}
								}
							}
								
							$bossend = 0;
							$bossname = "";
							foreach($sub as $pk => $ok){
								if ($ok){
									if ((isset($this->instanceBosses[$npcsTra[$this->user[$pk][8]]]) && !isset($GroupBoss[$npcsTra[$this->user[$pk][8]]])) or isset($bossToGroup[$npcsTra[$this->user[$pk][8]]])){
										if ($ok[1]>$bossend or $bossend == 0){
											$bossend = $ok[1];
											$bossname = (isset($bossToGroup[$npcsTra[$this->user[$pk][8]]])) ? $bossToGroup[$npcsTra[$this->user[$pk][8]]] : $pk; // May also cause issues
										}
									}
								}
							}
							foreach($sub as $pk => $ok){
								if ($ok){
									if (!isset($this->instanceBosses[$npcsTra[$this->user[$pk][8]]])){ // May cause issues, look ^
										if ($bossend==0)
											$sub[$pk][0] = $var[3];
									}
								}
							}
							if ($bossend>0 && $bossname != ""){
								// Boss Array
								$tname = array();
								$bossbeginn = $this->getBossBeginn($r = (isset($bossBeginnArray[$bossname])) ? $bossBeginnArray[$bossname] : array($this->user[$bossname][0]), $var[1]); // Here also issues
								$preBossTrash = array();
								$preBossBoss = null;
								foreach($sub as $pk => $ok){
									if (!isset($GroupBoss[$npcsTra[$this->user[$pk][8]]])){
										if ($ok[0]>=$bossbeginn){
											if (!in_array($pk, $tname))
												array_push($tname, $pk);
										}else{
											if (!isset($this->instanceBosses[$pk]) && !isset($this->instanceBosses[$npcsTra[$this->user[$pk][8]]])){ 
												if (!in_array($pk, $preBossTrash))
													array_push($preBossTrash, $pk);
											}else{
												$preBossBoss = $pk;
											}
										}
									}
								}
								
								// Trash after boss death
								foreach($tname as $pk => $ok){
									$sub[$ok] = null;
								}
								$tname = array();
								foreach($sub as $pk => $ok){
									if ($pk == $bossname){
										$sub[$bossname] = null;
									}else{
										if (!in_array($pk, $tname))
											array_push($tname, $pk);
									}
								}
								$var[3] = $this->getLatestPointInSub($sub, $var[3]);
								if ($var[3]>$bossend && $tname[0]){
									array_push($this->attempts, Array(
										1 => $k,
										2 => $tname[0],
										3 => $bossend,
										4 => $var[2],
										5 => $var[3],
										6 => true,
										7 => ($var[3] - $bossend),
										9 => ($r = (isset($var[4]) && $var[4] === true) ? true : false), // wipe
										10 => $tname
									));
								}
								
								if (!isset($GroupBoss[$bossname])){ // issues?
									if (!in_array($bossname, $tname))
										array_push($tname, $bossname);
								}
								
								$bypass = false;
								foreach($this->attempts as $uu){
									if ($uu[2]==$bossname){
										$bypass = true;
										break 1;
									}										
								}
								if (($bossend - $bossbeginn)>10){
									$bossInArray = false;
									foreach($var[5] as $qqqv){
										if ($qqqv[1]==$bossname or (isset($bossToGroup[$npcsTra[$this->user[$qqqv[1]][8]]]) && $bossToGroup[$npcsTra[$this->user[$qqqv[1]][8]]] == $bossname)){
											$bossInArray = true;
											break 1;
										}
									}
									array_push($this->attempts, Array(
										1 => $k,
										2 => $bossname,
										3 => $bossbeginn,
										4 => $var[2],
										5 => $bossend,
										6 => true,
										7 => ($bossend - $bossbeginn),
										9 => ($r = ((isset($var[4]) && $var[4] === true && !$bossInArray) or $bypass or ((isset($var[4]) && $var[4] === false && !$bossInArray))) ? true : false), // wipe
										10 => $tname
									));
									}
								
								if (isset($preBossTrash[0]) or $preBossBoss){
									array_push($this->attempts, Array(
										1 => $k,
										2 => $preBossTrash[0],
										3 => $var[1],
										4 => $var[2],
										5 => $bossbeginn,
										6 => true,
										7 => ($bossbeginn - $var[1]),
										9 => false, // wipe
										10 => $preBossTrash
									));
								}
							}else{
								// Some extra code for wipes at group bosses
								$tempBool = false;
								$var[3] = $this->getLatestPointInSub($sub, $var[3]);
								
								foreach($bossBeginnArray as $qk => $qv){
									if (isset($qk) && $qk != "" && $qk != " "){
										//$var[0] = (isset($bossToGroup[$npcsRevTra[$var[0]]])) ? $bossToGroup[$npcsRevTra[$var[0]]] : $var[0];
										if (in_array($npcsTra[$this->user[$var[0]][8]], $qv) || $this->checkArray($var[5], $qv, $npcsTra)){ // check array translation?
											$namees = array();
											foreach($qv as $qvq){
												if (!isset($GroupBoss[$npcsTra[$this->user[$qvq][8]]])){
													if (!in_array($qvq, $namees))
														array_push($namees, $qvq);
												}
											}
											$name = (isset($this->npcByEntry[$npcsTraRev[$qk]][8])) ? $this->npcByEntry[$npcsTraRev[$qk]][8] : $qk;
											if (!isset($this->user[$name])){
												$this->user[$qk] = array(0=>($r = (isset($GroupBoss[$npcsTra[$this->user[$qk][8]]])) ? $GroupBoss[$npcsTra[$this->user[$qk][8]]] : $iii));
												$this->userById[($r = (isset($GroupBoss[$npcsTra[$this->user[$qk][8]]])) ? $GroupBoss[$npcsTra[$this->user[$qk][8]]] : $iii)] = array(0=>$qk); // May cause issues
												$iii++;
											}
											if (($var[3] - $var[1])>10){
												array_push($this->attempts, Array(
													1 => $k,
													2 => $qk,
													3 => $var[1],
													4 => $var[2],
													5 => $var[3],
													6 => true,
													7 => ($var[3] - $var[1]),
													9 => true, // wipe
													10 => $namees
												));
											}
											$tempBool = true;
											break 1;
										}
									}
								}
								
								if (!$tempBool){
									if (isset($this->instanceBosses[$npcsTra[$this->user[$var[0]][8]]]))
										$bossbeginn = $this->getBossBeginn($r = (isset($bossBeginnArray[$npcsTra[$this->user[$var[0]][8]]])) ? $bossBeginnArray[$npcsTra[$this->user[$var[0]][8]]] : array($this->user[$var[0]][0]), $var[1]); // May also cause issues
									else
										$bossbeginn = $var[1];
									$namees = array();
									foreach($sub as $pk => $ok){
										if (!isset($GroupBoss[$npcsTra[$this->user[$pk][8]]])){
											if (!in_array($pk, $namees))
												array_push($namees, $pk);
										}
									}
									if (!isset($GroupBoss[$npcsTra[$this->user[$var[0]][8]]])){
										if (!in_array($var[0], $namees))
											array_push($namees, $var[0]);
									}
									$bypass = false;
									if (isset($this->instanceBosses[$npcsTra[$this->user[$var[0]][8]]])){
										foreach($this->attempts as $ke => $va){
											if ($va[1]==$var[0]){ // issues?
												$bypass = true;
												break 1;
											}
										}
										foreach($namees as $qqqv){
											if ($qqqv==$var[2] or (isset($bossToGroup[$npcsTraRev[$qqqv]]) && $bossToGroup[$npcsTraRev[$qqqv]] == $var[0]) or $qqqv==$npcsTraRev[$var[0]]){
												$bypass = true;
												break 1;
											}
										}
										if (sizeOf($namees)==0)
											$bypass = true;
									}
									if (!isset($this->instanceBosses[$npcsTra[$this->user[$var[0]][8]]]) or (isset($this->instanceBosses[$npcsTra[$this->user[$var[0]][8]]]) && ($var[3]-$bossbeginn)>=10)){
										array_push($this->attempts, Array(
											1 => $k,
											2 => $var[0],
											3 => $bossbeginn,
											4 => $var[2],
											5 => $var[3],
											6 => true,
											7 => ($var[3] - $bossbeginn),
											9 => ($r = ((isset($var[4]) && $var[4] === true) or $bypass) ? true : false), // wipe
											10 => $namees
										));
									}
								}
							}
						}else{
							if ($var[1]==1){
								foreach($var[5] as $pk => $ok){
									if (!in_array($ok[1], $unknownArr))
										array_push($unknownArr, $ok[1]);
								}
								$unTime = $var[2];
							}
						}
					}
					if (isset($unknownArr[0])){
						array_push($this->attempts, Array(
							1 => $k,
							2 => "Unknown",
							3 => 0,
							4 => $unTime,
							5 => 0,
							6 => true,
							7 => 1,
							9 => false, // wipe
							10 => $unknownArr
						));
					}
				}
			}
		}
	}
	
	private function sortAttemptsToNpc($npcTra){
		foreach($this->attempts as $k => $v){
			if (isset($v[2])){
				$this->attemptsWithNpcId[$k] = $v;
				//$q = $this->db->query('SELECT id, type FROM wotlk_npcs WHERE name = "'.$v[2].'"')->fetch();
				if (isset($this->user[$v[2]][8])){
					$this->attemptsWithNpcId[$k][2] = $this->user[$v[2]][8];
					$this->attemptsWithNpcId[$k][8] = (isset($this->instanceBosses[$npcTra[$this->user[$v[2]][8]]]) ? 1 : 0); // 1 => Boss
				}else{
					print "NOT FOUND => ".$v[2]."<br/>";
				}
			}
		}
	}
	
	private $resetByServer = array(
		10 => "Wednesday",
		11 => "Wednesday",
		12 => "Wednesday",
		13 => "Wednesday",
		14 => "Wednesday"
	);
	
	private function getLastReset($raidnameid, $serverid){
		return $this->resetByServer[$serverid];
	}
	
	private function returnStartTimeStamp($raidnameid, $serverid, $end){
		if (date("l") == $this->getLastReset($raidnameid, $serverid) && strtotime("today 03:00:00")<=$end){
			return strtotime("today 03:00:00");
		}
		if (($end-strtotime("last ".$this->getLastReset($raidnameid, $serverid)))>=50000){
			return $end-50000; // Preventing uploads that cause to corrupt the logs
		}else{
			return strtotime("last ".$this->getLastReset($raidnameid, $serverid));
		}
	}
	
	private function isNewLog($raidnameid, $end, $participants, $serverid){
		// If today were wednesday. What would last wednesday be? This or literally last wednesday?
		$now = time();
		if ($this->db->query('SELECT * FROM `wotlk-raids` WHERE nameid = "'.$raidnameid.'" AND tsstart BETWEEN "'.$this->returnStartTimeStamp($raidnameid, $serverid, $end).'" AND "'.$end.'"')->rowCount() > 0){
			//print "Test";
			foreach($this->db->query('SELECT a.id as rid, b.tanks, b.dps, b.healers FROM `wotlk-raids` a LEFT JOIN `wotlk-raids-participants` b ON a.id = b.rid WHERE nameid = "'.$raidnameid.'" AND tsstart BETWEEN "'.$this->returnStartTimeStamp($raidnameid, $serverid, $end).'" AND "'.$end.'"') as $row){
				$arr = explode(",", $row->tanks.$row->dps.$row->healers);
				$attempts = array();
				$attemptsWithIds = array();
				$extraTime = $this->getExtraTime($row->rid, null, $raidnameid);
				foreach($this->db->query('SELECT a.id,a.npcid,a.cbtend,a.rid,a.cbt,a.type,c.type,b.nameid,c.type as boss,a.time FROM `wotlk-raids-attempts` a LEFT JOIN `wotlk-raids` b ON a.rid = b.id LEFT JOIN npcs c ON a.npcid = c.id WHERE a.rid = '.$row->rid) as $q){
					// Getting the next attempt id judging by npcid and combat time
					$aid = 0; $lastCBT = -1;
					foreach($this->attemptsWithNpcId as $k => $v){ // attempt id // array(1=>Instance, 2=>npcid,3=>bossbeginn,4=>TimeString,5=>cbtent,6=>wipe?,7=>duration,8=>isBoss?,9=>wipe?,10=>namearr);
						if ($v[2]==$q->npcid){
							$tsss = $this->GetRealTS(strtotime($v[4]), $now);
							if (($lastCBT == -1 || abs($tsss-$q->time)<=$lastCBT)){
								$aid = $k;
								$lastCBT = abs($tsss-$q->time);
							}
						}
					}
					
					if ($lastCBT != -1 && $lastCBT<=300){
						$attempts[$aid] = $q->id;
						$attemptsWithIds[$aid] = Array(
							1 => $q->id,
							2 => $q->rid,
							3 => $q->npcid,
							4 => $q->cbt+$extraTime,
							5 => $q->cbtend+$extraTime,
							6 => $q->type,
							7 => $q->boss,
							8 => $q->nameid,
							9 => date("H:i", $q->time)
						);
					}
				}
				$count = 0;
				foreach($participants as $k => $v){
					if ($v && $v != ""){
						if (in_array($v, $arr)){
							$count += 1;
						}
						if ($count >= 10){
							return array(1 => $row->rid, 2=> $attempts, 3 => $attemptsWithIds);
						}
					}
				}
			}
		}
		return array(1 => 0, 2 => array(), 3 => array());
	}
	
	private function getGuild(){
		$num = 0;
		$t = array();
		foreach($this->participantKeys as $k => $v){
			if (isset($this->userById[$v][6]) && $this->userById[$v][6] != "" && $this->userById[$v][6] != " "){
				$name = $this->userById[$v][6];
				if (!isset($t[$name]))
					$t[$name] = 0;
				$t[$name] += 1;
				$num++;
			}
		}
		foreach($t as $k => $v){
			if ($k){
				if ($v>floor($num*0.7))
					return $k;
			}
		}
		return "PugRaid";
	}
	
	private function getServerId(){
		if ($this->pinfo[3]=="Algalon - Main Realm")
			$this->pinfo[3] = "Algalon";
		if ($this->pinfo[3]=="Legacy - Instant 80")
			$this->pinfo[3] = "Legacy";
		$id = $this->db->query('SELECT id FROM servernames WHERE expansion = 2 AND name = "'.$this->pinfo[3].'"')->fetch()->id;
		if (!$id)
			$id = 1;
		return $id;
	}
	
	private function getTimeStamp($v1, $v2){
		$const = time() + 43200;
		$time = strtotime($v1);
		$t2 = strtotime($v2);
		if ($const<$time)
			$time = strtotime("yesterday ".$v1);
		if ($const<$t2)
			$t2 = strtotime("yesterday ".$v2);
		if ($time>$t2)
			$t2 = strtotime($v2);
		return array(1 => $time, 2 => $t2);
	}
	
	private function GetRealTS($ts, $now){
		if ($ts>$now)
			return strtotime("yesterday ".date("H:i:s", $ts));
		return $ts;
	}
	
	private function getTses($kk, $serverid, $now){
		$min = null; $max = null;
		$atmtsize = sizeOf($this->atmt[$kk]);
		if ($atmtsize==1){
			$min = $this->GetRealTS(strtotime($this->atmt[$kk][0][2]), $now);
			$max = $min + $this->cbt["total"];
			return array(1 => ceil($min), 2 => ceil($max));
		}
		
		$min = $this->GetRealTS(strtotime($this->atmt[$kk][$atmtsize-1][2]), $now);
		$max = $this->GetRealTS(strtotime($this->atmt[$kk][0][2])+($this->atmt[$kk][0][3]-$this->atmt[$kk][0][1]), $now);
		if (abs($max-$min)>37000){
			// Case 1: min>max
			if ($min>$max)
				$max += 86400;
			// Case 2: One of them is in the future
			if (($min>$now || $max>$now) && ($now-time())<=86400)
				return $this->getTses($kk, $serverid, $now+600);
			// something went wrong
			if (abs($max-$min)>37000)
				return array(1 => ceil($min), 2 => ceil($min + $this->cbt["total"]));
		}
		return array(1 => ceil($min), 2 => ceil($max));
	}
	
	private function getAttemptIdByCBTTime($cbt, $attemptsWithDbId, $npcs, $npcsTra){
		$last = 0;
		$delta = null;
		foreach($attemptsWithDbId as $k => $v){
			if (isset($this->instanceBosses[$npcsTra[$npcs[$v[3]]]]) && ($v[11]===1 or $v[11]=="1")){
				if (!$delta || $delta>abs($v[5]-$cbt+10)){
					$last = $v[1];
					$delta = abs($v[5]-$cbt+10);
				}
			}
		}
		return $last;
	}
	
	private function getLootArray($attempts, $npcs, $npcsTra){
		$t = array();
		foreach($this->loot as $k => $v){
			foreach($v as $ke => $va){
				$key = $this->getAttemptIdByCBTTime($va[0], $attempts, $npcs, $npcsTra);
				if ($key != 0){
					if (!isset($t[$key]))
						$t[$key] = array();
					array_push($t[$key], array(1 => $va[1], 2 => $this->user[$va[3]][0]));
				}
			}
		}
		return $t;
	}
	
	// Would have to replace this later with the updated ids
	private $QQraidBosses = array(
		14 => array(
			18728 => true,
		),
		15 => array(
			17711 => true,
		),
		16 => array(
			22887 => true,
			22898 => true,
			22841 => true,
			22871 => true,
			22948 => true,
			50003 => true, // Reliquary of Souls
			22947 => true,
			23426 => true, // The ilidari Council Id 23426
			22917 => true,
		),
		17 => array(
			21216 => true,
			21217 => true,
			21215 => true,
			21214 => true,
			21213 => true,
			21212 => true,
		),
		18 => array(
			15550 => true,
			50001 => true, //Opera event
			15687 => true,
			16457 => true,
			15691 => true,
			15688 => true,
			16524 => true,
			15689 => true,
			15690 => true,
			17225 => true,
		),
		19 => array(
			18831 => true,
			19044 => true,
		),
		20 => array(
			19703 => true,
		),
		21 => array(
			23576 => true,
			23578 => true,
			23574 => true,
			23577 => true,
			24239 => true,
			23863 => true,
		),
		22 => array(
			19514 => true,
			19516 => true,
			18805 => true,
			19622 => true,
		),
		23 => array(
			17767 => true,
			17808 => true,
			17888 => true,
			17842 => true,
			17968 => true,
		),
		24 => array(
			24850 => true,
			24882 => true,
			25038 => true,
			50000 => true, // Eredar Twins
			25741 => true,
			25608 => true,
		),
	);
	
	private $extraTimeArray = array();
	private function getExtraTime($isMerge, $nameid, $othernameid){
		if (isset($this->extraTimeArray[$isMerge][$othernameid])){
			return $this->extraTimeArray[$isMerge][$othernameid];
		}elseif (isset($this->extraTimeArray[$isMerge][$nameid])){
			return $this->extraTimeArray[$isMerge][$nameid];
		}else{
			$extraTime = 0;
			// Gettings first boss id
			$firstBoss = 0; $fbTime = 0; $fbId = 0;
			foreach($this->attemptsWithNpcId as $k => $v){
				if (($fbTime == 0 or $fbTime>$v[3]) && $v[8] == 1){
					$fbTime = $v[3];
					$firstBoss = $v[2];
					$fbId = $k;
				}
			}
			// Checking if he already exists
			if ($firstBoss != 0 && $isMerge){
				$q = $this->db->query('SELECT cbt FROM `wotlk-raids-attempts` WHERE npcid = "'.$firstBoss.'" AND rid = "'.$isMerge.'" AND rdy = 1 ORDER BY cbt DESC LIMIT 1')->fetch();
				// If it exists what is the difference
				// If it does not exist what is the last killed boss then in the db?
				if (isset($q->cbt)){
					if (($q->cbt-$fbTime)>=20)
						$extraTime = $q->cbt-$fbTime + 20;
				}else{
					// Gettings last killed boss
					$qq = $this->db->query('SELECT a.cbt, b.name, a.npcid FROM `wotlk-raids-attempts` a LEFT JOIN wotlk_npcs b ON a.npcid = b.id WHERE a.rid = "'.$isMerge.'" AND b.type = 1 AND a.rdy = 1 ORDER BY a.cbt DESC LIMIT 1')->fetch();
					if (isset($qq->cbt)){
						// Check if the boss is before or after the first boss
						if (!isset($nameid)){
							$offset = array_search($firstBoss, array_keys($this->QQraidBosses[$othernameid]));
							$offset2 = array_search($qq->npcid, array_keys($this->QQraidBosses[$othernameid]));							
						}else{
							$offset = array_search($firstBoss, array_keys($this->QQraidBosses[$nameid[$fbId][8]]));
							$offset2 = array_search($qq->npcid, array_keys($this->QQraidBosses[$nameid[$fbId][8]]));
						}
						if ($offset>$offset2){
							if (($qq->cbt-$fbTime)>=20)
								$extraTime = $qq->cbt-$fbTime + 20;
						}
					}
				}
			}
			if ($isMerge){
				if (!isset($nameid)){
					$this->extraTimeArray[$isMerge][$othernameid] = $extraTime;
				}else{
					$this->extraTimeArray[$isMerge][$nameid] = $extraTime;
				}
			}
			return $extraTime;
		}
	}
	
	private function BossesAreBefore($nameid, $isMerge, $othernameid, $lastboss){
		if (isset($nameid) or isset($othernameid)){
			$qq = $this->db->query('SELECT a.cbt, b.name, a.npcid FROM `wotlk-raids-attempts` a LEFT JOIN wotlk_npcs b ON a.npcid = b.id WHERE a.rid = "'.$isMerge.'" AND b.type = 1 AND a.rdy = 1 ORDER BY a.cbt LIMIT 1')->fetch();
			//$LB = $this->db->query('SELECT name FROM wotlk_npcs WHERE id = '.$lastboss)->fetch()->name;
			//print $LB."<br />";
			if (!isset($nameid)){
				$offset = array_search($lastboss, array_keys($this->QQraidBosses[$othernameid]));
				$offset2 = array_search($qq->npcid, array_keys($this->QQraidBosses[$othernameid]));							
			}else{
				$offset = array_search($lastboss, array_keys($this->QQraidBosses[$nameid]));
				$offset2 = array_search($qq->npcid, array_keys($this->QQraidBosses[$nameid]));
			}
			if ($offset<$offset2){
				return true;
			}
		}
		return false;
	}
	
	// Have to find a point to add to
	// i.E: If Boss A-C has been uploaded and then D-Z with a new reset it has to add on to it
	private $alreadyUpdatedNameIds = array();
	private function getGraphStrings($arr, $isMerge, $nameid, $othernameid){
		$newArr = array();
		$raidsById = array(
			14 => "Hellfire Peninsula",
			15 => "Shadowmoon Valley",
			16 => "Black Temple",
			17 => "Serpentshrine Cavern",
			18 => "Karazhan",
			19 => "Gruul's Lair",
			20 => "Magtheridon's Lair",
			21 => "Zul'Aman",
			22 => "The Eye",
			23 => "Hyjal Summit",
			24 => "Sunwell Plateau",
		);
		$extraTime = $this->getExtraTime($isMerge, $nameid, $othernameid);
		if ($isMerge){
			// Exception if bosses are added before the first boss. Increase the time of the existing logs based on max time of added log.
			// i.E. Second half was uploaded and first half is being merged.
			// Update those only once!
			if (!isset($this->alreadyUpdatedNameIds[$isMerge])){
				$lastboss = 0; $beforeTime = 0;
				foreach($this->attemptsWithNpcId as $k => $v){
					if ($v[8]==1){
						$lastboss = $v[2];
						$beforeTime = $v[5];
						break 1;
					}
				}
				if ($lastboss>0){
					if ($this->BossesAreBefore($nameid, $isMerge, $othernameid, $lastboss)){
						// Update those graphes now
						$cbtstart = array();
						$cbtend = array();
						$rnid = (isset($nameid)) ? $raidsById[$nameid] : $raidsById[$othernameid];
						foreach($this->db->query('SELECT a.* FROM `wotlk-raids-graph-individual-dmgdone` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE b.rid = '.$isMerge) as $row){
							$t1 = explode(",", $row->time);
							$newTimeString = '';
							foreach($t1 as $qqq => $kkk){
								if (isset($kkk) && $kkk != ''){
									if (!isset($cbtstart[$row->attemptid]) or $cbtstart[$row->attemptid]>(intval($kkk)+$beforeTime))
										$cbtstart[$row->attemptid] = (intval($kkk)+$beforeTime-$this->instanceStart[$rnid]);
									if (!isset($cbtend[$row->attemptid]) or $cbtend[$row->attemptid]<(intval($kkk)+$beforeTime))
										$cbtend[$row->attemptid] = (intval($kkk)+$beforeTime-$this->instanceStart[$rnid]);
									$newTimeString .= (intval($kkk)+$beforeTime-$this->instanceStart[$rnid]).',';
								}else{
									$newTimeString .= ',';
								}
							}
							$this->db->query('UPDATE `wotlk-raids-graph-individual-dmgdone` SET time = "'.$newTimeString.'" WHERE id = '.$row->id);
						}
						foreach($this->db->query('SELECT a.* FROM `wotlk-raids-graph-individual-dmgtaken` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE b.rid = '.$isMerge) as $row){
							$t1 = explode(",", $row->time);
							$newTimeString = '';
							foreach($t1 as $qqq => $kkk){
								if (isset($kkk) && $kkk != ''){
									$newTimeString .= (intval($kkk)+$beforeTime-$this->instanceStart[$rnid]).',';
								}else{
									$newTimeString .= ',';
								}
							}
							$this->db->query('UPDATE `wotlk-raids-graph-individual-dmgtaken` SET time = "'.$newTimeString.'" WHERE id = '.$row->id);
						}
						foreach($this->db->query('SELECT a.* FROM `wotlk-raids-graph-individual-healingreceived` a LEFT JOIN `wotlk-raids-attempts` b ON a.attemptid = b.id WHERE b.rid = '.$isMerge) as $row){
							$t1 = explode(",", $row->time);
							$newTimeString = '';
							foreach($t1 as $qqq => $kkk){
								if (isset($kkk) && $kkk != ''){
									$newTimeString .= (intval($kkk)+$beforeTime-$this->instanceStart[$rnid]).',';
								}else{
									$newTimeString .= ',';
								}
							}
							$this->db->query('UPDATE `wotlk-raids-graph-individual-healingreceived` SET time = "'.$newTimeString.'" WHERE id = '.$row->id);
						}
						foreach($cbtstart as $k => $v){
							$this->db->query('UPDATE `wotlk-raids-attempts` SET cbt = "'.$v.'", cbtend = "'.$cbtend[$k].'", duration = "'.($cbtend[$k]-$v).'" WHERE id = '.$k);
						}
						$this->alreadyUpdatedNameIds[$isMerge] = true;
					}
				}
			}
			if ($extraTime > 0){
				$rnid = (isset($nameid)) ? $raidsById[$nameid] : $raidsById[$othernameid];
				foreach($arr as $k => $v){
					foreach($v as $key => $var){
						$newArr[$k][$key+$extraTime-$this->instanceStart[$rnid]] = $var;
					}
				}
			}
		}
		if (!empty($newArr)){
			$u = $newArr;
		}else{
			$u = $arr;
		}
		
		$t = array();
		foreach($u as $k => $v){
			$num = sizeOf($v);
			$coeff = floor($num/100);
			if ($coeff >= 2){
				$ltime = 0; $lam = 0; $i = 0;
				foreach($v as $key => $var){
					if ($i == $coeff){
						$t[$k][$ltime] = $lam;
						$ltime = 0; $lam = 0; $i = 0;
					}else{
						if ($ltime == 0)
							$ltime = $key;
						else
							$ltime = ($ltime+$key)/2;
						$lam += $var;
						$i++;
					}
					
				}
			}else{
				$t[$k] = $v;
			}
			if (isset($t[$k]))
				ksort($t[$k]);
		}
		
		$p = array();
		if (isset($t)){
			foreach($t as $k => $v){
				if (isset($v)){
					foreach($v as $key => $var){
						$ptime = $key;
						$instance = $this->getInstanceId($key);
						$istartCBT = $this->instanceStart[$instance];
						if ($isMerge && $extraTime==0)
							$istartCBT = 0;
						if (($key-$istartCBT)>=0){
							$ptime = $key-$istartCBT;
						}
						if (!isset($p[$k])){
							$p[$k] = array(1=>round($ptime, 2),2=>round($var, 2));
						}else{
							$p[$k][1] .= ",".round($ptime, 2);
							$p[$k][2] .= ",".round($var, 2);
						}
					}
				}
			}
		}
		return $p;
	}
	
	
	// Have to find a common point and start from there on
	private function mergeGraphs($q, $v){
		$oldTimes = explode(",", $q->time);
		$oldAmounts = explode(",", $q->amount);
		$newTimes = explode(",", $v[1]);
		$newAmounts = explode(",", $v[2]);
		
		$old = array();
		foreach($oldTimes as $k => $v){
			$old[$v] = $oldAmounts[$k];
		}
		ksort($old);
		
		foreach($old as $k => $v){
			foreach ($newTimes as $key => $var){
				if (($k+0.5)>=$var && ($k-0.5)<=$var){
					$old[$k] = ($old[$k]+$newAmounts[$key])/2;
				}
			}
		}
		$timesString = ""; $amountsString = "";
		foreach ($old as $k => $v){
			$timesString .= $k.",";
			$amountsString .= $v.",";
		}
		return array(1=>$timesString, 2=>$amountsString);
	}
	
	// do sth against corrupted logs
	private $supersuperstate = true;
	private function writeIntoDB($spells, $npcs, $npcsById, $npcsTra, $npcRevTra, $spellsTra, $spellsRevTra, $cronid, $spellsRaw){
		$classes = array(
			"warrior" => 1,
			"rogue" => 2,
			"priest" => 3,
			"hunter" => 4,
			"druid" => 5,
			"mage" => 6,
			"warlock" => 7,
			"paladin" => 8,
			"shaman" => 9,
			"deathknight" => 10,
		);
		$classesReverse = array(
			1 => "warrior",
			2 => "rogue",
			3 => "priest",
			4 => "hunter",
			5 => "druid",
			6 => "mage",
			7 => "warlock",
			8 => "paladin",
			9 => "shaman",
			10 => "deathknight"
		);
		$realmtype = array(
			-1 => array(
				0 => 1,
				1 => 1,
				2 => 1,
				3 => 2,
				4 => 2,
				5 => 1,
				6 => 2,
				7 => 2,
				8 => 1,
				9 => 2
			),
			1 => array(
				0 => 1,
				1 => 1,
				2 => 1,
				3 => 2,
				4 => 2,
				5 => 2,
				6 => 2,
				7 => 2,
				8 => 2,
				9 => 2
			)
		);
		$raids = array( // That is only valid for Frostmourne?
			"Onyxia's Lairx1" => 25, // 10 
			"Onyxia's Lairx2" => 26, // 25
			"Naxxramasx1" => 27, // 10
			"Naxxramasx2" => 28, // 25
			"The Eye of Eternityx1" => 29, // 10
			"The Eye of Eternityx2" => 30, // 25
			"Vault of Archavonx1" => 31, // 10
			"Vault of Archavonx2" => 32, // 25
			"The Obsidian Sanctumx1" => 33, // 10
			"The Obsidian Sanctumx2" => 34, // 25
			"Ulduarx1" => 35, // 10
			"Ulduarx2" => 36, // 25
			"Trial of the Crusaderx1" => 37, // 10
			"Trial of the Crusaderx2" => 38, // 25
			"Trial of the Crusaderx3" => 39, // 10 HC
			"Trial of the Crusaderx4" => 40, // 25 HC
			"Icecrown Citadelx1" => 41, // 10
			"Icecrown Citadelx2" => 42, // 25
			"Icecrown Citadelx3" => 43, // 10 HC
			"Icecrown Citadelx4" => 44, // 25 HC
			"The Ruby Sanctumx1" => 45, // 10
			"The Ruby Sanctumx2" => 46, // 25
			"The Ruby Sanctumx3" => 47, // 10
			"The Ruby Sanctumx4" => 48, // 25 HC
			
			// German
			"Onyxias Hortx1" => 25, // 10 
			"Onyxias Hortx2" => 26, // 25
			"Naxxramasx1" => 27, // 10
			"Naxxramasx2" => 28, // 25
			"Das Auge der Ewigkeitx1" => 29, // 10
			"Das Auge der Ewigkeitx2" => 30, // 25
			"Archavons Kammerx1" => 31, // 10
			"Archavons Kammerx2" => 32, // 25
			"Das Obsidiansanktumx1" => 33, // 10
			"Das Obsidiansanktumx2" => 34, // 25
			"Ulduarx1" => 35, // 10
			"Ulduarx2" => 36, // 25
			"Prüfung des Kreuzfahrersx1" => 37, // 10
			"Prüfung des Kreuzfahrersx2" => 38, // 25
			"Prüfung des Kreuzfahrersx3" => 39, // 10 HC
			"Prüfung des Kreuzfahrersx4" => 40, // 25 HC
			"Eiskronenzitadellex1" => 41, // 10
			"Eiskronenzitadellex2" => 42, // 25
			"Eiskronenzitadellex3" => 43, // 10 HC
			"Eiskronenzitadellex4" => 44, // 25 HC
			"Das Rubinsanktumx1" => 45, // 10
			"Das Rubinsanktumx2" => 46, // 25
			"Das Rubinsanktumx3" => 47, // 10
			"Das Rubinsanktumx4" => 48, // 25 HC
		);
		/*// Delete all (temporary) 
		$this->db->query('DELETE FROM `wotlk-immortal-runs`');
		$this->db->query('DELETE FROM `wotlk-raids-newbuffs`');
		$this->db->query('DELETE FROM `wotlk-raids-newdebuffs`');
		$this->db->query('DELETE FROM `wotlk-raids`;');
		$this->db->query('DELETE FROM `wotlk-raids-attempts`;');
		//$this->db->query('DELETE FROM `wotlk-raids-buffs`;');
		$this->db->query('DELETE FROM `wotlk-raids-deaths`;');
		//$this->db->query('DELETE FROM `wotlk-raids-debuffs`;');
		$this->db->query('DELETE FROM `wotlk-raids-dispels`;');
		//$this->db->query('DELETE FROM `wotlk-raids-dmgdonetofriendly`;');
		$this->db->query('DELETE FROM `wotlk-raids-interruptsmissed`;');
		$this->db->query('DELETE FROM `wotlk-raids-loot`;');
		$this->db->query('DELETE FROM `wotlk-raids-participants`;');
		$this->db->query('DELETE FROM `wotlk-raids-records`;');
		$this->db->query('DELETE FROM `wotlk-raids-uploader`;');
		$this->db->query('DELETE FROM `wotlk-rankings`;');
		$this->db->query('DELETE FROM `wotlk-speed-kills`;');
		$this->db->query('DELETE FROM `wotlk-speed-runs`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-buffs`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-debuffsbyplayer`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-death`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-debuffs`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-dmgdonetoenemy`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-dmgdonebyability`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-dmgtakenfromability`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-dmgtakenbyplayer`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-dmgtakenfromsource`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-healingbyability`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-healingtofriendly`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-interrupts`;');
		$this->db->query('DELETE FROM `wotlk-raids-individual-procs`;');
		$this->db->query('DELETE FROM `chars`;');
		$this->db->query('DELETE FROM `contributors`;');
		$this->db->query('DELETE FROM `guilds`;');
		$this->db->query('DELETE FROM `wotlk-raids-graph-individual-dmgdone`');
		$this->db->query('DELETE FROM `wotlk-raids-graph-individual-friendlyfire`');
		$this->db->query('DELETE FROM `wotlk-raids-graph-individual-dmgtaken`');
		$this->db->query('DELETE FROM `wotlk-raids-graph-individual-healingreceived`');
		$this->db->query('DELETE FROM `wotlk-raids-casts`');
		// TEMPORARY*/

		//$this->db->query('SET NAMES latin1');
		
		$guildsByKeys = array();
		$guildname = $this->getGuild();
		$serverid = $this->getServerId(); 
		if ($guildname=="PugRaid"){
			if ($this->db->query('SELECT id FROM guilds WHERE name = "'.$guildname.'" AND serverid = "'.$serverid.'" AND faction = "'.$this->pinfo[2].'"')->rowCount() == 0)
				$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$guildname.'", "'.$serverid.'", "'.$this->pinfo[2].'")'); // Just to be on the save site
			$guildid = $this->db->query('SELECT id FROM guilds WHERE name = "'.$guildname.'" AND serverid = '.$serverid.' AND faction = "'.$this->pinfo[2].'"')->fetch()->id;
			if (isset($this->pinfo[4]) && $this->pinfo[4] != "" && $this->pinfo[4] != " " && $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->pinfo[4].'" AND serverid = "'.$serverid.'" AND faction = "'.$this->pinfo[2].'"')->rowCount() == 0)
				$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$this->pinfo[4].'", "'.$serverid.'", "'.$this->pinfo[2].'")'); // Just to be on the save site
			$this->pinfo[5] = $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->pinfo[4].'" AND serverid = '.$serverid)->fetch()->id;
		}else{
			if ($this->db->query('SELECT id FROM guilds WHERE name = "'.$guildname.'" AND serverid = "'.$serverid.'"')->rowCount() == 0)
				$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$guildname.'", "'.$serverid.'", "'.$this->pinfo[2].'")'); // Just to be on the save site
			$guildid = $this->db->query('SELECT id FROM guilds WHERE name = "'.$guildname.'" AND serverid = '.$serverid)->fetch()->id;
			if (isset($this->pinfo[4]) && $this->pinfo[4] != "" && $this->pinfo[4] != " " && $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->pinfo[4].'" AND serverid = "'.$serverid.'"')->rowCount() == 0)
				$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$this->pinfo[4].'", "'.$serverid.'", "'.$this->pinfo[2].'")'); // Just to be on the save site
			$this->pinfo[5] = $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->pinfo[4].'" AND serverid = '.$serverid)->fetch()->id;
		}
		if ($this->db->query('SELECT id FROM chars WHERE name = "'.$this->pinfo[0].'" AND serverid = "'.$serverid.'"')->rowCount() == 0)
			$this->db->query('INSERT INTO chars (name, classid, faction, guildid, serverid) VALUES ("'.$this->pinfo[0].'", "'.$classes[strtolower($this->pinfo[1])].'", "'.$this->pinfo[2].'", "'.($r = (isset($this->pinfo[5])) ? $this->pinfo[5] : 0).'", "'.$serverid.'")'); // Just to be on the save site
		$pid = $this->db->query('SELECT id FROM chars WHERE name = "'.$this->pinfo[0].'" AND serverid = "'.$serverid.'"')->fetch()->id;
		
		$charsByKey = array();
		foreach($this->participantKeys as $k => $v){
			// guilds
			if (isset($this->userById[$v][6]) && $this->userById[$v][6]!="" && $this->userById[$v][6]!=" "){
				if ($this->db->query('SELECT id FROM guilds WHERE name = "'.$this->userById[$v][6].'" AND serverid = "'.$serverid.'"')->rowCount() == 0)
					$this->db->query('INSERT INTO guilds (name, serverid, faction) VALUES ("'.$this->userById[$v][6].'", "'.$serverid.'", "'.$this->pinfo[2].'")');
				$guildsByKeys[$v] = $this->db->query('SELECT id FROM guilds WHERE name = "'.$this->userById[$v][6].'" AND serverid = '.$serverid)->fetch()->id;
			}
			// chars
			if (!$npcs[$v] && $this->userById[$v][3]===false && $this->userById[$v][0]!="Unknown" && $this->userById[$v][0]!="Unbekannt" && !strpos($this->userById[$v][0], "'s Minion")){
				$q = $this->db->query('SELECT id, classid, guildid FROM chars WHERE name = "'.$this->userById[$v][0].'" AND serverid = "'.$serverid.'" AND ownerid = 0');
				$f = $q->fetch();
				//print $this->userById[$v][1]."HAS GOTTEN HERE<br />";
				if ($q->rowCount() == 0){
					$this->db->query('INSERT INTO chars (name, classid, faction, guildid, serverid, ownerid) VALUES ("'.$this->userById[$v][0].'", "'.($r = (isset($this->userById[$v][1])) ? $classes[$this->userById[$v][1]] : 0).'", "'.$this->userById[$v][2].'", "'.($r = (isset($guildsByKeys[$v])) ? $guildsByKeys[$v] : 0).'", "'.$serverid.'", "0")');
					$charsByKey[$v] = $this->db->query('SELECT id FROM chars WHERE name = "'.$this->userById[$v][0].'" AND serverid = "'.$serverid.'" AND ownerid = 0')->fetch()->id;
				}else{
					if ($f->classid != 0 && intval($classes[$this->userById[$v][1]]) != 0 && $f->classid != intval($classes[$this->userById[$v][1]])){
						// If the character changes everything has to be cleared
						$this->db->query('DELETE FROM `wotlk-rankings` WHERE charid = "'.$f->id.'";'); // need to adjust this as well
						$this->db->query('DELETE FROM `armory` WHERE charid = "'.$f->id.'";');
						$this->db->query('DELETE FROM `armory-itemsets-tbc` WHERE charid = "'.$f->id.'";');
						$this->db->query('DELETE FROM `armory-guildhistory` WHERE charid = "'.$f->id.'";');
						$this->db->query('DELETE FROM `armory-itemhistory` WHERE charid = "'.$f->id.'";');
						$this->db->query('UPDATE `chars` SET classid = "'.intval($classes[$this->userById[$v][1]]).'" WHERE id = "'.$f->id.'";');
					}
					if ($f->classid == 0 && $f->classid != intval($classes[$this->userById[$v][1]]))
						$this->db->query('UPDATE chars SET classid = "'.$classes[$this->userById[$v][1]].'" WHERE name = "'.$this->userById[$v][0].'" AND serverid = "'.$serverid.'" AND ownerid = 0');
					if ($f->guildid == 0 && $f->guildid != intval($guildsByKeys[$v]) && intval($guildsByKeys[$v]) != 0)
						$this->db->query('UPDATE chars SET guildid = "'.$guildsByKeys[$v].'" WHERE name = "'.$this->userById[$v][0].'" AND serverid = "'.$serverid.'"');
					$charsByKey[$v] = $f->id;
				}
			}
		}
		
		$knownPets = array();
		$knownPetNames = array();
		$petOwner = array();
		foreach($charsByKey as $key => $var){
			if (gettype($this->userById[$key][4])=="string" && $this->userById[$key][4]!="" && isset($this->user[$this->userById[$key][4]])){
				$knownPetNames[] = '"'.$this->userById[$key][4].'"';
				$petOwner[] = $var;
			}
		}
		
		
		if (!empty($petOwner) && !empty($knownPetNames)){
			foreach($this->db->query('SELECT id, name FROM chars WHERE ownerid IN ('.implode(",",$petOwner).') AND name IN ('.implode(",",$knownPetNames).');') as $row){
				if (isset($this->user[$row->name][0]) && !isset($charsByKey[$this->user[$row->name][0]]))
					$charsByKey[$this->user[$row->name][0]] = $row->id;
			}
		}
		
		// pets
		foreach($this->participantKeys as $k => $v){
			if (isset($this->userById[$v][3]) && isset($this->userById[$v][5]) && isset($charsByKey[$this->userById[$v][5]]) && $this->userById[$v][3] == true && !isset($npcs[$v]) && $this->userById[$v][0]!="Unknown" && $this->userById[$v][0]!="Unbekannt" && !isset($charsByKey[$v])){
				if ($this->db->query('SELECT id, classid, guildid FROM chars WHERE name = "'.$this->userById[$v][0].'" AND serverid = "'.$serverid.'" AND ownerid != 0')->rowCount() == 0)
					$this->db->query('INSERT INTO chars (name, classid, faction, guildid, serverid, ownerid) VALUES ("'.$this->userById[$v][0].'", "0", "'.$this->userById[$this->userById[$v][5]][2].'", "0", "'.$serverid.'", "'.$charsByKey[$this->userById[$v][5]].'")');
				$charsByKey[$v] = $this->db->query('SELECT id FROM chars WHERE name = "'.$this->userById[$v][0].'" AND serverid = "'.$serverid.'" AND ownerid != 0')->fetch()->id;
			}
		}
		
		print "34 done <br />";
		
		//v-raids // v-attempts
		$raidsByZone = array();
		$attemptsWithDbId = array();
		$attemptsWithDbIdByNpcId = array();
		//$raidExists = array(); //Deprecated
		$raidExistsAttempts = array();
		$raidExistsAttemptsWithIds = array();
		$mergeBoolean = false;
		foreach($this->atmt as $k => $v){
			if (isset($raids[$k]) && $this->isValidLog($k, $npcsTra)){ // Worldboss issue
				$tses = $this->getTses($k, $serverid, time());
				$newLog = $this->isNewLog($raids[$k], $tses[2], $charsByKey, $serverid);
				foreach($newLog[2] as $qq => $ss){
					$raidExistsAttempts[$qq] = $ss;
				}
				foreach($newLog[3] as $qq => $ss){
					$raidExistsAttemptsWithIds[$qq] = $ss;
				}
				if ($newLog[1] == 0){
					$this->db->query('INSERT INTO `wotlk-raids` (nameid, guildid, tsstart, tsend) VALUES ("'.$raids[$k].'", "'.$guildid.'", "'.$tses[1].'", "'.$tses[2].'")');
					$raidsByZone[$k] = $this->db->query('SELECT id FROM `wotlk-raids` WHERE nameid = "'.$raids[$k].'" AND guildid = "'.$guildid.'" AND tsstart = "'.$tses[1].'" AND tsend = "'.$tses[2].'"')->fetch()->id;
					$this->db->query('UPDATE cronjob SET merge = "'.$raidsByZone[$k].'", mergetype = 0 WHERE id = "'.$cronid.'"');
				}else{
					$mergeBoolean = $newLog[1];
					// Exit to avoid double attempts
					if ($this->db->query('SELECT id FROM cronjob WHERE merge = "'.$newLog[1].'" AND expansion = 2')->rowCount()>0){
						$this->supersuperstate = false;
						return false;
					}
					$q = $this->db->query('SELECT a.guildid, a.id, c.name, a.tsstart, a.tsend FROM `wotlk-raids` a LEFT JOIN `wotlk-raids-attempts` b ON a.id = b.rid LEFT JOIN guilds c ON a.guildid = c.id WHERE a.nameid = "'.$raids[$k].'" AND a.id = "'.$mergeBoolean.'"')->fetch();
					if ($q->name == "PugRaid" && $guildname != "PugRaid")
						$this->db->query('UPDATE `wotlk-raids` SET guildid = "'.$guildid.'" WHERE id = "'.$q->id.'";');
					if ($q->tsend<$tses[2])
						$this->db->query('UPDATE `wotlk-raids` SET tsend = "'.$tses[2].'" WHERE id = "'.$q->id.'";');
					if ($q->tsstart>$tses[1] && $tses[1] != 0)
						$this->db->query('UPDATE `wotlk-raids` SET tsstart = "'.$tses[1].'" WHERE id = "'.$q->id.'";');
					$raidsByZone[$k] = $q->id;
					$this->db->query('UPDATE cronjob SET merge = "'.$raidsByZone[$k].'", mergetype = 1 WHERE id = "'.$cronid.'"');
				}
				if ($this->db->query('SELECT id FROM `wotlk-raids-uploader` WHERE rid = "'.$raidsByZone[$k].'" AND charid = "'.$pid.'"')->rowCount() == 0){
					$this->db->query('INSERT INTO `wotlk-raids-uploader` (rid, charid) VALUES ("'.$raidsByZone[$k].'", "'.$pid.'")');
				}
			}
		}
		
		// maybe change it to double at some time
		$instanceStartById = array();
		foreach($this->attemptsWithNpcId as $k => $v){
			if (isset($v[2]) && $v[2] != 0 && $v[2] != "" && !isset($raidExistsAttempts[$k])){
				$ts = $this->getTimeStamp($v[4], $v[4]);
				$extraTime = $this->getExtraTime($mergeBoolean, null, $raids[$v[1]]);
				$npcstr = "";
				foreach($v[10] as $q => $s){
					if (isset($this->user[$s][0]) && isset($npcs[$this->user[$s][0]])){
						$npcstr .= ($r = ($npcstr != "") ? "," : "").$npcs[$this->user[$s][0]];
					}
				}
				$istartCBT = $this->instanceStart[$v[1]];
				if ($mergeBoolean && $extraTime==0)
					$istartCBT = 0;
				//print $v[2]." // ".$k."<br />";
				$this->db->query('INSERT IGNORE INTO `wotlk-raids-attempts` (npcid, rid, type, time, cbt, cbtend, duration, npcs) VALUES ("'.$v[2].'", "'.$raidsByZone[$v[1]].'", "'.($r = (!$v[9]) ? 1 : -1).'", "'.$ts[1].'", "'.floor($v[3]-$istartCBT+$extraTime).'", "'.floor($v[5]-$istartCBT+$extraTime).'", "'.$v[7].'", "'.$npcstr.'")');
				$id = $this->db->query('SELECT id FROM `wotlk-raids-attempts` WHERE npcid = "'.$v[2].'" AND rid = "'.$raidsByZone[$v[1]].'" AND cbt = "'.floor($v[3]-$istartCBT+$extraTime).'"')->fetch()->id;
				if (intval($id)==0)
					$id = $this->db->query('SELECT id FROM `wotlk-raids-attempts` WHERE LOCATE("'.$v[2].'", npcs) AND rid = "'.$raidsByZone[$v[1]].'" AND cbt >= "'.floor($v[3]-$istartCBT+$extraTime-1).'" AND cbt <= "'.floor($v[3]-$istartCBT+$extraTime+1).'" ORDER BY id DESC LIMIT 1')->fetch()->id;
				$attemptsWithDbId[$k] = Array(
					1 => $id, // attemptid
					2 => $raidsByZone[$v[1]], // raid id
					3 => $v[2], // npcid
					4 => $v[3], // cbt start
					5 => $v[5], // cbt end
					6 => $v[6], // kill attempt
					7 => $v[8], // 1 => boss
					8 => $raids[$v[1]], // raidnameid
					9 => $v[4], // time
					10 => $v[1],
					11 => (!$v[9]) ? 1 : -1
				);
				$attemptsWithDbIdByNpcId[$v[2]] = array(
					1 => $id,
					2 => $raidsByZone[$v[1]], // raid id
					3 => $v[2],
					4 => $v[3],
					5 => $v[5],
					6 => $v[6], // kill attempt
					7 => $v[8], // 1 => boss
					8 => $raids[$v[1]], // raidnameid
					9 => $v[4], // time
					10 => $v[1],
					11 => (!$v[9]) ? 1 : -1
				);
				$instanceStartById[$k] = $istartCBT;
			}
		}
		// contributors 
		if ($this->db->query('SELECT id FROM contributors WHERE charid = "'.$pid.'"')->rowCount() == 0)
			$this->db->query('INSERT INTO contributors (charid, time) VALUES ("'.$pid.'", "'.time().'")');
		
		// v-raids-participants
		$participantsArr = array();
		foreach($this->participants as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($charsByKey[$var]) && !isset($npcs[$var])){
						if (isset($participantsArr[$k][$ke]))
							$participantsArr[$k][$ke] .= $charsByKey[$var].",";
						else
							$participantsArr[$k][$ke] = $charsByKey[$var].",";
					}
				}
			}
		}
		print "35 done <br />";
		foreach($raidsByZone as $k => $v){
			if (isset($participantsArr[$k])){
				$q = $this->db->query('SELECT * FROM `wotlk-raids-participants` WHERE rid = "'.$v.'"');
				if ($q->rowCount() == 0){
					$this->db->query('INSERT INTO `wotlk-raids-participants` (rid, tanks, dps, healers) VALUES ("'.$v.'", "'.$participantsArr[$k]["Tanks"].'", "'.$participantsArr[$k]["DPS"].'", "'.$participantsArr[$k]["Healer"].'")');
				}else{
					$f = $q->fetch();
					$tanks = explode(",", $f->tanks);
					$dps = explode(",", $f->dps);
					$healers = explode(",", $f->healers);
					$tanksNew = explode(",", $participantsArr[$k]["Tanks"]);
					foreach($tanksNew as $key => $var){
						if (isset($var) and $var != ""){
							if (!in_array($var, $tanks) && !in_array($var, $dps) && !in_array($var, $healers))
								array_push($tanks, $var);
						}
					}
					$dpsNew = explode(",", $participantsArr[$k]["DPS"]);
					foreach($dpsNew as $key => $var){
						if (isset($var) and $var != ""){
							if (!in_array($var, $tanks) && !in_array($var, $dps) && !in_array($var, $healers))
								array_push($dps, $var);
						}
					}
					$healersNew = explode(",", $participantsArr[$k]["Healer"]);
					foreach($healersNew as $key => $var){
						if (isset($var) and $var != ""){
							if (!in_array($var, $tanks) && !in_array($var, $dps) && !in_array($var, $healers))
								array_push($healers, $var);
						}
					}
					$dpsString = "";
					foreach($dps as $ke => $va){
						if (isset($va) and $va != "")
							$dpsString .= $va.",";
					}
					$tanksString = "";
					foreach($tanks as $ke => $va){
						if (isset($va) and $va != "")
							$tanksString .= $va.",";
					}
					$healersString = "";
					foreach($healers as $ke => $va){
						if (isset($va) and $va != "")
							$healersString .= $va.",";
					}
					$this->db->query('UPDATE `wotlk-raids-participants` SET tanks = "'.$tanksString.'", dps = "'.$dpsString.'", healers = "'.$healersString.'" WHERE rid = "'.$v.'"');
				}
			}
		}
		
		//v-raids-loot
		foreach($this->getLootArray($attemptsWithDbId, $npcsById, $npcsTra) as $k => $v){
			foreach($v as $key => $var){
				if ($mergeBoolean)
					$qqqwe = $this->db->query('SELECT * FROM `wotlk-raids-loot` WHERE charid = "'.$charsByKey[$var[2]].'" AND loot = "'.$var[1].'"');
				if (!isset($qqqwe) || (isset($qqqwe) && $qqqwe->rowCount() == 0)){
					$this->db->query('INSERT INTO `wotlk-raids-loot` (attemptid, loot, charid) VALUES ("'.$k.'", "'.$var[1].'", "'.($r = (isset($charsByKey[$var[2]])) ? $charsByKey[$var[2]] : 0).'")');
				}
			}
		}
		print "36 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 60 WHERE id = '.$cronid);
		
		// Freeing memory
		unset($this->dmg);
		unset($this->dmgtaken);
		unset($this->edt);
		unset($this->edd);
		unset($this->dispels);
		unset($this->interrupts);
		unset($this->deaths);
		unset($this->ehealing);
		unset($this->thealing);
		unset($this->overhealing);
		unset($this->absorbs);
		unset($this->auras);
		unset($this->totalDmgDone);
		unset($this->totalDmgTaken);
		unset($this->totalEDDTable);
		unset($this->totalEDTTable);
		unset($this->totalEHealingDone);
		unset($this->totalEHealingTaken);
		unset($this->totalTHealingDone);
		unset($this->totalTHealingTaken);
		//gc_collect_cycles();
		
		// Damage done
		/*
		* dmgDoneBySource[attemptid][charid] = Array(1 => value, 2 => active);
		* dmgDoneByAbility[attemptid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 => resist); //potential block
		* dmgDoneToEnemy[attemptid][npcid] = Array(1 => amount, 2 => active);
		* To test => dmgDoneToFriendly[attemptid][charid(the victim)] = amount;
		* To test => individualDmgDoneByAbility[attemptid][charid][abilityid] = Array(1 => casts, 2 => hits, 3 => amount, 4 => average, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 => resist);
		* To test => individualDmgDoneToEnemy[attemptid][npcid][charid] = Array(1 => amount, 2 => active);
		*/
		/*// v-raids-dmgdonebyability
		$sql = 'INSERT INTO `wotlk-raids-dmgdonebyability` (attemptid, abilityid, amount, casts, hits, crit, miss, parry, dodge, resist) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-dmgdonebyability` SET 
								casts = IF(?>amount, ?, casts),
								hits = IF(?>amount, ?, hits),
								crit = IF(?>amount, ?, crit),
								miss = IF(?>amount, ?, miss),
								parry = IF(?>amount, ?, parry),
								dodge = IF(?>amount, ?, dodge),
								resist = IF(?>amount, ?, resist),
								amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->dmgDoneByAbility as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset(($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]))){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[3], $var[1], $var[4], $var[1], $var[5], $var[1], $var[6], $var[1], $var[7], $var[1], $var[8], $var[1], $var[9], $var[1], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
						}else{
							$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
							$insertData[] = $var[1];
							$insertData[] = $var[3];
							$insertData[] = $var[4];
							$insertData[] = $var[5];
							$insertData[] = $var[6];
							$insertData[] = $var[7];
							$insertData[] = $var[8];
							$insertData[] = $var[9];
							//$this->db->query('INSERT INTO `wotlk-raids-dmgdonebyability` (attemptid, abilityid, amount, average, casts, hits, crit, miss, parry, dodge, resist) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'", "'.$var[5].'", "'.$var[6].'", "'.$var[7].'", "'.$var[8].'", "'.$var[9].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-dmgdonebysource
		$sql = 'INSERT INTO `wotlk-raids-dmgdonebysource` (attemptid, charid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-dmgdonebysource` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND charid = ?');
		foreach($this->dmgDoneBySource as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset($charsByKey[$key])){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `wotlk-raids-dmgdonebysource` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							//$this->db->query('INSERT INTO `wotlk-raids-dmgdonebysource` (attemptid, charid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-dmgdonetoenemy
		$sql = 'INSERT INTO `wotlk-raids-dmgdonetoenemy` (attemptid, npcid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-dmgdonetoenemy` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND npcid = ?');
		foreach($this->dmgDoneToEnemy as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1])){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $npcs[$key]));
							//$this->db->query('UPDATE `wotlk-raids-dmgdonetoenemy` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND npcid = "'.$npcs[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $npcs[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							if (!$npcs[$key])
								print $this->userById[$key][1]."<br />";
							//$this->db->query('INSERT INTO `wotlk-raids-dmgdonetoenemy` (attemptid, npcid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$npcs[$key].'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-dmgdonetofriendly
		$sql = 'INSERT INTO `wotlk-raids-dmgdonetofriendly` (attemptid, charid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		// New updating mechanic || Given we want to merge
		// 1. Get table
		// 2. Check table for existing and non existing stuff
		// 3. If exist put statement into buffer
		// 4. If not exist put statement into the other buffer
		// => Replacing the update function reducing the amount of queries that have to be executed significantly for the price of lots of memory. RIP provider server :P
		// Step 1
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-dmgdonetofriendly`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, amount) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->dmgDoneToFriendly as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					$toUpdateTable[$row->attemptid][$row->charid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `wotlk-raids-dmgdonetofriendly` SET amount = greatest(?, amount) WHERE attemptid = ? AND charid = ?');
		foreach($this->dmgDoneToFriendly as $k => $v){
			foreach($v as $key => $var){
				if (isset($var) && isset($charsByKey[$key])){
					if ($var>0){
						if (isset($toUpdateTable[$raidExistsAttempts[$k]]) && isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]) && $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]->amount<$var){
							$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]->id;
							$insertQueryUpdate[] = '(?, ?, ?, ?)';
							$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]->id;
							$insertDataUpdate[] = $raidExistsAttempts[$k];
							$insertDataUpdate[] = $charsByKey[$key];
							$insertDataUpdate[] = $var;
							//$ustmt->execute(array($var, $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `wotlk-raids-dmgdonetofriendly` SET amount = greatest("'.$var.'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var;
							//$this->db->query('INSERT INTO `wotlk-raids-dmgdonetofriendly` (attemptid, charid, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var.'")');
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		
		// v-raids-individual-dmgdonetoenemy
		$sql = 'INSERT INTO `wotlk-raids-individual-dmgdonetoenemy` (attemptid, charid, npcid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-individual-dmgdonetoenemy`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, npcid, amount, active) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDmgDoneToEnemy as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->npcid] = $row;
				}
			}
		}
		//$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-dmgdonetoenemy` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND charid = ? AND npcid = ?');
		foreach($this->individualDmgDoneToEnemy as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1])){
						if ($var[1]>0){
							if (isset($npcs[$ke]) && isset($charsByKey[$key])){
								if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]) 
								&& ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount<$var[1] or $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active<$var[2])){
									if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id, $toDeleteUpdate)){
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id;
										$insertQueryUpdate[] = '(?,?,?,?,?,?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charsByKey[$key];
										$insertDataUpdate[] = $npcs[$ke];
										$insertDataUpdate[] = ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount<$var[1]) ? $var[1] : $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount;
										$insertDataUpdate[] = ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active<$var[2]) ? $var[2] : $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active;
									}
									
									//$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $charsByKey[$key], $npcs[$ke]));
									//$this->db->query('UPDATE `wotlk-raids-individual-dmgdonetoenemy` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'" AND npcid = "'.$npcs[$ke].'"');
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$key];
									$insertData[] = $npcs[$ke];
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									//$this->db->query('INSERT INTO `wotlk-raids-individual-dmgdonetoenemy` (attemptid, charid, npcid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$npcs[$ke].'", "'.$var[1].'", "'.$var[2].'")');
								}
							}else{
								//print $this->userById[$ke][1]."<br />";
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		// v-raids-individual-dmgdonebyability
		$sql = 'INSERT INTO `wotlk-raids-individual-dmgdonebyability` (attemptid, charid, abilityid, casts, hits, amount, crit, miss, parry, dodge, resist, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-individual-dmgdonebyability`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, abilityid, casts, hits, amount, crit, miss, parry, dodge, resist, npcid) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDmgDoneByAbility as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->npcid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->npcid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->npcid][$row->abilityid] = $row;
				}
			}
		}
		
		/*$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-dmgdonebyability` SET 
								casts = IF(?>amount, ?, casts),
								hits = IF(?>amount, ?, hits),
								crit = IF(?>amount, ?, crit),
								miss = IF(?>amount, ?, miss),
								parry = IF(?>amount, ?, parry),
								dodge = IF(?>amount, ?, dodge),
								resist = IF(?>amount, ?, resist),
								amount = greatest(?, amount) WHERE attemptid = ? AND charid = ? AND abilityid = ? AND npcid = ?');*/
		foreach($this->individualDmgDoneByAbility as $k => $v){ // attemptid
			foreach($v as $ke => $va){ // charid
				if (isset($charsByKey[$ke])){
					foreach($va as $qq => $ss){ //npcid
						if (isset($npcs[$qq])){
							//$ddteid = $this->db->query('SELECT id FROM `wotlk-raids-individual-dmgdonetoenemy` WHERE attemptid = '.$attemptsWithDbId[$k][1].' AND npcid = '.$npcs[$qq].' AND charid = '.$charsByKey[$ke])->fetch()->id;
							foreach($ss as $key => $var){ // abilityid
								if (isset($var[3])){
									if ($var[3]>0){
										if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
										&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
										&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]]) 
										&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]) 
										&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->amount<$var[3]){
											if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id, $toDeleteUpdate)){
												$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id;
												$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
												$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id;
												$insertDataUpdate[] = $raidExistsAttempts[$k];
												$insertDataUpdate[] = $charsByKey[$ke];
												$insertDataUpdate[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
												$insertDataUpdate[] = $var[1];
												$insertDataUpdate[] = $var[2];
												$insertDataUpdate[] = $var[3];
												$insertDataUpdate[] = $var[5];
												$insertDataUpdate[] = $var[6];
												$insertDataUpdate[] = $var[7];
												$insertDataUpdate[] = $var[8];
												$insertDataUpdate[] = $var[9];
												$insertDataUpdate[] = $npcs[$qq];
											}
											
											//$ustmt->execute(array($var[3], $var[1], $var[3], $var[2], $var[3], $var[5], $var[3], $var[6], $var[3], $var[7], $var[3], $var[8], $var[3], $var[9], $var[3], $attemptsWithDbId[$k][1], $charsByKey[$ke], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]), $npcs[$qq]));
										}else{
											$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
											$insertData[] = $attemptsWithDbId[$k][1];
											$insertData[] = $charsByKey[$ke];
											$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
											$insertData[] = $var[1];
											$insertData[] = $var[2];
											$insertData[] = $var[3];
											$insertData[] = $var[5];
											$insertData[] = $var[6];
											$insertData[] = $var[7];
											$insertData[] = $var[8];
											$insertData[] = $var[9];
											$insertData[] = $npcs[$qq];
											//print $this->abilitiesById[$key][0]." => ".($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])."<br />";
											//$this->db->query('INSERT INTO `wotlk-raids-individual-dmgdonebyability` (attemptid, charid, abilityid, casts, hits, amount, average, crit, miss, parry, dodge, resist) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'", "'.$var[5].'", "'.$var[6].'", "'.$var[7].'", "'.$var[8].'", "'.$var[9].'")');
										}
									}
								}else{
									print $this->abilitiesById[$key][1]."<br />";
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		/*// v-raids-graph-dmgdone
		$sql = 'INSERT INTO `wotlk-raids-graph-dmgdone` (attemptid, time, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('SELECT * FROM `wotlk-raids-graph-dmgdone` WHERE attemptid = ?');
		$ustmtw = $this->db->prepare('UPDATE `wotlk-raids-graph-dmgdone` SET time = ?, amount = ? WHERE attemptid = ?;');
		foreach($this->getGraphStrings($this->graphdmgdone, $mergeBoolean, $attemptsWithDbId) as $k => $v){
			if (!isset($raidExistsAttempts[$k])){
				$insertQuery[] = '(?, ?, ?)';
				$insertData[] = $attemptsWithDbId[$k][1];
				$insertData[] = $v[1];
				$insertData[] = $v[2];
				//$this->db->query('INSERT INTO `wotlk-raids-graph-dmgdone` (attemptid, time, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$v[1].'", "'.$v[2].'")');
			/*}else{
				$ustmt->execute(array($raidExistsAttempts[$k]));
				$q = $ustmt->fetch();
				//$q = $this->db->query('SELECT * FROM `wotlk-raids-graph-dmgdone` WHERE attemptid = "'.$raidExistsAttempts[$k].'"')->fetch();
				if (isset($q->time)){
					$strings = $this->mergeGraphs($q, $v);
					$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$k]));
					//$this->db->query('UPDATE `wotlk-raids-graph-dmgdone` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$k].'";');
				}/
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		
		// v-raids-graph-individual-dmgdone
		$sql = 'INSERT INTO `wotlk-raids-graph-individual-dmgdone` (attemptid, time, amount, charid, abilityid, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		//$ustmt = $this->db->prepare('SELECT * FROM `wotlk-raids-graph-individual-dmgdone` WHERE attemptid = ? AND charid = ? AND abilityid = ?');
		//$ustmtw = $this->db->prepare('UPDATE `wotlk-raids-graph-individual-dmgdone` SET time = ?, amount = ? WHERE attemptid = ? AND charid = ? AND abilityid = ?;');
		foreach($this->graphindividualdmgdone as $k => $v){
			if (isset($charsByKey[$k])){
				foreach($v as $ke => $va){
					foreach($va as $keys => $vars){
						foreach($this->getGraphStrings($vars, $mergeBoolean, null, $attemptsWithDbId[$ke][8]) as $key => $var){
							if (!isset($raidExistsAttempts[$ke]) && isset($attemptsWithDbId[$ke][1])){
								$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$ke][1];
								$insertData[] = $var[1];
								$insertData[] = $var[2];
								$insertData[] = $charsByKey[$k];
								$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
								$insertData[] = $npcs[$keys];
								//$this->db->query('INSERT INTO `wotlk-raids-graph-individual-dmgdone` (attemptid, time, amount, charid) VALUES ("'.$attemptsWithDbId[$key][1].'", "'.$var[1].'", "'.$var[2].'", "'.$charsByKey[$k].'")');
							/*}else{
								$ustmt->execute(array($raidExistsAttempts[$ke], $charsByKey[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
								$q = $ustmt->fetch();
								//$q = $this->db->query('SELECT * FROM `wotlk-raids-graph-individual-dmgdone` WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'"')->fetch();
								if (isset($q->time)){
									$strings = $this->mergeGraphs($q, $var);
									$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$ke], $charsByKey[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
									//$this->db->query('UPDATE `wotlk-raids-graph-individual-dmgdone` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'";');
								}*/
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		//graphindividualfriendlyfire
		$sql = 'INSERT INTO `wotlk-raids-graph-individual-friendlyfire` (attemptid, time, amount, charid, abilityid, culpritid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		//$ustmt = $this->db->prepare('SELECT * FROM `wotlk-raids-graph-individual-dmgdone` WHERE attemptid = ? AND charid = ? AND abilityid = ?');
		//$ustmtw = $this->db->prepare('UPDATE `wotlk-raids-graph-individual-dmgdone` SET time = ?, amount = ? WHERE attemptid = ? AND charid = ? AND abilityid = ?;');
		foreach($this->graphindividualfriendlyfire as $k => $v){
			if (isset($charsByKey[$k])){
				foreach($v as $ke => $va){
					foreach($va as $keys => $vars){
						foreach($this->getGraphStrings($vars, $mergeBoolean, null, $attemptsWithDbId[$ke][8]) as $key => $var){
							if (!isset($raidExistsAttempts[$ke])){
								$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$ke][1];
								$insertData[] = $var[1];
								$insertData[] = $var[2];
								$insertData[] = $charsByKey[$k];
								$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
								$insertData[] = $charsByKey[$keys];
								//$this->db->query('INSERT INTO `wotlk-raids-graph-individual-dmgdone` (attemptid, time, amount, charid) VALUES ("'.$attemptsWithDbId[$key][1].'", "'.$var[1].'", "'.$var[2].'", "'.$charsByKey[$k].'")');
							/*}else{
								$ustmt->execute(array($raidExistsAttempts[$ke], $charsByKey[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
								$q = $ustmt->fetch();
								//$q = $this->db->query('SELECT * FROM `wotlk-raids-graph-individual-dmgdone` WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'"')->fetch();
								if (isset($q->time)){
									$strings = $this->mergeGraphs($q, $var);
									$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$ke], $charsByKey[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
									//$this->db->query('UPDATE `wotlk-raids-graph-individual-dmgdone` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'";');
								}*/
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		
		
		$sql = 'INSERT INTO `wotlk-raids-casts` (attemptid, charid, tarid, abilityid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-casts`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, tarid, abilityid, amount) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->casts as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->tarid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->tarid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->tarid][$row->abilityid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `wotlk-raids-casts` SET amount = greatest(?, amount) WHERE attemptid = ? AND charid = ? AND tarid = ? AND abilityid = ?');
		foreach($this->casts as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						foreach($var as $keys => $vars){
							if (floor($vars) > 0 && $this->abilitiesById[$keys][0] != $spellsTra["Attack"] && $this->abilitiesById[$keys][0] != $spellsTra["Auto Shot"]){ // TRANSLATION ALSO FOR VANILLA!
								$npppcid = (isset($npcs[$key])) ? $npcs[$key] : $charsByKey[$key];
								if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid][($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys])]) 
								&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid][($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys])]->amount<$vars){
									if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid][($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys])]->id, $toDeleteUpdate)){
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid][($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys])]->id;
										$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npppcid][($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys])]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charsByKey[$ke];
										$insertDataUpdate[] = $npppcid;
										$insertDataUpdate[] = ($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys]);
										$insertDataUpdate[] = $vars;
									}
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = $npppcid;
									$insertData[] = ($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys]);
									$insertData[] = $vars;
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		print "37 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 70 WHERE id = '.$cronid);
		
		// Damage taken
		/*
		* All of them have to be tested
		* Note: DmgTaken is very similiar to dmg done
		*
		* dmgTakenBySource[attemptid][charid] = Array(1 => amount, 2 => active);
		* dmgTakenFromAbility[attemptid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => crit, 6 => miss, 7 => parry, 8 => dodge, 9 =>resist, 10 => crush, 11 => block);
		* dmgTakenFromSource[attemptid][npcid/charid] = Array(1 => gettype(char or npc), 2 => amount, 3 => active);
		* individualDmgTakenByAbility[attemptid][charid][abilityid] = Array(1 => amount, 2 => average, 3 => casts, 4 => hits, 5 => block, 6 => crit, 7 => miss, 8 => parry, 9 => dodge, 10 => resist, 11 => crush);
		* individualDmgTakenBySource[attemptid][npcid][charid] = Array(1 => amount, 2 => active);
		* individualDmgTakenByPlayer[attemptid][charid][culpritid] = amount;
		*/
		/*// v-raids-dmgtakenbysource
		$sql = 'INSERT INTO `wotlk-raids-dmgtakenbysource` (attemptid, charid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-dmgtakenbysource` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND charid = ?');
		foreach($this->dmgTakenBySource as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset($charsByKey[$key])){
					if ($var[1]>0){ 
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `wotlk-raids-dmgtakenbysource` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							//$this->db->query('INSERT INTO `wotlk-raids-dmgtakenbysource` (attemptid, charid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-dmgtakenfromability
		$sql = 'INSERT INTO `wotlk-raids-dmgtakenfromability` (attemptid, abilityid, amount, casts, hits, crit, miss, parry, dodge, resist, crush, block, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-dmgtakenfromability` SET 
								casts = IF(?>amount, ?, casts),
								hits = IF(?>amount, ?, hits),
								crit = IF(?>amount, ?, crit),
								miss = IF(?>amount, ?, miss),
								parry = IF(?>amount, ?, parry),
								dodge = IF(?>amount, ?, dodge),
								resist = IF(?>amount, ?, resist),
								crush = IF(?>amount, ?, crush),
								block = IF(?>amount, ?, block),
								amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ? AND npcid = ?');
		foreach($this->dmgTakenFromAbility as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1])){
						if ($var[1]>0){
							if (isset($raidExistsAttempts[$k])){
								$ustmt->execute(array($var[1], $var[3], $var[1], $var[4], $var[1], $var[5], $var[1], $var[6], $var[1], $var[7], $var[1], $var[8], $var[1], $var[9], $var[1], $var[10], $var[1], $var[11], $var[1], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke]), $npcs[$key]));
								/*$this->db->query('UPDATE `wotlk-raids-dmgtakenfromability` SET 
									average = IF("'.$var[1].'">amount, "'.$var[2].'", average),
									casts = IF("'.$var[1].'">amount, "'.$var[3].'", casts),
									hits = IF("'.$var[1].'">amount, "'.$var[4].'", hits),
									crit = IF("'.$var[1].'">amount, "'.$var[5].'", crit),
									miss = IF("'.$var[1].'">amount, "'.$var[6].'", miss),
									parry = IF("'.$var[1].'">amount, "'.$var[7].'", parry),
									dodge = IF("'.$var[1].'">amount, "'.$var[8].'", dodge),
									resist = IF("'.$var[1].'">amount, "'.$var[9].'", resist),
									crush = IF("'.$var[1].'">amount, "'.$var[10].'", crush),
									block = IF("'.$var[1].'">amount, "'.$var[11].'", block),
									amount = greatest("'.$var[1].'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'"');/
							}else{
								$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$k][1];
								$insertData[] = ($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke]);
								$insertData[] = $var[1];
								$insertData[] = $var[3];
								$insertData[] = $var[4];
								$insertData[] = $var[5];
								$insertData[] = $var[6];
								$insertData[] = $var[7];
								$insertData[] = $var[8];
								$insertData[] = $var[9];
								$insertData[] = $var[10];
								$insertData[] = $var[11];
								$insertData[] = $npcs[$key];
								//$this->db->query('INSERT INTO `wotlk-raids-dmgtakenfromability` (attemptid, abilityid, amount, average, casts, hits, crit, miss, parry, dodge, resist, crush, block) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'", "'.$var[5].'", "'.$var[6].'", "'.$var[7].'" ,"'.$var[8].'", "'.$var[9].'", "'.$var[10].'", "'.$var[11].'")');
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-dmgtakenfromsource
		$sql = 'INSERT INTO `wotlk-raids-dmgtakenfromsource` (attemptid, type, typeid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-dmgtakenfromsource` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND typeid = ?');
		foreach($this->dmgTakenFromSource as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[2])){
					if ($var[2]>0){
						if (isset($raidExistsAttempts[$k])){
							// I did not use type here.
							$ustmt->execute(array($var[2], $var[3], $raidExistsAttempts[$k], $npcs[$key]));
							//$this->db->query('UPDATE `wotlk-raids-dmgtakenfromsource` SET amount = greatest("'.$var[2].'", amount), active = greatest("'.$var[3].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND typeid = "'.$npcs[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $var[1];
							$insertData[] = $npcs[$key];
							$insertData[] = $var[2];
							$insertData[] = $var[3];
							//$this->db->query('INSERT INTO `wotlk-raids-dmgtakenfromsource` (attemptid, type, typeid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$var[1].'", "'.$npcs[$key].'", "'.$var[2].'", "'.$var[3].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-individual-dmgtakenbyability
		$sql = 'INSERT INTO `wotlk-raids-individual-dmgtakenfromability` (attemptid, charid, abilityid, casts, hits, amount, block, crit, miss, parry, dodge, resist, crush, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-individual-dmgtakenfromability`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, abilityid, casts, hits, amount, block, crit, miss, parry, dodge, resist, crush, npcid) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDmgTakenByAbility as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->npcid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->npcid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->npcid][$row->abilityid] = $row;
				}
			}
		}
		
		/*$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-dmgtakenfromability` SET 
								casts = IF(?>amount, ?, casts),
								hits = IF(?>amount, ?, hits),
								crit = IF(?>amount, ?, crit),
								miss = IF(?>amount, ?, miss),
								parry = IF(?>amount, ?, parry),
								dodge = IF(?>amount, ?, dodge),
								resist = IF(?>amount, ?, resist),
								crush = IF(?>amount, ?, crush),
								block = IF(?>amount, ?, block),
								amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ? AND charid = ? AND npcid = ?');*/
		foreach($this->individualDmgTakenByAbility as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						foreach($var as $keys => $vars){
							if (isset($vars[3])){
								if ($vars[3]>0){
									if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
									&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
									&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]]) 
									&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]) 
									&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->amount<$vars[3]){
										if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id, $toDeleteUpdate)){
											$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id;
											$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
											$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$keys]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id;
											$insertDataUpdate[] = $raidExistsAttempts[$k];
											$insertDataUpdate[] = $charsByKey[$ke];
											$insertDataUpdate[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
											$insertDataUpdate[] = $vars[1];
											$insertDataUpdate[] = $vars[2];
											$insertDataUpdate[] = $vars[3];
											$insertDataUpdate[] = $vars[5];
											$insertDataUpdate[] = $vars[6];
											$insertDataUpdate[] = $vars[7];
											$insertDataUpdate[] = $vars[8];
											$insertDataUpdate[] = $vars[9];
											$insertDataUpdate[] = $vars[10];
											$insertDataUpdate[] = $vars[11];
											$insertDataUpdate[] = $npcs[$keys];
										}
										
										
										//$ustmt->execute(array($vars[3], $vars[1], $vars[3], $vars[2], $vars[3], $vars[6], $vars[3], $vars[7], $vars[3], $vars[8], $vars[3], $vars[9], $vars[3], $vars[10], $vars[3], $vars[11], $vars[3], $vars[5], $vars[3], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]), $charsByKey[$ke], $npcs[$keys]));
										/*$this->db->query('UPDATE `wotlk-raids-individual-dmgtakenfromability` SET 
										average = IF("'.$vars[3].'">amount, "'.$vars[4].'", average),
										casts = IF("'.$vars[3].'">amount, "'.$vars[1].'", casts),
										hits = IF("'.$vars[3].'">amount, "'.$vars[2].'", hits),
										crit = IF("'.$vars[3].'">amount, "'.$vars[6].'", crit),
										miss = IF("'.$vars[3].'">amount, "'.$vars[7].'", miss),
										parry = IF("'.$vars[3].'">amount, "'.$vars[8].'", parry),
										dodge = IF("'.$vars[3].'">amount, "'.$vars[9].'", dodge),
										resist = IF("'.$vars[3].'">amount, "'.$vars[10].'", resist),
										crush = IF("'.$vars[3].'">amount, "'.$vars[11].'", crush),
										block = IF("'.$vars[3].'">amount, "'.$vars[5].'", block),
										amount = greatest("'.$vars[3].'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'" AND charid = "'.$charsByKey[$ke].'"');*/
									}else{
										$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
										$insertData[] = $attemptsWithDbId[$k][1];
										$insertData[] = $charsByKey[$ke];
										$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
										$insertData[] = $vars[1];
										$insertData[] = $vars[2];
										$insertData[] = $vars[3];
										$insertData[] = $vars[5];
										$insertData[] = $vars[6];
										$insertData[] = $vars[7];
										$insertData[] = $vars[8];
										$insertData[] = $vars[9];
										$insertData[] = $vars[10];
										$insertData[] = $vars[11];
										$insertData[] = $npcs[$keys];
										//$this->db->query('INSERT INTO `wotlk-raids-individual-dmgtakenfromability` (attemptid, charid, abilityid, casts, hits, amount, average, block, crit, miss, parry, dodge, resist, crush) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$vars[1].'", "'.$vars[2].'", "'.$vars[3].'", "'.$vars[4].'", "'.$vars[5].'", "'.$vars[6].'", "'.$vars[7].'", "'.$vars[8].'", "'.$vars[9].'", "'.$vars[10].'", "'.$vars[11].'")');
									}
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-individual-dmgtakenbyplayer
		$sql = 'INSERT INTO `wotlk-raids-individual-dmgtakenbyplayer` (attemptid, charid, culpritid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-individual-dmgtakenbyplayer`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, culpritid, amount) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDmgTakenByPlayer as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->culpritid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-dmgtakenbyplayer` SET amount = greatest(?, amount) WHERE attemptid = ? AND charid = ? AND culpritid = ?');
		foreach($this->individualDmgTakenByPlayer as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var) && isset($charsByKey[$ke]) && isset($charsByKey[$key])){
						if ($var>0){
							if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]]) 
							&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]]->amount<$var){
								if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]]->id, $toDeleteUpdate)){
									$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]]->id;
									$insertQueryUpdate[] = '(?, ?, ?, ?, ?)';
									$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]]->id;
									$insertDataUpdate[] = $raidExistsAttempts[$k];
									$insertDataUpdate[] = $charsByKey[$ke];
									$insertDataUpdate[] = $charsByKey[$key];
									$insertDataUpdate[] = $var;
								}
								
								//$ustmt->execute(array($var, $raidExistsAttempts[$k], $charsByKey[$ke], $charsByKey[$key]));
								//$this->db->query('UPDATE `wotlk-raids-individual-dmgtakenbyplayer` SET amount = greatest("'.$var.'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$ke].'" AND culpritid = "'.$charsByKey[$key].'"');
							}else{
								$insertQuery[] = '(?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$k][1];
								$insertData[] = $charsByKey[$ke];
								$insertData[] = $charsByKey[$key];
								$insertData[] = $var;
								//$this->db->query('INSERT INTO `wotlk-raids-individual-dmgtakenbyplayer` (attemptid, charid, culpritid, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$charsByKey[$key].'", "'.$var.'")');
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-individual-dmgtakenbysource
		$sql = 'INSERT INTO `wotlk-raids-individual-dmgtakenfromsource` (attemptid, charid, npcid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-individual-dmgtakenfromsource`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, npcid, amount, active) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDmgTakenBySource as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->npcid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-dmgtakenfromsource` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND charid = ? AND npcid = ?');
		foreach($this->individualDmgTakenBySource as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1]) && isset($charsByKey[$key])){
						if ($var[1]>0){
							if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]) 
							&& ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount<$var[1] or $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active<$var[2])){
								if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id, $toDeleteUpdate)){
									$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id;
									$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
									$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->id;
									$insertDataUpdate[] = $raidExistsAttempts[$k];
									$insertDataUpdate[] = $charsByKey[$key];
									$insertDataUpdate[] = $npcs[$ke];
									$insertDataUpdate[] = ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount<$var[1]) ? $var[1] : $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->amount;
									$insertDataUpdate[] = ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active<$var[2]) ? $var[2] : $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$key]][$npcs[$ke]]->active;
								}
								//$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $charsByKey[$key], $npcs[$ke]));
								//$this->db->query('UPDATE `wotlk-raids-individual-dmgtakenfromsource` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'" AND typeid = "'.$npcs[$ke].'"');
							}else{
								$insertQuery[] = '(?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$k][1];
								$insertData[] = $charsByKey[$key];
								$insertData[] = $npcs[$ke];
								$insertData[] = $var[1];
								$insertData[] = $var[2];
								//$this->db->query('INSERT INTO `wotlk-raids-individual-dmgtakenfromsource` (attemptid, charid, typeid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$npcs[$ke].'", "'.$var[1].'", "'.$var[2].'")');
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		/*// v-raids-graph-dmgtaken
		$sql = 'INSERT INTO `wotlk-raids-graph-dmgtaken` (attemptid, time, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('SELECT * FROM `wotlk-raids-graph-dmgtaken` WHERE attemptid = ?');
		$ustmtw = $this->db->prepare('UPDATE `wotlk-raids-graph-dmgtaken` SET time = ?, amount = ? WHERE attemptid = ?;');
		foreach($this->getGraphStrings($this->graphdmgtaken, $mergeBoolean, $attemptsWithDbId) as $k => $v){
			if (!isset($raidExistsAttempts[$k])){
				$insertQuery[] = '(?, ?, ?)';
				$insertData[] = $attemptsWithDbId[$k][1];
				$insertData[] = $v[1];
				$insertData[] = $v[2];
				//$this->db->query('INSERT INTO `wotlk-raids-graph-dmgtaken` (attemptid, time, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$v[1].'", "'.$v[2].'")');
			/*}else{
				$ustmt->execute(array($raidExistsAttempts[$k]));
				$q = $ustmt->fetch();
				//$q = $this->db->query('SELECT * FROM `wotlk-raids-graph-dmgtaken` WHERE attemptid = "'.$raidExistsAttempts[$k].'"')->fetch();
				if (isset($q->time)){
					$strings = $this->mergeGraphs($q, $v);
					$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$k]));
					//$this->db->query('UPDATE `wotlk-raids-graph-dmgtaken` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$k].'";');
				}/
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-graph-individual-dmgtaken
		$sql = 'INSERT INTO `wotlk-raids-graph-individual-dmgtaken` (attemptid, time, amount, charid, abilityid, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		//$ustmt = $this->db->prepare('SELECT * FROM `wotlk-raids-graph-individual-dmgtaken` WHERE attemptid = ? AND charid = ? AND abilityid = ?');
		//$ustmtw = $this->db->prepare('UPDATE `wotlk-raids-graph-individual-dmgtaken` SET time = ?, amount = ? WHERE attemptid = ? AND charid = ? AND abilityid = ?;');
		foreach($this->graphindividualdmgtaken as $k => $v){
			if (isset($charsByKey[$k])){
				foreach($v as $ke => $va){
					foreach($va as $keys => $vars){
						foreach($this->getGraphStrings($vars, $mergeBoolean, null, $attemptsWithDbId[$ke][8]) as $key => $var){
							if (!isset($raidExistsAttempts[$ke])){
								$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$ke][1];
								$insertData[] = $var[1];
								$insertData[] = $var[2];
								$insertData[] = $charsByKey[$k];
								$insertData[] = ($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys]);
								$insertData[] = $npcs[$key];
								//$this->db->query('INSERT INTO `wotlk-raids-graph-individual-dmgtaken` (attemptid, time, amount, charid) VALUES ("'.$attemptsWithDbId[$key][1].'", "'.$var[1].'", "'.$var[2].'", "'.$charsByKey[$k].'")');
							/*}else{
								$ustmt->execute(array($raidExistsAttempts[$ke], $charsByKey[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
								$q = $ustmt->fetch();
								//$q = $this->db->query('SELECT * FROM `wotlk-raids-graph-individual-dmgtaken` WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'"')->fetch();
								if (isset($q->time)){
									$strings = $this->mergeGraphs($q, $var);
									$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$ke], $charsByKey[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
									//$this->db->query('UPDATE `wotlk-raids-graph-individual-dmgtaken` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'";');
								}*/
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		print "38 done <br />";
		
		// Healing done
		/*
		* All of them have to be tested
		*
		* healingBySource[attemptid][charid] = Array(1 => tamount, 2 => eamount, 3 => absorbed, 4 => active);
		* healingByAbility[attemptid][abilityid] = Array(1 => casts, 2 => tamount, 3 => eamount, 4 => average, 5 => crit);
		* healingToFriendly[attemptid][charid] = Array(1 => tamount, 2 => eamount, 3 => absorbed, 4 => active);
		* individualHealingToFriendly[attemptid][charid][tarid] = Array(1 => tamount, 2 => eamount);
		* individualHealingByAbility[attemptid][charid][abilityid] = Array(1 => tamount, 2 => eamount, 3 => taverage, 4 => eaverage, 5 => hits, 6 => crit);
		*/
		/*// v-raids-healingbyability
		$sql = 'INSERT INTO `wotlk-raids-healingbyability` (attemptid, abilityid, casts, tamount, eamount, crit) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-healingbyability` SET 
								casts = IF(?>tamount, ?, casts),
								crit = IF(?>tamount, ?, crit),
								tamount = greatest(?, tamount), 
								eamount = greatest(?, eamount) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->healingByAbility as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[2]) and isset($var[3]) && isset(($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]))){
					if ($var[2]>0 || $var[3]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[2], $var[1], $var[2], $var[5], $var[2], $var[3], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
							/*$this->db->query('UPDATE `wotlk-raids-healingbyability` SET 
								casts = IF("'.$var[2].'">tamount, "'.$var[1].'", casts),
								average = IF("'.$var[2].'">tamount, "'.$var[4].'", average),
								crit = IF("'.$var[2].'">tamount, "'.$var[5].'", crit),
								tamount = greatest("'.$var[2].'", tamount), 
								eamount = greatest("'.$var[3].'", eamount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'"');/
						}else{
							$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $var[3];
							$insertData[] = $var[5];
							//$this->db->query('INSERT INTO `wotlk-raids-healingbyability` (attemptid, abilityid, casts, tamount, eamount, average, crit) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'" , "'.$var[4].'", "'.$var[5].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-healingbysource
		$sql = 'INSERT INTO `wotlk-raids-healingbysource` (attemptid, charid, tamount, eamount, absorbed, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-healingbysource` SET tamount = greatest(?, tamount), eamount = greatest(?, eamount), absorbed = greatest(?, absorbed), active = greatest(?, active) WHERE attemptid = ? AND charid = ?');
		foreach($this->healingBySource as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) and isset($var[2]) && isset($charsByKey[$key])){
					if ($var[1]>0 || $var[2]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $var[3], $var[4], $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `wotlk-raids-healingbysource` SET tamount = greatest("'.$var[1].'", tamount), eamount = greatest("'.$var[2].'", eamount), absorbed = greatest("'.$var[3].'", absorbed), active = greatest("'.$var[4].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $var[3];
							$insertData[] = $var[4];
							//$this->db->query('INSERT INTO `wotlk-raids-healingbysource` (attemptid, charid, tamount, eamount, absorbed, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-healingtofriendly
		$sql = 'INSERT INTO `wotlk-raids-healingtofriendly` (attemptid, charid, tamount, eamount, absorbed, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-healingtofriendly` SET tamount = greatest(?, tamount), eamount = greatest(?, eamount), absorbed = greatest(?, absorbed), active = greatest(?, active) WHERE attemptid = ? AND charid = ?');
		foreach($this->healingToFriendly as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) and isset($var[2]) && isset($charsByKey[$key])){
					if ($var[1]>0 and $var[2]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $var[3], $var[4], $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `wotlk-raids-healingtofriendly` SET tamount = greatest("'.$var[1].'", tamount), eamount = greatest("'.$var[2].'", eamount), absorbed = greatest("'.$var[3].'", absorbed), active = greatest("'.$var[4].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $var[3];
							$insertData[] = $var[4];
							//$this->db->query('INSERT INTO `wotlk-raids-healingtofriendly` (attemptid, charid, tamount, eamount, absorbed, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-individual-healingbyability
		$sql = 'INSERT INTO `wotlk-raids-individual-healingbyability` (attemptid, charid, abilityid, tamount, eamount, casts, crit, tarid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-individual-healingbyability`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, abilityid, tamount, eamount, casts, crit, tarid) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualHealingByAbility as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->tarid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->tarid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->tarid][$row->abilityid] = $row;
				}
			}
		}
		
		/*$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-healingbyability` SET 
									casts = IF(?>tamount, ?, casts),
									crit = IF(?>tamount, ?, crit),
									tamount = greatest(?, tamount), 
									eamount = greatest(?, eamount) WHERE attemptid = ? AND abilityid = ? AND charid = ? AND tarid = ?');*/
		foreach($this->individualHealingByAbility as $k => $v){
			foreach($v as $ke => $va){ // charid
				foreach($va as $qq => $ss){ //tarid
					foreach($ss as $key => $var){
						if (isset($var[1]) and isset($var[2])){
							if ($var[1]>0 and $var[2]>0 && isset($charsByKey[$ke])){
								if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]) 
								&& ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->tamount<$var[1] or $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->eamount<$var[2])){
									if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id, $toDeleteUpdate)){
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id;
										$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charsByKey[$ke];
										$insertDataUpdate[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
										$insertDataUpdate[] = $var[1];
										$insertDataUpdate[] = $var[2];
										$insertDataUpdate[] = $var[5];
										$insertDataUpdate[] = $var[6];
										$insertDataUpdate[] = $charsByKey[$qq];
									}
									//$ustmt->execute(array($var[1], $var[5], $var[1], $var[6], $var[1], $var[2], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]), $charsByKey[$ke], $charsByKey[$qq]));
									/*$this->db->query('UPDATE `wotlk-raids-individual-healingbyability` SET 
										casts = IF("'.$var[1].'">tamount, "'.$var[5].'", casts),
										average = IF("'.$var[1].'">tamount, "'.$var[3].'", average),
										crit = IF("'.$var[1].'">tamount, "'.$var[6].'", crit),
										tamount = greatest("'.$var[1].'", tamount), 
										eamount = greatest("'.$var[2].'", eamount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'" AND charid = "'.$charsByKey[$ke].'"');*/
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									$insertData[] = $var[5];
									$insertData[] = $var[6];
									$insertData[] = $charsByKey[$qq];
									//$this->db->query('INSERT INTO `wotlk-raids-individual-healingbyability` (attemptid, charid, abilityid, tamount, eamount, average, casts, crit) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[5].'", "'.$var[6].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-individual-healingtofriendly
		$sql = 'INSERT INTO `wotlk-raids-individual-healingtofriendly` (attemptid, charid, tarid, tamount, eamount, absorbed, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-individual-healingtofriendly`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, tarid, tamount, eamount, absorbed, active) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualHealingToFriendly as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->tarid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-healingtofriendly` SET tamount = greatest(?, tamount), eamount = greatest(?, eamount) WHERE attemptid = ? AND charid = ? AND tarid = ?');
		foreach($this->individualHealingToFriendly as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1]) and isset($var[2])){
						if (($var[1]>0 and $var[2]>0) or $var[4]>0){
							$charid1 = (isset($charsByKey[$key])) ? $charsByKey[$key] : 0;
							$charid2 = (isset($charsByKey[$ke])) ? $charsByKey[$ke] : 0;
							if ($charid1>0){
								if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charid1]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]) 
								&& ($toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]->tamount<$var[1] or $toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]->eamount<$var[2])){
									if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]->id, $toDeleteUpdate)){
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]->id;
										$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?, ?, ?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charid1][$charid2]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charid1;
										$insertDataUpdate[] = $charid2;
										$insertDataUpdate[] = $var[1];
										$insertDataUpdate[] = $var[2];
										$insertDataUpdate[] = $var[4];
										$insertDataUpdate[] = $var[5];
									}
									
									//$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], $charsByKey[$ke], $charsByKey[$key]));
									//$this->db->query('UPDATE `wotlk-raids-individual-healingtofriendly` SET tamount = greatest("'.$var[1].'", tamount), eamount = greatest("'.$var[2].'", eamount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$ke].'" AND tarid = "'.$charsByKey[$key].'"');
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charid1;
									$insertData[] = $charid2;
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									$insertData[] = $var[4];
									$insertData[] = $var[5];
									//$this->db->query('INSERT INTO `wotlk-raids-individual-healingtofriendly` (attemptid, charid, tarid, tamount, eamount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.($r = (isset($charsByKey[$ke])) ? $charsByKey[$ke] : 0).'", "'.$var[1].'", "'.$var[2].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		/*// v-raids-graph-healingdone
		$sql = 'INSERT INTO `wotlk-raids-graph-healingdone` (attemptid, time, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('SELECT * FROM `wotlk-raids-graph-healingdone` WHERE attemptid = ?');
		$ustmtw = $this->db->prepare('UPDATE `wotlk-raids-graph-healingdone` SET time = ?, amount = ? WHERE attemptid = ?;');
		foreach($this->getGraphStrings($this->graphhealingdone, $mergeBoolean, $attemptsWithDbId) as $k => $v){
			if (!isset($raidExistsAttempts[$k])){
				$insertQuery[] = '(?, ?, ?)';
				$insertData[] = $attemptsWithDbId[$k][1];
				$insertData[] = $v[1];
				$insertData[] = $v[2];
				//$this->db->query('INSERT INTO `wotlk-raids-graph-healingdone` (attemptid, time, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$v[1].'", "'.$v[2].'")');
			/*}else{
				$ustmt->execute(array($raidExistsAttempts[$k]));
				$q = $ustmt->fetch();
				//$q = $this->db->query('SELECT * FROM `wotlk-raids-graph-healingdone` WHERE attemptid = "'.$raidExistsAttempts[$k].'"')->fetch();
				if (isset($q->time)){
					$strings = $this->mergeGraphs($q, $v);
					$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$k]));
					//$this->db->query('UPDATE `wotlk-raids-graph-healingdone` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$k].'";');
				}/
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-graph-individual-healingdone
		$sql = 'INSERT INTO `wotlk-raids-graph-individual-healingdone` (attemptid, time, amount, charid, abilityid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('SELECT * FROM `wotlk-raids-graph-individual-healingdone` WHERE attemptid = ? AND charid = ? AND abilityid = ?');
		$ustmtw = $this->db->prepare('UPDATE `wotlk-raids-graph-individual-healingdone` SET time = ?, amount = ? WHERE attemptid = ? AND charid = ? AND abilityid = ?;');
		foreach($this->graphindividualhealingdone as $k => $v){
			if (isset($charsByKey[$k])){
				foreach($v as $ke => $va){
					foreach($this->getGraphStrings($va, $mergeBoolean, null, $attemptsWithDbId[$ke][8]) as $key => $var){
						if (!isset($raidExistsAttempts[$ke])){
							$insertQuery[] = '(?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$ke][1];
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $charsByKey[$k];
							$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
							//$this->db->query('INSERT INTO `wotlk-raids-graph-individual-healingdone` (attemptid, time, amount, charid) VALUES ("'.$attemptsWithDbId[$key][1].'", "'.$var[1].'", "'.$var[2].'", "'.$charsByKey[$k].'")');
						/*}else{
							$ustmt->execute(array($raidExistsAttempts[$ke], $charsByKey[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
							$q = $ustmt->fetch();
							//$q = $this->db->query('SELECT * FROM `wotlk-raids-graph-individual-healingdone` WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'"')->fetch();
							if (isset($q->time)){
								$strings = $this->mergeGraphs($q, $var);
								$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$ke], $charsByKey[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
								//$this->db->query('UPDATE `wotlk-raids-graph-individual-healingdone` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'";');
							}/
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-graph-individual-healingreceived
		$sql = 'INSERT INTO `wotlk-raids-graph-individual-healingreceived` (attemptid, time, amount, charid, abilityid, sourceid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		//$ustmt = $this->db->prepare('SELECT * FROM `wotlk-raids-graph-individual-healingreceived` WHERE attemptid = ? AND charid = ? AND abilityid = ?');
		//$ustmtw = $this->db->prepare('UPDATE `wotlk-raids-graph-individual-healingreceived` SET time = ?, amount = ? WHERE attemptid = ? AND charid = ? AND abilityid = ?;');
		foreach($this->graphindividualhealingreceived as $k => $v){ // user
			if (isset($charsByKey[$k])){
				foreach($v as $ke => $va){ // attemptid
					foreach($va as $key => $var){ // abilityid
						foreach($this->getGraphStrings($var, $mergeBoolean, null, $attemptsWithDbId[$ke][8]) as $keys => $vars){
							if (!isset($raidExistsAttempts[$ke])){
								$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$ke][1];
								$insertData[] = $vars[1];
								$insertData[] = $vars[2];
								$insertData[] = $charsByKey[$k];
								$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
								$insertData[] = $charsByKey[$keys];
								//$this->db->query('INSERT INTO `wotlk-raids-graph-individual-healingreceived` (attemptid, time, amount, charid) VALUES ("'.$attemptsWithDbId[$key][1].'", "'.$var[1].'", "'.$var[2].'", "'.$charsByKey[$k].'")');
							/*}else{
								$ustmt->execute(array($raidExistsAttempts[$ke], $charsByKey[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
								$q = $ustmt->fetch();
								//$q = $this->db->query('SELECT * FROM `wotlk-raids-graph-individual-healingreceived` WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'"')->fetch();
								if (isset($q->time)){
									$strings = $this->mergeGraphs($q, $var);
									$ustmtw->execute(array($strings[1], $strings[2], $raidExistsAttempts[$ke], $charsByKey[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
									//$this->db->query('UPDATE `wotlk-raids-graph-individual-healingreceived` SET time = "'.$strings[1].'", amount = "'.$strings[2].'" WHERE attemptid = "'.$raidExistsAttempts[$key].'" AND charid = "'.$charsByKey[$k].'";');
								}*/
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		print "38 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 80 WHERE id = '.$cronid);
		
		// Auras
		/*
		* All of them have to be tested.
		*
		* buffs[attemptid][abilityid] = Array(1 => amount, 2 => active);
		* procs[attemptid][abilityid] = Array(1 => amount, 2 => chance);
		* individualBuffs[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
		* individualProcs[attemptid][charid][abilityid] = Array(1 => amount, 2 => chance);
		* individualBuffsByPlayer[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
		* debuffs[attemptid][abilityid] = Array(1 => amount, 2 => active);
		* individualDebuffs[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
		* individualDebuffsByPlayer[attemptid][charid][abilityid] = Array(1 => amount, 2 => active);
		*/
		// v-raids-buffs
		// New Buffsystem
		
		// How does merging work here?
		// If the second half of the log is uploaded first and then the first half, this might have issues here with merging. Lets see.
		$sql = 'INSERT INTO `wotlk-raids-newbuffs` (charid, abilityid, cbtstart, cbtend, rid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$sqlUpdate = 'INSERT INTO `wotlk-raids-newbuffs` (charid, abilityid, cbtstart, cbtend, rid) VALUES ';
		$cacheUpdateArray = array();
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		
		if ($mergeBoolean){
			foreach($this->db->query('SELECT * FROM `wotlk-raids-newbuffs` WHERE rid = '.$mergeBoolean) as $row){
				if (!isset($cacheUpdateArray[$row->charid]))
					$cacheUpdateArray[$row->charid] = array();
				if (!isset($cacheUpdateArray[$row->charid][$row->abilityid]))
					$cacheUpdateArray[$row->charid][$row->abilityid] = $row;
			}
		}
		
		foreach($this->newBuffs as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1]) && isset($var[2]) && $var[1] != "" && $var[2] != "" && isset($charsByKey[$k]) && $key != ""){
						if ($mergeBoolean){
							$extraTime = $this->getExtraTime($mergeBoolean, null, $raids[$key]);
							if (isset($cacheUpdateArray[$charsByKey[$k]][($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])])){
								$f = $q->fetch();
								$qq = array();
								$qq[1] = explode(",",$cacheUpdateArray[$charsByKey[$k]][($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])]->cbtstart);
								$qq[2] = explode(",",$var[1]);
								$qq[3] = explode(",",$var[2]);
								$qq[4] = explode(",",$cacheUpdateArray[$charsByKey[$k]][($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])]->cbtend);
								if (sizeOf($qq[1])>sizeOf($qq[4]))
									$f->cbtend .= ",0";
								
								$last = -1;
								foreach ($qq[1] as $kk => $oo){
									if ($oo>$last)
										$last = $oo;
								}
								$newcbtstart = $cacheUpdateArray[$charsByKey[$k]][($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])]->cbtstart;
								$newcbtend = $cacheUpdateArray[$charsByKey[$k]][($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])]->cbtend;
								foreach($qq[2] as $qw => $qe){
									if ((intval($qe)+$extraTime)>$last){
										$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qe))];
										if ($extraTime==0)
											$iStartCBT = 0;
										$newcbtstart .= ",".round(intval($qe)+$extraTime-$iStartCBT,1);
										$newcbtend .= ",".round(intval($qq[3][$qw])+$extraTime-$iStartCBT,1);
									}
								}
								
								$insertQueryUpdate[] = '(?,?,?,?,?)';
								$insertDataUpdate[] = $charsByKey[$k];
								$insertDataUpdate[] = ($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke]);
								$insertDataUpdate[] = $newcbtstart;
								$insertDataUpdate[] = $newcbtend;
								$insertDataUpdate[] = $mergeBoolean;
							}else{
								$qp1 = explode(",",$var[1]);
								$qp2 = explode(",",$var[2]);
								$newcbtstart = "";
								$newcbtend = "";
								foreach($qp1 as $qw => $qr){
									$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qr))];
									if ($extraTime==0)
										$iStartCBT = 0;
									$newcbtstart .= ($r = ($newcbtstart != "") ? "," : "").round(intval($qr)+$extraTime-$iStartCBT, 1);
								}
								foreach($qp2 as $qw => $qr){
									$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qr))];
									if ($extraTime==0)
										$iStartCBT = 0;
									$newcbtend .= ($r = ($newcbtend != "") ? "," : "").round(intval($qr)+$extraTime-$iStartCBT, 1);
								}
								$insertQuery[] = '(?,?,?,?,?)';
								$insertData[] = $charsByKey[$k];
								$insertData[] = ($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke]);
								$insertData[] = $newcbtstart;
								$insertData[] = $newcbtend;
								$insertData[] = $raidsByZone[$key];
							}
						}else{
							$insertQuery[] = '(?,?,?,?,?)';
							$insertData[] = $charsByKey[$k];
							$insertData[] = ($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke]);
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $raidsByZone[$key];
						}
					}
				}
			}
		}
		
		if (!empty($insertQueryUpdate)) {
			$this->db->query('DELETE FROM `wotlk-raids-newbuffs` WHERE rid = '.$mergeBoolean);
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		$sql = 'INSERT INTO `wotlk-raids-newdebuffs` (charid, abilityid, cbtstart, cbtend, rid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$sqlUpdate = 'INSERT INTO `wotlk-raids-newdebuffs` (charid, abilityid, cbtstart, cbtend, rid) VALUES ';
		$cacheUpdateArray = array();
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		
		if ($mergeBoolean){
			foreach($this->db->query('SELECT * FROM `wotlk-raids-newdebuffs` WHERE rid = '.$mergeBoolean) as $row){
				if (!isset($cacheUpdateArray[$row->charid]))
					$cacheUpdateArray[$row->charid] = array();
				if (!isset($cacheUpdateArray[$row->charid][$row->abilityid]))
					$cacheUpdateArray[$row->charid][$row->abilityid] = $row;
			}
		}
		
		foreach($this->newDebuffs as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[1]) && isset($var[2]) && $var[1] != "" && $var[2] != "" && isset($charsByKey[$k]) && $key != ""){
						if ($mergeBoolean){
							$extraTime = $this->getExtraTime($mergeBoolean, null, $raids[$key]);
							if (isset($cacheUpdateArray[$charsByKey[$k]][($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])])){
								$f = $q->fetch();
								$qq = array();
								$qq[1] = explode(",",$cacheUpdateArray[$charsByKey[$k]][($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])]->cbtstart);
								$qq[2] = explode(",",$var[1]);
								$qq[3] = explode(",",$var[2]);
								$qq[4] = explode(",",$cacheUpdateArray[$charsByKey[$k]][($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])]->cbtend);
								if (sizeOf($qq[1])>sizeOf($qq[4]))
									$f->cbtend .= ",0";
								
								$last = -1;
								foreach ($qq[1] as $kk => $oo){
									if ($oo>$last)
										$last = $oo;
								}
								$newcbtstart = $cacheUpdateArray[$charsByKey[$k]][($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])]->cbtstart;
								$newcbtend = $cacheUpdateArray[$charsByKey[$k]][($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke])]->cbtend;
								foreach($qq[2] as $qw => $qe){
									if ((intval($qe)+$extraTime)>$last){
										$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qe))];
										if ($extraTime==0)
											$iStartCBT = 0;
										$newcbtstart .= ",".round(intval($qe)+$extraTime-$iStartCBT,1);
										$newcbtend .= ",".round(intval($qq[3][$qw])+$extraTime-$iStartCBT,1);
									}
								}
								
								$insertQueryUpdate[] = '(?,?,?,?,?)';
								$insertDataUpdate[] = $charsByKey[$k];
								$insertDataUpdate[] = ($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke]);
								$insertDataUpdate[] = $newcbtstart;
								$insertDataUpdate[] = $newcbtend;
								$insertDataUpdate[] = $mergeBoolean;
							}else{
								$qp1 = explode(",",$var[1]);
								$qp2 = explode(",",$var[2]);
								$newcbtstart = "";
								$newcbtend = "";
								foreach($qp1 as $qw => $qr){
									$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qr))];
									if ($extraTime==0)
										$iStartCBT = 0;
									$newcbtstart .= ($r = ($newcbtstart != "") ? "," : "").round(intval($qr)+$extraTime-$iStartCBT, 1);
								}
								foreach($qp2 as $qw => $qr){
									$iStartCBT = $this->instanceStart[$this->getInstanceId(intval($qr))];
									if ($extraTime==0)
										$iStartCBT = 0;
									$newcbtend .= ($r = ($newcbtend != "") ? "," : "").round(intval($qr)+$extraTime-$iStartCBT, 1);
								}
								$insertQuery[] = '(?,?,?,?,?)';
								$insertData[] = $charsByKey[$k];
								$insertData[] = ($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke]);
								$insertData[] = $newcbtstart;
								$insertData[] = $newcbtend;
								$insertData[] = $raidsByZone[$key];
							}
						}else{
							$insertQuery[] = '(?,?,?,?,?)';
							$insertData[] = $charsByKey[$k];
							$insertData[] = ($qrs = (intval($this->abilitiesById[$ke][3])>10) ? $this->abilitiesById[$ke][3] : $spells[$ke]);
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							$insertData[] = $raidsByZone[$key];
						}
					}
				}
			}
		}
		
		if (!empty($insertQueryUpdate)) {
			$this->db->query('DELETE FROM `wotlk-raids-newdebuffs` WHERE rid = '.$mergeBoolean);
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		/*$sql = 'INSERT INTO `wotlk-raids-buffs` (attemptid, abilityid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-buffs` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->buffs as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset(($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]))){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
							//$this->db->query('UPDATE `wotlk-raids-buffs` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							//$this->db->query('INSERT INTO `wotlk-raids-buffs` (attemptid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-procs
		$sql = 'INSERT INTO `wotlk-raids-procs` (attemptid, abilityid, amount, chance) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-procs` SET amount = greatest(?, amount), chance = greatest(?, chance) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->procs as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset(($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]))){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
							//$this->db->query('UPDATE `wotlk-raids-procs` SET amount = greatest("'.$var[1].'", amount), chance = greatest("'.$var[2].'", chance) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							//$this->db->query('INSERT INTO `wotlk-raids-procs` (attemptid, abilityid, amount, chance) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		/*// v-raids-debuffs
		$sql = 'INSERT INTO `wotlk-raids-debuffs` (attemptid, abilityid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-debuffs` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->debuffs as $k => $v){
			foreach($v as $key => $var){
				if (isset($var[1]) && isset(($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]))){
					if ($var[1]>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
							//$this->db->query('UPDATE `wotlk-raids-debuffs` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'"');
						}else{
							$insertQuery[] = '(?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
							$insertData[] = $var[1];
							$insertData[] = $var[2];
							//$this->db->query('INSERT INTO `wotlk-raids-debuffs` (attemptid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-individual-buffs
		$sql = 'INSERT INTO `wotlk-raids-individual-buffs` (attemptid, charid, abilityid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-buffs` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND abilityid = ? AND charid = ?');
		foreach($this->individualBuffs as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (isset($var[1]) && isset(($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]))){
							if ($var[1]>0){
								if (isset($raidExistsAttempts[$k])){
									$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]), $charsByKey[$ke]));
									//$this->db->query('UPDATE `wotlk-raids-individual-buffs` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'" AND charid = "'.$charsByKey[$ke].'"');
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									//$this->db->query('INSERT INTO `wotlk-raids-individual-buffs` (attemptid, charid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-individual-buffsbyplayer
		$sql = 'INSERT INTO `wotlk-raids-individual-buffsbyplayer` (attemptid, charid, abilityid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-buffsbyplayer` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND abilityid = ? AND charid = ?');
		foreach($this->individualBuffsByPlayer as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (isset($var[1]) && isset(($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]))){
							if ($var[1]>0){
								if (isset($raidExistsAttempts[$k])){
									$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]), $charsByKey[$ke]));
									//$this->db->query('UPDATE `wotlk-raids-individual-buffsbyplayer` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'" AND charid = "'.$charsByKey[$ke].'"');
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									//$this->db->query('INSERT INTO `wotlk-raids-individual-buffsbyplayer` (attemptid, charid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-individual-debuffs
		$sql = 'INSERT INTO `wotlk-raids-individual-debuffs` (attemptid, charid, abilityid, amount, active) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-debuffs` SET amount = greatest(?, amount), active = greatest(?, active) WHERE attemptid = ? AND abilityid = ? AND charid = ?');
		foreach($this->individualDebuffs as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (isset($var[1]) && isset(($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]))){
							if ($var[1]>0){
								if (isset($raidExistsAttempts[$k])){
									$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]), $charsByKey[$ke]));
									//$this->db->query('UPDATE `wotlk-raids-individual-debuffs` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'" AND charid = "'.$charsByKey[$ke].'"');
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									//$this->db->query('INSERT INTO `wotlk-raids-individual-debuffs` (attemptid, charid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-individual-debuffsbyplayer
		$sql = 'INSERT INTO `wotlk-raids-individual-debuffsbyplayer` (attemptid, charid, abilityid, amount, npcid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-individual-debuffsbyplayer`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, abilityid, amount, npcid) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDebuffsByPlayer as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->npcid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->npcid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->npcid][$row->abilityid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-debuffsbyplayer` SET amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ? AND charid = ? AND npcid = ?');
		foreach($this->individualDebuffsByPlayer as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $qq => $ss){
						foreach($ss as $key => $var){
							if (isset($var[1])){
								if ($var[1]>0){
									if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
									&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
									&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]) 
									&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->amount<$var[1]){
										if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id, $toDeleteUpdate)){
											$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id;
											$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
											$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$npcs[$qq]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id;
											$insertDataUpdate[] = $raidExistsAttempts[$k];
											$insertDataUpdate[] = $charsByKey[$ke];
											$insertDataUpdate[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
											$insertDataUpdate[] = $var[1];
											$insertDataUpdate[] = $npcs[$qq];
										}
										
										//$ustmt->execute(array($var[1], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]), $charsByKey[$ke], $npcs[$qq]));
										//$this->db->query('UPDATE `wotlk-raids-individual-debuffsbyplayer` SET amount = greatest("'.$var[1].'", amount), active = greatest("'.$var[2].'", active) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'" AND charid = "'.$charsByKey[$ke].'"');
									}else{
										$insertQuery[] = '(?, ?, ?, ?, ?)';
										$insertData[] = $attemptsWithDbId[$k][1];
										$insertData[] = $charsByKey[$ke];
										$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
										$insertData[] = $var[1];
										$insertData[] = $npcs[$qq];
										//$this->db->query('INSERT INTO `wotlk-raids-individual-debuffsbyplayer` (attemptid, charid, abilityid, amount, active) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'")');
									}
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		// v-raids-individual-procs
		// Maybe removing chance from update?
		$sql = 'INSERT INTO `wotlk-raids-individual-procs` (attemptid, charid, abilityid, amount, chance) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-individual-procs`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, abilityid, amount, chance) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualProcs as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->abilityid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `wotlk-raids-individual-procs` SET amount = greatest(?, amount), chance = greatest(?, chance) WHERE attemptid = ? AND abilityid = ? AND charid = ?');
		foreach($this->individualProcs as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (isset($var[1]) && isset($charsByKey[$ke])){
							if ($var[1]>0){
								if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]) 
								&& ($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->amount<$var[1] or $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->chance<$var[2])){
									if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id, $toDeleteUpdate)){
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id;
										$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charsByKey[$ke];
										$insertDataUpdate[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
										$insertDataUpdate[] = $var[1];
										$insertDataUpdate[] = $var[2];
									}
									
									//$ustmt->execute(array($var[1], $var[2], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]), $charsByKey[$ke]));
									//$this->db->query('UPDATE `wotlk-raids-individual-procs` SET amount = greatest("'.$var[1].'", amount), chance = greatest("'.$var[2].'", chance) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'" AND charid = "'.$charsByKey[$ke].'"');
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
									$insertData[] = $var[1];
									$insertData[] = $var[2];
									//$this->db->query('INSERT INTO `wotlk-raids-individual-procs` (attemptid, charid, abilityid, amount, chance) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var[1].'", "'.$var[2].'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		print "39 done <br />";
		
		// Deaths
		/*
		* All of them have to be tested
		* What happens if someone dies twice in an attempt?
		* 
		* deathsBySource[attemptid][charid][cbt] = Array(1 => killingblow(abilityid), 2 => time);
		* individualDeath[attemptid][charid][cbt][abilityid] = Array(1 => dmg, 2 => heal, 3 => time, 4 => npcid, 5 => gettype(hit/crit/crush));
		*/
		// v-raids-deaths
		$deathsByCBT = array();
		foreach($this->deathsBySource as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (!isset($raidExistsAttempts[$k])){
							//print $this->userById[$ke][0]."<br />";
							$ts = $this->getTimeStamp($var[2], $var[2]);
							$extraTime = $this->getExtraTime($mergeBoolean, null, $attemptsWithDbId[$k][8]);
							$abb = ($qrs = (intval($this->abilitiesById[$var[1]][3])>10) ? $this->abilitiesById[$var[1]][3] : $spells[$var[1]]);
							$this->db->query('INSERT INTO `wotlk-raids-deaths` (attemptid, charid, cbt, killingblow, time, flagid, flag) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.($key-$instanceStartById[$k]+$extraTime).'", "'.($rr = ($abb) ? $abb : intval($spells[$var[1]])).'", "'.$ts[1].'", "'.($r = ($var[4] == 1 && isset($npcs[$var[3]])) ? $npcs[$var[3]] : $charsByKey[$var[3]]).'", "'.$var[4].'")');
							$deathsByCBT[$k][$ke][round(($key-$instanceStartById[$k]+$extraTime))] = $this->db->query('SELECT id FROM `wotlk-raids-deaths` WHERE attemptid = "'.$attemptsWithDbId[$k][1].'" AND cbt = "'.round(($key-$instanceStartById[$k]+$extraTime)).'" AND charid = "'.$charsByKey[$ke].'"')->fetch()->id;
						}
					}
				}
			}
		}
		// v-raids-individual-death
		$sql = 'INSERT INTO `wotlk-raids-individual-death` (attemptid, deathid, charid, cbt, abilityid, dmg, heal, time, flagid, type, flag) VALUES ';
		$insertQuery = array();
		$insertData = array();
		foreach($this->individualDeath as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						foreach($var as $keys => $vars){
							if (!isset($raidExistsAttempts[$k])){
								$extraTime = $this->getExtraTime($mergeBoolean, null, $attemptsWithDbId[$k][8]);
								$ts = $this->getTimeStamp($vars[3], $vars[3]);
								$abb = ($qrs = (gettype($this->abilitiesById[$vars[6]][3])=="string") ? $this->abilitiesById[$vars[6]][4] : $this->abilitiesById[$vars[6]][3]);
								$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$k][1];
								$insertData[] = $deathsByCBT[$k][$ke][round(($key-$instanceStartById[$k]+$extraTime))];
								$insertData[] = $charsByKey[$ke];
								$insertData[] = ($vars[8]-$instanceStartById[$k]+$extraTime);
								$insertData[] = ($rr = ($abb) ? $abb : intval($spells[$vars[6]]));
								$insertData[] = $vars[1];
								$insertData[] = $vars[2];
								$insertData[] = $ts[1];
								$insertData[] = ($r = ($vars[7] == 1) ? $npcs[$vars[4]] : $charsByKey[$vars[4]]);
								$insertData[] = $vars[5];
								$insertData[] = $vars[7];
								//$this->db->query('INSERT INTO `wotlk-raids-individual-death` (attemptid, deathid, charid, cbt, abilityid, dmg, heal, time, flagid, type, flag) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$deathsByCBT[$k][$ke][round(($key-$instanceStartById[$k]))].'","'.$charsByKey[$ke].'", "'.($vars[8]-$instanceStartById[$k]).'", "'.($qrs = (gettype($this->abilitiesById[$var[6]][3])=="string") ? $this->abilitiesById[$var[6]][4] : $this->abilitiesById[$var[6]][3]).'", "'.$vars[1].'", "'.$vars[2].'", "'.$ts[1].'", "'.($r = ($vars[7] == 1) ? $npcs[$vars[4]] : $charsByKey[$vars[4]]).'", "'.$vars[5].'", "'.$vars[7].'")');
							}
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		print "40 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 90 WHERE id = '.$cronid);
		
		// Interrupts
		/*
		* All of them have to be tested (STILL TODO -> Time missing, also cbt?)
		* 
		* missedInterrupts[attemptid][npcid][charid] = Array(1 => abilityid, 2 => amount);
		* successfullInterruptsSum[attemptid][charid] = amount
		* missedInterruptsSum[attemptid][abilityid] = amount
		* individualInterrtups[attemptid][charid][cbt] = Array(1 => time, 2 => abilityid, 3 => npcid);
		*/
		// v-raids-interruptsmissed
		$sql = 'INSERT INTO `wotlk-raids-interruptsmissed` (attemptid, npcid, abilityid, targetid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-interruptsmissed`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, npcid, abilityid, targetid, amount) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->missedInterrupts as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->npcid]))
						$toUpdateTable[$row->attemptid][$row->npcid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->npcid][$row->targetid]))
						$toUpdateTable[$row->attemptid][$row->npcid][$row->targetid] = array();
					$toUpdateTable[$row->attemptid][$row->npcid][$row->targetid][$row->abilityid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `wotlk-raids-interruptsmissed` SET amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ? AND npcid = ? AND targetid = ?');
		foreach($this->missedInterrupts as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (isset($var[2])){
						if ($var[2]>0){
							if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]]) 
							&& isset($toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]][$charsByKey[$key]][($qrs = (intval($this->abilitiesById[$var[1]][3])>10) ? $this->abilitiesById[$var[1]][3] : $spells[$var[1]])]) 
							&& $toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]][$charsByKey[$key]][($qrs = (intval($this->abilitiesById[$var[1]][3])>10) ? $this->abilitiesById[$var[1]][3] : $spells[$var[1]])]->amount<$var[2]){
								if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]][$charsByKey[$key]][($qrs = (intval($this->abilitiesById[$var[1]][3])>10) ? $this->abilitiesById[$var[1]][3] : $spells[$var[1]])]->id, $toDeleteUpdate)){
									$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]][$charsByKey[$key]][($qrs = (intval($this->abilitiesById[$var[1]][3])>10) ? $this->abilitiesById[$var[1]][3] : $spells[$var[1]])]->id;
									$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
									$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$npcs[$ke]][$charsByKey[$key]][($qrs = (intval($this->abilitiesById[$var[1]][3])>10) ? $this->abilitiesById[$var[1]][3] : $spells[$var[1]])]->id;
									$insertDataUpdate[] = $raidExistsAttempts[$k];
									$insertDataUpdate[] = $npcs[$ke];
									$insertDataUpdate[] = ($qrs = (intval($this->abilitiesById[$var[1]][3])>10) ? $this->abilitiesById[$var[1]][3] : $spells[$var[1]]);
									$insertDataUpdate[] = $charsByKey[$key];
									$insertDataUpdate[] = $var[2];
								}
								
								//$ustmt->execute(array($var[2], $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$var[1]][3])>10) ? $this->abilitiesById[$var[1]][3] : $spells[$var[1]]), $npcs[$ke], $charsByKey[$key]));
								//$this->db->query('UPDATE `wotlk-raids-interruptsmissed` SET amount = greatest("'.$var[2].'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$var[1]][3])>10) ? $this->abilitiesById[$var[1]][3] : $spells[$var[1]]).'" AND npcid = "'.$npcs[$ke].'" AND targetid = "'.$charsByKey[$key].'"');
							}else{
								$insertQuery[] = '(?, ?, ?, ?, ?)';
								$insertData[] = $attemptsWithDbId[$k][1];
								$insertData[] = $npcs[$ke];
								$insertData[] = ($qrs = (intval($this->abilitiesById[$var[1]][3])>10) ? $this->abilitiesById[$var[1]][3] : $spells[$var[1]]);
								$insertData[] = $charsByKey[$key];
								$insertData[] = $var[2];
								//$this->db->query('INSERT INTO `wotlk-raids-interruptsmissed` (attemptid, npcid, abilityid, targetid, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$npcs[$ke].'", "'.($qrs = (intval($this->abilitiesById[$var[1]][3])>10) ? $this->abilitiesById[$var[1]][3] : $spells[$var[1]]).'", "'.$charsByKey[$key].'", "'.$var[2].'")');
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		/*// v-raids-interruptssum
		$sql = 'INSERT INTO `wotlk-raids-interruptssum` (attemptid, charid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-interruptssum` SET amount = greatest(?, amount) WHERE attemptid = ? AND charid = ?');
		foreach($this->successfullInterruptsSum as $k => $v){
			foreach($v as $key => $var){
				if (isset($var) && isset($charsByKey[$key])){
					if ($var>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var, $raidExistsAttempts[$k], $charsByKey[$key]));
							//$this->db->query('UPDATE `wotlk-raids-interruptssum` SET amount = greatest("'.$var.'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND charid = "'.$charsByKey[$key].'"');
						}else{
							$insertQuery[] = '(?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$key];
							$insertData[] = $var;
							//$this->db->query('INSERT INTO `wotlk-raids-interruptssum` (attemptid, charid, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$key].'", "'.$var.'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		// v-raids-individual-interrupts
		$sql = 'INSERT INTO `wotlk-raids-individual-interrupts` (attemptid, charid, abilityid, npcid, cbt, time) VALUES ';
		$insertQuery = array();
		$insertData = array();
		foreach($this->individualInterrupts as $k => $v){
			foreach($v as $ke => $va){
				if (isset($charsByKey[$ke])){
					foreach($va as $key => $var){
						if (!isset($raidExistsAttempts[$k]) && isset($attemptsWithDbId[$k][1])){
							$extraTime = $this->getExtraTime($mergeBoolean, null, $attemptsWithDbId[$k][8]);
							$ts = $this->getTimeStamp($var[1], $var[1]);
							$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = $charsByKey[$ke];
							$insertData[] = ($qrs = (intval($this->abilitiesById[$var[2]][3])>10) ? $this->abilitiesById[$var[2]][3] : $spells[$var[2]]);
							$insertData[] = $npcs[$var[3]];
							$insertData[] = ($key-$instanceStartById[$k]+$extraTime);
							$insertData[] = $ts[1];
							//$this->db->query('INSERT INTO `wotlk-raids-individual-interrupts` (attemptid, charid, abilityid, npcid, cbt, time) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.($qrs = (intval($this->abilitiesById[$var[2]][3])>10) ? $this->abilitiesById[$var[2]][3] : $spells[$var[2]]).'", "'.$npcs[$var[3]].'", "'.($key-$instanceStartById[$k]).'", "'.$ts[1].'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		/*// v-raids-interruptsmissedsum
		$sql = 'INSERT INTO `wotlk-raids-interruptsmissedsum` (attemptid, abilityid, amount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$ustmt = $this->db->prepare('UPDATE `wotlk-raids-interruptsmissedsum` SET amount = greatest(?, amount) WHERE attemptid = ? AND abilityid = ?');
		foreach($this->missedInterruptsSum as $k => $v){
			foreach($v as $key => $var){
				if (isset($var)){
					if ($var>0){
						if (isset($raidExistsAttempts[$k])){
							$ustmt->execute(array($var, $raidExistsAttempts[$k], ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key])));
							//$this->db->query('UPDATE `wotlk-raids-interruptsmissedsum` SET amount = greatest("'.$var.'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'"');
						}else{
							$insertQuery[] = '(?, ?, ?)';
							$insertData[] = $attemptsWithDbId[$k][1];
							$insertData[] = ($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]);
							$insertData[] = $var;
							//$this->db->query('INSERT INTO `wotlk-raids-interruptsmissedsum` (attemptid, abilityid, amount) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.($qrs = (intval($this->abilitiesById[$key][3])>10) ? $this->abilitiesById[$key][3] : $spells[$key]).'", "'.$var.'")');
						}
					}
				}
			}
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}*/
		
		print "41 done <br />";
		// Dispels
		/*
		* All of these have to be tested
		*
		* dispelsByAbility[attemptid][abilityid] = amount
		* dispelsByFriendly[attemptid][charid] = amount
		* individualDispelsByTarget[attemptid][charid][tarid] = amount;
		* individualDispelsByAbility[attemptid][charid][abilityid(the dispelled ability)] = amount;
		*/
		// v-raids-individual-dispelbytarget
		$sql = 'INSERT INTO `wotlk-raids-dispels` (attemptid, charid, targetid, amount, abilityid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		
		$toUpdateTable = array();
		$toDeleteUpdate = array();
		$toUpdateTableName = '`wotlk-raids-dispels`';
		$sqlUpdate = 'INSERT INTO '.$toUpdateTableName.' (id, attemptid, charid, targetid, amount, abilityid) VALUES ';
		$insertQueryUpdate = array();
		$insertDataUpdate = array();
		if ($mergeBoolean){
			$aids = "";
			foreach($this->individualDispelsByTarget as $k => $v){
				if (isset($k) && $k != "" && isset($raidExistsAttempts[$k]) && $raidExistsAttempts[$k] != ""){
					$aids .= ($r = ($aids !="") ? "," : "").$raidExistsAttempts[$k];
				}
			}
			if ($aids != ""){
				foreach($this->db->query('SELECT * FROM '.$toUpdateTableName.' WHERE attemptid IN ('.$aids.');') as $row){
					if (!isset($toUpdateTable[$row->attemptid]))
						$toUpdateTable[$row->attemptid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid]))
						$toUpdateTable[$row->attemptid][$row->charid] = array();
					if (!isset($toUpdateTable[$row->attemptid][$row->charid][$row->targetid]))
						$toUpdateTable[$row->attemptid][$row->charid][$row->targetid] = array();
					$toUpdateTable[$row->attemptid][$row->charid][$row->targetid][$row->abilityid] = $row;
				}
			}
		}
		
		//$ustmt = $this->db->prepare('UPDATE `wotlk-raids-dispels` SET amount = greatest(?, amount) WHERE attemptid = ? AND targetid = ? AND charid = ? AND abilityid = ?');
		foreach($this->individualDispelsByTarget as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					foreach($var as $keys => $vars){
						if (isset($vars) && isset($charsByKey[$key]) && isset($charsByKey[$ke])){
							if ($vars>0){
								if (isset($toUpdateTable[$raidExistsAttempts[$k]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]]) 
								&& isset($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]][($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys])]) 
								&& $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]][($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys])]->amount<$vars){
									if (!in_array($toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]][($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys])]->id, $toDeleteUpdate)){
										$toDeleteUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]][($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys])]->id;
										$insertQueryUpdate[] = '(?, ?, ?, ?, ?, ?)';
										$insertDataUpdate[] = $toUpdateTable[$raidExistsAttempts[$k]][$charsByKey[$ke]][$charsByKey[$key]][($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys])]->id;
										$insertDataUpdate[] = $raidExistsAttempts[$k];
										$insertDataUpdate[] = $charsByKey[$ke];
										$insertDataUpdate[] = $charsByKey[$key];
										$insertDataUpdate[] = $vars;
										$insertDataUpdate[] = ($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys]);
									}
									
									//$ustmt->execute(array($vars, $raidExistsAttempts[$k], $charsByKey[$key], $charsByKey[$ke], ($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys])));
									//$this->db->query('UPDATE `wotlk-raids-dispels` SET amount = greatest("'.$vars.'", amount) WHERE attemptid = "'.$raidExistsAttempts[$k].'" AND targetid = "'.$charsByKey[$key].'" AND charid = "'.$charsByKey[$ke].'" AND abilityid = "'.($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys]).'"');
								}else{
									$insertQuery[] = '(?, ?, ?, ?, ?)';
									$insertData[] = $attemptsWithDbId[$k][1];
									$insertData[] = $charsByKey[$ke];
									$insertData[] = $charsByKey[$key];
									$insertData[] = $vars;
									$insertData[] = ($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys]);
									//$this->db->query('INSERT INTO `wotlk-raids-dispels` (attemptid, charid, targetid, amount, abilityid) VALUES ("'.$attemptsWithDbId[$k][1].'", "'.$charsByKey[$ke].'", "'.$charsByKey[$key].'", "'.$vars.'", "'.($qrs = (intval($this->abilitiesById[$keys][3])>10) ? $this->abilitiesById[$keys][3] : $spells[$keys]).'")');
								}
							}
						}
					}
				}
			}
		}
		if (!empty($toDeleteUpdate)){
			$this->db->query('DELETE FROM '.$toUpdateTableName.' WHERE id IN ('.implode(",", $toDeleteUpdate).');');
		}
		if (!empty($insertQueryUpdate)) {
			$sqlUpdate .= implode(', ', $insertQueryUpdate);
			$stmt = $this->db->prepare($sqlUpdate);
			$stmt->execute($insertDataUpdate);
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		print "42 done <br />";
		$this->db->query('UPDATE cronjob SET progress = 95 WHERE id = '.$cronid);
		// Records
		// How about unrealistic values?
		// Fixing merges is required here.
		// v-rankings
		
		$VRankings = $this->getVRankings($charsByKey, $npcs, $attemptsWithDbIdByNpcId, $serverid, $classes, $npcRevTra, $npcsTra); // I have to sort it before, so I gotta check this later.
		$counter = array();
		$sql = 'INSERT INTO `wotlk-raids-records` (attemptid, type, realm, realmclass, realmtype, charid) VALUES ';
		$sql2 = 'INSERT INTO `wotlk-rankings` (bossid, type, charid, boval, aoval, bmval, amval, botime, aotime, bmtime, amtime, oattemptid, mattemptid, bochange, aochange, bmchange, amchange, aoamount, boamount) VALUES ';
		$insertQuery = array();
		$insertQuery2 = array();
		$insertQuery3 = array();
		$insertData = array();
		$insertData2 = array();
		$insertData3 = array();
		$deleting = array();
		$deleting2 = array();
		$bufferi = 1;
		foreach($VRankings as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					if (!isset($counter[$k][$ke][$var[17]]))
						$counter[$k][$ke][$var[17]] = array(
							1 => 0,
							2 => array(),
							3 => array()
						);
					if (!isset($counter[$k][$ke][$var[17]][2][$var[18]]))
						$counter[$k][$ke][$var[17]][2][$var[18]] = 0;
					if (!isset($counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]]))
						$counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]] = 0;
					$counter[$k][$ke][$var[17]][1] += 1; // Realm counter
					$counter[$k][$ke][$var[17]][2][$var[18]] += 1; // realm class counter
					$counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]] += 1;
					if (isset($var[15]) && isset($var[9]) && isset($key) && $key != "" && $var[9] != "" && $var[15]==true){
						if ($counter[$k][$ke][$var[17]][1]<=50 || $counter[$k][$ke][$var[17]][2][$var[18]] <= 50 || $counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]]<= 50){
							$deleting[1] .= ($r = (isset($deleting[1]) && $deleting[1] != '') ? ',' : '').$var[9];
							$deleting[2] .= ($r = (isset($deleting[2]) && $deleting[2] != '') ? ',' : '').$key;
							//$this->db->query('DELETE FROM `wotlk-raids-records` WHERE attemptid = "'.$var[9].'" AND type = "'.$ke.'" AND charid = "'.$key.'"');
							$insertQuery[] = '(?, ?, ?, ?, ?, ?)';
							$insertData[] = $var[9];
							$insertData[] = $ke;
							$insertData[] = $counter[$k][$ke][$var[17]][1];
							$insertData[] = $counter[$k][$ke][$var[17]][2][$var[18]];
							$insertData[] = $counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]];
							$insertData[] = $key;
							//$this->db->query('INSERT INTO `wotlk-raids-records` (attemptid, type, realm, realmclass, realmtype, charid) VALUES ("'.$var[9].'", "'.$ke.'", "'.$counter[$k][$ke][$var[17]][1].'", "'.$counter[$k][$ke][$var[17]][2][$var[18]].'", "'.$counter[$k][$ke][$var[17]][3][$realmtype[$ke][$var[18]]].'", "'.$key.'")');
						}
					}
					if (isset($var[16]) && $var[16]==true && isset($key) && isset($k) && $key != "" and $k != ""){
						$deleting2[1] .= ($r = (isset($deleting2[1]) && $deleting2[1] != '') ? ',' : '').$key;
						$deleting2[2] .= ($r = (isset($deleting2[2]) && $deleting2[2] != '') ? ',' : '').$k;
						//$this->db->query('DELETE FROM `wotlk-rankings` WHERE charid = "'.$key.'" AND type = "'.$ke.'" AND bossid = "'.$k.'"');
						if ($bufferi>30000){
							$insertQuery3[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
							$insertData3[] = $k;
							$insertData3[] = $ke;
							$insertData3[] = $key;
							$insertData3[] = $var[1];
							$insertData3[] = $var[2];
							$insertData3[] = $var[3];
							$insertData3[] = $var[4];
							$insertData3[] = $var[5];
							$insertData3[] = $var[6];
							$insertData3[] = $var[7];
							$insertData3[] = $var[8];
							$insertData3[] = $var[9];
							$insertData3[] = $var[10];
							$insertData3[] = $var[11];
							$insertData3[] = $var[12];
							$insertData3[] = $var[13];
							$insertData3[] = $var[14];
							$insertData3[] = $var[19];
							$insertData3[] = $var[20];
	
						}else{
							$insertQuery2[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
							$insertData2[] = $k;
							$insertData2[] = $ke;
							$insertData2[] = $key;
							$insertData2[] = $var[1];
							$insertData2[] = $var[2];
							$insertData2[] = $var[3];
							$insertData2[] = $var[4];
							$insertData2[] = $var[5];
							$insertData2[] = $var[6];
							$insertData2[] = $var[7];
							$insertData2[] = $var[8];
							$insertData2[] = $var[9];
							$insertData2[] = $var[10];
							$insertData2[] = $var[11];
							$insertData2[] = $var[12];
							$insertData2[] = $var[13];
							$insertData2[] = $var[14];
							$insertData2[] = $var[19];
							$insertData2[] = $var[20];
						}
						$bufferi++;
						//$this->db->query('INSERT INTO `wotlk-rankings` (bossid, type, charid, boval, aoval, bmval, amval, botime, aotime, bmtime, amtime, oattemptid, mattemptid, bochange, aochange, bmchange, amchange) VALUES ("'.$k.'", "'.$ke.'", "'.$key.'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'", "'.$var[5].'", "'.$var[6].'", "'.$var[7].'", "'.$var[8].'", "'.$var[9].'", "'.$var[10].'", "'.$var[11].'", "'.$var[12].'", "'.$var[13].'", "'.$var[14].'")');
					}
				}
			}
		}
		if (!empty($deleting)){
			$this->db->query('DELETE FROM `wotlk-raids-records` WHERE attemptid IN ('.$deleting[1].') AND charid IN ('.$deleting[2].')');
		}
		if (!empty($deleting2)){
			$this->db->query('DELETE FROM `wotlk-rankings` WHERE charid IN ('.$deleting2[1].') AND bossid IN ('.$deleting2[2].')');
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		if (!empty($insertQuery2)) {
			$sql2 .= implode(', ', $insertQuery2);
			$stmt = $this->db->prepare($sql2);
			$stmt->execute($insertData2);
		}
		if (!empty($insertQuery3)) {
			$sql2 .= implode(', ', $insertQuery3);
			$stmt = $this->db->prepare($sql2);
			$stmt->execute($insertData3);
		}
		
		// speed-runs
		$SpeedRunRanking = $this->getSpeedRunRanking($attemptsWithDbIdByNpcId, $guildid, $npcsById, $npcRevTra, $raids);
		$sql = 'INSERT INTO `wotlk-speed-runs` (raidnameid, guildid, fotime, foboss, foatime, foaboss, fmtime, fmboss, fmatime, fmaboss, oraidid, mraidid, fochange, foachange, fmchange, fmachange, foamount, fmamount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$deleting = array();
		foreach($SpeedRunRanking as $key => $var){
			if (isset($var[19]) && $var[19] && isset($key)){
				$deleting[1] .= ($r = (isset($deleting[1]) && $deleting[1] != '') ? ',' : '').$guildid;
				$deleting[2] .= ($r = (isset($deleting[2]) && $deleting[2] != '') ? ',' : '').$key;
				//$this->db->query('DELETE FROM `wotlk-speed-runs` WHERE guildid = "'.$guildid.'" AND raidnameid = "'.$key.'"');
				$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
				$insertData[] = $key;
				$insertData[] = $guildid;
				$insertData[] = $var[1];
				$insertData[] = $var[2];
				$insertData[] = $var[4];
				$insertData[] = $var[5];
				$insertData[] = $var[7];
				$insertData[] = $var[8];
				$insertData[] = $var[10];
				$insertData[] = $var[11];
				$insertData[] = intval($var[13]);
				$insertData[] = intval($var[14]);
				$insertData[] = $var[15];
				$insertData[] = $var[16];
				$insertData[] = $var[17];
				$insertData[] = $var[18];
				$insertData[] = $var[20];
				$insertData[] = $var[21];
				//$this->db->query('INSERT INTO `wotlk-speed-runs` (raidnameid, guildid, fotime, foboss, foatime, foaboss, fmtime, fmboss, fmatime, fmaboss, oraidid, mraidid, fochange, foachange, fmchange, fmachange) VALUES ("'.$key.'", "'.$guildid.'", "'.$var[1].'", "'.$var[2].'", "'.$var[4].'", "'.$var[5].'", "'.$var[7].'", "'.$var[8].'", "'.$var[10].'", "'.$var[11].'", "'.$var[13].'", "'.$var[14].'", "'.$var[15].'", "'.$var[16].'", "'.$var[17].'", "'.$var[18].'")');
			}
		}
		if (!empty($deleting)){
			$this->db->query('DELETE FROM `wotlk-speed-runs` WHERE guildid IN ('.$deleting[1].') AND raidnameid IN ('.$deleting[2].')');
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		// speed-kills
		$SpeedKillRanking = $this->getSpeedKillRanking($attemptsWithDbIdByNpcId, $guildid, $npcsById, $npcRevTra);
		$sql = 'INSERT INTO `wotlk-speed-kills` (bossid, guildid, fotime, foatime, fmtime, fmatime, fochange, foachange, fmchange, fmachange, oraidid, mraidid, foamount, fmamount) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$deleting = array();
		foreach($SpeedKillRanking as $key => $var){
			if (isset($var[11]) && isset($key) && $key != '' && isset($var[9]) && isset($var[10])){
				$deleting[1] .= ($r = (isset($deleting[1]) && $deleting[1] != '') ? ',' : '').$guildid;
				$deleting[2] .= ($r = (isset($deleting[2]) && $deleting[2] != '') ? ',' : '').$key;
				//$this->db->query('DELETE FROM `wotlk-speed-kills` WHERE guildid = "'.$guildid.'" AND bossid = "'.$key.'"');
				$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
				$insertData[] = $key;
				$insertData[] = $guildid;
				$insertData[] = $var[1];
				$insertData[] = $var[2];
				$insertData[] = $var[3];
				$insertData[] = $var[4];
				$insertData[] = $var[5];
				$insertData[] = $var[6];
				$insertData[] = $var[7];
				$insertData[] = $var[8];
				$insertData[] = $var[9];
				$insertData[] = $var[10];
				$insertData[] = $var[12];
				$insertData[] = $var[13];
				//$this->db->query('INSERT INTO `wotlk-speed-kills` (bossid, guildid, fotime, foatime, fmtime, fmatime, fochange, foachange, fmchange, fmachange, oraidid, mraidid) VALUES ("'.$key.'", "'.$guildid.'", "'.$var[1].'", "'.$var[2].'", "'.$var[3].'", "'.$var[4].'", "'.$var[5].'", "'.$var[6].'", "'.$var[7].'", "'.$var[8].'", "'.$var[9].'", "'.$var[10].'")');
			}
		}
		if (!empty($deleting)){
			$this->db->query('DELETE FROM `wotlk-speed-kills` WHERE guildid IN ('.$deleting[1].') AND bossid IN ('.$deleting[2].')');
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		$this->db->query('UPDATE cronjob SET progress = 99 WHERE id = '.$cronid);
		
		//immortal runs
		$immortalRuns = $this->getImmortalRuns($attemptsWithDbId, $guildid, $npcsById, $npcRevTra, $charsByKey);
		$sql = 'INSERT INTO `wotlk-immortal-runs` (fodeaths, foadeaths, modeaths, moadeaths, fochange, foachange, mochange, moachange, forid, foarid, morid, moarid, foamount, foaamount, moamount, moaamount, guildid, raidnameid) VALUES ';
		$insertQuery = array();
		$insertData = array();
		$deleting = array();
		foreach($immortalRuns as $k => $v){
			if ($v[15] && isset($k) && isset($guildid) && $k != '' && $guildid != ''){
				$deleting[1] .= ($r = (isset($deleting[1]) && $deleting[1] != '') ? ',' : '').$guildid;
				$deleting[2] .= ($r = (isset($deleting[2]) && $deleting[2] != '') ? ',' : '').$k;
				$insertQuery[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
				$insertData[] = $v[1];
				$insertData[] = $v[2];
				$insertData[] = $v[3];
				$insertData[] = $v[4];
				$insertData[] = $v[5];
				$insertData[] = $v[6];
				$insertData[] = $v[7];
				$insertData[] = $v[8];
				$insertData[] = intval($v[9]);
				$insertData[] = intval($v[10]);
				$insertData[] = intval($v[11]);
				$insertData[] = intval($v[12]);
				$insertData[] = $v[13];
				$insertData[] = $v[14];
				$insertData[] = $v[17];
				$insertData[] = $v[18];
				$insertData[] = intval($guildid);
				$insertData[] = intval($k);
			}
		}
		if (!empty($deleting)){
			$this->db->query('DELETE FROM `wotlk-immortal-runs` WHERE guildid IN ('.$deleting[1].') AND raidnameid IN ('.$deleting[2].')');
		}
		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$stmt = $this->db->prepare($sql);
			$stmt->execute($insertData);
		}
		
		print "43 done <br />";
 		
		foreach($raidsByZone as $var){
			// Get Database Offsets
			// Get all attempts used in this raid
			$offsets = array();
			$offlimits = array();
			$aids = $this->db->query('SELECT group_concat(id) as aids FROM `wotlk-raids-attempts` WHERE rid = "'.$var.'"')->fetch()->aids;
			if ($aids != ""){
				// Getting an idea where it may be
				$idea = $this->db->query('SELECT * FROM `wotlk-raids` WHERE rdy = 1 AND id<'.intval($var-10).' ORDER BY id DESC LIMIT 1')->fetch();
				$offlimits[1] = explode(",", $idea->casts);
				$offlimits[2] = explode(",", $idea->deaths);
				$offlimits[3] = explode(",", $idea->dispels);
				$offlimits[4] = explode(",", $idea->graphdmg);
				$offlimits[5] = explode(",", $idea->graphdmgt);
				$offlimits[6] = explode(",", $idea->graphheal);
				$offlimits[7] = explode(",", $idea->inddeath);
				$offlimits[8] = explode(",", $idea->inddbp);
				$offlimits[9] = explode(",", $idea->indddba);
				$offlimits[10] = explode(",", $idea->indddte);
				$offlimits[11] = explode(",", $idea->inddtbp);
				$offlimits[12] = explode(",", $idea->inddtfa);
				$offlimits[13] = explode(",", $idea->inddtfs);
				$offlimits[14] = explode(",", $idea->indhba);
				$offlimits[15] = explode(",", $idea->indhtf);
				$offlimits[16] = explode(",", $idea->indint);
				$offlimits[17] = explode(",", $idea->indprocs);
				$offlimits[18] = explode(",", $idea->indintm);
				$offlimits[19] = explode(",", $idea->newbuffs);
				$offlimits[20] = explode(",", $idea->newdebuffs);
				$offlimits[21] = explode(",", $idea->indrecords);
				$offlimits[22] = explode(",", $idea->loot);
				$offlimits[23] = explode(",", $idea->graphff);
				
				/*UPDATE `wotlk-raids` SET 
				casts = "0,99999999999",
				deaths = "0,99999999999",
				dispels = "0,99999999999",
				graphdmg = "0,99999999999",
				graphdmgt = "0,99999999999",
				inddbp = "0,99999999999",
				graphheal = "0,99999999999",
				inddeath = "0,99999999999",
				inddtbp = "0,99999999999",
				indddba = "0,99999999999",
				indddte = "0,99999999999",
				inddtfa = "0,99999999999",
				inddtfs = "0,99999999999",
				indhba = "0,99999999999",
				indhtf = "0,99999999999",
				indint = "0,99999999999",
				indprocs = "0,99999999999",
				indintm = "0,99999999999",
				newbuffs = "0,99999999999",
				newdebuffs = "0,99999999999",
				indrecords = "0,99999999999",
				loot = "0,99999999999",
				graphff = "0,99999999999" WHERE rdy = -1
				*/
				
				$offsets[1] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-casts` WHERE id>'.intval($offlimits[1][0]).' AND attemptid IN ('.$aids.')')->fetch();
				$offsets[2] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-deaths` WHERE id>'.intval($offlimits[2][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[3] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-dispels` WHERE id>'.intval($offlimits[3][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[4] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-graph-individual-dmgdone` WHERE id>'.intval($offlimits[4][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[5] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-graph-individual-dmgtaken` WHERE id>'.intval($offlimits[5][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[6] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-graph-individual-healingreceived` WHERE id>'.intval($offlimits[6][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[7] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-individual-death` WHERE id>'.intval($offlimits[7][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[8] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-individual-debuffsbyplayer` WHERE id>'.intval($offlimits[8][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[9] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-individual-dmgdonebyability` WHERE id>'.intval($offlimits[9][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[10] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-individual-dmgdonetoenemy` WHERE id>'.intval($offlimits[10][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[11] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-individual-dmgtakenbyplayer` WHERE id>'.intval($offlimits[11][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[12] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-individual-dmgtakenfromability` WHERE id>'.intval($offlimits[12][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[13] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-individual-dmgtakenfromsource` WHERE id>'.intval($offlimits[13][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[14] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-individual-healingbyability` WHERE id>'.intval($offlimits[14][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[15] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-individual-healingtofriendly` WHERE id>'.intval($offlimits[15][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[16] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-individual-interrupts` WHERE id>'.intval($offlimits[16][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[17] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-individual-procs` WHERE id>'.intval($offlimits[17][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[18] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-interruptsmissed` WHERE id>'.intval($offlimits[18][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[19] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-newbuffs` WHERE id>'.intval($offlimits[19][0]).' AND  rid = "'.$var.'"')->fetch();
				$offsets[20] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-newdebuffs` WHERE id>'.intval($offlimits[20][0]).' AND  rid = "'.$var.'"')->fetch();
				$offsets[21] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-records` WHERE id>'.intval($offlimits[21][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[22] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-graph-individual-friendlyfire` WHERE id>'.intval($offlimits[23][0]).' AND  attemptid IN ('.$aids.')')->fetch();
				$offsets[23] = $this->db->query('SELECT MIN(id) as min, MAX(id) as max FROM `wotlk-raids-loot` WHERE id>'.intval($offlimits[22][0]).' AND  attemptid IN ('.$aids.')')->fetch();
			
				for ($i=1; $i<24; $i++){
					if (intval($offsets[$i]->min)==0)
						$offsets[$i]->min = 0;
					if (intval($offsets[$i]->max)==0)
						$offsets[$i]->max = 0;
				}
				
				$this->db->query('UPDATE `wotlk-raids` SET rdy = "1", 
					casts = "'.$offsets[1]->min.','.$offsets[1]->max.'",
					deaths = "'.$offsets[2]->min.','.$offsets[2]->max.'",
					dispels = "'.$offsets[3]->min.','.$offsets[3]->max.'",
					graphdmg = "'.$offsets[4]->min.','.$offsets[4]->max.'",
					graphdmgt = "'.$offsets[5]->min.','.$offsets[5]->max.'",
					graphheal = "'.$offsets[6]->min.','.$offsets[6]->max.'",
					inddeath = "'.$offsets[7]->min.','.$offsets[7]->max.'",
					inddbp = "'.$offsets[8]->min.','.$offsets[8]->max.'",
					indddba = "'.$offsets[9]->min.','.$offsets[9]->max.'",
					indddte = "'.$offsets[10]->min.','.$offsets[10]->max.'",
					inddtbp = "'.$offsets[11]->min.','.$offsets[11]->max.'",
					inddtfa = "'.$offsets[12]->min.','.$offsets[12]->max.'",
					inddtfs = "'.$offsets[13]->min.','.$offsets[13]->max.'",
					indhba = "'.$offsets[14]->min.','.$offsets[14]->max.'",
					indhtf = "'.$offsets[15]->min.','.$offsets[15]->max.'",
					indint = "'.$offsets[16]->min.','.$offsets[16]->max.'",
					indprocs = "'.$offsets[17]->min.','.$offsets[17]->max.'",
					indintm = "'.$offsets[18]->min.','.$offsets[18]->max.'",
					newbuffs = "'.$offsets[19]->min.','.$offsets[19]->max.'",
					newdebuffs = "'.$offsets[20]->min.','.$offsets[20]->max.'",
					indrecords = "'.$offsets[21]->min.','.$offsets[21]->max.'",
					graphff = "'.$offsets[22]->min.','.$offsets[22]->max.'",
					loot = "'.$offsets[23]->min.','.$offsets[23]->max.'"
				WHERE id = "'.$var.'";');
				$this->db->query('UPDATE `wotlk-raids-uploader` SET rdy = "1" WHERE rid = "'.$var.'";');
				$this->db->query('UPDATE `wotlk-raids-attempts` SET rdy = "1" WHERE rid = "'.$var.'";');
			}
		}
		
		print "DONE!<br />";
		
		// Templates
		// v-raids-individual-
		/*foreach($this-> as $k => $v){
			foreach($v as $ke => $va){
				foreach($va as $key => $var){
					$this->db->query('INSERT INTO v-raids-individual- () VALUES ("'..'")');
				}
			}
		}
		// v-raids-
		foreach($this-> as $k => $v){
			foreach($v as $key => $var){
				$this->db->query('INSERT INTO v-raids- () VALUES ("'..'")');
			}
		}*/
	}
	
	private function isValidLog($kk, $npcsTra){
		foreach($this->attempts as $k => $v){
			if ((isset($this->instanceBosses[$v[2]]) or isset($this->instanceBosses[$npcsTra[$this->user[$v[2]][8]]])) && $v[1]==$kk)
				return true;
		}
		return false;
	}
	
	private function validLog($npcsTra){
		foreach($this->attempts as $k => $v){
			if (isset($this->instanceBosses[$v[2]]) or isset($this->instanceBosses[$npcsTra[$this->user[$v[2]][8]]]))
				return true;
		}
		return false;
	}
	
	private function isOldLog(){
		foreach($this->dmg as $key => $var){
			foreach($var as $ke => $va){
				if ($ke == "i"){
					$try = false;
					foreach($va as $k => $v){
						$try = true;
					}
					if ($try == true)
						return true;
				}
			}
		}
		return false;
	}
	
	public $superState = true;
	public function __construct($file, $db, $id){
		$this->db = $db;
		
		if ($file == ""){
			$this->superState = true;
			return true;
		}
		
		// Parse all files and assign them to a variable
		$pa = new LuaParser(file_get_contents($file));
		$arr = $pa->parse();
		$this->abilities = $arr["DPSMateAbility"];
		print "1 done <br />";
		$this->user = $arr["DPSMateUser"];
		print "2 done <br />";
		$this->dmg = $arr["DPSMateDamageDone"][0];
		print "3 done <br />";
		$this->dmgtaken = $arr["DPSMateDamageTaken"][0];
		print "4 done <br />";
		$this->edt = $arr["DPSMateEDT"][0];
		print "5 done <br />";
		$this->edd = $arr["DPSMateEDD"][0];
		print "6 done <br />";
		$this->dispels = $arr["DPSMateDispels"][0];
		print "7 done <br />";
		$this->interrupts = $arr["DPSMateInterrupts"][0];
		print "8 done <br />";
		$this->deaths = $arr["DPSMateDeaths"][0];
		print "9 done <br />";
		$this->ehealing = $arr["DPSMateEHealing"][0];
		print "10 done <br />";
		$this->thealing = $arr["DPSMateTHealing"][0];
		print "11 done <br />";
		$this->overhealing = $arr["DPSMateOverhealing"][0];
		print "12 done <br />";
		$this->thealingtaken = $arr["DPSMateHealingTaken"][0];
		print "13 done <br />";
		$this->ehealingtaken = $arr["DPSMateEHealingTaken"][0];
		print "14 done <br />";
		$this->absorbs = $arr["DPSMateAbsorbs"][0];
		print "15 done <br />";
		$this->auras = $arr["DPSMateAurasGained"][0];
		print "16 done <br />";
		$this->cbt = $arr["DPSMateCombatTime"];
		print "17 done <br />";
		$this->atmt = $arr["DPSMateAttempts"];
		print "18 done <br />";
		$this->loot = $arr["DPSMateLoot"];
		print "19 done <br />";
		$this->pinfo = $arr["DPSMatePlayer"];
		print "20 done <br />";
		unset($arr);
		//gc_collect_cycles();
		if (!isset($this->dmg) || !isset($this->thealing) || !isset($this->atmt) || !isset($this->pinfo)){
			$this->superState = true;
			return true;
		}
		$db->query('UPDATE cronjob SET progress = 10 WHERE id = '.$id);
		
		if (isset($this->user["Umgebung"]))
			$this->user["Umgebung"][8] = 50006;
		if (isset($this->user["Environment"]))
			$this->user["Environment"][8] = 50006;
		$this->userById = $this->sortById($this->user);
		print "21 done <br />";
		$this->abilitiesById = $this->sortById($this->abilities);
		$this->abByEntry = $this->sortByAnotherKey($this->abilities, 3);
		$this->npcByEntry = $this->sortByAnotherKey($this->user, 8);
		$this->getTotalTables();
		print "22 done <br />";
		$spells = array();
		$spellsTra = array();
		$spellsRevTra = array();
		$spellsRaw = array();
		foreach($this->db->query('SELECT id, name FROM wotlk_spells') as $row){
			if (isset($this->abByEntry[$row->id])){
				$spellsRaw[$row->id] = $row->name;
				$spells[$this->abByEntry[$row->id][0]] = $row->id;
				$spellsTra[$row->id] = $row->name;
				$spellsRevTra[$row->name] = $row->id;
			}
		}
		$npcs = array();
		$npcsById = array();
		$npcsTra = array();
		$npcsTraRev = array();
		$npcsTraMoreRev = array();
		foreach($this->db->query('SELECT id, name FROM wotlk_npcs') as $row){
			if (isset($this->npcByEntry[$row->id]) or $row->id>=50000){
				$npcs[$this->npcByEntry[$row->id][0]] = $row->id;
				$npcsById[$row->id] = $row->name;
				$npcsTra[$row->id] = $row->name;
				$npcsTraRev[$row->name] = $row->id;
			}
		}
		$diffi = 1; $diffiSize = 0;
		foreach($this->atmt as $k => $v){
			if (sizeOf($v)>1 && $diffiSize<sizeOf($v)){
				$diffi = intval(substr($k, strlen($k)-1, strlen($k)-1));
				$diffiSize = sizeOf($v);
			}
		}
		switch($diffi){
			case 1:
				$npcs[100000] = 50000; $this->npcByEntry[50000] = array(0=>100000,8=>"Assembly of Iron"); $this->user["Assembly of Iron"] = array(0=>100000, 8=>50000);
				$npcs[100001] = 32930; $this->npcByEntry[32930] = array(0=>100001,8=>"Kologarn"); $this->user["Kologarn"] = array(0=>100001, 8=>32930);
				$npcs[100002] = 33350; $this->npcByEntry[33350] = array(0=>100002,8=>"Mimiron"); $this->user["Mimiron"] = array(0=>100002, 8=>33350);
				$npcs[100003] = 50001; $this->npcByEntry[50001] = array(0=>100003,8=>"Beasts of Northrend");  $this->user["Beasts of Northrend"] = array(0=>100003, 8=>50001);
				$npcs[100004] = 50002; $this->npcByEntry[50002] = array(0=>100004,8=>"Faction Champions"); $this->user["Faction Champions"] = array(0=>100004, 8=>50002);
				$npcs[100005] = 50003; $this->npcByEntry[50003] = array(0=>100005,8=>"Twin Val'kyr"); $this->user["Twin Val'kyr"] = array(0=>100005, 8=>50003);
				$npcs[100006] = 50004; $this->npcByEntry[50004] = array(0=>100006,8=>"Blood Prince Council"); $this->user["Blood Prince Council"] = array(0=>100006, 8=>50004);
				$npcs[100007] = 36789; $this->npcByEntry[36789] = array(0=>100007,8=>"Valithria Dreamwalker"); $this->user["Valithria Dreamwalker"] = array(0=>100007, 8=>36789);
				$npcs[100008] = 50005; $this->npcByEntry[50005] = array(0=>100008,8=>"The Four Horsemen"); $this->user["The Four Horsemen"] = array(0=>100008, 8=>50005);
				$npcs[100009] = 50007; $this->npcByEntry[50007] = array(0=>100008,8=>"Gunship Battle"); $this->user["Gunship Battle"] = array(0=>100009, 8=>50007);
				break;
			case 2:
				$npcs[100000] = 50008; $this->npcByEntry[50008] = array(0=>100000,8=>"Assembly of Iron"); $this->user["Assembly of Iron"] = array(0=>100000, 8=>50008);
				$npcs[100001] = 34297; $this->npcByEntry[34297] = array(0=>100001,8=>"Kologarn"); $this->user["Kologarn"] = array(0=>100001, 8=>34297);
				$npcs[100002] = 50025; $this->npcByEntry[50025] = array(0=>100002,8=>"Mimiron"); $this->user["Mimiron"] = array(0=>100002, 8=>50025);
				$npcs[100003] = 50009; $this->npcByEntry[50009] = array(0=>100003,8=>"Beasts of Northrend");  $this->user["Beasts of Northrend"] = array(0=>100003, 8=>50009);
				$npcs[100004] = 50012; $this->npcByEntry[50012] = array(0=>100004,8=>"Faction Champions"); $this->user["Faction Champions"] = array(0=>100004, 8=>50012);
				$npcs[100005] = 50015; $this->npcByEntry[50015] = array(0=>100005,8=>"Twin Val'kyr"); $this->user["Twin Val'kyr"] = array(0=>100005, 8=>50015);
				$npcs[100006] = 50018; $this->npcByEntry[50018] = array(0=>100006,8=>"Blood Prince Council"); $this->user["Blood Prince Council"] = array(0=>100006, 8=>50018);
				$npcs[100007] = 38589; $this->npcByEntry[38589] = array(0=>100007,8=>"Valithria Dreamwalker"); $this->user["Valithria Dreamwalker"] = array(0=>100007, 8=>38589);
				$npcs[100008] = 50021; $this->npcByEntry[50021] = array(0=>100008,8=>"The Four Horsemen"); $this->user["The Four Horsemen"] = array(0=>100008, 8=>50021);
				$npcs[100009] = 50022; $this->npcByEntry[50022] = array(0=>100008,8=>"Gunship Battle"); $this->user["Gunship Battle"] = array(0=>100009, 8=>50022);
				break;
			case 3:
				$npcs[100000] = 50000; $this->npcByEntry[50000] = array(0=>100000,8=>"Assembly of Iron"); $this->user["Assembly of Iron"] = array(0=>100000, 8=>50000);
				$npcs[100001] = 32930; $this->npcByEntry[32930] = array(0=>100001,8=>"Kologarn"); $this->user["Kologarn"] = array(0=>100001, 8=>32930);
				$npcs[100002] = 33350; $this->npcByEntry[33350] = array(0=>100002,8=>"Mimiron"); $this->user["Mimiron"] = array(0=>100002, 8=>33350);
				$npcs[100003] = 50010; $this->npcByEntry[50010] = array(0=>100003,8=>"Beasts of Northrend");  $this->user["Beasts of Northrend"] = array(0=>100003, 8=>50010);
				$npcs[100004] = 50013; $this->npcByEntry[50013] = array(0=>100004,8=>"Faction Champions"); $this->user["Faction Champions"] = array(0=>100004, 8=>50013);
				$npcs[100005] = 50016; $this->npcByEntry[50016] = array(0=>100005,8=>"Twin Val'kyr"); $this->user["Twin Val'kyr"] = array(0=>100005, 8=>50016);
				$npcs[100006] = 50019; $this->npcByEntry[50019] = array(0=>100006,8=>"Blood Prince Council"); $this->user["Blood Prince Council"] = array(0=>100006, 8=>50019);
				$npcs[100007] = 38174; $this->npcByEntry[38174] = array(0=>100007,8=>"Valithria Dreamwalker"); $this->user["Valithria Dreamwalker"] = array(0=>100007, 8=>38174);
				$npcs[100008] = 50005; $this->npcByEntry[50005] = array(0=>100008,8=>"The Four Horsemen"); $this->user["The Four Horsemen"] = array(0=>100008, 8=>50005);
				$npcs[100009] = 50023; $this->npcByEntry[50023] = array(0=>100008,8=>"Gunship Battle"); $this->user["Gunship Battle"] = array(0=>100009, 8=>50023);
				break;
			case 4:
				$npcs[100000] = 50008; $this->npcByEntry[50008] = array(0=>100000,8=>"Assembly of Iron"); $this->user["Assembly of Iron"] = array(0=>100000, 8=>50008);
				$npcs[100001] = 34297; $this->npcByEntry[34297] = array(0=>100001,8=>"Kologarn"); $this->user["Kologarn"] = array(0=>100001, 8=>34297);
				$npcs[100002] = 50025; $this->npcByEntry[50025] = array(0=>100002,8=>"Mimiron"); $this->user["Mimiron"] = array(0=>100002, 8=>50025);
				$npcs[100003] = 50011; $this->npcByEntry[50011] = array(0=>100003,8=>"Beasts of Northrend");  $this->user["Beasts of Northrend"] = array(0=>100003, 8=>50011);
				$npcs[100004] = 50014; $this->npcByEntry[50014] = array(0=>100004,8=>"Faction Champions"); $this->user["Faction Champions"] = array(0=>100004, 8=>50014);
				$npcs[100005] = 50017; $this->npcByEntry[50017] = array(0=>100005,8=>"Twin Val'kyr"); $this->user["Twin Val'kyr"] = array(0=>100005, 8=>50017);
				$npcs[100006] = 50020; $this->npcByEntry[50020] = array(0=>100006,8=>"Blood Prince Council"); $this->user["Blood Prince Council"] = array(0=>100006, 8=>50020);
				$npcs[100007] = 38590; $this->npcByEntry[38590] = array(0=>100007,8=>"Valithria Dreamwalker"); $this->user["Valithria Dreamwalker"] = array(0=>100007, 8=>38590);
				$npcs[100008] = 50021; $this->npcByEntry[50021] = array(0=>100008,8=>"The Four Horsemen"); $this->user["The Four Horsemen"] = array(0=>100008, 8=>50021);
				$npcs[100009] = 50024; $this->npcByEntry[50024] = array(0=>100008,8=>"Gunship Battle"); $this->user["Gunship Battle"] = array(0=>100009, 8=>50024);
				break;
		}
		$db->query('UPDATE cronjob SET progress = 20 WHERE id = '.$id);
		$this->getAttempts($npcsTra, $npcsTraRev);
		if (!$this->validLog($npcsTra)){
			$this->superState = true;
			return true;
		}
		print "23 done <br />";
		$this->sortAttemptsToNpc($npcsTra);
		print "24 done <br />";
		$this->getParticipants($spellsTra, $npcs);
		print "25 done <br />";
		$this->getDmgDone($npcsTraRev, $npcsTra, $spellsRevTra, $npcs);
		print "26 done <br />";
		$db->query('UPDATE cronjob SET progress = 30 WHERE id = '.$id);
		$this->getDmgTaken($npcsTraRev, $npcsTra, $npcs);
		print "27 done <br />";
		$this->getHealing($npcs, $spellsRaw);
		print "28 done <br />";
		$this->getAuras($spellsTra, $spellsRevTra, $spellsRaw, $spells);
		print "29 done <br />";
		$db->query('UPDATE cronjob SET progress = 40 WHERE id = '.$id);
		$this->getDeaths();
		print "30 done <br />";
		$this->getInterrupts($spellsTra, $spellsRevTra, $spellsRaw, $spells);
		print "31 done <br />";
		$this->getDispels($spellsTra, $spellsRevTra);
		print "32 done <br />";
		$db->query('UPDATE cronjob SET progress = 50 WHERE id = '.$id);
		
		//gc_collect_cycles();
		$this->writeIntoDB($spells, $npcs, $npcsById, $npcsTra, $npcsTraRev, $spellsTra, $spellsRevTra, $id, $spellsRaw);
		$this->superState = $this->supersuperstate;
		return $this->supersuperstate;
	}
}


?>