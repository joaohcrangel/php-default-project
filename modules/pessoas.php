<?php 
$app->get("/pessoas",function(){

	$q = get("q");

	$where = array();

	if ($q) {
		array_push($where, "despessoa LIKE '%".$q."%'");
	}

	if (count($where) > 0) {
		$where = "WHERE ".implode(" AND ", $where);
	} else {
		$where = "";
	}

	$pessoas = new Pessoas();
	$pessoas->loadFromQuery("
		select * from tb_pessoasdados ".$where." order by despessoa
	");
	echo success(array(
   		"data"=>$pessoas->getFields()
	));
});


 ?>