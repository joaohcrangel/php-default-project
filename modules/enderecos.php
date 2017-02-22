<?php 
 $app->get("/enderecostipos",function(){

   $endereco = EnderecosTipos::listAll();
    echo success(array(
     "data"=> $endereco->getFields()
   	));

 });

$app->get('/enderecos/cep/:nrcep', function($nrcep){

    Permissao::checkSession(Permissao::ADMIN);

    $endereco = Endereco::getByCEP($nrcep);

    echo success(array(
        'data'=>$endereco->getFields()
    ));

});

 $app->get('/enderecos/cidades', function(){

    Permissao::checkSession(Permissao::ADMIN);

    $cidades = new Cidades();

    $cidades->loadFromQuery("
        SELECT * 
        FROM tb_cidades a
        INNER JOIN tb_estados b ON a.idestado = b.idestado
        WHERE descidade LIKE '".utf8_decode(get('q'))."%'
        ORDER BY descidade, desuf
        LIMIT 10
    ");

    echo success(array(
        'data'=>$cidades->getFields()
    ));

 });

 $app->get('/enderecos/tipos', function () {

	Permissao::checkSession(Permissao::ADMIN);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('desenderecotipo')) {
        array_push($where, "desenderecotipo LIKE '%".get('desenderecotipo')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AND ', $where);
    } else {
        $where = '';
    }

    $query = "
        SELECT SQL_CALC_FOUND_ROWS *
        FROM tb_enderecostipos 
        ".$where." LIMIT ?, ?;";

      $paginacao = new Pagination(
        $query,
        array(),
        "EnderecosTipos",
        $itemsPerPage
    );

    $enderecostipos = $paginacao->getPage($currentPage);

    echo success(array(
        "data"=>$enderecostipos->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),

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