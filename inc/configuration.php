<?php

if((float)PHP_VERSION < 5.3) define("__DIR__", dirname(__FILE__));//Fixbug PHP < 5.3

define("PATH", realpath(__DIR__."/../"));
define("URL", str_replace("\\", "/", str_replace(PATH, "", str_replace("/", "\\", $_SERVER["SCRIPT_FILENAME"]))));
define("SITE_NAME", basename(PATH));

require_once("functions.php");
require_once("raintpl-v.2.7.2/inc/rain.tpl.class.php");
?>