CREATE DEFINER = CURRENT_USER TRIGGER tb_contatos_BEFORE_DELETE BEFORE DELETE ON tb_contatos FOR EACH ROW
BEGIN
	CALL sp_pessoasdados_save(OLD.idpessoa);
END