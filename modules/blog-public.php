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
		SELECT SQL_CALC_FOUND_ROWS a.*, b.desauthor, f.desurl, CONCAT(e.desdirectory, e.desfile, '.', e.desextension) AS descover FROM tb_blogposts a
			INNER JOIN tb_blogauthors b ON a.idauthor = b.idauthor
			LEFT JOIN tb_blogpostscategories c ON a.idpost = c.idpost
			LEFT JOIN tb_blogpoststags d ON a.idpost = d.idpost
            LEFT JOIN tb_files e ON a.idcover = e.idfile
            LEFT JOIN tb_urls f ON a.idurl = f.idurl
		".$where." GROUP BY a.idpost LIMIT ?, ?;
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

?>