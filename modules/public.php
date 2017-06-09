<?php 

$app->get("/", function(){

	$carousel = Hcode\Site\Carousel::getHTML(1);

    $page = new Hcode\Site\Page();
    
    $page->setTpl('index', array(
    	"testimonial"=>Hcode\Site\Testimonial::listAll()->getFields(),
    	"workers"=>Hcode\Team\Workers::listAll()->getFields(),
    	"carousel"=>$carousel['html'],
    	"options"=>$carousel['options']
    ));

});

$app->get("/termos-de-uso", function(){

    $page = new Hcode\Site\Page([
    	"data"=>[
    		"title"=>"Termos de Uso - Hcode Treinamentos"
    	]
    ]);

    $page->setTpl('termos-de-uso');

});

$app->get("/politica-de-privacidade", function(){

    $page = new Hcode\Site\Page([
    	"data"=>[
    		"title"=>"Política de Privacidade - Hcode Treinamentos"
    	]
    ]);

    $page->setTpl('politica-de-privacidade');

});

$app->get("/shop/cart", function(){

	$cart = Hcode\Session::getCart();
	$cart->reload();

    $page = new Hcode\Site\Page([
    	"footer"=>false,
    	"data"=>[
    		"title"=>"Carrinho de Compras - Hcode Treinamentos"
    	]
    ]);

    $page->setTpl('shop-cart', [
    	"cart"=>$cart->getFields(),
    	"products"=>$cart->getProducts()->getFields()
    ]);

});

$app->get("/shop/cart/:idproduct/remove", function($idproduct){

	if (!$idproduct) {
    	throw new Exception("Nenhum produto foi informado.");
    }

    $cart = Hcode\Session::getCart();

    $cart->removeProduct(new Hcode\Shop\Product([
    	"idproduct"=>$idproduct
    ]));

    $cart->reload();

    Hcode\Session::setCart($cart);

    header("Location: /shop/cart");
    exit;

});

$app->post("/shop/cart", function(){

    if (!post("idproduct")) {
    	throw new Exception("Nenhum produto foi informado.");
    }

    $cart = Hcode\Session::getCart();

    $cart->addProduct(new Hcode\Shop\Product([
    	"idproduct"=>post("idproduct")
    ]));

    $cart->reload();

    Hcode\Session::setCart($cart);

    header("Location: /shop/cart");
    exit;

});

$app->get("/shop/checkout/billing-address", function(){



});

$app->get("/shop/checkout", function(){

	Hcode\Session::checkLogin(true);

	\PagSeguro\Library::initialize();
	\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
	\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

    $sessionCode = \PagSeguro\Services\Session::create(
        \PagSeguro\Configuration\Configure::getAccountCredentials()
    );

	$cart = Hcode\Session::getCart();
	$user = Hcode\Session::getUser();
	$person = $user->getPerson();

	$order = Hcode\Session::getOrder();

	$order->set([
		"idperson"=>$person->getidperson(),
		"idstatus"=>Hcode\Financial\Order\Status::AWAITING,
		"dessession"=>session_id(),
		"vltotal"=>$cart->getvltotal()
	]);

	Hcode\Session::setOrder($order);

    $page = new Hcode\Site\Page([
    	"header"=>false,
    	"footer"=>false,
    	"data"=>[
    		"scripts_footer"=>[
    			'<script src="/res/public/js/plugins/jquery.card.js"></script>'
    		],
    		"title"=>"Pagamento"
    	]
    ]);

    $page->setTpl('shop-checkout', [
    	"cart"=>$cart->getFields(),
    	"products"=>$cart->getProducts()->getFields(),
    	"order"=>$order->getFields(),
    	"pagseguro"=>[
    		"sessionid"=>$sessionCode->getResult()
    	]
    ]);

});

$app->post("/shop/checkout", function(){

	var_dump($_POST);

});

$app->get("/shop/complete", function(){

	Hcode\Session::checkLogin(true);

    $page = new Hcode\Site\Page([
    	'data'=>[
    		"title"=>"Obrigado - Hcode Treinamentos"
    	]
    ]);

    $page->setTpl('shop-complete');

});

$app->get("/shop/cart-buy", function(){

	Hcode\Session::checkLogin(true);

	$cart = Hcode\Session::getCart();
	$cart->reload();

	if (!$cart->getnrproducts() > 0) {

		header("Location: /shop/cart");
		exit;

	}

	$person = Hcode\Session::getPerson();

	if ($cart->getidperson() !== $person->getidperson()) {
		$cart->setidperson($person->getidperson());
		$cart->save();
	}

	Hcode\Session::setCart($cart);

	header("Location: /shop/checkout");
	exit;

});

$app->get("/shop/:desurl", function($desurl){

	$course = Hcode\Course\Course::getByUrl($desurl);

	if (!$course->getidcourse() > 0) {
		header("Location: /");
		exit;
	}

    $page = new Hcode\Site\Page([
    	'data'=>[
    		"title"=>$course->getdescourse()." - Hcode Treinamentos"
    	]
    ]);

    $page->setTpl('produto-curso', array(
    	"course"=>$course->getFields(),
    	"sections"=>$course->getSections()->getFields(),
    	"curriculums"=>$course->getCurriculums()->getFields(),
    	"instructors"=>$course->getInstructors()->getFields()
    ));

});

$app->get("/blog", function(){

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

	$page = new Hcode\Site\Page([
		'data'=>[
			'title'=>'Blog - Hcode Treinamentos'
		]
	]);

	$page->setTpl("blog", array(
		"posts"=>$posts->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$page,
		"itemsPerPage"=>$itemsPerPage,
		"categories"=>Hcode\Site\Blog\Categories::listAll()->getFields()
	));

});

$app->get("/login", function(){

	$page = new Hcode\Site\Page([
		"header"=>false,
    	"footer"=>false,
    	'data'=>[
			'title'=>'Login - Hcode Treinamentos'
		]
    ]);

	$page->setTpl("login");

});

$app->get("/cadastro", function(){

	$types = Hcode\Address\Types::listAll();

	$page = new Hcode\Site\Page([
    	"header"=>false,
    	"footer"=>false,
    	'data'=>[
			'title'=>'Cadastro - Hcode Treinamentos'
		]
    ]);

	$page->setTpl("cadastro", [
		"types"=>$types->getFields()
	]);

});

$app->get("/esqueceu-a-senha", function(){

	$page = new Hcode\Site\Page([
		'data'=>[
			'title'=>'Esqueceu a senha - Hcode Treinamentos'
		]
	]);

	$page->setTpl("forget");

});

$app->get("/contato", function(){

	$page = new Hcode\Site\Page([
		'data'=>[
			'title'=>'Contato - Hcode Treinamentos'
		]
	]);

	$page->setTpl("site-contact", array(
		"conf"=>Hcode\Session::getConfigurations()->getNames()
	));

});

$app->get("/perfil", function(){

	$page = new Hcode\Site\Page([
		'data'=>[
			'title'=>'Meu Perfil - Hcode Treinamentos'
		]
	]);

	$person = Hcode\Session::getPerson();
	
	$root = new Hcode\Site\Contact(array("idsitecontact"=>0));

	$sitesContacts = Hcode\Person\Person::getSiteContactsHTML($root, $person->getSiteContacts());

	$addresstypes = Hcode\Address\Types::listAll();

	$page->setTpl("profile", array(
		"conf"=>Hcode\Session::getConfigurations()->getFields(),
		"sitesContacts"=>$sitesContacts,
		"person"=>$person->getFields(),
		"addresstypes"=>$addresstypes->getFields()
	));

	//pre($person->getFields());

});

$app->post("/perfil-foto", function(){

	$files = Hcode\FileSystem\Files::upload($_FILES['arquivo']);
	$file = $files->getFirst();
    $person = Hcode\Session::getPerson();
    $person->setPhoto($file);
    Hcode\Session::setPerson($person);
    echo success(array(
        'data'=>$files->getFields(),
        'person'=>$person->getFields(),
        "file"=>$file->getFields()
    ));

});

$app->post("/profile", function(){

	$person = Hcode\Session::getPerson();

	$person->set($_POST);

	$person->save();

	echo success();

});

$app->post("/password", function(){

	$user = Hcode\Session::getUser();

	if(!$user->checkPassword(post("descurrentpassword"))){
		throw new Exception("A senha informada está errada", 403);		
	}

	if($_POST['despasswordnew'] != $_POST['despasswordnew2']){
		throw new Exception("As senhas devem ser idênticas");
	}

	$user->setdespassword(Hcode\System\User::getPasswordHash(post("despasswordnew")));

	$user->save();

	echo success();

});

$app->get("/public/places/:idplace", function($idplace){

	$place = new Hcode\Place\Place((int)$idplace);

	echo success(array("data"=>$place->getFields()));

});

$app->post("/login", function(){

	$user = Hcode\System\User::login(strtolower(post("username")), post("password"));

	$user->getPerson();

	Hcode\Session::setUser($user, (isset($_POST['remember'])));
	
	$configurations = Hcode\System\Configurations::listAll();

	Hcode\Session::setConfigurations($configurations);

	echo success(array(
		"token"=>session_id(),
		"url"=>Hcode\Session::getAfterRedirect()
	));

});

$app->get("/logout", function(){

	unsetLocalCookie(COOKIE_KEY);

	if (isset($_SESSION)) unset($_SESSION);

	session_destroy();

	if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) {
		$afterRedirect = $_SERVER['HTTP_REFERER'];
	} else {
		$afterRedirect = "/";
	}

	header("Location: ".$afterRedirect);
	exit;

});

$app->post("/register", function(){

	if (!post("desperson")) {
		throw new Exception("Preencha o seu nome completo.", 400);
	}

	if (!post("dessex")) {
		throw new Exception("Selecione o sexo.", 400);
	}

	if (!post("descpf")) {
		throw new Exception("Preencha o seu CPF.", 400);
	}

	if (!post("dtbirth")) {
		throw new Exception("Preencha a data de nascimento.", 400);
	}

	if (!post("desphone")) {
		throw new Exception("Preencha o telefone para contato.", 400);
	}

	//if (!post("despassword")) {
	//throw new Exception("Preencha a senha.", 400);		
	//}

	//if ($_POST["despassword"] != $_POST['despassword2']) {
	//throw new Exception("As senhas devem ser idênticas.", 400);		
	//}

	// if (!Hcode\Document\Document::exists(post("descpf"), Hcode\Document\Type::CPF)) {
	// 	throw new Exception("Este CPF já está sendo usado por outro usuário.");
	// }

	//if (!Hcode\Contact\Contact::exists(post("desemail"), Hcode\Contact\Type::EMAIL)) {
	//throw new Exception("Este e-mail já está sendo usado por outro usuário.");
	//}

	$person = new Hcode\Person\Person(array(
		"idpersontype"=>Hcode\Person\Type::FISICA
	));

	$person->set($_POST);

	$person->save();

	$user = new Hcode\System\User(array(
		"idperson"=>$person->getidperson(),
		"desuser"=>post("desemail"),
		"despassword"=>Hcode\System\User::getPasswordHash(post('despassword')),
		"inblocked"=> false,
		"idusertype"=>Hcode\System\User\Type::CLIENTE
	));

	$user->save();

	$address = new Hcode\Address\Address();

	$address->set($_POST);

	$address->setinmain(1);

	$address->save();

	$person->addAddress($address);

	$user->getPerson();

	Hcode\Session::setUser($user, (isset($_POST['remember'])));
	
	$configurations = Hcode\System\Configurations::listAll();

	Hcode\Session::setConfigurations($configurations);

	echo success();

});

$app->post("/site-contacts/new", function(){

	if(isLogged()){

		$person = Hcode\Session::getPerson();

	}else{

		$person = Hcode\Person\Person::getByEmail(post("desemail"));

		if(!(int)$person->getidperson() > 0){

			$person = new Hcode\Person\Person(array(
				"idpersontype"=>Hcode\Person\Type::FISICA,
				"desperson"=>post("desperson")
			));

			$person->save();

			$person->addContact(post("desemail"), Hcode\Contact\SubType::EMAIL_PESSOAL);

		}

	}

	$sitecontact = new Hcode\Site\Contact(array(
		"idperson"=>$person->getidperson(),
		"desmessage"=>post("desmessage")
	));

	$sitecontact->save();

	echo success();

});

?>


