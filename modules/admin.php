<?php 

$app->get("/admin", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        'data'=>array(
            'head_title'=>'Administração'
        )
    ));

    $page->setTpl('/admin/index');

});

$app->get("/admin/login", function(){

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false,
        'data'=>array(
            'head_title'=>'Login'
        )
    ));

    $page->setTpl('login');

});

$app->get("/admin/menu-refresh", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    Menu::resetMenuSession();

    header('Location: '.SITE_PATH.'/');
    exit;

});

$app->get("/admin/lock", function(){

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/lock');

});

$app->get("/admin/settings", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage();

    $page->setTpl('/admin/index');

});

$app->get("/admin/perfil", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage();

    $usuario = Session::getUsuario();

    $page->setTpl('/admin/perfil', array(
        'usuario'=>$usuario->getFields(),
        'pessoa'=>$usuario->getPessoa()->getFields()
    ));

});

$app->get("/admin/session", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    pre($_SESSION);

});

$app->get("/admin/usuarios", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	$page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

	$page->setTpl("/admin/usuarios");

});

$app->get("/admin/usuarios/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

	$usuarios = Usuarios::listAll();

	echo success(array("data"=>$usuarios->getFields()));

});

$app->post("/admin/usuarios", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $usuario = new Usuario($_POST);
    $usuario->save();

    echo success(array("data"=>$usuario->getFields()));

});

$app->delete("/admin/usuarios", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $ids = explode(",", post("ids"));

    foreach($ids as $idusuario){
        if(!(int)$idusuario > 0){
            throw new Exception("ID de usuário não informado.", 400);
        }

        $usuario = new Usuario((int)$idusuario);

        if(!(int)$usuario->getidusuario() > 0){
            throw new Exception("Usuário não encontrado.", 404);            
        }

        // $usuario->remove();
    }

    echo success();

});

?>