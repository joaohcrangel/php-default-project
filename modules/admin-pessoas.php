<?php 

$app->get("/".DIR_ADMIN."/pessoas-criar", function(){

   Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
    	'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/pessoas-criar');

});

$app->get("/".DIR_ADMIN."/pessoas/:idpessoa", function($idpessoa){

    Permissao::checkSession(Permissao::ADMIN, true);

    $pessoa = new Pessoa((int)$idpessoa);

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/pessoas-panel',  array(
        'pessoa'=>$pessoa->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/pessoas", function(){

   Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl('/admin/pessoas');

});

?>