
<?php 

$app->get("/".DIR_ADMIN."/sistema/Settings", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/sistema-Settings");

});

 ?>
