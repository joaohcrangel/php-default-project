<?php

$app->get("/".DIR_ADMIN."/social-networks", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
	));

	$page->setTpl("/admin/social-networks");

});

$app->get("/social-networks", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = (int)get("page");
	$itemsPerPage = (int)get("limit");

	$where = array();

	if(get("dessocialnetwork") != ""){
		array_push($where, "dessocialnetwork LIKE '%".utf8_encode(get("dessocialnetwork"))."%'");
	}

	if(count($where) > 0){
		$where = " WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_socialnetworks
		".$where." LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Social\Networks",
		$itemsPerPage
	);

	$networks = $pagination->getPage($page);

	echo success(array(
		"data"=>$networks->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$page,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->get("/social-networks/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	echo success(array("data"=>Hcode\Social\Networks::listAll()->getFields()));

});

$app->post("/social-networks", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if((int)post("idsocialnetwork") > 0){
		$network = new Hcode\Social\Network((int)post("idsocialnetwork"));
	}else{
		$network = new Hcode\Social\Network();
	}

	$network->set($_POST);

	$network->save();

	echo success();

});

$app->delete("/social-networks", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idnetwork) {

		if(!(int)$idnetwork){
			throw new Exception("Rede social não informada", 400);			
		}
		
		$network = new Hcode\Social\Network((int)$idnetwork);

		if(!(int)$network->getidsocialnetwork() > 0){
			throw new Exception("Rede social não encontrada", 404);			
		}

		$network->remove();

	}

	echo success();

});

?>