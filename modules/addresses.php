<?php 

 $app->get("/addressestypes",function(){

   $address = Hcode\Address\Types::listAll();
    echo success(array(
     "data"=> $address->getFields()
   	));

 });

 $app->get("/addresses/:idaddress", function($idaddress){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

    $address = new Hcode\Address\Address((int)$idaddress);

    echo success(array("data"=>$address->getFields()));

 });

$app->get('/addresses/cep/:nrcep', function($nrcep){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

    $address = Hcode\Address\Address::getByCep($nrcep);

    echo success(array(
        'data'=>$address->getFields()
    ));
});

 $app->get('/addresses/cities', function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

    $address = new Hcode\Address\Cities();

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

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

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

      $Pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Address\Types",
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

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

    $addresstype = new Hcode\Address\Type($_POST);

    $addresstype->save();

    echo success(array(
        'data'=>$addresstype->getFields()
    ));

});

$app->delete('/addresses-types/:idaddresstype', function ($idaddresstype) {

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$addresstype = new Hcode\Address\Type((int)$idaddresstype);

	$addresstype->remove();

	echo success();

}); 

 $app->post("/".DIR_ADMIN."/addresses", function(){

 	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

 	if(post('idaddress') > 0){
 		$address = new Hcode\Address\Address((int)post('idaddress'));
 	}else{
 		$address = new Hcode\Address\Address();
 	}

 	foreach ($_POST as $key => $value) {
 		$address->{'set'.$key}($value);
 	}

 	$address->save();

 	echo success(array("data"=>$address->getFields()));

 });

 $app->delete("/".DIR_ADMIN."/addresses/:idaddress", function($idaddress){

 	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

 	if(!(int)$idaddress){
 		throw new Exception("Endereço não informado", 400); 		
 	}

 	$address = new Hcode\Address\Address((int)$idaddress);

 	if(!(int)$address->getidaddress() > 0){
 		throw new Exception("Endereço não encontrado", 404); 		
 	}

 	$address->remove();

 	echo success();

 });

?>