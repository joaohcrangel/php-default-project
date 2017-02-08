CREATE DEFINER = CURRENT_USER TRIGGER tg_pessoasenderecos_BEFORE_DELETE BEFORE DELETE ON tb_pessoasenderecos FOR EACH ROW
BEGIN
	CALL sp_pessoasdados_save(OLD.idpessoa);
END