<?php 

$app->get("/".DIR_ADMIN."/sistema/menu", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/sistema-menu", array(
        'menuHTML'=>Menu::getAllMenuOL()
    ));

});

$app->delete("/".DIR_ADMIN."/sistema/menu", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $menu = new Menu((int)post('idmenu'));

    $menu->remove();

    echo success();

});

$app->get("/".DIR_ADMIN."/sistema/menus", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    function convertDataTreeview($itens){

        foreach ($itens as &$item) {
            
            $data = array(
                'text'=>$item['desmenu'],
                'data'=>$item
            );

            if (isset($item['Menus'])) {
                $data['nodes'] = convertDataTreeview($item['Menus']);
            }

            $item = $data;

        }

        return $itens;

    }

    $menus = Menu::getAllMenus()->getFields();

    $menus = convertDataTreeview($menus);

    echo success(array(
        'data'=>$menus
    ));

});

$app->post("/".DIR_ADMIN."/sistema/menu", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

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

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/site-menu", array(
        'menuHTML'=>SiteMenu::getAllMenuOL()
    ));

});

$app->delete("/".DIR_ADMIN."/site/menu", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $menu = new SiteMenu((int)post('idmenu'));

    $menu->remove();

    echo success();

});

$app->get("/".DIR_ADMIN."/site/menus", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    function convertDataTreeview($itens){

        foreach ($itens as &$item) {
            
            $data = array(
                'text'=>$item['desmenu'],
                'data'=>$item
            );

            if (isset($item['Menus'])) {
                $data['nodes'] = convertDataTreeview($item['Menus']);
            }

            $item = $data;

        }

        return $itens;

    }

    $menus = SiteMenu::getAllMenus()->getFields();

    $menus = convertDataTreeview($menus);

    echo success(array(
        'data'=>$menus
    ));

});

$app->post("/".DIR_ADMIN."/site/menu", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

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