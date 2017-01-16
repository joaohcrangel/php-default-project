<?php 
$app->get("/admin/teste", function(){

$teste =  new AdminPage();

$teste->setTpl("teste");

});




 ?>