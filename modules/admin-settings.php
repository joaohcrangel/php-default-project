<?php 

$app->get("/".DIR_ADMIN."/system/settings", function(){

    Permission::checkSession(Permission::ADMIN, true);

    $page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/system-settings");

});

 ?>