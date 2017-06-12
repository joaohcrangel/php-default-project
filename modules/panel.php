<?php

// produtos
$app->get("/panel/products/:idproduct", function($idproduct){

	$conf = Hcode\Session::getconfigurations();

	$product = new Hcode\Shop\Product((int)$idproduct);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\product", array(
		"product"=>$product->getFields(),
		"diretorio"=>$conf->getByName("UPLOAD_DIR")
	));

});

$app->get("/panel/product-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\product-create");

});

$app->get("/panel/orders/:idorder", function($idorder){

	$order = new Hcode\Shop\Order((int)$idorder);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\pagamento", array(
		"order"=>$order->getFields()
	));

});

$app->get("/panel/order-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\pagamento-criar");

});

// contatos tipos
$app->get("/panel/contacts-types-save/:idcontacttype", function($idcontacttype){

	$contact = new Hcode\Contact\Type((int)$idcontacttype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\contact-type-save", array(
		"contact"=>$contact->getFields()
	));

});

$app->get("/panel/contacts-types-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\contact-type-create");

});

// pessoas tipos
$app->get("/panel/persons-types/:idpersontype", function($idpersontype){

	$person = new Hcode\Person\PersonType((int)$idpersontype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\person-type-save", array( // nome do arquivo panel, vai no html no plural
		"person"=>$person->getFields()
	));

});


$app->get("/panel/persons-types-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\person-type-create");

});

// Material-type

$app->get("/panel/materiais-types/:idtype", function($idtype){

	$material = new Hcode\Stand\Material\Type((int)$idtype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\material-type-save", array( // nome do arquivo panel, vai no html no plural
		"material"=>$material->getFields()
	));

});

$app->get("/panel/materiais-types-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\material-type-create");

});

////// Unit-Type

$app->get("/panel/materiais-units-types/:idunitytype", function($idunitytype){

	$materialunit = new Hcode\Stand\Material\Unit\Type((int)$idunitytype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\material-unit-type-save", array( // nome do arquivo panel, vai no html no plural
		"materialunit"=>$materialunit->getFields()
	));

});

$app->get("/panel/materiais-units-types-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\material-unit-type-create");

});



// gateways
$app->get("/panel/gateways-save/:idgateway", function($idgateway){

	$gateway = new Hcode\Shop\Gateway((int)$idgateway);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\gateway-save", array( 
		"gateway"=>$gateway->getFields()
	));

});

$app->get("/panel/gateways-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\gateways-create");

});

// pedidos-status
$app->get("/panel/orders-status/:idstatus", function($idstatus){

	$status = new Hcode\Financial\Order\Status((int)$idstatus);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\orders-status-save", array(
		"status"=>$status->getFields()
	));

});

$app->get("/panel/orders-status-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\orders-status-create");

});

// orders negotiations types
$app->get("/panel/ordersnegotiations-types/:idnegociacao", function($idnegociacao){

	$order = new Hcode\Financial\Order\Negotiation\Type((int)$idnegociacao);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\ordernegotiation-type-save", array(
		"order"=>$order->getFields()
	));

});

$app->get("/panel/ordernegotiation-type-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\ordernegotiation-type-create");

});

// site contacts
$app->get("/panel/sites-contacts/:idsitecontact", function($idsitecontact){

	$site = new Hcode\Site\Contact((int)$idsitecontact);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\site-contato", array(
		"sitecontact"=>$site->getFields()
	));

});
///////////////////////////////////////////////////////////////

// formas de pagamento
$app->get("/panel/forms-payments/:idformpayment", function($idformpayment){

	$form = new Hcode\Financial\FormPayment((int)$idformpayment);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\form-payment", array(
		"formpayment"=>$form->getFields()
	));

});

$app->get("/panel/form-payment-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\form-payment-create");

});
///////////////////////////////////////////////////////////

// cartoes de credito
$app->get("/panel/cards/:idcard", function($idcard){

	$card = new Hcode\Financial\CreditCard((int)$idcard);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\cartao", array(
		"card"=>$card->getFields()
	));

});

$app->get("/panel/card-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\cartao-criar");

});

// permissoes
$app->get("/panel/permission-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\permission-create");

});

///////////////////////////////////////////////////////////

// cupons
$app->get("/panel/coupons/:idcoupon", function($idcoupon){

	$coupon = new Hcode\Shop\Coupon((int)$idcoupon);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\cupom", array(
		"coupon"=>$coupon->getFields()
	));

});

$app->get("/panel/coupon-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\cupom-criar");

});
////////////////////////////////
//cupons-tipos

$app->get("/panel/coupons-types/:idcoupontype", function($idcoupontype){

	$coupon = new Hcode\Shop\Coupon\Type((int)$idcoupontype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\coupons-types-save", array(
		"coupon"=>$coupon->getFields()
	));

});

$app->get("/panel/coupons-types-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\coupons-types-create");

});

// Permissao Salvar
$app->get("/panel/permissions/:idpermission", function($idpermission){

	$permission = new Hcode\Admin\Permission((int)$idpermission);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\permission-save", array(
		"permission"=>$permission->getFields()
	));

});

/////////////////////////////////////////
// product-type salvar
$app->get("/panel/products-types/:idproducttype", function($idproducttype){

	$product = new Hcode\Shop\Product\Type((int)$idproducttype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\product-type-save", array(
		"product"=>$product->getFields()
	));

});

$app->get("/panel/products-types-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\product-type-create");

});
/////////////////////////////////////////
// usuario-tipo salvar

$app->get("/panel/users-types/:idusertype", function($idusertype){

	$usertype = new Hcode\System\User\Type((int)$idusertype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\user-type-save", array(
		"usertype"=>$usertype->getFields()
	));


});

$app->get("/panel/user-type-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\user-type-create");

});

// pessoas-valores-campos
$app->get("/panel/persons-valuesfields/:idfield", function($idfield){

	$personvalue = new Hcode\Person\PersonValueField((int)$idfield);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\person-valuefield-save", array(
		"personvalue"=>$personvalue->getFields()
	));

});

$app->get("/panel/persons-valuesfields-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\person-valuefield-create");

});

// configuracoes-tipos
$app->get("/panel/configurations-types/:idconfigurationtype", function($idconfigurationtype){

	$configuration = new Hcode\System\Configuration\Type((int)$idconfigurationtype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\configuration-type-save", array(
		"configuration"=>$configuration->getFields()
	));

});

$app->get("/panel/configurations-types-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\configuration-type-create");

});

/////////////////////////////////////////
// lugares-tipos salvar
$app->get("/panel/places-types/:idplacetype", function($idplacetype){

	$placetype = new Hcode\Place\Type((int)$idplacetype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\places-types-save", array(
		"placetype"=>$placetype->getFields()
	));

});

$app->get("/panel/places-types-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\places-types-create");

});

////////////////////////////////////////////////////
// documentos-tipos
$app->get("/panel/documents/types/:iddocumenttype", function($iddocumenttype){

	$document = new Hcode\Document\Type((int)$iddocumenttype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\document-type-save", array(
		"document"=>$document->getFields()
	));

});

$app->get("/panel/document-type-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\document-type-create");

});

// enderecos-types
$app->get("/panel/addresses/types/:idaddresstype", function($idaddresstype){

	$address = new Hcode\Address\Type((int)$idaddresstype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\address-type-save", array(
		"address"=>$address->getFields()
	));

});

$app->get("/panel/address-type-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\address-type-create");

});

// userslogs-tipos
$app->get("/panel/userslogs-types/:idlogtype", function($idlogtype){

	$logs = new Hcode\System\User\Log\Type((int)$idlogtype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\userslog-type-save", array(
		"logs"=>$logs->getFields()
	));

});

$app->get("/panel/userslog-type-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\userslog-type-create");

});

// transaçoes-tipos
$app->get("/panel/transactions-types/:idtransactiontype", function($idtransactiontype){

	$transaction = new Hcode\Financial\Transaction\Type((int)$idtransactiontype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\transaction-type-save", array(
		"transaction"=>$transaction->getFields()
	));

});

$app->get("/panel/transaction-type-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\transaction-type-create");

});

// blogs tags
$app->get("/panel/blog-tags/:idtag", function($idtag){

	$tag = new Hcode\Site\Blog\Tag((int)$idtag);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\blog-tag-save", array(
		"tag"=>$tag->getFields()
	));

});

$app->get("/panel/blog-tag-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\blog-tag-create");

});


// blogs categoria
$app->get("/panel/blog-categories/:idcategory", function($idcategory){

	$category = new Hcode\Site\Blog\Category((int)$idcategory);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\blog-category-save", array(
		"category"=>$category->getFields()
	));

});

$app->get("/panel/blog-category-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\blog-category-create");

});

// historicos-tipos
$app->get("/panel/logs-types/:idlogtype", function($idlogtype){

	$logtype = new Hcode\Person\Log\Type((int)$idlogtype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\log-type-save", array(
		"logtype"=>$logtype->getFields()
	));

});

$app->get("/panel/log-type-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\log-type-create");

});
////////////////////////////////////////////////////////////////

// persons
$app->get("/panel/persons/:idperson", function($idperson){

	$person = new Hcode\Person\Person((int)$idperson);

	$page = new Hcode\Admin\Page(array(
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

	$page->setTpl("panel\pessoa", array(
		"person"=>$person->getFields()
	));

});

///////////////////////////////////////////////////////////
// carrinhos
$app->get("/panel/carts/:idcart", function($idcart){

	$cart = new Hcode\Shop\Cart((int)$idcart);

	$freight = new Hcode\Shop\Cart\Freight((int)$idcart);

	$cart->setProducts($cart->getProducts()->getFields());
	$cart->setCoupons($cart->getCoupons()->getFields());
	$cart->setFreight($freight->getFields());

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\cart", array(
		"cart"=>$cart->getFields()
	));

});

////////////////////////////////////////////////////////////
// lugares
$app->get("/panel/places/:idplace", function($idplace){

	$config = Hcode\Session::getConfigurations();

	$place = new Hcode\Place\Place((int)$idplace);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$data = $place->getFields();

	$schedules = $place->getSchedules()->getFields();

	if(!count($schedules) > 0) $schedules = Hcode\Locale\Language::getWeekdays();

	$data['Schedules'] = $schedules;

	$page->setTpl("panel\place", array(
		"place"=>$data,
		"mapKey"=>$config->getByName("GOOGLE_MAPS_KEY"),
		"addressestypes"=>Hcode\Address\Types::listAll()->getFields()
	));

});

$app->get("/panel/place-create", function(){

	$config = Hcode\Session::getConfigurations();

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\place-create", array(
		"mapKey"=>$config->getByName("GOOGLE_MAPS_KEY")
	));

});

$app->get("/panel/place-logs", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\place-logs", array(
		"ids"=>$_GET['ids'],
		"logs"=>Language::getWeekdays()
	));

});
/////////////////////////////////////////////////////////////

// cursos
$app->get("/panel/courses/:idcourse", function($idcourse){

	$course = new Hcode\Course\Course((int)$idcourse);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\course", array(
		"course"=>$course->getFields()
	));

});

$app->get("/panel/course-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\course-create");

});
//////////////////////////////////////////////////////////////////////

// carousels
$app->get("/panel/carousels/:idcarousel", function($idcarousel){

	$carousel = new Hcode\Site\Carousel((int)$idcarousel);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/carousel", array(
		"carousel"=>$carousel->getFields()
	));

});

$app->get("/panel/carousel-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/carousel-create");

});
//////////////////////////////////////////////////////////////////

// carousels items tipos
$app->get("/panel/carousels-items-types/:idtype", function($idtype){

	$type = new Hcode\Site\Carousel\Item\Type((int)$idtype);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\carousel-item-type-save", array(
		"type"=>$type->getFields()
	));

});

$app->get("/panel/carousel-item-type-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\carousel-item-type-create");

});
////////////////////////////////////////////////////////////////

// paises
$app->get("/panel/countries/:idcountry", function($idcountry){

	$country = new Hcode\Address\Country((int)$idcountry);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\country", array(
		"country"=>$country->getFields()
	));

});

$app->get("/panel/country-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\country-create");

});
/////////////////////////////////////////////////////

// estados
$app->get("/panel/states/:idstate", function($idstate){

	$state = new Hcode\Address\State((int)$idstate);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\state", array(
		"state"=>$state->getFields()
	));

});

$app->get("/panel/state-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\state-create");

});
///////////////////////////////////////////////////////

// cidades
$app->get("/panel/cities/:idcity", function($idcity){

	$city = new Hcode\Address\City((int)$idcity);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\city", array(
		"city"=>$city->getFields()
	));

});

$app->get("/panel/city-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\city-create");

});
////////////////////////////////////////////////////

// persons categorias tipos
$app->get("/panel/persons-categories-types/:idcategory", function($idcategory){

	$category = new Hcode\Person\PersonCategoryType((int)$idcategory);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\person-category-type-save", array(
		"category"=>$category->getFields()
	));

});

$app->get("/panel/person-category-type-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\person-category-type-create");

});
///////////////////////////////////////////////////////////

// urls
$app->get("/panel/urls/:idurl", function($idurl){

	$url = new Hcode\Site\Url((int)$idurl);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\url", array(
		"url"=>$url->getFields()
	));

});

$app->get("/panel/url-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel\url-criar");

});

// social networks
$app->get("/panel/social-networks/:idsocialnetwork", function($idsocialnetwork){

	$network = new Hcode\Social\Network((int)$idsocialnetwork);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/panel/social-network", array(
		"network"=>$network->getFields()
	));

});

$app->get("/panel/social-network-create", function(){

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("social-network-create");

});

?>