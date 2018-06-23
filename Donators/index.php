<?php
require(dirname(__FILE__)."/../init.php");

class Home extends Site{
	private $page = 1;
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Amount</th>
							<th>Date</th>
						</tr>
		';
		$count =  $this->db->query('SELECT max(id) as am FROM donators')->fetch()->am;
		$max = floor($count/15+1);
		foreach ($this->db->query('SELECT id, name, amount, time FROM donators WHERE id ORDER BY id DESC LIMIT '.(($this->page-1)*15).', 15') as $row){
				$content .= '
							<tr>
								<td>'.$row->id.'</td>
								<td>'.$row->name.'</td>
								<td>'.$row->amount.'€</td>
								<td>'.date('d.m.y H:i', $row->time).'</td>
							</tr>
				';
		}
		$content .= '
					</table>
				</div>
			</section>
			<footer class="pager">
				<div class="pleft">
					<a href="{path}Donators/?page=1"><button class="icon-button icon-darrowleft"></button></a><a href="{path}Donators/?page='.($r = (($this->page-1)>=1) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft"></button></a>
				</div>
				<div class="pright">
					<div class="pseudoButton">Page '.$this->page.' of '.$max.'</div><a href="{path}Donators/?page='.($r = (($this->page+1)<=$max) ? ($this->page+1) : $max).'"><button class="icon-button icon-arrowright"></button></a><a href="{path}Donators/?page='.$max.'"><button class="icon-button icon-darrowright"></button></a>
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