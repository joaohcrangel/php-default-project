<?php

$app->get("/forms-payments/all", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if (get('desformpayment')) {
        array_push($where, "desformpayment LIKE '%".get('desformpayment')."%'");
    }
    
    if (get('nrplotsmax')) {
        array_push($where, "nrplotsmax = '".get('nrplotsmax')."'");
    }
    if (get('idgateway')) {
        array_push($where, "idgateway = ".get('idgateway'));
    }

    

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AND ', $where);
    } else {
        $where = '';
    }

    $query = '
        SELECT SQL_CALC_FOUND_ROWS * 
        FROM tb_formspayments a 
        INNER JOIN tb_gateways b USING(idgateway)
        '.$where.' LIMIT ?, ?';

      $pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Financial\FormsPayments",
        $itemsPerPage
    );

    $formspayments = $pagination->getPage($currentPage); 

    echo success(array(
        "data"=>$formspayments->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),
    ));
  
});

$app->post("/forms-payments", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(post('idformpayment') > 0){
        $payment = new Hcode\Financial\FormPayment((int)post('idformpayment'));
    }else{
        $payment = new Hcode\Financial\FormPayment();
    }

    $payment->set($_POST);

    if (isset($_POST['instatus'])) {
        $payment->setinstatus(true);
    } else {    
        $payment->setinstatus(false);
    }    

    $payment->save();

    echo success(array("data"=>$payment->getFields()));

});

$app->delete("/forms-payments/:idformpayment", function($idformpayment){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idformpayment){
        throw new Exception("Forma de Pagamento não informado", 400);
    }

    $payment = new Hcode\Financial\FormPayment((int)$idformpayment);

    if(!(int)$payment->getidformpayment() > 0){
        throw new Exception("Forma de pagamento não encontrado", 404); 
    }

    $payment->remove();

    echo success();

});

?>