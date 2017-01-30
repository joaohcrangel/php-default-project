<?php

$app->get('/pessoas/:idpessoa',function($idpessoa){
   
	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array(
		'data'=>$pessoa->getFields()
	));

});

$app->delete('/pessoas/:idpessoa',function($idpessoa){
   
	$pessoa = new Pessoa((int)$idpessoa);

	$pessoa->remove();

	echo success();

});

$app->get('/pessoas/:idpessoa/contatos',function($idpessoa){
     
     $pessoa = new Pessoa(array(
		'idpessoa'=>(int)$idpessoa
	));

     $contato = $pessoa->getContatos();

	echo success(array(
         'data'=>$contato->getFields()
    ));  

});

$app->get('/pessoas/:idpessoa/historicos',function($idpessoa){
     
     $pessoa = new Pessoa(array(
		'idpessoa'=>(int)$idpessoa
	));

     $historico = $pessoa->getHistoricos();

	echo success(array(
         'data'=>$historico->getFields()
    ));  

});

$app->get("/pessoas",function(){
	

	$q = get("q");

	$where = array();

	if ($q) {
		array_push($where, "despessoa LIKE '%".$q."%'");
	}

	if (count($where) > 0) {
		$where = "WHERE ".implode(" AND ", $where);
	} else {
		$where = "";
	}

	$pessoas = new Pessoas();
	$pessoas->loadFromQuery("
		select * from tb_pessoasdados ".$where." order by despessoa
	");
	echo success(array(
   		"data"=>$pessoas->getFields()
	));
});

$app->get("/pessoas/all", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	echo success(array("data"=>Pessoas::listAll()->getFields()));

});

$app->post("/pessoas", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idpessoa') > 0){
		$pessoa = new Pessoa((int)post('idpessoa'));
	}else{
		$pessoa = new Pessoa();
	}

	$pessoa->set($_POST);

	$pessoa->save();

	echo success(array("data"=>$pessoa->getFields()));

});

$app->delete("/pessoas/:idpessoa", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idpessoa){
		throw new Exception("Pessoa não informada", 400);		
	}

	$pessoa = new Pessoa((int)$idpessoa);

	if(!(int)$pessoa->getidpessoa() > 0){
		throw new Exception("Pessoa não encontrada", 404);		
	}

	$pessoa->remove();

	echo success();

});

// documentos
$app->get("/pessoas/:idpessoa/documentos", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array("data"=>$pessoa->getDocumentos()->getFields()));

});

// contatos
$app->get("/pessoas/:idpessoa/contatos", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array("data"=>$pessoa->getContatos()->getFields()));

});

// site contatos
$app->get("/pessoas/:idpessoa/fale-conosco", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array("data"=>$pessoa->getSiteContatos()->getFields()));

});

// pagamentos
$app->get("/pessoas/:idpessoa/pagamentos", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array("data"=>$pessoa->getPagamentos()->getFields()));

});

// cartoes de credito
$app->get("/pessoas/:idpessoa/cartoes", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array("data"=>$pessoa->getCartoesCreditos()->getFields()));

});

// carrinhos
$app->get("/pessoas/:idpessoa/carrinhos", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array("data"=>$pessoa->getCarrinhos()->getFields()));

});

// enderecos
$app->get("/pessoas/:idpessoa/enderecos", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array("data"=>$pessoa->getEnderecos()->getFields()));

});

?>