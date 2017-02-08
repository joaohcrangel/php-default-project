<?php

$app->get("/carrinhos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $where = array();

    if(isset($_GET['despessoa']) && $_GET['despessoa'] != ""){
        array_push($where, "b.despessoa LIKE '%".utf8_decode(get('despessoa'))."%'");
    }

    if(isset($_GET['dtinicio']) && isset($_GET['dttermino'])){
        if($_GET['dtinicio'] != '' && $_GET['dttermino'] != ''){
            array_push($where, "a.dtcadastro BETWEEN '".get('dtinicio')."' AND '".get('dttermino')."'");
        }
    }

    if(isset($_GET['idcarrinho'])){
        if($_GET['idcarrinho'] != '') array_push($where, "a.idcarrinho = ".(int)get('idcarrinho'));
    }

    if(count($where) > 0){
        $where = "WHERE ".implode(" AND ", $where);
    }else{
        $where = "";
    }

    $query = "
        SELECT SQL_CALC_FOUND_ROWS a.*, b.despessoa FROM tb_carrinhos a
            INNER JOIN tb_pessoas b USING(idpessoa) ".$where."
        ORDER BY b.despessoa LIMIT ?, ?;
    ";

    $pagina = (int)get('pagina');
    $itemsPerPage = (int)get('limite');

    $paginacao = new Pagination(
        $query,
        array(),
        "Carrinhos",
        $itemsPerPage
    );

    $carrinhos = $paginacao->getPage($pagina);

    echo success(array(
        "data"=>$carrinhos->getFields(),
        "total"=>$paginacao->getTotal(),
        "currentPage"=>$pagina,
        "itemsPerPage"=>$itemsPerPage
    ));

});

$app->get("/carrinhos/:idcarrinho/produtos", function($idcarrinho){

    Permissao::checkSession(Permissao::ADMIN, true);

    $carrinho = new Carrinho((int)$idcarrinho);

    echo success(array("data"=>$carrinho->getProdutos()->getFields()));

});

$app->post("/carrinhos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idcarrinho') > 0){
        $carrinho = new Carrinho((int)post('idcarrinho'));
    }else{
        $carrinho = new Carrinho();
    }

    foreach ($_POST as $key => $value) {
        $carrinho->{'set'.$key}($value);
    }

    $carrinho->save();

    echo success(array("data"=>$carrinho->getFields()));

});

$app->delete("/carrinhos/:idcarrinho", function($idcarrinho){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcarrinho){
        throw new Exception("Carrinho não informado", 400);        
    }

    $carrinho = new Carrinho((int)$idcarrinho);

    if(!(int)$carrinho->getidcarrinho() > 0){
        throw new Exception("Carrinho não encontrado", 404);        
    }

    $carrinho->remove();

    echo success();

});
///////////////////////////////////////////////////////

// carrinhos cupons
$app->get("/carrinhos-cupons/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>CarrinhosCupons::listAll()->getFields()));

});

$app->post("/carrinhos-cupons", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(isset($_POST['idcarrinho'], $_POST['idcupom'])){

        $cupom = new CarrinhoCupom();

        $cupom->queryToAttr("CALL sp_carrinhoscupons_save(?, ?);", array(
            post('idcarrinho'),
            post('idcupom')
        ));

        echo success();

    }else{
        throw new Exception("Carrinho ou cupom não informado", 400);        
    }

});

$app->delete("/carrinhos/:idcarrinho/cupons/:idcupom", function($idcarrinho, $idcupom){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcarrinho){
        throw new Exception("Carrinho não informado", 400);        
    }

    if(!(int)$idcupom){
        throw new Exception("Cupom não informado", 400);        
    }

    $cupom = new CarrinhoCupom();

    $cupom->queryToAttr("CALL sp_carrinhoscupons_remove(?, ?);", array(
        (int)$idcarrinho,
        (int)$idcupom
    ));

});
////////////////////////////////////////////////

// carrinhos fretes
$app->get("/carrinhos-fretes/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>CarrinhosFretes::listAll()->getFields()));

});

$app->post("/carrinhos-fretes", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idcarrinho') > 0){
        $frete = new CarrinhoFrete((int)post('idcarrinho'));
    }else{
        $frete = new CarrinhoFrete();
    }

    $frete->set();

    $frete->save();

    echo success(array("data"=>$frete->getFields()));

});

$app->delete("/carrinhos-fretes/:idcarrinho", function($idcarrinho){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcarrinho){
        throw new Exception("Carrinho não informado", 400);        
    }

    $frete = new CarrinhoFrete((int)$idcarrinho);

    if(!(int)$frete->getidcarrinho() > 0){
        throw new Exception("Carrinho não encontrado", 404);        
    }

    $frete->remove();

    echo success();

});

?>