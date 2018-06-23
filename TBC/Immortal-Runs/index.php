<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="centredNormal">
				<a href="Ranking/?server=0&faction=0&mode=0&id=18">
					<div class="ref-button unselectable">
						<img src="img/kara.png" />
						<div>Karazhan</div>
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=17">
					<div class="ref-button margin-half unselectable">
						<div>Serpentshrine Cavern</div>
						<img src="img/ssc.png" />
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=20">
					<div class="ref-button unselectable">
						<img src="img/mag.png" />
						<div>Magtheridon\'s Lair</div>
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=21">
					<div class="ref-button margin-half unselectable">
						<div>Zul\'Aman</div>
						<img src="img/za.png" />
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=19">
					<div class="ref-button unselectable">
						<img src="img/gruul.png" />
						<div>Gruul\'s Lair</div>
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=23">
					<div class="ref-button margin-half unselectable">
						<div>Hyjal Summit</div>
						<img src="img/hyjal.png" />
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=22">
					<div class="ref-button unselectable">
						<img src="img/eye.png" />
						<div>The Eye</div>
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=24">
					<div class="ref-button margin-half unselectable">
						<div>Sunwell Plateau</div>
						<img src="img/swp.png" />
					</div>
				</a>
				<a href="Ranking/?server=0&faction=0&mode=0&id=16">
					<div class="ref-button unselectable">
						<img src="img/bt.png" />
						<div>Black Temple</div>
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