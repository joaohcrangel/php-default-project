<?php 

$app->get("/menus/:idmenu/usuarios", function($idmenu){

	Permissao::checkSession(UsuarioTipo::CLIENTE);

	$menu = new Menu(array(
		'idmenu'=>(int)$idmenu
	));

	echo success(array('data'=>Usuarios::listFromMenu($menu)->getFields()));

});

$app->get("/menus/:idmenu/permissoes/faltantes", function($idmenu){

	Permissao::checkSession(UsuarioTipo::CLIENTE);

	$menu = new Menu(array(
		'idmenu'=>(int)$idmenu
	));

	$permissoes = Permissoes::listFromMenu($menu, true);

	echo success(array('data'=>$permissoes->getFields()));

});

$app->get("/menus/:idmenu/permissoes", function($idmenu){

	Permissao::checkSession(UsuarioTipo::CLIENTE);

	$menu = new Menu(array(
		'idmenu'=>(int)$idmenu
	));

	echo success(array('data'=>Permissoes::listFromMenu($menu)->getFields()));

});

$app->post("/menus/:idmenu/permissoes", function($idmenu){

	Permissao::checkSession(UsuarioTipo::CLIENTE);

	$menu = new Menu(array(
		'idmenu'=>(int)$idmenu
	));

	$permissoes = new Permissoes();

	foreach (explode(",", post('idpermissao')) as $id) {
		$permissoes->add(new Permissao(array(
			'idpermissao'=>(int)$id
		)));
	}

	$permissoes = $menu->addPermissoes($permissoes);

	echo success(array(
		'data'=>$permissoes->getFields()
	));


});

$app->delete("/menus/:idmenu/permissoes", function($idmenu){

	Permissao::checkSession(UsuarioTipo::CLIENTE);

	$menu = new Menu(array(
		'idmenu'=>(int)$idmenu
	));

	$permissoes = new Permissoes();

	foreach (explode(",", post('idpermissao')) as $id) {
		$permissoes->add(new Permissao(array(
			'idpermissao'=>(int)$id
		)));
	}

	$menu->removePermissoes($permissoes);

	echo success();

});

$app->get("/menus/:idmenu", function($idmenu){

	Permissao::checkSession(UsuarioTipo::CLIENTE);

	$menu = new Menu((int)$idmenu);

	echo success(array('data'=>$menu->getFields()));

});

$app->delete("/menus/:idmenu", function($idmenu){

	Permissao::checkSession(UsuarioTipo::CLIENTE);

	$menu = new Menu((int)$idmenu);

	$menu->remove();

	echo success();

});

$app->post("/menus/:idmenu", function($idmenu){

	Permissao::checkSession(UsuarioTipo::CLIENTE);

	$menu = new Menu((int)$idmenu);

	$menu->set($_POST);

	$menu->save();

	echo success(array('data'=>$menu->getFields()));

});

$app->post("/menus", function(){

	Permissao::checkSession(UsuarioTipo::CLIENTE);

	$menu = new Menu($_POST);

	$menu->save();

	echo success(array('data'=>$menu->getFields()));

});

?>