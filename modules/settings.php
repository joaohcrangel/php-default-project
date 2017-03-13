<?php 

$app->get("/settings", function(){

    Permission::checkSession(Permission::ADMIN, true);

    $settings = Settings::listAll();

    echo success(array(
    	'data'=>$settings->getFields()
    ));

});

$app->post("/settings", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if ((int)post('idsetting') > 0) {
		$conf = new Setting((int)post('idsetting'));
	} else {
		$conf = new Setting();
	}

	$conf->set($_POST);

	$conf->save();

	$settings = Settings::listAll();
	Session::setSettings($settings);

	echo success(array(
		'data'=>$conf->getFields()
	));

});

$app->delete("/settings/:idsetting", function($idsetting){

	Permission::checkSession(Permission::ADMIN, true);

	if (!(int)$idsetting > 0) {
		throw new Exception("O ID não foi informado.");		
	}

	$conf = new Setting((int)$idsetting);

	$conf->remove();

	$settings = Settings::listAll();
	Session::setS
	ettings($settings);

	echo success();

});

?>