<?php

$app->get("/".DIR_ADMIN."/system/menu", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/system-menu", array(
        'menuHTML'=>Hcode\Menu::getAllMenuOL()
    ));

});

$app->delete("/".DIR_ADMIN."/system/menu", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $menu = new Menu((int)post('idmenu'));

    $menu->remove();

    echo success();

});

$app->get("/".DIR_ADMIN."/system/menus", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

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

    $menus = Menu::getAllMenus()->getFields();

    $menus = convertDataTreeview($menus);

    echo success(array(
        'data'=>$menus
    ));

});

$app->post("/".DIR_ADMIN."/system/menu", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    if (!post('desmenu')) {
        throw new Exception("Informe o texto do menu.", 400);
    }

    if ((int)post('idmenu') > 0) {
        $menu = new Menu((int)post('idmenu'));
    } else {
        $menu = new SiteMenu();
    }

    $menu->set($_POST);

    $menu->save();

    echo success(array(
        'data'=>$menu->getFields()
    ));

});
////////////////////////////////////////////////////////////
$app->get("/".DIR_ADMIN."/site/menu", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/sites-menus", array(
        'menuHTML'=>SiteMenu::getAllMenuOL()
    ));

});

$app->delete("/".DIR_ADMIN."/site/menu", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $menu = new SiteMenu((int)post('idmenu'));

    $menu->remove();

    echo success();

});

$app->get("/".DIR_ADMIN."/site/menus", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

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

    $menus = SiteMenu::getAllMenus()->getFields();

    $menus = convertDataTreeview($menus);

    echo success(array(
        'data'=>$menus
    ));

});

$app->post("/".DIR_ADMIN."/site/menu", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    if (!post('desmenu')) {
        throw new Exception("Informe o texto do menu.", 400);
    }

    if ((int)post('idmenu') > 0) {
        $menu = new SiteMenu((int)post('idmenu'));
    } else {
        $menu = new SiteMenu();
    }

    $menu->set($_POST);

    $menu->save();

    echo success(array(
        'data'=>$menu->getFields()
    ));

});

 ?>