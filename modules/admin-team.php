<?php

$app->get("/".DIR_ADMIN."/team/jobs-positions", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		'data'=>array(
			'body'=>array(
				'class'=>'page-aside-fixed page-aside-left'
			)
		)
	));

	$page->setTpl("/admin/jobs-positions");

});

$app->get("/jobs-positions", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$itemsPerPage = (int)get("limite");
	$page = (int)get("pagina");

	$where = array();

	if(get("desjobposition") != ""){
		array_push($where, "desjobposition LIKE '%".utf8_encode(get("desjobposition"))."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where);
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_jobspositions
		".$where." LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Team\Job\Positions",
		$itemsPerPage
	);

	$positions = $pagination->getPage($page);

	echo success(array(
		"data"=>$positions->getFields(),
		"total"=>$pagination->getTotal(),
		"itemsPerPage"=>$itemsPerPage,
		"currentPage"=>$page
	));

});

$app->get("/".DIR_ADMIN."/jobs-positions-create", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/jobs-positions-create");

});

$app->get("/".DIR_ADMIN."/jobs-positions/:idjobposition", function($idjobposition){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$position = new Hcode\Team\Job\Position((int)$idjobposition);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/job-position", array(
		"position"=>$position->getFields()
	));

});

$app->get("/jobs-positions/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	echo success(array("data"=>Hcode\Team\Job\Positions::listAll()->getFields()));

});

$app->post("/jobs-positions", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if((int)post("idjobposition") > 0){
		$position = new Hcode\Team\Job\Position((int)post("idjobposition"));
	}else{
		$position = new Hcode\Team\Job\Position();
	}

	$position->set($_POST);

	$position->save();

	echo success(array("data"=>$position->getFields()));

});

$app->delete("/jobs-positions", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idjobposition) {
		
		if(!(int)$idjobposition){
			throw new Exception("Cargo não informado", 400);			
		}

		$position = new Hcode\Team\Job\Position((int)$idjobposition);

		if(!(int)$position->getidjobposition() > 0){
			throw new Exception("Cargo não encontrado", 404);			
		}

		$position->remove();

	}

	echo success();

});

$app->get("/".DIR_ADMIN."/team/workers", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		'data'=>array(
			'body'=>array(
				'class'=>'page-aside-fixed page-aside-left'
			)
		)
	));

	$page->setTpl("/admin/workers");

});

$app->get("/".DIR_ADMIN."/workers/:idworker", function($idworker){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$worker = new Hcode\Team\Worker((int)$idworker);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/worker", array(
		"worker"=>$worker->getFields()
	));

});

$app->get("/".DIR_ADMIN."/worker-create", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/worker-create");

});

$app->get("/workers/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = (int)get("page");
	$itemsPerPage = (int)get("limit");

	$where = array();

	if(get("desperson") != ""){
		array_push($where, "b.desperson LIKE '%".utf8_encode(get("desperson"))."%'");
	}

	if(get("idjobposition")){
		array_push($where, "a.idjobposition = ".(int)get("idjobposition"));
	}

	if(count($where) > 0){
		$where = " WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.*, c.desjobposition FROM tb_workers a
			INNER JOIN tb_persons b ON a.idperson = b.idperson
			INNER JOIN tb_jobspositions c ON a.idjobposition = c.idjobposition
		".$where." LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Team\Workers",
		$itemsPerPage
	);

	$workers = $pagination->getPage($page);

	echo success(array(
		"data"=>$workers->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$page,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/workers", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if((int)post("idworker") > 0){
		$worker = new Hcode\Team\Worker((int)post("idworker"));
	}else{
		$worker = new Hcode\Team\Worker();
	}

	$worker->set($_POST);

	$worker->save();

	echo success(array("data"=>$worker->getFields()));

});

$app->delete("/workers", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idworker) {

		if(!(int)$idworker){
			throw new Exception("Funcionário não informado", 400);			
		}
		
		$worker = new Hcode\Team\Worker((int)$idworker);

		if(!(int)$worker->getidworker() > 0){
			throw new Exception("Funcionário não encontrado", 404);			
		}

		$worker->remove();

	}

	echo success();

});

?>