<?php 
 $app->get("/enderecostipos",function(){

   $endereco = EnderecosTipos::listAll();
    echo success(array(
     "data"=> $endereco->getFields()
   	));

 });

 $app->get('/enderecos/cidades', function(){

    Permissao::checkSession(Permissao::ADMIN);

    $cidades = new Cidades();

    $cidades->loadFromQuery("
        SELECT * 
        FROM tb_cidades a
        INNER JOIN tb_estados b ON a.idestado = b.idestado
        WHERE descidade LIKE '".get('q')."%'
        ORDER BY descidade, desuf
    ");

    echo success(array(
        'data'=>$cidades->getFields()
    ));

 });

 $app->get('/enderecos/tipos', function () {

	Permissao::checkSession(Permissao::ADMIN);

	echo success(array(
		'data'=>EnderecosTipos::listAll()->getFields()
	));

});

 $app->post('/enderecos-tipos', function () {

    Permissao::checkSession(Permissao::ADMIN);

    $enderecotipo = new EnderecoTipo($_POST);

    $enderecotipo->save();

    echo success(array(
        'data'=>$enderecotipo->getFields()
    ));

});

$app->delete('/enderecos-tipos/:idenderecotipo', function ($idenderecotipo) {

	Permissao::checkSession(Permissao::ADMIN);

	$enderecotipo = new EnderecoTipo((int)$idenderecotipo);

	$enderecotipo->remove();

	echo success();

});
 

 $app->post("/".DIR_ADMIN."/enderecos", function(){

 	Permissao::checkSession(Permissao::ADMIN, true);

 	if(post('idendereco') > 0){
 		$endereco = new Endereco((int)post('idendereco'));
 	}else{
 		$endereco = new Endereco();
 	}

 	foreach ($_POST as $key => $value) {
 		$endereco->{'set'.$key}($value);
 	}

 	$endereco->save();

 	echo success(array("data"=>$endereco->getFields()));

 });

 $app->delete("/".DIR_ADMIN."/enderecos/:idendereco", function($idendereco){

 	Permissao::checkSession(Permissao::ADMIN, true);

 	if(!(int)$idendereco){
 		throw new Exception("Endereço nãoo informado", 400); 		
 	}

 	$endereco = new Endereco((int)$idendereco);

 	if(!(int)$endereco->getidendereco() > 0){
 		throw new Exception("Endereço não encontrado", 404); 		
 	}

 	$endereco->remove();

 	echo success();

 });

 ?>