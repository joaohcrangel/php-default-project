<?php

$app->get("/gateways/all", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('desgateway')) {
        array_push($where, "desgateway LIKE '%".get('desgateway')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AND ', $where);
    } else {
        $where = '';
    }

    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_gateways
    ".$where." limit ?, ?;";

    $paginacao = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Shop\Gateways",
        $itemsPerPage
    );

    $gateways = $paginacao->getPage($currentPage);

    echo success(array(
        "data"=>$gateways->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),

    ));

});

$app->post("/gateways", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(post('idgateway') > 0){
        $gateway = new Hcode\Shop\Gateway((int)post('idgateway'));
    }else{
        $gateway = new Hcode\Shop\Gateway();
    }

    foreach ($_POST as $key => $value) {
        $gateway->{'set'.$key}($value);
    }

    $gateway->save();

    echo success(array("data"=>$gateway->getFields()));

});

$app->delete("/gateways/:idgateway", function($idgateway){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idgateway){
        throw new Exception("Gateway não informado", 400);        
    }

    $gateway = new Hcode\Shop\Gateway((int)$idgateway);

    if(!(int)$gateway->getidgateway() > 0){
        throw new Exception("Gateway não encontrado", 404);        
    }

    $gateway->remove();

    echo success();

});

?>