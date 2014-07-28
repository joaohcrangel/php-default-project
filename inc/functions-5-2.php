<?php

if (!function_exists("get_called_class")) {
	function get_called_class () {
		$arr = array(); 
		$arrTraces = debug_backtrace();
		foreach ($arrTraces as $arrTrace){
		   if(!array_key_exists("class", $arrTrace)) continue;
		   if(count($arr)==0) $arr[] = $arrTrace['class'];
		   else if(get_parent_class($arrTrace['class'])==end($arr)) $arr[] = $arrTrace['class'];
		}
		return end($arr);
	}	
}

?>
