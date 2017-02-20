<?php

$app->get("/carousels/all", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	$where = array();

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
    	FROM tb_carousels ".$where."
    	LIMIT ?, ?;
	";

	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');

	$paginacao = new Pagination(
		$query,
		array(),
		"Carousels",
		$itemsPerPage
	);

	$carousels = $paginacao->getPage($pagina);

	echo success(array(
		"data"=>$carousels->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->get("/carousels/:idcarousel/items", function($idcarousel){

	Permissao::checkSession(Permissao::ADMIN, true);

	$carousel = new Carousel((int)$idcarousel);

	echo success(array("data"=>$carousel->getCarouselsItems()->getFields()));

});

$app->post("/carousels", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idcarousel') > 0){
		$carousel = new Carousel((int)post('idcarousel'));
	}else{
		$carousel = new Carousel();
	}

	foreach ($_POST as $key => $value) {
		
		if($value === 'false') $_POST[$key] = false;

	}

	$carousel->set($_POST);

	$carousel->save();

	echo success(array("data"=>$carousel->getFields()));

});

$app->delete("/carousels/:idcarousel", function($idcarousel){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idcarousel){
		throw new Exception("Carousel não informado", 400);		
	}

	$carousel = new Carousel((int)$idcarousel);

	if(!(int)$carousel->getidcarousel() > 0){
		throw new Exception("Carousel não encontrado", 404);		
	}

	$carousel->remove();

	echo success();

});
///////////////////////////////////////////////////////////////////////

// carousels items
$app->post("/carousels-items", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('iditem') > 0){
		$item = new CarouselItem((int)post('iditem'));
	}else{
		$item = new CarouselItem();
	}

	$item->set($_POST);

	$item->save();

	echo success(array("data"=>$item->getFields()));

});

$app->delete("/carousels-items/:iditem", function($iditem){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$iditem){
		throw new Exception("Item não informado", 400);		
	}

	$item = new CarouselItem((int)$iditem);

	if(!(int)$item->getiditem() > 0){
		throw new Exception("Item não encontrado", 404);		
	}

	$item->remove();

	echo success();

});
///////////////////////////////////////////////////////////////////////

// carousel items tipos
$app->get("/carousels-tipos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	echo success(array("data"=>CarouselsItemsTipos::listAll()->getFields()));

});

$app->post("/carousels-tipos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idtipo') > 0){
		$tipo = new CarouselItemTipo((int)post('idtipo'));
	}else{
		$tipo = new CarouselItemTipo();
	}

	$tipo->set($_POST);

	$tipo->save();

	echo success(array("data"=>$tipo->getFields()));

});

$app->delete("/carousels-tipos/:idtipo", function($idtipo){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idtipo){
		throw new Exception("Carousel não informado", 400);		
	}

	$carousel = new CarouselItemTipo((int)$idtipo);

	if(!(int)$carousel->getidtipo() > 0){
		throw new Exception("Carousel não encontrado", 404);		
	}

	$carousel->remove();

	echo success();

});

?>