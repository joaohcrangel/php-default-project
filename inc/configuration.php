<?php
if (isset($_GET['token'])) session_id($_GET['token']);
session_start();

if((float)PHP_VERSION < 5.3) define("__DIR__", dirname(__FILE__));//Fixbug PHP < 5.3

require_once("consts.php");
require_once("functions.php");
require_once("raintpl/inc/rain.tpl.class.php");

spl_autoload_register('autoload_php_default_project');//Define a função autoload como uma função automatica de __autoload

?>
