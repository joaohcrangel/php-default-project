<?php 

$app->get("/sitesmenus/:idmenu", function($idmenu){

	Permissao::checkSession(Permissao::ADMIN);

	$menu = new SiteMenu((int)$idmenu);

	echo success(array('data'=>$menu->getFields()));

});

$app->delete("/sitesmenus/:idmenu", function($idmenu){

	Permissao::checkSession(Permissao::ADMIN);

	$menu = new SiteMenu((int)$idmenu);

	$menu->remove();

	echo success();

});

$app->post("/sitesmenus/:idmenu", function($idmenu){

	Permissao::checkSession(Permissao::ADMIN);

	$menu = new SiteMenu((int)$idmenu);

	$menu->set($_POST);

	$menu->save();

	echo success(array('data'=>$menu->getFields()));

});

$app->post("/sitesmenus", function(){

	Permissao::checkSession(Permissao::ADMIN);

	$menu = new SiteMenu($_POST);

	$menu->save();

	echo success(array('data'=>$menu->getFields()));

});

?>