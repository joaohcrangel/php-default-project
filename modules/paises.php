<?php

$app->get("/paises/all", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	echo success(array("data"=>Paises::listAll()->getFields()));

});

$app->post("/paises", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idpais') > 0){
		$pais = new Pais((int)post('idpais'));
	}else{
		$pais = new Pais();
	}

	$pais->set($_POST);

	$pais->save();

	echo success(array("data"=>$pais->getFields()));

});

$app->delete("/paises/:idpais", function($idpais){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idpais){
		throw new Exception("País não informado", 400);		
	}

	$pais = new Pais((int)$idpais);

	if(!(int)$pais->getidpais() > 0){
		throw new Exception("País não encontrado", 404);		
	}

	$pais->remove();

	echo success();

});

?>