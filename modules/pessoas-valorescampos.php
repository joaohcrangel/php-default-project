<?php 

$app->get('/pessoas-valorescampos',function(){

 	$pessoavalor = PessoasValoresCampos::listAll();

 	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('descampo')) {
		array_push($where, "descampo LIKE '%".get('descampo')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AD ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_pessoasvalorescampos
	".$where." limit ?, ?;";

	$paginacao = new Pagination(
        $query,
        array(),
        "PessoasValoresCampos",
        $itemsPerPage
    );


    $pessoasvalorescampos = $paginacao->getPage($currentPage);

    echo success(array(
    	"data"=>$pessoasvalorescampos->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),

    ));

});

$app->post("/pessoas-valorescampos", function(){

	if(post('idcampo') > 0){
		$pessoavalor = new PessoaValorCampo((int)post('idcampo'));
	}else{
		$pessoavalor = new PessoaValorCampo();
	}

	$pessoavalor->set($_POST);

	$pessoavalor->save();

	echo success(array("data"=>$pessoavalor->getFields()));

});

$app->delete("/pessoas-valorescampos/:idcampo", function($idcampo){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idcampo > 0){
		throw new Exception("Valores de Campos não informado.", 400);		
	}

	$pessoavalor = new PessoaValorCampo((int)$idcampo);

	$pessoavalor->remove();

	echo success();

});






 
?>