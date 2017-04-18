<?php

$app->get("/states", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	echo success(array("data"=>Hcode\Address\States::listAll()->getFields()));

});

$app->get("/states/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

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

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Address\States",
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

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(post('idstate') > 0){
		$state = new Hcode\Address\State((int)post('idstate'));
	}else{
		$state = new Hcode\Address\State();
	}

	$state->set($_POST);

	$state->save();

	echo success(array("data"=>$state->getFields()));

});

$app->delete("/states", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idstate) {

		if(!(int)$idstate){
			throw new Exception("Estado não encontrado", 400);		
		}

		$state = new Hcode\Address\State((int)$idstate);

		if(!(int)$state->getidstate() > 0){
			throw new Exception("Estado não encontrado", 404);		
		}

		$state->remove();

	}

	echo success();

});

?>