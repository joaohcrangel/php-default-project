<?php

// produtos
$app->get("/panel/products/:idproduct", function($idproduct){

	$conf = Session::getconfigurations();

	$product = new Product((int)$idproduct);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/product", array(
		"product"=>$product->getFields(),
		"diretorio"=>$conf->getByName("UPLOAD_DIR")
	));

});

$app->get("/panel/product-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/product-create");

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

	$page->setTpl("panel/contact-type-save", array(
		"contact"=>$contact->getFields()
	));

});

$app->get("/panel/contacts-types-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/contact-type-create");

});

// pessoas tipos
$app->get("/panel/persons-types/:idpersontype", function($idpersontype){

	$person = new PersonType((int)$idpersontype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/person-type-save", array( // nome do arquivo panel, vai no html no plural
		"person"=>$person->getFields()
	));

});

$app->get("/panel/persons-types-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/person-type-create");

});

// gateways
$app->get("/panel/gateways-save/:idgateway", function($idgateway){

	$gateway = new Gateway((int)$idgateway);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/gateway-save", array( 
		"gateway"=>$gateway->getFields()
	));

});

$app->get("/panel/gateways-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/gateways-create");

});

// pedidos-status
$app->get("/panel/orders-status/:idstatus", function($idstatus){

	$status = new OrderStatus((int)$idstatus);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/orders-status-save", array(
		"status"=>$status->getFields()
	));

});

$app->get("/panel/orders-status-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/orders-status-create");

});

// orders negotiations types
$app->get("/panel/ordersnegotiations-types/:idnegociacao", function($idnegociacao){

	$order = new OrderNegotiationType((int)$idnegociacao);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/ordernegotiation-type-save", array(
		"order"=>$order->getFields()
	));

});

$app->get("/panel/ordernegotiation-type-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/ordernegotiation-type-create");

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

	$page->setTpl("panel/form-payment", array(
		"formpayment"=>$form->getFields()
	));

});

$app->get("/panel/form-payment-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/form-payment-create");

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

	$page->setTpl("panel/permission-create");

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

	$page->setTpl("panel/coupons-types-save", array(
		"coupon"=>$coupon->getFields()
	));

});

$app->get("/panel/coupons-types-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/coupons-types-create");

});

// Permissao Salvar
$app->get("/panel/permissions/:idpermission", function($idpermission){

	$permission = new Permission((int)$idpermission);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/permission-save", array(
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

	$page->setTpl("panel/product-type-save", array(
		"product"=>$product->getFields()
	));

});

$app->get("/panel/products-types-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/product-type-create");

});
/////////////////////////////////////////
// usuario-tipo salvar

$app->get("/panel/users-types/:idusertype", function($idusertype){

	$usertype = new UserType((int)$idusertype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/user-type-save", array(
		"usertype"=>$usertype->getFields()
	));


});

$app->get("/panel/user-type-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/user-type-create");

});

// pessoas-valores-campos
$app->get("/panel/persons-valuesfields/:idfield", function($idfield){

	$personvalue = new PersonValueField((int)$idfield);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/person-valuefield-save", array(
		"personvalue"=>$personvalue->getFields()
	));

});

$app->get("/panel/persons-valuesfields-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/person-valuefield-create");

});

// configuracoes-tipos
$app->get("/panel/configurations-types/:idconfigurationtype", function($idconfigurationtype){

	$configuration = new ConfigurationType((int)$idconfigurationtype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/configuration-type-save", array(
		"configuration"=>$configuration->getFields()
	));

});

$app->get("/panel/configurations-types-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/configuration-type-create");

});

/////////////////////////////////////////
// lugares-tipos salvar
$app->get("/panel/places-types/:idplacetype", function($idplacetype){

	$placetype = new PlaceType((int)$idplacetype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/places-types-save", array(
		"placetype"=>$placetype->getFields()
	));

});

$app->get("/panel/places-types-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/places-types-create");

});

////////////////////////////////////////////////////
// documentos-tipos
$app->get("/panel/documents/types/:iddocumenttype", function($iddocumenttype){

	$document = new DocumentType((int)$iddocumenttype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/documento-tipo-salvar", array(
		"document"=>$document->getFields()
	));

});

$app->get("/panel/document-type-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/documento-tipo-criar");

});

// enderecos-types
$app->get("/panel/addresses/types/:idaddresstype", function($idaddresstype){

	$address = new AddressType((int)$idaddresstype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/endereco-tipo-salvar", array(
		"address"=>$address->getFields()
	));

});

$app->get("/panel/address-type-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/endereco-tipo-criar");

});

// userslogs-tipos
$app->get("/panel/userslogs-types/:idlogtype", function($idlogtype){

	$logs = new UserLogType((int)$idlogtype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/userslog-type-save", array(
		"logs"=>$logs->getFields()
	));

});

$app->get("/panel/userslog-type-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/userslog-type-create");

});

// transaçoes-tipos
$app->get("/panel/transactions-types/:idtransactiontype", function($idtransactiontype){

	$transaction = new TransactionType((int)$idtransactiontype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/transaction-type-save", array(
		"transaction"=>$transaction->getFields()
	));

});

$app->get("/panel/transaction-type-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/transaction-type-create");

});

// blogs tags
$app->get("/panel/blog-tags/:idtag", function($idtag){

	$tag = new BlogTag((int)$idtag);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/blog-tag-save", array(
		"tag"=>$tag->getFields()
	));

});

$app->get("/panel/blog-tag-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/blog-tag-create");

});


// blogs categoria
$app->get("/panel/blog-categories/:idcategory", function($idcategory){

	$category = new BlogCategory((int)$idcategory);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/blog-category-save", array(
		"category"=>$category->getFields()
	));

});

$app->get("/panel/blog-category-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/blog-category-create");

});

// historicos-tipos
$app->get("/panel/logs-types/:idlogtype", function($idlogtype){

	$logtype = new LogType((int)$idlogtype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/log-type-save", array(
		"logtype"=>$logtype->getFields()
	));

});

$app->get("/panel/log-type-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/log-type-create");

});
////////////////////////////////////////////////////////////////

// persons
$app->get("/panel/persons/:idperson", function($idperson){

	$person = new Person((int)$idperson);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$contacts = $person->getContacts();

	$phones = $contacts->filterBy(array(
		"idcontacttype"=>Contact::TELEFONE
	), true); // filtrando os contacts que são telefones

	$emails = $contacts->filterBy(array(
		"idcontacttype"=>Contact::EMAIL
	), true); // filtrando os contacts que são emails

	$documents = $person->getDocuments();

	$person->setDocuments($documents);
	$person->setPhones($phones);
	$person->setEmails($emails);

	$page->setTpl("panel/pessoa", array(
		"person"=>$person->getFields()
	));

});

///////////////////////////////////////////////////////////
// carrinhos
$app->get("/panel/carts/:idcart", function($idcart){

	$cart = new Cart((int)$idcart);

	$freight = new CartFreight((int)$idcart);

	$cart->setProducts($cart->getProducts()->getFields());
	$cart->setCoupons($cart->getCoupons()->getFields());
	$cart->setFreight($freight->getFields());

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cart", array(
		"cart"=>$cart->getFields()
	));

});

////////////////////////////////////////////////////////////
// lugares
$app->get("/panel/places/:idplace", function($idplace){

	$config = Session::getConfigurations();

	$place = new Place((int)$idplace);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$data = $place->getFields();

	$schedules = $place->getPlacesSchedules()->getFields();

	if(!count($schedules) > 0) $schedules = Language::getWeekdays();

	$data['Schedules'] = $schedules;

	$page->setTpl("panel/lugar", array(
		"place"=>$data,
		"mapKey"=>$config->getByName("GOOGLE_MAPS_KEY"),
		"addressestypes"=>AddressesTypes::listAll()->getFields()
	));

});

$app->get("/panel/place-create", function(){

	$config = Session::getConfigurations();

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/lugar-criar", array(
		"mapKey"=>$config->getByName("GOOGLE_MAPS_KEY")
	));

});

$app->get("/panel/place-logs", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/place-logs", array(
		"ids"=>$_GET['ids'],
		"logs"=>Language::getWeekdays()
	));

});
/////////////////////////////////////////////////////////////

// cursos
$app->get("/panel/courses/:idcourse", function($idcourse){

	$course = new Course((int)$idcourse);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/curso", array(
		"course"=>$course->getFields()
	));

});

$app->get("/panel/course-create", function(){

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

$app->get("/panel/carousel-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carousel-criar");

});
//////////////////////////////////////////////////////////////////

// carousels items tipos
$app->get("/panel/carousels-items-types/:idtype", function($idtype){

	$type = new CarouselItemType((int)$idtype);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carousel-item-type-save", array(
		"type"=>$type->getFields()
	));

});

$app->get("/panel/carousel-item-type-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carousel-item-type-create");

});
////////////////////////////////////////////////////////////////

// paises
$app->get("/panel/countries/:idcountry", function($idcountry){

	$country = new Country((int)$idcountry);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/country", array(
		"country"=>$country->getFields()
	));

});

$app->get("/panel/country-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/country-create");

});
/////////////////////////////////////////////////////

// estados
$app->get("/panel/states/:idstate", function($idstate){

	$state = new State((int)$idstate);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/state", array(
		"state"=>$state->getFields()
	));

});

$app->get("/panel/state-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/state-create");

});
///////////////////////////////////////////////////////

// cidades
$app->get("/panel/cities/:idcity", function($idcity){

	$city = new City((int)$idcity);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/city", array(
		"city"=>$city->getFields()
	));

});

$app->get("/panel/city-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/city-create");

});
////////////////////////////////////////////////////

// persons categorias tipos
$app->get("/panel/persons-categories-types/:idcategory", function($idcategory){

	$category = new PersonCategoryType((int)$idcategory);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/person-category-type-save", array(
		"category"=>$category->getFields()
	));

});

$app->get("/panel/person-category-type-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/person-category-type-create");

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

$app->get("/panel/url-create", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/url-criar");

});

?>