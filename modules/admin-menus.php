<?php

$app->get("/".DIR_ADMIN."/system/menu", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/system-menu", array(
        'menuHTML'=>Hcode\Admin\Menu::getAllMenuOL()
    ));

});

$app->delete("/".DIR_ADMIN."/system/menu", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $menu = new Hcode\Admin\Menu((int)post('idmenu'));

    $menu->remove();

    echo success();

});

$app->get("/".DIR_ADMIN."/system/menus", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    function convertDataTreeview($Items){

        foreach ($Items as &$item) {
            
            $data = array(
                'text'=>$item['desmenu'],
                'data'=>$item
            );

            if (isset($item['Menus'])) {
                $data['nodes'] = convertDataTreeview($item['Menus']);
            }

            $item = $data;

        }

        return $Items;

    }

    $menus = Hcode\Admin\Menu::getAllMenus()->getFields();

    $menus = convertDataTreeview($menus);

    echo success(array(
        'data'=>$menus
    ));

});

$app->post("/".DIR_ADMIN."/system/menu", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if (!post('desmenu')) {
        throw new Exception("Informe o texto do menu.", 400);
    }

    if ((int)post('idmenu') > 0) {
        $menu = new Hcode\Admin\Menu((int)post('idmenu'));
    } else {
        $menu = new Hcode\Site\Menu();
    }

    $menu->set($_POST);

    $menu->save();

    echo success(array(
        'data'=>$menu->getFields()
    ));

});
////////////////////////////////////////////////////////////
$app->get("/".DIR_ADMIN."/site/menu", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/sites-menus", array(
        'menuHTML'=>Hcode\Site\Menu::getAllMenuOL()
    ));

});

$app->delete("/".DIR_ADMIN."/site/menu", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $menu = new Hcode\Site\Menu((int)post('idmenu'));

    $menu->remove();

    echo success();

});

$app->get("/".DIR_ADMIN."/site/menus", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    function convertDataTreeview($Items){

        foreach ($Items as &$item) {
            
            $data = array(
                'text'=>$item['desmenu'],
                'data'=>$item
            );

            if (isset($item['Menus'])) {
                $data['nodes'] = convertDataTreeview($item['Menus']);
            }

            $item = $data;

        }

        return $Items;

    }

    $menus = Hcode\Site\Menu::getAllMenus()->getFields();

    $menus = convertDataTreeview($menus);

    echo success(array(
        'data'=>$menus
    ));

});

$app->post("/".DIR_ADMIN."/site/menu", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if (!post('desmenu')) {
        throw new Exception("Informe o texto do menu.", 400);
    }

    if ((int)post('idmenu') > 0) {
        $menu = new Hcode\Site\Menu((int)post('idmenu'));
    } else {
        $menu = new Hcode\Site\Menu();
    }

    $menu->set($_POST);

    $menu->save();

    echo success(array(
        'data'=>$menu->getFields()
    ));

});

 ?>