<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $men = 4;
	private $user = array();
	private $levelNames = array(
		0 => "None",
		1 => "Bronze",
		2 => "Silver",
		3 => "Gold",
	);
	
	private function loadUser(){
		$cred = explode(",", base64_decode($_COOKIE["lluser"]));
		$cred[0] = $this->antiSQLInjection($cred[0]);
		$cred[1] = $this->antiSQLInjection($cred[1]);
		$this->user = $this->db->query('SELECT * FROM `user` WHERE name = "'.$cred[0].'" AND pass = "'.$cred[1].'" LIMIT 1;')->fetch();
		if (intval($this->user->id)==0){
			header('Location: ../SignIn');
			exit();
		}
	}
	
	public function content(){
		$this->loadUser();
		if ($this->men>$this->user->level && $this->men != 4){
			header('Location: index.php');
			exit();
		}
		$content = '
		<div class="container" id="container">
			<section class="ttitle top">Account Manager</section>
			<section class="table">
				<div class="right">
					<div class="acc-nav">
						<a href="{path}Service/Account/"><button'.(($this->men==0) ? ' id="selected"' : '').'>Summary</button></a>
		';
		if ($this->user->level>=1)
			$content .= '
						<a href="{path}Service/Account/?s=1"><button'.(($this->men==1) ? ' id="selected"' : '').'>Bronze</button></a>
			';
		if ($this->user->level>=2)
			$content .= '
						<a href="{path}Service/Account/?s=2"><button'.(($this->men==2) ? ' id="selected"' : '').'>Silver</button></a>
			';
		if ($this->user->level>=3)
			$content .= '
						<a href="{path}Service/Account/?s=3"><button'.(($this->men==3) ? ' id="selected"' : '').'>Gold</button></a>
			';
		$content .= '
						<a href="{path}Service/Account/?s=4"><button'.(($this->men==4) ? ' id="selected"' : '').'>Settings</button></a>
					</div>
					<div class="acc-con">
		';
		if ($this->men==1){
			$content .= '
				<form action="changeDisabled.php" method="POST">
					<table cellspacing="0" id="disable">
						<tr>
							<td><input type="checkbox" name="disabled" id="dis" onChange="this.form.submit()" '.((intval($this->user->ads)==1) ? 'checked' : '').'/><label for="dis"></label></td>
							<td>Disable advertisements</td>
						</tr>
					</table>
				</form>
			';
		}elseif ($this->men==2){
			$num = $this->db->query('SELECT count(id) as num FROM `user-silver-chars` WHERE accid = '.$this->user->id.';')->fetch()->num;
			$content .= '
				<div class="acc-con-top">
					<div class="pseudoButton">'.$num.'</div>
			';
			if ($num<10){
				$content .= '
					<form action="addChar.php" method="POST">
						<input type="text" placeholder="Character..." name="char" required/>
						<input type="submit" value="Add" />
					</form>
				';
			}
			$content .= '
				</div>
				<form action="removeChar.php" method="POST">
					<table cellspacing="0" id="chars">
						<tbody>
			';
			$i = 1;
			foreach($this->db->query('SELECT id, name FROM `user-silver-chars` WHERE accid = '.$this->user->id.' ORDER BY id DESC;') as $usc){
				$content .= '
							<tr>
								<td>'.$usc->name.'</td>
								<td><input type="hidden" name="cidVal-'.$i.'" value="'.base64_encode($usc->id).'" /><input type="submit" name="cid-'.$i.'" value="Remove" /></td>
							</tr>
				';
				$i++;
			}
			$content .= '
						</tbody>
					</table>
				</form>
			';
		}elseif ($this->men==3){
			$q = $this->db->query('SELECT id, title FROM poll ORDER BY id DESC LIMIT 1')->fetch();
			if (!isset($q)){
				$q->id = 0;
				$q->title = "None";
			}
			$content .= '
				<script>function vote(chcd, elem){for(var i=1; i<=10; i++){if (document.getElementById("option-"+i)){document.getElementById("option-"+i).checked=null}}; document.getElementById(elem).checked=chcd;}</script>
				<form action="votePoll.php" method="POST" id="poll">
					<input type="hidden" value="'.$q->id.'" name="pid" />
					<span>'.$q->title.'</span>
					<table cellspacing="0">
			';
			$numTotal = $this->db->query('SELECT COUNT(id) as num FROM `poll-votes` WHERE pollid = '.$q->id.';')->fetch()->num;
			if ($numTotal==0)
				$numTotal = 1;
			$votedNum = intval($this->db->query('SELECT optionid FROM `poll-votes` WHERE pollid = '.$q->id.' AND accid = "'.$this->user->id.'";')->fetch()->optionid);
			foreach($this->db->query('SELECT * FROM `poll-options` WHERE pollid='.$q->id.';') as $row){
				$content .= '
						<tr>
							<td><input type="checkbox" name="option-'.$row->num.'" id="option-'.$row->num.'" onChange="vote(this.checked, \'option-'.$row->num.'\')" '.(($votedNum==$row->num) ? "checked" : "").'/><label for="option-'.$row->num.'"></label></td>
							<td>'.$row->option.'</td>
							<td>'.(100*round($this->db->query('SELECT COUNT(id) as num FROM `poll-votes` WHERE pollid = '.$q->id.' AND optionid = '.$row->id.';')->fetch()->num/$numTotal, 2)).'%</td>
						</tr>
				';
			}
			$content .= '
					</table>
					<input type="submit" value="Vote now" id="pollsubmit" />
				</form>
			';
		}elseif ($this->men==4){
			$content .= '
				<form action="changeSettings.php" method="POST">
					<table cellspacing="0" id="settings">
						<tr>
							<td>
								<input type="text" name="mail" placeholder="Mail address" />
								<input type="password" name="pass" placeholder="Your password" />
							</td>
							<td>
								<input type="submit" name="chmail" value="Change mail" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="password" name="passnew" placeholder="New password" />
								<input type="password" name="passnewconf" placeholder="Confirm new password" />
								<input type="password" name="oldpass" placeholder="Old password" />
							</td>
							<td>
								<input type="submit" name="chpass" value="Change password" />
							</td>
						</tr>
					</table>
				</form>
			';
		}else{
			$content .= '
				<table cellspacing="0">
					<tr>
						<td>Name</td>
						<td>'.$this->user->name.'</td>
					</tr>
					<tr>
						<td>E-Mail</td>
						<td>'.$this->user->mail.'</td>
					</tr>
					<tr>
						<td>Level</td>
						<td>'.$this->levelNames[$this->user->level].'</td>
					</tr>
					<tr>
						<td>Patreon</td>
						<td>'.((intval($this->user->patreon)>0) ? 'Patreon since '.date("d.m.y", $this->user->patreon) : 'Become a <a href="https://patreon.com/legacylogs">patreon!</a>').'</td>
					</tr>
				</table>
			';
		}
		$content .= '
					</div>
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $men){
		$this->men = intval($this->antiSQLInjection($men));
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["s"]);

?>