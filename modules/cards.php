<?php

$app->get("/cards/all", function(){

     Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    echo success(array("data"=>Hcode\Financial\CardsCredits::listAll()->getFields()));

});

$app->post("/cards", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(post('idcard') > 0){
        $card = new Hcode\Financial\CardCredit((int)post('idcard'));
    }else{
        $card = new Hcode\Financial\CardCredit();
    }

    foreach ($_POST as $key => $value) {
        $card->{'set'.$key}($value);
    }

    $card->save();

    echo success(array("data"=>$card->getFields()));

});

$app->delete("/cards/:idcard", function($idcard){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idcard){
        throw new Exception("Cartão não informado", 400);        
    }

    $card = new Hcode\Financial\CardCredit((int)$idcard);

    if(!(int)$card->getidcard() > 0){
        throw new Exception("Cartão não encontrado", 404);        
    }

    $card->remove();

    echo success();

});

?>