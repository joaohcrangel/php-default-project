<?php 
 $app->get("/enderecostipos",function(){

   $endereco = EnderecosTipos::listAll();
    echo success(array(
     "data"=> $endereco->getFields()
   	));

 });

 ?>