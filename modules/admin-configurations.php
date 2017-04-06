<?php 

$app->get("/".DIR_ADMIN."/system/configurations", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/system-configurations");

});

 ?>