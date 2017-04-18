<?php 

$app->get("/menus/:idmenu/users", function($idmenu){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$menu = new Hcode\Admin\Menu(array(
		'idmenu'=>(int)$idmenu
	));

	echo success(array('data'=>Users::listFromMenu($menu)->getFields()));

});

$app->get("/menus/:idmenu/permissions/missing", function($idmenu){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$menu = new Hcode\Admin\Menu(array(
		'idmenu'=>(int)$idmenu
	));

	$permissions = Permission::listFromMenu($menu, true);

	echo success(array('data'=>$permissions->getFields()));

});

$app->get("/menus/:idmenu/permissions", function($idmenu){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$menu = new Hcode\Admin\Menu(array(
		'idmenu'=>(int)$idmenu
	));

	echo success(array('data'=>Permission::listFromMenu($menu)->getFields()));

});

$app->post("/menus/:idmenu/permissions", function($idmenu){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$menu = new Hcode\Admin\Menu(array(
		'idmenu'=>(int)$idmenu
	));

	$permissions = new Hcode\Admin\Permissions();

	foreach (explode(",", post('idpermission')) as $id) {
		$permissions->add(new Permission(array(
			'idpermission'=>(int)$id
		)));
	}

	$permissions = $menu->addPermissoes($permissions);

	echo success(array(
		'data'=>$permissions->getFields()
	));


});

$app->delete("/menus/:idmenu/permissions", function($idmenu){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$menu = new Hcode\Admin\Menu(array(
		'idmenu'=>(int)$idmenu
	));

	$permissions = new Hcode\Admin\Permission();

	foreach (explode(",", post('idpermission')) as $id) {
		$permissoes->add(new Hcode\Admin\Permission(array(
			'idpermission'=>(int)$id
		)));
	}

	$menu->removePermission($permissions);

	echo success();

});

$app->get("/menus/:idmenu", function($idmenu){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$menu = new Hcode\Admin\Menu((int)$idmenu);

	echo success(array('data'=>$menu->getFields()));

});

$app->delete("/menus/:idmenu", function($idmenu){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$menu = new Hcode\Admin\Menu((int)$idmenu);

	$menu->remove();

	echo success();

});

$app->post("/menus/:idmenu", function($idmenu){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$menu = new Hcode\Admin\Menu((int)$idmenu);

	$menu->set($_POST);

	$menu->save();

	echo success(array('data'=>$menu->getFields()));

});

$app->post("/menus", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$menu = new Hcode\Admin\Menu($_POST);

	$menu->save();

	echo success(array('data'=>$menu->getFields()));

});

?>