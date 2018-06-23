<?php

class CronJob{
	private $file = "";
	private $fileGzip = "";
	private $patreonChars = array();
	
	// DPSMate-Save-Invader-17-21-59-2016
	private function getCharNameFromSave($filename){
		preg_match("/DPSMate-Save-(\w+)\-/", $filename, $g);
		return $g[1];
	}
	
	private function getNewOldestFile($active){
		$files = glob('Files/*.lua.gz');
		array_multisort(array_map( 'filemtime', $files ),SORT_NUMERIC,SORT_ASC,$files);
		$i = 0;
		$temp = "";
		while(true){
			if (!$files[$i] || $files[$i] == ""){
				break;
			}else{
				if (!$active[str_replace(array(".lua", ".lua.gz"), "", $files[$i])]){
					if (isset($this->patreonChars[$this->getCharNameFromSave($files[$i])]) && $temp == ""){
						$temp = $files[$i];
						break;
					}
					if ($this->fileGzip=="")
						$this->fileGzip = $files[$i];
				}
			}
			$i++;
		}
		if ($temp != "")
			$this->fileGzip = $temp;
		if ((time()-filemtime($this->fileGzip))>=60 && filemtime($this->fileGzip) >= 10){
			$this->file = str_replace(".gz", "", $this->fileGzip);
			$f = gzfile($this->fileGzip);
			$out_file = fopen($this->file, 'wb'); 
			foreach ($f as $line) {
				fwrite($out_file, $line);
			}
			fclose($out_file);
			$savedFiles = glob('Save/*.lua.gz');
			foreach($savedFiles as $sf){
				if ((time()-filemtime($sf))>86400)
					unlink($sf);
			}
			copy($this->fileGzip, 'Save/'.str_replace("Files/", "", $this->fileGzip));
			unlink($this->fileGzip);
			return $this->file;
		}else{
			return "";
		}
	}
	
	private function getOldestFile($active){
		$files = glob('Files/*.lua');
		array_multisort(array_map( 'filemtime', $files ),SORT_NUMERIC,SORT_ASC,$files);
		$i = 0;
		$temp = "";
		while(true){
			if (!$files[$i] || $files[$i] == ""){
				break;
			}else{
				if (!$active[str_replace(array(".lua", ".lua.gz"), "", $files[$i])]){
					if (isset($this->patreonChars[$this->getCharNameFromSave($files[$i])]) && $temp == "")
						$temp = $files[$i];
					if ($this->file=="")
						$this->file = $files[$i];
					//break;
				}
			}
			$i++;
		}
		if ($temp != "")
			$this->file = $temp;
		if ((time()-filemtime($this->file))>=60 && filemtime($this->file) >= 10){
			return $this->file;
		}else{
			return $this->getNewOldestFile($active);
		}
	}
	
	private function removeFile($db, $id){
		if ($this->file != "")
			unlink($this->file);
		$db->query('UPDATE cronjob SET active = -1, name="None", merge = 0, progress=0, mergetype=0, date = '.time().' WHERE id = '.$id);
	}
	
	function getActive($db){
		$t = array();
		foreach($db->query('SELECT name FROM `user-silver-chars`') as $row){
			$this->patreonChars[$row->name] = true;
		}
		foreach($db->query('SELECT id, name, date FROM cronjob WHERE active = 1 AND expansion = 0') as $row){
			if ((time()-$row->date)>=1200)
				$db->query('UPDATE cronjob SET active = -1, name="None", merge = 0, progress=0, mergetype=0, date = '.time().' WHERE id = '.$row->id);
			else
				$t[$row->name] = true;
		}
		return $t;
	}
	
	function isActive($db, $file, $id){
		$q = $db->query('SELECT * FROM cronjob WHERE id = '.$id)->fetch();
		if ($q->active == -1 || abs($q->date-time())>=1200){
			$db->query('UPDATE cronjob SET active = 1, date = '.time().', name = "'.str_replace(array(".lua", ".lua.gz"), "", $file).'", progress=0, mergetype=0 WHERE id = '.$id);
			return false;
		}
		return true;
	}
	
	private function clearRedundantLogs(){
		$files = glob('Files/*.lua.gz');
		$i = 0;
		while(true){
			if (!$files[$i] || $files[$i] == ""){
				break;
			}else{
				if (filesize($files[$i])<50000)
					unlink($files[$i]);
				$i++;
			}
		}
	}
	
	public function __construct($db, $id){
		$this->clearRedundantLogs();
		$active = $this->getActive($db);
		$file = $this->getOldestFile($active);
		if ($file && $file != ""){
			if (!$this->isActive($db, $file, $id)){
				$p = new Process($file, $db, $id);
				if ($p == true){
					$this->removeFile($db, $id);
				}else{
					$db->query('UPDATE cronjob SET active = -1, name="None", merge = 0, progress=0, mergetype=0, date = '.time().' WHERE id = '.$id);
				}
			}
		}
		//exit();
	}
}

?>