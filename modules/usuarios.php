<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/usuarios/login", function(){

	$usuario = Usuario::login(strtolower(post('username')), post('password'));

	$usuario->getPessoa();

	Session::setUsuario($usuario, (isset($_POST['remember'])));

	Menu::resetMenuSession();

	echo success(array('token'=>session_id(), 'data'=>$usuario->getFields()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/usuarios/menus/reset", function(){

	Permissao::checkSession(Permissao::ADMIN);

	Menu::resetMenuSession();

	echo success(array('token'=>session_id()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/usuarios/forget", function(){

	$usuario = Usuario::getByEmail(strtolower(post('email')));

	if ($usuario->getidusuario() > 0) {

		//Enviar e-mail

	}

	echo success(array('token'=>session_id(), 'data'=>array(
		'message'=>'E-mail de recuperação de senha enviado com sucesso.'
	)));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/usuarios", function(){

	Permissao::checkSession(Permissao::ADMIN);

	$usuarios = Usuarios::listAll($_GET);

    echo success(array(
    	'data'=>$usuarios->getFields()
    ));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/usuariostipos", function(){

	Permissao::checkSession(Permissao::ADMIN);

    echo success(array(
    	'data'=>UsuariosTipos::listAll()->getFields()
    ));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/usuarios/:idusuario/permissoes", function($idusuario){

	Permissao::checkSession(Permissao::ADMIN);

	$usuario = new Usuario(array(
		'idusuario'=>(int)$idusuario
	));

	echo success(array(
    	'data'=>$usuario->getPermissoes()->getFields()
    ));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/usuarios/:idusuario/menus", function($idusuario){

	Permissao::checkSession(Permissao::ADMIN);

	$usuario = new Usuario(array(
		'idusuario'=>(int)$idusuario
	));

	echo success(array(
    	'data'=>$usuario->getMenus()->getFields()
    ));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/usuarios/:idusuario/senha", function($idusuario){

	Permissao::checkSession(Permissao::ADMIN);

	if (!post('dessenhanova')) {
		throw new Exception("Informe a senha.", 400);
	}

	if (post('dessenhanova')!==post('dessenhaconfirme')) {
		throw new Exception("Confirme a senha corretamente.", 400);
	}

	$usuario = new Usuario((int)$idusuario);

	if (!$usuario->checkPassword(post('dessenhaatual'))) {
		throw new Exception("A senha atual não é válida.", 400);
	}

	$usuario->setdessenha(Usuario::getPasswordHash(post('dessenhanova')));

	$usuario->save();

	$usuario->getPessoa();

	Session::setUsuario($usuario);

	echo success(array(
		'data'=>$usuario->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/usuarios/:idusuario", function($idusuario){

	Permissao::checkSession(Permissao::ADMIN);

	$usuario = new Usuario((int)$idusuario);

	$pessoa = $usuario->getPessoa();

	$pessoa->set($_POST);

	$pessoa->save();

	$usuario->set($_POST);

	$usuario->save();

	if ($usuario->getidusuario() === Session::getUsuario()->getidusuario()) {

		$usuario->getPessoa();
		Session::setUsuario($usuario);

	}

	echo success(array('data'=>$usuario->getFields()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->post("/usuarios", function(){

	Permissao::checkSession(Permissao::ADMIN);

	$pessoa = new Pessoa((int)post('idpessoa'));

	if (!(int)$pessoa->getidpessoa() > 0) {
		throw new Exception("Pessoa não encontrada.", 404);
	}

	$_POST['dessenha'] = Usuario::getPasswordHash(post('dessenha'));

	$usuario = new Usuario($_POST);
	$usuario->save();

	echo success(array('data'=>$usuario->getFields()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {get} /usuarios/logout Limpar sessão do usuário.
 * @apiGroup Usuario
 *
 * @apiUse SuccessDefault
 *
 */
$app->get('/usuarios/logout', function () {

	Permissao::checkSession(Permissao::ADMIN);

	unsetLocalCookie(COOKIE_KEY);

	if (isset($_SESSION)) unset($_SESSION);

	session_destroy();

	header("Location: /".DIR_ADMIN);
	exit;

});
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {get} /usuarios/lock Bloquear sessão do usuário.
 * @apiGroup Usuario
 *
 * @apiUse SuccessDefault
 *
 */
$app->get('/usuarios/lock', function () {

	Permissao::checkSession(Permissao::ADMIN);

	$usuario = Session::getUsuario();

	unset($usuario);

	$url = (isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:SITE_PATH.'/'.DIR_ADMIN;

	$_SESSION[Usuario::SESSION_NAME_LOCK] = array(
		'url'=>$url,
		'time'=>time()
	);

	header("Location: /".DIR_ADMIN);
	exit;

});
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {post} /usuarios/unlock Desbloquear sessão do usuário.
 * @apiGroup Usuario
 *
 * @apiParam {String} password Senha do usuário da sessão.
 *
 * @apiSuccess {String} url URL que o usuário estava quando bloqueou a sessão.
 *
 */
$app->post('/usuarios/unlock', function () {

	if(!post('password')){
		http_response_code(400);
		throw new Exception("Digite a senha");
	}

	$usuario = Session::getUsuario(false);

	$u = Usuario::login($usuario->getdesusuario(), post('password'));

	if (!(int)$u->getidusuario() > 0) {

		http_response_code(403);
		throw new Exception("Usuário e/ou senha incorretos.");

	}

	Session::setUsuario($u);

	$url = $_SESSION[Usuario::SESSION_NAME_LOCK]['url'];

	unset($_SESSION[Usuario::SESSION_NAME_LOCK]);

	Menu::resetMenuSession();

	echo success(array(
		'url'=>$url
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @api {get} /usuarios/me Carrega os dados do usuário autenticado.
 * @apiGroup Usuario
 *
 * @apiSuccess {Object} data Dados do usuário.
 *
 */
$app->get('/usuarios/me', function () {

	Permissao::checkSession(Permissao::ADMIN);

	$usuario = Session::getUsuario();

	if(!$usuario->getidusuario() > 0){
		http_response_code(404);
		throw new Exception("O usuário não existe.");
	}

	echo success(array(
		'data'=>$usuario->getFields()
	));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/usuarios/:idusuario", function($idusuario){

	Permissao::checkSession(Permissao::ADMIN);

	if (!(int)$idusuario > 0) {
		throw new Exception("ID de usuário não informado.", 400);
	}

	$usuario = new Usuario($idusuario);

	if (!(int)$usuario->getidusuario() > 0) {
		throw new Exception("Usuário não encontrado.", 404);
	}

	echo success(array('data'=>$usuario->getFields()));

});
////////////////////////////////////////////////////////////////////////////////////////////////////
$app->delete("/usuarios/:idusuario", function($idusuario){

	Permissao::checkSession(Permissao::ADMIN);

	if (!(int)$idusuario > 0) {
		throw new Exception("ID de usuário não informado.", 400);
	}

	$usuario = new Usuario((int)$idusuario);

	if (!(int)$usuario->getidusuario() > 0) {
		throw new Exception("Usuário não encontrado.", 404);
	}

	$usuario->remove();

	echo success();

});
////////////////////////////////////////////////////////////////////////////////////////////////////
?>
