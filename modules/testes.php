<?php

function saveTriggers($triggers = array()){

	$sql = new Sql();

	foreach ($triggers as $name) {
		$sql->query("DROP TRIGGER IF EXISTS {$name};");
		$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	}

}

?>