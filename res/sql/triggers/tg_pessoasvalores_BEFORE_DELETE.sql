CREATE DEFINER = CURRENT_USER TRIGGER tg_pessoasvalores_BEFORE_DELETE BEFORE DELETE ON tb_pessoasvalores FOR EACH ROW
BEGIN
	CALL sp_pessoasdados_remove(OLD.idpessoa);
END