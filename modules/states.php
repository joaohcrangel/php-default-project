<?php

$app->get("/states", function(){

	Permission::checkSession(Permission::ADMIN, true);

	echo success(array("data"=>States::listAll()->getFields()));

});

$app->get("/states/all", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$where = array();

	if(get('desstate') != ''){
		array_push($where, "desstate LIKE '%".utf8_decode(get('desstate'))."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
		FROM tb_states ".$where."
		LIMIT ?, ?;
	";

	$pagina = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$pagination = new Pagination(
		$query,
		array(),
		"States",
		$itemsPerPage
	);

	$states = $pagination->getPage($pagina);

	echo success(array(
		"data"=>$states->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/states", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if(post('idstate') > 0){
		$state = new States((int)post('idstate'));
	}else{
		$state = new States();
	}

	$state->set($_POST);

	$state->save();

	echo success(array("data"=>$state->getFields()));

});

$app->delete("/states", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idstate) {

		if(!(int)$idstate){
			throw new Exception("Estado não encontrado", 400);		
		}

		$state = new State((int)$idstate);

		if(!(int)$state->getidstate() > 0){
			throw new Exception("Estado não encontrado", 404);		
		}

		$state->remove();

	}

	echo success();

});

?>