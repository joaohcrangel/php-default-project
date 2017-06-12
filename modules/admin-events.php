<?php

$app->get("/".DIR_ADMIN."/events", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-right'
            )
        )
    ));

	$page->setTpl("/admin/events");

});

$app->get("/".DIR_ADMIN."/events-create", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/events-create");

});

$app->get("/".DIR_ADMIN."/events/:idevent", function($idevent){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$event = new Hcode\Stand\Event((int)$idevent);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/event", array(
		"event"=>$event->getFields()
	));

});

$app->get("/events/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	echo success(array("data"=>Hcode\Stand\Events::listAll()->getFields()));

});

$app->get("/events", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get("q") != ""){
		array_push($where, "a.desevent LIKE '%".utf8_encode(get("q"))."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where);
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.* FROM tb_events a
			LEFT JOIN tb_eventscalendars b ON a.idevent = b.idevent
		".$where." LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Stand\Events",
		$itemsPerPage
	);

	$events = $pagination->getPage($page);

	echo success(array(
		"data"=>$events->getFields(),
		"total"=>$pagination->getTotal(),
		"itemsPerPage"=>$itemsPerPage,
		"currentPage"=>$page
	));

});

$app->post("/events", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if((int)post("idevent") > 0){
		$event = new Hcode\Stand\Event((int)post("idevent"));
	}else{
		$event = new Hcode\Stand\Event();
	}

	$event->set($_POST);

	$event->save();

	echo success(array("data"=>$event->getFields()));

});

$app->delete("/events", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idevent) {
		
		if(!(int)$idevent){
			throw new Exception("Evento não informado", 400);			
		}

		$event = new Hcode\Stand\Event((int)$idevent);

		if(!(int)$event->getidevent() > 0){
			throw new Exception("Evento não encontrado", 404);			
		}

		$event->remove();

	}

	echo success();

});
/////////////////////////////////////////////////////////////////////

// events organizers
$app->get("/".DIR_ADMIN."/events-organizers", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"data"=>array(
			"body"=>array(
				"class"=>"page-aside-fixed page-aside-left"
			)
		)
	));

	$page->setTpl("/admin/events-organizers");

});

$app->get("/".DIR_ADMIN."/events-organizers-create", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/events-organizers-create");

});

$app->get("/".DIR_ADMIN."/events-organizers/:idorganizer", function($idorganizer){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$organizer = new Hcode\Stand\Event\Organizer((int)$idorganizer);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/event-organizer", array(
		"organizer"=>$organizer->getFields()
	));

});

$app->get("/events-organizers", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get("desorganizer") != ""){
		array_push($where, "desorganizer LIKE '%".utf8_encode(get("desorganizer"))."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where);
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_eventsorganizers
		".$where." LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Stand\Event\Organizers",
		$itemsPerPage
	);

	$organizers = $pagination->getPage($page);

	echo success(array(
		"data"=>$organizers->getFields(),
		"total"=>$pagination->getTotal(),
		"itemsPerPage"=>$itemsPerPage,
		"currentPage"=>$page
	));

});

$app->post("/events-organizers", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if((int)post("idorganizer") > 0){
		$organizer = new Hcode\Stand\Event\Organizer((int)post("idorganizer"));
	}else{
		$organizer = new Hcode\Stand\Event\Organizer();
	}

	$organizer->set($_POST);

	$organizer->save();

	echo success(array("data"=>$organizer->getFields()));

});

$app->delete("/events-organizers", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idorganizer) {
		
		if(!(int)$idorganizer){
			throw new Exception("Organizador não informado", 400);			
		}

		$organizer = new Hcode\Stand\Event\Organizer((int)$idorganizer);

		if(!(int)$organizer->getidorganizer() > 0){
			throw new Exception("Organizador não encontrado", 404);			
		}

		$organizer->remove();

	}

	echo success();

});
///////////////////////////////////////////////////////////

// events frequencies
$app->get("/".DIR_ADMIN."/events-frequencies", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"data"=>array(
			"body"=>array(
				"class"=>"page-aside-fixed page-aside-left"
			)
		)
	));

	$page->setTpl("/admin/events-frequencies");

});

$app->get("/".DIR_ADMIN."/events-frequencies-create", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/events-frequencies-create");

});

$app->get("/".DIR_ADMIN."/events-frequencies/:idfrequency", function($idfrequency){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$frequency = new Hcode\Stand\Event\Frequency((int)$idfrequency);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/event-frequency", array(
		"frequency"=>$frequency->getFields()
	));

});

$app->get("/events-frequencies", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get("desfrequency") != ""){
		array_push($where, "desfrequency LIKE '%".utf8_encode(get("desfrequency"))."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where);
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_eventsfrequencies
		".$where." LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Stand\Event\Frequencies",
		$itemsPerPage
	);

	$frequencies = $pagination->getPage($page);

	echo success(array(
		"data"=>$frequencies->getFields(),
		"total"=>$pagination->getTotal(),
		"itemsPerPage"=>$itemsPerPage,
		"currentPage"=>$page
	));

});

$app->post("/events-frequencies", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if((int)post("idfrequency") > 0){
		$frequency = new Hcode\Stand\Event\Frequency((int)post("idfrequency"));
	}else{
		$frequency = new Hcode\Stand\Event\Frequency();
	}

	$frequency->set($_POST);

	$frequency->save();

	echo success(array("data"=>$frequency->getFields()));

});

$app->delete("/events-frequencies", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idfrequency) {
		
		if(!(int)$idfrequency){
			throw new Exception("Dado não informado", 400);			
		}

		$frequency = new Hcode\Stand\Event\Frequency((int)$idfrequency);

		if(!(int)$frequency->getidfrequency() > 0){
			throw new Exception("Dado não encontrado", 404);			
		}

		$frequency->remove();

	}

	echo success();

});
///////////////////////////////////////////////////////////

// events calendars
$app->get("/".DIR_ADMIN."/events-calendars", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"data"=>array(
			"body"=>array(
				"class"=>"page-aside-fixed page-aside-left"
			)
		)
	));

	$page->setTpl("/admin/events-calendars");

});

$app->get("/".DIR_ADMIN."/events-calendars-create", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/events-calendars-create");

});

$app->get("/".DIR_ADMIN."/events-calendars/:idcalendar", function($idcalendar){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$calendar = new Hcode\Stand\Event\Calendar((int)$idcalendar);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/event-calendar", array(
		"calendar"=>$calendar->getFields()
	));

});

$app->get("/events-calendars", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where);
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_eventscalendars
		".$where." LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Stand\Event\Calendars",
		$itemsPerPage
	);

	$calendars = $pagination->getPage($page);

	echo success(array(
		"data"=>$calendars->getFields(),
		"total"=>$pagination->getTotal(),
		"itemsPerPage"=>$itemsPerPage,
		"currentPage"=>$page
	));

});

$app->post("/events-calendars", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if((int)post("idcalendar") > 0){
		$calendar = new Hcode\Stand\Event\Calendar((int)post("idcalendar"));
	}else{
		$calendar = new Hcode\Stand\Event\Calendar();
	}

	if(post("desurl")){

		$url = Hcode\Site\Url::checkUrl(post("desurl"), post("idurl"));

		$url->save();

		$_POST['idurl'] = $url->getidurl();

	}

	$calendar->set($_POST);

	$calendar->save();

	echo success(array("data"=>$calendar->getFields()));

});

$app->delete("/events-calendars", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idcalendar) {
		
		if(!(int)$idcalendar){
			throw new Exception("Evento não informado", 400);			
		}

		$calendar = new Hcode\Stand\Event\Calendar((int)$idcalendar);

		if(!(int)$calendar->getidcalendar() > 0){
			throw new Exception("Evento não encontrado", 404);			
		}

		$calendar->remove();

	}

	echo success();

});

?>