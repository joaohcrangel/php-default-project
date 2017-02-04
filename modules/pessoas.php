<?php

$app->get('/pessoas/:idpessoa',function($idpessoa){
   
	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array(
		'data'=>$pessoa->getFields()
	));

});

// $app->delete('/pessoas/:idpessoa',function($idpessoa){
   
// 	$pessoa = new Pessoa((int)$idpessoa);

// 	$pessoa->remove();

// 	echo success();

// });

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

		$whereOr = array();

		array_push($whereOr, "despessoa LIKE '%".utf8_decode($q)."%'");
		array_push($whereOr, "desusuario = '".utf8_decode($q)."'");
		array_push($whereOr, "desemail = '".utf8_decode($q)."'");
		array_push($whereOr, "destelefone = '".utf8_decode($q)."'");
		array_push($whereOr, "descpf = '".utf8_decode($q)."'");
		array_push($whereOr, "descnpj = '".utf8_decode($q)."'");
		array_push($whereOr, "desrg = '".utf8_decode($q)."'");

		array_push($where, "(".implode(" OR ", $whereOr).")");
	}

	if (isset($_GET['idpessoatipo'])) {
		array_push($where, "idpessoatipo = ".((int)get('idpessoatipo')));
	}

	if (count($where) > 0) {
		$where = "WHERE ".implode(" AND ", $where);
	} else {
		$where = "";
	}

	/***********************************************************************************************/
	$pagina = (int)get('pagina');//Página atual
	$itensPorPagina = (int)get('limite');//Itens por página

	$paginacao = new Pagination(
		"SELECT SQL_CALC_FOUND_ROWS * FROM tb_pessoasdados ".$where." ORDER BY despessoa LIMIT ?, ?",//Query com as duas interrogações no LIMIT
	    array(),//Outros parâmetros
	    'Pessoas',//Coleção que será retornada
	    $itensPorPagina//Informo os itens por página
	);

	$pessoas = $paginacao->getPage($pagina);//Neste momento vai no banco e solicita os itens da página específica

	echo success(array(
   		"data"=>$pessoas->getFields(),//Devolvo os dados
   		"total"=>$paginacao->getTotal(),//Mostro o total
   		"currentPage"=>$pagina,//Mostro a página atual
   		"itensPerPage"=>$itensPorPagina//Mostro a quantidade de itens por página
	));
	/***********************************************************************************************/

});

$app->get("/pessoas/all", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	echo success(array("data"=>Pessoas::listAll()->getFields()));

});

$app->post("/pessoas", function(){

	//Permissao::checkSession(Permissao::ADMIN, true);

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

	// Permissao::checkSession(Permissao::ADMIN, true);

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

	// Permissao::checkSession(Permissao::ADMIN, true);

	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_sitecontatos
		WHERE idpessoa = ".$idpessoa." ORDER BY desmensagem LIMIT ?, ?;
	";

	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');

	$paginacao = new Pagination(
		$query,
		array(),
		"SiteContatos",
		$itemsPerPage
	);

	$pessoa = $paginacao->getPage($pagina);	

	echo success(array(
		"data"=>$pessoa->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

// pagamentos
$app->get("/pessoas/:idpessoa/pagamentos", function($idpessoa){

	// Permissao::checkSession(Permissao::ADMIN, true);

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.*, c.desformapagamento, d.* FROM tb_pagamentos a
			INNER JOIN tb_pessoas b USING(idpessoa)
	        INNER JOIN tb_formaspagamentos c ON a.idformapagamento = c.idformapagamento
	        INNER JOIN tb_pagamentosstatus d ON a.idstatus = d.idstatus
		WHERE a.idpessoa = ".$idpessoa." LIMIT ?, ?;
	";

	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');

	$paginacao = new Pagination(
		$query,
		array(),
		"Pagamentos",
		$itemsPerPage
	);

	$pessoa = $paginacao->getPage($pagina);

	echo success(array(
		"data"=>$pessoa->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

// cartoes de credito
$app->get("/pessoas/:idpessoa/cartoes", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array("data"=>$pessoa->getCartoesCreditos()->getFields()));

});

// carrinhos
$app->get("/pessoas/:idpessoa/carrinhos", function($idpessoa){

	// Permissao::checkSession(Permissao::ADMIN, true);

	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_carrinhos
		WHERE idpessoa = ".$idpessoa." LIMIT ?, ?;
	";

	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');

	$paginacao = new Pagination(
		$query,
		array(),
		"Carrinhos",
		$itemsPerPage
	);

	$pessoa = $paginacao->getPage($pagina);

	echo success(array(
		"data"=>$pessoa->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

// enderecos
$app->get("/pessoas/:idpessoa/enderecos", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array("data"=>$pessoa->getEnderecos()->getFields()));

});

// usuarios
$app->get("/pessoas/:idpessoa/usuarios", function($idpessoa){

	Permissao::checkSession(Permissao::ADMIN, true);

	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array("data"=>$pessoa->getUsuarios()->getFields()));

});

?>