<?php

$app->get("/cards/all", function(){

     Permission::checkSession(Permission::ADMIN, true);

    echo success(array("data"=>CardsCredits::listAll()->getFields()));

});

$app->post("/cards", function(){

    Permission::checkSession(Permission::ADMIN, true);

    if(post('idcard') > 0){
        $card = new CardCredit((int)post('idcard'));
    }else{
        $card = new CardCredit();
    }

    foreach ($_POST as $key => $value) {
        $card->{'set'.$key}($value);
    }

    $card->save();

    echo success(array("data"=>$card->getFields()));

});

$app->delete("/cards/:idcard", function($idcard){

    Permission::checkSession(Permission::ADMIN, true);

    if(!(int)$idcard){
        throw new Exception("Cartão não informado", 400);        
    }

    $card = new CardCredit((int)$idcard);

    if(!(int)$card->getidcard() > 0){
        throw new Exception("Cartão não encontrado", 404);        
    }

    $card->remove();

    echo success();

});

?>