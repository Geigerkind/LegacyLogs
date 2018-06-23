<?php
define("ROOT", dirname(__FILE__));

abstract class Site extends phpquery {
	public $db = null;
	public $siteTitle = "";
	public $keyWords = "";
	private $doc = null;
	private $dir = null;
	private $js = array();
	private $jsLink = array();
	private $cssLink = array();
	public $metadesc = "Legacy Logs is an advanced combat evaluation site for World of Warcraft, providing in depth information about raid boss fights, pvp and pve rankings.";
	
	public abstract function content();
	//public abstract function addExternalCss();
	
	public function addExternalJs(){
		foreach ($this->jsLink as $var){
			pq("head")->append("<script src='".$var[1]."'".($r = (!$var[2]) ? " defer" : "")."></script>");
		}
		
		foreach ($this->js as $var){
			pq("head")->append("<script>".$var."</script>");
		}
	}
	
	public function addExternalCss(){
		foreach ($this->cssLink as $var){
			pq("head")->append("<link rel='stylesheet' href='".$var."' />");
		}
	}
	
	public function addJs($val){
		array_push($this->js, $val);
	}
	
	public function addJsLink($val,$bool){
		array_push($this->jsLink, array(1=>$val,2=>$bool));
	}
	
	public function addCssLink($val){
		array_push($this->cssLink, $val);
	}
	
	private function addCss(){
		$css = "";
		$pat = (($_SERVER["HTTP_HOST"] == '127.0.0.1') ? "\\" : "/");
		$mes = explode($pat, $this->dir);
		$next = false; $free = false; $path = "";
		foreach($mes as $var){
			if ($var != "" && $free){
				$css .= ($r = ($next) ? ", " : "").$premod.'#'.($r = (in_array($var, array("2vs2","3vs3","5vs5"))) ? "Arena" : "").$var;
				$path .= ($r = ($next) ? "/" : "").$var;
				$next = true;
			}
			if ($var == "Raidlogger" || $var == "public_html" || $var == "html")
				$free = true;
			$premod = "";
			if ($var == "TBC")
				$premod = "#TBCNav ";
			if ($var == "Vanilla")
				$premod = "#VanillaNav ";
			if ($var == "WOTLK")
				$premod = "#WOTLKNav ";
		}
		$css .= ', #mode'.intval($_GET["mode"]).'{color: #f28f45 !important;}';
		$css .= '#cogwheel{width: 130px !important;} #cogwheel img{border:none;box-shadow:none;}';
		$list = array("Vanilla", "TBC", "Contribute", "Addons", "Service", "Queue");
		foreach($list as $var){
			if (strpos($css, $var) !== FALSE){
				$css .= '#'.$var.'Nav{border-bottom: 5px solid #f28f45;}';
				break;
			}
		}
		
		if ($_SERVER["HTTP_HOST"] == '127.0.0.1'){
			$this->addCssLink('main.css');
			$this->addCssLink('http://127.0.0.1/Raidlogger/Site/css/edgeSupport.css');
		}else{
			if ($path != "")
				$this->addCssLink('/'.$path.'/main.css');
			else
				$this->addCssLink('/main.css');
			$this->addCssLink('/Site/css/edgeSupport.css');
		}
		pq('head')->append("<style>".$css."</style>");
	}
	
	public function in_array($arr, $val){
		foreach($arr as $key => $var){
			if ($key == $val || $var == $val)
				return true;
		}
		return false;
	}
	
	private function replaceKeys(){
		// path
		$path = "";
		$mes = explode($pat = ($_SERVER["HTTP_HOST"] == '127.0.0.1') ? "\\" : "/", $this->dir);
		$pos = sizeOf($mes) - array_search('Raidlogger', $mes);
		
		if ($_SERVER["HTTP_HOST"] == '127.0.0.1')
			for($i = 1; $i < $pos; $i++){ $path .= '../'; }
		else
			$path = "/";
		
		
		//account
		if (isset($_COOKIE["lluser"]) && $_COOKIE["lluser"]){
			$this->doc = str_replace(array('%7Baccount%7D', '{account}'), '<a href="{path}Service/Account">Account</a>', $this->doc);
		}else{
			$this->doc = str_replace(array('%7Baccount%7D', '{account}'), '<a href="{path}Service/SignIn">Sign In</a>', $this->doc);
		}
		
		/*if (defined("USERADS") && defined("USERLEVEL") && USERADS==1 && USERLEVEL>=1){
			$this->doc = str_replace(array('%7Badstwo%7D', '{adstwo}'), "", $this->doc);
			$this->doc = str_replace(array('%7Badsone%7D', '{adsone}'), "", $this->doc);
		}else{
			$this->doc = str_replace(array('%7Badsone%7D', '{adsone}'), "(function(w) {
var d=document,h=d.getElementsByTagName('head')[0],j=d.createElement('script'),k=d.createElement('script');
j.setAttribute('src','//cdn.adsoptimal.com/advertisement/settings/48153.js');
k.setAttribute('src','//cdn.adsoptimal.com/advertisement/manual.js');
h.appendChild(j); h.appendChild(k);
})(window);", $this->doc);
			$this->doc = str_replace(array('%7Badstwo%7D', '{adstwo}'), '<div class="adsoptimal-slot" style="width: 728px; height: 90px; margin: 0px auto;"></div>', $this->doc);
		}*/
		
		//$path .= '../../../../'; // ENABLE WHEN PUSHING!
		$this->doc = str_replace(array('%7Bpath%7D', '{path}'), $path, $this->doc);
		//title
		$this->doc = str_replace(array('%7Btitle%7D', '{title}'), $this->siteTitle, $this->doc);
		//keyWords
		$this->doc = str_replace(array('%7Botherkeywords%7D', '{otherkeywords}'), $this->keyWords, $this->doc);
		//metaDesc
		$this->doc = str_replace(array('%7Bmetadescription%7D', '{metadescription}'), $this->metadesc, $this->doc);
		
		//location
		//$this->doc = str_replace(array('%7Blocation%7D', '{location}'), $_SERVER['REQUEST_URI'], $this->doc);
	}
	
	private function cookies(){
		if (!$_COOKIE["cookieNew"]==1){
			pq('body')->append('<div id="cookie">
				<div id="c">
					This website or its third party tools use cookies, which are necessary to its functioning. If you continue browsing this website, we\'ll assume that you agree.<br />
					<button onclick="document.cookie = \'cookie=1; expires=Thu, 18 Dec 2020 12:00:00 UTC\';document.getElementById(\'cookie\').style.display=\'none\';">Accept</button>
				</div>
			</div>');
			setcookie("cookieNew", 1, time()+31536000);
		}
	}
	
	public function antiSQLInjection($str){
		return str_replace(array(';', '"', '\'', '<', '>', '=', '@', '*', 'DELETE FROM', '`', 'RESET', 'ALL', '-'), "", $str);
	}
	
	public function mReadable($num){
		return number_format($num, 2, '.', ',');
	}
	
	public function mnReadable($num){
		return number_format($num, 0, '.', ',');
	}
	
	private function run(){
		$this->content();
		$this->cookies();
		$this->addCss();
		//$this->addExternalCss();
		$this->addExternalJs();
		$this->addExternalCss();
		$this->replaceKeys();
		print $this->doc;
	}
	
	public function __construct($db, $dir){
		$this->db = $db;
		$this->dir = $dir;
		$this->doc = $this->newDocumentFileHTML(ROOT."/../Site/index.html");
		$this->run();
	}
}

?>