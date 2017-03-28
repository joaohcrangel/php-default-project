<?php 

$app->get('/historicos-tipos',function(){

 	$historicotipo = HistoricosTipos::listAll();

 	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('deshistoricotipo')) {
		array_push($where, "deshistoricotipo LIKE '%".get('deshistoricotipo')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AD ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_historicostipos
	".$where." limit ?, ?;";

	$paginacao = new Pagination(
        $query,
        array(),
        "HistoricosTipos",
        $itemsPerPage
    );

    $historicostipos = $paginacao->getPage($currentPage);

    echo success(array(
    	"data"=>$historicostipos ->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),

    ));

});

$app->post("/historicos-tipos", function(){

	if(post('idhistoricotipo') > 0){
		$historicotipo = new HistoricoTipo((int)post('idhistoricotipo'));
	}else{
		$historicotipo = new HistoricoTipo();
	}

	$historicotipo->set($_POST);

	$historicotipo->save();

	echo success(array("data"=>$historicotipo->getFields()));

});

$app->delete("/historicos-tipos/:idhistoricotipo", function($idhistoricotipo){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idhistoricotipo > 0){
		throw new Exception("Tipo de historico não informado.", 400);		
	}

	$historicotipo = new HistoricoTipo((int)$idhistoricotipo);

	$historicotipo->remove();

	echo success();

});






 
?>