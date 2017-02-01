<?php

// pagamentos
$app->get("/pagamentos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>Pagamentos::listAll()->getFields()));

});

$app->post("/pagamentos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idpagamento') > 0){
        $pagamento = new Pagamento((int)post('idpagamento'));
    }else{
        $pagamento = new Pagamento();
    }

    foreach ($_POST as $key => $value) {
        $pagamento->{'set'.$key}($value);
    }

    $pagamento->save();

    echo success(array("data"=>$pagamento->getFields()));

});

$app->delete("/pagamentos/:idpagamento", function($idpagamento){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idpagamento){
        throw new Exception("Pagamento não informado", 400);
    }

    $pagamento = new Pagamento((int)$idpagamento);

    if(!(int)$pagamento->getidpagamento() > 0){
        throw new Exception("Pagamento não encontrado", 404);        
    }

    $pagamento->remove();

    echo success();

});
/////////////////////////////////////////////////////////////

// pagamentos status
$app->get("/pagamentos-status/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>PagamentosStatus::listAll()->getFields()));

});

$app->post("/pagamentos-status", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idstatus') > 0){
        $status = new PagamentoStatus((int)post('idstatus'));
    }else{
        $status = new PagamentoStatus();
    }

    foreach ($_POST as $key => $value) {
        $status->{'set'.$key}($value);
    }

    $status->save();

    echo success(array("data"=>$status->getFields()));

});

$app->delete("/pagamentos-status/:idstatus", function($idstatus){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idstatus){
        throw new Exception("Status não informado", 400);        
    }

    $status = new PagamentoStatus((int)$idstatus);

    if(!(int)$status->getidstatus() > 0){
        throw new Exception("Status não encontrado", 404);        
    }

    $status->remove();

    echo success();

});
///////////////////////////////////////////////////

// pagamentos produtos
$app->get("/pagamentos-produtos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>PagamentosProdutos::listAll()->getFields()));

});

$app->post("/pagamentos-produtos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idpagamento') > 0 && post('idproduto') > 0){
        $pagamento = new PagamentoProduto((int)post('idpagamento'), (int)post('idproduto'));
    }else{
        $pagamento = new PagamentoProduto();
    }

    foreach ($_POST as $key => $value) {
        $pagamento->{'set'.$key}($value);
    }

    $pagamento->save();

    echo success(array("data"=>$pagamento->getFields()));

});

$app->delete("/pagamentos/:idpagamento/produtos/:idproduto", function($idpagamento, $idproduto){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idpagamento){
        throw new Exception("Pagamento não informado", 400);        
    }

    if(!(int)$idproduto){
        throw new Exception("Produto não informado", 400);        
    }

    $pagamento = new PagamentoProduto((int)$idpagamento, (int)$idproduto);

    if(!(int)$pagamento->getidpagamento() > 0 && !(int)$pagamento->getidproduto() > 0){
        throw new Exception("Recurso não encontrado", 404);        
    }

    $pagamento->remove();

    echo success();

});
//////////////////////////////////////////////////////////////////////

// pagamentos recibos
$app->get("/pagamentos-recibos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>PagamentosRecibos::listAll()->getFields()));

});

$app->post("/pagamentos-recibos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idpagamento') > 0){
        $recibo = new PagamentoRecibo((int)post('idpagamento'));
    }else{
        $recibo = new PagamentoRecibo();
    }

    foreach ($_POST as $key => $value) {
        $recibo->{'set'.$key}($value);
    }

    $recibo->save();

    echo success(array("data"=>$recibo->getFields()));

});

$app->delete("/pagamentos-recibos/:idpagamento", function($idpagamento){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idpagamento){
        throw new Exception("Pagamento não informado", 400);        
    }

    $recibo = new PagamentoRecibo((int)$idpagamento);

    if(!(int)$recibo->getidpagamento() > 0){
        throw new Exception("Pagamento não encontrado", 404);        
    }

    $recibo->remove();

    echo success();

});

// recibos
$app->get("/pagamentos/:idpagamento/recibos", function($idpagamento){

    Permissao::checkSession(Permissao::ADMIN, true);

    $pagamento = new Pagamento((int)$idpagamento);

    echo success(array("data"=>$pagamento->getRecibos()->getFields()));

});
//////////////////////////////////////////////////////////////

// pagamentos historicos
$app->get("/pagamentos/historicos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>PagamentosHistoricos::listAll()->getFields()));

});

$app->post("/pagamentos-historicos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if((int)post('idhistorico') > 0){
        $historico = new PagamentoHistorico((int)post('idhistorico'));
    }else{
        $historico = new PagamentoHistorico();
    }

    $historico->set();

    $historico->save();

    echo success(array("data"=>$historico->getFields()));

});

$app->delete("/pagamentos-historicos/:idhistorico", function($idhistorico){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idhistorico){
        throw new Exception("Histórico não informado", 400);        
    }

    $historico = new PagamentoHistorico((int)$idhistorico);

    if(!(int)$historico->getidhistorico() > 0){
        throw new Exception("Histórico não encontrado", 404);        
    }

    $historico->remove();

    echo success();

});

?>