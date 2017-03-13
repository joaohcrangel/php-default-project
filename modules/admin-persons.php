<?php 

$app->get("/".DIR_ADMIN."/persons-criar", function(){

   Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
    	'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/persons-criar');

});

$app->get("/".DIR_ADMIN."/persons/:idperson", function($idperson){

    Permissao::checkSession(Permissao::ADMIN, true);

    $person = new Person((int)$idperson);

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/persons-panel-new',  array(
        'person'=>$person->getFields(),
        'addressTypes'=>AddressTypes::listAll()->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/persons", function(){

   Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl('/admin/persons');

});

?>