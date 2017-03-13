<?php 

$app->get("/".DIR_ADMIN."/system/settings", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/system-settings");

});

 ?>