<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="centredNormal">
				<a href="Ranking/?server=0&faction=0&mode=0&id=1">
					<div class="ref-button unselectable">
						<img src="img/mc.png" />
						<div>Molten Core</div>
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=3">
					<div class="ref-button margin-half unselectable">
						<div>Blackwing Lair</div>
						<img src="img/bwl.png" />
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=2">
					<div class="ref-button unselectable">
						<img src="img/ony.png" />
						<div>Onyxia\'s Lair</div>
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=4">
					<div class="ref-button margin-half unselectable">
						<div>Zul\'Gurub</div>
						<img src="img/zg.png" />
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=5">
					<div class="ref-button unselectable">
						<img src="img/aq20.png" />
						<div>Ruins of Ahn\'Qiraj</div>
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=6">
					<div class="ref-button margin-half unselectable">
						<div>Temple of Ahn\'Qiraj</div>
						<img src="img/aq40.png" />
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=7">
					<div class="ref-button unselectable">
						<img src="img/naxx.png" />
						<div>Naxxramas</div>
					</div>
				</a>
			</section>
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