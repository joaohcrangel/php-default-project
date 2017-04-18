<?php 

$app->get('/userslogs-types',function(){

 	$logs = Hcode\User\Log\Types::listAll();

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

	$pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\User\Log\Types",
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
		$logs = new Hcode\System\User\Log\Type((int)post('idlogtype'));
	}else{
		$logs = new Hcode\System\User\Log\Type();
	}

	$logs->set($_POST);

	$logs->save();

	echo success(array("data"=>$logs->getFields()));

});

$app->delete("/userslogs-types/:idlogtype", function($idlogtype){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idlogtype > 0){
		throw new Exception("Tipo de historico não informado.", 400);		
	}

	$logs = new Hcode\System\User\Log\Type((int)$idlogtype);

	$logs->remove();

	echo success();

});
 
?>