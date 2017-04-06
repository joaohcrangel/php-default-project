<?php 

$app->get('/logs-types',function(){

 	$logtype = LogsTypes::listAll();

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

	$pagination = new Pagination(
        $query,
        array(),
        "LogsTypes",
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
		$logtype = new LogType((int)post('idlogtype'));
	}else{
		$logtype = new LogType();
	}

	$logtype->set($_POST);

	$logtype->save();

	echo success(array("data"=>$logtype->getFields()));

});

$app->delete("/logs-types/:idlogtype", function($idlogtype){

	Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

	if(!(int)$idlogtype > 0){
		throw new Exception("Tipo de historico não informado.", 400);		
	}

	$logtype = new LogType((int)$idlogtype);

	$logtype->remove();

	echo success();

});
 
?>