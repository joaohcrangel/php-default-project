<?php

$app->get("/formas-pagamentos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $where = array();

    if (get('desformapagamento')) {
        array_push($where, "desformapagamento LIKE '%".get('desformapagamento')."%'");
    }
    

    if (get('nrparcelasmax')) {
        array_push($where, "nrparcelasmax = '".get('nrparcelasmax')."'");
    }
    
    if (count($where) > 0) {
        $where = 'WHERE '.implode(' AND ', $where);
    } else {
        $where = '';
    }

    $query = 'SELECT * FROM tb_formaspagamentos'.$where;

    $pagamentos = new FormasPagamentos();

    $pagamentos->loadFromQuery($query);

    echo success(array("data"=>$pagamentos->getFields()));
  

});

$app->post("/formas-pagamentos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

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

    Permissao::checkSession(Permissao::ADMIN, true);

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