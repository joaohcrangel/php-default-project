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

// permissoes
$app->get("/panel/permissao-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/permissao-criar");

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

// Permissao Salvar
$app->get("/panel/permissoes/:idpermissao", function($idpermissao){

	$permissao = new Permissao((int)$idpermissao);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/permissao-salvar", array(
		"permissao"=>$permissao->getFields()
	));

});

$app->get("/panel/cupom-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cupom-criar");

});

/////////////////////////////////////////
// produto-tipo salvar

$app->get("/panel/produtos/tipos/:idprodutotipo", function($idprodutotipo){

	$produto = new ProdutoTipo((int)$idprodutotipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto-tipo-salvar", array(
		"produto"=>$produto->getFields()
	));

});

$app->get("/panel/produtos-tipos-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto-tipo-criar");

});

////////////////////////////////////////////////////
// Documentos-tipos

$app->get("/panel/documentos/tipos/:iddocumentotipo", function($iddocumentotipo){

	$documento = new DocumentoTipo((int)$iddocumentotipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/documento-tipo-salvar", array(
		"documento"=>$documento->getFields()
	));

});

$app->get("/panel/documento-tipo-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/documento-tipo-criar");

});

// Enderecos-tipos

$app->get("/panel/enderecos/tipos/:idenderecotipo", function($idenderecotipo){

	$endereco = new EnderecoTipo((int)$idenderecotipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/endereco-tipo-salvar", array(
		"endereco"=>$endereco->getFields()
	));

});

$app->get("/panel/endereco-tipo-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/endereco-tipo-criar");

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