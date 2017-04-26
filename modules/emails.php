<?php 

$app->get("/emails", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$q = get("q");
	$where = array();
	$params = array();
	foreach ($_GET as $key => $value) {
		
		if (get($key) && !in_array($key, array('pagina', 'limite'))) {
			array_push($where, $key." = ?");
			array_push($params, get($key));		
		}

	}

	if (count($where) > 0) {
		$where = "WHERE ".implode(" AND ", $where);
	} else {
		$where = "";
	}

	/***********************************************************************************************/
	$pagina = (int)get('pagina');//Página atual
	$itensPorPagina = (int)get('limite');//Itens por página
	$pagination = new Hcode\Pagination(
		"SELECT SQL_CALC_FOUND_ROWS * FROM tb_emails ".$where." ORDER BY desemail LIMIT ?, ?",//Query com as duas interrogações no LIMIT
	    $params,//Outros parâmetros
	    'Hcode\Email\Emails',//Coleção que será retornada
	    $itensPorPagina//Informo os itens por página
	);
	$persons = $pagination->getPage($pagina);//Neste momento vai no banco e solicita os itens da página específica
	echo success(array(
   		"data"=>$persons->getFields(),//Devolvo os dados
   		"total"=>$pagination->getTotal(),//Mostro o total
   		"currentPage"=>$pagina,//Mostro a página atual
   		"itensPerPage"=>$itensPorPagina//Mostro a quantidade de itens por página
	));
	/***********************************************************************************************/

});

$app->post("/emails", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$email = new Hcode\Email\Email();
	$email->set($_POST);
	$email->save();

	echo success(array(
		"data"=>$email->getFields()
	));

});

 ?>