<?php

$app->get("/courses/all", function(){

	echo success(array("data"=>Hcode\Course\Courses::listAll()->getFields()));

});

$app->get("/courses", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$where = array();

	if(get('descourse') != ''){
		array_push($where, "descourse LIKE'%".get('descourse')."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
    	FROM tb_courses ".$where." LIMIT ?, ?;
    ";

    $pagina = (int)get('pagina');

    $itemsPerPage = (int)get('limite');

    $pagination = new Hcode\Pagination(
    	$query,
    	array(),
    	"Hcode\Course\Courses",
    	$itemsPerPage
    );

    $courses = $pagination->getPage($pagina);

	echo success(array(
		"data"=>$courses->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->get("/courses/:idcourse/sections", function($idcourse){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$course = new Hcode\Course\Course((int)$idcourse);

	echo success(array(
		"dataSections"=>$course->getSections()->getFields(),
		"dataCurriculums"=>$course->getCurriculums()->getFields()
	));

});

$app->get("/courses/:idcourse/html", function($idcourse){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$course = new Hcode\Course\Course((int)$idcourse);

	$course->getDescription();

	echo success(array(
		"data"=>array(
			"desdescription"=>addslashes($course->getdesdescription()),
			"deswhatlearn"=>addslashes($course->getdeswhatlearn()),
			"desrequirements"=>addslashes($course->getdesrequirements()),
			"destargetaudience"=>addslashes($course->getdestargetaudience())
		)
	));

});

$app->post("/courses", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(post('idcourse') > 0){
		$course = new Hcode\Course\Course((int)post('idcourse'));
	}else{
		$course = new Hcode\Course\Course();
	}

	$url = Hcode\Site\Url::checkUrl(post("desurl"), post("idurl"));

	$url->save();

	$_POST['inremoved'] = (post('inremoved') == 'true' ? 1 : 0);

	$date = DateTime::createFromFormat("H:m", $_POST['vlworkload']);

	$_POST['vlworkload'] = $date->format("H:m:s");

	$course->set($_POST);

	var_dump($course->getFields());
	exit;

	$course->save();

	$course->setUrl($url);

	echo success(array("data"=>$course->getFields()));

});

$app->post("/courses/:idcourse/banner", function($idcourse){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$course = new Hcode\Course\Course((int)$idcourse);

	$arquivo = $_FILES['arquivo'];

	$file = Hcode\FileSystem\File::upload(
		$arquivo['name'],
		$arquivo['type'],
		$arquivo['tmp_name'],
		$arquivo['error'],
		$arquivo['size']
	);

	$course->setBanner($file);

	echo success(array("data"=>$course->getFields()));

});

$app->post("/courses/:idcourse/brasao", function($idcourse){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$course = new Hcode\Course\Course((int)$idcourse);

	$arquivo = $_FILES['arquivo'];

	$file = Hcode\FileSystem\File::upload(
		$arquivo['name'],
		$arquivo['type'],
		$arquivo['tmp_name'],
		$arquivo['error'],
		$arquivo['size']
	);

	$course->setBrasao($file);

	echo success(array("data"=>$course->getFields()));

});

$app->delete("/courses/:idcourse", function($idcourse){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idcourse){
		throw new Exception("Curso não informado", 400);		
	}

	$course = new Hcode\Course\Course((int)$idcourse);

	if(!(int)$course->getidcourse() > 0){
		throw new Exception("Curso não encontrado", 404);		
	}

	$course->remove();

	echo success();

});
////////////////////////////////////////////////////////////////

// cursos secoes
$app->get("/courses-sections/:idsection/curriculums", function($idsection){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$section = new Hcode\Course\Section((int)$idsection);

	echo success(array("data"=>$section->getCurriculums()->getFields()));

});

$app->post("/courses-sections", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(post('idsection') > 0){
		$section = new Hcode\Course\Section((int)post('idsection'));
	}else{
		$section = new Hcode\Course\Section();
	}

	$section->set($_POST);

	$section->save();

	echo success(array("data"=>$section->getFields()));

});

$app->delete("/courses-sections/:idsection", function($idsection){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idsection){
		throw new Exception("Seção não informada", 400);		
	}

	$section = new Hcode\Course\Section((int)$idsection);

	if(!(int)$section->getidsection() > 0){
		throw new Exception("Seção não encontrada", 404);		
	}

	$section->remove();

	echo success();

});
//////////////////////////////////////////////////////////////////

// cursos curriculos
$app->post("/courses-curriculums", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(post('idcurriculum') > 0){
		$curriculum = new Hcode\Course\Curriculum((int)post('idcurriculum'));
	}else{
		$curriculum = new Hcode\Course\Curriculum();
	}

	$curriculum->set($_POST);

	$curriculum->save();

	echo success(array("data"=>$curriculum->getFields()));

});

$app->delete("/courses-curriculums/:idcurriculum", function($idcurriculum){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idcurriculum){
		throw new Exception("Currículo não informado", 400);		
	}

	$curriculum = new Hcode\Course\Curriculum((int)$idcurriculum);

	if(!(int)$curriculum->getidcurriculum() > 0){
		throw new Exception("Currículo não encontrado", 404);		
	}

	$curriculum->remove();

	echo success();

});
/////////////////////////////////

// courses instructors
$app->get("/courses/:idcourse/instructors", function($idcourse){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$course = new Hcode\Course\Course((int)$idcourse);

	echo success(array("data"=>$course->getInstructors()->getFields()));

});

$app->get("/courses/:idcourse/instructors/not", function($idcourse){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$course = new Hcode\Course\Course((int)$idcourse);

	echo success(array("data"=>$course->getInstructorsNot()->getFields()));

});

$app->post("/courses/:idcourse/instructors", function($idcourse){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idcourse){
		throw new Exception("Curso não informado", 400);		
	}

	$course = new Hcode\Course\Course((int)$idcourse);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idinstructor) {

		if(!(int)$idinstructor){
			throw new Exception("Instrutor não informado", 400);			
		}

		$instructor = new Hcode\Course\Instructor((int)$idinstructor);
		
		$course->setInstructor($instructor);

	}

	echo success(array("data"=>$course->getInstructors()->getFields()));

});

$app->delete("/courses/:idcourse/instructors", function($idcourse){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if(!(int)$idcourse){
		throw new Exception("Curso não informado", 400);
	}

	$course = new Hcode\Course\Course((int)$idcourse);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idinstructor) {

		$instructor = new Hcode\Course\Instructor((int)$idinstructor);
		
		$course->removeInstructor($instructor);

	}

	echo success();

});

?>