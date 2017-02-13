<?php 

$app->get('/pessoas-valorescampos',function(){

 	$pessoavalor = PessoasValoresCampos::listAll();

    echo success(array(
         'data'=>$pessoavalor->getFields()
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