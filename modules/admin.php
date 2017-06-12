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

$app->get("/".DIR_ADMIN."/", function(){

    header("Location: /".DIR_ADMIN);
    exit;

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

    Hcode\Admin\Menu::resetMenuSession();

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

    $user = Hcode\Session::getUser();
    $person = Hcode\Session::getPerson();

    $page->setTpl('/admin/lock', array(
        "user"=>$user->getFields(),
        "person"=>$person->getFields()
    ));

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

$app->get("/".DIR_ADMIN."/materiais-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/materiais-types");

});

$app->get("/".DIR_ADMIN."/materiais-units-types", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page(array(
        'data'=>array(
            'body'=>array(
                'class'=>'page-aside-fixed page-aside-left'
            )
        )
    ));

    $page->setTpl("/admin/materiais-units-types");

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

$app->post("/".DIR_ADMIN."/system/sql-to-class/check", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $tablename = post("table");
    $table = Hcode\SQL\Table::loadFromName($tablename);
    $tables = $table->getTablesReferences();

    echo success(array(
        'data'=>array(
            //"tables_ref"=>$tables->getFields(),
            "table"=>file_exists(PATH."/res/sql/tables/".$tablename.".sql"),
            "get"=>file_exists(PATH."/res/sql/procedures/get/".$table->getProcedureName("get").".sql"),
            "save"=>file_exists(PATH."/res/sql/procedures/save/".$table->getProcedureName("save").".sql"),
            "remove"=>file_exists(PATH."/res/sql/procedures/remove/".$table->getProcedureName("remove").".sql"),
            "list"=>file_exists(PATH."/res/sql/procedures/list/".$table->getProcedureName("list").".sql"),
            "inserts"=>file_exists(PATH."/res/sql/inserts/".$tablename.".sql"),
            "trigger_after_insert"=>file_exists(PATH."/res/sql/triggers/".str_replace("tb_", "tg_", $tablename)."_AFTER_INSERT.sql"),
            "trigger_before_insert"=>file_exists(PATH."/res/sql/triggers/".str_replace("tb_", "tg_", $tablename)."_BEFORE_INSERT.sql"),
            "trigger_after_update"=>file_exists(PATH."/res/sql/triggers/".str_replace("tb_", "tg_", $tablename)."_AFTER_UPDATE.sql"),
            "trigger_before_update"=>file_exists(PATH."/res/sql/triggers/".str_replace("tb_", "tg_", $tablename)."_BEFORE_UPDATE.sql"),
            "trigger_after_delete"=>file_exists(PATH."/res/sql/triggers/".str_replace("tb_", "tg_", $tablename)."_AFTER_DELETE.sql"),
            "trigger_before_delete"=>file_exists(PATH."/res/sql/triggers/".str_replace("tb_", "tg_", $tablename)."_BEFORE_DELETE.sql")
        )
    ));

});

$app->post("/".DIR_ADMIN."/system/sql-to-class/add-to-install", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $tablename = post("table");
    $item = post("item");
    $table = Hcode\SQL\Table::loadFromName($tablename);

    switch ($item) {

        case "table":

        $file = fopen(PATH."/res/sql/tables/".$table->getName().".sql", "w+");
        fwrite($file, $table->getCreate());
        fclose($file);

        $tablesNames = array();
        foreach ($table->getTablesReferences()->getFields() as $t) {

            if(isset($t["referenced_table_name"])) array_push($tablesNames, $t["referenced_table_name"]);
        }

        $file = fopen(PATH."/res/sql/references/".$table->getName().".json", "w+");
        fwrite($file, json_encode(array(
            "tables"=>$tablesNames
        )));
        fclose($file);

        break;

        case "get":
        case "save":
        case "remove":
        case "list":

        $file = fopen(PATH."/res/sql/procedures/".$item."/".$table->getProcedureName($item).".sql", "w+");
        fwrite($file, $table->getProcedureScriptFromTpl($item));
        fclose($file);
        
        break;

        case "inserts":

        $sql = new Hcode\Sql();

        $data = $sql->query("SELECT * FROM ".$table->getName());

        $valuesRows = array();

        foreach ($data as $row) {
            
            $columns = array();
            $values = array();

            foreach ($row as $key => $value) {

                if ($key !== "dtregister") {

                    array_push($columns, $key);
                    switch (gettype($value)) {
                        case "string":
                        array_push($values, "'".$value."'");
                        break;

                        default:
                        if (!$value) $value = 'NULL';
                        array_push($values, $value);
                        break;
                    }
                }
                
            }

            array_push($valuesRows, "(".implode(",", $values).")");

        }

        $insert = "INSERT INTO ".$table->getName()." (".implode(",", $columns).") VALUES\r\n".implode(",\r\n", $valuesRows).";";

        $file = fopen(PATH."/res/sql/inserts/".$table->getName().".sql", "w+");
        fwrite($file, $insert);
        fclose($file);

        break;

    }

    echo success();

});

$app->get("/".DIR_ADMIN."/system/sql-to-class/tables", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $tables = Hcode\SQL\Tables::listAll()->getFields();

    foreach ($tables as &$table) {
        
        $table["installer"] = file_exists(PATH."/res/sql/tables/".$table["Name"].".sql");

    }

    echo success(array(
        'data'=>$tables
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
        throw new Exception("Informe o nome da tabela.");
    }

    if (!isset($_POST['pks'])) {
        throw new Exception("Informe qual a coluna é a chave primária da tabela.");
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
        Rain\Tpl::configure(array("tpl_ext" => "php"));
        $tpl_name = post("filetype");
        break;

        case "get":
        case "list":
        case "save":
        case "remove":
        Rain\Tpl::configure(array("tpl_ext" => "sql"));
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

    $template_code = str_replace( array("&lt;?","&gt;","&quot;"), array("<?",">",'"'), $template_code );

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

$app->get("/".DIR_ADMIN."/sales-orders", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/sales-orders");

});

$app->get("/".DIR_ADMIN."/clients", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/clients");

});

$app->get("/".DIR_ADMIN."/stock", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/stock");

});

$app->get("/".DIR_ADMIN."/purshaces", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/purshaces");

});

$app->get("/".DIR_ADMIN."/providers", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/providers");

});

$app->get("/".DIR_ADMIN."/accounts", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/accounts");

});

$app->get("/".DIR_ADMIN."/bank-statement", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/bank-statement");

});

$app->get("/".DIR_ADMIN."/bills-to-pay", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/bills-to-pay");

});

$app->get("/".DIR_ADMIN."/bills-to-receive", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/bills-to-receive");

});

$app->get("/".DIR_ADMIN."/financial-categories", function(){

    Hcode\Admin\Permission::checkSession(Hcode\Admin\Permission::ADMIN, true);

    $page = new Hcode\Admin\Page();

    $page->setTpl("/admin/financial-categories");

});

?>