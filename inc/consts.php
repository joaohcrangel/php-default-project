<?php
define("PATH", realpath(__DIR__."/../"));
define("URL", str_replace("\\", "/", str_replace(PATH, "", str_replace("/", "\\", $_SERVER["SCRIPT_FILENAME"]))));
define("SITE_NAME", basename(PATH));
define("SITE_PATH", str_replace($_SERVER['DOCUMENT_ROOT'], "", str_replace("\\", "/", PATH)));
?>