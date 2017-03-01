<?php 

$app->get("/arquivos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if (get('desarquivo')) {
        array_push($where, "desalias LIKE '%".get('desarquivo')."%'");
    }

    if (get('desextensao')) {
        array_push($where, "desextensao = '".get('desextensao')."'");
    }

    if (count($where) > 0) {
        $where = 'WHERE '.implode(' AND ', $where);
    } else {
        $where = '';
    }

    $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM tb_arquivos '.$where.' LIMIT ?, ?';

    $paginacao = new Pagination(
        $query,
        array(),
        "Arquivos",
        $itemsPerPage
    );

    $arquivos = $paginacao->getPage($currentPage); 

    echo success(array(
        "data"=>$arquivos->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),
    ));
  

});

$app->post("/arquivos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $arquivos = Arquivos::upload($_FILES['arquivo']);
    
    echo success(array(
        'data'=>$arquivos->getFields()
    ));

});

$app->delete("/arquivos/:idarquivo", function($idarquivo){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idarquivo){
        throw new Exception("Arquivo não informado", 400);        
    }

    $arquivo = new Arquivo((int)$idarquivo);

    if(!(int)$arquivo->getidarquivo() > 0){
        throw new Exception("Arquivo não encontrado", 404);        
    }

    $arquivo->remove();

    echo success();

});

$app->delete("/arquivos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $ids = explode(",",post('ids'));

    foreach ($ids as $idarquivo) {

        $arquivo = new Arquivo(array(
            'idarquivo'=>(int)$idarquivo
        ));
        $arquivo->remove();

    }

    echo success();

});




 ?>