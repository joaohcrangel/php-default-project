<?php

$app->get("/formas-pagamentos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>FormasPagamentos::listAll()->getFields()));

});

$app->post("/formas-pagamentos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idformapagamento') > 0){
        $pagamento = new FormaPagamento((int)post('idformapagamento'));
    }else{
        $pagamento = new FormaPagamento();
    }

    foreach ($_POST as $key => $value) {
        $pagamento->{'set'.$key}($value);
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

    $pagameto->remove();

    echo success();

});

?>