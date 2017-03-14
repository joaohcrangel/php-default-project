<?php

$app->get("/cursos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	$where = array();

	if(get('descurso') != ''){
		array_push($where, "descurso LIKE'%".get('descurso')."%'");
	}

	if(count($where) > 0){
		$where = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
    	FROM tb_cursos ".$where." LIMIT ?, ?;
    ";

    $pagina = (int)get('pagina');

    $itemsPerPage = (int)get('limite');

    $paginacao = new Pagination(
    	$query,
    	array(),
    	"Cursos",
    	$itemsPerPage
    );

    $cursos = $paginacao->getPage($pagina);

	echo success(array(
		"data"=>$cursos->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->get("/cursos/:idcurso/secoes", function($idcurso){

	Permissao::checkSession(Permissao::ADMIN, true);

	$curso = new Curso((int)$idcurso);

	echo success(array(
		"dataSecoes"=>$curso->getSecoes()->getFields(),
		"dataCurriculos"=>$curso->getCurriculos()->getFields()
	));

});

$app->get("/cursos/:idcurso/html", function($idcurso){

	Permissao::checkSession(Permissao::ADMIN, true);

	$curso = new Curso((int)$idcurso);

	echo success(array(
		"data"=>addslashes($curso->getdesdescricao())
	));

});

$app->post("/cursos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idcurso') > 0){
		$curso = new Curso((int)post('idcurso'));
	}else{
		$curso = new Curso();
	}

	$_POST['inremovido'] = (post('inremovido') == 'true' ? true : false);

	$curso->set($_POST);

	$curso->save();

	echo success(array("data"=>$curso->getFields()));

});

$app->delete("/cursos/:idcurso", function($idcurso){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idcurso){
		throw new Exception("Curso não informado", 400);		
	}

	$curso = new Curso((int)$idcurso);

	if(!(int)$curso->getidcurso() > 0){
		throw new Exception("Curso não encontrado", 404);		
	}

	$curso->remove();

	echo success();

});
////////////////////////////////////////////////////////////////

// cursos secoes
$app->get("/cursos-secoes/:idsecao/curriculos", function($idsecao){

	Permissao::checkSession(Permissao::ADMIN, true);

	$secao = new CursoSecao((int)$idsecao);

	echo success(array("data"=>$secao->getCurriculos()->getFields()));

});

$app->post("/cursos-secoes", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idsecao') > 0){
		$secao = new CursoSecao((int)post('idsecao'));
	}else{
		$secao = new CursoSecao();
	}

	$secao->set($_POST);

	$secao->save();

	echo success(array("data"=>$secao->getFields()));

});

$app->delete("/cursos-secoes/:idsecao", function($idsecao){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idsecao){
		throw new Exception("Seção não informada", 400);		
	}

	$secao = new CursoSecao((int)$idsecao);

	if(!(int)$secao->getidsecao() > 0){
		throw new Exception("Seção não encontrada", 404);		
	}

	$secao->remove();

	echo success();

});
//////////////////////////////////////////////////////////////////

// cursos curriculos
$app->post("/cursos-curriculos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idcurriculo') > 0){
		$curriculo = new CursoCurriculo((int)post('idcurriculo'));
	}else{
		$curriculo = new CursoCurriculo();
	}

	$curriculo->set($_POST);

	$curriculo->save();

	echo success(array("data"=>$curriculo->getFields()));

});

$app->delete("/cursos-curriculos/:idcurriculo", function($idcurriculo){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idcurriculo){
		throw new Exception("Currículo não informado", 400);		
	}

	$curriculo = new CursoCurriculo((int)$idcurriculo);

	if(!(int)$curriculo->getidcurriculo() > 0){
		throw new Exception("Currículo não encontrado", 404);		
	}

	$curriculo->remove();

	echo success();

});

?>