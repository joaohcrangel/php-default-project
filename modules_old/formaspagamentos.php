<?php

$app->get("/formas-pagamentos/all", function(){

    Permission::checkSession(Permission::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if (get('desformapagamento')) {
        array_push($where, "desformapagamento LIKE '%".get('desformapagamento')."%'");
    }
    
    if (get('nrparcelasmax')) {
        array_push($where, "nrparcelasmax = '".get('nrparcelasmax')."'");
    }
    if (get('idgateway')) {
        array_push($where, "idgateway = ".get('idgateway'));
    }

    

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AND ', $where);
    } else {
        $where = '';
    }

    $query = '
        SELECT SQL_CALC_FOUND_ROWS * 
        FROM tb_formaspagamentos a 
        INNER JOIN tb_gateways b USING(idgateway)
        '.$where.' LIMIT ?, ?';

      $paginacao = new Pagination(
        $query,
        array(),
        "FormasPagamentos",
        $itemsPerPage
    );

    $formaspagamentos = $paginacao->getPage($currentPage); 

    echo success(array(
        "data"=>$formaspagamentos->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),
    ));
  
});

$app->post("/formas-pagamentos", function(){

    Permission::checkSession(Permission::ADMIN, true);

    if(post('idformapagamento') > 0){
        $pagamento = new FormaPagamento((int)post('idformapagamento'));
    }else{
        $pagamento = new FormaPagamento();
    }

    $pagamento->set($_POST);

    if (isset($_POST['instatus'])) {
        $pagamento->setinstatus(true);
    } else {    
        $pagamento->setinstatus(false);
    }    

    $pagamento->save();

    echo success(array("data"=>$pagamento->getFields()));

});

$app->delete("/formas-pagamentos/:idformapagamento", function($idformapagamento){

    Permission::checkSession(Permission::ADMIN, true);

    if(!(int)$idformapagamento){
        throw new Exception("Forma de Pagamento não informado", 400);
    }

    $pagamento = new FormaPagamento((int)$idformapagamento);

    if(!(int)$pagamento->getidformapagamento() > 0){
        throw new Exception("Forma de Pagamento não encontrado", 404); 
    }

    $pagamento->remove();

    echo success();

});

?>