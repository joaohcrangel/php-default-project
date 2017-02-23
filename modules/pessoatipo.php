<?php

$app->get('/pessoas-tipos',function(){

	Permissao::checkSession(Permissao::ADMIN);

	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");
 	
 	$where = array();

	if(get('despessoatipo')) {
		array_push($where, "despessoatipo LIKE '%".get('despessoatipo')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AD ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_pessoastipos
	".$where." limit ?, ?;";

	$paginacao = new Pagination(
        $query,
        array(),
        "PessoasTipos",
        $itemsPerPage
    );

    $pessoastipos = $paginacao->getPage($currentPage);

    echo success(array(
    	"data"=>$pessoastipos->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal()
    ));
});

$app->post("/pessoas-tipos", function(){

	if(post('idpessoatipo') > 0){
		$pessoa = new PessoaTipo((int)post('idpessoatipo'));
	}else{
		$pessoa = new PessoaTipo();
	}

	$pessoa->set($_POST);

	$pessoa->save();

	echo success(array("data"=>$pessoa->getFields()));

});

$app->delete("/pessoas-tipos/:idpessoatipo", function($idpessoatipo){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idpessoatipo > 0){
		throw new Exception("Tipo de pessoa não informada.", 400);		
	}

	$pessoa = new PessoaTipo((int)$idpessoatipo);

	$pessoa->remove();

	echo success();

});

 ?>