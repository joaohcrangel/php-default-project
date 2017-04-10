<?php

$app->get("/".DIR_ADMIN."/blog/posts", function(){

    Permission::checkSession(Permission::ADMIN, true);

    $page = new AdminPage(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-left"
            )
        )
    ));

    $page->setTpl("/admin/blog-posts");

});

$app->get("/".DIR_ADMIN."/blog/posts/new", function(){

    Permission::checkSession(Permission::ADMIN, true);

    $page = new AdminPage(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-right"
            )
        )
    ));

    $page->setTpl("/admin/blog-posts-new");

});

$app->get("/blog-posts/:idpost", function($idpost){

    Permission::checkSession(Permission::ADMIN, true);

    $post = new BlogPost((int)$idpost);

    $page = new AdminPage(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-right"
            )
        )
    ));

    $post->setTags($post->getTags());
    $post->setCategories($post->getCategories());

    $post->setdescontent(addslashes($post->getdescontent()));

    $page->setTpl("/admin/blog-posts-new", array(
        "post"=>$post->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/blog/categories", function(){

    Permission::checkSession(Permission::ADMIN, true);

    $page = new AdminPage(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-left"
            )
        )
    ));

    $page->setTpl("/admin/blog-posts-categories");

});

$app->get("/".DIR_ADMIN."/blog/tags", function(){

    Permission::checkSession(Permission::ADMIN, true);

    $page = new AdminPage(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-left"
            )
        )
    ));

    $page->setTpl("/admin/blog-posts-tags");

});

$app->get("/".DIR_ADMIN."/blog/comments", function(){

    Permission::checkSession(Permission::ADMIN, true);

    $page = new AdminPage(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-left"
            )
        )
    ));

    $page->setTpl("/admin/blog-posts-comments");

});

?>