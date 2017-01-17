<?php

$app->get("/".DIR_ADMIN, function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        'data'=>array(
            'head_title'=>'Administração'
        )
    ));

    $page->setTpl('/admin/index');

});

$app->get("/".DIR_ADMIN."/", function(){

    header('Location: /'.DIR_ADMIN);
    exit;

});

$app->get("/".DIR_ADMIN."/index", function(){

    header('Location: /'.DIR_ADMIN);
    exit;

});

$app->get("/".DIR_ADMIN."/home", function(){

    header('Location: /'.DIR_ADMIN);
    exit;

});

$app->get("/".DIR_ADMIN."/login", function(){

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false,
        'data'=>array(
            'head_title'=>'Login'
        )
    ));

    $page->setTpl('login');

});

$app->get("/".DIR_ADMIN."/forget", function(){

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false,
        'data'=>array(
            'head_title'=>'Forget'
        )
    ));

    $page->setTpl('forget');

});

$app->get("/".DIR_ADMIN."/reset", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $usuario = Session::getUsuario();

    $usuario->reload();

    $usuario->getPessoa();

    Session::setUsuario($usuario);

    Menu::resetMenuSession();

    $nextUrl = $_SERVER['HTTP_REFERER'];
    $nextUrlParse = parse_url($nextUrl);

    $location = SITE_PATH.'/admin';

    if ($nextUrlParse['host'] === $_SERVER['HTTP_HOST']) {
        $location = $nextUrl;
    }

    header('Location: '.$location);
    exit;

});

$app->get("/".DIR_ADMIN."/lock", function(){

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/lock');

});

$app->get("/".DIR_ADMIN."/profile/change-password", function(){

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false,
        'data'=>array(
            'head_title'=>'Perfil - Alterar Senha'
        )
    ));

    $page->setTpl('profile-change-password');

});

$app->get("/".DIR_ADMIN."/profile", function(){

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false,
        'data'=>array(
            'head_title'=>'Perfil'
        )
    ));

    $page->setTpl('profile');

});

$app->get("/".DIR_ADMIN."/settings", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage();

    $page->setTpl('/admin/index');

});

$app->get("/".DIR_ADMIN."/pessoas", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage();

    $page->setTpl('/admin/pessoas');

});

$app->get("/".DIR_ADMIN."/perfil", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage();

    $usuario = Session::getUsuario();

    $page->setTpl('/admin/perfil', array(
        'usuario'=>$usuario->getFields(),
        'pessoa'=>$usuario->getPessoa()->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/session", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    pre($_SESSION);

});

$app->get("/".DIR_ADMIN."/search-panel", function(){

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl("/admin/search-panel", array(
        'q'=>urldecode(get('q')),
        'total'=>0
    ));

});

$app->get("/".DIR_ADMIN."/sistema/usuarios", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/sistema-usuarios");

});

$app->get("/".DIR_ADMIN."/sistema/menu", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/sistema-menu", array(
        'menuHTML'=>Menu::getAllMenuOL()
    ));

});

$app->delete("/".DIR_ADMIN."/sistema/menu", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $menu = new Menu((int)post('idmenu'));

    $menu->remove();

    echo success();

});

$app->get("/".DIR_ADMIN."/sistema/menus", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    function convertDataTreeview($itens){

        foreach ($itens as &$item) {
            
            $data = array(
                'text'=>$item['desmenu'],
                'data'=>$item
            );

            if (isset($item['Menus'])) {
                $data['nodes'] = convertDataTreeview($item['Menus']);
            }

            $item = $data;

        }

        return $itens;

    }

    $menus = Menu::getAllMenus()->getFields();

    $menus = convertDataTreeview($menus);

    echo success(array(
        'data'=>$menus
    ));

});

$app->post("/".DIR_ADMIN."/sistema/menu", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if (!post('desmenu')) {
        throw new Exception("Informe o texto do menu.", 400);
    }

    if ((int)post('idmenu') > 0) {
        $menu = new Menu((int)post('idmenu'));
    } else {
        $menu = new Menu();
    }

    foreach ($_POST as $key => $value) {
        $menu->{'set'.$key}($value);
    }

    $menu->save();

    echo success(array(
        'data'=>$menu->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/sistema/sql-to-class", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/sistema-sql-to-class");

});

$app->get("/".DIR_ADMIN."/produtos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage();

    $page->setTpl("/admin/produtos");

});

$app->get("/".DIR_ADMIN."/produtos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>Produtos::listAll()->getFields()));

});

$app->post('/'.DIR_ADMIN.'/produtos', function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idproduto') > 0){
        $produto = new Produto((int)post('idproduto'));
    }else{
        $produto = new Produto();
    }

    foreach ($_POST as $key => $value) {
        $produto->{'set'.$key}($value);
    }

    $produto->save();

    echo success(array("data"=>$produto->getFields()));

});

$app->delete("/".DIR_ADMIN."/produtos/:idproduto", function($idproduto){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idproduto){
        throw new Exception("Produto não informado", 400);        
    }

    $produto = new Produto((int)$idproduto);

    if(!(int)$produto->getidproduto() > 0){
        throw new Exception("Produto não encontrado", 404);        
    }

    $produto->remove();

    echo success();

});
/////////////////////////////////////////////////////////

// produtos tipos
$app->get("/".DIR_ADMIN."/produtos/tipos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>ProdutosTipos::listAll()->getFields()));

});

$app->post("/".DIR_ADMIN."/produtos-tipos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idprodutotipo') > 0){
        $produtotipo = new ProdutoTipo((int)post('idprodutotipo'));
    }else{
        $produtotipo = new ProdutoTipo();
    }

    foreach ($_POST as $key => $value) {
        $produtotipo->{'set'.$key}($value);
    }

    $produtotipo->save();

    echo success(array("data"=>$produtotipo->getFields()));

});

$app->delete("/".DIR_ADMIN."/produtos-tipos/:idprodutotipo", function($idprodutotipo){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idprodutotipo){
        throw new Exception("Tipo de produto não informado", 400);        
    }

    $produtotipo = new ProdutoTipo((int)$idprodutotipo);

    if(!(int)$produtotipo->getidprodutotipo() > 0){
        throw new Exception("Tipo de produto não encontrado", 404);        
    }

    $produtotipo->remove();

    echo success();

});

$app->get("/".DIR_ADMIN."/sistema/sql-to-class/tables", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $tables = SQL\Tables::listAll();

    echo success(array(
        'data'=>$tables->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/sistema/sql-to-class/tables/:tableName", function($tableName){

    Permissao::checkSession(Permissao::ADMIN, true);

    $table = SQL\Table::loadFromName($tableName);

    $table->setdessingular($table->getSingularName());
    $table->setdesplural($table->getPluralName());
    $table->setdestabela($table->getName());

    echo success(array(
        'data'=>$table->getFields()
    ));

});

$app->post("/".DIR_ADMIN."/sistema/sql-to-class/execute", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if (!post('destabela')) {
        throw new Exception("Informe o nome da tabela.", 400);
    }

    $table = SQL\Table::loadFromName(post('destabela'));

    $columns = $table->getColumns();

    $columnsRequiredPost = $_POST['requireds'];

    foreach ($columnsRequiredPost as &$value) {
        $value = "'".$value."'";
    }

    $columnsRequired = array_unique(array_merge($columnsRequiredPost, $columns->getArrayFieldsRequireds()));

    $columnsPksPost = $_POST['pks'];

    foreach ($columnsPksPost as &$value) {
        $value = "".$value."";
    }

    $columnsPks = array_unique(array_merge($columnsPksPost, $columns->getArrayPrimaryKey()));

    $data = array(
        "table"=>$table->getName(),
        "columns"=>$columns->getFields(),
        "fields"=>implode(", ", $columns->getArrayFields()),
        "fieldstypes"=>$columns->getArrayFieldsTypes(),
        "requireds"=>implode(', ', $columnsRequired),
        "primarykey"=>$columnsPks,
        "primarykeys"=>implode(', ', $columnsPks),
        "object"=>ucfirst(post('dessingular')),
        "object_name"=>strtolower(post('dessingular')),
        "collection"=>ucfirst(post('desplural')),
        "rest_name"=>strtolower(post('desplural')),
        "sp_get"=>$table->getProcedureName("get"),
        "sp_save"=>$table->getProcedureName("save"),
        "sp_remove"=>$table->getProcedureName("remove"),
        "sp_list"=>$table->getProcedureName("list"),
        "fieldssave"=>$columns->getStringFieldsSave(),
        "fieldssaveparams"=>$columns->getStringFieldsSaveParams(),  
        "fieldsinsert"=>$columns->getStringFieldsSaveInsert(),
        "fieldsinsertp"=>$columns->getStringFieldsSaveInsertVars(),
        "fieldsupdate"=>$columns->getStringFieldsUpdate(),
        "params"=>$columns->getStringParams(),
        "saveArgs"=>$columns->getStringFieldsSaveArgs()
    );
    
    $download = false;

    switch(post("filetype")){
        case "model":
        case "collection":
        case "rest":
        $download = true;
        raintpl::configure("tpl_ext", "php");
        $tpl_name = post("filetype");
        break;

        case "get":
        case "list":
        case "save":
        case "remove":
        raintpl::configure("tpl_ext", "sql");
        $tpl_name = "sp_".post("filetype");
        break;

        default:
        throw new Exception("Invalid filetype");
        break;
    }

    raintpl::configure("base_url", PATH );
    raintpl::configure("tpl_dir", PATH."/res/tpl/sql-to-class/" );
    raintpl::configure("cache_dir", PATH."/res/tpl/tmp/" );
    raintpl::configure("path_replace", false );

    $tpl = new RainTPL();

    if(gettype($data)=='array'){
        foreach($data as $key=>$val){
            $tpl->assign($key, $val);
        }
    }

    $template_code = $tpl->draw($tpl_name, true);

    $template_code = str_replace( array("&lt;?","?&gt;"), array("<?","?>"), $template_code );

    if ($download === false) {

        $sql = new Sql();

        $spName = '';

        switch (post("filetype")) {
            case 'save':
            $spName = $data['sp_save'];
            break;
            case 'get':
            $spName = $data['sp_get'];
            break;
            case 'remove':
            $spName = $data['sp_remove'];
            break;
            case 'list':
            $spName = $data['sp_list'];
            break;
        }

        $sql->query("DROP procedure IF EXISTS $spName;");

        $sql->query($template_code);

        echo success(array(
            'data'=>array(
                'table'=>$table->getFields(),
                'tplParams'=>$data,
                'drop'=>"DROP procedure IF EXISTS $tpl_name;",
                'query'=>$template_code
            )
        ));

    } else {

        echo $template_code;

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        switch(post("filetype")){
            case "model":
            header("Content-Disposition: attachment;filename=".ucfirst(post('dessingular')).".php ");
            break;
            case "collection":
            case "rest":
            header("Content-Disposition: attachment;filename=".ucfirst(post('desplural')).".php ");
            break;
            default:
            header("Content-Disposition: attachment;filename=file.php ");
            break;
        }

        header("Content-Transfer-Encoding: binary ");

    }

});
////////////////////////////////////////////////

// carrinhos
$app->get("/".DIR_ADMIN."/carrinhos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>Carrinhos::listAll()->getFields()));

});

$app->post("/".DIR_ADMIN."/carrinhos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idcarrinho') > 0){
        $carrinho = new Carrinho((int)post('idcarrinho'));
    }else{
        $carrinho = new Carrinho();
    }

    foreach ($_POST as $key => $value) {
        $carrinho->{'set'.$key}($value);
    }

    $carrinho->save();

    echo success(array("data"=>$carrinho->getFields()));

});

$app->delete("/".DIR_ADMIN."/carrinhos/:idcarrinho", function($idcarrinho){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcarrinho){
        throw new Exception("Carrinho não informado", 400);        
    }

    $carrinho = new Carrinho((int)$idcarrinho);

    if(!(int)$carrinho->getidcarrinho() > 0){
        throw new Exception("Carrinho não encontrado", 404);        
    }

    $carrinho->remove();

    echo success();

});
///////////////////////////////////////////////////////

// cartoes de credito
$app->get("/".DIR_ADMIN."/cartoes/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>CartoesCreditos::listAll()->getFields()));

});

$app->post("/".DIR_ADMIN."/cartoes", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idcartao') > 0){
        $cartao = new CartaoCredito((int)post('idcartao'));
    }else{
        $cartao = new CartaoCredito();
    }

    foreach ($_POST as $key => $value) {
        $cartao->{'set'.$key}($value);
    }

    $cartao->save();

    echo success(array("data"=>$cartao->getFields()));

});

$app->delete("/".DIR_ADMIN."/cartoes/:idcartao", function($idcartao){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcartao){
        throw new Exception("Cartão não informado", 400);        
    }

    $cartao = new CartaoCredito((int)$idcartao);

    if(!(int)$cartao->getidcartao() > 0){
        throw new Exception("Cartão não encontrado", 404);        
    }

    $cartao->remove();

    echo success();

});
/////////////////////////////////////////////////////////////////////

// gateways
$app->get("/".DIR_ADMIN."/gateways/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>Gateways::listAll()->getFields()));

});

$app->post("/".DIR_ADMIN."/gateways", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idgateway') > 0){
        $gateway = new Gateway((int)post('idgateway'));
    }else{
        $gateway = new Gateway();
    }

    foreach ($_POST as $key => $value) {
        $gateway->{'set'.$key}($value);
    }

    $gateway->save();

    echo success(array("data"=>$gateway->getFields()));

});

$app->delete("/".DIR_ADMIN."/gateways/:idgateway", function($idgateway){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idgateway){
        throw new Exception("Gateway não informado", 400);        
    }

    $gateway = new Gateway((int)$idgateway);

    if(!(int)$gateway->getidgateway() > 0){
        throw new Exception("Gateway não encontrado", 404);        
    }

    $gateway->remove();

    echo success();

});
///////////////////////////////////////////////////////

// formas pagamentos
$app->get("/".DIR_ADMIN."/formas-pagamentos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>FormasPagamentos::listAll()->getFields()));

});

$app->post("/".DIR_ADMIN."/formas-pagamentos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idformapagamento') > 0){
        $pagamento = new FormaPagamento((int)post('idformapagamento'));
    }else{
        $pagamento = new FormaPagamento();
    }

    foreach ($_POST as $key => $value) {
        $pagamento->{'set'.$key}($value);
    }

    $pagamento->save();

    echo success(array("data"=>$pagamento->getFields()));

});

$app->delete("/".DIR_ADMIN."/formas-pagamentos/:idformapagamento", function($idformapagamento){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idformapagamento){
        throw new Exception("Forma de Pagamento não informado", 400);        
    }

    $pagamento = new FormaPagamento((int)$idformapagamento);

    if(!(int)$pagamento->getidformapagamento() > 0){
        throw new Exception("Forma de Pagamento não encontrado", 404);        
    }

    $pagameto->remove();

    echo success();

});
////////////////////////////////////////////////////////

// pagamentos status
$app->get("/".DIR_ADMIN."/pagamentos-status/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>PagamentosStatus::listAll()->getFields()));

});

$app->post("/".DIR_ADMIN."/pagamentos-status", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idstatus') > 0){
        $status = new PagamentoStatus((int)post('idstatus'));
    }else{
        $status = new PagamentoStatus();
    }

    foreach ($_POST as $key => $value) {
        $status->{'set'.$key}($value);
    }

    $status->save();

    echo success(array("data"=>$status->getFields()));

});

$app->delete("/".DIR_ADMIN."/pagamentos-status/:idstatus", function($idstatus){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idstatus){
        throw new Exception("Status não informado", 400);        
    }

    $status = new PagamentoStatus((int)$idstatus);

    if(!(int)$status->getidstatus() > 0){
        throw new Exception("Status não encontrado", 404);        
    }

    $status->remove();

    echo success();

});
///////////////////////////////////////////////////

// pagamentos
$app->get("/".DIR_ADMIN."/pagamentos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>Pagamentos::listAll()->getFields()));

});

$app->post("/".DIR_ADMIN."/pagamentos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idpagamento') > 0){
        $pagamento = new Pagamento((int)post('idpagamento'));
    }else{
        $pagamento = new Pagamento();
    }

    foreach ($_POST as $key => $value) {
        $pagamento->{'set'.$key}($value);
    }

    $pagamento->save();

    echo success(array("data"=>$pagamento->getFields()));

});

$app->delete("/".DIR_ADMIN."/pagamentos/:idpagamento", function($idpagamento){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idpagamento){
        throw new Exception("Pagamento não informado", 400);
    }

    $pagamento = new Pagamento((int)$idpagamento);

    if(!(int)$pagamento->getidpagamento() > 0){
        throw new Exception("Pagamento não encontrado", 404);        
    }

    $pagamento->remove();

    echo success();

});
/////////////////////////////////////////////////////////////

// pagamentos produtos
$app->get("/".DIR_ADMIN."/pagamentos-produtos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>PagamentosProdutos::listAll()->getFields()));

});

$app->post("/".DIR_ADMIN."/pagamentos-produtos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idpagamento') > 0 && post('idproduto') > 0){
        $pagamento = new PagamentoProduto((int)post('idpagamento'), (int)post('idproduto'));
    }else{
        $pagamento = new PagamentoProduto();
    }

    foreach ($_POST as $key => $value) {
        $pagamento->{'set'.$key}($value);
    }

    $pagamento->save();

    echo success(array("data"=>$pagamento->getFields()));

});

$app->delete("/".DIR_ADMIN."/pagamentos/:idpagamento/produtos/:idproduto", function($idpagamento, $idproduto){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idpagamento){
        throw new Exception("Pagamento não informado", 400);        
    }

    if(!(int)$idproduto){
        throw new Exception("Produto não informado", 400);        
    }

    $pagamento = new PagamentoProduto((int)$idpagamento, (int)$idproduto);

    if(!(int)$pagamento->getidpagamento() > 0 && !(int)$pagamento->getidproduto() > 0){
        throw new Exception("Recurso não encontrado", 404);        
    }

    $pagamento->remove();

    echo success();

});
//////////////////////////////////////////////////////////////////////

// pagamentos recibos
$app->get("/".DIR_ADMIN."/pagamentos-recibos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>PagamentosRecibos::listAll()->getFields()));

});

$app->post("/".DIR_ADMIN."/pagamentos-recibos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idpagamento') > 0){
        $recibo = new PagamentoRecibo((int)post('idpagamento'));
    }else{
        $recibo = new PagamentoRecibo();
    }

    foreach ($_POST as $key => $value) {
        $recibo->{'set'.$key}($value);
    }

    $recibo->save();

    echo success(array("data"=>$recibo->getFields()));

});

$app->delete("/".DIR_ADMIN."/pagamentos-recibos/:idpagamento", function($idpagamento){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idpagamento){
        throw new Exception("Pagamento não informado", 400);        
    }

    $recibo = new PagamentoRecibo((int)$idpagamento);

    if(!(int)$recibo->getidpagamento() > 0){
        throw new Exception("Pagamento não encontrado", 404);        
    }

    $recibo->remove();

    echo success();

});
//////////////////////////////////////////////////////////////////

// site contatos
$app->get("/".DIR_ADMIN."/site-contatos/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>SiteContatos::listAll()->getFields()));

});

$app->post("/".DIR_ADMIN."/site-contatos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idsitecontato') > 0){
        $site = new SiteContato((int)post('idsitecontato'));
    }else{
        $site = new SiteContato();
    }

    foreach ($_POST as $key => $value) {
        $site->{'set'.$key}($value);
    }

    $site->save();

    echo success(array("data"=>$site->getFields()));

});

$app->delete("/".DIR_ADMIN."/site-contatos/:idsitecontato", function($idsitecontato){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idsitecontato){
        throw new Exception("Contato não informado", 400);        
    }

    $site = new SiteContato((int)$idsitecontato);

    if(!(int)$site->getidsitecontato() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $site->remove();

    echo success();

});
///////////////////////////////////////////////////////////

// contatos
$app->get("/".DIR_ADMIN."/contatos/tipos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>ContatosTipos::listAll()->getFields()));

});

$app->post("/".DIR_ADMIN."/contatos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('idcontato') > 0){
        $contato = new Contato((int)post('idcontato'));
    }else{
        $contato = new Contato();
    }

    foreach ($_POST as $key => $value) {
        $contato->{'set'.$key}($value);
    }

    $contato->save();

    echo success(array("data"=>$contato->getFields()));

});

$app->delete("/".DIR_ADMIN."/contatos/:idcontato", function($idcontato){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$idcontato){
        throw new Exception("Contato não informado", 400);        
    }

    $contato = new Contato((int)$idcontato);

    if(!(int)$contato->getidcontato() > 0){
        throw new Exception("Contato não encontrado", 404);        
    }

    $contato->remove();

    echo success();

});
////////////////////////////////////////////////////

// documentos
$app->get("/".DIR_ADMIN."/documentos/tipos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    echo success(array("data"=>Documentos::listTipos()->getFields()));

});

$app->post("/".DIR_ADMIN."/documentos", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(post('iddocumento') > 0){
        $documento = new Documento((int)post('iddocumento'));
    }else{
        $documento = new Documento();
    }

    foreach ($_POST as $key => $value) {
        $documento->{'set'.$key}($value);
    }

    $documento->save();

    echo success(array("data"=>$documento->getFields()));

});

$app->delete("/".DIR_ADMIN."/documentos/:iddocumento", function($iddocumento){

    Permissao::checkSession(Permissao::ADMIN, true);

    if(!(int)$iddocumento){
        throw new Exception("Documento não informado", 400);        
    }

    $documento = new Documento((int)$iddocumento);

    if(!(int)$documento->getiddocumento() > 0){
        throw new Exception("Documento não encontrado", 404);        
    }

    $documento->remove();

    echo success();

});

?>