CREATE DEFINER = CURRENT_USER TRIGGER tg_pessoasvalores_AFTER_INSERT AFTER INSERT ON tb_pessoasvalores FOR EACH ROW
BEGIN
	CALL sp_pessoasdados_save(NEW.idpessoa);
END