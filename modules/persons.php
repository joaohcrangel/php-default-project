<?php

$app->get('/persons/:idperson',function($idperson){
   
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$person = new Hcode\Person\Person((int)$idperson);

	echo success(array(
		'data'=>$person->getFields()
	));

});

$app->get('/persons/:idperson/contacts',function($idperson){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
     
    $person = new Hcode\Person\Person(array(
		'idperson'=>(int)$idperson
	));
     $contact = $person->getContacts();
	echo success(array(
         'data'=>$contact->getFields()
    ));
});

$app->get('/persons/:idperson/logs',function($idperson){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = (int)get("page");
	$itemsPerPage = (int)get("limit");
     
    $where = array();

    if(count($where) > 0){
    	$where = " WHERE ".implode(" AND ", $where)."";
    }else{
    	$where = "";
    }

    $query = "
    	SELECT SQL_CALC_FOUND_ROWS a.*, b.desperson, c.deslogtype FROM tb_personslogs a
    		INNER JOIN tb_persons b ON a.idperson = b.idperson
    		INNER JOIN tb_personslogstypes c ON a.idlogtype = c.idlogtype
    	".$where." LIMIT ?, ?;
   	";

   	$pagination = new Hcode\Pagination(
   		$query,
   		array(),
   		"Hcode\Person\Logs",
   		$itemsPerPage
   	);

   	$logs = $pagination->getPage($page);

   	echo success(array(
   		"data"=>$logs->getFields(),
   		"total"=>$pagination->getTotal(),
   		"currentPage"=>$page,
   		"itemsPerPage"=>$itemsPerPage
   	));

});

$app->get("/persons",function(){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$q = get("q");
	$where = array();
	$params = array();

	foreach ($_GET as $key => $value) {
		
		if (get($key) && !in_array($key, array('pagina', 'limite'))) {
			if ($key == "desperson") {
				array_push($where, $key." LIKE ?");	
				array_push($params, "%".get($key)."%");
			} else {
				array_push($where, $key." = ?");
				array_push($params, get($key));
			}			
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
		"SELECT SQL_CALC_FOUND_ROWS * FROM tb_personsdata ".$where." ORDER BY desperson LIMIT ?, ?",//Query com as duas interrogações no LIMIT
	    $params,//Outros parâmetros
	    'Hcode\Person\Persons',//Coleção que será retornada
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

$app->get("/persons/all", function(){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	echo success(array("data"=>Persons::listAll()->getFields()));
});

$app->get("/persons-post", function(){
	$_POST = array(
		'desperson'=>'João Rangel',
		'idpersontype'=>'1',
		'idperson'=>'3'
	);
	if(post('idperson') > 0){
		$person = new Hcode\Person\Person((int)post('idperson'));
	}else{
		$person = new Hcode\Person\Person();
	}
	$person->set($_POST);
	$person->save();
	if (isset($_POST['desemail'])) {
		$person->addEmail(post('desemail'));
	}
	if (isset($_POST['desphone'])) {
		$person->addphone(post('desphone'));
	}
	if (isset($_POST['descpf'])) {
		$person->addCPF(post('descpf'));
	}
	$person->reload();
	echo success(array(
		"data"=>$person->getFields()
	));
});

$app->post("/persons/:idperson/photo", function($idperson){

	$file = $_FILES['arquivo'];

	$file = Hcode\FileSystem\File::upload(
		$file['name'],
		$file['type'],
		$file['tmp_name'],
		$file['error'],
		$file['size']
	);

	if (isset($_POST['top']) && isset($_POST['left']) && isset($_POST['width']) && isset($_POST['height'])) {
		$file->crop(post('width'), post('height'), post('top'), post('left'), post('width_responsive'), post('height_responsive'));
	}

	$person = new Hcode\Person\Person((int)$idperson);
	$person->setPhoto($file);
	$person->getPhotoURL();

	echo success(array(
		'data'=>$person->getFields()
	));

});

$app->post("/persons", function(){

	if(post('idperson') > 0){
		$person = new Hcode\Person\Person((int)post('idperson'));
	}else{
		$person = new Hcode\Person\Person();
	}

	$person->set($_POST);
	$person->save();

	if(isset($_POST["idaddress"]) && !empty($_POST["idaddress"])){
	
		if((int)post('idaddress') > 0){
			$address = new Hcode\Address\Address((int)post('idaddress'));
		}else{
			$address = new Hcode\Address\Address();
		}

		foreach (array(
			'idaddresstype',
			'descep',
			'desaddress',
			'desnumber',
			'descomplement',
			'desdistrict',
			'descity'
		) as $field) {
			if (isset($_POST[$field]) && post($field)) {
				$address->{'set'.$field}(post($field));
			}	
		}

		if (isset($_POST['idcity']) && (int)post('idcity') > 0) {
			$city = new Hcode\Address\City((int)post('idcity'));
		} else {
			if (post('desuf')) {
				$city = Hcode\Address\City::loadFromName(post('descity'), post('desuf'));			
			} else {
				$city = Hcode\Address\City::loadFromName(post('descity'));
			}
		}

		if (!$address->getidaddresstype() > 0 && count($address->getFields()) > 0) {

			$address->setidaddresstype(($person->getidpersontype() === Hcode\Person\Type::FISICA)?Hcode\Address\Type::RESIDENCIAL:Hcode\Address\Type::COMERCIAL);

		}

		if (count($city->getFields())) $address->set($city->getFields());

		if (count($address->getFields())) {

			$address->setinmain(true);

			$address->save();

			$person->addAddress($address);

		}

	}

	$person->reload();

	echo success(array(
		"data"=>$person->getFields()
	));
});

$app->delete("/persons/:idperson", function($idperson){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	if(!(int)$idperson > 0){
		throw new Exception("Pessoa não informada", 400);		
	}
	if ((int)$idperson === 1) {
		throw new Exception("Não é possível excluir o cadastro root.", 400);
	}
	$person = new Hcode\Person\Person((int)$idperson);
	$person->remove();
	echo success();
});

// documentos
$app->get("/persons/:idperson/documents", function($idperson){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$person = new Hcode\Person\Person((int)$idperson);
	echo success(array("data"=>$person->getDocuments()->getFields()));
});

// contacts
$app->get("/persons/:idperson/contacts", function($idperson){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$person = new Hcode\Person\Person((int)$idperson);
	echo success(array("data"=>$person->getContacts()->getFields()));
});

// site contacts
$app->get("/persons/:idperson/site-contact", function($idperson){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$query = "
		SELECT SQL_CALC_FOUND_ROWS 
		a.idsitecontact, a.desmessage, a.inread, a.dtregister,
		CASE WHEN a.idpersonanswer IS NULL THEN b.idperson ELSE c.idperson END AS idperson,
		CASE WHEN a.idpersonanswer IS NULL THEN b.desperson ELSE c.desperson END AS desperson,
		CASE WHEN a.idpersonanswer IS NULL THEN b.desphoto ELSE c.desphoto END AS desphoto,
		CASE WHEN a.idpersonanswer IS NULL THEN b.idpersontype ELSE c.idpersontype END AS idpersontype,
		CASE WHEN a.idpersonanswer IS NULL THEN 1 ELSE 0 END AS inanswer
		FROM tb_sitescontacts a
		INNER JOIN tb_personsdata b ON a.idperson = b.idperson
		LEFT JOIN tb_personsdata c ON a.idpersonanswer = c.idperson
		WHERE a.idperson = ".$idperson."
		ORDER BY a.desmessage LIMIT ?, ?;
	";
	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');
	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Person\Persons",
		$itemsPerPage
	);
	$person = $pagination->getPage($pagina);	
	echo success(array(
		"data"=>$person->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));
});

$app->post("/persons/:idperson/files", function($idperson){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	if (!(int)$idperson > 0) {
		throw new Exception("Informe o ID da pessoa.");
	}

	$person = new Hcode\Person\Person(array('idperson'=>(int)$idperson));

	$files = Hcode\FileSystem\Files::upload($_FILES['arquivo']);

	foreach ($files->getItens() as $file) {
		$person->addFile($file);
	}

	echo success(array(
		'data'=>$files->getFields()
	));

});

$app->get("/persons/:idperson/files", function($idperson){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
		FROM tb_files a
		INNER JOIN tb_personsfiles b ON a.idfile = b.idfile
		WHERE b.idperson = ".$idperson." LIMIT ?, ?;
	";
	$pagina = (int)get('page');
	$itemsPerPage = (int)get('limit');
	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\FileSystem\Files",
		$itemsPerPage
	);
	$files = $pagination->getPage($pagina);
	echo success(array(
		"data"=>$files->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));

});

// pedidos
$app->get("/persons/:idperson/orders", function($idperson){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.*, c.desformpayment, d.* FROM tb_orders a
			INNER JOIN tb_persons b USING(idperson)
	        INNER JOIN tb_formspayments c ON a.idformpayment = c.idformpayment
	        INNER JOIN tb_ordersstatus d ON a.idstatus = d.idstatus
		WHERE a.idperson = ".$idperson." LIMIT ?, ?;
	";
	$pagina = (int)get('page');
	$itemsPerPage = (int)get('limit');
	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Financial\Orders",
		$itemsPerPage
	);
	$person = $pagination->getPage($pagina);
	echo success(array(
		"data"=>$person->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));
});

// cartoes de credito
$app->get("/persons/:idperson/cards", function($idperson){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$person = new Hcode\Person\Person((int)$idperson);
	echo success(array("data"=>$person->getCreditCards()->getFields()));
});

// carrinhos
$app->get("/persons/:idperson/carts", function($idperson){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$query = "
		SELECT SQL_CALC_FOUND_ROWS * FROM tb_carts
		WHERE idperson = ".$idperson." LIMIT ?, ?;
	";
	$pagina = (int)get('page');
	$itemsPerPage = (int)get('limit');
	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Shop\Carts",
		$itemsPerPage
	);
	$person = $pagination->getPage($pagina);
	echo success(array(
		"data"=>$person->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));
});

// enderecos
$app->get("/persons/:idperson/addresses", function($idperson){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$person = new Hcode\Person\Person((int)$idperson);
	echo success(array("data"=>$person->getAddresses()->getFields()));
});

// usuarios
$app->get("/persons/:idperson/users", function($idperson){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$person = new Hcode\Person\Person((int)$idperson);
	echo success(array("data"=>$person->getUsers()->getFields()));
});

// categories
$app->get("/persons-categories/all", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	echo success(array("data"=>Hcode\Person\Category\Types::listAll()->getFields()));

});

$app->get("/persons/:idperson/categories", function($idperson){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$page = (int)get("page");
	$itemsPerPage = (int)get("limit");

	$where = array();

	if($_GET['descategory'] != ''){
		array_push($where, "c.descategory LIKE '".utf8_encode(get("descategory"))."'");
	}

	if(count($where) > 0){
		$where = " WHERE ".implode(" AND ", $where)."";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS c.* FROM tb_persons a
			INNER JOIN tb_personscategories b ON a.idperson = b.idperson
			INNER JOIN tb_personscategoriestypes c ON b.idcategory = c.idcategory
		".$where." LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		'Hcode\Person\Category\Types',
		$itemsPerPage
	);

	$categories = $pagination->getPage($page);

	echo success(array(
		"data"=>$categories->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$page,
		"itemsPerPage"=>$itemsPerPage
	));

});

$app->post("/persons/:idperson/categories", function($idperson){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

	$ids = explode(",", post("ids"));

	$person = new Hcode\Person\Person((int)$idperson);

	$person->removeCategories();

	foreach ($ids as $idcategory) {

		$category = new Hcode\Person\Category\Type((int)$idcategory);

		$person->addCategory($category);

	}

	echo success(array("data"=>$person->getCategories()->getFields()));

});

/////////////////////////////////////////////////////////////////////

// pessoas categorias types
$app->get("/persons-categories-types/all", function(){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	$where = array();
	if(get('descategory') != ''){
		array_push($where, "descategory LIKE '%".utf8_decode(get('descategory'))."%'");
	}
	if(count($where) > 0){
		$where  = "WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}
	$query = "
		SELECT SQL_CALC_FOUND_ROWS *
		FROM tb_personscategoriestypes ".$where."
		LIMIT ?, ?;
	";
	$pagina = (int)get('pagina');
	$itemsPerPage = (int)get('limite');
	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Person\Category\Types",
		$itemsPerPage
	);
	$categories = $pagination->getPage($pagina);
	echo success(array(
		"data"=>$categories->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$pagina,
		"itemsPerPage"=>$itemsPerPage
	));
});

$app->post("/persons-categories-types", function(){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	if(post('idcategory') > 0){
		$category = new Hcode\Person\Category\Type((int)post('idcategory'));
	}else{
		$category = new Hcode\Person\Category\Type();
	}
	$category->set($_POST);
	$category->save();
	echo success(array("data"=>$category->getFields()));
});

$app->delete("/persons-categories-types/:idcategory", function($idcategory){
	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);
	if(!(int)$idcategory){
		throw new Exception("Categoria não informada", 400);		
	}
	$category = new Hcode\Person\Category\Type((int)$idcategory);
	if(!(int)$category->getidcategory() > 0){
		throw new Exception("Categoria não encontrada", 404);		
	}
	$category->remove();
	echo success();
});

?>