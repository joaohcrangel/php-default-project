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