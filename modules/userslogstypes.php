<?php 

$app->get('/userslogs-types',function(){

 	$logs = UsersLogsTypes::listAll();

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

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_userslogstypes
	".$where." limit ?, ?;";

	$pagination = new Pagination(
        $query,
        array(),
        "UsersLogsTypes",
        $itemsPerPage
    );

    $logs = $pagination->getPage($currentPage);

    echo success(array(
    	"data"=>$logs ->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));

});

$app->post("/userslogs-types", function(){

	if(post('idlogtype') > 0){
		$logs = new UserLogType((int)post('idlogtype'));
	}else{
		$logs = new UserLogType();
	}

	$logs->set($_POST);

	$logs->save();

	echo success(array("data"=>$logs->getFields()));

});

$app->delete("/userslogs-types/:idlogtype", function($idlogtype){

	Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

	if(!(int)$idlogtype > 0){
		throw new Exception("Tipo de historico não informado.", 400);		
	}

	$logs = new UserLogType((int)$idlogtype);

	$logs->remove();

	echo success();

});
 
?>