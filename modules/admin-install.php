<?php

define("PATH_PROC", PATH."/res/sql/procedures/");
define("PATH_TRIGGER", PATH."/res/sql/triggers/");
function saveProcedures($procs = array()){
	$sql = new Sql();
	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}
}
function saveTriggers($triggers = array()){
	$sql = new Sql();
	foreach ($triggers as $name) {
		$sql->query("DROP TRIGGER IF EXISTS {$name};");
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
		  inremovido bit NOT NULL DEFAULT b'0',
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
	$sql->query("
		CREATE TABLE tb_pessoasvalorescampos(
			idcampo INT NOT NULL AUTO_INCREMENT,
			descampo VARCHAR(128) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcampo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_pessoasvalores(
			idpessoavalor INT NOT NULL AUTO_INCREMENT,
			idpessoa INT NOT NULL,
			idcampo INT NOT NULL,
			desvalor VARCHAR(128) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idpessoavalor),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa),
			CONSTRAINT FOREIGN KEY(idcampo) REFERENCES tb_pessoasvalorescampos(idcampo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/pessoas/triggers", function(){
	$triggers = array(
		"tg_pessoas_AFTER_INSERT",
		"tg_pessoas_AFTER_UPDATE",
		"tg_pessoas_BEFORE_DELETE"
	);
	saveTriggers($triggers);
	echo success();
});
$app->get("/install-admin/sql/pessoas/inserts", function(){

	$lang = new Language();

	$pessoaTipoF = new PessoaTipo(array(
		'despessoatipo'=>$lang->getString("pessoas_fisica")
	));
	$pessoaTipoF->save();
	$pessoaTipoJ = new PessoaTipo(array(
		'despessoatipo'=>$lang->getString("pessoas_juridica")
	));
	$pessoaTipoJ->save();
	$pessoa = new Pessoa(array(
		'despessoa'=>$lang->getString("pessoas_nome"),
		'idpessoatipo'=>PessoaTipo::FISICA
	));
	$pessoa->save();
	echo success();
	
});
$app->get("/install-admin/sql/pessoas/get", function(){
	$procs = array(
		"sp_pessoas_get",
		"sp_historicostipos_get",
		"sp_pessoashistoricos_get",
		"sp_pessoasvalores_get",
		"sp_pessoasvalorescampos_get",
		"sp_pessoastipos_get"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/pessoas/list", function(){
	$procs = array(
		"sp_pessoas_list",
		"sp_pessoastipos_list",
        "sp_historicostipos_list",
        "sp_pessoasvalores_list",
        "sp_pessoasvalorescampos_list"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/pessoas/save", function(){
	$names = array(
		"sp_pessoasdados_save",
		"sp_pessoas_save",
		"sp_historicostipos_save",
		"sp_pessoasvalores_save",
		"sp_pessoasvalorescampos_save",
		"sp_pessoastipos_save"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/pessoas/remove", function(){
	$names = array(
		"sp_pessoasdados_remove",
		"sp_pessoas_remove",
		"sp_historicostipos_remove",
		"sp_pessoasvalores_remove",
		"sp_pessoasvalorescampos_remove",
		"sp_pessoastipos_remove"
	);
	saveProcedures($names);
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
			inremovido BIT(1) NOT NULL DEFAULT b'0',
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
			dttermino DATETIME DEFAULT NULL,
			vlpreco DECIMAL(10,2) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idpreco),
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/produtos/triggers", function(){
	$triggers = array(
		"tg_produtos_AFTER_INSERT",
		"tg_produtos_AFTER_UPDATE",
		"tg_produtos_BEFORE_DELETE",
		"tg_produtosprecos_AFTER_INSERT",
		"tg_produtosprecos_AFTER_UPDATE",
		"tg_produtosprecos_BEFORE_DELETE"
	);
	saveTriggers($triggers);
	
	echo success();
});
$app->get("/install-admin/sql/produtos/inserts", function(){
	
	$lang = new Language();

	$cursoUdemy = new ProdutoTipo(array(
		'desprodutotipo'=>$lang->getString('produtos_curso')
	));
	$cursoUdemy->save();

	$camiseta = new ProdutoTipo(array(
		'desprodutotipo'=>$lang->getString('produtos_camiseta')
	));
	$camiseta->save();

	echo success();

});
$app->get("/install-admin/sql/produtos/get", function(){
	$procs = array(
		"sp_produto_get",
		"sp_produtotipo_get",
		"sp_produtosprecos_get"
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/produtos/list", function(){
	$procs = array(
		"sp_produtos_list",
		"sp_produtostipos_list",
		"sp_produtosprecos_list",
		"sp_carrinhosfromproduto_list",
		"sp_pedidosfromproduto_list",
		"sp_precosfromproduto_list"
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/produtos/save", function(){
	$procs = array(
		"sp_produto_save",
		"sp_produtotipo_save",
		"sp_produtosprecos_save",
		"sp_produtosdados_save"
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/produtos/remove", function(){
	$procs = array(
		"sp_produto_remove",
		"sp_produtotipo_remove",
		"sp_produtosprecos_remove",
		"sp_produtosdados_remove"
	);
	saveProcedures($procs);
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
	$triggers = array(
		"tg_usuarios_AFTER_INSERT",
		"tg_usuarios_AFTER_UPDATE",
		"tg_usuarios_BEFORE_DELETE"
	);
	saveTriggers($triggers);
	echo success();
});
$app->get("/install-admin/sql/usuarios/inserts", function(){

    $lang = new Language();

	$sql = new Sql();
	$hash = Usuario::getPasswordHash($lang->getString('usuarios_root'));

	$sql->proc("sp_usuariostipos_save", array(
		0,
		$lang->getString('usuarios_admin')
	));
	$sql->proc("sp_usuariostipos_save", array(
		0,
		$lang->getString('usuarios_clientes')
	));
	
	$sql->query("
		INSERT INTO tb_usuarios (idpessoa, desusuario, dessenha, idusuariotipo) VALUES
		(?, ?, ?, ?);
	", array(
		1, $lang->getString('usuarios_root'), $hash, 1
	));
	echo success();
});
$app->get("/install-admin/sql/usuarios/get", function(){
	$procs = array(
		"sp_usuarios_get",
		"sp_usuarioslogin_get",
		"sp_usuariosfromemail_get",
		"sp_usuariosfrommenus_list",
		"sp_usuariostipos_get"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/usuarios/remove", function(){
	$procs = array(
		"sp_usuarios_remove",
		"sp_usuariostipos_remove"
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/usuarios/save", function(){
	$procs = array(
		"sp_usuarios_save",
		"sp_usuariostipos_save"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/usuarios/list", function(){
	$names = array(
        "sp_usuariostipos_list",
        "sp_usuariosfrompessoa_list",
        "sp_usuarios_list"
	);
	saveProcedures($names);
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

	$sql->query("
		CREATE TABLE tb_sitesmenus (
		  idmenu int(11) NOT NULL AUTO_INCREMENT,
		  idmenupai int(11) DEFAULT NULL,
		  desmenu varchar(128) NOT NULL,
		  desicone varchar(64) NOT NULL,
		  deshref varchar(64) NOT NULL,
		  nrordem int(11) NOT NULL,
		  nrsubmenus int(11) DEFAULT '0' NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  CONSTRAINT PRIMARY KEY (idmenu),
		  CONSTRAINT FK_sitesmenus_sitesmenus FOREIGN KEY (idmenupai) REFERENCES tb_sitesmenus (idmenu) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/menus/inserts", function(){

	$lang = new Language();

	//////////////////////////////////////
	$menuDashboard = new Menu(array(
		'nrordem'=>0,
		'idmenupai'=>NULL,
		'desicone'=>'md-view-dashboard',
		'deshref'=>'/',
		'desmenu'=>$lang->getString('menus_dashboard')
	));
	$menuDashboard->save();
	//////////////////////////////////////
	$menuSistema = new Menu(array(
		'nrordem'=>1,
		'idmenupai'=>NULL,
		'desicone'=>'md-code-setting',
		'deshref'=>'',
		'desmenu'=>$lang->getString('menus_sistema')
	));
	$menuSistema->save();
	//////////////////////////////////////
	$menuAdmin = new Menu(array(
		'nrordem'=>2,
		'idmenupai'=>NULL,
		'desicone'=>'md-settings',
		'deshref'=>'',
		'desmenu'=>$lang->getString('menus_administracao')
	));
	$menuAdmin->save();
	//////////////////////////////////////
	$menuPessoas = new Menu(array(
		'nrordem'=>3,
		'idmenupai'=>NULL,
		'desicone'=>'md-accounts',
		'deshref'=>'/pessoas',
		'desmenu'=>$lang->getString('menus_pessoa')
	));
	$menuPessoas->save();
	//////////////////////////////////////
	$menuTipos = new Menu(array(
		'nrordem'=>0,
		'idmenupai'=>$menuAdmin->getidmenu(),
		'desicone'=>'md-collection-item',
		'deshref'=>'',
		'desmenu'=>$lang->getString('menus_tipo')
	));
	$menuTipos->save();
	//////////////////////////////////////
	$menuMenu = new Menu(array(
		'nrordem'=>1,
		'idmenupai'=>$menuAdmin->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/sistema/menu',
		'desmenu'=>$lang->getString('menus_menu')
	));
	$menuMenu->save();
	//////////////////////////////////////
	$menuUsuarios = new Menu(array(
		'nrordem'=>2,
		'idmenupai'=>$menuAdmin->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/sistema/usuarios',
		'desmenu'=>$lang->getString('menus_usuario')
	));
	$menuUsuarios->save();
	//////////////////////////////////////
	$menuConfigs = new Menu(array(
		'nrordem'=>3,
		'idmenupai'=>$menuAdmin->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/sistema/configuracoes',
		'desmenu'=>$lang->getString('menus_configuracoes')
	));
	$menuConfigs->save();
	//////////////////////////////////////
	$menuSqlToClass = new Menu(array(
		'nrordem'=>0,
		'idmenupai'=>$menuSistema->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/sistema/sql-to-class',
		'desmenu'=>$lang->getString('menus_sql_to_class')
	));
	$menuSqlToClass->save();
	//////////////////////////////////////
	$menuTemplate = new Menu(array(
		'nrordem'=>1,
		'idmenupai'=>$menuSistema->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/../res/theme/material/base/html/index.html',
		'desmenu'=>$lang->getString('menus_template')
	));
	$menuTemplate->save();
	//////////////////////////////////////
	$menuExemplos = new Menu(array(
		'nrordem'=>2,
		'idmenupai'=>$menuSistema->getidmenu(),
		'desicone'=>'',
		'deshref'=>'',
		'desmenu'=>$lang->getString('menus_exemplos')
	));
	$menuExemplos->save();
	//////////////////////////////////////
	$menuUpload = new Menu(array(
		'nrordem'=>0,
		'idmenupai'=>$menuExemplos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/exemplos/upload',
		'desmenu'=>$lang->getString('menus_exemplos_upload')
	));
	$menuUpload->save();
	//////////////////////////////////////
	$menuPermissoes = new Menu(array(
		'nrordem'=>3,
		'idmenupai'=>$menuAdmin->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/permissoes',
		'desmenu'=>$lang->getString('menus_permissoes')
	));
	$menuPermissoes->save();
	//////////////////////////////////////
	$menuProdutos = new Menu(array(
		'nrordem'=>4,
		'idmenupai'=>NULL,
		'desicone'=>'md-devices',
		'deshref'=>'/produtos',
		'desmenu'=>$lang->getString('menus_produto')
	));
	$menuProdutos->save();
	//////////////////////////////////////
	$menuTiposEnderecos = new Menu(array(
		'nrordem'=>0,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/enderecos-tipos',
		'desmenu'=>$lang->getString('menus_endereco')
	));
	$menuTiposEnderecos->save();
	//////////////////////////////////////
	$menuTiposUsuarios = new Menu(array(
		'nrordem'=>1,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/usuarios-tipos',
		'desmenu'=>$lang->getString('menus_usuario_tipo')
	));
	$menuTiposUsuarios->save();
	//////////////////////////////////////
	$menuTiposDocumentos = new Menu(array(
		'nrordem'=>2,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/documentos-tipos',
		'desmenu'=>$lang->getString('menus_documento_tipo')
	));
	$menuTiposDocumentos->save();
	//////////////////////////////////////
	$menuTiposLugares = new Menu(array(
		'nrordem'=>3,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/lugares-tipos',
		'desmenu'=>$lang->getString('menus_lugar_tipo')
	));
	$menuTiposLugares->save();
	//////////////////////////////////////
	$menuTiposCupons = new Menu(array(
		'nrordem'=>4,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/cupons-tipos',
		'desmenu'=>$lang->getString('menus_cupom_tipo')
	));
	$menuTiposCupons->save();
	//////////////////////////////////////
	$menuTiposProdutos = new Menu(array(
		'nrordem'=>5,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/produtos-tipos',
		'desmenu'=>$lang->getString('menus_produto_tipo')
	));
	$menuTiposProdutos->save();
	//////////////////////////////////////
	$menuPedidosStatus = new Menu(array(
		'nrordem'=>6,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/pedidos-status',
		'desmenu'=>$lang->getString('menus_pedido_statu')
	));
	$menuPedidosStatus->save();
	//////////////////////////////////////
	$menuPessoasTipos = new Menu(array(
		'nrordem'=>7,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/pessoas-tipos',
		'desmenu'=>$lang->getString('menus_pessoa_tipo')
	));
	$menuPessoasTipos->save();
	//////////////////////////////////////
	$menuContatosTipos = new Menu(array(
		'nrordem'=>8,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/contatos-tipos',
		'desmenu'=>$lang->getString('menus_contato_tipo')
	));
	$menuContatosTipos->save();
	//////////////////////////////////////
	$menuGateways = new Menu(array(
		'nrordem'=>9,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/gateways',
		'desmenu'=>$lang->getString('menus_gateway')
	));
	$menuGateways->save();
	//////////////////////////////////////
	$menuHistoricosTipos = new Menu(array(
		'nrordem'=>10,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/historicos-tipos',
		'desmenu'=>$lang->getString('menus_historico_tipo')
	));
	$menuHistoricosTipos->save();
	//////////////////////////////////////
	$menuFormasPedidos = new Menu(array(
		'nrordem'=>11,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/formas-pagamentos',
		'desmenu'=>$lang->getString('menus_forma_pedido')
	));
	$menuFormasPedidos->save();
	//////////////////////////////////////
	$menuPessoasValoresCampos = new Menu(array(
		'nrordem'=>11,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/pessoas-valorescampos',
		'desmenu'=>$lang->getString('menus_pessoa_valor')
	));
	$menuPessoasValoresCampos->save();
	//////////////////////////////////////
	$menuConfiguracoesTipos = new Menu(array(
		'nrordem'=>12,
		'idmenupai'=>$menuTipos->getidmenu(),
		'desicone'=>'',
		'deshref'=>'/configuracoes-tipos',
		'desmenu'=>$lang->getString('menus_configuracao_tipo')
	));
	$menuConfiguracoesTipos->save();
	//////////////////////////////////////
	$menuPedidos = new Menu(array(
		"nrordem"=>5,
		"idmenupai"=>NULL,
		"desicone"=>'md-money-box',
		"deshref"=>'/pedidos',
		"desmenu"=>$lang->getString('menus_pedido')
	));
	$menuPedidos->save();
	//////////////////////////////////////
	$menuCarrinhos = new Menu(array(
		"nrordem"=>6,
		"idmenupai"=>NULL,
		"desicone"=>"md-shopping-cart",
		"deshref"=>"/carrinhos",
		"desmenu"=>$lang->getString('menus_carrinho')
	));
	$menuCarrinhos->save();
	//////////////////////////////////////
	$menuLugares = new Menu(array(
		"nrordem"=>7,
		"idmenupai"=>NULL,
		"desicone"=>"md-city",
		"deshref"=>"/lugares",
		"desmenu"=>$lang->getString('menus_lugar')
	));
	$menuLugares->save();
	//////////////////////////////////////
	$menuSite = new Menu(array(
		"nrordem"=>8,
		"idmenupai"=>NULL,
		"desicone"=>"md-view-web",
		"deshref"=>"",
		"desmenu"=>$lang->getString('menus_site')
	));
	$menuSite->save();
	//////////////////////////////////////
	$menuSiteMenu = new Menu(array(
		"nrordem"=>0,
		"idmenupai"=>$menuSite->getidmenu(),
		"desicone"=>"",
		"deshref"=>"/site/menu",
		"desmenu"=>$lang->getString('menus_site_menu')
	));
	$menuSiteMenu->save();
	//////////////////////////////////////
	
	echo success();
});
$app->get("/install-admin/sql/menus/get", function(){
	$names = array(
       "sp_menus_get",
       "sp_sitesmenus_get"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/menus/list", function(){
	$names = array(
        "sp_menus_list",
        "sp_sitesmenus_list"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/menus/remove", function(){
	$names = array(
       "sp_menus_remove",
       "sp_sitesmenus_remove"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/menus/save", function(){
	$procs = array(
		"sp_menusfromusuario_list",
		"sp_menustrigger_save",
		"sp_menus_save",
		"sp_sitesmenustrigger_save",
		"sp_sitesmenus_save"
	);
	saveProcedures($procs);
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
	$triggers = array(
		"tg_contatos_AFTER_INSERT",
		"tg_contatos_AFTER_UPDATE",
		"tg_contatos_BEFORE_DELETE"
	);
	saveTriggers($triggers);
    
	echo success();
});
$app->get("/install-admin/sql/contatos/inserts", function(){

	$lang = new Language();
	
	$email = new ContatoTipo(array(
		'descontatotipo'=>$lang->getString('contato_tipo')
	));
	$email->save();

	$telefone = new ContatoTipo(array(
		'descontatotipo'=>$lang->getString('telefone_tipo')
	));
	$telefone->save();

	$telefoneCasa = new ContatoSubtipo(array(
		'idcontatotipo'=>$telefone->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('casa_tipo')
	));
	$telefoneCasa->save();

	$telefoneTrabalho = new ContatoSubtipo(array(
		'idcontatotipo'=>$telefone->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('trabalho_tipo')
	));
	$telefoneTrabalho->save();

	$telefoneCelular = new ContatoSubtipo(array(
		'idcontatotipo'=>$telefone->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('celular_tipo')
	));
	$telefoneCelular->save();

	$telefoneFax = new ContatoSubtipo(array(
		'idcontatotipo'=>$telefone->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('fax_tipo')
	));
	$telefoneFax->save();

	$telefoneOutro = new ContatoSubtipo(array(
		'idcontatotipo'=>$telefone->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('outro_tipo')
	));
	$telefoneOutro->save();

	$emailPessoal = new ContatoSubtipo(array(
		'idcontatotipo'=>$email->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('pessoal_tipo')
	));
	$emailPessoal->save();

	$emailTrabalho = new ContatoSubtipo(array(
		'idcontatotipo'=>$email->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('trabalho_tipo')
	));
	$emailTrabalho->save();

	$emailOutro = new ContatoSubtipo(array(
		'idcontatotipo'=>$email->getidcontatotipo(),
		'descontatosubtipo'=>$lang->getString('outro_tipo_email')
	));
	$emailOutro->save();

	echo success();
	
});
$app->get("/install-admin/sql/contatos/get", function(){
	$procs = array(
		"sp_contatos_get",
		"sp_contatossubtipos_get",
		"sp_contatostipos_get"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/contatos/list", function(){
	$procs = array(
		"sp_contatosfrompessoa_list",
		"sp_contatostipos_list",
		"sp_contatossubtipos_list"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/contatos/save", function(){
	$procs = array(
		"sp_contatos_save",
		"sp_contatossubtipos_save",
		"sp_contatostipos_save"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/contatos/remove", function(){
	$procs = array(
		"sp_contatos_remove",
		"sp_contatossubtipos_remove",
		"sp_contatostipos_remove"
	);
	saveProcedures($procs);
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
	$triggers = array(
		"tg_documentos_AFTER_INSERT",
		"tg_documentos_AFTER_UPDATE",
		"tg_documentos_BEFORE_DELETE"
	);
	saveTriggers($triggers);
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
	$names = array(
        "sp_documentos_get",
        "sp_documentostipos_get"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/documentos/list", function(){
	$procs = array(
		"sp_documentosfrompessoa_list",
		"sp_documentostipos_list"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/documentos/save", function(){
	$names = array(
       "sp_documentos_save",
       "sp_documentostipos_save"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/documentos/remove", function(){
	$names = array(
        "sp_documentos_remove",
        "sp_documentostipos_remove"
	);
	saveProcedures($names);
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
		  CONSTRAINT FK_enderecostipos FOREIGN KEY (idenderecotipo) REFERENCES tb_enderecostipos(idenderecotipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_pessoasenderecos(
			idpessoa INT NOT NULL,
			idendereco INT NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa),
			CONSTRAINT FOREIGN KEY(idendereco) REFERENCES tb_enderecos(idendereco)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/enderecos/triggers", function(){
	$triggers = array(
		"tg_enderecos_AFTER_INSERT",
		"tg_enderecos_AFTER_UPDATE",
		"tg_enderecos_BEFORE_DELETE"
	);
	// saveTriggers($triggers);
	echo success();
});
$app->get("/install-admin/sql/enderecos/inserts", function(){

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
$app->get("/install-admin/sql/enderecos/get", function(){
	$names = array(
        "sp_enderecos_get",
        "sp_enderecostipos_get"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/enderecos/list", function(){
	$names = array(
        "sp_enderecosfrompessoa_list",
        "sp_enderecostipos_list"
    );
    saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/enderecos/save", function(){
	$names = array(
       "sp_enderecos_save",
       "sp_enderecostipos_save"
	);
	saveProcedures($names);
	echo success();
});
$app->get("/install-admin/sql/enderecos/remove", function(){
	$names = array(
       "sp_enderecos_remove",
       "sp_enderecostipos_remove"
	);
	saveProcedures($names);
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

	$lang = new Language();
	
	$superUsuario = new Permissao(array(
		'despermissao'=>$lang->getString('permissoes_usuario')
	));
	$superUsuario->save();

	$acessoAdmin = new Permissao(array(
		'despermissao'=>$lang->getString('permissoes_administrativo')
	));
	$acessoAdmin->save();

	$acessoClient = new Permissao(array(
		'despermissao'=>$lang->getString('permissoes_cliente')
	));
	$acessoClient->save();

	$sql = new Sql();

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
	echo success();
});
$app->get("/install-admin/sql/permissoes/save", function(){
	$procs = array(
		"sp_permissoes_save",
		"sp_permissoesmenus_save"
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/permissoes/remove", function(){
	$procs = array(
		"sp_permissoes_remove",
		"sp_permissoesmenus_remove"
	);
	saveProcedures($procs);
	
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
		  dessexo ENUM('M', 'F'),
		  dtnascimento DATE DEFAULT NULL,
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
			vlpreco DEC(10,2) NULL,
			desprodutotipo VARCHAR(64) NOT NULL,
			dtinicio DATETIME NULL,
			dttermino DATETIME NULL,
			inremovido BIT(1) NOT NULL DEFAULT 0,
			dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT PRIMARY KEY (idproduto),
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto),
			CONSTRAINT FOREIGN KEY(idprodutotipo) REFERENCES tb_produtostipos(idprodutotipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/cupons/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_cuponstipos(
			idcupomtipo INT NOT NULL AUTO_INCREMENT,
			descupomtipo VARCHAR(128) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcupomtipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_cupons(
			idcupom INT NOT NULL AUTO_INCREMENT,
			idcupomtipo INT NOT NULL,
			descupom VARCHAR(128) NOT NULL,
			descodigo VARCHAR(128) NOT NULL,
			nrqtd INT NOT NULL DEFAULT 1,
			nrqtdusado INT NOT NULL DEFAULT 0,
			dtinicio DATETIME NULL,
			dttermino DATETIME NULL,
			inremovido BIT(1) NULL,
			nrdesconto DECIMAL(10,2) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcupom),
			CONSTRAINT FOREIGN KEY(idcupomtipo) REFERENCES tb_cuponstipos(idcupomtipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/cupons/list", function(){
	
	$procs = array(
		'sp_cupons_list',
		'sp_cuponstipos_list'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/cupons/save", function(){
	$procs = array(
		'sp_cupons_save',
		'sp_cuponstipos_save'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/cupons/get", function(){
	$procs = array(
		'sp_cupons_get',
		'sp_cuponstipos_get'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/cupons/remove", function(){
	$procs = array(
		'sp_cupons_remove',
		'sp_cuponstipos_remove'
	);
	saveProcedures($procs);
	echo success();
});
$app->get("/install-admin/sql/cupons/inserts", function(){

	$lang = new Language();
	
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_cuponstipos(descupomtipo)
		VALUES(?), (?);
	", array(
		$lang->getString('cupom_valor'),
		$lang->getString('cupom_porcentage')
		
	));
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
			nrprodutos INT NULL,
			vltotal DECIMAL(10,2) NULL,
			vltotalbruto DECIMAL(10,2),
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcarrinho),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_carrinhosprodutos(
			idcarrinhoproduto INT NOT NULL AUTO_INCREMENT,
			idcarrinho INT NOT NULL,
			idproduto INT NOT NULL,
			dtremovido DATETIME NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idcarrinhoproduto),
			CONSTRAINT FOREIGN KEY(idcarrinho) REFERENCES tb_carrinhos(idcarrinho),
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_carrinhosfretes(
			idcarrinho INT NOT NULL,
			descep CHAR(8) NOT NULL,
			vlfrete DECIMAL(10,2) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idcarrinho) REFERENCES tb_carrinhos(idcarrinho)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_carrinhoscupons(
			idcarrinho INT NOT NULL,
			idcupom INT NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idcarrinho) REFERENCES tb_carrinhos(idcarrinho),
			CONSTRAINT FOREIGN KEY(idcupom) REFERENCES tb_cupons(idcupom)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/carrinhos/triggers", function(){
	$triggers = array(
		"tg_carrinhoscupons_AFTER_INSERT",
		"tg_carrinhoscupons_AFTER_UPDATE",		
		"tg_carrinhosfretes_AFTER_INSERT",
		"tg_carrinhosfretes_AFTER_UPDATE",		
		"tg_carrinhosprodutos_AFTER_INSERT",
		"tg_carrinhosprodutos_AFTER_UPDATE"		
	);
	saveTriggers($triggers);
	echo success();
});
$app->get("/install-admin/sql/carrinhos/list", function(){
	$procs = array(
		"sp_carrinhos_list",
		"sp_carrinhosprodutos_list",
		"sp_carrinhosfrompessoa_list",
		'sp_carrinhoscupons_list',
		'sp_carrinhosfretes_list',
		'sp_produtosfromcarrinho_list',
		'sp_cuponsfromcarrinho_list'
	);
	saveProcedures($procs);
	echo success();
	
});
$app->get("/install-admin/sql/carrinhos/get", function(){
	$procs = array(
		"sp_carrinhos_get",
		"sp_carrinhosprodutos_get",
		'sp_carrinhoscupons_get',
		'sp_carrinhosfretes_get'
	);
	saveProcedures($procs);
	
	echo success();
});
$app->get("/install-admin/sql/carrinhos/save", function(){
	$procs = array(
		"sp_carrinhos_save",
		"sp_carrinhosprodutos_save",
		'sp_carrinhoscupons_save',
		'sp_carrinhosfretes_save',
		'sp_carrinhosdados_save'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/carrinhos/remove", function(){
	$procs = array(
		"sp_carrinhos_remove",
		"sp_carrinhosprodutos_remove",
		'sp_carrinhoscupons_remove',
		'sp_carrinhosfretes_remove'
	);
	saveProcedures($procs);
	
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
	$procs = array(
		"sp_cartoesdecreditos_list",
		"sp_cartoesfrompessoa_list"
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/cartoesdecreditos/get", function(){
	$name = array(
		"sp_cartoesdecreditos_get"
	);
	
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/cartoesdecreditos/save", function(){
	$name = array(
		"sp_cartoesdecreditos_save"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/cartoesdecreditos/remove", function(){
	$name = array(
		"sp_cartoesdecreditos_remove"
	);
	saveProcedures($name);
	
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

	$lang = new Language();

	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_gateways(desgateway) VALUES(?);
	", array(
		$lang->getString('gateway_pagseguro')
	));
	
	echo success();
	
});
$app->get("/install-admin/sql/gateways/list", function(){
	$name = array(
		"sp_gateways_list"
	);
	
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/gateways/get", function(){
	$name = array(
		"sp_gateways_get"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/gateways/save", function(){
	$name = array(
		"sp_gateways_save"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/gateways/remove", function(){
	$name = array(
		"sp_gateways_remove"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/pedidos/tables", function(){
	
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
		CREATE TABLE tb_pedidosstatus(
			idstatus INT NOT NULL AUTO_INCREMENT,
			desstatus VARCHAR(128) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idstatus)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_pedidos(
			idpedido INT NOT NULL AUTO_INCREMENT,
			idpessoa INT NOT NULL,
			idformapagamento INT NOT NULL,
			idstatus INT NOT NULL,
			dessession VARCHAR(128) NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			nrparcelas INT NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idpedido),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa),
			CONSTRAINT FOREIGN KEY(idformapagamento) REFERENCES tb_formaspagamentos(idformapagamento),
			CONSTRAINT FOREIGN KEY(idstatus) REFERENCES tb_pedidosstatus(idstatus)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_pedidosprodutos(
			idpedido INT NOT NULL,
			idproduto INT NOT NULL,
			nrqtd INT NOT NULL,
			vlpreco DECIMAL(10,2) NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idpedido, idproduto),
			CONSTRAINT FOREIGN KEY(idpedido) REFERENCES tb_pedidos(idpedido),
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_pedidosrecibos(
			idpedido INT NOT NULL,
			desautenticacao VARCHAR(256) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY (idpedido),
			CONSTRAINT FOREIGN KEY(idpedido) REFERENCES tb_pedidos(idpedido)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_pedidoshistoricos(
			idhistorico INT NOT NULL AUTO_INCREMENT,
			idpedido INT NOT NULL,
			idusuario INT NOT NULL,
			dtcadastro TIMESTAMP NULL,			
			CONSTRAINT PRIMARY KEY(idhistorico),
			CONSTRAINT FOREIGN KEY(idpedido) REFERENCES tb_pedidos(idpedido),
			CONSTRAINT FOREIGN KEY(idusuario) REFERENCES tb_usuarios(idusuario)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});
$app->get("/install-admin/sql/pedidos/inserts", function(){

	$lang = new Language();
	
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
	$sql->query("
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
	
	echo success();
	
});
$app->get("/install-admin/sql/pedidos/list", function(){
	$procs = array(
		'sp_formaspagamentos_list',
		'sp_pedidos_list',
		'sp_pedidosprodutos_list',
		'sp_pedidosrecibos_list',
		'sp_pedidosstatus_list',
		'sp_pedidosfrompessoa_list',
		'sp_recibosfrompedido_list',
		'sp_pedidoshistoricos_list'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/pedidos/get", function(){
	$procs = array(
		'sp_formaspagamentos_get',
		'sp_pedidos_get',
		'sp_pedidosprodutos_get',
		'sp_pedidosrecibos_get',
		'sp_pedidosstatus_get',
		'sp_pedidoshistoricos_get'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/pedidos/save", function(){
	$procs = array(
		'sp_formaspagamentos_save',
		'sp_pedidos_save',
		'sp_pedidosprodutos_save',
		'sp_pedidosrecibos_save',
		'sp_pedidosstatus_save',
		'sp_pedidoshistoricos_save'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/pedidos/remove", function(){
	$procs = array(
		'sp_formaspagamentos_remove',
		'sp_pedidos_remove',
		'sp_pedidosprodutos_remove',
		'sp_pedidosrecibos_remove',
		'sp_pedidosstatus_remove',
		'sp_pedidoshistoricos_remove'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/sitescontatos/tables", function(){
	
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_sitescontatos(
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
$app->get("/install-admin/sql/sitescontatos/list", function(){
	$procs = array(
		"sp_sitescontatos_list",
		"sp_sitescontatosfrompessoa_list"
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/sitescontatos/get", function(){
	$procs = array(
		'sp_sitescontatosbypessoa_get',
		'sp_sitescontatos_get'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/sitescontatos/save", function(){
	$name = array(
		"sp_sitescontatos_save"
	);
	saveProcedures($name);
	
	echo success();
	
});
$app->get("/install-admin/sql/sitescontatos/remove", function(){
	$name = array(
		"sp_sitescontatos_remove"
	);
	saveProcedures($name);
	
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
			idendereco INT NULL,
			idlugartipo INT NOT NULL,
			desconteudo TEXT NULL,
			nrviews INT NULL,
			vlreview DECIMAL(10,2) NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idlugar),
			CONSTRAINT FOREIGN KEY(idlugarpai) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idendereco) REFERENCES tb_enderecos(idendereco),
			CONSTRAINT FOREIGN KEY(idlugartipo) REFERENCES tb_lugarestipos(idlugartipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_lugareshorarios(
			idhorario INT NOT NULL AUTO_INCREMENT,
			idlugar INT NOT NULL,
			nrdia TINYINT(4) NOT NULL,
			hrabre TIME NULL,
			hrfecha TIME NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idhorario),
			CONSTRAINT FOREIGN KEY(idlugar) REFERENCES tb_lugares(idlugar)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_lugarescoordenadas(
			idlugar INT NOT NULL,
			idcoordenada INT NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idlugar) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idcoordenada) REFERENCES tb_coordenadas(idcoordenada)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_lugaresdados(
			idlugar INT NOT NULL,
			deslugar VARCHAR(128) NOT NULL,
			idlugarpai INT NULL,
			deslugarpai VARCHAR(128) NULL,
			idlugartipo INT NOT NULL,
			deslugartipo  VARCHAR(128) NOT NULL,
			idenderecotipo INT NOT NULL,
			desenderecotipo VARCHAR(128) NOT NULL,
			idendereco INT NOT NULL,
			desendereco VARCHAR(128) NOT NULL,
			desnumero VARCHAR(16) NOT NULL,
			desbairro VARCHAR(64) NOT NULL,
			descidade VARCHAR(64) NOT NULL,
			desestado VARCHAR(32) NOT NULL,
			despais VARCHAR(32) NOT NULL,
			descep CHAR(8) NOT NULL,
			descomplemento VARCHAR(32) NULL,
			idcoordenada INT NULL,
			vllatitude DECIMAL(20,17) NULL,
			vllongitude DECIMAL(20,17) NULL,
			nrzoom TINYINT(4) NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idlugar),
			CONSTRAINT FOREIGN KEY(idlugar) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idlugarpai) REFERENCES tb_lugares(idlugar),
			CONSTRAINT FOREIGN KEY(idlugartipo) REFERENCES tb_lugarestipos(idlugartipo),
			CONSTRAINT FOREIGN KEY(idendereco) REFERENCES tb_enderecos(idendereco),
			CONSTRAINT FOREIGN KEY(idenderecotipo) REFERENCES tb_enderecostipos(idenderecotipo),
			CONSTRAINT FOREIGN KEY(idcoordenada) REFERENCES tb_coordenadas(idcoordenada)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});
$app->get("/install-admin/sql/lugares/triggers", function(){
	$triggers = array(
		'tg_lugares_AFTER_INSERT',
		'tg_lugares_AFTER_UPDATE',
		'tg_lugares_BEFORE_DELETE',

		'tg_lugarescoordenadas_AFTER_INSERT',
		'tg_lugarescoordenadas_AFTER_UPDATE',
		'tg_lugarescoordenadas_BEFORE_DELETE'
	);
	saveTriggers($triggers);

	echo success();

});
$app->get("/install-admin/sql/lugares/list", function(){
	$procs = array(
		"sp_lugares_list",
		"sp_lugarestipos_list",
		"sp_lugareshorarios_list"
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/lugares/get", function(){
	$procs = array(
		'sp_lugarestipos_get',
		'sp_lugares_get',
		'sp_lugareshorarios_get'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/lugares/save", function(){
	$procs = array(
		'sp_lugarestipos_save',
		'sp_lugares_save',
		'sp_lugaresdados_save',
		'sp_lugarescoordenadas_add',
		'sp_lugareshorarios_save'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/lugares/remove", function(){
	$procs = array(
		'sp_lugarestipos_remove',
		'sp_lugares_remove',
		'sp_lugaresdados_remove',
		'sp_lugareshorarios_remove',
		'sp_lugareshorariosall_remove'
	);
	saveProcedures($procs);
	
	echo success();
	
});
$app->get("/install-admin/sql/lugares/inserts", function(){
	
	$lang = new Language();
	
	$bairro = new LugarTipo(array(
		'deslugartipo'=>$lang->getString('lugartipo_bairro')
	));
	$bairro->save();

	$cidade = new LugarTipo(array(
		'deslugartipo'=>$lang->getString('lugartipo_cidade')
	));
	$cidade->save();

	$estado = new LugarTipo(array(
		'deslugartipo'=>$lang->getString('lugartipo_estado')
	));
	$estado->save();

	$pais = new LugarTipo(array(
		'deslugartipo'=>$lang->getString('lugartipo_pais')
	));
	$pais->save();

	$empresas = new LugarTipo(array(
		'deslugartipo'=>$lang->getString('lugartipo_empresas')
	));
	$empresas->save();
	
	$endereco = new Endereco(array(
		'idenderecotipo'=>EnderecoTipo::COMERCIAL,
		'desendereco'=>$lang->getString('lugartipo_hcode_endereco'),
		'desnumero'=>$lang->getString('lugartipo_hcode_numero'),
		'desbairro'=>$lang->getString('lugartipo_hcode_bairro'),
		'descidade'=>$lang->getString('lugartipo_hcode_cidade'),
		'desestado'=>$lang->getString('lugartipo_hcode_estado'),
		'despais'=>$lang->getString('lugartipo_hcode_pais'),
		'descep'=>$lang->getString('lugartipo_hcode_cep')
	));
	$endereco->save();

	$lugarHcode = new Lugar(array(
		'deslugar'=>$lang->getString('lugar_hcode'),
		'idlugartipo'=>$empresas->getidlugartipo(),
		'idendereco'=>$endereco->getidendereco()
	));
	$lugarHcode->save();
	
	echo success();
	
});
// coordenadas
$app->get("/install-admin/sql/coordenadas/tables", function(){

	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_coordenadas(
			idcoordenada INT NOT NULL AUTO_INCREMENT,
			vllatitude DECIMAL(20,17) NOT NULL,
			vllongitude DECIMAL(20,17) NOT NULL,
			nrzoom TINYINT(4) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcoordenada)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_enderecoscoordenadas(
			idendereco INT NOT NULL,
			idcoordenada INT NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idendereco) REFERENCES tb_enderecos(idendereco),
			CONSTRAINT FOREIGN KEY(idcoordenada) REFERENCES tb_coordenadas(idcoordenada)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});
$app->get("/install-admin/sql/coordenadas/get", function(){
	$procs = array(
		'sp_coordenadas_get'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/coordenadas/save", function(){
	$procs = array(
		'sp_coordenadas_save'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/coordenadas/remove", function(){
	$procs = array(
		'sp_coordenadas_remove'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/cursos/tables", function(){

	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_cursos (
		  idcurso int(11) NOT NULL AUTO_INCREMENT,
		  descurso varchar(64) NOT NULL,
		  destitulo varchar(256) DEFAULT NULL,
		  vlcargahoraria decimal(10,2) NOT NULL DEFAULT '0.00',
		  nraulas int(11) NOT NULL DEFAULT '0',
		  nrexercicios int(11) NOT NULL DEFAULT '0',
		  desdescricao varchar(10240) DEFAULT NULL,
		  inremovido bit(1) NOT NULL DEFAULT b'0',
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcurso)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_cursossecoes (
		  idsecao int(11) NOT NULL AUTO_INCREMENT,
		  dessecao varchar(128) NOT NULL,
		  nrordem int(11) NOT NULL DEFAULT '0',
		  idcurso int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idsecao),
		  KEY FK_cursossecoes_cursos_idx (idcurso),
		  CONSTRAINT FK_cursossecoes_cursos FOREIGN KEY (idcurso) REFERENCES tb_cursos (idcurso) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_cursoscurriculos (
		  idcurriculo int(11) NOT NULL AUTO_INCREMENT,
		  descurriculo varchar(128) NOT NULL,
		  idsecao int(11) NOT NULL,
		  desdescricao varchar(2048) DEFAULT NULL,
		  nrordem varchar(45) DEFAULT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcurriculo),
		  KEY FK_cursoscurriculos_cursossecoes_idx (idsecao),
		  CONSTRAINT FK_cursoscurriculos_cursossecoes FOREIGN KEY (idsecao) REFERENCES tb_cursossecoes (idsecao) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();
});

$app->get("/install-admin/sql/cursos/list", function(){
	$procs = array(
		'sp_cursos_list',
		'sp_cursoscurriculos_list',
		'sp_cursossecoes_list',
		'sp_secoesfromcurso_list',
		'sp_curriculosfromsecao_list'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/cursos/get", function(){
	$procs = array(
		'sp_cursos_get',
		'sp_cursoscurriculos_get',
		'sp_cursossecoes_get'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/cursos/save", function(){
	$procs = array(
		'sp_cursos_save',
		'sp_cursoscurriculos_save',
		'sp_cursossecoes_save'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/cursos/remove", function(){
	$procs = array(
		'sp_cursos_remove',
		'sp_cursoscurriculos_remove',
		'sp_cursossecoes_remove'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/carousels/tables", function(){
	
	$sql = new Sql();
	$sql->query("
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
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcarousel)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_carouselsitemstipos (
		  idtipo int(11) NOT NULL AUTO_INCREMENT,
		  destipo varchar(32) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idtipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_carouselsitems (
		  iditem int(11) NOT NULL AUTO_INCREMENT,
		  desitem varchar(45) NOT NULL,
		  desconteudo text,
		  nrordem varchar(45) NOT NULL DEFAULT '0',
		  idtipo int(11) NOT NULL,
		  idcarousel int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (iditem),
		  KEY FK_carouselsitems_carousels_idx (idcarousel),
		  KEY FK_carouselsitems_carouselsitemstipos_idx (idtipo),
		  CONSTRAINT FK_carouselsitems_carousels FOREIGN KEY (idcarousel) REFERENCES tb_carousels (idcarousel) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_carouselsitems_carouselsitemstipos FOREIGN KEY (idtipo) REFERENCES tb_carouselsitemstipos (idtipo) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();

});

$app->get("/install-admin/sql/carousels/list", function(){
	$procs = array(
		'sp_carousels_list',
		'sp_carouselsitems_list',
		'sp_carouselsitemstipos_list',
		'sp_itemsfromcarousel_list'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/carousels/get", function(){
	$procs = array(
		'sp_carousels_get',
		'sp_carouselsitems_get',
		'sp_carouselsitemstipos_get'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/carousels/save", function(){
	$procs = array(
		'sp_carousels_save',
		'sp_carouselsitems_save',
		'sp_carouselsitemstipos_save'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/carousels/remove", function(){
	$procs = array(
		'sp_carousels_remove',
		'sp_carouselsitems_remove',
		'sp_carouselsitemstipos_remove'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/configuracoes/tables", function(){
	
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_configuracoestipos (
		  idconfiguracaotipo int(11) NOT NULL AUTO_INCREMENT,
		  desconfiguracaotipo varchar(32) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idconfiguracaotipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_configuracoes (
		  idconfiguracao int(11) NOT NULL AUTO_INCREMENT,
		  desconfiguracao varchar(64) NOT NULL,
		  desvalor varchar(2048) NOT NULL,
		  desdescricao varchar(256) NULL,
		  idconfiguracaotipo int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idconfiguracao),
		  KEY FK_configuracoes_configuracoestipos_idx (idconfiguracaotipo),
		  KEY IX_desconfiguracao (desconfiguracao),
		  CONSTRAINT FK_configuracoes_configuracoestipos FOREIGN KEY (idconfiguracaotipo) REFERENCES tb_configuracoestipos (idconfiguracaotipo) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();

});

$app->get("/install-admin/sql/configuracoes/inserts", function(){

	$lang = new Language();

	$texto = new ConfiguracaoTipo(array(
		'desconfiguracaotipo'=>$lang->getString('configtipo_string')
	));
	$texto->save();

	$int = new ConfiguracaoTipo(array(
		'desconfiguracaotipo'=>$lang->getString('configtipo_int')
	));
	$int->save();

	$float = new ConfiguracaoTipo(array(
		'desconfiguracaotipo'=>$lang->getString('configtipo_float')
	));
	$float->save();

	$bool = new ConfiguracaoTipo(array(
		'desconfiguracaotipo'=>$lang->getString('configtipo_boolean')
	));
	$bool->save();

	$data = new ConfiguracaoTipo(array(
		'desconfiguracaotipo'=>$lang->getString('configtipo_datetime')
	));
	$data->save();

	$array = new ConfiguracaoTipo(array(
		'desconfiguracaotipo'=>$lang->getString('configtipo_object')
	));
	$array->save();

	$adminName = new Configuracao(array(
		'desconfiguracao'=>$lang->getString('config_admin_name'),
		'desvalor'=>$lang->getString('config_admin_name_value'),
		'idconfiguracaotipo'=>$texto->getidconfiguracaotipo(),
		'desdescricao'=>$lang->getString('config_admin_name_description')
	));
	$adminName->save();

	$uploadDir = new Configuracao(array(
		'desconfiguracao'=>$lang->getString('config_upload_dir'),
		'desvalor'=>$lang->getString('config_upload_dir_value'),
		'idconfiguracaotipo'=>$texto->getidconfiguracaotipo(),
		'desdescricao'=>$lang->getString('config_upload_dir_description')
	));
	$uploadDir->save();

	$uploadMimes = new Configuracao(array(
		'desconfiguracao'=>$lang->getString('config_upload_mimetype'),
		'desvalor'=>json_encode(array(
			'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf'
		)),
		'idconfiguracaotipo'=>$array->getidconfiguracaotipo(),
		'desdescricao'=>$lang->getString('config_upload_mimetype_description')
	));
	$uploadMimes->save();

	echo success();

});

$app->get("/install-admin/sql/configuracoes/get", function(){
	$procs = array(
		'sp_configuracoestipos_get',
		'sp_configuracoestipos_list',
		'sp_configuracoes_get',
		'sp_configuracoes_list'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/configuracoes/save", function(){
	$procs = array(
		'sp_configuracoestipos_save',
		'sp_configuracoes_save'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/configuracoes/remove", function(){
	$procs = array(
		'sp_configuracoestipos_remove',
		'sp_configuracoes_remove'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/arquivos/tables", function(){
	
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_arquivos (
		  idarquivo int(11) NOT NULL AUTO_INCREMENT,
		  desdiretorio varchar(256) NOT NULL,
		  desarquivo varchar(128) NOT NULL,
		  desextensao varchar(32) NOT NULL,
		  desalias varchar(128) NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idarquivo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();

});

$app->get("/install-admin/sql/arquivos/get", function(){
	$procs = array(
		'sp_arquivos_get'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/arquivos/save", function(){
	$procs = array(
		'sp_arquivos_save'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/arquivos/remove", function(){
	$procs = array(
		'sp_arquivos_remove'
	);
	saveProcedures($procs);

	echo success();
});
$app->get("/install-admin/sql/arquivos/list", function(){
	$procs = array(
		'sp_arquivos_list'
	);
	saveProcedures($procs);

	echo success();
});

$app->get("/install-admin/sql/produtosarquivos/tables", function(){

	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_produtosarquivos (
		  idproduto int(11) NOT NULL,
		  idarquivo int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idproduto,idarquivo),
		  KEY FK_produtosarquivos_arquivos_idx (idarquivo),
		  CONSTRAINT FK_produtosarquivos_arquivos FOREIGN KEY (idarquivo) REFERENCES tb_arquivos (idarquivo) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_produtosarquivos_produtos FOREIGN KEY (idproduto) REFERENCES tb_produtos (idproduto) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";	
	");

	echo success();

});


?>