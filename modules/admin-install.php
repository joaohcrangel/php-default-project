<?php

define("PATH_PROC", PATH."/res/sql/procedures/");
define("PATH_TRIGGER", PATH."/res/sql/triggers/");
define("PATH_FUNCTION", PATH."/res/sql/functions/");

function saveProcedures($procs = array()){
	$sql = new Sql();
	foreach ($procs as $name) {
		$sql->exec("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
}
function saveTriggers($triggers = array()){
	$sql = new Sql();
	foreach ($triggers as $name) {
		$sql->exec("DROP TRIGGER IF EXISTS {$name};");
		$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	}
}
$app->get("/install", function(){

	unsetLocalCookie(COOKIE_KEY);
	if (isset($_SESSION)) unset($_SESSION);
	session_destroy();
	$page = new Page(array(
		'header'=>false,
		'footer'=>false
	));
	$page->setTpl("install/index");

});
$app->get("/install-admin/uploads/clear", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	foreach (scandir(PATH."/res/uploads") as $file) {
		if ($file !== '.' && $file !== '..') {
			unlink(PATH."/res/uploads/".$file);
		}
	}

	echo success();

});
$app->get("/install-admin/sql/clear", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();
	
	$procs = $sql->arrays("SHOW PROCEDURE STATUS WHERE Db = ?", array(
		DB_NAME
	));

	foreach ($procs as $row) {
		$sql->exec("DROP PROCEDURE IF EXISTS ".$row['Name'].";");
	}

	$funcs = $sql->arrays("SHOW FUNCTION STATUS WHERE Db = '".DB_NAME."';");
	foreach ($funcs as $row) {
		$sql->exec("DROP FUNCTION IF EXISTS ".$row['Name'].";");
	}
	$const = $sql->arrays("
		SELECT 
		  TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
		FROM
		  INFORMATION_SCHEMA.KEY_COLUMN_USAGE
		 WHERE
		  REFERENCED_TABLE_SCHEMA = '".DB_NAME."';
	");
	foreach ($const as $row) {
		$sql->exec("alter table ".$row['TABLE_NAME']." drop foreign key ".$row['CONSTRAINT_NAME'].";");
	}
	$tables = $sql->arrays("
		SHOW TABLES;
	");
	foreach ($tables as $row) {
		$sql->exec("DROP TABLE IF EXISTS ".$row['Tables_in_'.DB_NAME].";");
	}
	
	echo success();
});

// $app->get("/teste", function(){
// 	define("BANCO_DE_DADOS", [

// '127.0.0.1',
// 'root',
// 'password',
// 'test'

// ]);

// print_r(BANCO_DE_DADOS);
// });

$app->get("/install-admin/sql/persons/tables", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_personstypes (
		  idpersontype int(11) NOT NULL AUTO_INCREMENT,
		  despersontype varchar(64) NOT NULL,
		  dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpersontype)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_persons (
		  idperson int(11) NOT NULL AUTO_INCREMENT,
		  idpersontype int(1) NOT NULL,
		  desperson varchar(64) NOT NULL,
		  inremoved bit NOT NULL DEFAULT b'0',
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idperson),
		  KEY FK_personstypes (idpersontype),
		  CONSTRAINT FK_persons_personstypes FOREIGN KEY (idpersontype) REFERENCES tb_personstypes (idpersontype) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_logstypes (
			idlogtype int(11) NOT NULL AUTO_INCREMENT,
			deslogtype varchar(32) NOT NULL,
			dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (idlogtype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
        CREATE TABLE tb_personslogs (
			idpersonlog int(11) NOT NULL AUTO_INCREMENT,
			idperson int(11) NOT NULL,
			idlogtype int(11) NOT NULL,
			deslog varchar(512) NOT NULL,
			dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (idpersonlog),
			KEY fk_personslogs_logstypes (idlogtype),
			KEY fk_personslogs_persons_idx (idperson),
			CONSTRAINT fk_personslogs_logstypes FOREIGN KEY (idlogtype) REFERENCES tb_logstypes (idlogtype) ON DELETE NO ACTION ON UPDATE NO ACTION,
			CONSTRAINT fk_personslogs_persons FOREIGN KEY (idperson) REFERENCES tb_persons (idperson) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_personsvaluesfields(
			idfield INT NOT NULL AUTO_INCREMENT,
			desfield VARCHAR(128) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idfield)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_personsvalues(
			idpersonvalue INT NOT NULL AUTO_INCREMENT,
			idperson INT NOT NULL,
			idfield INT NOT NULL,
			desvalue VARCHAR(128) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idpersonvalue),
			CONSTRAINT FOREIGN KEY(idperson) REFERENCES tb_persons(idperson),
			CONSTRAINT FOREIGN KEY(idfield) REFERENCES tb_personsvaluesfields(idfield)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_personscategoriestypes (
		  idcategory int(11) NOT NULL AUTO_INCREMENT,
		  descategory varchar(32) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
		  PRIMARY KEY (idcategory)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=4 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_personscategories (
		  idperson int(11) NOT NULL,
		  idcategory int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP(),
		  PRIMARY KEY (idperson,idcategory),
		  KEY FK_personscategories_personscategoriestypes_idx (idcategory),
		  CONSTRAINT FK_personscategories_persons FOREIGN KEY (idperson) REFERENCES tb_persons (idperson) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_personscategories_personscategoriestypes FOREIGN KEY (idcategory) REFERENCES tb_personscategoriestypes (idcategory) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_pessoasdispositivos (
		  iddispositivo int(11) NOT NULL AUTO_INCREMENT,
		  idpessoa int(11) NOT NULL,
		  desdispositivo varchar(128) NOT NULL,
		  desid varchar(512) NOT NULL,
		  dessistema varchar(128) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (iddispositivo),
		  KEY FK_pessoasdispositivos_pessoas_idx (idpessoa),
		  CONSTRAINT FK_pessoasdispositivos_pessoas FOREIGN KEY (idpessoa) REFERENCES tb_pessoas (idpessoa) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/persons/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		"tg_persons_AFTER_INSERT",
		"tg_persons_AFTER_UPDATE",
		"tg_persons_BEFORE_DELETE",

		"tg_personsvalues_AFTER_INSERT",
		"tg_personsvalues_AFTER_UPDATE",
		"tg_personsvalues_BEFORE_DELETE"
	);
	saveTriggers($triggers);
	echo success();
});
$app->get("/install-admin/sql/persons/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();

	$persontypeF = new PessoaTipo(array(
		'despessoatipo'=>$lang->getString("pessoas_fisica")
	));
	$pessoatipoF->save();

	$pessoatipoJ = new PessoaTipo(array(
		'despessoatipo'=>$lang->getString("pessoas_juridica")
	));
	$pessoatipoJ->save();
	
	$pessoa = new PessoaTipo(array(
		'despessoa'=>$lang->getString("pessoas_nome"),
		'idpessoatipo'=>PessoaTipo::FISICA
	));
	$pessoa->save();

	$nascimento = new PessoaValorCampo(array(
		'desfield'=>$lang->getString('data_nascimento')
	));
	$nascimento->save();
	$sexo = new PessoaValorCampo(array(
		'desfield'=>$lang->getString('sexo')
	));
	$sexo->save();
	$foto = new PessoaValorCampo(array(
		'desfield'=>$lang->getString('foto')
	));
	$foto->save();
	$cliente = new PessoaCategoriaTipo(array(
		'idcategory'=>0,
		'descategory'=>$lang->getString('pessoa_cliente')
	));
	$cliente->save();
	$fornecedor = new PessoaCategoriaTipo(array(
		'idcategory'=>0,
		'descategory'=>$lang->getString('pessoa_fornecedor')
	));
	$fornecedor->save();
	$colaborador = new PessoaCategoriaTipo(array(
		'idcategory'=>0,
		'descategory'=>$lang->getString('pessoa_colaborador')
	));
	$colaborador->save();
	echo success();
	
});
$app->get("/install-admin/sql/persons/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_persons_get",
		"sp_logstypes_get",
		"sp_personslogs_get",
		"sp_personsvalues_get",
		"sp_personsvaluesfields_get",
		"sp_personstypes_get",
		"sp_personscategoriestypes_get"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/persons/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_persons_list",
		"sp_personstypes_list",
        "sp_logstypes_list",
        "sp_personsvalues_list",
        "sp_personsvaluesfields_list",
        "sp_personscategoriestypes_list"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/persons/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
		"sp_personsdados_save",
		"sp_persons_save",
		"sp_logstypes_save",
		"sp_personsvalues_save",
		"sp_personsvaluesfields_save",
		"sp_personstypes_save",
		"sp_personscategoriestypes_save"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/persons/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
		"sp_personsdados_remove",
		"sp_persons_remove",
		"sp_logstypes_remove",
		"sp_personsvalues_remove",
		"sp_personsvaluesfields_remove",
		"sp_personstypes_remove",
		"sp_personscategoriestypes_remove"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/products/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_productstypes(
			idproducttype INT NOT NULL AUTO_INCREMENT,
			desproducttype VARCHAR(64) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idproducttype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_products(
			idproduct INT NOT NULL AUTO_INCREMENT,
			idproducttype INT NOT NULL,
			desproduct VARCHAR(64) NOT NULL,
			inremoved BIT(1) NOT NULL DEFAULT b'0',
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT PRIMARY KEY(idproduct),
			CONSTRAINT FOREIGN KEY(idproducttype) REFERENCES tb_productstypes(idproducttype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_productsprices(
			idprice INT NOT NULL AUTO_INCREMENT,
			idproduct INT NOT NULL,
			dtstart DATETIME NOT NULL,
			dtend DATETIME DEFAULT NULL,
			vlprice DECIMAL(10,2) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idprice),
			CONSTRAINT FOREIGN KEY(idproduct) REFERENCES tb_products(idproduct)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/products/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		"tg_products_AFTER_INSERT",
		"tg_products_AFTER_UPDATE",
		"tg_products_BEFORE_DELETE",
		
		"tg_productsprices_AFTER_INSERT",
		"tg_productsprices_AFTER_UPDATE",
		"tg_productsprices_BEFORE_DELETE"
	);
	saveTriggers($triggers);
	
	echo success();
});
$app->get("/install-admin/sql/products/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$lang = new Language();

	$cursoUdemy = new ProdutoTipo(array(
		'desproducttype'=>$lang->getString('products_curso')
	));
	$cursoUdemy->save();

	$camiseta = new ProdutoTipo(array(
		'desproducttype'=>$lang->getString('products_camiseta')
	));
	$camiseta->save();

	echo success();

});
$app->get("/install-admin/sql/products/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_product_get",
		"sp_producttype_get",
		"sp_productsprices_get"
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/products/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_products_list",
		"sp_productstypes_list",
		"sp_productsprices_list",
		"sp_carrinhosfromproduct_list",
		"sp_pedidosfromproduct_list",
		"sp_pricesfromproduct_list"
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/products/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_product_save",
		"sp_producttype_save",
		"sp_productsprices_save",
		"sp_productsdados_save"
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/products/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_product_remove",
		"sp_producttype_remove",
		"sp_productsprices_remove",
		"sp_productsdados_remove"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/users/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_userstypes (
		  idusertype int(11) NOT NULL AUTO_INCREMENT,
		  desusertype varchar(32) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idusertype)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_users (
		  iduser int(11) NOT NULL AUTO_INCREMENT,
		  idperson int(11) NOT NULL,
		  desuser varchar(128) NOT NULL,
		  despassword varchar(256) NOT NULL,
		  inblocked bit(1) NOT NULL DEFAULT b'0',
		  idusertype int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (iduser),
		  CONSTRAINT FK_users_persons FOREIGN KEY (idperson) REFERENCES tb_persons (idperson) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_users_userstypes FOREIGN KEY (idusertype) REFERENCES tb_userstypes (idusertype) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/users/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		"tg_users_AFTER_INSERT",
		"tg_users_AFTER_UPDATE",
		"tg_users_BEFORE_DELETE"
	);
	saveTriggers($triggers);
	echo success();
});
$app->get("/install-admin/sql/users/inserts", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

    $lang = new Language();

	$sql = new Sql();
	$hash = user::getPasswordHash($lang->getString('users_root'));

	$sql->proc("sp_userstypes_save", array(
		0,
		$lang->getString('users_admin')
	));
	$sql->proc("sp_userstypes_save", array(
		0,
		$lang->getString('users_clientes')
	));
	
	$sql->arrays("
		INSERT INTO tb_users (idperson, desuser, despassword, idusertype) VALUES
		(?, ?, ?, ?);
	", array(
		1, $lang->getString('users_root'), $hash, 1
	));

	echo success();
});
$app->get("/install-admin/sql/users/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_users_get",
		"sp_userslogin_get",
		"sp_usersfromemail_get",
		"sp_usersfrommenus_list",
		"sp_userstypes_get"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/users/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_users_remove",
		"sp_userstypes_remove"
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/users/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_users_save",
		"sp_userstypes_save"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/users/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
        "sp_userstypes_list",
        "sp_usersfromperson_list",
        "sp_users_list"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/menus/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_menus (
		  idmenu int(11) NOT NULL AUTO_INCREMENT,
		  idmenufather int(11) DEFAULT NULL,
		  desmenu varchar(128) NOT NULL,
		  desicon varchar(64) NOT NULL,
		  deshref varchar(64) NOT NULL,
		  nrorder int(11) NOT NULL,
		  nrsubmenus int(11) DEFAULT '0' NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idmenu),
		  CONSTRAINT FK_menus_menus FOREIGN KEY (idmenufather) REFERENCES tb_menus (idmenu) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_menususers (
		  idmenu int(11) NOT NULL,
		  iduser int(11) NOT NULL,
		  CONSTRAINT FOREIGN KEY FK_usersmenuspersons (iduser) REFERENCES tb_users(iduser),
		  CONSTRAINT FOREIGN KEY FK_usersmenusmenus (idmenu) REFERENCES tb_menus(idmenu)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->exec("
		CREATE TABLE tb_sitesmenus (
		  idmenu int(11) NOT NULL AUTO_INCREMENT,
		  idmenufather int(11) DEFAULT NULL,
		  desmenu varchar(128) NOT NULL,
		  desicon varchar(64) NOT NULL,
		  deshref varchar(64) NOT NULL,
		  nrorder int(11) NOT NULL,
		  nrsubmenus int(11) DEFAULT '0' NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idmenu),
		  CONSTRAINT FK_sitesmenus_sitesmenus FOREIGN KEY (idmenufather) REFERENCES tb_sitesmenus (idmenu) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/menus/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();

	//////////////////////////////////////
	$menuDashboard = new Menu(array(
		'nrorder'=>0,
		'idmenufather'=>NULL,
		'desicon'=>'md-view-dashboard',
		'deshref'=>'/',
		'desmenu'=>$lang->getString('menus_dashboard')
	));
	$menuDashboard->save();
	//////////////////////////////////////
	$menuSistema = new Menu(array(
		'nrorder'=>1,
		'idmenufather'=>NULL,
		'desicon'=>'md-code-setting',
		'deshref'=>'',
		'desmenu'=>$lang->getString('menus_sistema')
	));
	$menuSistema->save();
	//////////////////////////////////////
	$menuAdmin = new Menu(array(
		'nrorder'=>2,
		'idmenufather'=>NULL,
		'desicon'=>'md-settings',
		'deshref'=>'',
		'desmenu'=>$lang->getString('menus_administracao')
	));
	$menuAdmin->save();
	//////////////////////////////////////
	$menupersons = new Menu(array(
		'nrorder'=>3,
		'idmenufather'=>NULL,
		'desicon'=>'md-accounts',
		'deshref'=>'/persons',
		'desmenu'=>$lang->getString('menus_person')
	));
	$menupersons->save();
	//////////////////////////////////////
	$menutypes = new Menu(array(
		'nrorder'=>0,
		'idmenufather'=>$menuAdmin->getidmenu(),
		'desicon'=>'md-collection-item',
		'deshref'=>'',
		'desmenu'=>$lang->getString('menus_type')
	));
	$menutypes->save();
	//////////////////////////////////////
	$menuMenu = new Menu(array(
		'nrorder'=>1,
		'idmenufather'=>$menuAdmin->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/sistema/menu',
		'desmenu'=>$lang->getString('menus_menu')
	));
	$menuMenu->save();
	//////////////////////////////////////
	$menuusers = new Menu(array(
		'nrorder'=>2,
		'idmenufather'=>$menuAdmin->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/sistema/users',
		'desmenu'=>$lang->getString('menus_user')
	));
	$menuusers->save();
	//////////////////////////////////////
	$menuConfigs = new Menu(array(
		'nrorder'=>3,
		'idmenufather'=>$menuAdmin->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/sistema/configuracoes',
		'desmenu'=>$lang->getString('menus_configuracoes')
	));
	$menuConfigs->save();
	//////////////////////////////////////
	$menuSqlToClass = new Menu(array(
		'nrorder'=>0,
		'idmenufather'=>$menuSistema->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/sistema/sql-to-class',
		'desmenu'=>$lang->getString('menus_sql_to_class')
	));
	$menuSqlToClass->save();
	//////////////////////////////////////
	$menuTemplate = new Menu(array(
		'nrorder'=>1,
		'idmenufather'=>$menuSistema->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/../res/theme/material/base/html/index.html',
		'desmenu'=>$lang->getString('menus_template')
	));
	$menuTemplate->save();
	//////////////////////////////////////
	$menuExemplos = new Menu(array(
		'nrorder'=>2,
		'idmenufather'=>$menuSistema->getidmenu(),
		'desicon'=>'',
		'deshref'=>'',
		'desmenu'=>$lang->getString('menus_exemplos')
	));
	$menuExemplos->save();
	//////////////////////////////////////
	$menuUpload = new Menu(array(
		'nrorder'=>0,
		'idmenufather'=>$menuExemplos->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/exemplos/upload',
		'desmenu'=>$lang->getString('menus_exemplos_upload')
	));
	$menuUpload->save();
	//////////////////////////////////////
	$menuPermissoes = new Menu(array(
		'nrorder'=>3,
		'idmenufather'=>$menuAdmin->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/permissoes',
		'desmenu'=>$lang->getString('menus_permissoes')
	));
	$menuPermissoes->save();
	//////////////////////////////////////
	$menuproducts = new Menu(array(
		'nrorder'=>4,
		'idmenufather'=>NULL,
		'desicon'=>'md-devices',
		'deshref'=>'/products',
		'desmenu'=>$lang->getString('menus_product')
	));
	$menuproducts->save();
	//////////////////////////////////////
	$menutypesadresses = new Menu(array(
		'nrorder'=>0,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/adresses-types',
		'desmenu'=>$lang->getString('menus_adress')
	));
	$menutypesadresses->save();
	//////////////////////////////////////
	$menutypesusers = new Menu(array(
		'nrorder'=>1,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/users-types',
		'desmenu'=>$lang->getString('menus_user_type')
	));
	$menutypesusers->save();
	//////////////////////////////////////
	$menutypesdocuments = new Menu(array(
		'nrorder'=>2,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/documents-types',
		'desmenu'=>$lang->getString('menus_document_type')
	));
	$menutypesdocuments->save();
	//////////////////////////////////////
	$menutypesLugares = new Menu(array(
		'nrorder'=>3,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/lugares-types',
		'desmenu'=>$lang->getString('menus_lugar_type')
	));
	$menutypesLugares->save();
	//////////////////////////////////////
	$menutypesCupons = new Menu(array(
		'nrorder'=>4,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/cupons-types',
		'desmenu'=>$lang->getString('menus_cupom_type')
	));
	$menutypesCupons->save();
	//////////////////////////////////////
	$menutypesproducts = new Menu(array(
		'nrorder'=>5,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/products-types',
		'desmenu'=>$lang->getString('menus_product_type')
	));
	$menutypesproducts->save();
	//////////////////////////////////////
	$menuPedidosStatus = new Menu(array(
		'nrorder'=>6,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/pedidos-status',
		'desmenu'=>$lang->getString('menus_pedido_statu')
	));
	$menuPedidosStatus->save();
	//////////////////////////////////////
	$menupersonstypes = new Menu(array(
		'nrorder'=>7,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/persons-types',
		'desmenu'=>$lang->getString('menus_person_type')
	));
	$menupersonstypes->save();
	//////////////////////////////////////
	$menucontactstypes = new Menu(array(
		'nrorder'=>8,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/contacts-types',
		'desmenu'=>$lang->getString('menus_contact_type')
	));
	$menucontactstypes->save();
	//////////////////////////////////////
	$menuGateways = new Menu(array(
		'nrorder'=>9,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/gateways',
		'desmenu'=>$lang->getString('menus_gateway')
	));
	$menuGateways->save();
	//////////////////////////////////////
	$menuHistoricostypes = new Menu(array(
		'nrorder'=>10,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/logs-types',
		'desmenu'=>$lang->getString('menus_log_type')
	));
	$menuHistoricostypes->save();
	//////////////////////////////////////
	$menuFormasPedidos = new Menu(array(
		'nrorder'=>11,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/formas-pagamentos',
		'desmenu'=>$lang->getString('menus_forma_pedido')
	));
	$menuFormasPedidos->save();
	//////////////////////////////////////
	$menupersonsvaluesfields = new Menu(array(
		'nrorder'=>11,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/persons-valuesfields',
		'desmenu'=>$lang->getString('menus_person_value')
	));
	$menupersonsvaluesfields->save();
	//////////////////////////////////////
	$menuConfiguracoestypes = new Menu(array(
		'nrorder'=>12,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/configuracoes-types',
		'desmenu'=>$lang->getString('menus_configuracao_type')
	));
	$menuConfiguracoestypes->save();
	//////////////////////////////////////
	$menuCarouselsItemstypes = new Menu(array(
		'nrorder'=>13,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/carousels-types',
		'desmenu'=>$lang->getString('menus_carousel_type')
	));
	$menuCarouselsItemstypes->save();
	//////////////////////////////////////
	$menuPedidosNegociacoestypes = new Menu(array(
		'nrorder'=>13,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/pedidosnegociacoestypes',
		'desmenu'=>$lang->getString('menus_negociacao_type')
	));
	$menuPedidosNegociacoestypes->save();
	//////////////////////////////////////
	$menuPedidos = new Menu(array(
		"nrorder"=>5,
		"idmenufather"=>NULL,
		"desicon"=>'md-money-box',
		"deshref"=>'/pedidos',
		"desmenu"=>$lang->getString('menus_pedido')
	));
	$menuPedidos->save();
	//////////////////////////////////////
	$menuCarrinhos = new Menu(array(
		"nrorder"=>6,
		"idmenufather"=>NULL,
		"desicon"=>"md-shopping-cart",
		"deshref"=>"/carrinhos",
		"desmenu"=>$lang->getString('menus_carrinho')
	));
	$menuCarrinhos->save();
	//////////////////////////////////////
	$menuLugares = new Menu(array(
		"nrorder"=>7,
		"idmenufather"=>NULL,
		"desicon"=>"md-city",
		"deshref"=>"/lugares",
		"desmenu"=>$lang->getString('menus_lugar')
	));
	$menuLugares->save();
	//////////////////////////////////////
	$menuSite = new Menu(array(
		"nrorder"=>8,
		"idmenufather"=>NULL,
		"desicon"=>"md-view-web",
		"deshref"=>"",
		"desmenu"=>$lang->getString('menus_site')
	));
	$menuSite->save();
	//////////////////////////////////////
	$menuSiteMenu = new Menu(array(
		"nrorder"=>0,
		"idmenufather"=>$menuSite->getidmenu(),
		"desicon"=>"",
		"deshref"=>"/site/menu",
		"desmenu"=>$lang->getString('menus_site_menu')
	));
	$menuSiteMenu->save();
	//////////////////////////////////////
	$menuCursos = new Menu(array(
		"nrorder"=>9,
		"idmenufather"=>NULL,
		"desicon"=>"md-book",
		"deshref"=>"/cursos",
		"desmenu"=>$lang->getString('menus_cursos')
	));
	$menuCursos->save();
	//////////////////////////////////////
	$menuCarousels = new Menu(array(
		"nrorder"=>1,
		"idmenufather"=>$menuSite->getidmenu(),
		"desicon"=>"",
		"deshref"=>"/carousels",
		"desmenu"=>$lang->getString('menus_carousels')
	));
	$menuCarousels->save();
	//////////////////////////////////////
	$menupaises = new Menu(array(
		"nrorder"=>5,
		"idmenufather"=>$menuAdmin->getidmenu(),
		"desicon"=>"",
		"deshref"=>"/paises",
		"desmenu"=>$lang->getString('menus_paises')
	));
	$menupaises->save();
	//////////////////////////////////////
	$menuEstados = new Menu(array(
		"nrorder"=>6,
		"idmenufather"=>$menuAdmin->getidmenu(),
		"desicon"=>"",
		"deshref"=>"/estados",
		"desmenu"=>$lang->getString('menus_estados')
	));
	$menuEstados->save();
	//////////////////////////////////////
	$menuCidades = new Menu(array(
		"nrorder"=>7,
		"idmenufather"=>$menuAdmin->getidmenu(),
		"desicon"=>"",
		"deshref"=>"/cidades",
		"desmenu"=>$lang->getString('menus_cidades')
	));
	$menuCidades->save();
	//////////////////////////////////////
	$menuCidades = new Menu(array(
		"nrorder"=>8,
		"idmenufather"=>$menuAdmin->getidmenu(),
		"desicon"=>"",
		"deshref"=>"/arquivos",
		"desmenu"=>$lang->getString('menus_arquivos')
	));
	$menuCidades->save();
	//////////////////////////////////////
	$menupersonscategoriestypes = new Menu(array(
		'nrorder'=>14,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/persons-categories-types',
		'desmenu'=>$lang->getString('menus_persons_categories_types')
	));
	$menupersonscategoriestypes->save();
	//////////////////////////////////////
	$menuUrls = new Menu(array(
		'nrorder'=>10,
		'idmenufather'=>NULL,
		'desicon'=>'md-link',
		'deshref'=>'/urls',
		'desmenu'=>$lang->getString('menus_urls')
	));
	$menuUrls->save();
	//////////////////////////////////////	
	
	echo success();
});
$app->get("/install-admin/sql/menus/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
       "sp_menus_get",
       "sp_sitesmenus_get"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/menus/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
        "sp_menus_list",
        "sp_sitesmenus_list"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/menus/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
       "sp_menus_remove",
       "sp_sitesmenus_remove"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/menus/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_menusfromuser_list",
		"sp_menustrigger_save",
		"sp_menus_save",
		"sp_sitesmenustrigger_save",
		"sp_sitesmenus_save"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/contacts/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_contactstypes (
		  idcontacttype int(11) NOT NULL AUTO_INCREMENT,
		  descontacttype varchar(64) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idcontacttype)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_contactssubtypes (
		  idcontactsubtype int NOT NULL AUTO_INCREMENT,
		  descontactsubtype varchar(32) NOT NULL,
		  idcontacttype int NOT NULL,
		  iduser int NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idcontactsubtype),
		  KEY FK_contactstypes (idcontacttype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_contacts (
		  idcontact int(11) NOT NULL AUTO_INCREMENT,
		  idcontactsubtype int(11) NOT NULL,
		  idperson int(11) NOT NULL,
		  descontact varchar(128) NOT NULL,
		  inprincipal bit(1) NOT NULL DEFAULT b'0',
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idcontact),
		  CONSTRAINT FOREIGN KEY FK_contactssubtypes (idcontactsubtype) REFERENCES tb_contactssubtypes(idcontactsubtype),
		  CONSTRAINT FOREIGN KEY FK_personscontacts (idperson) REFERENCES tb_persons(idperson)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/contacts/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		"tg_contacts_AFTER_INSERT",
		"tg_contacts_AFTER_UPDATE",
		"tg_contacts_BEFORE_DELETE"
	);
	saveTriggers($triggers);
    
	echo success();
});
$app->get("/install-admin/sql/contacts/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();
	
	$email = new ContatoTipo(array(
		'descontatotipo'=>$lang->getString('contato_tipo')
	));
	$email->save();

	$telefone = new ContatoTipo(array(
		'descontatotipo'=>$lang->getString('telefone_tipo')
	));
	$telefone->save();

	$telefoneCasa = new ContatoSubTipo(array(
		'idcontatotipo'=>$telefone->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('casa_tipo')
	));
	$telefoneCasa->save();

	$telefoneTrabalho = new ContatoSubTipo(array(
		'idcontatotipo'=>$telefone->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('trabalho_tipo')
	));
	$telefoneTrabalho->save();

	$telefoneCelular = new ContatoSubTipo(array(
		'idcontatotipo'=>$telefone->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('celular_tipo')
	));
	$telefoneCelular->save();

	$telefoneFax = new ContatoSubTipo(array(
		'idcontatotipo'=>$telefone->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('fax_tipo')
	));
	$telefoneFax->save();

	$telefoneOutro = new ContatoSubTipo(array(
		'idcontatotipo'=>$telefone->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('outro_tipo')
	));
	$telefoneOutro->save();

	$emailpersonl = new ContatoSubTipo(array(
		'idcontatotipo'=>$email->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('personl_tipo')
	));
	$emailpersonl->save();

	$emailTrabalho = new ContatoSubTipo(array(
		'idcontatotipo'=>$email->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('trabalho_tipo')
	));
	$emailTrabalho->save();

	$emailOutro = new ContatoSubTipo(array(
		'idcontatotipo'=>$email->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('outro_tipo_email')
	));
	$emailOutro->save();

	echo success();
	
});
$app->get("/install-admin/sql/contacts/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_contacts_get",
		"sp_contactssubtypes_get",
		"sp_contactstypes_get"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/contacts/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_contactsfromperson_list",
		"sp_contactstypes_list",
		"sp_contactssubtypes_list"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/contacts/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_contacts_save",
		"sp_contactssubtypes_save",
		"sp_contactstypes_save"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/contacts/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_contacts_remove",
		"sp_contactssubtypes_remove",
		"sp_contactstypes_remove"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/documents/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_documentstypes (
		  iddocumenttype int(11) NOT NULL AUTO_INCREMENT,
		  desdocumenttype varchar(64) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (iddocumenttype)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_documents (
		  iddocument int(11) NOT NULL AUTO_INCREMENT,
		  iddocumenttype int(11) NOT NULL,
		  idperson int(11) NOT NULL,
		  desdocument varchar(64) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (iddocument),
		  CONSTRAINT FK_personsdocuments FOREIGN KEY (idperson) REFERENCES tb_persons(idperson),
		  CONSTRAINT FK_documents FOREIGN KEY (iddocumenttype) REFERENCES tb_documentstypes(iddocumenttype)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/documents/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		"tg_documents_AFTER_INSERT",
		"tg_documents_AFTER_UPDATE",
		"tg_documents_BEFORE_DELETE"
	);
	saveTriggers($triggers);
	echo success();
});
$app->get("/install-admin/sql/documents/inserts", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->arrays("
		INSERT INTO tb_documentstypes (desdocumenttype) VALUES
		(?),
		(?),
		(?);
	", array(
		'CPF',
		'CNPJ',
		'RG'
	));
	echo success();
});
$app->get("/install-admin/sql/documents/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
        "sp_documents_get",
        "sp_documentstypes_get"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/documents/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_documentsfromperson_list",
		"sp_documentstypes_list"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/documents/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
       "sp_documents_save",
       "sp_documentstypes_save"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/documents/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
        "sp_documents_remove",
        "sp_documentstypes_remove"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/adresses/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_paises (
		  idpais int(11) NOT NULL AUTO_INCREMENT,
		  despais varchar(64) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idpais)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_estados (
		  idestado int(11) NOT NULL AUTO_INCREMENT,
		  desestado varchar(64) NOT NULL,
		  desuf char(2) NOT NULL,
		  idpais int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idestado),
		  KEY FK_estados_paises_idx (idpais),
		  CONSTRAINT FK_estados_paises FOREIGN KEY (idpais) REFERENCES tb_paises (idpais) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_cidades (
		  idcidade int(11) NOT NULL AUTO_INCREMENT,
		  descidade varchar(128) NOT NULL,
		  idestado int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcidade),
		  KEY FK_cidades_estados_idx (idestado),
		  CONSTRAINT FK_cidades_estados FOREIGN KEY (idestado) REFERENCES tb_estados (idestado) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_adressestypes (
		  idadresstype int(11) NOT NULL AUTO_INCREMENT,
		  desadresstype varchar(64) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idadresstype)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_adresses (
		  idadress int(11) NOT NULL AUTO_INCREMENT,
		  idadresstype int(11) NOT NULL,
		  desadress varchar(64) NOT NULL,
		  desnumber varchar(16) NOT NULL,
		  desbairro varchar(64) NOT NULL,
		  descidade varchar(64) NOT NULL,
		  desestado varchar(32) NOT NULL,
		  despai varchar(32) NOT NULL,
		  descep char(8) NOT NULL,
		  descomplemento varchar(32) DEFAULT NULL,
		  inprincipal bit(1) NOT NULL DEFAULT b'0',
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idadress),
		  CONSTRAINT FK_adressestypes FOREIGN KEY (idadresstype) REFERENCES tb_adressestypes(idadresstype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/adresses/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		"tg_adresses_AFTER_INSERT",
		"tg_adresses_AFTER_UPDATE",
		"tg_adresses_BEFORE_DELETE"
	);
	saveTriggers($triggers);
	echo success();
});
$app->get("/install-admin/sql/adresses/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();

	$residencial = new EnderecoTipo(array(
		'desenderecotipo'=>$lang->getString('endereco_residencial')
	));
	$residencial->save();

	$comercial = new EnderecoTipo(array(
		'desenderecotipo'=>$lang->getString('endereco_comercial')
	));
	$comercial->save();

	$cobranca = new EnderecoTipo(array(
		'desenderecotipo'=>$lang->getString('endereco_cobranca')
	));
	$cobranca->save();

	$entrega = new EnderecoTipo(array(
		'desenderecotipo'=>$lang->getString('endereco_entrega')
	));
	$entrega->save();

	echo success();

});
$app->get("/install-admin/sql/adresses/paises/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();
	$sql->arrays("
		INSERT INTO tb_paises (idpais, despais) VALUES (1, 'Brasil');
	");

	echo success();

});
$app->get("/install-admin/sql/adresses/estados/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();

	$sql = new Sql();

	$sql->arrays("
		INSERT INTO tb_estados (idestado, desestado, desuf, idpai) VALUES
		(1, '".utf8_decode($lang->getString("estado_AC"))."', 'AC', 1),
		(2, '".utf8_decode($lang->getString("estado_AL"))."', 'AL', 1),
		(3, '".utf8_decode($lang->getString("estado_AM"))."', 'AM', 1),
		(4, '".utf8_decode($lang->getString("estado_AP"))."', 'AP', 1),
		(5, '".utf8_decode($lang->getString("estado_BA"))."', 'BA', 1),
		(6, '".utf8_decode($lang->getString("estado_CE"))."', 'CE', 1),
		(7, '".utf8_decode($lang->getString("estado_DF"))."', 'DF', 1),
		(8, '".utf8_decode($lang->getString("estado_ES"))."', 'ES', 1),
		(9, '".utf8_decode($lang->getString("estado_GO"))."', 'GO', 1),
		(10, '".utf8_decode($lang->getString("estado_MA"))."', 'MA', 1),
		(11, '".utf8_decode($lang->getString("estado_MG"))."', 'MG', 1),
		(12, '".utf8_decode($lang->getString("estado_MS"))."', 'MS', 1),
		(13, '".utf8_decode($lang->getString("estado_MT"))."', 'MT', 1),
		(14, '".utf8_decode($lang->getString("estado_PA"))."', 'PA', 1),
		(15, '".utf8_decode($lang->getString("estado_PB"))."', 'PB', 1),
		(16, '".utf8_decode($lang->getString("estado_PE"))."', 'PE', 1),
		(17, '".utf8_decode($lang->getString("estado_PI"))."', 'PI', 1),
		(18, '".utf8_decode($lang->getString("estado_PR"))."', 'PR', 1),
		(19, '".utf8_decode($lang->getString("estado_RJ"))."', 'RJ', 1),
		(20, '".utf8_decode($lang->getString("estado_RN"))."', 'RN', 1),
		(21, '".utf8_decode($lang->getString("estado_RO"))."', 'RO', 1),
		(22, '".utf8_decode($lang->getString("estado_RR"))."', 'RR', 1),
		(23, '".utf8_decode($lang->getString("estado_RS"))."', 'RS', 1),
		(24, '".utf8_decode($lang->getString("estado_SC"))."', 'SC', 1),
		(25, '".utf8_decode($lang->getString("estado_SE"))."', 'SE', 1),
		(26, '".utf8_decode($lang->getString("estado_SP"))."', 'SP', 1),
		(27, '".utf8_decode($lang->getString("estado_TO"))."', 'TO', 1);
	");

	echo success();

});
$app->post("/install-admin/sql/adresses/cidades/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$data = json_decode(post('json'), true);

	$sql = new Sql();

	foreach ($data as $city) {
		$sql->arrays("
			INSERT INTO tb_cidades (idcidade, descidade, idestado)
			VALUES(?, ?, ?);
		", array(
			(int)$city['idcidade'],
			$city['descidade'],
			(int)$city['idestado']
		));
	}	

	echo success();

});
$app->get("/install-admin/sql/adresses/cidades/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();
	
	$results = $sql->arrays("SELECT * FROM tb_cidades");

	echo json_encode($results);

});
$app->get("/install-admin/sql/pedidosnegociacoestypes/inserts", function(){ 

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();
	
	$results = $sql->arrays("SELECT * FROM tb_pedidosnegociacoestypes");

	echo json_encode($results);

});
$app->get("/install-admin/sql/adresses/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
        "sp_adresses_get",
        "sp_adressestypes_get",
        "sp_paises_get",
        "sp_estados_get",
        "sp_cidades_get"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/adresses/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
        "sp_adressesfromperson_list",
        "sp_adressestypes_list",
        "sp_paises_list",
        "sp_estados_list",
        "sp_cidades_list",
        "sp_adressesfromlugar_list"
    );
    saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/adresses/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
       "sp_adresses_save",
       "sp_adressestypes_save",
       "sp_paises_save",
       "sp_estados_save",
       "sp_cidades_save",
       "sp_personsadresses_save"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/adresses/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
       "sp_adresses_remove",
       "sp_adressestypes_remove",
       "sp_paises_remove",
       "sp_estados_remove",
       "sp_cidades_remove"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/permissoes/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_permissoes (
		  idpermissao int(11) NOT NULL AUTO_INCREMENT,
		  despermissao varchar(64) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpermissao)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_permissoesmenus (
		  idpermissao int(11) NOT NULL,
		  idmenu int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpermissao, idmenu),
		  CONSTRAINT FK_menuspermissoes FOREIGN KEY (idmenu) REFERENCES tb_menus (idmenu),
		  CONSTRAINT FK_permissoesmenus FOREIGN KEY (idpermissao) REFERENCES tb_permissoes (idpermissao)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_permissoesusers (
		  idpermissao int(11) NOT NULL,
		  iduser int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpermissao, iduser),
		  CONSTRAINT FK_permissoesusers FOREIGN KEY (idpermissao) REFERENCES tb_permissoes (idpermissao),
		  CONSTRAINT FK_userspermissoes FOREIGN KEY (iduser) REFERENCES tb_users (iduser)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/permissoes/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();
	
	$superuser = new Permissao(array(
		'despermissao'=>$lang->getString('permissoes_user')
	));
	$superuser->save();

	$acessoAdmin = new Permissao(array(
		'despermissao'=>$lang->getString('permissoes_administrativo')
	));
	$acessoAdmin->save();

	$acessoClient = new Permissao(array(
		'despermissao'=>$lang->getString('permissoes_cliente')
	));
	$acessoClient->save();

	$sql = new Sql();

	$sql->arrays("
		INSERT INTO tb_permissoesmenus (idmenu, idpermissao)
		SELECT idmenu, 1 FROM tb_menus;
	", array());

	$sql->arrays("
		INSERT INTO tb_permissoesusers (iduser, idpermissao) VALUES
		(?, ?),
		(?, ?);
	", array(
		1, 1,
		1, 2
	));
	echo success();
});
$app->get("/install-admin/sql/permissoes/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_permissoes_get',
		'sp_permissoesfrommenus_list',
		'sp_permissoesfrommenusfaltantes_list',
		'sp_permissoes_list'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/permissoes/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	echo success();
});
$app->get("/install-admin/sql/permissoes/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_permissoes_save",
		"sp_permissoesmenus_save"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/permissoes/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_permissoes_remove",
		"sp_permissoesmenus_remove"
	);
	saveProcedures($procs);
	
	echo success();
});

// AQUI O RAFA PARA


// DAQUI PRA BAIXO É O RONALDO



$app->get("/install-admin/sql/personsdados/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_personsdados (
		  idperson int(11) NOT NULL,
		  desperson varchar(128) NOT NULL,
		  desnome varchar(32) NOT NULL,
		  desprimeironome varchar(64) NOT NULL,
		  desultimonome varchar(64) NOT NULL,
		  idpersontype int(11) NOT NULL,
		  despersontype varchar(64) NOT NULL,
		  desuser varchar(128) DEFAULT NULL,
		  despassword varchar(256) DEFAULT NULL,
		  iduser int(11) DEFAULT NULL,
		  inblocked bit(1) DEFAULT NULL,
		  desemail varchar(128) DEFAULT NULL,
		  idemail int(11) DEFAULT NULL,
		  destelefone varchar(32) DEFAULT NULL,
		  idtelefone int(11) DEFAULT NULL,
		  descpf char(11) DEFAULT NULL,
		  idcpf int(11) DEFAULT NULL,
		  descnpj char(14) DEFAULT NULL,
		  idcnpj int(11) DEFAULT NULL,
		  desrg varchar(16) DEFAULT NULL,
		  idrg int(11) DEFAULT NULL,
		  dtatualizacao datetime NOT NULL,
		  dessexo ENUM('M', 'F'),
		  dtnascimento DATE DEFAULT NULL,
		  desfoto varchar(128) DEFAULT NULL,
		  incliente BIT NOT NULL DEFAULT b'0',
		  infornecedor BIT NOT NULL DEFAULT b'0',
		  incolaborador BIT NOT NULL DEFAULT b'0',
		  idadress int(11) DEFAULT NULL,
		  idadresstype int(11) DEFAULT NULL,
		  desadresstype varchar(64) DEFAULT NULL,
		  desadress varchar(64) DEFAULT NULL, 
		  desnumber varchar(16) DEFAULT NULL, 
		  desbairro varchar(64) DEFAULT NULL, 
		  descidade varchar(64) DEFAULT NULL, 
		  desestado varchar(32) DEFAULT NULL, 
		  despai varchar(32) DEFAULT NULL, 
		  descep char(8) DEFAULT NULL, 
		  descomplemento varchar(32),
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idperson),
		  KEY FK_personsdados_personstypes_idx (idpersontype),
		  KEY FK_personsdados_users_idx (iduser),
		  CONSTRAINT FK_personsdados_persons FOREIGN KEY (idperson) REFERENCES tb_persons (idperson) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_personsdados_personstypes FOREIGN KEY (idpersontype) REFERENCES tb_personstypes (idpersontype) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_personsdados_users FOREIGN KEY (iduser) REFERENCES tb_users (iduser) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/productsdados/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_productsdados(
			idproduct INT NOT NULL,
			idproducttype INT NOT NULL,
			desproduct VARCHAR(64) NOT NULL,
			vlprice DEC(10,2) NULL,
			desproducttype VARCHAR(64) NOT NULL,
			dtstart DATETIME NULL,
			dtend DATETIME NULL,
			inremoved BIT(1) NOT NULL DEFAULT 0,
			dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT PRIMARY KEY (idproduct),
			CONSTRAINT FOREIGN KEY(idproduct) REFERENCES tb_products(idproduct),
			CONSTRAINT FOREIGN KEY(idproducttype) REFERENCES tb_productstypes(idproducttype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/cupons/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_cuponstypes(
			idcupomtype INT NOT NULL AUTO_INCREMENT,
			descupomtype VARCHAR(128) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcupomtype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_cupons(
			idcupom INT NOT NULL AUTO_INCREMENT,
			idcupomtype INT NOT NULL,
			descupom VARCHAR(128) NOT NULL,
			descodigo VARCHAR(128) NOT NULL,
			nrqtd INT NOT NULL DEFAULT 1,
			nrqtdusado INT NOT NULL DEFAULT 0,
			dtstart DATETIME NULL,
			dtend DATETIME NULL,
			inremoved BIT(1) NULL,
			nrdesconto DECIMAL(10,2) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcupom),
			CONSTRAINT FOREIGN KEY(idcupomtype) REFERENCES tb_cuponstypes(idcupomtype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/cupons/list", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$procs = array(
		'sp_cupons_list',
		'sp_cuponstypes_list'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/cupons/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_cupons_save',
		'sp_cuponstypes_save'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/cupons/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_cupons_get',
		'sp_cuponstypes_get'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/cupons/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_cupons_remove',
		'sp_cuponstypes_remove'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/cupons/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();
	
	$sql = new Sql();
	$sql->arrays("
		INSERT INTO tb_cuponstypes(descupomtype)
		VALUES(?), (?);
	", array(
		$lang->getString('cupom_value'),
		$lang->getString('cupom_porcentage')
		
	));
	echo success();
});
$app->get("/install-admin/sql/carrinhos/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_carrinhos(
			idcarrinho INT NOT NULL AUTO_INCREMENT,
			idperson INT NOT NULL,
			dessession VARCHAR(128) NOT NULL,
			infechado BIT(1),
			nrproducts INT NULL,
			vltotal DECIMAL(10,2) NULL,
			vltotalbruto DECIMAL(10,2),
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcarrinho),
			CONSTRAINT FOREIGN KEY(idperson) REFERENCES tb_persons(idperson)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_carrinhosproducts(
			idcarrinhoproduct INT NOT NULL AUTO_INCREMENT,
			idcarrinho INT NOT NULL,
			idproduct INT NOT NULL,
			dtremoved DATETIME NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idcarrinhoproduct),
			CONSTRAINT FOREIGN KEY(idcarrinho) REFERENCES tb_carrinhos(idcarrinho),
			CONSTRAINT FOREIGN KEY(idproduct) REFERENCES tb_products(idproduct)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_carrinhosfretes(
			idcarrinho INT NOT NULL,
			descep CHAR(8) NOT NULL,
			vlfrete DECIMAL(10,2) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idcarrinho) REFERENCES tb_carrinhos(idcarrinho)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_carrinhoscupons(
			idcarrinho INT NOT NULL,
			idcupom INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idcarrinho) REFERENCES tb_carrinhos(idcarrinho),
			CONSTRAINT FOREIGN KEY(idcupom) REFERENCES tb_cupons(idcupom)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/carrinhos/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		"tg_carrinhoscupons_AFTER_INSERT",
		"tg_carrinhoscupons_AFTER_UPDATE",		
		"tg_carrinhosfretes_AFTER_INSERT",
		"tg_carrinhosfretes_AFTER_UPDATE",		
		"tg_carrinhosproducts_AFTER_INSERT",
		"tg_carrinhosproducts_AFTER_UPDATE"		
	);
	saveTriggers($triggers);
	echo success();
});
$app->get("/install-admin/sql/carrinhos/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_carrinhos_list",
		"sp_carrinhosproducts_list",
		"sp_carrinhosfromperson_list",
		'sp_carrinhoscupons_list',
		'sp_carrinhosfretes_list',
		'sp_productsfromcarrinho_list',
		'sp_cuponsfromcarrinho_list'
	);
	saveProcedures($procs);
	echo success();
	
});
$app->get("/install-admin/sql/carrinhos/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_carrinhos_get",
		"sp_carrinhosproducts_get",
		'sp_carrinhoscupons_get',
		'sp_carrinhosfretes_get'
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/carrinhos/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_carrinhos_save",
		"sp_carrinhosproducts_save",
		'sp_carrinhoscupons_save',
		'sp_carrinhosfretes_save',
		'sp_carrinhosdados_save'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/carrinhos/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_carrinhos_remove",
		"sp_carrinhosproducts_remove",
		'sp_carrinhoscupons_remove',
		'sp_carrinhosfretes_remove'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/cartoesdecreditos/tables", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_cartoesdecreditos(
			idcartao INT NOT NULL AUTO_INCREMENT,
			idperson INT NOT NULL,
			desnome VARCHAR(64) NOT NULL,
			dtvalidade DATE NOT NULL,
			nrcds VARCHAR(8) NOT NULL,
			desnumber CHAR(16) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcartao),
			CONSTRAINT FOREIGN KEY(idperson) REFERENCES tb_persons(idperson)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});
$app->get("/install-admin/sql/cartoesdecreditos/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_cartoesdecreditos_list",
		"sp_cartoesfromperson_list"
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/cartoesdecreditos/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$name = array(
		"sp_cartoesdecreditos_get"
	);
	
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/cartoesdecreditos/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$name = array(
		"sp_cartoesdecreditos_save"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/cartoesdecreditos/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$name = array(
		"sp_cartoesdecreditos_remove"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/gateways/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();

	$sql = new Sql();
	$sql->arrays("
		INSERT INTO tb_gateways(desgateway) VALUES(?);
	", array(
		$lang->getString('gateway_pagseguro')
	));
	
	echo success();
	
});
$app->get("/install-admin/sql/gateways/list", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$name = array(
		"sp_gateways_list"
	);
	
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/gateways/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$name = array(
		"sp_gateways_get"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/gateways/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$name = array(
		"sp_gateways_save"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/gateways/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$name = array(
		"sp_gateways_remove"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/pedidos/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_gateways(
			idgateway INT NOT NULL AUTO_INCREMENT,
			desgateway VARCHAR(128) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT PRIMARY KEY(idgateway)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_formaspagamentos(
			idformapagamento INT NOT NULL AUTO_INCREMENT,
			idgateway INT NOT NULL,
			desformapagamento VARCHAR(128) NOT NULL,
			nrparcelasmax INT NOT NULL,
			instatus BIT(1),
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idformapagamento),
			CONSTRAINT FOREIGN KEY(idgateway) REFERENCES tb_gateways(idgateway)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_pedidosstatus(
			idstatus INT NOT NULL AUTO_INCREMENT,
			desstatus VARCHAR(128) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idstatus)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_pedidos(
			idpedido INT NOT NULL AUTO_INCREMENT,
			idperson INT NOT NULL,
			idformapagamento INT NOT NULL,
			idstatus INT NOT NULL,
			dessession VARCHAR(128) NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			nrparcelas INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idpedido),
			CONSTRAINT FOREIGN KEY(idperson) REFERENCES tb_persons(idperson),
			CONSTRAINT FOREIGN KEY(idformapagamento) REFERENCES tb_formaspagamentos(idformapagamento),
			CONSTRAINT FOREIGN KEY(idstatus) REFERENCES tb_pedidosstatus(idstatus)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_pedidosproducts(
			idpedido INT NOT NULL,
			idproduct INT NOT NULL,
			nrqtd INT NOT NULL,
			vlprice DECIMAL(10,2) NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idpedido, idproduct),
			CONSTRAINT FOREIGN KEY(idpedido) REFERENCES tb_pedidos(idpedido),
			CONSTRAINT FOREIGN KEY(idproduct) REFERENCES tb_products(idproduct)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_pedidosrecibos(
			idpedido INT NOT NULL,
			desautenticacao VARCHAR(256) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idpedido),
			CONSTRAINT FOREIGN KEY(idpedido) REFERENCES tb_pedidos(idpedido)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_pedidoslogs(
			idlog INT NOT NULL AUTO_INCREMENT,
			idpedido INT NOT NULL,
			iduser INT NOT NULL,
			dtregister TIMESTAMP NULL,			
			CONSTRAINT PRIMARY KEY(idlog),
			CONSTRAINT FOREIGN KEY(idpedido) REFERENCES tb_pedidos(idpedido),
			CONSTRAINT FOREIGN KEY(iduser) REFERENCES tb_users(iduser)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_pedidosnegociacoestypes (
		  idnegociacao int(11) NOT NULL AUTO_INCREMENT,
		  desnegociacao varchar(64) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idnegociacao)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");		
	$sql->exec("
		CREATE TABLE tb_pedidosnegociacoes (
		  idnegociacao int(11) NOT NULL,
		  idpedido int(11) NOT NULL,
		  dtstart datetime NOT NULL,
		  dtend datetime DEFAULT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idnegociacao,idpedido),
		  KEY FK_pedidosnegociacoes_pedidos_idx (idpedido),
		  CONSTRAINT FK_pedidosnegociacoes_pedidos FOREIGN KEY (idpedido) REFERENCES tb_pedidos (idpedido) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_pedidosnegociacoes_pedidosnegociacoestypes FOREIGN KEY (idpedido) REFERENCES tb_pedidosnegociacoestypes (idnegociacao) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});
$app->get("/install-admin/sql/pedidos/inserts", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();
	
	$sql = new Sql();
	$sql->arrays("
		INSERT INTO tb_formaspagamentos (idgateway, desformapagamento, nrparcelasmax, instatus) VALUES
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?),
		(?, ?, ?, ?)
		;
	", array(
		1, $lang->getString('gateway_visa'), 12, 1,
		1, $lang->getString('gateway_mastercard'), 12, 1,
		1, $lang->getString('gateway_dinerclub'), 12, 1,
		1, $lang->getString('gateway_amex'), 12, 1,
		1, $lang->getString('gateway_hipercard'), 12, 1,
		1, $lang->getString('gateway_aura'), 12, 1,
		1, $lang->getString('gateway_elo'), 12, 1,
		1, $lang->getString('gateway_boleto'), 1, 1,
		1, $lang->getString('gateway_debito_itau'), 1, 1,
		1, $lang->getString('gateway_debito_brasil'), 1, 1,
		1, $lang->getString('gateway_debito_banrisul'), 1, 1,
		1, $lang->getString('gateway_debito_bradesco'), 1, 1,
		1, $lang->getString('gateway_debito_hsbc'), 1, 1,
		1, $lang->getString('gateway_plenocard'), 3, 1,
		1, $lang->getString('gateway_personalcard'), 3, 1,
		1, $lang->getString('gateway_jbc'), 1, 1,
		1, $lang->getString('gateway_discover'), 1, 1,
		1, $lang->getString('gateway_brasilcard'), 12, 1,
		1, $lang->getString('gateway_fortbrasil'), 12, 1,
		1, $lang->getString('gateway_cardban'), 12, 1,
		1, $lang->getString('gateway_valecard'), 3, 1,
		1, $lang->getString('gateway_cabal'), 12, 1,
		1, $lang->getString('gateway_mais'), 10, 1,
		1, $lang->getString('gateway_avista'), 6, 1,
		1, $lang->getString('gateway_grandcard'), 12, 1,
		1, $lang->getString('gateway_sorocred'), 12, 1
	));
	$sql->arrays("
		INSERT INTO tb_pedidosstatus(desstatus)
		VALUES(?), (?), (?), (?), (?), (?), (?);
	", array(
	    $lang->getString('statu_pedido'),
	 	$lang->getString('statu_analise'),
	 	$lang->getString('statu_pago'),
	 	$lang->getString('statu_disponivel'),
		$lang->getString('statu_disputa'),
		$lang->getString('statu_devolvido'),
		$lang->getString('statu_cancelado')
	));

	$sql->arrays("
		INSERT INTO tb_pedidosnegociacoestypes(desnegociacao)
		VALUES(?);
	", array(
	    $lang->getString('negociacao_orcemanto'),
	 	$lang->getString('negociacao_venda')
	));
	
	echo success();
	
});
$app->get("/install-admin/sql/pedidos/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_formaspagamentos_list',
		'sp_pedidos_list',
		'sp_pedidosproducts_list',
		'sp_pedidosrecibos_list',
		'sp_pedidosstatus_list',
		'sp_pedidosfromperson_list',
		'sp_recibosfrompedido_list',
		'sp_pedidoslogs_list'
	);
	saveProcedures($procs);
	
	echo success();
	
});

$app->get("/install-admin/sql/pedidosnegociacoestypes/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
	
		'sp_pedidosnegociacoestypes_list'
		
	);
	saveProcedures($procs);
	
	echo success();
	
});

$app->get("/install-admin/sql/pedidosnegociacoestypes/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(

		'sp_pedidosnegociacoestypes_get'
		
	);
	saveProcedures($procs);
	
	echo success();
	
});

$app->get("/install-admin/sql/pedidosnegociacoestypes/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		
		'sp_pedidosnegociacoestypes_save'
		
	);
	saveProcedures($procs);
	
	echo success();
	
});

$app->get("/install-admin/sql/pedidosnegociacoestypes/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
	
		'sp_pedidosnegociacoestypes_remove'
		
	);
	saveProcedures($procs);
	
	echo success();
		
});		

$app->get("/install-admin/sql/pedidos/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_formaspagamentos_get',
		'sp_pedidos_get',
		'sp_pedidosproducts_get',
		'sp_pedidosrecibos_get',
		'sp_pedidosstatus_get',
		'sp_pedidoslogs_get'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/pedidos/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_formaspagamentos_save',
		'sp_pedidos_save',
		'sp_pedidosproducts_save',
		'sp_pedidosrecibos_save',
		'sp_pedidosstatus_save',
		'sp_pedidoslogs_save'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/pedidos/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_formaspagamentos_remove',
		'sp_pedidos_remove',
		'sp_pedidosproducts_remove',
		'sp_pedidosrecibos_remove',
		'sp_pedidosstatus_remove',
		'sp_pedidoslogs_remove'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/sitescontacts/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_sitescontacts(
			idsitecontact INT NOT NULL AUTO_INCREMENT,
			idperson INT NOT NULL,
			idpersonresposta INT NULL,
			desmensagem VARCHAR(2048) NOT NULL,
			inlido BIT(1) NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idsitecontact),
			CONSTRAINT FOREIGN KEY(idperson) REFERENCES tb_persons(idperson)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});
$app->get("/install-admin/sql/sitescontacts/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_sitescontacts_list",
		"sp_sitescontactsfromperson_list"
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/sitescontacts/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_sitescontactsbyperson_get',
		'sp_sitescontacts_get'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/sitescontacts/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$name = array(
		"sp_sitescontacts_save"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/sitescontacts/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$name = array(
		"sp_sitescontacts_remove"
	);
	saveProcedures($name);
	
	echo success();
	
});
// lugares
$app->get("/install-admin/sql/lugares/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_lugarestypes(
			idlugartype INT NOT NULL AUTO_INCREMENT,
			deslugartype VARCHAR(128) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT PRIMARY KEY(idlugartype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_lugares(
			idlugar INT NOT NULL AUTO_INCREMENT,
			idlugarfather INT NULL,
			deslugar VARCHAR(128) NOT NULL,
			idlugartype INT NOT NULL,
			desconteudo TEXT NULL,
			nrviews INT NULL,
			vlreview DECIMAL(10,2) NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idlugar),
			CONSTRAINT FOREIGN KEY(idlugarfather) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idlugartype) REFERENCES tb_lugarestypes(idlugartype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_lugareshorarios(
			idhorario INT NOT NULL AUTO_INCREMENT,
			idlugar INT NOT NULL,
			nrdia TINYINT(4) NOT NULL,
			hrabre TIME NULL,
			hrfecha TIME NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idhorario),
			CONSTRAINT FOREIGN KEY(idlugar) REFERENCES tb_lugares(idlugar)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_lugarescoordenadas(
			idlugar INT NOT NULL,
			idcoordenada INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idlugar) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idcoordenada) REFERENCES tb_coordenadas(idcoordenada)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_lugaresadresses(
			idlugar INT NOT NULL,
			idadress INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idlugar) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idadress) REFERENCES tb_adresses(idadress)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_lugaresvaluesfields(
			idfield INT NOT NULL AUTO_INCREMENT,
			desfield VARCHAR(128) NOT NULL,
			CONSTRAINT PRIMARY KEY(idfield),
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP()
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_lugaresvalues(
			idlugarvalue INT NOT NULL AUTO_INCREMENT,
			idlugar INT NOT NULL,
			idfield INT NOT NULL,
			desvalue VARCHAR(128) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idlugarvalue),
			CONSTRAINT FOREIGN KEY(idlugar) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idfield) REFERENCES tb_lugaresvaluesfields(idfield)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_lugaresdados(
			idlugar INT NOT NULL,
			deslugar VARCHAR(128) NOT NULL,
			idlugarfather INT NULL,
			deslugarfather VARCHAR(128) NULL,
			idlugartype INT NOT NULL,
			deslugartype  VARCHAR(128) NOT NULL,
			idadresstype INT NULL,
			desadresstype VARCHAR(128) NULL,
			idadress INT NULL,
			desadress VARCHAR(128) NULL,
			desnumber VARCHAR(16) NULL,
			desbairro VARCHAR(64) NULL,
			descidade VARCHAR(64) NULL,
			desestado VARCHAR(32) NULL,
			despai VARCHAR(32) NULL,
			descep CHAR(8) NULL,
			descomplemento VARCHAR(32) NULL,
			idcoordenada INT NULL,
			vllatitude DECIMAL(20,17) NULL,
			vllongitude DECIMAL(20,17) NULL,
			nrzoom TINYINT(4) NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idlugar),
			CONSTRAINT FOREIGN KEY(idlugar) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idlugarfather) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idlugartype) REFERENCES tb_lugarestypes(idlugartype),
			CONSTRAINT FOREIGN KEY(idadress) REFERENCES tb_adresses(idadress),
			CONSTRAINT FOREIGN KEY(idadresstype) REFERENCES tb_adressestypes(idadresstype),
			CONSTRAINT FOREIGN KEY(idcoordenada) REFERENCES tb_coordenadas(idcoordenada)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});
$app->get("/install-admin/sql/lugares/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		'tg_lugares_AFTER_INSERT',
		'tg_lugares_AFTER_UPDATE',
		'tg_lugares_BEFORE_DELETE',

		'tg_lugarescoordenadas_AFTER_INSERT',
		'tg_lugarescoordenadas_AFTER_UPDATE',
		'tg_lugarescoordenadas_BEFORE_DELETE',

		'tg_lugaresadresses_AFTER_INSERT',
		'tg_lugaresadresses_AFTER_UPDATE',
		'tg_lugaresadresses_BEFORE_DELETE'
	);
	saveTriggers($triggers);

	echo success();

});
$app->get("/install-admin/sql/lugares/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_lugares_list",
		"sp_lugarestypes_list",
		"sp_lugareshorarios_list"
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/lugares/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_lugarestypes_get',
		'sp_lugares_get',
		'sp_lugareshorarios_get'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/lugares/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_lugarestypes_save',
		'sp_lugares_save',
		'sp_lugaresdados_save',
		'sp_lugarescoordenadas_add',
		'sp_lugareshorarios_save',
		'sp_lugaresadresses_add',
		'sp_lugaresarquivos_add'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/lugares/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_lugarestypes_remove',
		'sp_lugares_remove',
		'sp_lugaresdados_remove',
		'sp_lugareshorarios_remove',
		'sp_lugareshorariosall_remove'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/lugares/inserts", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$lang = new Language();
	
	$bairro = new Lugartype(array(
		'deslugartype'=>$lang->getString('lugartype_bairro')
	));
	$bairro->save();

	$cidade = new Lugartype(array(
		'deslugartype'=>$lang->getString('lugartype_cidade')
	));
	$cidade->save();

	$estado = new Lugartype(array(
		'deslugartype'=>$lang->getString('lugartype_estado')
	));
	$estado->save();

	$pai = new Lugartype(array(
		'deslugartype'=>$lang->getString('lugartype_pai')
	));
	$pai->save();

	$empresas = new Lugartype(array(
		'deslugartype'=>$lang->getString('lugartype_empresas')
	));
	$empresas->save();
	
	$adress = new adress(array(
		'idadresstype'=>adresstype::COMERCIAL,
		'desadress'=>$lang->getString('lugartype_hcode_adress'),
		'desnumber'=>$lang->getString('lugartype_hcode_number'),
		'desbairro'=>$lang->getString('lugartype_hcode_bairro'),
		'descidade'=>$lang->getString('lugartype_hcode_cidade'),
		'desestado'=>$lang->getString('lugartype_hcode_estado'),
		'despai'=>$lang->getString('lugartype_hcode_pai'),
		'descep'=>$lang->getString('lugartype_hcode_cep'),
		'inprincipal'=>true
	));
	$adress->save();

	$lugarHcode = new Lugar(array(
		'deslugar'=>$lang->getString('lugar_hcode'),
		'idlugartype'=>$empresas->getidlugartype()
	));
	$lugarHcode->save();
	$lugarHcode->setadress($adress);
	
	echo success();
	
});
// lugares arquivos
$app->get("/install-admin/sql/lugaresarquivos/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_lugaresarquivos(
			idlugar INT NOT NULL,
			idarquivo INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idlugar) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idarquivo) REFERENCES tb_arquivos(idarquivo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});
// coordenadas
$app->get("/install-admin/sql/coordenadas/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_coordenadas(
			idcoordenada INT NOT NULL AUTO_INCREMENT,
			vllatitude DECIMAL(20,17) NOT NULL,
			vllongitude DECIMAL(20,17) NOT NULL,
			nrzoom TINYINT(4) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcoordenada)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_adressescoordenadas(
			idadress INT NOT NULL,
			idcoordenada INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idadress) REFERENCES tb_adresses(idadress),
			CONSTRAINT FOREIGN KEY(idcoordenada) REFERENCES tb_coordenadas(idcoordenada)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});
$app->get("/install-admin/sql/coordenadas/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_coordenadas_get'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/coordenadas/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_coordenadas_save'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/coordenadas/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_coordenadas_remove'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/cursos/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();

	$sql->exec("
		CREATE TABLE tb_cursos (
		  idcurso int(11) NOT NULL AUTO_INCREMENT,
		  descurso varchar(64) NOT NULL,
		  destitulo varchar(256) DEFAULT NULL,
		  vlcargahoraria decimal(10,2) NOT NULL DEFAULT '0.00',
		  nraulas int(11) NOT NULL DEFAULT '0',
		  nrexercicios int(11) NOT NULL DEFAULT '0',
		  desdescricao varchar(10240) DEFAULT NULL,
		  inremoved bit(1) NOT NULL DEFAULT b'0',
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcurso)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->exec("
		CREATE TABLE tb_cursossecoes (
		  idsecao int(11) NOT NULL AUTO_INCREMENT,
		  dessecao varchar(128) NOT NULL,
		  nrorder int(11) NOT NULL DEFAULT '0',
		  idcurso int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idsecao),
		  KEY FK_cursossecoes_cursos_idx (idcurso),
		  CONSTRAINT FK_cursossecoes_cursos FOREIGN KEY (idcurso) REFERENCES tb_cursos (idcurso) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->exec("
		CREATE TABLE tb_cursoscurriculos (
		  idcurriculo int(11) NOT NULL AUTO_INCREMENT,
		  descurriculo varchar(128) NOT NULL,
		  idsecao int(11) NOT NULL,
		  desdescricao varchar(2048) DEFAULT NULL,
		  nrorder varchar(45) DEFAULT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcurriculo),
		  KEY FK_cursoscurriculos_cursossecoes_idx (idsecao),
		  CONSTRAINT FK_cursoscurriculos_cursossecoes FOREIGN KEY (idsecao) REFERENCES tb_cursossecoes (idsecao) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();
});

$app->get("/install-admin/sql/cursos/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_cursos_list',
		'sp_cursoscurriculos_list',
		'sp_cursossecoes_list',
		'sp_secoesfromcurso_list',
		'sp_curriculosfromcurso_list'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/cursos/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_cursos_get',
		'sp_cursoscurriculos_get',
		'sp_cursossecoes_get'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/cursos/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_cursos_save',
		'sp_cursoscurriculos_save',
		'sp_cursossecoes_save'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/cursos/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_cursos_remove',
		'sp_cursoscurriculos_remove',
		'sp_cursossecoes_remove'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/carousels/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_carousels (
		  idcarousel int(11) NOT NULL AUTO_INCREMENT,
		  descarousel varchar(64) NOT NULL,
		  inloop bit(1) NOT NULL DEFAULT b'0',
		  innav bit(1) NOT NULL DEFAULT b'0',
		  incenter bit(1) NOT NULL DEFAULT b'0',
		  inautowidth bit(1) NOT NULL DEFAULT b'0',
		  invideo bit(1) NOT NULL DEFAULT b'0',
		  inlazyload bit(1) NOT NULL DEFAULT b'0',
		  indots bit(1) NOT NULL DEFAULT b'1',
		  nritems int(11) NOT NULL DEFAULT '3',
		  nrstagepadding int(11) NOT NULL DEFAULT '0',
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcarousel)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_carouselsitemstypes (
		  idtype int(11) NOT NULL AUTO_INCREMENT,
		  destype varchar(32) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idtype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_carouselsitems (
		  iditem int(11) NOT NULL AUTO_INCREMENT,
		  desitem varchar(45) NOT NULL,
		  desconteudo text,
		  nrorder varchar(45) NOT NULL DEFAULT '0',
		  idtype int(11) NOT NULL,
		  idcarousel int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (iditem),
		  KEY FK_carouselsitems_carousels_idx (idcarousel),
		  KEY FK_carouselsitems_carouselsitemstypes_idx (idtype),
		  CONSTRAINT FK_carouselsitems_carousels FOREIGN KEY (idcarousel) REFERENCES tb_carousels (idcarousel) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_carouselsitems_carouselsitemstypes FOREIGN KEY (idtype) REFERENCES tb_carouselsitemstypes (idtype) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();

});

$app->get("/install-admin/sql/carousels/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_carousels_list',
		'sp_carouselsitems_list',
		'sp_carouselsitemstypes_list',
		'sp_itemsfromcarousel_list'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/carousels/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_carousels_get',
		'sp_carouselsitems_get',
		'sp_carouselsitemstypes_get'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/carousels/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_carousels_save',
		'sp_carouselsitems_save',
		'sp_carouselsitemstypes_save'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/carousels/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_carousels_remove',
		'sp_carouselsitems_remove',
		'sp_carouselsitemstypes_remove'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/configuracoes/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_configuracoestypes (
		  idconfiguracaotype int(11) NOT NULL AUTO_INCREMENT,
		  desconfiguracaotype varchar(32) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idconfiguracaotype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->exec("
		CREATE TABLE tb_configuracoes (
		  idconfiguracao int(11) NOT NULL AUTO_INCREMENT,
		  desconfiguracao varchar(64) NOT NULL,
		  desvalue varchar(2048) NOT NULL,
		  desdescricao varchar(256) NULL,
		  idconfiguracaotype int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idconfiguracao),
		  KEY FK_configuracoes_configuracoestypes_idx (idconfiguracaotype),
		  KEY IX_desconfiguracao (desconfiguracao),
		  CONSTRAINT FK_configuracoes_configuracoestypes FOREIGN KEY (idconfiguracaotype) REFERENCES tb_configuracoestypes (idconfiguracaotype) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();

});

$app->get("/install-admin/sql/configuracoes/inserts", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();

	$texto = new Configuracaotype(array(
		'desconfiguracaotype'=>$lang->getString('configtype_string')
	));
	$texto->save();

	$int = new Configuracaotype(array(
		'desconfiguracaotype'=>$lang->getString('configtype_int')
	));
	$int->save();

	$float = new Configuracaotype(array(
		'desconfiguracaotype'=>$lang->getString('configtype_float')
	));
	$float->save();

	$bool = new Configuracaotype(array(
		'desconfiguracaotype'=>$lang->getString('configtype_boolean')
	));
	$bool->save();

	$data = new Configuracaotype(array(
		'desconfiguracaotype'=>$lang->getString('configtype_datetime')
	));
	$data->save();

	$array = new Configuracaotype(array(
		'desconfiguracaotype'=>$lang->getString('configtype_object')
	));
	$array->save();

	$adminName = new Configuracao(array(
		'desconfiguracao'=>$lang->getString('config_admin_name'),
		'desvalue'=>$lang->getString('config_admin_name_value'),
		'idconfiguracaotype'=>$texto->getidconfiguracaotype(),
		'desdescricao'=>$lang->getString('config_admin_name_description')
	));
	$adminName->save();

	$uploadDir = new Configuracao(array(
		'desconfiguracao'=>$lang->getString('config_upload_dir'),
		'desvalue'=>$lang->getString('config_upload_dir_value'),
		'idconfiguracaotype'=>$texto->getidconfiguracaotype(),
		'desdescricao'=>$lang->getString('config_upload_dir_description')
	));
	$uploadDir->save();

	$uploadMaxSize = new Configuracao(array(
		'desconfiguracao'=>$lang->getString('config_upload_max_filesize'),
		'desvalue'=>file_upload_max_size(),
		'idconfiguracaotype'=>$int->getidconfiguracaotype(),
		'desdescricao'=>$lang->getString('config_upload_max_filesize_description')
	));
	$uploadMaxSize->save();

	$uploadMimes = new Configuracao(array(
		'desconfiguracao'=>$lang->getString('config_upload_mimetype'),
		'desvalue'=>json_encode(array(
			'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf'
		)),
		'idconfiguracaotype'=>$array->getidconfiguracaotype(),
		'desdescricao'=>$lang->getString('config_upload_mimetype_description')
	));
	$uploadMimes->save();

	$googleMapKey = new Configuracao(array(
		'desconfiguracao'=>$lang->getString('config_google_map_key'),
		'desvalue'=>$lang->getString('google_map_key'),
		'idconfiguracaotype'=>$texto->getidconfiguracaotype(),
		'desdescricao'=>$lang->getString('config_google_map_key_description')
	));
	$googleMapKey->save();

	echo success();

});

$app->get("/install-admin/sql/configuracoes/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_configuracoestypes_get',
		'sp_configuracoestypes_list',
		'sp_configuracoes_get',
		'sp_configuracoes_list'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/configuracoes/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_configuracoestypes_save',
		'sp_configuracoes_save'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/configuracoes/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_configuracoestypes_remove',
		'sp_configuracoes_remove'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/arquivos/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_arquivos (
		  idarquivo int(11) NOT NULL AUTO_INCREMENT,
		  desdiretorio varchar(256) NOT NULL,
		  desarquivo varchar(128) NOT NULL,
		  desextensao varchar(32) NOT NULL,
		  desalias varchar(128) NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idarquivo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();

});

$app->get("/install-admin/sql/arquivos/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_arquivos_get'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/arquivos/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_arquivos_save'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/arquivos/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_arquivos_remove'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/arquivos/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_arquivos_list'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/urls/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_urls_get'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/urls/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_urls_save'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/urls/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_urls_remove'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/urls/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_urls_list'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/productsarquivos/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();

	$sql->exec("
		CREATE TABLE tb_productsarquivos (
		  idproduct int(11) NOT NULL,
		  idarquivo int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idproduct,idarquivo),
		  KEY FK_productsarquivos_arquivos_idx (idarquivo),
		  CONSTRAINT FK_productsarquivos_arquivos FOREIGN KEY (idarquivo) REFERENCES tb_arquivos (idarquivo) ON DELETE CASCADE ON UPDATE CASCADE,
		  CONSTRAINT FK_productsarquivos_products FOREIGN KEY (idproduct) REFERENCES tb_products (idproduct) ON DELETE CASCADE ON UPDATE CASCADE
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";	
	");

	echo success();

});

$app->get("/install-admin/sql/personsarquivos/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();

	$sql->exec("
		CREATE TABLE tb_personsarquivos (
		  idperson int(11) NOT NULL,
		  idarquivo int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idperson,idarquivo),
		  KEY FK_personsarquivos_arquivos_idx (idarquivo),
		  CONSTRAINT FK_personsarquivos_arquivos FOREIGN KEY (idarquivo) REFERENCES tb_arquivos (idarquivo) ON DELETE CASCADE ON UPDATE CASCADE,
		  CONSTRAINT FK_personsarquivos_persons FOREIGN KEY (idperson) REFERENCES tb_persons (idperson) ON DELETE CASCADE ON UPDATE CASCADE
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/personsarquivos/procs", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$procs = array(
		'sp_personsarquivos_save'
	);
	saveProcedures($procs);

	echo success();

});

$app->get("/install-admin/sql/functions", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();

	foreach (scandir(PATH_FUNCTION) as $file) {
		if ($file !== '.' && $file !== '..') {
			$sql->queryFromFile(PATH_FUNCTION.$file);
		}
	}

	echo success();

});

$app->get("/install-admin/sql/urls/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();

	$sql->exec("
		CREATE TABLE tb_urls (
		  idurl int(11) NOT NULL AUTO_INCREMENT,
		  desurl varchar(128) NOT NULL,
		  destitulo varchar(64) DEFAULT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idurl),
		  UNIQUE KEY desurl_UNIQUE (desurl)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/urls/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$procs = array(
		'sp_urls_list'
	);
	saveProcedures($procs);

	echo success();

});

$app->get("/install-admin/sql/urls/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$procs = array(
		'sp_urls_get'
	);
	saveProcedures($procs);

	echo success();

});

$app->get("/install-admin/sql/urls/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$procs = array(
		'sp_urls_save'
	);
	saveProcedures($procs);

	echo success();

});

$app->get("/install-admin/sql/urls/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$procs = array(
		'sp_urls_remove'
	);
	saveProcedures($procs);

	echo success();

});

$app->get("/install-admin/sql/personsadresses/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();

	$sql->exec("
		CREATE TABLE tb_personsadresses(
			idperson INT NOT NULL,
			idadress INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idperson) REFERENCES tb_persons(idperson),
			CONSTRAINT FOREIGN KEY(idadress) REFERENCES tb_adresses(idadress)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/personsadresses/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		"tg_personsadresses_AFTER_INSERT",
		"tg_personsadresses_AFTER_UPDATE",
		"tg_personsadresses_BEFORE_DELETE"
	);
	saveTriggers($triggers);
	echo success();
});


?>