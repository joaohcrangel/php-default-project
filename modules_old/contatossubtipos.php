<?php 
  $app->get("/contatossubtipos",function(){
   $contato =  ContatosSubtipos::listAll();

   if ((int)get('idcontatotipo') > 0) {

   	$contato = $contato->filter('idcontatotipo', (int)get('idcontatotipo'));

   }

   echo success(array(
     "data"=> $contato->getFields()
   	));

  });

 ?>