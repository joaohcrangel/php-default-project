<?php 

$app->get("/".DIR_ADMIN."/users/:iduser", function($iduser){

    Permissao::checkSession(Permissao::ADMIN, true);

    $user = new User((int)$iduser);

    $user->getPerson();

    $page = new AdminPage(array(
    	"header"=>false,
        "footer"=>false,
        'data'=>array(
            'head_title'=>'Administração - Usuário'
        )
    ));

    $page->setTpl('/admin/system-user', array(
    	'user'=>$user->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/users", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	$page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

	$page->setTpl("/admin/users");

});

?>