<?php

$app->get("/gateways/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>Gateways::listAll()->getFields()));

});

$app->post("/gateways", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idgateway') > 0){
        $gateway = new Gateway((int)post('idgateway'));
    }else{
        $gateway = new Gateway();
    }

    foreach ($_POST as $key => $value) {
        $gateway->{'set'.$key}($value);
    }

    $gateway->save();

    echo success(array("data"=>$gateway->getFields()));

});

$app->delete("/gateways/:idgateway", function($idgateway){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idgateway){
        throw new Exception("Gateway não informado", 400);        
    }

    $gateway = new Gateway((int)$idgateway);

    if(!(int)$gateway->getidgateway() > 0){
        throw new Exception("Gateway não encontrado", 404);        
    }

    $gateway->remove();

    echo success();

});

?>