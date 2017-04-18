<?php 

$app->get("/", function(){

    $page = new Hcode\Site\Page();

    $page->setTpl('index');

});

$app->get("/blog", function(){

	$page = new Hcode\Site\Page();

	$page->setTpl("blog");

});

?>