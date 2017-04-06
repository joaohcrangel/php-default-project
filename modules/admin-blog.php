<?php

$app->get("/".DIR_ADMIN."/blog/posts", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-left"
            )
        )
    ));

    $page->setTpl("/admin/blog-posts");

});

$app->get("/".DIR_ADMIN."/blog/posts/new", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-right"
            )
        )
    ));

    $page->setTpl("/admin/blog-posts-new");

});

$app->get("/".DIR_ADMIN."/blog/categories", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-left"
            )
        )
    ));

    $page->setTpl("/admin/blog-posts-categories");

});

$app->get("/".DIR_ADMIN."/blog/tags", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-left"
            )
        )
    ));

    $page->setTpl("/admin/blog-posts-tags");

});

$app->get("/".DIR_ADMIN."/blog/comments", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-left"
            )
        )
    ));

    $page->setTpl("/admin/blog-posts-comments");

});

?>