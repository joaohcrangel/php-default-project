<?php

$app->get("/places/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	echo success(array("data"=>Hcode\Place\Places::listAll()->getFields()));

});

$app->get("/places", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$where = array();

	if(get("q") != ""){
		array_push($where, "a.desplace LIKE '%".utf8_decode(get('q'))."%'");
	}

	if(isset($_GET['desplace']) && $_GET['desplace'] != ""){
		array_push($where, "a.desplace LIKE '%".utf8_decode(get('desplace'))."%'");
	}

	if(isset($_GET['desaddress']) && $_GET['desaddress'] != ""){
		array_push($where, "b.desaddress LIKE '%".utf8_decode(get('desaddress'))."%'");
	}

	if(isset($_GET['idplacetype'])){
		array_push($where, "c.idplacetype = ".(int)get('idplacetype'));
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where);
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.desaddress, c.desplacetype FROM tb_places a
			LEFT JOIN tb_placesaddresses b1 ON a.idplace = b1.idplace
			LEFT JOIN tb_addresses b ON b1.idaddress = b.idaddress
		    INNER JOIN tb_placestypes c ON a.idplacetype = c.idplacetype
		".$where." ORDER BY a.desplace LIMIT ?, ?;
	";

	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Place\Places",
		$itemsPerPage
	);

	$places = $pagination->getPage($pagina);

	echo success(array(
		"data"=>$places->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->get("/places/:idplace", function($idplace){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$place = new Hcode\Place\Places((int)$idplace);

	echo success(array("data"=>$place->getFields()));

});

$app->get("/places/:idplace/addresses", function($idplace){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$place = new Hcode\Place\Place((int)$idplace);

	echo success(array("data"=>$place->getAddresses()->getFields()));

});

$app->get("/places/:idplace/files", function($idplace){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$place = new Hcode\Place\Place((int)$idplace);

	$where = array();

	array_push($where, "b.idplace = ".$place->getidplace()."");

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where);
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.desplace FROM tb_files a
			INNER JOIN tb_placesfiles c ON a.idfile = c.idfile
	        INNER JOIN tb_places b ON c.idplace = b.idplace
	    ".$where." LIMIT ?, ?;
	";

	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limit');

	// pre($query);
	// exit;

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\FileSystem\Files",
		$itemsPerPage
	);

	$files = $pagination->getPage($pagina);

	echo success(array(
		"data"=>$files->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/places", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(isset($_POST['idaddress'])){

		if((int)post('idaddress') > 0){
			$address = new Hcode\Address\Address((int)post('idaddress'));
		}else{
			$address = new Hcode\Address\Address();
		}

		foreach (array(
			'idaddresstype',
			'descep',
			'desaddress',
			'desnumber',
			'descomplement',
			'desdistrict',
			'descity'
		) as $field) {
			if (isset($_POST[$field]) && post($field)) {
				$address->{'set'.$field}(post($field));
			}	
		}

		if (isset($_POST['idcity']) && (int)post('idcity') > 0) {
			$city = new Hcode\Address\City((int)post('idcity'));
		} else {
			if (post('desuf')) {
				$city = Hcode\Address\City::loadFromName(post('descity'), post('desuf'));
			} else {
				$city = Hcode\Address\City::loadFromName(post('descity'));
			}
		}

		if (count($city->getFields())) $address->set($city->getFields());

		if (count($address->getFields())) {

			$address->setinmain(true);

			$address->save();

		}

		$_POST['idaddress'] = $address->getidaddress();

	}

	if(post('idplace') > 0){
		$place = new Hcode\Place\Place((int)post('idplace'));
	}else{
		$place = new Hcode\Place\Place();
	}

	foreach ($_POST as $key => $value) {
		$place->{'set'.$key}($value);
	}

	if(post('idplacefather') == '' || (int)$place->idplacefather() == 0) $place->setidplacefather(NULL);

	$place->save();

	if(count($address->getFields())) $place->setAddress($address);

	if(isset($_POST['vllatitude']) && isset($_POST['vllongitude'])){

		if((float)$_POST['vllatitude'] != 0 && (float)$_POST['vllongitude'] != 0){

			if($place->getidcoordinate() > 0){
				$c = new Hcode\Address\Coordinate((int)$place->getidcoordinate());
			}else{
				$c = new Hcode\Address\Coordinate();
			}

			$c->setvllatitude((float)post('vllatitude'));
			$c->setvllongitude((float)post('vllongitude'));
			$c->setnrzoom((float)post('nrzoom'));

			$c->save();

			$place->setCoordinate($c);

		}

	}

	echo success(array("data"=>$place->getFields()));

});

$app->post("/places/:idplace/coordinates", function($idplace){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$place = new Hcode\Place\Place((int)$idplace);

	if($place->getidcoordinate() > 0){
		$c = new Hcode\Address\Coordinate((int)$place->getidcoordinate());
	}else{
		$c = new Hcode\Address\Coordinate();
	}

	$c->set($_POST);

	$place->setCoordinate($c);

	echo success(array("data"=>$place->getFields()));

});

$app->post("/places/:idplace/files", function($idplace){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$place = new Hcode\Place\Place((int)$idplace);

	$files = Hcode\FileSystem\Files::upload($_FILES['arquivo']);

	foreach($files->getItens() as $file){
		$place->addFile($file);
	}

	echo success(array("data"=>$files->getFields()));

});

$app->post("/places/:idplace/addresses/:idaddress", function($idplace, $idaddress){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

});

$app->delete("/places/:idplace", function($idplace){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idplace){
		throw new Exception("Lugar não informado", 400);		
	}

	$place = new Hcode\Place\Place((int)$idplace);

	if(!(int)$place->getidplace() > 0){
		throw new Exception("Lugar não encontrado", 404);		
	}

	$place->remove();

	echo success();

});
/////////////////////////////////////////////////////////////

// lugares tipos

$app->get("/places-types", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('desplacetype')) {
		array_push($where, "desplacetype LIKE '%".utf8_decode(get('desplacetype'))."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AND ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_placestypes
	".$where." LIMIT ?, ?;";

	$pagination = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\Place\Types",
        $itemsPerPage
    );

	 $placestypes = $pagination->getPage($currentPage);

	echo success(array(
		"data"=> $placestypes->getFields(),
		"currentPage"=>$currentPage,
		"itemsPerPage"=>$itemsPerPage,
		"total"=>$pagination->getTotal(),
	));
});

$app->post("/places-types", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(post('idplacetype') > 0){
		$placetype = new Hcode\Place\Type((int)post('idplacetype'));
	}else{
		$placetype = new Hcode\Place\Type();
	}

	foreach ($_POST as $key => $value) {
		$placetype->{'set'.$key}($value);
	}

	$placetype->save();

	echo success(array("data"=>$placetype->getFields()));

});

$app->delete("/places-types/:idplacetype", function($idplacetype){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idplacetype){
		throw new Exception("Tipo de lugar não informado", 400);	
	}

	$placetype = new Hcode\Place\Type((int)$idplacetype);

	if(!(int)$placetype->getidplacetype() > 0){
		throw new Exception("Tipo de lugur não encontrado", 404);		
	}

	$placetype->remove();
	
	echo success();

});
////////////////////////////////////////////////////////////////

// lugares horarios

$app->post("/places-schedules", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idplace) {
		
		$place = new Hcode\Place\Place((int)$idplace);
	
		$schedules = new Hcode\Place\Schedules();

		$nrday = explode(",", post('nrday'));
		$hropen = explode(",", post('hropen'));
		$hrclose = explode(",", post('hrclose'));

		for($i = 0; $i < count($nrday); $i++){

			$schedules->add(new Hcode\Place\Schedule(array(
				'nrday'=>$nrday[$i],
				'hropen'=>$hropen[$i],
				'hrclose'=>$hrclose[$i]
			)));

		}

		$schedules = $place->setSchedules($schedules);

	}

	echo success(array("data"=>$schedules->getFields()));

});

?>