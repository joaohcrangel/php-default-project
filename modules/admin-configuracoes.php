<?php 

$app->get("/".DIR_ADMIN."/sistema/Settings", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/sistema-Settings");

});

 ?>