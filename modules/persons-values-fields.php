<?php 

$app->get('/persons-valuesfields',function(){

 	$personvalue = Hcode\Person\Value\Field::listAll();

 	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('desfield')) {
		array_push($where, "desfield LIKE '%".get('desfield')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AND ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_personsvaluesfields
	".$where." LIMIT ?, ?;";

	$pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Person\Value\Fields",
        $itemsPerPage
    );


    $personsvaluesfields = $pagination->getPage($currentPage);

    echo success(array(
    	"data"=>$personsvaluesfields->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));

});

$app->post("/persons-valuesfields", function(){

	if(post('idfield') > 0){
		$personvalue = new Hcode\Person\Value\Field((int)post('idfield'));
	}else{
		$personvalue = new Hcode\Person\Value\Field();
	}

	$personvalue->set($_POST);

	$personvalue->save();

	echo success(array("data"=>$personvalue->getFields()));

});

$app->delete("/persons-valuesfields/:idfield", function($idfield){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idfield > 0){
		throw new Exception("Valor de campo não informado.", 400);		
	}

	$personvalue = new Hcode\Person\Value\Field((int)$idfield);

	$personvalue->remove();

	echo success();

});
 
?>