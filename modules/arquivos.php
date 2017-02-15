<?php 

$app->get("/arquivos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>Arquivos::listAll()->getFields()));

});

$app->post("/arquivos/:idarquivo", function($idarquivo){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idarquivo){
        throw new Exception("Arquivo não informado", 400);        
    }

    $arquivo = new Arquivo(array(
        'idarquivo'=>(int)$idarquivo
    ));

    $file = $_FILES['arquivo'];
    $arquivo = Arquivo::upload(
        $file['name'],
        $file['type'],
        $file['tmp_name'],
        $file['error'],
        $file['size']
    );

    $arquivo->addArquivo($arquivo);
    
    echo success(array(
        'data'=>$arquivo->getFields()
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




 ?>