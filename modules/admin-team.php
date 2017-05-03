<?php

$app->get("/team/jobs-positions", function(){

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

?>