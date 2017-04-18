<?php 
$app->get('/configurations-types',function(){

 	$configuration = Hcode\System\Configuration\Types::listAll();

 	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('desconfigurationtype')) {
		array_push($where, "desconfigurationtype LIKE '%".get('desconfigurationtype')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AD ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_configurationstypes
	".$where." limit ?, ?;";

	$pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\System\Configuration\Types",
        $itemsPerPage
    );

	$configurationstypes = $pagination->getPage($currentPage);

    echo success(array(
    	"data"=>$configurationstypes->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));
    
});

$app->post("/configurations-types", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(post('idconfigurationtype') > 0){
		$configuration = new Hcode\System\Configuration\Type((int)post('idconfigurationtype'));
	}else{
		$configuration = new Hcode\System\Configuration\Type();
	}

	$configuration->set($_POST);

	$configuration->save();

	echo success(array("data"=>$configuration->getFields()));
});

$app->delete("/configurations-types/:idconfigurationtype", function($idconfigurationtype){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idconfigurationtype > 0){
		throw new Exception("Configuracao de Campos não informado.", 400);		
	}

	$configuration = new Hcode\System\Configuration\Type((int)$idconfigurationtype);

	$configuration->remove();

	echo success();

});


 ?>