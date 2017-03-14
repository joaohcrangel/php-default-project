<?php 

$app->get("/".DIR_ADMIN."/usuarios/:idusuario", function($idusuario){

    Permissao::checkSession(Permissao::ADMIN, true);

    $usuario = new Usuario((int)$idusuario);

    $usuario->getPessoa();

    $page = new AdminPage(array(
    	"header"=>false,
        "footer"=>false,
        'data'=>array(
            'head_title'=>'Administração - Usuário'
        )
    ));

    $page->setTpl('/admin/sistema-usuario', array(
    	'usuario'=>$usuario->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/usuarios", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	$page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

	$page->setTpl("/admin/usuarios");

});

?>