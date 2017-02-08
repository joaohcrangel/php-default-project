<?php

$app->get("/contatos/tipos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>ContatosTipos::listAll()->getFields()));

});

$app->post("/contatos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idcontato') > 0){
        $contato = new Contato((int)post('idcontato'));
    }else{
        $contato = new Contato();
    }

    foreach ($_POST as $key => $value) {
        $contato->{'set'.$key}($value);
    }

    $contato->save();

    echo success(array("data"=>$contato->getFields()));

});

$app->delete("/contatos/:idcontato", function($idcontato){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcontato){
        throw new Exception("Contato não informado", 400);        
    }

    $contato = new Contato((int)$idcontato);

    if(!(int)$contato->getidcontato() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $contato->remove();

    echo success();

});

// contatos- tipos
$app->post("/contatos-tipos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idcontatotipo') > 0){
        $contato = new ContatoTipo((int)post('idcontatotipo'));
    }else{
        $contato = new ContatoTipo();
    }

    foreach ($_POST as $key => $value) {
        $contato->{'set'.$key}($value);
    }

    $contato->save();

    echo success(array("data"=>$contato->getFields()));

});

$app->delete("/contatos-tipos/:idcontato", function($idcontatotipo){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcontatotipo){
        throw new Exception("Contato não informado", 400);        
    }

    $contato = new ContatoTipo((int)$idcontatotipo);

    if(!(int)$contato->getidcontatotipo() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $contato->remove();

    echo success();

});

?>