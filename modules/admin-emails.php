<?php 

$app->get("/".DIR_ADMIN."/emails", function(){

	Permission::checkSession(Permission::ADMIN, true);

    $page = new AdminPage(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/system-emails");

});

$app->get("/".DIR_ADMIN."/emails/new", function(){

	Permission::checkSession(Permission::ADMIN, true);

    $page = new AdminPage();

    $page->setTpl("/admin/system-emails-new");

});

 ?>