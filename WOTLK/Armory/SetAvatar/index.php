<?php
require(dirname(__FILE__)."/../../../init.php");

class Home extends Site{
	private $sname = "Unknown";
	private $name = "Unknown";
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>Introduction</h1>
					<p>
						You have probably noticed that Legacy Logs is not using some kind of model viewer. Instead I implemented a system to give you the opportunity to customize your character wallpaper, allowing more individualisation than a model viewer could provide. <br />
						This is <a href="{path}Vanilla/Armory/Kronos/Anri">Anri</a> for example. As you can see his character is displayed differently. You can design it however you want. That said, it is not completly without restrictions.
					</p>
					<h1>Restrictions</h1>
					<p>
						Not allowed are: <br />
						1. Insults in any way <br />
						2. Anything that relates with racism or antisemitism <br />
						2. Any symbols that are prohibited by law <br /> <br />
						I retain the right to block anything that I don\'t accept for reasons that might not be listed here at that moment. I also retain the right to adjust this list however I want. Therefore every wallpaper must be verified by me before it is displayed.
					</p>
					<h1>Materials and required size</h1>
					<p>
						The wallpaper requires to be 640x542. You can download a package of templates that I used to generate the default wallpapers <a href="{path}TBC/Armory/SetAvatar/template.zip">here</a>.<br />
						'.($r = (isset($_GET["b"])) ? ($rr = ($_GET["b"] == 1) ? "<span id=\"success\">Success! Your wallpaper will be processed soon!</span>" : "<span id=\"failure\">Something went wrong :( Please try it later again.</span>") : "").'
					</p>
					<h1>Upload</h1>
					<p>
						By uploading your wallpaper you agree to the terms of use, stated above and confirm that you didn\'t put such things into the wallpaper.<br /><br />
						<form action="{path}TBC/Armory/SetAvatar/work.php" method="post" enctype="multipart/form-data">
							<input type="hidden" value="'.$this->sname.','.$this->name.'" name="info" />
							<input name="img" type="file" size="50" accept="text/*"> <br />
							<button style="width: 150px; margin-top: 10px;">Upload</button>
						</form>
					</p>
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir){
		$this->sname = $this->antiSQLInjection($_GET["server"]);
		$this->name = $this->antiSQLInjection($_GET["name"]);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__);

?>