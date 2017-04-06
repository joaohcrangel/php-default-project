<?php 

$app->get("/".DIR_ADMIN."/emails", function(){

	Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/system-emails");

});

$app->get("/".DIR_ADMIN."/emails/new", function(){

	Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/system-emails-new");

});

 ?>