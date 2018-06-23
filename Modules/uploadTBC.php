<?php
	$filename = $_FILES['userfile']['name'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if ($ext=="gz" && strpos($filename, "DPSMate") !== false && strpos($filename, "Save") !== false && strpos($filename, "-") !== false && strpos($filename, "lua") !== false){
		move_uploaded_file($_FILES['userfile']['tmp_name'], "FilesTBC/".$_FILES['userfile']['name']);
		print $_FILES['userfile']['name']." successfully uploaded!";
	}
?>