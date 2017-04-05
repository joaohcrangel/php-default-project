<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/login", function(){

	$user = User::login(strtolower(post('username')), post('password'));

	$user->getPerson();

	Session::setUser($user, (isset($_POST['remember'])));
	
	$configurations = Configurations::listAll();

	Session::setConfigurations($configurations);

	Menu::resetMenuSession();

	echo success(array(
		'token'=>session_id(), 
		'data'=>$user->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/users/login", function(){

	$user = User::login('root', 'root');

	$user->getPerson();

	Session::setUser($user, (isset($_POST['remember'])));

	$configurations = Configurations::listAll();

	Session::setConfigurations($configurations);

	Menu::resetMenuSession();

	echo success(array(
		'token'=>session_id(), 
		'data'=>$user->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/users/menus/reset", function(){

	Permission::checkSession(Permission::ADMIN);

	$configurations = Configurations::listAll();

	Session::setConfigurations($configurations);

	Menu::resetMenuSession();

	echo success(array('token'=>session_id()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/forget", function(){

	$user = User::getByEmail(strtolower(post('email')));

	if ($user->getiduser() > 0) {

		//Enviar e-mail

	}

	echo success(array('token'=>session_id(), 'data'=>array(
		'message'=>'E-mail de recuperação de senha enviado com sucesso.'
	)));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/users", function(){

	Permission::checkSession(Permission::ADMIN);

	$users = Users::listAll($_GET);

    echo success(array(
    	'data'=>$users->getFields()
    ));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/userstypes", function(){

	Permission::checkSession(Permission::ADMIN);

    echo success(array(
    	'data'=>UsersTypes::listAll()->getFields()
    ));

});
/////////////////////////////////////////////////////////////////
$app->get("/users/types", function(){

	Permission::checkSession(Permission::ADMIN);

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

	$paginacao = new Pagination(
        $query,
        array(),
        "UsersTypes",
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

    Permission::checkSession(Permission::ADMIN, true);

    if(post('idusertype') > 0){
        $usertype = new UserType((int)post('idusertype'));
    }else{
        $usertype = new UserType();
    }

    foreach ($_POST as $key => $value) {
        $usertype->{'set'.$key}($value);
    }

    $usertype->save();

    echo success(array("data"=>$usertype->getFields()));

});

$app->delete("/users-types/:idusertype", function($idusertype){

    Permission::checkSession(Permission::ADMIN, true);

    if(!(int)$idusertype){
        throw new Exception("Tipo de usuário não informado", 400);        
    }

    $usertype = new UserType((int)$idusertype);

    if(!(int)$usertype->getidusertype() > 0){
        throw new Exception("Tipo de usuário não encontrado", 404);        
    }

    $usertype->remove();

    echo success();

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/:iduser/permissions", function($iduser){

	Permission::checkSession(Permission::ADMIN);

	$user = new User(array(
		'iduser'=>(int)$iduser
	));

	$permission = new Permission(array(
		'idpermission'=>(int)post('idpermission')
	));

	$user->addPermission($permission);

	echo success();

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->delete("/users/:iduser/permissions", function($iduser){

	Permission::checkSession(Permission::ADMIN);

	$user = new User(array(
		'iduser'=>(int)$iduser
	));

	$permission = new Permission(array(
		'idpermission'=>(int)post('idpermission')
	));

	$user->removePermission($permission);

	echo success();

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/users/:iduser/permissions", function($iduser){

	Permission::checkSession(Permission::ADMIN);

	$user = new User(array(
		'iduser'=>(int)$iduser
	));

	echo success(array(
    	'data'=>$user->getPermissions()->getFields()
    ));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/users/:iduser/menus", function($iduser){

	Permission::checkSession(Permission::ADMIN);

	$user = new User(array(
		'iduser'=>(int)$iduser
	));

	echo success(array(
    	'data'=>$user->getMenus()->getFields()
    ));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/:iduser/password", function($iduser){

	Permission::checkSession(Permission::ADMIN);

	if (!post('passwordnew')) {
		throw new Exception("Informe a senha.", 400);
	}

	if (post('passwordnew')!==post('passwordconfirm')) {
		throw new Exception("Confirme a senha corretamente.", 400);
	}

	$user = new User((int)$iduser);

	if (!$user->checkPassword(post('passwordcurrent'))) {
		throw new Exception("A senha atual não é válida.", 400);
	}

	$user->setdespassword(User::getPasswordHash(post('passwordnew')));

	$user->save();

	$user->getPerson();

	Session::setUser($user);

	echo success(array(
		'data'=>$user->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users", function(){

	Permission::checkSession(Permission::ADMIN);

	$person = new Person((int)post('idperson'));

	if (!(int)$person->getidperson() > 0) {
		throw new Exception("Pessoa não encontrada.", 404);
	}

	$_POST['despassword'] = User::getPasswordHash(post('despassword'));

	$user = new User($_POST);
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

	Permission::checkSession(Permission::ADMIN);

	$user = Session::getUser();

	unset($user);

	$url = (isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:SITE_PATH.'/'.DIR_ADMIN;

	$_SESSION[User::SESSION_NAME_LOCK] = array(
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

	$user = Session::getUser(false);

	$u = User::login($user->getdesuser(), post('password'));

	if (!(int)$u->getiduser() > 0) {

		http_response_code(403);
		throw new Exception("Usuário e/ou senha incorretos.");

	}

	Session::setUser($u);

	$url = $_SESSION[User::SESSION_NAME_LOCK]['url'];

	unset($_SESSION[User::SESSION_NAME_LOCK]);

	Menu::resetMenuSession();

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

	Permission::checkSession(Permission::ADMIN);

	$user = Session::getUser();

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

	Permission::checkSession(Permission::ADMIN);

	if (!(int)$iduser > 0) {
		throw new Exception("ID de usuário não informado.", 400);
	}

	$user = new User((int)$iduser);

	$user->getPerson();

	if (!(int)$user->getiduser() > 0) {
		throw new Exception("Usuário não encontrado.", 404);
	}

	echo success(array('data'=>$user->getFields()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/users/:iduser", function($iduser){

	Permission::checkSession(Permission::ADMIN);

	$user = new User((int)$iduser);

	$person = $user->getPerson();

	$person->set($_POST);

	$person->save();

	$user->set($_POST);

	$user->save();

	if ($user->getiduser() === Session::getUser()->getiduser()) {

		$user->getPerson();
		Session::setUser($user);

	}

	echo success(array('data'=>$user->getFields()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->delete("/users/:iduser", function($iduser){

	Permission::checkSession(Permission::ADMIN);

	if (!(int)$iduser > 0) {
		throw new Exception("ID de usuário não informado.", 400);
	}

	$user = new User((int)$iduser);

	if (!(int)$user->getiduser() > 0) {
		throw new Exception("Usuário não encontrado.", 404);
	}

	$user->remove();

	echo success();

});
////////////////////////////////////////////////////////////////////////////////////////////////////
?>
