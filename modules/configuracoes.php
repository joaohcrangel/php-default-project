<?php 

$app->get("/configuracoes", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $configuracoes = Configuracoes::listAll();

    echo success(array(
    	'data'=>$configuracoes->getFields()
    ));

});

$app->post("/configuracoes", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if ((int)post('idconfiguracao') > 0) {
		$conf = new Configuracao((int)post('idconfiguracao'));
	} else {
		$conf = new Configuracao();
	}

	$conf->set($_POST);

	$conf->save();

	$configuracoes = Configuracoes::listAll();
	Session::setConfiguracoes($configuracoes);

	echo success(array(
		'data'=>$conf->getFields()
	));

});

$app->delete("/configuracoes/:idconfiguracao", function($idconfiguracao){

	Permissao::checkSession(Permissao::ADMIN, true);

	if (!(int)$idconfiguracao > 0) {
		throw new Exception("O ID não foi informado.");		
	}

	$conf = new Configuracao((int)$idconfiguracao);

	$conf->remove();

	$configuracoes = Configuracoes::listAll();
	Session::setConfiguracoes($configuracoes);

	echo success();

});

?>