<?php

$app->get("/cartoes/all", function(){

     Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>CartoesCreditos::listAll()->getFields()));

});

$app->post("/cartoes", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idcartao') > 0){
        $cartao = new CartaoCredito((int)post('idcartao'));
    }else{
        $cartao = new CartaoCredito();
    }

    foreach ($_POST as $key => $value) {
        $cartao->{'set'.$key}($value);
    }

    $cartao->save();

    echo success(array("data"=>$cartao->getFields()));

});

$app->delete("/cartoes/:idcartao", function($idcartao){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcartao){
        throw new Exception("Cartão não informado", 400);        
    }

    $cartao = new CartaoCredito((int)$idcartao);

    if(!(int)$cartao->getidcartao() > 0){
        throw new Exception("Cartão não encontrado", 404);        
    }

    $cartao->remove();

    echo success();

});

?>