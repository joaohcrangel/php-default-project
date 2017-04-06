<?php 

$app->get("/configurations", function(){

    Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

    $configurations = Configurations::listAll();

    echo success(array(
    	'data'=>$configurations->getFields()
    ));

});

$app->post("/configurations", function(){

	Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

	if ((int)post('idconfiguration') > 0) {
		$conf = new Configuration((int)post('idconfiguration'));
	} else {
		$conf = new Configuration();
	}

	$conf->set($_POST);

	$conf->save();

	$configurations = Configurations::listAll();
	Hcode\Session::setConfigurations($configurations);

	echo success(array(
		'data'=>$conf->getFields()
	));

});

$app->delete("/configurations/:idconfiguration", function($idconfiguration){

	Hcode\Permission::checkSession(Hcode\Permission::ADMIN, true);

	if (!(int)$idconfiguration > 0) {
		throw new Exception("O ID não foi informado.");		
	}

	$conf = new Configuration((int)$idconfiguration);

	$conf->remove();

	$configurations = Configurations::listAll();
	Hcode\Session::setConfigurations($configurations);

	echo success();

});

?>