<?php

$app->get("/paises/all", function(){

	Permission::checkSession(Permission::ADMIN, true);

	echo success(array("data"=>Paises::listAll()->getFields()));

});

$app->get("/paises", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$where = array();

	if(get('despais') != ''){
		array_push($where, "despais LIKE '%".utf8_decode(get('despais'))."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
		FROM tb_paises ".$where."
		LIMIT ?, ?
	";

	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');

	$paginacao = new Pagination(
		$query,
		array(),
		"Paises",
		$itemsPerPage
	);

	$paises = $paginacao->getPage($pagina);

	echo success(array(
		"data"=>$paises->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/paises", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if(post('idpais') > 0){
		$pais = new Pais((int)post('idpais'));
	}else{
		$pais = new Pais();
	}

	$pais->set($_POST);

	$pais->save();

	echo success(array("data"=>$pais->getFields()));

});

$app->delete("/paises", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idpais) {	

		if(!(int)$idpais){
			throw new Exception("País não informado", 400);		
		}

		$pais = new Pais((int)$idpais);

		if(!(int)$pais->getidpais() > 0){
			throw new Exception("País não encontrado", 404);		
		}

		$pais->remove();

	}

	echo success();

});

?>