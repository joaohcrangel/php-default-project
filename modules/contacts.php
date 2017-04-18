<?php

$app->get("/contacts/", function(){
    
    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('descontacttype')) {
        array_push($where, "descontacttype LIKE '%".get('descontacttype')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AND ', $where);
    } else {
        $where = '';
    }

    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_contactstypes
    ".$where." limit ?, ?;";

    $pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Contact\Types",
        $itemsPerPage
    );

    $contactstypes = $pagination->getPage($currentPage);

    echo success(array(
        "data"=>$contactstypes->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));

});

$app->post("/contacts", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(post('idcontact') > 0){
        $contact = new Hcode\Contact\Contact((int)post('idcontact'));
    }else{
        $contact = new Hcode\Contact\Contact();
    }

    foreach ($_POST as $key => $value) {
        $contact->{'set'.$key}($value);
    }

    $contact->save();

    echo success(array("data"=>$contact->getFields()));

});

$app->delete("/contacts/:idcontact", function($idcontact){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idcontact){
        throw new Exception("Contato não informado", 400);        
    }

    $contact = new Hcode\Contact\Contact((int)$idcontato);

    if(!(int)$contact->getidcontact() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $contact->remove();

    echo success();

});

// contatos- tipos

$app->get("/contacts/types", function(){
    
    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('descontacttype')) {
        array_push($where, "descontacttype LIKE '%".get('descontacttype')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AND ', $where);
    } else {
        $where = '';
    }

    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_contactstypes
    ".$where." limit ?, ?;";

    $pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Contact\Contact\Types",
        $itemsPerPage
    );

    $contactstypes = $pagination->getPage($currentPage);

    echo success(array(
        "data"=>$contactstypes->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));

});

$app->post("/contacts-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(post('idcontacttype') > 0){
        $contact = new Hcode\Contact\Type((int)post('idcontacttype'));
    }else{
        $contact = new Hcode\Contact\Type();
    }

    foreach ($_POST as $key => $value) {
        $contact->{'set'.$key}($value);
    }

    $contact->save();

    echo success(array("data"=>$contact->getFields()));

});

$app->delete("/contacts-types/:idcontact", function($idcontacttype){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idcontacttype){
        throw new Exception("Contato não informado", 400);        
    }

    $contact = new Hcode\Contact\Type((int)$idcontacttype);

    if(!(int)$contact->getidcontacttype() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $contact->remove();

    echo success();

});

?>