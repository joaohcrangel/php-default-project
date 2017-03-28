<?php

$app->get("/places", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$where = array();

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
			INNER JOIN tb_placesaddresses b1 ON a.idplace = b1.idplace
			INNER JOIN tb_addresses b ON b1.idaddress = b.idaddress
		    INNER JOIN tb_placestypes c ON a.idplacetype = c.idplacetype
		".$where." ORDER BY a.desplace LIMIT ?, ?;
	";

	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');

	$pagination = new Pagination(
		$query,
		array(),
		"Places",
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

	Permission::checkSession(Permission::ADMIN, true);

	$place = new Places((int)$idplace);

	echo success(array("data"=>$place->getFields()));

});

$app->get("/places/:idplace/adresses", function($idplace){

	Permission::checkSession(Permission::ADMIN, true);

	$place = new Place((int)$idplace);

	echo success(array("data"=>$place->getAdresses()->getFields()));

});

$app->get("/places/:idplace/files", function($idplace){

	Permission::checkSession(Permission::ADMIN, true);

	$place = new Place((int)$idplace);

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

	$pagination = new Pagination(
		$query,
		array(),
		"Files",
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

	Permission::checkSession(Permission::ADMIN, true);

	if(isset($_POST['idaddress'])){

		if((int)post('idaddress') > 0){
			$address = new Address((int)post('idaddress'));
		}else{
			$address = new Address();
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
			$city = new City((int)post('idcity'));
		} else {
			if (post('desuf')) {
				$city = City::loadFromName(post('descity'), post('desuf'));
			} else {
				$city = City::loadFromName(post('descity'));
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
		$place = new Place((int)post('idplace'));
	}else{
		$place = new Place();
	}

	// var_dump($place);
	// exit;

	foreach ($_POST as $key => $value) {
		$place->{'set'.$key}($value);
	}

	if(post('idplacefather') == '' || (int)$place->idplacefather() == 0) $place->setidplacefather(NULL);

	$place->save();

	if(count($address->getFields())) $place->setAddress($address);

	if(isset($_POST['vllatitude']) && isset($_POST['vllongitude'])){

		if((float)$_POST['vllatitude'] != 0 && (float)$_POST['vllongitude'] != 0){

			if($place->getidcoordinate() > 0){
				$c = new Coordinate((int)$place->getidcoordinate());
			}else{
				$c = new Coordinate();
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

$app->post("/placees/:idplace/coordinates", function($idplace){

	Permission::checkSession(Permission::ADMIN, true);

	$place = new Place((int)$idplace);

	if($place->getidcoordinate() > 0){
		$c = new Coordinate((int)$place->getidcoordinate());
	}else{
		$c = new Coordinate();
	}

	$c->set($_POST);

	$place->setCoordinate($c);

	echo success(array("data"=>$place->getFields()));

});

$app->post("/places/:idplace/files", function($idplace){

	Permission::checkSession(Permission::ADMIN, true);

	$place = new Place((int)$idplace);

	$files = Files::upload($_FILES['file']);

	pre($files->getItens());
	exit;

	foreach($files->getItens() as $file){
		$place->addFile($file);
	}

	echo success(array("data"=>$files->getFields()));

});

$app->delete("/places/:idplace", function($idplace){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idplace){
		throw new Exception("Lugar não informado", 400);		
	}

	$place = new Place((int)$idplace);

	if(!(int)$place->getidplace() > 0){
		throw new Exception("Lugar não encontrado", 404);		
	}

	$place->remove();

	echo success();

});
/////////////////////////////////////////////////////////////

// lugares tipos

$app->get("/places-types", function(){

	Permission::checkSession(Permission::ADMIN, true);

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

	$pagination = new Pagination(
        $query,
        array(),
        "PlacesTypes",
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

	Permission::checkSession(Permission::ADMIN, true);

	if(post('idplacetype') > 0){
		$placetype = new PlaceType((int)post('idplacetype'));
	}else{
		$placetype = new PlaceType();
	}

	foreach ($_POST as $key => $value) {
		$placetype->{'set'.$key}($value);
	}

	$placetype->save();

	echo success(array("data"=>$placetype->getFields()));

});

$app->delete("/places-types/:idplacetype", function($idplacetype){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idplacetype){
		throw new Exception("Tipo de lugar não informado", 400);	
	}

	$placetype = new PlaceType((int)$idplacetype);

	if(!(int)$placetype->getidplacetype() > 0){
		throw new Exception("Tipo de lugur não encontrado", 404);		
	}

	$placetype->remove();
	
	echo success();

});
////////////////////////////////////////////////////////////////

// lugares horarios

$app->post("/places-schedules", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idplace) {
		
		$place = new Place((int)$idlplace);
	
		$schedules = new PlacesSchedules();

		$nrday = explode(",", post('nrday'));
		$hropen = explode(",", post('hropen'));
		$hrclose = explode(",", post('hrclose'));

		for($i = 0; $i < count($nrday); $i++){

			$schedules->add(new PlaceSchedule(array(
				'nrday'=>$nrdia[$i],
				'hropen'=>$hropen[$i],
				'hrclose'=>$hrclose[$i]
			)));

		}

		$schedules = $place->setSchedules($schedules);

	}

	echo success(array("data"=>$schedules->getFields()));

});

?>