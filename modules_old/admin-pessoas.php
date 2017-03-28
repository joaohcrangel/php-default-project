<?php 

$app->get("/".DIR_ADMIN."/pessoas-criar", function(){

   Permission::checkSession(Permission::ADMIN, true);

    $page = new AdminPage(array(
    	'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/pessoas-criar');

});

$app->get("/".DIR_ADMIN."/pessoas/:idpessoa", function($idpessoa){

    Permission::checkSession(Permission::ADMIN, true);

    $pessoa = new Pessoa((int)$idpessoa);

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/pessoas-panel-new',  array(
        'pessoa'=>$pessoa->getFields(),
        'enderecosTipos'=>EnderecosTipos::listAll()->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/pessoas", function(){

   Permission::checkSession(Permission::ADMIN, true);

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