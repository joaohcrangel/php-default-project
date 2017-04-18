<?php

$app->get("/public/blog-posts", function(){

	$page = (int)get("page");
	$itemsPerPage = (int)get("limit");

	$where = array();

	array_push($where, "a.dtpublished <= NOW()");

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

	echo success(array(
		"data"=>$posts->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$page,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->get("/public/blog-categories", function(){

	echo success(array("data"=>Hcode\Site\Blog\Categories::listAll()->getFields()));

});

$app->get("/blog/categories/:desurl", function($desurl){

	$sql = new Hcode\Sql();

	$data = $sql->query("CALL sp_blogcategorybyurl_get(?);", array(
		$desurl
	));

	if(isset($data[0])){

		$category = new Hcode\Site\Blog\Category($data[0]);

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
			"BlogPosts",		
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


		// function getCommentsHTML(BlogComment $commentFather, BlogComments $commentsAll){

		// 	$roots = $commentsAll->filter('idcommentfather', $commentFather->getidmenu());

		// 	$html = '';

		// 	if($roots->getSize() > 0){

		// 		$html = '<ul>';

		// 		$html .= '</ul>';

		// 	}

		// 	pre($html);
		// 	exit;

		// 	return $html;

		// }

		// foreach ($post->getComments()->getItens() as $comment) {
		// 	getCommentsHTML($comment, $post->getComments());
		// };

		$post->setTags($post->getTags());

		$page = new Hcode\Site\Page();

		$page->setTpl("blog-post", array(
			"post"=>$post->getFields(),
			"categories"=>$categories
		));

	}

});

$app->post("/blog/comment", function(){

	$person = new Person(array(
		"desperson"=>post("desperson"),
		"idpersontype"=>PersonType::FISICA,
		"desemail"=>post("desemail")
	));

	$person->save();

});

?>