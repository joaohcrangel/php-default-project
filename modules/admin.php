<?php

$app->get("/".DIR_ADMIN, function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'head_title'=>'Administração'
        )
    ));

    $page->setTpl('/admin/index');

});

$app->get("/".DIR_ADMIN."/sessionid", function(){
    
    echo session_id();

});

$app->get("/".DIR_ADMIN."/arquivos", function(){

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

    $page = new Hcode\Admin\Page(array(
        'header'=>false,
        'footer'=>false,
        'data'=>array(
            'head_title'=>'Login'
        )
    ));

    $page->setTpl('login');

});

$app->get("/".DIR_ADMIN."/forget", function(){

    $page = new Hcode\Admin\Page(array(
        'header'=>false,
        'footer'=>false,
        'data'=>array(
            'head_title'=>'Forget'
        )
    ));

    $page->setTpl('forget');

});

$app->get("/".DIR_ADMIN."/reset", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $user = Hcode\Session::getUser();

    $user->reload();

    $user->getPerson();

    Hcode\Session::setUser($user);

    $configurations = Hcode\System\Configurations::listAll();

    Hcode\Session::setConfigurations($configurations);

    Menu::resetMenuSession();

    $nextUrl = (isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']."/admin";
    $nextUrlParse = parse_url($nextUrl);

    $location = SITE_PATH.'/admin';

    if (isset($nextUrlParse['host']) && $nextUrlParse['host'] === $_SERVER['HTTP_HOST']) {
        $location = $nextUrl;
    }

    header('Location: '.$location);
    exit;

});

$app->get("/".DIR_ADMIN."/lock", function(){

    $page = new Hcode\Admin\Page(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl('/admin/lock');

});

$app->get("/".DIR_ADMIN."/profile/change-password", function(){

    $page = new Hcode\Admin\Page(array(
        'header'=>false,
        'footer'=>false,
        'data'=>array(
            'head_title'=>'Perfil - Alterar Senha'
        )
    ));

    $page->setTpl('profile-change-password');

});

$app->get("/".DIR_ADMIN."/profile", function(){

    $page = new Hcode\Admin\Page(array(
        'header'=>false,
        'footer'=>false,
        'data'=>array(
            'head_title'=>'Perfil'
        )
    ));

    $user = Hcode\Session::getUser();
    $user->reload();
    $user->setPerson(null);
    $user->getPerson();

    $page->setTpl('profile', array(
        "user"=>$user->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/settings", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl('/admin/index');

});

$app->get("/".DIR_ADMIN."/profile", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $user = Hcode\Session::getUser();

    $page->setTpl('/admin/profile', array(
        'user'=>$user->getFields(),
        'person'=>$user->getPerson()->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/session", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    pre($_SESSION);

});

$app->get("/".DIR_ADMIN."/search-panel", function(){

    $page = new Hcode\Admin\Page(array(
        'header'=>false,
        'footer'=>false
    ));

    $page->setTpl("/admin/search-panel", array(
        'q'=>urldecode(get('q')),
        'total'=>0
    ));

});

$app->get("/".DIR_ADMIN."/system/users", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/system-users");

});

$app->get("/".DIR_ADMIN."/system/sql-to-class", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        "header"=>true,
        "footer"=>true
    ));

    $page->setTpl("/admin/system-sql-to-class");

});

$app->get("/".DIR_ADMIN."/products", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/products");

});

$app->get("/admin/permissions", function(){

    $permisao = new Hcode\Admin\Page(array(
         'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $permisao->setTpl("/admin/permissions");

});

$app->get("/".DIR_ADMIN."/products-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/products-types");

});

$app->get("/".DIR_ADMIN."/documents-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )

    ));

    $page->setTpl("/admin/documents-types");

});

$app->get("/".DIR_ADMIN."/addresses-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
         'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/addresses-types");

});

$app->get("/".DIR_ADMIN."/users-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/users-types");

});

$app->get("/".DIR_ADMIN."/logs-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
         'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/logs-types");

});

$app->get("/".DIR_ADMIN."/userslogs-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
         'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/userslogs-types");

});

$app->get("/".DIR_ADMIN."/transactions-types", function(){
    
    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
         'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/transactions-types");
});

$app->get("/".DIR_ADMIN."/blog-tags/all", function(){

    Permission::checkSession(Permission::ADMIN, true);

   $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));
    $page->setTpl("blog-tags-all");

});

$app->get("/".DIR_ADMIN."/forms-payments", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

   $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));
    $page->setTpl("/admin/forms-payment");

});

$app->get("/".DIR_ADMIN."/places-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/places-types");

});

$app->get("/".DIR_ADMIN."/coupons-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
         'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/coupons-types");

});

$app->get("/".DIR_ADMIN."/gateways", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
          'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/gateways");

});

$app->get("/".DIR_ADMIN."/orders-status", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/orders-status");

});

$app->get("/".DIR_ADMIN."/contacts-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
         'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )

    ));

    $page->setTpl("/admin/contacts-types");

});

$app->get("/".DIR_ADMIN."/persons-valuesfields", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
         'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/persons-valuesfields");

});

$app->get("/".DIR_ADMIN."/ordersnegotiationstypes", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
         'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/ordersnegotiationstypes");

});

$app->get("/".DIR_ADMIN."/persons-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
         'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/persons-types");

});

$app->get("/".DIR_ADMIN."/forms-payment", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/forms-payment");

});

$app->get("/".DIR_ADMIN."/orders", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/orders");

});

$app->get("/".DIR_ADMIN."/site-contacts", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/site-contacts");

});

$app->get("/".DIR_ADMIN."/carts", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/carts");

});

$app->get("/".DIR_ADMIN."/credit-cards", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/credit-cards");

});

$app->get("/".DIR_ADMIN."/coupons", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/coupons");

});

$app->get("/".DIR_ADMIN."/configurations-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )

    ));

    $page->setTpl("/admin/configurations-types");

});

$app->get("/".DIR_ADMIN."/files", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $conf = Hcode\Session::getConfigurations();

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'app-media page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/files", array(
        'diretorio'=>$conf->getByName("UPLOAD_DIR")
    ));

});


$app->get("/".DIR_ADMIN."/courses", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/courses");

});

$app->get("/".DIR_ADMIN."/carousels", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/carousels");

});

$app->get("/".DIR_ADMIN."/carousels-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
         'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/carousels-types");

});

$app->get("/".DIR_ADMIN."/places", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/places");

});

$app->get("/".DIR_ADMIN."/countries", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/countries");

});

$app->get("/".DIR_ADMIN."/states", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/states");

});

$app->get("/".DIR_ADMIN."/cities", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/cities");

});

$app->get("/".DIR_ADMIN."/persons-categories-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/persons-categories-types");

});

$app->get("/".DIR_ADMIN."/urls", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/urls");

});

$app->get("/".DIR_ADMIN."/system/sql-to-class/tables", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $tables = Hcode\SQL\Tables::listAll();

    echo success(array(
        'data'=>$tables->getFields()
    ));

});

$app->get("/".DIR_ADMIN."/system/sql-to-class/tables/:tableName", function($tableName){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $table = Hcode\SQL\Table::loadFromName($tableName);

    $table->setdessingular($table->getSingularName());
    $table->setdesplural($table->getPluralName());
    $table->setdestabela($table->getName());

    echo success(array(
        'data'=>$table->getFields()
    ));

});

$app->post("/".DIR_ADMIN."/system/sql-to-class/execute", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    if (!post('destabela')) {
        throw new Exception("Informe o nome da tabela.", 400);
    }

    $table = Hcode\SQL\Table::loadFromName(post('destabela'));

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

    Rain\Tpl::configure(array(
        "base_url"      => PATH,
        "tpl_dir"       => PATH."/res/tpl/sql-to-class/",
        "cache_dir"     => PATH."/res/tpl/tmp/",
        "debug"         => false
    ));

    $tpl = new Rain\Tpl();

    if(gettype($data)=='array'){
        foreach($data as $key=>$val){
            $tpl->assign($key, $val);
        }
    }

    $template_code = $tpl->draw($tpl_name, true);

    $template_code = str_replace( array("&lt;?","?&gt;"), array("<?","?>"), $template_code );

    if ($download === false) {

        $sql = new Hcode\Sql();

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

        $sql->exec("DROP procedure IF EXISTS $spName;");

        $sql->exec($template_code);

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