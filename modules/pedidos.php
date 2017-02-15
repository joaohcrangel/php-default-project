<?php

// pedidos
$app->get("/pedidos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>Pedidos::listAll()->getFields()));

});

$app->get("/pedidos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $where = array();

    if(isset($_GET['despessoa'])){
        if($_GET['despessoa'] != '') array_push($where, "b.despessoa LIKE '%".utf8_decode(get('despessoa'))."%'");        
    }

    if(isset($_GET['idformapagamento'])){
        array_push($where, "c.idformapagamento = ".((int)get('idformapagamento')));
    }

    if(isset($_GET['idstatus'])){
        array_push($where, "d.idstatus = ".((int)get('idstatus')));
    }

    if(isset($_GET['dtinicio']) && isset($_GET['dttermino'])){
        if($_GET['dtinicio'] != '' && $_GET['dttermino'] != ''){
            array_push($where, "a.dtcadastro BETWEEN '".get('dtinicio')."' AND '".get('dttermino')."'");
        }
    }

    if(isset($_GET['idpedido'])){
        if($_GET['idpedido'] != '') array_push($where, "a.idpedido = ".(int)get('idpedido'));
    }

    if(count($where) > 0){
        $where = "WHERE ".implode(" AND ", $where);
    }else{
        $where = "";
    }

    $query = "
    SELECT SQL_CALC_FOUND_ROWS a.*, b.despessoa, c.desformapagamento, d.desstatus FROM tb_pedidos a
        LEFT JOIN tb_pessoas b ON a.idpessoa = b.idpessoa
        LEFT JOIN tb_formaspagamentos c ON a.idformapagamento = c.idformapagamento
        LEFT JOIN tb_pedidosstatus d ON a.idstatus = d.idstatus
    ".$where." ORDER BY b.despessoa LIMIT ?, ?;";

    $pagina = (int)get('pagina');
    $itemsPerPage = (int)get('limite');

    $paginacao = new Pagination(
        $query,
        array(),
        'Pedidos',
        $itemsPerPage
    );

    $pedidos = $paginacao->getPage($pagina);

    echo success(array(
        "data"=>$pedidos->getFields(),
        "total"=>$paginacao->getTotal(),
        "currentPage"=>$pagina,
        "itemsPerPage"=>$itemsPerPage
    ));

});

$app->post("/pedidos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idpedido') > 0){
        $pedido = new Pedido((int)post('idpedido'));
    }else{
        $pedido = new Pedido();
    }

    foreach ($_POST as $key => $value) {
        $pedido->{'set'.$key}($value);
    }

    $pedido->save();

    echo success(array("data"=>$pedido->getFields()));

});

$app->delete("/pedidos/:idpedido", function($idpedido){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idpedido){
        throw new Exception("Pedido não informado", 400);
    }

    $pedido = new Pedido((int)$idpedido);

    if(!(int)$pedido->getidpedido() > 0){
        throw new Exception("Pedido não encontrado", 404);        
    }

    $pedido->remove();

    echo success();

});
/////////////////////////////////////////////////////////////

// pedidos status
$app->get("/pedidos-status/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>PedidosStatus::listAll()->getFields()));

});

$app->post("/pedidos-status", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idstatus') > 0){
        $status = new PedidoStatus((int)post('idstatus'));
    }else{
        $status = new PedidoStatus();
    }

    foreach ($_POST as $key => $value) {
        $status->{'set'.$key}($value);
    }

    $status->save();

    echo success(array("data"=>$status->getFields()));

});

$app->delete("/pedidos-status/:idstatus", function($idstatus){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idstatus){
        throw new Exception("Status não informado", 400);        
    }

    $status = new PedidoStatus((int)$idstatus);

    if(!(int)$status->getidstatus() > 0){
        throw new Exception("Status não encontrado", 404);        
    }

    $status->remove();

    echo success();

});
///////////////////////////////////////////////////

// pedidos produtos
$app->get("/pedidos-produtos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>PedidosProdutos::listAll()->getFields()));

});

$app->post("/pedidos-produtos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idpedido') > 0 && post('idproduto') > 0){
        $pedido = new PedidoProduto((int)post('idpedido'), (int)post('idproduto'));
    }else{
        $pedido = new PedidoProduto();
    }

    foreach ($_POST as $key => $value) {
        $pedido->{'set'.$key}($value);
    }

    $pedido->save();

    echo success(array("data"=>$pedido->getFields()));

});

$app->delete("/pedidos/:idpedido/produtos/:idproduto", function($idpedido, $idproduto){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idpedido){
        throw new Exception("Pedido não informado", 400);        
    }

    if(!(int)$idproduto){
        throw new Exception("Produto não informado", 400);        
    }

    $pedido = new PedidoProduto((int)$idpedido, (int)$idproduto);

    if(!(int)$pedido->getidpedido() > 0 && !(int)$pedido->getidproduto() > 0){
        throw new Exception("Recurso não encontrado", 404);        
    }

    $pedido->remove();

    echo success();

});
//////////////////////////////////////////////////////////////////////

// pedidos recibos
$app->get("/pedidos-recibos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>PedidosRecibos::listAll()->getFields()));

});

$app->post("/pedidos-recibos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idpedido') > 0){
        $recibo = new PedidoRecibo((int)post('idpedido'));
    }else{
        $recibo = new PedidoRecibo();
    }

    foreach ($_POST as $key => $value) {
        $recibo->{'set'.$key}($value);
    }

    $recibo->save();

    echo success(array("data"=>$recibo->getFields()));

});

$app->delete("/pedidos-recibos/:idpedido", function($idpedido){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idpedido){
        throw new Exception("Pedido não informado", 400);        
    }

    $recibo = new PedidoRecibo((int)$idpedido);

    if(!(int)$recibo->getidpedido() > 0){
        throw new Exception("Pedido não encontrado", 404);        
    }

    $recibo->remove();

    echo success();

});

// recibos
$app->get("/pedidos/:idpedido/recibos", function($idpedido){

    Permissao::checkSession(Permissao::ADMIN, true);

    $pedido = new Pedido((int)$idpedido);

    echo success(array("data"=>$pedido->getRecibos()->getFields()));

});
//////////////////////////////////////////////////////////////

// pedidos historicos
$app->get("/pedidos/historicos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>PedidosHistoricos::listAll()->getFields()));

});

$app->post("/pedidos-historicos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if((int)post('idhistorico') > 0){
        $historico = new PedidoHistorico((int)post('idhistorico'));
    }else{
        $historico = new PedidoHistorico();
    }

    $historico->set();

    $historico->save();

    echo success(array("data"=>$historico->getFields()));

});

$app->delete("/pedidos-historicos/:idhistorico", function($idhistorico){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idhistorico){
        throw new Exception("Histórico não informado", 400);        
    }

    $historico = new PedidoHistorico((int)$idhistorico);

    if(!(int)$historico->getidhistorico() > 0){
        throw new Exception("Histórico não encontrado", 404);        
    }

    $historico->remove();

    echo success();

});

?>