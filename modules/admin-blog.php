<?php

$app->get("/".DIR_ADMIN."/blog/posts", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

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

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "data"=>array(
            "body"=>array(
                "class"=>"page-aside-fixed page-aside-right"
            )
        )
    ));

    $page->setTpl("/admin/blog-posts-new", array(
        "post"=>array()
    ));

});

$app->get("/blog-posts/:idpost", function($idpost){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $post = new Hcode\Site\Blog\Post((int)$idpost);

    $page = new Hcode\Admin\Page(array(
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

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

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

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

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

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

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