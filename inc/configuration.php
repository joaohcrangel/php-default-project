<?php

define("SITE_NAME", "");

if($_SERVER["HTTP_HOST"]=="localhost"){
	//PATH de desenvolvimento
	define("PATH", $_SERVER["DOCUMENT_ROOT"]."/".SITE_NAME);
}else{
	//PATH de produção
	define("PATH", $_SERVER["DOCUMENT_ROOT"]."/".SITE_NAME);
}

require_once("functions.php");
require_once("raintpl-v.2.7.2/inc/rain.tpl.class.php");
?>