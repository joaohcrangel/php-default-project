<?php

// produtos
$app->get("/panel/products/:idproduct", function($idproduct){

	$conf = Session::getconfigurations();

	$product = new Product((int)$idproduct);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto", array(
		"product"=>$product->getFields(),
		"diretorio"=>$conf->getByName("UPLOAD_DIR")
	));

});

$app->get("/panel/product-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto-criar");

});

// pagamentos
$app->get("/panel/payments/:idpayment", function($idpayment){

	$payment = new Payment((int)$idpayment);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pagamento", array(
		"payment"=>$payment->getFields()
	));

});

$app->get("/panel/payment-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pagamento-criar");

});

// contatos tipos
$app->get("/panel/contacts-types-save/:idcontacttype", function($idcontacttype){

	$contact = new ContactType((int)$idcontacttype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/contato-tipo-salvar", array(
		"contact"=>$contact->getFields()
	));

});

$app->get("/panel/contacts-types-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/contato-tipo-criar");

});

// pessoas tipos
$app->get("/panel/persons-types/:idpersontype", function($idpersontype){

	$person = new PersonType((int)$idpersontype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pessoa-tipo-salvar", array( // nome do arquivo panel, vai no html no plural
		"person"=>$person->getFields()
	));

});

$app->get("/panel/persons-types-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pessoa-tipo-criar");

});

// gateways
$app->get("/panel/gateways-save/:idgateway", function($idgateway){

	$gateway = new Gateway((int)$idgateway);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/gateway-salvar", array( 
		"gateway"=>$gateway->getFields()
	));

});

$app->get("/panel/gateways-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/gateways-criar");

});

// pedidos-status
$app->get("/panel/orders-status/:idstatus", function($idstatus){

	$status = new OrderStatus((int)$idstatus);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pedidos-status-salvar", array(
		"status"=>$status->getFields()
	));

});

$app->get("/panel/pedidos-status-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/orders-status-criar");

});

// orders negotiations types
$app->get("/panel/ordersnegotiations-types/:idnegociacao", function($idnegociacao){

	$order = new OrderNegotiationType((int)$idnegociacao);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pedidonegociacao-tipo-salvar", array(
		"order"=>$order->getFields()
	));

});

$app->get("/panel/ordernegotiation-type-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pedidonegociacao-tipo-criar");

});

// site contacts
$app->get("/panel/sites-contacts/:idsitecontact", function($idsitecontact){

	$site = new SiteContact((int)$idsitecontact);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/site-contato", array(
		"sitecontact"=>$site->getFields()
	));

});
///////////////////////////////////////////////////////////////

// formas de pagamento
$app->get("/panel/forms-payments/:idformpayment", function($idformpayment){

	$form = new FormPayment((int)$idformpayment);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/forma-pagamento", array(
		"formpayment"=>$form->getFields()
	));

});

$app->get("/panel/form-payment-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/forma-pagamento-criar");

});
///////////////////////////////////////////////////////////

// cartoes de credito
$app->get("/panel/cards/:idcard", function($idcard){

	$card = new CreditCard((int)$idcard);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cartao", array(
		"card"=>$card->getFields()
	));

});

$app->get("/panel/card-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cartao-criar");

});

// permissoes
$app->get("/panel/permission-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/permissao-criar");

});

///////////////////////////////////////////////////////////

// cupons
$app->get("/panel/coupons/:idcoupon", function($idcoupon){

	$coupon = new coupon((int)$idcoupon);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cupom", array(
		"coupon"=>$coupon->getFields()
	));

});

$app->get("/panel/coupon-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cupom-criar");

});
////////////////////////////////
//cupons-tipos

$app->get("/panel/coupons-types/:idcoupontype", function($idcoupontype){

	$coupon = new CouponType((int)$idcoupontype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cupons-tipos-salvar", array(
		"coupon"=>$coupon->getFields()
	));

});

$app->get("/panel/coupons-types-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cupons-tipos-criar");

});

// Permissao Salvar
$app->get("/panel/permissions/:idpermission", function($idpermission){

	$permission = new Permission((int)$idpermission);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/permissao-salvar", array(
		"permission"=>$permission->getFields()
	));

});

/////////////////////////////////////////
// product-type salvar
$app->get("/panel/products-types/:idproducttype", function($idproducttype){

	$product = new ProductType((int)$idproducttype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto-tipo-salvar", array(
		"product"=>$product->getFields()
	));

});

$app->get("/panel/products-types-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto-tipo-criar");

});
/////////////////////////////////////////
// usuario-tipo salvar

$app->get("/panel/users-types/:idusertype", function($idusertype){

	$usertype = new UserType((int)$idusertype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/usuario-tipo-salvar", array(
		"usertype"=>$usertype->getFields()
	));

});

$app->get("/panel/user-type-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/usuario-tipo-criar");

});

// pessoas-valores-campos
$app->get("/panel/persons-valuesfields/:idfield", function($idfield){

	$personvalue = new PersonValueField((int)$idfield);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pessoa-valor-campo-salvar", array(
		"personvalue"=>$personvalue->getFields()
	));

});

$app->get("/panel/persons-valuesfields-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pessoa-valor-campo-criar");

});

// configuracoes-tipos
$app->get("/panel/configurations-types/:idconfiguracaotype", function($idconfiguracaotype){

	$configuracao = new Configuracaotype((int)$idconfiguracaotype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/configuracao-type-salvar", array(
		"configuracao"=>$configuracao->getFields()
	));

});

$app->get("/panel/configurations-types-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/configuracao-type-criar");

});

/////////////////////////////////////////
// Lugares-types salvar

$app->get("/panel/lugares-types/:idlugartype", function($idlugartype){

	$lugartype = new Lugartype((int)$idlugartype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/lugares-types-salvar", array(
		"lugartype"=>$lugartype->getFields()
	));

});

$app->get("/panel/lugares-types-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/lugares-types-criar");

});

////////////////////////////////////////////////////
// Documentos-types

$app->get("/panel/documentos/types/:iddocumentotype", function($iddocumentotype){

	$documento = new Documentotype((int)$iddocumentotype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/documento-type-salvar", array(
		"documento"=>$documento->getFields()
	));

});

$app->get("/panel/documento-type-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/documento-type-criar");

});

// Enderecos-types

$app->get("/panel/enderecos/types/:idenderecotype", function($idenderecotype){

	$endereco = new Enderecotype((int)$idenderecotype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/endereco-type-salvar", array(
		"endereco"=>$endereco->getFields()
	));

});

$app->get("/panel/endereco-type-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/endereco-type-criar");

});

// Historicos-types

$app->get("/panel/historicos-types/:idhistoricotype", function($idhistoricotype){

	$historicotype = new Historicotype((int)$idhistoricotype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/historico-type-salvar", array(
		"historicotype"=>$historicotype->getFields()
	));

});

$app->get("/panel/historico-type-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/historico-type-criar");

});
////////////////////////////////////////////////////////////////

// persons
$app->get("/panel/persons/:idperson", function($idperson){

	$person = new person((int)$idperson);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$contacts = $person->getcontacts();

	$telefones = $contacts->filterBy(array(
		"idcontacttype"=>contact::TELEFONE
	), true); // filtrando os contacts que são telefones

	$emails = $contacts->filterBy(array(
		"idcontacttype"=>contact::EMAIL
	), true); // filtrando os contacts que são emails

	$documentos = $person->getDocumentos();

	$person->setDocumentos($documentos);
	$person->setTelefones($telefones);
	$person->setEmails($emails);

	$page->setTpl("panel/person", array(
		"person"=>$person->getFields()
	));

});

///////////////////////////////////////////////////////////
// carrinhos
$app->get("/panel/carrinhos/:idcarrinho", function($idcarrinho){

	$carrinho = new Carrinho((int)$idcarrinho);

	$frete = new CarrinhoFrete((int)$idcarrinho);

	$carrinho->setproducts($carrinho->getproducts()->getFields());
	$carrinho->setcoupons($carrinho->getcoupons()->getFields());
	$carrinho->setFrete($frete->getFields());

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carrinho", array(
		"carrinho"=>$carrinho->getFields()
	));

});

////////////////////////////////////////////////////////////
// lugares
$app->get("/panel/lugares/:idlugar", function($idlugar){

	$config = Session::getconfigurations();

	$lugar = new Lugar((int)$idlugar);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$data = $lugar->getFields();

	$horarios = $lugar->getLugaresHorarios()->getFields();

	if(!count($horarios) > 0) $horarios = Language::getWeekdays();

	$data['Horarios'] = $horarios;

	$page->setTpl("panel/lugar", array(
		"lugar"=>$data,
		"mapKey"=>$config->getByName("GOOGLE_MAPS_KEY"),
		"enderecostypes"=>Enderecostypes::listAll()->getFields()
	));

});

$app->get("/panel/lugar-criar", function(){

	$config = Session::getconfigurations();

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/lugar-criar", array(
		"mapKey"=>$config->getByName("GOOGLE_MAPS_KEY")
	));

});

$app->get("/panel/lugar-horarios", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/lugar-horarios", array(
		"ids"=>$_GET['ids'],
		"horarios"=>Language::getWeekdays()
	));

});
/////////////////////////////////////////////////////////////

// cursos
$app->get("/panel/cursos/:idcurso", function($idcurso){

	$curso = new Curso((int)$idcurso);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/curso", array(
		"curso"=>$curso->getFields()
	));

});

$app->get("/panel/curso-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/curso-criar");

});
//////////////////////////////////////////////////////////////////////

// carousels
$app->get("/panel/carousels/:idcarousel", function($idcarousel){

	$carousel = new Carousel((int)$idcarousel);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carousel", array(
		"carousel"=>$carousel->getFields()
	));

});

$app->get("/panel/carousel-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carousel-criar");

});
//////////////////////////////////////////////////////////////////

// carousels items types
$app->get("/panel/carousels-items-types/:idtype", function($idtype){

	$type = new CarouselItemtype((int)$idtype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carousel-item-type-salvar", array(
		"type"=>$type->getFields()
	));

});

$app->get("/panel/carousel-item-type-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carousel-item-type-criar");

});
////////////////////////////////////////////////////////////////

// paises
$app->get("/panel/paises/:idpais", function($idpais){

	$pais = new Pais((int)$idpais);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pais", array(
		"pais"=>$pais->getFields()
	));

});

$app->get("/panel/pais-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pais-criar");

});
/////////////////////////////////////////////////////

// estados
$app->get("/panel/estados/:idestado", function($idestado){

	$estado = new Estado((int)$idestado);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/estado", array(
		"estado"=>$estado->getFields()
	));

});

$app->get("/panel/estado-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/estado-criar");

});
///////////////////////////////////////////////////////

// cidades
$app->get("/panel/cidades/:idcidade", function($idcidade){

	$cidade = new Cidade((int)$idcidade);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cidade", array(
		"cidade"=>$cidade->getFields()
	));

});

$app->get("/panel/cidade-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cidade-criar");

});
////////////////////////////////////////////////////

// persons categorias types
$app->get("/panel/persons-categorias-types/:idcategoria", function($idcategoria){

	$categoria = new personCategoriatype((int)$idcategoria);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/person-categoria-type", array(
		"categoria"=>$categoria->getFields()
	));

});

$app->get("/panel/person-categoria-type-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/person-categoria-type-criar");

});
///////////////////////////////////////////////////////////

// urls
$app->get("/panel/urls/:idurl", function($idurl){

	$url = new Url((int)$idurl);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/url", array(
		"url"=>$url->getFields()
	));

});

$app->get("/panel/url-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/url-criar");

});

?>