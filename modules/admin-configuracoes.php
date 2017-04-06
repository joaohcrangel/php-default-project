
<?php 

$app->get("/".DIR_ADMIN."/sistema/Settings", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/sistema-Settings");

});

 ?>
