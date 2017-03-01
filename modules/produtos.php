<?php

$app->get("/produtos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $pagina = (int)get('pagina');    

    $itemsPorPagina = (int)get('limit');

    $where = array();

    if(isset($_GET['ids'])){
        $ids = explode(',',get('ids'));
        $newIds = array();
        foreach ($ids as $id) {
            if ((int)$id > 0) array_push($newIds, (int)$id);
        }
        if(count($newIds) > 0) array_push($where, "a.idprodutotipo IN(".implode(',', $newIds).")");        
    }

    if(count($where) > 0){
        $where = "WHERE ".implode(" AND ", $where)."";
    }else{
        $where = "";
    }

    $query = "
        SELECT SQL_CALC_FOUND_ROWS * FROM tb_produtos a
        ".$where." LIMIT ?, ?
    ;";

    $paginacao = new Pagination(
        $query,
        array(),
        "Produtos",
        $itemsPorPagina
    );

    $produtos = $paginacao->getPage($pagina); 

    echo success(array(
        "data"=>$produtos->getFields(),
        "total"=>$paginacao->getTotal(),
        "paginaAtual"=>$pagina,
        "itemsPorPagina"=>$itemsPorPagina
    ));

});

$app->post('/produtos', function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if((int)post('idproduto') > 0){
        $produto = new Produto((int)post('idproduto'));
    }else{
        $produto = new Produto();
    }

    $_POST['inremovido'] = ($_POST['inremovido']==='0')?false:true;

    $produto->set($_POST);

    $produto->save();

    echo success(array("data"=>$produto->getFields()));

});

$app->get("/produtos/:idproduto/precos", function($idproduto){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idproduto){
        throw new Exception("Produto não informado", 400);        
    }

    $produto = new Produto(array(
        'idproduto'=>(int)$idproduto
    ));

    $precos = $produto->getProdutosPrecos();

    $data = $precos->getFields();

    foreach ($data as &$row) {
        if (!isset($row['isodttermino'])) {
            
        } else {
            $row['desduracao'] = Utils::getDateTimeDiffHuman(
                                new DateTime($row['isodtinicio']),
                                new DateTime($row['isodttermino'])
                            );
        }

        
        
    }

    echo success(array(
        'data'=>$data
    ));

});

$app->get("/produtos/:idproduto/arquivos", function($idproduto){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idproduto){
        throw new Exception("Produto não informado", 400);        
    }

    $produto = new Produto(array(
        'idproduto'=>(int)$idproduto
    ));

    $arquivos = $produto->getArquivos();

    echo success(array(
        'data'=>$arquivos->getFields()
    ));

});

$app->post("/produtos/:idproduto/arquivos", function($idproduto){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idproduto){
        throw new Exception("Produto não informado", 400);        
    }

    $produto = new Produto(array(
        'idproduto'=>(int)$idproduto
    ));

    $file = $_FILES['arquivo'];

    $arquivo = Arquivo::upload(
        $file['name'],
        $file['type'],
        $file['tmp_name'],
        $file['error'],
        $file['size']
    );

    $produto->addArquivo($arquivo);
    
    echo success(array(
        'data'=>$arquivo->getFields()
    ));

});

$app->delete("/produtos/:idproduto", function($idproduto){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idproduto){
        throw new Exception("Produto não informado", 400);        
    }

    $produto = new Produto((int)$idproduto);

    if(!(int)$produto->getidproduto() > 0){
        throw new Exception("Produto não encontrado", 404);        
    }

    $produto->remove();

    echo success();

});
/////////////////////////////////////////////////////////

// produtos tipos

$app->get("/produtos/tipos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('desprodutotipo')) {
        array_push($where, "desprodutotipo LIKE '%".get('desprodutotipo')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AD ', $where);
    } else {
        $where = '';
    }

    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_produtostipos
    ".$where." limit ?, ?;";

    $paginacao = new Pagination(
        $query,
        array(),
        "ProdutosTipos",
        $itemsPerPage
    );

     $produtostipos = $paginacao->getPage($currentPage);

    echo success(array(
        "data"=>$produtostipos->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),

    ));
    
});

$app->post("/produtos-tipos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idprodutotipo') > 0){
        $produtotipo = new ProdutoTipo((int)post('idprodutotipo'));
    }else{
        $produtotipo = new ProdutoTipo();
    }

    foreach ($_POST as $key => $value) {
        $produtotipo->{'set'.$key}($value);
    }

    $produtotipo->save();

    echo success(array("data"=>$produtotipo->getFields()));

});

$app->delete("/produtos-tipos/:idprodutotipo", function($idprodutotipo){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idprodutotipo){
        throw new Exception("Tipo de produto não informado", 400);        
    }

    $produtotipo = new ProdutoTipo((int)$idprodutotipo);

    if(!(int)$produtotipo->getidprodutotipo() > 0){
        throw new Exception("Tipo de produto não encontrado", 404);        
    }

    $produtotipo->remove();

    echo success();

});

// carrinhos
$app->get("/produtos/:idproduto/carrinhos", function($idproduto){

    Permissao::checkSession(Permissao::ADMIN, true);

    $produto = new Produto((int)$idproduto);

    echo success(array("data"=>$produto->getCarrinhos()->getFields()));

});

// pagamentos
$app->get("/produtos/:idproduto/pagamentos", function($idproduto){

    Permissao::checkSession(Permissao::ADMIN, true);

    $produto = new Produto((int)$idproduto);

    echo success(array("data"=>$produto->getPagamentos()->getFields()));

});

// precos
$app->get("/produtos/:idproduto/precos", function($idproduto){

    Permissao::checkSession(Permissao::ADMIN, true);

    $produto = new Produto((int)$idproduto);

    echo success(array("data"=>$produto->getPrecos()->getFields()));

});

?>