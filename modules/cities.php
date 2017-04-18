<?php

$app->get("/cities/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$where = array();

	if(get('descity') != ''){
		array_push($where, "descity LIKE '%".utf8_decode(get('descity'))."%'");
	}

	if(isset($_GET['idstate'])){
		array_push($where, "idstate = ".(int)get('idstate')."");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
		FROM tb_cities INNER JOIN tb_states USING(idstate)
		".$where."
		LIMIT ?, ?;
	";

	$pagina = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Address\Cities",
		$itemsPerPage
	);

	$cities = $pagination->getPage($pagina);

	echo success(array(
		"data"=>$cities->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/cities", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(post('idcity') > 0){
		$city = new Hcode\Address\City((int)post('idcity'));
	}else{
		$city = new Hcode\Address\City();
	}

	$city->set($_POST);

	$city->save();

	echo success(array("data"=>$city->getFields()));

});

$app->delete("/cities", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idcity) {

		if(!(int)$idcity){
			throw new Exception("Cidade não informada", 400);		
		}

		$city = new Hcode\Address\City((int)$idcity);

		if(!(int)$city->getidcity() > 0){
			throw new Exception("Cidade não encontrada", 404);		
		}

		$city->remove();

	}

	echo success();

});

$app->delete("/cities/:idcity", function($idcity){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idcity){
		throw new Exception("cidade não encontrado", 400);		
	}

	$city = new Hcode\Address\City((int)$idcity);

	if(!(int)$city->getidcity() > 0){
		throw new Exception("cidade não encontrado", 404);		
	}

	$city->remove();

	echo success();

});

?>