<?php 

$app->get("/".DIR_ADMIN."/persons-create", function(){

   Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
    	'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/persons-create');

});

$app->get("/".DIR_ADMIN."/persons/:idperson", function($idperson){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $person = new Person((int)$idperson);

    $page = new Hcode\Admin\Page(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/persons-panel-new',  array(
        'person'=>$person->getFields(),
        'addressesTypes'=>AddressesTypes::listAll()->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/persons", function(){

   Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl('/admin/persons');

});

?>