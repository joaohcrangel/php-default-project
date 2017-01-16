<?php

$app->get('/admin/contatos',function(){

    $contato = Contatos::listAll();

    echo success(array(
         'data'=>$contato->getFields()
        ));

});

?>