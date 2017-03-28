<?php 

 $app->get("/addressestypes",function(){

   $address = AddressesTypes::listAll();
    echo success(array(
     "data"=> $address->getFields()
   	));

 });

 $app->get("/addresses/:idaddress", function($idaddress){

    Permission::checkSession(Permission::ADMIN);

    $address = new Address((int)$idaddress);

    echo success(array("data"=>$address->getFields()));

 });

$app->get('/addresses/cep/:nrcep', function($nrcep){

    Permission::checkSession(Permission::ADMIN);

    $address = Address::getByCep($nrcep);

    echo success(array(
        'data'=>$address->getFields()
    ));
});

 $app->get('/addresses/cities', function(){

    Permission::checkSession(Permission::ADMIN);

    $address = new Cities();

    $address->loadFromQuery("
        SELECT * 
        FROM tb_addresses a
        INNER JOIN tb_states b ON a.idstate = b.idstate
        WHERE descity LIKE '".utf8_decode(get('q'))."%'
        ORDER BY descity, desuf
        LIMIT 10
    ");

    echo success(array(
        'data'=>$cities->getFields()
    ));

 });

 $app->get('/addresses-types', function () {

	Permission::checkSession(Permission::ADMIN);

    $currentPage = (int)get("pagina");
    $itemsPerPage = (int)get("limite");

    $where = array();

    if(get('desaddresstype')) {
        array_push($where, "desaddresstype LIKE '%".get('desaddresstype')."%'");
    }

    if (count($where) > 0) {
        $where = ' WHERE '.implode(' AND ', $where);
    } else {
        $where = '';
    }

    $query = "
        SELECT SQL_CALC_FOUND_ROWS *
        FROM tb_addressestypes 
        ".$where." LIMIT ?, ?;";

      $Pagination = new Pagination(
        $query,
        array(),
        "AddressesTypes",
        $itemsPerPage
    );

    $addressestypes = $Pagination->getPage($currentPage);

    echo success(array(
        "data"=>$addressestypes->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$Pagination->getTotal(),

    ));

});

 $app->post('/addresses-types', function () {

    Permission::checkSession(Permission::ADMIN);

    $addresstype = new AddressType($_POST);

    $addresstype->save();

    echo success(array(
        'data'=>$addresstype->getFields()
    ));

});

$app->delete('/addresses-types/:idaddresstype', function ($idaddresstype) {

	Permission::checkSession(Permission::ADMIN);

	$addresstype = new AddressType((int)$idaddresstype);

	$addresstype->remove();

	echo success();

}); 

 $app->post("/".DIR_ADMIN."/addresses", function(){

 	Permission::checkSession(Permission::ADMIN, true);

 	if(post('idaddress') > 0){
 		$address = new Address((int)post('idaddress'));
 	}else{
 		$address = new Address();
 	}

 	foreach ($_POST as $key => $value) {
 		$address->{'set'.$key}($value);
 	}

 	$address->save();

 	echo success(array("data"=>$address->getFields()));

 });

 $app->delete("/".DIR_ADMIN."/addresses/:idaddress", function($idaddress){

 	Permission::checkSession(Permission::ADMIN, true);

 	if(!(int)$idaddress){
 		throw new Exception("Endereço não informado", 400); 		
 	}

 	$address = new Address((int)$idaddress);

 	if(!(int)$address->getidaddress() > 0){
 		throw new Exception("Endereço não encontrado", 404); 		
 	}

 	$address->remove();

 	echo success();

 });

?>