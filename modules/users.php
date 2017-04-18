<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/login", function(){

	$user = Hcode\System\User::login(strtolower(post('username')), post('password'));

	$user->getPerson();

	Hcode\Session::setUser($user, (isset($_POST['remember'])));
	
	$configurations = Hcode\System\Configurations::listAll();

	Hcode\Session::setConfigurations($configurations);

	Hcode\Admin\Menu::resetMenuSession();

	echo success(array(
		'token'=>session_id(),
		'data'=>$user->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/users/login", function(){

	$user = Hcode\System\User::login('root', 'root');

	$user->getPerson();

	Hcode\Session::setUser($user, (isset($_POST['remember'])));

	$configurations = Hcode\System\Configurations::listAll();

	Hcode\Session::setConfigurations($configurations);

	Hcode\Admin\Menu::resetMenuSession();

	echo success(array(
		'token'=>session_id(), 
		'data'=>$user->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/simulate", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$user = new Hcode\System\User((int)post("iduser"));

	Hcode\Session::simulateStart($user);

	echo success();

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/simulated", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	Hcode\Session::simulateEnd();

	echo success();

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/users/menus/reset", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$configurations = Hcode\System\Configurations::listAll();

	Hcode\Session::setConfigurations($configurations);

	Hcode\Admin\Menu::resetMenuSession();

	echo success(array('token'=>session_id()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/forget", function(){

	$user = Hcode\System\User::getByEmail(strtolower(post('email')));

	if ($user->getiduser() > 0) {

		//Enviar e-mail

	}

	echo success(array('token'=>session_id(), 'data'=>array(
		'message'=>'E-mail de recuperação de senha enviado com sucesso.'
	)));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/users", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$users = Hcode\System\Users::listAll($_GET);

    echo success(array(
    	'data'=>$users->getFields()
    ));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/userstypes", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

    echo success(array(
    	'data'=>Hcode\System\User\Types::listAll()->getFields()
    ));

});
/////////////////////////////////////////////////////////////////
$app->get("/users/types", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('desusertype')) {
		array_push($where, "desusertype LIKE '%".get('desusertype')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AND ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_userstypes
	".$where." LIMIT ?, ?;";

	$paginacao = new Hcode\Pagination(
        $query,
        array(),
        "Hcode\System\User\Types",
        $itemsPerPage
    );

    $userstypes = $paginacao->getPage($currentPage);

    echo success(array(
    	"data"=>$userstypes->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$paginacao->getTotal(),

    ));

});

$app->post("/users-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(post('idusertype') > 0){
        $usertype = new Hcode\System\User\Type((int)post('idusertype'));
    }else{
        $usertype = new Hcode\System\User\Type();
    }

    foreach ($_POST as $key => $value) {
        $usertype->{'set'.$key}($value);
    }

    $usertype->save();

    echo success(array("data"=>$usertype->getFields()));

});

$app->delete("/users-types/:idusertype", function($idusertype){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if(!(int)$idusertype){
        throw new Exception("Tipo de usuário não informado", 400);        
    }

    $usertype = new Hcode\System\User\Type((int)$idusertype);

    if(!(int)$usertype->getidusertype() > 0){
        throw new Exception("Tipo de usuário não encontrado", 404);        
    }

    $usertype->remove();

    echo success();

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/:iduser/permissions", function($iduser){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$user = new Hcode\System\User(array(
		'iduser'=>(int)$iduser
	));

	$permission = new Hcode\Admin\Permission(array(
		'idpermission'=>(int)post('idpermission')
	));

	$user->addPermission($permission);

	echo success();

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->delete("/users/:iduser/permissions", function($iduser){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$user = new Hcode\System\User(array(
		'iduser'=>(int)$iduser
	));

	$permission = new Hcode\Admin\Permission(array(
		'idpermission'=>(int)post('idpermission')
	));

	$user->removePermission($permission);

	echo success();

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/users/:iduser/permissions", function($iduser){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$user = new Hcode\System\User(array(
		'iduser'=>(int)$iduser
	));

	echo success(array(
    	'data'=>$user->getPermissions()->getFields()
    ));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/users/:iduser/menus", function($iduser){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$user = new Hcode\System\User(array(
		'iduser'=>(int)$iduser
	));

	echo success(array(
    	'data'=>$user->getMenus()->getFields()
    ));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/:iduser/password", function($iduser){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	if (!post('passwordnew')) {
		throw new Exception("Informe a senha.", 400);
	}

	if (post('passwordnew')!==post('passwordconfirm')) {
		throw new Exception("Confirme a senha corretamente.", 400);
	}

	$user = new Hcode\System\User((int)$iduser);

	if (!$user->checkPassword(post('passwordcurrent'))) {
		throw new Exception("A senha atual não é válida.", 400);
	}

	$user->setdespassword(Hcode\System\User::getPasswordHash(post('passwordnew')));

	$user->save();

	$user->getPerson();

	Hcode\Session::setUser($user);

	echo success(array(
		'data'=>$user->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users", function(){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	if ((int)post('idperson') > 0) {
		$person = new Hcode\Person\Person((int)post('idperson'));
	} else {
		$person = new Hcode\Person\Person(array(
			"desperson"=>post("desperson"),
			"idpersontype"=>Hcode\Person\Type::FISICA
		));
		$person->save();
	}	

	if (!(int)$person->getidperson() > 0) {
		throw new Exception("Pessoa não encontrada.", 404);
	}

	$_POST['despassword'] = Hcode\System\User::getPasswordHash(post('despassword'));
	$_POST['inblocked'] = 0;
	$_POST['idperson'] = $person->getidperson();

	$user = new Hcode\System\User($_POST);
	$user->save();

	echo success(array('data'=>$user->getFields()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {get} /users/logout Limpar sessão do usuário.
 * @apiGroup user
 *
 * @apiUse SuccessDefault
 *
 */
$app->get('/users/logout', function () {

	unsetLocalCookie(COOKIE_KEY);

	if (isset($_SESSION)) unset($_SESSION);

	session_destroy();

	header("Location: /".DIR_ADMIN);
	exit;

});
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {get} /users/lock Bloquear sessão do usuário.
 * @apiGroup user
 *
 * @apiUse SuccessDefault
 *
 */
$app->get('/users/lock', function () {

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$user = Hcode\Session::getUser();

	unset($user);

	$url = (isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:SITE_PATH.'/'.DIR_ADMIN;

	$_SESSION[Hcode\System\User::SESSION_NAME_LOCK] = array(
		'url'=>$url,
		'time'=>time()
	);

	header("Location: /".DIR_ADMIN);
	exit;

});
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {post} /users/unlock Desbloquear sessão do usuário.
 * @apiGroup user
 *
 * @apiParam {String} password Senha do usuário da sessão.
 *
 * @apiSuccess {String} url URL que o usuário estava quando bloqueou a sessão.
 *
 */
$app->post('/users/unlock', function () {

	if(!post('password')){
		http_response_code(400);
		throw new Exception("Digite a senha");
	}

	$user = Hcode\Session::getUser(false);

	$u = Hcode\System\User::login($user->getdesuser(), post('password'));

	if (!(int)$u->getiduser() > 0) {

		http_response_code(403);
		throw new Exception("Usuário e/ou senha incorretos.");

	}

	Hcode\Session::setUser($u);

	$url = $_SESSION[Hcode\System\User::SESSION_NAME_LOCK]['url'];

	unset($_SESSION[Hcode\System\User::SESSION_NAME_LOCK]);

	Hcode\Admin\Menu::resetMenuSession();

	echo success(array(
		'url'=>$url
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {get} /users/me Carrega os dados do usuário autenticado.
 * @apiGroup user
 *
 * @apiSuccess {Object} data Dados do usuário.
 *
 */
$app->get('/users/me', function () {

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$user = Hcode\Session::getUser();

	if(!$user->getiduser() > 0){
		http_response_code(404);
		throw new Exception("O usuário não existe.");
	}

	echo success(array(
		'data'=>$user->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/users/:iduser", function($iduser){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	if (!(int)$iduser > 0) {
		throw new Exception("ID de usuário não informado.", 400);
	}

	$user = new Hcode\System\User((int)$iduser);

	$user->getPerson();

	if (!(int)$user->getiduser() > 0) {
		throw new Exception("Usuário não encontrado.", 404);
	}

	echo success(array('data'=>$user->getFields()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/:iduser", function($iduser){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	$user = new Hcode\System\User((int)$iduser);

	$person = $user->getPerson();

	$person->set($_POST);

	$person->save();

	$user->set($_POST);

	$user->save();

	if ($user->getiduser() === Hcode\Session::getUser()->getiduser()) {

		$user->getPerson();
		Hcode\Session::setUser($user);

	}

	echo success(array('data'=>$user->getFields()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->delete("/users/:iduser", function($iduser){

	Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN);

	if (!(int)$iduser > 0) {
		throw new Exception("ID de usuário não informado.", 400);
	}

	$user = new Hcode\System\User((int)$iduser);

	if (!(int)$user->getiduser() > 0) {
		throw new Exception("Usuário não encontrado.", 404);
	}

	$user->remove();

	echo success();

});
////////////////////////////////////////////////////////////////////////////////////////////////////
?>
