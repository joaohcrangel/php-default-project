<?php

$app->get('/persons-types',function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");
 	
 	$where = array();

	if(get('despersontype')) {
		array_push($where, "despersontype LIKE '%".get('despersontype')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AD ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_personstypes
	".$where." LIMIT ?, ?;";

	$pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Person\Types",
        $itemsPerPage
    );

    $personstypes = $pagination->getPage($currentPage);

    echo success(array(
    	"data"=>$personstypes->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal()
    ));
});

$app->post("/persons-types", function(){

	if(post('idpersontype') > 0){
		$person = new Hcode\Person\Type((int)post('idpersontype'));
	}else{
		$person = new Hcode\Person\Type();
	}

	$person->set($_POST);

	$person->save();

	echo success(array("data"=>$person->getFields()));

});

$app->delete("/persons-types/:idpersontype", function($idpersontype){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idpersontype > 0){
		throw new Exception("Tipo de pessoa não informado.", 400);		
	}

	$person = new Hcode\Person\Type((int)$idpersontype);

	$person->remove();

	echo success();

});

 ?>