<?php

$app->get("/site-contatos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>SiteContatos::listAll()->getFields()));

});

$app->post("/site-contatos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idsitecontato') > 0){
        $site = new SiteContato((int)post('idsitecontato'));
    }else{
        $site = new SiteContato();
    }

    foreach ($_POST as $key => $value) {
        $site->{'set'.$key}($value);
    }

    $site->save();

    echo success(array("data"=>$site->getFields()));

});

$app->delete("/site-contatos/:idsitecontato", function($idsitecontato){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idsitecontato){
        throw new Exception("Contato não informado", 400);        
    }

    $site = new SiteContato((int)$idsitecontato);

    if(!(int)$site->getidsitecontato() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $site->remove();

    echo success();

});

?>