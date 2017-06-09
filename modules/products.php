<?php

$app->get("/products/all", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $pagina = (int)get('pagina');    

    $itemsPorPagina = (int)get('limit');

    $where = array();

    if(get('desproduct') != ''){
        array_push($where, "a.desproduct LIKE '%".utf8_decode(get('desproduct'))."%'");
    }

    if(isset($_GET['ids'])){
        $ids = explode(',',get('ids'));
        $newIds = array();
        foreach ($ids as $id) {
            if ((int)$id > 0) array_push($newIds, (int)$id);
        }
        if(count($newIds) > 0) array_push($where, "a.idproducttype IN(".implode(',', $newIds).")");        
    }

    if(count($where) > 0){
        $where = "WHERE ".implode(" AND ", $where)."";
    }else{
        $where = "";
    }

    $query = "
        SELECT SQL_CALC_FOUND_ROWS * FROM tb_productsdata a
        ".$where." LIMIT ?, ?
    ;";

    $pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Shop\Products",
        $itemsPorPagina
    );

    $products = $pagination->getPage($pagina); 

    echo success(array(
        "data"=>$products->getFields(),
        "total"=>$pagination->getTotal(),
        "paginaAtual"=>$pagina,
        "itemsPorPagina"=>$itemsPorPagina
    ));

});

$app->post('/products', function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if((int)post('idproduct') > 0){
        $product = new Hcode\Shop\Product((int)post('idproduct'));
    }else{
        $product = new Hcode\Shop\Product();
    }

    $url = Hcode\Site\Url::checkUrl(post("desurl"), post("idurl"));

    $url->save();

    $_POST['inremoved'] = ($_POST['inremoved'] === '0') ? false : true;

    $product->set($_POST);

    $product->save();

    $product->setUrl($url);

    echo success(array("data"=>$product->getFields()));

});

$app->post("/products-courses", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if((int)post('idproduct') > 0){
        $product = new Hcode\Shop\Product((int)post('idproduct'));
    }else{
        $product = new Hcode\Shop\Product();
    }

    $course = new Hcode\Course\Course((int)post("idcourse"));

    $_POST['inremoved'] = 0;

    $product->set($_POST);

    $product->setdesproduct(post("descourse"));

    $product->save();

    $product->setCourse($course);

    echo success(array("data"=>$product->getFields()));

});

$app->post("/products/:idproduct/thumb", function($idproduct){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idproduct){
        throw new Exception("Produto não informado", 400);        
    }

    $files = Hcode\FileSystem\Files::upload($_FILES["arquivo"]);

    $file = $files->getFirst();

    $product = new Hcode\Shop\Product((int)$idproduct);

    $product->setidthumb($file->getidfile());

    $product->save();

    echo success([
        "data"=>$file->getFields()
    ]);

});

$app->get("/products/:idproduct/prices", function($idproduct){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idproduct){
        throw new Exception("Produto não informado", 400);        
    }

    $product = new Hcode\Shop\Product(array(
        'idproduct'=>(int)$idproduct
    ));

    $prices = $product->getPrices();

    $data = $prices->getFields();

    foreach ($data as &$row) {
        if (!isset($row['isodttermino'])) {
            
        } else {
            $row['desduracao'] = Hcode\System\Utils::getDateTimeDiffHuman(
                new DateTime($row['isodtinicio']),
                new DateTime($row['isodttermino'])
            );
        }        
        
    }

    echo success(array(
        'data'=>$data
    ));

});

$app->get("/products/:idproduct/files", function($idproduct){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $pagina = (int)get('pagina');
    $itemsPerPage = (int)get('limit');

    $where = array();

    array_push($where, "c.idproduct = ".(int)$idproduct."");

    if(count($where) > 0){
        $where = "WHERE ".implode(" AND ", $where)."";
    }else{
        $where = "";
    }

    $query = "
        SELECT SQL_CALC_FOUND_ROWS a.*, c.desproduct FROM tb_files a
            INNER JOIN tb_productsfiles b ON a.idfile = b.idfile
            INNER JOIN tb_products c ON b.idproduct = c.idproduct
        ".$where." LIMIT ?, ?;
    ";

    $pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\FileSystem\Files",
        $itemsPerPage
    );

    $files = $pagination->getPage($pagina);

    echo success(array(
        "data"=>$files->getFields(),
        "total"=>$pagination->getTotal(),
        "currentPage"=>$pagina,
        "itemsPerPage"=>$itemsPerPage
    ));

});

$app->post("/products/:idproduct/files", function($idproduct){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idproduct){
        throw new Exception("Produto não informado", 400);        
    }

    $product = new Hcode\Shop\Product(array(
        'idproduct'=>(int)$idproduct
    ));

    $files = Hcode\FileSystem\Files::upload($_FILES['arquivo']);

    foreach($files->getItens() as $file){
        $product->addFile($file);
    }
    
    echo success(array(
        'data'=>$file->getFields()
    ));

});

$app->delete("/products/:idproduct", function($idproduct){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idproduct){
        throw new Exception("Produto não informado", 400);        
    }

    $product = new Hcode\Shop\Product((int)$idproduct);

    if(!(int)$product->getidproduct() > 0){
        throw new Exception("Produto não encontrado", 404);        
    }

    $product->remove();

    echo success();

});
/////////////////////////////////////////////////////////

// products types
$app->get("/products/types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('desproducttype')) {
        array_push($where, "desproducttype LIKE '%".get('desproducttype')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AD ', $where);
    } else {
        $where = '';
    }

    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_productstypes
    ".$where." limit ?, ?;";

    $pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Shop\Product\Types",
        $itemsPerPage
    );

     $productstypes = $pagination->getPage($currentPage);

    echo success(array(
        "data"=>$productstypes->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));
    
});

$app->post("/products-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(post('idproducttype') > 0){
        $producttype = new Hcode\Shop\Product\Type((int)post('idproducttype'));
    }else{
        $producttype = new Hcode\Shop\Product\Type();
    }

    foreach ($_POST as $key => $value) {
        $producttype->{'set'.$key}($value);
    }

    $producttype->save();

    echo success(array("data"=>$producttype->getFields()));

});

$app->delete("/products-types/:idproducttype", function($idproducttype){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idproducttype){
        throw new Exception("Tipo de produto não informado", 400);        
    }

    $producttype = new Hcode\Shop\Product\Type((int)$idproducttype);

    if(!(int)$producttype->getidproducttype() > 0){
        throw new Exception("Tipo de produto não encontrado", 404);        
    }

    $producttype->remove();

    echo success();

});

// carrinhos
$app->get("/products/:idproduct/carts", function($idproduct){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $product = new Hcode\Shop\Product((int)$idproduct);

    echo success(array("data"=>$product->getCarts()->getFields()));

});

// pagamentos
$app->get("/products/:idproduct/payments", function($idproduct){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $product = new Hcode\Shop\Product((int)$idproduct);

    echo success(array("data"=>$product->getPayments()->getFields()));

});

// precos
$app->get("/products/:idproduct/prices", function($idproduct){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $product = new Hcode\Shop\Product((int)$idproduct);

    echo success(array("data"=>$product->getPrices()->getFields()));

});

?>