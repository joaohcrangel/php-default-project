<?php

$app->get("/site-contacts/all", function(){

    Permission::checkSession(Permission::ADMIN, true);

    echo success(array("data"=>SiteContacts::listAll()->getFields()));

});

$app->post("/site-contacts", function(){

    Permission::checkSession(Permission::ADMIN, true);

    if(post('idsitecontact') > 0){
        $site = new SiteContact((int)post('idsitecontact'));
    }else{
        $site = new SiteContact();
    }

    foreach ($_POST as $key => $value) {
        $site->{'set'.$key}($value);
    }

    $site->save();

    echo success(array("data"=>$site->getFields()));

});

$app->post("/site-contacts/person", function(){

    $sql = new Sql();

    $data = $sql->execute("sp_sitecontactsbyperson_get", array(
        post('desemail')
    ));

    if(isset($data[0])){

        $site = new SiteContact(array(            
            'idsitecontact'=>0,
            'idperson'=>$data[0]['idperson'],
            'desmessage'=>post('desmessage')
        ));

        $site->save();

        $person = new Person((int)$data[0]['idperson']);

    }else{

        $person = new Person($_POST);

        $person->save();

        $saveArgs = array(
            array(
                "idcontacttype"=>1,
                "idcontactsubtype"=>post("idcontactsubtype1"),
                "idperson"=>$person->getidperson(),
                "descontact"=>post("desemail"),
                "inmain"=>post("inmain")
            ),
            array(
                "idcontacttype"=>2,
                "idcontactsubtype"=>post("idcontactsubtype2"),
                "idperson"=>$person->getidperson(),
                "descontact"=>post("destelefone"),
                "inmain"=>post("inmain")
            )
        );

        foreach ($saveArgs as $value) {
            
            $contact = new Contact($value);

            $contact->save();

        }

    }

    echo success(array("data"=>$person->getFields()));

});

$app->delete("/site-contacts/:idsitecontact", function($idsitecontact){

    Permission::checkSession(Permission::ADMIN, true);

    if(!(int)$idsitecontact){
        throw new Exception("Contato não informado", 400);        
    }

    $site = new SiteContact((int)$idsitecontact);

    if(!(int)$site->getidsitecontact() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $site->remove();

    echo success();

});

?>