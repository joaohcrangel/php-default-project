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
///////////////////////////////////////////////////////

// carrinhos cupons
$app->get("/carrinhos-cupons/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>CarrinhosCupons::listAll()->getFields()));

});

$app->post("/carrinhos-cupons", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(isset($_POST['idcarrinho'], $_POST['idcupom'])){

        $cupom = new CarrinhoCupom();

        $cupom->queryToAttr("CALL sp_carrinhoscupons_save(?, ?);", array(
            post('idcarrinho'),
            post('idcupom')
        ));

        echo success();

    }else{
        throw new Exception("Carrinho ou cupom não informado", 400);        
    }

});

$app->delete("/carrinhos/:idcarrinho/cupons/:idcupom", function($idcarrinho, $idcupom){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcarrinho){
        throw new Exception("Carrinho não informado", 400);        
    }

    if(!(int)$idcupom){
        throw new Exception("Cupom não informado", 400);        
    }

    $cupom = new CarrinhoCupom();

    $cupom->queryToAttr("CALL sp_carrinhoscupons_remove(?, ?);", array(
        (int)$idcarrinho,
        (int)$idcupom
    ));

});
////////////////////////////////////////////////

// carrinhos fretes
$app->get("/carrinhos-fretes/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>CarrinhosFretes::listAll()->getFields()));

});

$app->post("/carrinhos-fretes", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idcarrinho') > 0){
        $frete = new CarrinhoFrete((int)post('idcarrinho'));
    }else{
        $frete = new CarrinhoFrete();
    }

    $frete->set();

    $frete->save();

    echo success(array("data"=>$frete->getFields()));

});

$app->delete("/carrinhos-fretes/:idcarrinho", function($idcarrinho){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcarrinho){
        throw new Exception("Carrinho não informado", 400);        
    }

    $frete = new CarrinhoFrete((int)$idcarrinho);

    if(!(int)$frete->getidcarrinho() > 0){
        throw new Exception("Carrinho não encontrado", 404);        
    }

    $frete->remove();

    echo success();

});

?>