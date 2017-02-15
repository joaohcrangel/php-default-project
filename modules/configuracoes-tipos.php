<?php 
$app->get('/configuracoes-tipos',function(){

 	$configuracao = ConfiguracoesTipos::listAll();

    echo success(array(
         'data'=>$configuracao->getFields()
    ));
});

$app->post("/configuracoes-tipos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idconfiguracaotipo') > 0){
		$configuracao = new ConfiguracaoTipo((int)post('idconfiguracaotipo'));
	}else{
		$configuracao = new ConfiguracaoTipo();
	}

	$configuracao->set("_post");

	$configuracao->save();

	echo success(array("data"=>$configuracao->getFields()));
});

$app->delete("/configuracoes-tipos/:idconfiguracaotipo", function($idconfiguracaotipo){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idconfiguracaotipo > 0){
		throw new Exception("Configuracao de Campos não informado.", 400);		
	}

	$configuracao = new ConfiguracaoTipo((int)$idconfiguracaotipo);

	$configuracao->remove();

	echo success();

});


 ?>