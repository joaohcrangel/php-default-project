<?php

$app->get("/documents/cpf/:nrcpf", function($nrcpf){

    Permission::checkSession(Permission::ADMIN, true);

    echo success(array("data"=>array(
        'incpf'=>Document::CPFValidate($nrcpf)
    )));

});

$app->post("/documents", function(){

    Permission::checkSession(Permission::ADMIN, true);

    if(post('iddocument') > 0){
        $document = new Document((int)post('iddocument'));
    }else{
        $document = new Document();
    }

    foreach ($_POST as $key => $value) {
        $document->{'set'.$key}($value);
    }

    $document->save();

    echo success(array("data"=>$document->getFields()));

});

$app->delete("/documents/:iddocument", function($iddocument){

    Permission::checkSession(Permission::ADMIN, true);

    if(!(int)$iddocument){
        throw new Exception("Documento não informado", 400);        
    }

    $document = new Document((int)$iddocument);

    if(!(int)$document->getiddocument() > 0){
        throw new Exception("Documento não encontrado", 404);        
    }

    $document->remove();

    echo success();

});


$app->get("/documents/types", function(){

    Permission::checkSession(Permission::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('desdocumenttype')) {
        array_push($where, "desdocumenttype LIKE '%".get('desdocumenttype')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AD ', $where);
    } else {
        $where = '';
    }

    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_documentstypes
    ".$where." limit ?, ?;";

    $pagination = new Pagination(
        $query,
        array(),
        "DocumentsTypes",
        $itemsPerPage
    );

    $documentstypes = $pagination->getPage($currentPage); 

    echo success(array(
        "data"=>$documentstypes->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),
    ));

});

$app->post('/documents-types', function () {

    Permission::checkSession(Permission::ADMIN);

    $documenttype = new DocumentType($_POST);

    $documenttype->save();

    echo success(array(
        'data'=>$documenttype->getFields()
    ));

});

$app->delete('/documents-types/:iddocumenttype', function ($iddocumenttype) {

    Permission::checkSession(Permission::ADMIN);

    $documenttype = new DocumentType((int)$iddocumenttype);

    $documenttype->remove();

    echo success();

});




?>