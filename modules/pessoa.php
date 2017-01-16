<?php

$app->get('/pessoas/:idpessoa',function($idpessoa){
   
	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array(
		'data'=>$pessoa->getFields()
	));

});

$app->get('/pessoas/:idpessoa/contatos',function($idpessoa){
     
     $pessoa = new Pessoa(array(
		'idpessoa'=>(int)$idpessoa
	));

     $contato = $pessoa->getContatos();

	echo success(array(
         'data'=>$contato->getFields()
    ));  

})


 ?>