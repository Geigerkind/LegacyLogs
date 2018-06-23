<?php
/***********************************************************************************
 *
 *   lua2php_array - Converts an WoW-Lua File into a php-Array.
 *
 *   Author: PattyPur (Patty.Pur@web.de)
 *   Char : Shindara 
 *   Guild: Ehrengarde von Theramore
 *   Realm: Kel'Thuzad (DE-PVP)
 *   
 *   Date: 02.10.2005
 *
 **********************************************************************************
 */

/*
hosted at: http://fin.instinct.org/
used with: http://fin.instinct.org/lua/ - an online lua2php converter

comments / updates / criticism to: fin@instinct.org
*/

// Helper-functions

/*
  function trimval(string)
  
  cuts the leading and tailing quotationmarks and the tailing comma from the value
  Example:
    Input: "Value",
    Output: Value    
*/

class LuaParser{

	private function trimval($str)
	{
	  $str = trim($str);
	  if (mb_substr($str,0,1)=="\""){
		
		$str  = trim(mb_substr($str,1,mb_strlen($str)));
	  }
	  if (mb_substr($str,-1,1)==","){
		$str  = trim(mb_substr($str,0,mb_strlen($str)-1));
	  }

	  if (mb_substr($str,-1,1)=="\""){
		$str  = trim(mb_substr($str,0,mb_strlen($str)-1));
	  }
	  
	  if ($str =='false') 
	  {
		$str = false;
	  }
	  if ($str =='true') 
	  {
		$str = true;
	  }
	  
	  return $str;
	}

	/*
	  function array_id(string)
	  
	  extracts the Key-Value for array indexing 
	  String-Example:
		Input: ["Key"]
		Output: Key    
	  Int-Example:
		Input: [0]
		Output: 0    
	*/
	private function array_id($str)
	{
	  $id1 = sscanf($str, "[%d]");  
	  if (mb_strlen($id1[0])>0){
		return $id1[0];    
	  }
	  else
	  {
		if (mb_substr($str,0,1)=="[")
		{
		  $str  = mb_substr($str,1,mb_strlen($str));
		}
		if (mb_substr($str,0,1)=="\"")
		{
		  $str  = mb_substr($str,1,mb_strlen($str));
		}
		if (mb_substr($str,-1,1)=="]")
		{
		  $str  = mb_substr($str,0,mb_strlen($str)-1);
		}
		if (mb_substr($str,-1,1)=="\"")
		{
		  $str  = mb_substr($str,0,mb_strlen($str)-1);
		}
		return $str;
	  } 
	}

	/*
	  function luaparser(array, arrayStartIndex)
	  
	  recursive Function - it does the main work
	*/
	private function luaparser($lua, &$pos)
	{
	  $parray = array();
	  $stop = false;
	  $q = 1;
	  if ($pos < count($lua)) 
	  {
		for ($i = $pos;$stop ==false;)
		{
		  if ($i >= count($lua)) { $stop=true;}
		  if (!isset($lua[$i]))
			  break;
		  $strs = explode("=",utf8_decode(utf8_encode($lua[$i])));
		  if (trim($r = (isset($strs[1])) ? $strs[1] : "") == "{"){
			$i++;
			if (isset($parray[$this->array_id(trim($strs[0]))]))
				$parray[$this->array_id(trim($strs[0]))] += $this->luaparser($lua, $i);
			else
				$parray[$this->array_id(trim($strs[0]))]=$this->luaparser($lua, $i);
		  } 
		  else if (trim($strs[0]) == "}" || trim($strs[0]) == "},")
		  {
			//$i--;
			$i++;
			$stop = true;
		  }
		  else
		  {
			$i++;
			if (mb_strlen($this->array_id(trim($strs[0])))>0 && mb_strlen($strs[1])>0) 
			{
				if (isset($parray[$this->array_id(trim($strs[0]))]))
					$parray[$this->array_id(trim($strs[0]))] += $this->trimval($strs[1]);
				else
					$parray[$this->array_id(trim($strs[0]))]=$this->trimval($strs[1]);
			}
		  } 
		}
	  }
	  $pos=$i;
	  return $parray;
	}

	/*
	  function makePhpArray($input)
	  
	  thst the thing to call :-)
	  
	  $input can be 
		- an array with the lines of the LuaFile
		- a String with the whole LuaFile
		- a Filename
	  
	*/
	public function makePhpArray($input){
	  $start = 0;
	  if (is_array($input))
	  {    
		return $this->luaparser($input,$start);
	  } 
	  elseif (is_string($input))
	  {
		if (@is_file ( $input ))
		{
		  return $this->luaparser(file($input),$start);
		}
		else
		{
		  return $this->luaparser(explode("\n",$input),$start);
		}
	  }
	}
	
	public function __construct(){}
}

?>