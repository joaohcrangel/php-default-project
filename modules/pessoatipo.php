<?php

$app->get('/pessoas-tipos',function(){

 	$pessoatipo = PessoasTipos::listAll();

    echo success(array(
         'data'=>$pessoatipo->getFields()
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