<?php

$app->get("/contatos/tipos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('descontatotipo')) {
        array_push($where, "descontatotipo LIKE '%".get('descontatotipo')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AD ', $where);
    } else {
        $where = '';
    }

    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_contatostipos
    ".$where." limit ?, ?;";

    $paginacao = new Pagination(
        $query,
        array(),
        "ContatosTipos",
        $itemsPerPage
    );

    $contatostipos = $paginacao->getPage($currentPage);

    echo success(array(
        "data"=>$contatostipos->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),

    ));

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