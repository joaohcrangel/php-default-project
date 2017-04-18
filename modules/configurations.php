<?php 

$app->get("/configurations", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $configurations = Hcode\System\Configurations::listAll();

    echo success(array(
    	'data'=>$configurations->getFields()
    ));

});

$app->post("/configurations", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if ((int)post('idconfiguration') > 0) {
		$conf = new Hcode\System\Configuration((int)post('idconfiguration'));
	} else {
		$conf = new Hcode\System\Configuration();
	}

	$conf->set($_POST);

	$conf->save();

	$configurations = Hcode\System\Configurations::listAll();
	Hcode\Session::setConfigurations($configurations);

	echo success(array(
		'data'=>$conf->getFields()
	));

});

$app->delete("/configurations/:idconfiguration", function($idconfiguration){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if (!(int)$idconfiguration > 0) {
		throw new Exception("O ID não foi informado.");		
	}

	$conf = new Hcode\System\Configuration((int)$idconfiguration);

	$conf->remove();

	$configurations = Hcode\System\Configurations::listAll();
	Hcode\Session::setConfigurations($configurations);

	echo success();

});

?>