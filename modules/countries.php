<?php

$app->get("/countries/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	echo success(array("data"=>Hcode\Address\Countries::listAll()->getFields()));

});

$app->get("/countries", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$where = array();

	if(get('descountry') != ''){
		array_push($where, "descountry LIKE '%".utf8_decode(get('descountry'))."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
		FROM tb_countries ".$where."
		LIMIT ?, ?
	";

	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Address\Countries",
		$itemsPerPage
	);

	$countries = $pagination->getPage($pagina);

	echo success(array(
		"data"=>$countries->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/countries", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(post('idcountry') > 0){
		$country = new Hcode\Address\Country((int)post('idcountry'));
	}else{
		$country = new Hcode\Address\Country();
	}

	$country->set($_POST);

	$country->save();

	echo success(array("data"=>$country->getFields()));

});

$app->delete("/countries", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idcountry) {	

		if(!(int)$idcountry){
			throw new Exception("País não informado", 400);		
		}

		$country = new Hcode\Address\Country((int)$idcountry);

		if(!(int)$country->getidcountry() > 0){
			throw new Exception("País não encontrado", 404);		
		}

		$country->remove();

	}

	echo success();

});

?>