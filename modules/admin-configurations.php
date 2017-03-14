<?php 

$app->get("/".DIR_ADMIN."/system/configurations", function(){

    Permission::checkSession(Permission::ADMIN, true);

    $page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/system-configurations");

});

 ?>