<?php

	$app->get('/admin/pessoastipos',function(){

 $pessoatipo = PessoasTipos::listAll();

    echo success(array(
         'data'=>$pessoatipo->getFields()
        ));
});

 ?>