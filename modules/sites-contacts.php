<?php

$app->get("/site-contacts/all", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    echo success(array("data"=>Hcode\Site\Contacts::listAll()->getFields()));

});

$app->post("/site-contacts", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(post('idsitecontact') > 0){
        $site = new Hcode\Site\Contact((int)post('idsitecontact'));
    }else{
        $site = new Hcode\Site\Contact();
    }

    foreach ($_POST as $key => $value) {
        $site->{'set'.$key}($value);
    }

    $site->save();

    echo success(array("data"=>$site->getFields()));

});

$app->post("/site-contacts/person", function(){

    $sql = new Hcode\Sql();

    $data = $sql->execute("sp_sitecontactsbyperson_get", array(
        post('desemail')
    ));

    if(isset($data[0])){

        $site = new Hcode\Site\Contact(array(            
            'idsitecontact'=>0,
            'idperson'=>$data[0]['idperson'],
            'desmessage'=>post('desmessage')
        ));

        $site->save();

        $person = new Hcode\Person\Person((int)$data[0]['idperson']);

    }else{

        $person = new Hcode\Person\Person($_POST);

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
            
            $contact = new Hcode\Contact\Contact($value);

            $contact->save();

        }

    }

    echo success(array("data"=>$person->getFields()));

});

$app->delete("/site-contacts/:idsitecontact", function($idsitecontact){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idsitecontact){
        throw new Exception("Contato não informado", 400);        
    }

    $site = new Hcode\Site\Contact((int)$idsitecontact);

    if(!(int)$site->getidsitecontact() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $site->remove();

    echo success();

});

?>