<?php

$app->get("/teste-sql", function(){

	$sql = new Sql2();

	$data = $sql->arrays("SELECT * FROM tb_cidades LIMIT 10");

	pre($data);

});

?>