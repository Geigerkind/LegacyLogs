<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>Sign In</h1>
					<p>
						Please enter your user credentials to sign in or <a href="{path}Service/Register">register</a> a new account.<br />
						'.((intval($_GET["s"])==1) ? '<span id="failure">Wrong username or password.' : '').'
					</p>
				</div>
			</section>
			<section class="centredNormal formular">
				<form action="work.php" method="post">
					<input type="text" name="user" placeholder="Your username..." required/>
					<input type="password" name="pass" placeholder="Your password..." required/><br /><br /><br />
					<input type="submit" value="Sign In" name="submit" />
				</form>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir){
		if (isset($_COOKIE["lluser"]) && strlen($_COOKIE["lluser"])>10){
			header('Location: ../Account');
			exit();
		}
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__);

?>