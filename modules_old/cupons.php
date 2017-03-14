<?php

$app->get("/cupons/all", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	echo success(array("data"=>Cupons::listAll()->getFields()));

});

$app->post("/cupons", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if((int)post("idcupom") > 0){
		$cupom = new Cupom((int)post("idcupom"));
	}else{
		$cupom = new Cupom();
	}

	$cupom->set();

	$cupom->save();

	echo success(array("data"=>$cupom->getFields()));

});

$app->delete("/cupons/:idcupom", function($idcupom){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idcupom){
		throw new Exception("Cupom não informado", 400);		
	}

	$cupom = new Cupom((int)$idcupom);

	if(!(int)$cupom->getidcupom() > 0){
		throw new Exception("Cupom não encontrado", 404);		
	}

	$cupom->remove();

	echo success();

});
//////////////////////////////////////////////////

// cupons tipos
$app->get("/cupons/tipos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('descupomtipo')) {
		array_push($where, "descupomtipo LIKE '%".get('descupomtipo')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AD ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_cuponstipos
	".$where." limit ?, ?;";

	$paginacao = new Pagination(
        $query,
        array(),
        "CuponsTipos",
        $itemsPerPage
    );

     $cuponstipos = $paginacao->getPage($currentPage);


	echo success(array(
		"data"=>$cuponstipos->getFields(),
		"currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),

    ));


});

$app->post("/cupons-tipos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if((int)post('idcupomtipo') > 0){
		$cupom = new CupomTipo((int)post('idcupomtipo'));
	}else{
		$cupom = new CupomTipo();
	}

	$cupom->set($_POST);

	$cupom->save();

	echo success(array("data"=>$cupom->getFields()));

});

$app->delete("/cupons-tipos/:idcupomtipo", function($idcupomtipo){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!($idcupomtipo)){
		throw new Exception("Tipo de cupom não informado", 400);		
	}

	$tipo = new CupomTipo((int)$idcupomtipo);

	if(!(int)$tipo->getidcupomtipo() > 0){
		throw new Exception("Tipo de cupom não encontrado", 404);		
	}

	$tipo->remove();

	echo success();

});

?>