<?php 

$app->get("/".DIR_ADMIN."/users/:iduser", function($iduser){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $user = new Hcode\System\User((int)$iduser);

    $user->getPerson();

    $page = new Hcode\Admin\Page(array(
    	"header"=>false,
        "footer"=>false,
        'data'=>array(
            'head_title'=>'Administração - Usuário'
        )
    ));

    $page->setTpl('system-user', array(
    	'user'=>$user->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/users", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
        "header"=>false,
        "footer"=>false
    ));

	$page->setTpl("panel\user");

});

?>