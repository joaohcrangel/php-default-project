<?php

$app->get('/permissoes', function () {

	Permissao::checkSession(Permissao::ADMIN);

	echo success(array(
		'data'=>Permissoes::listAll()->getFields()
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