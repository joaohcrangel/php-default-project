<?php 
$app->get('/settings-types',function(){

 	$setting = SettingsTypes::listAll();

 	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('dessettingtype')) {
		array_push($where, "dessettingtype LIKE '%".get('dessettingtype')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AD ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_settingstypes
	".$where." limit ?, ?;";

	$pagination = new Pagination(
        $query,
        array(),
        "SettingsTypes",
        $itemsPerPage
    );

	$settingstypes = $pagination->getPage($currentPage);

    echo success(array(
    	"data"=>$settingstypes->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));
    
});

$app->post("/settings-types", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if(post('idsettingtype') > 0){
		$setting = new SettingType((int)post('idsettingtype'));
	}else{
		$setting = new SettingType();
	}

	$setting->set($_POST);

	$setting->save();

	echo success(array("data"=>$setting->getFields()));
});

$app->delete("/settings-types/:idsettingtype", function($idsettingtype){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idsettingtype > 0){
		throw new Exception("Configuracao de Campos não informado.", 400);		
	}

	$setting = new SettingType((int)$idsettingtype);

	$setting->remove();

	echo success();

});


 ?>