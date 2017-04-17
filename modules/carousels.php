<?php

$app->get("/carousels/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$where = array();

	if(get('descarousel') != ''){
		array_push($where, "descarousel LIKE '%".utf8_decode(get('descarousel'))."%'");
	}

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

	$pagination = new Pagination(
		$query,
		array(),
		"Carousels",
		$itemsPerPage
	);

	$carousels = $pagination->getPage($pagina);

	echo success(array(
		"data"=>$carousels->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->get("/carousels/:idcarousel/items", function($idcarousel){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$carousel = new Carousel((int)$idcarousel);

	echo success(array("data"=>$carousel->getCarouselsItems()->getFields()));

});

$app->post("/carousels", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

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

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

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

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

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

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

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
$app->get("/carousels-types", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('destype')) {
		array_push($where, "destype LIKE '%".get('destype')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AD ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_carouselsitemstypes
	".$where." limit ?, ?;";

	$pagination = new Pagination(
        $query,
        array(),
        "CarouselsItemsTypes",
        $itemsPerPage
    );

	$carouselstypes = $pagination->getPage($currentPage);

    echo success(array(
    	"data"=>$carouselstypes->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));

});

$app->post("/carousels-types", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(post('idtype') > 0){
		$type = new CarouselItemType((int)post('idtype'));
	}else{
		$type = new CarouselItemType();
	}

	$type->set($_POST);

	$type->save();

	echo success(array("data"=>$type->getFields()));

});

$app->delete("/carousels-types/:idtype", function($idtype){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idtype){
		throw new Exception("Carousel não informado", 400);		
	}

	$carousel = new CarouselItemType((int)$idtype);

	if(!(int)$carousel->getidtype() > 0){
		throw new Exception("Carousel não encontrado", 404);		
	}

	$carousel->remove();

	echo success();

});

?>