<?php 

$app->get("/".DIR_ADMIN."/emails/:idemail/dashboard", function($idemail){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $email = new Hcode\Email\Email((int)$idemail);

    $page = new Hcode\Admin\Page(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl("email-dashboard", array(

    ));

});

$app->get("/".DIR_ADMIN."/emails", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("system-emails");

});

$app->get("/".DIR_ADMIN."/emails/new", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("system-emails-new");

});

 ?>