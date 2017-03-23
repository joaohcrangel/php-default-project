<?php 

$app->get("/".DIR_ADMIN."/persons-create", function(){

   Permission::checkSession(Permission::ADMIN, true);

    $page = new AdminPage(array(
    	'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/persons-create');

});

$app->get("/".DIR_ADMIN."/persons/:idperson", function($idperson){

    Permission::checkSession(Permission::ADMIN, true);

    $person = new Person((int)$idperson);

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/persons-panel-new',  array(
        'person'=>$person->getFields(),
        'addressesTypes'=>AddressesTypes::listAll()->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/persons", function(){

   Permission::checkSession(Permission::ADMIN, true);

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