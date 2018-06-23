<?php
require(dirname(__FILE__)."/../init.php");

class Home extends Site{
	private $page = 1;
	private $classById = array(
		1 => "warrior",
		2 => "rogue",
		3 => "priest",
		4 => "hunter",
		5 => "druid",
		6 => "mage",
		7 => "warlock",
		8 => "paladin",
		9 => "shaman",
		10 => "deathknight",
	);
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th>#</th>
							<th>Date of first submit</th>
							<th class="char">Character</th>
							<th>Server</th>
						</tr>
		';
		$count = $this->db->query('SELECT id as am FROM contributors')->rowCount();
		$max = floor($count/15+1);
		$i = 0;
		foreach ($this->db->query('SELECT a.id, a.time, b.name, b.classid, c.name as servername FROM contributors a JOIN chars b ON a.charid = b.id JOIN servernames c ON b.serverid = c.id ORDER BY a.id DESC LIMIT '.(($this->page-1)*15).', 15') as $row){
			$content .= '
						<tr>
							<td>'.($count-$i-$this->page*15+15).'</td>
							<td>'.date('d.m.y H:i', $row->time).'</td>
							<td class="char color-'.$this->classById[$row->classid].'"><img src="img/c'.$row->classid.'.png" />'.$row->name.'</td>
							<td>'.$row->servername.'</td>
						</tr>
			';
			$i++;
		}
		$content .= '
					</table>
				</div>
			</section>
			<footer class="pager">
				<div class="pleft">
					<a href="{path}Contributors/?page=1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}Contributors/?page='.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}Contributors/?page='.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}Contributors/?page='.$max.'"><button class="icon-button icon-darrowright"></button></a>
				</div>
			</footer>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $page){
		$this->page = intval($page);
		if ($this->page <= 0)
			$this->page = 1;
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["page"]);

?>