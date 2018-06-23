<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $rpw = 0;
	private $srp = 0;
	private $rparr = array();
	
	private function calculateRP($week){
		$lastweek = $week - 1;
		$rp = $this->srp;
		if (!isset($rparr[$lastweek])){
			for($i=0; $i<=$lastweek; $i++){
				$rp = $rp - $rp*0.2 + $this->rpw;
			}
			$rparr[$lastweek] = $rp;
		}
		return ceil($rparr[$lastweek]-$rparr[$lastweek]*0.2+$this->rpw);
	}
	
	private function calcProg($week){
		if ($week == 0)
			return ceil($this->srp-$this->srp*0.2+$this->rpw)-$this->srp;
		return ceil($this->calculateRP($week)-$this->calculateRP($week-1));
	}
	
	private function calculateProgress($week){
		return $this->mReadable(100*($this->calcProg($week)/5000));
	}
	
	private function calculateTotalProgress($week){
		return $this->mReadable(100*$this->calcProg($week)/60000);
	}
	
	private function calculateRank($rp){
		return ceil(($rp/5000)+1);
	}
	
	private function jsToAdd(){
		$content .= "
	      google.charts.load('current', {'packages':['corechart']});
		  google.charts.setOnLoadCallback(drawChart);
		
		  function drawChart() {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Weeks');
			data.addColumn('number', 'Rankpoints');
			data.addRows([
				['Week 0', ".$this->srp."],
		";
		for($i=0;$i<10; $i++){
			$content .="
				['Week ".($i+1)."', ".$this->calculateRP($i)."],
			";
		}
		$content .= "
			]);

			var options = {
			  curveType: 'function',
			  legend: { position: 'bottom', 'textStyle': { 'color': 'white' } },
			  chartArea: {top: 25,right: 20,height: '70%', width: '90%'},
			  backgroundColor: {'fill': 'transparent' },
			  hAxis: {textStyle:{color: '#FFF'}},
			  vAxis: {textStyle:{color: '#FFF'},viewWindow: {min:0}},
			  series: {
				0: { color: '#f1ca3a' },
				1: { color: '#e2431e' },
				2: { color: '#e7711b' },
				3: { color: '#6f9654' },
			  },
			};

			var chart = new google.visualization.LineChart(document.getElementById('graph'));

			chart.draw(data, options);
			 var columns = [];
			var series = {};
			for (var i = 0; i < data.getNumberOfColumns(); i++) {
				columns.push(i);
				if (i > 0) {
					series[i - 1] = {};
				}
			}
		  }
		";
		return $content;
	}
	
	public function content(){
		$this->addJs($this->jsToAdd());
		$content = '
		<div class="container cont" id="container">
			<section class="centredNormal top">
				<form action="#">
					<input name="rpw" type="text" placeholder="Estimated rankpoints per week" value="'.($r = ($this->rpw>0) ? $this->rpw : "").'" />
					<input name="srp" type="text" placeholder="Your current rankpoints" value="'.($r = ($this->rpw>0) ? $this->srp : "").'" />
					<input type="submit" value="Calculate" />
				</form>
			</section>
		';
		if ($this->rpw>0){
			$content .= '
			<section class="centredNormal table bott">
				<div class="right">
					<div id="graph"></div>
					<table cellspacing="0">
						<tr>
							<th>Week</th>
							<th>Rank</th>
							<th>Rankpoints</th>
							<th>Progress</th>
							<th>Progress %</th>
							<th>Total progress</th>
						</tr>
				';
				for($i=0;$i<10; $i++){
					$rp = $this->calculateRP($i);
					$content .= '
						<tr>
							<td>'.($i+1).'</td>
							<td>'.$this->calculateRank($rp).'</td>
							<td>'.$rp.'</td>
							<td>'.$this->calcProg($i).'</td>
							<td>'.$this->calculateProgress($i).'%</td>
							<td>'.$this->calculateTotalProgress($i).'%</td>
						</tr>
					';
				}
				$content .= '
					</table>
				</div>
			</section>
			';
		}
		$content .= '
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $rpw, $srp){
		$this->rpw = intval($this->antiSQLInjection($rpw));
		$this->srp = intval($this->antiSQLInjection($srp));
		if ($this->rpw>15000)
			$this->rpw=15000;
		if ($this->rpw<0)
			$this->rpw=0;
		if ($this->srp<0)
			$this->srp = 0;
		if ($this->srp>65000)
			$this->srp = 65000;
		$this->addJsLink("https://www.gstatic.com/charts/loader.js", true);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["rpw"], $_GET["srp"]);

?>