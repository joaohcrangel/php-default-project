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
///////////////////////////////////////////////////////////

// cartoes de credito
$app->get("/panel/cartoes/:idcartao", function($idcartao){

	$cartao = new CartaoCredito((int)$idcartao);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cartao", array(
		"cartao"=>$cartao->getFields()
	));

});

$app->get("/panel/cartao-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cartao-criar");

});
///////////////////////////////////////////////////////////

// cupons
$app->get("/panel/cupons/:idcupom", function($idcupom){

	$cupom = new Cupom((int)$idcupom);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cupom", array(
		"cupom"=>$cupom->getFields()
	));

});

$app->get("/panel/cupom-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cupom-criar");

});
////////////////////////////////////////////////////////////////

// pessoas
$app->get("/panel/pessoas/:idpessoa", function($idpessoa){

	$pessoa = new Pessoa((int)$idpessoa);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$contatos = $pessoa->getContatos();

	$telefones = $contatos->filterBy(array(
		"idcontatotipo"=>Contato::TELEFONE
	), true); // filtrando os contatos que são telefones

	$emails = $contatos->filterBy(array(
		"idcontatotipo"=>Contato::EMAIL
	), true); // filtrando os contatos que são emails

	$documentos = $pessoa->getDocumentos();

	$pessoa->setDocumentos($documentos);
	$pessoa->setTelefones($telefones);
	$pessoa->setEmails($emails);

	$page->setTpl("panel/pessoa", array(
		"pessoa"=>$pessoa->getFields()
	));

});

?>