<?php
if((float)PHP_VERSION < 5.3) require_once("functions-5-2.php");
function __autoload($class){
	$filepath = __DIR__."/class/".strtolower($class).".php";
    if(file_exists($filepath)){
    	require_once($filepath);
    	return true;
    }
    $filepath = __DIR__."/class/objects/".strtolower($class).".php";
    if(file_exists($filepath)){
    	require_once($filepath);
    	return true;
    }
}
if(URL === "/inc/configuration.php"){
	phpinfo();
	exit;
}
function removeSimplesQuotes($val){
	return str_replace("'", "", $val);
}
function request($key){
	return removeSimplesQuotes($_REQUEST[$key]);
}
function r($key){
	return request($key);
}
function post($key){
	return removeSimplesQuotes($_POST[$key]);
}
function p($key){
	return post($key);
}
function get($key){
	return removeSimplesQuotes($_GET[$key]);
}
function g($key){
	return get($key);
}
function in($t, $arrays = true, $keyEncode=''){
	if(is_array($t)){
		if($arrays){
			$b = array();
			foreach($t as $i){
				$n = array();
				foreach($i as $k=>$v){
					$n[chgName($k)] = $v;
				}
				$n['_'.chgName($keyEncode)] = in($i[$keyEncode]);
				array_push($b, $n);
			}
			return $b;
		}else{
			$n = array();
			foreach($t as $k=>$v){
				$n[chgName($k)] = $v;
			}
			$n['_'.chgName($keyEncode)] = in($t[$keyEncode]);
			return $n;
		}
	}else{
		$encode = base64_encode(time());
		return base64_encode(str_pad(strlen($encode), 3, '0', STR_PAD_LEFT).$encode.base64_encode($t));
	}
}
function out($t){
	$t = base64_decode($t);	
	$len = substr($t, 0, 3);
	return requestFIT(base64_decode(substr($t, ($len+3), strlen($t)-($len+3))));
}
function pre(){
	echo "<pre>";
	foreach(func_get_args() as $arg){
		print_r($arg);
	}
	echo "</pre>";
}
function getClass($class_name){
	if(isset($_SESSION[$class_name])){
		return new $class_name($_SESSION[$class_name]);
	}else{
		throw new Exception("A classe $class_name não está em sessão");
	}
}
function setClass($class){
	$_SESSION[get_class($class)] = $class->getFields();
}
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
?>