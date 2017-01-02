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

	$sql->query("DROP TABLE IF EXISTS tb_contatos;");
	$sql->query("DROP TABLE IF EXISTS tb_contatostipos;");
	$sql->query("DROP TABLE IF EXISTS tb_contatossubtipos;");
	$sql->query("DROP TABLE IF EXISTS tb_documentos;");
	$sql->query("DROP TABLE IF EXISTS tb_documentostipos;");
	$sql->query("DROP TABLE IF EXISTS tb_enderecos;");
	$sql->query("DROP TABLE IF EXISTS tb_enderecostipos;");	
	$sql->query("DROP TABLE IF EXISTS tb_permissoesmenus;");
	$sql->query("DROP TABLE IF EXISTS tb_permissoesusuarios;");
	$sql->query("DROP TABLE IF EXISTS tb_permissoes;");
	$sql->query("DROP TABLE IF EXISTS tb_menususuarios;");
	$sql->query("DROP TABLE IF EXISTS tb_menus;");
	$sql->query("DROP TABLE IF EXISTS tb_pessoasdados;");
	$sql->query("DROP TABLE IF EXISTS tb_usuarios;");
	$sql->query("DROP TABLE IF EXISTS tb_pessoas;");
	$sql->query("DROP TABLE IF EXISTS tb_pessoastipos;");

	echo success();

});

$app->get("/install-admin/sql/pessoas/tables", function(){

	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_pessoastipos (
		  idpessoatipo int(11) NOT NULL AUTO_INCREMENT,
		  despessoatipo varchar(64) NOT NULL,
		  PRIMARY KEY (idpessoatipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_pessoas (
		  idpessoa int(11) NOT NULL AUTO_INCREMENT,
		  idpessoatipo int(1) NOT NULL,
		  despessoa varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (idpessoa),
		  KEY FK_pessoastipos (idpessoatipo),
		  CONSTRAINT FK_pessoas_pessoastipos FOREIGN KEY (idpessoatipo) REFERENCES tb_pessoastipos (idpessoatipo) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/pessoas/triggers", function(){

	$sql = new Sql();

	$name = "tg_pessoas_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	$name = "tg_pessoas_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	$name = "tg_pessoas_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

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

	$name = "sp_pessoas_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_pessoasdados_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_pessoasdados_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");	

	echo success();

});

$app->get("/install-admin/sql/pessoas/list", function(){

	$sql = new Sql();

	$name = "sp_pessoas_list";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();

});

$app->get("/install-admin/sql/pessoas/save", function(){

	$sql = new Sql();

	$name = "sp_pessoas_save";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();

});

$app->get("/install-admin/sql/pessoas/remove", function(){

	$sql = new Sql();

	$name = "sp_pessoas_remove";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();

});

$app->get("/install-admin/sql/usuarios/tables", function(){

	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_usuarios (
		  idusuario int(11) NOT NULL AUTO_INCREMENT,
		  idpessoa int(11) NOT NULL,
		  desusuario varchar(128) NOT NULL,
		  dessenha varchar(256) NOT NULL,
		  inbloqueado bit(1) NOT NULL DEFAULT b'0',
		  idusuariotipo int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idusuario),
		  KEY FK_usuarios_pessoas_idx (idpessoa),
		  KEY FK_usuarios_usuariostipos_idx (idusuariotipo),
		  CONSTRAINT FK_usuarios_pessoas FOREIGN KEY (idpessoa) REFERENCES tb_pessoas (idpessoa) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_usuarios_usuariostipos FOREIGN KEY (idusuariotipo) REFERENCES tb_usuariostipos (idusuariotipo) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_usuariostipos (
		  idusuariotipo int(11) NOT NULL AUTO_INCREMENT,
		  desusuariotipo varchar(32) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idusuariotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/usuarios/triggers", function(){

	$sql = new Sql();

	$name = "tg_usuarios_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	$name = "tg_usuarios_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	$name = "tg_usuarios_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/usuarios/inserts", function(){

	$sql = new Sql();

	$hash = Usuario::getPasswordHash("root");

	$sql->query("
		INSERT INTO tb_usuarios (idpessoa, desusuario, dessenha) VALUES
		(?, ?, ?);
	", array(
		1, 'root', $hash
	));

	$sql->proc("sp_usuariostipos_save", array(
		0,
		'Administrativo'
	));

	$sql->proc("sp_usuariostipos_save", array(
		0,
		'Cliente'
	));

	echo success();

});

$app->get("/install-admin/sql/usuarios/get", function(){

	$sql = new Sql();

	$name = "sp_usuarios_get";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_usuarioslogin_get";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_usuariosfromemail_get";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_usuariosfrommenus_list";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_usuariostipos_get";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/usuarios/remove", function(){

	$sql = new Sql();

	$name = "sp_usuarios_remove";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_usuariostipos_remove";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/usuarios/save", function(){

	$sql = new Sql();

	$name = "sp_usuarios_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_usuariostipos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/usuarios/list", function(){

	$sql = new Sql();

	$name = "sp_usuariostipos_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

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
		  PRIMARY KEY (idmenu),
		  KEY FK_menus_menus (idmenupai),
		  CONSTRAINT FK_menus_menus FOREIGN KEY (idmenupai) REFERENCES tb_menus (idmenu) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_menususuarios (
		  idmenu int(11) NOT NULL,
		  idusuario int(11) NOT NULL,
		  KEY FK_usuariosmenuspessoas (idusuario),
		  KEY FK_usuariosmenusmenus (idmenu)
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

	$name = "sp_menus_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/menus/list", function(){

	$sql = new Sql();

	$name = "sp_menus_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/menus/remove", function(){

	$sql = new Sql();

	$name = "sp_menus_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/menus/save", function(){

	$sql = new Sql();

	$name = "sp_menusfromusuario_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_menustrigger_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_menus_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/contatos/tables", function(){

	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_contatossubtipos (
		  idcontatosubtipo int(11) NOT NULL AUTO_INCREMENT,
		  descontatosubtipo varchar(32) NOT NULL,
		  descontatotipo varchar(32) NOT NULL,
		  idusuario int(11) DEFAULT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcontatosubtipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_contatostipos (
		  idcontatotipo int(11) NOT NULL AUTO_INCREMENT,
		  descontatotipo varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcontatotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_contatos (
		  idcontato int(11) NOT NULL AUTO_INCREMENT,
		  idcontatotipo int(11) NOT NULL,
		  idcontatosubtipo int(11) NOT NULL,
		  idpessoa int(11) NOT NULL,
		  descontato varchar(128) NOT NULL,
		  inprincipal bit(1) NOT NULL DEFAULT b'0',
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcontato),
		  KEY FK_contatostipos (idcontatotipo),
		  KEY FK_contatossubtipos (idcontatosubtipo),
		  KEY FK_pessoascontatos (idpessoa)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/contatos/triggers", function(){

	$sql = new Sql();

	$name = "tg_contatos_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	$name = "tg_contatos_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	$name = "tg_contatos_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/contatos/inserts", function(){

	$sql = new Sql();

	$sql->query("
		INSERT INTO tb_contatostipos (descontatotipo) VALUES
		(?),
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

	foreach ($procs as $name) {

		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");

	}

	echo success();

});

$app->get("/install-admin/sql/contatos/list", function(){

	$sql = new Sql();

	$name = "sp_contatosfrompessoa_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_contatostipos_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/contatos/save", function(){

	$sql = new Sql();

	$name = "sp_contatos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_contatossubtipos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");


	echo success();

});

$app->get("/install-admin/sql/contatos/remove", function(){

	$sql = new Sql();

	$name = "sp_contatos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_contatossubtipos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");	

	echo success();

});

$app->get("/install-admin/sql/documentos/tables", function(){

	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_documentostipos (
		  iddocumentotipo int(11) NOT NULL AUTO_INCREMENT,
		  desdocumentotipo varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (iddocumentotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_documentos (
		  iddocumento int(11) NOT NULL AUTO_INCREMENT,
		  iddocumentotipo int(11) NOT NULL,
		  idpessoa int(11) NOT NULL,
		  desdocumento varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (iddocumento),
		  KEY FK_pessoasdocumentos (idpessoa),
		  KEY FK_documentos (iddocumentotipo),
		  CONSTRAINT FK_documentos FOREIGN KEY (iddocumentotipo) REFERENCES tb_documentostipos (iddocumentotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/documentos/triggers", function(){

	$sql = new Sql();

	$name = "tg_documentos_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	$name = "tg_documentos_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	$name = "tg_documentos_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

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

	$name = "sp_documentos_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/documentos/list", function(){

	$sql = new Sql();

	$name = "sp_documentosfrompessoa_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_documentostipos_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/documentos/save", function(){

	$sql = new Sql();

	$name = "sp_documentos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/documentos/remove", function(){

	$sql = new Sql();

	$name = "sp_documentos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/enderecos/tables", function(){

	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_enderecostipos (
		  idenderecotipo int(11) NOT NULL AUTO_INCREMENT,
		  desenderecotipo varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (idenderecotipo)
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
		  PRIMARY KEY (idendereco),
		  KEY FK_enderecostipos (idenderecotipo),
		  KEY FK_pessoasenderecos (idpessoa)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/enderecos/triggers", function(){

	$sql = new Sql();

	$name = "tg_enderecos_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	$name = "tg_enderecos_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	$name = "tg_enderecos_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

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

	$name = "sp_enderecos_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/enderecos/list", function(){

	$sql = new Sql();

	$name = "sp_enderecosfrompessoa_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/enderecos/save", function(){

	$sql = new Sql();

	$name = "sp_enderecos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/enderecos/remove", function(){

	$sql = new Sql();

	$name = "sp_enderecos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();

});

$app->get("/install-admin/sql/permissoes/tables", function(){

	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_permissoes (
		  idpermissao int(11) NOT NULL AUTO_INCREMENT,
		  despermissao varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idpermissao)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_permissoesmenus (
		  idpermissao int(11) NOT NULL,
		  idmenu int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  KEY FK_permissoesmenus (idpermissao),
		  KEY FK_menuspermissoes (idmenu),
		  CONSTRAINT FK_menuspermissoes FOREIGN KEY (idmenu) REFERENCES tb_menus (idmenu),
		  CONSTRAINT FK_permissoesmenus FOREIGN KEY (idpermissao) REFERENCES tb_permissoes (idpermissao)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_permissoesusuarios (
		  idpermissao int(11) NOT NULL,
		  idusuario int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  KEY FK_permissoesusuarios (idpermissao),
		  KEY FK_usuariospermissoes (idusuario),
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
		'Acesso Área Restrita'
	));

	$sql->query("
		INSERT INTO tb_permissoesmenus (idpermissao, idmenu) VALUES
		(?, ?);
	", array(
		1, 1		
	));

	$sql->query("
		INSERT INTO tb_permissoesusuarios (idpermissao, idusuario) VALUES
		(?, ?),
		(?, ?),
		(?, ?);
	", array(
		1, 1,
		2, 1,
		3, 1
	));

	echo success();

});

$app->get("/install-admin/sql/permissoes/get", function(){

	$sql = new Sql();

	$name = "sp_permissoes_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_permissoesfrommenus_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_permissoesfrommenusfaltantes_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");	

	echo success();

});

$app->get("/install-admin/sql/permissoes/list", function(){

	echo success();

});

$app->get("/install-admin/sql/permissoes/save", function(){

	$sql = new Sql();

	$name = "sp_permissoes_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_permissoesmenus_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	

	echo success();

});

$app->get("/install-admin/sql/permissoes/remove", function(){

	$sql = new Sql();

	$name = "sp_permissoes_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_permissoesmenus_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");	
	
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
		  PRIMARY KEY (idpessoa),
		  KEY FK_pessoasdados_pessoastipos_idx (idpessoatipo),
		  KEY FK_pessoasdados_usuarios_idx (idusuario),
		  CONSTRAINT FK_pessoasdados_pessoas FOREIGN KEY (idpessoa) REFERENCES tb_pessoas (idpessoa) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_pessoasdados_pessoastipos FOREIGN KEY (idpessoatipo) REFERENCES tb_pessoastipos (idpessoatipo) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_pessoasdados_usuarios FOREIGN KEY (idusuario) REFERENCES tb_usuarios (idusuario) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});
?>