<?php

$app->get("/".DIR_ADMIN."/instructors", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"data"=>array(
			"body"=>array(
				"class"=>"page-aside-fixed page-aside-left"
			)
		)
	));

	$page->setTpl("/admin/instructors");

});

$app->get("/".DIR_ADMIN."/instructors/:idinstructor", function($idinstructor){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$instructor = new Hcode\Course\Instructor((int)$idinstructor);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/instructor", array(
		"instructor"=>$instructor->getFields(),
		"desbiography"=>addslashes($instructor->getBiography()->getdesbiography())
	));

});

$app->get("/".DIR_ADMIN."/instructor-create", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/instructor-create");

});

$app->get("/instructors/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get("desperson") != ""){
		array_push($where, "b.desperson LIKE '%".utf8_encode(get("desperson"))."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.desperson, CONCAT(d.desdirectory, d.desfile, '.', d.desextension) AS desphoto FROM tb_instructors a
			INNER JOIN tb_persons b ON a.idperson = b.idperson
			LEFT JOIN tb_coursesinstructors e ON a.idinstructor = e.idinstructor
			LEFT JOIN tb_courses c ON e.idcourse = c.idcourse
			INNER JOIN tb_files d ON a.idphoto = d.idfile
		".$where." GROUP BY a.idinstructor LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Course\Instructors",
		$itemsPerPage
	);

	$instructors = $pagination->getPage($page);

	echo success(array(
		"data"=>$instructors->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$page,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/instructors", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if((int)post("idinstructor")){
		$instructor = new Hcode\Course\Instructor((int)post("idinstructor"));
	}else{
		$instructor = new Hcode\Course\Instructor();
	}

	$person = new Hcode\Person\Person(array(
		"desperson"=>post("desperson"),
		"idpersontype"=>Hcode\Person\Type::FISICA
	));

	$person->save();

	$_POST['idperson'] = $person->getidperson();

	$instructor->set($_POST);

	$instructor->save();

	if(isset($_POST['idcourse'])){

		$course = new Hcode\Course\Course((int)post("idcourse"));

		$course->setInstructor($instructor);

	}

	echo success(array("data"=>$instructor->getFields()));

});

$app->post("/instructors/:idinstructor/photo", function($idinstructor){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$files = Hcode\FileSystem\Files::upload($_FILES["arquivo"]);

    $file = $files->getFirst();

	$instructor = new Hcode\Course\Instructor((int)$idinstructor);

	$instructor->setidphoto($file->getidfile());

	$instructor->save();

	echo success(array("data"=>$file->getFields()));

});

$app->delete("/instructors", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idinstructor) {
		
		if(!(int)$idinstructor){
			throw new Exception("Instrutor não informado", 400);			
		}

		$instructor = new Hcode\Course\Instructor((int)$idinstructor);

		if(!(int)$instructor->getidinstructor() > 0){
			throw new Exception("Instrutor não encontrado", 404);			
		}

		$instructor->remove();

	}

	echo success();

});

?>