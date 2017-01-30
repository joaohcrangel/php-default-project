<?php
define("PATH_PROC", PATH."/res/sql/procedures/");
define("PATH_TRIGGER", PATH."/res/sql/triggers/");

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

$app->get("/install-admin/sql/clear", function(){

	$sql = new Sql();
	
	$procs = $sql->arrays("SHOW PROCEDURE STATUS WHERE Db = '".DB_NAME."';");
	foreach ($procs as $row) {
		$sql->query("DROP PROCEDURE IF EXISTS ".$row['Name'].";");
	}

	$funcs = $sql->arrays("SHOW FUNCTION STATUS WHERE Db = '".DB_NAME."';");
	foreach ($funcs as $row) {
		$sql->query("DROP FUNCTION IF EXISTS ".$row['Name'].";");
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
		$sql->query("alter table ".$row['TABLE_NAME']." drop foreign key ".$row['CONSTRAINT_NAME'].";");
	}

	$tables = $sql->arrays("
		SHOW TABLES;
	");
	foreach ($tables as $row) {
		$sql->query("DROP TABLE IF EXISTS ".$row['Tables_in_'.DB_NAME].";");
	}
	
	echo success();
});
$app->get("/install-admin/sql/pessoas/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_pessoastipos (
		  idpessoatipo int(11) NOT NULL AUTO_INCREMENT,
		  despessoatipo varchar(64) NOT NULL,
		  dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpessoatipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_pessoas (
		  idpessoa int(11) NOT NULL AUTO_INCREMENT,
		  idpessoatipo int(1) NOT NULL,
		  despessoa varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpessoa),
		  KEY FK_pessoastipos (idpessoatipo),
		  CONSTRAINT FK_pessoas_pessoastipos FOREIGN KEY (idpessoatipo) REFERENCES tb_pessoastipos (idpessoatipo) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_historicostipos (
			idhistoricotipo int(11) NOT NULL AUTO_INCREMENT,
			deshistoricotipo varchar(32) NOT NULL,
			dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (idhistoricotipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
        CREATE TABLE tb_pessoashistoricos (
			idpessoahistorico int(11) NOT NULL AUTO_INCREMENT,
			idpessoa int(11) NOT NULL,
			idhistoricotipo int(11) NOT NULL,
			deshistorico varchar(512) NOT NULL,
			dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (idpessoahistorico),
			KEY fk_pessoashistoricos_historicostipos (idhistoricotipo),
			KEY fk_pessoashistoricos_pessoas_idx (idpessoa),
			CONSTRAINT fk_pessoashistoricos_historicostipos FOREIGN KEY (idhistoricotipo) REFERENCES tb_historicostipos (idhistoricotipo) ON DELETE NO ACTION ON UPDATE NO ACTION,
			CONSTRAINT fk_pessoashistoricos_pessoas FOREIGN KEY (idpessoa) REFERENCES tb_pessoas (idpessoa) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();
});
$app->get("/install-admin/sql/pessoas/triggers", function(){
	$sql = new Sql();

	$triggers = array(
		"tg_pessoas_AFTER_INSERT",
		"tg_pessoas_AFTER_UPDATE",
		"tg_pessoas_BEFORE_DELETE"
	);

	foreach ($triggers as $name) {
		$sql->query("DROP TRIGGER IF EXISTS {$name};");
		$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/pessoas/inserts", function(){
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_pessoastipos (despessoatipo) VALUES
		(?),
		(?);
	", array(
		'Física',
		'Jurídica'
	));
	$sql->query("
		INSERT INTO tb_pessoas (despessoa, idpessoatipo) VALUES
		(?, ?);
	", array(
		'Super Usuário (root)', 1
	));
	echo success();
});
$app->get("/install-admin/sql/pessoas/get", function(){
	$sql = new Sql();

	$procs = array(
		"sp_pessoas_get",
		"sp_historicostipos_get",
		"sp_pessoashistoricos_get"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/pessoas/list", function(){
	$sql = new Sql();

	$procs = array(
		"sp_pessoas_list",
		"sp_pessoastipos_list",
        "sp_historicostipos_list"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/pessoas/save", function(){
	$sql = new Sql();

	$names = array(
		"sp_pessoasdados_save"
	);

	foreach ($names as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});

$app->get("/install-admin/sql/pessoas/remove", function(){
	$sql = new Sql();

	$names = array(
		"sp_pessoasdados_remove",
		"sp_pessoas_remove"
	);

	foreach ($names as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});

$app->get("/install-admin/sql/produtos/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_produtostipos(
			idprodutotipo INT NOT NULL AUTO_INCREMENT,
			desprodutotipo VARCHAR(64) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idprodutotipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_produtos(
			idproduto INT NOT NULL AUTO_INCREMENT,
			idprodutotipo INT NOT NULL,
			desproduto VARCHAR(64) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT PRIMARY KEY(idproduto),
			CONSTRAINT FOREIGN KEY(idprodutotipo) REFERENCES tb_produtostipos(idprodutotipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_produtosprecos(
			idpreco INT NOT NULL AUTO_INCREMENT,
			idproduto INT NOT NULL,
			dtinicio DATETIME NOT NULL,
			dttermino DATETIME NOT NULL,
			vlpreco DECIMAL(10,2) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idpreco),
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/produtos/triggers", function(){
	$sql = new Sql();

	$triggers = array(
		"tg_produtos_AFTER_INSERT",
		"tg_produtos_AFTER_UPDATE",
		"tg_produtos_BEFORE_DELETE",
		"tg_produtosprecos_AFTER_INSERT",
		"tg_produtosprecos_AFTER_UPDATE",
		"tg_produtosprecos_BEFORE_DELETE"
	);

	foreach ($triggers as $name) {
		$sql->query("DROP TRIGGER IF EXISTS {$name};");
		$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	}
	
	echo success();
});
$app->get("/install-admin/sql/produtos/inserts", function(){
	$sql = new Sql();

	echo success();
});
$app->get("/install-admin/sql/produtos/get", function(){
	$sql = new Sql();

	$procs = array(
		"sp_produto_get",
		"sp_produtotipo_get",
		"sp_produtosprecos_get"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
	
	echo success();
});
$app->get("/install-admin/sql/produtos/list", function(){
	$sql = new Sql();

	$procs = array(
		"sp_produtos_list",
		"sp_produtostipos_list",
		"sp_produtosprecos_list",
		"sp_carrinhosfromproduto_list",
		"sp_pagamentosfromproduto_list",
		"sp_precosfromproduto_list"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
});
$app->get("/install-admin/sql/produtos/save", function(){
	$sql = new Sql();

	$procs = array(
		"sp_produto_save",
		"sp_produtotipo_save",
		"sp_produtosprecos_save",
		"sp_produtosdados_save"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
	
	echo success();
});
$app->get("/install-admin/sql/produtos/remove", function(){
	$sql = new Sql();

	$procs = array(
		"sp_produto_remove",
		"sp_produtotipo_remove",
		"sp_produtosprecos_remove",
		"sp_produtosdados_remove"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});

$app->get("/install-admin/sql/usuarios/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_usuariostipos (
		  idusuariotipo int(11) NOT NULL AUTO_INCREMENT,
		  desusuariotipo varchar(32) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idusuariotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_usuarios (
		  idusuario int(11) NOT NULL AUTO_INCREMENT,
		  idpessoa int(11) NOT NULL,
		  desusuario varchar(128) NOT NULL,
		  dessenha varchar(256) NOT NULL,
		  inbloqueado bit(1) NOT NULL DEFAULT b'0',
		  idusuariotipo int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idusuario),
		  CONSTRAINT FK_usuarios_pessoas FOREIGN KEY (idpessoa) REFERENCES tb_pessoas (idpessoa) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_usuarios_usuariostipos FOREIGN KEY (idusuariotipo) REFERENCES tb_usuariostipos (idusuariotipo) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();
});
$app->get("/install-admin/sql/usuarios/triggers", function(){
	$sql = new Sql();

	$triggers = array(
		"tg_usuarios_AFTER_INSERT",
		"tg_usuarios_AFTER_UPDATE",
		"tg_usuarios_BEFORE_DELETE"
	);

	foreach ($triggers as $name) {
		$sql->query("DROP TRIGGER IF EXISTS {$name};");
		$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/usuarios/inserts", function(){
	$sql = new Sql();
	$hash = Usuario::getPasswordHash("root");

	$sql->proc("sp_usuariostipos_save", array(
		0,
		'Administrativo'
	));
	$sql->proc("sp_usuariostipos_save", array(
		0,
		'Cliente'
	));
	
	$sql->query("
		INSERT INTO tb_usuarios (idpessoa, desusuario, dessenha, idusuariotipo) VALUES
		(?, ?, ?, ?);
	", array(
		1, 'root', $hash, 1
	));

	$sql->query("
		INSERT INTO tb_usuarios (idpessoa, desusuario, dessenha, idusuariotipo) VALUES
		(?, ?, ?, ?);
	", array(
		1, 'root', $hash, 1
	));

	echo success();
});
$app->get("/install-admin/sql/usuarios/get", function(){
	$sql = new Sql();

	$procs = array(
		"sp_usuarios_get",
		"sp_usuarioslogin_get",
		"sp_usuariosfromemail_get",
		"sp_usuariosfrommenus_list",
		"sp_usuariostipos_get"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/usuarios/remove", function(){
	$sql = new Sql();

	$procs = array(
		"sp_usuarios_remove",
		"sp_usuariostipos_remove"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
	
	echo success();
});
$app->get("/install-admin/sql/usuarios/save", function(){
	$sql = new Sql();

	$procs = array(
		"sp_usuarios_save",
		"sp_usuariostipos_save"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/usuarios/list", function(){
	$sql = new Sql();

	$names = array(
        "sp_usuariostipos_list"
	);

	foreach ($names as $name) {
        $sql->query("DROP PROCEDURE IF EXISTS {$name};");
	    $sql->queryFromFile(PATH_PROC."{$name}.sql");
		
	}

	echo success();
});
$app->get("/install-admin/sql/menus/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_menus (
		  idmenu int(11) NOT NULL AUTO_INCREMENT,
		  idmenupai int(11) DEFAULT NULL,
		  desmenu varchar(128) NOT NULL,
		  desicone varchar(64) NOT NULL,
		  deshref varchar(64) NOT NULL,
		  nrordem int(11) NOT NULL,
		  nrsubmenus int(11) DEFAULT '0' NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idmenu),
		  CONSTRAINT FK_menus_menus FOREIGN KEY (idmenupai) REFERENCES tb_menus (idmenu) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_menususuarios (
		  idmenu int(11) NOT NULL,
		  idusuario int(11) NOT NULL,
		  CONSTRAINT FOREIGN KEY FK_usuariosmenuspessoas (idusuario) REFERENCES tb_usuarios(idusuario),
		  CONSTRAINT FOREIGN KEY FK_usuariosmenusmenus (idmenu) REFERENCES tb_menus(idmenu)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();
});
$app->get("/install-admin/sql/menus/inserts", function(){
	$sql = new Sql();
	$sql->proc("sp_menus_save", array(
		NULL,
		0,
		'md-view-dashboard', 
		'/', 
		0, 
		'Dashboard'
	));
	$sql->proc("sp_menus_save", array(
		NULL,
		0,
		'md-settings', 
		'', 
		0, 
		'Sistema'
	));
	$sql->proc("sp_menus_save", array(
		NULL,
		0,
		'md-accounts', 
		'/pessoas', 
		0, 
		'Pessoas'
	));
	$sql->proc("sp_menus_save", array(
		2,
		0,
		'', 
		'/sistema/menu', 
		0, 
		'Menu'
	));
	$sql->proc("sp_menus_save", array(
		2,
		0,
		'', 
		'/sistema/usuarios', 
		0, 
		'Usuários'
	));
	$sql->proc("sp_menus_save", array(
		2,
		0,
		'', 
		'/sistema/sql-to-class', 
		1, 
		'SQL to CLASS'
	));
	$sql->proc("sp_menus_save", array(
		2,
		0,
		'', 
		'/../res/theme/material/base/html/index.html', 
		2, 
		'Template'
	));
	
	echo success();
});
$app->get("/install-admin/sql/menus/get", function(){
	$sql = new Sql();

	$names = array(
       "sp_menus_get"
	);

	foreach ($names as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	    $sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/menus/list", function(){
	$sql = new Sql();

	$names = array(
        "sp_menus_list"
	);

	foreach ($names as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	    $sql->queryFromFile(PATH_PROC."{$name}.sql");

	}

	echo success();
});
$app->get("/install-admin/sql/menus/remove", function(){
	$sql = new Sql();

	$names = array(
       "sp_menus_remove"
	);

	foreach ($names as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	    $sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/menus/save", function(){
	$sql = new Sql();

	$procs = array(
		"sp_menusfromusuario_list",
		"sp_menustrigger_save",
		"sp_menus_save"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/contatos/tables", function(){
	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_contatostipos (
		  idcontatotipo int(11) NOT NULL AUTO_INCREMENT,
		  descontatotipo varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idcontatotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_contatossubtipos (
		  idcontatosubtipo int NOT NULL AUTO_INCREMENT,
		  descontatosubtipo varchar(32) NOT NULL,
		  idcontatotipo int NOT NULL,
		  idusuario int NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idcontatosubtipo),
		  KEY FK_contatostipos (idcontatotipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_contatos (
		  idcontato int(11) NOT NULL AUTO_INCREMENT,
		  idcontatosubtipo int(11) NOT NULL,
		  idpessoa int(11) NOT NULL,
		  descontato varchar(128) NOT NULL,
		  inprincipal bit(1) NOT NULL DEFAULT b'0',
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idcontato),
		  CONSTRAINT FOREIGN KEY FK_contatossubtipos (idcontatosubtipo) REFERENCES tb_contatossubtipos(idcontatosubtipo),
		  CONSTRAINT FOREIGN KEY FK_pessoascontatos (idpessoa) REFERENCES tb_pessoas(idpessoa)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/contatos/triggers", function(){
	$sql = new Sql();

	$triggers = array(
		"tg_contatos_AFTER_INSERT",
		"tg_contatos_AFTER_UPDATE",
		"tg_contatos_BEFORE_DELETE"
	);

	foreach ($triggers as $name) {
		$sql->query("DROP TRIGGER IF EXISTS {$name};");
		$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	}
    
	echo success();
});
$app->get("/install-admin/sql/contatos/inserts", function(){
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_contatostipos (descontatotipo) VALUES
		(?),
		(?);
	", array(
		'E-mail',
		'Telefone'
	));

	$sql->query("
		INSERT INTO tb_contatossubtipos (idcontatotipo, descontatosubtipo) VALUES
		(?, ?),
		(?, ?),
		(?, ?),
		(?, ?),
		(?, ?),
		(?, ?),
		(?, ?),
		(?, ?);
	", array(
		2, 'Casa',		
		2, 'Trabalho',		
		2, 'Celular',		
		2, 'Fax',		
		2, 'Outro',		
		1, 'Pessoal',		
		1, 'Trabalho',		
		1, 'Outro'		
	));

	echo success();
});
$app->get("/install-admin/sql/contatos/get", function(){
	$sql = new Sql();

	$procs = array(
		"sp_contatos_get",
		"sp_contatossubtipos_get"
	);

	foreach ($procs as $name){
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/contatos/list", function(){
	$sql = new Sql();

	$procs = array(
		"sp_contatosfrompessoa_list",
		"sp_contatostipos_list"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/contatos/save", function(){
	$sql = new Sql();

	$procs = array(
		"sp_contatos_save",
		"sp_contatossubtipos_save"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/contatos/remove", function(){
	$sql = new Sql();

	$procs = array(
		"sp_contatos_remove",
		"sp_contatossubtipos_remove"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/documentos/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_documentostipos (
		  iddocumentotipo int(11) NOT NULL AUTO_INCREMENT,
		  desdocumentotipo varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (iddocumentotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_documentos (
		  iddocumento int(11) NOT NULL AUTO_INCREMENT,
		  iddocumentotipo int(11) NOT NULL,
		  idpessoa int(11) NOT NULL,
		  desdocumento varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (iddocumento),
		  CONSTRAINT FK_pessoasdocumentos FOREIGN KEY (idpessoa) REFERENCES tb_pessoas(idpessoa),
		  CONSTRAINT FK_documentos FOREIGN KEY (iddocumentotipo) REFERENCES tb_documentostipos(iddocumentotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/documentos/triggers", function(){
	$sql = new Sql();

	$triggers = array(
		"tg_documentos_AFTER_INSERT",
		"tg_documentos_AFTER_UPDATE",
		"tg_documentos_BEFORE_DELETE"
	);

	foreach ($triggers as $name) {
		$sql->query("DROP TRIGGER IF EXISTS {$name};");
		$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/documentos/inserts", function(){
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_documentostipos (desdocumentotipo) VALUES
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
$app->get("/install-admin/sql/documentos/get", function(){
	$sql = new Sql();

	$names = array(
        "sp_documentos_get"
	);

	foreach ($names as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	    $sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/documentos/list", function(){
	$sql = new Sql();

	$procs = array(
		"sp_documentosfrompessoa_list",
		"sp_documentostipos_list"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/documentos/save", function(){
	$sql = new Sql();

	$names = array(
       "sp_documentos_save"
	);

	foreach ($names as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	    $sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/documentos/remove", function(){
	$sql = new Sql();

	$names = array(
        "sp_documentos_remove"
	);

	foreach ($names as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	    $sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/enderecos/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_enderecostipos (
		  idenderecotipo int(11) NOT NULL AUTO_INCREMENT,
		  desenderecotipo varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idenderecotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_enderecos (
		  idendereco int(11) NOT NULL AUTO_INCREMENT,
		  idenderecotipo int(11) NOT NULL,
		  idpessoa int(11) NOT NULL,
		  desendereco varchar(64) NOT NULL,
		  desnumero varchar(16) NOT NULL,
		  desbairro varchar(64) NOT NULL,
		  descidade varchar(64) NOT NULL,
		  desestado varchar(32) NOT NULL,
		  despais varchar(32) NOT NULL,
		  descep char(8) NOT NULL,
		  descomplemento varchar(32) DEFAULT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idendereco),
		  CONSTRAINT FK_enderecostipos FOREIGN KEY (idenderecotipo) REFERENCES tb_enderecostipos(idenderecotipo),
		  CONSTRAINT FK_pessoasenderecos FOREIGN KEY (idpessoa) REFERENCES tb_pessoas(idpessoa)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/enderecos/triggers", function(){
	$sql = new Sql();

	$triggers = array(
		"tg_enderecos_AFTER_INSERT",
		"tg_enderecos_AFTER_UPDATE",
		"tg_enderecos_BEFORE_DELETE"
	);

	foreach ($triggers as $name) {
		$sql->query("DROP TRIGGER IF EXISTS {$name};");
		$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/enderecos/inserts", function(){
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_enderecostipos (desenderecotipo) VALUES
		(?),
		(?),
		(?),
		(?);
	", array(
		'Residencial',
		'Comercial',
		'Cobrança',
		'Entrega'
	));
	echo success();
});
$app->get("/install-admin/sql/enderecos/get", function(){
	$sql = new Sql();

	$names = array(
        "sp_enderecos_get"
	);

	foreach ($names as $name) {
	    $sql->query("DROP PROCEDURE IF EXISTS {$name};");
	    $sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/enderecos/list", function(){
	$sql = new Sql();

	$names = array(
        "sp_enderecosfrompessoa_list"
    );

    foreach ($names as $name) {
    	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	    $sql->queryFromFile(PATH_PROC."{$name}.sql");
    }

	echo success();
});
$app->get("/install-admin/sql/enderecos/save", function(){
	$sql = new Sql();

	$names = array(
       "sp_enderecos_save"
	);

	foreach ($names as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	    $sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/enderecos/remove", function(){
	$sql = new Sql();

	$names = array(
       "sp_enderecos_remove"
	);

	foreach ($names as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	    $sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/permissoes/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_permissoes (
		  idpermissao int(11) NOT NULL AUTO_INCREMENT,
		  despermissao varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpermissao)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_permissoesmenus (
		  idpermissao int(11) NOT NULL,
		  idmenu int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpermissao, idmenu),
		  CONSTRAINT FK_menuspermissoes FOREIGN KEY (idmenu) REFERENCES tb_menus (idmenu),
		  CONSTRAINT FK_permissoesmenus FOREIGN KEY (idpermissao) REFERENCES tb_permissoes (idpermissao)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_permissoesusuarios (
		  idpermissao int(11) NOT NULL,
		  idusuario int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpermissao, idusuario),
		  CONSTRAINT FK_permissoesusuarios FOREIGN KEY (idpermissao) REFERENCES tb_permissoes (idpermissao),
		  CONSTRAINT FK_usuariospermissoes FOREIGN KEY (idusuario) REFERENCES tb_usuarios (idusuario)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();
});
$app->get("/install-admin/sql/permissoes/inserts", function(){
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_permissoes (despermissao) VALUES
		(?),
		(?),
		(?);
	", array(
		'Super Usuário',
		'Acesso Administrativo',
		'Acesso Autenticado de Cliente'
	));
	$sql->query("
		INSERT INTO tb_permissoesmenus (idmenu, idpermissao)
		SELECT idmenu, 1 FROM tb_menus;
	", array());

	$sql->query("
		INSERT INTO tb_permissoesusuarios (idusuario, idpermissao) VALUES
		(?, ?),
		(?, ?);
	", array(
		1, 1,
		1, 2
	));
	echo success();
});
$app->get("/install-admin/sql/permissoes/get", function(){
	$sql = new Sql();

	$procs = array(
		'sp_permissoes_get',
		'sp_permissoesfrommenus_list',
		'sp_permissoesfrommenusfaltantes_list',
		'sp_permissoes_list'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/permissoes/list", function(){
	echo success();
});
$app->get("/install-admin/sql/permissoes/save", function(){
	$sql = new Sql();

	$procs = array(
		"sp_permissoes_save",
		"sp_permissoesmenus_save"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/permissoes/remove", function(){
	$sql = new Sql();

	$procs = array(
		"sp_permissoes_remove",
		"sp_permissoesmenus_remove"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
	
	echo success();
});
$app->get("/install-admin/sql/pessoasdados/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_pessoasdados (
		  idpessoa int(11) NOT NULL,
		  despessoa varchar(128) NOT NULL,
		  desnome varchar(32) NOT NULL,
		  desprimeironome varchar(64) NOT NULL,
		  desultimonome varchar(64) NOT NULL,
		  idpessoatipo int(11) NOT NULL,
		  despessoatipo varchar(64) NOT NULL,
		  desusuario varchar(128) DEFAULT NULL,
		  dessenha varchar(256) DEFAULT NULL,
		  idusuario int(11) DEFAULT NULL,
		  inbloqueado bit(1) DEFAULT NULL,
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
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idpessoa),
		  KEY FK_pessoasdados_pessoastipos_idx (idpessoatipo),
		  KEY FK_pessoasdados_usuarios_idx (idusuario),
		  CONSTRAINT FK_pessoasdados_pessoas FOREIGN KEY (idpessoa) REFERENCES tb_pessoas (idpessoa) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_pessoasdados_pessoastipos FOREIGN KEY (idpessoatipo) REFERENCES tb_pessoastipos (idpessoatipo) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_pessoasdados_usuarios FOREIGN KEY (idusuario) REFERENCES tb_usuarios (idusuario) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});

$app->get("/install-admin/sql/produtosdados/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_produtosdados(
			idproduto INT NOT NULL,
			idprodutotipo INT NOT NULL,
			desproduto VARCHAR(64) NOT NULL,
			vlpreco DEC(10,2),
			desprodutotipo VARCHAR(64) NOT NULL,
			dtinicio DATE,
			dttermino DATE,
			CONSTRAINT PRIMARY KEY (idproduto),
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto),
			CONSTRAINT FOREIGN KEY(idprodutotipo) REFERENCES tb_produtostipos(idprodutotipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});

$app->get("/install-admin/sql/carrinhos/tables", function(){

	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_carrinhos(
			idcarrinho INT NOT NULL AUTO_INCREMENT,
			idpessoa INT NOT NULL,
			dessession VARCHAR(128) NOT NULL,
			infechado BIT(1),
			nrprodutos INT NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			vltotalbruto DECIMAL(10,2),
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcarrinho),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_carrinhosprodutos(
			idcarrinho INT NOT NULL,
			idproduto INT NOT NULL,
			inremovido BIT(1) NOT NULL,
			dtremovido DATETIME NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idcarrinho, idproduto),
			CONSTRAINT FOREIGN KEY(idcarrinho) REFERENCES tb_carrinhos(idcarrinho),
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/carrinhos/list", function(){
	
	$sql = new Sql();

	$procs = array(
		"sp_carrinhos_list",
		"sp_carrinhosprodutos_list",
		"sp_carrinhosfrompessoa_list"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
	
});

$app->get("/install-admin/sql/carrinhos/get", function(){
	
	$sql = new Sql();

	$procs = array(
		"sp_carrinhos_get",
		"sp_carrinhosprodutos_get"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
	
	echo success();

});

$app->get("/install-admin/sql/carrinhos/save", function(){
	
	$sql = new Sql();

	$procs = array(
		"sp_carrinhos_save",
		"sp_carrinhosprodutos_save"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
	
	echo success();
	
});

$app->get("/install-admin/sql/carrinhos/remove", function(){
	
	$sql = new Sql();

	$procs = array(
		"sp_carrinhos_remove",
		"sp_carrinhosprodutos_remove"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
	
	echo success();
	
});

$app->get("/install-admin/sql/cartoesdecreditos/tables", function(){
	
	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_cartoesdecreditos(
			idcartao INT NOT NULL AUTO_INCREMENT,
			idpessoa INT NOT NULL,
			desnome VARCHAR(64) NOT NULL,
			dtvalidade DATE NOT NULL,
			nrcds VARCHAR(8) NOT NULL,
			desnumero CHAR(16) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcartao),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});

$app->get("/install-admin/sql/cartoesdecreditos/list", function(){
	
	$sql = new Sql();

	$procs = array(
		"sp_cartoesdecreditos_list",
		"sp_cartoesfrompessoa_list"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
	
	echo success();
	
});

$app->get("/install-admin/sql/cartoesdecreditos/get", function(){
	
	$sql = new Sql();

	$name = "sp_cartoesdecreditos_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/cartoesdecreditos/save", function(){
	
	$sql = new Sql();

	$name = "sp_cartoesdecreditos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/cartoesdecreditos/remove", function(){
	
	$sql = new Sql();

	$name = "sp_cartoesdecreditos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/tables", function(){
	
	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_gateways(
			idgateway INT NOT NULL AUTO_INCREMENT,
			desgateway VARCHAR(128) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT PRIMARY KEY(idgateway)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/inserts", function(){
	
	$sql = new Sql();

	$sql->query("
		INSERT INTO tb_gateways(desgateway) VALUES(?);
	", array(
		'PagSeguro'
	));
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/list", function(){
	
	$sql = new Sql();

	$name = "sp_gateways_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/get", function(){
	
	$sql = new Sql();

	$name = "sp_gateways_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/save", function(){
	
	$sql = new Sql();

	$name = "sp_gateways_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/remove", function(){
	
	$sql = new Sql();

	$name = "sp_gateways_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/tables", function(){
	
	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_formaspagamentos(
			idformapagamento INT NOT NULL AUTO_INCREMENT,
			idgateway INT NOT NULL,
			desformapagamento VARCHAR(128) NOT NULL,
			nrparcelasmax INT NOT NULL,
			instatus BIT(1),
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idformapagamento),
			CONSTRAINT FOREIGN KEY(idgateway) REFERENCES tb_gateways(idgateway)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_pagamentosstatus(
			idstatus INT NOT NULL AUTO_INCREMENT,
			desstatus VARCHAR(128) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idstatus)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_pagamentos(
			idpagamento INT NOT NULL AUTO_INCREMENT,
			idpessoa INT NOT NULL,
			idformapagamento INT NOT NULL,
			idstatus INT NOT NULL,
			dessession VARCHAR(128) NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			nrparcelas INT NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idpagamento),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa),
			CONSTRAINT FOREIGN KEY(idformapagamento) REFERENCES tb_formaspagamentos(idformapagamento),
			CONSTRAINT FOREIGN KEY(idstatus) REFERENCES tb_pagamentosstatus(idstatus)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_pagamentosprodutos(
			idpagamento INT NOT NULL,
			idproduto INT NOT NULL,
			nrqtd INT NOT NULL,
			vlpreco DECIMAL(10,2) NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idpagamento, idproduto),
			CONSTRAINT FOREIGN KEY(idpagamento) REFERENCES tb_pagamentos(idpagamento),
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_pagamentosrecibos(
			idpagamento INT NOT NULL,
			desautenticacao VARCHAR(256) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idpagamento),
			CONSTRAINT FOREIGN KEY(idpagamento) REFERENCES tb_pagamentos(idpagamento)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/inserts", function(){
	
	$sql = new Sql();

	$sql->query("
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
		1, 'Visa', 12, 1,
		1, 'MasterCard', 12, 1,
		1, 'Diners Club', 12, 1,
		1, 'Amex', 12, 1,
		1, 'HiperCard', 12, 1,
		1, 'Aura', 12, 1,
		1, 'Elo', 12, 1,
		1, 'Boleto', 1, 1,
		1, 'Débito Online Itaú', 1, 1,
		1, 'Débito Online Banco do Brasil', 1, 1,
		1, 'Débito Online Banrisul', 1, 1,
		1, 'Débito Online Bradesco', 1, 1,
		1, 'Débito Online HSBC', 1, 1,
		1, 'PlenoCard', 3, 1,
		1, 'PersonalCard', 3, 1,
		1, 'JCB', 1, 1,
		1, 'Discover', 1, 1,
		1, 'BrasilCard', 12, 1,
		1, 'FortBrasil', 12, 1,
		1, 'CardBan', 12, 1,
		1, 'ValeCard', 3, 1,
		1, 'Cabal', 12, 1,
		1, 'Mais', 10, 1,
		1, 'Avista', 6, 1,
		1, 'GRANDCARD', 12, 1,
		1, 'Sorocred', 12, 1
	));
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/list", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_formaspagamentos_list',
		'sp_pagamentos_list',
		'sp_pagamentosprodutos_list',
		'sp_pagamentosrecibos_list',
		'sp_pagamentosstatus_list',
		'sp_pagamentosfrompessoa_list',
		'sp_recibosfrompagamento_list'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/get", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_formaspagamentos_get',
		'sp_pagamentos_get',
		'sp_pagamentosprodutos_get',
		'sp_pagamentosrecibos_get',
		'sp_pagamentosstatus_get'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/save", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_formaspagamentos_save',
		'sp_pagamentos_save',
		'sp_pagamentosprodutos_save',
		'sp_pagamentosrecibos_save',
		'sp_pagamentosstatus_save'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/remove", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_formaspagamentos_remove',
		'sp_pagamentos_remove',
		'sp_pagamentosprodutos_remove',
		'sp_pagamentosrecibos_remove',
		'sp_pagamentosstatus_remove'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
	
});

$app->get("/install-admin/sql/sitecontatos/tables", function(){
	
	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_sitecontatos(
			idsitecontato INT NOT NULL AUTO_INCREMENT,
			idpessoa INT NOT NULL,
			desmensagem VARCHAR(2048) NOT NULL,
			inlido BIT(1) NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idsitecontato),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});

$app->get("/install-admin/sql/sitecontatos/list", function(){
	
	$sql = new Sql();

	$procs = array(
		"sp_sitecontatos_list",
		"sp_sitecontatosfrompessoa_list"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
	
	echo success();
	
});

$app->get("/install-admin/sql/sitecontatos/get", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_sitecontatosbypessoa_get',
		'sp_sitecontatos_get'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
	
});

$app->get("/install-admin/sql/sitecontatos/save", function(){
	
	$sql = new Sql();

	$name = "sp_sitecontatos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/sitecontatos/remove", function(){
	
	$sql = new Sql();

	$name = "sp_sitecontatos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

// lugares
$app->get("/install-admin/sql/lugares/tables", function(){
	
	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_lugarestipos(
			idlugartipo INT NOT NULL AUTO_INCREMENT,
			deslugartipo VARCHAR(128) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT PRIMARY KEY(idlugartipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_lugares(
			idlugar INT NOT NULL AUTO_INCREMENT,
			idlugarpai INT NULL,
			deslugar VARCHAR(128) NOT NULL,
			idendereco INT NOT NULL,
			idlugartipo INT NOT NULL,
			desconteudo TEXT,
			nrviews INT NULL,
			vlreview DECIMAL(10,2) NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idlugar),
			CONSTRAINT FOREIGN KEY(idlugarpai) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idendereco) REFERENCES tb_enderecos(idendereco),
			CONSTRAINT FOREIGN KEY(idlugartipo) REFERENCES tb_lugarestipos(idlugartipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});

$app->get("/install-admin/sql/lugares/list", function(){
	
	$sql = new Sql();

	$procs = array(
		"sp_lugares_list",
		"sp_lugarestipos_list"
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
	
	echo success();
	
});

$app->get("/install-admin/sql/lugares/get", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_lugarestipos_get',
		'sp_lugares_get'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
	
});

$app->get("/install-admin/sql/lugares/save", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_lugarestipos_save',
		'sp_lugares_save'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
	
	echo success();
	
});

$app->get("/install-admin/sql/lugares/remove", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_lugarestipos_remove',
		'sp_lugares_remove'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
	
});

$app->get("/install-admin/sql/lugares/inserts", function(){
	
	$sql = new Sql();

	$sql->query("
		INSERT INTO tb_lugarestipos(deslugartipo)
		VALUES(?), (?), (?), (?), (?), (?);
	", array(
		'Banco',
		'Posto de Gasolina',
		'Cinema',
		'Cidade',
		'Estado',
		'País'
	));
	
	echo success();
	
});

?>