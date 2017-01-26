<?php 
 $app->get("/enderecostipos",function(){

   $endereco = EnderecosTipos::listAll();
    echo success(array(
     "data"=> $endereco->getFields()
   	));

 });

 $app->post("/".DIR_ADMIN."/enderecos", function(){

 	Permissao::checkSession(Permissao::ADMIN, true);

 	if(post('idendereco') > 0){
 		$endereco = new Endereco((int)post('idendereco'));
 	}else{
 		$endereco = new Endereco();
 	}

 	foreach ($_POST as $key => $value) {
 		$endereco->{'set'.$key}($value);
 	}

 	$endereco->save();

 	echo success(array("data"=>$endereco->getFields()));

 });

 $app->delete("/".DIR_ADMIN."/enderecos/:idendereco", function($idendereco){

 	Permissao::checkSession(Permissao::ADMIN, true);

 	if(!(int)$idendereco){
 		throw new Exception("Endereço nãoo informado", 400); 		
 	}

 	$endereco = new Endereco((int)$idendereco);

 	if(!(int)$endereco->getidendereco() > 0){
 		throw new Exception("Endereço não encontrado", 404); 		
 	}

 	$endereco->remove();

 	echo success();

 });

 ?>