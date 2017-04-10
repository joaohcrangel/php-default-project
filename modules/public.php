<?php 

$app->get("/", function(){

    $page = new Page();

    $page->setTpl('index');

});

$app->get("/blog", function(){

	$page = new Page();

	$page->setTpl("blog");

});

?>