<?php 

$app->get("/".DIR_ADMIN."/users/:iduser", function($iduser){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $user = new Hcode\User((int)$iduser);

    $user->getPerson();

    $page = new Hcode\Admin\Page(array(
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

	Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
        "header"=>true,
        "footer"=>true
    ));

	$page->setTpl("/admin/users");

});

?>