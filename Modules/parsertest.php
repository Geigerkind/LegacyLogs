<?php





$toparse = file_get_contents("FilesTBC/Bandyto_10man_KZ.lua");

$pa = new LuaParser($toparse);
print_r($pa->parse());

?>