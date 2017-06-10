<?php 

 $app->get("/materiais",function(){

   $material = Hcode\Material::listAll();
    echo success(array(
     "data"=> $material->getFields()
   ));


   
 });

 ?>