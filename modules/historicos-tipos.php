<?php 

$app->get('/historicos-tipos',function(){

 	$historicotipo = HistoricosTipos::listAll();

    echo success(array(
         'data'=>$historicotipo->getFields()
    ));
});

$app->post("/historicos-tipos", function(){

	if(post('idhistoricotipo') > 0){
		$historicotipo = new HistoricoTipo((int)post('idhistoricotipo'));
	}else{
		$historicotipo = new HistoricoTipo();
	}

	$historicotipo->set($_POST);

	$historicotipo->save();

	echo success(array("data"=>$historicotipo->getFields()));

});

$app->delete("/historicos-tipos/:idhistoricotipo", function($idhistoricotipo){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idhistoricotipo > 0){
		throw new Exception("Tipo de historico não informado.", 400);		
	}

	$historicotipo = new HistoricoTipo((int)$idhistoricotipo);

	$historicotipo->remove();

	echo success();

});






 
?>