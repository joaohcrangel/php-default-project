<?php

$app->get('/pessoas/:idpessoa',function($idpessoa){
   
	Permissao::checkSession(Permissao::ADMIN, true);
	$pessoa = new Pessoa((int)$idpessoa);

	echo success(array(
		'data'=>$pessoa->getFields()
	));

});

$app->get('/pessoas/:idpessoa/contatos',function($idpessoa){
	Permissao::checkSession(Permissao::ADMIN, true);
     
    $pessoa = new Pessoa(array(
		'idpessoa'=>(int)$idpessoa
	));
     $contato = $pessoa->getContatos();
	echo success(array(
         'data'=>$contato->getFields()
    ));
});

$app->get('/pessoas/:idpessoa/historicos',function($idpessoa){
	Permissao::checkSession(Permissao::ADMIN, true);
     
    $pessoa = new Pessoa(array(
		'idpessoa'=>(int)$idpessoa
	));
     $historico = $pessoa->getHistoricos();
	echo success(array(
         'data'=>$historico->getFields()
    ));  
});

$app->get("/pessoas",function(){
	Permissao::checkSession(Permissao::ADMIN, true);
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
	$paginacao = new Pagination(
		"SELECT SQL_CALC_FOUND_ROWS * FROM tb_pessoasdados ".$where." ORDER BY despessoa LIMIT ?, ?",//Query com as duas interrogações no LIMIT
	    $params,//Outros parâmetros
	    'Pessoas',//Coleção que será retornada
	    $itensPorPagina//Informo os itens por página
	);
	$pessoas = $paginacao->getPage($pagina);//Neste momento vai no banco e solicita os itens da página específica
	echo success(array(
   		"data"=>$pessoas->getFields(),//Devolvo os dados
   		"total"=>$paginacao->getTotal(),//Mostro o total
   		"currentPage"=>$pagina,//Mostro a página atual
   		"itensPerPage"=>$itensPorPagina//Mostro a quantidade de itens por página
	));
	/***********************************************************************************************/
});

$app->get("/pessoas/all", function(){
	Permissao::checkSession(Permissao::ADMIN, true);
	echo success(array("data"=>Pessoas::listAll()->getFields()));
});

$app->get("/pessoas-post", function(){
	$_POST = array(
		'despessoa'=>'João Rangel',
		'idpessoatipo'=>'1',
		'idpessoa'=>'3'
	);
	if(post('idpessoa') > 0){
		$pessoa = new Pessoa((int)post('idpessoa'));
	}else{
		$pessoa = new Pessoa();
	}
	$pessoa->set($_POST);
	$pessoa->save();
	if (isset($_POST['desemail'])) {
		$pessoa->addEmail(post('desemail'));
	}
	if (isset($_POST['destelefone'])) {
		$pessoa->addTelefone(post('destelefone'));
	}
	if (isset($_POST['descpf'])) {
		$pessoa->addCPF(post('descpf'));
	}
	$pessoa->reload();
	echo success(array(
		"data"=>$pessoa->getFields()
	));
});

$app->post("/pessoas/:idpessoa/photo", function($idpessoa){

	$file = $_FILES['arquivo'];

	$arquivo = Arquivo::upload(
		$file['name'],
		$file['type'],
		$file['tmp_name'],
		$file['error'],
		$file['size']
	);

	$pessoa = new Pessoa((int)$idpessoa);
	$pessoa->setPhoto($arquivo);
	$pessoa->getPhotoURL();

	echo success(array(
		'data'=>$pessoa->getFields()
	));

});

$app->post("/pessoas", function(){

	if(post('idpessoa') > 0){
		$pessoa = new Pessoa((int)post('idpessoa'));
	}else{
		$pessoa = new Pessoa();
	}

	$pessoa->set($_POST);
	$pessoa->save();
	
	if((int)post('idendereco') > 0){
		$endereco = new Endereco((int)post('idendereco'));
	}else{
		$endereco = new Endereco();
	}

	foreach (array(
		'descep',
		'desendereco',
		'desnumero',
		'descomplemento',
		'desbairro',
		'descidade'
	) as $field) {
		if (isset($_POST[$field]) && post($field)) {
			$endereco->{'set'.$field}(post($field));
		}	
	}

	if (isset($_POST['idcidade']) && (int)post('idcidade') > 0) {
		$cidade = new Cidade((int)post('idcidade'));
	} else {
		if (post('desuf')) {
			$cidade = Cidade::loadFromName(post('descidade'), post('desuf'));
		} else {
			$cidade = Cidade::loadFromName(post('descidade'));
		}
	}

	if (!$endereco->getidenderecotipo() > 0 && count($endereco->getFields()) > 0) {

		$endereco->setidenderecotipo(($pessoa->getidpessoatipo() === PessoaTipo::FISICA)?EnderecoTipo::RESIDENCIAL:EnderecoTipo::COMERCIAL);

	}

	if (count($cidade->getFields())) $endereco->set($cidade->getFields());

	if (count($endereco->getFields())) {

		$endereco->setinprincipal(true);

		$endereco->save();

		$endereco = $pessoa->addEndereco($endereco);

	}

	$pessoa->reload();

	echo success(array(
		"data"=>$pessoa->getFields()
	));
});

$app->delete("/pessoas/:idpessoa", function($idpessoa){
	Permissao::checkSession(Permissao::ADMIN, true);
	if(!(int)$idpessoa > 0){
		throw new Exception("Pessoa não informada", 400);		
	}
	if ((int)$idpessoa === 1) {
		throw new Exception("Não é possível excluir o cadastro root.", 400);
	}
	$pessoa = new Pessoa((int)$idpessoa);
	$pessoa->remove();
	echo success();
});

// documentos
$app->get("/pessoas/:idpessoa/documentos", function($idpessoa){
	Permissao::checkSession(Permissao::ADMIN, true);
	$pessoa = new Pessoa((int)$idpessoa);
	echo success(array("data"=>$pessoa->getDocumentos()->getFields()));
});

// contatos
$app->get("/pessoas/:idpessoa/contatos", function($idpessoa){
	Permissao::checkSession(Permissao::ADMIN, true);
	$pessoa = new Pessoa((int)$idpessoa);
	echo success(array("data"=>$pessoa->getContatos()->getFields()));
});

// site contatos
$app->get("/pessoas/:idpessoa/fale-conosco", function($idpessoa){
	Permissao::checkSession(Permissao::ADMIN, true);
	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_sitecontatos
		WHERE idpessoa = ".$idpessoa." ORDER BY desmensagem LIMIT ?, ?;
	";
	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');
	$paginacao = new Pagination(
		$query,
		array(),
		"SiteContatos",
		$itemsPerPage
	);
	$pessoa = $paginacao->getPage($pagina);	
	echo success(array(
		"data"=>$pessoa->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));
});

// pedidos
$app->get("/pessoas/:idpessoa/pedidos", function($idpessoa){
	Permissao::checkSession(Permissao::ADMIN, true);
	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.*, c.desformapagamento, d.* FROM tb_pedidos a
			INNER JOIN tb_pessoas b USING(idpessoa)
	        INNER JOIN tb_formaspagamentos c ON a.idformapagamento = c.idformapagamento
	        INNER JOIN tb_pedidosstatus d ON a.idstatus = d.idstatus
		WHERE a.idpessoa = ".$idpessoa." LIMIT ?, ?;
	";
	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');
	$paginacao = new Pagination(
		$query,
		array(),
		"Pagamentos",
		$itemsPerPage
	);
	$pessoa = $paginacao->getPage($pagina);
	echo success(array(
		"data"=>$pessoa->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));
});

// cartoes de credito
$app->get("/pessoas/:idpessoa/cartoes", function($idpessoa){
	Permissao::checkSession(Permissao::ADMIN, true);
	$pessoa = new Pessoa((int)$idpessoa);
	echo success(array("data"=>$pessoa->getCartoesCreditos()->getFields()));
});

// carrinhos
$app->get("/pessoas/:idpessoa/carrinhos", function($idpessoa){
	Permissao::checkSession(Permissao::ADMIN, true);
	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_carrinhos
		WHERE idpessoa = ".$idpessoa." LIMIT ?, ?;
	";
	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');
	$paginacao = new Pagination(
		$query,
		array(),
		"Carrinhos",
		$itemsPerPage
	);
	$pessoa = $paginacao->getPage($pagina);
	echo success(array(
		"data"=>$pessoa->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));
});

// enderecos
$app->get("/pessoas/:idpessoa/enderecos", function($idpessoa){
	Permissao::checkSession(Permissao::ADMIN, true);
	$pessoa = new Pessoa((int)$idpessoa);
	echo success(array("data"=>$pessoa->getEnderecos()->getFields()));
});

// usuarios
$app->get("/pessoas/:idpessoa/usuarios", function($idpessoa){
	Permissao::checkSession(Permissao::ADMIN, true);
	$pessoa = new Pessoa((int)$idpessoa);
	echo success(array("data"=>$pessoa->getUsuarios()->getFields()));
});
/////////////////////////////////////////////////////////////////////

// pessoas categorias tipos
$app->get("/pessoas-categorias-tipos/all", function(){
	Permissao::checkSession(Permissao::ADMIN, true);
	$where = array();
	if(get('descategoria') != ''){
		array_push($where, "descategoria LIKE '%".utf8_decode(get('descategoria'))."%'");
	}
	if(count($where) > 0){
		$where  = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}
	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
		FROM tb_pessoascategoriastipos ".$where."
		LIMIT ?, ?;
	";
	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');
	$paginacao = new Pagination(
		$query,
		array(),
		"PessoasCategoriasTipos",
		$itemsPerPage
	);
	$categorias = $paginacao->getPage($pagina);
	echo success(array(
		"data"=>$categorias->getFields(),
		"total"=>$paginacao->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));
});

$app->post("/pessoas-categorias-tipos", function(){
	Permissao::checkSession(Permissao::ADMIN, true);
	if(post('idcategoria') > 0){
		$categoria = new PessoaCategoriaTipo((int)post('idcategoria'));
	}else{
		$categoria = new PessoaCategoriaTipo();
	}
	$categoria->set($_POST);
	$categoria->save();
	echo success(array("data"=>$categoria->getFields()));
});

$app->delete("/pessoas-categorias-tipos/:idcategoria", function($idcategoria){
	Permissao::checkSession(Permissao::ADMIN, true);
	if(!(int)$idcategoria){
		throw new Exception("Categoria não informada", 400);		
	}
	$categoria = new PessoaCategoriaTipo((int)$idcategoria);
	if(!(int)$categoria->getidcategoria() > 0){
		throw new Exception("Categoria não encontrada", 404);		
	}
	$categoria->remove();
	echo success();
});

?>