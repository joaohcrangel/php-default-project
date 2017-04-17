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

	$user = Session::getUser();

	$sql = new Sql();

	$data = $sql->query("
		SELECT * FROM tb_blogauthors WHERE iduser = ?
	", array(
		$user->getiduser()
	));

	if(count($data) > 0){
		$_POST['idauthor'] = $data[0]['idauthor'];
	}else{

		$person = $user->getPerson();

		$author = new BlogAuthor(array(
			"iduser"=>$user->getiduser(),
			"desauthor"=>$person->getdesperson()
		));

		$author->save();

		$_POST['idauthor'] = $author->getidauthor();

	}

	if(post("desurl")){

		$sql = new Sql();

		if(post("idurl") > 0){

			$url = new Url((int)post("idurl"));

			$urls = $sql->query("SELECT * FROM tb_urls WHERE desurl = ?;", array(
				post("desurl")
			));

			if(count($urls) > 0){
				$urls2 = $sql->query("SELECT * FROM tb_urls WHERE desurl = ? AND idurl = ?;", array(
					post("desurl"),
					post("idurl")
				));

				if(!count($urls2) > 0){
					throw new Exception("Essa URL já existe", 400);					
				}
			}

		}else{

			$url = new Url(array(
				"desurl"=>post("desurl")
			));

			$urls = $sql->query("SELECT * FROM tb_urls WHERE desurl = ?", array(
				post("desurl")
			));

			if(count($urls) > 0){
				throw new Exception("A URL informada já existe", 400);			
			}

		}	

		$url->save();

		$_POST['idurl'] = $url->getidurl();

	}

	if(post("descontentshort") == ""){
		$_POST['descontentshort'] = strip_tags(substr(post("descontent"), 0, 256));
	}

	$_POST['intrash'] = (isset($_POST['intrash']) && $_POST['intrash'] === '1') ? true : false;

	if(isset($_POST['idcover']) && $_POST['idcover'] == 0) $_POST['idcover'] = NULL;

	$post->set($_POST);

	$post->save();

	if($_POST['idsCategories']){

		$idsCategories = explode(",", post("idsCategories"));

		foreach ($idsCategories as $idcategory) {

			$category = new BlogCategory((int)$idcategory);
			
			$post->addCategory($category);

		}
	}

	if($_POST['idsTags']){

		$idsTags = explode(",", post("idsTags"));

		foreach ($idsTags as $idtag) {

			$tag = new BlogTag((int)$idtag);
			
			$post->addTag($tag);

		}
	}

	echo success(array("data"=>$post->getFields()));

});

$app->post("/blog-posts/:idpost/tags", function($idpost){

	Permission::checkSession(Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	$post = new BlogPost((int)$idpost);

	$post->removeTags();

	foreach($ids as $idtag){

		$tag = new BlogTag((int)$idtag);

		$post->addTag($tag);

	}

	echo success(array("data"=>$post->getFields()));

});

$app->post("/blog-posts/:idpost/categories", function($idpost){

	Permission::checkSession(Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	$post = new BlogPost((int)$idpost);

	$post->removeCategories();

	foreach($ids as $idcategory){

		$category = new BlogCategory((int)$idcategory);

		$post->addCategory($category);

	}

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

	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('descategory')) {
		array_push($where, "descategory LIKE '%".utf8_encode(get('descategory'))."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AND ', $where);
	} else {
		$where = '';
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.desurl FROM tb_blogcategories a
			INNER JOIN tb_urls b ON a.idurl = b.idurl
	".$where." LIMIT ?, ?;";

	$pagination = new Pagination(
        $query,
        array(),
        "BlogCategories",
        $itemsPerPage
    );

    $category = $pagination->getPage($currentPage);

    echo success(array(
    	"data"=>$category->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));
});

$app->get("/blog-categories/:idcategory/posts", function($idcategory){

	$page = (int)get("page");
	$itemsPerPage = (int)get("limit");

	$where = array();

	array_push($where, "c.idcategory = ".(int)$idcategory);

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

	$pagination = new Pagination(
		$query,
		array(),
		"BlogPosts",		
		$itemsPerPage
	);

	$posts = $pagination->getPage($page);

	echo success(array(
		"data"=>$posts->getFields(),
		"currentPage"=>$page,
		"total"=>$pagination->getTotal(),
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/blog-categories", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if(post("idcategory") > 0){
		$category = new BlogCategory((int)post("idcategory"));
	}else{
		$category = new BlogCategory();
	}

	$category->set($_POST);

	if(isset($_POST['desurl'])){

		$url = new Url(array(
			"desurl"=>post("desurl")
		));

		$url->save();

		$category->setidurl($url->getidurl());

	}

	$category->save();

	echo success(array("data"=>$category->getFields()));

});

$app->delete("/blog-categories/:idcategory", function($idcategory){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idcategory > 0){
		throw new Exception("categoria não informado.", 400);		
	}

	$category = new BlogCategory((int)$idcategory);

	$category->remove();

	echo success();

});

// blog tags
$app->get("/blog-tags/all", function(){

	$tag = BlogTags::listAll();

	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('destag')) {
		array_push($where, "destag LIKE '%".get('destag')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AND ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_blogtags
	".$where." limit ?, ?;";

	$pagination = new Pagination(
        $query,
        array(),
        "BlogTags",
        $itemsPerPage
    );

    $tag = $pagination->getPage($currentPage);

    echo success(array(
    	"data"=>$tag ->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));

});

$app->post("/blog-tags", function(){

	Permission::checkSession(Permission::ADMIN, true);

	if(post("idtag") > 0){
		$tag = new BlogTag((int)post("idtag"));
	}else{
		$tag = new BlogTag();
	}

	$tag->set($_POST);

	$tag->save();

	echo success(array("data"=>$tag->getFields()));

});

$app->delete("/blog-tags/:idtag", function($idtag){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idtag > 0){
		throw new Exception("Tag não informado.", 400);		
	}

	$tag = new BlogTag((int)$idtag);

	$tag->remove();

	echo success();

});
 /*
///fazer o administrativo do
 
 ("blogcategories")
 ("blogtags")
*/
?>
