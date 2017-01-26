<?php

$app->get("/carrinhos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>Carrinhos::listAll()->getFields()));

});

$app->post("/carrinhos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idcarrinho') > 0){
        $carrinho = new Carrinho((int)post('idcarrinho'));
    }else{
        $carrinho = new Carrinho();
    }

    foreach ($_POST as $key => $value) {
        $carrinho->{'set'.$key}($value);
    }

    $carrinho->save();

    echo success(array("data"=>$carrinho->getFields()));

});

$app->delete("/carrinhos/:idcarrinho", function($idcarrinho){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcarrinho){
        throw new Exception("Carrinho não informado", 400);        
    }

    $carrinho = new Carrinho((int)$idcarrinho);

    if(!(int)$carrinho->getidcarrinho() > 0){
        throw new Exception("Carrinho não encontrado", 404);        
    }

    $carrinho->remove();

    echo success();

});

?>