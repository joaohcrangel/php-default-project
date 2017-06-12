<?php 

$app->get("/materiais-types/", function(){
    
    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('destype')) {
        array_push($where, "destype LIKE '%".get('destype')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AND ', $where);
    } else {
        $where = '';
    }

    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_materialstypes
    ".$where." limit ?, ?;";

    $pagination = new Hcode\Pagination(
        $query,
        array(),
       "Hcode\Stand\Material\Types",
        $itemsPerPage
    );

    $materialstypes = $pagination->getPage($currentPage);

    echo success(array(
        "data"=>$materialstypes->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));

});

$app->post("/materiais-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(post('idtype') > 0){
        $material = new Hcode\Stand\Material\Type((int)post('idtype'));
    }else{
        $material = new Hcode\Stand\Material\Type();
    }

    foreach ($_POST as $key => $value) {
        $material->{'set'.$key}($value);
    }

    $material->save();

    echo success(array("data"=>$material->getFields()));

});

$app->delete("/materiais-types/:idtype", function($idtype){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idtype){
        throw new Exception("Material não informado", 400);        
    }

    $material = new Hcode\Stand\Material\Type((int)$idtype);

    if(!(int)$material->getidtype() > 0){
        throw new Exception("Material não encontrado", 404);        
    }

    $material->remove();

    echo success();

});

///////////////////////////////////////////////////////////////////

// Units-Types

$app->get("/materiais-units-types/", function(){
    
    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('desunitytype')) {
        array_push($where, "desunitytype LIKE '%".get('desunitytype')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AND ', $where);
    } else {
        $where = '';
    }

    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_materialsunitstypes
    ".$where." limit ?, ?;";

    $pagination = new Hcode\Pagination(
        $query,
        array(),
       "Hcode\Stand\Material\Unit\Types",
        $itemsPerPage
    );

    $materialunit = $pagination->getPage($currentPage);

    echo success(array(
        "data"=>$materialunit->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));

});

$app->post("/materiais-units-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(post('idunitytype') > 0){
        $materialunit = new Hcode\Stand\Material\Unit\Type((int)post('idunitytype'));
    }else{
        $materialunit = new Hcode\Stand\Material\Unit\Type();
    }

    foreach ($_POST as $key => $value) {
        $materialunit->{'set'.$key}($value);
    }

    $materialunit->save();

    echo success(array("data"=>$materialunit->getFields()));

});

$app->delete("/materiais-units-types/:idunitytype", function($idunitytype){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idunitytype){
        throw new Exception("Material não informado", 400);        
    }

    $materialunit = new Hcode\Stand\Material\Unit\Type((int)$idunitytype);

    if(!(int)$materialunit->getidunitytype() > 0){
        throw new Exception("Material não encontrado", 404);        
    }

    $materialunit->remove();

    echo success();

});

?>