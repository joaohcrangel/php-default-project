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

$app->get("/pessoas/all", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	echo success(array("data"=>Pessoas::listAll()->getFields()));

});

$app->post("/pessoas", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idpessoa') > 0){
		$pessoa = new Pessoa((int)post('idpessoa'));
	}else{
		$pessoa = new Pessoa();
	}

	foreach ($_POST as $key => $value) {
		$pessoa->{'set'.$key}($value);
	}

	$pessoa->save();

	echo success(array("data"=>$pessoa->getFields()));

});

$app->delete("/pessoas/:idpessoa", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idpessoa){
		throw new Exception("Pessoa não informada", 400);		
	}

	$pessoa = new Pessoa((int)$idpessoa);

	if(!(int)$pessoa->getidpessoa() > 0){
		throw new Exception("Pessoa não encontrada", 404);		
	}

	$pessoa->remove();

	echo success();

});

 ?>