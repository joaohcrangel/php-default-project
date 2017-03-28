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
function saveTriggers($triggers = array(), $pathTrigger = PATH_TRIGGER){
	$sql = new Sql();
	foreach ($triggers as $name) {
		$sql->exec("DROP TRIGGER IF EXISTS {$name};");
		$sql->queryFromFile($pathTrigger."{$name}.sql");
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
		CREATE TABLE tb_personsdevices (
		  iddevice int(11) NOT NULL AUTO_INCREMENT,
		  idperson int(11) NOT NULL,
		  desdevice varchar(128) NOT NULL,
		  desid varchar(512) NOT NULL,
		  dessystem varchar(128) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (iddevice),
		  KEY FK_personsdevices_persons_idx (idperson),
		  CONSTRAINT FK_personsdevices_persons FOREIGN KEY (idperson) REFERENCES tb_persons (idperson) ON DELETE NO ACTION ON UPDATE NO ACTION
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

	$personTypeF = new PersonType(array(
		'despersontype'=>$lang->getString("persons_fisica")
	));
	$personTypeF->save();

	$personTypeJ = new PersonType(array(
		'despersontype'=>$lang->getString("persons_juridica")
	));
	$personTypeJ->save();
	
	$person = new Person(array(
		'desperson'=>$lang->getString("persons_nome"),
		'idpersontype'=>PersonType::FISICA
	));
	$person->save();

	$nascimento = new PersonValueField(array(
		'desfield'=>$lang->getString('data_nascimento')
	));
	$nascimento->save();
	$sexo = new PersonValueField(array(
		'desfield'=>$lang->getString('sexo')
	));
	$sexo->save();
	$foto = new PersonValueField(array(
		'desfield'=>$lang->getString('foto')
	));
	$foto->save();
	$cliente = new PersonCategoryType(array(
		'idcategory'=>0,
		'descategory'=>$lang->getString('person_cliente')
	));
	$cliente->save();
	$fornecedor = new PersonCategoryType(array(
		'idcategory'=>0,
		'descategory'=>$lang->getString('person_fornecedor')
	));
	$fornecedor->save();
	$colaborador = new PersonCategoryType(array(
		'idcategory'=>0,
		'descategory'=>$lang->getString('person_colaborador')
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
		"sp_personscategoriestypes_get",
		"sp_personsdevices_get"
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
		"sp_personsdata_save",
		"sp_persons_save",
		"sp_logstypes_save",
		"sp_personsvalues_save",
		"sp_personsvaluesfields_save",
		"sp_personstypes_save",
		"sp_personscategoriestypes_save",
		"sp_personsdevices_save"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/persons/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
		"sp_personsdata_remove",
		"sp_persons_remove",
		"sp_logstypes_remove",
		"sp_personsvalues_remove",
		"sp_personsvaluesfields_remove",
		"sp_personstypes_remove",
		"sp_personscategoriestypes_remove",
		"sp_personsdevices_remove"
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

	$courseUdemy = new ProductType(array(
		'desproducttype'=>$lang->getString('products_course')
	));
	$courseUdemy->save();

	$camiseta = new ProductType(array(
		'desproducttype'=>$lang->getString('products_shirt')
	));
	$camiseta->save();

	echo success();

});
$app->get("/install-admin/sql/products/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_products_get",
		"sp_productstypes_get",
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
		"sp_cartsfromproduct_list",
		"sp_ordersfromproduct_list",
		"sp_pricesfromproduct_list"
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/products/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_products_save",
		"sp_productstypes_save",
		"sp_productsprices_save",
		"sp_productsdata_save"
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/products/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_products_remove",
		"sp_productstypes_remove",
		"sp_productsprices_remove",
		"sp_productsdata_remove"
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
	$hash = User::getPasswordHash($lang->getString('users_root'));

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
		  nrsubmenus int(11) DEFAULT '0',
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
		'desmenu'=>$lang->getString('menus_system')
	));
	$menuSistema->save();
	//////////////////////////////////////
	$menuAdmin = new Menu(array(
		'nrorder'=>2,
		'idmenufather'=>NULL,
		'desicon'=>'md-settings',
		'deshref'=>'',
		'desmenu'=>$lang->getString('menus_admin')
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
		'deshref'=>'/sistema/configurations',
		'desmenu'=>$lang->getString('menus_config')
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
		'desmenu'=>$lang->getString('menus_examples')
	));
	$menuExemplos->save();
	//////////////////////////////////////
	$menuUpload = new Menu(array(
		'nrorder'=>0,
		'idmenufather'=>$menuExemplos->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/exemplos/upload',
		'desmenu'=>$lang->getString('menus_examples_upload')
	));
	$menuUpload->save();
	//////////////////////////////////////
	$menupermissions = new Menu(array(
		'nrorder'=>3,
		'idmenufather'=>$menuAdmin->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/permissions',
		'desmenu'=>$lang->getString('menus_permissions')
	));
	$menupermissions->save();
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
	$menutypesaddresses = new Menu(array(
		'nrorder'=>0,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/addresses-types',
		'desmenu'=>$lang->getString('menus_address')
	));
	$menutypesaddresses->save();
	//////////////////////////////////////
	$menutypesusers = new Menu(array(
		'nrorder'=>1,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/users-types',
		'desmenu'=>$lang->getString('menus_user_types')
	));
	$menutypesusers->save();
	//////////////////////////////////////
	$menutypesdocuments = new Menu(array(
		'nrorder'=>2,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/documents-types',
		'desmenu'=>$lang->getString('menus_document_types')
	));
	$menutypesdocuments->save();
	//////////////////////////////////////
	$menutypesplaces = new Menu(array(
		'nrorder'=>3,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/places-types',
		'desmenu'=>$lang->getString('menus_place_types')
	));
	$menutypesplaces->save();
	//////////////////////////////////////
	$menutypesCupons = new Menu(array(
		'nrorder'=>4,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/cupons-types',
		'desmenu'=>$lang->getString('menus_coupon_types')
	));
	$menutypesCupons->save();
	//////////////////////////////////////
	$menutypesproducts = new Menu(array(
		'nrorder'=>5,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/products-types',
		'desmenu'=>$lang->getString('menus_product_types')
	));
	$menutypesproducts->save();
	//////////////////////////////////////
	$menuordersStatus = new Menu(array(
		'nrorder'=>6,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/orders-status',
		'desmenu'=>$lang->getString('menus_order_status')
	));
	$menuordersStatus->save();
	//////////////////////////////////////
	$menupersonstypes = new Menu(array(
		'nrorder'=>7,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/persons-types',
		'desmenu'=>$lang->getString('menus_person_types')
	));
	$menupersonstypes->save();
	//////////////////////////////////////
	$menucontactstypes = new Menu(array(
		'nrorder'=>8,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/contacts-types',
		'desmenu'=>$lang->getString('menus_contact_types')
	));
	$menucontactstypes->save();
	//////////////////////////////////////
	$menuGateways = new Menu(array(
		'nrorder'=>9,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/gateways',
		'desmenu'=>$lang->getString('menus_gateways')
	));
	$menuGateways->save();
	//////////////////////////////////////
	$menuHistoricostypes = new Menu(array(
		'nrorder'=>10,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/logs-types',
		'desmenu'=>$lang->getString('menus_log_types')
	));
	$menuHistoricostypes->save();
	//////////////////////////////////////
	$menuFormasorders = new Menu(array(
		'nrorder'=>11,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/formas-pagamentos',
		'desmenu'=>$lang->getString('menus_order_methods')
	));
	$menuFormasorders->save();
	//////////////////////////////////////
	$menupersonsvaluesfields = new Menu(array(
		'nrorder'=>11,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/persons-valuesfields',
		'desmenu'=>$lang->getString('menus_person_values')
	));
	$menupersonsvaluesfields->save();
	//////////////////////////////////////
	$menuconfigurationstypes = new Menu(array(
		'nrorder'=>12,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/configurations-types',
		'desmenu'=>$lang->getString('menus_config_types')
	));
	$menuconfigurationstypes->save();
	//////////////////////////////////////
	$menuCarouselsItemstypes = new Menu(array(
		'nrorder'=>13,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/carousels-types',
		'desmenu'=>$lang->getString('menus_carousel_types')
	));
	$menuCarouselsItemstypes->save();
	//////////////////////////////////////
	$menuordersnegotiationstypes = new Menu(array(
		'nrorder'=>13,
		'idmenufather'=>$menutypes->getidmenu(),
		'desicon'=>'',
		'deshref'=>'/ordersnegotiationstypes',
		'desmenu'=>$lang->getString('menus_negotiation_types')
	));
	$menuordersnegotiationstypes->save();
	//////////////////////////////////////
	$menuorders = new Menu(array(
		"nrorder"=>5,
		"idmenufather"=>NULL,
		"desicon"=>'md-money-box',
		"deshref"=>'/orders',
		"desmenu"=>$lang->getString('menus_orders')
	));
	$menuorders->save();
	//////////////////////////////////////
	$menuCarrinhos = new Menu(array(
		"nrorder"=>6,
		"idmenufather"=>NULL,
		"desicon"=>"md-shopping-cart",
		"deshref"=>"/carrinhos",
		"desmenu"=>$lang->getString('menus_carts')
	));
	$menuCarrinhos->save();
	//////////////////////////////////////
	$menuplaces = new Menu(array(
		"nrorder"=>7,
		"idmenufather"=>NULL,
		"desicon"=>"md-city",
		"deshref"=>"/places",
		"desmenu"=>$lang->getString('menus_places')
	));
	$menuplaces->save();
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
	$menucourses = new Menu(array(
		"nrorder"=>9,
		"idmenufather"=>NULL,
		"desicon"=>"md-book",
		"deshref"=>"/courses",
		"desmenu"=>$lang->getString('menus_courses')
	));
	$menucourses->save();
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
		"desmenu"=>$lang->getString('menus_countries')
	));
	$menupaises->save();
	//////////////////////////////////////
	$menustates = new Menu(array(
		"nrorder"=>6,
		"idmenufather"=>$menuAdmin->getidmenu(),
		"desicon"=>"",
		"deshref"=>"/states",
		"desmenu"=>$lang->getString('menus_states')
	));
	$menustates->save();
	//////////////////////////////////////
	$menucities = new Menu(array(
		"nrorder"=>7,
		"idmenufather"=>$menuAdmin->getidmenu(),
		"desicon"=>"",
		"deshref"=>"/cities",
		"desmenu"=>$lang->getString('menus_cities')
	));
	$menucities->save();
	//////////////////////////////////////
	$menucities = new Menu(array(
		"nrorder"=>8,
		"idmenufather"=>$menuAdmin->getidmenu(),
		"desicon"=>"",
		"deshref"=>"/files",
		"desmenu"=>$lang->getString('menus_files')
	));
	$menucities->save();
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
		  inmain bit(1) NOT NULL DEFAULT b'0',
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
	
	$email = new ContactType(array(
		'descontacttype'=>$lang->getString('contact_type')
	));
	$email->save();

	$telefone = new ContactType(array(
		'descontacttype'=>$lang->getString('phone_type')
	));
	$telefone->save();

	$telefoneCasa = new ContactSubType(array(
		'idcontacttype'=>$telefone->getidcontacttype(),
		'descontactsubtype'=>$lang->getString('home_type')
	));
	$telefoneCasa->save();

	$telefoneTrabalho = new ContactSubType(array(
		'idcontacttype'=>$telefone->getidcontacttype(),
		'descontactsubtype'=>$lang->getString('work_type')
	));
	$telefoneTrabalho->save();

	$telefoneCelular = new ContactSubType(array(
		'idcontacttype'=>$telefone->getidcontacttype(),
		'descontactsubtype'=>$lang->getString('cell_phone_type')
	));
	$telefoneCelular->save();

	$telefoneFax = new ContactSubType(array(
		'idcontacttype'=>$telefone->getidcontacttype(),
		'descontactsubtype'=>$lang->getString('fax_type')
	));
	$telefoneFax->save();

	$telefoneOutro = new ContactSubType(array(
		'idcontacttype'=>$telefone->getidcontacttype(),
		'descontactsubtype'=>$lang->getString('other_type')
	));
	$telefoneOutro->save();

	$emailpersonl = new ContactSubType(array(
		'idcontacttype'=>$email->getidcontacttype(),
		'descontactsubtype'=>$lang->getString('personal_type')
	));
	$emailpersonl->save();

	$emailTrabalho = new ContactSubType(array(
		'idcontacttype'=>$email->getidcontacttype(),
		'descontactsubtype'=>$lang->getString('work_type')
	));
	$emailTrabalho->save();

	$emailOutro = new ContactSubType(array(
		'idcontacttype'=>$email->getidcontacttype(),
		'descontactsubtype'=>$lang->getString('other_type_email')
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
$app->get("/install-admin/sql/addresses/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_countries (
		  idcountry int(11) NOT NULL AUTO_INCREMENT,
		  descountry varchar(64) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcountry)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_states (
		  idstate int(11) NOT NULL AUTO_INCREMENT,
		  desstate varchar(64) NOT NULL,
		  desuf char(2) NOT NULL,
		  idcountry int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idstate),
		  KEY FK_states_countries_idx (idcountry),
		  CONSTRAINT FK_states_countries FOREIGN KEY (idcountry) REFERENCES tb_countries (idcountry) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_cities (
		  idcity int(11) NOT NULL AUTO_INCREMENT,
		  descity varchar(128) NOT NULL,
		  idstate int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcity),
		  KEY FK_cities_states_idx (idstate),
		  CONSTRAINT FK_cities_states FOREIGN KEY (idstate) REFERENCES tb_states (idstate) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_addressestypes (
		  idaddresstype int(11) NOT NULL AUTO_INCREMENT,
		  desaddresstype varchar(64) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idaddresstype)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_addresses (
		  idaddress int(11) NOT NULL AUTO_INCREMENT,
		  idaddresstype int(11) NOT NULL,
		  desaddress varchar(64) NOT NULL,
		  desnumber varchar(16) NOT NULL,
		  desdistrict varchar(64) NOT NULL,
		  descity varchar(64) NOT NULL,
		  desstate varchar(32) NOT NULL,
		  descountry varchar(32) NOT NULL,
		  descep char(8) NOT NULL,
		  descomplement varchar(32) DEFAULT NULL,
		  inmain bit(1) NOT NULL DEFAULT b'0',
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idaddress),
		  CONSTRAINT FK_addressestypes FOREIGN KEY (idaddresstype) REFERENCES tb_addressestypes(idaddresstype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/addresses/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		"tg_addresses_AFTER_INSERT",
		"tg_addresses_AFTER_UPDATE",
		"tg_addresses_BEFORE_DELETE"
	);
	// saveTriggers($triggers);
	echo success();
});
$app->get("/install-admin/sql/addresses/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();

	$residencial = new AddressType(array(
		'desaddresstype'=>$lang->getString('address_residencial')
	));
	$residencial->save();

	$comercial = new AddressType(array(
		'desaddresstype'=>$lang->getString('address_comercial')
	));
	$comercial->save();

	$cobranca = new AddressType(array(
		'desaddresstype'=>$lang->getString('address_cobranca')
	));
	$cobranca->save();

	$entrega = new AddressType(array(
		'desaddresstype'=>$lang->getString('address_entrega')
	));
	$entrega->save();

	echo success();

});
$app->get("/install-admin/sql/addresses/countries/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();
	$sql->arrays("
		INSERT INTO tb_countries (idcountry, descountry) VALUES (1, 'Brasil');
	");

	echo success();

});
$app->get("/install-admin/sql/addresses/states/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();

	$sql = new Sql();

	$sql->arrays("
		INSERT INTO tb_states (idstate, desstate, desuf, idcountry) VALUES
		(1, '".utf8_decode($lang->getString("state_AC"))."', 'AC', 1),
		(2, '".utf8_decode($lang->getString("state_AL"))."', 'AL', 1),
		(3, '".utf8_decode($lang->getString("state_AM"))."', 'AM', 1),
		(4, '".utf8_decode($lang->getString("state_AP"))."', 'AP', 1),
		(5, '".utf8_decode($lang->getString("state_BA"))."', 'BA', 1),
		(6, '".utf8_decode($lang->getString("state_CE"))."', 'CE', 1),
		(7, '".utf8_decode($lang->getString("state_DF"))."', 'DF', 1),
		(8, '".utf8_decode($lang->getString("state_ES"))."', 'ES', 1),
		(9, '".utf8_decode($lang->getString("state_GO"))."', 'GO', 1),
		(10, '".utf8_decode($lang->getString("state_MA"))."', 'MA', 1),
		(11, '".utf8_decode($lang->getString("state_MG"))."', 'MG', 1),
		(12, '".utf8_decode($lang->getString("state_MS"))."', 'MS', 1),
		(13, '".utf8_decode($lang->getString("state_MT"))."', 'MT', 1),
		(14, '".utf8_decode($lang->getString("state_PA"))."', 'PA', 1),
		(15, '".utf8_decode($lang->getString("state_PB"))."', 'PB', 1),
		(16, '".utf8_decode($lang->getString("state_PE"))."', 'PE', 1),
		(17, '".utf8_decode($lang->getString("state_PI"))."', 'PI', 1),
		(18, '".utf8_decode($lang->getString("state_PR"))."', 'PR', 1),
		(19, '".utf8_decode($lang->getString("state_RJ"))."', 'RJ', 1),
		(20, '".utf8_decode($lang->getString("state_RN"))."', 'RN', 1),
		(21, '".utf8_decode($lang->getString("state_RO"))."', 'RO', 1),
		(22, '".utf8_decode($lang->getString("state_RR"))."', 'RR', 1),
		(23, '".utf8_decode($lang->getString("state_RS"))."', 'RS', 1),
		(24, '".utf8_decode($lang->getString("state_SC"))."', 'SC', 1),
		(25, '".utf8_decode($lang->getString("state_SE"))."', 'SE', 1),
		(26, '".utf8_decode($lang->getString("state_SP"))."', 'SP', 1),
		(27, '".utf8_decode($lang->getString("state_TO"))."', 'TO', 1);
	");

	echo success();

});
$app->post("/install-admin/sql/addresses/cities/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);
	ini_set('memory_limit', 512);

	$data = json_decode(post('json'), true);

	$sql = new Sql();

	foreach ($data as $city) {
		$sql->arrays("
			INSERT INTO tb_cities (idcity, descity, idstate)
			VALUES(?, ?, ?);
		", array(
			(int)$city['idcity'],
			$city['descity'],
			(int)$city['idstate']
		));
	}	

	echo success();

});
$app->get("/install-admin/sql/addresses/cities/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);
	ini_set('memory_limit', 512);

	$sql = new Sql();
	
	$results = $sql->arrays("SELECT * FROM tb_cities");

	echo json_encode($results);

});
$app->get("/install-admin/sql/ordersnegotiationstypes/inserts", function(){ 

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();
	
	$results = $sql->arrays("SELECT * FROM tb_ordersnegotiationstypes");

	echo json_encode($results);

});
$app->get("/install-admin/sql/addresses/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
        "sp_addresses_get",
        "sp_addressestypes_get",
        "sp_countries_get",
        "sp_states_get",
        "sp_cities_get"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/addresses/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
        "sp_addressesfromperson_list",
        "sp_addressestypes_list",
        "sp_countries_list",
        "sp_states_list",
        "sp_cities_list",
        "sp_addressesfromplace_list"
    );
    saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/addresses/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
       "sp_addresses_save",
       "sp_addressestypes_save",
       "sp_countries_save",
       "sp_states_save",
       "sp_cities_save",
       "sp_personsaddresses_save"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/addresses/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$names = array(
       "sp_addresses_remove",
       "sp_addressestypes_remove",
       "sp_countries_remove",
       "sp_states_remove",
       "sp_cities_remove"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/permissions/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_permissions (
		  idpermission int(11) NOT NULL AUTO_INCREMENT,
		  despermission varchar(64) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpermission)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_permissionsmenus (
		  idpermission int(11) NOT NULL,
		  idmenu int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpermission, idmenu),
		  CONSTRAINT FK_menuspermissions FOREIGN KEY (idmenu) REFERENCES tb_menus (idmenu),
		  CONSTRAINT FK_permissionsmenus FOREIGN KEY (idpermission) REFERENCES tb_permissions (idpermission)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_permissionsusers (
		  idpermission int(11) NOT NULL,
		  iduser int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpermission, iduser),
		  CONSTRAINT FK_permissionsusers FOREIGN KEY (idpermission) REFERENCES tb_permissions (idpermission),
		  CONSTRAINT FK_userspermissions FOREIGN KEY (iduser) REFERENCES tb_users (iduser)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/permissions/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();
	
	$superUser = new Permission(array(
		'despermission'=>$lang->getString('permissions_user')
	));
	$superUser->save();

	$accessAdmin = new Permission(array(
		'despermission'=>$lang->getString('permissions_admin')
	));
	$accessAdmin->save();

	$accessClient = new Permission(array(
		'despermission'=>$lang->getString('permissions_client')
	));
	$accessClient->save();

	$sql = new Sql();

	$sql->arrays("
		INSERT INTO tb_permissionsmenus (idmenu, idpermission)
		SELECT idmenu, 1 FROM tb_menus;
	", array());

	$sql->arrays("
		INSERT INTO tb_permissionsusers (iduser, idpermission) VALUES
		(?, ?),
		(?, ?);
	", array(
		1, 1,
		1, 2
	));
	echo success();
});
$app->get("/install-admin/sql/permissions/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_permissions_get',
		'sp_permissionsfrommenus_list',
		'sp_permissionsfrommenusmissing_list',
		'sp_permissions_list'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/permissions/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	echo success();
});
$app->get("/install-admin/sql/permissions/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_permissions_save",
		"sp_permissionsmenus_save"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/permissions/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_permissions_remove",
		"sp_permissionsmenus_remove"
	);
	saveProcedures($procs);
	
	echo success();
});

// AQUI O RAFA PARA


// DAQUI PRA BAIXO É O RONALDO



$app->get("/install-admin/sql/personsdata/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_personsdata (
		  idperson int(11) NOT NULL,
		  desperson varchar(128) NOT NULL,
		  desname varchar(32) NOT NULL,
		  desfirstname varchar(64) NOT NULL,
		  deslastname varchar(64) NOT NULL,
		  idpersontype int(11) NOT NULL,
		  despersontype varchar(64) NOT NULL,
		  desuser varchar(128) DEFAULT NULL,
		  despassword varchar(256) DEFAULT NULL,
		  iduser int(11) DEFAULT NULL,
		  inblocked bit(1) DEFAULT NULL,
		  desemail varchar(128) DEFAULT NULL,
		  idemail int(11) DEFAULT NULL,
		  desphone varchar(32) DEFAULT NULL,
		  idphone int(11) DEFAULT NULL,
		  descpf char(11) DEFAULT NULL,
		  idcpf int(11) DEFAULT NULL,
		  descnpj char(14) DEFAULT NULL,
		  idcnpj int(11) DEFAULT NULL,
		  desrg varchar(16) DEFAULT NULL,
		  idrg int(11) DEFAULT NULL,
		  dtupdate datetime NOT NULL,
		  dessex ENUM('M', 'F'),
		  dtbirth DATE DEFAULT NULL,
		  desphoto varchar(128) DEFAULT NULL,
		  inclient BIT NOT NULL DEFAULT b'0',
		  inprovider BIT NOT NULL DEFAULT b'0',
		  incollaborator BIT NOT NULL DEFAULT b'0',
		  idaddress int(11) DEFAULT NULL,
		  idaddresstype int(11) DEFAULT NULL,
		  desaddresstype varchar(64) DEFAULT NULL,
		  desaddress varchar(64) DEFAULT NULL, 
		  desnumber varchar(16) DEFAULT NULL, 
		  desdistrict varchar(64) DEFAULT NULL, 
		  descity varchar(64) DEFAULT NULL, 
		  desstate varchar(32) DEFAULT NULL, 
		  descountry varchar(32) DEFAULT NULL, 
		  descep char(8) DEFAULT NULL, 
		  descomplement varchar(32),
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idperson),
		  KEY FK_personsdata_personstypes_idx (idpersontype),
		  KEY FK_personsdata_users_idx (iduser),
		  CONSTRAINT FK_personsdata_persons FOREIGN KEY (idperson) REFERENCES tb_persons (idperson) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_personsdata_personstypes FOREIGN KEY (idpersontype) REFERENCES tb_personstypes (idpersontype) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_personsdata_users FOREIGN KEY (iduser) REFERENCES tb_users (iduser) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/productsdata/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_productsdata(
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
$app->get("/install-admin/sql/coupons/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_couponstypes(
			idcoupontype INT NOT NULL AUTO_INCREMENT,
			descoupontype VARCHAR(128) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcoupontype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_coupons(
			idcoupon INT NOT NULL AUTO_INCREMENT,
			idcoupontype INT NOT NULL,
			descoupon VARCHAR(128) NOT NULL,
			descode VARCHAR(128) NOT NULL,
			nrqtd INT NOT NULL DEFAULT 1,
			nrqtdused INT NOT NULL DEFAULT 0,
			dtstart DATETIME NULL,
			dtend DATETIME NULL,
			inremoved BIT(1) NULL,
			nrdiscount DECIMAL(10,2) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcoupon),
			CONSTRAINT FOREIGN KEY(idcoupontype) REFERENCES tb_couponstypes(idcoupontype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/coupons/list", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$procs = array(
		'sp_coupons_list',
		'sp_couponstypes_list'
	);

	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/coupons/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_coupons_save',
		'sp_couponstypes_save'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/coupons/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_coupons_get',
		'sp_couponstypes_get'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/coupons/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_coupons_remove',
		'sp_couponstypes_remove'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/coupons/inserts", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();
	
	$sql = new Sql();
	$sql->arrays("
		INSERT INTO tb_couponstypes(descoupontype)
		VALUES(?), (?);
	", array(
		$lang->getString('coupon_value'),
		$lang->getString('coupon_percentage')
		
	));
	echo success();
});

$app->get("/install-admin/sql/carts/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_carts(
			idcart INT NOT NULL AUTO_INCREMENT,
			idperson INT NOT NULL,
			dessession VARCHAR(128) NOT NULL,
			inclosed BIT(1),
			nrproducts INT NULL,
			vltotal DECIMAL(10,2) NULL,
			vltotalgross DECIMAL(10,2),
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcart),
			CONSTRAINT FOREIGN KEY(idperson) REFERENCES tb_persons(idperson)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_cartsproducts(
			idcartproduct INT NOT NULL AUTO_INCREMENT,
			idcart INT NOT NULL,
			idproduct INT NOT NULL,
			dtremoved DATETIME NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idcartproduct),
			CONSTRAINT FOREIGN KEY(idcart) REFERENCES tb_carts(idcart),
			CONSTRAINT FOREIGN KEY(idproduct) REFERENCES tb_products(idproduct)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_cartsfreights(
			idcart INT NOT NULL,
			descep CHAR(8) NOT NULL,
			vlfreight DECIMAL(10,2) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idcart) REFERENCES tb_carts(idcart)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_cartscoupons(
			idcart INT NOT NULL,
			idcoupon INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idcart) REFERENCES tb_carts(idcart),
			CONSTRAINT FOREIGN KEY(idcoupon) REFERENCES tb_coupons(idcoupon)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/carts/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		"tg_cartscoupons_AFTER_INSERT",
		"tg_cartscoupons_AFTER_UPDATE",		
		"tg_cartsfreights_AFTER_INSERT",
		"tg_cartsfreights_AFTER_UPDATE",		
		"tg_cartsproducts_AFTER_INSERT",
		"tg_cartsproducts_AFTER_UPDATE"		
	);
	saveTriggers($triggers);
	echo success();
});
$app->get("/install-admin/sql/carts/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_carts_list",
		"sp_cartsproducts_list",
		"sp_cartsfromperson_list",
		'sp_cartscoupons_list',
		'sp_cartsfreights_list',
		'sp_productsfromcart_list',
		'sp_couponsfromcart_list'
	);
	saveProcedures($procs);
	echo success();
	
});
$app->get("/install-admin/sql/carts/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_carts_get",
		"sp_cartsproducts_get",
		'sp_cartscoupons_get',
		'sp_cartsfreights_get'
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/carts/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_carts_save",
		"sp_cartsproducts_save",
		'sp_cartscoupons_save',
		'sp_cartsfreights_save',
		'sp_cartsdata_save'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/carts/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_carts_remove",
		"sp_cartsproducts_remove",
		'sp_cartscoupons_remove',
		'sp_cartsfreights_remove'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/creditcards/tables", function(){

	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_creditcards(
			idcard INT NOT NULL AUTO_INCREMENT,
			idperson INT NOT NULL,
			desname VARCHAR(64) NOT NULL,
			dtvalidity DATE NOT NULL,
			nrcds VARCHAR(8) NOT NULL,
			desnumber CHAR(16) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcard),
			CONSTRAINT FOREIGN KEY(idperson) REFERENCES tb_persons(idperson)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});
$app->get("/install-admin/sql/creditcards/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_creditcards_list",
		"sp_cardsfromperson_list"
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/creditcards/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$name = array(
		"sp_creditcards_get"
	);
	
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/creditcards/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$name = array(
		"sp_creditcards_save"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/creditcards/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$name = array(
		"sp_creditcards_remove"
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
$app->get("/install-admin/sql/orders/tables", function(){
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
		CREATE TABLE tb_formspayments(
			idformpayment INT NOT NULL AUTO_INCREMENT,
			idgateway INT NOT NULL,
			desformpayment VARCHAR(128) NOT NULL,
			nrparcelsmax INT NOT NULL,
			instatus BIT(1),
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idformpayment),
			CONSTRAINT FOREIGN KEY(idgateway) REFERENCES tb_gateways(idgateway)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_ordersstatus(
			idstatus INT NOT NULL AUTO_INCREMENT,
			desstatus VARCHAR(128) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idstatus)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_orders(
			idorder INT NOT NULL AUTO_INCREMENT,
			idperson INT NOT NULL,
			idformpayment INT NOT NULL,
			idstatus INT NOT NULL,
			dessession VARCHAR(128) NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			nrparcels INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idorder),
			CONSTRAINT FOREIGN KEY(idperson) REFERENCES tb_persons(idperson),
			CONSTRAINT FOREIGN KEY(idformpayment) REFERENCES tb_formspayments(idformpayment),
			CONSTRAINT FOREIGN KEY(idstatus) REFERENCES tb_ordersstatus(idstatus)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_ordersproducts(
			idorder INT NOT NULL,
			idproduct INT NOT NULL,
			nrqtd INT NOT NULL,
			vlprice DECIMAL(10,2) NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idorder, idproduct),
			CONSTRAINT FOREIGN KEY(idorder) REFERENCES tb_orders(idorder),
			CONSTRAINT FOREIGN KEY(idproduct) REFERENCES tb_products(idproduct)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_ordersreceipts(
			idorder INT NOT NULL,
			desauthentication VARCHAR(256) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idorder),
			CONSTRAINT FOREIGN KEY(idorder) REFERENCES tb_orders(idorder)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_orderslogs(
			idlog INT NOT NULL AUTO_INCREMENT,
			idorder INT NOT NULL,
			iduser INT NOT NULL,
			dtregister TIMESTAMP NULL,			
			CONSTRAINT PRIMARY KEY(idlog),
			CONSTRAINT FOREIGN KEY(idorder) REFERENCES tb_orders(idorder),
			CONSTRAINT FOREIGN KEY(iduser) REFERENCES tb_users(iduser)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_ordersnegotiationstypes (
		  idnegotiation int(11) NOT NULL AUTO_INCREMENT,
		  desnegotiation varchar(64) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idnegotiation)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");		
	$sql->exec("
		CREATE TABLE tb_ordersnegotiations (
		  idnegotiation int(11) NOT NULL,
		  idorder int(11) NOT NULL,
		  dtstart datetime NOT NULL,
		  dtend datetime DEFAULT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idnegotiation,idorder),
		  KEY FK_ordersnegotiations_orders_idx (idorder),
		  CONSTRAINT FK_ordersnegotiations_orders FOREIGN KEY (idorder) REFERENCES tb_orders (idorder) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_ordersnegotiations_ordersnegotiationstypes FOREIGN KEY (idorder) REFERENCES tb_ordersnegotiationstypes (idnegotiation) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});
$app->get("/install-admin/sql/orders/inserts", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();
	
	$sql = new Sql();
	$sql->arrays("
		INSERT INTO tb_formspayments (idgateway, desformpayment, nrparcelsmax, instatus) VALUES
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
		INSERT INTO tb_ordersstatus(desstatus)
		VALUES(?), (?), (?), (?), (?), (?), (?);
	", array(
	    $lang->getString('statu_order'),
	 	$lang->getString('statu_analysis'),
	 	$lang->getString('statu_paid'),
	 	$lang->getString('statu_available'),
		$lang->getString('statu_dispute'),
		$lang->getString('statu_returned'),
		$lang->getString('statu_canceled')
	));

	$sql->arrays("
		INSERT INTO tb_ordersnegotiationstypes(desnegotiation)
		VALUES(?), (?);
	", array(
	    $lang->getString('negotiation_estimate'),
	 	$lang->getString('negotiation_sale')
	));
	
	echo success();
	
});
$app->get("/install-admin/sql/orders/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_orders_list',
		'sp_orders_list',
		'sp_ordersproducts_list',
		'sp_ordersreceipts_list',
		'sp_ordersstatus_list',
		'sp_ordersfromperson_list',
		'sp_receiptsfromorder_list',
		'sp_orderslogs_list'
	);
	saveProcedures($procs);
	
	echo success();
	
});

$app->get("/install-admin/sql/ordersnegotiationstypes/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
	
		'sp_ordersnegotiationstypes_list'
		
	);
	saveProcedures($procs);
	
	echo success();
	
});

$app->get("/install-admin/sql/ordersnegotiationstypes/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(

		'sp_ordersnegotiationstypes_get'
		
	);
	saveProcedures($procs);
	
	echo success();
	
});

$app->get("/install-admin/sql/ordersnegotiationstypes/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		
		'sp_ordersnegotiationstypes_save'
		
	);
	saveProcedures($procs);
	
	echo success();
	
});

$app->get("/install-admin/sql/ordersnegotiationstypes/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
	
		'sp_ordersnegotiationstypes_remove'
		
	);
	saveProcedures($procs);
	
	echo success();
		
});		

$app->get("/install-admin/sql/orders/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_orders_get',
		'sp_orders_get',
		'sp_ordersproducts_get',
		'sp_ordersreceipts_get',
		'sp_ordersstatus_get',
		'sp_orderslogs_get'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/orders/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_orders_save',
		'sp_orders_save',
		'sp_ordersproducts_save',
		'sp_ordersreceipts_save',
		'sp_ordersstatus_save',
		'sp_orderslogs_save'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/orders/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_orders_remove',
		'sp_orders_remove',
		'sp_ordersproducts_remove',
		'sp_ordersreceipts_remove',
		'sp_ordersstatus_remove',
		'sp_orderslogs_remove'
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
			idpersonanswer INT NULL,
			desmessage VARCHAR(2048) NOT NULL,
			inread BIT(1) NULL,
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
// places
$app->get("/install-admin/sql/places/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_placestypes(
			idplacetype INT NOT NULL AUTO_INCREMENT,
			desplacetype VARCHAR(128) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT PRIMARY KEY(idplacetype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_places(
			idplace INT NOT NULL AUTO_INCREMENT,
			idplacefather INT NULL,
			desplace VARCHAR(128) NOT NULL,
			idplacetype INT NOT NULL,
			descontent TEXT NULL,
			nrviews INT NULL,
			vlreview DECIMAL(10,2) NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idplace),
			CONSTRAINT FOREIGN KEY(idplacefather) REFERENCES tb_places(idplace),
			CONSTRAINT FOREIGN KEY(idplacetype) REFERENCES tb_placestypes(idplacetype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_placesschedules(
			idschedule INT NOT NULL AUTO_INCREMENT,
			idplace INT NOT NULL,
			nrday TINYINT(4) NOT NULL,
			hropen TIME NULL,
			hrclose TIME NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idschedule),
			CONSTRAINT FOREIGN KEY(idplace) REFERENCES tb_places(idplace)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_placescoordinates(
			idplace INT NOT NULL,
			idcoordinate INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idplace) REFERENCES tb_places(idplace),
			CONSTRAINT FOREIGN KEY(idcoordinate) REFERENCES tb_coordinates(idcoordinate)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_placesaddresses(
			idplace INT NOT NULL,
			idaddress INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idplace) REFERENCES tb_places(idplace),
			CONSTRAINT FOREIGN KEY(idaddress) REFERENCES tb_addresses(idaddress)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_placesvaluesfields(
			idfield INT NOT NULL AUTO_INCREMENT,
			desfield VARCHAR(128) NOT NULL,
			CONSTRAINT PRIMARY KEY(idfield),
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP()
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_placesvalues(
			idplacevalue INT NOT NULL AUTO_INCREMENT,
			idplace INT NOT NULL,
			idfield INT NOT NULL,
			desvalue VARCHAR(128) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idplacevalue),
			CONSTRAINT FOREIGN KEY(idplace) REFERENCES tb_places(idplace),
			CONSTRAINT FOREIGN KEY(idfield) REFERENCES tb_placesvaluesfields(idfield)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("

		CREATE TABLE tb_placesdata(
			idplace INT NOT NULL,
			desplace VARCHAR(128) NOT NULL,
			idplacefather INT NULL,
			desplacefather VARCHAR(128) NULL,
			idplacetype INT NOT NULL,
			desplacetype  VARCHAR(128) NOT NULL,
			idaddresstype INT NULL,
			desaddresstype VARCHAR(128) NULL,
			idaddress INT NULL,
			desaddress VARCHAR(128) NULL,
			desnumber VARCHAR(16) NULL,
			desdistrict VARCHAR(64) NULL,
			descity VARCHAR(64) NULL,
			desstate VARCHAR(32) NULL,
			descountry VARCHAR(32) NULL,
			descep CHAR(8) NULL,
			descomplement VARCHAR(32) NULL,
			idcoordinate INT NULL,
			vllatitude DECIMAL(20,17) NULL,
			vllongitude DECIMAL(20,17) NULL,
			nrzoom TINYINT(4) NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idplace),
			CONSTRAINT FOREIGN KEY(idplace) REFERENCES tb_places(idplace),
			CONSTRAINT FOREIGN KEY(idplacefather) REFERENCES tb_places(idplace),
			CONSTRAINT FOREIGN KEY(idplacetype) REFERENCES tb_placestypes(idplacetype),
			CONSTRAINT FOREIGN KEY(idaddress) REFERENCES tb_addresses(idaddress),
			CONSTRAINT FOREIGN KEY(idaddresstype) REFERENCES tb_addressestypes(idaddresstype),
			CONSTRAINT FOREIGN KEY(idcoordinate) REFERENCES tb_coordinates(idcoordinate)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});
$app->get("/install-admin/sql/places/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		'tg_places_AFTER_INSERT',
		'tg_places_AFTER_UPDATE',
		'tg_places_BEFORE_DELETE',

		'tg_placescoordinates_AFTER_INSERT',
		'tg_placescoordinates_AFTER_UPDATE',
		'tg_placescoordinates_BEFORE_DELETE',

		'tg_placesaddresses_AFTER_INSERT',
		'tg_placesaddresses_AFTER_UPDATE',
		'tg_placesaddresses_BEFORE_DELETE'
	);
	saveTriggers($triggers);

	echo success();

});
$app->get("/install-admin/sql/places/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		"sp_places_list",
		"sp_placestypes_list",
		"sp_placesschedules_list"
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/places/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_placestypes_get',
		'sp_places_get',
		'sp_placesschedules_get'
	);
	saveProcedures($procs);
	
	echo success();
	
});

$app->get("/install-admin/sql/placesvaluesfield/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		
		'sp_placesvaluesfield_get'
	);
	saveProcedures($procs);
	
	echo success();
	
});

$app->get("/install-admin/sql/places/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_placestypes_save',
		'sp_places_save',
		'sp_placesdata_save',
		'sp_placescoordinates_add',
		'sp_placesschedules_save',
		'sp_placesaddresses_add',
		'sp_placesfiles_add'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/places/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_placestypes_remove',
		'sp_places_remove',
		'sp_placesdata_remove',
		'sp_placesschedules_remove',
		'sp_placesschedulesall_remove'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/places/inserts", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$lang = new Language();
	
	$district = new PlaceType(array(
		'desplacetype'=>$lang->getString('placetype_district')
	));
	$district->save();

	$city = new PlaceType(array(
		'desplacetype'=>$lang->getString('placetype_city')
	));
	$city->save();

	$state = new PlaceType(array(
		'desplacetype'=>$lang->getString('placetype_state')
	));
	$state->save();

	$country = new PlaceType(array(
		'desplacetype'=>$lang->getString('placetype_country')
	));
	$country->save();

	$companies = new PlaceType(array(
		'desplacetype'=>$lang->getString('placetype_companies')
	));
	$companies->save();
	
	$address = new Address(array(
		'idaddresstype'=>AddressType::COMERCIAL,
		'desaddress'=>$lang->getString('placetype_hcode_address'),
		'desnumber'=>$lang->getString('placetype_hcode_number'),
		'desdistrict'=>$lang->getString('placetype_hcode_district'),
		'descity'=>$lang->getString('placetype_hcode_city'),
		'desstate'=>$lang->getString('placetype_hcode_state'),
		'descountry'=>$lang->getString('placetype_hcode_country'),
		'descep'=>$lang->getString('placetype_hcode_cep'),
		'inmain'=>true
	));
	$address->save();

	$placeHcode = new Place(array(
		'desplace'=>$lang->getString('place_hcode'),
		'idplacetype'=>$companies->getidplacetype()
	));
	$placeHcode->save();
	$placeHcode->setaddress($address);
	
	echo success();
	
});
// places files
$app->get("/install-admin/sql/placesfiles/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_placesfiles(
			idplace INT NOT NULL,
			idfile INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idplace) REFERENCES tb_places(idplace),
			CONSTRAINT FOREIGN KEY(idfile) REFERENCES tb_files(idfile)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});
// coordinates
$app->get("/install-admin/sql/coordinates/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_coordinates(
			idcoordinate INT NOT NULL AUTO_INCREMENT,
			vllatitude DECIMAL(20,17) NOT NULL,
			vllongitude DECIMAL(20,17) NOT NULL,
			nrzoom TINYINT(4) NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcoordinate)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->exec("
		CREATE TABLE tb_addressescoordinates(
			idaddress INT NOT NULL,
			idcoordinate INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idaddress) REFERENCES tb_addresses(idaddress),
			CONSTRAINT FOREIGN KEY(idcoordinate) REFERENCES tb_coordinates(idcoordinate)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});
$app->get("/install-admin/sql/coordinates/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_coordinates_get'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/coordinates/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_coordinates_save'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/coordinates/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_coordinates_remove'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/courses/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();

	$sql->exec("
		CREATE TABLE tb_courses (
		  idcourse int(11) NOT NULL AUTO_INCREMENT,
		  descourse varchar(64) NOT NULL,
		  destitle varchar(256) DEFAULT NULL,
		  vlworkload decimal(10,2) NOT NULL DEFAULT '0.00',
		  nrlessons int(11) NOT NULL DEFAULT '0',
		  nrexercises int(11) NOT NULL DEFAULT '0',
		  desdescription varchar(10240) DEFAULT NULL,
		  inremoved bit(1) NOT NULL DEFAULT b'0',
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcourse)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->exec("
		CREATE TABLE tb_coursessections (
		  idsection int(11) NOT NULL AUTO_INCREMENT,
		  dessection varchar(128) NOT NULL,
		  nrorder int(11) NOT NULL DEFAULT '0',
		  idcourse int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idsection),
		  KEY FK_coursessections_courses_idx (idcourse),
		  CONSTRAINT FK_coursessections_courses FOREIGN KEY (idcourse) REFERENCES tb_courses (idcourse) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->exec("
		CREATE TABLE tb_coursescurriculums (
		  idcurriculum int(11) NOT NULL AUTO_INCREMENT,
		  descurriculum varchar(128) NOT NULL,
		  idsection int(11) NOT NULL,
		  desdescription varchar(2048) DEFAULT NULL,
		  nrorder varchar(45) DEFAULT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcurriculum),
		  KEY FK_coursescurriculums_coursessections_idx (idsection),
		  CONSTRAINT FK_coursescurriculums_coursessections FOREIGN KEY (idsection) REFERENCES tb_coursessections (idsection) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();
});

$app->get("/install-admin/sql/courses/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_courses_list',
		'sp_coursescurriculums_list',
		'sp_coursessections_list',
		'sp_sectionsfromcourse_list',
		'sp_curriculumsfromcourse_list'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/courses/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_courses_get',
		'sp_coursescurriculums_get',
		'sp_coursessections_get'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/courses/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_courses_save',
		'sp_coursescurriculums_save',
		'sp_coursessections_save'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/courses/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_courses_remove',
		'sp_coursescurriculums_remove',
		'sp_coursessections_remove'
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
		  descontent text,
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

$app->get("/install-admin/sql/configurations/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_configurationstypes (
		  idconfigurationtype int(11) NOT NULL AUTO_INCREMENT,
		  desconfigurationtype varchar(32) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idconfigurationtype)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->exec("
		CREATE TABLE tb_configurations (
		  idconfiguration int(11) NOT NULL AUTO_INCREMENT,
		  desconfiguration varchar(64) NOT NULL,
		  desvalue varchar(2048) NOT NULL,
		  desdescription varchar(256) NULL,
		  idconfigurationtype int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idconfiguration),
		  KEY FK_configurations_configurationstypes_idx (idconfigurationtype),
		  KEY IX_desconfiguration (desconfiguration),
		  CONSTRAINT FK_configurations_configurationstypes FOREIGN KEY (idconfigurationtype) REFERENCES tb_configurationstypes (idconfigurationtype) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();

});

$app->get("/install-admin/sql/configurations/inserts", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$lang = new Language();

	$texto = new ConfigurationType(array(
		'desconfigurationtype'=>$lang->getString('configtype_string')
	));
	$texto->save();

	$int = new ConfigurationType(array(
		'desconfigurationtype'=>$lang->getString('configtype_int')
	));
	$int->save();

	$float = new ConfigurationType(array(
		'desconfigurationtype'=>$lang->getString('configtype_float')
	));
	$float->save();

	$bool = new ConfigurationType(array(
		'desconfigurationtype'=>$lang->getString('configtype_boolean')
	));
	$bool->save();

	$data = new ConfigurationType(array(
		'desconfigurationtype'=>$lang->getString('configtype_datetime')
	));
	$data->save();

	$array = new ConfigurationType(array(
		'desconfigurationtype'=>$lang->getString('configtype_object')
	));
	$array->save();

	$adminName = new Configuration(array(
		'desconfiguration'=>$lang->getString('config_admin_name'),
		'desvalue'=>$lang->getString('config_admin_name_value'),
		'idconfigurationtype'=>$texto->getidconfigurationtype(),
		'desdescription'=>$lang->getString('config_admin_name_description')
	));
	$adminName->save();

	$uploadDir = new Configuration(array(
		'desconfiguration'=>$lang->getString('config_upload_dir'),
		'desvalue'=>$lang->getString('config_upload_dir_value'),
		'idconfigurationtype'=>$texto->getidconfigurationtype(),
		'desdescription'=>$lang->getString('config_upload_dir_description')
	));
	$uploadDir->save();

	$uploadMaxSize = new Configuration(array(
		'desconfiguration'=>$lang->getString('config_upload_max_filesize'),
		'desvalue'=>file_upload_max_size(),
		'idconfigurationtype'=>$int->getidconfigurationtype(),
		'desdescription'=>$lang->getString('config_upload_max_filesize_description')
	));
	$uploadMaxSize->save();

	$uploadMimes = new Configuration(array(
		'desconfiguration'=>$lang->getString('config_upload_mimetype'),
		'desvalue'=>json_encode(array(
			'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf'
		)),
		'idconfigurationtype'=>$array->getidconfigurationtype(),
		'desdescription'=>$lang->getString('config_upload_mimetype_description')
	));
	$uploadMimes->save();

	$googleMapKey = new Configuration(array(
		'desconfiguration'=>$lang->getString('config_google_map_key'),
		'desvalue'=>$lang->getString('google_map_key'),
		'idconfigurationtype'=>$texto->getidconfigurationtype(),
		'desdescription'=>$lang->getString('config_google_map_key_description')
	));
	$googleMapKey->save();

	echo success();

});

$app->get("/install-admin/sql/configurations/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_configurationstypes_get',
		'sp_configurationstypes_list',
		'sp_configurations_get',
		'sp_configurations_list'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/configurations/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_configurationstypes_save',
		'sp_configurations_save'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/configurations/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_configurationstypes_remove',
		'sp_configurations_remove'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/files/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	
	$sql = new Sql();
	$sql->exec("
		CREATE TABLE tb_files (
		  idfile int(11) NOT NULL AUTO_INCREMENT,
		  desdiretorio varchar(256) NOT NULL,
		  desfile varchar(128) NOT NULL,
		  desextension varchar(32) NOT NULL,
		  desalias varchar(128) NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idfile)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();

});

$app->get("/install-admin/sql/files/get", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_files_get'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/files/save", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_files_save'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/files/remove", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_files_remove'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/files/list", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$procs = array(
		'sp_files_list'
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

$app->get("/install-admin/sql/productsfiles/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();

	$sql->exec("
		CREATE TABLE tb_productsfiles (
		  idproduct int(11) NOT NULL,
		  idfile int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idproduct,idfile),
		  KEY FK_productsfiles_files_idx (idfile),
		  CONSTRAINT FK_productsfiles_files FOREIGN KEY (idfile) REFERENCES tb_files (idfile) ON DELETE CASCADE ON UPDATE CASCADE,
		  CONSTRAINT FK_productsfiles_products FOREIGN KEY (idproduct) REFERENCES tb_products (idproduct) ON DELETE CASCADE ON UPDATE CASCADE
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";	
	");

	echo success();

});

$app->get("/install-admin/sql/personsfiles/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();

	$sql->exec("
		CREATE TABLE tb_personsfiles (
		  idperson int(11) NOT NULL,
		  idfile int(11) NOT NULL,
		  dtregister timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idperson,idfile),
		  KEY FK_personsfiles_files_idx (idfile),
		  CONSTRAINT FK_personsfiles_files FOREIGN KEY (idfile) REFERENCES tb_files (idfile) ON DELETE CASCADE ON UPDATE CASCADE,
		  CONSTRAINT FK_personsfiles_persons FOREIGN KEY (idperson) REFERENCES tb_persons (idperson) ON DELETE CASCADE ON UPDATE CASCADE
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/personsfiles/procs", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$procs = array(
		'sp_personsfiles_save'
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
		  destitle varchar(64) DEFAULT NULL,
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

$app->get("/install-admin/sql/personsaddresses/tables", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);

	$sql = new Sql();

	$sql->exec("
		CREATE TABLE tb_personsaddresses(
			idperson INT NOT NULL,
			idaddress INT NOT NULL,
			dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idperson) REFERENCES tb_persons(idperson),
			CONSTRAINT FOREIGN KEY(idaddress) REFERENCES tb_addresses(idaddress)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/personsaddresses/triggers", function(){
	set_time_limit(0);
	ini_set('max_execution_time', 0);
	$triggers = array(
		"tg_personsaddresses_AFTER_INSERT",
		"tg_personsaddresses_AFTER_UPDATE",
		"tg_personsaddresses_BEFORE_DELETE"
	);
	saveTriggers($triggers);
	echo success();
});


?>