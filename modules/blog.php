<?php

// blog authors
$app->get("/blog/authors", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$page = (int)get("page");
	$itemsPerPage = (int)get("limit");

	$where = array();

	if(get("desauthor")){
		array_push($where, "a.desauthor LIKE '%".utf8_encode(get("desauthor"))."%'");
	}

	if(count($where) > 0){
		$where = " WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.desuser FROM tb_blogauthors a
			INNER JOIN tb_users b ON a.iduser = b.iduser
		".$where." LIMIT ?, ?;
	";

	$pagination = new Pagination(
		$query,
		array(),
		"BlogAuthors",
		$itemsPerPage
	);

	$authors = $pagination->getPage($page);

	echo success(array(
		"data"=>$authors->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$page,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/blog/authors", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if((int)post("idauthor") > 0){
		$author = new BlogAuthor((int)post("idauthor"));
	}else{
		$author = new BlogAuthor();
	}

	$author->set($_POST);

	$author->save();

	echo success(array("data"=>$author->getFields()));

});

$app->delete("/blog/authors", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idauthor) {

		if(!(int)$idauthor){
			throw new Exception("Autor não informado", 400);			
		}
		
		$author = new BlogAuthor((int)$idauthor);

		if(!(int)$author->getidauthor() > 0){
			throw new Exception("Autor não encontrado", 404);			
		}

		$author->remove();

	}

	echo success();

});

// blog posts
$app->get("/blog-posts", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$page = (int)get("page");
	$itemsPerPage = (int)get("limit");

	$where = array();

	if(get("destitle") != ""){
		array_push($where, "a.destitle LIKE '%".utf8_encode(get("destitle"))."%'");
	}

	if(get("desauthor") != ""){
		array_push($where, "b.desauthor LIKE '%".utf8_encode(get("desauthor"))."%'");
	}

	if(get("dtpublished") != ""){
		array_push($where, "a.dtpublished = ".get("dtpublished")."");
	}

	if(get("idcategory")){
		array_push($where, "c.idcategory IN(".get("idcategory").")");
	}

	if(get("idtag")){
		array_push($where, "d.idtag IN(".get("idtag").")");
	}

	if(count($where) > 0){
		$where = " WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_blogposts a
			INNER JOIN tb_blogauthors b ON a.idauthor = b.idauthor
			LEFT JOIN tb_blogpostscategories c ON a.idpost = c.idpost
			LEFT JOIN tb_blogpoststags d ON a.idpost = d.idpost
		".$where." LIMIT ?, ?;
	";

	$pagination = new Pagination(
		$query,
		array(),
		"BlogPosts",
		$itemsPerPage
	);

	$posts = $pagination->getPage($page);

	echo success(array(
		"data"=>$posts->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$page,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/blog-posts", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if((int)get("idpost") > 0){
		$post = new BlogPost((int)post("idpost"));
	}else{
		$post = new BlogPost();
	}

	$post->set($_POST);

	$post->save();

	echo success(array("data"=>$post->getFields()));

});

$app->delete("/blog-posts", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idpost) {
		
		if(!(int)$idpost){
			throw new Exception("Post não informado", 400);			
		}

		$post = new BlogPost((int)$idpost);

		if(!(int)$post->getidpost() > 0){
			throw new Exception("Post não encontrado", 404);			
		}

		$post->remove();

	}

	echo success();

});

?>