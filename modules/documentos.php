<?php

$app->get("/documentos/cpf/:nrcpf", function($nrcpf){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>array(
        'incpf'=>Documento::validaCPF($nrcpf)
    )));

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


$app->get("/documentos/tipos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('desdocumentotipo')) {
        array_push($where, "desdocumentotipo LIKE '%".get('desdocumentotipo')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AD ', $where);
    } else {
        $where = '';
    }

    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_documentostipos
    ".$where." limit ?, ?;";

    $paginacao = new Pagination(
        $query,
        array(),
        "DocumentosTipos",
        $itemsPerPage
    );

    $documentostipos = $paginacao->getPage($currentPage); 

    echo success(array(
        "data"=>$documentostipos->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),
    ));

});

$app->post('/documentos-tipos', function () {

    Permissao::checkSession(Permissao::ADMIN);

    $documentotipo = new DocumentoTipo($_POST);

    $documentotipo->save();

    echo success(array(
        'data'=>$documentotipo->getFields()
    ));

});

$app->delete('/documentos-tipos/:iddocumentotipo', function ($iddocumentotipo) {

    Permissao::checkSession(Permissao::ADMIN);

    $documentotipo = new DocumentoTipo((int)$iddocumentotipo);

    $documentotipo->remove();

    echo success();

});




?>