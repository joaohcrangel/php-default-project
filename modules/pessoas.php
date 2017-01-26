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

$app->post("/pessoas", function(){

	if(post('idpessoa') > 0){
		$pessoa = new Pessoa((int)post('idpessoa'));
	}else{
		$pessoa = new Pessoa();
	}

	$pessoa->set($_POST);

	$pessoa->save();

	echo success(array("data"=>$pessoa->getFields()));

});

?>