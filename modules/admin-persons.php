<?php 

$app->get("/".DIR_ADMIN."/persons-create", function(){

   Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
    	'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/persons-create');

});

$app->get("/".DIR_ADMIN."/persons/:idperson", function($idperson){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $person = new Hcode\Person\Person((int)$idperson);

    $person->setCategories($person->getCategories());

    $page = new Hcode\Admin\Page(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/persons-panel-new',  array(
        'person'=>$person->getFields(),
        'addressesTypes'=>Hcode\Address\Types::listAll()->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/persons", function(){

   Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

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