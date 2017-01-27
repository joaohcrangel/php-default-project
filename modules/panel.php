<?php

// produtos
$app->get("/panel/produtos/:idproduto", function($idproduto){

	$produto = new Produto((int)$idproduto);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto", array(
		"produto"=>$produto->getFields()
	));

});

$app->get("/panel/produto-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto-criar");

});

// pagamentos
$app->get("/panel/pagamentos/:idpagamento", function($idpagamento){

	$pagamento = new Pagamento((int)$idpagamento);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pagamento", array(
		"pagamento"=>$pagamento->getFields()
	));

});

$app->get("/panel/pagamento-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pagamento-criar");

});

// site contatos
$app->get("/panel/sites-contatos/:idsitecontato", function($idsitecontato){

	$site = new SiteContato((int)$idsitecontato);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/site-contato", array(
		"sitecontato"=>$site->getFields()
	));

});
///////////////////////////////////////////////////////////////

// formas de pagamento
$app->get("/panel/formas-pagamentos/:idformapagamento", function($idformapagamento){

	$forma = new FormaPagamento((int)$idformapagamento);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/forma-pagamento", array(
		"formapagamento"=>$forma->getFields()
	));

});

$app->get("/panel/forma-pagamento-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/forma-pagamento-criar");

});

?>