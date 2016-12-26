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

    header('Location: '.SITE_PATH.'/admin');
    exit;

});

$app->get("/".DIR_ADMIN."/lock", function(){

    $page = new AdminPage(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/lock');

});

$app->get("/".DIR_ADMIN."/settings", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $page = new AdminPage();

    $page->setTpl('/admin/index');

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

$app->get("/".DIR_ADMIN."/usuarios", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	$page = new AdminPage(array(
        "header"=>true,
        "footer"=>true
    ));

	$page->setTpl("/admin/usuarios");

});

$app->get("/".DIR_ADMIN."/usuarios/all", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

	$usuarios = Usuarios::listAll();

	echo success(array("data"=>$usuarios->getFields()));

});

$app->post("/".DIR_ADMIN."/usuarios", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $usuario = new Usuario($_POST);
    $usuario->save();

    echo success(array("data"=>$usuario->getFields()));

});

$app->delete("/".DIR_ADMIN."/usuarios", function(){

    Permissao::checkSession(Permissao::ADMIN, true);

    $ids = explode(",", post("ids"));

    foreach($ids as $idusuario){
        
        if(!(int)$idusuario > 0){
            throw new Exception("ID de usuário não informado.", 400);
        }

        $usuario = new Usuario((int)$idusuario);

        if(!(int)$usuario->getidusuario() > 0){
            throw new Exception("Usuário não encontrado.", 404);            
        }

        // $usuario->remove();
    }

    echo success();

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

?>