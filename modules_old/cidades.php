<?php

$app->get("/cidades/all", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$where = array();

	if(get('descidade') != ''){
		array_push($where, "descidade LIKE '%".utf8_decode(get('descidade'))."%'");
	}

	if(isset($_GET['idestado'])){
		array_push($where, "idestado = ".(int)get('idestado')."");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
		FROM tb_cidades INNER JOIN tb_estados USING(idestado)
		".$where."
		LIMIT ?, ?;
	";

	$pagina = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$paginacao = new Pagination(
		$query,
		array(),
		"Cidades",
		$itemsPerPage
	);

	$cidades = $paginacao->getPage($pagina);

	echo success(array(
		"data"=>$cidades->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/cidades", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if(post('idcidade') > 0){
		$cidade = new cidade((int)post('idcidade'));
	}else{
		$cidade = new cidade();
	}

	$cidade->set($_POST);

	$cidade->save();

	echo success(array("data"=>$cidade->getFields()));

});

$app->delete("/cidades", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idcidade) {

		if(!(int)$idcidade){
			throw new Exception("cidade não encontrado", 400);		
		}

		$cidade = new cidade((int)$idcidade);

		if(!(int)$cidade->getidcidade() > 0){
			throw new Exception("cidade não encontrado", 404);		
		}

		$cidade->remove();

	}

	echo success();

});

$app->delete("/cidades/:idcidade", function($idcidade){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idcidade){
		throw new Exception("cidade não encontrado", 400);		
	}

	$cidade = new cidade((int)$idcidade);

	if(!(int)$cidade->getidcidade() > 0){
		throw new Exception("cidade não encontrado", 404);		
	}

	$cidade->remove();

	echo success();

});

?>