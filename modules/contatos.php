<?php
/*
$app->get('/admin/contatos',function(){

    $contato = Contatos::listAll();

    echo success(array(
         'data'=>$contato->getFields()
        ));

});
*/


$app->delete('/contatos/:idcontato', function($idcontato){

	//$contato = new Contato((int)$idcontato);

	$contato = new Contato(array(
		"idcontato"=>(int)$idcontato
	));

	$contato->remove();

	echo success();

});


$app->post('/contatos',function(){

	$contato = new Contato();

	$contato->setdescontato(post("descontato"));
    $contato->setidcontatotipo(post("idcontatotipo"));
	$contato->setidpessoa(post("idpessoa"));
	$contato->setinprincipal(post("inprincipal"));

	$contato->save();

	echo success(array(
		'data'=>$contato->getFields()
	));

});
?>