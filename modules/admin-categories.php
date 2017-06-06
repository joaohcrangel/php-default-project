<?php

$app->get("/".DIR_ADMIN."/categories", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"data"=>array(
			"body"=>array(
				"class"=>"page-aside-fixed page-aside-left"
			)
		)
	));

	$page->setTpl("/admin/categories");

});

$app->get("/".DIR_ADMIN."/categories/:idcategory", function($idcategory){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$category = new Hcode\Site\Category((int)$idcategory);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/category", array(
		"category"=>$category->getFields()
	));

});

$app->get("/".DIR_ADMIN."/category-create", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = new Hcode\Admin\Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("/admin/category-create");

});

$app->get("/categories", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get("descategory") != ""){
		array_push($where, "descategory LIKE '%".utf8_encode(get("descategory"))."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where);
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_categories
		".$where." LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Site\Categories",
		$itemsPerPage
	);

	$categories = $pagination->getPage($page);

	echo success(array(
		"data"=>$categories->getFields(),
		"total"=>$pagination->getTotal(),
		"page"=>$page,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->get("/categories/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	echo success(array("data"=>Hcode\Site\Categories::listAll()->getFields()));

});

$app->post("/categories", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if((int)post("idcategory") > 0){
		$category = new Hcode\Site\Category((int)post("idcategory"));
	}else{
		$category = new Hcode\Site\Category();
	}

	$category->set($_POST);

	if($category->getidcategoryfather() == 0){
		$category->setidcategoryfather(NULL);
	}

	$category->save();

	echo success(array("data"=>$category->getFields()));

});

$app->delete("/categories", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idcategory) {
		
		if(!(int)$idcategory){
			throw new Exception("Categoria não informada", 400);			
		}

		$category = new Hcode\Site\Category((int)$idcategory);

		if(!(int)$category->getidcategory() > 0){
			throw new Exception("Categoria não encontrada", 404);			
		}

		$category->remove();

	}

	echo success();

});

?>