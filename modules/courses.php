<?php

$app->get("/courses", function(){

	Permission::checkSession(Permission::ADMIN, true);

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

    $pagination = new Pagination(
    	$query,
    	array(),
    	"Courses",
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

	Permission::checkSession(Permission::ADMIN, true);

	$course = new Course((int)$idcourse);

	echo success(array(
		"dataSections"=>$course->getSections()->getFields(),
		"dataCurriculum"=>$course->getCurriculum()->getFields()
	));

});

$app->get("/courses/:idcourse/html", function($idcourse){

	Permission::checkSession(Permission::ADMIN, true);

	$course = new Course((int)$idcourse);

	echo success(array(
		"data"=>addslashes($course->getdesdescricao())
	));

});

$app->post("/courses", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if(post('idcourse') > 0){
		$course = new Course((int)post('idcourse'));
	}else{
		$course = new Course();
	}

	$_POST['inremoved'] = (post('inremoved') == 'true' ? true : false);

	$course->set($_POST);

	$course->save();

	echo success(array("data"=>$course->getFields()));

});

$app->delete("/courses/:idcourse", function($idcourse){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idcourse){
		throw new Exception("Curso não informado", 400);		
	}

	$course = new Course((int)$idcourse);

	if(!(int)$course->getidcourse() > 0){
		throw new Exception("Curso não encontrado", 404);		
	}

	$course->remove();

	echo success();

});
////////////////////////////////////////////////////////////////

// cursos secoes
$app->get("/courses-sections/:idsection/curriculums", function($idsection){

	Permission::checkSession(Permission::ADMIN, true);

	$section = new CourseSection((int)$idsection);

	echo success(array("data"=>$section->getCurriculums()->getFields()));

});

$app->post("/courses-sections", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if(post('idsection') > 0){
		$section = new CourseSection((int)post('idsection'));
	}else{
		$section = new CourseSection();
	}

	$section->set($_POST);

	$section->save();

	echo success(array("data"=>$section->getFields()));

});

$app->delete("/courses-sections/:idsection", function($idsection){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idsection){
		throw new Exception("Seção não informada", 400);		
	}

	$section = new CourseSection((int)$idsection);

	if(!(int)$Section->getidSection() > 0){
		throw new Exception("Seção não encontrada", 404);		
	}

	$section->remove();

	echo success();

});
//////////////////////////////////////////////////////////////////

// cursos curriculos
$app->post("/courses-curriculums", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if(post('idcurriculum') > 0){
		$curriculum = new CoursoCurriculum((int)post('idcurriculum'));
	}else{
		$curriculum = new CoursoCurriculum();
	}

	$curriculum->set($_POST);

	$curriculum->save();

	echo success(array("data"=>$curriculum->getFields()));

});

$app->delete("/courses-curriculums/:idcurriculum", function($idcurriculum){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idcurriculum){
		throw new Exception("Currículo não informado", 400);		
	}

	$curriculum = new CoursoCurriculum((int)$idcurriculum);

	if(!(int)$curriculum->getidcurriculum() > 0){
		throw new Exception("Currículo não encontrado", 404);		
	}

	$curriculum->remove();

	echo success();

});

?>