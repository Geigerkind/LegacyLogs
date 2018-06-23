<?php
require(dirname(__FILE__)."/../init.php");

class Home extends Site{
	private $patreonChars = array();
	
	// DPSMate-Save-Invader-17-21-59-2016
	private function getCharNameFromSave($filename){
		preg_match("/DPSMate-Save-(\w+)\-/", $filename, $g);
		return $g[1];
	}
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>Introduction</h1>
					<p>
						This page shows you all files that are being processed at the moment. It will calculate the approximate time based on experienced values, which means that they are not accurate.<br />
						If your logs are not being uploaded please check if you have the <a href="http://legacy-logs.com/Contribute">newest version of the client</a> and the <a href="http://legacy-logs.com/Addons">newest version of DPSMate</a>. <br />
						Due to the changed system, logs will need up to 2 minutes to show up in the log!
					</p>
					
				</div>
			</section>
			<section class="table rt">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th class="num">Position</th>
							<th class="lstring">Name</th>
							<th class="snum">Type</th>
							<th class="llstring">Progress</th>
						</tr>
		';
		$filesone = glob('../Modules/Files/*.lua.gz');
		$filestwo = glob('../Modules/Files/*.lua');
		$filesthree = glob('../Modules/FilesTBC/*.lua.gz');
		$filesfour = glob('../Modules/FilesTBC/*.lua');
		$filesfive = glob('../Modules/FilesWOTLK/*.lua.gz');
		$filessix = glob('../Modules/FilesWOTLK/*.lua');
		$files = array_merge($filesone, $filestwo, $filesthree, $filesfour, $filesfive, $filessix);
		array_multisort(array_map( 'filemtime', $files ),SORT_NUMERIC,SORT_ASC,$files);
		$already = array();
		foreach ($files as $k => $v){
			$name = str_replace(array("../Modules/Files/", "../Modules/FilesTBC/", "../Modules/FilesWOTLK/", ".lua.gz", ".lua"), "", $v);
			if (!isset($already[$name]) && isset($this->patreonChars[$this->getCharNameFromSave($name)])){
				$q = $this->db->query('SELECT progress,merge,mergetype FROM cronjob WHERE active = 1 AND (name = "Files/'.$name.'" or name = "FilesTBC/'.$name.'" or name = "FilesWOTLK/'.$name.'")')->fetch();
				$content .= '
							<tr>
								<td class="num">'.($k+1).'</td>
								<td class="lstring">'.$name.'</td>
								<td class="snum">'.($r = ($q->mergetype==1) ? "Merge: ".$q->merge : "Normal").'</td>
								<td class="llstring"><div class="progress"><div style="width: '.$q->progress.'% !important;">'.($r = (isset($q->progress) && $q->progress != "") ? $q->progress : 0).'%</div></div></td>
							</tr>
				';
				$already[$name] = true;
			}
		}
		foreach ($files as $k => $v){
			$name = str_replace(array("../Modules/Files/", "../Modules/FilesTBC/", "../Modules/FilesWOTLK/", ".lua.gz", ".lua"), "", $v);
			if (!isset($already[$name]) && !isset($this->patreonChars[$this->getCharNameFromSave($name)])){
				$q = $this->db->query('SELECT progress,merge,mergetype FROM cronjob WHERE active = 1 AND (name = "Files/'.$name.'" or name = "FilesTBC/'.$name.'" or name = "FilesWOTLK/'.$name.'")')->fetch();
				$content .= '
							<tr>
								<td class="num">'.($k+1).'</td>
								<td class="lstring">'.$name.'</td>
								<td class="snum">'.($r = ($q->mergetype==1) ? "Merge: ".$q->merge : "Normal").'</td>
								<td class="llstring"><div class="progress"><div style="width: '.$q->progress.'% !important;">'.($r = (isset($q->progress) && $q->progress != "") ? $q->progress : 0).'%</div></div></td>
							</tr>
				';
				$already[$name] = true;
			}
		}
		$content .= '
					</table>
		';
		if (sizeOf($files)==0)
			$content .= 'There are no files in the queue at the moment.';
		$content .= '
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir){
		foreach($db->query('SELECT name FROM `user-silver-chars`') as $row){
			$this->patreonChars[$row->name] = true;
		}
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__);

?>