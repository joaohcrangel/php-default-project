<?php

$app->get("/:ano/:mes/:dia/:text", function($ano, $mes, $dia, $text){

	echo $ano . "/" . $mes . "/" . $dia . "/" . $text;

});

$app->get("/urls/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$where = array();

	if(get('desurl') != ''){
		array_push($where, "desurl LIKE '%".utf8_decode(get('desurl'))."%'");
	}

	if(get('destitle') != ''){
		array_push($where, "destitle LIKE '%".utf8_decode(get('destitle'))."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
		FROM tb_urls ".$where." LIMIT ?, ?
	";

	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');

	$paginacao = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Site\Urls",
		$itemsPerPage
	);

	$urls = $paginacao->getPage($pagina);

	echo success(array(
		"data"=>$urls->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/urls", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(post('idurl') > 0){
		$url = new Hcode\Site\Url((int)post('idurl'));
	}else{
		$url = new Hcode\Site\Url();
	}

	$url->set($_POST);

	$url->save();

	echo success(array("data"=>$url->getFields()));

});

$app->delete("/urls", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post('ids'));

	foreach($ids as $idurl){

		if(!(int)$idurl){
			throw new Exception("URL não informada", 400);			
		}

		$url = new Hcode\Site\Url((int)$idurl);

		if(!(int)$url->getidurl() > 0){
			throw new Exception("URL não encontrada", 404);			
		}

		$url->remove();

	}

	echo success();

});

?>