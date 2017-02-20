<?php

$app->get("/estados/all", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	$where = array();

	if(get('desestado') != ''){
		array_push($where, "desestado LIKE '%".utf8_decode(get('desestado'))."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
		FROM tb_estados ".$where."
		LIMIT ?, ?;
	";

	$pagina = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$paginacao = new Pagination(
		$query,
		array(),
		"Estados",
		$itemsPerPage
	);

	$estados = $paginacao->getPage($pagina);

	echo success(array(
		"data"=>$estados->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/estados", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idestado') > 0){
		$estado = new Estado((int)post('idestado'));
	}else{
		$estado = new Estado();
	}

	$estado->set($_POST);

	$estado->save();

	echo success(array("data"=>$estado->getFields()));

});

$app->delete("/estados", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idestado) {

		if(!(int)$idestado){
			throw new Exception("Estado não encontrado", 400);		
		}

		$estado = new Estado((int)$idestado);

		if(!(int)$estado->getidestado() > 0){
			throw new Exception("Estado não encontrado", 404);		
		}

		$estado->remove();

	}

	echo success();

});

?>