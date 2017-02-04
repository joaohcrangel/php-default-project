<?php

$app->get("/lugares", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	$where = array();

	if(isset($_GET['deslugar']) && $_GET['deslugar'] != ""){
		array_push($where, "a.deslugar LIKE '%".utf8_decode(get('deslugar'))."%'");
	}

	if(isset($_GET['desendereco']) && $_GET['desendereco'] != ""){
		array_push($where, "b.desendereco LIKE '%".utf8_decode(get('desendereco'))."%'");
	}

	if(isset($_GET['idlugartipo'])){
		array_push($where, "c.idlugartipo = ".(int)get('idlugartipo'));
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where);
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.desendereco, c.deslugartipo FROM tb_lugares a
			INNER JOIN tb_enderecos b ON a.idendereco = b.idendereco
		    INNER JOIN tb_lugarestipos c ON a.idlugartipo = c.idlugartipo
		".$where." ORDER BY a.deslugar LIMIT ?, ?;
	";

	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');

	$paginacao = new Pagination(
		$query,
		array(),
		"Lugares",
		$itemsPerPage
	);

	$lugares = $paginacao->getPage($pagina);

	echo success(array(
		"data"=>$lugares->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/lugares", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(isset($_POST['idendereco'])){

		$endereco = new Endereco((int)post('idendereco'));

		$endereco->set($_POST);

		if(!post('idpessoa')){
			$endereco->setidpessoa(Session::getPessoa()->getidpessoa());
		}

		$endereco->save();

		$_POST['idendereco'] = $endereco->getidendereco();

	}

	if(post('idlugar') > 0){
		$lugar = new Lugar((int)post('idlugar'));
	}else{
		$lugar = new Lugar();
	}

	foreach ($_POST as $key => $value) {
		$lugar->{'set'.$key}($value);
	}

	$lugar->setidlugarpai(NULL);

	$lugar->save();

	echo success(array("data"=>$lugar->getFields()));

});

$app->delete("/lugares/:idlugar", function($idlugar){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idlugar){
		throw new Exception("Lugar não informado", 400);		
	}

	$lugar = new Lugar((int)$idlugar);

	if(!(int)$lugar->getidlugar() > 0){
		throw new Exception("Lugar não encontrado", 404);		
	}

	$lugar->remove();

	echo success();

});
/////////////////////////////////////////////////////////////

// lugares tipos
$app->get("/lugares/tipos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	echo success(array("data"=>LugaresTipos::listAll()->getFields()));

});

$app->post("/lugarestipos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idlugartipo') > 0){
		$tipo = new LugarTipo((int)post('idlugartipo'));
	}else{
		$tipo = new LugarTipo();
	}

	foreach ($_POST as $key => $value) {
		$tipo->{'set'.$key}($value);
	}

	$tipo->save();

	echo success(array("data"=>$tipo->getFields()));

});

$app->delete("/lugarestipos/:idlugartipo", function($idlugartipo){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idlugartipo){
		throw new Exception("Tipo de lugar não informado", 400);	
	}

	$tipo = new LugarTipo((int)$idlugartipo);

	if(!(int)$tipo->getidlugartipo() > 0){
		throw new Exception("Tipo não encontrado", 404);		
	}

	$tipo->remove();
	
	echo success();

});

?>