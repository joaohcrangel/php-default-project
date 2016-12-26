<?php 

$app->get("/menus/:idmenu", function($idmenu){

	Permissao::checkSession(Permissao::CLIENT);

	$menu = new Menu((int)$idmenu);

	echo success(array('data'=>$menu->getFields()));

});

$app->delete("/menus/:idmenu", function($idmenu){

	Permissao::checkSession(Permissao::CLIENT);

	$menu = new Menu((int)$idmenu);

	$menu->remove();

	echo success();

});

$app->post("/menus/:idmenu", function($idmenu){

	Permissao::checkSession(Permissao::CLIENT);

	$menu = new Menu((int)$idmenu);

	$menu->set($_POST);

	$menu->save();

	echo success(array('data'=>$menu->getFields()));

});

$app->post("/menus", function(){

	Permissao::checkSession(Permissao::CLIENT);

	$menu = new Menu($_POST);

	$menu->save();

	echo success(array('data'=>$menu->getFields()));

});

?>