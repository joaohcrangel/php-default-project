<?php 

$app->get("/", function(){

    $page = new Page();

    $page->setTpl('index');

});

?>