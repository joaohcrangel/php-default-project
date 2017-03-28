<?php 
$app->get('/configuracoes-tipos',function(){

 	$configuracao = ConfiguracoesTipos::listAll();

 	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('desconfiguracaotipo')) {
		array_push($where, "desconfiguracaotipo LIKE '%".get('desconfiguracaotipo')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AD ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_configuracoestipos
	".$where." limit ?, ?;";

	$paginacao = new Pagination(
        $query,
        array(),
        "ConfiguracoesTipos",
        $itemsPerPage
    );

	$configuracoestipos = $paginacao->getPage($currentPage);

    echo success(array(
    	"data"=>$configuracoestipos->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),

    ));
    
});

$app->post("/configuracoes-tipos", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if(post('idconfiguracaotipo') > 0){
		$configuracao = new ConfiguracaoTipo((int)post('idconfiguracaotipo'));
	}else{
		$configuracao = new ConfiguracaoTipo();
	}

	$configuracao->set($_POST);

	$configuracao->save();

	echo success(array("data"=>$configuracao->getFields()));
});

$app->delete("/configuracoes-tipos/:idconfiguracaotipo", function($idconfiguracaotipo){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idconfiguracaotipo > 0){
		throw new Exception("Configuracao de Campos não informado.", 400);		
	}

	$configuracao = new ConfiguracaoTipo((int)$idconfiguracaotipo);

	$configuracao->remove();

	echo success();

});


 ?>