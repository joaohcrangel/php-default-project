<?php

$app->get("/documentos/tipos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>Documentos::listTipos()->getFields()));

});

$app->post("/documentos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('iddocumento') > 0){
        $documento = new Documento((int)post('iddocumento'));
    }else{
        $documento = new Documento();
    }

    foreach ($_POST as $key => $value) {
        $documento->{'set'.$key}($value);
    }

    $documento->save();

    echo success(array("data"=>$documento->getFields()));

});

$app->delete("/documentos/:iddocumento", function($iddocumento){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$iddocumento){
        throw new Exception("Documento não informado", 400);        
    }

    $documento = new Documento((int)$iddocumento);

    if(!(int)$documento->getiddocumento() > 0){
        throw new Exception("Documento não encontrado", 404);        
    }

    $documento->remove();

    echo success();

});

?>