<?php

$app->get("/public/blog-categories", function(){

	echo success(array("data"=>Hcode\Site\Blog\Categories::listAll()->getFields()));

});

$app->get("/blog/categories/:desurl", function($desurl){

	$sql = new Hcode\Sql();

	$data = $sql->query("CALL sp_blogcategorybyurl_get(?);", array(
		$desurl
	));

	if(isset($data[0])){

		$category = new Hcode\Site\Blog\Categories($data[0]);


		$page = (int)get("page");
		$itemsPerPage = (int)get("limit");

		$where = array();

		array_push($where, "c.idcategory = ".$category->getidcategory());

		if(count($where) > 0){
			$where = " WHERE ".implode(" AND ", $where);
		}else{
			$where = "";
		}

		$query = "
			SELECT SQL_CALC_FOUND_ROWS a.*, b.desauthor, f.desurl, CONCAT(e.desdirectory, e.desfile, '.', e.desextension) AS descover, 
				(
					SELECT COUNT(idcomment) FROM tb_blogcomments WHERE idpost = a.idpost
				) AS nrcomments,
				(
					SELECT GROUP_CONCAT(b.destag)
					FROM tb_blogpoststags a
					LEFT JOIN tb_blogtags b ON a.idtag = b.idtag
					WHERE idpost = a.idpost
				) AS destags FROM tb_blogposts a
				INNER JOIN tb_blogauthors b ON a.idauthor = b.idauthor
				LEFT JOIN tb_blogpostscategories c ON a.idpost = c.idpost
				LEFT JOIN tb_blogpoststags d ON a.idpost = d.idpost
	            LEFT JOIN tb_files e ON a.idcover = e.idfile
	            LEFT JOIN tb_urls f ON a.idurl = f.idurl
	            LEFT JOIN tb_blogcomments g ON a.idpost = g.idpost
	        ".$where." GROUP BY a.idpost LIMIT ?, ?;
		";

		$pagination = new Hcode\Pagination(
			$query,
			array(),
			"Hcode\Site\Blog\Posts",		
			$itemsPerPage
		);

		$posts = $pagination->getPage($page);

		$categories = Hcode\Site\Blog\Categories::listAll()->getFields();

		$page = new Hcode\Site\Page();

		$page->setTpl("blog-category", array(
			"category"=>$category->getFields(),
			"posts"=>$posts->getFields(),
			"currentPage"=>$page,
			"total"=>$pagination->getTotal(),
			"itemsPerPage"=>$itemsPerPage,
			"categories"=>$categories
		));

	}

});

$app->get("/blog/search", function(){

	$page = (int)get("page");

	$itemsPerPage = (int)get("limit");

	$where = array();

	array_push($where, "a.destitle LIKE '%".utf8_encode(get("despost"))."%'");

	if(count($where) > 0){
		$where = " WHERE ".implode(" AND ", $where);
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.desauthor, f.desurl, CONCAT(e.desdirectory, e.desfile, '.', e.desextension) AS descover, 
			(
				SELECT COUNT(idcomment) FROM tb_blogcomments WHERE idpost = a.idpost
			) AS nrcomments,
			(
				SELECT GROUP_CONCAT(b.destag)
				FROM tb_blogpoststags a
				LEFT JOIN tb_blogtags b ON a.idtag = b.idtag
				WHERE idpost = a.idpost
			) AS destags FROM tb_blogposts a
			INNER JOIN tb_blogauthors b ON a.idauthor = b.idauthor
			LEFT JOIN tb_blogpostscategories c ON a.idpost = c.idpost
			LEFT JOIN tb_blogpoststags d ON a.idpost = d.idpost
            LEFT JOIN tb_files e ON a.idcover = e.idfile
            LEFT JOIN tb_urls f ON a.idurl = f.idurl
            LEFT JOIN tb_blogcomments g ON a.idpost = g.idpost
        ".$where." GROUP BY a.idpost LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Site\Blog\Posts",
		$itemsPerPage
	);

	$posts = $pagination->getPage($page);

	foreach ($posts->getFields() as $post) {
	
		$post['desdtpublished'] = strftime("%d de %B de %Y", strtotime($post['desdtpublished']));

	}

	$page = new Hcode\Site\Page();

	$page->setTpl("blog-search", array(
		"posts"=>$posts->getFields(),
		"currentPage"=>$page,
		"total"=>$pagination->getTotal(),
		"itemsPerPage"=>$itemsPerPage,
		"get"=>$_GET,
		"categories"=>Hcode\Site\Blog\Categories::listAll()->getFields()
	));

});

$app->get("/blog/:desurl", function($desurl){

	$sql = new Hcode\Sql();

	$data = $sql->query("CALL sp_blogpostbyurl_get(?);", array(
		$desurl
	));

	if(isset($data[0])){

		$post = new Hcode\Site\Blog\Post($data[0]);

		$categories = Hcode\Site\Blog\Categories::listAll()->getFields();

		$post->setTags($post->getTags());

		$root = new Hcode\Site\Blog\Comment(array("idcomment"=>0));
		
		$commentsHTML = Hcode\Site\Blog\Comment::getCommentsHTML($root, $post->getComments());

		$page = new Hcode\Site\Page();

		$page->setTpl("blog-post", array(
			"post"=>$post->getFields(),
			"categories"=>$categories,
			"comments"=>$commentsHTML
		));

	}

});

$app->get("/blog/images/world-map.png", function(){

	echo success(array("data"=>Hcode\Site\Blog::listAll()->getFields()));

});

$app->post("/blog/comments", function(){

	$person = new Hcode\Person\Person(array(
		"desperson"=>post("desperson"),
		"idpersontype"=>Hcode\Person\Type::FISICA,
		"desemail"=>post("desemail")
	));

	$person->save();

	$comment = new Hcode\Site\Blog\Comment(array(
		"descomment"=>post("descomment"),
		"idperson"=>$person->getidperson(),
		"idpost"=>post("idpost"),
		"inapproved"=>false
	));

	$comment->save();

	echo success();

});


$app->get("/blog/authors/:desauthor", function($desauhtor){

	$author = Hcode\Site\Blog\Author::getByAuthor($desauhtor);

	if($author){

		$page = new Hcode\Site\Page();

		$page->setTpl("blog-author", array(
			"author"=>$author->getFields(),
			"posts"=>$author->getPosts()->getFields(),
			"categories"=>Hcode\Site\Blog\Categories::listAll()->getFields()
		));

	}

});

?>