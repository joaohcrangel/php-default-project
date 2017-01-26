<?php

$app->get("/site-contatos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>SiteContatos::listAll()->getFields()));

});

$app->post("/site-contatos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idsitecontato') > 0){
        $site = new SiteContato((int)post('idsitecontato'));
    }else{
        $site = new SiteContato();
    }

    foreach ($_POST as $key => $value) {
        $site->{'set'.$key}($value);
    }

    $site->save();

    echo success(array("data"=>$site->getFields()));

});

$app->post("/site-contatos/pessoa", function(){

    $sql = new Sql();

    $data = $sql->proc("sp_sitecontatosbypessoa_get", array(
        post('desemail')
    ));

    if(isset($data[0])){

        $site = new SiteContato(array(            
            'idsitecontato'=>0,
            'idpessoa'=>$data[0]['idpessoa'],
            'desmensagem'=>post('desmensagem')
        ));

        $site->save();

        $pessoa = new Pessoa((int)$data[0]['idpessoa']);

    }else{

        $pessoa = new Pessoa($_POST);

        $pessoa->save();

        $saveArgs = array(
            array(
                "idcontatotipo"=>1,
                "idcontatosubtipo"=>post("idcontatosubtipo1"),
                "idpessoa"=>$pessoa->getidpessoa(),
                "descontato"=>post("desemail"),
                "inprincipal"=>post("inprincipal")
            ),
            array(
                "idcontatotipo"=>2,
                "idcontatosubtipo"=>post("idcontatosubtipo2"),
                "idpessoa"=>$pessoa->getidpessoa(),
                "descontato"=>post("destelefone"),
                "inprincipal"=>post("inprincipal")
            )
        );

        foreach ($saveArgs as $value) {
            
            $contato = new Contato($value);

            $contato->save();

        }

    }

    echo success(array("data"=>$pessoa->getFields()));

});

$app->delete("/site-contatos/:idsitecontato", function($idsitecontato){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idsitecontato){
        throw new Exception("Contato não informado", 400);        
    }

    $site = new SiteContato((int)$idsitecontato);

    if(!(int)$site->getidsitecontato() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $site->remove();

    echo success();

});

?>