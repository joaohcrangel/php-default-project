<?php

$app->get('/permissoes', function () {

	Permissao::checkSession(Permissao::ADMIN);

	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('despermissao')) {
		array_push($where, "despermissao LIKE '%".get('despermissao')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AD ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_permissoes
	".$where." limit ?, ?;";

	$paginacao = new Pagination(
        $query,
        array(),
        "Permissoes",
        $itemsPerPage
    );

    $permissoes = $paginacao->getPage($currentPage);


	echo success(array(
		"data"=>$permissoes->getFields(),
		"currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),

    ));

});

$app->post('/permissoes', function () {

	Permissao::checkSession(Permissao::ADMIN);

	$permissao = new Permissao($_POST);

	$permissao->save();

	echo success(array(
		'data'=>$permissao->getFields()
	));

});

$app->post('/permissoes/:idpermissao', function ($idpermissao) {
	
	Permissao::checkSession(Permissao::ADMIN);

	$permissao = new Permissao((int)$idpermissao);

	$permissao->set($_POST);

	$permissao->save();

	echo success(array(
		'data'=>$permissao->getFields()
	));

});

$app->delete('/permissoes/:idpermissao', function ($idpermissao) {

	Permissao::checkSession(Permissao::ADMIN);

	$permissao = new Permissao((int)$idpermissao);

	$permissao->remove();

	echo success();

});

$app->get('/permissoes/:idpermissao', function ($idpermissao) {

	Permissao::checkSession(Permissao::ADMIN);
	
	$permissao = new Permissao((int)$idpermissao);

	echo success(array(
		'data'=>$permissao->getFields()
	));

});

?>