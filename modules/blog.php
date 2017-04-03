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
		array_push($where, "a.dtpublished = '".get("dtpublished")."'");
	}

	if(get("idsCategories")){
		array_push($where, "c.idcategory IN(".get("idcategory").")");
	}

	if(get("idsTags")){
		array_push($where, "d.idtag IN(".get("idtag").")");
	}

	if(count($where) > 0){
		$where = " WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.desauthor FROM tb_blogposts a
			INNER JOIN tb_blogauthors b ON a.idauthor = b.idauthor
			LEFT JOIN tb_blogpostscategories c ON a.idpost = c.idpost
			LEFT JOIN tb_blogpoststags d ON a.idpost = d.idpost
		".$where." GROUP BY a.idpost LIMIT ?, ?;
	";

	// pre($query);
	// exit;

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

// blog comments
$app->get("/blog-comments", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$page = (int)get("page");
	$itemsPerPage = (int)get("limit");

	$where = array();

	if(get("despost") != ""){
		array_push($where, "b.despost LIKE '%".utf8_encode(get("despost"))."%'");
	}

	if(get("desperson") != ""){
		array_push($where, "c.desperson LIKE '%".utf8_encode(get("desperson"))."%'");
	}

	if(count($where) > 0){
		$where = " WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_blogcomments a
			INNER JOIN tb_posts b ON a.idpost = b.idpost
			INNER JOIN tb_persons c ON a.idperson = c.idperson
		".$where." LIMIT ?, ?;
	";


	$pagination = new Pagination(
		$query,
		array(),
		"BlogComments",
		$itemsPerPage
	);

	$comments = $pagination->getPage($page);

	echo success(array(
		"data"=>$comments->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$page,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/blog-comments", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if((int)post("idcomment") > 0){
		$comment = new BlogComment((int)post("idcomment"));
	}else{
		$comment = new BlogComment();
	}

	$comment->set($_POST);

	$comment->save();

	echo success(array("data"=>$comment->getFields()));

});

$app->delete("/blog-comments", function(){

	Permission::checkSession(Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	foreach ($ids as $idcomment) {
			
		if(!(int)$idcomment){
			throw new Exception("Comentário não informado", 400);			
		}

		$comment = new BlogComment((int)$idcomment);

		if(!(int)$comment->getidcomment() > 0){
			throw new Exception("Comentário não encontrado", 404);			
		}

		$comment->remove();

	}

	echo success();

});

// blog categories
$app->get("/blog-categories/all", function(){

	Permission::checkSession(Permission::ADMIN, true);

	echo success(array("data"=>BlogCategories::listAll()->getFields()));

});

// blog tags
$app->get("/blog-tags/all", function(){

	Permission::checkSession(Permission::ADMIN, true);

	echo success(array("data"=>BlogTags::listAll()->getFields()));

});

?>