<?php

$app->get("/contacts/", function(){
    
    Permission::checkSession(Permission::ADMIN, true);

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

    $pagination = new Pagination(
        $query,
        array(),
        "ContactsTypes",
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

    Permission::checkSession(Permission::ADMIN, true);

    if(post('idcontact') > 0){
        $contact = new Contact((int)post('idcontact'));
    }else{
        $contact = new Contact();
    }

    foreach ($_POST as $key => $value) {
        $contact->{'set'.$key}($value);
    }

    $contact->save();

    echo success(array("data"=>$contact->getFields()));

});

$app->delete("/contacts/:idcontact", function($idcontact){

    Permission::checkSession(Permission::ADMIN, true);

    if(!(int)$idcontact){
        throw new Exception("Contato não informado", 400);        
    }

    $contact = new Contact((int)$idcontato);

    if(!(int)$contact->getidcontact() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $contact->remove();

    echo success();

});

// contatos- tipos

$app->get("/contacts/types", function(){
    
    Permission::checkSession(Permission::ADMIN, true);

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

    $pagination = new Pagination(
        $query,
        array(),
        "ContactsTypes",
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

    Permission::checkSession(Permission::ADMIN, true);

    if(post('idcontacttype') > 0){
        $contact = new ContactType((int)post('idcontacttype'));
    }else{
        $contact = new ContactType();
    }

    foreach ($_POST as $key => $value) {
        $contact->{'set'.$key}($value);
    }

    $contact->save();

    echo success(array("data"=>$contact->getFields()));

});

$app->delete("/contacts-types/:idcontact", function($idcontacttype){

    Permission::checkSession(Permission::ADMIN, true);

    if(!(int)$idcontacttype){
        throw new Exception("Contato não informado", 400);        
    }

    $contact = new ContactType((int)$idcontacttype);

    if(!(int)$contact->getidcontacttype() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $contact->remove();

    echo success();

});

?>