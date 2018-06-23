<?php

class ArmoryCronJob{
	private $file = "";
	private $fileGzip = "";
	
	private function getNewOldestFile($active){
		$files = glob('ArmoryTBC/*.lua.gz');
		array_multisort(array_map( 'filemtime', $files ),SORT_NUMERIC,SORT_ASC,$files);
		$i = 0;
		while(true){
			if (!$files[$i] || $files[$i] == ""){
				break;
			}else{
				if (!isset($active[str_replace(array(".lua", ".lua.gz"), "", $files[$i])])){
					$this->fileGzip = $files[$i];
					break;
				}
			}
			$i++;
		}
		if ((time()-filemtime($this->fileGzip))>=60 && filemtime($this->fileGzip) >= 10){
			$this->file = str_replace(".gz", "", $files[0]);
			$f = gzfile($files[0]);
			$out_file = fopen($this->file, 'wb'); 
			foreach ($f as $line) {
				fwrite($out_file, $line);
			}
			fclose($out_file);
			unlink($this->fileGzip);
			return $this->file;
		}else{
			return "";
		}
	}
	
	private function getOldestFile($active){
		$files = glob('ArmoryTBC/*.lua');
		array_multisort(array_map( 'filemtime', $files ),SORT_NUMERIC,SORT_ASC,$files);
		$i = 0;
		while(true){
			if (!$files[$i] || $files[$i] == ""){
				break;
			}else{
				if (!isset($active[str_replace(array(".lua", ".lua.gz"), "", $files[$i])])){
					$this->file = $files[$i];
					break;
				}
			}
			$i++;
		}
		if ((time()-filemtime($this->file))>=60 && filemtime($this->file) >= 10){
			return $this->file;
		}else{
			return $this->getNewOldestFile($active);
		}
	}
	
	private function removeFile($db, $id){
		if ($this->file != "")
			unlink($this->file);
		$db->query('UPDATE armorycronjob SET active = -1, name="None" WHERE id = '.$id);
	}
	
	function getActive($db){
		$t = array();
		foreach($db->query('SELECT id,name,date FROM armorycronjob WHERE expansion=1 AND active = 1') as $row){
			if ((time()-$row->date)>=1200)
				$db->query('UPDATE armorycronjob SET active = -1, name="None" WHERE id = '.$row->id);
			else
				$t[$row->name] = true;
		}
		return $t;
	}
	
	function isActive($db, $file, $id){
		$q = $db->query('SELECT * FROM armorycronjob WHERE id = '.$id)->fetch();
		if ($q->active == -1 || abs($q->date-time())>=1200){
			$db->query('UPDATE armorycronjob SET active = 1, date = '.time().', name = "'.str_replace(array(".lua", ".lua.gz"), "", $file).'" WHERE id = '.$id);
			return false;
		}
		return true;
	}
	
	public function __construct($db, $id){
		$active = $this->getActive($db);
		$file = $this->getOldestFile($active);
		if ($file && $file != ""){
			if (!$this->isActive($db, $file, $id)){
				$p = new Armory($file, $db, $id);
				if ($p == true){
					$this->removeFile($db, $id);
				}else{
					$db->query('UPDATE armorycronjob SET active = -1, name="None" WHERE id = '.$id);
				}
			}
		}
		//exit();
	}
}

?>