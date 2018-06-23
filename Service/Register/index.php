<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $errmsg = array(
		1 => 'Something went wrong, please <a href="{path}Service/Contact">contact</a> Shino!',
		2 => "Name is already taken.",
		3 => "Email is invalid!",
	);
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>Register</h1>
					<p>
						Make sure to use the same mail address as on patreon in order to receive rewards.<br />
						Also make sure not to use any special characters. Those are not allowed.<br />
						You already have an account? <br /><a href="{path}Service/SignIn">Sign In</a><br />
						'.((intval($_GET["s"])>0) ? '<span id="failure">'.$this->errmsg[intval($_GET["s"])].'</span>' : '').'
					</p>
				</div>
			</section>
			<section class="centredNormal formular">
				<form action="work.php" method="post">
					<input type="text" name="user" placeholder="Username" required/>
					<input type="text" name="mail" placeholder="Mail" required/>
					<input type="text" name="conmail" placeholder="Confirm mail" required/>
					<input type="password" name="pass" placeholder="Password" required/>
					<input type="password" name="conpass" placeholder="Confirm password" required/><br /><br /><br /><br /><br /><br /><br /><br />
					<input type="submit" value="Register" name="submit" />
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