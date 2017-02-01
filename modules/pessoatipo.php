<?php

$app->get('/pessoastipos',function(){

 	$pessoatipo = PessoasTipos::listAll();

    echo success(array(
         'data'=>$pessoatipo->getFields()
    ));
});

 ?>