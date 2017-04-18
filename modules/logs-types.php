<?php 

$app->get('/logs-types',function(){

 	$logtype = Hcode\Person\Log\Types::listAll();

 	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('deslogtype')) {
		array_push($where, "deslogtype LIKE '%".get('deslogtype')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AND ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_logstypes
	".$where." limit ?, ?;";

	$pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Person\Log\Types",
        $itemsPerPage
    );

    $logstypes = $pagination->getPage($currentPage);

    echo success(array(
    	"data"=>$logstypes ->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));

});

$app->post("/logs-types", function(){

	if(post('idlogtype') > 0){
		$logtype = new Hcode\Person\Log\Type((int)post('idlogtype'));
	}else{
		$logtype = new Hcode\Person\Log\Type();
	}

	$logtype->set($_POST);

	$logtype->save();

	echo success(array("data"=>$logtype->getFields()));

});

$app->delete("/logs-types/:idlogtype", function($idlogtype){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idlogtype > 0){
		throw new Exception("Tipo de historico não informado.", 400);		
	}

	$logtype = new Hcode\Person\Log\Type((int)$idlogtype);

	$logtype->remove();

	echo success();

});
 
?>